<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetMaintenance;
use App\Models\Monitoring;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardMroController extends Controller
{
    public function index(Request $request)
    {
        // 1. Fetch Data Monitoring Progres MRO (Semua data)
        $allMonitorings = Monitoring::with('documents')->get();

        $statusCounts = [
            'Open' => $allMonitorings->where('status', 'Open')->count(),
            'Closed' => $allMonitorings->where('status', 'Closed')->count(),
            'On Hold' => $allMonitorings->where('status', 'On Hold')->count(),
        ];

        // 2. Notifikasi Kontrak
        $notifCounts = [
            'berjalan' => 0,
            'h7' => 0,
            'berakhir' => 0,
            'selesai' => 0,
        ];

        foreach ($allMonitorings as $m) {
            $notif = $m->notifKontrak();
            $text = strtolower($notif['text'] ?? '');

            if (str_contains($text, 'h-7')) {
                $notifCounts['h7']++;
            } elseif (str_contains($text, 'telah berakhir')) {
                $notifCounts['berakhir']++;
            } elseif (str_contains($text, 'selesai')) {
                $notifCounts['selesai']++;
            } else {
                $notifCounts['berjalan']++;
            }
        }

        // 3. Tabel Ringkasan Progres MRO (Tampilkan SEMUA data)
        $monitorings = Monitoring::with('documents')
            ->latest()
            ->get();

        // 4. KALKULASI PM 1 TAHUN
        $tahun = $request->get('tahun', date('Y'));
        $totalAsset = Asset::count();

        $totalPersen12Bulan = 0;

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $realisasiUnit = AssetMaintenance::where('tahun', $tahun)
                ->where('bulan', $bulan)
                ->where('realisasi', true)
                ->distinct()
                ->count('asset_id');

            $monthlyProgress = $totalAsset > 0
                ? floor(($realisasiUnit / $totalAsset) * 100 * 10) / 10
                : 0;

            $totalPersen12Bulan += $monthlyProgress;
        }

        $pmYearlyPercentage = round($totalPersen12Bulan / 12, 2);

        return view('dashboard.mro', compact(
            'statusCounts',
            'notifCounts',
            'monitorings',
            'pmYearlyPercentage',
            'tahun'
        ));
    }
}
