<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Models\MonitoringWil1;
use App\Models\MonitoringWil2;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class DivisiWilayahProgressController extends Controller
{
    /**
     * Mengambil data gabungan Wilayah 1, Wilayah 2, dan MRO secara berurutan
     */
    private function getCombinedMonitorings(Request $request)
    {
        $data = collect();

        /*
         * |--------------------------------------------------------------------------
         * | 1. WILAYAH 1
         * |--------------------------------------------------------------------------
         */
        $queryWil1 = MonitoringWil1::with('documents');

        if ($request->filled('po')) {
            $queryWil1->where(
                'po_nota_dinas',
                'like',
                '%' . trim($request->po) . '%'
            );
        }

        if ($request->filled('pekerjaan')) {
            $queryWil1->where(
                'nama_pekerjaan',
                'like',
                '%' . trim($request->pekerjaan) . '%'
            );
        }

        $wil1Data = $queryWil1->get()->sortByDesc(function ($item) {
            return $item->updated_at ?? $item->created_at;
        });

        foreach ($wil1Data as $item) {
            $item->divisi = 'Wilayah 1';
            $data->push($item);
        }

        /*
         * |--------------------------------------------------------------------------
         * | 2. WILAYAH 2
         * |--------------------------------------------------------------------------
         */
        $queryWil2 = MonitoringWil2::with('documents');

        if ($request->filled('po')) {
            $queryWil2->where(
                'po_nota_dinas',
                'like',
                '%' . trim($request->po) . '%'
            );
        }

        if ($request->filled('pekerjaan')) {
            $queryWil2->where(
                'nama_pekerjaan',
                'like',
                '%' . trim($request->pekerjaan) . '%'
            );
        }

        $wil2Data = $queryWil2->get()->sortByDesc(function ($item) {
            return $item->updated_at ?? $item->created_at;
        });

        foreach ($wil2Data as $item) {
            $item->divisi = 'Wilayah 2';
            $data->push($item);
        }

        /*
         * |--------------------------------------------------------------------------
         * | 3. MRO
         * |--------------------------------------------------------------------------
         */
        $queryMro = Monitoring::with('documents');

        if ($request->filled('po')) {
            $queryMro->where(
                'po_nota_dinas',
                'like',
                '%' . trim($request->po) . '%'
            );
        }

        if ($request->filled('pekerjaan')) {
            $queryMro->where(
                'nama_pekerjaan',
                'like',
                '%' . trim($request->pekerjaan) . '%'
            );
        }

        $mroData = $queryMro->get()->sortByDesc(function ($item) {
            return $item->updated_at ?? $item->created_at;
        });

        foreach ($mroData as $item) {
            $item->divisi = 'MRO';
            $data->push($item);
        }

        return $data->values();
    }

    /**
     * Helper untuk menghitung total realisasi dari sebuah collection data
     */
    private function calculateRealizationStats($collection)
    {
        $totalInka = 0;
        $totalNonInka = 0;

        foreach ($collection as $item) {
            $jenis = strtolower(trim($item->jenis_pekerjaan ?? ''));
            $isInka = ($jenis === 'inka');

            // Hitung dari dokumen realisasi/closed yang valid
            $sumDocs = $item->documents
                ? $item->documents->filter(function ($doc) {
                    $kriteria = strtolower($doc->kriteria ?? '');
                    return in_array($kriteria, ['realisasi', 'closed']) && !is_null($doc->harga) && $doc->harga > 0;
                })->sum('harga')
                : 0;

            $realisasiVal = $sumDocs > 0 ? $sumDocs : ($item->total_realisasi ?? ($item->realisasi ?? 0));

            if ($isInka) {
                $totalInka += $realisasiVal;
            } else {
                $totalNonInka += $realisasiVal;
            }
        }

        return [
            'inka' => $totalInka,
            'non_inka' => $totalNonInka,
            'total' => $totalInka + $totalNonInka
        ];
    }

    /**
     * INDEX
     */
    public function index(Request $request)
    {
        $allMonitorings = $this->getCombinedMonitorings($request);

        /*
         * |--------------------------------------------------------------------------
         * | PAGINATION
         * |--------------------------------------------------------------------------
         */
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $currentItems = $allMonitorings
            ->slice(($currentPage - 1) * $perPage, $perPage)
            ->values();

        $monitorings = new LengthAwarePaginator(
            $currentItems,
            $allMonitorings->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view(
            'divisi_wilayah.progress',
            compact('monitorings')
        );
    }

    /**
     * PRINT PDF
     */
    public function print(Request $request)
    {
        // 1. Ambil data sesuai filter
        $monitorings = $this->getCombinedMonitorings($request);

        // 2. Pisahkan data berdasarkan divisi untuk keperluan perhitungan ringkasan
        $wil1Collection = $monitorings->where('divisi', 'Wilayah 1');
        $wil2Collection = $monitorings->where('divisi', 'Wilayah 2');
        $mroCollection = $monitorings->where('divisi', 'MRO');

        // 3. Hitung statistik masing-masing divisi
        $statsWil1 = $this->calculateRealizationStats($wil1Collection);
        $statsWil2 = $this->calculateRealizationStats($wil2Collection);
        $statsMro = $this->calculateRealizationStats($mroCollection);

        // 4. Hitung Grand Total Keseluruhan
        $grandTotalInka = $statsWil1['inka'] + $statsWil2['inka'] + $statsMro['inka'];
        $grandTotalNonInka = $statsWil1['non_inka'] + $statsWil2['non_inka'] + $statsMro['non_inka'];
        $grandTotalAll = $grandTotalInka + $grandTotalNonInka;

        // Variabel ringkasan per divisi untuk dikirim ke view
        $totalWil1 = $statsWil1['total'];
        $realisasiWil1Inka = $statsWil1['inka'];
        $realisasiWil1NonInka = $statsWil1['non_inka'];

        $totalWil2 = $statsWil2['total'];
        $realisasiWil2Inka = $statsWil2['inka'];
        $realisasiWil2NonInka = $statsWil2['non_inka'];

        $totalMro = $statsMro['total'];
        $realisasiMroInka = $statsMro['inka'];
        $realisasiMroNonInka = $statsMro['non_inka'];

        // 5. Load PDF dengan membawa seluruh variabel ringkasan
        $pdf = Pdf::loadView(
            'divisi_wilayah.print_pdf',
            compact(
                'monitorings',
                'grandTotalAll',
                'grandTotalInka',
                'grandTotalNonInka',
                'totalWil1',
                'realisasiWil1Inka',
                'realisasiWil1NonInka',
                'totalWil2',
                'realisasiWil2Inka',
                'realisasiWil2NonInka',
                'totalMro',
                'realisasiMroInka',
                'realisasiMroNonInka'
            )
        )->setPaper('a4', 'landscape');

        return $pdf->stream(
            'Progress_Divisi_Wilayah_' . date('Ymd_His') . '.pdf'
        );
    }
}
