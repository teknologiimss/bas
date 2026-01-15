<?php

namespace App\Http\Controllers;

use App\Models\DetailLoi;
use App\Models\DetailLoiluar;
use App\Models\DetailNego;
use App\Models\DetailNegoluar;
use App\Models\DetailPo;
use App\Models\DetailPoluar;
use App\Models\DetailPR;
use App\Models\DetailSpph;
use App\Models\DetailSpphrfq;
use App\Models\Keproyekan;
use App\Models\Kontrak;
use App\Models\Lppb;
use App\Models\Notification;
use App\Models\PenerimaanBarang;
use App\Models\PrLampiran;
use App\Models\Purchase_Order;
use App\Models\Purchase_Orderluar;
use App\Models\PurchaseRequest;
use App\Models\RegistrasiBarang;
use App\Models\Spph;
use App\Models\User;
use App\Models\Vendor;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use setasign\Fpdi\Fpdi;
use stdClass;

class PurchaseRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Request $request)
    // {
    //     $search = $request->q;
    //     $warehouse_id = Session::get('selected_warehouse_id')
    //         ?? DB::table('warehouse')->first()->warehouse_id;
    //     $requests = PurchaseRequest::select('purchase_request.*', 'kontrak.nama_pekerjaan as proyek_name')
    //         ->join('kontrak', 'kontrak.id', '=', 'purchase_request.proyek_id')
    //         ->orderBy('purchase_request.id', 'asc')
    //         ->paginate(10);
    //     $proyeks = DB::table('kontrak')->get();
    //     // 🔹 Tambahkan lampiran untuk setiap request
    //     foreach ($requests as $item) {
    //         $lampiran = PrLampiran::where('pr_id', $item->id)->pluck('file')->toArray();
    //         $item->lampiran = implode(', ', $lampiran);
    //     }
    //     if ($search) {
    //         $requests = PurchaseRequest::where('nama_pekerjaan', 'LIKE', "%$search%")->paginate(10);
    //     }
    //     if ($request->format == 'json') {
    //         $requests = PurchaseRequest::where('warehouse_id', $warehouse_id)->get();
    //         return response()->json($requests);
    //     } else {
    //         foreach ($requests as $request) {
    //             $detail_pr = DetailPR::where('id_pr', $request->id)->get();
    //             if ($detail_pr->isEmpty()) {
    //                 $request->editable = true;
    //             } else {
    //                 foreach ($detail_pr as $detail) {
    //                     $detail_spph = DetailSpph::where('id_detail_pr', $detail->id)->first();
    //                     $po = Purchase_Order::where('id', $detail->id_po)->first();
    //                     if ($po && $po->tipe == '1') {
    //                         $request->editable = false;
    //                         break;
    //                     } else {
    //                         $request->editable = !$detail_spph;
    //                     }
    //                 }
    //             }
    //         }
    //         return view('purchase_request.purchase_request', compact('requests', 'proyeks'));
    //     }
    // }
    public function index(Request $request)
    {
        $search = $request->q;
        $user = Auth::user();

        $warehouse_id = Session::get('selected_warehouse_id')
            ?? DB::table('warehouse')->first()->warehouse_id;

        // 🔹 QUERY UTAMA
        $requests = PurchaseRequest::select(
            'purchase_request.*',
            'kontrak.nama_pekerjaan as proyek_name'
        )
            ->join('kontrak', 'kontrak.id', '=', 'purchase_request.proyek_id');

        // 🔐 FILTER BERDASARKAN ROLE
        if ($user->role == 2) {
            // WILAYAH 1
            $requests->whereRaw('LOWER(purchase_request.no_pr) LIKE ?', ['%wil1%']);
        } elseif ($user->role == 3) {
            // WILAYAH 2
            $requests->whereRaw('LOWER(purchase_request.no_pr) LIKE ?', ['%wil2%']);
        } elseif ($user->role == 14) {
            // MRO
            $requests->whereRaw('LOWER(purchase_request.no_pr) LIKE ?', ['%mro%']);
        } elseif ($user->role == 0) {
            // ADMIN → tampil semua
        } else {
            // Role tidak dikenal
            $requests->whereRaw('0=1');
        }

        // 🔍 SEARCH (OPSIONAL)
        if ($search) {
            $requests->where('kontrak.nama_pekerjaan', 'LIKE', "%$search%");
        }

        // 🔃 PAGINATION
        $requests = $requests
            ->orderBy('purchase_request.id', 'desc')
            ->paginate(10);

        $proyeks = DB::table('kontrak')->get();

        // 📎 LAMPIRAN
        foreach ($requests as $item) {
            $lampiran = PrLampiran::where('pr_id', $item->id)
                ->pluck('file')
                ->toArray();
            $item->lampiran = implode(', ', $lampiran);
        }

        // ✏️ EDITABLE
        foreach ($requests as $request) {
            $detail_pr = DetailPR::where('id_pr', $request->id)->get();

            if ($detail_pr->isEmpty()) {
                $request->editable = true;
            } else {
                foreach ($detail_pr as $detail) {
                    $detail_spph = DetailSpph::where('id_detail_pr', $detail->id)->first();
                    $po = Purchase_Order::where('id', $detail->id_po)->first();

                    if ($po && $po->tipe == '1') {
                        $request->editable = false;
                        break;
                    } else {
                        $request->editable = !$detail_spph;
                    }
                }
            }
        }

        return view('purchase_request.purchase_request', compact('requests', 'proyeks'));
    }

    public function indexApps(Request $request)
    {
        $search = $request->q;
        $purchaseRequests = PurchaseRequest::with('lampiran')->get();

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

        if ($request->format == 'json') {
            $requests = PurchaseRequest::where('warehouse_id', $warehouse_id)->get();

            return response()->json($requests);
        } else {
            return view('home.apps.wilayah.purchase_request', compact('requests', 'proyeks', 'purchaseRequests'));
        }
    }

    // public function indexPr()
    // {
    //     $user = Auth::user();
    //     $requests = PurchaseRequest::query();

    //     if ($user->role == 2) {
    //         // Pengguna dari Wilayah 1
    //         $requests->where('no_pr', 'like', '%WIL1%');
    //     } elseif ($user->role == 3) {
    //         // Pengguna dari Wilayah 2
    //         $requests->where('no_pr', 'like', '%WIL2%');
    //     } elseif ($user->role == 14) {
    //         // Pengguna dari MRO
    //         $requests->where('no_pr', 'like', '%MRO%');
    //     } elseif ($user->role == 0) {
    //         // Admin, tampilkan semua data
    //         // Tidak ada filter tambahan
    //     } else {
    //         // Role tidak dikenali, jangan tampilkan apapun
    //         $requests->whereRaw('0 = 1');
    //     }

    //     $requests = $requests->paginate(10);  // Ambil hasil query

    //     return view('purchase_requests.index', compact('requests'));
    // }

    // Status Proses di Purchase Request contoh 0/100
    public function getQtyStatus($id, $item)
    {
        // Relasi ke detail LOI dan menjumlahkan loi_qty
        $item->selisih_qty_loi = DetailLoi::where('id_detail_pr', $item->id)->sum('loi_qty');

        $item->selisih_qty = DetailSpph::where('id_detail_pr', $item->id)->sum('spph_qty');

        $item->selisih_qty_spphrfq = DetailSpphrfq::where('id_detail_pr', $item->id)->sum('spphrfq_qty');

        $item->selisih_qty_nego = DetailNego::where('id_detail_pr', $item->id)->sum('nego_qty');

        $item->selisih_qty_negoluar = DetailNegoluar::where('id_detail_pr', $item->id)->sum('negoluar_qty');

        $item->selisih_qty_po = DetailPo::where('id_detail_pr', $item->id)->sum('po_qty');

        $item->selisih_qty_poluar = DetailPoluar::where('id_detail_pr', $item->id)->sum('poluar_qty');

        return $item;
    }

    public function getPenerimaanBarang($item, $id_po)
    {
        $penerimaan_barang = PenerimaanBarang::where('id_detail_pr', $item->id)->where('id_po', $id_po)->first();

        $item->penerimaan = $penerimaan_barang ? $penerimaan_barang->penerimaan : null;
        $item->hasil_ok = $penerimaan_barang ? $penerimaan_barang->hasil_ok : null;
        $item->hasil_nok = $penerimaan_barang ? $penerimaan_barang->hasil_nok : null;
        $item->diterima_qc = $penerimaan_barang ? $penerimaan_barang->diterima_qc : null;
        $item->belum_diterima_qc = $penerimaan_barang ? $penerimaan_barang->belum_diterima_qc : null;
        $item->diterima_eks = $penerimaan_barang ? $penerimaan_barang->diterima_eks : null;
        $item->belum_diterima_eks = $penerimaan_barang ? $penerimaan_barang->belum_diterima_eks : null;
        $item->tgl_diterima = $penerimaan_barang ? $penerimaan_barang->tanggal_diterima : null;

        // dd($penerimaan_barang, $item->id, $id_po_real);

        return $item;
    }

    public function getDetailPr(Request $request)
    {
        $id = $request->id;
        $pr = PurchaseRequest::select('purchase_request.*', 'kontrak.nama_pekerjaan as nama_proyek')
            ->join('kontrak', 'kontrak.id', '=', 'purchase_request.proyek_id')
            ->where('purchase_request.id', $id)
            ->first();
        $pr->details = DetailPR::where('id_pr', $id)->get();
        // $pr->details = DetailPR::where('id_pr', $id)->leftJoin('kode_material', 'kode_material.id', '=', 'detail_pr.kode_material_id')->get();
        $pr->details = $pr->details->map(function ($item) use ($id, $request) {
            $item->spek = $item->spek ? $item->spek : '';
            $item->keterangan = $item->keterangan ? $item->keterangan : '';
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            $item->nomor_spph = Spph::where('id', $item->id_spph)->first()->nomor_spph ?? '';
            $item->no_po = Purchase_Order::where('id', $item->id_po)->first()->no_po ?? '';
            $item->userRole = User::where('id', $item->user_id)->first()->role ?? '';
            $item->no_sph = $item->no_sph ? $item->no_sph : '';
            $item->tanggal_sph = $item->tanggal_sph ? $item->tanggal_sph : '';
            $item->no_just = $item->no_just ? $item->no_just : '';
            $item->tanggal_just = $item->tanggal_just ? $item->tanggal_just : '';
            $item->no_nego1 = $item->no_nego1 ? $item->no_nego1 : '';
            $item->tanggal_nego1 = $item->tanggal_nego1 ? $item->tanggal_nego1 : '';
            $item->batas_nego1 = $item->batas_nego1 ? $item->batas_nego1 : '';
            $item->no_nego2 = $item->no_nego2 ? $item->no_nego2 : '';
            $item->tanggal_nego2 = $item->tanggal_nego2 ? $item->tanggal_nego2 : '';
            $item->batas_nego2 = $item->batas_nego2 ? $item->batas_nego2 : '';
            $item->batas_akhir = Purchase_Order::leftjoin('detail_po', 'detail_po.id_po', '=', 'purchase_order.id')->where('detail_po.id_detail_pr', $item->id)->first()->batas_akhir ?? '-';

            // untuk Status Tracking
            // Ambil nomor SPPH dari DetailSpph berdasarkan id_detail_pr
            $detailSpph = DetailSpph::where('id_detail_pr', $item->id)->first();
            $item->id_spph = $detailSpph->spph_id ?? null;
            $item->nomor_spph = $detailSpph->spph->nomor_spph ?? '-';

            // Ambil nomor SPPH dari DetailSpphRFQ berdasarkan id_detail_pr
            $detailSpphrfq = DetailSpphrfq::where('id_detail_pr', $item->id)->first();
            $item->id_spphrfq = $detailSpphrfq->spphrfq_id ?? null;
            $item->nomor_spphrfq = $detailSpphrfq->spphrfq->nomor_spphrfq ?? '-';

            // Ambil nomor SPPH dari DetailLoi berdasarkan id_detail_pr
            $detailLoi = DetailLoi::where('id_detail_pr', $item->id)->first();
            $item->id_loi = $detailLoi->loi_id ?? null;
            $item->nomor_loi = $detailLoi->loi->nomor_loi ?? '-';

            // Ambil nomor SPPH dari DetailLoiluar berdasarkan id_detail_pr
            $detailLoiluar = DetailLoiluar::where('id_detail_pr', $item->id)->first();
            $item->id_loiluar = $detailLoiluar->loiluar_id ?? null;
            $item->nomor_loiluar = $detailLoiluar->loiluar->nomor_loiluar ?? '-';

            // Ambil nomor SPPH dari DetailNego berdasarkan id_detail_pr
            $detailNego = DetailNego::where('id_detail_pr', $item->id)->first();
            $item->id_nego = $detailNego->nego_id ?? null;
            $item->nomor_nego = $detailNego->nego->nomor_nego ?? '-';

            // Ambil nomor SPPH dari DetailNegoluar berdasarkan id_detail_pr
            $detailNegoluar = DetailNegoluar::where('id_detail_pr', $item->id)->first();
            $item->id_negoluar = $detailNegoluar->negoluar_id ?? null;
            $item->nomor_negoluar = $detailNegoluar->negoluar->nomor_negoluar ?? '-';

            // Ambil nomor PO dari DetailPo berdasarkan id_detail_pr
            $detailPo = DetailPo::where('id_detail_pr', $item->id)->first();
            $item->id_po = $detailPo->id_po ?? null;
            $item->no_po = $detailPo->purchase_order->no_po ?? '-';

            // Ambil nomor PO Luar dari DetailPoLuar berdasarkan id_detail_pr
            $detailPoLuar = DetailPoluar::where('id_detail_pr', $item->id)->first();
            $item->id_poluar = $detailPoLuar->id_poluar ?? null;
            $item->no_poluar = $detailPoLuar->purchase_orderluar->no_poluar ?? '-';

            $ekspedisi = PenerimaanBarang::where('id_detail_pr', $item->id)->first();
            // dd($ekspedisi, $item->id);
            if ($ekspedisi) {
                $keterangan = $ekspedisi->keterangan;
                $tanggal = $ekspedisi->created_at;
                $tanggal = Carbon::parse($tanggal)->isoFormat('D MMMM Y');
                $keterangan = $keterangan . ', ' . $tanggal;
                // $item->ekspedisi = $ekspedisi;
                // $item->ekspedisi->keterangan = $keterangan;
            } else {
                // $item->ekspedisi = null;
                $keterangan = null;
            }

            // qc
            if ($ekspedisi) {
                $qc = Lppb::where('id_registrasi_barang', $ekspedisi->id)->first();
            } else {
                $qc = null;
            }

            if ($qc) {
                $penerimaan = $qc->penerimaan;
                $hasil_ok = $qc->hasil_ok;
                $hasil_nok = $qc->hasil_nok;
                $tanggal_qc = $qc->created_at;
                $tanggal_qc = Carbon::parse($qc->created_at)->isoFormat('D MMMM Y');
                $qc = new stdClass();
                $qc->penerimaan = $penerimaan;
                $qc->hasil_ok = $hasil_ok;
                $qc->hasil_nok = $hasil_nok;
                $qc->tanggal_qc = $tanggal_qc;
            } else {
                $penerimaan = null;
                $hasil_ok = null;
                $hasil_nok = null;
                $tanggal_qc = null;
                $qc = null;
            }

            $item->qc = $qc;

            $item = $this->getQtyStatus($id, $item);

            // PLEASE USE PENERIMAAN BARANG
            $id_po_real = $item->id_po;
            $item = $this->getPenerimaanBarang($item, $id_po_real);

            // Check if logistics is done (diterima_eks is not null and not empty)
            $isLogisticsDone = !empty($item->diterima_eks) && $item->diterima_eks !== null && $item->diterima_eks !== '-';

            if ($isLogisticsDone) {
                // If logistics is done, show completed status
                $item->countdown = 'Telah diproses';
                $item->backgroundcolor = '#008000';  // Green background
            } else {
                // countdown = waktu - date now
                $targetDate = Carbon::parse($item->waktu);
                $currentDate = Carbon::now();
                $diff = $currentDate->diff($targetDate);
                $remainingDays = $diff->days;

                $referenceDate = Carbon::parse($item->waktu);  // Change this to your desired reference date

                if ($currentDate->lessThan($referenceDate)) {
                    // If the current date is before the reference date
                    $item->countdown = "$remainingDays  Hari Sebelum Waktu Penyelesaian";
                    $item->backgroundcolor = '#008000';  // Green background
                } elseif ($currentDate->greaterThanOrEqualTo($referenceDate)) {
                    // If the current date is on or after the reference date
                    $item->countdown = "$remainingDays Hari Setelah Waktu Penyelesaian";
                    $item->backgroundcolor = '#FF0000';  // Red background
                }
            }

            return $item;
        });

        return response()->json([
            'pr' => $pr
        ]);
    }

    public function getDetailBarang(Request $request)
    {
        $id = $request->id;
        $pr = PurchaseRequest::select('purchase_request.*', 'kontrak.nama_pekerjaan as nama_proyek')
            ->join('kontrak', 'kontrak.id', '=', 'purchase_request.proyek_id')
            ->where('purchase_request.id', $id)
            ->first();
        $pr->details = DetailPR::where('id_pr', $id)->get();
        return response()->json([
            'pr' => $pr
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     //Store untuk menambah data
    //     $purchase_request = $request->id;
    //     $request->validate(
    //         [
    //             'proyek_id' => 'required',
    //             'no_pr' => 'required',
    //             'dasar_pr' => 'required',
    //             'tgl_pr' => 'required',
    //         ],
    //         [
    //             'proyek_id.required' => 'Proyek harus diisi',
    //             'no_pr.required' => 'No PR harus diisi',
    //             'dasar_pr.required' => 'Dasar PR harus diisi',
    //             'tgl_pr.required' => 'Tanggal PR harus diisi',
    //         ]
    //     );
    //     // if (empty($purchase_request)) {
    //     //     DB::table('purchase_request')->insert([
    //     //         'proyek_id' => $request->proyek_id,
    //     //         'no_pr' => $request->no_pr,
    //     //         'dasar_pr' => $request->dasar_pr,
    //     //         'tgl_pr' => $request->tgl_pr,
    //     //         'id_user' => auth()->user()->id,
    //     //     ]);
    //     //     return redirect()->route('purchase_request.index')->with('success', 'Purchase Request berhasil ditambahkan');
    //     // } else {
    //     //     DB::table('purchase_request')->where('id', $purchase_request)->update([
    //     //         'proyek_id' => $request->proyek_id,
    //     //         'no_pr' => $request->no_pr,
    //     //         'dasar_pr' => $request->dasar_pr,
    //     //         'tgl_pr' => $request->tgl_pr,
    //     //     ]);
    //     //     return redirect()->route('purchase_request.index')->with('success', 'Purchase Request berhasil diupdate');
    //     // }
    //     if (empty($purchase_request)) {
    //         // === INSERT BARU ===
    //         $pr_id = DB::table('purchase_request')->insertGetId([
    //             'proyek_id' => $request->proyek_id,
    //             'no_pr' => $request->no_pr,
    //             'dasar_pr' => $request->dasar_pr,
    //             'tgl_pr' => $request->tgl_pr,
    //             'id_user' => auth()->user()->id,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);
    //         // Upload lampiran jika ada
    //         if ($request->hasFile('lampiran')) {
    //             foreach ($request->file('lampiran') as $file) {
    //                 $file_name = rand() . '.' . $file->getClientOriginalExtension();
    //                 $file->move(public_path('lampiran'), $file_name);
    //                 PrLampiran::create([
    //                     'pr_id' => $pr_id,
    //                     'file' => $file_name,
    //                     'tipe' => $this->FunctionCountPages(public_path('lampiran/' . $file_name)),
    //                     'created_at' => now(),
    //                     'updated_at' => now(),
    //                 ]);
    //             }
    //         }
    //         return redirect()->route('purchase_request.index')
    //             ->with('success', 'Purchase Request berhasil ditambahkan');
    //     } else {
    //         // === UPDATE DATA YANG SUDAH ADA ===
    //         DB::table('purchase_request')->where('id', $purchase_request)->update([
    //             'proyek_id' => $request->proyek_id,
    //             'no_pr' => $request->no_pr,
    //             'dasar_pr' => $request->dasar_pr,
    //             'tgl_pr' => $request->tgl_pr,
    //             'updated_at' => now(),
    //         ]);
    //         // Jika ada file lampiran baru di-upload
    //         if ($request->hasFile('lampiran')) {
    //             foreach ($request->file('lampiran') as $file) {
    //                 $file_name = rand() . '.' . $file->getClientOriginalExtension();
    //                 $file->move(public_path('lampiran'), $file_name);
    //                 PrLampiran::create([
    //                     'pr_id' => $purchase_request, // pakai ID lama
    //                     'file' => $file_name,
    //                     'tipe' => $this->FunctionCountPages(public_path('lampiran/' . $file_name)),
    //                     'created_at' => now(),
    //                     'updated_at' => now(),
    //                 ]);
    //             }
    //         }
    //         // Ambil nama lampiran yang diinginkan dari request
    //         $nama_lampiran_baru = explode(', ', $request->nama_lampiran); //masih error
    //         // Ambil semua lampiran yang terkait dengan $spph dari database
    //         $existing_files = explode(', ', $request->lampiran_awal);
    //         // Loop untuk setiap lampiran yang sudah ada
    //         foreach ($existing_files as $existing_file) {
    //             // Jika lampiran tidak termasuk dalam nama lampiran yang baru diupload, hapus dari database dan filesystem
    //             if (!in_array($existing_file, $nama_lampiran_baru)) {
    //                 // Hapus dari database
    //                 PrLampiran::where('pr_id', $purchase_request)->where('file', $existing_file)->delete();
    //                 // Hapus dari filesystem jika perlu
    //                 // $file_path = public_path('lampiran/' . $existing_file);
    //                 // if (file_exists($file_path)) {
    //                 //     unlink($file_path);
    //                 // }
    //             }
    //         }
    //         return redirect()->route('purchase_request.index')
    //             ->with('success', 'Purchase Request berhasil diperbarui');
    //     }
    // }
    public function store(Request $request)
    {
        $pr_id = $request->id;

        // === VALIDASI ===
        $request->validate([
            'no_pr' => 'required',
            'tgl_pr' => 'required',
            'proyek_id' => 'required',
            'dasar_pr' => 'required',
            'revisi' => 'nullable|string',
        ]);

        if (empty($pr_id)) {
            // === INSERT BARU ===
            $pr = PurchaseRequest::create([
                'proyek_id' => $request->proyek_id,
                'no_pr' => $request->no_pr,
                'dasar_pr' => $request->dasar_pr,
                'tgl_pr' => $request->tgl_pr,
                'revisi' => $request->revisi,
                'id_user' => auth()->user()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 🔹 Upload lampiran (jika ada)
            if ($request->hasFile('lampiran')) {
                foreach ($request->file('lampiran') as $file) {
                    $file_name = rand() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('lampiran'), $file_name);

                    PrLampiran::create([
                        'pr_id' => $pr->id,
                        'file' => $file_name,
                        'tipe' => $this->FunctionCountPages(public_path('lampiran/' . $file_name)),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            return redirect()->route('purchase_request.index')->with('success', 'Purchase Request berhasil ditambahkan');
        } else {
            // === UPDATE DATA ===
            $pr = PurchaseRequest::find($pr_id);
            if (!$pr) {
                return redirect()->route('purchase_request.index')->with('error', 'Data tidak ditemukan.');
            }

            $pr->update([
                'proyek_id' => $request->proyek_id,
                'no_pr' => $request->no_pr,
                'dasar_pr' => $request->dasar_pr,
                'tgl_pr' => $request->tgl_pr,
                'revisi' => $request->revisi,
                'updated_at' => now(),
            ]);

            // 🔹 Upload lampiran baru (jika ada)
            if ($request->hasFile('lampiran')) {
                foreach ($request->file('lampiran') as $file) {
                    $file_name = rand() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('lampiran'), $file_name);

                    PrLampiran::create([
                        'pr_id' => $pr->id,
                        'file' => $file_name,
                        'tipe' => $this->FunctionCountPages(public_path('lampiran/' . $file_name)),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // 🔹 Hapus lampiran yang dihapus user
            $nama_lampiran_baru = explode(', ', $request->nama_lampiran);
            $existing_files = explode(', ', $request->lampiran_awal ?? '');

            foreach ($existing_files as $existing_file) {
                if (!in_array($existing_file, $nama_lampiran_baru)) {
                    PrLampiran::where('pr_id', $pr_id)
                        ->where('file', $existing_file)
                        ->delete();
                }
            }

            return redirect()->route('purchase_request.index')->with('success', 'Purchase Request berhasil diperbarui');
        }
    }

    function FunctionCountPages($path)
    {
        $pdftextfile = file_get_contents($path);
        $pagenumber = preg_match_all('/\/Page\W/', $pdftextfile, $dummy);
        return $pagenumber;
    }

    // public function store(Request $request)
    // {
    //     // Store untuk menambah data
    //     $purchase_request = $request->id;

    //     $request->validate(
    //         [
    //             'proyek_id' => 'required',
    //             'tgl_pr' => 'required',
    //         ],
    //         [
    //             'proyek_id.required' => 'Proyek harus diisi',
    //             'tgl_pr.required' => 'Tanggal PR harus diisi',
    //         ]
    //     );

    //     // Ambil role pengguna yang sedang login
    //     $user = auth()->user();

    //     // Tentukan wilayah berdasarkan role
    //     if ($user->role == 2) {
    //         $wilayah = 'WIL1';
    //     } elseif ($user->role == 3) {
    //         $wilayah = 'WIL2';
    //     }

    //     // Ambil nomor PR terakhir yang sesuai dengan wilayah
    //     $lastNoPR = DB::table('purchase_request')
    //         ->where('no_pr', 'like', '%/' . $wilayah . '/%') // Filter berdasarkan wilayah
    //         ->orderByDesc('no_pr') // Urutkan berdasarkan nomor PR
    //         ->first();

    //     if ($lastNoPR) {
    //         $lastNo = $lastNoPR->no_pr;  // Ambil no_pr

    //         $lastSequenceNumber = (int)substr($lastNo, 0, 3); // Ambil 3 digit pertama untuk nomor urut
    //         $sequenceNumber = str_pad($lastSequenceNumber + 1, 3, '0', STR_PAD_LEFT); // Nomor urut berikutnya
    //     } else {
    //         // Jika belum ada data di wilayah tersebut, mulai dengan nomor urut 001
    //         $sequenceNumber = '001';
    //     }

    //     $bulanRomawiMap = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
    //     $bulanRomawi = $bulanRomawiMap[date('n', strtotime($request->tgl_pr)) - 1]; // Ambil bulan dalam format romawi
    //     $tahun = date('Y'); // Tahun sekarang

    //     // Format nomor PR
    //     $no_pr = "{$sequenceNumber}/{$wilayah}/{$bulanRomawi}/{$tahun}";

    //     if (empty($purchase_request)) {
    //         // Menambah data baru
    //         DB::table('purchase_request')->insert([
    //             'proyek_id' => $request->proyek_id,
    //             'no_pr' => $no_pr, // Gunakan format otomatis
    //             'dasar_pr' => $request->dasar_pr,
    //             'tgl_pr' => $request->tgl_pr,
    //             'id_user' => auth()->user()->id,
    //         ]);

    //         return redirect()->route('purchase_request.index')->with('success', 'Purchase Request berhasil ditambahkan');
    //     } else {
    //         // Mengupdate data yang sudah ada
    //         DB::table('purchase_request')->where('id', $purchase_request)->update([
    //             'proyek_id' => $request->proyek_id,
    //             'no_pr' => $no_pr, // Tetap gunakan format otomatis
    //             'dasar_pr' => $request->dasar_pr,
    //             'tgl_pr' => $request->tgl_pr,
    //         ]);

    //         return redirect()->route('purchase_request.index')->with('success', 'Purchase Request berhasil diupdate');
    //     }
    // }

    // notif muncul tapi masih error
    //     public function store(Request $request)
    // {
    //     $purchase_request_id = $request->id; // Mengambil id purchase request jika ada

    //     $request->validate([
    //         'proyek_id' => 'required',
    //         'no_pr' => 'required',
    //         'dasar_pr' => 'required',
    //         'tgl_pr' => 'required',
    //     ], [
    //         'proyek_id.required' => 'Proyek harus diisi',
    //         'no_pr.required' => 'No PR harus diisi',
    //         'dasar_pr.required' => 'Dasar PR harus diisi',
    //         'tgl_pr.required' => 'Tanggal PR harus diisi',
    //     ]);

    //     if (empty($purchase_request_id)) {
    //         $new_purchase_request = DB::table('purchase_request')->insertGetId([
    //             'proyek_id' => $request->proyek_id,
    //             'no_pr' => $request->no_pr,
    //             'dasar_pr' => $request->dasar_pr,
    //             'tgl_pr' => $request->tgl_pr,
    //             'id_user' => auth()->user()->id,
    //         ]);

    //         // Mengirim notifikasi
    //         $this->createPurchaseRequestNotification($new_purchase_request, $request->no_pr);

    //         return response()->json(['status' => 'success', 'pr' => ['id' => $new_purchase_request]]);
    //     } else {
    //         DB::table('purchase_request')->where('id', $purchase_request_id)->update([
    //             'proyek_id' => $request->proyek_id,
    //             'no_pr' => $request->no_pr,
    //             'dasar_pr' => $request->dasar_pr,
    //             'tgl_pr' => $request->tgl_pr,
    //         ]);

    //         return response()->json(['status' => 'success', 'pr' => ['id' => $purchase_request_id]]);
    //     }
    // }

    // public function createPurchaseRequestNotification($prId, $no_pr)
    // {
    //     $notification = new Notification();
    //     $notification->user_id = auth()->user()->id;
    //     $notification->message = "Purchase Request $no_pr telah berhasil disimpan.";
    //     $notification->link = url("purchase-request/$prId");
    //     $notification->is_read = false;
    //     $notification->save();
    // }

    // Cetak PR Defaultnya
    // public function cetakPr(Request $request)
    // {
    //     $id = $request->id;
    //     $pr = PurchaseRequest::where('purchase_request.id', $id)
    //         ->leftjoin('keproyekan', 'keproyekan.id', '=', 'purchase_request.proyek_id')->first();

    //     $pr->pic = User::where('id', $pr->id_user)->first()->name ?? '-';
    //     //if no_pr contain WIL1 then wilayah = wil1 else wil2
    //     $detect_wil = strpos($pr->no_pr, 'WIL1');
    //     if ($detect_wil !== false) {
    //         $pr->role = "Wilayah 1";
    //         $pr->kadiv = "EKO PRASETYO";
    //     } else {
    //         $pr->role = "Wilayah 2";
    //         $pr->kadiv = 'HARI SUBEKTI';
    //     }
    //     $pr->purchases = DetailPR::select('detail_pr.*', 'purchase_request.*')
    //         ->leftjoin('purchase_request', 'purchase_request.id', '=', 'detail_pr.id_pr')
    //         ->where('purchase_request.id', $id)
    //         ->get();

    //     // return response()->json([
    //     //     'pr' => $pr
    //     // ]);
    //     // dd($po);
    //     // $po->batas_po = Carbon::parse($po->batas_po)->isoFormat('D MMMM Y');
    //     // $po->tanggal_po = Carbon::parse($po->tanggal_po)->isoFormat('D MMMM Y');

    //     $pdf = Pdf::loadview('purchase_request.pr_print', compact('pr'));
    //     $pdf->setPaper('A4', 'landscape');
    //     $no = $pr->no_pr;
    //     return $pdf->stream('PR-' . $no . '.pdf');
    // }

    public function cetakDokumen(Request $request)
    {
        $id = $request->id;
        $jenis = $request->jenis_cetak;

        if ($jenis === 'pr') {
            return $this->cetakPr($request);
        } elseif ($jenis === 'sppjp') {
            return $this->cetakSppjp($request);
        } else {
            return abort(404);
        }
    }

    // Cetak tanpa lampiran
    // public function cetakPr(Request $request)
    // {
    //     $id = $request->id;
    //     $pr = PurchaseRequest::where('purchase_request.id', $id)
    //         ->leftjoin('kontrak', 'kontrak.id', '=', 'purchase_request.proyek_id')
    //         ->first();

    //     if (!$pr) {
    //         return abort(404);
    //     }

    //     $pr->pic = User::where('id', $pr->id_user)->first()->name ?? '-';

    //     // if (preg_match('/wil1|wilayah1/i', $pr->no_pr)) {
    //     //     $pr->role = 'Wilayah 1';
    //     //     $pr->kadiv = 'EKO PRASETYO';
    //     //     $pr->kadep = 'RIKA KUSUMANING INDRATMOKO';
    //     // } else {
    //     //     $pr->role = 'Wilayah 2';
    //     //     $pr->kadiv = 'HARI SUBEKTI';
    //     //     $pr->kadep = 'HARLISTA DWI OKTYASWORO';
    //     // }

    //     if (preg_match('/mro/i', $pr->no_pr)) {
    //         $pr->role = 'MRO';
    //         $pr->kadiv = '-';  // Jika tidak ada kadiv MRO, isi dengan '-'
    //         $pr->kadep = 'DWI ANNA A';
    //     } elseif (preg_match('/wil1|wilayah1/i', $pr->no_pr)) {
    //         $pr->role = 'Wilayah 1';
    //         $pr->kadiv = 'EKO PRASETIYO';
    //         $pr->kadep = 'RIKA KUSUMANING INDRATMOKO';
    //     } else {
    //         $pr->role = 'Wilayah 2';
    //         $pr->kadiv = 'EKO PRASETIYO';
    //         $pr->kadep = 'DENI WULANDANI';
    //     }

    //     $pr->purchases = DetailPR::select('detail_pr.*', 'purchase_request.*')
    //         ->leftjoin('purchase_request', 'purchase_request.id', '=', 'detail_pr.id_pr')
    //         ->where('purchase_request.id', $id)
    //         ->get();

    //     $pdf = Pdf::loadview('purchase_request.pr_print', compact('pr'));
    //     $pdf->setPaper('A4', 'landscape');
    //     return $pdf->stream('PR-' . $pr->no_pr . '.pdf');
    // }

    // Cetak dengan FDPI tapi belum bisa
    public function cetakPr(Request $request)
    {
        $id = $request->id;

        $pr = PurchaseRequest::where('purchase_request.id', $id)
            ->leftJoin('kontrak', 'kontrak.id', '=', 'purchase_request.proyek_id')
            ->firstOrFail();

        $pr->pic = User::where('id', $pr->id_user)->first()->name ?? '-';

        // ROLE
        if (preg_match('/mro|MRO/i', $pr->no_pr)) {
            $pr->role = 'MRO';
            $pr->kadiv = '-';
            $pr->kadep = 'DWI ANNA A';
        } elseif (preg_match('/wil1|wilayah1/i', $pr->no_pr)) {
            $pr->role = 'Wilayah 1';
            $pr->kadiv = 'EKO PRASETIYO';
            $pr->kadep = 'RIKA KUSUMANING INDRATMOKO';
        } else {
            $pr->role = 'Wilayah 2';
            $pr->kadiv = 'EKO PRASETIYO';
            $pr->kadep = 'DENI WULANDANI';
        }

        $pr->purchases = DetailPR::where('id_pr', $id)->get();

        // 🔹 Ambil lampiran PR
        $lampiran = PrLampiran::where('pr_id', $id)->get();

        /* ===============================
           1️⃣ Generate PDF PR utama
        =============================== */
        $pdf = Pdf::loadView('purchase_request.pr_print', compact('pr'));
        $pdf->setPaper('A4', 'landscape');

        $tempPath = storage_path("app/temp_pr_{$id}.pdf");
        $pdf->save($tempPath);

        /* ===============================
           2️⃣ Merge dengan lampiran
        =============================== */
        $fpdi = new FPDI();

        // ➜ PR utama
        $pageCount = $fpdi->setSourceFile($tempPath);
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $tpl = $fpdi->importPage($pageNo);
            $size = $fpdi->getTemplateSize($tpl);

            $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';
            $fpdi->AddPage($orientation);

            $pageWidth = $orientation === 'L' ? 297 : 210;
            $pageHeight = $orientation === 'L' ? 210 : 297;

            $scale = min(
                $pageWidth / $size['width'],
                $pageHeight / $size['height']
            );

            $x = ($pageWidth - ($size['width'] * $scale)) / 2;
            $y = ($pageHeight - ($size['height'] * $scale)) / 2;

            $fpdi->useTemplate(
                $tpl,
                $x,
                $y,
                $size['width'] * $scale,
                $size['height'] * $scale
            );
        }

        // ➜ Lampiran PDF
        foreach ($lampiran as $file) {
            $filePath = public_path("/lampiran/{$file->file}");  // contoh: lampiran/checksheet.pdf

            if (!file_exists($filePath)) {
                continue;
            }

            $pageCount = $fpdi->setSourceFile($filePath);
            for ($i = 1; $i <= $pageCount; $i++) {
                $tpl = $fpdi->importPage($i);
                $size = $fpdi->getTemplateSize($tpl);

                $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';
                $fpdi->AddPage($orientation);

                $pageWidth = $orientation === 'L' ? 297 : 210;
                $pageHeight = $orientation === 'L' ? 210 : 297;

                $scale = min(
                    $pageWidth / $size['width'],
                    $pageHeight / $size['height']
                );

                $x = ($pageWidth - ($size['width'] * $scale)) / 2;
                $y = ($pageHeight - ($size['height'] * $scale)) / 2;

                $fpdi->useTemplate(
                    $tpl,
                    $x,
                    $y,
                    $size['width'] * $scale,
                    $size['height'] * $scale
                );
            }
        }

        unlink($tempPath);

        /* ===============================
           3️⃣ Output ke browser
        =============================== */
        return response(
            $fpdi->Output('S', 'PR-' . $pr->no_pr . '.pdf')
        )->header('Content-Type', 'application/pdf');
    }

    // Asli Tanpa Lampiran FDPI

    // public function cetakSppjp(Request $request)
    // {
    //     $id = $request->id;
    //     $sppjp = PurchaseRequest::where('purchase_request.id', $id)
    //         ->leftjoin('kontrak', 'kontrak.id', '=', 'purchase_request.proyek_id')
    //         ->first();

    //     if (!$sppjp) {
    //         return abort(404);
    //     }

    //     $sppjp->pic = User::where('id', $sppjp->id_user)->first()->name ?? '-';

    //     // if (preg_match('/wil1|wilayah1/i', $sppjp->no_pr)) {
    //     //     $sppjp->role = 'Wilayah 1';
    //     //     $sppjp->kadiv = 'EKO PRASETYO';
    //     //     $sppjp->kadep = 'RIKA KUSUMANING INDRATMOKO';
    //     // } else {
    //     //     $sppjp->role = 'Wilayah 2';
    //     //     $sppjp->kadiv = 'HARI SUBEKTI';
    //     //     $sppjp->kadep = 'HARLISTA DWI OKTYASWORO';
    //     // }

    //     if (preg_match('/mro|MRO/i', $sppjp->no_pr)) {
    //         $sppjp->role = 'MRO';
    //         $sppjp->kadiv = '-';  // bisa diisi jika ada kadiv khusus MRO
    //         $sppjp->kadep = 'DWI ANNA A';
    //     } elseif (preg_match('/wil1|wilayah1/i', $sppjp->no_pr)) {
    //         $sppjp->role = 'Wilayah 1';
    //         $sppjp->kadiv = 'EKO PRASETIYO';
    //         $sppjp->kadep = 'RIKA KUSUMANING INDRATMOKO';
    //     } else {
    //         $sppjp->role = 'Wilayah 2';
    //         $sppjp->kadiv = 'EKO PRASETIYO';
    //         $sppjp->kadep = 'DENI WULANDANI';
    //     }

    //     $sppjp->purchases = DetailPR::select('detail_pr.*', 'purchase_request.*')
    //         ->leftjoin('purchase_request', 'purchase_request.id', '=', 'detail_pr.id_pr')
    //         ->where('purchase_request.id', $id)
    //         ->get();

    //     $pdf = Pdf::loadview('purchase_request.sppjp_print', compact('sppjp'));
    //     $pdf->setPaper('A4', 'landscape');
    //     return $pdf->stream('PR-' . $sppjp->no_pr . '.pdf');
    // }

    // dengan lampiran Fdpi
    public function cetakSppjp(Request $request)
    {
        $id = $request->id;

        // Ambil data SPPJP + proyek (kontrak)
        $sppjp = PurchaseRequest::where('purchase_request.id', $id)
            ->leftJoin('kontrak', 'kontrak.id', '=', 'purchase_request.proyek_id')
            ->firstOrFail();

        // PIC
        $sppjp->pic = User::where('id', $sppjp->id_user)->first()->name ?? '-';

        // ROLE / KADIV / KADEP
        if (preg_match('/mro|MRO/i', $sppjp->no_pr)) {
            $sppjp->role = 'MRO';
            $sppjp->kadiv = '-';
            $sppjp->kadep = 'DWI ANNA A';
        } elseif (preg_match('/wil1|wilayah1/i', $sppjp->no_pr)) {
            $sppjp->role = 'Wilayah 1';
            $sppjp->kadiv = 'EKO PRASETIYO';
            $sppjp->kadep = 'RIKA KUSUMANING INDRATMOKO';
        } else {
            $sppjp->role = 'Wilayah 2';
            $sppjp->kadiv = 'EKO PRASETIYO';
            $sppjp->kadep = 'DENI WULANDANI';
        }

        // Detail purchases
        $sppjp->purchases = DetailPR::where('id_pr', $id)->get();

        // Ambil lampiran SPPJP
        $lampiran = PrLampiran::where('pr_id', $id)->get();

        /* ===============================
           1️⃣ Generate PDF SPPJP utama
        =============================== */
        $pdf = Pdf::loadView('purchase_request.sppjp_print', compact('sppjp'));
        $pdf->setPaper('A4', 'landscape');

        $tempPath = storage_path("app/temp_sppjp_{$id}.pdf");
        $pdf->save($tempPath);

        /* ===============================
           2️⃣ Merge dengan lampiran menggunakan FPDI
        =============================== */
        $fpdi = new \setasign\Fpdi\Fpdi();

        // ➜ SPPJP utama
        $pageCount = $fpdi->setSourceFile($tempPath);
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $tpl = $fpdi->importPage($pageNo);
            $size = $fpdi->getTemplateSize($tpl);

            $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';
            $fpdi->AddPage($orientation);

            $pageWidth = $orientation === 'L' ? 297 : 210;
            $pageHeight = $orientation === 'L' ? 210 : 297;

            $scale = min(
                $pageWidth / $size['width'],
                $pageHeight / $size['height']
            );

            $x = ($pageWidth - ($size['width'] * $scale)) / 2;
            $y = ($pageHeight - ($size['height'] * $scale)) / 2;

            $fpdi->useTemplate(
                $tpl,
                $x,
                $y,
                $size['width'] * $scale,
                $size['height'] * $scale
            );
        }

        // ➜ Lampiran PDF
        foreach ($lampiran as $file) {
            $filePath = public_path("/lampiran/{$file->file}");
            if (!file_exists($filePath))
                continue;

            $pageCount = $fpdi->setSourceFile($filePath);
            for ($i = 1; $i <= $pageCount; $i++) {
                $tpl = $fpdi->importPage($i);
                $size = $fpdi->getTemplateSize($tpl);

                $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';
                $fpdi->AddPage($orientation);

                $pageWidth = $orientation === 'L' ? 297 : 210;
                $pageHeight = $orientation === 'L' ? 210 : 297;

                $scale = min(
                    $pageWidth / $size['width'],
                    $pageHeight / $size['height']
                );

                $x = ($pageWidth - ($size['width'] * $scale)) / 2;
                $y = ($pageHeight - ($size['height'] * $scale)) / 2;

                $fpdi->useTemplate(
                    $tpl,
                    $x,
                    $y,
                    $size['width'] * $scale,
                    $size['height'] * $scale
                );
            }
        }

        // Hapus temporary file
        unlink($tempPath);

        /* ===============================
           3️⃣ Output ke browser
        =============================== */
        return response(
            $fpdi->Output('S', 'SPPJP-' . $sppjp->no_pr . '.pdf')
        )->header('Content-Type', 'application/pdf');
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

    // Hapus Multiple CheckBox
    public function hapusMultiplePr(Request $request)
    {
        if ($request->has('ids')) {
            $ids = $request->input('ids');

            // Hapus detail_pr terlebih dahulu
            DetailPr::whereIn('id_pr', $ids)->delete();

            // Hapus PurchaseRequest
            PurchaseRequest::whereIn('id', $ids)->delete();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // //edit detail
    // public function editDetail(Request $request)
    // {
    //     if (!$request->stock) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'QTY tidak boleh kosong'
    //         ]);
    //     }
    //     $request->validate([
    //         'lampiran' => 'nullable',
    //         // 'lampiran' => 'nullable|file|mimes:pdf|max:500',
    //     ]);
    //     if ($request->file('lampiran')) {
    //         $file = $request->file('lampiran');
    //         // dd($file);
    //         $fileName = rand() . '.' . $file->getClientOriginalExtension();
    //         // dd($fileName);
    //         $file->move(public_path('lampiran'), $fileName);
    //     } else {
    //         $fileName = null;
    //     }
    //     // Validasi data yang diterima dari request
    //     $request->validate([
    //         'id_pr' => $request->id_pr,
    //         'id_proyek' => $request->id_proyek,
    //         'kode_material' => $request->kode_material,
    //         'uraian' => $request->uraian,
    //         'spek' => $request->spek,
    //         'satuan' => $request->satuan,
    //         'qty' => $request->stock,
    //         'qty_spph' => $request->stock,
    //         'qty_nego' => $request->stock,
    //         'qty_po' => $request->stock,
    //         // 'qty2' => $request->stock,
    //         'waktu' => $request->waktu,
    //         'keterangan' => $request->keterangan,
    //         'lampiran' => $fileName,
    //     ]);
    //     $id = $request->id;
    //     // Cek apakah id_sr yang diberikan valid
    //     // dd($detailSR);
    //     if (!$id) {
    //         // Alihkan ke fungsi createDetailSr jika detail SR tidak ditemukan
    //         return $this->updateDetailPr($request);
    //         // dd($request->all());
    //     }
    //     $detailPR = DetailPR::where('id', $id)->first();
    //     // Update data detail SR
    //     $detailPR->update([
    //         'id_pr' => $request->id_pr,
    //         'id_proyek' => $request->id_proyek,
    //         'kode_material' => $request->kode_material,
    //         'uraian' => $request->uraian,
    //         'spek' => $request->spek,
    //         'satuan' => $request->satuan,
    //         'qty' => $request->stock,
    //         'waktu' => $request->waktu,
    //         'keterangan' => $request->keterangan,
    //         'lampiran' => $fileName,
    //     ]);
    //     $pr = DB::table('purchase_request')->where('id', $request->id_pr)->first();
    //     $pr->details = DetailPR::where('id_pr', $request->id_pr)->get();
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Data detail SR berhasil diupdate.',
    //         'pr' => $pr // Mengembalikan data detail SR yang telah diupdate
    //     ]);
    // }
    // //end edit detail
    // edit detail
    public function editDetail(Request $request)
    {
        // if (!$request->stock) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'QTY tidak boleh kosong'
        //     ]);
        // }
        $request->validate([
            'lampiran' => 'nullable',
            // 'lampiran' => 'nullable|file|mimes:pdf|max:500',
        ]);

        if ($request->file('lampiran')) {
            $file = $request->file('lampiran');
            // dd($file);
            $fileName = rand() . '.' . $file->getClientOriginalExtension();
            // dd($fileName);
            $file->move(public_path('lampiran'), $fileName);
        } else {
            $fileName = null;
        }
        // Validasi data yang diterima dari request
        $request->validate([
            'id_pr' => 'required',  // Pastikan id_sr wajib ada
            // 'id' => 'required',
            'kode_material' => 'nullable',
            'uraian' => 'nullable',
            'spek' => 'nullable',
            'qty' => 'nullable',
            'satuan' => 'nullable',
            'waktu' => 'nullable',
            'keterangan' => 'nullable',
            'lampiran' => 'nullable',
        ]);

        $id = $request->id;

        // Cek apakah id_sr yang diberikan valid

        // dd($detailSR);
        if (!$id) {
            // Alihkan ke fungsi createDetailSr jika detail SR tidak ditemukan
            return $this->updateDetailPr($request);
            // dd($request->all());
        }
        $detailPR = DetailPR::where('id', $id)->first();
        // Update data detail SR
        $detailPR->update([
            'id_pr' => $request->id_pr ?? '',
            'id_proyek' => $request->id_proyek ?? '',
            'kode_material' => $request->kode_material ?? '',
            'uraian' => $request->uraian ?? '',
            'spek' => $request->spek ?? '',
            'satuan' => $request->satuan ?? '',
            'qty' => $request->stock ?? 0,
            // 'qty_spph' => $request->stock ?? 0,
            // 'qty_loi' => $request->stock ?? 0,
            // 'qty_nego' => $request->stock ?? 0,
            // 'qty_po' => $request->stock ?? 0,
            // 'qty2' => $request->stock ?? 0,
            'waktu' => $request->waktu ?? '',
            'keterangan' => $request->keterangan ?? '',
            'lampiran' => $fileName ?? '',
        ]);

        $pr = DB::table('purchase_request')->where('id', $request->id_pr)->first();
        // TODO: tambah func disini
        $pr->details = DetailPR::where('id_pr', $request->id_pr)->get();
        $pr->details = $pr->details->map(function ($item) use ($request) {
            $item = $this->getQtyStatus($request->id_pr, $item);

            return $item;
        });
        return response()->json([
            'success' => true,
            'message' => 'Data detail SR berhasil diupdate.',
            'pr' => $pr  // Mengembalikan data detail SR yang telah diupdate
        ]);
    }

    // end edit detail

    public function updateDetailPr(Request $request)
    {
        // if (!$request->stock) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'QTY tidak boleh kosong'
        //     ]);
        // }
        $request->validate([
            'lampiran' => 'nullable',
            // 'lampiran' => 'nullable|file|mimes:pdf|max:500',
        ]);

        if ($request->file('lampiran')) {
            $file = $request->file('lampiran');
            // dd($file);
            $fileName = rand() . '.' . $file->getClientOriginalExtension();
            // dd($fileName);
            $file->move(public_path('lampiran'), $fileName);
        } else {
            $fileName = null;
        }
        $maxIdDel = DetailPR::max('id_del');  // Mengambil nilai maksimum id_del yang ada
        $idDel = $maxIdDel + 1;  // Menambahkan 1 pada nilai maksimum untuk mendapatkan id_del yang baru
        $insert = DetailPR::create([
            'id_pr' => $request->id_pr,
            'id_proyek' => $request->id_proyek,
            'kode_material' => $request->kode_material ?: '-',
            'uraian' => $request->uraian ?: '-',
            'spek' => $request->spek ?: '-',
            'satuan' => $request->satuan ?: '-',
            'qty' => $request->stock ?: 0,
            'waktu' => $request->waktu ?: '-',
            'keterangan' => $request->keterangan ?: '-',
            'lampiran' => $fileName ?: null,
            'id_del' => $idDel,
        ]);

        if (!$insert) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan detail PR'
            ]);
        }

        $pr = DB::table('purchase_request')->where('id', $request->id_pr)->first();
        $pr->details = DetailPR::where('id_pr', $request->id_pr)->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan detail PR',
            'pr' => $pr
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $delete_pr = $request->id;
        $delete_pr = DB::table('purchase_request')->where('id', $delete_pr)->delete();
        $delete_detail_pr = DetailPR::where('id_pr', $request->id)->delete();
        // 🔹 Tambahan: hapus data di tabel pr_lampiran
        $delete_lampiran = DB::table('pr_lampiran')->where('pr_id', $request->id)->delete();
        // $delete_detail_po = DetailPo::where('id_pr', $request->id)->delete();
        // $delete_detail_spph = Spph::leftjoin('detail_spph', 'detail_spph.spph_id', '=', 'spph.id')->where('detail_spph.id_detail_pr', $request->id)->delete();

        // if ($delete_pr && $delete_detail_pr && $delete_detail_po && $delete_detail_spph) {
        if ($delete_pr) {
            return redirect()->route('purchase_request.index')->with('success', 'Data Request berhasil dihapus');
        } else {
            return redirect()->route('purchase_request.index')->with('error', 'Data Request gagal dihapus');
        }

        return redirect()->route('purchase_request.index');
    }

    public function hapusDetail(Request $request, $id)
    {
        // Mendapatkan nilai id_pr sebelum menghapus data
        $id_pr = DetailPR::where('id', $id)->value('id_pr');

        // Menghapus data purchase request dan detailnya
        $delete_detail_pr = DetailPR::where('id', $id)->delete();

        // Periksa apakah permintaan utama berhasil dihapus dan kembalikan respons yang sesuai
        if ($delete_detail_pr) {
            return response()->json(['success' => 'Data Request berhasil dihapus', 'deletedId' => $id, 'id_pr' => $id_pr]);
        } else {
            return response()->json(['error' => 'Data Request gagal dihapus'], 500);
        }
    }

    public function detailPrSave(Request $request)
    {
        $id_pr = $request->id;
        $id = $request->id_pr;
        $no_sph = $request->no_sph;
        $tanggal_sph = $request->tanggal_sph;
        $no_just = $request->no_just;
        $tanggal_just = $request->tanggal_just;
        $no_nego1 = $request->no_nego1;
        $tanggal_nego1 = $request->tanggal_nego1;
        $batas_nego1 = $request->batas_nego1;
        $no_nego2 = $request->no_nego2;
        $tanggal_nego2 = $request->tanggal_nego2;
        $batas_nego2 = $request->batas_nego2;

        DetailPR::where('id', $id_pr)->update([
            'no_sph' => $no_sph,
            'tanggal_sph' => $tanggal_sph,
            'no_just' => $no_just,
            'tanggal_just' => $tanggal_just,
            'no_nego1' => $no_nego1,
            'tanggal_nego1' => $tanggal_nego1,
            'batas_nego1' => $batas_nego1,
            'no_nego2' => $no_nego2,
            'tanggal_nego2' => $tanggal_nego2,
            'batas_nego2' => $batas_nego2,
        ]);

        $pr = PurchaseRequest::where('id', $id)->first();
        $pr->details = DetailPR::where('id_pr', $pr->id)->get();
        // $pr->details = DetailPR::where('id_pr', $id)->leftJoin('kode_material', 'kode_material.id', '=', 'detail_pr.kode_material_id')->get();
        $pr->details = $pr->details->map(function ($item) {
            $item->spek = $item->spek ? $item->spek : '';
            $item->keterangan = $item->keterangan ? $item->keterangan : '';
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            $item->nomor_spph = Spph::where('id', $item->id_spph)->first()->nomor_spph ?? '';
            $item->no_po = Purchase_Order::where('id', $item->id_po)->first()->no_po ?? '';

            $item->no_sph = $item->no_sph ?? '';
            $item->tanggal_sph = $item->tanggal_sph ?? '';
            $item->no_just = $item->no_just ?? '';
            $item->tanggal_just = $item->tanggal_just ?? '';
            $item->no_nego1 = $item->no_nego1 ?? '';
            $item->tanggal_nego1 = $item->tanggal_nego1 ?? '';
            $item->batas_nego1 = $item->batas_nego1 ?? '';
            $item->no_nego2 = $item->no_nego2 ?? '';
            $item->tanggal_nego2 = $item->tanggal_nego2 ?? '';
            $item->batas_nego2 = $item->batas_nego2 ?? '';
            return $item;
        });
        return response()->json([
            'pr' => $pr
        ]);
    }

    // edit detail produk oleh engginering

    public function showEditPr(Request $request)
    {
        $search = $request->q;

        if (Session::has('selected_warehouse_id')) {
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $requests = PurchaseRequest::select('purchase_request.*', 'kontrak.nama_pekerjaan as proyek_name')
            ->join('kontrak', 'kontrak.id', '=', 'purchase_request.proyek_id')
            ->orderBy('purchase_request.id', 'asc')
            ->paginate(50);

        $proyeks = DB::table('kontrak')->get();
        //  dd($requests);

        if ($search) {
            $requests = PurchaseRequest::where('nama_proyek', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == 'json') {
            $requests = PurchaseRequest::where('warehouse_id', $warehouse_id)->get();

            return response()->json($requests);
        } else {
            // looping the paginate
            foreach ($requests as $request) {
                $detail_pr = DetailPR::where('id_pr', $request->id)->get();
                // if detail_pr empty then editable true
                if ($detail_pr->isEmpty()) {
                    $request->editable = TRUE;
                } else {
                    // looping detail_pr then check in detailspph with id_detail_pr exist
                    foreach ($detail_pr as $detail) {
                        $detail_spph = DetailSpph::where('id_detail_pr', $detail->id)->first();
                        $po = Purchase_Order::where('id', $detail->id_po)->first();
                        if ($po && $po->tipe == '1') {
                            $request->editable = FALSE;
                            break;
                        } else {
                            if ($detail_spph) {
                                $request->editable = FALSE;
                                break;
                            } else {
                                $request->editable = TRUE;
                            }
                        }
                    }
                }
            }
            return view('engineering.index', compact('requests', 'proyeks'));
        }
    }

    public function editPrEng(Request $request)
    {
        $id = $request->id;
        $id_pr = $request->id_pr;
        $kode_material = $request->kode_material;
        $spek = $request->spek;

        $edit = DetailPR::where('id', $id)->update([
            'kode_material' => $kode_material,
            'spek' => $spek,
        ]);

        if (!$edit) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengedit detail PR'
            ]);
        }

        $pr = PurchaseRequest::where('id', $request->id_pr)->first();
        $pr->details = DetailPR::where('id_pr', $pr->id_pr)->get();

        $pr->details = $pr->details->map(function ($item) {
            $item->spek = $item->spek ? $item->spek : '';
            $item->keterangan = $item->keterangan ? $item->keterangan : '';
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            $item->nomor_spph = Spph::where('id', $item->id_spph)->first()->nomor_spph ?? '';
            $item->no_po = Purchase_Order::where('id', $item->id_po)->first()->no_po ?? '';
            return $item;
        });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengedit detail PR',
            'pr' => $pr
        ]);
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'lampiran' => 'nullable|file|mimes:pdf|max:500',  // Menetapkan batasan tipe file dan ukuran
            // 'detail_id' => 'required|exists:details,id',
        ]);

        $detailId = $request->input('detail_id');
        $file = $request->file('lampiran');

        // Generate nama unik untuk file
        $fileName = 'lampiran' . time() . '_' . $file->getClientOriginalName();

        // Pindahkan file ke penyimpanan yang diinginkan (misalnya, storage/app/attachments)
        $file->storeAs('lampiran', $fileName);

        // Simpan informasi file di database, misalnya menyimpan nama file di kolom 'attachment' di tabel 'details'
        DetailPR::where('id', $detailId)->update(['lampiran' => $fileName]);

        return redirect()->back()->with('success', 'File berhasil diupload');
    }

    public function penerimaan_barang()
    {
        // ===== DALAM =====
        $itemsDalam = DetailPo::select(
            'detail_po.*',
            'purchase_order.no_po',
            DB::raw("'dalam' as sumber")
        )
            ->leftJoin('purchase_order', 'purchase_order.id', '=', 'detail_po.id_po')
            ->whereNotNull('purchase_order.id')
            ->groupBy('detail_po.id_po')
            ->get();

        foreach ($itemsDalam as $item) {
            $po = Purchase_Order::find($item->id_po);
            if ($po) {
                $split_proyek = explode(',', $po->proyek_id);
                $proyek_names = Kontrak::whereIn('id', $split_proyek)->pluck('nama_pekerjaan')->toArray();
                $item->proyeks = implode(', ', $proyek_names);

                $id_pr = explode(',', $po->pr_id);
                $item->no_pr = PurchaseRequest::whereIn('id', $id_pr)->pluck('no_pr')->implode(', ');

                $item->tipe = $po->tipe == 0 ? 'PO' : 'PO/PL';
            } else {
                $item->proyeks = '-';
                $item->no_pr = '-';
                $item->tipe = '-';
            }

            $registrasi = RegistrasiBarang::where('id_barang', $item->id)->first();
            $item->diterima = $registrasi ? 1 : 0;
            $item->keterangan = $registrasi ? $registrasi->keterangan : '';
        }

        // ===== LUAR =====
        $itemsLuar = DetailPoluar::select(
            'detail_poluar.*',
            'purchase_orderluar.no_poluar as no_po',
            DB::raw("'luar' as sumber")
        )
            ->leftJoin('purchase_orderluar', 'purchase_orderluar.id', '=', 'detail_poluar.id_poluar')
            ->whereNotNull('purchase_orderluar.id')
            ->groupBy('detail_poluar.id_poluar')
            ->get();

        foreach ($itemsLuar as $item) {
            $po = Purchase_Orderluar::find($item->id_poluar);
            if ($po) {
                $split_proyek = explode(',', $po->proyek_id);
                $proyek_names = Kontrak::whereIn('id', $split_proyek)->pluck('nama_pekerjaan')->toArray();
                $item->proyeks = implode(', ', $proyek_names);

                $id_pr = explode(',', $po->pr_id);
                $item->no_pr = PurchaseRequest::whereIn('id', $id_pr)->pluck('no_pr')->implode(', ');

                $item->tipe = $po->tipe == 0 ? 'PO' : 'PO/PL';
            } else {
                $item->proyeks = '-';
                $item->no_pr = '-';
                $item->tipe = '-';
            }

            $registrasi = RegistrasiBarang::where('id_barang', $item->id)->first();
            $item->diterima = $registrasi ? 1 : 0;
            $item->keterangan = $registrasi ? $registrasi->keterangan : '';
        }

        // ===== GABUNGKAN + PAGINASI =====
        $itemsGabungan = $itemsDalam->merge($itemsLuar)->values();

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentItems = $itemsGabungan->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $items = new LengthAwarePaginator($currentItems, $itemsGabungan->count(), $perPage, $currentPage, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);

        return view('penerimaan_barang.index', compact('items'));
    }

    //     public function penerimaan_barang()
    // {
    //     $items = DetailPo::select(
    //         'detail_po.*',
    //         'purchase_request.no_pr',
    //         'purchase_order.no_po',
    //         'purchase_request.nomor_lppb',
    //         'purchase_request.tanggal_lppb'
    //     )
    //     ->leftJoin('purchase_request', 'purchase_request.id', '=', 'detail_po.id_pr')
    //     ->leftJoin('purchase_order', 'purchase_order.id', '=', 'detail_po.id_po')
    //     ->groupBy('id_po')
    //     ->paginate(10);

    //     foreach ($items as $item) {
    //         $item->tipe = $item->tipe == 0 ? 'PO' : 'PO/PL';
    //         $item->diterima = RegistrasiBarang::where('id_barang', $item->id)->exists() ? 1 : 0;
    //         $item->keterangan = RegistrasiBarang::where('id_barang', $item->id)->value('keterangan') ?? '';

    //         $po = Purchase_Order::where('id', $item->id_po)->first();

    //         if ($po && $po->proyek_id) {
    //             $split_proyek = explode(',', $po->proyek_id);
    //             $proyek_names = Keproyekan::whereIn('id', $split_proyek)->pluck('nama_proyek')->toArray();
    //             $item->proyeks = implode(',', $proyek_names);
    //         } else {
    //             $item->proyeks = ''; // Berikan nilai default jika $po atau proyek_id tidak ditemukan
    //         }
    //     }

    //     return view('penerimaan_barang.index', compact('items'));
    // }

    public function registrasi_barang(Request $request)
    {
        $request->validate([
            'keterangan' => 'required',
        ], [
            'keterangan.required' => 'Keterangan harus diisi',
        ]);
        // dd($request->all());

        $id = $request->id_barang;
        $keterangan = $request->keterangan;

        $add = RegistrasiBarang::create([
            'id_barang' => $id,
            'id_user' => auth()->user()->id,
            'keterangan' => $keterangan,
        ]);

        return redirect()->route('penerimaan_barang')->with('success', 'Berhasil registrasi barang');
    }

    public function edit_registrasi_barang(Request $request)
    {
        $request->validate([
            'keterangan' => 'required',
        ], [
            'keterangan.required' => 'Keterangan harus diisi',
        ]);

        $id = $request->id_barang;
        $keterangan = $request->keterangan;

        $add = RegistrasiBarang::where('id_barang', $id)->update([
            'id_user' => auth()->user()->id,
            'keterangan' => $keterangan,
        ]);

        return redirect()->route('penerimaan_barang')->with('success', 'Berhasil mengubah keterangan');
    }

    // Jangan dihapus buat jaga-jaga kalo lppb error!!!!
    // public function lppb()
    // {
    //     // $items = RegistrasiBarang::select('detail_pr.*', 'purchase_request.no_pr', 'purchase_order.no_po', 'purchase_order.tipe', 'keproyekan.nama_proyek', 'registrasi_barang.created_at as diterima_ekspedisi', 'registrasi_barang.id as id_registrasi_barang')
    //     //     ->leftjoin('detail_pr', 'detail_pr.id', '=', 'registrasi_barang.id_barang')
    //     //     ->leftjoin('purchase_request', 'purchase_request.id', '=', 'detail_pr.id_pr')
    //     //     ->leftjoin('purchase_order', 'purchase_order.id', '=', 'detail_pr.id_po')
    //     //     ->leftjoin('keproyekan', 'keproyekan.id', '=', 'purchase_request.proyek_id')
    //     //     ->whereNotNull('detail_pr.id_po')
    //     //     ->paginate(10);

    //     // $items = RegistrasiBarang::select(
    //     // 'purchase_request.*',
    //     // 'purchase_request.no_pr',
    //     // 'purchase_order.no_po',
    //     // 'purchase_order.tipe',
    //     // 'kontrak.nama_pekerjaan',
    //     // 'registrasi_barang.created_at as diterima_ekspedisi',
    //     // 'registrasi_barang.id as id_registrasi_barang'
    //     // )
    //     // ->leftjoin('purchase_request', 'purchase_request.id', '=', 'registrasi_barang.id_barang')
    //     // ->leftjoin(DB::raw('(SELECT * FROM detail_pr GROUP BY id_pr) as detail_pr'), 'detail_pr.id_pr', '=', 'purchase_request.id')
    //     // ->leftjoin('purchase_order', 'purchase_order.id', '=', 'detail_pr.id_po')
    //     // ->leftjoin('kontrak', 'kontrak.id', '=', 'purchase_request.proyek_id')
    //     // ->whereNotNull('detail_pr.id_po')
    //     // ->paginate(10);

    //     $items = DetailPo::select(
    //         'detail_po.*',
    //         // 'purchase_request.no_pr',
    //         'purchase_order.no_po',
    //         'purchase_order.nomor_lppb',
    //         'purchase_order.tanggal_lppb',
    //     )
    //         // ->leftjoin('purchase_request','purchase_request.id', '=', 'detail_po.id_pr')
    //         ->leftjoin('purchase_order', 'purchase_order.id', '=', 'detail_po.id_po')
    //         ->groupBy('id_po')->paginate(10);

    //     foreach ($items as $item) {
    //         $po = Purchase_Order::where('id', $item->id_po)->first();
    //         $id_pr = explode(',', $po->pr_id);
    //         $item->no_pr = PurchaseRequest::whereIn('id', $id_pr)->pluck('no_pr')->implode(', ');
    //     }

    //     // $items = DetailPo::select(
    //     //     'detail_po.*',
    //     //     'purchase_request.no_pr',
    //     //     'purchase_order.no_po',
    //     //     'purchase_request.nomor_lppb',
    //     //     'purchase_request.tanggal_lppb',
    //     // )
    //     // ->leftjoin('purchase_request','purchase_request.id', '=', 'detail_po.id_pr')
    //     // ->leftjoin('purchase_order', 'purchase_order.id', '=', 'detail_po.id_po')
    //     // ->groupBy('id_po')->paginate(10);

    //     // dd($items);

    //     // $items = RegistrasiBarang::with(['purchase_request' => function ($query) {
    //     //     $query->join('purchase_order', 'detail_pr.id_po', '=', 'purchase_order.id')
    //     //         ->select('detail_pr.*', 'purchase_order.no_po');
    //     // }])->paginate(10);

    //     // $items = PurchaseRequest::with(['detailPr' => function ($query) {
    //     //     $query->join('purchase_order', 'detail_pr.id_po', '=', 'purchase_order.id')
    //     //         ->select('detail_pr.*', 'purchase_order.no_po');
    //     // }])->paginate(10);

    //     foreach ($items as $item) {
    //         $item->tipe = $item->tipe == 0 ? 'PO' : 'PO/PL';
    //         // $item->diterima = Lppb::where('id_registrasi_barang', $item->id_registrasi_barang)->first() ? 1 : 0;
    //         // $keterangan = Lppb::where('id_registrasi_barang', $item->id)->first() ? Lppb::where('id_registrasi_barang', $item->id)->first()->keterangan : '';
    //         // $item->keterangan = Lppb::where('id_registrasi_barang', $item->id)->first() ? Lppb::where('id_registrasi_barang', $item->id)->first()->keterangan : '';
    //         // $item->diterima_ekspedisi = Carbon::parse($item->diterima_ekspedisi)->isoFormat('D MMMM Y');
    //     }

    //     return view('lppb.index', compact('items'));
    // }

    // Baru , menampilkan po dan po luar
    public function lppb()
    {
        $itemsDalam = DetailPo::select(
            'detail_po.*',
            'purchase_order.no_po',
            'purchase_order.nomor_lppb',
            'purchase_order.tanggal_lppb',
            DB::raw("'dalam' as sumber")
        )
            ->leftJoin('purchase_order', 'purchase_order.id', '=', 'detail_po.id_po')
            ->whereNotNull('purchase_order.id')  // hanya yg join berhasil
            ->groupBy('detail_po.id_po')
            ->get()
            ->filter(function ($item) {
                return $item->nomor_lppb || $item->no_po;  // hanya item yg punya nilai
            });

        foreach ($itemsDalam as $item) {
            $po = Purchase_Order::find($item->id_po);
            if ($po) {
                $id_pr = explode(',', $po->pr_id);
                $item->no_pr = PurchaseRequest::whereIn('id', $id_pr)->pluck('no_pr')->implode(', ');
                $item->tipe = $po->tipe == 0 ? 'PO' : 'PO/PL';
            } else {
                $item->no_pr = '-';
                $item->tipe = '-';
            }
        }

        $itemsLuar = DetailPoluar::select(
            'detail_poluar.*',
            'purchase_orderluar.no_poluar as no_po',
            'purchase_orderluar.nomor_lppb',
            'purchase_orderluar.tanggal_lppb',
            DB::raw("'luar' as sumber")
        )
            ->leftJoin('purchase_orderluar', 'purchase_orderluar.id', '=', 'detail_poluar.id_poluar')
            ->whereNotNull('purchase_orderluar.id')
            ->groupBy('detail_poluar.id_poluar')
            ->get()
            ->filter(function ($item) {
                return $item->nomor_lppb || $item->no_po;
            });

        foreach ($itemsLuar as $item) {
            $po = Purchase_Orderluar::find($item->id_poluar);
            if ($po) {
                $id_pr = explode(',', $po->pr_id);
                $item->no_pr = PurchaseRequest::whereIn('id', $id_pr)->pluck('no_pr')->implode(', ');
                $item->tipe = $po->tipe == 0 ? 'PO' : 'PO/PL';
            } else {
                $item->no_pr = '-';
                $item->tipe = '-';
            }
        }

        // Gabungkan dan paginasi
        $itemsGabungan = $itemsDalam->merge($itemsLuar)->values();

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentItems = $itemsGabungan->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $items = new LengthAwarePaginator($currentItems, $itemsGabungan->count(), $perPage, $currentPage, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);

        return view('lppb.index', compact('items'));
    }

    // End Baru , menampilkan po dan po luar

    // Asli, Jangan Dihapus!!!!
    // public function getDetailLppb(Request $request)
    // {
    //     //cari di tabel detail_po berdasarkan id_po dari $request->id_po
    //     $po = DetailPo::where('detail_po.id_po', $request->id);

    //     $ids = $po->pluck('id_detail_pr');
    //     $id = $po->select('detail_po.*', 'detail_pr.id_pr')->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_po.id_detail_pr')->first()->id_pr;
    //     //then hasil dari $ids berupa array, misal [1,2] lalu taroh di detail_pr

    //     $pr = PurchaseRequest::select('purchase_request.*', 'kontrak.nama_pekerjaan as nama_proyek')
    //         ->join('kontrak', 'kontrak.id', '=', 'purchase_request.proyek_id')
    //         ->where('purchase_request.id', $id)
    //         ->first();

    //     // $pr = collect();
    //     $pr->id_po_woi = $request->id;
    //     //cari item PR berdasarkan $ids isine [1,2,3] dll
    //     // dd($ids);
    //     $pr->details = DetailPR::whereIn('id', $ids)->get();
    //     // $pr->details = DetailPR::where('id_pr', $id)->leftJoin('kode_material', 'kode_material.id', '=', 'detail_pr.kode_material_id')->get();
    //     // dd($pr->details);
    //     $pr->details = $pr->details->map(function ($item) use ($request) {
    //         $item->spek = $item->spek ? $item->spek : '';
    //         $item->keterangan = $item->keterangan ? $item->keterangan : '';
    //         $item->kode_material = $item->kode_material ? $item->kode_material : '';
    //         $item->nomor_spph = Spph::where('id', $item->id_spph)->first()->nomor_spph ?? '';
    //         $item->no_po = Purchase_Order::where('id', $request->id)->first()->no_po ?? '';
    //         $item->no_pr = PurchaseRequest::where('id', $item->id_pr)->first()->no_pr ?? '';
    //         $item->userRole = User::where('id', $item->user_id)->first()->role ?? '';
    //         $item->no_sph = $item->no_sph ? $item->no_sph : '';
    //         $item->tanggal_sph = $item->tanggal_sph ? $item->tanggal_sph : '';
    //         $item->no_just = $item->no_just ? $item->no_just : '';
    //         $item->tanggal_just = $item->tanggal_just ? $item->tanggal_just : '';
    //         $item->no_nego1 = $item->no_nego1 ? $item->no_nego1 : '';
    //         $item->tanggal_nego1 = $item->tanggal_nego1 ? $item->tanggal_nego1 : '';
    //         $item->batas_nego1 = $item->batas_nego1 ? $item->batas_nego1 : '';
    //         $item->no_nego2 = $item->no_nego2 ? $item->no_nego2 : '';
    //         $item->tanggal_nego2 = $item->tanggal_nego2 ? $item->tanggal_nego2 : '';
    //         $item->batas_nego2 = $item->batas_nego2 ? $item->batas_nego2 : '';
    //         $item->batas_akhir = Purchase_Order::leftjoin('detail_po', 'detail_po.id_po', '=', 'purchase_order.id')->where('detail_po.id_detail_pr', $item->id)->first()->batas_akhir ?? '-';

    //         $po = Purchase_Order::where('id', $request->id)->first();
    //         // dd($po);
    //         $split_proyek = explode(',', $po->proyek_id);
    //         // dd($split_proyek);
    //         $proyek_names = Kontrak::whereIn('id', $split_proyek)->pluck('nama_pekerjaan')->toArray();
    //         // dd($proyek_names);
    //         $item->proyeks = implode(',', $proyek_names);
    //         // dd($item->proyek);

    //         $ekspedisi = RegistrasiBarang::where('id_barang', $item->id)->first();
    //         if ($ekspedisi) {
    //             $keterangan = $ekspedisi->keterangan;
    //             $tanggal = $ekspedisi->created_at;
    //             $tanggal = Carbon::parse($tanggal)->isoFormat('D MMMM Y');
    //             $keterangan = $keterangan . ', ' . $tanggal;
    //         } else {
    //             $keterangan = null;
    //         }
    //         $item->ekspedisi = $keterangan;

    //         //qc
    //         if ($ekspedisi) {
    //             $qc = Lppb::where('id_registrasi_barang', $ekspedisi->id)->first();
    //         } else {
    //             $qc = null;
    //         }

    //         if ($qc) {
    //             $penerimaan = $qc->penerimaan;
    //             $hasil_ok = $qc->hasil_ok;
    //             $hasil_nok = $qc->hasil_nok;
    //             $tanggal_qc = $qc->created_at;
    //             $tanggal_qc = Carbon::parse($qc->created_at)->isoFormat('D MMMM Y');
    //             $qc = new stdClass();
    //             $qc->penerimaan = $penerimaan;
    //             $qc->hasil_ok = $hasil_ok;
    //             $qc->hasil_nok = $hasil_nok;
    //             $qc->tanggal_qc = $tanggal_qc;
    //         } else {
    //             $penerimaan = null;
    //             $hasil_ok = null;
    //             $hasil_nok = null;
    //             $tanggal_qc = null;
    //             $qc = null;
    //         }

    //         $item->qc = $qc;

    //         $id_po_real = $request->id;
    //         // $detail_pr
    //         $penerimaan_barang = PenerimaanBarang::where('id_detail_pr', $item->id)->where('id_po', $id_po_real)->first();

    //         $item->penerimaan = $penerimaan_barang ? $penerimaan_barang->penerimaan : null;
    //         $item->hasil_ok = $penerimaan_barang ? $penerimaan_barang->hasil_ok : null;
    //         $item->hasil_nok = $penerimaan_barang ? $penerimaan_barang->hasil_nok : null;
    //         $item->diterima_qc = $penerimaan_barang ? $penerimaan_barang->diterima_qc : null;
    //         $item->belum_diterima_qc = $penerimaan_barang ? $penerimaan_barang->belum_diterima_qc : null;
    //         $item->tgl_diterima = $penerimaan_barang ? $penerimaan_barang->tanggal_diterima : null;
    //         $item->diterima_eks = $penerimaan_barang ? $penerimaan_barang->diterima_eks : null;
    //         $item->belum_diterima_eks = $penerimaan_barang ? $penerimaan_barang->belum_diterima_eks : null;

    //         // Check if logistics is done (diterima_eks is not null and not empty)
    //         $isLogisticsDone = !empty($item->diterima_eks) && $item->diterima_eks !== null && $item->diterima_eks !== '-';

    //         if ($isLogisticsDone) {
    //             // If logistics is done, show completed status
    //             $item->countdown = "COMPLETED";
    //             $item->backgroundcolor = "#008000"; // Green background
    //         } else {
    //             //countdown = waktu - date now
    //             $targetDate = Carbon::parse($item->waktu);
    //             $currentDate = Carbon::now();
    //             $diff = $currentDate->diff($targetDate);
    //             $remainingDays = $diff->days;

    //             $referenceDate = Carbon::parse($item->waktu); // Change this to your desired reference date

    //             if ($currentDate->lessThan($referenceDate)) {
    //                 // If the current date is before the reference date
    //                 $item->countdown = "$remainingDays  Hari Sebelum Waktu Penyelesaian";
    //                 $item->backgroundcolor = "#008000"; // Green background
    //             } elseif ($currentDate->greaterThanOrEqualTo($referenceDate)) {
    //                 // If the current date is on or after the reference date
    //                 $item->countdown = "$remainingDays Hari Setelah Waktu Penyelesaian";
    //                 $item->backgroundcolor = "#FF0000"; // Red background
    //             }
    //         }

    //         return $item;
    //     });
    //     return response()->json([
    //         'pr' => $pr
    //     ]);
    // }

    // asli
    // public function getDetailLppb(Request $request)
    // {
    //     $type_po = $request->type_po;

    //     // --- CEK PO DALAM ---
    //     $poDalam = DetailPo::where('detail_po.id_po', $request->id);

    //     // --- CEK PO LUAR ---
    //     $poLuar = DetailPoluar::where('detail_poluar.id_poluar', $request->id);

    //     if ($type_po == 'PO') {
    //         // Kalau PO Dalam
    //         $po = $poDalam;
    //         $ids = $po->pluck('id_detail_pr');

    //         $id = $po->select('detail_po.*', 'detail_pr.id_pr')
    //             ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_po.id_detail_pr')
    //             ->first()
    //             ->id_pr;

    //         $purchaseOrder = Purchase_Order::find($request->id);
    //     } elseif ($type_po == 'POLUAR') {
    //         // Kalau PO Luar
    //         $po = $poLuar;
    //         $ids = $po->pluck('id_detail_pr');

    //         $id = $po->select('detail_poluar.*', 'detail_pr.id_pr')
    //             ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_poluar.id_detail_pr')
    //             ->first()
    //             ->id_pr;

    //         $purchaseOrder = Purchase_Orderluar::find($request->id);
    //     } else {
    //         return response()->json([
    //             'error' => 'Data PR tidak ditemukan untuk PO ini'
    //         ], 404);
    //     }

    //     // --- AMBIL DATA PR ---
    //     $pr = PurchaseRequest::select('purchase_request.*', 'kontrak.nama_pekerjaan as nama_proyek')
    //         ->join('kontrak', 'kontrak.id', '=', 'purchase_request.proyek_id')
    //         ->where('purchase_request.id', $id)
    //         ->first();

    //     $pr->id_po_woi = $request->id;

    //     // --- AMBIL DETAIL PR ---
    //     $pr->details = DetailPR::whereIn('id', $ids)->get();

    //     $pr->details = $pr->details->map(function ($item) use ($request, $purchaseOrder) {
    //         $item->spek = $item->spek ?? '';
    //         $item->keterangan = $item->keterangan ?? '';
    //         $item->kode_material = $item->kode_material ?? '';
    //         $item->nomor_spph = Spph::where('id', $item->id_spph)->value('nomor_spph') ?? '';
    //         // $item->no_po = $purchaseOrder->no_po ?? '';
    //         $item->no_po = $purchaseOrder->no_po ?? $purchaseOrder->no_poluar ?? '';
    //         $item->no_pr = PurchaseRequest::where('id', $item->id_pr)->value('no_pr') ?? '';
    //         $item->userRole = User::where('id', $item->user_id)->value('role') ?? '';
    //         $item->no_sph = $item->no_sph ?? '';
    //         $item->tanggal_sph = $item->tanggal_sph ?? '';
    //         $item->no_just = $item->no_just ?? '';
    //         $item->tanggal_just = $item->tanggal_just ?? '';
    //         $item->no_nego1 = $item->no_nego1 ?? '';
    //         $item->tanggal_nego1 = $item->tanggal_nego1 ?? '';
    //         $item->batas_nego1 = $item->batas_nego1 ?? '';
    //         $item->no_nego2 = $item->no_nego2 ?? '';
    //         $item->tanggal_nego2 = $item->tanggal_nego2 ?? '';
    //         $item->batas_nego2 = $item->batas_nego2 ?? '';

    //         // --- BATAS AKHIR ---
    //         $batas_akhir_dalam = Purchase_Order::leftJoin('detail_po', 'detail_po.id_po', '=', 'purchase_order.id')
    //             ->where('detail_po.id_detail_pr', $item->id)
    //             ->value('batas_akhir');

    //         $batas_akhir_luar = Purchase_Orderluar::leftJoin('detail_poluar', 'detail_poluar.id_poluar', '=', 'purchase_orderluar.id')
    //             ->where('detail_poluar.id_detail_pr', $item->id)
    //             ->value('batas_akhir');

    //         $item->batas_akhir = $batas_akhir_dalam ?? $batas_akhir_luar ?? '-';

    //         // --- PROYEK ---
    //         $split_proyek = explode(',', $purchaseOrder->proyek_id ?? '');
    //         $proyek_names = Kontrak::whereIn('id', $split_proyek)->pluck('nama_pekerjaan')->toArray();
    //         $item->proyeks = implode(',', $proyek_names);

    //         // --- EKSPEDISI ---
    //         $ekspedisi = RegistrasiBarang::where('id_barang', $item->id)->first();
    //         if ($ekspedisi) {
    //             $tanggal = Carbon::parse($ekspedisi->created_at)->isoFormat('D MMMM Y');
    //             $item->ekspedisi = $ekspedisi->keterangan . ', ' . $tanggal;
    //         } else {
    //             $item->ekspedisi = null;
    //         }

    //         // --- QC ---
    //         if ($ekspedisi) {
    //             $qcData = Lppb::where('id_registrasi_barang', $ekspedisi->id)->first();
    //         } else {
    //             $qcData = null;
    //         }

    //         if ($qcData) {
    //             $qc = new stdClass();
    //             $qc->penerimaan = $qcData->penerimaan;
    //             $qc->hasil_ok = $qcData->hasil_ok;
    //             $qc->hasil_nok = $qcData->hasil_nok;
    //             $qc->tanggal_qc = Carbon::parse($qcData->created_at)->isoFormat('D MMMM Y');
    //         } else {
    //             $qc = null;
    //         }

    //         $item->qc = $qc;

    //         // --- PENERIMAAN BARANG ---
    //         $penerimaan_barang = PenerimaanBarang::where('id_detail_pr', $item->id)
    //             ->where('id_po', $request->id)
    //             ->first();

    //         $item->penerimaan = $penerimaan_barang->penerimaan ?? null;
    //         $item->hasil_ok = $penerimaan_barang->hasil_ok ?? null;
    //         $item->hasil_nok = $penerimaan_barang->hasil_nok ?? null;
    //         $item->diterima_qc = $penerimaan_barang->diterima_qc ?? null;
    //         $item->belum_diterima_qc = $penerimaan_barang->belum_diterima_qc ?? null;
    //         $item->tgl_diterima = $penerimaan_barang->tanggal_diterima ?? null;
    //         $item->diterima_eks = $penerimaan_barang->diterima_eks ?? null;
    //         $item->belum_diterima_eks = $penerimaan_barang->belum_diterima_eks ?? null;

    //         // --- COUNTDOWN ---
    //         $isLogisticsDone = !empty($item->diterima_eks) && $item->diterima_eks !== null && $item->diterima_eks !== '-';

    //         if ($isLogisticsDone) {
    //             $item->countdown = "COMPLETED";
    //             $item->backgroundcolor = "#008000"; // Hijau
    //         } else {
    //             if (!empty($item->waktu)) {
    //                 $targetDate = Carbon::parse($item->waktu);
    //                 $currentDate = Carbon::now();
    //                 $diff = $currentDate->diff($targetDate);
    //                 $remainingDays = $diff->days;

    //                 if ($currentDate->lessThan($targetDate)) {
    //                     $item->countdown = "$remainingDays Hari Sebelum Waktu Penyelesaian";
    //                     $item->backgroundcolor = "#008000";
    //                 } else {
    //                     $item->countdown = "$remainingDays Hari Setelah Waktu Penyelesaian";
    //                     $item->backgroundcolor = "#FF0000";
    //                 }
    //             } else {
    //                 $item->countdown = "-";
    //                 $item->backgroundcolor = "#808080"; // abu-abu
    //             }
    //         }

    //         return $item;
    //     });

    //     return response()->json([
    //         'pr' => $pr
    //     ]);
    // }

    // coba coba
    public function getDetailLppb(Request $request)
    {
        $type_po = $request->type_po;

        if ($type_po == 'PO') {
            // --- PO Dalam ---
            $po = DetailPo::where('detail_po.id_po', $request->id);

            $ids = $po->pluck('id_detail_pr');

            $id = $po
                ->select('detail_po.*', 'detail_pr.id_pr')
                ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_po.id_detail_pr')
                ->first()
                ->id_pr;

            $purchaseOrder = Purchase_Order::find($request->id);
        } elseif ($type_po == 'POLUAR') {
            // --- PO Luar ---
            $po = DetailPoluar::where('detail_poluar.id_poluar', $request->id);

            $ids = $po->pluck('id_detail_pr');

            $id = $po
                ->select('detail_poluar.*', 'detail_pr.id_pr')
                ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_poluar.id_detail_pr')
                ->first()
                ->id_pr;

            $purchaseOrder = Purchase_Orderluar::find($request->id);
        } else {
            return response()->json([
                'error' => 'Data PR tidak ditemukan untuk PO ini'
            ], 404);
        }

        // --- Ambil Data PR ---
        $pr = PurchaseRequest::select('purchase_request.*', 'kontrak.nama_pekerjaan as nama_proyek')
            ->join('kontrak', 'kontrak.id', '=', 'purchase_request.proyek_id')
            ->where('purchase_request.id', $id)
            ->first();

        $pr->id_po_woi = $request->id;

        // --- Ambil Detail PR ---
        $pr->details = DetailPR::whereIn('id', $ids)->get();

        $pr->details = $pr->details->map(function ($item) use ($request, $purchaseOrder, $type_po) {
            $item->spek = $item->spek ?? '';
            $item->kode_material = $item->kode_material ?? '';
            $item->no_po = $purchaseOrder->no_po ?? $purchaseOrder->no_poluar ?? '';
            $item->no_pr = PurchaseRequest::where('id', $item->id_pr)->value('no_pr') ?? '';

            // --- Proyek ---
            $split_proyek = explode(',', $purchaseOrder->proyek_id ?? '');
            $proyek_names = Kontrak::whereIn('id', $split_proyek)->pluck('nama_pekerjaan')->toArray();
            $item->proyeks = implode(',', $proyek_names);

            // --- Penerimaan Barang (dibedakan untuk PO & POLUAR) ---
            if ($type_po == 'PO') {
                $penerimaan_barang = PenerimaanBarang::where('id_detail_pr', $item->id)
                    ->where('id_po', $request->id)
                    ->first();
            } else {
                $penerimaan_barang = PenerimaanBarang::where('id_detail_pr', $item->id)
                    ->where('id_poluar', $request->id)
                    ->first();
            }

            $item->penerimaan = $penerimaan_barang->penerimaan ?? null;
            $item->hasil_ok = $penerimaan_barang->hasil_ok ?? null;
            $item->hasil_nok = $penerimaan_barang->hasil_nok ?? null;
            $item->diterima_qc = $penerimaan_barang->diterima_qc ?? null;
            $item->belum_diterima_qc = $penerimaan_barang->belum_diterima_qc ?? null;
            $item->tgl_diterima = $penerimaan_barang->tanggal_diterima ?? null;

            return $item;
        });

        return response()->json([
            'pr' => $pr
        ]);
    }

    // asli
    // public function getDetailPenerimaanBarang(Request $request)
    // {
    //     $type_po = $request->type_po;

    //     // --- CEK PO DALAM ---
    //     $poDalam = DetailPo::where('detail_po.id_po', $request->id);

    //     // --- CEK PO LUAR ---
    //     $poLuar = DetailPoluar::where('detail_poluar.id_poluar', $request->id);

    //     if ($type_po == 'PO') {
    //         // --- DALAM ---
    //         $po = $poDalam;
    //         $ids = $po->pluck('id_detail_pr');

    //         $id = $po->select('detail_po.*', 'detail_pr.id_pr')
    //             ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_po.id_detail_pr')
    //             ->first()
    //             ->id_pr;

    //         $purchaseOrder = Purchase_Order::find($request->id);
    //     } elseif ($type_po == 'POLUAR') {
    //         // --- LUAR ---
    //         $po = $poLuar;
    //         $ids = $po->pluck('id_detail_pr');

    //         $id = $po->select('detail_poluar.*', 'detail_pr.id_pr')
    //             ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_poluar.id_detail_pr')
    //             ->first()
    //             ->id_pr;

    //         $purchaseOrder = Purchase_Orderluar::find($request->id);
    //     } else {
    //         return response()->json([
    //             'error' => 'Data PR tidak ditemukan untuk PO ini'
    //         ], 404);
    //     }

    //     // --- AMBIL DATA PR ---
    //     $pr = PurchaseRequest::select('purchase_request.*', 'kontrak.nama_pekerjaan as nama_proyek')
    //         ->join('kontrak', 'kontrak.id', '=', 'purchase_request.proyek_id')
    //         ->where('purchase_request.id', $id)
    //         ->first();

    //     $pr->id_po_woi = $request->id;

    //     // --- DETAIL PR ---
    //     $pr->details = DetailPR::whereIn('id', $ids)->get();

    //     $pr->details = $pr->details->map(function ($item) use ($request, $purchaseOrder, $type_po) {
    //         $item->spek = $item->spek ?? '';
    //         $item->keterangan = $item->keterangan ?? '';
    //         $item->kode_material = $item->kode_material ?? '';
    //         $item->nomor_spph = Spph::where('id', $item->id_spph)->value('nomor_spph') ?? '';
    //         $item->no_po = $purchaseOrder->no_po ?? $purchaseOrder->no_poluar ?? '';
    //         $item->no_pr = PurchaseRequest::where('id', $item->id_pr)->value('no_pr') ?? '';
    //         $item->userRole = User::where('id', $item->user_id)->value('role') ?? '';
    //         $item->no_sph = $item->no_sph ?? '';
    //         $item->tanggal_sph = $item->tanggal_sph ?? '';
    //         $item->no_just = $item->no_just ?? '';
    //         $item->tanggal_just = $item->tanggal_just ?? '';
    //         $item->no_nego1 = $item->no_nego1 ?? '';
    //         $item->tanggal_nego1 = $item->tanggal_nego1 ?? '';
    //         $item->batas_nego1 = $item->batas_nego1 ?? '';
    //         $item->no_nego2 = $item->no_nego2 ?? '';
    //         $item->tanggal_nego2 = $item->tanggal_nego2 ?? '';
    //         $item->batas_nego2 = $item->batas_nego2 ?? '';

    //         // --- BATAS AKHIR ---
    //         if ($type_po == 'PO') {
    //             $item->batas_akhir = Purchase_Order::leftJoin('detail_po', 'detail_po.id_po', '=', 'purchase_order.id')
    //                 ->where('detail_po.id_detail_pr', $item->id)
    //                 ->value('batas_akhir') ?? '-';
    //         } else {
    //             $item->batas_akhir = Purchase_Orderluar::leftJoin('detail_poluar', 'detail_poluar.id_poluar', '=', 'purchase_orderluar.id')
    //                 ->where('detail_poluar.id_detail_pr', $item->id)
    //                 ->value('batas_akhir') ?? '-';
    //         }

    //         // --- VENDOR ---
    //         $vendor = null;
    //         if ($type_po == 'PO') {
    //             $vendor = Purchase_Order::leftJoin('vendor', 'purchase_order.vendor_id', '=', 'vendor.id')
    //                 ->select('purchase_order.*', 'vendor.nama as nama')
    //                 ->where('purchase_order.id', $request->id)
    //                 ->first();
    //         } else {
    //             $vendor = Purchase_Orderluar::leftJoin('vendor', 'purchase_orderluar.vendor_id', '=', 'vendor.id')
    //                 ->select('purchase_orderluar.*', 'vendor.nama as nama')
    //                 ->where('purchase_orderluar.id', $request->id)
    //                 ->first();
    //         }
    //         $item->nama = $vendor->nama ?? '';

    //         // --- PROYEK ---
    //         $split_proyek = explode(',', $purchaseOrder->proyek_id ?? '');
    //         $proyek_names = Kontrak::whereIn('id', $split_proyek)->pluck('nama_pekerjaan')->toArray();
    //         $item->proyeks = implode(',', $proyek_names);

    //         // --- EKSPEDISI ---
    //         $ekspedisi = RegistrasiBarang::where('id_barang', $item->id)->first();
    //         if ($ekspedisi) {
    //             $tanggal = Carbon::parse($ekspedisi->created_at)->isoFormat('D MMMM Y');
    //             $item->ekspedisi = $ekspedisi->keterangan . ', ' . $tanggal;
    //         } else {
    //             $item->ekspedisi = null;
    //         }

    //         // --- QC ---
    //         $qcData = $ekspedisi ? Lppb::where('id_registrasi_barang', $ekspedisi->id)->first() : null;
    //         if ($qcData) {
    //             $qc = new stdClass();
    //             $qc->penerimaan = $qcData->penerimaan;
    //             $qc->hasil_ok = $qcData->hasil_ok;
    //             $qc->hasil_nok = $qcData->hasil_nok;
    //             $qc->tanggal_qc = Carbon::parse($qcData->created_at)->isoFormat('D MMMM Y');
    //             $item->qc = $qc;
    //         } else {
    //             $item->qc = null;
    //         }

    //         // --- PENERIMAAN BARANG ---
    //         $penerimaan_barang = PenerimaanBarang::where('id_detail_pr', $item->id)
    //             ->where('id_po', $request->id)
    //             ->first();

    //         $item->diterima_eks = $penerimaan_barang->diterima_eks ?? null;
    //         $item->belum_diterima_eks = $penerimaan_barang->belum_diterima_eks ?? null;
    //         $item->diterima_qc = $penerimaan_barang->diterima_qc ?? null;
    //         $item->belum_diterima_qc = $penerimaan_barang->belum_diterima_qc ?? null;
    //         $item->tanggal_diterima = $penerimaan_barang->tanggal_diterima ?? null;

    //         // --- COUNTDOWN ---
    //         $isLogisticsDone = !empty($item->diterima_eks) && $item->diterima_eks !== '-';

    //         if ($isLogisticsDone) {
    //             $item->countdown = "Telah diproses";
    //             $item->backgroundcolor = "#008000"; // hijau
    //         } else {
    //             if (!empty($item->waktu)) {
    //                 $targetDate = Carbon::parse($item->waktu);
    //                 $currentDate = Carbon::now();
    //                 $diff = $currentDate->diff($targetDate);
    //                 $remainingDays = $diff->days;

    //                 if ($currentDate->lessThan($targetDate)) {
    //                     $item->countdown = "$remainingDays Hari Sebelum Waktu Penyelesaian";
    //                     $item->backgroundcolor = "#008000";
    //                 } else {
    //                     $item->countdown = "$remainingDays Hari Setelah Waktu Penyelesaian";
    //                     $item->backgroundcolor = "#FF0000";
    //                 }
    //             } else {
    //                 $item->countdown = "-";
    //                 $item->backgroundcolor = "#808080";
    //             }
    //         }

    //         return $item;
    //     });

    //     return response()->json([
    //         'pr' => $pr
    //     ]);
    // }

    // coba coba
    public function getDetailPenerimaanBarang(Request $request)
    {
        $type_po = $request->type_po;

        // --- CEK PO DALAM ---
        $poDalam = DetailPo::where('detail_po.id_po', $request->id);

        // --- CEK PO LUAR ---
        $poLuar = DetailPoluar::where('detail_poluar.id_poluar', $request->id);

        if ($type_po == 'PO') {
            $po = $poDalam;
            $ids = $po->pluck('id_detail_pr');

            $id = $po
                ->select('detail_po.*', 'detail_pr.id_pr')
                ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_po.id_detail_pr')
                ->first()
                ->id_pr;

            $purchaseOrder = Purchase_Order::find($request->id);
        } elseif ($type_po == 'POLUAR') {
            $po = $poLuar;
            $ids = $po->pluck('id_detail_pr');

            $id = $po
                ->select('detail_poluar.*', 'detail_pr.id_pr')
                ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_poluar.id_detail_pr')
                ->first()
                ->id_pr;

            $purchaseOrder = Purchase_Orderluar::find($request->id);
        } else {
            return response()->json([
                'error' => 'Data PR tidak ditemukan untuk PO ini'
            ], 404);
        }

        // --- AMBIL DATA PR ---
        $pr = PurchaseRequest::select('purchase_request.*', 'kontrak.nama_pekerjaan as nama_proyek')
            ->join('kontrak', 'kontrak.id', '=', 'purchase_request.proyek_id')
            ->where('purchase_request.id', $id)
            ->first();

        $pr->id_po_woi = $request->id;

        // --- DETAIL PR ---
        $pr->details = DetailPR::whereIn('id', $ids)->get();

        $pr->details = $pr->details->map(function ($item) use ($request, $purchaseOrder, $type_po) {
            $item->spek = $item->spek ?? '';
            $item->keterangan = $item->keterangan ?? '';
            $item->kode_material = $item->kode_material ?? '';
            $item->nomor_spph = Spph::where('id', $item->id_spph)->value('nomor_spph') ?? '';
            $item->no_po = $purchaseOrder->no_po ?? $purchaseOrder->no_poluar ?? '';
            $item->no_pr = PurchaseRequest::where('id', $item->id_pr)->value('no_pr') ?? '';
            $item->userRole = User::where('id', $item->user_id)->value('role') ?? '';
            $item->no_sph = $item->no_sph ?? '';
            $item->tanggal_sph = $item->tanggal_sph ?? '';
            $item->no_just = $item->no_just ?? '';
            $item->tanggal_just = $item->tanggal_just ?? '';
            $item->no_nego1 = $item->no_nego1 ?? '';
            $item->tanggal_nego1 = $item->tanggal_nego1 ?? '';
            $item->batas_nego1 = $item->batas_nego1 ?? '';
            $item->no_nego2 = $item->no_nego2 ?? '';
            $item->tanggal_nego2 = $item->tanggal_nego2 ?? '';
            $item->batas_nego2 = $item->batas_nego2 ?? '';

            // --- BATAS AKHIR ---
            if ($type_po == 'PO') {
                $item->batas_akhir = Purchase_Order::leftJoin('detail_po', 'detail_po.id_po', '=', 'purchase_order.id')
                    ->where('detail_po.id_detail_pr', $item->id)
                    ->value('batas_akhir') ?? '-';
            } else {
                $item->batas_akhir = Purchase_Orderluar::leftJoin('detail_poluar', 'detail_poluar.id_poluar', '=', 'purchase_orderluar.id')
                    ->where('detail_poluar.id_detail_pr', $item->id)
                    ->value('batas_akhir') ?? '-';
            }

            // --- VENDOR ---
            if ($type_po == 'PO') {
                $vendor = Purchase_Order::leftJoin('vendor', 'purchase_order.vendor_id', '=', 'vendor.id')
                    ->select('purchase_order.*', 'vendor.nama as nama')
                    ->where('purchase_order.id', $request->id)
                    ->first();
            } else {
                $vendor = Purchase_Orderluar::leftJoin('vendor', 'purchase_orderluar.vendor_id', '=', 'vendor.id')
                    ->select('purchase_orderluar.*', 'vendor.nama as nama')
                    ->where('purchase_orderluar.id', $request->id)
                    ->first();
            }
            $item->nama = $vendor->nama ?? '';

            // --- PROYEK ---
            $split_proyek = explode(',', $purchaseOrder->proyek_id ?? '');
            $proyek_names = Kontrak::whereIn('id', $split_proyek)->pluck('nama_pekerjaan')->toArray();
            $item->proyeks = implode(',', $proyek_names);

            // --- EKSPEDISI ---
            $ekspedisi = RegistrasiBarang::where('id_barang', $item->id)->first();
            if ($ekspedisi) {
                $tanggal = Carbon::parse($ekspedisi->created_at)->isoFormat('D MMMM Y');
                $item->ekspedisi = $ekspedisi->keterangan . ', ' . $tanggal;
            } else {
                $item->ekspedisi = '-';
            }

            // --- QC ---
            $qcData = $ekspedisi ? Lppb::where('id_registrasi_barang', $ekspedisi->id)->first() : null;
            if ($qcData) {
                $qc = new stdClass();
                $qc->penerimaan = $qcData->penerimaan ?? '-';
                $qc->hasil_ok = $qcData->hasil_ok ?? '-';
                $qc->hasil_nok = $qcData->hasil_nok ?? '-';
                $qc->tanggal_qc = Carbon::parse($qcData->created_at)->isoFormat('D MMMM Y');
                $item->qc = $qc;
            } else {
                $item->qc = null;
            }

            // --- PENERIMAAN BARANG ---
            if ($type_po == 'PO') {
                $penerimaan_barang = PenerimaanBarang::where('id_detail_pr', $item->id)
                    ->where('id_po', $request->id)
                    ->first();
            } else {
                $penerimaan_barang = PenerimaanBarang::where('id_detail_pr', $item->id)
                    ->where('id_poluar', $request->id)
                    ->first();
            }

            $item->diterima_eks = optional($penerimaan_barang)->diterima_eks ?? '-';
            $item->belum_diterima_eks = optional($penerimaan_barang)->belum_diterima_eks ?? '-';
            $item->diterima_qc = optional($penerimaan_barang)->diterima_qc ?? '-';
            $item->belum_diterima_qc = optional($penerimaan_barang)->belum_diterima_qc ?? '-';
            $item->tanggal_diterima = optional($penerimaan_barang)->tanggal_diterima ?? '-';

            // --- COUNTDOWN ---
            $isLogisticsDone = !empty($item->diterima_eks) && $item->diterima_eks !== '-';

            if ($isLogisticsDone) {
                $item->countdown = 'Telah diproses';
                $item->backgroundcolor = '#008000';  // hijau
            } else {
                if (!empty($item->waktu)) {
                    $targetDate = Carbon::parse($item->waktu);
                    $currentDate = Carbon::now();
                    $diff = $currentDate->diff($targetDate);
                    $remainingDays = $diff->days;

                    if ($currentDate->lessThan($targetDate)) {
                        $item->countdown = "$remainingDays Hari Sebelum Waktu Penyelesaian";
                        $item->backgroundcolor = '#008000';
                    } else {
                        $item->countdown = "$remainingDays Hari Setelah Waktu Penyelesaian";
                        $item->backgroundcolor = '#FF0000';
                    }
                } else {
                    $item->countdown = '-';
                    $item->backgroundcolor = '#808080';
                }
            }

            return $item;
        });

        return response()->json([
            'pr' => $pr
        ]);
    }

    // public function getDetailPenerimaanBarang(Request $request)
    // {
    //     //cari di tabel detail_po berdasarkan id_po dari $request->id_po
    //     $po = DetailPo::where('detail_po.id_po', $request->id);

    //     $ids = $po->pluck('id_detail_pr');
    //     $id = $po->select('detail_po.*', 'detail_pr.id_pr')->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_po.id_detail_pr')->first()->id_pr;
    //     //then hasil dari $ids berupa array, misal [1,2] lalu taroh di detail_pr

    //     $pr = PurchaseRequest::select('purchase_request.*', 'kontrak.nama_pekerjaan as nama_proyek')
    //         ->join('kontrak', 'kontrak.id', '=', 'purchase_request.proyek_id')
    //         ->where('purchase_request.id', $id)
    //         ->first();
    //     $pr->id_po_woi = $request->id;
    //     //cari item PR berdasarkan $ids isine [1,2,3] dll
    //     $pr->details = DetailPR::whereIn('id', $ids)->get();
    //     // $pr->details = DetailPR::where('id_pr', $id)->leftJoin('kode_material', 'kode_material.id', '=', 'detail_pr.kode_material_id')->get();
    //     $pr->details = $pr->details->map(function ($item) use ($request) {
    //         $item->spek = $item->spek ? $item->spek : '';
    //         $item->keterangan = $item->keterangan ? $item->keterangan : '';
    //         $item->kode_material = $item->kode_material ? $item->kode_material : '';
    //         $item->nomor_spph = Spph::where('id', $item->id_spph)->first()->nomor_spph ?? '';
    //         $item->no_po = Purchase_Order::where('id', $request->id)->first()->no_po ?? '';
    //         $item->no_pr = PurchaseRequest::where('id', $item->id_pr)->first()->no_pr ?? '';
    //         $item->userRole = User::where('id', $item->user_id)->first()->role ?? '';
    //         $item->no_sph = $item->no_sph ? $item->no_sph : '';
    //         $item->tanggal_sph = $item->tanggal_sph ? $item->tanggal_sph : '';
    //         $item->no_just = $item->no_just ? $item->no_just : '';
    //         $item->tanggal_just = $item->tanggal_just ? $item->tanggal_just : '';
    //         $item->no_nego1 = $item->no_nego1 ? $item->no_nego1 : '';
    //         $item->tanggal_nego1 = $item->tanggal_nego1 ? $item->tanggal_nego1 : '';
    //         $item->batas_nego1 = $item->batas_nego1 ? $item->batas_nego1 : '';
    //         $item->no_nego2 = $item->no_nego2 ? $item->no_nego2 : '';
    //         $item->tanggal_nego2 = $item->tanggal_nego2 ? $item->tanggal_nego2 : '';
    //         $item->batas_nego2 = $item->batas_nego2 ? $item->batas_nego2 : '';
    //         $item->batas_akhir = Purchase_Order::leftjoin('detail_po', 'detail_po.id_po', '=', 'purchase_order.id')->where('detail_po.id_detail_pr', $item->id)->first()->batas_akhir ?? '-';

    //         //Menampilkan nama vendor
    //         $purchaseOrder = Purchase_Order::leftJoin('vendor', 'purchase_order.vendor_id', '=', 'vendor.id')
    //             ->select('purchase_order.*', 'vendor.nama as nama')
    //             ->where('purchase_order.id', $request->id)
    //             ->first();

    //         $item->nama = $purchaseOrder ? $purchaseOrder->nama : '';

    //         $po = Purchase_Order::where('id', $request->id)->first();
    //         // dd($po);
    //         $split_proyek = explode(',', $po->proyek_id);
    //         // dd($split_proyek);
    //         $proyek_names = Kontrak::whereIn('id', $split_proyek)->pluck('nama_pekerjaan')->toArray();
    //         // dd($proyek_names);
    //         $item->proyeks = implode(',', $proyek_names);

    //         $ekspedisi = RegistrasiBarang::where('id_barang', $item->id)->first();
    //         if ($ekspedisi) {
    //             $keterangan = $ekspedisi->keterangan;
    //             $tanggal = $ekspedisi->created_at;
    //             $tanggal = Carbon::parse($tanggal)->isoFormat('D MMMM Y');
    //             $keterangan = $keterangan . ', ' . $tanggal;
    //         } else {
    //             $keterangan = null;
    //         }
    //         $item->ekspedisi = $keterangan;

    //         //qc
    //         if ($ekspedisi) {
    //             $qc = Lppb::where('id_registrasi_barang', $ekspedisi->id)->first();
    //         } else {
    //             $qc = null;
    //         }

    //         if ($qc) {
    //             $penerimaan = $qc->penerimaan;
    //             $hasil_ok = $qc->hasil_ok;
    //             $hasil_nok = $qc->hasil_nok;
    //             $tanggal_qc = $qc->created_at;
    //             $tanggal_qc = Carbon::parse($qc->created_at)->isoFormat('D MMMM Y');
    //             $qc = new stdClass();
    //             $qc->penerimaan = $penerimaan;
    //             $qc->hasil_ok = $hasil_ok;
    //             $qc->hasil_nok = $hasil_nok;
    //             $qc->tanggal_qc = $tanggal_qc;
    //         } else {
    //             $penerimaan = null;
    //             $hasil_ok = null;
    //             $hasil_nok = null;
    //             $tanggal_qc = null;
    //             $qc = null;
    //         }

    //         $item->qc = $qc;

    //         $id_po_real = $request->id;
    //         $penerimaan_barang = PenerimaanBarang::where('id_detail_pr', $item->id)->where('id_po', $id_po_real)->first();
    //         $item->diterima_eks = $penerimaan_barang ? $penerimaan_barang->diterima_eks : null;
    //         $item->belum_diterima_eks = $penerimaan_barang ? $penerimaan_barang->belum_diterima_eks : null;
    //         $item->diterima_qc = $penerimaan_barang ? $penerimaan_barang->diterima_qc : null;
    //         $item->belum_diterima_qc = $penerimaan_barang ? $penerimaan_barang->belum_diterima_qc : null;
    //         $item->tanggal_diterima = $penerimaan_barang ? $penerimaan_barang->tanggal_diterima : null;

    //         // Check if logistics is done (diterima_eks is not null and not empty)
    //         $isLogisticsDone = !empty($item->diterima_eks) && $item->diterima_eks !== null && $item->diterima_eks !== '-';

    //         if ($isLogisticsDone) {
    //             // If logistics is done, show completed status
    //             $item->countdown = "Telah diproses";
    //             $item->backgroundcolor = "#008000"; // Green background
    //         } else {
    //             //countdown = waktu - date now
    //             $targetDate = Carbon::parse($item->waktu);
    //             $currentDate = Carbon::now();
    //             $diff = $currentDate->diff($targetDate);
    //             $remainingDays = $diff->days;

    //             $referenceDate = Carbon::parse($item->waktu); // Change this to your desired reference date

    //             if ($currentDate->lessThan($referenceDate)) {
    //                 // If the current date is before the reference date
    //                 $item->countdown = "$remainingDays  Hari Sebelum Waktu Penyelesaian";
    //                 $item->backgroundcolor = "#008000"; // Green background
    //             } elseif ($currentDate->greaterThanOrEqualTo($referenceDate)) {
    //                 // If the current date is on or after the reference date
    //                 $item->countdown = "$remainingDays Hari Setelah Waktu Penyelesaian";
    //                 $item->backgroundcolor = "#FF0000"; // Red background
    //             }
    //         }

    //         return $item;
    //     });
    //     return response()->json([
    //         'pr' => $pr
    //     ]);
    // }

    // public function getDetailPenerimaanBarang(Request $request)
    // {
    //     //cari di tabel detail_po berdasarkan id_po dari $request->id_po
    //     $po = DetailPo::where('detail_po.id_po', $request->id);

    //     $ids = $po->pluck('id_detail_pr');
    //     $id = $po->select('detail_po.*', 'detail_pr.id_pr')->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_po.id_detail_pr')->first()->id_pr;
    //     //then hasil dari $ids berupa array, misal [1,2] lalu taroh di detail_pr

    //     $pr = PurchaseRequest::select('purchase_request.*', 'kontrak.nama_pekerjaan as nama_proyek')
    //         ->join('kontrak', 'kontrak.id', '=', 'purchase_request.proyek_id')
    //         ->where('purchase_request.id', $id)
    //         ->first();
    //     $pr->id_po_woi = $request->id;
    //     //cari item PR berdasarkan $ids isine [1,2,3] dll
    //     $pr->details = DetailPR::whereIn('id', $ids)->get();
    //     // $pr->details = DetailPR::where('id_pr', $id)->leftJoin('kode_material', 'kode_material.id', '=', 'detail_pr.kode_material_id')->get();
    //     $pr->details = $pr->details->map(function ($item) use($request) {
    //         $item->spek = $item->spek ? $item->spek : '';
    //         $item->keterangan = $item->keterangan ? $item->keterangan : '';
    //         $item->kode_material = $item->kode_material ? $item->kode_material : '';
    //         $item->nomor_spph = Spph::where('id', $item->id_spph)->first()->nomor_spph ?? '';
    //         $item->no_po = Purchase_Order::where('id', $item->id_po)->first()->no_po ?? '';
    //         $item->userRole = User::where('id', $item->user_id)->first()->role ?? '';
    //         $item->no_sph = $item->no_sph ? $item->no_sph : '';
    //         $item->tanggal_sph = $item->tanggal_sph ? $item->tanggal_sph : '';
    //         $item->no_just = $item->no_just ? $item->no_just : '';
    //         $item->tanggal_just = $item->tanggal_just ? $item->tanggal_just : '';
    //         $item->no_nego1 = $item->no_nego1 ? $item->no_nego1 : '';
    //         $item->tanggal_nego1 = $item->tanggal_nego1 ? $item->tanggal_nego1 : '';
    //         $item->batas_nego1 = $item->batas_nego1 ? $item->batas_nego1 : '';
    //         $item->no_nego2 = $item->no_nego2 ? $item->no_nego2 : '';
    //         $item->tanggal_nego2 = $item->tanggal_nego2 ? $item->tanggal_nego2 : '';
    //         $item->batas_nego2 = $item->batas_nego2 ? $item->batas_nego2 : '';
    //         $item->batas_akhir = Purchase_Order::leftjoin('detail_po', 'detail_po.id_po', '=', 'purchase_order.id')->where('detail_po.id_detail_pr', $item->id)->first()->batas_akhir ?? '-';

    //         $po = Purchase_Order::where('id', $request->id)->first();
    //         // dd($po);
    //         $split_proyek = explode(',', $po->proyek_id);
    //         // dd($split_proyek);
    //         $proyek_names = Kontrak::whereIn('id', $split_proyek)->pluck('nama_pekerjaan')->toArray();
    //         // dd($proyek_names);
    //         $item->proyeks = implode(',', $proyek_names);

    //         $ekspedisi = RegistrasiBarang::where('id_barang', $item->id)->first();
    //         if ($ekspedisi) {
    //             $keterangan = $ekspedisi->keterangan;
    //             $tanggal = $ekspedisi->created_at;
    //             $tanggal = Carbon::parse($tanggal)->isoFormat('D MMMM Y');
    //             $keterangan = $keterangan . ', ' . $tanggal;
    //         } else {
    //             $keterangan = null;
    //         }
    //         $item->ekspedisi = $keterangan;

    //         //qc
    //         if ($ekspedisi) {
    //             $qc = Lppb::where('id_registrasi_barang', $ekspedisi->id)->first();
    //         } else {
    //             $qc = null;
    //         }

    //         if ($qc) {
    //             $penerimaan = $qc->penerimaan;
    //             $hasil_ok = $qc->hasil_ok;
    //             $hasil_nok = $qc->hasil_nok;
    //             $tanggal_qc = $qc->created_at;
    //             $tanggal_qc = Carbon::parse($qc->created_at)->isoFormat('D MMMM Y');
    //             $qc = new stdClass();
    //             $qc->penerimaan = $penerimaan;
    //             $qc->hasil_ok = $hasil_ok;
    //             $qc->hasil_nok = $hasil_nok;
    //             $qc->tanggal_qc = $tanggal_qc;
    //         } else {
    //             $penerimaan = null;
    //             $hasil_ok = null;
    //             $hasil_nok = null;
    //             $tanggal_qc = null;
    //             $qc = null;
    //         }

    //         $item->qc = $qc;

    //         //countdown = waktu - date now
    //         $targetDate = Carbon::parse($item->waktu);
    //         $currentDate = Carbon::now();
    //         $diff = $currentDate->diff($targetDate);
    //         $remainingDays = $diff->days;

    //         $referenceDate = Carbon::parse($item->waktu); // Change this to your desired reference date

    //         if ($currentDate->lessThan($referenceDate)) {
    //             // If the current date is before the reference date
    //             $item->countdown = "$remainingDays  Hari Sebelum Waktu Penyelesaian";
    //             $item->backgroundcolor = "#FF0000"; // Red background
    //         } elseif ($currentDate->greaterThanOrEqualTo($referenceDate)) {
    //             // If the current date is on or after the reference date
    //             $item->countdown = "$remainingDays Hari Setelah Waktu Penyelesaian";
    //             $item->backgroundcolor = "#008000"; // Green background
    //         }
    //         return $item;
    //     });
    //     return response()->json([
    //         'pr' => $pr
    //     ]);
    // }

    public function tambah_lppb(Request $request)
    {
        $request->validate([
            'keterangan' => 'nullable',
            'kuantitas_penerimaan' => 'required',
            'baik' => 'required',
            'tidak_baik' => 'required',
        ], [
            'keterangan.required' => 'Keterangan harus diisi',
            'kuantitas_penerimaan.required' => 'Kuantitas penerimaan harus diisi',
            'baik.required' => 'Kuantitas barang baik harus diisi',
            'tidak_baik.required' => 'Kuantitas barang tidak baik harus diisi',
        ]);

        $id = $request->id_barang;
        $id_registrasi_barang = $request->id_registrasi_barang;
        $keterangan = $request->keterangan;
        $kuantitas_penerimaan = $request->kuantitas_penerimaan;
        $baik = $request->baik;
        $tidak_baik = $request->tidak_baik;

        $add = Lppb::create([
            'id_registrasi_barang' => $id_registrasi_barang,
            'keterangan' => $keterangan,
            'penerimaan' => $kuantitas_penerimaan,
            'hasil_ok' => $baik,
            'hasil_nok' => $tidak_baik,
        ]);

        return redirect()->route('lppb')->with('success', 'Berhasil menerima barang');
    }

    public function getPurchaseRequestDetail($id)
    {
        $detail = PurchaseRequest::find($id);
        return response()->json($detail);
    }

    public function updatePurchaseRequestDetail(Request $request)
    {
        $detail = PurchaseRequest::find($request->id);
        $detail->kode_material = $request->kode_material;
        $detail->uraian = $request->uraian;
        $detail->spek = $request->spek;
        $detail->qty = $request->qty;
        $detail->satuan = $request->satuan;
        $detail->waktu = $request->waktu;
        $detail->keterangan = $request->keterangan;
        $detail->save();

        return response()->json(['message' => 'Item updated successfully']);
    }

    public function deleteDetail(Request $request)
    {
        try {
            $detail = PurchaseRequest::findOrFail($request->id);
            $detail->delete();

            return Response::json(['message' => 'Detail berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return Response::json(['message' => 'Gagal menghapus detail', 'error' => $e->getMessage()], 500);
        }
    }

    // public function cetakLPPB(Request $request)
    // {
    //     $id = $request->id;
    //     $data = PurchaseRequest::find($id);
    //     if ($data) {
    //         // Mengambil data dari model Keproyekan berdasarkan proyek_id dari model PurchaseRequest
    //         $proyek = Keproyekan::find($data->proyek_id)->nama_proyek;

    //         // Mengambil semua data dari model Keproyekan berdasarkan id_pr dari model PurchaseRequest
    //         $detailpr = DetailPR::where('id_pr', $data->id)->get();

    //         // Mengambil data no_po dan vendor_id dari model PurchaseOrder berdasarkan id_po dari model DetailPr
    //         $purchaseOrders = Purchase_Order::whereIn('id', $detailpr->pluck('id_po'))->get(['no_po', 'vendor_id']);

    //         // Memisahkan data no_po dan vendor_id ke dalam array terpisah
    //         $poNumbers = $purchaseOrders->pluck('no_po');
    //         $vendorIds = $purchaseOrders->pluck('vendor_id');

    //         // Mengambil semua data dari model Vendor berdasarkan vendor_id
    //         $vendors = Vendor::whereIn('id', $vendorIds)->get();

    //         $pdf = Pdf::loadview('lppb.lppb_print', compact('data', 'proyek', 'detailpr', 'poNumbers', 'vendors'));
    //         $pdf->setPaper('A4', 'landscape');
    //         return $pdf->stream('LPPB-' . '.pdf');
    //     } else {
    //         return response()->json([
    //             'message' => 'LPPB not found'
    //         ], 404);
    //     }
    // }

    // asli!!
    // public function cetakLPPB(Request $request)
    // {
    //     $po_asli = Purchase_Order::where('id', $request->id)->first();
    //     $po = DetailPo::where('detail_po.id_po', $request->id);

    //     $ids = $po->pluck('id_detail_pr');
    //     $id = $po->select('detail_po.*', 'detail_pr.id_pr')->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_po.id_detail_pr')->first()->id_pr;
    //     // $id = $po->first()->id_pr;

    //     $data = PurchaseRequest::find($id);

    //     if ($data) {
    //         // Mengambil data dari model Keproyekan berdasarkan proyek_id dari model PurchaseRequest
    //         $proyek = Kontrak::find($data->proyek_id)->nama_pekerjaan;

    //         // Mengambil semua data dari model DetailPR berdasarkan id_pr dari model PurchaseRequest
    //         $detailpr = DetailPR::whereIn('detail_pr.id', $ids)
    //             ->select('detail_pr.*', 'detail_po.id_po')
    //             ->join('detail_po', 'detail_po.id_detail_pr', '=', 'detail_pr.id')
    //             ->get();

    //         $detailpr = $detailpr->map(function ($item) use ($request) {
    //             $id_po_real = $request->id;
    //             $penerimaan_barang = PenerimaanBarang::where('id_detail_pr', $item->id)->where('id_po', $id_po_real)->first();

    //             $item->penerimaan = $penerimaan_barang ? $penerimaan_barang->penerimaan : null;
    //             $item->hasil_ok = $penerimaan_barang ? $penerimaan_barang->hasil_ok : null;
    //             $item->hasil_nok = $penerimaan_barang ? $penerimaan_barang->hasil_nok : null;
    //             $item->diterima_qc = $penerimaan_barang ? $penerimaan_barang->diterima_qc : null;
    //             $item->belum_diterima_qc = $penerimaan_barang ? $penerimaan_barang->belum_diterima_qc : null;
    //             $item->tgl_diterima = $penerimaan_barang ? $penerimaan_barang->tanggal_diterima : null;
    //             return $item;
    //         });

    //         // Mengambil data no_po dan vendor_id dari model PurchaseOrder berdasarkan id_po dari model DetailPR
    //         // $purchaseOrders = Purchase_Order::whereIn('id', $detailpr->pluck('id_po'))->get(['no_po', 'vendor_id']);
    //         $purchaseOrders = Purchase_Order::where('id', $request->id)->get(['no_po', 'vendor_id']);

    //         // Memisahkan data no_po dan vendor_id ke dalam array terpisah
    //         $poNumbers = $purchaseOrders->pluck('no_po');
    //         $vendorIds = $purchaseOrders->pluck('vendor_id');

    //         // Mengambil semua data dari model Vendor berdasarkan vendor_id
    //         $vendors = Vendor::whereIn('id', $vendorIds)->get();

    //         // Memuat view dengan data yang diperlukan
    //         $pdf = Pdf::loadview('lppb.lppb_print', compact('data', 'proyek', 'detailpr', 'poNumbers', 'vendors', 'po_asli'));
    //         $pdf->setPaper('A4', 'landscape');
    //         return $pdf->stream('LPPB-' . '.pdf');
    //     } else {
    //         return response()->json([
    //             'message' => 'LPPB not found'
    //         ], 404);
    //     }
    // }

    public function cetakLPPB(Request $request)
    {
        // --- cek apakah PO yang dimaksud itu PO Dalam atau PO Luar ---
        $poDalam = Purchase_Order::where('id', $request->id)->first();
        $poLuar = Purchase_Orderluar::where('id', $request->id)->first();

        if ($poDalam) {
            // ==================== PO DALAM ====================
            $po_asli = $poDalam;

            $po = DetailPo::where('detail_po.id_po', $request->id);
            $ids = $po->pluck('id_detail_pr');

            $id = $po
                ->select('detail_po.*', 'detail_pr.id_pr')
                ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_po.id_detail_pr')
                ->first()
                ->id_pr;

            $data = PurchaseRequest::find($id);

            if (!$data) {
                return response()->json(['message' => 'LPPB not found'], 404);
            }

            $proyek = Kontrak::find($data->proyek_id)->nama_pekerjaan;

            $detailpr = DetailPR::whereIn('detail_pr.id', $ids)
                ->select('detail_pr.*', 'detail_po.id_po')
                ->join('detail_po', 'detail_po.id_detail_pr', '=', 'detail_pr.id')
                ->get();

            $detailpr = $detailpr->map(function ($item) use ($request) {
                $id_po_real = $request->id;
                $penerimaan_barang = PenerimaanBarang::where('id_detail_pr', $item->id)
                    ->where('id_po', $id_po_real)
                    ->first();

                $item->penerimaan = $penerimaan_barang->penerimaan ?? null;
                $item->hasil_ok = $penerimaan_barang->hasil_ok ?? null;
                $item->hasil_nok = $penerimaan_barang->hasil_nok ?? null;
                $item->diterima_qc = $penerimaan_barang->diterima_qc ?? null;
                $item->belum_diterima_qc = $penerimaan_barang->belum_diterima_qc ?? null;
                $item->tgl_diterima = $penerimaan_barang->tanggal_diterima ?? null;
                return $item;
            });

            $purchaseOrders = Purchase_Order::where('id', $request->id)->get(['no_po', 'vendor_id']);
            $poNumbers = $purchaseOrders->pluck('no_po');
            $vendorIds = $purchaseOrders->pluck('vendor_id');
            $vendors = Vendor::whereIn('id', $vendorIds)->get();
        } elseif ($poLuar) {
            // ==================== PO LUAR ====================
            $po_asli = $poLuar;

            $po = DetailPoluar::where('detail_poluar.id_poluar', $request->id);
            $ids = $po->pluck('id_detail_pr');

            $id = $po
                ->select('detail_poluar.*', 'detail_pr.id_pr')
                ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_poluar.id_detail_pr')
                ->first()
                ->id_pr;

            $data = PurchaseRequest::find($id);

            if (!$data) {
                return response()->json(['message' => 'LPPB not found'], 404);
            }

            $proyek = Kontrak::find($data->proyek_id)->nama_pekerjaan;

            $detailpr = DetailPR::whereIn('detail_pr.id', $ids)
                ->select('detail_pr.*', 'detail_poluar.id_poluar')
                ->join('detail_poluar', 'detail_poluar.id_detail_pr', '=', 'detail_pr.id')
                ->get();

            $detailpr = $detailpr->map(function ($item) use ($request) {
                $id_po_real = $request->id;
                $penerimaan_barang = PenerimaanBarang::where('id_detail_pr', $item->id)
                    ->where('id_poluar', $id_po_real)
                    ->first();

                $item->penerimaan = $penerimaan_barang->penerimaan ?? null;
                $item->hasil_ok = $penerimaan_barang->hasil_ok ?? null;
                $item->hasil_nok = $penerimaan_barang->hasil_nok ?? null;
                $item->diterima_qc = $penerimaan_barang->diterima_qc ?? null;
                $item->belum_diterima_qc = $penerimaan_barang->belum_diterima_qc ?? null;
                $item->tgl_diterima = $penerimaan_barang->tanggal_diterima ?? null;
                return $item;
            });

            $purchaseOrders = Purchase_Orderluar::where('id', $request->id)->get(['no_poluar', 'vendor_id']);
            $poNumbers = $purchaseOrders->pluck('no_po');
            $vendorIds = $purchaseOrders->pluck('vendor_id');
            $vendors = Vendor::whereIn('id', $vendorIds)->get();
        } else {
            return response()->json(['message' => 'Data PO tidak ditemukan'], 404);
        }

        // Render PDF
        $pdf = Pdf::loadview('lppb.lppb_print', compact('data', 'proyek', 'detailpr', 'poNumbers', 'vendors', 'po_asli'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('LPPB-' . '.pdf');
    }

    // asli
    // public function editlppb(Request $request)
    // {
    //     // dd($request->all());
    //     // Validasi data yang diterima dari request
    //     $request->validate([
    //         'id_detail' => 'required',
    //         'penerimaan' => 'nullable',
    //         'ok' => 'nullable',
    //         'nok' => 'nullable',
    //         'sdh_qc' => 'nullable',
    //         'blm' => 'nullable',
    //         'tgld' => 'required',
    //     ]);
    //     $id_po_real = Purchase_Order::where('no_po', $request->no_po)->first()->id;
    //     $id = $request->id_detail;
    //     // $detailPR = DetailPR::where('id', $id)->first();
    //     // $detailPR->update([
    //     //     'penerimaan' => $request->penerimaan,
    //     //     'hasil_ok' => $request->ok,
    //     //     'hasil_nok' => $request->nok,
    //     //     'diterima_qc' => $request->sdh_qc,
    //     //     'belum_diterima_qc' => $request->blm,
    //     //     'tgl_diterima' => $request->tgld,
    //     // ]);

    //     $updated_data = PenerimaanBarang::where('id_detail_pr', $request->id_detail)->where('id_po', $id_po_real)->first();

    //     if ($updated_data) {
    //         PenerimaanBarang::where('id_detail_pr', $request->id_detail)->where('id_po', $id_po_real)->update([
    //             'penerimaan' => $request->penerimaan,
    //             'hasil_ok' => $request->ok,
    //             'hasil_nok' => $request->nok,
    //             'diterima_qc' => $request->sdh_qc,
    //             'belum_diterima_qc' => $request->blm,
    //             'tanggal_diterima' => $request->tgld,
    //         ]);
    //     }

    //     $po = DetailPo::where('id_po', $request->id_po);

    //     $ids = $po->pluck('id_detail_pr');

    //     $pr = DB::table('purchase_request')->where('id', $request->id_pr)->first();
    //     $pr->id_po_real = $id_po_real;
    //     $pr->id_po_woi = $request->id_po;
    //     $pr->details = DetailPR::select('detail_pr.*', 'detail_po.id_po')->whereIn('detail_pr.id', $ids)
    //         ->join('detail_po', 'detail_po.id_detail_pr', '=', 'detail_pr.id')->get();
    //     $pr->details = $pr->details->map(function ($item) use ($request, $id_po_real) {
    //         $po = Purchase_Order::where('id', $item->id_po)->first();
    //         // dd($po);
    //         $split_proyek = explode(',', $po->proyek_id);
    //         // dd($split_proyek);
    //         $proyek_names = Kontrak::whereIn('id', $split_proyek)->pluck('nama_pekerjaan')->toArray();
    //         // dd($proyek_names);
    //         $item->proyeks = implode(',', $proyek_names);
    //         // dd($item->proyek);

    //         $penerimaan_barang = PenerimaanBarang::where('id_detail_pr', $item->id)->where('id_po', $id_po_real)->first();

    //         $item->penerimaan = $penerimaan_barang ? $penerimaan_barang->penerimaan : null;
    //         $item->hasil_ok = $penerimaan_barang ? $penerimaan_barang->hasil_ok : null;
    //         $item->hasil_nok = $penerimaan_barang ? $penerimaan_barang->hasil_nok : null;
    //         $item->diterima_qc = $penerimaan_barang ? $penerimaan_barang->diterima_qc : null;
    //         $item->belum_diterima_qc = $penerimaan_barang ? $penerimaan_barang->belum_diterima_qc : null;
    //         $item->tgl_diterima = $penerimaan_barang ? $penerimaan_barang->tanggal_diterima : null;

    //         return $item;
    //     });
    //     return response()->json([
    //         'success' => true,
    //         'no_po' => $request->no_po,
    //         'nama_proyek' => $request->nama_proyek,
    //         'message' => 'LPPB berhasil diupdate.',
    //         'pr' => $pr // Mengembalikan data detail SR yang telah diupdate
    //     ]);
    // }

    // coba-coba dan sudah fix bisa!!
    // public function editlppb(Request $request)
    // {
    //     // Validasi data
    //     $request->validate([
    //         'id_detail' => 'required',
    //         'penerimaan' => 'nullable',
    //         'ok' => 'nullable',
    //         'nok' => 'nullable',
    //         'sdh_qc' => 'nullable',
    //         'blm' => 'nullable',
    //         'tgld' => 'required',
    //         'no_po' => 'required',
    //     ]);

    //     // --- CEK PO DALAM ---
    //     $poDalam = Purchase_Order::where('no_po', $request->no_po)->first();

    //     // --- CEK PO LUAR ---
    //     $poLuar = Purchase_OrderLuar::where('no_poluar', $request->no_po)->first();

    //     // Jika tidak ada keduanya
    //     if (!$poDalam && !$poLuar) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Data PO / PO Luar tidak ditemukan',
    //         ]);
    //     }

    //     // Tentukan apakah PO dalam atau luar
    //     if ($poDalam) {
    //         $id_po_real = $poDalam->id;
    //         $id_po_field = 'id_po';
    //     } else {
    //         $id_po_real = $poLuar->id;
    //         $id_po_field = 'id_poluar';
    //     }

    //     // Update / simpan penerimaan barang
    //     $updated_data = PenerimaanBarang::where('id_detail_pr', $request->id_detail)
    //         ->where($id_po_field, $id_po_real)
    //         ->first();

    //     if ($updated_data) {
    //         $updated_data->update([
    //             'penerimaan' => $request->penerimaan,
    //             'hasil_ok' => $request->ok,
    //             'hasil_nok' => $request->nok,
    //             'diterima_qc' => $request->sdh_qc,
    //             'belum_diterima_qc' => $request->blm,
    //             'tanggal_diterima' => $request->tgld,
    //         ]);
    //     } else {
    //         PenerimaanBarang::create([
    //             'id_detail_pr' => $request->id_detail,
    //             $id_po_field   => $id_po_real,
    //             'penerimaan' => $request->penerimaan,
    //             'hasil_ok' => $request->ok,
    //             'hasil_nok' => $request->nok,
    //             'diterima_qc' => $request->sdh_qc,
    //             'belum_diterima_qc' => $request->blm,
    //             'tanggal_diterima' => $request->tgld,
    //         ]);
    //     }

    //     // Ambil data PR
    //     if ($poDalam) {
    //         $po = DetailPo::where('id_po', $id_po_real);
    //     } else {
    //         $po = DetailPoluar::where('id_poluar', $id_po_real);
    //     }

    //     $ids = $po->pluck('id_detail_pr');
    //     $pr = DB::table('purchase_request')->where('id', $request->id_pr)->first();

    //     $pr->id_po_real = $id_po_real;
    //     $pr->id_po_woi = $request->id_po;

    //     if ($poDalam) {
    //         $pr->details = DetailPR::select('detail_pr.*', 'detail_po.id_po')
    //             ->whereIn('detail_pr.id', $ids)
    //             ->join('detail_po', 'detail_po.id_detail_pr', '=', 'detail_pr.id')
    //             ->get();
    //     } else {
    //         $pr->details = DetailPR::select('detail_pr.*', 'detail_poluar.id_poluar as id_po')
    //             ->whereIn('detail_pr.id', $ids)
    //             ->join('detail_poluar', 'detail_poluar.id_detail_pr', '=', 'detail_pr.id')
    //             ->get();
    //     }

    //     $pr->details = $pr->details->map(function ($item) use ($id_po_real, $id_po_field) {
    //         if ($id_po_field === 'id_po') {
    //             $po = Purchase_Order::find($item->id_po);
    //             $split_proyek = explode(',', $po->proyek_id);
    //         } else {
    //             $po = Purchase_OrderLuar::find($item->id_po);
    //             $split_proyek = explode(',', $po->proyek_id);
    //         }

    //         $proyek_names = Kontrak::whereIn('id', $split_proyek)->pluck('nama_pekerjaan')->toArray();
    //         $item->proyeks = implode(',', $proyek_names);

    //         $penerimaan_barang = PenerimaanBarang::where('id_detail_pr', $item->id)
    //             ->where($id_po_field, $id_po_real)
    //             ->first();

    //         $item->penerimaan = $penerimaan_barang->penerimaan ?? null;
    //         $item->hasil_ok = $penerimaan_barang->hasil_ok ?? null;
    //         $item->hasil_nok = $penerimaan_barang->hasil_nok ?? null;
    //         $item->diterima_qc = $penerimaan_barang->diterima_qc ?? null;
    //         $item->belum_diterima_qc = $penerimaan_barang->belum_diterima_qc ?? null;
    //         $item->tgl_diterima = $penerimaan_barang->tanggal_diterima ?? null;

    //         return $item;
    //     });

    //     return response()->json([
    //         'success' => true,
    //         'no_po' => $request->no_po,
    //         'nama_proyek' => $request->nama_proyek,
    //         'message' => 'LPPB berhasil diupdate.',
    //         'pr' => $pr
    //     ]);
    // }

    // fix sudah bisa
    public function editlppb(Request $request)
    {
        // Validasi data request
        $request->validate([
            'id_detail' => 'required',
            'penerimaan' => 'nullable|integer',
            'ok' => 'nullable|integer',
            'nok' => 'nullable|integer',
            'sdh_qc' => 'nullable|integer',
            'blm' => 'nullable|integer',
            'tgld' => 'required|date',
            'no_po' => 'required',
        ]);

        // --- CEK PO DALAM ---
        $poDalam = Purchase_Order::where('no_po', $request->no_po)->first();

        // --- CEK PO LUAR ---
        $poLuar = Purchase_OrderLuar::where('no_poluar', $request->no_po)->first();

        // Jika tidak ada keduanya
        if (!$poDalam && !$poLuar) {
            return response()->json([
                'success' => false,
                'message' => 'Data PO / PO Luar tidak ditemukan',
            ]);
        }

        // Tentukan apakah PO dalam atau luar
        if ($poDalam) {
            $id_po_real = $poDalam->id;
            $id_po_field = 'id_po';
        } else {
            $id_po_real = $poLuar->id;
            $id_po_field = 'id_poluar';
        }

        // --- Cek apakah data penerimaan barang sudah ada ---
        $updated_data = PenerimaanBarang::where('id_detail_pr', $request->id_detail)
            ->where($id_po_field, $id_po_real)
            ->first();

        if ($updated_data) {
            // Update data lama
            $updated_data->update([
                'penerimaan' => $request->penerimaan,
                'hasil_ok' => $request->ok,
                'hasil_nok' => $request->nok,
                'diterima_qc' => $request->sdh_qc,
                'belum_diterima_qc' => $request->blm,
                'tanggal_diterima' => $request->tgld,
            ]);
        } else {
            // Insert data baru dengan id_po / id_poluar sesuai
            if ($poDalam) {
                $dataInsert = [
                    'id_detail_pr' => $request->id_detail,
                    'id_po' => $id_po_real,
                    'id_poluar' => null,
                    'penerimaan' => $request->penerimaan,
                    'hasil_ok' => $request->ok,
                    'hasil_nok' => $request->nok,
                    'diterima_qc' => $request->sdh_qc,
                    'belum_diterima_qc' => $request->blm,
                    'tanggal_diterima' => $request->tgld,
                ];
            } else {
                $dataInsert = [
                    'id_detail_pr' => $request->id_detail,
                    'id_po' => null,
                    'id_poluar' => $id_po_real,
                    'penerimaan' => $request->penerimaan,
                    'hasil_ok' => $request->ok,
                    'hasil_nok' => $request->nok,
                    'diterima_qc' => $request->sdh_qc,
                    'belum_diterima_qc' => $request->blm,
                    'tanggal_diterima' => $request->tgld,
                ];
            }

            PenerimaanBarang::create($dataInsert);
        }

        // --- Ambil data PR untuk response ---
        if ($poDalam) {
            $po = DetailPo::where('id_po', $id_po_real);
        } else {
            $po = DetailPoluar::where('id_poluar', $id_po_real);
        }

        $ids = $po->pluck('id_detail_pr');
        $pr = DB::table('purchase_request')->where('id', $request->id_pr)->first();

        $pr->id_po_real = $id_po_real;

        if ($poDalam) {
            $pr->details = DetailPR::select('detail_pr.*', 'detail_po.id_po')
                ->whereIn('detail_pr.id', $ids)
                ->join('detail_po', 'detail_po.id_detail_pr', '=', 'detail_pr.id')
                ->get();
        } else {
            $pr->details = DetailPR::select('detail_pr.*', 'detail_poluar.id_poluar as id_po')
                ->whereIn('detail_pr.id', $ids)
                ->join('detail_poluar', 'detail_poluar.id_detail_pr', '=', 'detail_pr.id')
                ->get();
        }

        // Tambahkan info proyek & penerimaan ke tiap detail
        $pr->details = $pr->details->map(function ($item) use ($id_po_real, $id_po_field) {
            if ($id_po_field === 'id_po') {
                $po = Purchase_Order::find($item->id_po);
                $split_proyek = explode(',', $po->proyek_id);
            } else {
                $po = Purchase_OrderLuar::find($item->id_po);
                $split_proyek = explode(',', $po->proyek_id);
            }

            $proyek_names = Kontrak::whereIn('id', $split_proyek)->pluck('nama_pekerjaan')->toArray();
            $item->proyeks = implode(',', $proyek_names);

            $penerimaan_barang = PenerimaanBarang::where('id_detail_pr', $item->id)
                ->where($id_po_field, $id_po_real)
                ->first();

            $item->penerimaan = $penerimaan_barang->penerimaan ?? null;
            $item->hasil_ok = $penerimaan_barang->hasil_ok ?? null;
            $item->hasil_nok = $penerimaan_barang->hasil_nok ?? null;
            $item->diterima_qc = $penerimaan_barang->diterima_qc ?? null;
            $item->belum_diterima_qc = $penerimaan_barang->belum_diterima_qc ?? null;
            $item->tgl_diterima = $penerimaan_barang->tanggal_diterima ?? null;

            return $item;
        });

        return response()->json([
            'success' => true,
            'no_po' => $request->no_po,
            'nama_proyek' => $request->nama_proyek,
            'message' => 'LPPB berhasil diupdate.',
            'pr' => $pr
        ]);
    }

    // Asli
    // public function editpenerimaan(Request $request)
    // {
    //     // dd($request->all());
    //     // Validasi data yang diterima dari request
    //     $request->validate([
    //         'id' => 'required',
    //         'penerimaan' => 'nullable',
    //         'sdh' => 'nullable',
    //         'blm_sdh' => 'nullable',
    //     ]);

    //     $id = $request->id;
    //     // $detailPR = DetailPR::where('id', $id)->first();
    //     // $detailPR->update([
    //     //     'penerimaan' => $request->penerimaan,
    //     //     'diterima_eks' => $request->sdh,
    //     //     'belum_diterima_eks' => $request->blm_sdh,
    //     // ]);

    //     $id_po_real = Purchase_Order::where('no_po', $request->no_po)->first()->id;
    //     $updated_data = PenerimaanBarang::where('id_detail_pr', $request->id)->where('id_po', $id_po_real)->first();
    //     if ($updated_data) {
    //         PenerimaanBarang::where('id_detail_pr', $request->id)->where('id_po', $id_po_real)->update([
    //             'diterima_eks' => $request->sdh,
    //             'belum_diterima_eks' => $request->blm_sdh,
    //         ]);
    //     } else {
    //         PenerimaanBarang::create([
    //             'id_detail_pr' => $id,
    //             'id_po' => $id_po_real,
    //             'diterima_eks' => $request->sdh,
    //             'belum_diterima_eks' => $request->blm_sdh,
    //         ]);
    //     }

    //     $po = DetailPo::where('id_po', $request->id_po);

    //     $ids = $po->pluck('id_detail_pr');

    //     $pr = DB::table('purchase_request')->where('id', $request->id_pr)->first();
    //     $pr->id_po_real = $id_po_real;
    //     $pr->details = DetailPR::whereIn('id', $ids)->get();
    //     $pr->details = $pr->details->map(function ($item) use ($request) {
    //         $po = Purchase_Order::where('id', $request->id_po)->first();
    //         // dd($po);
    //         $split_proyek = explode(',', $po->proyek_id);
    //         // dd($split_proyek);
    //         $proyek_names = Kontrak::whereIn('id', $split_proyek)->pluck('nama_pekerjaan')->toArray();
    //         // dd($proyek_names);
    //         $item->proyeks = implode(',', $proyek_names);
    //         // dd($item->proyek);

    //         $id_po_real = Purchase_Order::where('no_po', $request->no_po)->first()->id;
    //         $penerimaan_barang = PenerimaanBarang::where('id_detail_pr', $item->id)->where('id_po', $id_po_real)->first();
    //         $item->diterima_eks = $penerimaan_barang ? $penerimaan_barang->diterima_eks : null;
    //         $item->belum_diterima_eks = $penerimaan_barang ? $penerimaan_barang->belum_diterima_eks : null;
    //         $item->diterima_qc = $penerimaan_barang ? $penerimaan_barang->diterima_qc : null;
    //         $item->belum_diterima_qc = $penerimaan_barang ? $penerimaan_barang->belum_diterima_qc : null;
    //         $item->tanggal_diterima = $penerimaan_barang ? $penerimaan_barang->tanggal_diterima : null;

    //         return $item;
    //     });
    //     return response()->json([
    //         'success' => true,
    //         'no_po' => $request->no_po,
    //         'nama_proyek' => $request->nama_proyek,
    //         'message' => 'LPPB berhasil diupdate.',
    //         'pr' => $pr // Mengembalikan data detail SR yang telah diupdate
    //     ]);
    // }

    // coba-coba
    public function editpenerimaan(Request $request)
    {
        $request->validate([
            'id' => 'required',  // id_detail_pr
            'penerimaan' => 'nullable',
            'sdh' => 'nullable',
            'blm_sdh' => 'nullable',
            'no_po' => 'required',
        ]);

        $id = $request->id;

        // --- CEK PO Dalam ---
        $poDalam = Purchase_Order::where('no_po', $request->no_po)->first();

        // --- CEK PO Luar ---
        $poLuar = Purchase_OrderLuar::where('no_poluar', $request->no_po)->first();

        if (!$poDalam && !$poLuar) {
            return response()->json([
                'success' => false,
                'message' => 'Data PO / PO Luar tidak ditemukan',
            ]);
        }

        // Tentukan jenis PO
        if ($poDalam) {
            $id_po_real = $poDalam->id;
            $id_po_field = 'id_po';
        } else {
            $id_po_real = $poLuar->id;
            $id_po_field = 'id_poluar';
        }

        // --- Cek apakah data penerimaan barang sudah ada ---
        $updated_data = PenerimaanBarang::where('id_detail_pr', $id)
            ->where($id_po_field, $id_po_real)
            ->first();

        if ($updated_data) {
            // Update
            $updated_data->update([
                'diterima_eks' => $request->sdh,
                'belum_diterima_eks' => $request->blm_sdh,
            ]);
        } else {
            // Insert baru
            $dataInsert = [
                'id_detail_pr' => $id,
                'diterima_eks' => $request->sdh,
                'belum_diterima_eks' => $request->blm_sdh,
            ];

            if ($poDalam) {
                $dataInsert['id_po'] = $id_po_real;
                $dataInsert['id_poluar'] = null;
            } else {
                $dataInsert['id_po'] = null;
                $dataInsert['id_poluar'] = $id_po_real;
            }

            PenerimaanBarang::create($dataInsert);
        }

        // --- Ambil data Detail PO/PO Luar untuk dapatkan ID Detail PR ---
        if ($poDalam) {
            $po = DetailPo::where('id_po', $id_po_real);
        } else {
            $po = DetailPoluar::where('id_poluar', $id_po_real);
        }

        $ids = $po->pluck('id_detail_pr');

        // --- Ambil data PR dari detail_pr → purchase_request ---
        $pr = DB::table('purchase_request')
            ->join('detail_pr', 'detail_pr.id_pr', '=', 'purchase_request.id')
            ->whereIn('detail_pr.id', $ids)
            ->select('purchase_request.*')
            ->first();

        if (!$pr) {
            return response()->json([
                'success' => false,
                'message' => 'Data PR tidak ditemukan',
            ], 404);
        }

        $pr->id_po_real = $id_po_real;

        if ($poDalam) {
            $pr->details = DetailPR::select('detail_pr.*', 'detail_po.id_po')
                ->whereIn('detail_pr.id', $ids)
                ->join('detail_po', 'detail_po.id_detail_pr', '=', 'detail_pr.id')
                ->get();
        } else {
            $pr->details = DetailPR::select('detail_pr.*', 'detail_poluar.id_poluar as id_po')
                ->whereIn('detail_pr.id', $ids)
                ->join('detail_poluar', 'detail_poluar.id_detail_pr', '=', 'detail_pr.id')
                ->get();
        }

        // Tambahkan proyek & penerimaan barang
        $pr->details = $pr->details->map(function ($item) use ($id_po_real, $id_po_field) {
            if ($id_po_field === 'id_po') {
                $po = Purchase_Order::find($item->id_po);
                $split_proyek = explode(',', $po->proyek_id);
                $item->no_po = $po->no_po;  // penting untuk tampil di blade
            } else {
                $po = Purchase_OrderLuar::find($item->id_po);
                $split_proyek = explode(',', $po->proyek_id);
                $item->no_po = $po->no_poluar;  // penting untuk tampil di blade
            }

            $proyek_names = Kontrak::whereIn('id', $split_proyek)->pluck('nama_pekerjaan')->toArray();
            $item->proyeks = implode(',', $proyek_names);

            // 🔑 ambil no_pr dari tabel purchase_request
            $item->no_pr = PurchaseRequest::where('id', $item->id_pr)->value('no_pr') ?? '-';

            $penerimaan_barang = PenerimaanBarang::where('id_detail_pr', $item->id)
                ->where($id_po_field, $id_po_real)
                ->first();

            $item->diterima_eks = $penerimaan_barang->diterima_eks ?? '-';
            $item->belum_diterima_eks = $penerimaan_barang->belum_diterima_eks ?? '-';
            $item->diterima_qc = $penerimaan_barang->diterima_qc ?? '-';
            $item->belum_diterima_qc = $penerimaan_barang->belum_diterima_qc ?? '-';
            $item->tanggal_diterima = $penerimaan_barang->tanggal_diterima ?? '-';

            return $item;
        });

        return response()->json([
            'success' => true,
            'no_po' => $request->no_po,
            'no_pr' => $pr->no_pr ?? '-',  // <-- ini penting supaya tidak undefined
            'nama_proyek' => $request->nama_proyek ?? '',
            'message' => 'Penerimaan berhasil diupdate.',
            'pr' => $pr
        ]);
    }

    // aslii simpan tanggal dan nomor LPPB
    // public function edit_nomor_lppb(Request $request)
    // {
    //     // dd($request->all());
    //     $request->validate([
    //         'id_prr' => 'required',
    //         'nomor_lppb' => 'required',
    //         'tanggal_lppb' => 'required',
    //     ], [
    //         'id_prr.required' => 'ID harus diisi',
    //         'nomor_lppb.required' => 'Nomor LPPB harus diisi',
    //         'tanggal_lppb.required' => 'Tanggal LPPB harus diisi',
    //     ]);

    //     $id = $request->id_prr;
    //     // $nomor_lppb = $request->nomor_lppb;
    //     // $tanggal_lppb = $request->tanggal_lppb;
    //     $edit = Purchase_Order::where('id', $id)->first();
    //     // dd($request->all());
    //     $edit->update([
    //         'nomor_lppb' => $request->nomor_lppb,
    //         'tanggal_lppb' => $request->tanggal_lppb,
    //     ]);

    //     return redirect()->route('lppb')->with('success', 'Berhasil mengubah Nomor & Tanggal LPPB');
    // }

    public function edit_nomor_lppb(Request $request)
    {
        $request->validate([
            'id_prr' => 'required',
            'nomor_lppb' => 'required',
            'tanggal_lppb' => 'required',
        ], [
            'id_prr.required' => 'ID harus diisi',
            'nomor_lppb.required' => 'Nomor LPPB harus diisi',
            'tanggal_lppb.required' => 'Tanggal LPPB harus diisi',
        ]);

        $id = $request->id_prr;

        // Cek di PO Dalam
        $edit = Purchase_Order::where('id', $id)->first();

        if ($edit) {
            $edit->update([
                'nomor_lppb' => $request->nomor_lppb,
                'tanggal_lppb' => $request->tanggal_lppb,
            ]);

            return redirect()->route('lppb')->with('success', 'Berhasil mengubah Nomor & Tanggal LPPB (PO Dalam)');
        }

        // Kalau tidak ketemu, cek di PO Luar
        $editLuar = Purchase_OrderLuar::where('id', $id)->first();

        if ($editLuar) {
            $editLuar->update([
                'nomor_lppb' => $request->nomor_lppb,
                'tanggal_lppb' => $request->tanggal_lppb,
            ]);

            return redirect()->route('lppb')->with('success', 'Berhasil mengubah Nomor & Tanggal LPPB (PO Luar)');
        }

        // Kalau dua-duanya tidak ketemu
        return redirect()->route('lppb')->with('error', 'Data PO / PO Luar tidak ditemukan');
    }
}
