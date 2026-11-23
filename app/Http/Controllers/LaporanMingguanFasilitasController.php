<?php

namespace App\Http\Controllers;

use App\Models\LaporanHarianFasilitas;
use App\Models\LaporanMingguanFasilitas;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanMingguanFasilitasController extends Controller
{
    /**
     * Menghitung rentang Senin - Jumat dari tanggal acuan mana pun.
     */
    private function getSeninJumatRange(?string $tanggalAcuan = null): array
    {
        $base = $tanggalAcuan ? Carbon::parse($tanggalAcuan) : Carbon::today();
        $senin = $base->copy()->startOfWeek(Carbon::MONDAY);
        $jumat = $senin->copy()->addDays(4);  // Senin + 4 hari = Jumat

        return [$senin, $jumat];
    }

    /**
     * Menyusun rincian hari Senin - Jumat beserta tanggal, hari, bulan, tahun, dan item pekerjaannya.
     */
    private function buildMingguanData(Carbon $senin, Carbon $jumat): array
    {
        $laporansByDate = LaporanHarianFasilitas::with(['items', 'teams'])
            ->whereBetween('tanggal', [$senin->toDateString(), $jumat->toDateString()])
            ->get()
            ->keyBy(function ($row) {
                return Carbon::parse($row->tanggal)->toDateString();
            });

        $hariList = [];
        $period = CarbonPeriod::create($senin->toDateString(), $jumat->toDateString());
        $totalItemPekerjaan = 0;
        $totalHariTerisi = 0;

        foreach ($period as $date) {
            $tglStr = $date->toDateString();
            $carbonId = $date->copy()->locale('id');
            $laporanHarian = $laporansByDate->get($tglStr);

            $itemsFormatted = [];
            if ($laporanHarian && $laporanHarian->items->count()) {
                $totalHariTerisi++;
                foreach ($laporanHarian->items as $item) {
                    $descLines = [];
                    if (!empty($item->deskripsi)) {
                        foreach (preg_split('/\r\n|\r|\n/', (string) $item->deskripsi) as $line) {
                            $clean = ltrim(trim($line), "~ \t");
                            if ($clean !== '') {
                                $descLines[] = $clean;
                            }
                        }
                    }

                    $subItems = is_array($item->sub_items) ? $item->sub_items : [];

                    $itemsFormatted[] = [
                        'id' => $item->id,
                        'kelompok' => $item->kelompok,
                        'sub_kategori' => $item->sub_kategori,
                        'deskripsi' => $item->deskripsi,
                        'desc_lines' => $descLines,
                        'sub_items' => $subItems,
                    ];
                    $totalItemPekerjaan++;
                }
            }

            $hariList[] = [
                'tanggal_iso' => $tglStr,
                'hari' => $carbonId->translatedFormat('l'),  // Senin, Selasa, Rabu, Kamis, Jumat
                'tanggal' => $carbonId->format('d'),  // 23
                'bulan' => $carbonId->translatedFormat('F'),  // November
                'bulan_angka' => $carbonId->format('m'),  // 11
                'tahun' => $carbonId->format('Y'),  // 2026
                'tanggal_full' => $carbonId->translatedFormat('d F Y'),  // 23 November 2026
                'laporan' => $laporanHarian,
                'items' => $itemsFormatted,
            ];
        }

        return [
            'hari_list' => $hariList,
            'total_item' => $totalItemPekerjaan,
            'total_hari_terisi' => $totalHariTerisi,
        ];
    }

    public function index(Request $request)
    {
        [$senin, $jumat] = $this->getSeninJumatRange($request->query('tanggal'));
        $mingguanData = $this->buildMingguanData($senin, $jumat);

        $arsipMingguan = LaporanMingguanFasilitas::where('tanggal_mulai', $senin->toDateString())
            ->where('tanggal_selesai', $jumat->toDateString())
            ->first();

        // Daftar 6 minggu terakhir untuk pilihan cepat
        $pilihanMinggu = [];
        for ($i = 0; $i < 6; $i++) {
            $s = Carbon::today()->startOfWeek(Carbon::MONDAY)->subWeeks($i);
            $j = $s->copy()->addDays(4);
            $pilihanMinggu[] = [
                'tanggal_acuan' => $s->toDateString(),
                'label' => 'Senin, ' . $s->locale('id')->translatedFormat('d M Y') . ' s.d. Jumat, ' . $j->locale('id')->translatedFormat('d M Y'),
                'bulan_tahun' => $j->locale('id')->translatedFormat('F Y'),
            ];
        }

        return view('laporan-mingguan.index', compact(
            'senin',
            'jumat',
            'mingguanData',
            'arsipMingguan',
            'pilihanMinggu'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_acuan' => 'required|date',
            'judul' => 'required|string|max:255',
            'catatan_mingguan' => 'nullable|string',
        ]);

        [$senin, $jumat] = $this->getSeninJumatRange($request->tanggal_acuan);

        $arsip = LaporanMingguanFasilitas::updateOrCreate(
            [
                'tanggal_mulai' => $senin->toDateString(),
                'tanggal_selesai' => $jumat->toDateString(),
            ],
            [
                'judul' => trim($request->judul),
                'catatan_mingguan' => $request->catatan_mingguan,
                'created_by' => Auth::id(),
            ]
        );

        return redirect()
            ->route('laporan-mingguan.index', ['tanggal' => $senin->toDateString()])
            ->with('success', 'Rekap laporan mingguan (' . $arsip->periode_label . ') berhasil disimpan.');
    }
}
