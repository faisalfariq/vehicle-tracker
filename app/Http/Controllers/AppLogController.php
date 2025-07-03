<?php

namespace App\Http\Controllers;

use App\Models\AppLog;
use App\Models\User;
use Illuminate\Http\Request;

class AppLogController extends Controller
{
    public function index()
    {
        $logs = AppLog::with('user')->latest()->paginate(20);
        return view('pages.app_logs.index', compact('logs'));
    }

    public function create()
    {
        $users = User::all();
        return view('pages.app_logs.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'action' => 'required|string|max:255',
            'module' => 'required|string|max:255',
            'ip_address' => 'nullable|ip',
        ]);

        try {
            \DB::beginTransaction();
            $log = AppLog::create($validated);
            \DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Log berhasil ditambahkan.',
                'data' => $log
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan log: ' . $e->getMessage()
            ]);
        }
    }

    public function show(string $id)
    {
        $log = AppLog::with('user')->findOrFail($id);
        return view('pages.app_logs.show', compact('log'));
    }

    public function edit(string $id)
    {
        $log = AppLog::findOrFail($id);
        $users = User::all();
        return view('pages.app_logs.edit', compact('log', 'users'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'action' => 'required|string|max:255',
            'module' => 'required|string|max:255',
            'ip_address' => 'nullable|ip',
        ]);

        try {
            \DB::beginTransaction();
            $log = AppLog::findOrFail($id);
            $log->update($validated);
            \DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Log berhasil diupdate.',
                'data' => $log
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal update log: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy(string $id)
    {
        try {
            \DB::beginTransaction();
            $log = AppLog::findOrFail($id);
            $log->delete();
            \DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Log berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus log: ' . $e->getMessage()
            ]);
        }
    }
}