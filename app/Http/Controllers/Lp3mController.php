<?php

namespace App\Http\Controllers;

use App\Models\Lp3m;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Lp3mController extends Controller
{
    public function index(Request $request)
    {
        $query = Lp3m::query();

        // SEARCH DESKRIPSI
        if ($request->filled('search')) {
            $query->where('deskripsi', 'like', '%' . $request->search . '%');
        }

        // SEARCH NO SPR
        if ($request->filled('spr_no')) {
            $query->where('spr_no', 'like', '%' . $request->spr_no . '%');
        }

        // FILTER TANGGAL
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $data = $query->latest()->paginate(10);
        $data->appends($request->all());

        // --- DATA DASHBOARD ---
        $total = Lp3m::count();
        $open = Lp3m::where('status', 'OPEN')->count();
        $closed = Lp3m::where('status', 'CLOSED')->count();
        $progress = $total > 0 ? round(($closed / $total) * 100, 2) : 0;

        $openData = Lp3m::where('status', 'OPEN')
            ->latest()
            ->get();

        return view('lp3m.index', compact(
            'data',
            'total',
            'open',
            'closed',
            'progress',
            'openData'
        ));
    }

    public function create()
    {
        return view('lp3m.create');
    }

    /*
     * |--------------------------------------------------------------------------
     * | SIMPAN DATA AWAL
     * |--------------------------------------------------------------------------
     */

    public function store(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required',
            'keterangan' => 'required',
        ]);

        $lp3m = Lp3m::create([
            'deskripsi' => $request->deskripsi,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('lp3m.index', $lp3m->id)
            ->with('success', 'Data berhasil dibuat');
    }

    /*
     * |--------------------------------------------------------------------------
     * | FORM LP3M
     * |--------------------------------------------------------------------------
     */

    public function form($id)
    {
        $data = Lp3m::findOrFail($id);

        return view('lp3m.form', compact('data'));
    }

    /*
     * |--------------------------------------------------------------------------
     * | SIMPAN FORM LP3M
     * |--------------------------------------------------------------------------
     */

    public function saveForm(Request $request, $id)
    {
        $data = Lp3m::findOrFail($id);

        $data->update([
            'status' => $request->status,
            'spr_no' => $request->spr_no,
            'hasil_pengukuran' => $request->hasil_pengukuran,
            'penyebab_kerusakan' => $request->penyebab_kerusakan,
            'aus' => $request->has('aus'),
            'retak' => $request->has('retak'),
            'komponen_tak_berfungsi' => $request->has('komponen_tak_berfungsi'),
            'kelebihan_beban' => $request->has('kelebihan_beban'),
            'salah_operasi' => $request->has('salah_operasi'),
            'kelainan' => $request->has('kelainan'),
            'kecelakaan' => $request->has('kecelakaan'),
            'lain_lain_kerusakan' => $request->has('lain_lain_kerusakan'),
            'nama' => json_encode($request->nama),
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'pekerjaan' => $request->pekerjaan,
            'komponen_diganti' => $request->has('komponen_diganti'),
            'diperiksa_disetel' => $request->has('diperiksa_disetel'),
            'diperbaiki_dibuat' => $request->has('diperbaiki_dibuat'),
            'dimodifikasi' => $request->has('dimodifikasi'),
            'dipindah_pasang_baru' => $request->has('dipindah_pasang_baru'),
            'diperlukan_evaluasi' => $request->has('diperlukan_evaluasi'),
            'lain_lain_tindakan' => $request->has('lain_lain_tindakan'),
            'nama_barang' => json_encode(array_values(array_filter($request->nama_barang ?? []))),
            'kode_barang' => json_encode(array_values(array_filter($request->kode_barang ?? []))),
            'jumlah' => json_encode(array_values(array_filter($request->jumlah ?? []))),
            'tanggal_selesai' => $request->tanggal_selesai,
            'jam_selesai_detail' => $request->jam_selesai_detail,
            'detail_penyelesaian' => $request->detail_penyelesaian,
        ]);

        return redirect()
            ->route('lp3m.index', $data->id)
            ->with('success', 'Form LP3M berhasil disimpan');
    }

    public function edit($id)
    {
        $data = Lp3m::findOrFail($id);

        return view('lp3m.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Lp3m::findOrFail($id);

        $data->update([
            'deskripsi' => $request->deskripsi,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
            'spr_no' => $request->spr_no,
            'hasil_pengukuran' => $request->hasil_pengukuran,
            'penyebab_kerusakan' => $request->penyebab_kerusakan,
            'aus' => $request->has('aus'),
            'retak' => $request->has('retak'),
            'komponen_tak_berfungsi' => $request->has('komponen_tak_berfungsi'),
            'kelebihan_beban' => $request->has('kelebihan_beban'),
            'salah_operasi' => $request->has('salah_operasi'),
            'kelainan' => $request->has('kelainan'),
            'kecelakaan' => $request->has('kecelakaan'),
            'lain_lain_kerusakan' => $request->has('lain_lain_kerusakan'),
            'nama' => json_encode($request->nama),
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'pekerjaan' => $request->pekerjaan,
            'komponen_diganti' => $request->has('komponen_diganti'),
            'diperiksa_disetel' => $request->has('diperiksa_disetel'),
            'diperbaiki_dibuat' => $request->has('diperbaiki_dibuat'),
            'dimodifikasi' => $request->has('dimodifikasi'),
            'dipindah_pasang_baru' => $request->has('dipindah_pasang_baru'),
            'diperlukan_evaluasi' => $request->has('diperlukan_evaluasi'),
            'lain_lain_tindakan' => $request->has('lain_lain_tindakan'),
            'nama_barang' => json_encode(array_values(array_filter($request->nama_barang ?? []))),
            'kode_barang' => json_encode(array_values(array_filter($request->kode_barang ?? []))),
            'jumlah' => json_encode(array_values(array_filter($request->jumlah ?? []))),
            'tanggal_selesai' => $request->tanggal_selesai,
            'jam_selesai_detail' => $request->jam_selesai_detail,
            'detail_penyelesaian' => $request->detail_penyelesaian,
        ]);

        return redirect()
            ->route('lp3m.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function show($id)
    {
        $data = Lp3m::findOrFail($id);

        return view('lp3m.show', compact('data'));
    }

    public function destroy($id)
    {
        $data = Lp3m::findOrFail($id);

        $this->deleteAllLampiranFiles($data);
        $data->delete();

        return redirect()
            ->route('lp3m.index')
            ->with('success', 'Data berhasil dihapus');
    }

    /*
     * |--------------------------------------------------------------------------
     * | PRINT PDF DOMPDF
     * |--------------------------------------------------------------------------
     */

    public function print($id)
    {
        $data = Lp3m::findOrFail($id);

        $pdf = Pdf::loadView('lp3m.print', compact('data'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('LP3M-' . $data->id . '.pdf');
    }

    public function getRiwayatSpr()
    {
        $riwayat = Lp3m::whereNotNull('spr_no')
            ->where('spr_no', '!=', '')
            ->select('id', 'spr_no', 'created_at')
            ->latest()
            ->get();

        return response()->json($riwayat);
    }

    /*
     * |--------------------------------------------------------------------------
     * | MULTIPLE LAMPIRAN HELPER & ACTIONS
     * |--------------------------------------------------------------------------
     */

    private function parseLampiran($lampiran): array
    {
        if (empty($lampiran)) {
            return [];
        }

        if (is_array($lampiran)) {
            return array_values(array_filter($lampiran));
        }

        $decoded = json_decode($lampiran, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return array_values(array_filter($decoded));
        }

        return [(string) $lampiran];
    }

    private function saveLampiranList(Lp3m $data, array $files): void
    {
        $cleanFiles = array_values(array_unique(array_filter($files)));
        $data->update([
            'lampiran' => count($cleanFiles) > 0 ? json_encode($cleanFiles) : null,
        ]);
    }

    private function deleteLampiranFileOnDisk(string $filename): void
    {
        $safeName = basename($filename);
        $filePath = public_path('lampiran/' . $safeName);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
    }

    private function deleteAllLampiranFiles(Lp3m $data): void
    {
        foreach ($this->parseLampiran($data->lampiran) as $file) {
            $this->deleteLampiranFileOnDisk($file);
        }
    }

    public function uploadLampiran(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:lp3m,id',
            'lampiran' => 'required|array|min:1',
            'lampiran.*' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:51200',
        ], [
            'lampiran.required' => 'Pilih minimal satu file lampiran.',
            'lampiran.*.mimes' => 'Format file harus PDF, JPG, JPEG, PNG, DOC, atau DOCX.',
            'lampiran.*.max' => 'Ukuran setiap file maksimal 50MB.',
        ]);

        $data = Lp3m::findOrFail($request->id);
        $existingFiles = $this->parseLampiran($data->lampiran);

        $uploadDir = public_path('lampiran');
        if (!File::exists($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true);
        }

        $uploadedCount = 0;

        foreach ($request->file('lampiran') as $index => $file) {
            $originalName = preg_replace('/[^A-Za-z0-9._-]/', '_', $file->getClientOriginalName());
            $filename = time() . '_' . ($index + 1) . '_' . Str::random(6) . '_' . $originalName;

            $file->move($uploadDir, $filename);
            $existingFiles[] = $filename;
            $uploadedCount++;
        }

        $this->saveLampiranList($data, $existingFiles);

        return redirect()
            ->route('lp3m.index')
            ->with('success', $uploadedCount . ' file lampiran berhasil diupload');
    }

    public function deleteLampiran(Request $request, $id)
    {
        $data = Lp3m::findOrFail($id);
        $files = $this->parseLampiran($data->lampiran);
        $targetFile = $request->input('file');

        if ($targetFile) {
            $targetBasename = basename($targetFile);
            $updatedFiles = [];
            $deleted = false;

            foreach ($files as $file) {
                if (basename($file) === $targetBasename) {
                    $this->deleteLampiranFileOnDisk($file);
                    $deleted = true;
                } else {
                    $updatedFiles[] = $file;
                }
            }

            if (!$deleted) {
                return redirect()
                    ->route('lp3m.index')
                    ->with('error', 'File lampiran tidak ditemukan');
            }

            $this->saveLampiranList($data, $updatedFiles);

            return redirect()
                ->route('lp3m.index')
                ->with('success', 'Lampiran berhasil dihapus');
        }

        // Jika tidak ada nama file spesifik, hapus semua lampiran pada record ini
        foreach ($files as $file) {
            $this->deleteLampiranFileOnDisk($file);
        }

        $data->update([
            'lampiran' => null,
        ]);

        return redirect()
            ->route('lp3m.index')
            ->with('success', 'Semua lampiran berhasil dihapus');
    }

    public function dashboard()
    {
        $total = Lp3m::count();

        $open = Lp3m::where('status', 'OPEN')->count();
        $closed = Lp3m::where('status', 'CLOSED')->count();

        $progress = $total > 0 ? round(($closed / $total) * 100, 2) : 0;

        $openData = Lp3m::where('status', 'OPEN')
            ->latest()
            ->get();

        $overdue = Lp3m::where('status', 'OPEN')
            ->whereDate('created_at', '<', now()->subDays(14))
            ->get();

        $statusChart = [
            'open' => $open,
            'closed' => $closed,
        ];

        return view('lp3m.dashboard', compact(
            'total',
            'open',
            'closed',
            'progress',
            'openData',
            'overdue',
            'statusChart'
        ));
    }

    public function listSpr(Request $request)
    {
        $status = $request->status;

        $query = Lp3m::query()->whereNotNull('spr_no');

        if ($status == 'OPEN') {
            $query->where('status', 'OPEN');
        }

        if ($status == 'CLOSED') {
            $query->where('status', 'CLOSED');
        }

        $data = $query->latest()->paginate(10);

        return view('lp3m.list_spr', compact('data', 'status'));
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih untuk dihapus!');
        }

        $items = Lp3m::whereIn('id', $ids)->get();

        foreach ($items as $item) {
            $this->deleteAllLampiranFiles($item);
            $item->delete();
        }

        return redirect()->back()->with('success', count($ids) . ' data LP3M berhasil dihapus!');
    }
}
