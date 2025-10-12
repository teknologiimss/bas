<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>Negotiation Letter-{{ $negoluar->nomor_negoluar }}</title>
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
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
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
    </header>

    <div class="judul-konten">NEGOTIATION LETTER</div>
    <div class="container">

        @foreach ($negoluars as $neg)
            <table style="width: 100%;">
                <tr>
                    <!-- Kolom Kiri: Vendor -->
                    <td style="vertical-align: top; width: 50%;">
                        <table style="width: 100%; border: 1px solid #000000; line-height: 1.4;">
                            <tr>
                                <td colspan="2">Vendor :</td>
                            </tr>
                            <tr>
                                <td colspan="2"><b>{!! nl2br($neg->nama) !!}</b></td>
                            </tr>
                            <tr>
                                <td colspan="2">{{ $neg->alamat }}</td>
                            </tr>
                            <tr>
                                <td style="width: 60px;">Telp</td>
                                <td>: {{ $neg->telp }}</td>
                            </tr>
                            <tr>
                                <td>Fax</td>
                                <td>: {{ $neg->fax }}</td>
                            </tr>
                            <tr>
                                <td valign="top">Email</td>
                                <td>
                                    @php $emails = array_map('trim', explode(',', $neg->email)); @endphp
                                    @foreach ($emails as $loopIndex => $email)
                                        {!! $loopIndex == 0 ? ': - ' : '&nbsp; - ' !!}{{ $email }}<br>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">Contact Person</td>
                                <td>
                                    @php $cps = array_map('trim', explode(',', $neg->cp)); @endphp
                                    @foreach ($cps as $loopIndex => $cp)
                                        {!! $loopIndex == 0 ? ': - ' : '&nbsp; - ' !!}{{ $cp }}<br>
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                    </td>

                    <!-- Kolom Kanan: Info RFQ -->
                    <td style="vertical-align: top; width: 50%;">
                        <table style="width: 100%; border: 1px solid #000000; padding: 10px;">
                            <tr>
                                <td>No. RFQ</td>
                                <td>: {{ $negoluar->nomor_negoluar }}</td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td>: {{ $negoluar->tanggal_negoluar }}</td>
                            </tr>
                            <tr>
                                <td><strong>Quot. Deadline</strong></td>
                                <td>: {{ $negoluar->batas_negoluar }}</td>
                            </tr>
                        </table>
                        <!-- Deliver to -->
                        <table
                            style="width: 100%; border: 1px solid #000000; border-collapse: collapse; line-height: 0.6;">
                            <tr>
                                <td colspan="2" style="padding: 8px;">Deliver to :</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding: 8px;">Unit Logistic</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding: 8px;"><b>PT. INKA MULTI SOLUSI SERVICE</b></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding: 8px;">Jl. Salak No. 59 Madiun</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; width: 20%;">Telp</td>
                                <td style="padding: 8px;">: +62-351-454094</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px;">Fax</td>
                                <td style="padding: 8px;">: -</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px;">Email</td>
                                <td style="padding: 8px;">: logistik@imsservice.co.id</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <div style="clear: both;"></div>

            <div class="content">
                <p>Dear Sir / Madam,</p>
                <p>
                    According to your quotation sheet No. <b
                        style="font-size: 11px">{{ $negoluar->no_jawaban_vendor }}</b>, we would like to negotiate the
                    price and delivery time as follows:
                </p>

                @php
                    $total_penawaran = 0;
                    $total_negosiasi = 0;
                    $nomor = 1;
                @endphp

                @foreach ($negoluar->details->chunk(5) as $chunk)
                    <table class="table" align="center" border="1" cellspacing="0" cellpadding="5"
                        style="width: 100%; margin-bottom: 20px;">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Material</th>
                                <th rowspan="2">Specification</th>
                                <th rowspan="2">Qty</th>
                                <th rowspan="2">Unit</th>
                                <th colspan="2">Vendor Offer</th>
                                <th colspan="2">PT. IMSS Negotiation</th>
                            </tr>
                            <tr>
                                <th>Unit Price ({{ $symbol }})</th>
                                <th>Total Price ({{ $symbol }})</th>
                                <th>Unit Price ({{ $symbol }})</th>
                                <th>Total Price ({{ $symbol }})</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($chunk as $item)
                                @php
                                    $harga = $item->harga_per_unit ?? 0;
                                    $harga_imss = $item->harga_per_unit_imss ?? 0;
                                    $total = $item->negoluar_qty * $harga;
                                    $total_imss = $item->negoluar_qty * $harga_imss;
                                    $total_penawaran += $total;
                                    $total_negosiasi += $total_imss;
                                @endphp
                                <tr>
                                    <td style="text-align: center;">{{ $nomor++ }}</td>
                                    <td>{{ $item->uraian }}</td>
                                    <td>{{ $item->spek }}</td>
                                    <td style="text-align: center;">{{ $item->negoluar_qty }}</td>
                                    <td style="text-align: center;">{{ $item->satuan }}</td>
                                    <td>{{ $symbol }} {{ number_format($harga, 2) }}</td>
                                    <td>{{ $symbol }} {{ number_format($total, 2) }}</td>
                                    <td>{{ $symbol }} {{ number_format($harga_imss, 2) }}</td>
                                    <td>{{ $symbol }} {{ number_format($total_imss, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        @if ($loop->last)
                            <tfoot>
                                <tr>
                                    <td colspan="6" style="text-align: center; font-weight: bold;">Total</td>
                                    <td style="font-weight: bold;">{{ $symbol }}
                                        {{ number_format($total_penawaran, 2) }}</td>
                                    <td></td>
                                    <td style="font-weight: bold;">{{ $symbol }}
                                        {{ number_format($total_negosiasi, 2) }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                    @if (!$loop->last)
                        <div class="page-break"></div>
                    @endif
                @endforeach

                <p>Deal price with notes:</p>
                @php
                    $data = $negoluar->keterangan_nego ?? '';
                    $items = array_filter(explode("\n", $data));
                @endphp

                @if (count($items))
                    <table style="width: 100%; border-collapse: collapse;">
                        @foreach ($items as $index => $item)
                            @php
                                $parts = explode(':', $item, 2);
                                $label = trim($parts[0] ?? '');
                                $value = trim($parts[1] ?? '');
                            @endphp
                            <tr>
                                <td style="width: 5%;">{{ $index + 1 }}.</td>
                                <td style="width: 20%;">{{ $label }}</td>
                                <td style="width: 2%;">:</td>
                                <td>{{ $value }}</td>
                            </tr>
                        @endforeach
                    </table>
                    
                @else
                    <p>-</p>
                @endif
            </div>
        @endforeach


    </div>
</body>

</html>
