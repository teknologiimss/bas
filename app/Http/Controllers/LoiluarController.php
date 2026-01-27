<?php

namespace App\Http\Controllers;

use App\Models\DetailLoiluar;
use App\Models\DetailPR;
use App\Models\Kontrak;
use App\Models\Loiluar;
use App\Models\LoiluarLampiran;
use App\Models\Nego;
use App\Models\Purchase_Order;
use App\Models\PurchaseRequest;
use App\Models\Spph;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;

class LoiluarController extends Controller
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
        $loiluares = Loiluar::paginate(20);
        foreach ($loiluares as $key => $item) {
            $id = json_decode($item->vendor_id);
            $item->vendor = Vendor::whereIn('id', $id)->get();
            $item->vendor = $item->vendor->map(function ($item) {
                return $item->nama;
            });
            //change $item->vendor collection to array
            $item->vendor = $item->vendor->toArray();
            $item->vendor = implode(', ', $item->vendor);

            //lampiran bisa lebih dari 1
            $lampiran = LoiluarLampiran::where('loiluar_id', $item->id)->pluck('file')->toArray();
            $item->lampiran = implode(', ', $lampiran);
            // $item->lampiran = json_decode($item->lampiran); 
        }
        $vendors = Vendor::all();
        // dd($spphes);
        if ($search) {
            $loiluares = Loiluar::where('tanggal_loiluar', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == "json") {
            $categories = Loiluar::where("warehouse_id", $warehouse_id)->get();

            return response()->json($categories);
        } else {
            return view('loiluar.loiluar', compact('loiluares', 'vendors'));
        }
    }




    public function indexApps(Request $request)
    {
        $search = $request->q;

        if (Session::has('selected_warehouse_id')) {
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $loiluares = Loiluar::paginate(20);
        $vendors = Vendor::all();

        if ($search) {
            $loiluares = Loiluar::where('tanggal_loiluar', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == "json") {
            $categories = Loiluar::where("warehouse_id", $warehouse_id)->get();

            return response()->json($categories);
        } else {
            return view('home.apps.logistik.loiluar', compact('loiluares', 'vendors'));
        }
    }





    function FunctionCountPages($path)
    {
        $pdftextfile = file_get_contents($path);
        $pagenumber = preg_match_all("/\/Page\W/", $pdftextfile, $dummy);
        return $pagenumber;
    }





    public function store(Request $request)
    {
        $loiluar = $request->id;
        // if (Session::has('selected_warehouse_id')) {
        //     $warehouse_id = Session::get('selected_warehouse_id');
        // } else {
        //     $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        // }
        // dd($request->all());

        $request->validate([
            'nomor_loiluar' => 'required',
            'id_pr' => 'required',
            'nomor_pr' => 'required',
            // 'lampiran' => 'required',
            'vendor' => 'required',
            'tanggal_loiluar' => 'required',
            'batas_loiluar' => 'required',
            'perihal' => 'required',

            // 'penerima' => 'required',
            // 'alamat' => 'required'
        ], [
            'nomor_loiluar.required' => 'Nomor Loi harus diisi',
            'id_pr.required' => 'ID pr harus diisi',
            'nomor_pr.required' => 'Nomor pr harus diisi',
            // 'lampiran.required' => 'Lampiran harus diisi',
            'vendor.required' => 'Vendor harus diisi',
            'tanggal_loiluar.required' => 'Tanggal Loi harus diisi',
            'batas_loiluar.required' => 'Batas Loi harus diisi',
            'perihal.required' => 'Perihal harus diisi',
            'penerima.required' => 'Penerima harus diisi',
            'alamat.required' => 'Alamat harus diisi',

        ]);

        $data = [
            'nomor_loiluar' => $request->nomor_loiluar,
            'id_pr' => $request->id_pr,
            'nomor_pr' => $request->nomor_pr,
            'nomor_po' => $request->nomor_po,
            'vendor_id' => json_encode($request->vendor),
            'tanggal_po' => $request->tanggal_po,
            'tanggal_loiluar' => $request->tanggal_loiluar,
            'batas_loiluar' => $request->batas_loiluar,
            'perihal' => $request->perihal,
            'penerima' => json_encode($request->penerima),
            'alamat' => json_encode($request->alamat),
            'keterangan_loiluar' => $request->keterangan_loiluar,
            'signature_imss' => $request->signature_imss,
            'signature_vendor' => $request->signature_vendor,
        ];

        // Ubah data vendor menjadi ID berdasarkan nama
        $vendorNames = json_decode($data['vendor_id']);
        $vendors = Vendor::whereIn('nama', $vendorNames)->pluck('id')->toArray();
        $data['vendor_id'] = json_encode($vendors);


        // dd($data);

        if (empty($loiluar)) {
            $add = Loiluar::create($data);

            // Check if 'lampiran' exists and is not null
            if ($request->hasFile('lampiran')) {
                $files = $request->file('lampiran');
                foreach ($files as $file) {
                    $file_name = rand() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('lampiran'), $file_name);
                    LoiluarLampiran::create([
                        'loiluar_id' => $add->id,
                        'file' => $file_name,
                        'tipe' => $this->FunctionCountPages(public_path('lampiran/' . $file_name))
                    ]);
                }
            }

            if ($add) {
                return redirect()->route('loiluar.index')->with('success', 'Loi berhasil ditambahkan');
            } else {
                return redirect()->route('loiluar.index')->with('error', 'Loi gagal ditambahkan');
            }
        } else {
            $update = Loiluar::where('id', $loiluar)->update($data);
            if ($request->hasFile('lampiran')) {
                $files = $request->file('lampiran');
                foreach ($files as $file) {
                    $file_name = rand() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('lampiran'), $file_name);
                    LoiluarLampiran::create([
                        'loiluar_id' => $loiluar,
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
                    LoiluarLampiran::where('loiluar_id', $loiluar)->where('file', $existing_file)->delete();

                    // Hapus dari filesystem jika perlu
                    // $file_path = public_path('lampiran/' . $existing_file);
                    // if (file_exists($file_path)) {
                    //     unlink($file_path);
                    // }
                }
            }

            // if ($request->hasFile('lampiran')) {
            //     $files = $request->file('lampiran');
            //     foreach ($files as $file) {
            //         $file_name = rand() . '.' . $file->getClientOriginalExtension();
            //         $file->move(public_path('lampiran'), $file_name);

            //         // Find the existing SpphLampiran record to update
            //         $lampiran = SpphLampiran::where('spph_id', $spph)->first();

            //         if ($lampiran) {
            //             // Update the existing record
            //             $lampiran->update([
            //                 'file' => $file_name,
            //                 'tipe' => $this->FunctionCountPages(public_path('lampiran/' . $file_name))
            //             ]);
            //         }
            //     }
            // }


            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'SPPH berhasil diupdate',
            //     'data' => $update
            // ]);

            if ($update) {
                return redirect()->route('loiluar.index')->with('success', 'loi berhasil diupdate');
            } else {
                return redirect()->route('loiluar.index')->with('error', 'loi gagal diupdate');
            }
        }

        // return redirect()->route('spph.index')->with('success', 'SPPH berhasil disimpan');
    }








    public function QtyLoiluarSave(Request $request)
    {
        // Validasi array
        $request->validate([
            'data' => 'required|array',
            'data.*.id' => 'required|integer',
            'data.*.qty_loiluar1' => 'required|numeric|min:0' // Memastikan qty_loi1 minimal 0 agar tetap bisa tersimpan
        ]);

        foreach ($request->data as $item) {
            $loiDetail = DetailPR::find($item['id']);

            if (!$loiDetail) continue;

            // Simpan data ke tabel DetailLoi meskipun qty_loi1 bernilai 0
            DetailLoiluar::create([
                'loiluar_id' => $item['loiluar_id'],
                'id_detail_pr' => $item['id'],
                'loiluar_qty' => $item['qty_loiluar1'],
                'id_del_loiluar' => 0,
            ]);
        }

        return response()->json(['success' => true]);
    }




    //simpan detailloi
    public function detailLoiluarSave(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'id' => 'required|integer',
            'id_loiluar' => 'required|integer',
            'id_detail_loiluar' => 'required|integer',
            'harga_per_unit' => 'required|numeric',
        ]);

        // Ambil data dari request
        $id = $request->id;
        $id_loiluar = $request->id_loiluar;
        $id_detail_loiluar = $request->id_detail_loiluar;
        $harga_per_unit = $request->harga_per_unit;

        // Update data di tabel DetailLoiluar
        $updated = \App\Models\DetailLoiluar::where('id', $id_detail_loiluar)->update([
            'harga' => $harga_per_unit,
        ]);

        if (!$updated) {
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui data'], 500);
        }

        // Ambil data Loiluar dan detailnya setelah update
        $loiluar = \App\Models\Loiluar::select('loiluar.*')
            ->where('loiluar.id', $request->id_loiluar)
            ->first();

        if (!$loiluar) {
            return response()->json(['success' => false, 'message' => 'Data LOI Luar tidak ditemukan'], 404);
        }

        $loiluar->details = \App\Models\DetailLoiluar::where('detail_loiluar.loiluar_id', $loiluar->id)
            ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_loiluar.id_detail_pr')
            ->select(
                'detail_pr.*',
                'detail_loiluar.id as id_detail_loiluar',
                'detail_loiluar.harga as harga_per_unit',
                'detail_loiluar.loiluar_qty'
            )
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menyimpan detail LOI Luar!',
            'loiluar' => $loiluar
        ]);
    }
    //End simpan detail loi







    //Hapus
    public function destroy(Request $request)
    {
        $delete_loiluar_id = $request->id;
        $detail_loiluar = DB::table('detail_loiluar')->where('loiluar_id', $delete_loiluar_id)->first();
        if ($detail_loiluar) {
            // Ambil data detail_pr terkait
            $detail_pr = DB::table('detail_pr')->where('id', $detail_loiluar->id_detail_pr)->first();

            if ($detail_loiluar && $detail_pr) {
                if (!$detail_loiluar->id_del_loiluar) {
                    DB::table('detail_pr')->where('id', $detail_pr->id)->update(['qty_loiluar' => $detail_pr->qty]);
                } else {
                    // Jika ada id_del_loi, tambahkan qty_spph ke qty1
                    $loiluar_qty = $detail_loiluar->loiluar_qty;
                    $new_qty_loiluar = ($detail_pr->qty_loiluar ?? 0) + $loiluar_qty;
                    DB::table('detail_pr')->where('id', $detail_pr->id)->update(['qty_loiluar' => $new_qty_loiluar]);
                }
            }
        }

        // Perbarui kolom id_loi di tabel detail_pr menjadi null
        $update_detail_pr = DB::table('detail_pr')
            ->where('id_loiluar', $delete_loiluar_id)
            ->update(['id_loiluar' => null]);

        // Hapus data dari tabel detail_spph yang memiliki id_loi sesuai
        $delete_detail_loi = DB::table('detail_loiluar')
            ->where('loiluar_id', $delete_loiluar_id)
            ->delete();

        // Setelah memperbarui detail_pr dan menghapus detail_loi, hapus data dari tabel loi
        $delete_loiluar = DB::table('loiluar')->where('id', $delete_loiluar_id)->delete();

        if ($delete_loiluar) {
            return redirect()->route('loiluar.index')->with('success', 'Data loi berhasil dihapus');
        } else {
            return redirect()->route('loiluar.index')->with('error', 'Data loi gagal dihapus');
        }
    }

    //End Hapus





    //hapus detail loi
    public function destroyDetailLoiluar(Request $request)
    {
        // Menerima data dari request
        $id = $request->id;
        $id_loiluar = $request->id_loiluar;
        $id_detail_pr = $request->id_detail_pr;
        $id_detail_loiluar = $request->id_detail_loiluar; //ggwp

        // dd($request->all());
        // Mengambil data detail_spph dan detail_pr untuk validasi
        $detail_loiluar = DetailLoiluar::find($id_detail_loiluar);
        $detail_pr = DetailPR::find($id);

        // Validasi: cek jika id_del_spph di detail_spph ada
        if ($detail_loiluar && $detail_pr) {
            if (!$detail_loiluar->id_del_loiluar) {
                // Jika tidak ada id_del_spph, set qty1 dengan nilai qty dari detail_pr
                $detail_pr->qty_loiluar = $detail_pr->qty;
                $detail_pr->save();
            } else {
                // Jika id_del_spph ada dan data dihapus dari detail_spph
                // Ambil nilai qty_spph dan tambahkan ke qty1
                $loiluar_qty = $detail_loiluar->loiluar_qty;

                // Tambahkan qty_spph ke qty1 yang sudah ada
                $detail_pr->qty_loiluar += $loiluar_qty;
                $detail_pr->save();
            }
        }



        // Jika penghapusan berhasil, hapus referensi id_spph di detail_pr


        // Menghapus detail Loi berdasarkan ID
        $delete_detail_loiluar = DetailLoiluar::where('id', $id_detail_loiluar)->delete(); //ggwp

        // Menghapus semua referensi loi_id dari tabel detail_loi
        $delete_all_details = DetailLoiluar::where('loiluar_id', $id_detail_loiluar)->delete(); //ggwp, gk pake hapus aja bang

        // Mengupdate tabel DetailPR untuk menghapus referensi id_loi
        $delete_detail_pr = DetailPR::where('id', $id)->update([ //ggwp
            'id_loiluar' => null
        ]);

        // Jika semua operasi berhasil, ambil data loi yang diperbarui
        if ($delete_detail_loiluar) {  //ggwp
            $loiluar = Loiluar::select('loiluar.*')
                // ->leftjoin('vendor', 'vendor.id', '=', 'loi.vendor_id')
                // ->leftjoin('keproyekan', 'keproyekan.id', '=', 'loi.proyek_id')
                ->where('loiluar.id', $request->id_loiluar)
                ->first();

            if (!$loiluar) {
                return response()->json(['message' => 'Data loi tidak ditemukan'], 404);
            }

            $loiluar->details = DetailLoiluar::where('loiluar_id', $loiluar->id)
                ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_loiluar.id_detail_pr')
                ->select('detail_pr.*', 'detail_loiluar.id as id_detail_loiluar', 'detail_loiluar.harga as harga_per_unit',   'detail_loiluar.loiluar_qty')
                ->get();

            $loiluar->details = $loiluar->details->map(function ($item) use ($loiluar) {
                $item->id_loiluar = $loiluar->id;
                return $item;
            });

            return response()->json([
                'loiluar' => $loiluar
            ]);
        } else {
            // Mengembalikan response JSON dengan nilai loi null jika operasi gagal
            return response()->json([
                'loiluar' => null
            ]);
        }
    }
    //End hapus detail loi






    //Hapus Multiple
    public function hapusMultipleLoiluar(Request $request)
    {
        if ($request->has('ids')) {
            $ids = $request->input('ids');

            // Perbarui kolom id_loi di tabel detail_pr menjadi null
            DB::table('detail_pr')
                ->whereIn('id_loiluar', $ids)
                ->update(['id_loiluar' => null]);

            // Hapus data dari tabel detail_loi yang memiliki id_po sesuai
            DB::table('detail_loiluar')
                ->whereIn('loiluar_id', $ids)
                ->delete();

            // Hapus data dari tabel loi
            Loiluar::whereIn('id', $ids)->delete();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
    //End Hapus Multiple 






    //Get Detail Loi isian lihat detail
    public function getDetailLoiluar(Request $request)
    {
        $id = $request->id;
        $loiluar = Loiluar::where('id', $id)->first();
        $vendor = json_decode($loiluar->vendor_id);
        $vendor = Vendor::whereIn('id', $vendor)->get();
        $vendor = $vendor->map(function ($item) {
            return $item->nama;
        });
        $vendor = $vendor->toArray();
        $vendor = implode(', ', $vendor);
        $loiluar->penerima = $vendor;

        $loiluar->details = DetailLoiluar::where('loiluar_id', $id)
            ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_loiluar.id_detail_pr')
            ->select('detail_pr.*', 'detail_loiluar.id as id_detail_loiluar', 'detail_loiluar.harga as harga_per_unit',  'detail_loiluar.loiluar_qty')
            ->get();

        $loiluar->details = $loiluar->details->map(function ($item) use ($id) {
            $item->id_loiluar = $id;
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
        // dd($loi->details);

        return response()->json([
            'loiluar' => $loiluar
        ]);
    }
    //End Detail Loi






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
            $item->nomor_nego = Nego::where('id', $item->id_nego)->first()->nomor_nego ?? '';
            $item->nomor_loiluar = Loiluar::where('id', $item->id_loiluar)->first()->nomor_loiluar ?? '';
            $item->nomor_spph = Spph::where('id', $item->spph_id)->first()->nomor_spph ?? '';
            $item->pr_no = PurchaseRequest::where('id', $item->id_pr)->first()->no_pr ?? '';
            $item->po_no = Purchase_Order::where('id', $item->id_po)->first()->no_po ?? '';
            $item->nama_pekerjaan = Kontrak::where('id', $item->id_proyek)->first()->nama_pekerjaan ?? '';

            // Baru, hitung sisa Nego by QTY asli - jumlah di DetailNego by id_pr_detail
            $item->qty_loiluar = $item->qty - DetailLoiluar::where('id_detail_pr', $item->id)->sum('loiluar_qty');

            // Pastikan qty_loi1 selalu memiliki nilai minimal 0
            $item->qty_loiluar1 = 0;

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








    public function tambahLoiluarDetail(Request $request)
    {
        $id = $request->loiluar_id;
        $selected = $request->selected_id;

        // Cek jika selected_id kosong
        if (empty($selected)) {
            return response()->json([
                'success' => false,
                'message' => 'Pilih barang terlebih dahulu'
            ]);
        }

        // foreach ($selected as $key => $value) {
        //     $id_barang = $value;
        //     // Temukan DetailPR berdasarkan ID
        //     $detailPr = DetailPR::find($value);



        //     // Dapatkan nilai qty_loi1 dan id_del
        //     $qty_loi1 = $detailPr->qty_loi1;
        //     $id_del = $detailPr->id_del;

        //     // Tambahkan data ke tabel Detailloi
        //     $detailLoi = DetailLoi::create([
        //         'loi_id' => $id,
        //         'id_detail_pr' => $id_barang,
        //         // Gunakan $value untuk id_detail_pr
        //         'loi_qty' => $qty_loi1,  // Masukkan qty_loi1 ke kolom qty_spph
        //         'id_del_loi' => $id_del,
        //     ]);

        //     // Update status dan qty_loi1 pada DetailPR
        //     $update = DetailPR::where('id', $value)->update([
        //         'status' => 2,
        //         'qty_loi1' => null,  // Set qty_loi1 menjadi null
        //         'id_loi' => $id,
        //     ]);

        //     // Tambahkan id_loi jika qty_loi bernilai 0
        //     if ($detailPr->qty_loi == 0) {
        //         $updateData = [
        //             'id_loi' => $id
        //         ];

        //         // Lakukan update pada DetailPR
        //         DetailPR::where('id', $value)->update($updateData);
        //     }
        // }

        // Cek jika Loi tidak ditemukan
        $loiluar = Loiluar::find($id);
        if (!$loiluar) {
            return response()->json(['message' => 'Data Loi tidak ditemukan'], 404);
        }

        // Ambil detail Loi
        $loiluar->details = DetailLoiluar::where('loiluar_id', $loiluar->id)
            ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_loiluar.id_detail_pr')
            ->select('detail_pr.*', 'detail_loiluar.id as id_detail_loiluar', 'detail_loiluar.harga as harga_per_unit', 'detail_loiluar.loiluar_qty')
            ->get();

        $loiluar->details = $loiluar->details->map(function ($item) use ($loiluar) {
            $item->id_loiluar = $loiluar->id;
            $item->spek = $item->spek ? $item->spek : '';
            $item->satuan = $item->satuan ? $item->satuan : '';
            return $item;
        });

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil ditambahkan',
            'loiluar' => $loiluar
        ]);
    }





    public function nopr()
    {
        $data = PurchaseRequest::where('no_pr', 'LIKE', '%' . request('q') . '%')->paginate(10000);
        return response()->json($data);
    }







    //Print
    public function loiluarPrint(Request $request)
    {
        $id = $request->loiluar_id;
        $currency = $request->currency;
        $loiluar = Loiluar::where('id', $id)->first();
        $loiluar->details = DetailLoiluar::where('loiluar_id', $id)
            ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_loiluar.id_detail_pr')
            ->select('detail_pr.*', 'detail_loiluar.id as id_detail_loiluar', 'detail_loiluar.harga as harga_per_unit', 'detail_loiluar.loiluar_qty')
            ->get();

        $loiluar->tanggal_loiluar = Carbon::parse($loiluar->tanggal_loiluar)->isoFormat('D MMMM Y');
        $loiluar->batas_loiluar = Carbon::parse($loiluar->batas_loiluar)->isoFormat('D MMMM Y');

        $vendor = json_decode($loiluar->vendor_id);
        $vendor_name = Vendor::whereIn('id', $vendor)->pluck('nama')->toArray();
        $vendor_alamat = Vendor::whereIn('id', $vendor)->pluck('alamat')->toArray();
        $vendor_telp = Vendor::whereIn('id', $vendor)->pluck('telp')->toArray();
        $vendor_fax = Vendor::whereIn('id', $vendor)->pluck('fax')->toArray();
        $vendor_email = Vendor::whereIn('id', $vendor)->pluck('email')->toArray();

        $newObjects = [];
        foreach ($vendor_name as $key => $value) {
            $newObject = new \stdClass();
            $newObject->nama = $value;
            $newObject->alamat = $vendor_alamat[$key];
            $newObject->telp = $vendor_telp[$key];
            $newObject->fax = $vendor_fax[$key];
            $newObject->email = $vendor_email[$key];
            array_push($newObjects, $newObject);
        }

        $lampiran = LoiluarLampiran::where('loiluar_id', $loiluar->id)->get();
        $loiluar->lampiran = $lampiran->count();
        $loiluars = $newObjects;
        $count = count($loiluars);


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


        // ✅ 1. Generate PDF utama (loi)
        $pdf = PDF::loadView('loiluar.loiluar_print', compact('loiluar', 'loiluars', 'count','symbol', 'lampiran'));
        $pdfPath = storage_path('app/temp_loiluar.pdf');
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
        $outputPath = storage_path("app/merged_loiluar.pdf");
        $fpdi->Output($outputPath, 'F');

        // ✅ 5. Kirimkan hasil PDF ke browser
        return response()->file($outputPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="LOI_' . $loiluar->nomor_loiluar . '.pdf"',
        ]);
    }
    //EndPrint



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
}
