<?php

namespace App\Http\Controllers;

use App\Models\Lp3m;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Lp3mController extends Controller
{
    public function index(Request $request)
    {
        $query = Lp3m::query();

        // SEARCH DESKRIPSI
        if ($request->filled('search')) {
            $query->where('deskripsi', 'like', '%' . $request->search . '%');
        }

        // SEARCH NO SPR
        if ($request->filled('spr_no')) {
            $query->where('spr_no', 'like', '%' . $request->spr_no . '%');
        }

        // FILTER TANGGAL
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $data = $query->oldest()->paginate(10);

        $data->appends($request->all());

        return view('lp3m.index', compact('data'));
    }

    public function create()
    {
        return view('lp3m.create');
    }

    /*
     * |--------------------------------------------------------------------------
     * | SIMPAN DATA AWAL
     * |--------------------------------------------------------------------------
     */

    public function store(Request $request)
    {
        $request->validate([
            // 'status' => 'required',
            'deskripsi' => 'required',
            'keterangan' => 'required',
        ]);

        $lp3m = Lp3m::create([
            // 'status' => $request->status,
            'deskripsi' => $request->deskripsi,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('lp3m.index', $lp3m->id)
            ->with('success', 'Data berhasil dibuat');
    }

    /*
     * |--------------------------------------------------------------------------
     * | FORM LP3M
     * |--------------------------------------------------------------------------
     */

    public function form($id)
    {
        $data = Lp3m::findOrFail($id);

        return view('lp3m.form', compact('data'));
    }

    /*
     * |--------------------------------------------------------------------------
     * | SIMPAN FORM LP3M
     * |--------------------------------------------------------------------------
     */

    public function saveForm(Request $request, $id)
    {
        $data = Lp3m::findOrFail($id);

        $data->update([
            'status' => $request->status,
            'spr_no' => $request->spr_no,
            'hasil_pengukuran' => $request->hasil_pengukuran,
            'penyebab_kerusakan' => $request->penyebab_kerusakan,
            'aus' => $request->has('aus'),
            'retak' => $request->has('retak'),
            'komponen_tak_berfungsi' => $request->has('komponen_tak_berfungsi'),
            'kelebihan_beban' => $request->has('kelebihan_beban'),
            'salah_operasi' => $request->has('salah_operasi'),
            'kelainan' => $request->has('kelainan'),
            'kecelakaan' => $request->has('kecelakaan'),
            'lain_lain_kerusakan' => $request->has('lain_lain_kerusakan'),
            // 'nama' => $request->nama,
            'nama' => json_encode($request->nama),
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'pekerjaan' => $request->pekerjaan,
            'komponen_diganti' => $request->has('komponen_diganti'),
            'diperiksa_disetel' => $request->has('diperiksa_disetel'),
            'diperbaiki_dibuat' => $request->has('diperbaiki_dibuat'),
            'dimodifikasi' => $request->has('dimodifikasi'),
            'dipindah_pasang_baru' => $request->has('dipindah_pasang_baru'),
            'diperlukan_evaluasi' => $request->has('diperlukan_evaluasi'),
            'lain_lain_tindakan' => $request->has('lain_lain_tindakan'),
            // 'nama_barang' => $request->nama_barang,
            // 'kode_barang' => $request->kode_barang,
            // 'jumlah' => $request->jumlah,
            'nama_barang' => json_encode(array_values(array_filter($request->nama_barang ?? []))),
            'kode_barang' => json_encode(array_values(array_filter($request->kode_barang ?? []))),
            'jumlah' => json_encode(array_values(array_filter($request->jumlah ?? []))),
            'tanggal_selesai' => $request->tanggal_selesai,
            'jam_selesai_detail' => $request->jam_selesai_detail,
            'detail_penyelesaian' => $request->detail_penyelesaian,
        ]);

        return redirect()
            ->route('lp3m.index', $data->id)
            ->with('success', 'Form LP3M berhasil disimpan');
    }

    public function edit($id)
    {
        $data = Lp3m::findOrFail($id);

        return view('lp3m.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Lp3m::findOrFail($id);

        $data->update([
            'deskripsi' => $request->deskripsi,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
            'spr_no' => $request->spr_no,
            'hasil_pengukuran' => $request->hasil_pengukuran,
            'penyebab_kerusakan' => $request->penyebab_kerusakan,
            'aus' => $request->has('aus'),
            'retak' => $request->has('retak'),
            'komponen_tak_berfungsi' => $request->has('komponen_tak_berfungsi'),
            'kelebihan_beban' => $request->has('kelebihan_beban'),
            'salah_operasi' => $request->has('salah_operasi'),
            'kelainan' => $request->has('kelainan'),
            'kecelakaan' => $request->has('kecelakaan'),
            'lain_lain_kerusakan' => $request->has('lain_lain_kerusakan'),
            // 'nama' => $request->nama,
            'nama' => json_encode($request->nama),
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'pekerjaan' => $request->pekerjaan,
            'komponen_diganti' => $request->has('komponen_diganti'),
            'diperiksa_disetel' => $request->has('diperiksa_disetel'),
            'diperbaiki_dibuat' => $request->has('diperbaiki_dibuat'),
            'dimodifikasi' => $request->has('dimodifikasi'),
            'dipindah_pasang_baru' => $request->has('dipindah_pasang_baru'),
            'diperlukan_evaluasi' => $request->has('diperlukan_evaluasi'),
            'lain_lain_tindakan' => $request->has('lain_lain_tindakan'),
            // 'nama_barang' => $request->nama_barang,
            // 'kode_barang' => $request->kode_barang,
            // 'jumlah' => $request->jumlah,
            'nama_barang' => json_encode(array_values(array_filter($request->nama_barang ?? []))),
            'kode_barang' => json_encode(array_values(array_filter($request->kode_barang ?? []))),
            'jumlah' => json_encode(array_values(array_filter($request->jumlah ?? []))),
            'tanggal_selesai' => $request->tanggal_selesai,
            'jam_selesai_detail' => $request->jam_selesai_detail,
            'detail_penyelesaian' => $request->detail_penyelesaian,
        ]);

        return redirect()
            ->route('lp3m.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function show($id)
    {
        $data = Lp3m::findOrFail($id);

        return view('lp3m.show', compact('data'));
    }

    public function destroy($id)
    {
        $data = Lp3m::findOrFail($id);

        // Hapus file lampiran
        if ($data->lampiran) {
            $filePath = public_path('lampiran/' . $data->lampiran);

            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        $data->delete();

        return redirect()
            ->route('lp3m.index')
            ->with('success', 'Data berhasil dihapus');
    }

    /*
     * |--------------------------------------------------------------------------
     * | PRINT PDF DOMPDF
     * |--------------------------------------------------------------------------
     */

    public function print($id)
    {
        $data = Lp3m::findOrFail($id);

        $pdf = Pdf::loadView('lp3m.print', compact('data'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('LP3M-' . $data->id . '.pdf');
    }

    public function getRiwayatSpr()
    {
        $riwayat = Lp3m::whereNotNull('spr_no')
            ->where('spr_no', '!=', '')
            ->select('id', 'spr_no', 'created_at')
            ->latest()
            ->get();

        return response()->json($riwayat);
    }

    // public function uploadLampiran(Request $request)
    // {
    //     $request->validate([
    //         'lampiran' => 'required|file|max:5120'
    //     ]);

    //     $data = Lp3m::findOrFail($request->id);

    //     if ($request->hasFile('lampiran')) {
    //         // hapus file lama
    //         if ($data->lampiran) {
    //             $oldFile = public_path('lampiran/' . $data->lampiran);

    //             if (File::exists($oldFile)) {
    //                 File::delete($oldFile);
    //             }
    //         }

    //         $file = $request->file('lampiran');

    //         $filename = time() . '_' . $file->getClientOriginalName();

    //         $file->move(
    //             public_path('lampiran'),
    //             $filename
    //         );

    //         $data->update([
    //             'lampiran' => $filename
    //         ]);
    //     }

    //     return redirect()
    //         ->route('lp3m.index')
    //         ->with(
    //             'success',
    //             'Lampiran berhasil diupload'
    //         );
    // }

    public function uploadLampiran(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:lp3m,id',
            'lampiran' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:51200'
        ]);

        $data = Lp3m::findOrFail($request->id);

        if ($request->hasFile('lampiran')) {
            // Hapus file lama jika ada
            if ($data->lampiran) {
                $oldFile = public_path('lampiran/' . $data->lampiran);

                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }

            $file = $request->file('lampiran');

            // Simpan dengan timestamp agar tidak bentrok
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(
                public_path('lampiran'),
                $filename
            );

            $data->update([
                'lampiran' => $filename
            ]);
        }

        return redirect()
            ->route('lp3m.index')
            ->with('success', 'Lampiran berhasil diupload');
    }

    public function deleteLampiran($id)
    {
        $data = Lp3m::findOrFail($id);

        if ($data->lampiran) {
            $filePath = public_path('lampiran/' . $data->lampiran);

            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            $data->update([
                'lampiran' => null
            ]);
        }

        return redirect()
            ->route('lp3m.index')
            ->with('success', 'Lampiran berhasil dihapus');
    }
}
