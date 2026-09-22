<?php

namespace App\Http\Controllers;

use App\Models\MroTool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MroToolController extends Controller
{
    public function index(Request $request)
    {
        $query = MroTool::query();

        // 1. Fitur Search (Berdasarkan Nama Tools, Jenis, Spesifikasi, atau Lokasi)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q
                    ->where('nama_tools', 'like', "%{$search}%")
                    ->orWhere('jenis', 'like', "%{$search}%")
                    ->orWhere('spesifikasi', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        // 2. Fitur Filter khusus Jenis (jika dipilih)
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->input('jenis'));
        }

        // 3. Fitur Sorting / Pengurutan Data
        if ($request->filled('sort')) {
            switch ($request->input('sort')) {
                case 'nama_asc':
                    $query->orderBy('nama_tools', 'asc');
                    break;
                case 'nama_desc':
                    $query->orderBy('nama_tools', 'desc');
                    break;
                case 'qty_asc':
                    $query->orderBy('qty', 'asc');
                    break;
                case 'qty_desc':
                    $query->orderBy('qty', 'desc');
                    break;
                default:
                    $query->orderBy('position', 'asc')->orderBy('id', 'asc');
                    break;
            }
        } else {
            // Default diurutkan berdasarkan kolom position
            $query->orderBy('position', 'asc')->orderBy('id', 'asc');
        }

        // Ambil data beserta pagination
        $tools = $query->paginate(15)->withQueryString();

        // Ambil daftar opsi jenis secara dinamis untuk dropdown filter
        $listJenis = MroTool::whereNotNull('jenis')
            ->where('jenis', '!=', '')
            ->distinct()
            ->pluck('jenis');

        return view('mro.tools.index', compact('tools', 'listJenis'));
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|exists:mro_tools,id',
            'order.*.position' => 'required|integer',
        ]);

        foreach ($request->order as $item) {
            MroTool::where('id', $item['id'])->update(['position' => $item['position']]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Urutan item berhasil diperbarui!'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tools' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string',
            'qty' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'kondisi' => 'required|in:Baik,Rusak,Scrap',
            'lokasi' => 'nullable|string|max:255',  // <= Validasi Lokasi
            'keterangan' => 'nullable|string',
            'jenis' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->all();

        // Set urutan paling akhir untuk data baru
        $maxPosition = MroTool::max('position') ?? 0;
        $data['position'] = $maxPosition + 1;

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('mro_tools', 'public');
        }

        MroTool::create($data);

        return redirect()->route('mro.tools.index')->with('success', 'Data Tools MRO berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $tool = MroTool::findOrFail($id);

        $request->validate([
            'nama_tools' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string',
            'qty' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'kondisi' => 'required|in:Baik,Rusak,Scrap',
            'lokasi' => 'nullable|string|max:255',  // <= Validasi Lokasi
            'keterangan' => 'nullable|string',
            'jenis' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            if ($tool->gambar && Storage::disk('public')->exists($tool->gambar)) {
                Storage::disk('public')->delete($tool->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('mro_tools', 'public');
        }

        $tool->update($data);

        return redirect()->route('mro.tools.index')->with('success', 'Data Tools MRO berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $tool = MroTool::findOrFail($id);

        if ($tool->gambar && Storage::disk('public')->exists($tool->gambar)) {
            Storage::disk('public')->delete($tool->gambar);
        }

        $tool->delete();

        return redirect()->route('mro.tools.index')->with('success', 'Data Tools MRO berhasil dihapus!');
    }
}
