<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::oldest()->paginate(20);

        return view(
            'assets.index',
            compact('assets')
        );
    }

    public function create()
    {
        return view('assets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit' => 'required',
            'no_lambung' => 'required',
            'lokasi' => 'required',
        ]);

        Asset::create([
            'unit' => $request->unit,
            'no_lambung' => $request->no_lambung,
            'lokasi' => $request->lokasi,
        ]);

        return redirect()
            ->route('assets.index')
            ->with(
                'success',
                'Asset berhasil ditambahkan'
            );
    }

    public function edit($id)
    {
        $asset = Asset::findOrFail($id);

        return view(
            'assets.edit',
            compact('asset')
        );
    }

    public function update(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        $asset->update([
            'unit' => $request->unit,
            'no_lambung' => $request->no_lambung,
            'lokasi' => $request->lokasi,
        ]);

        return redirect()
            ->route('assets.index')
            ->with(
                'success',
                'Asset berhasil diupdate'
            );
    }

    public function destroy($id)
    {
        Asset::findOrFail($id)->delete();

        return redirect()
            ->route('assets.index')
            ->with(
                'success',
                'Asset berhasil dihapus'
            );
    }
}