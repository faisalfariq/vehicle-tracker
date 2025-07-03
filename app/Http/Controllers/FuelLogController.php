<?php

namespace App\Http\Controllers;

use App\Models\FuelLog;
use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\AppLog;
use Illuminate\Http\Request;

class FuelLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fuelLogs = FuelLog::with(['vehicle', 'booking'])->latest()->paginate(20);
        return view('pages.fuel_logs.index', compact('fuelLogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehicles = Vehicle::all();
        $bookings = Booking::all();
        return view('pages.fuel_logs.create', compact('vehicles', 'bookings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'booking_id' => 'nullable|exists:bookings,id',
            'date' => 'required|date',
            'fuel_amount' => 'required|numeric|min:0',
            'fuel_cost' => 'required|numeric|min:0',
            'km_before' => 'required|integer|min:0',
            'km_after' => 'required|integer|min:0|gte:km_before',
        ]);
        try {
            \DB::beginTransaction();
            $fuelLog = FuelLog::create($validated);
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'create',
                'module' => 'fuel_log',
                'ip_address' => $request->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Successfully added new fuel log.',
                'fuel_log_id' => $fuelLog->id
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Failed to add fuel log: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fuelLog = FuelLog::with(['vehicle', 'booking'])->findOrFail($id);
        return view('pages.fuel_logs.show', compact('fuelLog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fuelLog = FuelLog::findOrFail($id);
        $vehicles = Vehicle::all();
        $bookings = Booking::all();
        return view('pages.fuel_logs.edit', compact('fuelLog', 'vehicles', 'bookings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fuelLog = FuelLog::findOrFail($id);
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'booking_id' => 'nullable|exists:bookings,id',
            'date' => 'required|date',
            'fuel_amount' => 'required|numeric|min:0',
            'fuel_cost' => 'required|numeric|min:0',
            'km_before' => 'required|integer|min:0',
            'km_after' => 'required|integer|min:0|gte:km_before',
        ]);
        try {
            \DB::beginTransaction();
            $fuelLog->update($validated);
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'update',
                'module' => 'fuel_log',
                'ip_address' => $request->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Successfully updated fuel log.',
                'fuel_log_id' => $fuelLog->id
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Failed to update fuel log: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fuelLog = FuelLog::findOrFail($id);
        try {
            \DB::beginTransaction();
            $fuelLog->delete();
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'delete',
                'module' => 'fuel_log',
                'ip_address' => request()->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Successfully deleted fuel log.'
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete fuel log: ' . $e->getMessage()
            ]);
        }
    }
}