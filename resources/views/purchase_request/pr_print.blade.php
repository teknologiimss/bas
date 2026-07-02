<!DOCTYPE html>

<head>
    <title>Purchase Request-{{ $pr->no_pr }}</title>
    <style>
        @page {
            margin: 0cm;
        }

        body {
            margin-top: 0.5cm;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            margin-bottom: 0.5cm;
        }

        * {
            font-family: Verdana, Arial, sans-serif;
            font-size: 0.95rem;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        table {
            border-collapse: collapse;
        }

        table,
        td,
        th {
            /* border: 1px solid black; */
        }

        td {
            padding-left: 15px;
            padding-right: 15px;
        }

        /* thead {
            background-color: #f2f2f2;
        } */

        th {
            padding: 15px 15px 15px 25px;
        }

        .page_break {
            page-break-before: always;
        }

        .td-no-top-border {
            border-top: 1px solid transparent !important;
        }

        .td-no-left-right-border {
            border-left: 1px solid transparent !important;
            border-right: 1px solid transparent !important;
        }

        .td-no-left-border {
            border-left: 1px solid transparent !important;
        }

        .pagenum:before {
            content: counter(page);
        }

        .invoice table {
            margin: 15px;
        }

        .invoice h3 {
            margin-left: 15px;
        }

        .information {
            color: #000000;
        }

        .information .logo {
            margin: 5px;
        }

        /* .information table {
            padding: 10px;
        } */

        header {
            position: fixed;
            top: 0.3cm;
            left: 0.5cm;
            right: 0.5cm;
            /* height: 5.5cm; */
            /* margin-bottom: 400px; */
            border: 1px solid black;
        }

        .table {
            width: 100%;
            border: 1px solid black;
            text-align: center;
        }

        .table tr,
        .table td,
        .table th {
            border: 1px solid black;
            /* padding: 5px; */
        }

        .table2 tr {
            border: 1px solid black;
            /* padding: 5px; */
        }

        body {
            border: 1px solid black;
            padding: 15px;
        }
    </style>

</head>

<body>
    {{-- <header> --}}
    <div class="information">
        <table width="100%">
            <tr style="border: 1px solid black;">
                <td align="center" style="width:22%; border:1px solid #000;">
                    <img src="{{ public_path('img/IMST.png') }}" alt="Logo" style="width:120px; height:95px;">
                </td>

                {{-- <td align="center" style="width: 85%; border-style: none;">
                        <strong style="font-size: 15">PURCHASE REQUEST</strong><br>
                        <strong style="font-size: 15">(PR)</strong><br>
                    </td> --}}
                <td align="center" style="width: 78%; border-style: none;">
                    @if (auth()->user()->role == 14)
                        <strong style="font-size:17px">SURAT PERMINTAAN PEMBELIAN (MATERIAL)</strong><br>
                        <strong style="font-size:17px">(SPP)</strong><br>
                    @else
                        <strong style="font-size:17px">PURCHASE REQUEST</strong><br>
                        <strong style="font-size:17px">(PR)</strong><br>
                    @endif
                </td>

                <td style="border-style:none"></td>
            </tr>
        </table>

        <table
            style="width:100%; border-collapse:collapse; border:1px solid black; table-layout:fixed;margin-top:12px;">
            <tr>

                <!-- KIRI -->
                <td style="width:22%; border-right:1px solid black; padding:8px; vertical-align:top;">
                    <strong>Kepada Yth.</strong><br>
                    <strong>Dept. Logistik</strong>
                </td>

                <!-- KANAN -->
                <td style="width:78%; padding:8px; vertical-align:top;">
                    <table style="width:100%; table-layout:fixed; border-collapse:collapse;">

                        <tr>
                            <!-- Nomor -->
                            <td style="width:12%; vertical-align:top;"><strong>Nomor</strong></td>
                            <td style="width:3%; vertical-align:top;">:</td>
                            <td style="width:30%; vertical-align:top; word-break:break-word;">
                                {{ $pr->no_pr }}
                            </td>

                            <!-- Proyek -->
                            <td style="width:12%; vertical-align:top;"><strong>Proyek</strong></td>
                            <td style="width:3%; vertical-align:top;">:</td>
                            <td style="width:40%; vertical-align:top; word-break:break-word; overflow-wrap:break-word;">
                                {{ $pr->nama_pekerjaan }}
                            </td>
                        </tr>

                        <tr>
                            <!-- Tanggal -->
                            <td style="vertical-align:top;"><strong>Tanggal</strong></td>
                            <td style="vertical-align:top;">:</td>
                            <td style="vertical-align:top;">
                                @if ($pr['tgl_pr'])
                                    {{ \Carbon\Carbon::parse($pr['tgl_pr'])->translatedFormat('d F Y') }}
                                @else
                                    -
                                @endif
                            </td>

                            <!-- Revisi -->
                            <td style="vertical-align:top;">
                                <strong>{{ auth()->user()->role == 14 ? 'Dasar' : 'Revisi' }}</strong>
                            </td>
                            <td style="vertical-align:top;">:</td>
                            <td style="vertical-align:top; word-break:break-word;">
                                {{ auth()->user()->role == 14 ? $pr->dasar ?? '-' : $pr->revisi ?? '-' }}
                            </td>
                        </tr>

                    </table>
                </td>

            </tr>
        </table>


        </tr>
        </table>
    </div>
    {{-- </header> --}}

    {{--
    <div class="w-100 text-center">
        <b style="text-decoration: underline"></i>PURCHASE ORDER</b><br />
    </div> --}}
    <table class="table" style="width: 100%;margin-top:12px;">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Material</th>
                <th>Uraian Barang/Jasa</th>
                <th>Spesifikasi</th>
                <th>Qty</th>
                <th>Sat</th>
                <th>Waktu <br> Penyelesaiaan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pr->purchases as $item)
                @if ($loop->index % 8 == 0 && $loop->index != 0)
        </tbody>
    </table>
    <div class="page_break"></div>
    <table class="table" style="width: 100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Material</th>
                <th>Uraian Barang/Jasa</th>
                <th>Spesifikasi</th>
                <th>Qty</th>
                <th>Sat</th>
                <th>Waktu <br> Penyelesaiaan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @endif
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->kode_material }}</td>
                <td style="word-wrap: break-word; overflow: hidden; text-overflow: ellipsis; text-align: left;">
                    {{ $item->uraian }}
                </td>
                {{-- <td style="word-wrap: break-word;text-align: left">{{ $item->spek }}</td> --}}
                <td
                    style="word-wrap: break-word; max-width: 200px; overflow: hidden; text-overflow: ellipsis; text-align: left;">
                    {{ $item->spek }}
                </td>
                <td>{{ $item->qty }}</td>
                <td>{{ $item->satuan }}</td>
                {{-- <td>{{ $item->waktu }}</td> --}}
                <td>
                    @if ($item['waktu'])
                        {{ \Carbon\Carbon::parse($item['waktu'])->locale('id')->translatedFormat('d F Y') }}
                    @else
                        -
                    @endif
                </td>
                <td
                    style="word-wrap: break-word; max-width: 200px; overflow: hidden; text-overflow: ellipsis; text-align: left;">
                    {{ $item->keterangan }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center" style="text-align: center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Asli tampil semua TTDNYA --}}
    {{-- <div style="margin-top: 1rem">
        <div>
            <table style="width: 100%">
                <tr>
                    <td align="center" style="width: 25%;">
                        Menyetujui,<br>
                        Kadiv. {{ $pr->role }}
                        <br><br><br><br><br>
                        <strong>{{ $pr->kadiv }}</strong><br>
                    </td>
                    <td align="center" style="width: 25%;">
                        Diperiksa Oleh,<br>
                        Kadep. {{ $pr->role }} <br>
                        <br><br><br><br>
                        <strong>{{ $pr->kadep }}</strong><br>
                    </td>
                    <td align="center" style="width: 25%;">
                        Dibuat Oleh,<br>
                        Staff {{ $pr->role }}
                        <br><br><br><br><br>
                        <strong>{{ $pr->pic }}</strong><br>
                    </td>
                </tr>
            </table>
        </div>
    </div> --}}


    {{-- PR Print --}}
    <div style="margin-top: 1rem">
        <table style="width: 100%">
            <tr>

                @if ($pr->role !== 'MRO')
                    <!-- Kadiv -->
                    <td align="center" style="width: 25%;">
                        Menyetujui,<br>
                        Kadiv. {{ $pr->role }}
                        <br><br><br><br><br>
                        <strong>{{ $pr->kadiv }}</strong><br>
                    </td>
                @endif

                <!-- Kadep -->
                <td align="center" style="width: 25%;">
                    Diperiksa Oleh,<br>
                    Kadep. {{ $pr->role }} <br>
                    <br><br><br><br>
                    <strong>{{ $pr->kadep }}</strong><br>
                </td>

                <!-- Staff -->
                <td align="center" style="width: 25%;">
                    Dibuat Oleh,<br>
                    Staff {{ $pr->role }}
                    <br><br><br><br><br>
                    <strong>{{ $pr->pic }}</strong><br>
                </td>

            </tr>
        </table>
    </div>




    {{-- <table class="table2" style="width:100%; margin-top:2rem">
        <tr>
            <td>
                <strong><u>Dasar PR/SPPJP :</u></strong><br>
                <span>{!! nl2br($pr->dasar_pr) !!}</span>

            </td>
        </tr>
    </table> --}}

    {{-- <table class="table2" style="width:100%; margin-top:2rem">
        <tr>
            <td>
                <strong>
                    <u>{{ auth()->user()->role == 14 ? 'Catatan :' : 'Dasar PR/SPPJP :' }}</u>
                </strong><br>

                <span>
                    {!! nl2br(auth()->user()->role == 14 ? $pr->catatan ?? '' : $pr->dasar_pr ?? '') !!}
                </span>
            </td>
        </tr>
    </table> --}}


    {{-- Jika MRO Dasar PR menjadi Catatan , dan Selain User MRO , maka akan muncul Dasar PR dan Catatan --}}
    <table class="table2" style="width:100%; margin-top:2rem">
        <tr>
            @if (auth()->user()->role == 14)
                <td>
                    <strong>
                        <u>Catatan :</u>
                    </strong><br>

                    <span>
                        {!! nl2br($pr->catatan ?? '') !!}
                    </span>
                </td>
            @else
                <td style="width:50%; vertical-align:top;">
                    <strong>
                        <u>Dasar PR/SPPJP :</u>
                    </strong><br>

                    <span>
                        {!! nl2br($pr->dasar_pr ?? '') !!}
                    </span>
                </td>

                <td style="width:50%; vertical-align:top;">
                    <strong>
                        <u>Catatan :</u>
                    </strong><br>

                    <span>
                        {!! nl2br($pr->catatan ?? '') !!}
                    </span>
                </td>
            @endif
        </tr>
    </table>



</body>



</html>
