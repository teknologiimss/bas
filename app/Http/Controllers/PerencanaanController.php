<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\PerencanaanProyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PerencanaanController extends Controller
{
    // =========================
    // LIST PROYEK PERENCANAAN
    // =========================
    // public function proyek()
    // {

    //     $data = PerencanaanProyek::paginate(10);
    //     return view('perencanaan.proyek', compact('data'));
    // }

    public function proyek(Request $request)
    {
        $query = \App\Models\PerencanaanProyek::query();

        if ($request->search) {
            $query->where('nama_proyek', 'like', '%' . $request->search . '%');
        }

        $data = $query->paginate(10);

        return view('perencanaan.proyek', compact('data'));
    }

    // =========================
    // DETAIL PERENCANAAN
    // =========================
    public function index($proyek_id)
    {
        $plan = Item::where('proyek_id', $proyek_id)
            ->where('tipe', 'plan')
            ->get()
            ->groupBy('kategori');

        $realisasi = Item::where('proyek_id', $proyek_id)
            ->where('tipe', 'realisasi')
            ->get()
            ->groupBy('kategori');

        return view('perencanaan.index', compact('plan', 'realisasi', 'proyek_id'));
    }

    // =========================
    // ITEM (PLAN / REALISASI)
    // =========================
    // public function store(Request $r)
    // {
    //     Item::create($r->all());
    //     return back()->with('success', 'Data berhasil ditambah');
    // }

    public function store(Request $r)
    {
        $item = Item::create($r->all());

        // 🔥 HANDLE LAMPIRAN (KHUSUS REALISASI)
        if ($r->tipe == 'realisasi' && $r->hasFile('lampiran')) {
            foreach ($r->file('lampiran') as $key => $file) {
                if ($file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('lampiran'), $filename);

                    $item->lampiran()->create([
                        'file' => $filename,
                        'keterangan' => $r->lampiran_keterangan[$key] ?? null
                    ]);
                }
            }
        }

        return back()->with('success', 'Data berhasil ditambah');
    }

    // public function update(Request $r, $id)
    // {
    //     Item::findOrFail($id)->update($r->all());
    //     return back()->with('success', 'Data berhasil diupdate');
    // }

    public function update(Request $r, $id)
    {
        $item = Item::with('lampiran')->findOrFail($id);

        // =========================
        // UPDATE DATA ITEM
        // =========================
        $item->update($r->only([
            'uraian',
            'qty',
            'satuan',
            'keterangan'
        ]));

        // =====================================================
        // 🔥 HAPUS LAMPIRAN
        // =====================================================
        if ($r->hapus_lampiran) {
            foreach ($r->hapus_lampiran as $lampiranId) {
                $lampiran = $item->lampiran()->where('id', $lampiranId)->first();

                if ($lampiran) {
                    $path = public_path('lampiran/' . $lampiran->file);

                    if (File::exists($path)) {
                        File::delete($path);
                    }

                    $lampiran->delete();
                }
            }
        }

        // =====================================================
        // 🔥 UPDATE / REPLACE LAMPIRAN LAMA
        // =====================================================
        if ($r->old_keterangan) {
            foreach ($r->old_keterangan as $lampiranId => $ket) {
                $lampiran = $item->lampiran()->where('id', $lampiranId)->first();

                if ($lampiran) {
                    // update keterangan
                    $lampiran->keterangan = $ket;

                    // replace file jika ada
                    if ($r->hasFile("replace_file.$lampiranId")) {
                        $oldPath = public_path('lampiran/' . $lampiran->file);
                        if (File::exists($oldPath)) {
                            File::delete($oldPath);
                        }

                        $file = $r->file("replace_file.$lampiranId");
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('lampiran'), $filename);

                        $lampiran->file = $filename;
                    }

                    $lampiran->save();
                }
            }
        }

        // =====================================================
        // 🔥 TAMBAH LAMPIRAN BARU
        // =====================================================
        if ($r->hasFile('lampiran')) {
            foreach ($r->file('lampiran') as $key => $file) {
                if ($file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('lampiran'), $filename);

                    $item->lampiran()->create([
                        'file' => $filename,
                        'keterangan' => $r->lampiran_keterangan[$key] ?? null
                    ]);
                }
            }
        }

        return back()->with('success', 'Data berhasil diupdate');
    }

    // public function destroy($id)
    // {
    //     Item::findOrFail($id)->delete();
    //     return back()->with('success', 'Data berhasil dihapus');
    // }

    public function destroy($id)
    {
        $item = Item::with('lampiran')->findOrFail($id);

        // 🔥 hapus file fisik
        foreach ($item->lampiran as $l) {
            $path = public_path('lampiran/' . $l->file);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $item->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }

    // =========================
    // CRUD PROYEK PERENCANAAN
    // =========================
    public function storeProyek(Request $request)
    {
        $request->validate([
            'nama_proyek' => 'required'
        ]);

        PerencanaanProyek::create([
            'nama_proyek' => $request->nama_proyek
        ]);

        return back()->with('success', 'Proyek berhasil ditambahkan');
    }

    public function updateProyek(Request $request, $id)
    {
        $request->validate([
            'nama_proyek' => 'required'
        ]);

        PerencanaanProyek::findOrFail($id)->update([
            'nama_proyek' => $request->nama_proyek
        ]);

        return back()->with('success', 'Proyek berhasil diupdate');
    }

    public function deleteProyek($id)
    {
        PerencanaanProyek::findOrFail($id)->delete();
        return back()->with('success', 'Proyek berhasil dihapus');
    }
}
