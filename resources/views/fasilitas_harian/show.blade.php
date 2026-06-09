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
    </style>

    <div class="container-fluid mt-3">

        <div class="card matrix-card">

            <div class="matrix-header">

                <div class="d-flex justify-content-between align-items-center">

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

                    <div>

                        <a href="{{ route('fasilitas.print', $checksheet->id) }}" target="_blank" class="btn btn-light">

                            🖨 Print PDF

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
                        X = Rusak / SPR
                    </span>

                    <span class="badge-o">
                        O = Tidak Operasi
                    </span>

                </div>

                <div class="table-wrapper">

                    <table class="table table-bordered matrix-table">

                        <thead>

                            <tr>

                                <th width="70">
                                    No
                                </th>

                                <th width="300">
                                    Uraian Pekerjaan
                                </th>

                                <th width="350">
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

                                            $result = $item->results->where('tanggal', $tanggalCari)->first();

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
