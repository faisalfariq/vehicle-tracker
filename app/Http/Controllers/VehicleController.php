<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Models\Region;
use App\Models\AppLog;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::with(['type', 'region'])->latest()->paginate(20);
        return view('pages.vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = VehicleType::all();
        $regions = Region::all();
        return view('pages.vehicles.create', compact('types', 'regions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'plate_number' => 'required|string|max:100|unique:vehicles,plate_number',
            'type_id' => 'required|exists:vehicle_types,id',
            'is_rented' => 'nullable|boolean',
            'fuel_type' => 'nullable|string|max:50',
            'region_id' => 'nullable|exists:regions,id',
            'is_available' => 'nullable|boolean',
        ]);

        try {
            \DB::beginTransaction();
            $vehicle = Vehicle::create($validated);
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'create',
                'module' => 'vehicle',
                'ip_address' => $request->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Kendaraan berhasil ditambahkan.',
                'data' => $vehicle
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan kendaraan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vehicle = Vehicle::with(['type', 'region'])->findOrFail($id);
        return view('pages.vehicles.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $types = VehicleType::all();
        $regions = Region::all();
        return view('pages.vehicles.edit', compact('vehicle', 'types', 'regions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'plate_number' => 'required|string|max:100|unique:vehicles,plate_number,' . $vehicle->id,
            'type_id' => 'required|exists:vehicle_types,id',
            'is_rented' => 'nullable|boolean',
            'fuel_type' => 'nullable|string|max:50',
            'region_id' => 'nullable|exists:regions,id',
            'is_available' => 'nullable|boolean',
        ]);

        try {
            \DB::beginTransaction();
            $vehicle->update($validated);
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'update',
                'module' => 'vehicle',
                'ip_address' => $request->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Kendaraan berhasil diupdate.',
                'data' => $vehicle
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal update kendaraan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            \DB::beginTransaction();
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->delete();
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'delete',
                'module' => 'vehicle',
                'ip_address' => request()->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Kendaraan berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus kendaraan: ' . $e->getMessage()
            ]);
        }
    }
}