<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Booking;
use App\Models\AppLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('booking')->latest()->paginate(20);
        return view('pages.documents.index', compact('documents'));
    }

    public function create()
    {
        $bookings = Booking::all();
        return view('pages.documents.create', compact('bookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:2048',
        ]);

        try {
            \DB::beginTransaction();
            $path = $request->file('file')->store('documents', 'public');
            $document = Document::create([
                'booking_id' => $validated['booking_id'],
                'file_path' => $path,
            ]);
            \DB::commit();
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'create',
                'module' => 'document',
                'ip_address' => $request->ip(),
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Dokumen berhasil diupload.',
                'document_id' => $document->id
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal upload dokumen: ' . $e->getMessage()
            ]);
        }
    }

    public function show(string $id)
    {
        $document = Document::with('booking')->findOrFail($id);
        return view('pages.documents.show', compact('document'));
    }

    public function edit(string $id)
    {
        $document = Document::findOrFail($id);
        $bookings = Booking::all();
        return view('pages.documents.edit', compact('document', 'bookings'));
    }

    public function update(Request $request, string $id)
    {
        $document = Document::findOrFail($id);
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:2048',
        ]);
        try {
            \DB::beginTransaction();
            $data = [
                'booking_id' => $validated['booking_id'],
            ];
            if ($request->hasFile('file')) {
                // Delete old file from public storage
                if ($document->file_path && \Storage::disk('public')->exists($document->file_path)) {
                    \Storage::disk('public')->delete($document->file_path);
                }
                $data['file_path'] = $request->file('file')->store('documents', 'public');
            }
            $document->update($data);
            \DB::commit();
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'update',
                'module' => 'document',
                'ip_address' => $request->ip(),
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Dokumen berhasil diupdate.',
                'document_id' => $document->id
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal update dokumen: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy(string $id)
    {
        $document = Document::findOrFail($id);
        try {
            \DB::beginTransaction();
            if ($document->file_path && \Storage::disk('public')->exists($document->file_path)) {
                \Storage::disk('public')->delete($document->file_path);
            }
            $document->delete();
            \DB::commit();
            // Log
            AppLog::create([
                'user_id' => null,
                'action' => 'delete',
                'module' => 'document',
                'ip_address' => request()->ip(),
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Dokumen berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal hapus dokumen: ' . $e->getMessage()
            ]);
        }
    }
}