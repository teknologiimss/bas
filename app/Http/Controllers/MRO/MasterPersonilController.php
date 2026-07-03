<?php

namespace App\Http\Controllers\MRO;

use App\Http\Controllers\Controller;
use App\Models\MasterPersonil;
use Illuminate\Http\Request;

class MasterPersonilController extends Controller
{
    public function index()
    {
        $data = MasterPersonil::orderBy('nama')->get();

        return view(
            'mro.master_personil.index',
            compact('data')
        );
    }

    public function create()
    {
        return view('mro.master_personil.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'=>'required',
            'nip'=>'nullable',
            'status'=>'required',
            'penempatan'=>'required'
        ]);

        MasterPersonil::create($request->all());

        return redirect()
            ->route('master-personil.index')
            ->with('success','Data berhasil disimpan');
    }

    public function edit($id)
    {
        $personil = MasterPersonil::findOrFail($id);

        return view(
            'mro.master_personil.edit',
            compact('personil')
        );
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'nama'=>'required',
            'nip'=>'nullable',
            'status'=>'required',
            'penempatan'=>'required'
        ]);

        $personil=MasterPersonil::findOrFail($id);

        $personil->update($request->all());

        return redirect()
            ->route('master-personil.index')
            ->with('success','Data berhasil diupdate');
    }

    public function destroy($id)
    {
        MasterPersonil::findOrFail($id)->delete();

        return back()->with(
            'success',
            'Data berhasil dihapus'
        );
    }
}