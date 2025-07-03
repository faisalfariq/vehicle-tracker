<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Region;
use App\Models\AppLog;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = Driver::with('region')->latest()->paginate(20);
        return view('pages.drivers.index', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regions = Region::all();
        return view('pages.drivers.create', compact('regions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'region_id' => 'nullable|exists:regions,id',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            \DB::beginTransaction();
            $driver = Driver::create($validated);
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'create',
                'module' => 'driver',
                'ip_address' => $request->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Driver berhasil ditambahkan.',
                'driver_id' => $driver->id
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambah driver: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $driver = Driver::with('region')->findOrFail($id);
        return view('pages.drivers.show', compact('driver'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $driver = Driver::findOrFail($id);
        $regions = Region::all();
        return view('pages.drivers.edit', compact('driver', 'regions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'region_id' => 'nullable|exists:regions,id',
            'is_active' => 'nullable|boolean',
        ]);

        $driver = Driver::findOrFail($id);
        try {
            \DB::beginTransaction();
            $driver->update($validated);
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'update',
                'module' => 'driver',
                'ip_address' => $request->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Driver berhasil diupdate.',
                'driver_id' => $driver->id
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal update driver: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $driver = Driver::findOrFail($id);
        try {
            \DB::beginTransaction();
            $driver->delete();
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'delete',
                'module' => 'driver',
                'ip_address' => request()->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Driver berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus driver: ' . $e->getMessage()
            ]);
        }
    }
}