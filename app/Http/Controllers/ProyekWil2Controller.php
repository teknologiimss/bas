<?php

namespace App\Http\Controllers;

use App\Models\ProyekWil2;
use Illuminate\Http\Request;

class ProyekWil2Controller extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $proyeks = ProyekWil2::when($search, function ($query, $search) {
            return $query->where('nama_proyek', 'like', "%{$search}%");
        })->paginate(10);

        return view('proyekwil2.index', compact('proyeks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
        ]);

        ProyekWil2::create([
            'nama_proyek' => $request->nama_proyek,
        ]);

        return redirect()->back()->with('success', 'Proyek Wilayah 2 berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
        ]);

        $proyek = ProyekWil2::findOrFail($id);
        $proyek->update([
            'nama_proyek' => $request->nama_proyek,
        ]);

        return redirect()->back()->with('success', 'Proyek Wilayah 2 berhasil diperbarui');
    }

    public function destroy($id)
    {
        $proyek = ProyekWil2::findOrFail($id);
        $proyek->delete();

        return redirect()->back()->with('success', 'Proyek Wilayah 2 berhasil dihapus');
    }
}