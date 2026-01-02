<!DOCTYPE html>

<head>
    <title>Purchase Order {{ $po->nama_proyek ?? '-' }}</title>
    <style>
        @page {
            margin: 0cm;
        }

        body {
            margin-top: 9cm;
            margin-left: 0cm;
            margin-right: 0cm;
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
            padding: 10px;
        }

        td {
            padding-left: 10px;
            padding-right: 10px;
        }

        th {
            padding: 15px 15px 15px 25px;
        }

        .table {
            width: 100%;
            /* margin-top: 1cm; */
            border: none;
            table-layout: fixed;
        }

        .table tr,
        .table th {
            border: none;
            text-align: center;
            table-layout: fixed;
        }

        .table th {
            border-top: 1px solid #000;
            /* border atas */
            border-bottom: 1px solid #000;
            /* border bawah */
            border-left: none;
            /* hilangkan border kiri */
            border-right: none;
            /* hilangkan border kanan */
            padding: 8px;
        }


        .page-break {
            page-break-after: always;
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


        .information table {
            /* padding: 10px; */
            margin-bottom: 2cm;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 8.4cm;
        }

        .table2 tr {
            border: 1px solid black;
            padding: 5px;
        }

        .alamat {
            white-space: pre-wrap;

        }

        .title-header {
            margin-top: 0;
        }

        /* footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
        } */

        /* body {
            margin-bottom: 5cm;
        } */

        .page_break {
            page-break-before: always;
        }
    </style>

</head>

<body>
    <header>
        {{-- <div class="information"> --}}
        <table width="100%" style="border-collapse:collapse; margin-bottom:0;">
            <tr>
                <!-- KOLOM COMPANY -->
                <td style="text-align:left; width:33%; vertical-align:top; padding-top:4px; line-height:1.2;" rowspan="10">
                    <strong>Company</strong><br>
                    <span>{{ $po->nama_vendor }}</span><br>
                    <span>{{ $po->alamat_vendor ?? '-' }}</span><br>
                    <div style="display:table;">
                        <div style="display:table-row;">
                            <span style="display:table-cell; width:130px;">Contact Person</span>
                            <span style="display:table-cell;">: {{ $po->cp ?? '-' }}</span>
                        </div>
                        <div style="display:table-row;">
                            <span style="display:table-cell;">Telepon</span>
                            <span style="display:table-cell;">: {{ $po->telp_vendor ?? '-' }}</span>
                        </div>
                        <div style="display:table-row;">
                            <span style="display:table-cell;">Fax</span>
                            <span style="display:table-cell;">: {{ $po->fax_vendor ?? '-' }}</span>
                        </div>
                        <div style="display:table-row;">
                            <span style="display:table-cell;">Email</span>
                            <span style="display:table-cell;">: {{ $po->email_vendor ?? '-' }}</span>
                        </div>
                    </div>
                </td>

                <!-- KOLOM LOGO -->
                <td align="center" rowspan="10" style="vertical-align:top; line-height:1.2">
                    <img src="https://inkamultisolusi.co.id/api_cms/public/uploads/editor/20220511071342_LSnL6WiOy67Xd9mKGDaG.png"
                        alt="Logo" width="200" class="logo" /><br>

                    <strong>PT INKA MULTI SOLUSI SERVICE</strong><br>
                    Jl Salak No. 59 Madiun 63131 - Indonesia<br>
                    Telepon : +62 351 454094<br>
                </td>
            </tr>

            <!-- KELOMPOK 1 -->
            <tr>
                <td style="padding-bottom:1px">NO PO</td>
                <td style="padding-bottom:1px">: {{ $po->no_po }}</td>
            </tr>
            <tr>
                <td style="padding-bottom:1px">Tanggal PO</td>
                <td style="padding-bottom:1px">: {{ $po->tanggal_po }}</td>
            </tr>
            <tr>
                <td style="padding-bottom:1px">Incoterm</td>
                <td style="padding-bottom:1px">: {{ $po->incoterm }}</td>
            </tr>

            <!-- SPACER -->
            <tr>
                <td colspan="2" style="height:2px;"></td>
            </tr>

            <!-- KELOMPOK 2 -->
            <tr>
                <td style="padding-bottom:1px">PR NO.</td>
                <td style="padding-bottom:1px">: {!! nl2br($po->no_pr ?? '-') !!}</td>
            </tr>
            <tr>
                <td style="padding-bottom:1px">Referensi SPH</td>
                <td style="padding-bottom:1px">: {{ $po->ref_sph ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding-bottom:1px">No. Justifikasi</td>
                <td style="padding-bottom:1px">: {{ $po->no_just ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding-bottom:1px">No. Negosiasi</td>
                <td style="padding-bottom:1px">: {{ $po->no_nego ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding-bottom:1px">Batas Akhir PO</td>
                <td style="padding-bottom:1px">: {{ $po->batas_po ?? '-' }}</td>
            </tr>

            <tr>
                <td style="vertical-align:top;">
                </td>

                <td
                    style="
            padding:0;
            margin:0;
            line-height:1;
            height:1%;
            text-align:center;
            vertical-align:middle;
        ">
                    <strong style="
            display:block;
            margin:0;
            padding:0;
            line-height:1;
            font-size:20px;
        ">PURCHASE ORDER</strong>
                </td>

                <td colspan=2 style="vertical-align:top;">
                </td>
            </tr>

            <tr>
                <!-- Kolom kiri (Company width 33%) -->
                <td style="vertical-align:top;">
                    Alamat {{ $po->jenis_proyek ?? '-' }} :<br>
                    {!! nl2br(e($po->alamat_proyek ?? '-')) !!}
                </td>

                <!-- Kolom tengah (Logo width otomatis) -->
                <td style="vertical-align:top; text-align:center;">
                </td>

                <!-- Kolom kanan (Info PO) -->
                <td colspan="2" style="vertical-align:top;">
                    Alamat Penagihan :<br>
                    Direktur Keuangan, SDM, dan Manrisk<br>
                    PT INKA Multi Solusi Service<br>
                    Jl. Salak No. 59 Madiun<br>
                    N.P.W.P : 70.970.401.9-621.000
                </td>
            </tr>
        </table>



    </header>
    {{-- <div style="margin-top: 400px"></div> --}}

    <table class="table" style="width: 100%;">
        <thead>
            <tr>
                <th colspan="10"
                    style="
                    text-align:left;
                    font-weight:normal;
                    border:0;
                    padding:6px 0 4px 0;
                ">
                    Dengan ini kami memesan item berikut:
                </th>
            </tr>

            <tr>
                <th>Item</th>
                <th>Kode Material</th>
                <th>Deskripsi</th>
                <th>Batas Akhir Diterima</th>
                <th>Kuantitas</th>
                <th>Unit</th>
                <th>Harga Per Unit</th>
                <th>Mata Uang</th>
                <th>Vat</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($po->details as $item)
            @php
            $harga_per_unit = $item->harga_per_unit ?? 0;
            @endphp
            @if ($loop->index % 5 == 0 && $loop->index != 0)
        </tbody>
    </table>

    <div class="page_break"></div>

    <table class="table" style="width: 100%; margin-top: 25px;">
        <thead>
            <tr>
                <th>Item</th>
                <th>Kode Material</th>
                <th>Deskripsi</th>
                <th>Batas Akhir Diterima</th>
                <th>Kuantitas</th>
                <th>Unit</th>
                <th>Harga Per Unit</th>
                <th>Mata Uang</th>
                <th>Vat</th>
                <th>Total</th>
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
                    style="word-wrap: break-word; max-width: 200px; overflow: hidden; text-overflow: ellipsis; text-align: center;">
                    {{ $item->batas ? date('d/m/Y', strtotime($item->batas)) : '-' }}
                </td>
                <td>{{ $item->po_qty }}</td>
                <td>{{ $item->satuan }}</td>
                <td>@rupiah($harga_per_unit)</td>
                <td>{{ $item->mata_uang ?? '-' }}</td>
                <td>{{ $item->vat ?? '-' }}</td>
                <td>@rupiah($item->po_qty * $harga_per_unit)</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center" style="text-align: center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- <table class="table" style="width: 100%;">
        <thead>
            <tr>
                <th>Item</th>
                <th>Kode Material</th>
                <th>Deskripsi</th>
                <th>Batas Akhir Diterima</th>
                <th>Kuantitas</th>
                <th>Unit</th>
                <th>Harga Per Unit</th>
                <th>Mata Uang</th>
                <th>Vat</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody id="table-body">
            @forelse ($po->details as $item)
                @php
                    $harga_per_unit = $item->harga_per_unit ?? 0;
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
    <td>{{ $item->kode_material }}</td>
    <td>{{ $item->uraian }}</td>
    <td style="text-align: center;">{{ $item->batas ? date('d/m/Y', strtotime($item->batas)) : '-' }}</td>
    <td style="text-align: center;">{{ $item->qty }}</td>
    <td style="text-align: center;">{{ $item->satuan }}</td>
    <td style="text-align: center;">@rupiah($harga_per_unit)</td>
    <td style="text-align: center;">{{ $item->mata_uang ?? '-' }}</td>
    <td style="text-align: center;">{{ $item->vat ?? '-' }}</td>
    <td style="text-align: center;">@rupiah($item->po_qty * $harga_per_unit)</td>
    </tr>
    @empty
    <tr>
        <td colspan="10" style="text-align: center">Tidak ada data</td>
    </tr>
    @endforelse
    </tbody>
    </table> --}}

    <div class="total" style="margin-left:70%; width:50%; page-break-inside:avoid">
        <table style="border-collapse:collapse">
            <tr>
                <td>Sub Total</td>
                <td>:</td>
                <td>@rupiah($po->subtotal)</td>
            </tr>
            <tr>
                <td>PPN</td>
                <td>:</td>
                <td>@rupiah($po->ppn)</td>
            </tr>
            <tr>
                <td>PPH</td>
                <td>:</td>
                <td>@rupiah($po->pph)</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td>:</td>
                <td><strong>@rupiah($po->total)</strong></td>
            </tr>
        </table>
    </div>

    {{-- <div class="page-break"></div> --}}



    {{-- <footer>
        <div style="margin-top:1000x">
            <table class="table2" style="width:100%;padding:10px">
                <tr>
                    <td style="width: 16%">
                        <span>Referensi PO</span><br>
                        <span>Termin Pembayaran</span><br>
                        <span>Garansi</span><br>
                        <span>Proyek</span><br>
                    </td>
                    <td style="width: 1%">
                        <span>:</span><br>
                        <span>:</span><br>
                        <span>:</span><br>
                        <span>:</span><br>
                    </td>
                    <td>
                        <span>{{ $po->ref_po }}</span><br>
    <span>{{ $po->term_pay }}</span><br>
    <span>{{ $po->garansi }}</span><br>
    <span>{{ $po->nama_proyek }}</span><br>
    </td>
    </tr>
    <tr>
        <td style="height: 50px;vertical-align: top;">Catatan Untuk Vendor</td>
        <td style="vertical-align: top;">:</td>
        <td style="vertical-align: top">{!! nl2br($po->catatan_vendor) !!}</td>
    </tr>
    </table>
    </div>

    </footer> --}}

    <div style="page-break-inside: avoid;">
        <table class="table2" style="width:100%; padding:10px">
            <tr>
                <td style="width: 16%">
                    <span>Referensi PO</span><br>
                    <span>Termin Pembayaran</span><br>
                    <span>Garansi</span><br>
                    <span>Proyek</span><br>
                </td>
                <td style="width: 1%">
                    <span>:</span><br>
                    <span>:</span><br>
                    <span>:</span><br>
                    <span>:</span><br>
                </td>
                <td>
                    <span>{{ $po->ref_po }}</span><br>
                    <span>{{ $po->term_pay }}</span><br>
                    <span>{{ $po->garansi }}</span><br>
                    <span>{{ $po->proyek }}</span><br>
                </td>
            </tr>
            <tr>
                <td style="height: 50px;vertical-align: top;">Catatan</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top">{!! nl2br($po->catatan_vendor) !!}</td>
            </tr>
        </table>
    </div>

    <div style="page-break-inside: avoid;">
        <div style="float: left; width: 50%">
            <table class="w-100">
                <tr>
                    <td>Disetujui Oleh,</td>
                </tr>
            </table>
        </div>
    </div>

    <table style="width: 80%; margin: 20px auto 0 auto; border-collapse: collapse;">
        <tr>
            <td style="width: 40%; text-align: center;">
                <div><b>{{ $po->nama_vendor ?? 'VENDOR' }}</b></div>
                <div style="height: 120px;"></div>
                <div>
                    <b style="text-decoration: underline;">
                        {{ $po->ttd_vendor ?? '_________________' }}
                    </b><br>
                    <b>{{ $po->jabatan_vendor ?? '' }}</b>
                </div>
            </td>
            <td style="width: 40%; text-align: center;">
                <div><b>PT INKA MULTI SOLUSI SERVICE</b></div>
                <div style="height: 120px;"></div>
                <div>
                    <b style="text-decoration: underline;">
                        @if ($po->total < 25000000)
                            RUDY SUSANTO
                            @elseif($po->total >= 25000000 && $po->total < 100000000)
                                RAHARDIAN TITUS N
                                @elseif($po->total >= 100000000)
                                RA NUR FADHILLAH
                                @endif
                    </b><br>
                    <b>
                        @if ($po->total < 25000000)
                            KEPALA DEPARTEMEN LOGISTIK
                            @elseif($po->total >= 25000000 && $po->total < 100000000)
                                KEPALA DIVISI TEKNIK DAN LOGISTIK
                                @elseif($po->total >= 100000000)
                                PLT DIREKTUR UTAMA
                                @endif
                    </b>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>