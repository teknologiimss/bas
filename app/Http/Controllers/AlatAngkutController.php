<?php

namespace App\Http\Controllers;

use App\Models\AlatAngkut;
use App\Models\AlatAngkutDetail;
use Illuminate\Http\Request;

class AlatAngkutController extends Controller
{
    public function index(Request $request)
    {
        $data = AlatAngkut::when($request->search, function ($q) use ($request) {
            $q->where('nama_proyek', 'like', '%' . $request->search . '%');
        })->latest()->paginate(10);

        return view('alat.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_proyek' => 'required'
        ]);

        AlatAngkut::create($request->all());

        return back()->with('success', 'Proyek berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_proyek' => 'required'
        ]);

        AlatAngkut::findOrFail($id)->update($request->all());

        return back()->with('success', 'Berhasil update');
    }

    public function delete($id)
    {
        AlatAngkut::findOrFail($id)->delete();
        return back()->with('success', 'Berhasil hapus');
    }

    public function monitor(Request $request, $id)
    {
        $proyek = AlatAngkut::findOrFail($id);

        $detail = $proyek
            ->details()
            ->when($request->unit, function ($q) use ($request) {
                $q->where('unit', 'like', '%' . $request->unit . '%');
            })
            ->when($request->no_lambung, function ($q) use ($request) {
                $q->where('no_lambung', 'like', '%' . $request->no_lambung . '%');
            })
            ->when($request->no_kontrak, function ($q) use ($request) {
                $q->where('no_kontrak', 'like', '%' . $request->no_kontrak . '%');
            })
            ->when($request->aset, function ($q) use ($request) {
                $q->where('aset', 'like', '%' . $request->aset . '%');
            })
            ->oldest()
            ->get();

        // =========================
        // 🔥 SUMMARY FINAL
        // =========================
        $summary = $detail->groupBy('unit')->map(function ($items) {
            // helper biar rapi
            $buildGroup = function ($collection) {
                $lokasi = $collection->pluck('lokasi')->filter()->unique()->values();
                $lambung = $collection->pluck('no_lambung')->filter()->unique()->values();

                return [
                    'total' => $collection->count(),
                    'lokasi' => $lokasi,
                    'no_lambung' => $lambung,
                ];
            };

            // 🔴 IMSS
            $imss = $items->filter(function ($item) {
                return str_contains(strtoupper($item->aset), 'IMSS');
            });

            // 🟢 NON IMSS
            $non = $items->reject(function ($item) {
                return str_contains(strtoupper($item->aset), 'IMSS');
            });

            // 📍 lokasi → semua lambung
            $lokasiMap = $items->groupBy('lokasi')->map(function ($group) {
                return $group
                    ->pluck('no_lambung')
                    ->filter()
                    ->unique()
                    ->values();
            });

            return [
                'total' => $items->count(),
                'lokasi_map' => $lokasiMap,
                'imss' => $buildGroup($imss),
                'non' => $buildGroup($non),
            ];
        });

        return view('alat.monitor', compact('proyek', 'detail', 'summary'));
    }

    public function dashboard()
    {
        $detail = AlatAngkutDetail::all();

        $totalUnit = $detail->count();

        $imss = $detail->filter(function ($item) {
            return str_contains(
                strtoupper($item->aset ?? ''),
                'IMSS'
            );
        })->count();

        $nonImss = $totalUnit - $imss;

        $totalLokasi = $detail
            ->pluck('lokasi')
            ->filter()
            ->unique()
            ->count();

        $statusChart = [
            'imss' => $imss,
            'non' => $nonImss
        ];

        $unitSummary = AlatAngkutDetail::get()
            ->groupBy('unit')
            ->map(function ($items) {
                $imss = $items->filter(function ($item) {
                    return str_contains(
                        strtoupper($item->aset),
                        'IMSS'
                    );
                })->count();

                $nonImss = $items->count() - $imss;

                return [
                    'total' => $items->count(),
                    'imss' => $imss,
                    'non_imss' => $nonImss
                ];
            });

        return view(
            'alat.dashboard',
            compact(
                'totalUnit',
                'imss',
                'nonImss',
                'totalLokasi',
                'statusChart',
                'unitSummary',
            )
        );
    }

    public function listData(Request $request)
    {
        $query = AlatAngkutDetail::query();

        $filter = null;

        if ($request->aset == 'IMSS') {
            $query->where('aset', 'LIKE', '%IMSS%');

            $filter = 'IMSS';
        } elseif ($request->aset == 'NON') {
            $query->where(function ($q) {
                $q
                    ->whereNull('aset')
                    ->orWhere('aset', 'NOT LIKE', '%IMSS%');
            });

            $filter = 'NON IMSS';
        }

        $data = $query
            ->oldest()
            ->paginate(20);

        return view(
            'alat.list',
            compact(
                'data',
                'filter'
            )
        );
    }

    public function lokasiList()
    {
        $data = AlatAngkutDetail::select(
            'lokasi',
            'unit',
            'no_lambung',
            'aset'
        )
            ->orderBy('lokasi')
            ->paginate(20);

        return view(
            'alat.lokasi-list',
            compact('data')
        );
    }
}
