<?php

namespace App\Http\Controllers;  // atau namespace App\Http\Controllers; sesuaikan dengan project Anda

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
        if ($request->filled('no_aset')) {
            $query->where('no_aset', 'like', '%' . $request->no_aset . '%');
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
        $pompa = Pompa::create([
            'judul' => $request->judul,
            'jenis_perawatan' => $request->jenis_perawatan,
            'no_form_unscheduled' => $request->no_form_unscheduled,
            'no_pompa' => $request->no_pompa,
            'no_aset' => $request->no_aset,
            'lokasi' => $request->lokasi,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'durasi_pekerjaan' => $request->durasi_pekerjaan,
            'personil' => $request->personil,
            'status_kondisi' => $request->status_kondisi,
            'jenis_kerusakan' => $request->jenis_kerusakan,
            'tindak_lanjut' => $request->tindak_lanjut,
        ]);

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
        $pompa->update([
            'judul' => $request->judul,
            'jenis_perawatan' => $request->jenis_perawatan,
            'no_form_unscheduled' => $request->no_form_unscheduled,
            'no_pompa' => $request->no_pompa,
            'no_aset' => $request->no_aset,
            'lokasi' => $request->lokasi,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'durasi_pekerjaan' => $request->durasi_pekerjaan,
            'personil' => $request->personil,
            'status_kondisi' => $request->status_kondisi,
            'jenis_kerusakan' => $request->jenis_kerusakan,
            'tindak_lanjut' => $request->tindak_lanjut,
        ]);

        if ($request->jenis_perawatan !== 'Unscheduled' && $request->has('items')) {
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
        $newPompa->judul = $original->judul . ' (Copy)';
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
        $request->validate(['dokumen' => 'required|file|max:10240']);
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
}
