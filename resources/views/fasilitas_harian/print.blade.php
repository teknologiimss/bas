<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>
        Checksheet Harian Fasilitas
    </title>

    <style>
        body {

            font-family: DejaVu Sans;

            font-size: 10px;
        }

        table {

            width: 100%;

            border-collapse: collapse;
        }

        th,
        td {

            border: 1px solid #000;

            padding: 3px;

            text-align: center;

            vertical-align: middle;
        }

        .header {

            text-align: center;

            margin-bottom: 10px;
        }

        .header h2 {

            margin: 0;
        }

        .info {

            margin-bottom: 10px;
        }

        .left {
            text-align: left;
        }

        .small {
            font-size: 8px;
        }

        .signature {

            margin-top: 25px;
        }

        .signature td {

            border: none;

            height: 70px;
        }



        /* Header tabel judul , logo form  */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .header-table td {
            border: 1px solid #000;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 16px;
            font-weight: bold;
            margin-top: 3px;
        }

        .info td {
            text-align: left;
        }



        .header-table td {
            border: 1px solid #000;
        }

        .identitas-table {
            width: 100%;
            border-collapse: collapse;
        }

        .identitas-table td {
            border: 1px solid #000;
            padding: 3px;
        }

        /* Hilangkan border yang menempel ke border luar */
        .identitas-table tr:first-child td {
            border-top: none;
        }

        .identitas-table tr:last-child td {
            border-bottom: none;
        }

        .identitas-table td:first-child {
            border-left: none;
        }

        .identitas-table td:last-child {
            border-right: none;
        }
    </style>

</head>

<body>

    <table class="header-table">

        <tr>

            {{-- LOGO --}}
            <td width="15%" class="text-center">

                <img src="{{ public_path('img/IMSS.jpg') }}" width="80">

            </td>

            {{-- JUDUL --}}
            <td width="50%" class="text-center">

                <div class="title">
                    CHECKSHEET HARIAN OPERATOR FORKLIFT
                </div>



            </td>

            {{-- IDENTITAS DOKUMEN --}}
            <td width="35%" style="padding:0">

                <table class="identitas-table">

                    <tr>
                        <td width="45%">
                            <b>No. Dokumen</b>
                        </td>
                        <td width="55%">
                            {{ $checksheet->nomor_dokumen ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <b>No. Fasilitas</b>
                        </td>
                        <td>
                            {{ $checksheet->nomor_fasilitas ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <b>No. Sertifikasi</b>
                        </td>
                        <td>
                            {{ $checksheet->nomor_sertifikasi ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <b>Nama Alat</b>
                        </td>
                        <td>
                            {{ $checksheet->nama_alat ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <b>Lokasi</b>
                        </td>
                        <td>
                            {{ $checksheet->lokasi }}
                        </td>
                    </tr>

                </table>

            </td>

        </tr>

    </table>

    <table>

        <thead>

            <tr>

                <th rowspan="2">
                    No
                </th>

                <th rowspan="2">
                    Uraian Pekerjaan
                </th>

                <th rowspan="2">
                    Aktivitas Pekerjaan
                </th>

                <th colspan="{{ $jumlahHari }}">

                    TANGGAL

                    <br>

                    <span style="font-size:9px;font-weight:normal;">

                        {{ strtoupper($checksheet->bulan) }}
                        {{ $checksheet->tahun }}

                    </span>

                </th>

            </tr>

            <tr>

                @for ($i = 1; $i <= $jumlahHari; $i++)
                    <th>

                        {{ $i }}

                    </th>
                @endfor

            </tr>

        </thead>

        {{-- <tbody>

            @foreach ($checksheet->items as $item)
                <tr>

                    <td>

                        {{ $item->nomor }}

                    </td>

                    <td class="left">

                        {{ $item->uraian_pekerjaan }}

                    </td>

                    <td class="left">

                        {{ $item->aktivitas_pekerjaan }}

                    </td>

                    @for ($tgl = 1; $tgl <= $jumlahHari; $tgl++)
                        @php

                            $result = $item->results
                                ->where(
                                    'tanggal',
                                    sprintf(
                                        '%04d-%02d-%02d',
                                        $checksheet->tahun,
                                        \Carbon\Carbon::parse('01 ' . $checksheet->bulan . ' ' . $checksheet->tahun)
                                            ->month,
                                        $tgl,
                                    ),
                                )
                                ->first();

                        @endphp

                        <td>

                            {{ $result->status ?? '' }}

                        </td>
                    @endfor

                </tr>
            @endforeach

        </tbody> --}}

        <tbody>

            @foreach ($checksheet->items as $item)
                <tr>

                    <td>
                        {{ $item->nomor }}
                    </td>

                    <td class="left">
                        {{ $item->uraian_pekerjaan }}
                    </td>

                    <td class="left">

                        @foreach ($item->aktivitas as $a)
                            • {{ $a->aktivitas }}<br>
                        @endforeach

                    </td>

                    @for ($tgl = 1; $tgl <= $jumlahHari; $tgl++)
                        @php

                            $tanggalCari = sprintf('%04d-%02d-%02d', $checksheet->tahun, $bulanAngka, $tgl);

                            $result = $item->results->first(function ($r) use ($tanggalCari) {
                                return optional($r->tanggal)->format('Y-m-d') == $tanggalCari;
                            });

                        @endphp

                        <td>

                            @if ($result)
                                @if ($result->status == 'V')
                                    V
                                @elseif($result->status == 'X')
                                    X
                                @elseif($result->status == 'O')
                                    O
                                @endif
                            @endif

                        </td>
                    @endfor

                </tr>
            @endforeach

        </tbody>

    </table>

    <br>

    <table style="width:100%; border-collapse:collapse;">

        <tr>

            <!-- Keterangan -->
            <td width="60%" class="left" style="vertical-align:top;">

                <b>Keterangan :</b>

                <br><br>

                V = Pemeriksaan Bagus

                <br>

                X = Pemeriksaan Jelek
                (ditindaklanjuti dengan pengajuan SPR)

                <br>

                O = Pemeriksaan Bagus, tetapi
                mesin tidak beroperasi, karena tidak ada pekerjaan

            </td>

            <!-- Tanda Tangan -->
            <td width="40%" style="vertical-align:top; border:none;">

                <table style="width:100%; border-collapse:collapse;">

                    <tr>

                        <td colspan="2"
                            style="
                    border:1px solid #000;
                    text-align:center;
                    font-weight:bold;
                    padding:5px;
                ">



                            <span style="font-weight:normal;">

                                <b>Madiun,
                                    {{ $checksheet->tanggal ? \Carbon\Carbon::parse($checksheet->tanggal)->format('d/m/Y') : date('d/m/Y') }}
                                </b>
                            </span>

                        </td>

                    </tr>

                    <tr>

                        <td
                            style="
                    width:50%;
                    border:1px solid #000;
                    height:120px;
                    text-align:center;
                    vertical-align:top;
                    padding-top:8px;
                ">

                            <b>Operator</b>

                            <br><br><br><br><br><br>

                            ____________________

                        </td>

                        <td
                            style="
                    width:50%;
                    border:1px solid #000;
                    height:120px;
                    text-align:center;
                    vertical-align:top;
                    padding-top:8px;
                ">

                            <b>Staff Teknisi</b>

                            <br><br><br><br><br><br>

                            ____________________

                        </td>

                    </tr>

                </table>

            </td>

        </tr>

    </table>

</body>

</html>
