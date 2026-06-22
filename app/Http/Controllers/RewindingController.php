<?php

namespace App\Http\Controllers;

use App\Models\Rewinding;
use App\Models\RewindingDetail;
use App\Models\RewindingDetailLampiran;
use App\Models\RewindingFolder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RewindingController extends Controller
{
    // public function index(Request $request)
    // {
    //     $search = $request->search;

    //     $data = Rewinding::query()
    //         ->when($search, function ($q) use ($search) {
    //             $q
    //                 ->where('no_sjn', 'like', '%' . $search . '%')
    //                 ->orWhere('deskripsi', 'like', '%' . $search . '%')
    //                 ->orWhere('no_sppjp', 'like', '%' . $search . '%');
    //         })
    //         ->latest()
    //         ->paginate(20);

    //     return view('rewinding.index', compact(
    //         'data',
    //         'search'
    //     ));
    // }

    public function monitor(
        Request $request,
        RewindingFolder $folder
    ) {
        $search = $request->search;

        $data = Rewinding::where(
            'rewinding_folder_id',
            $folder->id
        )
            ->when(
                $search,
                function ($q) use ($search) {
                    $q
                        ->where(
                            'no_sjn',
                            'like',
                            "%$search%"
                        )
                        ->orWhere(
                            'deskripsi',
                            'like',
                            "%$search%"
                        )
                        ->orWhere(
                            'no_sppjp',
                            'like',
                            "%$search%"
                        );
                }
            )
            ->latest()
            ->paginate(20);

        return view(
            'rewinding.index',
            compact(
                'data',
                'folder',
                'search'
            )
        );
    }

    public function create(RewindingFolder $folder)
    {
        return view(
            'rewinding.create',
            compact('folder')
        );
    }

    public function store(Request $request)
    {
        $lampiranKeluar = null;
        $namaKeluar = null;

        if ($request->hasFile('lampiran_sjn_keluar')) {
            $file = $request->file('lampiran_sjn_keluar');

            $namaKeluar = $file->getClientOriginalName();

            $namaFile = time() . '_keluar_' . $namaKeluar;

            $file->move(
                public_path('lampiran'),
                $namaFile
            );

            $lampiranKeluar = 'lampiran/' . $namaFile;
        }

        $lampiranMasuk = null;
        $namaMasuk = null;

        if ($request->hasFile('lampiran_sjn_masuk')) {
            $file = $request->file('lampiran_sjn_masuk');

            $namaMasuk = $file->getClientOriginalName();

            $namaFile = time() . '_masuk_' . $namaMasuk;

            $file->move(
                public_path('lampiran'),
                $namaFile
            );

            $lampiranMasuk = 'lampiran/' . $namaFile;
        }

        $rewinding = Rewinding::create([
            'rewinding_folder_id' => $request->rewinding_folder_id,
            'no_sjn' => $request->no_sjn,
            'tanggal_sjn_keluar' =>
                $request->tanggal_sjn_keluar,
            'lampiran_sjn_keluar' =>
                $lampiranKeluar,
            'nama_lampiran_keluar' =>
                $namaKeluar,
            'tanggal_sjn_masuk' =>
                $request->tanggal_sjn_masuk,
            'lampiran_sjn_masuk' =>
                $lampiranMasuk,
            'nama_lampiran_masuk' =>
                $namaMasuk,
            'deskripsi' =>
                $request->deskripsi,
            'status' =>
                $lampiranMasuk ? 'Closed' : 'Open',
            'keterangan' =>
                $request->keterangan,
            'no_sppjp' =>
                $request->no_sppjp
        ]);

        return redirect()
            ->route(
                'rewinding.monitor',
                $rewinding->rewinding_folder_id
            )
            ->with('success', 'Data berhasil disimpan');
    }

    public function edit(Rewinding $rewinding)
    {
        return view(
            'rewinding.edit',
            compact('rewinding')
        );
    }

    public function update(
        Request $request,
        Rewinding $rewinding
    ) {
        $lampiranKeluar =
            $rewinding->lampiran_sjn_keluar;

        $namaKeluar =
            $rewinding->nama_lampiran_keluar;

        $lampiranMasuk =
            $rewinding->lampiran_sjn_masuk;

        $namaMasuk =
            $rewinding->nama_lampiran_masuk;

        if ($request->hasFile('lampiran_sjn_keluar')) {
            if (
                $rewinding->lampiran_sjn_keluar &&
                File::exists(
                    public_path(
                        $rewinding->lampiran_sjn_keluar
                    )
                )
            ) {
                File::delete(
                    public_path(
                        $rewinding->lampiran_sjn_keluar
                    )
                );
            }

            $file =
                $request->file('lampiran_sjn_keluar');

            $namaKeluar =
                $file->getClientOriginalName();

            $namaFile =
                time() . '_keluar_' . $namaKeluar;

            $file->move(
                public_path('lampiran'),
                $namaFile
            );

            $lampiranKeluar =
                'lampiran/' . $namaFile;
        }

        if ($request->hasFile('lampiran_sjn_masuk')) {
            if (
                $rewinding->lampiran_sjn_masuk &&
                File::exists(
                    public_path(
                        $rewinding->lampiran_sjn_masuk
                    )
                )
            ) {
                File::delete(
                    public_path(
                        $rewinding->lampiran_sjn_masuk
                    )
                );
            }

            $file =
                $request->file('lampiran_sjn_masuk');

            $namaMasuk =
                $file->getClientOriginalName();

            $namaFile =
                time() . '_masuk_' . $namaMasuk;

            $file->move(
                public_path('lampiran'),
                $namaFile
            );

            $lampiranMasuk =
                'lampiran/' . $namaFile;
        }

        $rewinding->update([
            'no_sjn' => $request->no_sjn,
            'tanggal_sjn_keluar' =>
                $request->tanggal_sjn_keluar,
            'lampiran_sjn_keluar' =>
                $lampiranKeluar,
            'nama_lampiran_keluar' =>
                $namaKeluar,
            'tanggal_sjn_masuk' =>
                $request->tanggal_sjn_masuk,
            'lampiran_sjn_masuk' =>
                $lampiranMasuk,
            'nama_lampiran_masuk' =>
                $namaMasuk,
            'deskripsi' =>
                $request->deskripsi,
            'status' =>
                $lampiranMasuk
                    ? 'Closed'
                    : 'Open',
            'keterangan' =>
                $request->keterangan,
            'no_sppjp' =>
                $request->no_sppjp
        ]);

        return redirect()
            ->route(
                'rewinding.monitor',
                $rewinding->rewinding_folder_id
            )
            ->with(
                'success',
                'Data berhasil diperbarui'
            );
    }

    public function destroy(Rewinding $rewinding)
    {
        if (
            $rewinding->lampiran_sjn_keluar &&
            File::exists(
                public_path(
                    $rewinding->lampiran_sjn_keluar
                )
            )
        ) {
            File::delete(
                public_path(
                    $rewinding->lampiran_sjn_keluar
                )
            );
        }

        if (
            $rewinding->lampiran_sjn_masuk &&
            File::exists(
                public_path(
                    $rewinding->lampiran_sjn_masuk
                )
            )
        ) {
            File::delete(
                public_path(
                    $rewinding->lampiran_sjn_masuk
                )
            );
        }

        $rewinding->delete();

        return back()->with(
            'success',
            'Data berhasil dihapus'
        );
    }

    public function hapusLampiranKeluar(
        Rewinding $rewinding
    ) {
        if ($rewinding->lampiran_sjn_keluar) {
            $file = public_path(
                $rewinding->lampiran_sjn_keluar
            );

            if (file_exists($file)) {
                unlink($file);
            }
        }

        $rewinding->update([
            'lampiran_sjn_keluar' => null,
            'nama_lampiran_keluar' => null
        ]);

        return back()
            ->with(
                'success',
                'Lampiran keluar berhasil dihapus'
            );
    }

    public function hapusLampiranMasuk(
        Rewinding $rewinding
    ) {
        if ($rewinding->lampiran_sjn_masuk) {
            $file = public_path(
                $rewinding->lampiran_sjn_masuk
            );

            if (file_exists($file)) {
                unlink($file);
            }
        }

        $rewinding->update([
            'lampiran_sjn_masuk' => null,
            'nama_lampiran_masuk' => null,
            'status' => 'Open'
        ]);

        return back()
            ->with(
                'success',
                'Lampiran masuk berhasil dihapus'
            );
    }

    public function detail(
        Rewinding $rewinding
    ) {
        $detail =
            RewindingDetail::firstOrCreate([
                'rewinding_id' =>
                    $rewinding->id
            ]);

        return view(
            'rewinding.detail',
            compact(
                'rewinding',
                'detail'
            )
        );
    }

    public function detailStore(
        Request $request,
        Rewinding $rewinding
    ) {
        $detail =
            RewindingDetail::firstOrCreate([
                'rewinding_id' =>
                    $rewinding->id
            ]);

        $detail->update([
            'tanggal' =>
                $request->tanggal,
            'status' =>
                $request->status,
            'keterangan' =>
                $request->keterangan
        ]);

        if ($request->hasFile('lampiran')) {
            foreach (
                $request->file('lampiran') as $file
            ) {
                $namaFile =
                    time() . '_'
                    . $file->getClientOriginalName();

                $file->move(
                    public_path('rewinding'),
                    $namaFile
                );

                RewindingDetailLampiran::create([
                    'rewinding_detail_id' =>
                        $detail->id,
                    'file' =>
                        'rewinding/' . $namaFile,
                    'nama_file' =>
                        $file->getClientOriginalName()
                ]);
            }
        }

        return back()
            ->with(
                'success',
                'Detail berhasil disimpan'
            );
    }

    public function hapusLampiranDetail(
        RewindingDetailLampiran $lampiran
    ) {
        if (
            file_exists(
                public_path(
                    $lampiran->file
                )
            )
        ) {
            unlink(
                public_path(
                    $lampiran->file
                )
            );
        }

        $lampiran->delete();

        return back()
            ->with(
                'success',
                'Lampiran berhasil dihapus'
            );
    }

    public function folderIndex(Request $request)
    {
        $search = $request->search;

        $data = RewindingFolder::when(
            $search,
            function ($q) use ($search) {
                $q->where(
                    'nama_folder',
                    'like',
                    "%$search%"
                );
            }
        )
            ->latest()
            ->paginate(10);

        return view(
            'rewinding.folder-index',
            compact(
                'data',
                'search'
            )
        );
    }

    public function createFolder()
    {
        return view(
            'rewinding.folder-create'
        );
    }

    public function storeFolder(
        Request $request
    ) {
        RewindingFolder::create([
            'nama_folder' =>
                $request->nama_folder
        ]);

        return redirect()
            ->route('rewinding.index')
            ->with(
                'success',
                'Folder berhasil dibuat'
            );
    }

    public function updateFolder(
        Request $request,
        RewindingFolder $folder
    ) {
        $folder->update([
            'nama_folder' => $request->nama_folder
        ]);

        return back()->with(
            'success',
            'Folder berhasil diperbarui'
        );
    }

    public function deleteFolder(
        RewindingFolder $folder
    ) {
        foreach ($folder->rewindings as $rewinding) {
            if (
                $rewinding->lampiran_sjn_keluar &&
                file_exists(
                    public_path(
                        $rewinding->lampiran_sjn_keluar
                    )
                )
            ) {
                unlink(
                    public_path(
                        $rewinding->lampiran_sjn_keluar
                    )
                );
            }

            if (
                $rewinding->lampiran_sjn_masuk &&
                file_exists(
                    public_path(
                        $rewinding->lampiran_sjn_masuk
                    )
                )
            ) {
                unlink(
                    public_path(
                        $rewinding->lampiran_sjn_masuk
                    )
                );
            }

            $rewinding->delete();
        }

        $folder->delete();

        return back()->with(
            'success',
            'Folder beserta seluruh data dan lampiran berhasil dihapus'
        );
    }

    public function dashboard()
    {
        $total = Rewinding::count();

        $open = Rewinding::where('status', 'Open')->count();

        $closed = Rewinding::where('status', 'Closed')->count();

        $progress = $total > 0
            ? round(($closed / $total) * 100, 2)
            : 0;

        // Chart Open vs Closed
        $statusChart = [
            'open' => $open,
            'closed' => $closed
        ];

        // Grafik per bulan
        $monthlyData = Rewinding::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulan = [];
        $jumlah = [];

        $namaBulan = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agu',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des'
        ];

        foreach ($monthlyData as $item) {
            $bulan[] = $namaBulan[$item->bulan];
            $jumlah[] = $item->total;
        }

        // Semua data Open
        $openData = Rewinding::where('status', 'Open')
            ->orderBy('tanggal_sjn_keluar')
            ->get();

        

        return view('rewinding.dashboard', compact(
            'total',
            'open',
            'closed',
            'progress',
            'statusChart',
            'bulan',
            'jumlah',
            'openData'
        ));
    }

    public function listData(Request $request)
    {
        $status = $request->status;

        $data = Rewinding::with('folder')
            ->when($status, function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->latest()
            ->paginate(20);

        return view(
            'rewinding.list-data',
            compact(
                'data',
                'status'
            )
        );
    }
}
