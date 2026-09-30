<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Monitoring;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardMroController extends Controller
{
    public function index()
    {
        // Fetch Data Monitoring Progres MRO
        $allMonitorings = Monitoring::with('documents')->get();

        // 1. Kalkulasi Status Proyek
        $statusCounts = [
            'Open' => $allMonitorings->where('status', 'Open')->count(),
            'Closed' => $allMonitorings->where('status', 'Closed')->count(),
            'On Hold' => $allMonitorings->where('status', 'On Hold')->count(),
        ];

        // 2. Kalkulasi Notifikasi Kontrak
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

        // 4. Kalkulasi Preventive Maintenance (PM) 1 TAHUN
        $tahun = date('Y');

        $assets = Asset::with(['maintenances' => function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        }])->get();

        $monthlyProgress = [];

        // Ambil nilai persen persis seperti footer di view (Bulan 1 s.d 12)
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $totalP = 0;
            $totalR = 0;

            foreach ($assets as $asset) {
                $m = $asset->maintenances->where('bulan', $bulan);
                $totalP += $m->where('planning', true)->count();
                $totalR += $m->where('realisasi', true)->count();
            }

            // Simpan persen bulanan (Bulan tanpa planning bernilai 0)
            $monthlyProgress[$bulan] = ($totalP > 0) ? ($totalR / $totalP) * 100 : 0;
        }

        // JUMLAHKAN NILAI PERSEN 12 BULAN LALU BAGI 12
        $pmYearlyPercentage = round(array_sum($monthlyProgress) / 12, 2);

        return view('dashboard.mro', compact(
            'statusCounts',
            'notifCounts',
            'monitorings',
            'pmYearlyPercentage'
        ));
    }
}
