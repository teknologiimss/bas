<?php

namespace App\Http\Controllers;

use App\Models\MonitoringWil2;
use App\Models\MonitoringWil2Document;
use App\Models\Proyek;
use App\Models\ProyekWil2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use ZipArchive;

class MonitoringWil2Controller extends Controller
{
    public function index(Request $request, $proyek_id)
    {
        $proyek = ProyekWil2::findOrFail($proyek_id);
        $query = MonitoringWil2::with('documents')->where('proyek_id', $proyek_id);

        if ($request->filled('po')) {
            $query->where('po_nota_dinas', 'like', '%' . trim($request->po) . '%');
        }

        if ($request->filled('pekerjaan')) {
            $query->where('nama_pekerjaan', 'like', '%' . trim($request->pekerjaan) . '%');
        }

        $monitorings = $query->latest()->get();

        return view('monitoringwil2.index', compact('proyek', 'monitorings'));
    }

    public function store(Request $request, $proyek_id)
    {
        $request->validate([
            'po_nota_dinas' => 'required|string',
            'nama_pekerjaan' => 'required|string',
            'jenis_pekerjaan' => 'required|string',
            'tanggal_kontrak' => 'required|date',
            'tanggal_selesai_kontrak' => 'required|date',
            'status' => 'required|in:Open,Closed,On Hold',
        ]);

        $monitoring = MonitoringWil2::create([
            'proyek_id' => $proyek_id,
            'po_nota_dinas' => $request->po_nota_dinas,
            'nama_pekerjaan' => $request->nama_pekerjaan,
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
            'tanggal_kontrak' => $request->tanggal_kontrak,
            'tanggal_selesai_kontrak' => $request->tanggal_selesai_kontrak,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'progress' => 0,
            'keterangan2' => $request->keterangan2,
        ]);

        if ($request->hasFile('file_dokumen')) {
            $folder = public_path('lampiran');
            if (!file_exists($folder))
                mkdir($folder, 0777, true);

            foreach ($request->file('file_dokumen') as $index => $file) {
                $uniqueName = time() . '_' . $file->getClientOriginalName();
                $file->move($folder, $uniqueName);

                MonitoringWil2Document::create([
                    'monitoringwil2_id' => $monitoring->id,
                    'nama_dokumen' => $request->nama_dokumen[$index] ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                    'file_path' => 'lampiran/' . $uniqueName,
                ]);
            }

            $monitoring->progress = $monitoring->calculateProgress();
            $monitoring->save();
        }

        return redirect()->back()->with('success', 'Data Wilayah 2 berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $monitoring = MonitoringWil2::findOrFail($id);
        $monitoring->update($request->only([
            'po_nota_dinas',
            'nama_pekerjaan',
            'jenis_pekerjaan',
            'tanggal_kontrak',
            'tanggal_selesai_kontrak',
            'status',
            'keterangan',
            'keterangan2',
        ]));

        if ($request->hasFile('file_dokumen')) {
            $folder = public_path('lampiran');
            if (!file_exists($folder))
                mkdir($folder, 0777, true);

            foreach ($request->file('file_dokumen') as $index => $file) {
                $uniqueName = time() . '_' . $file->getClientOriginalName();
                $file->move($folder, $uniqueName);

                MonitoringWil2Document::create([
                    'monitoringwil2_id' => $monitoring->id,
                    'nama_dokumen' => $request->nama_dokumen[$index] ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                    'file_path' => 'lampiran/' . $uniqueName,
                ]);
            }

            $monitoring->progress = $monitoring->calculateProgress();
            $monitoring->save();
        }

        return redirect()->back()->with('success', 'Data Wilayah 2 berhasil diperbarui');
    }

    public function destroy($id)
    {
        $monitoring = MonitoringWil2::findOrFail($id);
        foreach ($monitoring->documents as $doc) {
            if ($doc->file_path && File::exists(public_path($doc->file_path))) {
                File::delete(public_path($doc->file_path));
            }
            $doc->delete();
        }
        $monitoring->delete();

        return redirect()->back()->with('success', 'Data Wilayah 2 berhasil dihapus');
    }

    public function updateDocument(Request $request, $id)
    {
        $document = MonitoringWil2Document::findOrFail($id);

        if ($request->has('nama_dokumen'))
            $document->nama_dokumen = $request->nama_dokumen;
        if ($request->has('status')) {
            $document->status = $request->status;
            $document->tanggal_closed = ($request->status === 'Closed') ? ($request->tanggal_closed ?? now()) : null;
            $document->keterangan_closed = ($request->status === 'Closed') ? $request->keterangan_closed : null;
        }

        if ($request->hasFile('file_dokumen')) {
            if ($document->file_path && File::exists(public_path($document->file_path))) {
                File::delete(public_path($document->file_path));
            }
            $file = $request->file('file_dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('lampiran'), $filename);
            $document->file_path = 'lampiran/' . $filename;
        }

        $document->save();

        $monitoring = $document->monitoring;
        $newProgress = $monitoring ? $monitoring->calculateProgress() : 0;
        if ($monitoring) {
            $monitoring->progress = $newProgress;
            $monitoring->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil diubah',
            'file_url' => asset($document->file_path) . '?v=' . time(),
            'progress' => $newProgress
        ]);
    }

    public function destroyDocument($id)
    {
        $document = MonitoringWil2Document::findOrFail($id);
        $monitoring = $document->monitoring;

        if ($document->file_path && File::exists(public_path($document->file_path))) {
            File::delete(public_path($document->file_path));
        }
        $document->delete();

        $newProgress = $monitoring ? $monitoring->calculateProgress() : 0;
        if ($monitoring) {
            $monitoring->progress = $newProgress;
            $monitoring->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil dihapus',
            'progress' => $newProgress
        ]);
    }

