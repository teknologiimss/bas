<?php

namespace App\Http\Controllers;

use App\Models\Rewinding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class RewindingController extends Controller
{
    public function index()
    {
        $data = Rewinding::latest()->paginate(10);

        return view('rewinding.index', compact('data'));
    }

    public function create()
    {
        return view('rewinding.create');
    }

    public function store(Request $request)
    {
        $lampiran = null;
        $namaLampiran = null;

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');

            $namaLampiran = $file->getClientOriginalName();

            $namaFile =
                time() . '_'
                . str_replace(' ', '_', $namaLampiran);

            $file->move(
                public_path('lampiran'),
                $namaFile
            );

            $lampiran = 'lampiran/' . $namaFile;
        }

        Rewinding::create([
            'no_sjn' => $request->no_sjn,
            'tanggal_sjn' => $request->tanggal_sjn,
            'tanggal_masuk_sjn' => $request->tanggal_masuk_sjn,
            'status' => $lampiran ? 'Closed' : 'Open',
            'deskripsi' => $request->deskripsi,
            'qty' => $request->qty,
            'satuan' => $request->satuan,
            'keterangan' => $request->keterangan,
            'lampiran' => $lampiran,
            'nama_lampiran' => $namaLampiran,
            'no_sppjp' => $request->no_sppjp,
        ]);

        return redirect()
            ->route('rewinding.index')
            ->with('success', 'Data berhasil disimpan');
    }

    public function edit(Rewinding $rewinding)
    {
        return view('rewinding.edit', compact('rewinding'));
    }

    public function update(Request $request, Rewinding $rewinding)
    {
        $lampiran = $rewinding->lampiran;
        $namaLampiran = $rewinding->nama_lampiran;

        if ($request->hasFile('lampiran')) {
            if (
                $rewinding->lampiran &&
                File::exists(public_path($rewinding->lampiran))
            ) {
                File::delete(
                    public_path($rewinding->lampiran)
                );
            }

            $file = $request->file('lampiran');

            $namaLampiran = $file->getClientOriginalName();

            $namaFile =
                time() . '_'
                . str_replace(' ', '_', $namaLampiran);

            $file->move(
                public_path('lampiran'),
                $namaFile
            );

            $lampiran = 'lampiran/' . $namaFile;
        }

        $rewinding->update([
            'no_sjn' => $request->no_sjn,
            'tanggal_sjn' => $request->tanggal_sjn,
            'tanggal_masuk_sjn' => $request->tanggal_masuk_sjn,
            'status' => $lampiran ? 'Closed' : 'Open',
            'deskripsi' => $request->deskripsi,
            'qty' => $request->qty,
            'satuan' => $request->satuan,
            'keterangan' => $request->keterangan,
            'lampiran' => $lampiran,
            'nama_lampiran' => $namaLampiran,
            'no_sppjp' => $request->no_sppjp,
        ]);

        return redirect()
            ->route('rewinding.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(Rewinding $rewinding)
    {
        if (
            $rewinding->lampiran &&
            File::exists(public_path($rewinding->lampiran))
        ) {
            File::delete(
                public_path($rewinding->lampiran)
            );
        }

        $rewinding->delete();

        return redirect()
            ->route('rewinding.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function show(Rewinding $rewinding)
    {
        return redirect()->route('rewinding.index');
    }

    public function hapusLampiran(Rewinding $rewinding)
    {
        // Hapus file fisik
        if ($rewinding->lampiran) {
            $file = public_path($rewinding->lampiran);

            if (file_exists($file)) {
                unlink($file);
            }
        }

        // Update langsung ke database
        Rewinding::where('id', $rewinding->id)->update([
            'lampiran' => null,
            'nama_lampiran' => null,
            'status' => 'Open',
        ]);

        return redirect()
            ->route('rewinding.edit', $rewinding->id)
            ->with('success', 'Lampiran berhasil dihapus');
    }
}
