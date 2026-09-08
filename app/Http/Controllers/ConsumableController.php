<?php

namespace App\Http\Controllers;

use App\Models\ConsumableFolder;
use App\Models\ConsumableItem;
use Illuminate\Http\Request;

class ConsumableController extends Controller
{
    // Halaman List Folder
    public function index()
    {
        $folders = ConsumableFolder::latest()->get();
        return view('consumable.index', compact('folders'));
    }

    // Simpan Folder Baru
    public function storeFolder(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|numeric',
        ]);

        ConsumableFolder::create($request->only('title', 'year'));

        return redirect()->back()->with('success', 'Folder Perencanaan Berhasil Dibuat.');
    }

    // Update Folder
    public function updateFolder(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|numeric',
        ]);

        $folder = ConsumableFolder::findOrFail($id);
        $folder->update($request->only('title', 'year'));

        return redirect()->back()->with('success', 'Folder Berhasil Diperbarui.');
    }

    // Hapus Folder
    public function destroyFolder($id)
    {
        ConsumableFolder::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Folder Berhasil Dihapus.');
    }

    // Halaman Monitor (Isi Tabel Perencanaan)
    public function monitor($id)
    {
        $folder = ConsumableFolder::with('items')->findOrFail($id);

        // Mengelompokkan item berdasarkan sub_header
        $groupedItems = $folder->items()->get()->groupBy('sub_header');

        return view('consumable.monitor', compact('folder', 'groupedItems'));
    }

    // Simpan Item Komponen Baru
    public function storeItem(Request $request, $folderId)
    {
        $request->validate([
            'sub_header' => 'required|string',
            'komponen' => 'required|string',
            'satuan' => 'required|string',
        ]);

        $data = $request->all();
        $data['consumable_folder_id'] = $folderId;

        ConsumableItem::create($data);

        return redirect()->back()->with('success', 'Item Komponen Berhasil Ditambahkan.');
    }

    // Update Item Komponen
    public function updateItem(Request $request, $id)
    {
        $request->validate([
            'sub_header' => 'required|string',
            'komponen' => 'required|string',
            'satuan' => 'required|string',
        ]);

        $item = ConsumableItem::findOrFail($id);
        $item->update($request->all());

        return redirect()->back()->with('success', 'Item Komponen Berhasil Diperbarui.');
    }

    // Hapus Item Komponen
    public function destroyItem($id)
    {
        ConsumableItem::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Item Berhasil Dihapus.');
    }

    // Cetak Dokumen / Print
    public function print($id)
    {
        $folder = ConsumableFolder::with('items')->findOrFail($id);
        $groupedItems = $folder->items()->get()->groupBy('sub_header');

        return view('consumable.print', compact('folder', 'groupedItems'));
    }
}
