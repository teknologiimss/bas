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
        $monitorings = $this->getCombinedMonitorings($request);

        $pdf = Pdf::loadView(
            'divisi_wilayah.print_pdf',
            compact('monitorings')
        )->setPaper('a4', 'landscape');

        return $pdf->stream(
            'Progress_Divisi_Wilayah_' . date('Ymd_His') . '.pdf'
        );
    }
}
