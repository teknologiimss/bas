<?php

namespace App\Http\Controllers;

use App\Models\EkspedisiDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EkspedisiDokumenController extends Controller
{
    public function index()
    {
        $dokumens = EkspedisiDokumen::with('sender')->latest()->get();
        return view('ekspedisi.index', compact('dokumens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|string',
            'diterima_oleh' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:12048',
        ]);

        $filePath = null;
        if ($request->hasFile('file_dokumen')) {
            $filePath = $request->file('file_dokumen')->store('ekspedisi_dokumen', 'public');
        }

        EkspedisiDokumen::create([
            'user_id' => Auth::id(),  // Otomatis mengisi ID user yang sedang login
            'deskripsi' => $request->deskripsi,
            'diterima_oleh' => $request->diterima_oleh,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'file_dokumen' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Data Ekspedisi Dokumen berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'deskripsi' => 'required|string',
            'diterima_oleh' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:12048',
        ]);

        $dokumen = EkspedisiDokumen::findOrFail($id);

        $filePath = $dokumen->file_dokumen;

        // Jika mengupload file baru
        if ($request->hasFile('file_dokumen')) {
            // Hapus file lama jika ada
            if ($dokumen->file_dokumen && Storage::disk('public')->exists($dokumen->file_dokumen)) {
                Storage::disk('public')->delete($dokumen->file_dokumen);
            }
            // Simpan file baru
            $filePath = $request->file('file_dokumen')->store('ekspedisi_dokumen', 'public');
        }

        $dokumen->update([
            'deskripsi' => $request->deskripsi,
            'diterima_oleh' => $request->diterima_oleh,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'file_dokumen' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Data Ekspedisi Dokumen berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $dokumen = EkspedisiDokumen::findOrFail($id);

        if ($dokumen->file_dokumen && Storage::disk('public')->exists($dokumen->file_dokumen)) {
            Storage::disk('public')->delete($dokumen->file_dokumen);
        }

        $dokumen->delete();

        return redirect()->back()->with('success', 'Data Ekspedisi Dokumen berhasil dihapus!');
    }
}
