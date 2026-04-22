<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\PerencanaanProyek;
use Illuminate\Http\Request;

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
    public function store(Request $r)
    {
        Item::create($r->all());
        return back()->with('success', 'Data berhasil ditambah');
    }

    public function update(Request $r, $id)
    {
        Item::findOrFail($id)->update($r->all());
        return back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Item::findOrFail($id)->delete();
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
