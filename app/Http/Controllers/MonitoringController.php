<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Models\MonitoringDocument;
use App\Models\Proyek;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class MonitoringController extends Controller
{
    public function index($proyek_id)
    {
        $proyek = Proyek::findOrFail($proyek_id);
        $monitorings = Monitoring::with('documents')->where('proyek_id', $proyek_id)->latest()->get();
        return view('monitoring.index', compact('proyek', 'monitorings'));
    }

    public function store(Request $request, $proyek_id)
    {
        $validated = $request->validate([
            'po_nota_dinas' => 'required|string',
            'nama_pekerjaan' => 'required|string',
            'jenis_pekerjaan' => 'required|string',
            'tanggal_kontrak' => 'required|date',
            'tanggal_selesai_kontrak' => 'required|date',
            'status' => 'required|in:Open,Closed,On Hold',
            'keterangan' => 'nullable|string',
            'nama_dokumen.*' => 'nullable|string',
            'file_dokumen.*' => 'nullable|file|max:60000',
        ]);

        $monitoring = Monitoring::create([
            'proyek_id' => $proyek_id,
            'po_nota_dinas' => $request->po_nota_dinas,
            'nama_pekerjaan' => $request->nama_pekerjaan,
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
            'tanggal_kontrak' => $request->tanggal_kontrak,
            'tanggal_selesai_kontrak' => $request->tanggal_selesai_kontrak,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        // if ($request->hasFile('file_dokumen')) {
        //     foreach ($request->file('file_dokumen') as $index => $file) {
        //         $path = $file->store('monitoring_docs', 'public');
        //         MonitoringDocument::create([
        //             'monitoring_id' => $monitoring->id,
        //             'nama_dokumen' => $request->nama_dokumen[$index] ?? 'Dokumen Tanpa Nama',
        //             'file_path' => $path,
        //         ]);
        //     }
        // }

        if ($request->hasFile('file_dokumen')) {
            foreach ($request->file('file_dokumen') as $index => $file) {
                // Pastikan folder lampiran ada
                $folder = public_path('lampiran');
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                // Ambil nama file asli
                $originalName = $file->getClientOriginalName();

                // Buat nama unik (supaya tidak menimpa file lama)
                $uniqueName = time() . '_' . $originalName;

                // Simpan file ke folder public/lampiran
                $file->move($folder, $uniqueName);

                // Simpan path ke database
                MonitoringDocument::create([
                    'monitoring_id' => $monitoring->id,
                    'nama_dokumen' => $request->nama_dokumen[$index] ?? pathinfo($originalName, PATHINFO_FILENAME),
                    'file_path' => 'lampiran/' . $uniqueName,  // tanpa 'storage/'
                ]);
            }
        }

        return redirect()->back()->with('success', 'Monitoring berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $monitoring = Monitoring::findOrFail($id);

        $request->validate([
            'po_nota_dinas' => 'required|string',
            'nama_pekerjaan' => 'required|string',
            'jenis_pekerjaan' => 'required|string',
            'tanggal_kontrak' => 'required|date',
            'tanggal_selesai_kontrak' => 'required|date',
            'status' => 'required|in:Open,Closed,On Hold',
            'keterangan' => 'nullable|string',
            'nama_dokumen.*' => 'nullable|string',
            'file_dokumen.*' => 'nullable|file|max:60000',
        ]);

        $monitoring->update($request->only([
            'po_nota_dinas',
            'nama_pekerjaan',
            'jenis_pekerjaan',
            'tanggal_kontrak',
            'tanggal_selesai_kontrak',
            'status',
            'keterangan',
        ]));

        // Upload dokumen tambahan jika ada
        // if ($request->hasFile('file_dokumen')) {
        //     foreach ($request->file('file_dokumen') as $index => $file) {
        //         $path = $file->store('monitoring_docs', 'public');
        //         MonitoringDocument::create([
        //             'monitoring_id' => $monitoring->id,
        //             'nama_dokumen' => $request->nama_dokumen[$index] ?? 'Dokumen Tambahan',
        //             'file_path' => $path,
        //         ]);
        //     }
        // }

        if ($request->hasFile('file_dokumen')) {
            foreach ($request->file('file_dokumen') as $index => $file) {
                // Pastikan folder lampiran ada
                $folder = public_path('lampiran');
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                // Ambil nama file asli
                $originalName = $file->getClientOriginalName();

                // Buat nama unik (supaya tidak menimpa file lama)
                $uniqueName = time() . '_' . $originalName;

                // Simpan file ke folder public/lampiran
                $file->move($folder, $uniqueName);

                // Simpan path ke database
                MonitoringDocument::create([
                    'monitoring_id' => $monitoring->id,
                    'nama_dokumen' => $request->nama_dokumen[$index] ?? pathinfo($originalName, PATHINFO_FILENAME),
                    'file_path' => 'lampiran/' . $uniqueName,  // tanpa 'storage/'
                ]);
            }
        }

        return redirect()->back()->with('success', 'Monitoring berhasil diperbarui');
    }

    public function destroy($id)
    {
        $monitoring = Monitoring::findOrFail($id);

        // Hapus file dokumen
        foreach ($monitoring->documents as $doc) {
            Storage::disk('public')->delete($doc->file_path);
            $doc->delete();
        }

        $monitoring->delete();

        return redirect()->back()->with('success', 'Monitoring berhasil dihapus');
    }

    public function destroyDocument($id)
    {
        $document = MonitoringDocument::findOrFail($id);

        // Hapus file fisik
        $filePath = public_path($document->file_path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Hapus record database
        $document->delete();

        // Kembalikan response JSON
        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil dihapus'
        ]);
    }

    public function updateDocument(Request $request, $id)
    {
        $document = MonitoringDocument::findOrFail($id);

        $document->nama_dokumen = $request->nama_dokumen;
        $document->status = $request->status ?? 'Open';
        $document->tanggal_closed = $request->status === 'Closed' ? ($request->tanggal_closed ?? now()) : null;
        $document->keterangan_closed = $request->status === 'Closed' ? $request->keterangan_closed : null;

        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = 'lampiran/' . $filename;
            $file->move(public_path('lampiran'), $filename);
            $document->file_path = $path;
        }

        $document->save();

        return response()->json(['success' => true, 'message' => 'Dokumen berhasil diperbarui.']);
    }

    public function exportZip($proyek_id)
    {
        $proyek = Proyek::findOrFail($proyek_id);
        $monitorings = Monitoring::with('documents')->where('proyek_id', $proyek_id)->get();

        // Nama file ZIP
        $zipFileName = 'export_monitoring_' . $proyek->nama_proyek . '_' . date('Ymd_His') . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        // Hapus ZIP jika sudah ada
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($monitorings as $m) {
                // Nama Folder berdasarkan Nomor PO / Nota Dinas
                $folderName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $m->po_nota_dinas);

                foreach ($m->documents as $doc) {
                    if ($doc->file_path && file_exists(public_path($doc->file_path))) {
                        $fileAbsolute = public_path($doc->file_path);
                        $fileName = basename($doc->file_path);

                        // Tambahkan file ke ZIP pada folder sesuai PO
                        $zip->addFile($fileAbsolute, $folderName . '/' . $fileName);
                    }
                }
            }

            $zip->close();

            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        return back()->with('error', '❌ Gagal membuat file ZIP.');
    }
}
