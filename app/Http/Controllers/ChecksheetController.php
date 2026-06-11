<?php

namespace App\Http\Controllers;

use App\Models\Checksheet;
use App\Models\ChecksheetItem;
use App\Models\ChecksheetItemDetail;
use App\Models\ChecksheetResult;
use App\Models\ChecksheetResultPhoto;
use App\Models\ChecksheetSection;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Image;

class ChecksheetController extends Controller
{
    // =========================
    // LIST
    // =========================
    // public function index()
    // {
    //     // $data = Checksheet::latest()->get();
    //     $data = Checksheet::oldest()->get();

    //     return view('checksheet.index', compact('data'));
    // }

    public function index(Request $request)
    {
        $query = Checksheet::query();

        // =========================
        // FILTER UNIT
        // =========================
        if ($request->filled('unit')) {
            $query->where(
                'unit',
                'like',
                '%' . $request->unit . '%'
            );
        }

        // =========================
        // FILTER NO LAMBUNG
        // =========================
        if ($request->filled('no_lambung')) {
            $query->where(
                'no_lambung',
                'like',
                '%' . $request->no_lambung . '%'
            );
        }

        // =========================
        // GET DATA
        // =========================
        $data = $query
            ->oldest()
            ->get();

        return view(
            'checksheet.index',
            compact('data')
        );
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        return view('checksheet.create');
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {
        // VALIDASI
        $request->validate([
            'judul' => 'required|string|max:255',
        ]);

        // HEADER
        $checksheet = Checksheet::create([
            'judul' => $request->judul,
            'unit' => $request->unit,
            'no_lambung' => $request->no_lambung,
            'tanggal' => $request->tanggal,
            'jenis_perawatan' => $request->jenis_perawatan,
        ]);

        // SECTION
        if (!empty($request->sections)) {
            foreach ($request->sections as $sIndex => $section) {
                if (empty($section['nama'])) {
                    continue;
                }

                $sec = ChecksheetSection::create([
                    'checksheet_id' => $checksheet->id,
                    'kode' => $section['kode'] ?? null,
                    'nama_section' => $section['nama'],
                    'urutan' => $sIndex
                ]);

                // ITEMS
                if (!empty($section['items'])) {
                    foreach ($section['items'] as $iIndex => $item) {
                        if (empty($item['uraian'])) {
                            continue;
                        }

                        // CREATE ITEM
                        $newItem = ChecksheetItem::create([
                            'section_id' => $sec->id,
                            'nomor' => $itemData['nomor'] ?? null,
                            'uraian' => $item['uraian'],
                            'urutan' => $iIndex
                        ]);

                        // DETAILS
                        if (!empty($item['details'])) {
                            foreach ($item['details'] as $dIndex => $detail) {
                                if (
                                    empty($detail['aktivitas']) &&
                                    empty($detail['standar'])
                                ) {
                                    continue;
                                }

                                ChecksheetItemDetail::create([
                                    'item_id' => $newItem->id,
                                    'aktivitas' => $detail['aktivitas'] ?? null,
                                    'standar' => $detail['standar'] ?? null,
                                    'urutan' => $dIndex
                                ]);
                            }
                        }
                    }
                }
            }
        }

        return redirect()
            ->route('checksheet.index')
            ->with('success', 'Checksheet berhasil dibuat');
    }

    // =========================
    // SHOW DESKTOP
    // =========================
    public function show($id)
    {
        $checksheet = Checksheet::with([
            'sections.items.details',
            'sections.items.result'
        ])->findOrFail($id);

        return view('checksheet.show', compact('checksheet'));
    }

    // =========================
    // MOBILE
    // =========================
    public function mobile($id)
    {
        $checksheet = Checksheet::with([
            'sections.items.details.result'
        ])->findOrFail($id);

        return view('checksheet.mobile', compact('checksheet'));
    }

    // =========================
    // SAVE MOBILE
    // =========================
    // public function saveMobile(Request $request)
    // {
    //     if (empty($request->details)) {
    //         return back()->with('error', 'Tidak ada data');
    //     }

    //     foreach ($request->details as $detailId => $data) {
    //         $detail = \App\Models\ChecksheetItemDetail::find($detailId);

    //         if (!$detail) {
    //             continue;
    //         }

    //         ChecksheetResult::updateOrCreate(
    //             [
    //                 'detail_id' => $detailId
    //             ],
    //             [
    //                 'item_id' => $detail->item_id,
    //                 'status' => $data['status'] ?? null,
    //                 'keterangan' => $data['keterangan'] ?? null,
    //             ]
    //         );
    //     }

    //     return back()->with(
    //         'success',
    //         'Checksheet berhasil disimpan'
    //     );
    // }

    public function saveMobile(Request $request)
    {
        if (empty($request->details)) {
            return back()
                ->with('error', 'Tidak ada data');
        }

        foreach ($request->details as $detailId => $data) {
            $detail =
                ChecksheetItemDetail::find($detailId);

            if (!$detail) {
                continue;
            }

            $result =
                ChecksheetResult::updateOrCreate(
                    [
                        'detail_id' => $detailId
                    ],
                    [
                        'item_id' => $detail->item_id,
                        'status' => $data['status'] ?? null,
                        'keterangan' => $data['keterangan'] ?? null,
                    ]
                );

            /*
             * ==========================
             * SIMPAN FOTO
             * ==========================
             */

            // if (
            //     isset($data['photos'])
            // ) {
            //     foreach (
            //         $data['photos'] as $photo
            //     ) {
            //         $filename =
            //             time() . '_'
            //             . uniqid()
            //             . '.' . $photo
            //                 ->getClientOriginalExtension();

            //         $photo->move(
            //             public_path(
            //                 'uploads/checksheet'
            //             ),
            //             $filename
            //         );

            //         ChecksheetResultPhoto::create([
            //             'result_id' => $result->id,
            //             'foto' => $filename
            //         ]);
            //     }
            // }

            if (isset($data['photos'])) {
                foreach ($data['photos'] as $photo) {
                    $filename =
                        time() . '_'
                        . uniqid() . '.'
                        . $photo->getClientOriginalExtension();

                    // ==========================
                    // SIMPAN FOTO
                    // ==========================

                    $photo->move(
                        public_path('uploads/checksheet'),
                        $filename
                    );

                    $filePath = public_path(
                        'uploads/checksheet/' . $filename
                    );

                    // ==========================
                    // AUTO ROTATE FOTO HP
                    // ==========================

                    try {
                        if (function_exists('exif_read_data')) {
                            $exif = @exif_read_data($filePath);

                            if (
                                isset($exif['Orientation'])
                            ) {
                                $orientation =
                                    $exif['Orientation'];

                                $image =
                                    imagecreatefromstring(
                                        file_get_contents(
                                            $filePath
                                        )
                                    );

                                switch ($orientation) {
                                    case 3:
                                        $image =
                                            imagerotate(
                                                $image,
                                                180,
                                                0
                                            );
                                        break;

                                    case 6:
                                        $image =
                                            imagerotate(
                                                $image,
                                                -90,
                                                0
                                            );
                                        break;

                                    case 8:
                                        $image =
                                            imagerotate(
                                                $image,
                                                90,
                                                0
                                            );
                                        break;
                                }

                                imagejpeg(
                                    $image,
                                    $filePath,
                                    85
                                );

                                imagedestroy($image);
                            }
                        }
                    } catch (\Exception $e) {
                        // abaikan jika exif gagal
                    }

                    // ==========================
                    // SIMPAN DATABASE
                    // ==========================

                    ChecksheetResultPhoto::create([
                        'result_id' => $result->id,
                        'foto' => $filename
                    ]);
                }
            }
        }

        return back()->with(
            'success',
            'Checksheet berhasil disimpan'
        );
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        Checksheet::findOrFail($id)->delete();

        return back()->with(
            'success',
            'Checksheet dihapus'
        );
    }

    public function duplicate($id)
    {
        // =========================
        // AMBIL DATA LENGKAP
        // =========================
        $old = Checksheet::with(
            'sections.items.details'
        )->findOrFail($id);

        // =========================
        // DUPLICATE HEADER
        // =========================
        $newChecksheet = Checksheet::create([
            'judul' => $old->judul,
            'unit' => $old->unit,
            'no_lambung' => $old->no_lambung,
            'tanggal' => now()->format('Y-m-d')
        ]);

        // =========================
        // DUPLICATE SECTION
        // =========================
        foreach ($old->sections as $section) {
            $newSection = ChecksheetSection::create([
                'checksheet_id' => $newChecksheet->id,
                'kode' => $section->kode,
                'nama_section' => $section->nama_section,
                'urutan' => $section->urutan
            ]);

            // =========================
            // DUPLICATE ITEM
            // =========================
            foreach ($section->items as $item) {
                $newItem = ChecksheetItem::create([
                    'section_id' => $newSection->id,
                    'nomor' => $item->nomor,
                    'uraian' => $item->uraian,
                    'urutan' => $item->urutan
                ]);

                // =========================
                // DUPLICATE DETAIL
                // =========================
                foreach ($item->details as $detail) {
                    ChecksheetItemDetail::create([
                        'item_id' => $newItem->id,
                        'aktivitas' => $detail->aktivitas,
                        'standar' => $detail->standar,
                        'urutan' => $detail->urutan
                    ]);
                }
            }
        }

        return redirect()
            ->route('checksheet.index', $newChecksheet->id)
            ->with(
                'success',
                'Checksheet berhasil digunakan kembali'
            );
    }

    public function edit($id)
    {
        $checksheet = Checksheet::with(
            'sections.items.details'
        )->findOrFail($id);

        return view(
            'checksheet.edit',
            compact('checksheet')
        );
    }

    // public function update(Request $request, $id)
    // {
    //     $checksheet = Checksheet::findOrFail($id);

    //     // =========================
    //     // UPDATE HEADER
    //     // =========================
    //     $checksheet->update([
    //         'judul' => $request->judul,
    //         'unit' => $request->unit,
    //         'no_lambung' => $request->no_lambung,
    //         'tanggal' => $request->tanggal,
    //         'jenis_perawatan' => $request->jenis_perawatan,
    //     ]);

    //     // =========================
    //     // HAPUS DATA LAMA
    //     // =========================
    //     foreach ($checksheet->sections as $section) {
    //         foreach ($section->items as $item) {
    //             // hapus detail
    //             $item->details()->delete();
    //         }

    //         // hapus item
    //         $section->items()->delete();
    //     }

    //     // hapus section
    //     $checksheet->sections()->delete();

    //     // =========================
    //     // SIMPAN ULANG
    //     // =========================
    //     if (!empty($request->sections)) {
    //         foreach ($request->sections as $sIndex => $section) {
    //             $newSection = ChecksheetSection::create([
    //                 'checksheet_id' => $checksheet->id,
    //                 'kode' => $section['kode'] ?? null,
    //                 'nama_section' => $section['nama'],
    //                 'urutan' => $sIndex
    //             ]);

    //             if (!empty($section['items'])) {
    //                 foreach ($section['items'] as $iIndex => $item) {
    //                     $newItem = ChecksheetItem::create([
    //                         'section_id' => $newSection->id,
    //                         'nomor' => $item['nomor'] ?? null,
    //                         'uraian' => $item['uraian'],
    //                         'urutan' => $iIndex
    //                     ]);

    //                     if (!empty($item['details'])) {
    //                         foreach ($item['details'] as $dIndex => $detail) {
    //                             ChecksheetItemDetail::create([
    //                                 'item_id' => $newItem->id,
    //                                 'aktivitas' => $detail['aktivitas'] ?? null,
    //                                 'standar' => $detail['standar'] ?? null,
    //                                 'urutan' => $dIndex
    //                             ]);
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     return redirect()
    //         ->route('checksheet.index')
    //         ->with(
    //             'success',
    //             'Checksheet berhasil diupdate'
    //         );
    // }

    public function update(Request $request, $id)
    {
        $checksheet = Checksheet::with([
            'sections.items.details.result'
        ])->findOrFail($id);

        // =========================
        // SIMPAN RESULT LAMA BERDASARKAN DETAIL ID
        // =========================
        $oldResults = [];

        foreach ($checksheet->sections as $section) {
            foreach ($section->items as $item) {
                foreach ($item->details as $detail) {
                    if ($detail->result) {
                        $oldResults[$detail->id] = [
                            'status' => $detail->result->status,
                            'keterangan' => $detail->result->keterangan,
                        ];
                    }
                }
            }
        }

        // =========================
        // UPDATE HEADER
        // =========================
        $checksheet->update([
            'judul' => $request->judul,
            'unit' => $request->unit,
            'no_lambung' => $request->no_lambung,
            'tanggal' => $request->tanggal,
            'jenis_perawatan' => $request->jenis_perawatan,
        ]);

        // =========================
        // HAPUS DATA LAMA
        // =========================
        foreach ($checksheet->sections as $section) {
            foreach ($section->items as $item) {
                foreach ($item->details as $detail) {
                    ChecksheetResult::where(
                        'detail_id',
                        $detail->id
                    )->delete();
                }

                $item->details()->delete();
            }

            $section->items()->delete();
        }

        $checksheet->sections()->delete();

        // =========================
        // SIMPAN ULANG
        // =========================
        if (!empty($request->sections)) {
            foreach ($request->sections as $sIndex => $section) {
                $newSection = ChecksheetSection::create([
                    'checksheet_id' => $checksheet->id,
                    'kode' => $section['kode'] ?? null,
                    'nama_section' => $section['nama'],
                    'urutan' => $sIndex
                ]);

                if (!empty($section['items'])) {
                    foreach ($section['items'] as $iIndex => $item) {
                        $newItem = ChecksheetItem::create([
                            'section_id' => $newSection->id,
                            'nomor' => $item['nomor'] ?? null,
                            'uraian' => $item['uraian'],
                            'urutan' => $iIndex
                        ]);

                        if (!empty($item['details'])) {
                            foreach ($item['details'] as $dIndex => $detail) {
                                $newDetail = ChecksheetItemDetail::create([
                                    'item_id' => $newItem->id,
                                    'aktivitas' => $detail['aktivitas'] ?? null,
                                    'standar' => $detail['standar'] ?? null,
                                    'urutan' => $dIndex
                                ]);

                                // =========================
                                // RESTORE STATUS HANYA
                                // JIKA DETAIL LAMA
                                // =========================
                                $oldDetailId = $detail['id'] ?? null;

                                if (
                                    $oldDetailId &&
                                    isset($oldResults[$oldDetailId])
                                ) {
                                    ChecksheetResult::create([
                                        'detail_id' => $newDetail->id,
                                        'item_id' => $newItem->id,
                                        'status' => $oldResults[$oldDetailId]['status'],
                                        'keterangan' => $oldResults[$oldDetailId]['keterangan'],
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }

        return redirect()
            ->route('checksheet.index')
            ->with(
                'success',
                'Checksheet berhasil diupdate'
            );
    }

    public function print($id)
    {
        // $checksheet = Checksheet::with([
        //     'sections.items.details.result'
        // ])->findOrFail($id);

        $checksheet = Checksheet::with([
            'sections.items.details.result.photos'
        ])->findOrFail($id);

        return view(
            'checksheet.print',
            compact('checksheet')
        );
    }

    public function pdf($id)
    {
        // $checksheet = Checksheet::with([
        //     'sections.items.details.result'
        // ])->findOrFail($id);

        $checksheet = Checksheet::with([
            'sections.items.details.result.photos'
        ])->findOrFail($id);

        $pdf = Pdf::loadView(
            'checksheet.print',
            compact('checksheet')
        );

        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream(
            'checksheet.pdf'
        );
    }

    // delete photo
    public function deletePhoto($id)
    {
        $photo =
            ChecksheetResultPhoto::find($id);

        if (!$photo) {
            return back()->with(
                'error',
                'Foto tidak ditemukan'
            );
        }

        $filePath =
            public_path(
                'uploads/checksheet/'
                . $photo->foto
            );

        // hapus file fisik
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // hapus database
        $photo->delete();

        return back()->with(
            'success',
            'Foto berhasil dihapus'
        );
    }
}
