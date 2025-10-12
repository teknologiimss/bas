<?php

namespace App\Http\Controllers;

use App\Models\DetailPo;
use App\Models\DetailPoluar;
use App\Models\DetailPR;
use App\Models\Keproyekan;
use App\Models\Kontrak;
use App\Models\Nego;
use App\Models\Proyek;
use App\Models\Purchase_Order;
use App\Models\Purchase_Orderluar;
use App\Models\PurchaseRequest;
use App\Models\Spph;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseOrderluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->q;
        if (Session::has('selected_warehouse_id')) {
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $purchaseluars = Purchase_Orderluar::select('purchase_orderluar.*', 'vendor.nama as vendor_name', 'kontrak.nama_pekerjaan as proyek_name', 'purchase_request.no_pr as pr_no')
            ->where('purchase_orderluar.tipe', "0")
            ->join('vendor', 'vendor.id', '=', 'purchase_orderluar.vendor_id')
            ->leftjoin('kontrak', 'kontrak.id', '=', 'purchase_orderluar.proyek_id')
            ->leftjoin('purchase_request', 'purchase_request.id', '=', 'purchase_orderluar.pr_id')
            ->orderBy('id', 'asc')
            ->paginate(50);
        $vendors = DB::table('vendor')->get();
        $proyeks = DB::table('kontrak')->get();

        foreach ($purchaseluars as $purchaseluar) {
            $split_proyek = explode(',', $purchaseluar->proyek_id);

            $proyek_names = Kontrak::whereIn('id', $split_proyek)->pluck('nama_pekerjaan')->toArray();
            $proyek = implode(',', $proyek_names);

            // Add the proyek value (optional if already exists in the query result)
            // if ($proyek) {
            $purchaseluar->proyek_name = $proyek;
            // }
        }


        if ($search) {
            $purchaseluars = Purchase_Orderluar::where('no_poluar', 'LIKE', "%$search%")->paginate(50);
        }

        $purchaseluars->getCollection()->transform(function ($purchaseluar) {
            $pr = PurchaseRequest::whereIn('id', explode(',', $purchaseluar->pr_id))->get();
            // dd($pr, $purchaseluar->pr_id, PurchaseRequest::where('id', 1)->first());
            $purchaseluar->pr_no = $pr->pluck('no_pr')->implode(', ');
            return $purchaseluar;
        });

        if ($request->format == "json") {
            $purchaseluars = Purchase_Orderluar::where("warehouse_id", $warehouse_id)->get();

            $purchaseluars->getCollection()->transform(function ($purchaseluar) {
                $pr = PurchaseRequest::whereIn('id', explode(',', $purchaseluar->pr_id))->get();
                $purchaseluar->pr_no = $pr->pluck('no_pr')->implode(', ');
                return $purchaseluar;
            });

            return response()->json($purchaseluars);
        } else {
            // dd($purchaseluars);
            $prs = PurchaseRequest::all();
            return view('purchase_orderluar.purchase_orderluar', compact('purchaseluars', 'vendors', 'proyeks', 'prs'));
        }
    }




    //Simpan Data
    public function store(Request $request)
    {
        // dd($request->all());

        $purchase_orderluar = $request->id;

        $request->validate(
            [
                'no_poluar' => 'required',
                'vendor_id' => 'required',
                'tanggal_poluar' => 'required',
                'batas_poluar' => 'required',
                'proyek_id' => 'required',

            ],
            [
                'no_poluar.required' => 'No. PO harus diisi',
                'vendor_id.required' => 'Vendor harus diisi',
                'tanggal_poluar.required' => 'Tanggal PO harus diisi',
                'batas_poluar.required' => 'Batas Akhir PO harus diisi',
                'proyek_id.required' => 'Proyek harus diisi',
            ]
        );

        if (empty($purchase_orderluar)) {
            $tipe = 0; // 0 = PO biasa, 1 = PO PL
            // dd($request->all());
            $poluar = DB::table('purchase_orderluar')->insertGetId([
                'vendor_id' => $request->vendor_id,
                'no_poluar' => $request->no_poluar,
                'proyek_id' => implode(',', $request->proyek_id),
                'pr_id' => implode(',', $request->nomor_pr),
                'tanggal_poluar' => $request->tanggal_poluar,
                'reference' => $request->reference,
                'rfq' => $request->rfq,
                'quotation' => $request->quotation,
                'no_nego' => $request->no_nego,
                'final_quotation' => $request->final_quotation,
                'batas_poluar' => $request->batas_poluar,
                'keterangan_nama' => $request->keterangan_nama,
                'signature_imss' => $request->signature_imss,
                'signature_vendor' => $request->signature_vendor,
                'keterangan_shipment' => $request->keterangan_shipment,
                'keterangan_payment' => $request->keterangan_payment,
                'delivery' => $request->delivery,
                'shipment' => $request->shipment,
                'delivery_term' => $request->delivery_term,
                'destination' => $request->destination,
                'payment' => $request->payment,

                'tipe' => $tipe,


            ]);

            // $prs = DetailPR::where('id_pr', $request->pr_id)->get();


            // foreach ($prs as $pr) {
            //     DetailPo::insert([
            //         'id_po' => $po,
            //         'id_pr' => $request->pr_id,
            //         'id_detail_pr' => $pr->id,
            //     ]);
            // }
            // dd($request->all());
            return redirect()->route('purchase_orderluar.index')->with('success', 'Data PO berhasil ditambahkan');
        } else {

            DB::table('purchase_orderluar')->where('id', $purchase_orderluar)->update([
                'vendor_id' => $request->vendor_id,
                'no_poluar' => $request->no_poluar,
                'proyek_id' => implode(',', $request->proyek_id),
                'pr_id' => implode(',', $request->nomor_pr),
                'tanggal_poluar' => $request->tanggal_poluar,
                'reference' => $request->reference,
                'rfq' => $request->rfq,
                'quotation' => $request->quotation,
                'no_nego' => $request->no_nego,
                'final_quotation' => $request->final_quotation,
                'batas_poluar' => $request->batas_poluar,
                'keterangan_nama' => $request->keterangan_nama,
                'signature_imss' => $request->signature_imss,
                'signature_vendor' => $request->signature_vendor,
                'keterangan_shipment' => $request->keterangan_shipment,
                'keterangan_payment' => $request->keterangan_payment,
                'delivery' => $request->delivery,
                'shipment' => $request->shipment,
                'delivery_term' => $request->delivery_term,
                'destination' => $request->destination,
                'payment' => $request->payment,



            ]);

            return redirect()->route('purchase_orderluar.index')->with('success', 'Data PO berhasil diubah');
        }
    }
    //End Simpan Data




    //Hapus Data
    public function destroy(Request $request)
    {
        $delete_poluar_id = $request->id;

        // Ambil data detail_po yang akan dihapus
        $detail_poluar = DB::table('detail_poluar')->where('id_poluar', $delete_poluar_id)->first();

        if ($detail_poluar) {
            // Ambil data detail_pr terkait
            $detail_pr = DB::table('detail_pr')->where('id', $detail_poluar->id_detail_pr)->first();

            if ($detail_pr) {
                // Cek apakah ada id_del_po di detail_po
                if (!$detail_poluar->id_del_poluar) {
                    // Jika tidak ada id_del_po, set qty_po dengan nilai qty dari detail_pr
                    DB::table('detail_pr')->where('id', $detail_pr->id)->update(['qty_poluar' => $detail_pr->qty]);
                } else {
                    // Ambil semua data detail_po dengan id_po yang sama
                    $detail_poluar_list = DB::table('detail_poluar')->where('id_poluar', $detail_poluar->id_poluar)->get();

                    if ($detail_poluar_list->isNotEmpty()) {
                        // Kelompokkan data detail_po berdasarkan id_detail_pr
                        $grouped = $detail_poluar_list->groupBy('id_detail_pr');

                        foreach ($grouped as $id_detail_pr => $poluar_entries) {
                            // Hitung total po_qty untuk id_detail_pr tersebut
                            $total_poluar_qty = $poluar_entries->sum('poluar_qty');

                            // Ambil data detail_pr terkait
                            $detail_pr = DB::table('detail_pr')->where('id', $id_detail_pr)->first();
                            if ($detail_pr) {
                                $new_qty_poluar = ($detail_pr->qty_poluar ?? 0) + $total_poluar_qty;
                                DB::table('detail_pr')->where('id', $detail_pr->id)->update([
                                    'qty_poluar' => $new_qty_poluar
                                ]);
                            }
                        }
                    }
                }
            }
        }

        // Perbarui kolom id_po di tabel detail_pr menjadi null
        DB::table('detail_pr')->where('id_poluar', $delete_poluar_id)->update(['id_poluar' => null]);

        // Hapus data dari tabel detail_po yang memiliki id_po sesuai
        DB::table('detail_poluar')->where('id_poluar', $delete_poluar_id)->delete();

        // Setelah memperbarui detail_pr dan menghapus detail_po, hapus data dari tabel purchase_order
        $delete_poluar = DB::table('purchase_orderluar')->where('id', $delete_poluar_id)->delete();

        if ($delete_poluar) {
            return redirect()->route('purchase_orderluar.index')->with('success', 'Data PO berhasil dihapus, id_po pada detail_pr diubah menjadi null, dan detail_po berhasil dihapus');
        } else {
            return redirect()->route('purchase_orderluar.index')->with('error', 'Data PO gagal dihapus');
        }
    }
    //End Hapus Data






    // Hapus Multiple CheckBox
    public function hapusMultiplePoluar(Request $request)
    {
        if ($request->has('ids')) {
            $ids = $request->input('ids');

            // Ambil semua data detail_po yang akan dihapus
            $detail_poluar_list = DB::table('detail_poluar')->whereIn('id_poluar', $ids)->get();

            if ($detail_poluar_list->isNotEmpty()) {
                // Kelompokkan data detail_po berdasarkan id_detail_pr
                $grouped = $detail_poluar_list->groupBy('id_detail_pr');

                foreach ($grouped as $id_detail_pr => $poluar_entries) {
                    // Hitung total po_qty untuk id_detail_pr tersebut
                    $total_poluar_qty = $poluar_entries->sum('poluar_qty');

                    // Ambil data detail_pr terkait
                    $detail_pr = DB::table('detail_pr')->where('id', $id_detail_pr)->first();
                    if ($detail_pr) {
                        // Update qty_po dengan menambahkan kembali total_po_qty
                        $new_qty_poluar = ($detail_pr->qty_poluar ?? 0) + $total_poluar_qty;
                        DB::table('detail_pr')->where('id', $detail_pr->id)->update([
                            'qty_poluar' => $new_qty_poluar
                        ]);
                    }
                }
            }

            // Perbarui kolom id_po di tabel detail_pr menjadi null
            DB::table('detail_pr')
                ->whereIn('id_poluar', $ids)
                ->update(['id_poluar' => null]);

            // Hapus data dari tabel detail_po yang memiliki id_po sesuai
            DB::table('detail_poluar')
                ->whereIn('id_poluar', $ids)
                ->delete();

            // Hapus data dari tabel po
            Purchase_Orderluar::whereIn('id', $ids)->delete();

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
    //End Hapus Multiple CheckBox




    // Hapus Multiple CheckBox
    public function hapusMultipleTracking(Request $request)
    {
        if ($request->has('ids')) {
            PurchaseRequest::whereIn('id', $request->input('ids'))->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }






    //Get Detail PO
    public function getDetailPoluar(Request $request)
    {
        $id = $request->id;
        $poluar = Purchase_Orderluar::select('purchase_orderluar.*', 'vendor.nama as nama_vendor', 'kontrak.nama_pekerjaan as nama_proyek')
            ->join('vendor', 'vendor.id', '=', 'purchase_orderluar.vendor_id')
            ->leftjoin('kontrak', 'kontrak.id', '=', 'purchase_orderluar.proyek_id')
            ->where('purchase_orderluar.id', $id)
            ->first();

        $split_proyek = explode(',', $poluar->proyek_id);
        $proyek_names = Kontrak::whereIn('id', $split_proyek)->pluck('nama_pekerjaan')->toArray();
        $poluar->nama_proyek = implode(',', $proyek_names);

        $details = DetailPoluar::where('detail_poluar.id_poluar', $id)
            ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_poluar.id_detail_pr')
            ->select('detail_pr.*', 'detail_poluar.id as id_detail_poluar', 'detail_poluar.harga as harga_per_unit', 'detail_poluar.mata_uang as mata_uang', 'detail_poluar.vat as vat', 'detail_poluar.batas_akhir as batas', 'detail_poluar.poluar_qty')
            ->get();
        // Pastikan details selalu array, meskipun kosong
        $poluar->details = $details ? $details->toArray() : [];
        
        return response()->json([
            'poluar' => $poluar,
        ]);
    }
    //End Get Detail PO





    //Detail PR Save
    public function detailPrSave(Request $request)
    {
        $id_poluar = $request->id_poluar;
        $id_detail_poluar = $request->id;
        $batas = $request->batas;
        $harga_per_unit = $request->harga_per_unit;
        $mata_uang = $request->mata_uang;
        $vat = $request->vat;

        // Validasi data yang masuk
        $request->validate([
            'id' => 'required|integer',
            'id_poluar' => 'required|integer',
            'batas' => 'required',
            'harga_per_unit' => 'required|numeric',
            'mata_uang' => 'required',
            'vat' => 'required',
        ]);

        $updated = DetailPoluar::where('id', $id_detail_poluar)->update([
            'batas_akhir' => $batas,
            'harga' => $harga_per_unit,
            'mata_uang' => $mata_uang,
            'vat' => $vat,
        ]);

        if (!$updated) {
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui data'], 500);
        }

        $poluar = Purchase_Orderluar::select('purchase_orderluar.*', 'vendor.nama as nama_vendor', 'kontrak.nama_pekerjaan as nama_proyek')
            ->leftjoin('vendor', 'vendor.id', '=', 'purchase_orderluar.vendor_id')
            ->leftjoin('kontrak', 'kontrak.id', '=', 'purchase_orderluar.proyek_id')
            ->where('purchase_orderluar.id', $id_poluar)
            ->first();
        $poluar->details = DetailPoluar::where('detail_poluar.id_poluar', $poluar->id)
            ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_poluar.id_detail_pr')
            ->select('detail_pr.*', 'detail_poluar.id as id_detail_poluar', 'detail_poluar.harga as harga_per_unit', 'detail_poluar.mata_uang as mata_uang', 'detail_poluar.vat as vat', 'detail_poluar.batas_akhir as batas', 'detail_poluar.poluar_qty')
            ->get();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil menyimpan detail Purchase Order Luar!',
            'poluar' => $poluar
        ]);
    }
    //End Detail PR Save




    //Update Detail POluar
    public function updateDetailPoluar(Request $request)
    {
        $id = $request->id;
        $poluar = Purchase_Orderluar::where('id', $id)->update([
            'vendor_id' => $request->vendor_id,
            'no_poluar' => $request->no_poluar,
            'proyek_id' => $request->proyek_id,
            'pr_id' => $request->pr_id,
            'tanggal_poluar' => $request->tanggal_poluar,
            'reference' => $request->reference,
            'rfq' => $request->rfq,
            'quotation' => $request->quotation,
            'no_nego' => $request->no_nego,
            'final_quotation' => $request->final_quotation,
            'batas_poluar' => $request->batas_poluar,
            'keterangan_nama' => $request->keterangan_nama,
            'keterangan_shipment' => $request->keterangan_shipment,
            'keterangan_payment' => $request->keterangan_payment,
            'delivery' => $request->delivery,
            'shipment' => $request->shipment,
            'delivery_term' => $request->delivery_term,
            'destination' => $request->destination,
            'payment' => $request->payment,





        ]);
        return response()->json([
            'poluar' => $poluar
        ]);
    }
    //End Detail POluar



    //Hapus Detail PO
    public function destroyDetailPoluar(Request $request)
    {
        $id = $request->id;
        $id_poluar = $request->id_poluar;
        $id_detailpr = $request->id_detail_pr;

        // Ambil data qty sebelum dihapus dari detail_po
        $detail_poluar = DetailPoluar::where('id', $id)->first();

        if ($detail_poluar) {
            $poluar_qty = $detail_poluar->poluar_qty;
            $id_del_poluar = $detail_poluar->id_del_poluar;

            // Hapus data dari detail_po
            $delete_detail_poluar = DetailPoluar::where('id', $id)->delete();

            // Update qty_po di detail_pr jika id_del_po dan id_del sama
            // $update_detail_pr = DetailPR::where('id', $id_detailpr)
            //     ->where('id_del', $id_del_po)
            //     ->increment('qty_po', $po_qty);

            // Set id_po di detail_pr menjadi null
            $delete_detail_pr = DetailPR::where('id', $id_detailpr)->update([
                'id_poluar' => null
            ]);

            if ($delete_detail_poluar) {
                $poluar = Purchase_Orderluar::select('purchase_orderluar.*', 'vendor.nama as nama_vendor', 'keproyekan.nama_proyek as nama_proyek')
                    ->leftjoin('vendor', 'vendor.id', '=', 'purchase_orderluar.vendor_id')
                    ->leftjoin('keproyekan', 'keproyekan.id', '=', 'purchase_orderluar.proyek_id')
                    ->where('purchase_orderluar.id', $id_poluar)
                    ->first();

                $poluar->details = DetailPoluar::where('detail_poluar.id_poluar', $poluar->id)
                    ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_poluar.id_detail_pr')
                    ->select(
                        'detail_pr.*',
                        'detail_poluar.id as id_detail_poluar',
                        'detail_poluar.harga as harga_per_unit',
                        'detail_poluar.mata_uang as mata_uang',
                        'detail_poluar.vat as vat',
                        'detail_poluar.batas_akhir as batas',
                        'detail_poluar.poluar_qty'
                    )
                    ->get();

                return response()->json([
                    'poluar' => $poluar
                ]);
            }
        }

        return response()->json([
            'poluar' => null
        ]);
    }
    //End Hapus Detail PO





    //Test pr
    public function test_pr(Request $request)
    {
        $id_poluar = $request->id_poluar;
        $poluar = Purchase_Orderluar::select('purchase_orderluar.*', 'vendor.nama as nama_vendor', 'kontrak.nama_pekerjaan as nama_proyek')
            ->leftjoin('vendor', 'vendor.id', '=', 'purchase_orderluar.vendor_id')
            ->leftjoin('kontrak', 'kontrak.id', '=', 'purchase_orderluar.proyek_id')
            ->where('purchase_orderluar.id', $id_poluar)
            ->first();
        $poluar->details = DetailPoluar::where('detail_poluar.id_poluar', $poluar->id)
            ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_poluar.id_detail_pr')
            ->select('detail_pr.*', 'detail_poluar.id as id_detail_poluar', 'detail_poluar.harga as harga_per_unit', 'detail_poluar.mata_uang as mata_uang', 'detail_poluar.vat as vat', 'detail_poluar.batas_akhir as batas')
            ->get();
        return response()->json([
            'poluar' => $poluar
        ]);
    }
    //End Test pr






    function tambahDetailPoluar(Request $request)
    {
        $id = $request->id_poluar;
        $selected = $request->selected;

        // Fetch the updated purchase order data
        $poluar = Purchase_Orderluar::leftjoin('kontrak', 'kontrak.id', '=', 'purchase_orderluar.proyek_id')
            ->leftjoin('purchase_request', 'purchase_request.id', '=', 'purchase_orderluar.pr_id')
            ->leftjoin('vendor', 'vendor.id', '=', 'purchase_orderluar.vendor_id')
            ->select('purchase_orderluar.*', 'kontrak.*', 'vendor.*', 'purchase_request.*', 'purchase_orderluar.id as id_poluar')
            ->where('purchase_orderluar.id', $id)
            ->first();

        $details = DetailPoluar::where('detail_poluar.id_poluar', $poluar->id_poluar)
            ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_poluar.id_detail_pr')
            ->select(
                'detail_pr.*',
                'detail_poluar.id as id_detail_poluar',
                'detail_poluar.harga as harga_per_unit',
                'detail_poluar.mata_uang as mata_uang',
                'detail_poluar.vat as vat',
                'detail_poluar.batas_akhir as batas',
                'detail_poluar.poluar_qty'
            )
            ->get();
        // Pastikan details selalu array, meskipun kosong
        $poluar->details = $details ? $details->toArray() : [];

        return response()->json([
            'poluar' => $poluar
        ]);
    }
    //End tambahDetailPoluar




    //Qty Poluar Save
    public function QtyPoluarSave(Request $request)
    {
        // Validasi array
        $request->validate([
            'data' => 'required|array',
            'data.*.id' => 'required|integer',
            'data.*.qty_poluar1' => 'required|numeric'
        ]);

        foreach ($request->data as $item) {
            $poluarDetail = DetailPR::find($item['id']);

            if (!$poluarDetail) continue;

            // Pastikan qty2 tidak lebih besar dari qty_spph
            // if ($poDetail->qty < $item['qty_po1']) {
            //     return response()->json(['error' => 'Qty tidak boleh lebih besar dari Qty1'], 400);
            // }

            // Update data
            // $poDetail->qty_po -= $item['qty_po1'];
            // $poDetail->qty_po1 = $item['qty_po1'];
            // $poDetail->save();

            $detailPoluar = DetailPoluar::create([
                'id_poluar' => $item['id_poluar'],
                'id_detail_pr' => $item['id'],
                'poluar_qty' => $item['qty_poluar1'],
                'id_del_poluar' => 0,
            ]);
        }

        return response()->json(['success' => true]);
    }
    //End Qty Poluar Save















    //Tracking
    public function tracking(Request $request)
    {
        $search = $request->q;

        if (Session::has('selected_warehouse_id')) {
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $requests = PurchaseRequest::select('purchase_request.*', 'kontrak.nama_pekerjaan as proyek_name')
            ->join('kontrak', 'kontrak.id', '=', 'purchase_request.proyek_id')
            ->paginate(50);

        $proyeks = DB::table('kontrak')->get();

        if ($search) {
            $requests = PurchaseRequest::where('nama_pekerjaan', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == "json") {
            $requests = PurchaseRequest::where("warehouse_id", $warehouse_id)->get();

            return response()->json($requests);
        } else {
            return view('admin.trackingpr', compact('requests', 'proyeks'));
        }
    }
    //End Tracking



    //Trackingwilayah
    public function trackingwil(Request $request)
    {
        $search = $request->q;

        if (Session::has('selected_warehouse_id')) {
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $requests = PurchaseRequest::select('purchase_request.*', 'kontrak.nama_pekerjaan as proyek_name')
            ->join('kontrak', 'kontrak.id', '=', 'purchase_request.proyek_id')
            ->paginate(50);

        $proyeks = DB::table('kontrak')->get();

        if ($search) {
            $requests = PurchaseRequest::where('nama_pekerjaan', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == "json") {
            $requests = PurchaseRequest::where("warehouse_id", $warehouse_id)->get();

            return response()->json($requests);
        } else {
            return view('admin.trackingwil', compact('requests', 'proyeks'));
        }
    }
    //End Trackingwilayah





    public function getByIdspo(Request $request)
    {
        $prIds = explode(',', $request->pr_ids);
        $purchaseRequests = PurchaseRequest::whereIn('id', $prIds)->get(['id', 'no_pr']);

        return response()->json($purchaseRequests);
    }




    public function cetakPoluar(Request $request)
    {
        $id = $request->id_poluar;
        $currency = $request->currency;
        $poluar = Purchase_Orderluar::select(
            'purchase_orderluar.*',
            'vendor.nama as nama_vendor',
            'vendor.alamat as alamat_vendor',
            'vendor.telp as telp_vendor',
            'vendor.email as email_vendor',
            'vendor.fax as fax_vendor',
            'vendor.cp as cp_vendor',
            'kontrak.nama_pekerjaan as nama_proyek',
            'purchase_request.no_pr as pr_no'
        )
            ->leftJoin('vendor', 'vendor.id', '=', 'purchase_orderluar.vendor_id')
            ->leftJoin('kontrak', 'kontrak.id', '=', 'purchase_orderluar.proyek_id')
            ->leftJoin('purchase_request', 'purchase_request.id', '=', 'purchase_orderluar.pr_id')
            ->where('purchase_orderluar.id', $id)
            ->first();

        if (!$poluar) {
            return back()->withErrors('Data PO tidak ditemukan');
        }

        $poluar->batas_poluar = Carbon::parse($poluar->batas_poluar)->isoFormat('D MMMM Y');
        $poluar->tanggal_poluar = Carbon::parse($poluar->tanggal_poluar)->isoFormat('D MMMM Y');

        $poluar->details = DetailPoluar::where('detail_poluar.id_poluar', $poluar->id)
            ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_poluar.id_detail_pr')
            ->select(
                'detail_pr.*',
                'detail_poluar.id as id_detail_poluar',
                'detail_poluar.harga as harga_per_unit',
                'detail_poluar.mata_uang as mata_uang',
                'detail_poluar.vat as vat',
                'detail_poluar.batas_akhir as batas',
                'detail_poluar.poluar_qty'
            )
            ->get();

        // Pastikan ada data sebelum diakses
        if ($poluar->details->isNotEmpty()) {
            $poluar->details = $poluar->details->map(function ($detail) {
                $detail->no_pr = optional(PurchaseRequest::find($detail->id_pr))->no_pr;
                $detail->no_just = optional(DetailPR::find($detail->id))->no_just;
                $detail->no_sph = optional(DetailPR::find($detail->id))->no_sph;
                $detail->no_nego = optional(DetailPR::find($detail->id))->no_nego1;
                return $detail;
            });

            $poluar->no_pr = $poluar->details->pluck('no_pr')->unique()->implode(', ');
        } else {
            $poluar->no_pr = '-';
        }



        $symbol = match ($currency) {
            'USD' => '$',          // Amerika Serikat
            'EUR' => '€',          // Euro (Eropa)
            'IDR' => 'Rp',         // Indonesia
            'JPY' => '¥',          // Jepang
            'AUD' => 'A$',         // Australia
            'CNY' => '¥',          // China (Yuan)
            'PHP' => '₱',          // Filipina
            'INR' => '₹',          // India
            'KRW' => '₩',          // Korea Selatan
            'SAR' => '﷼',          // Arab Saudi (Riyal)
            'MYR' => 'RM',         // Malaysia
            'ARS' => '$',          // Argentina
            'BRL' => 'R$',         // Brazil
            'THB' => '฿',          // Thailand (Baht)
            'KHR' => '៛',          // Kamboja (Riel)
            'IRR' => '﷼',          // Iran (Rial)
            'BND' => 'B$',         // Brunei (Dollar)
            'QAR' => '﷼',          // Qatar (Riyal)

            // Eropa (negara-negara Euro)
            'DE' => '€',           // Jerman
            'FR' => '€',           // Prancis
            'IT' => '€',           // Italia
            'ES' => '€',           // Spanyol
            'PT' => '€',           // Portugal

            default => '',
        };

        $currentPr = PurchaseRequest::whereIn('id', explode(',', $poluar->pr_id))->get();
        $poluar->no_pr = $currentPr->pluck('no_pr')->implode(', ');

        // Pastikan variabel angka tidak bernilai null
        $poluar->subtotal = $poluar->details->sum(function ($detail) {
            return (float) ($detail->harga_per_unit * $detail->poluar_qty);
        });

        $poluar->ongkos = (float) ($poluar->ongkos ?? 0);
        $poluar->asuransi = (float) ($poluar->asuransi ?? 0);
        $poluar->total = $poluar->subtotal + $poluar->ongkos + $poluar->asuransi;

        $split_proyek = explode(',', $poluar->proyek_id);
        $proyek_names = Kontrak::whereIn('id', $split_proyek)->pluck('nama_pekerjaan')->toArray();
        $poluar->proyek = implode(', ', $proyek_names);

        // Tambahkan ini
        $count = $poluar->details->count();

        $pdf = PDF::loadView('purchase_orderluar.poluar_print', compact('poluar', 'symbol'));
        $pdf->setPaper('A4', 'potrait');

        $nama = $poluar->nama_proyek ?? 'Unknown';
        $no = $poluar->no_poluar ?? 'Unknown';

        return $pdf->stream('PO-' . $nama . '(' . $no . ')' . '.pdf');
    }
    //End Cetak PO



    // public function cetakPoluar(Request $request)
    // {
    //     $id = $request->poluar_id;
    //     $currency = $request->currency;

    //     $poluar = Purchase_Orderluar::where('id', $id)->first();
    //     $poluar->details = DetailPoluar::where('poluar_id', $id)
    //         ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_poluar.id_detail_pr')
    //         ->select('detail_pr.*', 'detail_poluar.id as id_detail_poluar', 'detail_poluar.harga as harga_per_unit', 'detail_poluar.poluar_qty')
    //         ->get();

    //     $poluar->tanggal_poluar = Carbon::parse($poluar->tanggal_poluar)->isoFormat('D MMMM Y');
    //     $poluar->batas_poluar = Carbon::parse($poluar->batas_poluar)->isoFormat('D MMMM Y');

    //     $vendor = json_decode($poluar->vendor_id);
    //     $vendor_name = Vendor::whereIn('id', $vendor)->pluck('nama')->toArray();
    //     $vendor_alamat = Vendor::whereIn('id', $vendor)->pluck('alamat')->toArray();
    //     $vendor_telp = Vendor::whereIn('id', $vendor)->pluck('telp')->toArray();
    //     $vendor_fax = Vendor::whereIn('id', $vendor)->pluck('fax')->toArray();
    //     $vendor_email = Vendor::whereIn('id', $vendor)->pluck('email')->toArray();
    //     $vendor_cp = Vendor::whereIn('id', $vendor)->pluck('cp')->toArray();

    //     $newObjects = [];
    //     foreach ($vendor_name as $key => $value) {
    //         $newObject = new \stdClass();
    //         $newObject->nama = $value;
    //         $newObject->alamat = $vendor_alamat[$key];
    //         $newObject->telp = $vendor_telp[$key] ?? '-';
    //         $newObject->fax = $vendor_fax[$key] ?? '-';
    //         $newObject->email = $vendor_email[$key] ?? '-';
    //         $newObject->cp = $vendor_cp[$key] ?? '-';
    //         array_push($newObjects, $newObject);
    //     }


    //     $symbol = match($currency) {
    //         'USD' => '$',          // Amerika Serikat
    //         'EUR' => '€',          // Euro (Eropa)
    //         'IDR' => 'Rp',         // Indonesia
    //         'JPY' => '¥',          // Jepang
    //         'AUD' => 'A$',         // Australia
    //         'CNY' => '¥',          // China (Yuan)
    //         'PHP' => '₱',          // Filipina
    //         'INR' => '₹',          // India
    //         'KRW' => '₩',          // Korea Selatan
    //         'SAR' => '﷼',          // Arab Saudi (Riyal)
    //         'MYR' => 'RM',         // Malaysia
    //         'ARS' => '$',          // Argentina
    //         'BRL' => 'R$',         // Brazil
    //         'THB' => '฿',          // Thailand (Baht)
    //         'KHR' => '៛',          // Kamboja (Riel)
    //         'IRR' => '﷼',          // Iran (Rial)
    //         'BND' => 'B$',         // Brunei (Dollar)
    //         'QAR' => '﷼',          // Qatar (Riyal)

    //         // Eropa (negara-negara Euro)
    //         'DE' => '€',           // Jerman
    //         'FR' => '€',           // Prancis
    //         'IT' => '€',           // Italia
    //         'ES' => '€',           // Spanyol
    //         'PT' => '€',           // Portugal

    //         default => '',
    //     };



    //     // $lampiran = NegoluarLampiran::where('negoluar_id', $negoluar->id)->get();
    //     // $negoluar->lampiran = $lampiran->count();
    //     $poluars = $newObjects;
    //     $count = count($poluars);

    //     // ✅ 1. Generate PDF utama (nego)
    //     $pdf = PDF::loadView('purchase_orderluar.poluar_print', compact('poluar', 'poluars', 'count','currency', 'symbol'));
    //     $pdfPath = storage_path('app/temp_po.pdf');
    //     $pdf->save($pdfPath);

    //     // ✅ 2. Buat FPDI untuk menggabungkan dokumen
    //     // $fpdi = new FPDI();
    //     // $fpdi->setSourceFile($pdfPath);
    //     // $tplIdx = $fpdi->importPage(1);
    //     // $fpdi->AddPage();
    //     // $fpdi->useTemplate($tplIdx, 10, 10, 190);

    //     // foreach ($lampiran as $file) {
    //     //     $filePath = public_path("/lampiran/{$file->file}");
    //     //     if (file_exists($filePath)) {
    //     //         $pageCount = $fpdi->setSourceFile($filePath);
    //     //         for ($i = 1; $i <= $pageCount; $i++) {
    //     //             $tplIdx = $fpdi->importPage($i);
    //     //             $size = $fpdi->getTemplateSize($tplIdx);

    //     //             // Deteksi orientasi berdasarkan ukuran halaman
    //     //             $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';

    //     //             $fpdi->AddPage($orientation);

    //     //             // Hitung scaling agar sesuai dengan halaman A4
    //     //             $pageWidth = $orientation === 'L' ? 297 : 210; // A4 Landscape = 297mm, Portrait = 210mm
    //     //             $pageHeight = $orientation === 'L' ? 210 : 297; // A4 Landscape = 210mm, Portrait = 297mm
    //     //             $scaleX = $pageWidth / $size['width'];
    //     //             $scaleY = $pageHeight / $size['height'];
    //     //             $scale = min($scaleX, $scaleY); // Ambil skala yang lebih kecil agar tetap proporsional

    //     //             // Posisikan gambar agar pas di tengah halaman
    //     //             $x = ($pageWidth - ($size['width'] * $scale)) / 2;
    //     //             $y = ($pageHeight - ($size['height'] * $scale)) / 2;

    //     //             $fpdi->useTemplate($tplIdx, $x, $y, $size['width'] * $scale, $size['height'] * $scale);
    //     //         }
    //     //     }
    //     // }

    //     // // ✅ 4. Simpan hasil PDF yang sudah digabungkan
    //     // $outputPath = storage_path("app/merged_nego.pdf");
    //     // $fpdi->Output($outputPath, 'F');

    //     // // ✅ 5. Kirimkan hasil PDF ke browser
    //     // return response()->file($outputPath, [
    //     //     'Content-Type' => 'application/pdf',
    //     //     'Content-Disposition' => 'inline; filename="NEGO_' . $negoluar->nomor_negoluar . '.pdf"',
    //     // ]);
    // }






    //Detail Product
    public function getProductPR(Request $request)
    {
        // dd($request);
        $id_pr = $request->id_pr; // Ambil id_pr dari request
        $id_pr = explode(',', $id_pr);
        $proyek = strtolower($request->proyek);

        // Ambil DetailPR yang sesuai dengan id_pr
        $products = DetailPR::whereIn('id_pr', $id_pr)->get();


        // Proses setiap produk
        $products = $products->map(function ($item) {
            $item->spek = $item->spek ? $item->spek : '';
            $item->keterangan = $item->keterangan ? $item->keterangan : '';
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            $item->nomor_nego = Nego::where('id', $item->id_nego)->first()->nomor_nego ?? '';
            $item->nomor_spph = Spph::where('id', $item->spph_id)->first()->nomor_spph ?? '';
            $item->pr_no = PurchaseRequest::where('id', $item->id_pr)->first()->no_pr ?? '';
            $item->poluar_no = Purchase_Orderluar::where('id', $item->id_poluar)->first()->no_poluar ?? '';
            $item->nama_pekerjaan = Kontrak::where('id', $item->id_proyek)->first()->nama_pekerjaan ?? '';

            // Baru, hitung sisa Nego by QTY asli - jumlah di DetailNego by id_pr_detail
            $item->qty_poluar = $item->qty - DetailPoluar::where('id_detail_pr', $item->id)->sum('poluar_qty');
            $item->qty_poluar1 = 0;
            return $item;
        });

        // Filter produk berdasarkan nama proyek
        $products = $products->filter(function ($item) use ($proyek) {
            return strpos(strtolower($item->nama_pekerjaan), $proyek) !== false;
        });

        // Kembalikan hasil dalam bentuk JSON
        return response()->json([
            'products' => $products
        ]);
    }
    //End Detail Product





}
