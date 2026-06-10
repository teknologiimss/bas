@extends('layouts.main')

@section('title', 'Matrix Checksheet Harian Fasilitas')

@section('content')

    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

    <style>
        body {
            background: #f5f6fa;
        }

        .matrix-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .08);
        }

        .matrix-header {
            background: linear-gradient(135deg, #b30000, #ff2d2d);
            color: white;
            padding: 20px;
        }

        .table-wrapper {
            overflow: auto;
            max-height: 80vh;
        }

        .matrix-table {
            white-space: nowrap;
            min-width: 1800px;
        }

        .matrix-table th {
            background: #b30000;
            color: white;
            text-align: center;
            vertical-align: middle;
            position: sticky;
            top: 0;
            z-index: 10;
            font-size: 12px;
        }

        .matrix-table td {
            text-align: center;
            vertical-align: middle;
            font-size: 12px;
        }

        .left-col {
            position: sticky;
            left: 0;
            background: white;
            z-index: 5;
            min-width: 70px;
        }

        .left-col-2 {
            position: sticky;
            left: 70px;
            background: white;
            z-index: 5;
            min-width: 280px;
        }

        .left-col-3 {
            position: sticky;
            left: 350px;
            background: white;
            z-index: 5;
            min-width: 350px;
        }

        /* ==========================
               FREEZE HEADER + KOLOM
            ========================== */

        .header-freeze {
            position: sticky !important;
            top: 0;
            background: #b30000 !important;
            color: white !important;
        }

        /* Header No */
        th.left-col {
            left: 0;
            z-index: 30 !important;
        }

        /* Header Uraian */
        th.left-col-2 {
            left: 70px;
            z-index: 29 !important;
        }

        /* Header Aktivitas */
        th.left-col-3 {
            left: 350px;
            z-index: 28 !important;
        }

        /* Isi tabel */
        td.left-col {
            z-index: 20;
        }

        td.left-col-2 {
            z-index: 19;
        }

        td.left-col-3 {
            z-index: 18;
        }

        .legend {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .legend span {
            padding: 6px 12px;
            border-radius: 10px;
            color: white;
            font-size: 12px;
        }

        .badge-v {
            background: #198754;
        }

        .badge-x {
            background: #dc3545;
        }

        .badge-o {
            background: #ffc107;
            color: black !important;
        }


        /* Tampilan Hp  */
        /* ==========================
                                       MOBILE RESPONSIVE
                                    ========================== */
        @media (max-width: 768px) {

            .matrix-header .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .matrix-header h4 {
                font-size: 18px;
            }

            .matrix-header .btn {
                width: 100%;
                margin-top: 8px;
            }

            .table-wrapper {
                max-height: 65vh;
                overflow: auto;
                -webkit-overflow-scrolling: touch;
            }

            .matrix-table {
                min-width: 1200px;
                font-size: 11px;
            }

            .matrix-table th,
            .matrix-table td {
                padding: 4px;
                font-size: 11px;
            }

            .left-col {
                min-width: 50px;
                font-size: 11px;
            }

            .left-col-2 {
                left: 50px;
                min-width: 180px;
                font-size: 11px;
            }

            .left-col-3 {
                left: 230px;
                min-width: 220px;
                font-size: 11px;
            }

            .legend {
                gap: 6px;
            }

            .legend span {
                font-size: 10px;
                padding: 5px 8px;
            }

            .header-responsive {
                flex-direction: column;
                align-items: stretch;
            }

            .header-responsive .action-btn {
                display: flex;
                flex-direction: column;
                gap: 10px;
                width: 100%;
            }

            .header-responsive .action-btn .btn {
                width: 100%;
            }

            /* Freeze */
            /* ==========================
           MOBILE TANPA FREEZE
        ========================== */

            /* MATIKAN SEMUA STICKY DI HP */
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

            .matrix-table th {
                position: static !important;
            }

            .table-wrapper {
                overflow-x: auto;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
                max-height: 70vh;
            }

            .matrix-table {
                min-width: 1200px;
            }

            .matrix-table th,
            .matrix-table td {
                font-size: 11px;
                padding: 4px;
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
