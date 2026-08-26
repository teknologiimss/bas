<?php

namespace App\Http\Controllers;

use App\Models\Chiller;
use App\Models\ChillerItem;
use App\Models\ChillerPhoto;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChillerController extends Controller
{
    public function index(Request $request)
    {
        $query = Chiller::query();

        if ($request->no_chiller) {
            $query->where('no_chiller', 'like', '%' . $request->no_chiller . '%');
        }

        if ($request->no_aset) {
            $query->where('no_aset', 'like', '%' . $request->no_aset . '%');
        }

        $data = $query->latest()->get();
        return view('chiller.index', compact('data'));
    }

    public function create()
    {
        return view('chiller.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'jenis_perawatan' => 'required',
        ]);

        $chiller = Chiller::create([
            'judul' => $request->judul,
            'jenis_perawatan' => $request->jenis_perawatan,
            'no_aset' => $request->no_aset,
            'lokasi' => $request->lokasi,
            'no_chiller' => $request->no_chiller,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'durasi_pekerjaan' => $request->durasi_pekerjaan,
            'personil' => $request->personil,
        ]);

        if ($request->has('items')) {
            foreach ($request->items as $item) {
                if (!empty($item['uraian_pekerjaan']) && isset($item['details'])) {
                    foreach ($item['details'] as $detail) {
                        if (!empty($detail['aktivitas_pekerjaan'])) {
                            ChillerItem::create([
                                'chiller_id' => $chiller->id,
                                'nomor' => $item['nomor'] ?? null,
                                'uraian_pekerjaan' => $item['uraian_pekerjaan'],
                                'aktivitas_pekerjaan' => $detail['aktivitas_pekerjaan'],
                                'standar' => $detail['standar'] ?? '',
                            ]);
                        }
                    }
                }
            }
        }

        return redirect()->route('chiller.index')->with('success', 'Checksheet Chiller Berhasil Dibuat!');
    }

    public function show($id)
    {
        $chiller = Chiller::with('items.photos')->findOrFail($id);
        return view('chiller.show', compact('chiller'));
    }

    public function edit($id)
    {
        // Cukup load relasi 'items'
        $checksheet = Chiller::with('items')->findOrFail($id);
        return view('chiller.edit', compact('checksheet'));
    }

    // public function update(Request $request, $id)
    // {
    //     $chiller = Chiller::findOrFail($id);

    //     // 1. Update Header
    //     $chiller->update([
    //         'judul' => $request->judul,
    //         'jenis_perawatan' => $request->jenis_perawatan,
    //         'no_aset' => $request->no_aset,
    //         'lokasi' => $request->lokasi,
    //         'no_chiller' => $request->no_chiller,
    //         'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
    //         'durasi_pekerjaan' => $request->durasi_pekerjaan,
    //         'personil' => $request->personil,
    //     ]);

    //     // 2. Hapus item lama dan simpan item baru
    //     $chiller->items()->delete();

    //     if ($request->has('items')) {
    //         foreach ($request->items as $item) {
    //             if (!empty($item['uraian_pekerjaan']) && isset($item['details'])) {
    //                 foreach ($item['details'] as $detail) {
    //                     if (!empty($detail['aktivitas_pekerjaan'])) {
    //                         ChillerItem::create([
    //                             'chiller_id' => $chiller->id,
    //                             'nomor' => $item['nomor'] ?? null,
    //                             'uraian_pekerjaan' => $item['uraian_pekerjaan'],
    //                             'aktivitas_pekerjaan' => $detail['aktivitas_pekerjaan'],
    //                             'standar' => $detail['standar'] ?? '',
    //                         ]);
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     return redirect()->route('chiller.index')->with('success', 'Checksheet Berhasil Diperbarui!');
    // }

    public function update(Request $request, $id)
    {
        $chiller = Chiller::findOrFail($id);

        // 1. Update Header
        $chiller->update([
            'judul' => $request->judul,
            'jenis_perawatan' => $request->jenis_perawatan,
            'no_aset' => $request->no_aset,
            'lokasi' => $request->lokasi,
            'no_chiller' => $request->no_chiller,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'durasi_pekerjaan' => $request->durasi_pekerjaan,
            'personil' => $request->personil,
        ]);

        // 2. Kumpulkan semua ID detail yang dikirim dari form
        $submittedDetailIds = [];

        if ($request->has('items')) {
            foreach ($request->items as $item) {
                if (!empty($item['uraian_pekerjaan']) && isset($item['details'])) {
                    foreach ($item['details'] as $detail) {
                        if (!empty($detail['aktivitas_pekerjaan'])) {
                            // Cek apakah item detail sudah ada sebelumnya
                            if (!empty($detail['id'])) {
                                $chillerItem = ChillerItem::find($detail['id']);
                                if ($chillerItem) {
                                    $chillerItem->update([
                                        'nomor' => $item['nomor'] ?? null,
                                        'uraian_pekerjaan' => $item['uraian_pekerjaan'],
                                        'aktivitas_pekerjaan' => $detail['aktivitas_pekerjaan'],
                                        'standar' => $detail['standar'] ?? '',
                                    ]);
                                    $submittedDetailIds[] = $chillerItem->id;
                                }
                            } else {
                                // Jika item detail baru ditambahkan dari halaman edit
                                $newItem = ChillerItem::create([
                                    'chiller_id' => $chiller->id,
                                    'nomor' => $item['nomor'] ?? null,
                                    'uraian_pekerjaan' => $item['uraian_pekerjaan'],
                                    'aktivitas_pekerjaan' => $detail['aktivitas_pekerjaan'],
                                    'standar' => $detail['standar'] ?? '',
                                ]);
                                $submittedDetailIds[] = $newItem->id;
                            }
                        }
                    }
                }
            }
        }

        // 3. Hapus item lama yang sengaja dibuang/dihapus oleh user di form edit beserta fotonya
        $itemsToDelete = $chiller->items()->whereNotIn('id', $submittedDetailIds)->get();
        foreach ($itemsToDelete as $deletedItem) {
            foreach ($deletedItem->photos as $photo) {
                if (file_exists(public_path('uploads/chiller/' . $photo->foto))) {
                    unlink(public_path('uploads/chiller/' . $photo->foto));
                }
                $photo->delete();
            }
            $deletedItem->delete();
        }

        return redirect()->route('chiller.index')->with('success', 'Checksheet Berhasil Diperbarui!');
    }

    public function mobile($id)
    {
        $chiller = Chiller::with('items.photos')->findOrFail($id);
        return view('chiller.mobile', compact('chiller'));
    }

    public function saveMobile(Request $request, $id)
    {
        $chiller = Chiller::findOrFail($id);
        $chiller->update([
            'kesimpulan' => $request->kesimpulan,
            'catatan' => $request->catatan,
        ]);

        if ($request->has('items')) {
            foreach ($request->items as $itemId => $itemData) {
                $item = ChillerItem::find($itemId);
                if ($item) {
                    $item->update([
                        'status' => $itemData['status'] ?? null,
                        'keterangan' => $itemData['keterangan'] ?? null,
                    ]);

                    if (isset($itemData['photos'])) {
                        foreach ($itemData['photos'] as $file) {
                            $fileName = time() . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
                            $file->move(public_path('uploads/chiller'), $fileName);

                            ChillerPhoto::create([
                                'chiller_item_id' => $item->id,
                                'foto' => $fileName,
                                'latitude' => $itemData['latitude'] ?? null,
                                'longitude' => $itemData['longitude'] ?? null,
                                'alamat' => $itemData['alamat'] ?? null,
                            ]);
                        }
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Data Hasil Inspeksi Berhasil Disimpan!');
    }

    public function print($id)
    {
        $chiller = Chiller::with('items.photos')->findOrFail($id);
        $pdf = Pdf::loadView('chiller.print', compact('chiller'));
        return $pdf->stream('Checksheet_Chiller_' . $chiller->no_chiller . '.pdf');
    }

    // --- FITUR BARU: UPLOAD DOKUMEN DARI INDEX ---
    public function uploadDokumen(Request $request, $id)
    {
        $request->validate([
            'dokumen' => 'required|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
        ]);

        $chiller = Chiller::findOrFail($id);

        if ($chiller->dokumen && Storage::disk('public')->exists($chiller->dokumen)) {
            Storage::disk('public')->delete($chiller->dokumen);
        }

        $filePath = $request->file('dokumen')->store('dokumen_chiller', 'public');
        $chiller->dokumen = $filePath;
        $chiller->save();

        return redirect()->back()->with('success', 'Dokumen lampiran berhasil diupload!');
    }

    // --- FITUR BARU: HAPUS DOKUMEN LAMPIRAN ---
    public function deleteDokumen($id)
    {
        $chiller = Chiller::findOrFail($id);

        if ($chiller->dokumen && Storage::disk('public')->exists($chiller->dokumen)) {
            Storage::disk('public')->delete($chiller->dokumen);
        }

        $chiller->dokumen = null;
        $chiller->save();

        return redirect()->back()->with('success', 'Dokumen lampiran berhasil dihapus!');
    }

    // public function destroy($id)
    // {
    //     $chiller = Chiller::findOrFail($id);
    //     $chiller->delete();
    //     return redirect()->route('chiller.index')->with('success', 'Data Berhasil Dihapus!');
    // }

    public function destroy($id)
    {
        $chiller = Chiller::findOrFail($id);

        // Hapus file dokumen dari storage jika ada
        if ($chiller->dokumen && Storage::disk('public')->exists($chiller->dokumen)) {
            Storage::disk('public')->delete($chiller->dokumen);
        }

        $chiller->delete();
        return redirect()->route('chiller.index')->with('success', 'Data Berhasil Dihapus!');
    }

    public function deletePhoto($id)
    {
        $photo = ChillerPhoto::findOrFail($id);
        if (file_exists(public_path('uploads/chiller/' . $photo->foto))) {
            unlink(public_path('uploads/chiller/' . $photo->foto));
        }
        $photo->delete();
        return redirect()->back()->with('success', 'Foto berhasil dihapus!');
    }

    public function duplicate($id)
    {
        // 1. Cari data chiller beserta item pendukungnya
        $original = Chiller::with('items')->findOrFail($id);

        // 2. Duplikasi data header (tanpa embel-embel Copy)
        $newChiller = Chiller::create([
            'judul' => $original->judul,
            'jenis_perawatan' => $original->jenis_perawatan,
            'no_aset' => null,  // Kosong
            'no_chiller' => null,  // Kosong
            'lokasi' => null,  // Kosong
            'tanggal_pelaksanaan' => null,  // Kosong
            'durasi_pekerjaan' => null,  // Kosong
            'personil' => null,  // Kosong
        ]);

        // 3. Duplikasi semua item / uraian & aktivitas pekerjaan
        foreach ($original->items as $item) {
            ChillerItem::create([
                'chiller_id' => $newChiller->id,
                'nomor' => $item->nomor,
                'uraian_pekerjaan' => $item->uraian_pekerjaan,
                'aktivitas_pekerjaan' => $item->aktivitas_pekerjaan,
                'standar' => $item->standar,
            ]);
        }

        return redirect()
            ->route('chiller.edit', $newChiller->id)
            ->with('success', 'Format berhasil diduplikasi! Silakan lengkapi data yang kosong.');
    }
}
