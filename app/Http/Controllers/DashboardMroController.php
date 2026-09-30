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
        // 1. Fetch Data Monitoring Progres MRO
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

        // 3. Tabel Ringkasan Progres MRO
        $monitorings = Monitoring::with('documents')
            ->latest()
            ->take(6)
            ->get();

        // 4. KALKULASI PM 1 TAHUN (DENGAN TRUNCATE 1 DESIMAL)
        $tahun = $request->get('tahun', date('Y'));
        $totalAsset = Asset::count();

        $totalPersen12Bulan = 0;

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            // Hitung unit unik yang punya realisasi di bulan ini
            $realisasiUnit = AssetMaintenance::where('tahun', $tahun)
                ->where('bulan', $bulan)
                ->where('realisasi', true)
                ->distinct()
                ->count('asset_id');

            // Potong desimal ke 1 angka di belakang koma (5.263... dipotong jadi 5.2)
            $monthlyProgress = $totalAsset > 0
                ? floor(($realisasiUnit / $totalAsset) * 100 * 10) / 10
                : 0;

            // Akumulasi total persen bulanan (5.2 + 0 + ... + 0 = 5.2)
            $totalPersen12Bulan += $monthlyProgress;
        }

        // BAGI 12 BULAN (5.2 / 12 = 0.4333... -> dibulatkan jadi 0.43%)
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
