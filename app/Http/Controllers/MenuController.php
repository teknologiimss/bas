<?php

namespace App\Http\Controllers;

use App\Models\DetailPR;
use App\Models\Keproyekan;
use App\Models\PurchaseRequest;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class MenuController extends Controller
{


    public function getWarehouse()
    {
        $controller = new ProductController;
        return $controller->getWarehouse();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouse = $this->getWarehouse();

        // Menghitung jumlah data pada tanggal yang sama dengan tanggal hari ini
        // $jumlahDataHariIni = SuratMasuk::whereDate('tanggalMasuk', Carbon::today())->count();

        // // Mengambil 5 data terbaru SuratMasuk
        // $suratMasuks = SuratMasuk::orderBy('id', 'desc')->take(10)->get();

        // Mengambil seluruh data PurchaseRequest beserta nama_proyek menggunakan join
        // Ambil semua id_pr dari DetailPr yang memiliki status 1
        $details = DetailPR::where('status', 1)->pluck('id_pr')->unique();

        // Ambil purchase_request yang id-nya ada di dalam $details
        $purchaseRequests = PurchaseRequest::join('kontrak', 'purchase_request.proyek_id', '=', 'kontrak.id')
            ->whereIn('purchase_request.id', $details)
            ->select('purchase_request.*', 'kontrak.nama_pekerjaan')
            ->orderBy('purchase_request.id', 'desc')
            ->get();

        // Hitung jumlah purchase_request yang sesuai
        $totalPurchaseRequests = $purchaseRequests->count();

        // Debug untuk memastikan hasilnya
        // dd($totalPurchaseRequests, $purchaseRequests);

        // Mengambil seluruh data DetailPr
        $detailPrs = DetailPR::all();

        // Mengambil seluruh data Keproyekan
        $keproyekans = Keproyekan::all();


        return View::make("menu")->with(compact('warehouse', 'purchaseRequests', 'detailPrs', 'keproyekans', 'totalPurchaseRequests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
