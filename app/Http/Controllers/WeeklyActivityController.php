<?php

namespace App\Http\Controllers;

use App\Exports\WeeklyActivityExport;
use App\Models\DailyActivity;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class WeeklyActivityController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->start_date
            ? Carbon::parse($request->start_date)->startOfDay()
            : Carbon::now()->startOfWeek()->startOfDay();

        $end = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::now()->endOfWeek()->endOfDay();

        // Query Data Utama
        $data = DailyActivity::with(['monitoring'])
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal', 'asc')
            ->get()
            ->map(function ($item) {
                $item->status = strtolower(trim($item->status));
                return $item;
            });

        /* =========================
           EXECUTIVE METRICS
        ========================= */
        $total = $data->count();
        $open = $data->where('status', 'open')->count();
        $closed = $data->where('status', 'closed')->count();
        $completionRate = $total > 0 ? round(($closed / $total) * 100, 1) : 0;

        /* =========================
           GROUP PER PROYEK & HIGHLIGHTS
        ========================= */
        $grouped = $data->groupBy(function ($i) {
            return optional($i->monitoring)->nama_pekerjaan ?? 'Tanpa Proyek / Umum';
        });

        $projectSummary = [];
        foreach ($grouped as $project => $items) {
            $totalP = $items->count();
            $closedP = $items->where('status', 'closed')->count();
            $openP = $items->where('status', 'open')->count();
            $rate = $totalP > 0 ? round(($closedP / $totalP) * 100, 1) : 0;

            $projectSummary[] = [
                'project' => $project,
                'total' => $totalP,
                'closed' => $closedP,
                'open' => $openP,
                'rate' => $rate,
                'issues' => $items->where('status', 'open')->pluck('keterangan')->filter()->values(),
                'items' => $items
            ];
        }

        /* =========================
           DYNAMIC TREND CHART
        ========================= */
        $trendLabels = [];
        $trendTotal = [];
        $trendOpen = [];
        $trendClosed = [];

        $period = CarbonPeriod::create($start, $end);
        foreach ($period as $date) {
            $formattedDate = $date->format('Y-m-d');
            $dayData = $data->filter(function ($item) use ($formattedDate) {
                return Carbon::parse($item->tanggal)->format('Y-m-d') === $formattedDate;
            });

            $trendLabels[] = $date->format('d M');
            $trendTotal[] = $dayData->count();
            $trendOpen[] = $dayData->where('status', 'open')->count();
            $trendClosed[] = $dayData->where('status', 'closed')->count();
        }

        return view('mro.weekly.index', compact(
            'data',
            'grouped',
            'projectSummary',
            'total',
            'open',
            'closed',
            'completionRate',
            'start',
            'end',
            'trendLabels',
            'trendTotal',
            'trendOpen',
            'trendClosed'
        ));
    }

    public function exportExcel(Request $request)
    {
        $start = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfWeek();
        $end = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfWeek();

        return Excel::download(
            new WeeklyActivityExport($start, $end),
            'weekly-activity-report.xlsx'
        );
    }
}
