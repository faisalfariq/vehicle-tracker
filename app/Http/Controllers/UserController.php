<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Region;
use App\Models\AppLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['role', 'region'])->latest()->paginate(20);
        return view('pages.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $regions = Region::all();
        return view('pages.users.create', compact('roles', 'regions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id',
            'region_id' => 'nullable|exists:regions,id',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();
            $validated['password'] = Hash::make($validated['password']);
            $user = User::create($validated);
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'create',
                'module' => 'user',
                'ip_address' => $request->ip(),
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'User berhasil ditambahkan.',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambah user: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with(['role', 'region'])->findOrFail($id);
        return view('pages.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $regions = Region::all();
        return view('pages.users.edit', compact('user', 'roles', 'regions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role_id' => 'required|exists:roles,id',
            'region_id' => 'nullable|exists:regions,id',
            'is_active' => 'nullable|boolean',
        ]);
        try {
            DB::beginTransaction();
            if (!empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }
            $user->update($validated);
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'update',
                'module' => 'user',
                'ip_address' => $request->ip(),
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'User berhasil diupdate.',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal update user: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        try {
            DB::beginTransaction();
            $user->delete();
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'delete',
                'module' => 'user',
                'ip_address' => request()->ip(),
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'User berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus user: ' . $e->getMessage()
            ]);
        }
    }
}