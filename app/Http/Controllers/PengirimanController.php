<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengirimanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Query Data Proyek untuk Daftar (Paginate)
        $query = DB::table('pengiriman');

        if ($request->search) {
            $query->where('nama_proyek', 'like', '%' . $request->search . '%');
        }

        $data = $query->paginate(10);

        // 2. Data Statistik Dashboard
        $detail = DB::table('pengiriman_detail')->get();

        $totalData = $detail->count();

        $onTime = $detail
            ->where('status_delivery', 'On Time')
            ->count();

        $overdue = $detail
            ->where('status_delivery', 'Overdue')
            ->count();

        $delivered = $detail
            ->whereNotNull('actual_delivery')
            ->count();

        $unloading = $detail
            ->whereNotNull('actual_unloading')
            ->count();

        $vendorCount = $detail
            ->pluck('vendor')
            ->filter()
            ->unique()
            ->count();

        $trainsetCount = $detail
            ->pluck('trainset')
            ->filter()
            ->unique()
            ->count();

        $projectCount = DB::table('pengiriman')->count();

        // 3. Progress per Proyek mengambil berdasarkan Tipe Kereta
        $tipeKeretaProgress = DB::table('pengiriman')
            ->join(
                'pengiriman_detail',
                'pengiriman.id',
                '=',
                'pengiriman_detail.pengiriman_id'
            )
            ->select(
                'pengiriman.id as proyek_id',
                'pengiriman.nama_proyek',
                'pengiriman_detail.tipe_kereta',
                DB::raw('COUNT(pengiriman_detail.id) as total_unit'),
                DB::raw('
                    SUM(
                        CASE
                            WHEN pengiriman_detail.actual_delivery IS NOT NULL
                            THEN 1
                            ELSE 0
                        END
                    ) as delivered
                ')
            )
            ->groupBy(
                'pengiriman.id',
                'pengiriman.nama_proyek',
                'pengiriman_detail.tipe_kereta'
            )
            ->orderBy('pengiriman.nama_proyek')
            ->get()
            ->map(function ($item) {
                $item->progress =
                    $item->total_unit > 0
                        ? round(
                            ($item->delivered / $item->total_unit) * 100,
                            1
                        )
                        : 0;

                return $item;
            })
            ->groupBy('nama_proyek');

        // Pass semua data ke view pengiriman.index
        return view('pengiriman.index', compact(
            'data',
            'totalData',
            'onTime',
            'overdue',
            'delivered',
            'unloading',
            'vendorCount',
            'trainsetCount',
            'projectCount',
            'tipeKeretaProgress'
        ));
    }

    public function monitor(Request $request, $id)
    {
        $proyek = DB::table('pengiriman')->where('id', $id)->first();

        $query = DB::table('pengiriman_detail')
            ->where('pengiriman_id', $id);

        // FILTER
        if ($request->trainset) {
            $query->where('trainset', 'like', '%' . $request->trainset . '%');
        }

        if ($request->nomor_lambung) {
            $query->where('nomor_lambung', 'like', '%' . $request->nomor_lambung . '%');
        }

        if ($request->batch) {
            $query->where('batch', 'like', '%' . $request->batch . '%');
        }

        if ($request->no_sjn) {
            $query->where('no_sjn', 'like', '%' . $request->no_sjn . '%');
        }

        if ($request->actual_delivery) {
            $query->whereDate('actual_delivery', $request->actual_delivery);
        }

        if ($request->status_delivery) {
            $query->where('status_delivery', $request->status_delivery);
        }

        if ($request->loading_truck) {
            $query->whereDate('loading_truck', $request->loading_truck);
        }

        if ($request->actual_unloading) {
            $query->whereDate('actual_unloading', $request->actual_unloading);
        }

        $detail = $query->get();

        return view('pengiriman.monitor', compact('proyek', 'detail'));
    }

    public function store(Request $r)
    {
        DB::table('pengiriman')->insert([
            'nama_proyek' => $r->nama_proyek
        ]);

        return redirect()->route('pengiriman.index')->with('success', 'Proyek berhasil dibuat');
    }

    public function update(Request $r, $id)
    {
        DB::table('pengiriman')->where('id', $id)->update([
            'nama_proyek' => $r->nama_proyek
        ]);

        return redirect()->route('pengiriman.index')->with('success', 'Proyek berhasil diperbarui');
    }

    public function delete($id)
    {
        DB::table('pengiriman')->where('id', $id)->delete();
        return redirect()->route('pengiriman.index')->with('success', 'Proyek berhasil dihapus');
    }

    public function storeDetail(Request $r)
    {
        // AUTO STATUS DELIVERY
        $statusDelivery = null;

        if ($r->plan_delivery && $r->actual_delivery) {
            $plan = Carbon::parse($r->plan_delivery);
            $actual = Carbon::parse($r->actual_delivery);

            if ($actual->lte($plan)) {
                $statusDelivery = 'On Time';
            } else {
                $statusDelivery = 'Overdue';
            }
        }

        DB::table('pengiriman_detail')->insert([
            'pengiriman_id' => $r->pengiriman_id,
            'trainset' => $r->trainset,
            'tipe_kereta' => $r->tipe_kereta,
            'nomor_lambung' => $r->nomor_lambung,
            'batch' => $r->batch,
            'trucking' => $r->trucking,
            'nopol' => $r->nopol,
            'no_sjn' => $r->no_sjn,
            'code_armada' => $r->code_armada,
            'plan_delivery' => $r->plan_delivery,
            'actual_delivery' => $r->actual_delivery,
            'status_delivery' => $statusDelivery,
            'loading_truck' => $r->loading_truck,
            'loading_vessel' => $r->loading_vessel,
            'plan_unloading' => $r->plan_unloading,
            'actual_unloading' => $r->actual_unloading,
            'vendor' => $r->vendor,
            'keterangan' => $r->keterangan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Data pengiriman ditambahkan');
    }

    public function updateDetail(Request $r, $id)
    {
        // AUTO STATUS DELIVERY
        $statusDelivery = null;

        if ($r->plan_delivery && $r->actual_delivery) {
            $plan = Carbon::parse($r->plan_delivery);
            $actual = Carbon::parse($r->actual_delivery);

            if ($actual->lte($plan)) {
                $statusDelivery = 'On Time';
            } else {
                $statusDelivery = 'Overdue';
            }
        }

        DB::table('pengiriman_detail')->where('id', $id)->update([
            'trainset' => $r->trainset,
            'tipe_kereta' => $r->tipe_kereta,
            'nomor_lambung' => $r->nomor_lambung,
            'batch' => $r->batch,
            'trucking' => $r->trucking,
            'nopol' => $r->nopol,
            'no_sjn' => $r->no_sjn,
            'code_armada' => $r->code_armada,
            'plan_delivery' => $r->plan_delivery,
            'actual_delivery' => $r->actual_delivery,
            'status_delivery' => $statusDelivery,
            'loading_truck' => $r->loading_truck,
            'loading_vessel' => $r->loading_vessel,
            'plan_unloading' => $r->plan_unloading,
            'actual_unloading' => $r->actual_unloading,
            'vendor' => $r->vendor,
            'keterangan' => $r->keterangan,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Data diupdate');
    }

    public function deleteDetail($id)
    {
        DB::table('pengiriman_detail')->where('id', $id)->delete();

        return back()->with('success', 'Data dihapus');
    }

    public function bulkDelete(Request $request)
    {
        if ($request->ids) {
            DB::table('pengiriman_detail')
                ->whereIn('id', $request->ids)
                ->delete();
        }

        return back()->with('success', 'Data terpilih berhasil dihapus');
    }

    public function dashboard()
    {
        // Tetap dipertahankan apabila masih ada route terpisah yang memanggil method dashboard()
        $detail = DB::table('pengiriman_detail')->get();

        $totalData = $detail->count();

        $onTime = $detail
            ->where('status_delivery', 'On Time')
            ->count();

        $overdue = $detail
            ->where('status_delivery', 'Overdue')
            ->count();

        $delivered = $detail
            ->whereNotNull('actual_delivery')
            ->count();

        $unloading = $detail
            ->whereNotNull('actual_unloading')
            ->count();

        $vendorCount = $detail
            ->pluck('vendor')
            ->filter()
            ->unique()
            ->count();

        $trainsetCount = $detail
            ->pluck('trainset')
            ->filter()
            ->unique()
            ->count();

        $projectCount = DB::table('pengiriman')->count();

        $tipeKeretaProgress = DB::table('pengiriman')
            ->join(
                'pengiriman_detail',
                'pengiriman.id',
                '=',
                'pengiriman_detail.pengiriman_id'
            )
            ->select(
                'pengiriman.id as proyek_id',
                'pengiriman.nama_proyek',
                'pengiriman_detail.tipe_kereta',
                DB::raw('COUNT(pengiriman_detail.id) as total_unit'),
                DB::raw('
                    SUM(
                        CASE
                            WHEN pengiriman_detail.actual_delivery IS NOT NULL
                            THEN 1
                            ELSE 0
                        END
                    ) as delivered
                ')
            )
            ->groupBy(
                'pengiriman.id',
                'pengiriman.nama_proyek',
                'pengiriman_detail.tipe_kereta'
            )
            ->orderBy('pengiriman.nama_proyek')
            ->get()
            ->map(function ($item) {
                $item->progress =
                    $item->total_unit > 0
                        ? round(
                            ($item->delivered / $item->total_unit) * 100,
                            1
                        )
                        : 0;

                return $item;
            })
            ->groupBy('nama_proyek');

        return view(
            'pengiriman.dashboard',
            compact(
                'totalData',
                'onTime',
                'overdue',
                'delivered',
                'unloading',
                'vendorCount',
                'trainsetCount',
                'projectCount',
                'tipeKeretaProgress'
            )
        );
    }

    public function dashboardDetail($type)
    {
        switch ($type) {
            case 'proyek':
                $title = 'Daftar Proyek';
                $data = DB::table('pengiriman')
                    ->select('id', 'nama_proyek')
                    ->get();
                break;

            case 'pengiriman':
                $title = 'Semua Data Pengiriman';
                $data = DB::table('pengiriman_detail')->get();
                break;

            case 'ontime':
                $title = 'Data On Time';
                $data = DB::table('pengiriman_detail')
                    ->where('status_delivery', 'On Time')
                    ->get();
                break;

            case 'overdue':
                $title = 'Data Overdue';
                $data = DB::table('pengiriman_detail')
                    ->where('status_delivery', 'Overdue')
                    ->get();
                break;

            case 'delivery':
                $title = 'Data Sudah Delivery';
                $data = DB::table('pengiriman_detail')
                    ->whereNotNull('actual_delivery')
                    ->get();
                break;

            case 'unloading':
                $title = 'Data Sudah Unloading';
                $data = DB::table('pengiriman_detail')
                    ->whereNotNull('actual_unloading')
                    ->get();
                break;

            case 'vendor':
                $title = 'Daftar Vendor Aktif';
                $data = DB::table('pengiriman_detail')
                    ->select('vendor')
                    ->whereNotNull('vendor')
                    ->distinct()
                    ->orderBy('vendor')
                    ->get();
                break;

            case 'trainset':
                $title = 'Daftar Trainset';
                $data = DB::table('pengiriman_detail')
                    ->select('trainset')
                    ->distinct()
                    ->orderBy('trainset')
                    ->get();
                break;

            default:
                abort(404);
        }

        return view(
            'pengiriman.dashboard-detail',
            compact('title', 'data', 'type')
        );
    }
}