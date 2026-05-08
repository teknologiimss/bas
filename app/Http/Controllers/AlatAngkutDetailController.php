<?php

namespace App\Http\Controllers;

use App\Models\AlatAngkutChecksheet;
use App\Models\AlatAngkutDetail;
use App\Models\AlatAngkutLampiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AlatAngkutDetailController extends Controller
{
    public function store(Request $request)
    {
        // AlatAngkutDetail::create($request->all());
        AlatAngkutDetail::create([
            'alat_id' => $request->alat_id,
            'unit' => $request->unit,
            'no_lambung' => $request->no_lambung,
            'kapasitas' => $request->kapasitas,
            'lokasi' => $request->lokasi,
            'no_kontrak' => $request->no_kontrak,
            'aset' => $request->aset,
            'model_sn' => $request->model_sn,
            'tgl_kontrak' => $request->tgl_kontrak,
            'tgl_habis' => $request->tgl_habis,
            'kontrak_dgn' => $request->kontrak_dgn,
            'thn_kedatangan' => $request->thn_kedatangan,
        ]);

        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function delete($id)
    {
        AlatAngkutDetail::findOrFail($id)->delete();
        return back();
    }

    public function update(Request $request, $id)
    {
        $data = AlatAngkutDetail::findOrFail($id);

        $data->update([
            'unit' => $request->unit,
            'no_lambung' => $request->no_lambung,
            'kapasitas' => $request->kapasitas,
            'lokasi' => $request->lokasi,
            'no_kontrak' => $request->no_kontrak,
            'aset' => $request->aset,
            'model_sn' => $request->model_sn,
            'tgl_kontrak' => $request->tgl_kontrak,
            'tgl_habis' => $request->tgl_habis,
            'kontrak_dgn' => $request->kontrak_dgn,
            'thn_kedatangan' => $request->thn_kedatangan,
        ]);

        return back()->with('success', 'Data berhasil diupdate');
    }

    public function monitor($id)
    {
        $data = AlatAngkutDetail::findOrFail($id);

        $checksheets = AlatAngkutChecksheet::where('detail_id', $id)
            ->get()
            ->keyBy('bulan');

        return view('alat.detail-monitor', compact('data', 'checksheets'));
    }

    // public function storeChecksheet(Request $request)
    // {
    //     $detail_id = $request->detail_id;

    //     for ($i = 1; $i <= 12; $i++) {
    //         AlatAngkutChecksheet::updateOrCreate(
    //             [
    //                 'detail_id' => $detail_id,
    //                 'bulan' => $i
    //             ],
    //             [
    //                 'status' => $request->status[$i] ?? null,
    //                 'tanggal' => $request->tanggal[$i] ?? null,
    //                 'keterangan' => $request->keterangan[$i] ?? null,
    //             ]
    //         );
    //     }

    //     return back()->with('success', 'Checksheet berhasil disimpan');
    // }

    public function storeChecksheet(Request $request)
    {
        $request->validate([
            'lampiran.*.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:5120'
        ]);

        $detail_id = $request->detail_id;

        for ($i = 1; $i <= 12; $i++) {
            /*
             * |--------------------------------------------------------------------------
             * | Simpan Checksheet
             * |--------------------------------------------------------------------------
             */

            $checksheet = AlatAngkutChecksheet::updateOrCreate(
                [
                    'detail_id' => $detail_id,
                    'bulan' => $i
                ],
                [
                    'status' => $request->status[$i] ?? null,
                    'tanggal' => $request->tanggal[$i] ?? null,
                    'keterangan' => $request->keterangan[$i] ?? null,
                ]
            );

            /*
             * |--------------------------------------------------------------------------
             * | Upload Multiple Lampiran
             * |--------------------------------------------------------------------------
             */

            if ($request->hasFile("lampiran.$i")) {
                foreach ($request->file("lampiran.$i") as $file) {
                    $filename = time() . '_' . rand(100, 999) . '_' . $file->getClientOriginalName();

                    $destination = public_path('lampiran');

                    if (!File::exists($destination)) {
                        File::makeDirectory($destination, 0755, true);
                    }

                    $file->move($destination, $filename);

                    AlatAngkutLampiran::create([
                        'checksheet_id' => $checksheet->id,
                        'file' => 'lampiran/' . $filename,
                        'nama_file' => $file->getClientOriginalName(),
                    ]);
                }
            }
        }

        return back()->with('success', 'Checksheet berhasil disimpan');
    }

    public function deleteLampiran($id)
    {
        $lampiran = AlatAngkutLampiran::findOrFail($id);

        $filePath = public_path($lampiran->file);

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $lampiran->delete();

        return back()->with('success', 'Lampiran berhasil dihapus');
    }

    public function bulkDelete(Request $request)
    {
        $ids = explode(',', $request->ids);

        AlatAngkutDetail::whereIn('id', $ids)->delete();

        return back()->with('success', 'Data terpilih berhasil dihapus');
    }
}
