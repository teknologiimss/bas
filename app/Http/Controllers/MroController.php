<?php

namespace App\Http\Controllers;

use App\Exports\BarangMroExport;
use App\Models\Category;
use App\Models\Mro;
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
                    ->orWhere('mro_code', 'like', "%{$request->q}%");
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

    public function categories()
    {
        return Category::select('category_id', 'category_name')->get();
    }

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
}
