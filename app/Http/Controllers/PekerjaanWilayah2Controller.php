<?php

namespace App\Http\Controllers;

use App\Models\MonitoringWil2;
use App\Models\PekerjaanWilayah2;
use App\Models\PekerjaanWilayah2Item;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PekerjaanWilayah2Controller extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $proyeks = PekerjaanWilayah2::when($search, function ($query, $search) {
            return $query
                ->where('nama_proyek', 'like', "%{$search}%")
                ->orWhere('no_kontrak', 'like', "%{$search}%");
        })->paginate(10);

        // Sinkronisasi otomatis tanggal kontrak dari tabel master MonitoringWil2
        foreach ($proyeks as $p) {
            if ($p->no_kontrak) {
                $monInfo = MonitoringWil2::where('po_nota_dinas', $p->no_kontrak)->first();
                if ($monInfo) {
                    $needsUpdate = false;
                    $updateData = [];

                    if ($p->tanggal_kontrak !== $monInfo->tanggal_kontrak) {
                        $updateData['tanggal_kontrak'] = $monInfo->tanggal_kontrak;
                        $needsUpdate = true;
                    }
                    if ($p->tanggal_selesai_kontrak !== $monInfo->tanggal_selesai_kontrak) {
                        $updateData['tanggal_selesai_kontrak'] = $monInfo->tanggal_selesai_kontrak;
                        $needsUpdate = true;
                    }

                    if ($needsUpdate) {
                        $p->update($updateData);
                    }
                }
            }
        }

        return view('wilayah2.proyek.index', compact('proyeks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'no_kontrak' => 'nullable|string|max:255',
            'tanggal_kontrak' => 'nullable|date',
            'tanggal_selesai_kontrak' => 'nullable|date',
        ]);

        $tanggalMulai = $request->tanggal_kontrak;
        $tanggalSelesai = $request->tanggal_selesai_kontrak;

        if ((!$tanggalMulai || !$tanggalSelesai) && $request->no_kontrak) {
            $monitoring = MonitoringWil2::where('po_nota_dinas', $request->no_kontrak)->first();
            if ($monitoring) {
                $tanggalMulai = $tanggalMulai ?? $monitoring->tanggal_kontrak;
                $tanggalSelesai = $tanggalSelesai ?? $monitoring->tanggal_selesai_kontrak;
            }
        }

        PekerjaanWilayah2::create([
            'nama_proyek' => $request->nama_proyek,
            'no_kontrak' => $request->no_kontrak,
            'tanggal_kontrak' => $tanggalMulai,
            'tanggal_selesai_kontrak' => $tanggalSelesai,
        ]);

        return redirect()->route('pekerjaanwil2.index')->with('success', 'Proyek Wilayah 2 berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'no_kontrak' => 'nullable|string|max:255',
            'tanggal_kontrak' => 'nullable|date',
            'tanggal_selesai_kontrak' => 'nullable|date',
        ]);

        $proyek = PekerjaanWilayah2::findOrFail($id);
        $tanggalMulai = $request->tanggal_kontrak;
        $tanggalSelesai = $request->tanggal_selesai_kontrak;

        if ((!$tanggalMulai || !$tanggalSelesai) && $request->no_kontrak) {
            $monitoring = MonitoringWil2::where('po_nota_dinas', $request->no_kontrak)->first();
            if ($monitoring) {
                $tanggalMulai = $tanggalMulai ?? $monitoring->tanggal_kontrak;
                $tanggalSelesai = $tanggalSelesai ?? $monitoring->tanggal_selesai_kontrak;
            }
        }

        $proyek->update([
            'nama_proyek' => $request->nama_proyek,
            'no_kontrak' => $request->no_kontrak,
            'tanggal_kontrak' => $tanggalMulai,
            'tanggal_selesai_kontrak' => $tanggalSelesai,
        ]);

        return redirect()->route('pekerjaanwil2.index')->with('success', 'Proyek Wilayah 2 berhasil diupdate.');
    }

    public function destroy($id)
    {
        $proyek = PekerjaanWilayah2::findOrFail($id);
        $proyek->delete();
        return redirect()->route('pekerjaanwil2.index')->with('success', 'Proyek Wilayah 2 berhasil dihapus.');
    }

    public function monitor($id)
    {
        $proyek = PekerjaanWilayah2::with('items')->findOrFail($id);
        $tglMulaiKontrak = $proyek->tanggal_kontrak;
        $tglSelesaiKontrak = $proyek->tanggal_selesai_kontrak;

        if ($proyek->no_kontrak) {
            $monInfo = MonitoringWil2::where('po_nota_dinas', $proyek->no_kontrak)->first();
            if ($monInfo) {
                $tglMulaiKontrak = $monInfo->tanggal_kontrak ?? $tglMulaiKontrak;
                $tglSelesaiKontrak = $monInfo->tanggal_selesai_kontrak ?? $tglSelesaiKontrak;
            }
        }

        if ($tglMulaiKontrak && $tglSelesaiKontrak) {
            $startDate = Carbon::parse($tglMulaiKontrak)->startOfDay();
            $endDate = Carbon::parse($tglSelesaiKontrak)->startOfDay();
            $diffDays = $startDate->diffInDays($endDate) + 1;
            $totalWeeks = (int) ceil($diffDays / 7);
            if ($totalWeeks < 1)
                $totalWeeks = 1;
        } else {
            $startDate = Carbon::now()->startOfYear();
            $totalWeeks = 52;
        }

        return view('wilayah2.proyek.monitor', compact('proyek', 'totalWeeks', 'tglMulaiKontrak', 'tglSelesaiKontrak', 'startDate'));
    }

    public function storeItem(Request $request, $id)
    {
        $request->validate([
            'item_pekerjaan' => 'required|array',
            'satuan' => 'required|array',
            'vol_rencana' => 'required|array',
        ]);

        $proyek = PekerjaanWilayah2::findOrFail($id);

        foreach ($request->item_pekerjaan as $index => $itemNama) {
            PekerjaanWilayah2Item::create([
                'pekerjaan_wilayah2_id' => $proyek->id,
                'item_pekerjaan' => $itemNama,
                'satuan' => $request->satuan[$index],
                'vol_rencana' => $request->vol_rencana[$index],
                'harga_satuan' => !empty($request->harga_satuan[$index]) ? $request->harga_satuan[$index] : null,
                'progress_utama' => $request->progress_utama[$index] ?? 0,
                'progress_mingguan' => [],
            ]);
        }

        return redirect()->route('pekerjaanwil2.monitor', $id)->with('success', 'Item pekerjaan berhasil ditambahkan.');
    }

    public function updateProgressUtama(Request $request)
    {
        $item = PekerjaanWilayah2Item::findOrFail($request->item_id);
        $item->progress_utama = $request->progress_utama;
        $item->save();
        return redirect()->back()->with('success', 'Progress utama berhasil diperbarui.');
    }

    public function updateProgress(Request $request)
    {
        $item = PekerjaanWilayah2Item::findOrFail($request->item_id);
        $existingProgress = $item->progress_mingguan ?? [];

        if ($request->has('vol_realisasi')) {
            foreach ($request->vol_realisasi as $week => $data) {
                $existingProgress[$week] = $data;
            }
        }

        $item->progress_mingguan = $existingProgress;
        $item->save();
        return redirect()->back()->with('success', 'Volume realisasi berhasil diperbarui.');
    }

    public function updateItem(Request $request, $id)
    {
        $item = PekerjaanWilayah2Item::findOrFail($id);
        $item->update([
            'item_pekerjaan' => $request->item_pekerjaan,
            'satuan' => $request->satuan,
            'vol_rencana' => $request->vol_rencana,
            'harga_satuan' => $request->harga_satuan,
            'progress_utama' => $request->progress_utama ?? 0,
        ]);
        return redirect()->back()->with('success', 'Item pekerjaan berhasil diupdate.');
    }

    public function destroyItem($id)
    {
        $item = PekerjaanWilayah2Item::findOrFail($id);
        $item->delete();
        return redirect()->back()->with('success', 'Item pekerjaan dihapus.');
    }
}
