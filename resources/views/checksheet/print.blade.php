<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>
        Checksheet PDF
    </title>

    <style>
        @page {
            size: A4 portrait;
            margin: 8mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: middle;
        }

        th {
            background: #efefef;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 20px;
            font-weight: bold;
            margin-top: 5px;
        }

        .jenis {
            font-size: 24px;
            font-weight: bold;
        }

        .section-row td {
            background: #d9a3a3;
            font-weight: bold;
        }

        .status-box {
            font-size: 16px;
            font-weight: bold;
            font-family: DejaVu Sans, sans-serif;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-row-group;
        }

        /* tr {
            page-break-inside: avoid !important;
        } */

        tbody {
            page-break-inside: auto;
        }

        /* td,
        th {
            overflow: hidden;
        } */

        td,
        th {
            word-wrap: break-word;
        }

        .signature-box {
            height: 70px;
        }
    </style>

</head>

<body>

    <table>

        {{-- HEADER REPEAT --}}
        <thead>

            {{-- HEADER --}}
            <tr>

                <td colspan="7" style="padding:0;">

                    <table>

                        <tr>

                            {{-- LOGO --}}
                            <td width="15%" class="text-center">

                                <img src="{{ public_path('img/IMSS.jpg') }}" width="80">

                            </td>

                            {{-- JUDUL --}}
                            <td width="65%" class="text-center">

                                <div class="title">
                                    CHECKSHEET PERAWATAN
                                </div>

                                <div class="subtitle">
                                    {{ strtoupper($checksheet->unit) }}
                                </div>

                            </td>

                            {{-- JENIS --}}
                            <td width="20%" class="text-center jenis">

                                {{ strtoupper($checksheet->jenis_perawatan ?? '-') }}

                            </td>

                        </tr>

                    </table>

                    {{-- INFO --}}
                    <table>

                        <tr>

                            <td class="text-bold">

                                NO LAMBUNG :
                                {{ $checksheet->no_lambung }}

                            </td>

                        </tr>

                    </table>

                </td>

            </tr>

            {{-- HEADER TABEL --}}
            <tr>

                <th width="4%">
                    No
                </th>

                <th width="22%">
                    Uraian Pekerjaan
                </th>

                <th width="30%">
                    Aktivitas Pekerjaan
                </th>

                <th width="18%">
                    Standar
                </th>

                <th width="4%">
                    OK
                </th>

                <th width="4%">
                    NOK
                </th>

                <th width="18%">
                    Keterangan
                </th>

            </tr>

        </thead>

        {{-- BODY --}}
        <tbody>

            @foreach ($checksheet->sections as $section)
                {{-- SECTION --}}
                <tr class="section-row">

                    <td colspan="7">

                        {{ $section->kode }}
                        {{ $section->nama_section }}

                    </td>

                </tr>

                @foreach ($section->items as $item)
                    @php
                        $detailCount = $item->details->count();
                    @endphp

                    @foreach ($item->details as $dIndex => $detail)
                        <tr>

                            {{-- NOMOR --}}
                            @if ($dIndex == 0)
                                <td rowspan="{{ $detailCount }}" class="text-center">

                                    {{ $item->nomor }}

                                </td>

                                {{-- URAIAN --}}
                                <td rowspan="{{ $detailCount }}">

                                    {{ $item->uraian }}

                                </td>
                            @endif

                            {{-- AKTIVITAS --}}
                            <td>

                                {{ $detail->aktivitas }}

                            </td>

                            {{-- STANDAR --}}
                            <td>

                                {{ $detail->standar }}

                            </td>

                            {{-- OK --}}
                            <td class="text-center status-box">

                                @if (optional($detail->result)->status == 'OK')
                                    &#10004;
                                @endif

                            </td>

                            {{-- NOK --}}
                            <td class="text-center status-box">

                                @if (optional($detail->result)->status == 'NOK')
                                    &#10004;
                                @endif

                            </td>

                            {{-- KETERANGAN --}}
                            <td>

                                {{ optional($detail->result)->keterangan }}

                            </td>

                        </tr>
                    @endforeach
                @endforeach
            @endforeach

        </tbody>

    </table>

    {{-- FOOTER --}}
    <table style="margin-top:15px;">

        <tr>

            <td>

                Berdasarkan hasil perawatan,
                unit dinyatakan :

                <b>
                    SO / SO dengan catatan / TSO
                </b>

                <br><br>

                Catatan :

                <br><br><br>

            </td>

        </tr>

    </table>

    {{-- TTD --}}
    <table style="margin-top:25px; border:none;">

        <tr>

            <td width="50%" style="border:none;" class="text-center">

                <div style="height:40px;"></div>

                <b>Kepala Departemen MRO 1</b>

                <div class="signature-box"></div>

                ______________________

            </td>

            <td width="50%" style="border:none;" class="text-center">

                <div style="height:40px;">

                    Madiun,
                    {{ \Carbon\Carbon::parse($checksheet->tanggal)->format('d/m/Y') }}

                </div>

                <b>PELAKSANA</b>

                <div class="signature-box"></div>

                ______________________

            </td>

        </tr>

    </table>

</body>

</html>
