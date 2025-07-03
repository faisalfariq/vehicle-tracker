<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\AppLog;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regions = Region::latest()->paginate(20);
        return view('pages.regions.index', compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.regions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:pusat,cabang,tambang',
            'address' => 'nullable|string|max:255',
        ]);
        try {
            \DB::beginTransaction();
            $region = Region::create($validated);
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'create',
                'module' => 'region',
                'ip_address' => $request->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Region berhasil ditambahkan.',
                'data' => $region
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan region: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $region = Region::findOrFail($id);
        return view('pages.regions.show', compact('region'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $region = Region::findOrFail($id);
        return view('pages.regions.edit', compact('region'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $region = Region::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:pusat,cabang,tambang',
            'address' => 'nullable|string|max:255',
        ]);
        try {
            \DB::beginTransaction();
            $region->update($validated);
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'update',
                'module' => 'region',
                'ip_address' => $request->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Region berhasil diupdate.',
                'data' => $region
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal update region: ' . $e->getMessage()
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
            $region = Region::findOrFail($id);
            $region->delete();
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'delete',
                'module' => 'region',
                'ip_address' => request()->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Region berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus region: ' . $e->getMessage()
            ]);
        }
    }
}