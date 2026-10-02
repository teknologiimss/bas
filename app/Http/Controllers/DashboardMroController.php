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
        // Filter Tahun (Default tahun berjalan)
        $tahun = $request->get('tahun', date('Y'));

        // 1. Fetch Data Monitoring Progres MRO
        $allMonitorings = Monitoring::with('documents')->get();

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

        // 3. METRIK CARD SUMMARY KPI
        $totalKontrak = $allMonitorings->count();
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

        // 4. Kalkulasi Data Jatuh Tempo Kontrak per Bulan (Inisialisasi Indeks 0 - 11 untuk Jan - Des)
        $dueDateSelesai = array_fill(0, 12, 0);  // Status Closed
        $dueDateBelumSelesai = array_fill(0, 12, 0);  // Status Non-Closed

        foreach ($allMonitorings as $m) {
            if (!empty($m->tanggal_selesai_kontrak)) {
                $date = Carbon::parse($m->tanggal_selesai_kontrak);
                if ($date->year == $tahun) {
                    $monthIndex = $date->month - 1;

                    if ($m->status === 'Closed') {
                        $dueDateSelesai[$monthIndex]++;
                    } else {
                        $dueDateBelumSelesai[$monthIndex]++;
                    }
                }
            }
        }

        // 5. Tabel Ringkasan Progres MRO
        $monitorings = Monitoring::with('documents')
            ->latest()
            ->get();

        // 6. KALKULASI PM 1 TAHUN (Khusus Gauge Chart)
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
