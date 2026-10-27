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
        }

        thead.thead-dark {
            position: sticky;
            top: 0;
            z-index: 30;
        }

        thead.thead-dark th {
            position: sticky;
            top: 0;
            z-index: 30;
            background-color: #0f172a !important;
            background-image: linear-gradient(135deg, var(--navy), var(--blue)) !important;
            color: #ffffff !important;
            border: none;
            letter-spacing: .5px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.15);
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

    {{-- HITUNG AKURAT GABUNGAN MRO, WILAYAH 1, DAN WILAYAH 2 (GLOBAL TANPA PAGINATE) --}}
    @php
        $totalMro = \App\Models\Monitoring::count();
        $totalWil1 = \App\Models\MonitoringWil1::count();
        $totalWil2 = \App\Models\MonitoringWil2::count();
        $countTotal = $totalMro + $totalWil1 + $totalWil2;

        $inkaMro = \App\Models\Monitoring::whereRaw('LOWER(jenis_pekerjaan) = ?', ['inka'])->count();
        $inkaWil1 = \App\Models\MonitoringWil1::whereRaw('LOWER(jenis_pekerjaan) = ?', ['inka'])->count();
        $inkaWil2 = \App\Models\MonitoringWil2::whereRaw('LOWER(jenis_pekerjaan) = ?', ['inka'])->count();
        $countInka = $inkaMro + $inkaWil1 + $inkaWil2;

        $nonInkaMro = \App\Models\Monitoring::whereRaw('LOWER(jenis_pekerjaan) != ?', ['inka'])
            ->orWhereNull('jenis_pekerjaan')
            ->count();
        $nonInkaWil1 = \App\Models\MonitoringWil1::whereRaw('LOWER(jenis_pekerjaan) != ?', ['inka'])
            ->orWhereNull('jenis_pekerjaan')
            ->count();
        $nonInkaWil2 = \App\Models\MonitoringWil2::whereRaw('LOWER(jenis_pekerjaan) != ?', ['inka'])
            ->orWhereNull('jenis_pekerjaan')
            ->count();
        $countNonInka = $nonInkaMro + $nonInkaWil1 + $nonInkaWil2;
    @endphp


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

        {{-- KARTU RINGKASAN STATISTIK --}}
        <div class="row mb-4 no-print">
            <!-- Total Semua Data -->
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100"
                    style="border-left: 5px solid var(--blue) !important; border-radius: 12px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="mr-3 text-primary" style="font-size: 2rem;">📊</div>
                        <div>
                            <h6 class="text-muted mb-1 font-weight-bold" style="font-size: 13px;">TOTAL SEMUA PEKERJAAN</h6>
                            <h3 class="mb-0 font-weight-bold text-dark"
                                style="-webkit-text-fill-color: initial; background: none;">
                                {{ number_format($countTotal, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jumlah Pekerjaan INKA -->
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100"
                    style="border-left: 5px solid #22c55e !important; border-radius: 12px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="mr-3 text-success" style="font-size: 2rem;">🚂</div>
                        <div>
                            <h6 class="text-muted mb-1 font-weight-bold" style="font-size: 13px;">JUMLAH PEKERJAAN INKA</h6>
                            <h3 class="mb-0 font-weight-bold text-success"
                                style="-webkit-text-fill-color: initial; background: none;">
                                {{ number_format($countInka, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jumlah Pekerjaan Non INKA -->
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100"
                    style="border-left: 5px solid #f59e0b !important; border-radius: 12px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="mr-3 text-warning" style="font-size: 2rem;">🏢</div>
                        <div>
                            <h6 class="text-muted mb-1 font-weight-bold" style="font-size: 13px;">JUMLAH PEKERJAAN NON INKA
                            </h6>
                            <h3 class="mb-0 font-weight-bold text-dark"
                                style="-webkit-text-fill-color: initial; background: none;">
                                {{ number_format($countNonInka, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php
            // --- FUNGSIONALITAS KALKULASI TOTAL REALISASI PER DIVISI & JENIS PEKERJAAN ---

            // 1. Helper function untuk menghitung Total Realisasi per Model & Jenis
            $calcRealisasi = function ($modelClass, $isInka = true) {
                return $modelClass
                    ::whereHas('documents', function ($q) {
                        $q->whereIn(\DB::raw('LOWER(kriteria)'), ['realisasi', 'closed'])
                            ->whereNotNull('harga')
                            ->where('harga', '>', 0);
                    })
                    ->get()
                    ->sum(function ($item) use ($isInka) {
                        $jenis = strtolower($item->jenis_pekerjaan ?? '');
                        $match = $isInka ? $jenis === 'inka' : $jenis !== 'inka';
                        if (!$match) {
                            return 0;
                        }

                        $sumDocs = $item->documents
                            ->filter(function ($d) {
                                return in_array(strtolower($d->kriteria ?? ''), ['realisasi', 'closed']) &&
                                    $d->harga > 0;
                            })
                            ->sum('harga');

                        return $sumDocs > 0 ? $sumDocs : $item->total_realisasi ?? ($item->realisasi ?? 0);
                    });
            };

            // Wilayah 1
            $realisasiWil1Inka = $calcRealisasi(\App\Models\MonitoringWil1::class, true);
            $realisasiWil1NonInka = $calcRealisasi(\App\Models\MonitoringWil1::class, false);
            $totalWil1 = $realisasiWil1Inka + $realisasiWil1NonInka;

            // Wilayah 2
            $realisasiWil2Inka = $calcRealisasi(\App\Models\MonitoringWil2::class, true);
            $realisasiWil2NonInka = $calcRealisasi(\App\Models\MonitoringWil2::class, false);
            $totalWil2 = $realisasiWil2Inka + $realisasiWil2NonInka;

            // MRO
            $realisasiMroInka = $calcRealisasi(\App\Models\Monitoring::class, true);
            $realisasiMroNonInka = $calcRealisasi(\App\Models\Monitoring::class, false);
            $totalMro = $realisasiMroInka + $realisasiMroNonInka;

            // Total Grand Realisasi
            $grandTotalInka = $realisasiWil1Inka + $realisasiWil2Inka + $realisasiMroInka;
            $grandTotalNonInka = $realisasiWil1NonInka + $realisasiWil2NonInka + $realisasiMroNonInka;
            $grandTotalAll = $grandTotalInka + $grandTotalNonInka;
        @endphp

        <!-- ================= SECTION REALISASI S/D BULAN INI ================= -->
        <div class="mb-4 no-print">
            <div class="d-flex align-items-center mb-3">
                <h5 class="font-weight-bold text-dark mb-0">
                    💰 Realisasi Nilai Pekerjaan s/d Bulan Ini
                </h5>
            </div>

            <!-- GRAND TOTAL HIGHLIGHT (RINGKASAN UTAMA) -->
            <div class="row mb-3">
                <div class="col-md-4 mb-2">
                    <div class="card border-0 shadow-sm text-white"
                        style="background: linear-gradient(135deg, #0f172a, #1e293b); border-radius: 12px;">
                        <div class="card-body p-3 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-uppercase font-weight-bold text-light"
                                    style="font-size: 11px; letter-spacing: 0.5px;">
                                    TOTAL REALISASI KESELURUHAN
                                </div>
                                <h4 class="font-weight-bold mb-0 text-white mt-1">
                                    Rp {{ number_format($grandTotalAll, 0, ',', '.') }}
                                </h4>
                            </div>
                            <div style="font-size: 2rem; opacity: 0.8;">🌐</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-2">
                    <div class="card border-0 shadow-sm text-white"
                        style="background: linear-gradient(135deg, #2563eb, #1d4ed8); border-radius: 12px;">
                        <div class="card-body p-3 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-uppercase font-weight-bold text-light"
                                    style="font-size: 11px; letter-spacing: 0.5px;">
                                    TOTAL REALISASI (INKA)
                                </div>
                                <h4 class="font-weight-bold mb-0 text-white mt-1">
                                    Rp {{ number_format($grandTotalInka, 0, ',', '.') }}
                                </h4>
                            </div>
                            <div style="font-size: 2rem; opacity: 0.8;">🚂</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-2">
                    <div class="card border-0 shadow-sm text-white"
                        style="background: linear-gradient(135deg, #d97706, #b45309); border-radius: 12px;">
                        <div class="card-body p-3 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-uppercase font-weight-bold text-light"
                                    style="font-size: 11px; letter-spacing: 0.5px;">
                                    TOTAL REALISASI (NON INKA)
                                </div>
                                <h4 class="font-weight-bold mb-0 text-white mt-1">
                                    Rp {{ number_format($grandTotalNonInka, 0, ',', '.') }}
                                </h4>
                            </div>
                            <div style="font-size: 2rem; opacity: 0.8;">🏢</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RINCIAN PER DIVISI (WILAYAH 1, WILAYAH 2, MRO) -->
            <div class="row">
                <!-- WILAYAH 1 -->
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm h-100"
                        style="border-radius: 12px; border-top: 4px solid #2563eb !important;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge badge-primary px-3 py-2" style="font-size: 13px;">🏢 Wilayah 1</span>
                                <span class="text-muted font-weight-bold small">Total: Rp
                                    {{ number_format($totalWil1, 0, ',', '.') }}</span>
                            </div>
                            <div class="p-2 mb-2 rounded" style="background: #eff6ff;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold text-secondary" style="font-size: 12px;">🚂 INKA</span>
                                    <span class="font-weight-bold text-primary">Rp
                                        {{ number_format($realisasiWil1Inka, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="p-2 rounded" style="background: #fffbeb;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold text-secondary" style="font-size: 12px;">🏢 NON
                                        INKA</span>
                                    <span class="font-weight-bold text-warning" style="color: #d97706 !important;">Rp
                                        {{ number_format($realisasiWil1NonInka, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- WILAYAH 2 -->
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm h-100"
                        style="border-radius: 12px; border-top: 4px solid #16a34a !important;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge badge-success px-3 py-2"
                                    style="font-size: 13px; background: linear-gradient(135deg, #16a34a, #166534) !important;">🏙️
                                    Wilayah 2</span>
                                <span class="text-muted font-weight-bold small">Total: Rp
                                    {{ number_format($totalWil2, 0, ',', '.') }}</span>
                            </div>
                            <div class="p-2 mb-2 rounded" style="background: #eff6ff;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold text-secondary" style="font-size: 12px;">🚂 INKA</span>
                                    <span class="font-weight-bold text-primary">Rp
                                        {{ number_format($realisasiWil2Inka, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="p-2 rounded" style="background: #fffbeb;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold text-secondary" style="font-size: 12px;">🏢 NON
                                        INKA</span>
                                    <span class="font-weight-bold text-warning" style="color: #d97706 !important;">Rp
                                        {{ number_format($realisasiWil2NonInka, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MRO -->
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm h-100"
                        style="border-radius: 12px; border-top: 4px solid #b91c1c !important;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge badge-danger px-3 py-2"
                                    style="font-size: 13px; background: linear-gradient(135deg, #b91c1c, #7f1d1d) !important;">🛠️
                                    MRO</span>
                                <span class="text-muted font-weight-bold small">Total: Rp
                                    {{ number_format($totalMro, 0, ',', '.') }}</span>
                            </div>
                            <div class="p-2 mb-2 rounded" style="background: #eff6ff;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold text-secondary" style="font-size: 12px;">🚂 INKA</span>
                                    <span class="font-weight-bold text-primary">Rp
                                        {{ number_format($realisasiMroInka, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="p-2 rounded" style="background: #fffbeb;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold text-secondary" style="font-size: 12px;">🏢 NON
                                        INKA</span>
                                    <span class="font-weight-bold text-warning" style="color: #d97706 !important;">Rp
                                        {{ number_format($realisasiMroNonInka, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
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
                <form method="GET" action="{{ route('divisi.wilayah.progress') }}">
                    <div class="form-row">

                        {{-- PO --}}
                        <div class="col-md-4 mb-2">
                            <input type="text" name="po" class="form-control" placeholder="Cari PO / Nota Dinas"
                                value="{{ request('po') }}">
                        </div>

                        {{-- PEKERJAAN --}}
                        <div class="col-md-4 mb-2">
                            <input type="text" name="pekerjaan" class="form-control"
                                placeholder="Cari Nama Pekerjaan" value="{{ request('pekerjaan') }}">
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
                                <th>PO / SO / Kontrak</th>
                                <th>Nama Pekerjaan</th>
                                <th>Jenis Pekerjaan</th>
                                <th width="100">Tanggal Kontrak</th>
                                <th width="100">Selesai Kontrak</th>
                                <th width="160">Nilai Kontrak/SO</th>
                                <th width="160">Realisasi Bulan Ini</th>
                                <th width="170">Total Realisasi s/d Bulan Ini</th>
                                <th>Status</th>
                                <th width="140">Progress</th>
                                <th>Keterangan Progress</th>
                                <th width="260">Status Dokumen Terakhir</th>
                                <th width="180">Nilai Persentase Kontrak Total Progres</th>
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

                                    // Class badge divisi
                                    $divisiClass = match ($m->divisi) {
                                        'MRO' => 'badge-mro',
                                        'Wilayah 1' => 'badge-wil1',
                                        'Wilayah 2' => 'badge-wil2',
                                        default => 'badge-secondary',
                                    };

                                    // 1. Ambil dokumen PALING BARU berdasarkan ID
                                    $latestDoc = $m->documents->sortByDesc('id')->first();

                                    // 2. NILAI KONTRAK (RENCANA)
                                    $nilaiKontrakDoc = $m->documents
                                        ->filter(fn($doc) => strtolower($doc->kriteria ?? '') === 'rencana')
                                        ->sum('harga');

                                    $nilaiKontrak =
                                        $nilaiKontrakDoc > 0
                                            ? $nilaiKontrakDoc
                                            : $m->nilai_kontrak ?? ($m->nilai_po ?? ($m->nilai ?? ($m->nominal ?? 0)));

                                    // 3. TOTAL REALISASI (Termasuk 'Realisasi' dan 'Closed')
                                    $realisasiDocs = $m->documents->filter(function ($doc) {
                                        $kriteria = strtolower($doc->kriteria ?? '');
                                        return in_array($kriteria, ['realisasi', 'closed']) &&
                                            !is_null($doc->harga) &&
                                            $doc->harga > 0;
                                    });

                                    $totalRealisasiDoc = $realisasiDocs->sum('harga');
                                    $totalRealisasi =
                                        $totalRealisasiDoc > 0
                                            ? $totalRealisasiDoc
                                            : $m->total_realisasi ?? ($m->realisasi ?? 0);

                                    // 4. REALISASI BULAN INI (Hanya dokumen berkriteria 'Realisasi')
                                    $groupedPriceDocs = $m->documents
                                        ->filter(function ($doc) {
                                            return strtolower($doc->kriteria ?? '') === 'realisasi' &&
                                                !is_null($doc->harga) &&
                                                $doc->harga > 0;
                                        })
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

                                    // 5. PENYESUAIAN KRITERIA CLOSED:
                                    if ($latestDoc && strtolower($latestDoc->kriteria ?? '') === 'closed') {
                                        $realisasiBulanIni = 0;
                                        $latestPriceDoc = null;
                                    }

                                    // =========================================================================
                                    // 6. PERHITUNGAN DINAMIS PERSENTASE TOTAL PROGRES PEKERJAAN DENGAN MATCHING MODEL
                                    // =========================================================================
                                    $persentaseTotalProgres = 0;
                                    $proyekModel = null;

                                    if ($m->divisi === 'MRO') {
                                        $proyekModel = \App\Models\PekerjaanMro::where(
                                            'no_kontrak',
                                            'LIKE',
                                            '%' . trim($m->po_nota_dinas) . '%',
                                        )
                                            ->where('nama_proyek', 'LIKE', '%' . trim($m->nama_pekerjaan) . '%')
                                            ->first();
                                    } elseif ($m->divisi === 'Wilayah 1') {
                                        $proyekModel = \App\Models\PekerjaanWilayah1::where(
                                            'no_kontrak',
                                            'LIKE',
                                            '%' . trim($m->po_nota_dinas) . '%',
                                        )
                                            ->where('nama_proyek', 'LIKE', '%' . trim($m->nama_pekerjaan) . '%')
                                            ->first();
                                    } elseif ($m->divisi === 'Wilayah 2') {
                                        $proyekModel = \App\Models\PekerjaanWilayah2::where(
                                            'no_kontrak',
                                            'LIKE',
                                            '%' . trim($m->po_nota_dinas) . '%',
                                        )
                                            ->where('nama_proyek', 'LIKE', '%' . trim($m->nama_pekerjaan) . '%')
                                            ->first();
                                    }

                                    if ($proyekModel && $proyekModel->items->count() > 0) {
                                        $tglMulaiItem = $m->tanggal_kontrak ?? null;
                                        $tglSelesaiItem = $m->tanggal_selesai_kontrak ?? null;

                                        $totalHargaGlobal = $proyekModel->items->sum(function ($item) {
                                            return $item->harga_satuan ? $item->vol_rencana * $item->harga_satuan : 0;
                                        });
                                        $hasHargaGlobal = $proyekModel->items->contains(function ($item) {
                                            return !empty($item->harga_satuan) && $item->harga_satuan > 0;
                                        });
                                        $totalItemCount = $proyekModel->items->count();

                                        $startDateVal = $tglMulaiItem
                                            ? \Carbon\Carbon::parse($tglMulaiItem)->startOfDay()
                                            : now();
                                        $endDateVal = $tglSelesaiItem
                                            ? \Carbon\Carbon::parse($tglSelesaiItem)->startOfDay()
                                            : now();
                                        $diffDays = $startDateVal->diffInDays($endDateVal) + 1;
                                        $totalWeeksCalc = max(1, ceil($diffDays / 7));

                                        $sumSmpaiMingguIniPerMgg = array_fill(1, $totalWeeksCalc, 0);

                                        foreach ($proyekModel->items as $item) {
                                            $bobotRencana = 0;
                                            if ($totalHargaGlobal > 0) {
                                                $jumlahItem = $item->harga_satuan
                                                    ? $item->vol_rencana * $item->harga_satuan
                                                    : 0;
                                                $bobotRencana = ($jumlahItem / $totalHargaGlobal) * 100;
                                            }

                                            $progressMingguanData = $item->progress_mingguan ?? [];
                                            $smpaiMingguIniAcc = 0;

                                            for ($w = 1; $w <= $totalWeeksCalc; $w++) {
                                                $volRealisasi = $progressMingguanData[$w]['vol'] ?? '';
                                                $progMingguIni = 0;

                                                if ($item->vol_rencana > 0 && is_numeric($volRealisasi)) {
                                                    if ($item->harga_satuan) {
                                                        $progMingguIni =
                                                            ($bobotRencana * $volRealisasi) / $item->vol_rencana;
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
                                            if ($hasHargaGlobal) {
                                                $persentaseTotalProgres = $sumSmpaiMingguIniPerMgg[$wLast] ?? 0;
                                            } else {
                                                $persentaseTotalProgres =
                                                    $totalItemCount > 0
                                                        ? ($sumSmpaiMingguIniPerMgg[$wLast] ?? 0) / $totalItemCount
                                                        : 0;
                                            }
                                        }
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
                                        @if ($latestPriceDoc && $realisasiBulanIni > 0)
                                            <div class="currency-box highlight-blue">
                                                <span class="currency-symbol">Rp</span>
                                                <span
                                                    class="currency-amount">{{ number_format((float) $realisasiBulanIni, 0, ',', '.') }}</span>
                                            </div>
                                        @else
                                            <div class="currency-box">
                                                <span class="currency-symbol">Rp</span>
                                                <span class="currency-amount">0</span>
                                            </div>
                                        @endif
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

                                    {{-- KOLOM: Nilai Persentase Kontrak Total Progres (Dinamis per Divisi) --}}
                                    <td class="text-center">
                                        @php
                                            $targetProgresRoute = match ($m->divisi) {
                                                'MRO' => route('pekerjaanmro.index'),
                                                'Wilayah 1' => route('pekerjaanwil1.index'),
                                                'Wilayah 2' => route('pekerjaanwil2.index'),
                                                default => null,
                                            };
                                        @endphp

                                        @if ($proyekModel && $targetProgresRoute)
                                            <a href="{{ $targetProgresRoute }}?search={{ urlencode(trim($m->po_nota_dinas)) }}" 
                                               class="text-decoration-none d-block" 
                                               title="Klik untuk melihat Rincian Pekerjaan {{ $m->divisi }}">
                                                <div class="p-2 border rounded bg-white shadow-sm transition-hover">
                                                    <div class="fw-bold text-info fs-6">
                                                        <b>{{ number_format($persentaseTotalProgres, 2, ',', '.') }}%</b>
                                                    </div>
                                                </div>
                                            </a>
                                        @else
                                            <div class="p-2 border rounded bg-white shadow-sm">
                                                <div class="fw-bold text-info fs-6">
                                                    <b>{{ number_format($persentaseTotalProgres, 2, ',', '.') }}%</b>
                                                </div>
                                            </div>
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
                                    <td colspan="16" class="text-center text-muted">
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
        <div class="row g-3 mt-3">
            <!-- Kolom Kiri: Wilayah 1 & 2 -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h6 class="font-weight-bold text-danger mb-3">
                            📌 Perhitungan Nilai Progress - Wilayah 1 & 2
                        </h6>
                        <ul class="mb-0" style="line-height: 1.9;">
                            <li>
                                <b>SO / PO / KO</b> =
                                <span class="badge bg-primary">30%</span>
                            </li>
                            <li>
                                <b>Memo</b> =
                                <span class="badge bg-primary">10%</span>
                            </li>
                            <li>
                                <b>T1 s/d T12 (Tiap T bernilai 5%)</b> =
                                <span class="badge bg-primary">60%</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: MRO -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h6 class="font-weight-bold text-danger mb-3">
                            📌 Perhitungan Nilai Progress - MRO
                        </h6>
                        <ul class="mb-0" style="line-height: 1.9;">
                            <li>
                                <b>SO / PO / KO</b> =
                                <span class="badge bg-primary">30%</span>
                            </li>
                            <li>
                                <b>Memo</b> =
                                <span class="badge bg-primary">10%</span>
                            </li>
                            <li>
                                <b>Dokumen / Administrasi</b> =
                                <span class="badge bg-primary">60%</span>
                            </li>
                        </ul>
                    </div>
                </div>
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
