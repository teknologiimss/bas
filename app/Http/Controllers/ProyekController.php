<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    public function index(Request $request)
    {
        $query = Proyek::query();

        if ($request->search) {
            $query->where('nama_proyek', 'like', '%' . $request->search . '%');
        }

        $proyeks = $query->paginate(10);

        return view('proyek.index', compact('proyeks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_proyek' => 'required',
        ]);

        Proyek::create([
            'nama_proyek' => $request->nama_proyek
        ]);

        return redirect()->route('proyek.index')->with('success', 'Proyek berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_proyek' => 'required',
        ]);

        Proyek::where('id', $id)->update([
            'nama_proyek' => $request->nama_proyek
        ]);

        return redirect()->route('proyek.index')->with('success', 'Proyek berhasil diperbarui');
    }

    public function destroy($id)
    {
        Proyek::where('id', $id)->delete();

        return redirect()->route('proyek.index')->with('success', 'Proyek berhasil dihapus');
    }
}
