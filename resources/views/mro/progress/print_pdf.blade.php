<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Progress MRO</title>
    <style>
        /* Pengaturan Kertas Cetak A4 Landscape dengan margin presisi */
        @page {
            size: A4 landscape;
            margin: 6mm 6mm 8mm 6mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 7.5px;
            color: #1e293b;
            margin: 0;
            padding: 0;
            background-color: #fff;
            position: relative;
        }

        /* Logo Absolute: Menempel di kanan atas */
        .header-logo {
            position: absolute;
            top: -20px;
            right: 0;
            height: 70px;
            object-fit: contain;
            z-index: 100;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            padding-right: 80px;
            padding-left: 80px;
        }

        .header h2 {
            margin: 0;
            color: #0f172a;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .header p {
            margin: 3px 0 0 0;
            color: #64748b;
            font-size: 7.5px;
        }

        /* Pengaturan Tabel Supaya Pas 1 Halaman & Tidak Terpotong */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 10px;
        }

        th,
        td {
            border: 1px solid #cbd5e1;
            padding: 3px 2px;
            vertical-align: middle;
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
            font-size: 7.5px;
        }

        th {
            background-color: #0f172a;
            color: #ffffff;
            text-align: center;
            font-weight: bold;
            font-size: 7.5px;
            text-transform: uppercase;
            padding: 5px 1px;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        /* Badge General Presisi (Anti Melebihi Kolom) */
        .badge {
            display: inline-block;
            max-width: 100%;
            padding: 2px 3px;
            border-radius: 3px;
            font-size: 6px;
            font-weight: bold;
            color: #fff;
            text-align: center;
            line-height: 1.15;
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
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

        .doc-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 2px 3px;
            border-radius: 3px;
            font-size: 7px;
            line-height: 1.1;
        }

        /* Progress Bar Style untuk Cetak */
        .progress-container {
            width: 100%;
            background-color: #dbeafe;
            border-radius: 4px;
            height: 9px;
            position: relative;
            overflow: hidden;
            display: inline-block;
            vertical-align: middle;
        }

        .progress-bar-fill {
            height: 100%;
            border-radius: 4px;
        }

        .progress-text {
            font-size: 6.5px;
            font-weight: bold;
            margin-top: 1px;
            display: block;
        }

        /* Penyesuaian Sel Notifikasi */
        td.col-notif {
            padding: 2px 1px;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- Logo di pojok kanan atas absolute -->
    <img src="{{ public_path('img/IMST.png') }}" alt="Logo IMST" class="header-logo">

    <div class="header">
        <h2>Laporan Progress MRO</h2>
        <p>Dicetak Pada: {{ date('d-m-Y H:i') }} WIB | B.A.S (Business Application System)</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 2.5%;">No</th>
                <th style="width: 9.5%;">SO / PO / KO</th>
                <th style="width: 9.5%;">Nama Pekerjaan</th>
                <th style="width: 6.5%;">Jenis</th>
                <th style="width: 6%;">Tgl Kontrak</th>
                <th style="width: 6%;">Selesai</th>
                <th style="width: 8.5%;">Nilai Kontrak/SO</th>
                <th style="width: 8.5%;">Realisasi Bln Ini</th>
                <th style="width: 9%;">Total Realisasi s/d Bln Ini</th>
                <th style="width: 5.5%;">Status</th>
                <th style="width: 6.5%;">Progress</th>
                <th style="width: 8.5%;">Ket. Progress</th>
                <th style="width: 10.5%;">Status Dokumen Terakhir</th>
                <th style="width: 7.5%;">Status Kontrak</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($monitorings->sortByDesc('created_at') as $m)
                @php
                    // Status Pekerjaan Warna Badge
                    $statusClass = match ($m->status) {
                        'Open' => 'badge-warning',
                        'Closed' => 'badge-success',
                        'On Hold' => 'badge-danger',
                        default => 'badge-secondary',
                    };

                    // Progress Calculation & Color Samakan Seperti di Blade
                    $progressVal = is_numeric($m->progress)
                        ? (float) $m->progress
                        : (float) preg_replace('/[^0-9.]/', '', $m->progress ?? 0);
                    $progressVal = max(0, min(100, $progressVal));

                    $progressColor = method_exists($m, 'progressColor') ? $m->progressColor() : '#2563eb';

                    // Ambil dokumen terakhir
                    $latestDoc = $m->documents ? $m->documents->sortByDesc('id')->first() : null;
                    $notif = method_exists($m, 'notifKontrak') ? $m->notifKontrak() : null;

                    // --- KALKULASI NILAI KONTRAK & REALISASI ---
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
                    $latestPriceDoc = null;
                    $totalHargaBulanIni = 0;

                    if ($latestMonthGroup) {
                        $latestPriceDoc = $latestMonthGroup
                            ->sortByDesc(fn($doc) => $doc->created_at ?? $doc->id)
                            ->first();

                        $totalHargaBulanIni = $latestMonthGroup->sum('harga');
                    }

                    if ($latestDoc && strtolower($latestDoc->kriteria ?? '') === 'closed') {
                        $totalHargaBulanIni = 0;
                        $latestPriceDoc = null;
                    }
                @endphp
                <tr>
                    {{-- No --}}
                    <td class="text-center">{{ $loop->iteration }}</td>

                    {{-- SO / PO / KO --}}
                    <td class="font-bold">{{ $m->po_nota_dinas ?: '-' }}</td>

                    {{-- Nama Pekerjaan --}}
                    <td>{{ $m->nama_pekerjaan ?: '-' }}</td>

                    {{-- Jenis Pekerjaan --}}
                    <td>{{ $m->jenis_pekerjaan ?? '-' }}</td>

                    {{-- Tanggal Kontrak --}}
                    <td class="text-center">
                        {{ $m->tanggal_kontrak ? \Carbon\Carbon::parse($m->tanggal_kontrak)->format('d-m-Y') : '-' }}
                    </td>

                    {{-- Selesai Kontrak --}}
                    <td class="text-center">
                        {{ $m->tanggal_selesai_kontrak ? \Carbon\Carbon::parse($m->tanggal_selesai_kontrak)->format('d-m-Y') : '-' }}
                    </td>

                    {{-- NILAI KONTRAK (TOTAL RENCANA) --}}
                    <td class="text-center">
                        <div class="doc-card">
                            <div class="font-bold">
                                Rp {{ number_format($nilaiKontrak, 0, ',', '.') }}
                            </div>
                        </div>
                    </td>

                    {{-- REALISASI BULAN INI --}}
                    <td class="text-center">
                        @if ($latestPriceDoc && $totalHargaBulanIni > 0)
                            <div class="doc-card">
                                <div class="font-bold">
                                    Rp {{ number_format($totalHargaBulanIni, 0, ',', '.') }}
                                </div>
                                <div style="margin-top: 2px;">
                                    @if ($latestPriceDoc->jenis_dokumen)
                                        <span class="badge badge-secondary" style="font-size: 5.5px;">
                                            {{ $latestPriceDoc->jenis_dokumen }}
                                        </span>
                                    @endif
                                    @if ($latestPriceDoc->tanggal_closed ?? $latestPriceDoc->created_at)
                                        <span class="badge badge-info" style="font-size: 5.5px;">
                                            {{ \Carbon\Carbon::parse($latestPriceDoc->tanggal_closed ?? $latestPriceDoc->created_at)->isoFormat('MMM YYYY') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @else
                            <span style="color: #94a3b8; font-style: italic;">Rp 0</span>
                        @endif
                    </td>

                    {{-- TOTAL REALISASI S/D BULAN INI --}}
                    <td class="text-center">
                        <div class="doc-card">
                            <div class="font-bold" style="color: #059669;">
                                Rp {{ number_format($totalRealisasi, 0, ',', '.') }}
                            </div>
                        </div>
                    </td>

                    {{-- STATUS PEKERJAAN --}}
                    <td class="text-center">
                        <span class="badge {{ $statusClass }}">
                            {{ $m->status ?? '-' }}
                        </span>
                    </td>

                    {{-- PROGRESS --}}
                    <td class="text-center">
                        <div class="progress-container">
                            <div class="progress-bar-fill"
                                style="width: {{ $progressVal }}%; background-color: {{ $progressColor }};"></div>
                        </div>
                        <span class="progress-text"
                            style="color: {{ $progressColor }};">{{ number_format($progressVal, 0) }}%</span>
                    </td>

                    {{-- KETERANGAN PROGRESS --}}
                    <td>
                        @php
                            $text = trim($m->keterangan2 ?? ($m->keterangan ?? '-'));
                            $lines = preg_split('/\r\n|\r|\n/', $text);
                            echo str_starts_with($text, '-') ? implode('<br>', $lines) : implode(', ', $lines);
                        @endphp
                    </td>

                    {{-- STATUS DOKUMEN TERAKHIR --}}
                    <td>
                        @if ($latestDoc)
                            <div class="doc-card">
                                <div><b>Doc:</b> {{ $latestDoc->nama_dokumen }}</div>
                                <div><b>Status:</b>
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

                    {{-- STATUS KONTRAK / NOTIFIKASI --}}
                    <td class="col-notif">
                        @if ($notif)
                            <span class="badge badge-{{ $notif['class'] }}">
                                {{-- Pastikan teks menampilkan detail hari jika bernilai 'Akan Berakhir' atau gunakan langsung $notif['text'] --}}
                                {{ $notif['text'] }}
                            </span>
                        @else
                            <span class="badge badge-secondary">-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="14" class="text-center" style="color: #64748b;">
                        Tidak ada data monitoring MRO
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>
