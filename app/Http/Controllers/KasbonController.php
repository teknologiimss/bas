<?php

namespace App\Http\Controllers;

use App\Models\KasbonFolder;
use App\Models\KasbonItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KasbonController extends Controller
{
    // 1. Menampilkan Daftar Folder Proyek Kasbon
    public function index(Request $request)
    {
        $search = $request->input('search');

        $folders = KasbonFolder::when($search, function ($query, $search) {
            return $query
                ->where('judul', 'like', "%{$search}%")
                ->orWhere('po_nota_dinas', 'like', "%{$search}%");
        })->latest()->get();

        return view('kasbon.index', compact('folders', 'search'));
    }

    // 2. Simpan Folder Proyek Kasbon Baru
    public function storeFolder(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'po_nota_dinas' => 'required|string|max:255',
        ]);

        KasbonFolder::create($request->all());

        return redirect()->route('kasbon.index')->with('success', 'Kasbon Proyek berhasil dibuat.');
    }

    // 3. Update Folder
    public function updateFolder(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'po_nota_dinas' => 'required|string|max:255',
        ]);

        $folder = KasbonFolder::findOrFail($id);
        $folder->update($request->all());

        return redirect()->route('kasbon.index')->with('success', 'Kasbon Proyek berhasil diperbarui.');
    }

    // 4. Hapus Folder
    public function destroyFolder($id)
    {
        $folder = KasbonFolder::findOrFail($id);

        // Hapus file fisik dari public/img
        foreach ($folder->items as $item) {
            if ($item->dokumen && is_array($item->dokumen)) {
                foreach ($item->dokumen as $file) {
                    $filePath = public_path('img/' . $file);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }
        }

        $folder->delete();

        return redirect()->route('kasbon.index')->with('success', 'Kasbon Proyek berhasil dihapus.');
    }

    // 5. Menampilkan Detail Isi Folder Transaksi Kasbon
    public function show($id)
    {
        /** @var \App\Models\KasbonFolder $folder */
        $folder = KasbonFolder::findOrFail($id);
        
        // Memuat item yang sudah diurutkan berdasarkan kolom position
        $folder->load(['items' => function ($query) {
            $query->orderBy('position', 'asc');
        }]);

        $totalMasuk = $folder->items->sum('uang_masuk');
        $totalKeluar = $folder->items->sum('uang_keluar');
        $selisih = $totalMasuk - $totalKeluar;

        $persen = $totalMasuk > 0 ? ($selisih / $totalMasuk) * 100 : 0;

        return view('kasbon.show', compact('folder', 'totalMasuk', 'totalKeluar', 'selisih', 'persen'));
    }

    // 6. Simpan Item Transaksi Baru (Upload ke public/img)
    public function storeItem(Request $request, $folderId)
    {
        $request->validate([
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'uang_masuk' => 'nullable|numeric|min:0',
            'uang_keluar' => 'nullable|numeric|min:0',
            'dokumen.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,zip|max:5000',
            'keterangan' => 'nullable|string',
        ]);

        $dokumenNames = [];
        if ($request->hasFile('dokumen')) {
            foreach ($request->file('dokumen') as $file) {
                // Buat nama unik agar tidak saling menimpa
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                // Pindahkan file secara fisik ke public/img
                $file->move(public_path('img'), $fileName);
                $dokumenNames[] = $fileName;
            }
        }

        // Ambil nilai position tertinggi agar item baru ditaruh di urutan paling bawah
        $maxPosition = KasbonItem::where('kasbon_folder_id', $folderId)->max('position') ?? 0;

        KasbonItem::create([
            'kasbon_folder_id' => $folderId,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'uang_masuk' => $request->uang_masuk ?? 0,
            'uang_keluar' => $request->uang_keluar ?? 0,
            'dokumen' => $dokumenNames,  // Menyimpan array nama file
            'keterangan' => $request->keterangan,
            'position' => $maxPosition + 1,
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan!');
    }

    // Edit / Update Item Transaksi
    public function updateItem(Request $request, $id)
    {
        $item = KasbonItem::findOrFail($id);

        $request->validate([
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'uang_masuk' => 'nullable|numeric|min:0',
            'uang_keluar' => 'nullable|numeric|min:0',
            'dokumen.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,zip|max:5000',
            'keterangan' => 'nullable|string',
        ]);

        $dokumenNames = $item->dokumen ?? [];

        // Jika user mengupload file baru, tambahkan ke folder public/img
        if ($request->hasFile('dokumen')) {
            foreach ($request->file('dokumen') as $file) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img'), $fileName);
                $dokumenNames[] = $fileName;
            }
        }

        $item->update([
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'uang_masuk' => $request->uang_masuk ?? 0,
            'uang_keluar' => $request->uang_keluar ?? 0,
            'dokumen' => $dokumenNames,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil diperbarui!');
    }

    // 7. Hapus Item Transaksi
    public function destroyItem($id)
    {
        $item = KasbonItem::findOrFail($id);
        $folderId = $item->kasbon_folder_id;

        // Hapus file fisik dari public/img
        if ($item->dokumen && is_array($item->dokumen)) {
            foreach ($item->dokumen as $file) {
                $filePath = public_path('img/' . $file);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        $item->delete();

        return redirect()->route('kasbon.show', $folderId)->with('success', 'Transaksi Kasbon berhasil dihapus.');
    }

    public function destroyDocument(Request $request, $itemId)
    {
        $item = KasbonItem::findOrFail($itemId);

        $fileToDelete = $request->input('file_name');
        $dokumenList = $item->dokumen ?? [];

        // Cek apakah file ada di array dokumen item
        if (($key = array_search($fileToDelete, $dokumenList)) !== false) {
            // 1. Hapus file fisik dari public/img
            $filePath = public_path('img/' . $fileToDelete);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // 2. Hapus dari array
            unset($dokumenList[$key]);

            // 3. Re-index array & simpan kembali
            $item->update([
                'dokumen' => array_values($dokumenList)
            ]);

            return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Dokumen tidak ditemukan.');
    }

    // 8. Reorder Item (AJAX Drag and Drop)
    public function reorderItems(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|exists:kasbon_items,id',
            'order.*.position' => 'required|integer',
        ]);

        foreach ($request->order as $itemData) {
            KasbonItem::where('id', $itemData['id'])->update([
                'position' => $itemData['position']
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan transaksi berhasil diperbarui.'
        ]);
    }

    public function printPdf($id)
    {
        /** @var \App\Models\KasbonFolder $folder */
        $folder = KasbonFolder::findOrFail($id);
        
        // Memuat item yang sudah diurutkan berdasarkan kolom position untuk PDF
        $folder->load(['items' => function ($query) {
            $query->orderBy('position', 'asc');
        }]);

        $totalMasuk = $folder->items->sum('uang_masuk');
        $totalKeluar = $folder->items->sum('uang_keluar');
        $selisih = $totalMasuk - $totalKeluar;
        $persen = $totalMasuk > 0 ? ($selisih / $totalMasuk) * 100 : 0;

        $pdf = Pdf::loadView('kasbon.print', compact('folder', 'totalMasuk', 'totalKeluar', 'selisih', 'persen'))
            ->setPaper('a4', 'portrait')
            ->setOption([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
            ]);

        return $pdf->stream('Laporan_Kasbon_' . \Illuminate\Support\Str::slug($folder->judul) . '.pdf');
    }
}