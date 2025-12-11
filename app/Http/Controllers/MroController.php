<?php

namespace App\Http\Controllers;

use App\Exports\BarangMroExport;
use App\Models\Category;
use App\Models\Mro;
use App\Models\MroStockLog;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MroController extends Controller
{
    public function index(Request $request)
    {
        $query = Mro::leftJoin('categories', 'categories.category_id', 'mro.category_id')
            ->select('mro.*', 'categories.category_name');

        if ($request->q) {
            $query->where(function ($q) use ($request) {
                $q
                    ->where('mro_name', 'like', "%{$request->q}%")
                    ->orWhere('mro_code', 'like', "%{$request->q}%")
                    ->orWhere('proyek', 'like', "%{$request->q}%");
            });
        }

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
                // 'category_id' => $request->category,
                'barcode' => $request->mro_code  // barcode mengikuti modul Products
            ]
        );

        return back()->with('success', 'Data MRO berhasil disimpan.');
    }

    public function delete(Request $request)
    {
        Mro::where('mro_id', $request->id)->delete();
        return back()->with('success', 'Data MRO berhasil dihapus.');
    }

    // public function categories()
    // {
    //     return Category::select('category_id', 'category_name')->get();
    // }

    public function export()
    {
        return Excel::download(new BarangMroExport, 'stok barang mro.xlsx');
    }

    // Print Barcode seperti di modul Products
    public function printBarcode($id)
    {
        $mro = Mro::findOrFail($id);
        return view('mro.barcode', compact('mro'));
    }

    public function printBarcodePage(Request $request)
    {
        $mro = Mro::orderBy('mro_name', 'asc')->get();
        return view('mro.print_barcode', compact('mro'));
    }

    // public function stockIn(Request $r)
    // {
    //     $item = Mro::where('barcode', $r->barcode)->first();

    //     if (!$item) {
    //         return back()->with('error', 'Barcode tidak ditemukan!');
    //     }

    //     $item->stock += $r->jumlah;
    //     $item->save();

    //     return back()->with('success', 'Stok berhasil ditambah!');
    // }

    public function stockIn(Request $r)
    {
        $item = Mro::where('barcode', $r->barcode)->first();
        if (!$item)
            return back()->with('error', 'Barcode tidak ditemukan!');

        $before = $item->stock;
        $item->stock += $r->jumlah;
        $item->save();

        MroStockLog::create([
            'mro_id' => $item->mro_id,
            'barcode' => $item->barcode,
            'type' => 'IN',
            'qty' => $r->jumlah,
            'stock_before' => $before,
            'stock_after' => $item->stock,
            'proyek' => $item->proyek,
            'user' => auth()->user()->name,
        ]);

        return back()->with('success', 'Stok berhasil ditambah!');
    }

    // public function stockOut(Request $r)
    // {
    //     $item = Mro::where('barcode', $r->barcode)->first();

    //     if (!$item) {
    //         return back()->with('error', 'Barcode tidak ditemukan!');
    //     }

    //     if ($item->stock < $r->jumlah) {
    //         return back()->with('error', 'Stok tidak mencukupi!');
    //     }

    //     $item->stock -= $r->jumlah;
    //     $item->save();

    //     return back()->with('success', 'Stok berhasil dikurangi!');
    // }

    public function stockOut(Request $r)
    {
        $item = Mro::where('barcode', $r->barcode)->first();
        if (!$item)
            return back()->with('error', 'Barcode tidak ditemukan!');

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

    // Filter MRO STOCK LOG
    public function stockLog(Request $request)
    {
        $query = MroStockLog::with('mro');

        // Filter kode material (barcode)
        if ($request->kode) {
            $query->where('barcode', 'LIKE', "%{$request->kode}%");
        }

        // Filter nama barang
        if ($request->nama) {
            $query->whereHas('mro', function ($q) use ($request) {
                $q->where('mro_name', 'LIKE', "%{$request->nama}%");
            });
        }

        // Filter proyek
        if ($request->proyek) {
            $query->whereHas('mro', function ($q) use ($request) {
                $q->where('proyek', 'LIKE', "%{$request->proyek}%");
            });
        }

        $logs = $query->orderBy('created_at', 'DESC')->paginate(20);

        return view('mro.stock_log', compact('logs'));
    }

    
    // Hapus Multiple
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
}
