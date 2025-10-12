<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Nego;
use App\Models\Spph;
use App\Models\Vendor;
use App\Models\Kontrak;
use App\Models\DetailPR;
use App\Models\DetailNego;
use App\Models\DetailNegoluar;
use App\Models\Keproyekan;
use App\Models\NegoLampiran;
use App\Models\Negoluar;
use App\Models\NegoluarLampiran;
use Illuminate\Http\Request;
use App\Models\Purchase_Order;
use App\Models\PurchaseRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;

class NegoluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        $search = $request->q;

        if (Session::has('selected_warehouse_id')) {
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }
        $negoluares = Negoluar::paginate(50);
        foreach ($negoluares as $key => $item) {
            $id = json_decode($item->vendor_id);
            $item->vendor = Vendor::whereIn('id', $id)->get();
            $item->vendor = $item->vendor->map(function ($item) {
                return $item->nama;
            });
            //change $item->vendor collection to array
            $item->vendor = $item->vendor->toArray();
            $item->vendor = implode(', ', $item->vendor);

            //lampiran bisa lebih dari 1
            $lampiran = NegoluarLampiran::where('negoluar_id', $item->id)->pluck('file')->toArray();
            $item->lampiran = implode(', ', $lampiran);
            // $item->lampiran = json_decode($item->lampiran); 
        }
        $vendors = Vendor::all();
        // dd($spphes);
        if ($search) {
            $negoluares = Negoluar::where('tanggal_negoluar', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == "json") {
            $categories = Negoluar::where("warehouse_id", $warehouse_id)->get();

            return response()->json($categories);
        } else {
            return view('negoluar.negoluar', compact('negoluares', 'vendors'));
        }
    }


    //** */
    function FunctionCountPages($path)
    {
        $pdftextfile = file_get_contents($path);
        $pagenumber = preg_match_all("/\/Page\W/", $pdftextfile, $dummy);
        return $pagenumber;
    }
    //** */



    // Simpan dan edit
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $negoluar = $request->id;
        // if (Session::has('selected_warehouse_id')) {
        //     $warehouse_id = Session::get('selected_warehouse_id');
        // } else {
        //     $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        // }
        // dd($request->all());

        $request->validate([
            'nomor_negoluar' => 'required',
            'id_pr' => 'required',
            'nomor_pr' => 'required',
            // 'lampiran' => 'required',
            'vendor' => 'required',
            'tanggal_negoluar' => 'required',
            'batas_negoluar' => 'required',
            'perihal' => 'required',
            'no_jawaban_vendor' => 'required',
            'franco' => 'required',
            // 'penerima' => 'required',
            // 'alamat' => 'required'
        ], [
            'nomor_negoluar.required' => 'Nomor Nego harus diisi',
            'id_pr.required' => 'ID pr harus diisi',
            'nomor_pr.required' => 'Nomor pr harus diisi',
            // 'lampiran.required' => 'Lampiran harus diisi',
            'vendor.required' => 'Vendor harus diisi',
            'tanggal_negoluar.required' => 'Tanggal nego harus diisi',
            'batas_negoluar.required' => 'Batas nego harus diisi',
            'perihal.required' => 'Perihal harus diisi',
            'penerima.required' => 'Penerima harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'no_jawaban_vendor.required' => 'Nomor Jawaban Nego Vendor harus diisi',
            'franco.required' => 'Franco harus diisi'
        ]);

        $data = [
            'nomor_negoluar' => $request->nomor_negoluar,
            'id_pr' => $request->id_pr,
            'nomor_pr' => $request->nomor_pr,
            'vendor_id' => json_encode($request->vendor),
            'tanggal_negoluar' => $request->tanggal_negoluar,
            'batas_negoluar' => $request->batas_negoluar,
            'perihal' => $request->perihal,
            'penerima' => json_encode($request->penerima),
            'alamat' => json_encode($request->alamat),
            'no_jawaban_vendor' => $request->no_jawaban_vendor,
            'franco' => $request->franco,
            'keterangan_negoluar' => $request->keterangan_negoluar,
            'signature_imss' => $request->signature_imss,
            'position' => $request->position,
        ];

        // Ubah data vendor menjadi ID berdasarkan nama
        $vendorNames = json_decode($data['vendor_id']);
        $vendors = Vendor::whereIn('nama', $vendorNames)->pluck('id')->toArray();
        $data['vendor_id'] = json_encode($vendors);


        // dd($data);

        if (empty($negoluar)) {
            $add = Negoluar::create($data);

            // Check if 'lampiran' exists and is not null
            if ($request->hasFile('lampiran')) {
                $files = $request->file('lampiran');
                foreach ($files as $file) {
                    $file_name = rand() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('lampiran'), $file_name);
                    NegoluarLampiran::create([
                        'negoluar_id' => $add->id,
                        'file' => $file_name,
                        'tipe' => $this->FunctionCountPages(public_path('lampiran/' . $file_name))
                    ]);
                }
            }

            if ($add) {
                return redirect()->route('negoluar.index')->with('success', 'Nego berhasil ditambahkan');
            } else {
                return redirect()->route('negoluar.index')->with('error', 'Nego gagal ditambahkan');
            }
        } else {
            $update = Negoluar::where('id', $negoluar)->update($data);
            if ($request->hasFile('lampiran')) {
                $files = $request->file('lampiran');
                foreach ($files as $file) {
                    $file_name = rand() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('lampiran'), $file_name);
                    NegoluarLampiran::create([
                        'negoluar_id' => $negoluar,
                        'file' => $file_name,
                        'tipe' => $this->FunctionCountPages(public_path('lampiran/' . $file_name))
                    ]);
                }
            }
            // Ambil nama lampiran yang diinginkan dari request
            $nama_lampiran_baru = explode(', ', $request->nama_lampiran); //masih error


            // Ambil semua lampiran yang terkait dengan $spph dari database
            $existing_files = explode(', ', $request->lampiran_awal);

            // dd($nama_lampiran_baru);

            // Loop untuk setiap lampiran yang sudah ada
            foreach ($existing_files as $existing_file) {
                // Jika lampiran tidak termasuk dalam nama lampiran yang baru diupload, hapus dari database dan filesystem
                if (!in_array($existing_file, $nama_lampiran_baru)) {
                    // Hapus dari database
                    NegoluarLampiran::where('negoluar_id', $negoluar)->where('file', $existing_file)->delete();
                }
            }



            if ($update) {
                return redirect()->route('negoluar.index')->with('success', 'Nego berhasil diupdate');
            } else {
                return redirect()->route('negoluar.index')->with('error', 'Nego gagal diupdate');
            }
        }

        // return redirect()->route('spph.index')->with('success', 'SPPH berhasil disimpan');
    }

    // End simpan dan edit





    //QTY Nego Luar SAVE
    public function QtyNegoluarSave(Request $request)
    {
        // Validasi array
        $request->validate([
            'data' => 'required|array',
            'data.*.id' => 'required|integer',
            'data.*.qty_negoluar1' => 'required|numeric|min:0'
        ]);

        foreach ($request->data as $item) {
            $negoluarDetail = DetailPR::find($item['id']);

            if (!$negoluarDetail) continue;




            // Update data
            // $negoDetail->qty_nego -= $item['qty_nego1'];
            // $negoDetail->qty_nego1 = $item['qty_nego1'];
            // $negoDetail->save();

            $detailNego = DetailNegoluar::create([
                'negoluar_id' => $item['negoluar_id'],
                'id_detail_pr' => $item['id'],
                'negoluar_qty' => $item['qty_negoluar1'],
                'id_del_negoluar' => 0,
            ]);
        }

        return response()->json(['success' => true]);
    }
    //End QTY Nego LUAR



    //simpan detailnego
    public function detailNegoluarSave(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'id' => 'required|integer',
            'id_negoluar' => 'required|integer',
            'id_detail_negoluar' => 'required|integer',
            'harga_per_unit' => 'required|numeric',
            'harga_per_unit_imss' => 'required|numeric',
        ]);

        // Ambil data dari request
        $id = $request->id;
        $id_negoluar = $request->id_negoluar;
        $id_detail_negoluar = $request->id_detail_negoluar;
        $harga_per_unit = $request->harga_per_unit;
        $harga_per_unit_imss = $request->harga_per_unit_imss;

        // Update data di tabel DetailNego
        $updated = DetailNegoluar::where('id', $id_detail_negoluar)->update([
            'harga' => $harga_per_unit,
            'harga_imss' => $harga_per_unit_imss,
        ]);

        if (!$updated) {
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui data'], 500);
        }

        // Ambil data Nego dan detailnya setelah update
        $negoluar = Negoluar::select('negoluar.*')
            ->where('negoluar.id', $request->id_negoluar)
            ->first();

        if (!$negoluar) {
            return response()->json(['success' => false, 'message' => 'Data Nego tidak ditemukan'], 404);
        }

        $negoluar->details = DetailNegoluar::where('detail_negoluar.negoluar_id', $negoluar->id)
            ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_negoluar.id_detail_pr')
            ->select(
                'detail_pr.*',
                'detail_negoluar.id as id_detail_negoluar',
                'detail_negoluar.harga as harga_per_unit',
                'detail_negoluar.harga_imss as harga_per_unit_imss',
                'detail_negoluar.negoluar_qty'
            )
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menyimpan detail negoluar!',
            'negoluar' => $negoluar
        ]);
    }
    //End simpan detail nego





    //Hapus
    public function destroy(Request $request)
    {
        $delete_negoluar_id = $request->id;
        $detail_negoluar = DB::table('detail_negoluar')->where('negoluar_id', $delete_negoluar_id)->first();

        if ($detail_negoluar) {
            // Ambil data detail_pr terkait
            $detail_pr = DB::table('detail_pr')->where('id', $detail_negoluar->id_detail_pr)->first();

            if ($detail_pr) {
                // Cek apakah ada id_del_nego di detail_nego
                if (!$detail_negoluar->id_del_negoluar) {
                    // Jika tidak ada id_del_nego, set qty_nego dengan nilai qty dari detail_pr
                    DB::table('detail_pr')->where('id', $detail_pr->id)->update(['qty_negoluar' => $detail_pr->qty]);
                } else {
                    // Ambil semua data detail_nego dengan nego_id yang akan dihapus
                    $detail_negoluar_list = DB::table('detail_negoluar')->where('negoluar_id', $delete_negoluar_id)->get();

                    if ($detail_negoluar_list->isNotEmpty()) {
                        // Kelompokkan data detail_nego berdasarkan id_detail_pr
                        $grouped = $detail_negoluar_list->groupBy('id_detail_pr');

                        foreach ($grouped as $id_detail_pr => $negoluar_entries) {
                            // Hitung total nego_qty untuk id_detail_pr tersebut
                            $total_negoluar_qty = $negoluar_entries->sum('negoluar_qty');

                            // Ambil data detail_pr terkait
                            $detail_pr = DB::table('detail_pr')->where('id', $id_detail_pr)->first();
                            if ($detail_pr) {
                                $new_qty_negoluar = ($detail_pr->qty_negoluar ?? 0) + $total_negoluar_qty;
                                DB::table('detail_pr')->where('id', $detail_pr->id)->update([
                                    'qty_negoluar' => $new_qty_negoluar
                                ]);
                            }
                        }
                    }
                }
            }

            // Perbarui kolom id_nego di tabel detail_pr menjadi null
            DB::table('detail_pr')
                ->where('id_negoluar', $delete_negoluar_id)
                ->update(['id_negoluar' => null]);

            // Hapus data dari tabel detail_nego yang memiliki id_nego sesuai
            DB::table('detail_negoluar')
                ->where('negoluar_id', $delete_negoluar_id)
                ->delete();

            // Setelah memperbarui detail_pr dan menghapus detail_nego, hapus data dari tabel nego
            $delete_negoluar = DB::table('negoluar')->where('id', $delete_negoluar_id)->delete();

            if ($delete_negoluar) {
                return redirect()->route('negoluar.index')->with('success', 'Data Nego berhasil dihapus, id_nego pada detail_pr diubah menjadi null, dan detail_nego berhasil dihapus');
            } else {
                return redirect()->route('negoluar.index')->with('error', 'Data Nego gagal dihapus');
            }
        }

        return redirect()->route('negoluar.index')->with('error', 'Data Nego tidak ditemukan');
    }
    // End Hapus





    //hapus detail Nego
    public function destroyDetailNegoluar(Request $request)
    {
        // Menerima data dari request
        $id = $request->id;
        $id_negoluar = $request->id_negoluar;
        $id_detail_pr = $request->id_detail_pr;
        $id_detail_negoluar = $request->id_detail_negoluar; //ggwp

        // dd($request->all());
        // Mengambil data detail_spph dan detail_pr untuk validasi
        $detail_negoluar = DetailNegoluar::find($id_detail_negoluar);
        $detail_pr = DetailPR::find($id);

        // Validasi: cek jika id_del_spph di detail_spph ada
        if ($detail_negoluar && $detail_pr) {
            if (!$detail_negoluar->id_del_negoluar) {
                // Jika tidak ada id_del_spph, set qty1 dengan nilai qty dari detail_pr
                $detail_pr->qty_negoluar = $detail_pr->qty;
                $detail_pr->save();
            } else {
                // Jika id_del_spph ada dan data dihapus dari detail_spph
                // Ambil nilai qty_spph dan tambahkan ke qty1
                $negoluar_qty = $detail_negoluar->negoluar_qty;

                // Tambahkan qty_spph ke qty1 yang sudah ada
                $detail_pr->qty_negoluar += $negoluar_qty;
                $detail_pr->save();
            }
        }



        // Jika penghapusan berhasil, hapus referensi id_spph di detail_pr


        // Menghapus detail Nego berdasarkan ID
        $delete_detail_negoluar = DetailNegoluar::where('id', $id_detail_negoluar)->delete(); //ggwp

        // Menghapus semua referensi nego_id dari tabel detail_nego
        $delete_all_details = DetailNegoluar::where('negoluar_id', $id_detail_negoluar)->delete(); //ggwp, gk pake hapus aja bang

        // Mengupdate tabel DetailPR untuk menghapus referensi id_nego
        $delete_detail_pr = DetailPR::where('id', $id)->update([ //ggwp
            'id_negoluar' => null
        ]);

        // Jika semua operasi berhasil, ambil data Nego yang diperbarui
        if ($delete_detail_negoluar) {  //ggwp
            $negoluar = Negoluar::select('negoluar.*')
                // ->leftjoin('vendor', 'vendor.id', '=', 'nego.vendor_id')
                // ->leftjoin('keproyekan', 'keproyekan.id', '=', 'nego.proyek_id')
                ->where('negoluar.id', $request->id_negoluar)
                ->first();

            if (!$negoluar) {
                return response()->json(['message' => 'Data Nego tidak ditemukan'], 404);
            }

            $negoluar->details = DetailNegoluar::where('negoluar_id', $negoluar->id)
                ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_negoluar.id_detail_pr')
                ->select('detail_pr.*', 'detail_negoluar.id as id_detail_negoluar', 'detail_negoluar.harga as harga_per_unit', 'detail_negoluar.harga_imss as harga_per_unit_imss', 'detail_negoluar.negoluar_qty')
                ->get();

            $negoluar->details = $negoluar->details->map(function ($item) use ($negoluar) {
                $item->id_negoluar = $negoluar->id;
                return $item;
            });

            return response()->json([
                'negoluar' => $negoluar
            ]);
        } else {
            // Mengembalikan response JSON dengan nilai nego null jika operasi gagal
            return response()->json([
                'negoluar' => null
            ]);
        }
    }
    //End hapus detail Nego




    //Hapus Multiple
    public function hapusMultipleNegoluar(Request $request)
    {
        if ($request->has('ids')) {
            $ids = $request->input('ids');

            // Ambil semua data detail_nego yang akan dihapus
            $detail_negoluar_list = DB::table('detail_negoluar')->whereIn('negoluar_id', $ids)->get();

            if ($detail_negoluar_list->isNotEmpty()) {
                // Kelompokkan data detail_nego berdasarkan id_detail_pr
                $grouped = $detail_negoluar_list->groupBy('id_detail_pr');

                foreach ($grouped as $id_detail_pr => $negoluar_entries) {
                    // Hitung total nego_qty untuk id_detail_pr tersebut
                    $total_negoluar_qty = $negoluar_entries->sum('negoluar_qty');

                    // Ambil data detail_pr terkait
                    $detail_pr = DB::table('detail_pr')->where('id', $id_detail_pr)->first();
                    if ($detail_pr) {
                        // Update qty_nego dengan menambahkan kembali total_nego_qty
                        $new_qty_negoluar = ($detail_pr->qty_negoluar ?? 0) + $total_negoluar_qty;
                        DB::table('detail_pr')->where('id', $detail_pr->id)->update([
                            'qty_negoluar' => $new_qty_negoluar
                        ]);
                    }
                }
            }

            // Perbarui kolom id_nego di tabel detail_pr menjadi null
            DB::table('detail_pr')
                ->whereIn('id_negoluar', $ids)
                ->update(['id_negoluar' => null]);

            // Hapus data dari tabel detail_nego yang memiliki id_nego sesuai
            DB::table('detail_negoluar')
                ->whereIn('negoluar_id', $ids)
                ->delete();

            // Hapus data dari tabel nego
            Negoluar::whereIn('id', $ids)->delete();

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
    //End Hapus Multiple




    //Get Detail Nego isian lihat detail
    public function getDetailNegoluar(Request $request)
    {
        $id = $request->id;
        $negoluar = Negoluar::where('id', $id)->first();
        $vendor = json_decode($negoluar->vendor_id);
        $vendor = Vendor::whereIn('id', $vendor)->get();
        $vendor = $vendor->map(function ($item) {
            return $item->nama;
        });
        $vendor = $vendor->toArray();
        $vendor = implode(', ', $vendor);
        $negoluar->penerima = $vendor;

        $negoluar->details = DetailNegoluar::where('negoluar_id', $id)
            ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_negoluar.id_detail_pr')
            ->select('detail_pr.*', 'detail_negoluar.id as id_detail_negoluar', 'detail_negoluar.harga as harga_per_unit', 'detail_negoluar.harga_imss as harga_per_unit_imss', 'detail_negoluar.negoluar_qty')
            ->get();

        $negoluar->details = $negoluar->details->map(function ($item) use ($id) {
            $item->id_negoluar = $id;
            $item->spek = $item->spek ? $item->spek : '';
            $item->keterangan = $item->keterangan ? $item->keterangan : '';
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            // $item->lampiran = $item->lampiran ? $item->lampiran : '';

            // // Start Get lampiran for each detail
            // $lampiran = SpphLampiran::where('spph_id', $item->id)->get();
            // $item->lampiran = $lampiran->map(function ($lampiran) {
            // $item->lampiran = $item->lampiran ? $item->lampiran : '';
            //     // dd($lampiran);
            //     return $lampiran->file; // Assuming `file_name` is the column name
            // })->toArray();
            // //End Get Lampiran for detail

            return $item;
        });
        // dd($nego->details);

        return response()->json([
            'negoluar' => $negoluar
        ]);
    }
    //End Detail Nego




    //Detail Product
    public function getProductPR(Request $request)
    {
        // dd($request);
        $id_pr = $request->id_pr; // Ambil id_pr dari request
        $proyek = strtolower($request->proyek);

        // Ambil DetailPR yang sesuai dengan id_pr
        $products = DetailPR::where('id_pr', $id_pr)->get();


        // Proses setiap produk
        $products = $products->map(function ($item) {
            $item->spek = $item->spek ? $item->spek : '';
            $item->keterangan = $item->keterangan ? $item->keterangan : '';
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            $item->nomor_negoluar = Negoluar::where('id', $item->id_negoluar)->first()->nomor_negoluar ?? '';
            $item->nomor_spph = Spph::where('id', $item->spph_id)->first()->nomor_spph ?? '';
            $item->pr_no = PurchaseRequest::where('id', $item->id_pr)->first()->no_pr ?? '';
            $item->po_no = Purchase_Order::where('id', $item->id_po)->first()->no_po ?? '';
            $item->nama_pekerjaan = Kontrak::where('id', $item->id_proyek)->first()->nama_pekerjaan ?? '';

            // Baru, hitung sisa Nego by QTY asli - jumlah di DetailNego by id_pr_detail
            $item->qty_negoluar = $item->qty - DetailNegoluar::where('id_detail_pr', $item->id)->sum('negoluar_qty');
            $item->qty_negoluar1 = 0;
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



    public function tambahNegoluarDetail(Request $request)
    {
        $id = $request->negoluar_id;
        $selected = $request->selected_id;



        // Cek jika Nego tidak ditemukan
        $negoluar = Negoluar::find($id);
        if (!$negoluar) {
            return response()->json(['message' => 'Data Nego tidak ditemukan'], 404);
        }

        // Ambil detail Nego
        $negoluar->details = DetailNegoluar::where('negoluar_id', $negoluar->id)
            ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_negoluar.id_detail_pr')
            ->select('detail_pr.*', 'detail_negoluar.id as id_detail_negoluar', 'detail_negoluar.harga as harga_per_unit', 'detail_negoluar.harga_imss as harga_per_unit_imss', 'detail_negoluar.negoluar_qty')
            ->get();

        $negoluar->details = $negoluar->details->map(function ($item) use ($negoluar) {
            $item->id_negoluar = $negoluar->id;
            $item->spek = $item->spek ? $item->spek : '';
            $item->satuan = $item->satuan ? $item->satuan : '';
            return $item;
        });

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil ditambahkan',
            'negoluar' => $negoluar
        ]);
    }




    public function nopr()
    {
        $data = PurchaseRequest::where('no_pr', 'LIKE', '%' . request('q') . '%')->paginate(10000);
        return response()->json($data);
    }




    //Print
    public function negoluarPrint(Request $request)
    {
        $id = $request->negoluar_id;
        $currency = $request->currency;
        

        $negoluar = Negoluar::where('id', $id)->first();
        $negoluar->details = DetailNegoluar::where('negoluar_id', $id)
            ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_negoluar.id_detail_pr')
            ->select('detail_pr.*', 'detail_negoluar.id as id_detail_negoluar', 'detail_negoluar.harga as harga_per_unit', 'detail_negoluar.harga_imss as harga_per_unit_imss', 'detail_negoluar.negoluar_qty')
            ->get();

        $negoluar->tanggal_negoluar = Carbon::parse($negoluar->tanggal_negoluar)->isoFormat('D MMMM Y');
        $negoluar->batas_negoluar = Carbon::parse($negoluar->batas_negoluar)->isoFormat('D MMMM Y');

        $vendor = json_decode($negoluar->vendor_id);
        $vendor_name = Vendor::whereIn('id', $vendor)->pluck('nama')->toArray();
        $vendor_alamat = Vendor::whereIn('id', $vendor)->pluck('alamat')->toArray();
        $vendor_telp = Vendor::whereIn('id', $vendor)->pluck('telp')->toArray();
        $vendor_fax = Vendor::whereIn('id', $vendor)->pluck('fax')->toArray();
        $vendor_email = Vendor::whereIn('id', $vendor)->pluck('email')->toArray();
        $vendor_cp = Vendor::whereIn('id', $vendor)->pluck('cp')->toArray();

        $newObjects = [];
        foreach ($vendor_name as $key => $value) {
            $newObject = new \stdClass();
            $newObject->nama = $value;
            $newObject->alamat = $vendor_alamat[$key];
            $newObject->telp = $vendor_telp[$key] ?? '-';
            $newObject->fax = $vendor_fax[$key] ?? '-';
            $newObject->email = $vendor_email[$key] ?? '-';
            $newObject->cp = $vendor_cp[$key] ?? '-';
            array_push($newObjects, $newObject);
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



        $lampiran = NegoluarLampiran::where('negoluar_id', $negoluar->id)->get();
        $negoluar->lampiran = $lampiran->count();
        $negoluars = $newObjects;
        $count = count($negoluars);

        // ✅ 1. Generate PDF utama (nego)
        $pdf = PDF::loadView('negoluar.negoluar_print', compact('negoluar', 'negoluars', 'count', 'lampiran', 'currency', 'symbol'));
        $pdfPath = storage_path('app/temp_nego.pdf');
        $pdf->save($pdfPath);


        // ✅ 2. Buat FPDI untuk menggabungkan dokumen
        // $fpdi = new FPDI();
        // $fpdi->setSourceFile($pdfPath);
        // $tplIdx = $fpdi->importPage(1);
        // $fpdi->AddPage();
        // $fpdi->useTemplate($tplIdx, 10, 10, 190);

        $fpdi = new FPDI();
        $pageCount = $fpdi->setSourceFile($pdfPath);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $tplIdx = $fpdi->importPage($pageNo);
            $size = $fpdi->getTemplateSize($tplIdx);

            // Deteksi orientasi halaman
            $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';

            $fpdi->AddPage($orientation);

            // Hitung scaling
            $pageWidth = $orientation === 'L' ? 297 : 210;
            $pageHeight = $orientation === 'L' ? 210 : 297;
            $scaleX = $pageWidth / $size['width'];
            $scaleY = $pageHeight / $size['height'];
            $scale = min($scaleX, $scaleY);
            $x = ($pageWidth - ($size['width'] * $scale)) / 2;
            $y = ($pageHeight - ($size['height'] * $scale)) / 2;

            $fpdi->useTemplate($tplIdx, $x, $y, $size['width'] * $scale, $size['height'] * $scale);
        }



        foreach ($lampiran as $file) {
            $filePath = public_path("/lampiran/{$file->file}");
            if (file_exists($filePath)) {
                $pageCount = $fpdi->setSourceFile($filePath);
                for ($i = 1; $i <= $pageCount; $i++) {
                    $tplIdx = $fpdi->importPage($i);
                    $size = $fpdi->getTemplateSize($tplIdx);

                    // Deteksi orientasi berdasarkan ukuran halaman
                    $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';

                    $fpdi->AddPage($orientation);

                    // Hitung scaling agar sesuai dengan halaman A4
                    $pageWidth = $orientation === 'L' ? 297 : 210; // A4 Landscape = 297mm, Portrait = 210mm
                    $pageHeight = $orientation === 'L' ? 210 : 297; // A4 Landscape = 210mm, Portrait = 297mm
                    $scaleX = $pageWidth / $size['width'];
                    $scaleY = $pageHeight / $size['height'];
                    $scale = min($scaleX, $scaleY); // Ambil skala yang lebih kecil agar tetap proporsional

                    // Posisikan gambar agar pas di tengah halaman
                    $x = ($pageWidth - ($size['width'] * $scale)) / 2;
                    $y = ($pageHeight - ($size['height'] * $scale)) / 2;

                    $fpdi->useTemplate($tplIdx, $x, $y, $size['width'] * $scale, $size['height'] * $scale);
                }
            }
        }

        // ✅ 4. Simpan hasil PDF yang sudah digabungkan
        $outputPath = storage_path("app/merged_nego.pdf");
        $fpdi->Output($outputPath, 'F');

        // ✅ 5. Kirimkan hasil PDF ke browser
        return response()->file($outputPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="NEGO_' . $negoluar->nomor_negoluar . '.pdf"',
        ]);
    }
    //EndPrint









}
