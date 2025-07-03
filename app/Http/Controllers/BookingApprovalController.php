<?php

namespace App\Http\Controllers;

use App\Models\BookingApproval;
use App\Models\Booking;
use App\Models\User;
use App\Models\AppLog;
use Illuminate\Http\Request;

class BookingApprovalController extends Controller
{
    public function index()
    {
        $approvals = BookingApproval::with(['booking', 'approver'])->latest()->paginate(20);
        return view('pages.booking_approvals.index', compact('approvals'));
    }

    public function create()
    {
        $bookings = Booking::all();
        $users = User::all();
        return view('pages.booking_approvals.create', compact('bookings', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'approver_id' => 'required|exists:users,id',
            'level' => 'required|integer|min:1',
            'status' => 'required|in:pending,approved,rejected',
            'note' => 'nullable|string',
            'approved_at' => 'nullable|date',
        ]);

        try {
            \DB::beginTransaction();
            $approval = BookingApproval::create($validated);
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'create',
                'module' => 'booking_approval',
                'ip_address' => $request->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Approval berhasil ditambahkan.',
                'approval_id' => $approval->id
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambah approval: ' . $e->getMessage()
            ]);
        }
    }

    public function show(string $id)
    {
        $approval = BookingApproval::with(['booking', 'approver'])->findOrFail($id);
        return view('pages.booking_approvals.show', compact('approval'));
    }

    public function edit(string $id)
    {
        $approval = BookingApproval::findOrFail($id);
        $bookings = Booking::all();
        $users = User::all();
        return view('pages.booking_approvals.edit', compact('approval', 'bookings', 'users'));
    }

    public function update(Request $request, string $id)
    {
        $approval = BookingApproval::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'note' => 'nullable|string',
        ]);
        try {
            \DB::beginTransaction();
            // Set approved_at if status is approved or rejected
            if ($validated['status'] === 'approved' || $validated['status'] === 'rejected') {
                $validated['approved_at'] = now();
            } else {
                $validated['approved_at'] = null;
            }
            $approval->update($validated);
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'update',
                'module' => 'booking_approval',
                'ip_address' => $request->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Approval berhasil diupdate.',
                'approval_id' => $approval->id
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal update approval: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy(string $id)
    {
        $approval = BookingApproval::findOrFail($id);
        try {
            \DB::beginTransaction();
            $approval->delete();
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'delete',
                'module' => 'booking_approval',
                'ip_address' => request()->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Approval berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus approval: ' . $e->getMessage()
            ]);
        }
    }
}