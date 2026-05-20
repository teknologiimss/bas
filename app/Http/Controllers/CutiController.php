<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\CutiTahunan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    public function index(Request $request)
    {
        // default bulan & tahun sekarang
        $bulan = $request->bulan ?? date('m');

        $tahun = $request->tahun ?? date('Y');

        // khusus pegawai MRO
        $pegawai = CutiTahunan::select('nama_pegawai')
            ->distinct()
            ->orderBy('nama_pegawai')
            ->get();

        // query cuti
        // $cuti = Cuti::with('user')
        //     ->whereMonth(
        //         'tanggal_mulai',
        //         $bulan
        //     )
        //     ->whereYear(
        //         'tanggal_mulai',
        //         $tahun
        //     )
        //     ->latest();

        // query cuti
        $cuti = Cuti::whereMonth(
            'tanggal_mulai',
            $bulan
        )
            ->whereYear(
                'tanggal_mulai',
                $tahun
            )
            ->oldest();

        // optional filter pegawai
        // if ($request->pegawai) {
        //     $cuti->where(
        //         'user_id',
        //         $request->pegawai
        //     );
        // }

        if ($request->pegawai) {
            $cuti->where(
                'nama_pegawai',
                $request->pegawai
            );
        }

        $cuti = $cuti->get();

        return view(
            'cuti.index',
            compact(
                'pegawai',
                'cuti',
                'bulan',
                'tahun'
            )
        );
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'user_id' => 'required',
        //     'jenis' => 'required',
        //     'tanggal_mulai' => 'required',
        //     'tanggal_selesai' => 'required',
        // ]);

        $request->validate([
            'nama_pegawai' => 'required',
            'jenis' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
        ]);

        $mulai = Carbon::parse(
            $request->tanggal_mulai
        );

        $selesai = Carbon::parse(
            $request->tanggal_selesai
        );

        $jumlahHari =
            $mulai->diffInDays($selesai) + 1;

        // upload lampiran
        $lampiran = null;

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');

            $namaFile =
                time()
                . '_'
                . $file->getClientOriginalName();

            $file->move(
                public_path('lampiran_cuti'),
                $namaFile
            );

            $lampiran = $namaFile;
        }

        // Cuti::create([
        //     'user_id' => $request->user_id,
        //     'jenis' => $request->jenis,
        //     'tanggal_mulai' => $request->tanggal_mulai,
        //     'tanggal_selesai' => $request->tanggal_selesai,
        //     'keterangan' => $request->keterangan,
        //     'lampiran' => $lampiran,
        //     'jumlah_hari' => $jumlahHari,
        // ]);

        Cuti::create([
            'nama_pegawai' => $request->nama_pegawai,
            'jenis' => $request->jenis,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'keterangan' => $request->keterangan,
            'lampiran' => $lampiran,
            'jumlah_hari' => $jumlahHari,
        ]);

        return back()->with(
            'success',
            'Data cuti berhasil disimpan'
        );
    }

    // public function rekap(Request $request)
    // {
    //     $bulan = $request->bulan ?? date('m');

    //     $tahun = $request->tahun ?? date('Y');

    //     $jumlahHari = cal_days_in_month(
    //         CAL_GREGORIAN,
    //         $bulan,
    //         $tahun
    //     );

    //     // $pegawai = User::orderBy('name')->get();

    //     // khusus pegawai MRO
    //     // $pegawai = User::where('role', '14')
    //     //     ->orderBy('name')
    //     //     ->get();

    //     $pegawai = CutiTahunan::select('nama_pegawai')
    //         ->distinct()
    //         ->orderBy('nama_pegawai')
    //         ->get();

    //     $cuti = Cuti::all();

    //     return view(
    //         'cuti.rekap',
    //         compact(
    //             'pegawai',
    //             'cuti',
    //             'bulan',
    //             'tahun',
    //             'jumlahHari'
    //         )
    //     );
    // }

    public function rekap(Request $request)
    {
        $bulan = $request->bulan ?? date('m');

        $tahun = $request->tahun ?? date('Y');

        $jumlahHari = cal_days_in_month(
            CAL_GREGORIAN,
            $bulan,
            $tahun
        );

        // ambil pegawai berdasarkan tahun filter
        $pegawai = CutiTahunan::where('tahun', $tahun)
            ->select('nama_pegawai')
            ->distinct()
            ->oldest()
            ->get();

        // ambil data cuti sesuai tahun
        $cuti = Cuti::whereYear('tanggal_mulai', $tahun)->get();

        return view(
            'cuti.rekap',
            compact(
                'pegawai',
                'cuti',
                'bulan',
                'tahun',
                'jumlahHari'
            )
        );
    }

    public function edit($id)
    {
        $cuti = Cuti::findOrFail($id);

        // $pegawai = User::orderBy('name')->get();
        $pegawai = CutiTahunan::select('nama_pegawai')
            ->distinct()
            ->orderBy('nama_pegawai')
            ->get();

        return view(
            'cuti.edit',
            compact(
                'cuti',
                'pegawai'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $cuti = Cuti::findOrFail($id);

        // $request->validate([
        //     'user_id' => 'required',
        //     'jenis' => 'required',
        //     'tanggal_mulai' => 'required',
        //     'tanggal_selesai' => 'required',
        // ]);

        $request->validate([
            'nama_pegawai' => 'required',
            'jenis' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
        ]);

        $mulai = Carbon::parse(
            $request->tanggal_mulai
        );

        $selesai = Carbon::parse(
            $request->tanggal_selesai
        );

        $jumlahHari =
            $mulai->diffInDays($selesai) + 1;

        // upload lampiran baru
        if ($request->hasFile('lampiran')) {
            // hapus file lama
            if (
                $cuti->lampiran &&
                file_exists(
                    public_path(
                        'lampiran_cuti/'
                        . $cuti->lampiran
                    )
                )
            ) {
                unlink(
                    public_path(
                        'lampiran_cuti/'
                        . $cuti->lampiran
                    )
                );
            }

            $file = $request->file('lampiran');

            $namaFile =
                time()
                . '_'
                . $file->getClientOriginalName();

            $file->move(
                public_path('lampiran_cuti'),
                $namaFile
            );

            $cuti->lampiran = $namaFile;
        }

        // $cuti->update([
        //     'user_id' => $request->user_id,
        //     'jenis' => $request->jenis,
        //     'tanggal_mulai' => $request->tanggal_mulai,
        //     'tanggal_selesai' => $request->tanggal_selesai,
        //     'jumlah_hari' => $jumlahHari,
        //     'keterangan' => $request->keterangan,
        // ]);

        $cuti->update([
            'nama_pegawai' => $request->nama_pegawai,
            'jenis' => $request->jenis,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jumlah_hari' => $jumlahHari,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('cuti.index')
            ->with(
                'success',
                'Data cuti berhasil diupdate'
            );
    }

    public function destroy($id)
    {
        $cuti = Cuti::findOrFail($id);

        // hapus lampiran
        if (
            $cuti->lampiran &&
            file_exists(
                public_path(
                    'lampiran_cuti/'
                    . $cuti->lampiran
                )
            )
        ) {
            unlink(
                public_path(
                    'lampiran_cuti/'
                    . $cuti->lampiran
                )
            );
        }

        $cuti->delete();

        return back()->with(
            'success',
            'Data cuti berhasil dihapus'
        );
    }
}
