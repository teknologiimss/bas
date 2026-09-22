<?php

namespace App\Http\Controllers;

use App\Models\MroTool;
use App\Models\ToolMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToolMutationController extends Controller
{
    public function index(Request $request)
    {
        $query = ToolMutation::with('tool');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query
                ->where('nama_peminjam', 'like', "%{$search}%")
                ->orWhereHas('tool', function ($q) use ($search) {
                    $q
                        ->where('nama_tools', 'like', "%{$search}%")
                        ->orWhere('spesifikasi', 'like', "%{$search}%");
                });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $mutations = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();
        $tools = MroTool::where('qty', '>', 0)->get();

        return view('mro.mutations.index', compact('mutations', 'tools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mro_tool_id' => 'required|exists:mro_tools,id',
            'nama_peminjam' => 'required|string|max:255',
            'qty_pinjam' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $tool = MroTool::findOrFail($request->mro_tool_id);

        if ($request->qty_pinjam > $tool->qty) {
            return redirect()->back()->with('error', 'Jumlah pinjam melebihi stok yang tersedia (Sisa stok: ' . $tool->qty . ')');
        }

        DB::transaction(function () use ($request, $tool) {
            // 1. Simpan Transaksi Peminjaman
            ToolMutation::create([
                'mro_tool_id' => $request->mro_tool_id,
                'nama_peminjam' => $request->nama_peminjam,
                'qty_pinjam' => $request->qty_pinjam,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'status' => 'Dipinjam',
                'keterangan' => $request->keterangan,
            ]);

            // 2. Kurangi stok pada MroTool
            $tool->decrement('qty', $request->qty_pinjam);
        });

        return redirect()->route('mro.mutations.index')->with('success', 'Peminjaman berhasil dicatat dan stok tools telah berkurang!');
    }

    public function returnTool(Request $request, $id)
    {
        $request->validate([
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $mutation = ToolMutation::findOrFail($id);

        if ($mutation->status === 'Dikembalikan') {
            return redirect()->back()->with('error', 'Tools ini sudah dikembalikan sebelumnya!');
        }

        DB::transaction(function () use ($request, $mutation) {
            // 1. Update status peminjaman
            $mutation->update([
                'tanggal_kembali' => $request->tanggal_kembali,
                'status' => 'Dikembalikan',
            ]);

            // 2. Kembalikan jumlah stok di MroTool
            $tool = MroTool::findOrFail($mutation->mro_tool_id);
            $tool->increment('qty', $mutation->qty_pinjam);
        });

        return redirect()->route('mro.mutations.index')->with('success', 'Tools telah berhasil dikembalikan dan stok bertambah!');
    }

    public function destroy($id)
    {
        $mutation = ToolMutation::findOrFail($id);

        // Jika data dihapus saat status masih 'Dipinjam', kembalikan stoknya
        if ($mutation->status === 'Dipinjam') {
            $tool = MroTool::find($mutation->mro_tool_id);
            if ($tool) {
                $tool->increment('qty', $mutation->qty_pinjam);
            }
        }

        $mutation->delete();

        return redirect()->route('mro.mutations.index')->with('success', 'Data mutasi berhasil dihapus!');
    }
}
