@extends('layouts.main')

@section('title', 'Detail LP3M')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')

    <style>
        body {
            background: #f4f6f9;
        }

        .lp3m-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            animation: fadeIn 0.6s ease;
        }

        .lp3m-header {
            background: linear-gradient(135deg, #b30000, #ff4d4d);
            padding: 18px;
        }

        .lp3m-header h4 {
            font-weight: bold;
            letter-spacing: 1px;
        }

        .section-title {
            background: linear-gradient(90deg, #ffe5e5, #fff);
            border-left: 5px solid #dc3545;
            padding: 12px 15px;
            border-radius: 10px;
            font-weight: bold;
            color: #b30000;
            margin-bottom: 15px;
            margin-top: 25px;
            animation: slideIn 0.5s ease;
        }

        .info-box {
            background: white;
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            animation: fadeUp 0.6s ease;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            background: #fff3f3;
            color: #b30000;
            font-weight: bold;
            width: 250px;
        }

        .table td {
            background: #fff;
        }

        .table-hover tbody tr:hover {
            background: #fff0f0;
            transition: 0.3s;
        }

        .check-box {
            font-size: 18px;
            font-weight: bold;
            color: #dc3545;
            margin-right: 5px;
        }

        .badge-open {
            background: #dc3545;
            color: white;
            padding: 7px 14px;
            border-radius: 20px;
            font-size: 12px;
        }

        .badge-closed {
            background: #198754;
            color: white;
            padding: 7px 14px;
            border-radius: 20px;
            font-size: 12px;
        }

        .btn-modern {
            border-radius: 12px;
            padding: 10px 18px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* =========================
               RESPONSIVE MOBILE FIX
            ========================= */

        @media (max-width: 768px) {

            .container-fluid {
                padding-left: 8px;
                padding-right: 8px;
            }

            .card-body {
                padding: 12px;
            }

            .lp3m-header {
                padding: 14px 10px;
            }

            .lp3m-header h4 {
                font-size: 15px;
                line-height: 22px;
            }

            .section-title {
                font-size: 14px;
                padding: 10px;
            }

            .info-box {
                padding: 10px;
                border-radius: 12px;
            }

            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table {
                min-width: 600px;
            }

            .table th,
            .table td {
                font-size: 12px;
                padding: 8px;
                vertical-align: top;
                white-space: normal;
                word-break: break-word;
            }

            .table th {
                min-width: 140px;
            }

            .check-box {
                font-size: 15px;
            }

            .btn-modern {
                width: 100%;
                font-size: 13px;
                padding: 10px;
                border-radius: 10px;
            }

            .d-flex.gap-2 {
                gap: 8px !important;
            }

        }

        @media (max-width: 480px) {

            .lp3m-header h4 {
                font-size: 13px;
            }

            .section-title {
                font-size: 13px;
            }

            .table th,
            .table td {
                font-size: 11px;
                padding: 7px;
            }

            .check-box {
                font-size: 14px;
            }

        }

        .badge-open,
        .badge-closed {
            display: inline-block;
            min-width: 75px;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            padding: 7px 12px;
            border-radius: 12px;
        }

        @media(max-width:768px) {

            .table {
                min-width: unset !important;
            }

            .table th {
                width: 35%;
            }

        }
    </style>

    <div class="container-fluid mt-3 mb-4">

        <div class="card shadow-lg lp3m-card">

            {{-- HEADER --}}
            <div class="lp3m-header text-white">

                <h4 class="mb-0 text-center">

                    <i class="fas fa-tools"></i>
                    LAPORAN PEKERJAAN PERBAIKAN PERAWATAN

                </h4>

            </div>

            <div class="card-body">

                {{-- INFORMASI --}}
                <div class="info-box">

                    <div class="section-title">

                        <i class="fas fa-info-circle"></i>
                        Informasi Utama

                    </div>

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover">

                            {{-- <tr>

                            <th>Status</th>

                            <td>

                                @if ($data->status == 'OPEN')

                                    <span class="badge-open">
                                        OPEN
                                    </span>

                                @else

                                    <span class="badge-closed">
                                        CLOSED
                                    </span>

                                @endif

                            </td>

                            <th>SPR No.</th>

                            <td>{{ $data->spr_no }}</td>

                        </tr> --}}

                            <tr>

                                <th width="35%">
                                    Status
                                </th>

                                <td>

                                    @if ($data->status == 'OPEN')
                                        <span class="badge-open">
                                            OPEN
                                        </span>
                                    @else
                                        <span class="badge-closed">
                                            CLOSED
                                        </span>
                                    @endif

                                </td>

                            </tr>

                            <tr>

                                <th>
                                    SPR No.
                                </th>

                                <td style="word-break: break-word;">
                                    {{ $data->spr_no }}
                                </td>

                            </tr>

                            <tr>

                                <th>Hasil Pengukuran</th>

                                <td colspan="3">
                                    {{ $data->hasil_pengukuran }}
                                </td>

                            </tr>

                            <tr>

                                <th>Penyebab Kerusakan</th>

                                <td colspan="3">
                                    {{ $data->penyebab_kerusakan }}
                                </td>

                            </tr>

                        </table>

                    </div>

                </div>

                {{-- PENYEBAB --}}
                <div class="info-box mt-4">

                    <div class="section-title">

                        <i class="fas fa-exclamation-triangle"></i>
                        Penyebab Kerusakan

                    </div>

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover">

                            <tr>

                                <td>
                                    <span class="check-box">
                                        {!! $data->aus ? '☑' : '☐' !!}
                                    </span>
                                    Aus
                                </td>

                                <td>
                                    <span class="check-box">
                                        {!! $data->retak ? '☑' : '☐' !!}
                                    </span>
                                    Retak / Patah
                                </td>

                                <td>
                                    <span class="check-box">
                                        {!! $data->komponen_tak_berfungsi ? '☑' : '☐' !!}
                                    </span>
                                    Komponen Tak Berfungsi
                                </td>

                            </tr>

                            <tr>

                                <td>
                                    <span class="check-box">
                                        {!! $data->kelebihan_beban ? '☑' : '☐' !!}
                                    </span>
                                    Kelebihan Beban
                                </td>

                                <td>
                                    <span class="check-box">
                                        {!! $data->salah_operasi ? '☑' : '☐' !!}
                                    </span>
                                    Salah Operasi
                                </td>

                                <td>
                                    <span class="check-box">
                                        {!! $data->kelainan ? '☑' : '☐' !!}
                                    </span>
                                    Kelainan
                                </td>

                            </tr>

                            <tr>

                                <td>
                                    <span class="check-box">
                                        {!! $data->kecelakaan ? '☑' : '☐' !!}
                                    </span>
                                    Kecelakaan
                                </td>

                                <td colspan="2">
                                    <span class="check-box">
                                        {!! $data->lain_lain_kerusakan ? '☑' : '☐' !!}
                                    </span>
                                    Lain-lain
                                </td>

                            </tr>

                        </table>

                    </div>

                </div>

                {{-- PEKERJAAN --}}
                <div class="info-box mt-4">

                    <div class="section-title">

                        <i class="fas fa-user-cog"></i>
                        Eksekusi

                    </div>

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover">

                            <tr>

                                <th>Nama Teknisi</th>

                                <td>

                                    @php
                                        $teknisi = json_decode($data->nama, true);
                                    @endphp

                                    @if ($teknisi)

                                        @foreach ($teknisi as $t)
                                            • {{ $t }} <br>
                                        @endforeach
                                    @else
                                        -

                                    @endif

                                </td>

                            </tr>

                            <tr>

                                <th>Tanggal</th>

                                <td>
                                    {{ $data->tanggal ? \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') : '-' }}
                                </td>

                            </tr>

                            <tr>

                                <th>Jam Mulai</th>

                                <td>{{ $data->jam_mulai }}</td>

                            </tr>

                            <tr>

                                <th>Jam Selesai</th>

                                <td>{{ $data->jam_selesai }}</td>

                            </tr>

                            <tr>

                                <th>Pekerjaan</th>

                                <td>{{ $data->pekerjaan }}</td>

                            </tr>

                        </table>

                    </div>

                </div>

                {{-- TINDAKAN --}}
                <div class="info-box mt-4">

                    <div class="section-title">

                        <i class="fas fa-tools"></i>
                        Tindakan

                    </div>

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover">

                            <tr>

                                <td>
                                    <span class="check-box">
                                        {!! $data->komponen_diganti ? '☑' : '☐' !!}
                                    </span>
                                    Komponen Diganti
                                </td>

                                <td>
                                    <span class="check-box">
                                        {!! $data->diperiksa_disetel ? '☑' : '☐' !!}
                                    </span>
                                    Diperiksa dan Disetel
                                </td>

                                <td>
                                    <span class="check-box">
                                        {!! $data->diperbaiki_dibuat ? '☑' : '☐' !!}
                                    </span>
                                    Diperbaiki dengan dibuat
                                </td>

                            </tr>

                            <tr>

                                <td>
                                    <span class="check-box">
                                        {!! $data->dimodifikasi ? '☑' : '☐' !!}
                                    </span>
                                    Dimodifikasi
                                </td>

                                <td>
                                    <span class="check-box">
                                        {!! $data->dipindah_pasang_baru ? '☑' : '☐' !!}
                                    </span>
                                    Dipindah Pasang Baru
                                </td>

                                <td>
                                    <span class="check-box">
                                        {!! $data->diperlukan_evaluasi ? '☑' : '☐' !!}
                                    </span>
                                    Diperlukan Evaluasi
                                </td>

                            </tr>

                            <tr>

                                <td colspan="3">

                                    <span class="check-box">
                                        {!! $data->lain_lain_tindakan ? '☑' : '☐' !!}
                                    </span>

                                    Lain-lain

                                </td>

                            </tr>

                        </table>

                    </div>

                </div>

                {{-- SPAREPART --}}
                <div class="info-box mt-4">

                    <div class="section-title">

                        <i class="fas fa-box-open"></i>
                        Sparepart / Material

                    </div>

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover">

                            <tr>

                                <th>Nama Barang</th>

                                <td>{{ $data->nama_barang }}</td>

                            </tr>

                            <tr>

                                <th>Kode Barang</th>

                                <td>{{ $data->kode_barang }}</td>

                            </tr>

                            <tr>

                                <th>Jumlah</th>

                                <td>{{ $data->jumlah }}</td>

                            </tr>

                            <tr>

                                <th>Tanggal Penyelesaian</th>

                                <td>
                                    {{ $data->tanggal_selesai ? \Carbon\Carbon::parse($data->tanggal_selesai)->format('d-m-Y') : '-' }}
                                </td>

                            </tr>

                            <tr>

                                <th>Jam</th>

                                <td>{{ $data->jam_selesai_detail }}</td>

                            </tr>

                            <tr>

                                <th>Detail Penyelesaian</th>

                                <td>{{ $data->detail_penyelesaian }}</td>

                            </tr>

                        </table>

                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="mt-4 d-flex flex-column flex-md-row gap-2">

                    <a href="{{ route('lp3m.index') }}" class="btn btn-secondary btn-modern">

                        <i class="fas fa-arrow-left"></i>
                        Kembali

                    </a>

                    <a href="{{ route('lp3m.print', $data->id) }}" target="_blank" class="btn btn-danger btn-modern">

                        <i class="fas fa-print"></i>
                        Print

                    </a>

                </div>

            </div>

        </div>

    </div>

@endsection
