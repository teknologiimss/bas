<?php

namespace App\Http\Controllers;

use App\Models\DetailPR;
use App\Models\Karyawan;
use App\Models\Keproyekan;
use App\Models\Kontrak;
use App\Models\Monitoring;
use App\Models\Purchase_Order;
use App\Models\PurchaseRequest;
// use App\Models\SuratMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function getWarehouse()
    {
        $controller = new ProductController;
        return $controller->getWarehouse();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
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
        $details = DetailPr::where('status', 1)->pluck('id_pr')->unique();

        // Ambil purchase_request yang id-nya ada di dalam $details
        $purchaseRequests = PurchaseRequest::join('kontrak', 'purchase_request.proyek_id', '=', 'kontrak.id')
            ->whereIn('purchase_request.id', $details)
            ->select('purchase_request.*', 'kontrak.nama_pekerjaan')
            ->orderBy('purchase_request.id', 'desc')
            ->get();

        $poPrPerProyek = Kontrak::leftJoin('purchase_request', 'kontrak.id', '=', 'purchase_request.proyek_id')
            ->leftJoin('purchase_order', 'kontrak.id', '=', 'purchase_order.proyek_id')
            ->select(
                'kontrak.nama_pekerjaan',
                \DB::raw('COUNT(DISTINCT purchase_order.id) as total_po'),
                \DB::raw('COUNT(DISTINCT purchase_request.id) as total_pr')
            )
            ->groupBy('kontrak.nama_pekerjaan')
            ->orderBy('kontrak.nama_pekerjaan')
            ->get();

        // Hitung jumlah purchase_request yang sesuai
        $totalPurchaseRequests = $purchaseRequests->count();

        // Debug untuk memastikan hasilnya
        // dd($totalPurchaseRequests, $purchaseRequests);

        // Mengambil seluruh data DetailPr
        $detailPrs = DetailPr::all();

        // Mengambil seluruh data Keproyekan
        $keproyekans = Keproyekan::all();

        // ✅ Tambahan perhitungan Lokasi Kerja
        $lokasiKerjaCounts = Karyawan::select('lokasi_kerja')
            ->selectRaw('count(*) as jumlah')
            ->groupBy('lokasi_kerja')
            ->pluck('jumlah', 'lokasi_kerja')
            ->toArray();

        // === HITUNG JUMLAH PO & PR DI SINI ===
        // pakai model (jika ada)
        $poCount = Purchase_Order::count();
        $prCount = PurchaseRequest::count();

        // $kontraks = Kontrak::select('nama_pekerjaan', 'status')->get();

        $kontraks = Kontrak::all();
        // Pastikan nilai_pekerjaan selalu numerik
        $totalNilaiPekerjaan = $kontraks->sum(function ($item) {
            return (float) $item->nilai_pekerjaan;
        });

        // ✅ Tambahan perhitungan jenis kelamin
        $maleCount = Karyawan::where('jenis_kelamin', 'Laki-laki')->count();
        $femaleCount = Karyawan::where('jenis_kelamin', 'Perempuan')->count();

        // Hitung status pegawai (group by)
        $statusCounts = Karyawan::select('status_pegawai', \DB::raw('COUNT(*) as total'))
            ->groupBy('status_pegawai')
            ->pluck('total', 'status_pegawai')
            ->toArray();

        $nilaiPekerjaanCounts = Kontrak::select('nama_pekerjaan')
            ->selectRaw('SUM(nilai_pekerjaan) as total_nilai')
            ->groupBy('nama_pekerjaan')
            ->pluck('total_nilai', 'nama_pekerjaan')
            ->toArray();

        $nilaiPekerjaanPerTahun = Kontrak::select(
            'tahun',
            'nama_pekerjaan',
            \DB::raw('SUM(nilai_pekerjaan) as total_nilai')
        )
            ->groupBy('tahun', 'nama_pekerjaan')
            ->orderBy('tahun')
            ->orderBy('nama_pekerjaan')
            ->get();

        $pelangganCounts = Kontrak::select('nama_pelanggan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('nama_pelanggan')
            ->pluck('total', 'nama_pelanggan')
            ->toArray();

        $kontrakPerTahun = Kontrak::select('tahun')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->pluck('total', 'tahun')
            ->toArray();

        $mroData = Monitoring::select(
            'po_nota_dinas',
            'nama_pekerjaan',
            'progress'
        )
            ->orderBy('progress')
            ->get();

        $statusPerProyek = DB::table('monitorings')
            ->join('proyeks', 'monitorings.proyek_id', '=', 'proyeks.id')
            ->select(
                'proyeks.nama_proyek',
                DB::raw("SUM(CASE WHEN monitorings.status = 'Open' THEN 1 ELSE 0 END) as open_count"),
                DB::raw("SUM(CASE WHEN monitorings.status = 'Closed' THEN 1 ELSE 0 END) as closed_count")
            )
            ->groupBy('proyeks.nama_proyek')
            ->get();

        return View::make('home')->with(compact(
            'warehouse',
            'purchaseRequests',
            'detailPrs',
            'keproyekans',
            'totalPurchaseRequests',
            'lokasiKerjaCounts',
            'poCount',
            'prCount',
            'kontraks',
            'totalNilaiPekerjaan',
            'maleCount',
            'femaleCount',
            'statusCounts',
            'nilaiPekerjaanCounts',
            'poPrPerProyek',
            'nilaiPekerjaanPerTahun',
            'pelangganCounts',
            'kontrakPerTahun',
            'mroData',
            'statusPerProyek',
        ));
    }

    public function unauthorized()
    {
        return view('home.unauthorized');
    }

    public function indexAwal()
    {
        $menus = [
            [
                'name' => 'Logistik',
                // 'route' => 'apps/spph',
                'route' => 'div/logistik',
                'bgcolor' => 'sagegreen',
                'icon' => 'box',
                'img' => asset('img/logistik.png')
            ],
            [
                'name' => 'Wilayah 1',
                // 'route' => 'apps/purchase_request',
                'route' => 'div/wilayah1',
                'bgcolor' => 'red',
                'icon' => 'map-marker-alt',
                'img' => asset('img/wilayah1.png')
            ],
            [
                'name' => 'Wilayah 2',
                // 'route' => 'apps/purchase_request',
                'route' => 'div/wilayah2',
                'bgcolor' => 'goldenrod',
                'icon' => 'map',
                'img' => asset('img/wilayah2.png')
            ],
            [
                'name' => 'Gudang',
                'route' => 'div/gudang',
                'bgcolor' => 'blue',
                'icon' => 'warehouse',
                'img' => asset('img/warehouse.png')
            ],
            // [
            //     'name' => 'Engineer',
            //     // 'route' => 'apps/purchase_request',
            //     'route' => 'div/eng',
            //     'bgcolor' => 'violet',
            //     'icon' => 'wrench',
            //     'img' => asset('img/eng.png')
            // ],
            // [
            //     'name' => 'Surat Keluar',
            //     'route' => 'apps/surat-keluar',
            //     'bgcolor' => 'green',
            //     'icon' => 'envelope',
            //     'img' => asset('public/img/suratkeluar.png')
            // ],
        ];

        // $menus2 = [
        //     [
        //         'name' => 'Surat Keluar',
        //         'route' => 'apps/surat-keluar',
        //         'bgcolor' => 'green',
        //         'icon' => 'envelope'
        //     ],
        //     // [
        //     //     'name' => 'Peraturan Direksi',
        //     //     // 'route' => 'apps/spph',
        //     //     'route' => 'apps/peraturan-direksi',
        //     //     'bgcolor' => 'violet',
        //     //     'icon' => 'gavel'
        //     // ],
        // ];

        return view('home.dashboard', compact('menus'));
    }

    public function appType($type)
    {
        if ($type == 'logistik') {
            $menus = [
                [
                    'name' => 'Purchase Request',
                    'route' => 'apps/purchase_request',
                    'bgcolor' => 'sagegreen',
                    'icon' => 'cart-arrow-down'
                ],
                [
                    'name' => 'SPPH',
                    'route' => 'apps/spph',
                    'bgcolor' => 'orange',
                    'icon' => 'mail-bulk'
                ],
                [
                    'name' => 'Tracking Purchase Request',
                    'route' => 'apps/purchase_request',
                    'bgcolor' => 'red',
                    'icon' => 'route',
                    'font-size' => '1px'
                ],
                [
                    'name' => 'Purchase Order',
                    'route' => 'apps/purchase_orders',
                    'bgcolor' => 'chocolate',
                    'icon' => 'hand-holding-usd'
                ],
            ];
            $title = 'Logistik';
        } else if ($type == 'gudang') {
            $menus = [
                // [
                //     'name' => 'Purchase Order',
                //     'route' => 'apps/purchase_orders',
                //     'bgcolor' => 'sagegreen',
                //     'icon' => 'hand-holding-usd'
                // ],
                [
                    'name' => 'Surat Jalan',
                    'route' => 'apps/surat_jalan',
                    'bgcolor' => 'orange',
                    'icon' => 'mail-bulk'
                ],
                [
                    'name' => 'Stok Barang',
                    'route' => 'apps/products',
                    'bgcolor' => 'orange',
                    'icon' => 'warehouse'
                ],
                // [
                //     'name' => 'Stock IN',
                //     'route' => 'apps/products/stockUpdate',
                //     'bgcolor' => 'blue',
                //     'icon' => 'warehouse'
                // ],
                // [
                //     'name' => 'Stock OUT',
                //     'route' => 'apps/stock_out',
                //     'bgcolor' => 'red',
                //     'icon' => 'map-marker-alt'
                // ],
                // [
                //     'name' => 'Retur',
                //     'route' => 'apps/retur',
                //     'bgcolor' => 'goldenrod',
                //     'icon' => 'retweet'
                // ]
            ];
            $title = 'Gudang';
        } else if ($type == 'wilayah1') {
            $menus = [
                [
                    'name' => 'Purchase Request',
                    'route' => 'apps/purchase_request',
                    'bgcolor' => 'sagegreen',
                    'icon' => 'cart-arrow-down'
                ],
                [
                    'name' => 'Tracking Purchase Request',
                    'route' => 'apps/purchase_request',
                    'bgcolor' => 'red',
                    'icon' => 'route'
                ]
            ];
            $title = 'Wilayah 1';
        } else if ($type == 'wilayah2') {
            $menus = [
                [
                    'name' => 'Purchase Request',
                    'route' => 'apps/purchase_request',
                    'bgcolor' => 'sagegreen',
                    'icon' => 'cart-arrow-down'
                ],
                [
                    'name' => 'Tracking Purchase Request',
                    'route' => 'apps/purchase_request',
                    'bgcolor' => 'red',
                    'icon' => 'route'
                ]
            ];
            $title = 'Wilayah 2';
        } else if ($type == 'eng') {
            $menus = [
                [
                    'name' => 'Justifikasi',
                    'route' => 'apps/justifikasi',
                    'bgcolor' => 'sagegreen',
                    'icon' => 'folder-open'
                ],
                [
                    'name' => 'Tracking Purchase Request',
                    'route' => 'apps/purchase_request',
                    'bgcolor' => 'red',
                    'icon' => 'route'
                ]
            ];
            $title = 'Engineer';
        }

        return view('home.tipe', compact('menus', 'title'));
    }
}
