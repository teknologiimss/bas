<?php

namespace App\Http\Controllers;

use App\Models\LaporanHarianFasilitas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanHarianFasilitasController extends Controller
{
    private function getSubKategoriList(): array
    {
        return [
            'A' => [
                'Pengecekan Harian',
                'Preventive Maintenance P1',
                'SPR',
            ],
            'B' => [
                'Cuker',
                'Pengiriman',
                'Rewinding Motor',
                'Sipil',
                'Tambahan kegiatan',
            ],
        ];
    }

    // public function index(Request $request)
    // {
    //     $query = LaporanHarianFasilitas::with(['items', 'teams'])->orderBy('tanggal', 'desc');

    //     if ($request->filled('bulan')) {
    //         $timestamp = strtotime($request->bulan . '-01');
    //         if ($timestamp !== false) {
    //             $query
    //                 ->whereMonth('tanggal', date('m', $timestamp))
    //                 ->whereYear('tanggal', date('Y', $timestamp));
    //         }
    //     }

    //     $laporans = $query->paginate(15);

    //     return view('laporan-fasilitas.index', compact('laporans'));
    // }

    public function index(Request $request)
    {
        $query = LaporanHarianFasilitas::with(['items', 'teams'])->orderBy('tanggal', 'desc');

        $bulanRaw = strtolower(trim((string) $request->query('bulan', '')));

        if ($bulanRaw !== '') {
            // 1. Format YYYY-MM (contoh: 2026-12)
            if (preg_match('/^(\d{4})[-_\/](\d{1,2})$/', $bulanRaw, $m)) {
                $tahun = (int) $m[1];
                $bulanAngka = (int) $m[2];
                if ($bulanAngka >= 1 && $bulanAngka <= 12) {
                    $query
                        ->whereYear('tanggal', $tahun)
                        ->whereMonth('tanggal', $bulanAngka);
                }
            } else {
                // 2. Mapping nama bulan Indonesia & Inggris ke angka 1-12
                $namaBulanMap = [
                    'januari' => 1,
                    'jan' => 1,
                    'january' => 1,
                    'februari' => 2,
                    'feb' => 2,
                    'february' => 2,
                    'maret' => 3,
                    'mar' => 3,
                    'march' => 3,
                    'april' => 4,
                    'apr' => 4,
                    'mei' => 5,
                    'may' => 5,
                    'juni' => 6,
                    'jun' => 6,
                    'june' => 6,
                    'juli' => 7,
                    'jul' => 7,
                    'july' => 7,
                    'agustus' => 8,
                    'agu' => 8,
                    'ags' => 8,
                    'august' => 8,
                    'aug' => 8,
                    'september' => 9,
                    'sep' => 9,
                    'sept' => 9,
                    'oktober' => 10,
                    'okt' => 10,
                    'october' => 10,
                    'oct' => 10,
                    'november' => 11,
                    'nov' => 11,
                    'desember' => 12,
                    'des' => 12,
                    'december' => 12,
                    'dec' => 12,
                ];

                // Jika user mengetik "desember 2026" atau "2026 desember"
                $tahun = null;
                if (preg_match('/\b(20\d{2}|19\d{2})\b/', $bulanRaw, $tahunMatch)) {
                    $tahun = (int) $tahunMatch[1];
                    $bulanRaw = trim(str_replace($tahunMatch[0], '', $bulanRaw));
                }

                $bulanAngka = null;
                if (isset($namaBulanMap[$bulanRaw])) {
                    $bulanAngka = $namaBulanMap[$bulanRaw];
                } elseif (is_numeric($bulanRaw)) {
                    $angka = (int) $bulanRaw;
                    if ($angka >= 1 && $angka <= 12) {
                        $bulanAngka = $angka;
                    }
                }

                if ($bulanAngka !== null) {
                    $query->whereMonth('tanggal', $bulanAngka);
                    if ($tahun !== null) {
                        $query->whereYear('tanggal', $tahun);
                    }
                }
            }
        }

        $laporans = $query->paginate(15);

        return view('laporan-fasilitas.index', compact('laporans'));
    }

    public function create()
    {
        $subKategoriList = $this->getSubKategoriList();
        return view('laporan-fasilitas.create', compact('subKategoriList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|unique:laporan_harian_fasilitas,tanggal',
            'judul' => 'required|string|max:255',
        ], [
            'tanggal.required' => 'Tanggal laporan wajib diisi.',
            'tanggal.unique' => 'Laporan untuk tanggal tersebut sudah ada. Silakan edit laporan yang sudah ada.',
            'judul.required' => 'Judul laporan wajib diisi.',
        ]);

        DB::beginTransaction();
        try {
            $laporan = LaporanHarianFasilitas::create([
                'tanggal' => $request->tanggal,
                'judul' => $request->judul,
                'catatan' => $request->catatan,
                'created_by' => Auth::id(),
            ]);

            $this->syncDetails($laporan, $request);

            DB::commit();

            return redirect()
                ->route('laporan-fasilitas.show', $laporan->id)
                ->with('success', 'Laporan harian fasilitas berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan laporan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $laporan = LaporanHarianFasilitas::with(['itemsKelompokA', 'itemsKelompokB', 'teams'])->findOrFail($id);
        $subKategoriList = $this->getSubKategoriList();

        return view('laporan-fasilitas.show', compact('laporan', 'subKategoriList'));
    }

    public function edit($id)
    {
        $laporan = LaporanHarianFasilitas::with(['items', 'teams'])->findOrFail($id);
        $subKategoriList = $this->getSubKategoriList();

        return view('laporan-fasilitas.edit', compact('laporan', 'subKategoriList'));
    }

    public function update(Request $request, $id)
    {
        $laporan = LaporanHarianFasilitas::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date|unique:laporan_harian_fasilitas,tanggal,' . $laporan->id,
            'judul' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $laporan->update([
                'tanggal' => $request->tanggal,
                'judul' => $request->judul,
                'catatan' => $request->catatan,
            ]);

            $laporan->items()->delete();
            $laporan->teams()->delete();
            $this->syncDetails($laporan, $request);

            DB::commit();

            return redirect()
                ->route('laporan-fasilitas.show', $laporan->id)
                ->with('success', 'Laporan harian fasilitas berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui laporan: ' . $e->getMessage());
        }
    }

    public function duplicate($id)
    {
        $sumber = LaporanHarianFasilitas::with(['items', 'teams'])->findOrFail($id);

        DB::beginTransaction();
        try {
            $tanggalBaru = $this->findAvailableTanggal(Carbon::today()->format('Y-m-d'));

            $duplikat = LaporanHarianFasilitas::create([
                'tanggal' => $tanggalBaru,
                'judul' => $sumber->judul,
                'catatan' => $sumber->catatan,
                'created_by' => Auth::id(),
            ]);

            foreach ($sumber->items as $item) {
                $duplikat->items()->create([
                    'kelompok' => $item->kelompok,
                    'sub_kategori' => $item->sub_kategori,
                    'deskripsi' => $item->deskripsi,
                    'sub_items' => $item->sub_items,
                    'urutan' => $item->urutan,
                ]);
            }

            foreach ($sumber->teams as $team) {
                $duplikat->teams()->create([
                    'nama_personil' => $team->nama_personil,
                    'keterangan' => $team->keterangan,
                    'urutan' => $team->urutan,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('laporan-fasilitas.edit', $duplikat->id)
                ->with('success', 'Laporan berhasil diduplikasi ke tanggal ' . Carbon::parse($tanggalBaru)->format('d/m/Y') . '. Silakan sesuaikan tanggal dan isinya.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menduplikasi laporan: ' . $e->getMessage());
        }
    }

    private function findAvailableTanggal(string $mulaiTanggal): string
    {
        $candidate = Carbon::parse($mulaiTanggal);
        while (LaporanHarianFasilitas::whereDate('tanggal', $candidate->format('Y-m-d'))->exists()) {
            $candidate->addDay();
        }
        return $candidate->format('Y-m-d');
    }

    public function destroy($id)
    {
        $laporan = LaporanHarianFasilitas::findOrFail($id);
        $laporan->delete();

        return redirect()
            ->route('laporan-fasilitas.index')
            ->with('success', 'Laporan harian berhasil dihapus.');
    }

    private function syncDetails(LaporanHarianFasilitas $laporan, Request $request): void
    {
        $subKategoriMap = $this->getSubKategoriList();

        if ($request->has('items') && is_array($request->items)) {
            $urutan = 0;
            foreach ($request->items as $item) {
                $deskripsiLines = [];
                if (!empty($item['deskripsi'])) {
                    $rawDescLines = preg_split('/\r\n|\r|\n/', $item['deskripsi']);
                    foreach ($rawDescLines as $dLine) {
                        $cleanDesc = trim($dLine);
                        if ($cleanDesc !== '') {
                            $deskripsiLines[] = $cleanDesc;
                        }
                    }
                }

                if (empty($deskripsiLines)) {
                    continue;
                }

                $kelompok = in_array($item['kelompok'] ?? 'A', ['A', 'B']) ? $item['kelompok'] : 'A';
                $subKategori = trim($item['sub_kategori'] ?? '');
                if ($subKategori === '' && !empty($subKategoriMap[$kelompok])) {
                    $subKategori = $subKategoriMap[$kelompok][0];
                }

                $subItemsArray = [];
                if (!empty($item['sub_items_raw'])) {
                    $lines = preg_split('/\r\n|\r|\n/', $item['sub_items_raw']);
                    foreach ($lines as $line) {
                        $cleanLine = trim($line);
                        if ($cleanLine !== '') {
                            $subItemsArray[] = $cleanLine;
                        }
                    }
                }

                $laporan->items()->create([
                    'kelompok' => $kelompok,
                    'sub_kategori' => $subKategori,
                    'deskripsi' => implode("\n", $deskripsiLines),
                    'sub_items' => !empty($subItemsArray) ? $subItemsArray : null,
                    'urutan' => $urutan++,
                ]);
            }
        }

        if ($request->has('teams') && is_array($request->teams)) {
            $teamUrutan = 0;
            foreach ($request->teams as $team) {
                $nama = trim($team['nama_personil'] ?? '');
                if ($nama === '') {
                    continue;
                }

                $laporan->teams()->create([
                    'nama_personil' => $nama,
                    'keterangan' => trim($team['keterangan'] ?? ''),
                    'urutan' => $teamUrutan++,
                ]);
            }
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:laporan_harian_fasilitas,id',
        ], [
            'ids.required' => 'Pilih minimal satu laporan yang ingin dihapus.',
            'ids.min' => 'Pilih minimal satu laporan yang ingin dihapus.',
        ]);

        DB::beginTransaction();
        try {
            $deletedCount = LaporanHarianFasilitas::whereIn('id', $request->ids)->delete();

            DB::commit();

            return redirect()
                ->route('laporan-fasilitas.index')
                ->with('success', $deletedCount . ' laporan harian fasilitas berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()
                ->route('laporan-fasilitas.index')
                ->with('error', 'Gagal menghapus laporan terpilih: ' . $e->getMessage());
        }
    }
}
