<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>Checksheet PDF</title>

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
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: middle;
            word-wrap: break-word;
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
            font-family: DejaVu Sans, sans-serif;
            font-size: 16px;
            text-align: center;
            font-weight: bold;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-row-group;
        }

        .signature-box {
            height: 70px;
        }

        .header-table td {
            border: 1px solid #000;
        }

        .no-border {
            border: none !important;
        }
    </style>

</head>

<body>

    {{-- HEADER --}}
    <table class="header-table">

        <tr>

            <td width="15%" class="text-center">

                <img src="{{ public_path('img/IMSS.jpg') }}" width="80">

            </td>

            <td width="65%" class="text-center">

                <div class="title">
                    CHECKSHEET PERAWATAN
                </div>

                <div class="subtitle">
                    {{ strtoupper($checksheet->unit) }}
                </div>

            </td>

            <td width="20%" class="text-center jenis">

                {{ strtoupper($checksheet->jenis_perawatan ?? '-') }}

            </td>

        </tr>

    </table>

    <table style="margin-bottom:5px;">

        <tr>

            <td class="text-bold">

                NO LAMBUNG :
                {{ $checksheet->no_lambung }}

            </td>

        </tr>

    </table>

    {{-- TABEL CHECKSHEET --}}
    <table>

        <thead>

            <tr>

                <th width="5%">
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

                <th width="5%">
                    OK
                </th>

                <th width="5%">
                    NOK
                </th>

                <th width="15%">
                    Keterangan
                </th>

            </tr>

        </thead>

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
                    @foreach ($item->details as $index => $detail)
                        <tr>

                            {{-- NOMOR --}}
                            <td class="text-center">

                                {{ $index == 0 ? $item->nomor : '' }}

                            </td>

                            {{-- URAIAN --}}
                            <td>

                                {{ $index == 0 ? $item->uraian : '' }}

                            </td>

                            {{-- AKTIVITAS --}}
                            <td>

                                {{ $detail->aktivitas }}

                            </td>

                            {{-- STANDAR --}}
                            <td>

                                {{ $detail->standar }}

                            </td>

                            {{-- OK --}}
                            <td class="status-box">

                                @if (optional($detail->result)->status == 'OK')
                                    ✓
                                @endif

                            </td>

                            {{-- NOK --}}
                            <td class="status-box">

                                @if (optional($detail->result)->status == 'NOK')
                                    ✓
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

    {{-- KETERANGAN AKHIR --}}
    <table style="margin-top:15px;">

        <tr>

            <td>

                Berdasarkan hasil perawatan, unit dinyatakan :

                <b>
                    SO / SO DENGAN CATATAN / TSO
                </b>

                <br><br>

                Catatan :

                <br><br><br><br>

            </td>

        </tr>

    </table>

    {{-- TTD --}}
    <table style="margin-top:25px;">

        <tr>

            <td width="50%" class="no-border text-center">

                <div style="height:40px;"></div>

                <b>
                    Kepala Departemen MRO 1
                </b>

                <div class="signature-box"></div>

                ______________________

            </td>

            <td width="50%" class="no-border text-center">

                <div style="height:40px;">

                    Madiun,
                    {{ $checksheet->tanggal ? \Carbon\Carbon::parse($checksheet->tanggal)->format('d/m/Y') : date('d/m/Y') }}

                </div>

                <b>
                    PELAKSANA
                </b>

                <div class="signature-box"></div>

                ______________________

            </td>

        </tr>

    </table>


    {{-- Lampiran --}}
    <div style="page-break-before:always;"></div>

    <h2 style="
text-align:center;
margin-bottom:20px;
">
        LAMPIRAN FOTO CHECKSHEET
    </h2>

    @foreach ($checksheet->sections as $section)
        @foreach ($section->items as $item)
            @foreach ($item->details as $detail)
                @if ($detail->result && $detail->result->photos->count())
                    <table style="
            margin-bottom:20px;
            ">

                        <tr>

                            <td width="30%">
                                Aktivitas
                            </td>

                            <td>
                                {{ $detail->aktivitas }}
                            </td>

                        </tr>

                        <tr>

                            <td>
                                Status
                            </td>

                            <td>

                                {{ $detail->result->status }}

                            </td>

                        </tr>

                        <tr>

                            <td>
                                Keterangan
                            </td>

                            <td>

                                {{ $detail->result->keterangan }}

                            </td>

                        </tr>

                    </table>

                    <table width="100%" style="
            margin-bottom:30px;
            ">

                        <tr>

                            @foreach ($detail->result->photos as $photo)
                                <td width="33%" align="center">

                                    <img src="{{ public_path('uploads/checksheet/' . $photo->foto) }}"
                                        style="
    width:auto;
    height:220px;
    border:1px solid #000;
">

                                </td>
                            @endforeach

                        </tr>

                    </table>
                @endif
            @endforeach
        @endforeach
    @endforeach

</body>

</html>
