@extends('layouts.main')

@section('title', 'Progress Wilayah 2')
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

        /* ================= TABLE & STICKY HEADER ================= */
        .table {
            border-radius: 12px;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        /* FREEZE HEADER (STICKY TH) */
        thead.thead-dark th {
            position: sticky;
            top: 0;
            z-index: 10;
            background: var(--navy) !important;
            background: linear-gradient(135deg, var(--navy), var(--blue)) !important;
            color: white;
            border: none;
            letter-spacing: .5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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

        /* KONTRAK BERJALAN (HIJAU) */
        .badge-success {
            background: linear-gradient(135deg, #22c55e, #16a34a) !important;
            color: white !important;
        }

        /* KONTRAK TELAH BERAKHIR (MERAH) */
        .badge-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626) !important;
            color: white !important;
        }

        /* KONTRAK SELESAI (BIRU) */
        .badge-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
            color: white !important;
        }

        /* AKAN BERAKHIR H-7 (KUNING / ORANGE) */
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
            max-height: 80vh;
            overflow-y: auto;
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
    </style>

    {{-- HITUNG AKURAT UNTUK WILAYAH 2 (GLOBAL TANPA PAGINATE) --}}
    @php
        $countTotal = \App\Models\MonitoringWil2::count();
        $countInka = \App\Models\MonitoringWil2::whereRaw('LOWER(jenis_pekerjaan) = ?', ['inka'])->count();
        $countNonInka = \App\Models\MonitoringWil2::whereRaw('LOWER(jenis_pekerjaan) != ?', ['inka'])
            ->orWhereNull('jenis_pekerjaan')
            ->count();
    @endphp

    <div class="container-fluid mt-4">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3><b>Progress Wilayah 2</b></h3>

            {{-- TOMBOL PRINT --}}
            <a href="{{ route('monitoringwil2.print') }}" target="_blank" class="btn btn-primary no-print">
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

        {{-- FLASH MESSAGE --}}
        @if (session('success'))
            <div class="alert alert-success no-print">
                {{ session('success') }}
            </div>
        @endif

        {{-- FILTER --}}
        <div class="card mb-3 no-print">
            <div class="card-body">
                <form method="GET" action="{{ route('monitoringwil2.resume_progress') }}">
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

                            <a href="{{ route('monitoringwil2.resume_progress') }}" class="btn btn-secondary">
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
                                <th>PO / SO / Kontrak</th>
                                <th>Nama Pekerjaan</th>
                                <th>Jenis Pekerjaan</th>
                                <th>Tanggal Kontrak</th>
                                <th>Selesai Kontrak</th>
                                <th width="180">Nilai Kontrak/SO</th>
                                <th>Status</th>
                                <th width="140">Progress</th>
                                <th>Keterangan Progress</th>
                                <th width="200">Realisasi Bulan Ini</th>
                                <th width="180">Total Realisasi s/d Bulan Ini</th>
                                <th width="260">Status Dokumen Terakhir</th>
                                <th width="180">Nilai Persentase Kontrak Total Progres</th>
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

                                    $latestDoc = $m->documents->sortByDesc('id')->first();

                                    $totalNilaiKontrak = $m->documents->where('kriteria', 'Rencana')->sum('harga');
                                    $totalRealisasi = $m->documents
                                        ->whereIn('kriteria', ['Realisasi', 'Closed'])
                                        ->sum('harga');

                                    $groupedPriceDocs = $m->documents
                                        ->filter(function ($doc) {
                                            return $doc->kriteria === 'Realisasi' &&
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
                                    $totalHargaBulanIni = 0;

                                    if ($latestMonthGroup) {
                                        $latestPriceDoc = $latestMonthGroup
                                            ->sortByDesc(function ($doc) {
                                                return $doc->created_at ?? $doc->id;
                                            })
                                            ->first();

                                        $totalHargaBulanIni = $latestMonthGroup->sum('harga');
                                    }

                                    if ($latestDoc && $latestDoc->kriteria === 'Closed') {
                                        $totalHargaBulanIni = 0;
                                        $latestPriceDoc = null;
                                    }

                                    // =========================================================================
                                    // PENCARIAN & PERHITUNGAN PERSENTASE TOTAL PROGRESS WILAYAH 2
                                    // =========================================================================
                                    $proyekWil2 = \App\Models\PekerjaanWilayah2::where(
                                        'no_kontrak',
                                        'LIKE',
                                        '%' . trim($m->po_nota_dinas) . '%',
                                    )
                                        ->where('nama_proyek', 'LIKE', '%' . trim($m->nama_pekerjaan) . '%')
                                        ->first();

                                    $persentaseTotalProgres = 0;

                                    if ($proyekWil2 && $proyekWil2->items->count() > 0) {
                                        $tglMulaiItem = $m->tanggal_kontrak ?? null;
                                        $tglSelesaiItem = $m->tanggal_selesai_kontrak ?? null;

                                        $totalHargaGlobal = $proyekWil2->items->sum(function ($item) {
                                            return $item->harga_satuan ? $item->vol_rencana * $item->harga_satuan : 0;
                                        });
                                        $hasHargaGlobal = $proyekWil2->items->contains(function ($item) {
                                            return !empty($item->harga_satuan) && $item->harga_satuan > 0;
                                        });
                                        $totalItemCount = $proyekWil2->items->count();

                                        $startDateVal = $tglMulaiItem
                                            ? \Carbon\Carbon::parse($tglMulaiItem)->startOfDay()
                                            : now();
                                        $endDateVal = $tglSelesaiItem
                                            ? \Carbon\Carbon::parse($tglSelesaiItem)->startOfDay()
                                            : now();
                                        $diffDays = $startDateVal->diffInDays($endDateVal) + 1;
                                        $totalWeeksCalc = max(1, ceil($diffDays / 7));

                                        $sumSmpaiMingguIniPerMgg = array_fill(1, $totalWeeksCalc, 0);

                                        foreach ($proyekWil2->items as $item) {
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
                                    <td class="text-center">
                                        {{ $monitorings->firstItem() + $index }}
                                    </td>

                                    <td>
                                        @if (Auth::user()->role == 17)
                                            <span class="font-weight-bold text-dark">
                                                {{ $m->po_nota_dinas }}
                                            </span>
                                        @else
                                            <a href="{{ route('monitoringwil2.index', $m->proyek_id) }}?po={{ urlencode(trim($m->po_nota_dinas)) }}"
                                                class="text-primary font-weight-bold">
                                                {{ $m->po_nota_dinas }}
                                            </a>
                                        @endif
                                    </td>

                                    <td>{{ $m->nama_pekerjaan }}</td>

                                    <td>
                                        {{ $m->jenis_pekerjaan ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($m->tanggal_kontrak)->format('d-m-Y') }}
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($m->tanggal_selesai_kontrak)->format('d-m-Y') }}
                                    </td>

                                    <td class="text-center">
                                        <div class="p-2 border rounded bg-white shadow-sm">
                                            <div class="fw-bold text-dark fs-6">
                                                <b>Rp {{ number_format($totalNilaiKontrak, 0, ',', '.') }}</b>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <span class="{{ $statusClass }}">
                                            {{ $m->status }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="progress" style="height: 18px;">
                                            <div class="progress-bar"
                                                style="width: {{ $m->progress }}%; background-color: {{ $m->progressColor() }};">
                                                {{ $m->progress }}%
                                            </div>
                                        </div>
                                    </td>

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

                                    <td class="text-center">
                                        @if ($latestPriceDoc && $totalHargaBulanIni > 0)
                                            <div class="p-2 border rounded bg-white shadow-sm">
                                                <div class="fw-bold text-dark fs-6">
                                                    <b> Rp {{ number_format($totalHargaBulanIni, 0, ',', '.') }} </b>
                                                </div>

                                                <div
                                                    class="mt-1 d-flex justify-content-center gap-1 align-items-center flex-wrap">
                                                    @if ($latestPriceDoc->jenis_dokumen)
                                                        <span class="badge badge-secondary text-white"
                                                            style="font-size: 10px;">
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
                                            <span class="text-muted font-italic small">Rp 0</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="p-2 border rounded bg-white shadow-sm">
                                            <div class="fw-bold text-success fs-6">
                                                <b>Rp {{ number_format($totalRealisasi, 0, ',', '.') }}</b>
                                            </div>
                                        </div>
                                    </td>

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

                                    {{-- KOLOM: Nilai Persentase Kontrak Total Progres --}}
                                    <td class="text-center">
                                        <div class="p-2 border rounded bg-white shadow-sm">
                                            <div class="fw-bold text-info fs-6">
                                                <b>{{ number_format($persentaseTotalProgres, 2, ',', '.') }}%</b>
                                            </div>
                                        </div>
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
                                    <td colspan="15" class="text-center text-muted">
                                        Tidak ada data monitoring Wilayah 2
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
                    📌 Perhitungan Nilai Progress Monitoring Wilayah 2
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
                        <b>T1 s/d T12 (Tiap T bernilai 5%)</b>
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

    {{-- ================= JS PRINT ================= --}}
    <script>
        function printPage() {
            window.print();
        }
    </script>

@endsection
