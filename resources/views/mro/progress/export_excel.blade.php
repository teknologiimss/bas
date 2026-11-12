<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }

        th {
            background-color: #0f172a;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
            border: 1px solid #000000;
            padding: 8px;
        }

        td {
            border: 1px solid #000000;
            padding: 6px;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }

        .num {
            mso-number-format: "#,##0";
        }

        .pct {
            mso-number-format: "0.00%";
        }

        .str {
            mso-number-format: "\@";
        }
    </style>
</head>

<body>

    <table>
        <tr>
            <td colspan="15" style="font-size: 14pt; font-weight: bold; text-align: center; border: none;">
                LAPORAN PROGRESS MRO
            </td>
        </tr>
        <tr>
            <td colspan="15" style="font-size: 10pt; text-align: center; border: none;">
                Dicetak Pada: {{ date('d-m-Y H:i') }} WIB | B.A.S (Business Application System)
            </td>
        </tr>
        <tr>
            <td colspan="15" style="border: none;"></td>
        </tr>
        <thead>
            <tr>
                <th>No</th>
                <th>PO / SO / Kontrak</th>
                <th>Nama Pekerjaan</th>
                <th>Jenis Pekerjaan</th>
                <th>Tanggal Kontrak</th>
                <th>Selesai Kontrak</th>
                <th>Nilai Kontrak/SO (Rp)</th>
                <th>Realisasi Bulan Ini (Rp)</th>
                <th>Total Realisasi s/d Bulan Ini (Rp)</th>
                <th>Status</th>
                <th>Progress (%)</th>
                <th>Keterangan Progress</th>
                <th>Status Dokumen Terakhir</th>
                <th>Nilai Persentase Kontrak Total Progres (%)</th>
                <th>Status Kontrak / Notifikasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($monitorings as $index => $m)
                @php
                    $latestDoc = $m->documents ? $m->documents->sortByDesc('id')->first() : null;
                    $notif = method_exists($m, 'notifKontrak') ? $m->notifKontrak() : null;

                    $nilaiKontrakDoc = $m->documents
                        ? $m->documents
                            ->filter(fn($doc) => strtolower($doc->kriteria ?? '') === 'rencana')
                            ->sum('harga')
                        : 0;
                    $nilaiKontrak =
                        $nilaiKontrakDoc > 0
                            ? $nilaiKontrakDoc
                            : $m->nilai_kontrak ?? ($m->nilai_po ?? ($m->nilai ?? ($m->nominal ?? 0)));

                    $totalRealisasiDoc = $m->documents
                        ? $m->documents
                            ->filter(function ($doc) {
                                $kriteria = strtolower($doc->kriteria ?? '');
                                return in_array($kriteria, ['realisasi', 'closed']) &&
                                    !is_null($doc->harga) &&
                                    $doc->harga > 0;
                            })
                            ->sum('harga')
                        : 0;
                    $totalRealisasi =
                        $totalRealisasiDoc > 0 ? $totalRealisasiDoc : $m->total_realisasi ?? ($m->realisasi ?? 0);

                    $groupedPriceDocs = $m->documents
                        ? $m->documents
                            ->filter(
                                fn($doc) => strtolower($doc->kriteria ?? '') === 'realisasi' &&
                                    !is_null($doc->harga) &&
                                    $doc->harga > 0,
                            )
                            ->groupBy(function ($doc) {
                                $date = $doc->tanggal_closed ?? $doc->created_at;
                                return \Carbon\Carbon::parse($date)->format('Y-m');
                            })
                            ->sortByDesc(fn($group, $key) => $key)
                        : collect();

                    $latestMonthGroup = $groupedPriceDocs->first();
                    $totalHargaBulanIni = $latestMonthGroup ? $latestMonthGroup->sum('harga') : 0;

                    if ($latestDoc && strtolower($latestDoc->kriteria ?? '') === 'closed') {
                        $totalHargaBulanIni = 0;
                    }

                    // Hitung Persentase Total Progres MRO
                    $proyekMro = \App\Models\PekerjaanMro::where(
                        'no_kontrak',
                        'LIKE',
                        '%' . trim($m->po_nota_dinas) . '%',
                    )
                        ->where('nama_proyek', 'LIKE', '%' . trim($m->nama_pekerjaan) . '%')
                        ->first();

                    $persentaseTotalProgres = 0;
                    if ($proyekMro && $proyekMro->items->count() > 0) {
                        $tglMulaiItem = $m->tanggal_kontrak ?? null;
                        $tglSelesaiItem = $m->tanggal_selesai_kontrak ?? null;

                        $totalHargaGlobal = $proyekMro->items->sum(
                            fn($item) => $item->harga_satuan ? $item->vol_rencana * $item->harga_satuan : 0,
                        );
                        $hasHargaGlobal = $proyekMro->items->contains(
                            fn($item) => !empty($item->harga_satuan) && $item->harga_satuan > 0,
                        );
                        $totalItemCount = $proyekMro->items->count();

                        $startDateVal = $tglMulaiItem ? \Carbon\Carbon::parse($tglMulaiItem)->startOfDay() : now();
                        $endDateVal = $tglSelesaiItem ? \Carbon\Carbon::parse($tglSelesaiItem)->startOfDay() : now();
                        $diffDays = $startDateVal->diffInDays($endDateVal) + 1;
                        $totalWeeksCalc = max(1, ceil($diffDays / 7));

                        $sumSmpaiMingguIniPerMgg = array_fill(1, $totalWeeksCalc, 0);

                        foreach ($proyekMro->items as $item) {
                            $bobotRencana = 0;
                            if ($totalHargaGlobal > 0) {
                                $jumlahItem = $item->harga_satuan ? $item->vol_rencana * $item->harga_satuan : 0;
                                $bobotRencana = ($jumlahItem / $totalHargaGlobal) * 100;
                            }

                            $progressMingguanData = $item->progress_mingguan ?? [];
                            $smpaiMingguIniAcc = 0;

                            for ($w = 1; $w <= $totalWeeksCalc; $w++) {
                                $volRealisasi = $progressMingguanData[$w]['vol'] ?? '';
                                $progMingguIni = 0;

                                if ($item->vol_rencana > 0 && is_numeric($volRealisasi)) {
                                    if ($item->harga_satuan) {
                                        $progMingguIni = ($bobotRencana * $volRealisasi) / $item->vol_rencana;
                                    } else {
                                        $progMingguIni = ($volRealisasi / $item->vol_rencana) * 100;
                                    }
                                }
                                $smpaiMingguIniAcc += $progMingguIni;
                                $sumSmpaiMingguIniPerMgg[$w] += $smpaiMingguIniAcc;
                            }
                        }

                        if ($totalWeeksCalc > 0) {
                            $wLast = $totalWeeksCalc;
                            $persentaseTotalProgres = $hasHargaGlobal
                                ? $sumSmpaiMingguIniPerMgg[$wLast] ?? 0
                                : ($totalItemCount > 0
                                    ? ($sumSmpaiMingguIniPerMgg[$wLast] ?? 0) / $totalItemCount
                                    : 0);
                        }
                    }

                    // Format Status Dokumen Terakhir
                    $docSummary = 'Belum ada dokumen';
                    if ($latestDoc) {
                        $st = $latestDoc->status == 'Closed' ? 'OK' : ($latestDoc->status == 'Nok' ? 'NOK' : '-');
                        $tgl =
                            $latestDoc->tanggal_closed ?? $latestDoc->created_at
                                ? \Carbon\Carbon::parse($latestDoc->tanggal_closed ?? $latestDoc->created_at)->format(
                                    'd-m-Y',
                                )
                                : '-';
                        $docSummary = "Doc: {$latestDoc->nama_dokumen} | Status: {$st} | Tgl: {$tgl}";
                        if ($latestDoc->keterangan_closed) {
                            $docSummary .= " | Ket: {$latestDoc->keterangan_closed}";
                        }
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="str font-bold">{{ $m->po_nota_dinas ?: '-' }}</td>
                    <td>{{ $m->nama_pekerjaan ?: '-' }}</td>
                    <td class="text-center">{{ $m->jenis_pekerjaan ?? '-' }}</td>
                    <td class="text-center">
                        {{ $m->tanggal_kontrak ? \Carbon\Carbon::parse($m->tanggal_kontrak)->format('d-m-Y') : '-' }}
                    </td>
                    <td class="text-center">
                        {{ $m->tanggal_selesai_kontrak ? \Carbon\Carbon::parse($m->tanggal_selesai_kontrak)->format('d-m-Y') : '-' }}
                    </td>
                    <td class="text-right num">{{ $nilaiKontrak }}</td>
                    <td class="text-right num">{{ $totalHargaBulanIni }}</td>
                    <td class="text-right num">{{ $totalRealisasi }}</td>
                    <td class="text-center">{{ $m->status ?? '-' }}</td>
                    <td class="text-center">{{ is_numeric($m->progress) ? $m->progress : 0 }}%</td>
                    <td>{{ trim($m->keterangan2 ?? ($m->keterangan ?? '-')) }}</td>
                    <td>{{ $docSummary }}</td>
                    <td class="text-right">{{ number_format($persentaseTotalProgres, 2, ',', '.') }}%</td>
                    <td class="text-center">{{ $notif['text'] ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="15" class="text-center">Tidak ada data monitoring MRO</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <br>

    {{-- TABEL RINGKASAN REALISASI --}}
    <table>
        <thead>
            <tr>
                <th colspan="4" style="background-color: #334155;">RINGKASAN REALISASI NILAI PEKERJAAN S/D BULAN INI
                </th>
            </tr>
            <tr>
                <th style="background-color: #475569;">Departemen</th>
                <th style="background-color: #475569;">Total Realisasi (Rp)</th>
                <th style="background-color: #475569;">Realisasi INKA (Rp)</th>
                <th style="background-color: #475569;">Realisasi Non INKA (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="font-bold">MRO</td>
                <td class="text-right font-bold num">{{ $totalMro ?? 0 }}</td>
                <td class="text-right num">{{ $realisasiMroInka ?? 0 }}</td>
                <td class="text-right num">{{ $realisasiMroNonInka ?? 0 }}</td>
            </tr>
        </tbody>
    </table>

</body>

</html>
