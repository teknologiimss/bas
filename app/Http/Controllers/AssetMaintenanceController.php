<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetMaintenance;
use Illuminate\Http\Request;

class AssetMaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $tahun =
            $request->tahun
                ?? date('Y');

        $assets =
            Asset::with([
                'maintenances' => function ($q) use ($tahun) {
                    $q->where(
                        'tahun',
                        $tahun
                    );
                }
            ])
                ->orderBy('unit')
                ->get();

        $totalAsset =
            Asset::count();

        $monthlyProgress = [];

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $realisasiUnit =
                AssetMaintenance::where(
                    'tahun',
                    $tahun
                )
                    ->where(
                        'bulan',
                        $bulan
                    )
                    ->where(
                        'realisasi',
                        true
                    )
                    ->distinct()
                    ->count('asset_id');

            $monthlyProgress[$bulan] =
                $totalAsset > 0
                    ? round(
                        (
                            $realisasiUnit
                            / $totalAsset
                        ) * 100,
                        2
                    )
                    : 0;
        }

        return view(
            'asset-maintenance.index',
            compact(
                'assets',
                'tahun',
                'monthlyProgress',
                'totalAsset'
            )
        );
    }

    
    public function mark(Request $request)
    {
        $data = AssetMaintenance::firstOrCreate([
            'asset_id' => $request->asset_id,
            'tahun' => $request->tahun,
            'bulan' => $request->bulan,
            'minggu' => $request->minggu,
        ]);

        if ($request->type == 'planning') {
            $data->planning = !$data->planning;
        }

        if ($request->type == 'realisasi') {
            $data->realisasi = !$data->realisasi;

            if ($data->realisasi) {
                $data->tanggal_realisasi = now();
            }
        }

        $data->save();

        return response()->json([
            'success' => true
        ]);
    }
}
