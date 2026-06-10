<?php

namespace App\Http\Controllers;

use App\Models\FasilitasHarian;
use App\Models\FasilitasHarianAktivitas;
use App\Models\FasilitasHarianItem;
use App\Models\FasilitasHarianResult;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class FasilitasHarianController extends Controller
{
    /*
     * |--------------------------------------------------------------------------
     * | INDEX
     * |--------------------------------------------------------------------------
     */
    public function index()
    {
        $data = FasilitasHarian::oldest()->paginate(10);

        return view(
            'fasilitas_harian.index',
            compact('data')
        );
    }

    /*
     * |--------------------------------------------------------------------------
     * | CREATE
     * |--------------------------------------------------------------------------
     */
    public function create()
    {
        return view('fasilitas_harian.create');
    }

    /*
     * |--------------------------------------------------------------------------
     * | STORE
     * |--------------------------------------------------------------------------
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'bulan' => 'required',
            'tahun' => 'required',
        ]);

        $checksheet = FasilitasHarian::create([
            'judul' => $request->judul,
            'nomor_dokumen' => $request->nomor_dokumen,
            'nomor_fasilitas' => $request->nomor_fasilitas,
            'nomor_sertifikasi' => $request->nomor_sertifikasi,
            'nama_alat' => $request->nama_alat,
            'lokasi' => $request->lokasi,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'dibuat_oleh' => auth()->user()->name ?? null
        ]);

        if ($request->items) {
            // foreach ($request->items as $item) {
            //     FasilitasHarianItem::create([
            //         'fasilitas_harian_id' => $checksheet->id,
            //         'nomor' => $item['nomor'],
            //         'uraian_pekerjaan' => $item['uraian'],
            //         'aktivitas_pekerjaan' => $item['aktivitas']
            //     ]);
            // }

            foreach ($request->items as $item) {
                $itemDb = FasilitasHarianItem::create([
                    'fasilitas_harian_id' => $checksheet->id,
                    'nomor' => $item['nomor'],
                    'uraian_pekerjaan' => $item['uraian'],
                ]);

                if (isset($item['aktivitas'])) {
                    foreach ($item['aktivitas'] as $aktivitas) {
                        if (!empty($aktivitas)) {
                            FasilitasHarianAktivitas::create([
                                'item_id' => $itemDb->id,
                                'aktivitas' => $aktivitas
                            ]);
                        }
                    }
                }
            }
        }

        return redirect()
            ->route('fasilitas-harian.index')
            ->with(
                'success',
                'Checksheet berhasil dibuat'
            );
    }

    /*
     * |--------------------------------------------------------------------------
     * | SHOW MATRIX
     * |--------------------------------------------------------------------------
     */
    public function show($id)
    {
        // $checksheet = FasilitasHarian::with([
        //     'items.results'
        // ])->findOrFail($id);

        $checksheet = FasilitasHarian::with([
            'items.results',
            'items.aktivitas'
        ])->findOrFail($id);

        $bulanMap = [
            'Januari' => 1,
            'Februari' => 2,
            'Maret' => 3,
            'April' => 4,
            'Mei' => 5,
            'Juni' => 6,
            'Juli' => 7,
            'Agustus' => 8,
            'September' => 9,
            'Oktober' => 10,
            'November' => 11,
            'Desember' => 12,
        ];

        $bulanAngka = $bulanMap[$checksheet->bulan] ?? 1;

        $jumlahHari = cal_days_in_month(
            CAL_GREGORIAN,
            $bulanAngka,
            $checksheet->tahun
        );

        return view(
            'fasilitas_harian.show',
            compact(
                'checksheet',
                'bulanAngka',
                'jumlahHari'
            )
        );
    }

    /*
     * |--------------------------------------------------------------------------
     * | EDIT
     * |--------------------------------------------------------------------------
     */
    // public function edit($id)
    // {
    //     $data = FasilitasHarian::with(
    //         'items'
    //     )->findOrFail($id);

    //     return view(
    //         'fasilitas_harian.edit',
    //         compact('data')
    //     );
    // }

    public function edit($id)
    {
        $data = FasilitasHarian::with([
            'items.aktivitas'
        ])->findOrFail($id);

        return view(
            'fasilitas_harian.edit',
            compact('data')
        );
    }

    /*
     * |--------------------------------------------------------------------------
     * | UPDATE
     * |--------------------------------------------------------------------------
     */
    public function update(Request $request, $id)
    {
        $checksheet = FasilitasHarian::findOrFail($id);

        $checksheet->update([
            'judul' => $request->judul,
            'nomor_dokumen' => $request->nomor_dokumen,
            'nomor_fasilitas' => $request->nomor_fasilitas,
            'nomor_sertifikasi' => $request->nomor_sertifikasi,
            'nama_alat' => $request->nama_alat,
            'lokasi' => $request->lokasi,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
        ]);
        $existingIds = [];

        foreach ($request->items as $item) {
            /*
             * |--------------------------------------------------------------------------
             * | UPDATE ITEM LAMA
             * |--------------------------------------------------------------------------
             */
            if (!empty($item['id'])) {
                $itemDb = FasilitasHarianItem::find($item['id']);

                if ($itemDb) {
                    $itemDb->update([
                        'nomor' => $item['nomor'],
                        'uraian_pekerjaan' => $item['uraian'],
                    ]);

                    $existingIds[] = $itemDb->id;

                    /*
                     * |--------------------------------------------------------------------------
                     * | HAPUS AKTIVITAS LAMA
                     * |--------------------------------------------------------------------------
                     */
                    $itemDb->aktivitas()->delete();

                    if (isset($item['aktivitas'])) {
                        foreach ($item['aktivitas'] as $aktivitas) {
                            if (!empty($aktivitas)) {
                                FasilitasHarianAktivitas::create([
                                    'item_id' => $itemDb->id,
                                    'aktivitas' => $aktivitas
                                ]);
                            }
                        }
                    }
                }
            }
            /*
             * |--------------------------------------------------------------------------
             * | ITEM BARU
             * |--------------------------------------------------------------------------
             */ else {
                $itemDb = FasilitasHarianItem::create([
                    'fasilitas_harian_id' => $checksheet->id,
                    'nomor' => $item['nomor'],
                    'uraian_pekerjaan' => $item['uraian'],
                ]);

                $existingIds[] = $itemDb->id;

                if (isset($item['aktivitas'])) {
                    foreach ($item['aktivitas'] as $aktivitas) {
                        if (!empty($aktivitas)) {
                            FasilitasHarianAktivitas::create([
                                'item_id' => $itemDb->id,
                                'aktivitas' => $aktivitas
                            ]);
                        }
                    }
                }
            }
        }

        /*
         * |--------------------------------------------------------------------------
         * | HAPUS ITEM YANG SUDAH DIHILANGKAN USER
         * |--------------------------------------------------------------------------
         */

        $deletedItems = FasilitasHarianItem::where(
            'fasilitas_harian_id',
            $checksheet->id
        )
            ->whereNotIn('id', $existingIds)
            ->get();

        foreach ($deletedItems as $deleted) {
            /*
             * |--------------------------------------------------------------------------
             * | HAPUS RESULT TERKAIT
             * |--------------------------------------------------------------------------
             */

            FasilitasHarianResult::where(
                'item_id',
                $deleted->id
            )->delete();

            $deleted->aktivitas()->delete();

            $deleted->delete();
        }

        return redirect()
            ->route('fasilitas-harian.index')
            ->with(
                'success',
                'Data berhasil diperbarui'
            );
    }

    /*
     * |--------------------------------------------------------------------------
     * | DELETE
     * |--------------------------------------------------------------------------
     */
    public function destroy($id)
    {
        FasilitasHarian::findOrFail($id)
            ->delete();

        return back()
            ->with(
                'success',
                'Data berhasil dihapus'
            );
    }

    /*
     * |--------------------------------------------------------------------------
     * | MOBILE INPUT
     * |--------------------------------------------------------------------------
     */

    // public function mobile($id)
    // {
    //     $checksheet = FasilitasHarian::with([
    //         'items.aktivitas',
    //         'items.results'
    //     ])->findOrFail($id);

    //     return view(
    //         'fasilitas_harian.mobile',
    //         compact('checksheet')
    //     );
    // }
    public function mobile(Request $request, $id)
    {
        $tanggal = $request->tanggal ?? now()->format('Y-m-d');

        $checksheet = FasilitasHarian::with([
            'items.aktivitas',
            'items.results'
        ])->findOrFail($id);

        return view(
            'fasilitas_harian.mobile',
            compact(
                'checksheet',
                'tanggal'
            )
        );
    }

    /*
     * |--------------------------------------------------------------------------
     * | SAVE MOBILE
     * |--------------------------------------------------------------------------
     */
    // public function saveMobile(Request $request)
    // {
    //     if (!$request->results) {
    //         return back()
    //             ->with(
    //                 'error',
    //                 'Belum ada data yang dipilih'
    //             );
    //     }

    //     foreach ($request->results as $itemId => $value) {
    //         FasilitasHarianResult::updateOrCreate(
    //             [
    //                 'item_id' => $itemId,
    //                 'tanggal' => $request->tanggal
    //             ],
    //             [
    //                 'status' => $value['status'],
    //                 'keterangan' =>
    //                     $value['keterangan'] ?? null,
    //                 'nomor_spr' =>
    //                     $value['nomor_spr'] ?? null
    //             ]
    //         );
    //     }

    //     return back()
    //         ->with(
    //             'success',
    //             'Checksheet berhasil disimpan'
    //         );
    // }
    public function saveMobile(Request $request)
    {
        if ($request->tanggal > now()->format('Y-m-d')) {
            return back()->with(
                'error',
                'Tidak boleh input tanggal masa depan'
            );
        }
        if (!$request->results) {
            return back()->with(
                'error',
                'Belum ada data yang dipilih'
            );
        }

        foreach ($request->results as $itemId => $value) {
            // skip jika belum pilih status
            if (!isset($value['status'])) {
                continue;
            }

            FasilitasHarianResult::updateOrCreate(
                [
                    'item_id' => $itemId,
                    'tanggal' => $request->tanggal
                ],
                [
                    'status' => $value['status'],
                    'keterangan' => $value['keterangan'] ?? null,
                    'nomor_spr' => $value['nomor_spr'] ?? null,
                ]
            );
        }

        return back()->with(
            'success',
            'Checksheet berhasil disimpan'
        );
    }

    /*
     * |--------------------------------------------------------------------------
     * | PRINT PDF
     * |--------------------------------------------------------------------------
     */
    public function print($id)
    {
        $checksheet = FasilitasHarian::with([
            'items.results'
        ])->findOrFail($id);

        $bulanMap = [
            'Januari' => 1,
            'Februari' => 2,
            'Maret' => 3,
            'April' => 4,
            'Mei' => 5,
            'Juni' => 6,
            'Juli' => 7,
            'Agustus' => 8,
            'September' => 9,
            'Oktober' => 10,
            'November' => 11,
            'Desember' => 12,
        ];

        $bulanAngka = $bulanMap[$checksheet->bulan] ?? 1;

        $jumlahHari = cal_days_in_month(
            CAL_GREGORIAN,
            $bulanAngka,
            $checksheet->tahun
        );

        $pdf = Pdf::loadView(
            'fasilitas_harian.print',
            compact(
                'checksheet',
                'bulanAngka',
                'jumlahHari'
            )
        );

        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream(
            'checksheet-fasilitas.pdf'
        );
    }

    /*
     * |--------------------------------------------------------------------------
     * | DUPLICATE
     * |--------------------------------------------------------------------------
     */

    public function duplicate($id)
    {
        $old = FasilitasHarian::with([
            'items.aktivitas'
        ])->findOrFail($id);

        // HEADER
        $new = FasilitasHarian::create([
            'judul' => $old->judul,
            'nomor_dokumen' => $old->nomor_dokumen,
            'nomor_fasilitas' => $old->nomor_fasilitas,
            'nomor_sertifikasi' => $old->nomor_sertifikasi,
            'nama_alat' => $old->nama_alat,
            'lokasi' => $old->lokasi,
            'bulan' => $old->bulan,
            'tahun' => $old->tahun,
            'dibuat_oleh' => auth()->user()->name ?? null,
        ]);

        // ITEM
        foreach ($old->items as $item) {
            $newItem = FasilitasHarianItem::create([
                'fasilitas_harian_id' => $new->id,
                'nomor' => $item->nomor,
                'uraian_pekerjaan' => $item->uraian_pekerjaan,
            ]);

            // AKTIVITAS
            foreach ($item->aktivitas as $aktivitas) {
                FasilitasHarianAktivitas::create([
                    'item_id' => $newItem->id,
                    'aktivitas' => $aktivitas->aktivitas
                ]);
            }
        }

        return redirect()
            ->route('fasilitas-harian.index', $new->id)
            ->with(
                'success',
                'Checksheet berhasil diduplikasi'
            );
    }
}
