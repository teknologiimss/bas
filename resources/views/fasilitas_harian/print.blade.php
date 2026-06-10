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
    </style>

</head>

<body>

    <div class="header">

        <h2>

            CHECKSHEET HARIAN FASILITAS

        </h2>

        <div>

            PT INDUSTRI MANUFAKTUR

        </div>

    </div>

    <table class="info">

        <tr>

            <td width="15%">
                Lokasi
            </td>

            <td width="35%">
                {{ $checksheet->lokasi }}
            </td>

            <td width="15%">
                Bulan
            </td>

            <td width="35%">
                {{ $checksheet->bulan }}
                {{ $checksheet->tahun }}
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
                    Tanggal
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

    <table>

        <tr>

            <td colspan="3" class="left">

                <b>Keterangan :</b>

                <br><br>

                V = Pemeriksaan Bagus

                <br>

                X = Pemeriksaan Jelek
                (ditindaklanjuti SPR)

                <br>

                O = Bagus tetapi
                mesin tidak beroperasi

            </td>

        </tr>

    </table>

    <table class="signature">

        <tr>

            <td width="50%">

                Mengetahui,

                <br>

                Supervisor

            </td>

            <td width="50%">

                Petugas Pemeriksa

            </td>

        </tr>

        <tr>

            <td>

                ______________________

            </td>

            <td>

                ______________________

            </td>

        </tr>

    </table>

</body>

</html>
