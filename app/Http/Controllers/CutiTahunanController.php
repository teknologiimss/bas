<?php

namespace App\Http\Controllers;

use App\Models\CutiTahunan;
use Illuminate\Http\Request;

class CutiTahunanController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');

        $data = CutiTahunan::where('tahun', $tahun)
            ->oldest()
            ->get();

        return view(
            'cuti_tahunan.index',
            compact(
                'data',
                'tahun'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'nama_pegawai' => 'required',
            'tahun' => 'required',
            'jatah' => 'required'

        ]);

        $cek = CutiTahunan::where(
                'nama_pegawai',
                $request->nama_pegawai
            )
            ->where(
                'tahun',
                $request->tahun
            )
            ->first();

        if ($cek) {

            return back()->with(
                'error',
                'Data sudah ada'
            );
        }

        CutiTahunan::create([

            'nama_pegawai' => $request->nama_pegawai,

            'tahun' => $request->tahun,

            'jatah' => $request->jatah,

            'carry_over' =>
                $request->carry_over ?? 0,

            'tambahan' =>
                $request->tambahan ?? 0,

            'pengurangan' =>
                $request->pengurangan ?? 0,

        ]);

        return back()->with(
            'success',
            'Data berhasil disimpan'
        );
    }

    public function update(Request $request, $id)
    {
        $data = CutiTahunan::findOrFail($id);

        $data->update([

            'nama_pegawai' => $request->nama_pegawai,

            'jatah' => $request->jatah,

            'carry_over' =>
                $request->carry_over,

            'tambahan' =>
                $request->tambahan,

            'pengurangan' =>
                $request->pengurangan,

        ]);

        return back()->with(
            'success',
            'Data berhasil diupdate'
        );
    }

    public function destroy($id)
    {
        CutiTahunan::findOrFail($id)
            ->delete();

        return back()->with(
            'success',
            'Data berhasil dihapus'
        );
    }
}