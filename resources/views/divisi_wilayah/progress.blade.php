@extends('layouts.main')

@section('title', 'Progress Divisi Wilayah')

<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        /* ================= ROOT COLOR ================= */
        :root {
            --navy: #0f172a;
            --navy-dark: #020617;
            --blue: #2563eb;
            --blue-soft: #eff6ff;
            --border: #bfdbfe;
        }

        body {
            background: linear-gradient(135deg, #f8fafc, #eff6ff);
        }

        /* ================= CARD MODERN ================= */
        .card {
            border: none;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 10px 28px rgba(15, 23, 42, .08);
            transition: .25s;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 36px rgba(15, 23, 42, .12);
        }

        /* ================= HEADER ================= */
        h3 {
            background: linear-gradient(90deg, var(--navy), var(--blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            animation: fadeDown .6s ease;
        }

        /* ================= TABLE ================= */
        .table {
            border-radius: 12px;
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        /* --- FREEZE HEADER (STICKY TH) FIX --- */
        .table-responsive {
            border-radius: 12px;
            max-height: 70vh;
            overflow-y: auto;
            position: relative;
            /* Menjaga konteks scroll internal */
        }

        thead.thead-dark {
            position: sticky;
            top: 0;
            z-index: 30;
            /* Dipastikan paling atas */
        }

        thead.thead-dark th {
            position: sticky;
            top: 0;
            z-index: 30;
            /* Latar belakang solid agar teks di bawahnya 100% tertutup */
            background-color: #0f172a !important;
            background-image: linear-gradient(135deg, var(--navy), var(--blue)) !important;
            color: #ffffff !important;
            border: none;
            letter-spacing: .5px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.15);
            /* Bayangan pemisah header */
        }

        tbody tr {
            transition: .25s;
        }

        tbody tr:hover {
            background: #f8fbff;
            transform: scale(1.003);
        }

        /* ================= LINK ================= */
        a.text-primary {
            color: var(--blue) !important;
            font-weight: 600;
            transition: .25s;
        }

        a.text-primary:hover {
            color: var(--navy) !important;
            text-decoration: none;
        }

        /* ================= BADGE ================= */
        .badge {
            border-radius: 30px;
            padding: 7px 12px;
            font-weight: 500;
            transition: .2s;
        }

        .badge:hover {
            transform: scale(1.05);
        }

        /* KONTRAK BERJALAN */
        .badge-success {
            background: linear-gradient(135deg, #22c55e, #16a34a) !important;
            color: white !important;
        }

        /* KONTRAK TELAH BERAKHIR */
        .badge-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626) !important;
            color: white !important;
        }

        /* KONTRAK SELESAI */
        .badge-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
            color: white !important;
        }

        /* AKAN BERAKHIR */
        .badge-warning {
            background: linear-gradient(135deg, #ffc107, #ff9800) !important;
            color: #222 !important;
        }

        .badge-secondary {
            background: #64748b;
            color: white;
        }

        /* ================= DIVISI ================= */
        .badge-mro {
            background: linear-gradient(135deg, #b91c1c, #7f1d1d) !important;
            color: white !important;
        }

        .badge-wil1 {
            background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
            color: white !important;
        }

        .badge-wil2 {
            background: linear-gradient(135deg, #16a34a, #166534) !important;
            color: white !important;
        }

        /* ================= CURRENCY STYLING ================= */
        .currency-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4px 8px;
            border-radius: 6px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            font-family: 'Consolas', 'Courier New', monospace;
            font-size: 13px;
            white-space: nowrap;
        }

        .currency-symbol {
            color: #64748b;
            font-weight: 600;
            margin-right: 6px;
        }

        .currency-amount {
            color: #0f172a;
            font-weight: 700;
        }

        .currency-box.highlight-blue {
            background-color: #eff6ff;
            border-color: #bfdbfe;
        }

        .currency-box.highlight-blue .currency-amount {
            color: #1d4ed8;
        }

        .currency-box.highlight-green {
            background-color: #f0fdf4;
            border-color: #bbf7d0;
        }

        .currency-box.highlight-green .currency-amount {
            color: #15803d;
        }

        /* ================= PROGRESS ================= */
        .progress {
            height: 18px;
            border-radius: 30px;
            background: #dbeafe;
            overflow: hidden;
        }

        .progress-bar {
            font-size: 11px;
            font-weight: 600;
            animation: progressGrow 1s ease;
            box-shadow: inset 0 0 8px rgba(255, 255, 255, .35);
        }

        /* ================= BUTTON ================= */
        .btn-primary {
            background: linear-gradient(135deg, var(--blue), var(--navy));
            border: none;
            border-radius: 30px;
            font-weight: 600;
            padding: 8px 18px;
            box-shadow: 0 6px 16px rgba(37, 99, 235, .25);
            transition: .25s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, var(--navy), var(--blue));
            box-shadow: 0 10px 24px rgba(37, 99, 235, .35);
        }

        .btn-secondary {
            border-radius: 30px;
        }

        /* ================= INPUT ================= */
        .form-control {
            border-radius: 12px;
            border: 1px solid var(--border);
            transition: .25s;
        }

        .form-control:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .18);
            transform: scale(1.01);
        }

        /* ================= FILTER CARD ================= */
        .card .card-body {
            padding: 1.5rem;
        }

        /* ================= NOTE ================= */
        h6.text-danger {
            color: var(--navy) !important;
            font-weight: 700;
        }

        /* ================= PAGINATION ================= */
        .pagination .page-link {
            color: var(--blue);
            border-radius: 8px;
            margin: 0 2px;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, var(--blue), var(--navy));
            border: none;
        }

        /* ================= SCROLL ================= */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(var(--blue), var(--navy));
            border-radius: 10px;
        }

        /* ================= ANIMATION ================= */
        @keyframes fadeDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes progressGrow {
            from {
                width: 0;
            }
        }

        /* ================= DIVISI COLUMN ================= */
        .divisi-badge {
            display: inline-block;
            min-width: 90px;
            text-align: center;
        }

        /* ================= RESPONSIVE ================= */
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }

            .table {
                min-width: 1800px;
            }

            .btn-primary,
            .btn-secondary {
                margin-bottom: 5px;
            }
        }
    </style>


    <div class="container-fluid mt-4">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <h3>
                <b>Progress Divisi Wilayah</b>
            </h3>

            {{-- TOMBOL PRINT --}}
            <a href="{{ route('divisi.wilayah.progress.print', request()->query()) }}" target="_blank"
                class="btn btn-primary no-print">
                🖨️ Print Semua
            </a>

        </div>


        {{-- FLASH MESSAGE --}}
        @if (session('success'))
            <div class="alert alert-success no-print">
                {{ session('success') }}
            </div>
        @endif


        {{-- FILTER --}}
        <div class="card mb-3 no-print">
            <div class="card-body">
                <form method="GET" action="{{ route('divisi.wilayah.progress') }}">
                    <div class="form-row">

                        {{-- PO --}}
                        <div class="col-md-4 mb-2">
                            <input type="text" name="po" class="form-control" placeholder="Cari PO / Nota Dinas"
                                value="{{ request('po') }}">
                        </div>

                        {{-- PEKERJAAN --}}
                        <div class="col-md-4 mb-2">
                            <input type="text" name="pekerjaan" class="form-control" placeholder="Cari Nama Pekerjaan"
                                value="{{ request('pekerjaan') }}">
                        </div>

                        {{-- BUTTON --}}
                        <div class="col-md-4 mb-2">
                            <button class="btn btn-primary mr-2" type="submit">
                                🔍 Filter
                            </button>

                            <a href="{{ route('divisi.wilayah.progress') }}" class="btn btn-secondary">
                                🔄 Reset
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>


        {{-- TABLE --}}
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped mb-0">

                        <thead class="thead-dark text-center">
                            <tr>
                                <th width="40">No</th>
                                <th width="110">Divisi</th>
                                <th>PO / Nota Dinas</th>
                                <th>Nama Pekerjaan</th>
                                <th>Jenis Pekerjaan</th>
                                <th width="100">Tanggal Kontrak</th>
                                <th width="100">Selesai Kontrak</th>
                                <th width="160">Nilai Kontrak</th>
                                <th width="160">Realisasi Bulan Ini</th>
                                <th width="170">Total Realisasi s/d Bulan Ini</th>
                                <th>Status</th>
                                <th width="140">Progress</th>
                                <th>Keterangan Progress</th>
                                <th width="260">Status Dokumen Terakhir</th>
                                <th>Notifikasi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($monitorings as $index => $m)

                                @php
                                    // Class badge status
                                    $statusClass = match ($m->status) {
                                        'Open' => 'badge badge-warning',
                                        'Closed' => 'badge badge-success',
                                        'On Hold' => 'badge badge-danger',
                                        default => 'badge badge-secondary',
                                    };

                                    // Definisikan $divisiClass
                                    $divisiClass = match ($m->divisi) {
                                        'MRO' => 'badge-mro',
                                        'Wilayah 1' => 'badge-wil1',
                                        'Wilayah 2' => 'badge-wil2',
                                        default => 'badge-secondary',
                                    };

                                    // Dokumen terakhir secara umum
                                    $latestDoc = $m->documents->last();

                                    // 1. NILAI KONTRAK
                                    $nilaiKontrakDoc = $m->documents
                                        ->filter(fn($doc) => strtolower($doc->kriteria ?? '') === 'rencana')
                                        ->sum('harga');

                                    $nilaiKontrak =
                                        $nilaiKontrakDoc > 0
                                            ? $nilaiKontrakDoc
                                            : $m->nilai_kontrak ?? ($m->nilai_po ?? ($m->nilai ?? ($m->nominal ?? 0)));

                                    // 2. TOTAL REALISASI
                                    $realisasiDocs = $m->documents->filter(function ($doc) {
                                        $kriteria = strtolower($doc->kriteria ?? '');
                                        return ($kriteria === 'realisasi' || empty($kriteria)) &&
                                            !is_null($doc->harga) &&
                                            $doc->harga > 0;
                                    });

                                    $totalRealisasiDoc = $realisasiDocs->sum('harga');
                                    $totalRealisasi =
                                        $totalRealisasiDoc > 0
                                            ? $totalRealisasiDoc
                                            : $m->total_realisasi ?? ($m->realisasi ?? 0);

                                    // 3. REALISASI BULAN INI
                                    $groupedPriceDocs = $realisasiDocs
                                        ->groupBy(function ($doc) {
                                            $date = $doc->tanggal_closed ?? $doc->created_at;
                                            return \Carbon\Carbon::parse($date)->format('Y-m');
                                        })
                                        ->sortByDesc(function ($group, $key) {
                                            return $key;
                                        });

                                    $latestMonthGroup = $groupedPriceDocs->first();
                                    $latestPriceDoc = null;
                                    $realisasiBulanIni = 0;

                                    if ($latestMonthGroup) {
                                        $latestPriceDoc = $latestMonthGroup
                                            ->sortByDesc(function ($doc) {
                                                return $doc->created_at ?? $doc->id;
                                            })
                                            ->first();

                                        $realisasiBulanIni = $latestMonthGroup->sum('harga');
                                    }
                                @endphp

                                <tr>
                                    {{-- NO --}}
                                    <td class="text-center">
                                        {{ $monitorings->firstItem() + $index }}
                                    </td>

                                    {{-- DIVISI --}}
                                    <td class="text-center">
                                        <span class="badge {{ $divisiClass }} divisi-badge">
                                            @if ($m->divisi === 'MRO')
                                                🛠️ MRO
                                            @elseif ($m->divisi === 'Wilayah 1')
                                                🏢 Wilayah 1
                                            @else
                                                🏙️ Wilayah 2
                                            @endif
                                        </span>
                                    </td>

                                    {{-- PO / NOTA DINAS --}}
                                    <td>
                                        @php
                                            $userRole = Auth::user()->role;
                                            $divisi = $m->divisi;
                                            $po = $m->po_nota_dinas;
                                            $proyekId = $m->proyek_id;

                                            $targetRoute = match ($divisi) {
                                                'MRO' => route('monitoring.index', $proyekId),
                                                'Wilayah 1' => route('monitoringwil1.index', $proyekId),
                                                'Wilayah 2' => route('monitoringwil2.index', $proyekId),
                                                default => null,
                                            };

                                            $canClick = false;
                                            if ($userRole == 0) {
                                                $canClick = true;
                                            } elseif ($userRole == 14 && $divisi === 'MRO') {
                                                $canClick = true;
                                            } elseif (in_array($userRole, [2, 8]) && $divisi === 'Wilayah 1') {
                                                $canClick = true;
                                            } elseif (in_array($userRole, [3, 9]) && $divisi === 'Wilayah 2') {
                                                $canClick = true;
                                            }
                                        @endphp

                                        @if ($canClick && $targetRoute)
                                            <a href="{{ $targetRoute }}?po={{ urlencode(trim($po)) }}"
                                                class="text-primary font-weight-bold">
                                                {{ $po }}
                                            </a>
                                        @else
                                            <span class="font-weight-bold text-dark">
                                                {{ $po }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- NAMA PEKERJAAN --}}
                                    <td>
                                        {{ $m->nama_pekerjaan }}
                                    </td>

                                    {{-- JENIS PEKERJAAN --}}
                                    <td>
                                        {{ $m->jenis_pekerjaan ?? '-' }}
                                    </td>

                                    {{-- TANGGAL KONTRAK --}}
                                    <td class="text-center">
                                        @if ($m->tanggal_kontrak)
                                            {{ \Carbon\Carbon::parse($m->tanggal_kontrak)->format('d-m-Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    {{-- TANGGAL SELESAI --}}
                                    <td class="text-center">
                                        @if ($m->tanggal_selesai_kontrak)
                                            {{ \Carbon\Carbon::parse($m->tanggal_selesai_kontrak)->format('d-m-Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    {{-- NILAI KONTRAK --}}
                                    <td>
                                        <div class="currency-box">
                                            <span class="currency-symbol">Rp</span>
                                            <span
                                                class="currency-amount">{{ number_format((float) $nilaiKontrak, 0, ',', '.') }}</span>
                                        </div>
                                    </td>

                                    {{-- REALISASI BULAN INI --}}
                                    <td>
                                        <div class="currency-box highlight-blue">
                                            <span class="currency-symbol">Rp</span>
                                            <span
                                                class="currency-amount">{{ number_format((float) $realisasiBulanIni, 0, ',', '.') }}</span>
                                        </div>
                                    </td>

                                    {{-- TOTAL REALISASI S/D BULAN INI --}}
                                    <td>
                                        <div class="currency-box highlight-green">
                                            <span class="currency-symbol">Rp</span>
                                            <span
                                                class="currency-amount">{{ number_format((float) $totalRealisasi, 0, ',', '.') }}</span>
                                        </div>
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="text-center">
                                        <span class="{{ $statusClass }}">
                                            {{ $m->status ?? '-' }}
                                        </span>
                                    </td>

                                    {{-- PROGRESS --}}
                                    <td>
                                        @php
                                            $progress = is_numeric($m->progress)
                                                ? (float) $m->progress
                                                : (float) preg_replace('/[^0-9.]/', '', $m->progress ?? 0);

                                            $progress = max(0, min(100, $progress));
                                        @endphp

                                        <div class="progress">
                                            <div class="progress-bar"
                                                style="width: {{ $progress }}%; background-color: {{ method_exists($m, 'progressColor') ? $m->progressColor() : '#2563eb' }};">
                                                {{ number_format($progress, 0) }}%
                                            </div>
                                        </div>
                                    </td>

                                    {{-- KETERANGAN --}}
                                    <td>
                                        @php
                                            $text = trim($m->keterangan2 ?? ($m->keterangan ?? '-'));

                                            if (str_starts_with($text, '-')) {
                                                $lines = preg_split('/\r\n|\r|\n/', $text);
                                                echo implode('<br>', $lines);
                                            } else {
                                                $lines = preg_split('/\r\n|\r|\n/', $text);
                                                echo implode(', ', $lines);
                                            }
                                        @endphp
                                    </td>

                                    {{-- STATUS DOKUMEN TERAKHIR --}}
                                    <td>
                                        @if ($latestDoc)
                                            <div class="p-2 border rounded bg-light" style="font-size: 12px;">
                                                <div
                                                    class="font-weight-bold text-dark mb-1 d-flex justify-content-between align-items-center">
                                                    <span>
                                                        📄 <b>{{ $latestDoc->nama_dokumen }}</b>
                                                    </span>
                                                    @if ($latestDoc->file_path)
                                                        <a href="{{ asset($latestDoc->file_path) }}" target="_blank"
                                                            class="badge badge-primary">
                                                            Lihat
                                                        </a>
                                                    @endif
                                                </div>

                                                <div class="mb-1">
                                                    <b>Status:</b>
                                                    @if ($latestDoc->status == 'Closed')
                                                        <span class="badge badge-success p-1">🟢 OK</span>
                                                    @elseif ($latestDoc->status == 'Nok')
                                                        <span class="badge badge-danger p-1">🔴 NOK</span>
                                                    @else
                                                        <span class="badge badge-secondary p-1">-</span>
                                                    @endif
                                                </div>

                                                @if ($latestDoc->tanggal_closed)
                                                    <div class="text-muted small mb-1">
                                                        <b>Tanggal:</b>
                                                        {{ \Carbon\Carbon::parse($latestDoc->tanggal_closed)->format('d-m-Y') }}
                                                    </div>
                                                @endif

                                                @if ($latestDoc->keterangan_closed)
                                                    <div class="text-danger small font-weight-bold">
                                                        <b>Ket:</b> <span
                                                            style="color: #dc3545;">{{ $latestDoc->keterangan_closed }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted font-italic small">Belum ada dokumen</span>
                                        @endif
                                    </td>

                                    {{-- NOTIFIKASI --}}
                                    <td class="text-center">
                                        @if (method_exists($m, 'notifKontrak'))
                                            @php $notif = $m->notifKontrak(); @endphp
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
                                    <td colspan="15" class="text-center text-muted">
                                        Tidak ada data monitoring
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>


        {{-- CATATAN PROGRESS --}}
        <div class="card mt-3">
            <div class="card-body">
                <h6 class="font-weight-bold text-danger mb-3">
                    📌 Perhitungan Nilai Progress Monitoring
                </h6>

                <ul class="mb-0" style="line-height: 1.9;">
                    <li>
                        <b>Nota Dinas / SO / PO</b> =
                        <span class="badge badge-primary">30%</span>
                    </li>
                    <li>
                        <b>Memo</b> =
                        <span class="badge badge-primary">10%</span>
                    </li>
                    <li>
                        <b>Dokumen / Administrasi</b> =
                        <span class="badge badge-primary">60%</span>
                    </li>
                </ul>
            </div>
        </div>


        {{-- PAGINATION --}}
        <div class="mt-3 d-flex justify-content-center no-print">
            {{ $monitorings->links('pagination::bootstrap-4') }}
        </div>

    </div>


    {{-- ================= JS PRINT ================= --}}

    <script>
        function printPage() {
            window.print();
        }
    </script>

@endsection
