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

        // $bookings = Booking::with(['user', 'vehicle', 'driver', 'approvals'])
        //     ->where(function($query) use ($keyword) {
        //         $query->where('code', 'LIKE', '%' . $keyword . '%')
        //             ->orWhereHas('user', function($q) use ($keyword) {
        //                 $q->where('name', 'LIKE', '%' . $keyword . '%');
        //             });
        //     })
        //     ->latest()
        //     ->paginate(1);

        $bookings = Booking::with(['user', 'vehicle', 'driver', 'approvals'])
                    ->when($keyword, function($query) use ($keyword) {
                        $query->where(function($q) use ($keyword) {
                            $q->where('code', 'LIKE', '%' . $keyword . '%')
                                ->orWhereHas('user', function($qu) use ($keyword) {
                                    $qu->where('name', 'LIKE', '%' . $keyword . '%');
                                });
                        });
                    })
                    ->latest()
                    ->paginate(2);

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
            // 'approver_ids' => 'required|array|min:2',
            // 'approver_ids.*' => 'exists:users,id',
        ]);

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
                'status' => 'pending',
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
        $users = User::get();
        $booking = Booking::findOrFail($id);
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

        try {
            DB::beginTransaction();

            $booking = Booking::findOrFail($id);
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
}