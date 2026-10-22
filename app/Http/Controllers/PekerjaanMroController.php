<?php

namespace App\Http\Controllers;

use App\Models\PekerjaanMro;
use App\Models\PekerjaanMroItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PekerjaanMroController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $proyeks = PekerjaanMro::when($search, function ($query, $search) {
            return $query
                ->where('nama_proyek', 'like', "%{$search}%")
                ->orWhere('no_kontrak', 'like', "%{$search}%");
        })->paginate(10);

        return view('pekerjaanmro.index', compact('proyeks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'no_kontrak' => 'nullable|string|max:255',
        ]);

        PekerjaanMro::create($request->all());

        return redirect()->route('pekerjaanmro.index')->with('success', 'Proyek MRO berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'no_kontrak' => 'nullable|string|max:255',
        ]);

        $proyek = PekerjaanMro::findOrFail($id);
        $proyek->update($request->all());

        return redirect()->route('pekerjaanmro.index')->with('success', 'Proyek MRO berhasil diupdate.');
    }

    public function destroy($id)
    {
        $proyek = PekerjaanMro::findOrFail($id);
        $proyek->delete();

        return redirect()->route('pekerjaanmro.index')->with('success', 'Proyek MRO berhasil dihapus.');
    }

    public function monitor($id)
    {
        $proyek = PekerjaanMro::with('items')->findOrFail($id);

        // Tentukan jumlah minggu dalam tahun berjalan (misal 2026)
        $year = Carbon::now()->year;
        $totalWeeks = Carbon::create($year, 12, 31)->weekOfYear;
        if ($totalWeeks == 1) {
            $totalWeeks = 52;
        }  // Fallback jika kalkulasi minggu edge case

        return view('pekerjaanmro.monitor', compact('proyek', 'totalWeeks', 'year'));
    }

    public function storeItem(Request $request, $id)
    {
        $request->validate([
            'item_pekerjaan' => 'required|array',
            'item_pekerjaan.*' => 'required|string',
            'satuan' => 'required|array',
            'vol_rencana' => 'required|array',
            'harga_satuan' => 'nullable|array',
            'progress_utama' => 'nullable|array',  // Progress (%) manual di tabel utama
        ]);

        $proyek = PekerjaanMro::findOrFail($id);

        foreach ($request->item_pekerjaan as $index => $itemNama) {
            PekerjaanMroItem::create([
                'pekerjaan_mro_id' => $proyek->id,
                'item_pekerjaan' => $itemNama,
                'satuan' => $request->satuan[$index],
                'vol_rencana' => $request->vol_rencana[$index],
                'harga_satuan' => !empty($request->harga_satuan[$index]) ? $request->harga_satuan[$index] : null,
                'progress_utama' => $request->progress_utama[$index] ?? 0,
                'progress_mingguan' => [],
            ]);
        }

        return redirect()->route('pekerjaanmro.monitor', $id)->with('success', 'Item pekerjaan berhasil ditambahkan.');
    }

    public function updateProgressUtama(Request $request)
    {
        $item = PekerjaanMroItem::findOrFail($request->item_id);
        $item->progress_utama = $request->progress_utama;
        $item->save();

        return redirect()->back()->with('success', 'Progress utama berhasil diperbarui.');
    }

    public function updateProgress(Request $request)
    {
        // Validasi atau pastikan item_id dikirim dari form
        $request->validate([
            'item_id' => 'required|exists:pekerjaan_mro_items,id',
        ]);

        $item = PekerjaanMroItem::findOrFail($request->item_id);

        // Ambil data progress mingguan yang lama
        $existingProgress = $item->progress_mingguan ?? [];

        // Timpa atau gabungkan dengan input baru yang dikirim dari input tabel
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
        $request->validate([
            'item_pekerjaan' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'vol_rencana' => 'required|numeric',
            'harga_satuan' => 'nullable|numeric',
            'progress_utama' => 'nullable|numeric',
        ]);

        $item = PekerjaanMroItem::findOrFail($id);
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
        $item = PekerjaanMroItem::findOrFail($id);
        $item->delete();
        return redirect()->back()->with('success', 'Item pekerjaan dihapus.');
    }
}
