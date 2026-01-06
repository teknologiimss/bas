<?php

namespace App\Http\Controllers;

use App\Exports\BarangMroExport;
use App\Models\Category;
use App\Models\Monitoring;
use App\Models\Mro;
use App\Models\MroStockLog;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MroController extends Controller
{
    public function index(Request $request)
    {
        $query = Mro::select('*');

        if ($request->q) {
            $query->where(function ($q) use ($request) {
                $q
                    ->where('mro_name', 'like', "%{$request->q}%")
                    ->orWhere('mro_code', 'like', "%{$request->q}%")
                    ->orWhere('proyek', 'like', "%{$request->q}%");
            });
        }

        // Sorting jika ada request
        if ($request->sort) {
            switch ($request->sort) {
                case 'name_az':
                    $query->orderBy('mro_name', 'asc');
                    break;
                case 'name_za':
                    $query->orderBy('mro_name', 'desc');
                    break;
                case 'proyek_az':
                    $query->orderBy('proyek', 'asc');
                    break;
                case 'proyek_za':
                    $query->orderBy('proyek', 'desc');
                    break;
            }
        } else {
            // ✔ Tambahkan default sorting
            $query->orderBy('mro_id', 'desc');
        }

        $mro = $query->paginate(20);

        return view('mro.index', compact('mro'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'mro_code' => 'required',
            'mro_name' => 'required',
            'stock' => 'required|numeric',
        ]);

        Mro::updateOrCreate(
            ['mro_id' => $request->mro_id],
            [
                'mro_code' => $request->mro_code,
                'mro_name' => $request->mro_name,
                'spesifikasi' => $request->spesifikasi,
                'stock' => $request->stock,
                'satuan' => $request->satuan,
                'proyek' => $request->proyek,
                // QR CODE menggunakan isi ini
                'barcode' => $request->mro_code
            ]
        );

        return back()->with('success', 'Data MRO berhasil disimpan.');
    }

    public function delete(Request $request)
    {
        Mro::where('mro_id', $request->id)->delete();
        return back()->with('success', 'Data MRO berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new BarangMroExport, 'stok barang mro.xlsx');
    }

    // Print QR Code
    public function printBarcode($id)
    {
        $mro = Mro::findOrFail($id);
        return view('mro.qrcode', compact('mro'));  // GANTI view barcode → qrcode
    }

    public function printBarcodePage(Request $request)
    {
        $mro = Mro::orderBy('mro_name', 'asc')->get();
        return view('mro.print_qrcode', compact('mro'));  // GANTI
    }

    public function stockIn(Request $r)
    {
        $item = Mro::where('barcode', $r->barcode)->first();

        if (!$item)
            return back()->with('error', 'QR Code tidak ditemukan!');

        $before = $item->stock;

        $item->stock += $r->jumlah;
        $item->save();

        MroStockLog::create([
            'mro_id' => $item->mro_id,
            'barcode' => $item->barcode,  // isi QR code
            'type' => 'IN',
            'qty' => $r->jumlah,
            'stock_before' => $before,
            'stock_after' => $item->stock,
            'proyek' => $item->proyek,
            'user' => auth()->user()->name,
        ]);

        return back()->with('success', 'Stok berhasil ditambah!');
    }

    public function stockOut(Request $r)
    {
        $item = Mro::where('barcode', $r->barcode)->first();

        if (!$item)
            return back()->with('error', 'QR Code tidak ditemukan!');

        if ($item->stock < $r->jumlah)
            return back()->with('error', 'Stok tidak mencukupi!');

        $before = $item->stock;

        $item->stock -= $r->jumlah;
        $item->save();

        MroStockLog::create([
            'mro_id' => $item->mro_id,
            'barcode' => $item->barcode,
            'type' => 'OUT',
            'qty' => $r->jumlah,
            'stock_before' => $before,
            'stock_after' => $item->stock,
            'proyek' => $item->proyek,
            'user' => auth()->user()->name,
        ]);

        return back()->with('success', 'Stok berhasil dikurangi!');
    }

    public function stockLog(Request $request)
    {
        $query = MroStockLog::with('mro');

        if ($request->kode)
            $query->where('barcode', 'LIKE', "%{$request->kode}%");

        if ($request->nama) {
            $query->whereHas('mro', function ($q) use ($request) {
                $q->where('mro_name', 'LIKE', "%{$request->nama}%");
            });
        }

        if ($request->proyek) {
            $query->whereHas('mro', function ($q) use ($request) {
                $q->where('proyek', 'LIKE', "%{$request->proyek}%");
            });
        }

        $logs = $query->orderBy('created_at', 'DESC')->paginate(20);
        return view('mro.stock_log', compact('logs'));
    }

    public function deleteMultipleLog(Request $request)
    {
        $ids = $request->ids;

        if (!$ids) {
            return back()->with('error', 'Tidak ada data yang dipilih!');
        }

        MroStockLog::whereIn('id', $ids)->delete();

        return back()->with('success', 'Data log terpilih berhasil dihapus!');
    }

    public function multiDelete(Request $request)
    {
        $ids = json_decode($request->ids);

        if (!$ids || count($ids) == 0) {
            return back()->with('error', 'Tidak ada data yang dipilih!');
        }

        Mro::whereIn('mro_id', $ids)->delete();

        return back()->with('success', 'Berhasil menghapus ' . count($ids) . ' data Stok Barang MRO.');
    }

    // public function scanStockIn($barcode)
    // {
    //     $item = Mro::where('barcode', $barcode)->firstOrFail();
    //     return view('mro.scan_stockin', compact('item'));
    // }

    public function scanStockIn(Request $request)
    {
        $item = Mro::where('barcode', $request->barcode)->firstOrFail();

        $item->stock += $request->jumlah;
        $item->save();

        return redirect()
            ->back()
            ->with('success', 'Stok barang berhasil ditambahkan');
    }

    // public function scanStockOut($barcode)
    // {
    //     $item = Mro::where('barcode', $barcode)->firstOrFail();
    //     return view('mro.scan_stockout', compact('item'));
    // }

    public function scanStockOut(Request $request)
    {
        $item = Mro::where('barcode', $request->barcode)->firstOrFail();

        $item->stock -= $request->jumlah;
        $item->save();

        return redirect()
            ->back()
            ->with('warning', 'Stok barang berhasil dikurangi');
    }

    public function scan($barcode)
    {
        $item = Mro::where('barcode', $barcode)->firstOrFail();
        return view('mro.scan', compact('item'));
    }

    // public function progress()
    // {
    //     $monitorings = Monitoring::orderBy('tanggal_kontrak', 'desc')->get();

    //     return view('mro.resume_progress', compact('monitorings'));
    // }

    public function progress()
    {
        $monitorings = Monitoring::orderBy('tanggal_kontrak', 'desc')
            ->paginate(10);

        return view('mro.resume_progress', compact('monitorings'));
    }
}
