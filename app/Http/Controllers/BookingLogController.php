<?php

namespace App\Http\Controllers;

use App\Models\BookingLog;
use App\Models\Booking;
use App\Models\AppLog;
use Illuminate\Http\Request;

class BookingLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = BookingLog::with('booking')->latest()->paginate(20);
        return view('pages.booking_logs.index', compact('logs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bookings = Booking::all();
        return view('pages.booking_logs.create', compact('bookings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'event' => 'required|in:start,stop,pause',
            'datetime' => 'required|date',
            'odometer' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);

        try {
            \DB::beginTransaction();
            $bookingLog = BookingLog::create($validated);
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'create',
                'module' => 'booking_log',
                'ip_address' => $request->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Log booking berhasil ditambahkan.',
                'log_id' => $bookingLog->id
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambah log booking: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $log = BookingLog::with('booking')->findOrFail($id);
        return view('pages.booking_logs.show', compact('log'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $log = BookingLog::findOrFail($id);
        $bookings = Booking::all();
        return view('pages.booking_logs.edit', compact('log', 'bookings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'event' => 'required|in:start,stop,pause',
            'datetime' => 'required|date',
            'odometer' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);

        $log = BookingLog::findOrFail($id);
        try {
            \DB::beginTransaction();
            $log->update($validated);
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'update',
                'module' => 'booking_log',
                'ip_address' => $request->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Log booking berhasil diupdate.',
                'log_id' => $log->id
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal update log booking: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $log = BookingLog::findOrFail($id);
        try {
            \DB::beginTransaction();
            $log->delete();
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'delete',
                'module' => 'booking_log',
                'ip_address' => request()->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Log booking berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus log booking: ' . $e->getMessage()
            ]);
        }
    }
}