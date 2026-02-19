<?php

namespace App\Http\Controllers;

use App\Models\DetailSppd;
use App\Models\DetailSpph;
use App\Models\Purchase_Order;
use App\Models\Sppd;
use App\Models\SppdLampiran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SppdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->q;
        $user = Auth::user();

        $warehouse_id = Session::get('selected_warehouse_id')
            ?? DB::table('warehouse')->first()->warehouse_id;

        // 🔹 QUERY UTAMA
        $requests = Sppd::select(
            'sppd.*',
        );

        // 🔐 FILTER BERDASARKAN ROLE
        // if ($user->role == 2) {
        //     // WILAYAH 1
        //     $requests->whereRaw('LOWER(purchase_request.no_pr) LIKE ?', ['%wil1%']);
        // } elseif ($user->role == 3) {
        //     // WILAYAH 2
        //     $requests->whereRaw('LOWER(purchase_request.no_pr) LIKE ?', ['%wil2%']);
        // } elseif ($user->role == 14) {
        //     // MRO
        //     $requests->whereRaw('LOWER(purchase_request.no_pr) LIKE ?', ['%mro%']);
        // } elseif ($user->role == 0) {
        //     // ADMIN → tampil semua
        // } else {
        //     // Role tidak dikenal
        //     $requests->whereRaw('0=1');
        // }

        // 🔍 SEARCH (OPSIONAL)
        if ($search) {
            $requests->where('sppd.kode_proyek', 'LIKE', "%$search%");
        }

        // 🔃 PAGINATION
        $requests = $requests
            ->orderBy('sppd.id', 'desc')
            ->paginate(10);

        $proyeks = DB::table('kontrak')->get();

        // 📎 LAMPIRAN
        foreach ($requests as $item) {
            $lampiran = SppdLampiran::where('sppd_id', $item->id)
                ->pluck('file')
                ->toArray();
            $item->lampiran = implode(', ', $lampiran);
        }

        // ✏️ EDITABLE
        foreach ($requests as $request) {
            $detail_sppd = DetailSppd::where('id_sppd', $request->id)->get();

            if ($detail_sppd->isEmpty()) {
                $request->editable = true;
            } else {
                foreach ($detail_sppd as $detail) {
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

        return view('sppd.sppd', compact('requests', 'proyeks'));
    }

    function FunctionCountPages($path)
    {
        $pdftextfile = file_get_contents($path);
        $pagenumber = preg_match_all('/\/Page\W/', $pdftextfile, $dummy);
        return $pagenumber;
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
        $sppd_id = $request->id;

        // === VALIDASI ===
        $request->validate([
            'kode_proyek' => 'nullable|string',
            'tujuan' => 'required',
            'keperluan' => 'required',
            'lama_perjalanan' => 'required',
            'status' => 'required|in:open,closed',
            'keterangan_status' => 'nullable'
        ]);

        if (empty($sppd_id)) {
            // === INSERT BARU ===
            $sppd = Sppd::create([
                'kode_proyek' => $request->kode_proyek,
                'tujuan' => $request->tujuan,
                'keperluan' => $request->keperluan,
                'lama_perjalanan' => $request->lama_perjalanan,
                'terhitung_mulai' => $request->terhitung_mulai,
                'terhitung_selesai' => $request->terhitung_selesai,
                'status' => $request->status,
                'keterangan_status' => $request->keterangan_status,
                // 'id_user' => auth()->user()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 🔹 Upload lampiran (jika ada)
            if ($request->hasFile('lampiran')) {
                foreach ($request->file('lampiran') as $file) {
                    $file_name = rand() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('lampiran'), $file_name);

                    SppdLampiran::create([
                        'sppd_id' => $sppd->id,
                        'file' => $file_name,
                        'tipe' => $this->FunctionCountPages(public_path('lampiran/' . $file_name)),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            return redirect()->route('sppd.index')->with('success', 'SPPD berhasil ditambahkan');
        } else {
            // === UPDATE DATA ===
            $sppd = Sppd::find($sppd_id);
            if (!$sppd) {
                return redirect()->route('sppd.index')->with('error', 'Data tidak ditemukan.');
            }

            $sppd->update([
                'kode_proyek' => $request->kode_proyek,
                'tujuan' => $request->tujuan,
                'keperluan' => $request->keperluan,
                'lama_perjalanan' => $request->lama_perjalanan,
                'terhitung_mulai' => $request->terhitung_mulai,
                'terhitung_selesai' => $request->terhitung_selesai,
                'status' => $request->status,
                'keterangan_status' => $request->keterangan_status,
                // 'id_user' => auth()->user()->id,
                // 'created_at' => now(),
                // 'updated_at' => now(),
            ]);

            // 🔹 Upload lampiran baru (jika ada)
            if ($request->hasFile('lampiran')) {
                foreach ($request->file('lampiran') as $file) {
                    $file_name = rand() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('lampiran'), $file_name);

                    SppdLampiran::create([
                        'sppd_id' => $sppd->id,
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
                    SppdLampiran::where('sppd_id', $sppd_id)
                        ->where('file', $existing_file)
                        ->delete();
                }
            }

            return redirect()->route('sppd.index')->with('success', 'SPPD berhasil diperbarui');
        }
    }

    public function destroy(Request $request)
    {
        //
        $delete_sppd = $request->id;
        $delete_sppd = DB::table('sppd')->where('id', $delete_sppd)->delete();
        $delete_detail_pr = DetailSppd::where('id_sppd', $request->id)->delete();
        // 🔹 Tambahan: hapus data di tabel pr_lampiran
        $delete_lampiran = DB::table('sppd_lampiran')->where('sppd_id', $request->id)->delete();
        // $delete_detail_po = DetailPo::where('id_pr', $request->id)->delete();
        // $delete_detail_spph = Spph::leftjoin('detail_spph', 'detail_spph.spph_id', '=', 'spph.id')->where('detail_spph.id_detail_pr', $request->id)->delete();

        // if ($delete_pr && $delete_detail_pr && $delete_detail_po && $delete_detail_spph) {
        if ($delete_sppd) {
            return redirect()->route('sppd.index')->with('success', 'Data SPPD berhasil dihapus');
        } else {
            return redirect()->route('sppd.index')->with('error', 'Data SPPD gagal dihapus');
        }

        return redirect()->route('sppd.index');
    }

    public function updateDetailSppd(Request $request)
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
        $maxIdDel = DetailSppd::max('id_del');  // Mengambil nilai maksimum id_del yang ada
        $idDel = $maxIdDel + 1;  // Menambahkan 1 pada nilai maksimum untuk mendapatkan id_del yang baru
        $insert = DetailSppd::create([
            'id_sppd' => $request->id_sppd,
            'nama' => $request->nama ?: '-',
            'nip' => $request->nip ?: '-',
            'golongan' => $request->golongan ?: '-',
            'unit_kerja' => $request->unit_kerja ?: '-',
            // 'qty' => $request->stock ?: 0,
            'hari' => $request->hari ?: '-',
            'tarif' => $request->tarif ?: '-',
            'jumlah' => $request->jumlah ?: '-',
            'jenis_kendaraan' => $request->jenis_kendaraan ?: '-',
            'tanggal' => $request->tanggal ?: '-',
            'lampiran' => $fileName ?: null,
            'id_del' => $idDel,
        ]);

        if (!$insert) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan detail PR'
            ]);
        }

        $sppd = DB::table('sppd')->where('id', $request->id_sppd)->first();
        $sppd->details = DetailSppd::where('id_sppd', $request->id_sppd)->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan detail SPPD',
            'sppd' => $sppd
        ]);
    }

    public function getDetailSppd(Request $request)
    {
        $id = $request->id;
        $sppd = Sppd::select('sppd.*')
            ->where('sppd.id', $id)
            ->first();
        $sppd->details = DetailSppd::where('id_sppd', $id)->get();
        // $pr->details = DetailPR::where('id_pr', $id)->leftJoin('kode_material', 'kode_material.id', '=', 'detail_pr.kode_material_id')->get();
        $sppd->details = $sppd->details->map(function ($item) use ($id, $request) {
            $item->nama = $item->nama ? $item->nama : '';
            $item->nip = $item->nip ? $item->nip : '';
            $item->golongan = $item->golongan ? $item->golongan : '';
            $item->unit_kerja = $item->unit_kerja ? $item->unit_kerja : '';
            $item->hari = $item->hari ? $item->hari : '';
            $item->tarif = $item->tarif ? $item->tarif : '';
            $item->jumlah = $item->jumlah ? $item->jumlah : '';
            $item->jenis_kendaraan = $item->jenis_kendaraan ? $item->jenis_kendaraan : '';
            $item->tanggal = $item->tanggal ? $item->tanggal : '';
            $item->tujuan = $item->tujuan ? $item->tujuan : '';

            $item->userRole = User::where('id', $item->user_id)->first()->role ?? '';

            return $item;
        });

        return response()->json([
            'sppd' => $sppd
        ]);
    }

    public function editDetailSppd(Request $request)
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
            'id_sppd' => 'required',  // Pastikan id_sr wajib ada
            // 'id' => 'required',
            'nama' => 'nullable',
            'nip' => 'nullable',
            'golongan' => 'nullable',
            'unit_kerja' => 'nullable',
            'hari' => 'nullable',
            'tarif' => 'nullable',
            'jumlah' => 'nullable',
            'jenis_kendaraan' => 'nullable',
            'tanggal' => 'nullable',
            'lampiran' => 'nullable',
        ]);

        $id = $request->id;

        // Cek apakah id_sr yang diberikan valid

        // dd($detailSR);
        if (!$id) {
            // Alihkan ke fungsi createDetailSr jika detail SR tidak ditemukan
            return $this->updateDetailSppd($request);
            // dd($request->all());
        }
        $detailSPPD = DetailSppd::where('id', $id)->first();
        // Update data detail SR
        $detailSPPD->update([
            'id_sppd' => $request->id_sppd ?? '',
            'nama' => $request->nama ?? '',
            'nip' => $request->nip ?? '',
            'golongan' => $request->golongan ?? '',
            'unit_kerja' => $request->unit_kerja ?? '',
            'hari' => $request->hari ?? '',
            'tarif' => $request->tarif ?? '',
            'jumlah' => $request->jumlah ?? '',
            'jenis_kendaraan' => $request->jenis_kendaraan ?? '',
            'tanggal' => $request->tanggal ?? '',
            'lampiran' => $fileName ?? '',
        ]);

        $sppd = DB::table('sppd')->where('id', $request->id_sppd)->first();
        // TODO: tambah func disini
        $sppd->details = DetailSppd::where('id_sppd', $request->id_sppd)->get();
        $sppd->details = $sppd->details->map(function ($item) use ($request) {
            $item = $this->getQtyStatus($request->id_sppd, $item);

            return $item;
        });
        return response()->json([
            'success' => true,
            'message' => 'Data detail SR berhasil diupdate.',
            'sppd' => $sppd  // Mengembalikan data detail SR yang telah diupdate
        ]);
    }

    public function hapusDetailSppd(Request $request, $id)
    {
        // Mendapatkan nilai id_pr sebelum menghapus data
        $id_sppd = DetailSppd::where('id', $id)->value('id_sppd');

        // Menghapus data purchase request dan detailnya
        $delete_detail_sppd = DetailSppd::where('id', $id)->delete();

        // Periksa apakah permintaan utama berhasil dihapus dan kembalikan respons yang sesuai
        if ($delete_detail_sppd) {
            return response()->json(['success' => 'Data SPPD berhasil dihapus', 'deletedId' => $id, 'id_sppd' => $id_sppd]);
        } else {
            return response()->json(['error' => 'Data SPPD gagal dihapus'], 500);
        }
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
}
