<?php

namespace App\Http\Controllers;

use App\Models\ServiceLog;
use App\Models\Vehicle;
use App\Models\AppLog;
use Illuminate\Http\Request;

class ServiceLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceLogs = ServiceLog::with('vehicle')->latest()->paginate(20);
        return view('pages.service_logs.index', compact('serviceLogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehicles = Vehicle::all();
        return view('pages.service_logs.create', compact('vehicles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'service_date' => 'required|date',
            'description' => 'required|string',
            'km' => 'required|integer|min:0',
            'cost' => 'required|numeric|min:0',
        ]);
        try {
            \DB::beginTransaction();
            $serviceLog = ServiceLog::create($validated);
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'create',
                'module' => 'service_log',
                'ip_address' => $request->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Log service berhasil ditambahkan.',
                'data' => $serviceLog
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan log service: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $serviceLog = ServiceLog::with('vehicle')->findOrFail($id);
        return view('pages.service_logs.show', compact('serviceLog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $serviceLog = ServiceLog::findOrFail($id);
        $vehicles = Vehicle::all();
        return view('pages.service_logs.edit', compact('serviceLog', 'vehicles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $serviceLog = ServiceLog::findOrFail($id);
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'service_date' => 'required|date',
            'description' => 'required|string',
            'km' => 'required|integer|min:0',
            'cost' => 'required|numeric|min:0',
        ]);
        try {
            \DB::beginTransaction();
            $serviceLog->update($validated);
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'update',
                'module' => 'service_log',
                'ip_address' => $request->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Log service berhasil diupdate.',
                'data' => $serviceLog
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal update log service: ' . $e->getMessage()
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
            $serviceLog = ServiceLog::findOrFail($id);
            $serviceLog->delete();
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'delete',
                'module' => 'service_log',
                'ip_address' => request()->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Log service berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus log service: ' . $e->getMessage()
            ]);
        }
    }
}