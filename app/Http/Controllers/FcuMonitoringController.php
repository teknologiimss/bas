<?php

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
use Illuminate\Support\Facades\Storage;

class FcuMonitoringController extends Controller
{
    public function index(Request $request)
    {
        // Tambahkan with('unscheduledForm')
        $query = FcuMonitoring::with('unscheduledForm');

        if ($request->filled('no_fcu')) {
            $query->where(function ($q) use ($request) {
                $q
                    ->where('no_fcu', 'like', '%' . $request->no_fcu . '%')
                    ->orWhereHas('unscheduledForm', function ($subQuery) use ($request) {
                        $subQuery->where('no_fcu', 'like', '%' . $request->no_fcu . '%');
                    });
            });
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

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $fcu = FcuMonitoring::create([
                'judul' => $request->judul,
                'jenis_perawatan' => $request->jenis_perawatan,
                'tanggal' => $request->tanggal,
                'no_fcu' => $request->no_fcu,
                'tanggal_2' => $request->tanggal_2 ?? $request->tanggal,
                'no_fcu_2' => $request->no_fcu_2,
            ]);

            if ($request->jenis_perawatan === 'Unscheduled') {
                FcuUnscheduledForm::create([
                    'fcu_monitoring_id' => $fcu->id,
                    'no_fcu' => $request->unscheduled_no_fcu ?? $request->no_fcu,  // <--- Ditambahkan
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
    //             'tanggal_2' => $request->tanggal_2 ?? $request->tanggal,
    //             'no_fcu_2' => $request->no_fcu_2,
    //         ]);

    //         if ($request->jenis_perawatan === 'Unscheduled') {
    //             FcuUnscheduledForm::updateOrCreate(
    //                 ['fcu_monitoring_id' => $fcu->id],
    //                 [
    //                     'no_fcu' => $request->unscheduled_no_fcu ?? $request->no_fcu,  // <--- Ditambahkan
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

    //         // Re-insert Struktur Items/Details
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

            // 1. Handle Unscheduled
            if ($request->jenis_perawatan === 'Unscheduled') {
                FcuUnscheduledForm::updateOrCreate(
                    ['fcu_monitoring_id' => $fcu->id],
                    [
                        'no_fcu' => $request->unscheduled_no_fcu ?? $request->no_fcu,
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

            // 2. Sync / Update Struktur Sections, Items, dan Details (Tanpa Hapus Total)
            if ($request->has('sections')) {
                $keepSectionIds = [];
                $keepItemIds = [];
                $keepDetailIds = [];

                foreach ($request->sections as $secData) {
                    // Update atau buat Section baru
                    $section = FcuSection::updateOrCreate(
                        [
                            'id' => $secData['id'] ?? null,
                            'fcu_monitoring_id' => $fcu->id,
                        ],
                        [
                            'kode' => $secData['kode'] ?? null,
                            'nama_section' => $secData['nama'],
                        ]
                    );
                    $keepSectionIds[] = $section->id;

                    if (isset($secData['items'])) {
                        foreach ($secData['items'] as $itemData) {
                            // Update atau buat Item baru
                            $item = FcuItem::updateOrCreate(
                                [
                                    'id' => $itemData['id'] ?? null,
                                    'fcu_section_id' => $section->id,
                                ],
                                [
                                    'nomor' => $itemData['nomor'] ?? null,
                                    'uraian' => $itemData['uraian'],
                                ]
                            );
                            $keepItemIds[] = $item->id;

                            if (isset($itemData['details'])) {
                                foreach ($itemData['details'] as $detData) {
                                    // Update atau buat Detail baru (preservasi ID agar FcuResult aman)
                                    $detail = FcuDetail::updateOrCreate(
                                        [
                                            'id' => $detData['id'] ?? null,
                                            'fcu_item_id' => $item->id,
                                        ],
                                        [
                                            'aktivitas' => $detData['aktivitas'] ?? null,
                                            'standar' => $detData['standar'] ?? null,
                                        ]
                                    );
                                    $keepDetailIds[] = $detail->id;
                                }
                            }
                        }
                    }
                }

                // Hapus hanya elemen yang secara eksplisit dibuang oleh user dari form edit
                FcuDetail::whereIn('fcu_item_id', function ($q) use ($fcu) {
                    $q->select('id')->from('fcu_items')->whereIn('fcu_section_id', function ($q2) use ($fcu) {
                        $q2->select('id')->from('fcu_sections')->where('fcu_monitoring_id', $fcu->id);
                    });
                })->whereNotIn('id', $keepDetailIds)->delete();

                FcuItem::whereIn('fcu_section_id', function ($q) use ($fcu) {
                    $q->select('id')->from('fcu_sections')->where('fcu_monitoring_id', $fcu->id);
                })->whereNotIn('id', $keepItemIds)->delete();

                FcuSection::where('fcu_monitoring_id', $fcu->id)->whereNotIn('id', $keepSectionIds)->delete();
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

    public function saveMobile(Request $request)
    {
        $detailsData = $request->input('details', []);

        foreach ($detailsData as $unitKey => $items) {
            foreach ($items as $detailId => $data) {
                if (!isset($data['status'])) {
                    continue;
                }

                $result = FcuResult::updateOrCreate(
                    [
                        'fcu_detail_id' => $detailId,
                        'unit' => $unitKey,
                    ],
                    [
                        'status' => $data['status'],
                        'keterangan' => $data['keterangan'] ?? null,
                    ]
                );

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

    public function show($id)
    {
        $fcu = FcuMonitoring::with(['sections.items.details.result.photos', 'unscheduledForm', 'notes'])->findOrFail($id);
        return view('fcu.show', compact('fcu'));
    }

    public function print($id)
    {
        // Tambahkan 'sections.items.details.results.photos' untuk memuat relasi results
        $fcu = FcuMonitoring::with([
            'sections.items.details.results.photos',
            'unscheduledForm',
            'notes'
        ])->findOrFail($id);

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
            $source = FcuMonitoring::with(['sections.items.details', 'unscheduledForm'])->findOrFail($id);

            $newFcu = $source->replicate();
            $newFcu->judul = $source->judul;
            $newFcu->no_fcu = '';
            $newFcu->no_fcu_2 = '';
            $newFcu->tanggal = now()->format('Y-m-d');
            $newFcu->tanggal_2 = now()->format('Y-m-d');
            $newFcu->kesimpulan = null;
            $newFcu->save();

            if ($source->jenis_perawatan === 'Unscheduled' && $source->unscheduledForm) {
                $newUnscheduled = $source->unscheduledForm->replicate();
                $newUnscheduled->fcu_monitoring_id = $newFcu->id;
                $newUnscheduled->no_fcu = '';  // Reset nilai no_fcu pada bentuk yang diduplikasi
                $newUnscheduled->tanggal = now()->format('Y-m-d');
                $newUnscheduled->save();
            }

            foreach ($source->sections as $section) {
                $newSection = $section->replicate();
                $newSection->fcu_monitoring_id = $newFcu->id;
                $newSection->save();

                foreach ($section->items as $item) {
                    $newItem = $item->replicate();
                    $newItem->fcu_section_id = $newSection->id;
                    $newItem->save();

                    foreach ($item->details as $detail) {
                        $newDetail = $detail->replicate();
                        $newDetail->fcu_item_id = $newItem->id;
                        $newDetail->save();
                    }
                }
            }
        });

        return redirect()->route('fcu.index')->with('success', 'Format Monitoring FCU berhasil diduplikasi!');
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'file_dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',  // Maks 5MB
        ]);

        $fcu = FcuMonitoring::findOrFail($id);

        if ($request->hasFile('file_dokumen')) {
            // Hapus file lama jika ada di disk 'public'
            if ($fcu->file_dokumen && Storage::disk('public')->exists($fcu->file_dokumen)) {
                Storage::disk('public')->delete($fcu->file_dokumen);
            }

            // Tersimpan di: storage/app/public/dokumen_fcu
            // Terhubung ke: public/storage/dokumen_fcu (setelah artisan storage:link)
            $path = $request->file('file_dokumen')->store('dokumen_fcu', 'public');

            // Menyimpan string path relatif, contoh: "dokumen_fcu/abc12345.pdf"
            $fcu->file_dokumen = $path;
            $fcu->save();
        }

        return redirect()->back()->with('success', 'Dokumen berhasil diunggah!');
    }

    public function deleteDocument($id)
    {
        $fcu = FcuMonitoring::findOrFail($id);

        // Hapus file fisik dari storage jika ada
        if ($fcu->file_dokumen && Storage::disk('public')->exists($fcu->file_dokumen)) {
            Storage::disk('public')->delete($fcu->file_dokumen);
        }

        // Reset kolom file_dokumen pada database
        $fcu->update([
            'file_dokumen' => null
        ]);

        return redirect()->back()->with('success', 'Dokumen lampiran berhasil dihapus.');
    }
}
