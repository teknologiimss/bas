<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengirimanController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = DB::table('pengiriman');

        if ($request->search) {
            $query->where('nama_proyek', 'like', '%' . $request->search . '%');
        }

        $data = $query->paginate(10);

        return view('pengiriman.index', compact('data'));
    }

    public function monitor($id)
    {
        $proyek = DB::table('pengiriman')->where('id', $id)->first();

        $detail = DB::table('pengiriman_detail')
            ->where('pengiriman_id', $id)
            ->get();

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

    // ========================

    // STORE DETAIL
    // ========================
    public function storeDetail(Request $r)
    {
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
            'leadtime_delivery' => $r->leadtime_delivery,
            'status_delivery' => $r->status_delivery,
            'loading_truck' => $r->loading_truck,
            'loading_vessel' => $r->loading_vessel,
            'plan_unloading' => $r->plan_unloading,
            'actual_unloading' => $r->actual_unloading,
            'leadtime_unloading' => $r->leadtime_unloading,
            'vendor' => $r->vendor,
            'keterangan' => $r->keterangan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Data pengiriman ditambahkan');
    }

    // ========================
    // UPDATE DETAIL
    // ========================
    public function updateDetail(Request $r, $id)
    {
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
            'leadtime_delivery' => $r->leadtime_delivery,
            'status_delivery' => $r->status_delivery,
            'loading_truck' => $r->loading_truck,
            'loading_vessel' => $r->loading_vessel,
            'plan_unloading' => $r->plan_unloading,
            'actual_unloading' => $r->actual_unloading,
            'leadtime_unloading' => $r->leadtime_unloading,
            'vendor' => $r->vendor,
            'keterangan' => $r->keterangan,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Data diupdate');
    }

    // ========================
    // DELETE DETAIL
    // ========================
    public function deleteDetail($id)
    {
        DB::table('pengiriman_detail')->where('id', $id)->delete();

        return back()->with('success', 'Data dihapus');
    }
}
