<?php

namespace App\Http\Controllers;

use App\Exports\WeeklyActivityExport;
use App\Models\DailyActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class WeeklyActivityController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->start_date
            ? Carbon::parse($request->start_date)
            : Carbon::now()->startOfWeek();

        $end = $request->end_date
            ? Carbon::parse($request->end_date)
            : Carbon::now()->endOfWeek();

        $data = DailyActivity::with(['monitoring'])
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal', 'asc')
            ->get()
            ->map(function ($item) {
                $item->status = strtolower(trim($item->status));
                return $item;
            });

        /* =========================
           SUMMARY
        ========================= */
        $total = $data->count();
        $open = $data->where('status', 'open')->count();
        $closed = $data->where('status', 'closed')->count();

        /* =========================
           GROUP PER PROYEK
        ========================= */
        $grouped = $data->groupBy(function ($i) {
            return optional($i->monitoring)->nama_pekerjaan ?? 'Tanpa Proyek';
        });

        /* =========================
           TREND 7 HARI (FIXED)
        ========================= */
        $trendLabels = [];
        $trendTotal = [];
        $trendOpen = [];
        $trendClosed = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');

            $dayData = $data->filter(function ($item) use ($date) {
                return Carbon::parse($item->tanggal)->format('Y-m-d') === $date;
            });

            $trendLabels[] = Carbon::parse($date)->format('d M');
            $trendTotal[] = $dayData->count();
            $trendOpen[] = $dayData->where('status', 'open')->count();
            $trendClosed[] = $dayData->where('status', 'closed')->count();
        }

        /* =========================
           PROGRESS PER PROYEK
        ========================= */
        $projectProgress = [];

        foreach ($grouped as $project => $items) {
            $totalP = $items->count();
            $closedP = $items->where('status', 'closed')->count();

            $projectProgress[] = [
                'project' => $project,
                'progress' => $totalP > 0
                    ? round(($closedP / $totalP) * 100, 2)
                    : 0
            ];
        }

        /* =========================
           SPLIT DATA
        ========================= */
        $openData = $data->where('status', 'open');
        $closedData = $data->where('status', 'closed');

        return view('mro.weekly.index', compact(
            'data',
            'grouped',
            'total',
            'open',
            'closed',
            'start',
            'end',
            'trendLabels',
            'trendTotal',
            'trendOpen',
            'trendClosed',
            'projectProgress',
            'openData',
            'closedData'
        ));
    }

    public function exportExcel(Request $request)
    {
        $start = $request->start_date
            ? Carbon::parse($request->start_date)
            : Carbon::now()->startOfWeek();

        $end = $request->end_date
            ? Carbon::parse($request->end_date)
            : Carbon::now()->endOfWeek();

        return Excel::download(
            new WeeklyActivityExport($start, $end),
            'weekly-activity.xlsx'
        );
    }
}
