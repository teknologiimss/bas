<?php

namespace App\Http\Controllers;

use App\Models\Checksheet5R;
use App\Models\FolderMonitoring5R;
use App\Models\Lampiran5R;
use App\Models\Monitoring5R;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class Monitoring5RController extends Controller
{
    public function index(Request $request)
    {
        $query = FolderMonitoring5R::query();
        if ($request->has('search') && $request->search != '') {
            $query
                ->where('tahun', 'like', '%' . $request->search . '%')
                ->orWhere('nama_folder', 'like', '%' . $request->search . '%');
        }
        $folders = $query->latest()->paginate(10);
        return view('monitoring_5r.index', compact('folders'));
    }

    public function storeFolder(Request $request)
    {
        $request->validate(['tahun' => 'required', 'nama_folder' => 'required']);
        FolderMonitoring5R::create($request->all());
        return redirect()->back()->with('success', 'Folder berhasil ditambahkan!');
    }

    public function destroyFolder($id)
    {
        FolderMonitoring5R::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Folder berhasil dihapus!');
    }

    public function monitor($folder_id, Request $request)
    {
        $folder = FolderMonitoring5R::findOrFail($folder_id);
        $query = Monitoring5R::where('folder_id', $folder_id);

        if ($request->no_kontrak) {
            $query->where('nomor_kontrak', 'like', '%' . $request->no_kontrak . '%');
        }
        if ($request->deskripsi) {
            $query->where('deskripsi_pekerjaan', 'like', '%' . $request->deskripsi . '%');
        }

        $items = $query->paginate(15);
        return view('monitoring_5r.monitor', compact('folder', 'items'));
    }

    public function storeItem(Request $request, $folder_id)
    {
        $request->validate([
            'deskripsi_pekerjaan' => 'required',
            'nomor_kontrak' => 'required',
        ]);

        Monitoring5R::create([
            'folder_id' => $folder_id,
            'deskripsi_pekerjaan' => $request->deskripsi_pekerjaan,
            'nomor_kontrak' => $request->nomor_kontrak,
            'tanggal_kontrak' => $request->tanggal_kontrak,
            'selesai_kontrak' => $request->selesai_kontrak,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function deleteItem($id)
    {
        $item = Monitoring5R::findOrFail($id);

        // Opsional: Hapus checksheet dan lampiran terkait bila perlu
        foreach ($item->checksheets as $checksheet) {
            foreach ($checksheet->lampirans as $lampiran) {
                if (file_exists(public_path($lampiran->file))) {
                    @unlink(public_path($lampiran->file));
                }
                $lampiran->delete();
            }
            $checksheet->delete();
        }

        $item->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function bulkDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        Monitoring5R::whereIn('id', $ids)->delete();
        return redirect()->back()->with('success', 'Data terpilih berhasil dihapus!');
    }

    // TAMPILKAN DETAIL MONITORING & CHECKSHEET 12 BULAN
    public function detailMonitor($id)
    {
        $data = Monitoring5R::findOrFail($id);
        // Key By Bulan (1-12) agar mudah dipanggil di Blade
        $checksheets = Checksheet5R::with('lampirans')
            ->where('monitoring_5r_id', $id)
            ->get()
            ->keyBy('bulan');

        return view('monitoring_5r.detail-monitor', compact('data', 'checksheets'));
    }

    // PROSES SIMPAN / UPDATE CHECKSHEET 12 BULAN & UPLOAD LAMPIRAN (SIMPAN KE public/lampiran)
    public function updateDetail(Request $request, $id)
    {
        $monitoring = Monitoring5R::findOrFail($id);

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $status = $request->status[$bulan] ?? null;
            $tanggal = $request->tanggal[$bulan] ?? null;
            $keterangan = $request->keterangan[$bulan] ?? null;

            $checksheet = Checksheet5R::updateOrCreate(
                [
                    'monitoring_5r_id' => $monitoring->id,
                    'bulan' => $bulan,
                ],
                [
                    'status' => $status,
                    'tanggal' => $tanggal,
                    'keterangan' => $keterangan,
                ]
            );

            $destinationPath = public_path('lampiran');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            // List jenis lampiran yang diproses
            $tipeLampiran = ['absensi', 'pelaporan'];

            foreach ($tipeLampiran as $jenis) {
                if ($request->hasFile("lampiran_{$jenis}.{$bulan}")) {
                    foreach ($request->file("lampiran_{$jenis}.{$bulan}") as $file) {
                        $originalName = $file->getClientOriginalName();
                        $filename = time() . '_' . uniqid() . '_' . $originalName;

                        $file->move($destinationPath, $filename);

                        Lampiran5R::create([
                            'checksheet_5r_id' => $checksheet->id,
                            'jenis_lampiran' => $jenis,
                            'file' => 'lampiran/' . $filename,
                            'nama_file' => $originalName,
                        ]);
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Laporan berhasil disimpan!');
    }

    // METHOD HAPUS LAMPIRAN FILE DARI public/lampiran
    public function deleteLampiran($id)
    {
        $lampiran = Lampiran5R::findOrFail($id);

        // Hapus file dari folder public/lampiran
        $fullPath = public_path($lampiran->file);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }

        $lampiran->delete();
        return redirect()->back()->with('success', 'Lampiran berhasil dihapus!');
    }

    // Method Update Folder
    public function updateFolder(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required',
            'nama_folder' => 'required',
        ]);

        $folder = FolderMonitoring5R::findOrFail($id);
        $folder->update([
            'tahun' => $request->tahun,
            'nama_folder' => $request->nama_folder,
        ]);

        return redirect()->back()->with('success', 'Folder berhasil diperbarui!');
    }

    // Update item pekerjaan/monitoring
    public function updateItem(Request $request, $id)
    {
        $request->validate([
            'deskripsi_pekerjaan' => 'required',
            'nomor_kontrak' => 'required',
        ]);

        $item = Monitoring5R::findOrFail($id);
        $item->update([
            'deskripsi_pekerjaan' => $request->deskripsi_pekerjaan,
            'nomor_kontrak' => $request->nomor_kontrak,
            'tanggal_kontrak' => $request->tanggal_kontrak,
            'selesai_kontrak' => $request->selesai_kontrak,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Data monitoring berhasil diperbarui!');
    }
}
