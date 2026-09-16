<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pompa;
use App\Models\PompaItem;
use App\Models\PompaPhoto;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PompaController extends Controller
{
    public function index(Request $request)
    {
        $query = Pompa::query();

        if ($request->filled('no_pompa')) {
            $query->where('no_pompa', 'like', '%' . $request->no_pompa . '%');
        }

        // Ubah 'no_aset' menjadi 'jenis_perawatan'
        if ($request->filled('jenis_perawatan')) {
            $query->where('jenis_perawatan', $request->jenis_perawatan);
        }

        $data = $query->latest()->get();

        return view('pompa.index', compact('data'));
    }

    public function create()
    {
        return view('pompa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'jenis_perawatan' => 'required',
        ]);

        $pompaData = [
            'judul' => $request->judul,
            'jenis_perawatan' => $request->jenis_perawatan,
            'no_pompa' => $request->no_pompa,
            'no_aset' => $request->no_aset,
            'lokasi' => $request->lokasi,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'personil' => $request->personil,
        ];

        // Kondisi jika perawatan jenis Unscheduled vs Scheduled
        if ($request->jenis_perawatan === 'Unscheduled') {
            $pompaData['no_form_unscheduled'] = $request->no_form_unscheduled;
            $pompaData['status_kondisi'] = $request->status_kondisi;
            $pompaData['kesimpulan'] = $request->kesimpulan;  // <--- Menyimpan kesimpulan
            $pompaData['jenis_kerusakan'] = $request->jenis_kerusakan;
            $pompaData['tindak_lanjut'] = $request->tindak_lanjut;
            $pompaData['durasi_pekerjaan'] = null;
        } else {
            $pompaData['durasi_pekerjaan'] = $request->durasi_pekerjaan;
        }

        $pompa = Pompa::create($pompaData);

        // Hanya simpan item jika jenis perawatan BUKAN Unscheduled
        if ($request->jenis_perawatan !== 'Unscheduled' && $request->has('items')) {
            foreach ($request->items as $itemData) {
                $nomor = $itemData['nomor'] ?? null;
                $uraian = $itemData['uraian_pekerjaan'];

                if (isset($itemData['details']) && is_array($itemData['details'])) {
                    foreach ($itemData['details'] as $detail) {
                        PompaItem::create([
                            'pompa_id' => $pompa->id,
                            'nomor' => $nomor,
                            'uraian_pekerjaan' => $uraian,
                            'aktivitas_pekerjaan' => $detail['aktivitas_pekerjaan'] ?? null,
                            'standar' => $detail['standar'] ?? null,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('pompa.index')->with('success', 'Checksheet Pompa berhasil dibuat!');
    }

    public function show($id)
    {
        $pompa = Pompa::with('items')->findOrFail($id);
        return view('pompa.show', compact('pompa'));
    }

    public function edit($id)
    {
        $checksheet = Pompa::with('items')->findOrFail($id);
        return view('pompa.edit', compact('checksheet'));
    }

    public function update(Request $request, $id)
    {
        $pompa = Pompa::findOrFail($id);

        $pompaData = [
            'judul' => $request->judul,
            'jenis_perawatan' => $request->jenis_perawatan,
            'no_pompa' => $request->no_pompa,
            'no_aset' => $request->no_aset,
            'lokasi' => $request->lokasi,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'personil' => $request->personil,
        ];

        if ($request->jenis_perawatan === 'Unscheduled') {
            $pompaData['no_form_unscheduled'] = $request->no_form_unscheduled;
            $pompaData['status_kondisi'] = $request->status_kondisi;
            $pompaData['kesimpulan'] = $request->kesimpulan;  // <--- Menyimpan update kesimpulan
            $pompaData['jenis_kerusakan'] = $request->jenis_kerusakan;
            $pompaData['tindak_lanjut'] = $request->tindak_lanjut;
            $pompaData['durasi_pekerjaan'] = null;

            // Hapus item-item jika diubah menjadi Unscheduled
            $pompa->items()->delete();
        } else {
            $pompaData['durasi_pekerjaan'] = $request->durasi_pekerjaan;
            $pompaData['no_form_unscheduled'] = null;
            $pompaData['status_kondisi'] = null;
            $pompaData['jenis_kerusakan'] = null;
            $pompaData['tindak_lanjut'] = null;

            // Simpan ulang item jika berupa Scheduled
            if ($request->has('items')) {
                $pompa->items()->delete();
                foreach ($request->items as $itemData) {
                    $nomor = $itemData['nomor'] ?? null;
                    $uraian = $itemData['uraian_pekerjaan'];

                    if (isset($itemData['details']) && is_array($itemData['details'])) {
                        foreach ($itemData['details'] as $detail) {
                            PompaItem::create([
                                'pompa_id' => $pompa->id,
                                'nomor' => $nomor,
                                'uraian_pekerjaan' => $uraian,
                                'aktivitas_pekerjaan' => $detail['aktivitas_pekerjaan'] ?? null,
                                'standar' => $detail['standar'] ?? null,
                            ]);
                        }
                    }
                }
            }
        }

        $pompa->update($pompaData);

        return redirect()->route('pompa.index')->with('success', 'Checksheet Pompa berhasil diubah!');
    }

    public function destroy($id)
    {
        $pompa = Pompa::findOrFail($id);
        $pompa->delete();
        return redirect()->route('pompa.index')->with('success', 'Checksheet berhasil dihapus!');
    }

    public function mobile($id)
    {
        $pompa = Pompa::with(['items.photos'])->findOrFail($id);
        return view('pompa.mobile', compact('pompa'));
    }

    public function saveMobile(Request $request, $id)
    {
        $pompa = Pompa::findOrFail($id);
        $pompa->update([
            'kesimpulan' => $request->kesimpulan,
            'catatan' => $request->catatan,
        ]);

        if ($request->has('items')) {
            foreach ($request->items as $itemId => $itemData) {
                $item = PompaItem::find($itemId);
                if ($item) {
                    $item->update([
                        'status' => $itemData['status'] ?? null,
                    ]);

                    if (isset($itemData['photos'])) {
                        foreach ($itemData['photos'] as $file) {
                            $filename = time() . '_' . $file->getClientOriginalName();
                            $file->move(public_path('uploads/pompa'), $filename);

                            PompaPhoto::create([
                                'pompa_item_id' => $item->id,
                                'foto' => $filename,
                                'alamat' => $itemData['alamat'] ?? null,
                            ]);
                        }
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Data inspeksi mobile berhasil disimpan!');
    }

    public function deletePhoto($id)
    {
        $photo = PompaPhoto::findOrFail($id);
        $filePath = public_path('uploads/pompa/' . $photo->foto);
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
        $photo->delete();
        return redirect()->back()->with('success', 'Foto berhasil dihapus!');
    }

    public function duplicate($id)
    {
        $original = Pompa::with('items')->findOrFail($id);
        $newPompa = $original->replicate();
        $newPompa->judul = $original->judul;
        $newPompa->created_at = now();
        $newPompa->save();

        foreach ($original->items as $item) {
            $newItem = $item->replicate();
            $newItem->pompa_id = $newPompa->id;
            $newItem->status = null;
            $newItem->save();
        }

        return redirect()->route('pompa.index')->with('success', 'Checksheet berhasil diduplikasi!');
    }

    public function uploadDokumen(Request $request, $id)
    {
        $request->validate(['dokumen' => 'required|file|max:60000']);
        $pompa = Pompa::findOrFail($id);

        if ($request->hasFile('dokumen')) {
            $path = $request->file('dokumen')->store('dokumen_pompa', 'public');
            $pompa->update(['dokumen' => $path]);
        }

        return redirect()->back()->with('success', 'Dokumen berhasil diunggah!');
    }

    public function deleteDokumen($id)
    {
        $pompa = Pompa::findOrFail($id);
        if ($pompa->dokumen) {
            Storage::disk('public')->delete($pompa->dokumen);
            $pompa->update(['dokumen' => null]);
        }
        return redirect()->back()->with('success', 'Dokumen berhasil dihapus!');
    }

    public function printPdf($id)
    {
        $pompa = Pompa::with(['items.photos'])->findOrFail($id);
        $pdf = Pdf::loadView('pompa.print', compact('pompa'));
        return $pdf->stream('Checksheet_Pompa_' . $pompa->no_pompa . '.pdf');
    }

    public function dashboard()
    {
        $totalMonitoring = Pompa::count();
        $totalSo = Pompa::where('kesimpulan', 'SO')->count();
        $totalSoCatatan = Pompa::whereIn('kesimpulan', ['SO DENGAN CATATAN', 'SO_NOTE'])->count();
        $totalTso = Pompa::where('kesimpulan', 'TSO')->count();
        $totalUnscheduled = Pompa::where('jenis_perawatan', 'Unscheduled')->count();
        $totalPending = Pompa::whereNull('kesimpulan')->orWhere('kesimpulan', '')->count();

        $perawatanCounts = [
            'P1' => Pompa::where('jenis_perawatan', 'P1')->count(),
            'P3' => Pompa::where('jenis_perawatan', 'P3')->count(),
            'P6' => Pompa::where('jenis_perawatan', 'P6')->count(),
            'P12' => Pompa::where('jenis_perawatan', 'P12')->count(),
            'Unscheduled' => $totalUnscheduled,
        ];

        $latestMonitoring = Pompa::latest()->take(5)->get();

        return view('pompa.dashboard', compact(
            'totalMonitoring',
            'totalSo',
            'totalSoCatatan',
            'totalTso',
            'totalUnscheduled',
            'totalPending',
            'perawatanCounts',
            'latestMonitoring'
        ));
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih untuk dihapus!');
        }

        $pompamList = Pompa::whereIn('id', $ids)->get();

        foreach ($pompamList as $pompa) {
            // Hapus berkas dokumen jika ada
            if ($pompa->dokumen && Storage::disk('public')->exists($pompa->dokumen)) {
                Storage::disk('public')->delete($pompa->dokumen);
            }

            // Hapus berkas foto dari pompa items
            foreach ($pompa->items as $item) {
                foreach ($item->photos as $photo) {
                    if (file_exists(public_path('uploads/pompa/' . $photo->foto))) {
                        unlink(public_path('uploads/pompa/' . $photo->foto));
                    }
                    $photo->delete();
                }
            }

            $pompa->delete();
        }

        return redirect()->route('pompa.index')->with('success', count($ids) . ' data checksheet berhasil dihapus!');
    }
}
