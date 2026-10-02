<?php

namespace App\Http\Controllers;

use App\Models\ProyekWil1;
use Illuminate\Http\Request;

class ProyekWil1Controller extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $proyeks = ProyekWil1::when($search, function ($query, $search) {
            return $query->where('nama_proyek', 'like', "%{$search}%");
        })->paginate(10);

        return view('proyekwil1.index', compact('proyeks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
        ]);

        ProyekWil1::create([
            'nama_proyek' => $request->nama_proyek,
        ]);

        return redirect()->back()->with('success', 'Proyek Wilayah 1 berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
        ]);

        $proyek = ProyekWil1::findOrFail($id);
        $proyek->update([
            'nama_proyek' => $request->nama_proyek,
        ]);

        return redirect()->back()->with('success', 'Proyek Wilayah 1 berhasil diperbarui');
    }

    public function destroy($id)
    {
        $proyek = ProyekWil1::findOrFail($id);
        $proyek->delete();

        return redirect()->back()->with('success', 'Proyek Wilayah 1 berhasil dihapus');
    }
}