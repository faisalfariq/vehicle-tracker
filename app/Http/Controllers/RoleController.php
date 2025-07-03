<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\AppLog;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::latest()->paginate(20);
        return view('pages.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        try {
            \DB::beginTransaction();
            $role = Role::create($validated);
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'create',
                'module' => 'role',
                'ip_address' => $request->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Role berhasil ditambahkan.',
                'data' => $role
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan role: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::findOrFail($id);
        return view('pages.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        return view('pages.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        ]);

        try {
            \DB::beginTransaction();
            $role->update($validated);
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'update',
                'module' => 'role',
                'ip_address' => $request->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Role berhasil diupdate.',
                'data' => $role
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal update role: ' . $e->getMessage()
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
            $role = Role::findOrFail($id);
            $role->delete();
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'delete',
                'module' => 'role',
                'ip_address' => request()->ip(),
            ]);
            \DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Role berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus role: ' . $e->getMessage()
            ]);
        }
    }
}