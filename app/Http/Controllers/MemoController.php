<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use App\Models\MemoItem;
use App\Models\Monitoring;
use App\Models\MonitoringDocument;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use setasign\Fpdi\Fpdi;

class MemoController extends Controller
{
    public function store(Request $request, $monitoringId)
    {
        $monitoring = Monitoring::findOrFail($monitoringId);

        $request->validate([
            'nomor_memo' => 'required',
            'tanggal' => 'required|date',
            'hal' => 'required',
            'dari' => 'required',
            'kepada' => 'required',
            'ttd_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_lampiran' => 'nullable|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        DB::beginTransaction();
        try {
            // A. Proses Simpan Gambar Tanda Tangan (Jika ada)
            $ttdPath = null;
            if ($request->hasFile('ttd_image')) {
                $ttdFile = $request->file('ttd_image');
                $ttdName = 'TTD_' . time() . '.' . $ttdFile->getClientOriginalExtension();
                $ttdFile->move(public_path('uploads/ttd'), $ttdName);
                $ttdPath = 'uploads/ttd/' . $ttdName;
            }

            // B. Proses Simpan File Lampiran (Jika ada)
            $lampiranPath = null;
            if ($request->hasFile('file_lampiran')) {
                $lampiranFile = $request->file('file_lampiran');
                $lampiranName = 'Lampiran_' . time() . '.' . $lampiranFile->getClientOriginalExtension();
                $lampiranFile->move(public_path('uploads/lampiran'), $lampiranName);
                $lampiranPath = 'uploads/lampiran/' . $lampiranName;
            }

            // C. Tentukan Path PDF Utama
            $fileName = 'Memo_' . str_replace('/', '-', $request->nomor_memo) . '_' . time() . '.pdf';
            $dbFilePath = 'documents/' . $fileName;

            // D. Buat Record Dokumen Monitoring
            $document = MonitoringDocument::create([
                'monitoring_id' => $monitoring->id,
                'nama_dokumen' => $request->nomor_memo . ' - ' . $request->hal,
                'file_path' => $dbFilePath,
                'status' => 'Closed',
                'tanggal_closed' => $request->tanggal,
                'keterangan_closed' => 'Memo dibuat otomatis dari sistem.'
            ]);

            // E. Buat Record Memo
            $memo = Memo::create([
                'monitoring_id' => $monitoring->id,
                'monitoring_document_id' => $document->id,
                'nomor_memo' => $request->nomor_memo,
                'tanggal' => $request->tanggal,
                'hal' => $request->hal,
                'dari' => $request->dari,
                'kepada' => $request->kepada,
                'pembuka' => $request->pembuka,
                'isi_utama' => $request->isi_utama,
                'has_table' => $request->has('has_table') ? true : false,
                'catatan_note' => $request->catatan_note,
                'penutup' => $request->penutup,
                'jabatan_penandatangan' => $request->jabatan_penandatangan ?? 'Kepala Divisi Wilayah II',
                'nama_penandatangan' => $request->nama_penandatangan,
                'ttd_path' => $ttdPath,
                'judul_lampiran' => $request->judul_lampiran,
                'lampiran_path' => $lampiranPath,
                'pdf_path' => $dbFilePath,
            ]);

            // F. Simpan Item Tabel
            if ($request->has_table && is_array($request->uraian_barang)) {
                foreach ($request->uraian_barang as $index => $uraian) {
                    if (!empty($uraian)) {
                        MemoItem::create([
                            'memo_id' => $memo->id,
                            'no' => $index + 1,
                            'uraian_barang' => $uraian,
                            'spesifikasi' => $request->spesifikasi[$index] ?? null,
                            'qty' => $request->qty[$index] ?? null,
                            'satuan' => $request->satuan[$index] ?? null,
                            'keterangan' => $request->keterangan_item[$index] ?? null,
                        ]);
                    }
                }
            }

            // G. Generate PDF File
            $memo->load('items');
            $pdf = Pdf::loadView('pdf.memo', compact('memo', 'monitoring'))->setPaper('a4', 'portrait');

            if (!file_exists(public_path('documents'))) {
                mkdir(public_path('documents'), 0777, true);
            }

            // Simpan sementara file memo dari DomPDF
            $tempMemoPath = public_path('documents/temp_' . $fileName);
            $pdf->save($tempMemoPath);

            // Cek apakah lampiran ada dan berformat PDF
            if ($lampiranPath && strtolower(pathinfo(public_path($lampiranPath), PATHINFO_EXTENSION)) === 'pdf' && file_exists(public_path($lampiranPath))) {
                $fpdi = new Fpdi();

                // 1. Gabungkan halaman dari Memo Utama
                $pageCount1 = $fpdi->setSourceFile($tempMemoPath);
                for ($i = 1; $i <= $pageCount1; $i++) {
                    $template = $fpdi->importPage($i);
                    $size = $fpdi->getTemplateSize($template);
                    $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $fpdi->useTemplate($template);
                }

                // 2. Gabungkan halaman dari File Lampiran PDF
                $pageCount2 = $fpdi->setSourceFile(public_path($lampiranPath));
                for ($i = 1; $i <= $pageCount2; $i++) {
                    $template = $fpdi->importPage($i);
                    $size = $fpdi->getTemplateSize($template);
                    $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $fpdi->useTemplate($template);
                }

                // Simpan hasil penggabungan ke file akhir & hapus file temp
                $fpdi->Output(public_path($dbFilePath), 'F');
                if (file_exists($tempMemoPath)) {
                    unlink($tempMemoPath);
                }
            } else {
                // Jika lampiran berupa gambar atau tidak ada lampiran, langsung gunakan file temp
                rename($tempMemoPath, public_path($dbFilePath));
            }

            DB::commit();

            return redirect()->back()->with('success', 'Memo dan lampiran berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membuat memo: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $memo = Memo::findOrFail($id);

        // 1. Hapus file TTD jika ada
        if ($memo->ttd_path && file_exists(public_path($memo->ttd_path))) {
            unlink(public_path($memo->ttd_path));
        }

        // 2. Hapus file lampiran jika ada
        if ($memo->lampiran_path && file_exists(public_path($memo->lampiran_path))) {
            unlink(public_path($memo->lampiran_path));
        }

        // 3. Hapus file PDF utama memo jika ada
        if ($memo->pdf_path && file_exists(public_path($memo->pdf_path))) {
            unlink(public_path($memo->pdf_path));
        }

        // 4. Hapus record dokumen monitoring terkait jika ada
        if ($memo->monitoring_document_id) {
            MonitoringDocument::destroy($memo->monitoring_document_id);
        }

        $memo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Memo beserta file terkait berhasil dihapus.'
        ]);
    }
}
