@extends('layouts.main')

@section('title', 'Progress Wilayah 1')
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
            --emerald: #059669;
            --emerald-light: #ecfdf5;
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

        /* ================= SUMMARY STAT CARD ================= */
        .summary-card {
            background: linear-gradient(135deg, #ffffff, var(--emerald-light));
            border-left: 5px solid var(--emerald);
            border-radius: 12px;
            padding: 1.25rem;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .summary-card .title {
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #475569;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .summary-card .value {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--emerald);
        }

        .summary-card .icon-box {
            width: 50px;
            height: 50px;
            background: rgba(5, 150, 105, 0.15);
            color: var(--emerald);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
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
            overflow: hidden;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        thead.thead-dark th {
            background: linear-gradient(135deg, var(--navy), var(--blue)) !important;
            color: white;
            border: none;
            letter-spacing: .5px;
        }

        tfoot.tfoot-summary th {
            background-color: #f1f5f9;
            color: var(--navy);
            font-size: 0.95rem;
            border-top: 2px solid #cbd5e1;
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
            transition: .22s;
        }

        .badge:hover {
            transform: scale(1.05);
        }

        .badge-success {
            background: linear-gradient(135deg, #22c55e, #16a34a) !important;
            color: white !important;
        }

        .badge-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626) !important;
            color: white !important;
        }

        .badge-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
            color: white !important;
        }

        .badge-warning {
            background: linear-gradient(135deg, #ffc107, #ff9800) !important;
            color: #222 !important;
        }

        .badge-secondary {
            background: #64748b;
            color: white;
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

        /* ================= TABLE CARD ================= */
        .table-responsive {
            border-radius: 12px;
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
    </style>

    <div class="container-fluid mt-4">

        {{-- CALCULATE TOTAL AKUMULASI DARI DATA HALAMAN INI --}}
        @php
            $grandTotalRealisasi = $monitorings->sum(function ($m) {
                return $m->documents->where('kriteria', 'Realisasi')->sum('harga');
            });
        @endphp

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3><b>Progress Wilayah 1</b></h3>

            {{-- TOMBOL PRINT --}}
            <a href="{{ route('monitoringwil1.print') }}" target="_blank" class="btn btn-primary no-print">
                🖨️ Print Semua
            </a>
        </div>

        {{-- SUMMARY CARD MODERN --}}
        <div class="row mb-3">
            <div class="col-md-5 col-lg-4">
                <div class="summary-card">
                    <div>
                        <div class="title">Total Akumulasi Realisasi</div>
                        <div class="value">Rp {{ number_format($grandTotalRealisasi, 0, ',', '.') }}</div>
                    </div>
                    <div class="icon-box">
                        💰
                    </div>
                </div>
            </div>
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
                <form method="GET" action="{{ route('monitoringwil1.resume_progress') }}">
                    <div class="form-row">
                        <div class="col-md-4 mb-2">
                            <input type="text" name="po" class="form-control" placeholder="Cari PO / Nota Dinas"
                                value="{{ request('po') }}">
                        </div>

                        <div class="col-md-4 mb-2">
                            <input type="text" name="pekerjaan" class="form-control" placeholder="Cari Nama Pekerjaan"
                                value="{{ request('pekerjaan') }}">
                        </div>

                        <div class="col-md-4 mb-2">
                            <button class="btn btn-primary mr-2" type="submit">
                                🔍 Filter
                            </button>

                            <a href="{{ route('monitoringwil1.resume_progress') }}" class="btn btn-secondary">
                                🔄 Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card shadow-sm">
            <div class="card-body table-responsive">

                <table class="table table-bordered table-hover table-striped mb-0">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th width="40">No</th>
                            <th>PO / Nota Dinas</th>
                            <th>Nama Pekerjaan</th>
                            <th>Tanggal Kontrak</th>
                            <th>Selesai Kontrak</th>
                            <th>Status</th>
                            <th width="140">Progress</th>
                            <th>Keterangan Progress</th>
                            <th width="200">Realisasi Bulan Ini</th>
                            <th width="180">Total Realisasi s/d Bulan Ini</th>
                            <th width="260">Status Dokumen Terakhir</th>
                            <th>Notifikasi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($monitorings as $index => $m)
                            @php
                                $statusClass = match ($m->status) {
                                    'Open' => 'badge badge-warning',
                                    'Closed' => 'badge badge-success',
                                    'On Hold' => 'badge badge-danger',
                                    default => 'badge badge-secondary',
                                };

                                // Dokumen terakhir secara umum
                                $latestDoc = $m->documents->last();

                                // Total Realisasi (Seluruh dokumen bernilai Realisasi)
                                $totalRealisasi = $m->documents->where('kriteria', 'Realisasi')->sum('harga');

                                // 1. Filter dokumen yang memiliki harga > 0
                                $groupedPriceDocs = $m->documents
                                    ->filter(fn($doc) => !is_null($doc->harga) && $doc->harga > 0)
                                    ->groupBy(function ($doc) {
                                        $date = $doc->tanggal_closed ?? $doc->created_at;
                                        return \Carbon\Carbon::parse($date)->format('Y-m');
                                    })
                                    ->sortByDesc(function ($group, $key) {
                                        return $key; // Urutkan berdasarkan kunci bulan paling baru (YYYY-MM)
                                    });

                                // 2. Ambil grup bulan terbaru
                                $latestMonthGroup = $groupedPriceDocs->first();

                                $latestPriceDoc = null;
                                $totalHargaBulanIni = 0;

                                if ($latestMonthGroup) {
                                    // Ambil sample dokumen terakhir di bulan tersebut untuk referensi atribut badge
                                    $latestPriceDoc = $latestMonthGroup
                                        ->sortByDesc(function ($doc) {
                                            return $doc->created_at ?? $doc->id;
                                        })
                                        ->first();

                                    // Jika kriteria dokumen terbaru adalah Realisasi, jumlahkan harga seluruh dokumen Realisasi di bulan tersebut
                                    if ($latestPriceDoc && $latestPriceDoc->kriteria == 'Realisasi') {
                                        $totalHargaBulanIni = $latestMonthGroup
                                            ->where('kriteria', 'Realisasi')
                                            ->sum('harga');
                                    } else {
                                        // Jika Rencana, gunakan harga dari dokumen rencana tersebut
                                        $totalHargaBulanIni = $latestPriceDoc->harga ?? 0;
                                    }
                                }
                            @endphp

                            <tr>
                                <td class="text-center">
                                    {{ $monitorings->firstItem() + $index }}
                                </td>

                                <td>
                                    @if (Auth::user()->role == 17)
                                        <span class="font-weight-bold text-dark">
                                            {{ $m->po_nota_dinas }}
                                        </span>
                                    @else
                                        <a href="{{ route('monitoringwil1.index', $m->proyek_id) }}?po={{ urlencode(trim($m->po_nota_dinas)) }}"
                                            class="text-primary font-weight-bold">
                                            {{ $m->po_nota_dinas }}
                                        </a>
                                    @endif
                                </td>

                                <td>{{ $m->nama_pekerjaan }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($m->tanggal_kontrak)->format('d-m-Y') }}
                                </td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($m->tanggal_selesai_kontrak)->format('d-m-Y') }}
                                </td>
                                <td class="text-center">
                                    <span class="{{ $statusClass }}">
                                        {{ $m->status }}
                                    </span>
                                </td>

                                {{-- PROGRESS BAR --}}
                                <td>
                                    <div class="progress" style="height: 18px;">
                                        <div class="progress-bar"
                                            style="width: {{ $m->progress }}%; background-color: {{ $m->progressColor() }};">
                                            {{ $m->progress }}%
                                        </div>
                                    </div>
                                </td>

                                {{-- KETERANGAN --}}
                                <td>
                                    @php
                                        $text = trim($m->keterangan2 ?? '-');

                                        if (str_starts_with($text, '-')) {
                                            $lines = preg_split('/\r\n|\r|\n/', $text);
                                            echo implode('<br>', $lines);
                                        } else {
                                            $lines = preg_split('/\r\n|\r|\n/', $text);
                                            echo implode(', ', $lines);
                                        }
                                    @endphp
                                </td>

                                {{-- REALISASI BULAN INI --}}
                                <td class="text-center">
                                    @if ($latestPriceDoc)
                                        <div class="p-2 border rounded bg-white shadow-sm">
                                            <div class="fw-bold text-dark fs-6">
                                                <b> Rp {{ number_format($totalHargaBulanIni, 0, ',', '.') }} </b>
                                            </div>

                                            <div
                                                class="mt-1 d-flex justify-content-center gap-1 align-items-center flex-wrap">
                                                @if ($latestPriceDoc->jenis_dokumen)
                                                    <span class="badge badge-secondary text-white" style="font-size: 10px;">
                                                        {{ $latestPriceDoc->jenis_dokumen }}
                                                    </span>
                                                @endif

                                                @if ($latestPriceDoc->tanggal_closed)
                                                    <span class="badge badge-info text-white" style="font-size: 10px;">
                                                        {{ \Carbon\Carbon::parse($latestPriceDoc->tanggal_closed)->isoFormat('MMM YYYY') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted font-italic small">-</span>
                                    @endif
                                </td>

                                {{-- TOTAL REALISASI S/D BULAN INI --}}
                                <td class="text-center">
                                    <div class="p-2 border rounded bg-white shadow-sm">
                                        <div class="fw-bold text-success fs-6">
                                            <b>Rp {{ number_format($totalRealisasi, 0, ',', '.') }}</b>
                                        </div>
                                    </div>
                                </td>

                                {{-- TABEL STATUS DOKUMEN TERAKHIR --}}
                                <td>
                                    @if ($latestDoc)
                                        <div class="p-2 border rounded bg-light" style="font-size: 12px;">
                                            <div
                                                class="fw-bold text-dark mb-1 d-flex justify-content-between align-items-center">
                                                <span>📄 <b>{{ $latestDoc->nama_dokumen }}</b></span>
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

                                <td class="text-center">
                                    @php
                                        $notif = $m->notifKontrak();
                                    @endphp

                                    <span class="badge badge-{{ $notif['class'] }}">
                                        {{ $notif['text'] }}
                                    </span>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="12" class="text-center text-muted">
                                    Tidak ada data monitoring Wilayah 1
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    {{-- FOOTER TABLE UNTUK PENJUMLAHAN --}}
                    @if ($monitorings->count() > 0)
                        <tfoot class="tfoot-summary">
                            <tr>
                                <th colspan="9" class="text-right font-weight-bold py-3">
                                    GRAND TOTAL REALISASI (HALAMAN INI):
                                </th>
                                <th class="text-center py-3">
                                    <div class="p-2 border rounded bg-success text-white shadow-sm">
                                        <b class="fs-6">Rp {{ number_format($grandTotalRealisasi, 0, ',', '.') }}</b>
                                    </div>
                                </th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    @endif
                </table>

            </div>
        </div>

        {{-- CATATAN PROGRESS --}}
        <div class="card mt-3">
            <div class="card-body">
                <h6 class="font-weight-bold text-danger mb-3">
                    📌 Perhitungan Nilai Progress Monitoring Wilayah 1
                </h6>

                <ul class="mb-0" style="line-height: 1.9;">
                    <li>
                        <b>SO / PO / KO</b>
                        = <span class="badge badge-primary">30%</span>
                    </li>

                    <li>
                        <b>Memo</b>
                        = <span class="badge badge-primary">10%</span>
                    </li>

                    <li>
                        <b>Dokumen / Administrasi</b>
                        = <span class="badge badge-primary">60%</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-3 d-flex justify-content-center no-print">
            {{ $monitorings->links('pagination::bootstrap-4') }}
        </div>

    </div>

    <script>
        function printPage() {
            window.print();
        }
    </script>

@endsection