    public function reorderDocuments(Request $request)
    {
        $order = $request->input('order');
        if ($order) {
            foreach ($order as $item) {
                MonitoringWil2Document::where('id', $item['id'])->update(['position' => $item['position']]);
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }

    // Ubah nama method menjadi export

    public function export($proyek_id)
    {
        $proyek = Proyek::findOrFail($proyek_id);
        $monitorings = MonitoringWil2::with('documents')->where('proyek_id', $proyek_id)->get();

        // Nama file ZIP
        $zipFileName = 'export_monitoring_' . $proyek->nama_proyek . '_' . date('Ymd_His') . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        if (file_exists($zipPath)) {
            unlink($zipPath);
        }

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($monitorings as $m) {
                $folderName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $m->po_nota_dinas);

                foreach ($m->documents as $doc) {
                    if ($doc->file_path && file_exists(public_path($doc->file_path))) {
                        $fileAbsolute = public_path($doc->file_path);
                        $fileName = basename($doc->file_path);

                        $zip->addFile($fileAbsolute, $folderName . '/' . $fileName);
                    }
                }
            }

            $zip->close();

            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        return back()->with('error', '❌ Gagal membuat file ZIP.');
    }

    public function resumeProgress(Request $request)
    {
        $query = MonitoringWil2::query();

        if ($request->filled('po')) {
            $query->where('po_nota_dinas', 'like', '%' . $request->po . '%');
        }

        if ($request->filled('pekerjaan')) {
            $query->where('nama_pekerjaan', 'like', '%' . $request->pekerjaan . '%');
        }

        $monitorings = $query->paginate(10)->withQueryString();

        return view('mro.resume_progress_wil2', compact('monitorings'));
    }

    public function print()
    {
        $monitorings = MonitoringWil2::with('documents')->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('mro.progress.print_pdf_wil2', compact('monitorings'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('Progress_MRO_Wilayah_2_' . date('Ymd_His') . '.pdf');
    }
}
