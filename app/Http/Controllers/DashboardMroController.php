<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Monitoring; 
use App\Models\Asset;
use Carbon\Carbon;

class DashboardMroController extends Controller
{
    public function index()
    {
        // Fetch Data Monitoring Progres MRO
        $allMonitorings = Monitoring::with('documents')->get();

        // 1. Kalkulasi Status Proyek (Open, Closed, On Hold)
        $statusCounts = [
            'Open'    => $allMonitorings->where('status', 'Open')->count(),
            'Closed'  => $allMonitorings->where('status', 'Closed')->count(),
            'On Hold' => $allMonitorings->where('status', 'On Hold')->count(),
        ];

        // 2. Kalkulasi Notifikasi Kontrak
        $notifCounts = [
            'berjalan' => 0,
            'h7'       => 0,
            'berakhir' => 0,
            'selesai'  => 0,
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

        // 3. Tabel Ringkasan Progres MRO (Ambil 6 Data Terbaru)
        $monitorings = Monitoring::with('documents')
            ->latest()
            ->take(6)
            ->get();

        // 4. Kalkulasi Preventive Maintenance (PM) 1 TAHUN (JUMLAH 12 BULAN / 12)
        $tahun = date('Y');
        
        $assets = Asset::with(['maintenances' => function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        }])->get();

        $totalPersen12Bulan = 0;

        // Hitung persentase realisasi untuk masing-masing bulan (1 s.d. 12)
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $totalPlanning = 0;
            $totalRealisasi = 0;

            foreach ($assets as $asset) {
                $maintenances = $asset->maintenances->where('bulan', $bulan);

                $totalPlanning += $maintenances->where('planning', true)->count();
                $totalRealisasi += $maintenances->where('realisasi', true)->count();
            }

            // Jika ada planning, hitung persennya. Jika tidak ada planning/kosong, nilainya 0
            $persenBulanIni = ($totalPlanning > 0) ? ($totalRealisasi / $totalPlanning) * 100 : 0;

            // Tambahkan persentase bulan ini ke total 12 bulan
            $totalPersen12Bulan += $persenBulanIni;
        }

        // Murni jumlahkan persen 12 bulan lalu dibagi 12
        $pmYearlyPercentage = round($totalPersen12Bulan / 12, 2);

        return view('dashboard.mro', compact(
            'statusCounts',
            'notifCounts',
            'monitorings',
            'pmYearlyPercentage'
        ));
    }
}