@extends('layouts.main')

@section('title', 'Progress MRO')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    {{-- <style>
        /* ================= GLOBAL ================= */
        body {
            background-color: #f5f6f8;
        }

        h3 {
            color: #dc3545;
            letter-spacing: 0.5px;
        }

        /* ================= CARD ================= */
        .card {
            border: none;
            border-radius: 12px;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* ================= TABLE ================= */
        table {
            font-size: 13px;
        }

        thead.thead-dark th {
            background-color: #dc3545 !important;
            color: #fff !important;
            border: none;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        tbody tr {
            transition: background 0.2s ease;
        }

        tbody tr:hover {
            background-color: #fff0f0;
        }

        /* ================= BADGE ================= */
        .badge {
            padding: 6px 10px;
            font-size: 11px;
            border-radius: 20px;
            letter-spacing: 0.3px;
        }

        .badge-warning {
            background-color: #ffccd2;
            color: #721c24;
        }

        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-danger {
            background-color: #dc3545;
            color: #fff;
        }

        /* ================= PROGRESS ================= */
        .progress {
            background-color: #f1f1f1;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar {
            font-size: 11px;
            font-weight: 600;
            transition: width 0.6s ease;
        }

        /* ================= LINK ================= */
        a.text-primary {
            color: #dc3545 !important;
        }

        a.text-primary:hover {
            text-decoration: underline;
        }

        /* ================= BUTTON ================= */
        .btn-primary {
            background-color: #dc3545;
            border-color: #dc3545;
            border-radius: 20px;
            padding: 6px 16px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #bd2130;
            border-color: #bd2130;
        }

        /* ================= PRINT ================= */
        @media print {
            body {
                background-color: #fff !important;
            }

            thead.thead-dark th {
                background-color: #dc3545 !important;
                color: #fff !important;
            }
        }
    </style> --}}

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
            overflow: hidden;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        thead.thead-dark th {
            background: linear-gradient(135deg,
                    var(--navy),
                    var(--blue)) !important;
            color: white;
            border: none;
            letter-spacing: .5px;
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

        .badge-warning {
            background: linear-gradient(135deg, #ffc107, #ff9800);
            color: #222;
        }

        .badge-success {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
        }

        .badge-danger {
            background: linear-gradient(135deg, #2563eb, #0f172a);
            color: white;
        }

        .badge-secondary {
            background: #64748b;
            color: white;
        }

        .badge-primary {
            background: linear-gradient(135deg, #2563eb, #0f172a);
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

            background: linear-gradient(135deg,
                    var(--blue),
                    var(--navy));

            border: none;
            border-radius: 30px;
            font-weight: 600;
            padding: 8px 18px;

            box-shadow: 0 6px 16px rgba(37, 99, 235, .25);

            transition: .25s;
        }

        .btn-primary:hover {

            transform: translateY(-2px);

            background: linear-gradient(135deg,
                    var(--navy),
                    var(--blue));

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

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3><b>Progress MRO</b></h3>

            {{-- TOMBOL PRINT --}}
            <a href="{{ route('mro.progress.print') }}" target="_blank" class="btn btn-primary no-print">
                🖨 Print Semua
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
                <form method="GET" action="{{ route('mro.progress.index') }}">
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

                            <a href="{{ route('mro.progress.index') }}" class="btn btn-secondary">
                                ♻ Reset
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>



        {{-- TABLE --}}
        <div class="card shadow-sm">
            <div class="card-body table-responsive">

                <table class="table table-bordered table-hover table-striped">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th width="50">No</th>
                            <th>PO / Nota Dinas</th>
                            <th>Nama Pekerjaan</th>
                            <th>Tanggal Kontrak</th>
                            <th>Selesai Kontrak</th>
                            <th>Status</th>
                            <th width="180">Progress</th>
                            <th>Keterangan Progress</th>
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
                            @endphp

                            <tr>
                                <td class="text-center">
                                    {{ $monitorings->firstItem() + $index }}
                                </td>

                                {{-- Klik PO/Nodin Spesifik ke Halaman Monitoring --}}
                                {{-- <td>
                                    <a href="{{ route('monitoring.index', $m->proyek_id) }}?po={{ urlencode(trim($m->po_nota_dinas)) }}"
                                        class="text-primary font-weight-bold">
                                        {{ $m->po_nota_dinas }}
                                    </a>
                                </td> --}}

                                <td>

                                    @if (Auth::user()->role == 17)
                                        <span class="font-weight-bold text-dark">
                                            {{ $m->po_nota_dinas }}
                                        </span>
                                    @else
                                        <a href="{{ route('monitoring.index', $m->proyek_id) }}?po={{ urlencode(trim($m->po_nota_dinas)) }}"
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


                                {{-- <td>
                                    <div class="progress" style="height: 18px;">
                                        <div class="progress-bar {{ $m->progressColor() }}"
                                            style="width: {{ $m->progress }}%">
                                            {{ $m->progress }}%
                                        </div>
                                    </div>
                                </td> --}}
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
                                <td colspan="8" class="text-center text-muted">
                                    Tidak ada data monitoring
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

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
                        <b>Nota Dinas / PO / Purchase Order</b>
                        = <span class="badge badge-primary">30%</span>
                    </li>

                    <li>
                        <b>Purchase Request / PR / SPP</b>
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

    {{-- ================= JS PRINT ================= --}}
    <script>
        function printPage() {
            window.print();
        }
    </script>

@endsection
