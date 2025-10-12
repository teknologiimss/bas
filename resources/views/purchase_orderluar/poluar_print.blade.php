<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>Purchase Order {{ $poluar->nama_proyek ?? '-' }}</title>

    <style type="text/css">
        @page {
            margin: 0px;
        }

        body {
            margin-top: 3cm;
            margin-left: 2.54cm;
            margin-right: 2.54cm;
            margin-bottom: 2cm;
        }

        * {
            font-family: Verdana, "Arial Unicode MS", Arial, sans-serif;
            font-size: 0.9rem;
        }

        header {
            position: fixed;
            top: 0.7cm;
            left: 2.54cm;
            right: 2.54cm;
            height: 6cm;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .logo {
            width: 150px;
            height: auto;
            margin-right: 10px;
        }

        .header h2 {
            font-size: 24px;
            margin: 0;
        }

        .line {
            border-top: 3px solid #000;
            margin: 10px 0;
        }

        .address {
            float: left;
            width: 50%;
        }

        .address p {
            margin: 0;
            word-wrap: break-word;
        }

        .date {
            text-align: right;
        }

        .info-surat {
            clear: both;
            text-align: left;
        }

        .info-surat p {
            margin: 0;
        }

        .judul-konten {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            margin-top: 20px;
        }

        .between {
            text-align: center;
            font-size: 11px;
            margin-top: 20px;
        }

        .and {
            text-align: center;
            font-size: 11px;
            margin-top: px;
        }

        .namavendor {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            margin-top: 5px;
        }







        .content {
            margin-top: 10px;
            line-height: 1.5;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .table-2 {
            width: 100%;
            border: 1px solid #000;
        }

        .page-break {
            page-break-after: always;
        }

        .container {
            font-size: 3px;
            /* Atur ukuran font secara global untuk seluruh container */
        }

        .info-surat,
        .content,
        .address,
        .date,
        .label {
            font-size: 10px;
            /* Mengatur ukuran font pada elemen-elemen penting */
        }

        table.table th,
        table.table td {
            font-size: 9px;
            /* Mengatur ukuran font di dalam tabel */
        }

        ol li {
            font-size: 10px;
            /* Ukuran font untuk daftar */
        }

        .w-100 {
            font-size: 10px;
            /* Mengatur ukuran font pada elemen yang menggunakan kelas w-100 */
        }

        .text-center {
            font-size: 10px;
            /* Untuk elemen-elemen yang memiliki teks tengah */
        }


        .container-box {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 20px;
        }

        .kotak {
            border: 1px solid #000;
            padding: 15px;
            width: 48%;
            box-sizing: border-box;
            font-size: 14px;
        }

        .kotak table {
            margin-top: 10px;
            font-size: 14px;
        }

        .kotak p {
            margin: 5px 0;
        }

        .info-surat .label {
            display: inline-block;
            width: 120px;
        }
    </style>

</head>

<body>
    <header>
        <div class="header">
            <table style="width: 100%">
                <tr>
                    <td style="width: 10%">
                        <img src="https://inkamultisolusi.co.id/api_cms/public/uploads/editor/20220511071342_LSnL6WiOy67Xd9mKGDaG.png"
                            alt="Logo IMSS" class="logo">
                    </td>
                    <td style="width: 75%">
                        <h2>PT INKA MULTI SOLUSI SERVICE</h2>
                        <p style="margin: 0;">
                            <b>SERVICE - MAINTENANCE - LOGISTICS - GENERAL CONTRACTOR</b>
                        </p>
                        <p style="margin: 0;">Jl. Salak No. 59 Madiun - 63131</p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="line"></div>

        {{-- footer --}}
        <div style="position: fixed; bottom: 10; width: 91%; text-align: left; right: 4%">
            <div style="border-bottom: 3px solid red; padding-top: 5px;">
                <b style="font-size: 11px">PT INKA MULTI SOLUSI SERVICE</b>
                <div style="font-size: 9px; margin-top: 2px;">
                    Kantor Pusat : Jl. Salak No.59 Madiun, Telp (0351) 454094, Website : www.imsservice.co.id, Email
                    :
                    imss.log@gmail.com
                </div>
            </div>

        </div>
    </header>
    {{-- <div style="margin-top: 400px"></div> --}}

    <div class="judul-konten">PURCHASE ORDER</div>
    <div class="between">Between</div>
    <div class="judul-konten">PT INKA MULTI SOLUSI SERVICE</div>
    <div class="and">And</div>
    <div class="namavendor">{{ $poluar->nama_vendor }}</div>

    <table style="width: 100%;">
        <tr>
            <!-- Kolom Kiri: Vendor -->
            <td style="vertical-align: top; width: 50%;">
                <table style="width: 100%; border: 1px solid #000000; padding: 0px;line-height: 1.4;">



                    <tr>
                        <td>Order Number</td>
                        <td>: {{ $poluar->no_poluar }}</td>
                    </tr>
                    <tr>
                        <td>Fax</td>
                        <td>: {{ $poluar->proyek }}</td>
                    </tr>






                </table>
            </td>

            <!-- Kolom Kanan: Info Surat -->
            <td style="vertical-align: top; width: 50%;">
                <table style="width: 100%; border: 1px solid #000000; padding: 10px;">
                    <tr>
                        <td>Date</td>
                        <td>: {{ $poluar->tanggal_poluar }}</td>
                    </tr>
                    <tr>
                        <td>Reference</td>
                        <td>: {{ $poluar->reference }}</td>
                    </tr>
                    <tr>
                        <td>No. RFQ</td>
                        <td>: {{ $poluar->rfq }}</td>
                    </tr>
                    <tr>
                        <td>Quotation</td>
                        <td>: {{ $poluar->quotation }}</td>
                    </tr>
                    <tr>
                        <td>Negotiation</td>
                        <td>: {{ $poluar->no_nego }}</td>
                    </tr>
                    <tr>
                        <td>Final Quotation</td>
                        <td>: {{ $poluar->final_quotation }}</td>
                    </tr>
                    <tr>
                        <td>Dated</td>
                        <td>: {{ $poluar->batas_poluar }}</td>
                    </tr>



                </table>


            </td>
        </tr>
    </table>


    <table class="tabel-2" style="width:100%;">
        <tr>
            <td>
                @php
                    $data = $poluar->keterangan_nama ?? '';
                    $items = explode("\n", $data);
                @endphp

                <table style="width: 100%; border-collapse: collapse;">
                    @foreach ($items as $item)
                        @php
                            // Cek apakah teks mengandung tanda ":" untuk pemisahan label dan isi
                            if (strpos($item, ':') !== false) {
                                $parts = explode(':', $item, 2);
                                $label = trim($parts[0] ?? '');
                                $value = trim($parts[1] ?? '');
                            } else {
                                $label = '';
                                $value = trim($item); // Jika tidak ada ":", tampilkan seluruh teks
                            }
                        @endphp
                        <tr>
                            <td style="width: 5%; vertical-align: top; "></td>
                            @if ($label)
                                <td style="width: 50%; vertical-align: top; ">
                                    {{ $label }}</td>
                                <td style="width: 2%; vertical-align: top; white-space: nowrap; ">
                                    :</td>
                                <td style="width: 70%; ">{{ $value }}
                                </td>
                            @else
                                <td colspan="3" style="width: 92%; vertical-align: top; ">
                                    {{ $value }}</td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>
    </table>

    <p>Both hereinafter referred to as <b>“Party”</b> or collectively the <b>“Parties”</b> </p>
    <p>PT. INKA Multi Solusi Service, as BUYER, confirms having purchased from the SELLER the following Goods by Order
        made on the below and on the terms and conditions set forth hereunder and on attached sheets</p>




    <table class="table" style="width: 100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Description Of Goods</th>
                <th>Spesification</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th style="text-align: left; font-weight: bold;font-family: 'DejaVu Sans', sans-serif;">Unit Price
                    ({{ $symbol }})</th>
                <th style="text-align: left; font-weight: bold;font-family: 'DejaVu Sans', sans-serif;">Total Amount
                    ({{ $symbol }})</th>

            </tr>
        </thead>
        <tbody>
            @php
                $total_unit_price = 0;
                $total_amount = 0;
            @endphp
            @forelse ($poluar->details as $item)
                @php
                    $harga_per_unit = $item->harga_per_unit ?? 0;
                    $qty = $item->poluar_qty ?? 0;
                    $subtotal = $qty * $harga_per_unit;

                    $total_unit_price += $harga_per_unit;
                    $total_amount += $subtotal;
                @endphp

                @if ($loop->index % 5 == 0 && $loop->index != 0)
        </tbody>
    </table>
    <div class="page-break"></div>
    <table class="table" style="width: 100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Description Of Goods</th>
                <th>Spesification</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Unit Price ({{ $symbol }})</th>
                <th>Total Amount</th>

            </tr>
        </thead>
        <tbody>
            @endif
            <tr>
                <td>{{ $loop->iteration }}</td>
                {{-- <td>{{ $item->kode_material }}</td> --}}
                <td
                    style="word-wrap: break-word; max-width:90px; overflow: hidden; text-overflow: ellipsis; text-align: left;">
                    {{ $item->uraian }}</td>
                {{-- <td style="word-wrap: break-word;text-align: left">{{ $item->spek }}</td> --}}
                <td
                    style="word-wrap: break-word; max-width:90px; overflow: hidden; text-overflow: ellipsis; text-align: left;">
                    {{ $item->spek }}</td>
                {{-- <td
                
                    style="word-wrap: break-word; max-width: 200px; overflow: hidden; text-overflow: ellipsis; text-align: left;">
                    {{ $item->batas ? date('d/m/Y', strtotime($item->batas)) : '-' }}
                </td> --}}
                <td>{{ $item->poluar_qty }}</td>
                <td>{{ $item->satuan }}</td>
                <td style="text-align: left; max-width:90px; font-weight: bold;font-family: 'DejaVu Sans', sans-serif;">
                    {{ $symbol }} {{ number_format($harga_per_unit, 2) }}
                </td>

                <td style="text-align: left; max-width:90px; font-weight: bold;font-family: 'DejaVu Sans', sans-serif;">
                    {{ $symbol }}
                    {{ number_format($item->poluar_qty * $harga_per_unit, 2) }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="10" class="text-center" style="text-align: center">Tidak ada data</td>
            </tr>
            @endforelse
        <tfoot>
            <tr>
                <td colspan="5" style="text-align: center; font-weight: bold;">Total</td>
                <td style="text-align: left; font-weight: bold;font-family: 'DejaVu Sans', sans-serif;">
                    {{ $symbol }} {{ number_format($total_unit_price, 2) }}
                </td>
                <td style="text-align: left; font-weight: bold;font-family: 'DejaVu Sans', sans-serif;">
                    {{ $symbol }} {{ number_format($total_amount, 2) }}
                </td>
            </tr>
        </tfoot>

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
    <div class="total" style="margin-left: 70%; width: 50%; page-break-inside: avoid;">
        {{-- <table class="w-100">
            <tr>
                <td>Sub Total</td>
                <td>:</td>
                <td>@rupiah($poluar->subtotal)</td>
            </tr>
            <tr>
                <td>Ongkos Kirim</td>
                <td>:</td>
                <td>@rupiah($poluar->ongkos)</td>
            </tr>
            <tr>
                <td>Asuransi</td>
                <td>:</td>
                <td>@rupiah($poluar->asuransi)</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>:</td>
                <td>@rupiah($poluar->total)</td>
            </tr>
        </table> --}}
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


    <p>SHIPMENT</p>
    <table class="tabel-2" style="width:100%;">
        <tr>
            <td>
                @php
                    $data = $poluar->keterangan_shipment ?? '';
                    $items = explode("\n", $data);
                @endphp

                <table style="width: 100%; border-collapse: collapse;">
                    @foreach ($items as $item)
                        @php
                            // Cek apakah teks mengandung tanda ":" untuk pemisahan label dan isi
                            if (strpos($item, ':') !== false) {
                                $parts = explode(':', $item, 2);
                                $label = trim($parts[0] ?? '');
                                $value = trim($parts[1] ?? '');
                            } else {
                                $label = '';
                                $value = trim($item); // Jika tidak ada ":", tampilkan seluruh teks
                            }
                        @endphp
                        <tr>
                            <td style="width: 0%; vertical-align: top; "></td>
                            @if ($label)
                                <td style="width: 50%; vertical-align: top; ">
                                    {{ $label }}</td>
                                <td style="width: 2%; vertical-align: top; white-space: nowrap; ">
                                    :</td>
                                <td style="width: 70%; ">{{ $value }}
                                </td>
                            @else
                                <td colspan="3" style="width: 92%; vertical-align: top; ">
                                    {{ $value }}</td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>
    </table>
    <hr>




    <table class="tabel-2" style="width:100%;">
        <tr>
            <td>
                @php
                    $data = $poluar->keterangan_payment ?? '';
                    $items = explode("\n", $data);
                @endphp

                <table style="width: 100%; border-collapse: collapse;">
                    @foreach ($items as $item)
                        @php
                            // Cek apakah teks mengandung tanda ":" untuk pemisahan label dan isi
                            if (strpos($item, ':') !== false) {
                                $parts = explode(':', $item, 2);
                                $label = trim($parts[0] ?? '');
                                $value = trim($parts[1] ?? '');
                            } else {
                                $label = '';
                                $value = trim($item); // Jika tidak ada ":", tampilkan seluruh teks
                            }
                        @endphp
                        <tr>
                            <td style="width: 0%; vertical-align: top; "></td>
                            @if ($label)
                                <td style="width: 50%; vertical-align: top; ">
                                    {{ $label }}</td>
                                <td style="width: 2%; vertical-align: top; white-space: nowrap; ">
                                    :</td>
                                <td style="width: 70%; ">{{ $value }}
                                </td>
                            @else
                                <td colspan="3" style="width: 92%; vertical-align: top; ">
                                    {{ $value }}</td>
                            @endif
                        </tr>
                    @endforeach
                    {{-- Tambahkan baris untuk PACKING di bawahnya --}}
                    <tr>
                        <td style="width: 0%; vertical-align: top;"></td>
                        <td style="width: 50%; vertical-align: top;">PACKING</td>
                        <td style="width: 2%; vertical-align: top; white-space: nowrap;">:</td>
                        <td style="width: 70%;">Manufacture’s standard Packing for export</td>
                    </tr>
                    <tr>
                        <td style="width: 0%; vertical-align: top;"></td>
                        <td style="width: 50%; vertical-align: top;">MARKING</td>
                        <td style="width: 2%; vertical-align: top; white-space: nowrap;">:</td>
                        <td style="width: 70%;">Please refer attached sheet</td>
                    </tr>
                    <tr>
                        <td style="width: 0%; vertical-align: top;"></td>
                        <td style="width: 50%; vertical-align: top;">INSURANCE</td>
                        <td style="width: 2%; vertical-align: top; white-space: nowrap;">:</td>
                        <td style="width: 70%;">Insured amount 110% of Invoice Value at ALL RISKS CONDITION shall be
                            covered by the BUYER</td>
                    </tr>
                    <tr>
                        <td style="width: 0%; vertical-align: top;"></td>
                        <td style="width: 50%; vertical-align: top;">INSPECTION</td>
                        <td style="width: 2%; vertical-align: top; white-space: nowrap;">:</td>
                        <td style="width: 70%;">Manufacturer’s inspection to be final</td>
                    </tr>
                    <tr>
                        <td style="width: 0%; vertical-align: top;"></td>
                        <td style="width: 50%; vertical-align: top;">WARRANTY</td>
                        <td style="width: 2%; vertical-align: top; white-space: nowrap;">:</td>
                        <td style="width: 70%;">SELLER must warrant the product after 12 months from the date of Bill
                            of Lading and or Airway Bill commissioning</td>
                    </tr>




                </table>
            </td>
        </tr>
    </table>
    <p>GENERAL TERM AND CONDITIONS : Please refer to attached sheets</p>
    <hr>








    <div style="margin-top: 2rem;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    Accepted <u>on :</u> ________, 2025<br>
                    <u>By :</u> {{ $poluar->nama_vendor }}
                </td>
                <td style="width: 35%; vertical-align: top;">
                    Buyer :<br>
                    PT INKA MULTI SOLUSI SERVICE
                </td>
            </tr>
            <tr>
                <td colspan="2" style="height: 100px;"></td>
            </tr>
            <tr>
                <td style="text-align: center;">
                    <div style="display: inline-block; margin-left: -150px;">
                        <b><u>{{ $poluar->signature_vendor }}</u></b>
                    </div>
                </td>
                <td style="text-align: center; vertical-align: bottom">
                    <b style="text-decoration: underline;">
                        {{ $poluar->signature_imss }}
                </td>
            </tr>
        </table>
    </div>





</body>


</html>
