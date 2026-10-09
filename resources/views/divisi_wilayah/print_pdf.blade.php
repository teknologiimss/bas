<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Progress Divisi Wilayah</title>
    <style>
        /* Pengaturan Cetak A4 Landscape */
        @page {
            size: A4 landscape;
            margin: 8mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 8.5px;
            color: #1e293b;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 12px;
        }

        .header h2 {
            margin: 0;
            color: #0f172a;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .header p {
            margin: 2px 0 0 0;
            color: #64748b;
            font-size: 8px;
        }

        /* Tabel Presisi & Tidak Terpotong */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 10px;
        }

        th,
        td {
            border: 1px solid #cbd5e1;
            padding: 4px 5px;
            vertical-align: middle;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        th {
            background-color: #0f172a;
            color: #ffffff;
            text-align: center;
            font-weight: bold;
            font-size: 8.5px;
            text-transform: uppercase;
            padding: 6px 3px;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        /* Badge Status */
        .badge {
            display: inline-block;
            padding: 2px 4px;
            border-radius: 3px;
            font-size: 7.5px;
            font-weight: bold;
            color: #fff;
            text-align: center;
            line-height: 1.1;
        }

        .badge-warning {
            background-color: #f59e0b;
            color: #fff;
        }

        .badge-success {
            background-color: #10b981;
            color: #fff;
        }

        .badge-danger {
            background-color: #ef4444;
            color: #fff;
        }

        .badge-secondary {
            background-color: #64748b;
            color: #fff;
        }

        .badge-info {
            background-color: #0ea5e9;
            color: #fff;
        }

        .badge-primary {
            background-color: #3b82f6;
            color: #fff;
        }

        /* Badge Divisi */
        .badge-mro {
            background-color: #991b1b;
            color: #fff;
        }

        .badge-wil1 {
            background-color: #1d4ed8;
            color: #fff;
        }

        .badge-wil2 {
            background-color: #166534;
            color: #fff;
        }

        /* Document Card */
        .doc-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 3px 4px;
            border-radius: 3px;
            font-size: 8px;
            line-height: 1.2;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Laporan Progress Divisi Wilayah</h2>
        <p>Rekapitulasi Progress MRO, Wilayah 1 dan Wilayah 2</p>
        <p>Dicetak Pada: {{ date('d-m-Y H:i') }} WIB | B.A.S (Business Application System)</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 6%;">Divisi</th>
                <th style="width: 10%;">PO / Nota Dinas</th>
                <th style="width: 12%;">Nama Pekerjaan</th>
                <th style="width: 7%;">Tgl Kontrak</th>
                <th style="width: 7%;">Selesai Kontrak</th>
                <th style="width: 9%;">Nilai Kontrak</th>
                <th style="width: 9%;">Ket. Progress</th>
                <th style="width: 10%;">Realisasi Bln Ini</th>
                <th style="width: 10%;">Total Realisasi s/d Bln Ini</th>
                <th style="width: 10%;">Status Dokumen Terakhir</th>
                <th style="width: 7%;">Status Kontrak</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($monitorings->sortByDesc('created_at') as $m)
                @php
                    // Penentuan Warna Badge Divisi
                    if ($m->divisi === 'MRO') {
                        $divisiClass = 'badge-mro';
                    } elseif ($m->divisi === 'Wilayah 1') {
                        $divisiClass = 'badge-wil1';
                    } else {
                        $divisiClass = 'badge-wil2';
                    }

                    // 1. Ambil dokumen PALING BARU berdasarkan ID
                    $latestDoc = $m->documents ? $m->documents->sortByDesc('id')->first() : null;

                    // Notifikasi Status Kontrak
                    $notif = method_exists($m, 'notifKontrak') ? $m->notifKontrak() : null;

                    // 2. Kalkulasi Nilai Kontrak (Dokumen Rencana dengan Fallback Nilai PO/Kontrak bawaan model)
                    $nilaiKontrakDoc = $m->documents
                        ? $m->documents
                            ->filter(fn($doc) => strtolower($doc->kriteria ?? '') === 'rencana')
                            ->sum('harga')
                        : 0;

                    $nilaiKontrak =
                        $nilaiKontrakDoc > 0
                            ? $nilaiKontrakDoc
                            : $m->nilai_kontrak ?? ($m->nilai_po ?? ($m->nilai ?? ($m->nominal ?? 0)));

                    // 3. Kalkulasi Total Realisasi s/d Bulan Ini (Mencakup 'Realisasi' & 'Closed')
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

                    // 4. Filter dokumen yang HANYA berkriteria 'Realisasi' per bulan
                    $groupedPriceDocs = $m->documents
                        ? $m->documents
                            ->filter(function ($doc) {
                                return strtolower($doc->kriteria ?? '') === 'realisasi' &&
                                    !is_null($doc->harga) &&
                                    $doc->harga > 0;
                            })
                            ->groupBy(function ($doc) {
                                $date = $doc->tanggal_closed ?? $doc->created_at;
                                return \Carbon\Carbon::parse($date)->format('Y-m');
                            })
                            ->sortByDesc(fn($group, $key) => $key)
                        : collect();

                    $latestMonthGroup = $groupedPriceDocs->first();
                    $latestPriceDoc = null;
                    $totalHargaBulanIni = 0;

                    if ($latestMonthGroup) {
                        $latestPriceDoc = $latestMonthGroup
                            ->sortByDesc(fn($doc) => $doc->created_at ?? $doc->id)
                            ->first();

                        $totalHargaBulanIni = $latestMonthGroup->sum('harga');
                    }

                    // 5. PENYESUAIAN KRITERIA CLOSED:
                    // Jika dokumen teratas/terakhir berkriteria 'Closed', paksa Realisasi Bulan Ini menjadi Rp.0
                    if ($latestDoc && strtolower($latestDoc->kriteria ?? '') === 'closed') {
                        $totalHargaBulanIni = 0;
                        $latestPriceDoc = null;
                    }
                @endphp
                <tr>
                    {{-- No --}}
                    <td class="text-center">{{ $loop->iteration }}</td>

                    {{-- Divisi --}}
                    <td class="text-center">
                        <span class="badge {{ $divisiClass }}">
                            {{ $m->divisi }}
                        </span>
                    </td>

                    {{-- PO / Nota Dinas --}}
                    <td class="font-bold">{{ $m->po_nota_dinas ?: '-' }}</td>

                    {{-- Nama Pekerjaan --}}
                    <td>{{ $m->nama_pekerjaan ?: '-' }}</td>

                    {{-- Tanggal Kontrak --}}
                    <td class="text-center">
                        {{ $m->tanggal_kontrak ? \Carbon\Carbon::parse($m->tanggal_kontrak)->format('d-m-Y') : '-' }}
                    </td>

                    {{-- Selesai Kontrak --}}
                    <td class="text-center">
                        {{ $m->tanggal_selesai_kontrak ? \Carbon\Carbon::parse($m->tanggal_selesai_kontrak)->format('d-m-Y') : '-' }}
                    </td>

                    {{-- Nilai Kontrak --}}
                    <td class="text-center">
                        <div class="doc-card">
                            <div class="font-bold">
                                Rp {{ number_format($nilaiKontrak, 0, ',', '.') }}
                            </div>
                        </div>
                    </td>

                    {{-- Keterangan Progress --}}
                    <td>
                        @php
                            $text = trim($m->keterangan2 ?? ($m->keterangan ?? '-'));
                            $lines = preg_split('/\r\n|\r|\n/', $text);
                            echo str_starts_with($text, '-') ? implode('<br>', $lines) : implode(', ', $lines);
                        @endphp
                    </td>

                    {{-- Realisasi Bulan Ini --}}
                    <td class="text-center">
                        @if ($latestPriceDoc && $totalHargaBulanIni > 0)
                            <div class="doc-card">
                                <div class="font-bold">
                                    Rp {{ number_format($totalHargaBulanIni, 0, ',', '.') }}
                                </div>
                                <div style="margin-top: 2px;">
                                    @if ($latestPriceDoc->jenis_dokumen)
                                        <span class="badge badge-secondary" style="font-size: 6.5px;">
                                            {{ $latestPriceDoc->jenis_dokumen }}
                                        </span>
                                    @endif
                                    @if ($latestPriceDoc->tanggal_closed ?? $latestPriceDoc->created_at)
                                        <span class="badge badge-info" style="font-size: 6.5px;">
                                            {{ \Carbon\Carbon::parse($latestPriceDoc->tanggal_closed ?? $latestPriceDoc->created_at)->isoFormat('MMM YYYY') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @else
                            <span style="color: #94a3b8; font-style: italic;">Rp.0</span>
                        @endif
                    </td>

                    {{-- Total Realisasi s/d Bulan Ini --}}
                    <td class="text-center">
                        <div class="doc-card">
                            <div class="font-bold" style="color: #059669;">
                                Rp {{ number_format($totalRealisasi, 0, ',', '.') }}
                            </div>
                        </div>
                    </td>

                    {{-- Status Dokumen Terakhir --}}
                    <td>
                        @if ($latestDoc)
                            <div class="doc-card">
                                <div><b>Doc:</b> {{ $latestDoc->nama_dokumen }}</div>
                                <div>
                                    <b>Status:</b>
                                    @if ($latestDoc->status == 'Closed')
                                        <span style="color: #10b981; font-weight: bold;">OK</span>
                                    @elseif ($latestDoc->status == 'Nok')
                                        <span style="color: #ef4444; font-weight: bold;">NOK</span>
                                    @else
                                        -
                                    @endif
                                </div>
                                @if ($latestDoc->tanggal_closed ?? $latestDoc->created_at)
                                    <div><b>Tgl:</b>
                                        {{ \Carbon\Carbon::parse($latestDoc->tanggal_closed ?? $latestDoc->created_at)->format('d-m-Y') }}
                                    </div>
                                @endif
                                @if ($latestDoc->keterangan_closed)
                                    <div style="color: #ef4444; font-weight: bold;">
                                        <b>Ket:</b> {{ $latestDoc->keterangan_closed }}
                                    </div>
                                @endif
                            </div>
                        @else
                            <span style="color: #94a3b8; font-style: italic;">Belum ada dokumen</span>
                        @endif
                    </td>

                    {{-- Status Kontrak --}}
                    <td class="text-center">
                        @if ($notif)
                            <span class="badge badge-{{ $notif['class'] }}">
                                {{ $notif['text'] }}
                            </span>
                        @else
                            <span class="badge badge-secondary">-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center" style="color: #64748b;">
                        Tidak ada data monitoring
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>
