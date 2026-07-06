<?php

namespace App\Http\Controllers\MRO;

use App\Http\Controllers\Controller;
use App\Models\MasterPersonil;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class MasterPersonilController extends Controller
{
    public function index()
    {
        $data = MasterPersonil::oldest()->get();

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
            'nama' => 'required',
            'nip' => 'nullable',
            'status' => 'required',
            'penempatan' => 'required',
            'jabatan' => 'nullable',
            'jobdesk' => 'nullable',
            'spesialisasi' => 'nullable',
            'catatan' => 'nullable',
        ]);

        MasterPersonil::create($request->all());

        return redirect()
            ->route('master-personil.index')
            ->with('success', 'Data berhasil disimpan');
    }

    public function edit($id)
    {
        $personil = MasterPersonil::findOrFail($id);

        return view(
            'mro.master_personil.edit',
            compact('personil')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'nullable',
            'status' => 'required',
            'penempatan' => 'required',
            'jabatan' => 'nullable',
            'jobdesk' => 'nullable',
            'spesialisasi' => 'nullable',
            'catatan' => 'nullable',
        ]);

        $personil = MasterPersonil::findOrFail($id);

        $personil->update($request->all());

        return redirect()
            ->route('master-personil.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        MasterPersonil::findOrFail($id)->delete();

        return back()->with(
            'success',
            'Data berhasil dihapus'
        );
    }

    public function print()
    {
        $data = MasterPersonil::oldest()->get();

        $pdf = Pdf::loadView(
            'mro.master_personil.print',
            compact('data')
        )->setPaper('a4', 'landscape');

        return $pdf->stream('Master_Personil_MRO.pdf');
    }
}
