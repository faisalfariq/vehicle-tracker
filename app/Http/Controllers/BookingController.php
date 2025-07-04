<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\BookingApproval;
use App\Models\AppLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $user = Auth::user();

        $query = Booking::with(['user', 'vehicle', 'driver', 'approvals']);

        // Filter based on user role
        if ($user->role->name === 'user') {
            // User: only see their own bookings
            $query->where('user_id', $user->id);
        } elseif ($user->role->name === 'approver') {
            // Approver: see their own bookings and bookings they need to approve
            $query->where(function($q) use ($user) {
                $q->where('user_id', $user->id) // their own bookings
                  ->orWhereHas('approvals', function($subQ) use ($user) {
                      $subQ->where('approver_id', $user->id); // bookings they need to approve
                  });
            });
        }
        // Admin: see all bookings (no additional filter)

        $bookings = $query->when($keyword, function($query) use ($keyword) {
                        $query->where(function($q) use ($keyword) {
                            $q->where('code', 'LIKE', '%' . $keyword . '%')
                                ->orWhereHas('user', function($qu) use ($keyword) {
                                    $qu->where('name', 'LIKE', '%' . $keyword . '%');
                                });
                        });
                    })
                    ->latest()
                    ->paginate(20);

        return view('pages.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('is_available', true)->get();
        $drivers = Driver::where('is_active', true)->get();
        $approvers = User::whereHas('role', function($q) {
            $q->where('name', 'approver');
        })->get();
        $users = User::get();
        return view('pages.bookings.create', compact('vehicles', 'drivers', 'approvers','users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'start_datetime' => 'required|date|after:now',
            'end_datetime' => 'required|date|after:start_datetime',
            'destination' => 'required|string|max:255',
            'reason' => 'nullable|string',
            'approver1_id' => 'required|exists:users,id',
            'approver2_id' => 'required|exists:users,id',
            'user_id' => 'required|exists:users,id',
        ]);

        // Cek vehicle harus tersedia
        $vehicle = Vehicle::find($validated['vehicle_id']);
        if (!$vehicle || !$vehicle->is_available) {
            return response()->json([
                'status' => false,
                'message' => 'Kendaraan yang dipilih tidak tersedia.'
            ], 422);
        }

        try{
            DB::beginTransaction();

        // DB::transaction(function() use ($validated) {
            // Generate booking code: BO-YYYY-MM-DD-XXXX (reset every month)
            $now = now();
            $prefix = 'BO-' . $now->format('Y-m-d') . '-';

            // Count bookings for this month
            $monthStart = $now->copy()->startOfMonth()->format('Y-m-d 00:00:00');
            $monthEnd = $now->copy()->endOfMonth()->format('Y-m-d 23:59:59');
            $lastBooking = Booking::whereBetween('created_at', [$monthStart, $monthEnd])
                ->orderByDesc('code')
                ->first();

            if ($lastBooking && preg_match('/^BO-\d{4}-\d{2}-\d{2}-(\d{4})$/', $lastBooking->code, $matches)) {
                $lastNumber = (int)$matches[1];
            } else {
                $lastNumber = 0;
            }
            $countThisMonth = $lastNumber;
            $nextNumber = str_pad($countThisMonth + 1, 4, '0', STR_PAD_LEFT);

            $booking_code = $prefix . $nextNumber;

            $booking = Booking::create([
                // 'user_id' => Auth::id(),
                'user_id' => $validated['user_id'],
                'vehicle_id' => $validated['vehicle_id'],
                'driver_id' => $validated['driver_id'] ?? null,
                'start_datetime' => $validated['start_datetime'],
                'end_datetime' => $validated['end_datetime'],
                'destination' => $validated['destination'],
                'reason' => $validated['reason'] ?? null,
                // status level : draft, pending, pending, approved, rejected, used, finished
                'status' => 'draft', //first status is draft
                'code' => $booking_code,
            ]);

            $validated['approver_ids'] = [
                $validated['approver1_id'],
                $validated['approver2_id']
            ];

            foreach ($validated['approver_ids'] as $level => $approver_id) {
                BookingApproval::create([
                    'booking_id' => $booking->id,
                    'approver_id' => $validated['approver1_id'],
                    'level' => $level + 1,
                    'status' => 'pending',
                ]);
            }
        // });

            DB::commit();
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'create',
                'module' => 'booking',
                'ip_address' => $request->ip(),
            ]);
            return response()->json(
                array(
                    'status' => True,
                    'message' => "Successfully create new booking" . "\n" . "Booking Code : " . $booking->code
                )
            );

        }catch(\Exception $e){
            DB::rollback();

            return response()->json(
                array(
                    'status' => False,
                    'message' => "Failed to save new booking, an error occurred : " . $e->getMessage()
                )
            );
        }

    //     return redirect()->route('bookings.index')->with('success', 'Pemesanan berhasil dibuat.');
    } 

    public function show(string $id)
    {
        $booking = Booking::with(['user', 'vehicle', 'driver', 'approvals.approver'])->findOrFail($id);
        return view('pages.bookings.show', compact('booking'));
    }

    public function edit(string $id)
    {
        $booking = Booking::findOrFail($id);

        // Hanya boleh edit jika status draft
        if ($booking->status !== 'draft') {
            // Bisa redirect atau abort, di sini kita abort dengan 403
            abort(403, 'Booking cannot be edited because its status is not draft.');
        }

        $users = User::get();
        $vehicles = Vehicle::where('is_available', true)->orWhere('id', $booking->vehicle_id)->get();
        $drivers = Driver::where('is_active', true)->orWhere('id', $booking->driver_id)->get();
        $approvers = User::whereHas('role', function($q) {
            $q->where('name', 'approver');
        })->get();
        return view('pages.bookings.edit', compact('booking', 'vehicles', 'drivers', 'approvers', 'users'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'start_datetime' => 'required|date|after:now',
            'end_datetime' => 'required|date|after:start_datetime',
            'destination' => 'required|string|max:255',
            'reason' => 'nullable|string',
            'approver1_id' => 'required|exists:users,id',
            'approver2_id' => 'required|exists:users,id',
        ]);

        // Cek vehicle harus tersedia
        $vehicle = Vehicle::find($validated['vehicle_id']);
        if (!$vehicle || !$vehicle->is_available) {
            return response()->json([
                'status' => false,
                'message' => 'Kendaraan yang dipilih tidak tersedia.'
            ], 422);
        }

        try {
            DB::beginTransaction();

            $booking = Booking::findOrFail($id);

            // Tambahkan pengecekan status, hanya bisa update jika status draft
            if ($booking->status !== 'draft') {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Booking cannot be updated because its status is not draft.'
                ], 403);
            }

            $booking->update($validated);

            // Update approvals
            $approverIds = [
                1 => $validated['approver1_id'],
                2 => $validated['approver2_id'],
            ];

            foreach ($approverIds as $level => $approver_id) {
                $approval = $booking->approvals()->where('level', $level)->first();

                if ($approval) {
                    // Jika sudah approve, jangan update approver_id
                    if ($approval->status === 'approved') {
                        continue;
                    }
                    // Jika belum approve, update approver_id jika berubah
                    if ($approval->approver_id != $approver_id) {
                        $approval->approver_id = $approver_id;
                        $approval->status = 'pending'; // reset status jika ganti approver
                        $approval->save();
                    }
                } else {
                    // Jika approval belum ada, buat baru
                    BookingApproval::create([
                        'booking_id' => $booking->id,
                        'approver_id' => $approver_id,
                        'level' => $level,
                        'status' => 'pending',
                    ]);
                }
            }

            // Jika ada approval lebih dari 2, hapus approval level lain yang tidak dipakai
            $booking->approvals()->whereNotIn('level', [1,2])->delete();

            DB::commit();
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'update',
                'module' => 'booking',
                'ip_address' => $request->ip(),
            ]);
            return response()->json(
                array(
                    'status' => True,
                    'message' => "Successfully update a booking" . "\n" . "Booking Code : " . $booking->code
                )
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update booking: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $booking = Booking::findOrFail($id);

        // Cek status booking, hanya boleh hapus jika status draft
        if ($booking->status !== 'draft') {
            return response()->json([
                'message' => 'Booking hanya bisa dihapus jika status masih draft.',
                'status' => false
            ], 403);
        }

        try {
            // Mulai transaksi database
            DB::beginTransaction();

            $booking->approvals()->delete();
            $booking_code = $booking->code;

            $booking->delete();

            // Akhiri transaksi database
            DB::commit();
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'delete',
                'module' => 'booking',
                'ip_address' => request()->ip(),
            ]);
            return response()->json([
                'message' => 'successfully deleted booking: ' . $booking_code,
                'status' => True
            ]);

        } catch (\Exception $e) {
            // Jika terjadi kesalahan, rollback transaksi dan tangkap eksepsi
            DB::rollback();
            return response()->json([
                'message' => 'an error occurred : ' . $e->getMessage(),
                'status' => False
            ]);

        }
    }

    public function approve(string $id)
    {
        try {
            DB::beginTransaction();

            $booking = Booking::with(['approvals.approver'])->findOrFail($id);
            $currentUser = Auth::user();

            // Hanya boleh approve jika status booking 'pending'
            if ($booking->status !== 'pending') {
                return response()->json([
                    'status' => false,
                    'message' => 'Booking hanya bisa di-approve jika status masih pending.'
                ], 403);
            }

            // Check if current user is an approver for this booking
            $userApproval = $booking->approvals()
                ->where('approver_id', $currentUser->id)
                ->first();

            if (!$userApproval) {
                return response()->json([
                    'status' => false,
                    'message' => 'Anda tidak memiliki izin untuk menyetujui booking ini.'
                ], 403);
            }

            // Check if approval is already processed
            if ($userApproval->status !== 'pending') {
                return response()->json([
                    'status' => false,
                    'message' => 'Approval sudah diproses sebelumnya.'
                ], 400);
            }

            // Update the specific approver's approval status
            $userApproval->status = 'approved';
            $userApproval->approved_at = now();
            $userApproval->save();

            // Check if this is approver level 2
            if ($userApproval->level == 2) {
                // Approver 2 can change booking status to approved
                $booking->status = 'approved';
                $booking->save();

                // Auto-approve approver 1 if not already approved
                $approver1 = $booking->approvals()->where('level', 1)->first();
                if ($approver1 && $approver1->status === 'pending') {
                    $approver1->status = 'approved';
                    $approver1->approved_at = now();
                    $approver1->save();
                }

                $message = 'Booking berhasil disetujui oleh approver level 2.';
            } else {
                // Approver level 1 - only update approval status, not booking status
                $message = 'Approval level 1 berhasil disetujui. Menunggu approval level 2.';
            }

            // Log the action
            AppLog::create([
                'user_id' => $currentUser->id,
                'action' => 'approve',
                'module' => 'booking_approval',
                'ip_address' => request()->ip(),
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reject(string $id) 
    {
        try {
            DB::beginTransaction();

            $booking = Booking::with(['approvals.approver'])->findOrFail($id);
            $currentUser = Auth::user();

            // Hanya boleh reject jika status booking 'pending'
            if ($booking->status !== 'pending') {
                return response()->json([
                    'status' => false,
                    'message' => 'Booking hanya bisa di-reject jika status masih pending.'
                ], 403);
            }

            // Check if current user is an approver for this booking
            $userApproval = $booking->approvals()
                ->where('approver_id', $currentUser->id)
                ->first();

            if (!$userApproval) {
                return response()->json([
                    'status' => false,
                    'message' => 'Anda tidak memiliki izin untuk menolak booking ini.'
                ], 403);
            }

            // Check if approval is already processed
            if ($userApproval->status !== 'pending') {
                return response()->json([
                    'status' => false,
                    'message' => 'Approval sudah diproses sebelumnya.'
                ], 400);
            }

            // Update the specific approver's approval status
            $userApproval->status = 'rejected';
            $userApproval->approved_at = now();
            $userApproval->save();

            // Any approver can reject the booking
            $booking->status = 'rejected';
            $booking->save();

            // Log the action
            AppLog::create([
                'user_id' => $currentUser->id,
                'action' => 'reject',
                'module' => 'booking_approval',
                'ip_address' => request()->ip(),
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Booking berhasil ditolak.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function submit(string $id)
    {
        $booking = Booking::findOrFail($id);

        // Hanya bisa submit jika status draft
        if ($booking->status !== 'draft') {
            return response()->json([
                'message' => 'Booking hanya bisa disubmit jika status masih draft.',
                'status' => false
            ], 403);
        }

        $booking->status = 'pending';
        $booking->save();
        return response()->json([
            'message' => 'successfully submitted booking: ' . $booking->code,
            'status' => true
        ]);
    }

    public function used(string $id)
    {
        $booking = Booking::with('approvals', 'vehicle')->findOrFail($id);

        // Only allow to set as 'onuse' if status is 'approved' and both approvers have approved
        if ($booking->status !== 'approved') {
            return response()->json([
                'message' => 'Booking hanya bisa digunakan jika status sudah approved.',
                'status' => false
            ], 403);
        }

        $approver1 = $booking->approvals->where('level', 1)->first();
        $approver2 = $booking->approvals->where('level', 2)->first();

        if (
            (optional($approver1)->status !== 'approved') ||
            (optional($approver2)->status !== 'approved')
        ) {
            return response()->json([
                'message' => 'Booking hanya bisa digunakan jika kedua approver sudah menyetujui.',
                'status' => false
            ], 403);
        }

        // Set vehicle is_available = false
        $vehicle = $booking->vehicle;
        if ($vehicle) {
            $vehicle->is_available = false;
            $vehicle->save();
        }

        $booking->status = 'onuse';
        $booking->save();

        return response()->json([
            'message' => 'successfully used booking: ' . $booking->code,
            'status' => true
        ]);
    }

    public function finish(string $id)
    {
        $booking = Booking::with('approvals', 'vehicle')->findOrFail($id);

        // Cek status booking, hanya bisa finish jika status = onuse
        if ($booking->status !== 'onuse') {
            return response()->json([
                'message' => 'Booking tidak dapat diselesaikan karena status belum onuse.',
                'status' => false
            ], 403);
        }

        // Cek kedua approver, jika masih ada yang pending tidak bisa finish
        $approver1 = $booking->approvals->where('level', 1)->first();
        $approver2 = $booking->approvals->where('level', 2)->first();

        if (
            (optional($approver1)->status === 'pending' || is_null(optional($approver1)->status)) ||
            (optional($approver2)->status === 'pending' || is_null(optional($approver2)->status))
        ) {
            return response()->json([
                'message' => 'Booking tidak dapat diselesaikan karena masih ada approver yang pending.',
                'status' => false
            ], 403);
        }

        // Set vehicle is_available = true
        $vehicle = $booking->vehicle;
        if ($vehicle) {
            $vehicle->is_available = true;
            $vehicle->save();
        }

        $booking->status = 'finish';
        $booking->save();

        return response()->json([
            'message' => 'successfully finished booking: ' . $booking->code,
            'status' => true
        ]);
    }
    
}