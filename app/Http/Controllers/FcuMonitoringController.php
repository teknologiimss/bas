<?php

// app/Http/Controllers/FcuMonitoringController.php
namespace App\Http\Controllers;

use App\Models\FcuDetail;
use App\Models\FcuItem;
use App\Models\FcuMonitoring;
use App\Models\FcuNote;
use App\Models\FcuResult;
use App\Models\FcuResultPhoto;
use App\Models\FcuSection;
use App\Models\FcuUnscheduledForm;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FcuMonitoringController extends Controller
{
    public function index(Request $request)
    {
        $query = FcuMonitoring::query();

        if ($request->filled('no_fcu')) {
            $query->where('no_fcu', 'like', '%' . $request->no_fcu . '%');
        }

        if ($request->filled('jenis_perawatan')) {
            $query->where('jenis_perawatan', $request->jenis_perawatan);
        }

        $data = $query->latest()->get();
        return view('fcu.index', compact('data'));
    }

    public function create()
    {
        return view('fcu.create');
    }

    // public function store(Request $request)
    // {
    //     DB::transaction(function () use ($request) {
    //         $fcu = FcuMonitoring::create([
    //             'judul' => $request->judul,
    //             'jenis_perawatan' => $request->jenis_perawatan,
    //             'tanggal' => $request->tanggal,
    //             'no_fcu' => $request->no_fcu,
    //         ]);

    //         if ($request->jenis_perawatan === 'Unscheduled') {
    //             FcuUnscheduledForm::create([
    //                 'fcu_monitoring_id' => $fcu->id,
    //                 'tanggal' => $request->unscheduled_tanggal,
    //                 'jenis_kerusakan' => $request->unscheduled_jenis_kerusakan,
    //                 'tindak_lanjut' => $request->unscheduled_tindak_lanjut,
    //                 'status' => $request->unscheduled_status,
    //                 'personil' => $request->unscheduled_personil,
    //             ]);
    //         }

    //         if ($request->has('sections')) {
    //             foreach ($request->sections as $secData) {
    //                 $section = FcuSection::create([
    //                     'fcu_monitoring_id' => $fcu->id,
    //                     'kode' => $secData['kode'] ?? null,
    //                     'nama_section' => $secData['nama'],
    //                 ]);

    //                 if (isset($secData['items'])) {
    //                     foreach ($secData['items'] as $itemData) {
    //                         $item = FcuItem::create([
    //                             'fcu_section_id' => $section->id,
    //                             'nomor' => $itemData['nomor'] ?? null,
    //                             'uraian' => $itemData['uraian'],
    //                         ]);

    //                         if (isset($itemData['details'])) {
    //                             foreach ($itemData['details'] as $detData) {
    //                                 FcuDetail::create([
    //                                     'fcu_item_id' => $item->id,
    //                                     'aktivitas' => $detData['aktivitas'] ?? null,
    //                                     'standar' => $detData['standar'] ?? null,
    //                                 ]);
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     });

    //     return redirect()->route('fcu.index')->with('success', 'Monitoring FCU berhasil dibuat!');
    // }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $fcu = FcuMonitoring::create([
                'judul' => $request->judul,
                'jenis_perawatan' => $request->jenis_perawatan,
                'tanggal' => $request->tanggal,
                'no_fcu' => $request->no_fcu,
                'tanggal_2' => $request->tanggal_2 ?? $request->tanggal,  // Default samakan jika tidak diisi
                'no_fcu_2' => $request->no_fcu_2,
            ]);

            if ($request->jenis_perawatan === 'Unscheduled') {
                FcuUnscheduledForm::create([
                    'fcu_monitoring_id' => $fcu->id,
                    'tanggal' => $request->unscheduled_tanggal,
                    'jenis_kerusakan' => $request->unscheduled_jenis_kerusakan,
                    'tindak_lanjut' => $request->unscheduled_tindak_lanjut,
                    'status' => $request->unscheduled_status,
                    'personil' => $request->unscheduled_personil,
                ]);
            }

            if ($request->has('sections')) {
                foreach ($request->sections as $secData) {
                    $section = FcuSection::create([
                        'fcu_monitoring_id' => $fcu->id,
                        'kode' => $secData['kode'] ?? null,
                        'nama_section' => $secData['nama'],
                    ]);

                    if (isset($secData['items'])) {
                        foreach ($secData['items'] as $itemData) {
                            $item = FcuItem::create([
                                'fcu_section_id' => $section->id,
                                'nomor' => $itemData['nomor'] ?? null,
                                'uraian' => $itemData['uraian'],
                            ]);

                            if (isset($itemData['details'])) {
                                foreach ($itemData['details'] as $detData) {
                                    FcuDetail::create([
                                        'fcu_item_id' => $item->id,
                                        'aktivitas' => $detData['aktivitas'] ?? null,
                                        'standar' => $detData['standar'] ?? null,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        });

        return redirect()->route('fcu.index')->with('success', 'Monitoring FCU berhasil dibuat!');
    }

    public function edit($id)
    {
        $fcu = FcuMonitoring::with(['sections.items.details', 'unscheduledForm'])->findOrFail($id);
        return view('fcu.edit', compact('fcu'));
    }

    // public function update(Request $request, $id)
    // {
    //     DB::transaction(function () use ($request, $id) {
    //         $fcu = FcuMonitoring::findOrFail($id);
    //         $fcu->update([
    //             'judul' => $request->judul,
    //             'jenis_perawatan' => $request->jenis_perawatan,
    //             'tanggal' => $request->tanggal,
    //             'no_fcu' => $request->no_fcu,
    //         ]);

    //         if ($request->jenis_perawatan === 'Unscheduled') {
    //             FcuUnscheduledForm::updateOrCreate(
    //                 ['fcu_monitoring_id' => $fcu->id],
    //                 [
    //                     'tanggal' => $request->unscheduled_tanggal,
    //                     'jenis_kerusakan' => $request->unscheduled_jenis_kerusakan,
    //                     'tindak_lanjut' => $request->unscheduled_tindak_lanjut,
    //                     'status' => $request->unscheduled_status,
    //                     'personil' => $request->unscheduled_personil,
    //                 ]
    //             );
    //         } else {
    //             FcuUnscheduledForm::where('fcu_monitoring_id', $fcu->id)->delete();
    //         }

    //         // Hapus struktur lama dan re-insert
    //         FcuSection::where('fcu_monitoring_id', $fcu->id)->delete();

    //         if ($request->has('sections')) {
    //             foreach ($request->sections as $secData) {
    //                 $section = FcuSection::create([
    //                     'fcu_monitoring_id' => $fcu->id,
    //                     'kode' => $secData['kode'] ?? null,
    //                     'nama_section' => $secData['nama'],
    //                 ]);

    //                 if (isset($secData['items'])) {
    //                     foreach ($secData['items'] as $itemData) {
    //                         $item = FcuItem::create([
    //                             'fcu_section_id' => $section->id,
    //                             'nomor' => $itemData['nomor'] ?? null,
    //                             'uraian' => $itemData['uraian'],
    //                         ]);

    //                         if (isset($itemData['details'])) {
    //                             foreach ($itemData['details'] as $detData) {
    //                                 FcuDetail::create([
    //                                     'fcu_item_id' => $item->id,
    //                                     'aktivitas' => $detData['aktivitas'] ?? null,
    //                                     'standar' => $detData['standar'] ?? null,
    //                                 ]);
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     });

    //     return redirect()->route('fcu.index')->with('success', 'Monitoring FCU berhasil diupdate!');
    // }

    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $fcu = FcuMonitoring::findOrFail($id);
            $fcu->update([
                'judul' => $request->judul,
                'jenis_perawatan' => $request->jenis_perawatan,
                'tanggal' => $request->tanggal,
                'no_fcu' => $request->no_fcu,
                'tanggal_2' => $request->tanggal_2 ?? $request->tanggal,
                'no_fcu_2' => $request->no_fcu_2,
            ]);

            if ($request->jenis_perawatan === 'Unscheduled') {
                FcuUnscheduledForm::updateOrCreate(
                    ['fcu_monitoring_id' => $fcu->id],
                    [
                        'tanggal' => $request->unscheduled_tanggal,
                        'jenis_kerusakan' => $request->unscheduled_jenis_kerusakan,
                        'tindak_lanjut' => $request->unscheduled_tindak_lanjut,
                        'status' => $request->unscheduled_status,
                        'personil' => $request->unscheduled_personil,
                    ]
                );
            } else {
                FcuUnscheduledForm::where('fcu_monitoring_id', $fcu->id)->delete();
            }

            // Re-insert Struktur Items/Details
            FcuSection::where('fcu_monitoring_id', $fcu->id)->delete();

            if ($request->has('sections')) {
                foreach ($request->sections as $secData) {
                    $section = FcuSection::create([
                        'fcu_monitoring_id' => $fcu->id,
                        'kode' => $secData['kode'] ?? null,
                        'nama_section' => $secData['nama'],
                    ]);

                    if (isset($secData['items'])) {
                        foreach ($secData['items'] as $itemData) {
                            $item = FcuItem::create([
                                'fcu_section_id' => $section->id,
                                'nomor' => $itemData['nomor'] ?? null,
                                'uraian' => $itemData['uraian'],
                            ]);

                            if (isset($itemData['details'])) {
                                foreach ($itemData['details'] as $detData) {
                                    FcuDetail::create([
                                        'fcu_item_id' => $item->id,
                                        'aktivitas' => $detData['aktivitas'] ?? null,
                                        'standar' => $detData['standar'] ?? null,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        });

        return redirect()->route('fcu.index')->with('success', 'Monitoring FCU berhasil diupdate!');
    }

    public function destroy($id)
    {
        FcuMonitoring::findOrFail($id)->delete();
        return redirect()->route('fcu.index')->with('success', 'Monitoring FCU berhasil dihapus!');
    }

    public function mobile($id)
    {
        $fcu = FcuMonitoring::with(['sections.items.details.result.photos', 'unscheduledForm', 'notes'])->findOrFail($id);
        return view('fcu.mobile', compact('fcu'));
    }

    // public function saveMobile(Request $request)
    // {
    //     DB::transaction(function () use ($request) {
    //         if ($request->has('details')) {
    //             foreach ($request->details as $detailId => $data) {
    //                 $result = FcuResult::updateOrCreate(
    //                     ['fcu_detail_id' => $detailId],
    //                     [
    //                         'status' => $data['status'] ?? null,
    //                         'keterangan' => $data['keterangan'] ?? null,
    //                     ]
    //                 );

    //                 if (isset($data['photos'])) {
    //                     foreach ($data['photos'] as $photoFile) {
    //                         $filename = time() . '_' . uniqid() . '.' . $photoFile->getClientOriginalExtension();
    //                         $photoFile->move(public_path('uploads/fcu'), $filename);

    //                         FcuResultPhoto::create([
    //                             'fcu_result_id' => $result->id,
    //                             'foto' => $filename,
    //                         ]);
    //                     }
    //                 }
    //             }
    //         }
    //     });

    //     return redirect()->back()->with('success', 'Checksheet FCU berhasil disimpan!');
    // }

    public function saveMobile(Request $request)
    {
        $detailsData = $request->input('details', []);

        foreach ($detailsData as $unitKey => $items) {
            foreach ($items as $detailId => $data) {
                if (!isset($data['status'])) {
                    continue;
                }

                // Simpan atau update ke model FcuResult
                $result = FcuResult::updateOrCreate(
                    [
                        'fcu_detail_id' => $detailId,
                        'unit' => $unitKey,  // Mengidentifikasi 'fcu1' atau 'fcu2'
                    ],
                    [
                        'status' => $data['status'],
                        'keterangan' => $data['keterangan'] ?? null,
                    ]
                );

                // Proses upload foto menggunakan model FcuResultPhoto
                if ($request->hasFile("details.{$unitKey}.{$detailId}.photos")) {
                    foreach ($request->file("details.{$unitKey}.{$detailId}.photos") as $file) {
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('uploads/fcu'), $filename);

                        FcuResultPhoto::create([
                            'fcu_result_id' => $result->id,
                            'foto' => $filename,
                        ]);
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Checksheet berhasil disimpan!');
    }

    public function saveHasil(Request $request, $id)
    {
        $fcu = FcuMonitoring::findOrFail($id);
        $fcu->update(['kesimpulan' => $request->hasil]);
        return redirect()->back()->with('success', 'Kesimpulan berhasil diperbarui!');
    }

    public function saveNote(Request $request, $id)
    {
        FcuNote::create([
            'fcu_monitoring_id' => $id,
            'catatan' => $request->catatan,
        ]);
        return redirect()->back()->with('success', 'Catatan ditambahkan!');
    }

    public function deleteNote($id)
    {
        FcuNote::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Catatan dihapus!');
    }

    public function deletePhoto($id)
    {
        $photo = FcuResultPhoto::findOrFail($id);
        @unlink(public_path('uploads/fcu/' . $photo->foto));
        $photo->delete();
        return redirect()->back()->with('success', 'Foto dihapus!');
    }

    // Tambahkan di App/Http/Controllers/FcuMonitoringController.php

    public function show($id)
    {
        $fcu = FcuMonitoring::with(['sections.items.details.result.photos', 'unscheduledForm', 'notes'])->findOrFail($id);
        return view('fcu.show', compact('fcu'));
    }

    public function print($id)
    {
        $fcu = FcuMonitoring::with(['sections.items.details.result.photos', 'unscheduledForm', 'notes'])->findOrFail($id);

        // Menyusun array berisi 2 FCU untuk dipetakan dalam 1 halaman PDF
        $checksheets = [
            [
                'no_fcu' => $fcu->no_fcu,
                'tanggal' => $fcu->tanggal
            ],
            [
                'no_fcu' => $fcu->no_fcu_2 ?? $fcu->no_fcu . ' (2)',
                'tanggal' => $fcu->tanggal_2 ?? $fcu->tanggal
            ]
        ];

        $pdf = Pdf::loadView('fcu.print', compact('fcu', 'checksheets'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Checksheet-FCU-' . $fcu->no_fcu . '.pdf');
    }

    public function copy($id)
    {
        DB::transaction(function () use ($id) {
            // 1. Load data lama beserta relasi strukturnya
            $source = FcuMonitoring::with(['sections.items.details', 'unscheduledForm'])->findOrFail($id);

            // 2. Replikasi data utama FcuMonitoring
            $newFcu = $source->replicate();

            $newFcu->judul = $source->judul;

            // Diisi string kosong agar tidak memicu error NOT NULL
            $newFcu->no_fcu = '';
            $newFcu->no_fcu_2 = '';

            $newFcu->tanggal = now()->format('Y-m-d');
            $newFcu->tanggal_2 = now()->format('Y-m-d');
            $newFcu->kesimpulan = null;
            $newFcu->save();

            // 3. Replikasi Unscheduled Form jika tipe perawatan Unscheduled
            if ($source->jenis_perawatan === 'Unscheduled' && $source->unscheduledForm) {
                $newUnscheduled = $source->unscheduledForm->replicate();
                $newUnscheduled->fcu_monitoring_id = $newFcu->id;
                $newUnscheduled->tanggal = now()->format('Y-m-d');
                $newUnscheduled->save();
            }

            // 4. Replikasi Struktur Section -> Item -> Detail
            foreach ($source->sections as $section) {
                $newSection = $section->replicate();
                $newSection->fcu_monitoring_id = $newFcu->id;
                $newSection->save();

                foreach ($section->items as $item) {
                    $newItem = $item->replicate();
                    $newItem->fcu_section_id = $newSection->id;
                    $newItem->save();

                    foreach ($item->details as $detail) {
                        // Replikasi detail tanpa menyentuh kolom 'hasil' / 'keterangan' / 'foto'
                        $newDetail = $detail->replicate();
                        $newDetail->fcu_item_id = $newItem->id;
                        $newDetail->save();
                    }
                }
            }
        });

        return redirect()->route('fcu.index')->with('success', 'Format Monitoring FCU berhasil diduplikasi!');
    }
}
