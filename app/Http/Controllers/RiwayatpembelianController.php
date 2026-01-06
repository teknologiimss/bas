<?php

namespace App\Http\Controllers;

use App\Models\DetailPo;
use App\Models\DetailPR;
use App\Models\Keproyekan;
use App\Models\Kontrak;
use App\Models\Purchase_Order;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RiwayatpembelianController extends Controller
{
    public function riwayat_pembelian()
    {
        $items = DetailPR::select(
            'detail_pr.*',
            'detail_po.id_po as id_po_detail'
        )
            ->join('detail_po', 'detail_po.id_detail_pr', '=', 'detail_pr.id')
            ->groupBy('detail_pr.kode_material')
            ->paginate(10);

        $items->getCollection()->transform(function ($d) {

            // Ambil PO pakai alias
            $po = Purchase_Order::find($d->id_po_detail);

            $d->no_po = $po->no_po ?? '-';
            $d->tanggal_po = $po->tanggal_po ?? null;

            if ($po && $po->proyek_id) {
                $ids = explode(',', $po->proyek_id);
                $d->nama_proyek = Kontrak::whereIn('id', $ids)
                    ->pluck('nama_pekerjaan')
                    ->implode(', ');
            } else {
                $d->nama_proyek = '-';
            }

            $detailPo = DetailPo::where('id_detail_pr', $d->id)->first();
            $d->harga = $detailPo->harga ?? 0;

            $d->nama_vendor = $po && $po->vendor_id
                ? Vendor::find($po->vendor_id)->nama ?? '-'
                : '-';

            return $d;
        });

        return view('riwayat_pembelian.index', compact('items'));
    }

    // public function riwayat_pembelian()
    // {
    //     $items = DetailPR::join('detail_po', 'detail_po.id_detail_pr', '=', 'detail_pr.id')->groupBy('detail_pr.kode_material')->paginate(10);

    //     return view('riwayat_pembelian.index', compact('items'));
    // }

    // public function getDetailRiwayatPembelian(Request $request)
    // {
    //     $komat = $request->kode_material;
    //     $items = DetailPR::whereNotNull('id_po')->where('kode_material', $komat)
    //     ->get();

    //     $items = $items->map(function($item){
    //         $po = Purchase_Order::where('id', $item->id_po)->first();
    //         // dd($po);
    //         $split_proyek = explode(',', $po->proyek_id);
    //         // dd($split_proyek);
    //         $proyek_names = Kontrak::whereIn('id', $split_proyek)->pluck('nama_pekerjaan')->toArray();
    //         // dd($proyek_names);
    //         $item->proyek = implode(',', $proyek_names);
    //         // dd($item->proyek);
    //         // $item->proyek = Keproyekan::where('id', $item->id_proyek)->first();
    //         $item->detail_po = DetailPo::where('id_detail_pr', $item->id)->first();
    //         $item->detail_po->harga = $this->format_rupiah($item->detail_po->harga);
    //         $po = Purchase_Order::where('id', $item->id_po)->first();
    //         $item->vendor = $po ? Vendor::where('id', $po->vendor_id)->first() : null;


    //         return $item;
    //     });

    //     return response()->json([
    //         'items' => $items
    //     ]);
    // }

    public function getDetailRiwayatPembelian(Request $request)
    {
        $komat = $request->kode_material;
        $items = DetailPR::select('detail_pr.*', 'detail_po.id_po')->join('detail_po', 'detail_po.id_detail_pr', '=', 'detail_pr.id')->where('detail_pr.kode_material', $komat)->get();

        $items = $items->map(function ($item) {
            $po = Purchase_Order::where('id', $item->id_po)->first();

            // Ambil nama proyek terkait
            $split_proyek = explode(',', $po->proyek_id);
            $proyek_names = Kontrak::whereIn('id', $split_proyek)->pluck('nama_pekerjaan')->toArray();

            // Tambahkan data tambahan
            $item->proyek = implode(',', $proyek_names);
            $item->no_po = $po->no_po; // Ambil no_po
            $item->tanggal_po = $po->tanggal_po ? Carbon::parse($po->tanggal_po)->format('d/m/Y') : null; // Format dd/mm/yyyy
            $item->detail_po = DetailPo::where('id_detail_pr', $item->id)->first();
            $item->detail_po->harga = $this->format_rupiah($item->detail_po->harga);
            $item->vendor = $po ? Vendor::where('id', $po->vendor_id)->first() : null;

            return $item;
        });

        return response()->json([
            'items' => $items,
        ]);
    }
}
