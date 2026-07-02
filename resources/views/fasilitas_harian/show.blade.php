@extends('layouts.main')

@section('title', 'Matrix Checksheet Harian Fasilitas')

@section('content')

    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

    <style>
        body {
            background: #eef3f9;
            font-family: 'Segoe UI', sans-serif;
        }

        /* ===========================
            CARD
    =========================== */

        .matrix-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .12);
        }

        /* ===========================
            HEADER
    =========================== */

        .matrix-header {

            background: linear-gradient(135deg, #0f172a, #1e3a8a, #2563eb);

            color: white;

            padding: 25px;

            box-shadow: 0 8px 25px rgba(30, 58, 138, .25);

        }

        .matrix-header h4 {

            font-weight: 700;

            margin-bottom: 8px;

        }

        .matrix-header .btn {

            border-radius: 12px;

            font-weight: 600;

        }

        /* ===========================
            TABLE
    =========================== */

        .table-wrapper {

            overflow: auto;

            max-height: 80vh;

            border-radius: 15px;

        }

        .matrix-table {

            white-space: nowrap;

            min-width: 1800px;

            margin-bottom: 0;

        }

        .matrix-table th {

            background: linear-gradient(135deg, #0f172a, #1e3a8a);

            color: white;

            text-align: center;

            vertical-align: middle;

            position: sticky;

            top: 0;

            z-index: 10;

            font-size: 12px;

            border: 1px solid #23395d;

        }

        .matrix-table td {

            text-align: center;

            vertical-align: middle;

            font-size: 12px;

            background: #fff;

            border: 1px solid #dee2e6;

        }

        .matrix-table tbody tr:nth-child(even) {

            background: #f8fbff;

        }

        .matrix-table tbody tr:hover td {

            background: #eef5ff;

        }

        /* ===========================
            FREEZE COLUMN
    =========================== */

        .left-col {

            position: sticky;

            left: 0;

            background: #fff;

            z-index: 5;

            min-width: 70px;

            font-weight: 700;

        }

        .left-col-2 {

            position: sticky;

            left: 70px;

            background: #fff;

            z-index: 5;

            min-width: 280px;

            text-align: left;

        }

        .left-col-3 {

            position: sticky;

            left: 350px;

            background: #fff;

            z-index: 5;

            min-width: 350px;

            text-align: left;

        }

        /* Freeze Header */

        .header-freeze {

            position: sticky !important;

            top: 0;

            background: linear-gradient(135deg, #0f172a, #1e3a8a) !important;

            color: #fff !important;

        }

        th.left-col {

            left: 0;

            z-index: 30 !important;

        }

        th.left-col-2 {

            left: 70px;

            z-index: 29 !important;

        }

        th.left-col-3 {

            left: 350px;

            z-index: 28 !important;

        }

        td.left-col {

            z-index: 20;

        }

        td.left-col-2 {

            z-index: 19;

        }

        td.left-col-3 {

            z-index: 18;

        }

        /* ===========================
            BADGE STATUS
    =========================== */

        .badge {

            font-size: 12px;

            padding: 6px 10px;

            border-radius: 8px;

        }

        .bg-success {

            background: #16a34a !important;

        }

        .bg-danger {

            background: #dc2626 !important;

        }

        .bg-warning {

            background: #facc15 !important;

            color: #111827 !important;

        }

        /* ===========================
            LEGEND
    =========================== */

        .legend {

            display: flex;

            gap: 12px;

            flex-wrap: wrap;

        }

        .legend span {

            padding: 8px 15px;

            border-radius: 12px;

            color: white;

            font-size: 12px;

            font-weight: 600;

            box-shadow: 0 3px 10px rgba(0, 0, 0, .08);

        }

        .badge-v {

            background: #16a34a;

        }

        .badge-x {

            background: #dc2626;

        }

        .badge-o {

            background: #facc15;

            color: #111827 !important;

        }

        /* ===========================
            BUTTON
    =========================== */

        .btn-light {

            background: #fff;

            border: none;

            color: #1e3a8a;

        }

        .btn-light:hover {

            background: #eef5ff;

        }

        .btn-outline-light {

            border: 1px solid rgba(255, 255, 255, .6);

            color: #fff;

        }

        .btn-outline-light:hover {

            background: #fff;

            color: #1e3a8a;

        }

        /* ===========================
            MOBILE
    =========================== */

        @media(max-width:768px) {

            .matrix-header {

                padding: 18px;

            }

            .matrix-header h4 {

                font-size: 20px;

            }

            .header-responsive {

                display: flex;

                flex-direction: column;

                gap: 15px;

            }

            .action-btn {

                display: flex;

                flex-direction: column;

                gap: 10px;

            }

            .action-btn .btn {

                width: 100%;

            }

            .table-wrapper {

                overflow: auto;

                max-height: 70vh;

                -webkit-overflow-scrolling: touch;

            }

            .matrix-table {

                min-width: 1200px;

            }

            .matrix-table th,

            .matrix-table td {

                font-size: 11px;

                padding: 5px;

            }

            .left-col,

            .left-col-2,

            .left-col-3,

            .header-freeze,

            th.left-col,

            th.left-col-2,

            th.left-col-3 {

                position: static !important;

                left: auto !important;

                top: auto !important;

                z-index: auto !important;

            }

        }
    </style>

    <div class="container-fluid mt-3">

        <div class="card matrix-card">

            <div class="matrix-header">

                {{-- <div class="d-flex justify-content-between align-items-center"> --}}
                <div class="header-responsive">

                    <div>

                        <h4 class="mb-2">
                            {{ $checksheet->judul }}
                        </h4>

                        <div>
                            Lokasi :
                            {{ $checksheet->lokasi }}
                        </div>

                        <div>
                            Bulan :
                            {{ $checksheet->bulan }}
                            {{ $checksheet->tahun }}
                        </div>

                    </div>

                    <div class="action-btn">

                        <a href="{{ route('fasilitas-harian.index') }}" class="btn btn-outline-light">

                            <i class="fas fa-arrow-left"></i>
                            Kembali

                        </a>

                        <a href="{{ route('fasilitas.print', $checksheet->id) }}" target="_blank" class="btn btn-light">

                            <i class="fas fa-print"></i>
                            Print PDF

                        </a>

                    </div>

                </div>

            </div>

            <div class="card-body">

                <div class="legend mb-3">

                    <span class="badge-v">
                        V = Bagus
                    </span>

                    <span class="badge-x">
                        X = Jelek di TL dengan SPR
                    </span>

                    <span class="badge-o">
                        O = Bagus, Tetapi Tidak Operasi
                    </span>

                </div>

                <div class="table-wrapper">

                    <table class="table table-bordered matrix-table">

                        <thead>

                            <tr>

                                <th width="70" class="left-col header-freeze">
                                    No
                                </th>

                                <th width="300" class="left-col-2 header-freeze">
                                    Uraian Pekerjaan
                                </th>

                                <th width="350" class="left-col-3 header-freeze">
                                    Aktivitas Pekerjaan
                                </th>

                                @for ($hari = 1; $hari <= $jumlahHari; $hari++)
                                    <th>
                                        {{ $hari }}
                                    </th>
                                @endfor

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($checksheet->items as $item)

                                <tr>

                                    <td class="left-col">
                                        {{ $item->nomor }}
                                    </td>

                                    <td class="left-col-2 text-start">
                                        {{ $item->uraian_pekerjaan }}
                                    </td>

                                    <td class="left-col-3 text-start">
                                        {{-- {{ $item->aktivitas_pekerjaan }} --}}
                                        @foreach ($item->aktivitas as $a)
                                            • {{ $a->aktivitas }}

                                            <br>
                                        @endforeach
                                    </td>

                                    @for ($tgl = 1; $tgl <= $jumlahHari; $tgl++)
                                        @php

                                            $tanggalCari = sprintf(
                                                '%04d-%02d-%02d',
                                                $checksheet->tahun,
                                                $bulanAngka,
                                                $tgl,
                                            );

                                            $result = $item->results->first(function ($r) use ($tanggalCari) {
                                                return $r->tanggal->format('Y-m-d') == $tanggalCari;
                                            });

                                        @endphp

                                        <td>

                                            @if ($result)
                                                @if ($result->status == 'V')
                                                    <span class="badge bg-success">
                                                        V
                                                    </span>
                                                @elseif($result->status == 'X')
                                                    <span class="badge bg-danger">
                                                        X
                                                    </span>
                                                @elseif($result->status == 'O')
                                                    <span class="badge bg-warning text-dark">
                                                        O
                                                    </span>
                                                @endif
                                            @endif

                                        </td>
                                    @endfor

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="{{ $jumlahHari + 3 }}">

                                        Belum ada item checksheet

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection
