@extends('layouts.main')

@section('content')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <style>
        /* =====================================================
               🔴 MODERN RED UI
            ===================================================== */

        :root {

            --red-main: #dc3545;
            --red-dark: #8b1e2d;
            --red-soft: #fff5f6;
            --red-border: #f3c8cf;

        }

        .card {

            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);

            animation: fadeUp .5s ease;

        }

        .card-header {

            background: linear-gradient(135deg,
                    var(--red-main),
                    var(--red-dark)) !important;

            padding: 18px 22px;

        }

        .card-header h5 {

            font-weight: 700;
            letter-spacing: .5px;

        }

        /* =====================================================
               FILTER
            ===================================================== */

        .form-control {

            border-radius: 12px;
            border: 1px solid #ddd;
            height: 45px;

        }

        .btn-primary {

            background: var(--red-main);
            border: none;
            border-radius: 12px;
            height: 45px;
            font-weight: 600;
            transition: .3s;

        }

        .btn-primary:hover {

            transform: translateY(-2px);
            background: var(--red-dark);

        }

        /* =====================================================
               TABLE
            ===================================================== */

        .table-rekap {

            min-width: 1200px;

        }

        .table-rekap td,
        .table-rekap th {

            font-size: 12px;
            text-align: center;
            vertical-align: middle;
            padding: 6px;
            white-space: nowrap;

        }

        .table-rekap thead th {

            background: var(--red-main);
            color: white;
            border-color: #fff;

        }

        .table-rekap tbody tr {

            transition: .2s;

        }

        .table-rekap tbody tr:hover {

            background: #fff8f8;
            transform: scale(1.002);

        }

        .nama-col {

            min-width: 220px;
            text-align: left !important;
            font-weight: 600;

            position: sticky;
            left: 0;

            background: white;
            z-index: 5;

        }

        /* =====================================================
               BADGE LEGEND
            ===================================================== */

        .legend-box {

            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;

        }

        .legend-item {

            padding: 7px 14px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;

            animation: fadeUp .5s ease;

        }

        /* =====================================================
               NOTE AREA
            ===================================================== */

        .note-box {

            background: var(--red-soft);
            border: 1px solid var(--red-border);
            border-radius: 16px;
            padding: 18px;
            margin-top: 20px;

            animation: fadeUp .7s ease;

        }

        .note-box h5 {

            font-size: 16px;
            font-weight: 700;
            color: var(--red-dark);

        }

        .note-box h6 {

            font-size: 13px;
            font-weight: 700;

        }

        .note-box p,
        .note-box li,
        .note-box td,
        .note-box th {

            font-size: 12px;

        }

        .note-table th {

            background: #ffe5e8;

        }

        /* =====================================================
               ANIMATION
            ===================================================== */

        @keyframes fadeUp {

            from {

                opacity: 0;
                transform: translateY(20px);

            }

            to {

                opacity: 1;
                transform: translateY(0);

            }

        }

        /* =====================================================
               MOBILE
            ===================================================== */

        @media(max-width:768px) {

            .card-header h5 {

                font-size: 16px;

            }

            .table-rekap td,
            .table-rekap th {

                font-size: 10px;
                padding: 4px;

            }

            .nama-col {

                min-width: 140px;

            }

            .form-control,
            .btn-primary {

                height: 40px;
                font-size: 12px;

            }

            .legend-item {

                font-size: 10px;

            }

        }


        /* =====================================================
           SISA CUTI BADGE
        ===================================================== */

        .sisa-badge {

            display: inline-block;
            min-width: 38px;

            padding: 7px 12px;

            border-radius: 30px;

            font-size: 13px;
            font-weight: 700;

            color: white;

            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);

            animation: pulse 2s infinite;

        }

        .sisa-badge.success {

            background: linear-gradient(135deg,
                    #28a745,
                    #1e7e34);

        }

        .sisa-badge.warning {

            background: linear-gradient(135deg,
                    #ffc107,
                    #e0a800);

            color: black;

        }

        .sisa-badge.danger {

            background: linear-gradient(135deg,
                    #dc3545,
                    #8b1e2d);

        }

        @keyframes pulse {

            0% {

                transform: scale(1);

            }

            50% {

                transform: scale(1.05);

            }

            100% {

                transform: scale(1);

            }

        }
    </style>

    <div class="container-fluid">

        <div class="card shadow">

            <div class="card-header text-white">

                <h5 class="mb-0">

                    <i class="fas fa-calendar-alt"></i>

                    REKAP CUTI BULANAN

                </h5>

            </div>

            <div class="card-body">

                {{-- FILTER --}}
                <form method="GET">

                    <div class="row mb-3">

                        <div class="col-md-2 mb-2">

                            <select name="bulan" class="form-control">

                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>

                                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}

                                    </option>
                                @endfor

                            </select>

                        </div>

                        <div class="col-md-2 mb-2">

                            <input type="number" name="tahun" class="form-control" value="{{ $tahun }}">

                        </div>

                        <div class="col-md-2 mb-2">

                            <button class="btn btn-primary w-100">

                                <i class="fas fa-search"></i>

                                FILTER

                            </button>

                        </div>

                    </div>

                </form>

                {{-- LEGEND --}}
                <div class="legend-box">

                    <div class="legend-item" style="background:#7CFC00">

                        CT = CUTI TAHUNAN

                    </div>

                    <div class="legend-item" style="background:#87CEFA">

                        CS = CUTI SAKIT

                    </div>

                    <div class="legend-item" style="background:yellow">

                        CP = CUTI PENTING

                    </div>

                    <div class="legend-item" style="background:#DDA0DD">

                        CB = CUTI BESAR

                    </div>

                </div>

                {{-- TABLE --}}
                <div class="table-responsive">

                    <table class="table table-bordered table-rekap">

                        <thead>

                            <tr>

                                <th rowspan="2">NO</th>

                                <th rowspan="2">NAMA</th>

                                <th colspan="{{ $jumlahHari }}">

                                    {{ strtoupper(date('F', mktime(0, 0, 0, $bulan, 1))) }}

                                </th>

                                <th rowspan="2">
                                    JUMLAH
                                </th>

                                <th rowspan="2">
                                    SISA
                                </th>

                            </tr>

                            <tr>

                                @for ($d = 1; $d <= $jumlahHari; $d++)
                                    <th>{{ $d }}</th>
                                @endfor

                            </tr>

                        </thead>

                        <tbody>

                            {{-- @foreach ($pegawai as $key => $p)
                                @php $totalCT = 0; @endphp

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td class="nama-col">

                                        {{ $p->name }}
                                        

                                    </td>

                                    @for ($d = 1; $d <= $jumlahHari; $d++)
                                        @php

                                            $tanggal =
                                                $tahun .
                                                '-' .
                                                str_pad($bulan, 2, '0', STR_PAD_LEFT) .
                                                '-' .
                                                str_pad($d, 2, '0', STR_PAD_LEFT);

                                            $cutiData = $cuti->first(function ($c) use ($p, $tanggal) {
                                                return $c->user_id == $p->id &&
                                                    $tanggal >= $c->tanggal_mulai &&
                                                    $tanggal <= $c->tanggal_selesai;
                                            });

                                            $warna = '';
                                            $text = '';

                                            if ($cutiData) {
                                                $text = $cutiData->jenis;

                                                if ($cutiData->jenis == 'CT') {
                                                    $warna = '#7CFC00';
                                                    $totalCT++;
                                                } elseif ($cutiData->jenis == 'CS') {
                                                    $warna = '#87CEFA';
                                                } elseif ($cutiData->jenis == 'CP') {
                                                    $warna = 'yellow';
                                                } elseif ($cutiData->jenis == 'CB') {
                                                    $warna = '#DDA0DD';
                                                }
                                            }

                                        @endphp

                                        <td style="background:{{ $warna }}">

                                            {{ $text }}

                                        </td>
                                    @endfor

                                    <td>

                                        <b>{{ $totalCT }}</b>

                                    </td>

                                    @php

                                        $cutiTahunan = $cuti->filter(function ($c) use ($p, $tahun, $bulan) {
                                            $tglMulai = \Carbon\Carbon::parse($c->tanggal_mulai);

                                            return $c->user_id == $p->id &&
                                                $c->jenis == 'CT' &&
                                                $tglMulai->year == $tahun &&
                                                $tglMulai->month <= $bulan;
                                        });

                                        $totalTahunan = 0;

                                        foreach ($cutiTahunan as $ct) {
                                            $totalTahunan += $ct->jumlah_hari;
                                        }

                                        $masterCuti = \App\Models\CutiTahunan::where('user_id', $p->id)
                                            ->where('tahun', $tahun)
                                            ->first();

                                        $jatahTahunan =
                                            ($masterCuti->jatah ?? 0) +
                                            ($masterCuti->carry_over ?? 0) +
                                            ($masterCuti->tambahan ?? 0) -
                                            ($masterCuti->pengurangan ?? 0);

                                        $sisaCuti = $jatahTahunan - $totalTahunan;
                                    @endphp

                                    <td>

                                        @if ($sisaCuti <= 2)
                                            <span class="sisa-badge danger">

                                                {{ $sisaCuti }}

                                            </span>
                                        @elseif($sisaCuti <= 5)
                                            <span class="sisa-badge warning">

                                                {{ $sisaCuti }}

                                            </span>
                                        @else
                                            <span class="sisa-badge success">

                                                {{ $sisaCuti }}

                                            </span>
                                        @endif

                                    </td>

                                </tr>
                            @endforeach --}}

                            @foreach ($pegawai as $key => $p)
                                @php $totalCT = 0; @endphp

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td class="nama-col">

                                        {{ $p->nama_pegawai }}

                                    </td>

                                    @for ($d = 1; $d <= $jumlahHari; $d++)
                                        @php

                                            $tanggal =
                                                $tahun .
                                                '-' .
                                                str_pad($bulan, 2, '0', STR_PAD_LEFT) .
                                                '-' .
                                                str_pad($d, 2, '0', STR_PAD_LEFT);

                                            $cutiData = $cuti->first(function ($c) use ($p, $tanggal) {
                                                return $c->nama_pegawai == $p->nama_pegawai &&
                                                    $tanggal >= $c->tanggal_mulai &&
                                                    $tanggal <= $c->tanggal_selesai;
                                            });

                                            $warna = '';
                                            $text = '';

                                            if ($cutiData) {
                                                $text = $cutiData->jenis;

                                                if ($cutiData->jenis == 'CT') {
                                                    $warna = '#7CFC00';
                                                    $totalCT++;
                                                } elseif ($cutiData->jenis == 'CS') {
                                                    $warna = '#87CEFA';
                                                } elseif ($cutiData->jenis == 'CP') {
                                                    $warna = 'yellow';
                                                } elseif ($cutiData->jenis == 'CB') {
                                                    $warna = '#DDA0DD';
                                                }
                                            }

                                        @endphp

                                        <td style="background:{{ $warna }}">

                                            {{ $text }}

                                        </td>
                                    @endfor

                                    <td>

                                        <b>{{ $totalCT }}</b>

                                    </td>

                                    @php

                                        $cutiTahunan = $cuti->filter(function ($c) use ($p, $tahun, $bulan) {
                                            $tglMulai = \Carbon\Carbon::parse($c->tanggal_mulai);

                                            return $c->nama_pegawai == $p->nama_pegawai &&
                                                $c->jenis == 'CT' &&
                                                $tglMulai->year == $tahun &&
                                                $tglMulai->month <= $bulan;
                                        });

                                        $totalTahunan = 0;

                                        foreach ($cutiTahunan as $ct) {
                                            $totalTahunan += $ct->jumlah_hari;
                                        }

                                        $masterCuti = \App\Models\CutiTahunan::where('nama_pegawai', $p->nama_pegawai)
                                            ->where('tahun', $tahun)
                                            ->first();

                                        $jatahTahunan =
                                            ($masterCuti->jatah ?? 0) +
                                            ($masterCuti->carry_over ?? 0) +
                                            ($masterCuti->tambahan ?? 0) -
                                            ($masterCuti->pengurangan ?? 0);

                                        $sisaCuti = $jatahTahunan - $totalTahunan;
                                    @endphp

                                    <td>

                                        @if ($sisaCuti <= 2)
                                            <span class="sisa-badge danger">

                                                {{ $sisaCuti }}

                                            </span>
                                        @elseif($sisaCuti <= 5)
                                            <span class="sisa-badge warning">

                                                {{ $sisaCuti }}

                                            </span>
                                        @else
                                            <span class="sisa-badge success">

                                                {{ $sisaCuti }}

                                            </span>
                                        @endif

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

                {{-- NOTE --}}
                <div class="note-box">

                    <h5>

                        <i class="fas fa-info-circle"></i>

                        NOTE CUTI

                    </h5>

                    <hr>

                    <h6>

                        Yang Mengurangi Jumlah Cuti Tahunan :

                    </h6>

                    <ol class="mb-3">

                        <li>Cuti Tahunan (CT)</li>

                        <li>Cuti Sakit tanpa Surat Dokter (<b>langsung mengambil Cuti Tahunan</b>)</li>

                    </ol>

                    <h6>

                        *Cuti Sakit (CS) dengan surat dokter tidak mengurangi jatah cuti tahunan.

                    </h6>

                    <h6>

                        Cuti Penting :

                    </h6>

                    <p>

                        Perusahaan memberikan ijin tidak masuk kerja
                        kepada Karyawan dengan tetap mendapat gaji
                        dan tunjangan secara penuh <b>tanpa mengurangi
                        hak Cuti Tahunan</b>.

                    </p>

                    <div class="table-responsive">

                        <table class="table table-bordered table-sm note-table">

                            <thead>

                                <tr>

                                    <th>No</th>
                                    <th>Keterangan</th>
                                    <th>Hak</th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr>
                                    <td>1</td>
                                    <td>Karyawan menikah</td>
                                    <td>3 Hari</td>
                                </tr>

                                <tr>
                                    <td>2</td>
                                    <td>Khitan / Baptis anak</td>
                                    <td>2 Hari</td>
                                </tr>

                                <tr>
                                    <td>3</td>
                                    <td>Isteri melahirkan</td>
                                    <td>3 Hari</td>
                                </tr>

                                <tr>
                                    <td>4</td>
                                    <td>Pernikahan anak</td>
                                    <td>2 Hari</td>
                                </tr>

                                <tr>
                                    <td>5</td>
                                    <td>Keluarga meninggal dunia</td>
                                    <td>2 Hari</td>
                                </tr>

                                <tr>
                                    <td>6</td>
                                    <td>Menjadi wali nikah</td>
                                    <td>1 Hari</td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
