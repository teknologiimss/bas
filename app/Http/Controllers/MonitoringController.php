<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use App\Models\Monitoring;
use App\Models\MonitoringDocument;
use App\Models\Proyek;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class MonitoringController extends Controller
{
    // public function index($proyek_id)
    // {
    //     $proyek = Proyek::findOrFail($proyek_id);
    //     $monitorings = Monitoring::with('documents',
    //         'folders.documents')->where('proyek_id', $proyek_id)->latest()->get();
    //     return view('monitoring.index', compact('proyek', 'monitorings'));
    // }

    // Klik PO/Nodin Spesifik ke Halaman Monitoring
    public function index(Request $request, $proyek_id)
    {
        $proyek = Proyek::findOrFail($proyek_id);

        $query = Monitoring::with('documents', 'folders.documents')
            ->where('proyek_id', $proyek_id);

        // 🔍 Filter PO / Nota Dinas
        if ($request->filled('po')) {
            $query->where('po_nota_dinas', 'like', '%' . trim($request->po) . '%');
        }

        // 🔍 Filter Nama Pekerjaan
        if ($request->filled('pekerjaan')) {
            $query->where('nama_pekerjaan', 'like', '%' . trim($request->pekerjaan) . '%');
        }

        $monitorings = $query->latest()->get();

        return view('monitoring.index', compact('proyek', 'monitorings'));
    }

    public function resumeProgress(Request $request)
    {
        $query = Monitoring::query();

        if ($request->filled('po')) {
            $query->where('po_nota_dinas', 'like', '%' . $request->po . '%');
        }

        if ($request->filled('pekerjaan')) {
            $query->where('nama_pekerjaan', 'like', '%' . $request->pekerjaan . '%');
        }

        $monitorings = $query->paginate(10)->withQueryString();

        return view('mro.resume_progress', compact('monitorings'));
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
            'progress' => 'nullable|string',
            'keterangan2' => 'nullable|string',
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
            'progress' => $request->progress,
            'keterangan2' => $request->keterangan2,
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

            // Hitung Ulang Progress Persen
            $monitoring->progress = $monitoring->calculateProgress();
            $monitoring->save();
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
            'progress' => 'nullable|string',
            'keterangan2' => 'nullable|string',
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
            'progress',
            'keterangan2',
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

            // Hitung Ulang Progress Persen
            $monitoring->progress = $monitoring->calculateProgress();
            $monitoring->save();
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

    // public function destroyDocument($id)
    // {
    //     $document = MonitoringDocument::findOrFail($id);

    //     // Hitung Ulang Progress persen
    //     $monitoring = $document->monitoring;

    //     // Hapus file fisik
    //     $filePath = public_path($document->file_path);
    //     if (file_exists($filePath)) {
    //         unlink($filePath);
    //     }

    //     // Hapus record database
    //     $document->delete();

    //     // 🔥 HITUNG ULANG PROGRESS persen
    //     $monitoring->progress = $monitoring->calculateProgress();
    //     $monitoring->save();

    //     // Kembalikan response JSON
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Dokumen berhasil dihapus'
    //     ]);
    // }

    public function destroyDocument($id)
    {
        DB::beginTransaction();

        try {
            $document = MonitoringDocument::findOrFail($id);
            $monitoring = $document->monitoring;

            // 1. HAPUS MEMO DENGAN 2 KONDISI:
            // - Berdasarkan ID Dokumen (monitoring_document_id)
            // - ATAU berdasarkan kesamaan file PDF (pdf_path == file_path) untuk data lama
            Memo::where('monitoring_document_id', $document->id)
                ->orWhere('pdf_path', $document->file_path)
                ->delete();

            // 2. Hapus file fisik dari public/documents
            if ($document->file_path) {
                $filePath = public_path($document->file_path);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // 3. Hapus record dokumen
            $document->delete();

            // 4. Hitung ulang progress
            $newProgress = 0;
            if ($monitoring) {
                $newProgress = $monitoring->calculateProgress();
                $monitoring->progress = $newProgress;
                $monitoring->save();
            }

            DB::commit();

            return response()->json([
                'success'  => true,
                'message'  => 'Dokumen dan Memo terkait berhasil dihapus dari database',
                'progress' => $newProgress
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    // public function updateDocument(Request $request, $id)
    // {
    //     $document = MonitoringDocument::findOrFail($id);

    //     $document->nama_dokumen = $request->nama_dokumen;
    //     $document->status = $request->status ?? 'Open';
    //     $document->tanggal_closed = $request->status === 'Closed' ? ($request->tanggal_closed ?? now()) : null;
    //     $document->keterangan_closed = $request->status === 'Closed' ? $request->keterangan_closed : null;

    //     if ($request->hasFile('file_dokumen')) {
    //         $file = $request->file('file_dokumen');
    //         $filename = time() . '_' . $file->getClientOriginalName();
    //         $path = 'lampiran/' . $filename;
    //         $file->move(public_path('lampiran'), $filename);
    //         $document->file_path = $path;
    //     }

    //     $document->save();

    //     // 🔥 HITUNG ULANG PROGRESS persen
    //     $monitoring = $document->monitoring;
    //     $monitoring->progress = $monitoring->calculateProgress();
    //     $monitoring->save();

    //     return response()->json(['success' => true, 'message' => 'Dokumen berhasil diperbarui.']);
    // }

    public function updateDocument(Request $request, $id)
    {
        $document = MonitoringDocument::findOrFail($id);

        if ($request->hasFile('file_dokumen')) {
            // Hapus file lama
            if ($document->file_path && File::exists(public_path($document->file_path))) {
                File::delete(public_path($document->file_path));
            }

            // Upload file baru (PASTI UNIK)
            $file = $request->file('file_dokumen');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('lampiran'), $filename);

            $document->file_path = 'lampiran/' . $filename;
            $document->save();
        }

        return response()->json([
            'success' => true,
            'file_url' => asset($document->file_path) . '?v=' . time()
        ]);
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

    // public function updateProgress(Request $request, $id)
    // {
    //     $request->validate([
    //         'progress' => 'required|integer|min:0|max:100',
    //         'keterangan_progress' => 'nullable|string'
    //     ]);

    //     $monitoring = Monitoring::findOrFail($id);
    //     $monitoring->update([
    //         'progress' => $request->progress,
    //         'keterangan2' => $request->keterangan2
    //     ]);

    //     return redirect()->back()->with('success', 'Progress berhasil diperbarui');
    // }

    // public function destroyprogress($id)
    // {
    //     Monitoring::findOrFail($id)->delete();
    //     return redirect()->back()->with('success', 'Data monitoring dihapus');
    // }

    public function print()
    {
        $monitorings = Monitoring::all();  // TANPA paginate

        return view('mro.progress.print', compact('monitorings'));
    }
}
