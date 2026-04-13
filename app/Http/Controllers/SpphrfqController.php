<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Spph;
use App\Models\Vendor;
use App\Models\Kontrak;
use App\Models\Product;
use App\Models\DetailPR;
use App\Models\DetailSpph;
use App\Models\DetailSpphrfq;
use App\Models\Keproyekan;
use App\Models\SpphLampiran;
use Illuminate\Http\Request;
use App\Models\Purchase_Order;
use App\Models\PurchaseRequest;
use App\Models\SpphRfq;
use App\Models\SpphRfqLampiran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;


class SpphrfqController extends Controller
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
        $spphrfqes = SpphRfq::paginate(50);
        foreach ($spphrfqes as $key => $item) {
            $id = json_decode($item->vendor_id);
            $item->vendor = Vendor::whereIn('id', $id)->get();
            $item->vendor = $item->vendor->map(function ($item) {
                return $item->nama;
            });
            //change $item->vendor collection to array
            $item->vendor = $item->vendor->toArray();
            $item->vendor = implode(', ', $item->vendor);

            //lampiran bisa lebih dari 1
            $lampiran = SpphRfqLampiran::where('spphrfq_id', $item->id)->pluck('file')->toArray();
            $item->lampiran = implode(', ', $lampiran);
            // $item->lampiran = json_decode($item->lampiran);
        }
        $vendors = Vendor::all();
        // dd($spphes);
        if ($search) {
            $spphes = Spph::where('tanggal_spph', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == "json") {
            $categories = SpphRfq::where("warehouse_id", $warehouse_id)->get();

            return response()->json($categories);
        } else {
            return view('spph_rfq.spph_rfq', compact('spphrfqes', 'vendors'));
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
        $spph = $request->id;
        // if (Session::has('selected_warehouse_id')) {
        //     $warehouse_id = Session::get('selected_warehouse_id');
        // } else {
        //     $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        // }
        // dd($request->all());

        $request->validate([
            'nomor_spphrfq' => 'required',
            'id_pr' => 'required',
            'nomor_pr' => 'required',
            // 'lampiran' => 'required',
            'vendor' => 'required',
            'tanggal_spphrfq' => 'required',
            'batas_spphrfq' => 'required',
            'perihal' => 'required',
            // 'penerima' => 'required',
            // 'alamat' => 'required'
        ], [
            'nomor_spphrfq.required' => 'Nomor SPPH harus diisi',
            'id_pr.required' => 'ID PR harus diisi',
            'nomor_pr.required' => 'Nomor PR harus diisi',
            // 'lampiran.required' => 'Lampiran harus diisi',
            'vendor.required' => 'Vendor harus diisi',
            'tanggal_spphrfq.required' => 'Tanggal SPPH harus diisi',
            'batas_spphrfq.required' => 'Batas SPPH harus diisi',
            'perihal.required' => 'Perihal harus diisi',
            'penerima.required' => 'Penerima harus diisi',
            'alamat.required' => 'Alamat harus diisi'
        ]);

        $data = [
            'nomor_spphrfq' => $request->nomor_spphrfq,
            'id_pr' => $request->id_pr,
            'nomor_pr' => $request->nomor_pr,
            'vendor_id' => json_encode($request->vendor),
            'tanggal_spphrfq' => $request->tanggal_spphrfq,
            'batas_spphrfq' => $request->batas_spphrfq,
            'perihal' => $request->perihal,
            'penerima' => json_encode($request->penerima),
            'alamat' => json_encode($request->alamat),
            'keterangan_spphrfq' => $request->keterangan_spphrfq,
        ];

        // Ubah data vendor menjadi ID berdasarkan nama
        $vendorNames = json_decode($data['vendor_id']);
        $vendors = Vendor::whereIn('nama', $vendorNames)->pluck('id')->toArray();
        $data['vendor_id'] = json_encode($vendors);


        // dd($data);

        if (empty($spph)) {
            $add = SpphRfq::create($data);

            // Check if 'lampiran' exists and is not null
            if ($request->hasFile('lampiran')) {
                $files = $request->file('lampiran');
                foreach ($files as $file) {
                    $file_name = rand() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('lampiran'), $file_name);
                    SpphRfqLampiran::create([
                        'spphrfq_id' => $add->id,
                        'file' => $file_name,
                        'tipe' => $this->FunctionCountPages(public_path('lampiran/' . $file_name))
                    ]);
                }
            }

            if ($add) {
                return redirect()->route('spph_rfq.index')->with('success', 'SPPH berhasil ditambahkan');
            } else {
                return redirect()->route('spph_rfq.index')->with('error', 'SPPH gagal ditambahkan');
            }
        } else {
            $update = SpphRfq::where('id', $spph)->update($data);
            if ($request->hasFile('lampiran')) {
                $files = $request->file('lampiran');
                foreach ($files as $file) {
                    $file_name = rand() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('lampiran'), $file_name);
                    SpphRfqLampiran::create([
                        'spphrfq_id' => $spph,
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
                    SpphRfqLampiran::where('spphrfq_id', $spph)->where('file', $existing_file)->delete();

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
                return redirect()->route('spph_rfq.index')->with('success', 'SPPH berhasil diupdate');
            } else {
                return redirect()->route('spph_rfq.index')->with('error', 'SPPH gagal diupdate');
            }
        }

        // return redirect()->route('spph.index')->with('success', 'SPPH berhasil disimpan');
    }


    //menghapus SPPH RFQ
    public function destroy(Request $request)
    {
        $delete_spph_id = $request->id;

        // Ambil data detail_spph yang akan dihapus
        $detail_spph = DB::table('detail_spphrfq')->where('spphrfq_id', $delete_spph_id)->first();

        if ($detail_spph) {
            // Ambil data detail_pr terkait
            $detail_pr = DB::table('detail_pr')->where('id', $detail_spph->id_detail_pr)->first();

            if ($detail_pr) {
                // Cek apakah ada id_del_spph di detail_spph
                if (!$detail_spph->id_del_spphrfq) {
                    // Jika tidak ada id_del_spph, set qty_spph dengan nilai qty dari detail_pr
                    DB::table('detail_pr')->where('id', $detail_pr->id)->update(['qty_spphrfq' => $detail_pr->qty]);
                }

                // Ambil semua data detail_spph dengan spph_id yang akan dihapus
                $detail_spph_list = DB::table('detail_spphrfq')->where('spphrfq_id', $delete_spph_id)->get();

                if ($detail_spph_list->isNotEmpty()) {
                    // Kelompokkan data detail_spph berdasarkan id_detail_pr
                    $grouped = $detail_spph_list->groupBy('id_detail_pr');

                    foreach ($grouped as $id_detail_pr => $spph_entries) {
                        // Hitung total spph_qty untuk id_detail_pr tersebut
                        $total_spph_qty = $spph_entries->sum('spphrfq_qty');

                        // Ambil data detail_pr terkait
                        $detail_pr = DB::table('detail_pr')->where('id', $id_detail_pr)->first();
                        if ($detail_pr) {
                            $new_qty_spph = ($detail_pr->qty_spphrfq ?? 0) + $total_spph_qty;
                            DB::table('detail_pr')->where('id', $detail_pr->id)->update([
                                'qty_spphrfq' => $new_qty_spph
                            ]);
                        }
                    }
                }
            }
        }

        // Perbarui kolom id_spph di tabel detail_pr menjadi null
        DB::table('detail_pr')->where('id_spphrfq', $delete_spph_id)->update(['id_spphrfq' => null]);

        // Hapus data dari tabel detail_spph yang memiliki id_spph sesuai
        DB::table('detail_spphrfq')->where('spphrfq_id', $delete_spph_id)->delete();

        // Setelah memperbarui detail_pr dan menghapus detail_spph, hapus data dari tabel spph
        $delete_spph = DB::table('spphrfq')->where('id', $delete_spph_id)->delete();

        if ($delete_spph) {
            return redirect()->route('spph_rfq.index')->with('success', 'Data SPPH berhasil dihapus, id_spph pada detail_pr diubah menjadi null, dan detail_spph berhasil dihapus');
        } else {
            return redirect()->route('spph_rfq.index')->with('error', 'Data SPPH gagal dihapus');
        }
    }
    //End Hapus SPPH RFQ



    //hapus yang dipilih
    public function hapusMultipleSpph(Request $request)
    {
        if ($request->has('ids')) {
            $ids = $request->input('ids');

            // Ambil semua data detail_spph yang akan dihapus
            $detail_spph_list = DB::table('detail_spphrfq')->whereIn('spphrfq_id', $ids)->get();

            if ($detail_spph_list->isNotEmpty()) {
                // Kelompokkan data detail_spph berdasarkan id_detail_pr
                $grouped = $detail_spph_list->groupBy('id_detail_pr');

                foreach ($grouped as $id_detail_pr => $spph_entries) {
                    // Hitung total spph_qty untuk id_detail_pr tersebut
                    $total_spph_qty = $spph_entries->sum('spphrfq_qty');

                    // Ambil data detail_pr terkait
                    $detail_pr = DB::table('detail_pr')->where('id', $id_detail_pr)->first();
                    if ($detail_pr) {
                        // Update qty_spph dengan menambahkan kembali total_spph_qty
                        $new_qty_spph = ($detail_pr->qty_spphrfq ?? 0) + $total_spph_qty;
                        DB::table('detail_pr')->where('id', $detail_pr->id)->update([
                            'qty_spphrfq' => $new_qty_spph
                        ]);
                    }
                }
            }

            // Perbarui kolom id_spph di tabel detail_pr menjadi null
            DB::table('detail_pr')
                ->whereIn('id_spphrfq', $ids)
                ->update(['id_spphrfq' => null]);

            // Hapus data dari tabel detail_spph yang memiliki id_spph sesuai
            DB::table('detail_spphrfq')
                ->whereIn('spphrfq_id', $ids)
                ->delete();

            // Hapus data dari tabel spph
            Spph::whereIn('id', $ids)->delete();

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
    //End hapus yang dipilih




    //Menghapus Detail SPPH
    public function destroyDetailSpphrfq(Request $request)
    {
        // Menerima data dari request
        $id = $request->id;
        $id_spphrfq = $request->id_spphrfq;
        $id_detail_pr = $request->id_detail_pr;
        $id_detail_spphrfq = $request->id_detail_spphrfq;

        // Mengambil data detail_spph dan detail_pr untuk validasi
        $detail_spphrfq = DetailSpphrfq::find($id_detail_spphrfq);
        $detail_pr = DetailPR::find($id);

        // Validasi apakah data ada
        if (!$detail_spphrfq) {
            return response()->json(['error' => 'Detail SPPH tidak ditemukan'], 404);
        }

        if (!$detail_pr) {
            return response()->json(['error' => 'Detail PR tidak ditemukan'], 404);
        }

        // Cek apakah ada id_del_spph di detail_spph
        if (!$detail_spphrfq->id_del_spphrfq) {
            // Jika tidak ada id_del_spph, set qty1 dengan nilai qty dari detail_pr
            $detail_pr->qty_spphrfq = $detail_pr->qty;
        } else {
            // Jika ada id_del_spph, tambahkan qty_spph ke qty1
            $spphrfq_qty = $detail_spphrfq->spphrfq_qty;
            $detail_pr->qty_spphrfq = ($detail_pr->qty_spphrfq ?? 0) + $spphrfq_qty;
        }

        $detail_pr->save();

        // Hapus data di detail_spph
        $delete_detail_spph = $detail_spphrfq->delete();

        // // Jika penghapusan berhasil, hapus referensi id_spph di detail_pr
        // if ($delete_detail_spph) {
        //     DetailPR::where('id', $id)->update(['id_spph' => null]);
        // }

        // Ambil data SPPH yang diperbarui
        $spphrfq = SpphRfq::where('id', $request->id_spphrfq)->first();

        if (!$spphrfq) {
            return response()->json(['message' => 'Data SPPH tidak ditemukan'], 404);
        }

        // Mengambil detail SPPH terbaru
        $spphrfq->details = DetailSpphrfq::where('detail_spphrfq.spphrfq_id', $spphrfq->id)
            ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_spphrfq.id_detail_pr')
            ->select(
                'detail_pr.*',
                'detail_spphrfq.id as id_detail_spphrfq',
                'detail_spphrfq.spphrfq_qty'
            )
            ->get();

        $spphrfq->details = $spphrfq->details->map(function ($item) use ($spphrfq) {
            $item->id_spph = $spphrfq->id;
            return $item;
        });

        return response()->json([
            'spphrfq' => $spphrfq
        ]);
    }

    //End Menghapus Detail SPPH




    //Detail SPPH RFQ
    public function getDetailSpphrfq(Request $request)
    {
        $id = $request->id;
        $spphrfq = SpphRfq::where('id', $id)->first();
        $vendor = json_decode($spphrfq->vendor_id);
        $vendor = Vendor::whereIn('id', $vendor)->get();
        $vendor = $vendor->map(function ($item) {
            return $item->nama;
        });
        $vendor = $vendor->toArray();
        $vendor = implode(', ', $vendor);
        $spphrfq->penerima = $vendor;

        $spphrfq->details = DetailSpphrfq::where('spphrfq_id', $id)
            ->select('detail_spphrfq.*', 'detail_pr.*', 'detail_spphrfq.id as id_detail_spphrfq')
            ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_spphrfq.id_detail_pr', 'detail_spphrfq.spphrfq_qty')
            ->get();

        $spphrfq->details = $spphrfq->details->map(function ($item) use ($id) {
            $item->id_spphrfq = $id;
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

        return response()->json([
            'spphrfq' => $spphrfq
        ]);
    }

    //End Detail SPPH RFQ 



    //Product 
    public function getProductPR(Request $request)
    {
        // dd($request);
        $id_pr = $request->id_pr; // Ambil id_pr dari request
        $proyek = strtolower($request->proyek);

        // Ambil DetailPR yang sesuai dengan id_pr
        $products = DetailPR::whereIn('id_pr', explode(',', $id_pr))->get();

        // Proses setiap produk
        $products = $products->map(function ($item) {
            $item->spek = $item->spek ? $item->spek : '';
            $item->keterangan = $item->keterangan ? $item->keterangan : '';
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            $item->nomor_spphrfq = SpphRfq::where('id', $item->id_spphrfq)->first()->nomor_spphrfq ?? '';
            $item->pr_no = PurchaseRequest::where('id', $item->id_pr)->first()->no_pr ?? '';
            $item->po_no = Purchase_Order::where('id', $item->id_po)->first()->no_po ?? '';
            $item->nama_pekerjaan = Kontrak::where('id', $item->id_proyek)->first()->nama_pekerjaan ?? ''; // Ambil nama_pekerjaan

            $item->qty_spphrfq = $item->qty - DetailSpphrfq::where('id_detail_pr', $item->id)->sum('spphrfq_qty');
            $item->qty2 = 0;

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

    //End Product



    //print SPPH RFQ
    public function spphPrintrfq(Request $request)
    {
        $id = $request->id ?? $request->spphrfq_id;
        $spphrfq = SpphRfq::where('id', $id)->first();
        $spphrfq->details = DetailSpphrfq::where('spphrfq_id', $id)->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_spphrfq.id_detail_pr')->get();
        $spphrfq->tanggal_spphrfq = Carbon::parse($spphrfq->tanggal_spphrfq)->isoFormat('D MMMM Y');
        $spphrfq->batas_spphrfq = Carbon::parse($spphrfq->batas_spphrfq)->isoFormat('D MMMM Y');

        $vendor = json_decode($spphrfq->vendor_id);
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
            $newObject->telp = $vendor_telp[$key];
            $newObject->fax = $vendor_fax[$key];
            $newObject->email = $vendor_email[$key];
            $newObject->cp = $vendor_cp[$key];
            array_push($newObjects, $newObject);
        }

        $lampiran = SpphRfqLampiran::where('spphrfq_id', $spphrfq->id)->get();
        $spphrfq->lampiran = $lampiran->count();
        $spphrfqs = $newObjects;
        $count = count($spphrfqs);

        // Generate main PDF
        $pdf = PDF::loadview('spph_rfq.spph_rfq_print', compact('spphrfq', 'spphrfqs', 'count', 'lampiran'));
        $no_spph = $spphrfq->nomor_spphrfq;
        $pdf->setPaper('A4', 'portrait');

        // Simpan PDF utama ke file sementara
        $pdfPath = storage_path('app/temp_spph.pdf');
        $pdf->save($pdfPath);

        // Gabungkan dengan lampiran PDF
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
        $outputPath = storage_path("app/merged_loi.pdf");
        $fpdi->Output($outputPath, 'F');

        // ✅ 5. Kirimkan hasil PDF ke browser
        return response()->file($outputPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="SPPHRFQ_' . $spphrfq->nomor_spphrfq . '.pdf"',
        ]);
    }
    //End Print SPPH RFQ



    //tambah SPPH Detail
    function tambahSpphDetail(Request $request)
    {
        $id = $request->spphrfq_id; // ID dari SPPH
        $selected = $request->selected_id; // Array ID barang yang dipilih

        

        // Ambil data SPPH beserta detailnya
        $spphrfq = SpphRfq::where('id', $id)->first();

        $spphrfq->details = DetailSpphrfq::where('spphrfq_id', $id)
            ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_spphrfq.id_detail_pr')
            ->select('detail_pr.*', 'detail_spphrfq.id as id_detail_spphrfq', 'detail_spphrfq.spphrfq_qty')
            ->get();
        // return response()->json($spph->details);

        $spphrfq->details = $spphrfq->details->map(function ($item) use ($id) {
            $item->id_spphrfq = $id;
            $item->spek = $item->spek ? $item->spek : '';
            $item->keterangan = $item->keterangan ? $item->keterangan : '';
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            $item->nomor_spphrfq = SpphRfq::where('id', $id)->first()->nomor_spphrfq ?? '';
            return $item;
        });

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil ditambahkan',
            'spphrfq' => $spphrfq,

        ]);
    }

    //End tambah SPPH Detail



    //Simpan Detail SPPH
    public function detailSpphSaverfq(Request $request)
    {
        // Validasi array
        $request->validate([
            'data' => 'required|array',
            'data.*.id' => 'required|integer',
            'data.*.qty2' => 'required|numeric|min:0'
        ]);

        foreach ($request->data as $item) {
            $spphDetail = DetailPR::find($item['id']);

            if (!$spphDetail) continue;

            // Pastikan qty2 tidak lebih besar dari qty_spph
            // if ($spphDetail->qty_spph < $item['qty2']) {
            //     return response()->json(['error' => 'Qty2 tidak boleh lebih besar dari Qty1'], 400);
            // }

            // // Update data
            // $spphDetail->qty_spph -= $item['qty2'];
            // $spphDetail->qty2 = $item['qty2'];
            // $spphDetail->save();
            $detailSpph = DetailSpphrfq::create([
                'spphrfq_id' => $item['spphrfq_id'],
                'id_detail_pr' => $item['id'],
                'spphrfq_qty' => $item['qty2'],
                'id_del_spphrfq' => 0,
            ]);
        }

        return response()->json(['success' => true]);
    }

    //End Simpan Detail SPPH



    public function nopr()
    {
        $data = PurchaseRequest::where('no_pr', 'LIKE', '%' . request('q') . '%')->paginate(10000);
        return response()->json($data);
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
}
