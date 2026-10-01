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
        // 1. Fetch Data Monitoring Progres MRO (Semua Tahun / All Time)
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

        // 3. METRIK CARD SUMMARY KPI (Akumulasi Semua Tahun)
        $totalKontrak = $allMonitorings->count();

        // Memastikan Pekerjaan Selesai secara eksplisit menghitung seluruh status 'Closed' akumulasi semua tahun
        $totalSelesai = $allMonitorings->where('status', 'Closed')->count();

        $kontrakKritis = $notifCounts['h7'] + $notifCounts['berakhir'];

        // Kalkulasi Rata-rata Progress Pekerjaan MRO
        $totalProgressSum = 0;
        foreach ($allMonitorings as $m) {
            $totalProgressSum += $m->progress_percentage ?? ($m->status === 'Closed' ? 100 : 0);
        }
        $avgProgressPekerjaan = $totalKontrak > 0
            ? round($totalProgressSum / $totalKontrak, 1)
            : 0;

        // 4. Kalkulasi Data Jatuh Tempo Kontrak per Bulan (Khusus Grafik - Berdasarkan Filter Tahun)
        $tahun = $request->get('tahun', date('Y'));

        $dueDateSelesai = array_fill(1, 12, 0);  // Selesai / Closed
        $dueDateBelumSelesai = array_fill(1, 12, 0);  // Belum Selesai (Open/On Hold/Lainnya)

        foreach ($allMonitorings as $m) {
            if (!empty($m->tanggal_selesai_kontrak)) {
                $date = Carbon::parse($m->tanggal_selesai_kontrak);
                if ($date->year == $tahun) {
                    $month = $date->month;
                    if ($m->status === 'Closed') {
                        $dueDateSelesai[$month]++;
                    } else {
                        $dueDateBelumSelesai[$month]++;
                    }
                }
            }
        }

        // 5. Tabel Ringkasan Progres MRO
        $monitorings = Monitoring::with('documents')
            ->latest()
            ->get();

        // 6. KALKULASI PM 1 TAHUN (Khusus Grafik Gauge - Berdasarkan Filter Tahun)
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
            'totalKontrak',
            'totalSelesai',
            'kontrakKritis',
            'avgProgressPekerjaan',
            'dueDateSelesai',
            'dueDateBelumSelesai',
            'monitorings',
            'pmYearlyPercentage',
            'tahun'
        ));
    }
}
