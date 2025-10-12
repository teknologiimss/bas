<!DOCTYPE html>
<html>

<head>
    <title>SPPH-{{ $spphrfq->nomor_spphrfq }}</title>
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
            font-family: Verdana, Arial, sans-serif;
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

        table.table th,
        table.table td {
            font-size: 10px;
            /* Mengatur ukuran font di dalam tabel */
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

        <div style="position: fixed; bottom: 10; width: 91%; text-align: left; right: 4%">
            <div style="border-bottom: 3px solid red; padding-top: 5px;">
                <b style="font-size: 11px">PT INKA MULTI SOLUSI SERVICE</b>
                <div style="font-size: 9px; margin-top: 2px;">
                    Kantor Pusat : Jl. Salak No.59 Madiun, Telp (0351) 454094, Website : www.imsservice.co.id, Email :
                    imss.log@gmail.com
                </div>
            </div>

        </div>
    </header>

    <div class="judul-konten">REQUEST FOR QUOTATION (RFQ)</div>
    <div class="container">
        @foreach ($spphrfqs as $sp)
            {{-- <div class="date">
                <p>{{ $spphrfq->tanggal_spphrfq }}</p>
            </div> --}}

            <table style="width: 100%;">
                <tr>
                    <!-- Kolom Kiri: Vendor -->
                    <td style="vertical-align: top; width: 50%;">
                        <table style="width: 100%; border: 1px solid #000000; padding: 0px;line-height: 1.4;">
                            <tr>
                                <td colspan="2">Vendor :</td>
                            </tr>
                            <tr>
                                <td colspan="2"><b>{!! nl2br($sp->nama) !!}</b></td>
                            </tr>
                            <tr>
                                <td colspan="2">{{ $sp->alamat }}</td>
                            </tr>
                            <tr>
                                <td style="width: 60px;">Telp</td>
                                <td>: {{ $sp->telp }}</td>
                            </tr>
                            <tr>
                                <td>Fax</td>
                                <td>: {{ $sp->fax }}</td>
                            </tr>

                            <tr>
                                <td valign="top">Email</td>
                                <td>
                                    @php
                                        $emails = array_map('trim', explode(',', $sp->email));
                                    @endphp

                                    @if (count($emails) == 1)
                                        : {{ $emails[0] }}
                                    @else
                                        @foreach ($emails as $loopIndex => $email)
                                            @if ($loopIndex == 0)
                                                : - {{ $email }}<br>
                                            @else
                                                &nbsp; - {{ $email }}<br>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">Contact Person</td>
                                <td>
                                    @php
                                        $cps = array_map('trim', explode(',', $sp->cp));
                                    @endphp

                                    @if (count($cps) == 1)
                                        : {{ $cps[0] }}
                                    @else
                                        @foreach ($cps as $loopIndex => $cp)
                                            @if ($loopIndex == 0)
                                                : - {{ $cp }}<br>
                                            @else
                                                &nbsp; - {{ $cp }}<br>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                            </tr>



                        </table>
                    </td>

                    <!-- Kolom Kanan: Info Surat -->
                    <td style="vertical-align: top; width: 50%;">
                        <table style="width: 100%; border: 1px solid #000000; padding: 10px;">
                            <tr>
                                <td>No. RFQ</td>
                                <td>: {{ $spphrfq->nomor_spphrfq }}</td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td>: {{ $spphrfq->tanggal_spphrfq }}</td>
                            </tr>
                            {{-- <tr>
                                <td><strong>Lampiran</strong></td>
                                <td>: {{ __($spphrfq->lampiran) > 0 ? $spphrfq->lampiran . ' Lembar' : '-' }}</td>
                            </tr> --}}
                            <tr>
                                <td><strong>Quot. Deadline</strong></td>
                                <td>: {{ $spphrfq->batas_spphrfq }}</td>
                            </tr>
                        </table>
                        <!-- Tambahan tabel untuk Deliver to -->
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
                <p style="text-align: justify">
                    Please quote your net price and delivery on the following article in the quantities shown here, and
                    return it to our office.
                    If you are not prepare to quote, return this document and state your reason.

                </p>

                @php
                    $detailsChunks = $spphrfq->details->chunk(5);
                    $nomor = 1; // Inisialisasi nomor urut di luar loop chunk
                @endphp

                @foreach ($detailsChunks as $details)
                    <table class="table" align="center">
                        <thead>
                            <tr>
                                <th style="text-align: center">No</th>
                                <th style="text-align: center">Description</th>
                                <th style="text-align: center">Specification</th>
                                <th style="text-align: center">Qty</th>
                                <th style="text-align: center">Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $item)
                                <tr>
                                    <td style="text-align: center">{{ $nomor++ }}</td>
                                    <td
                                        style="word-wrap: break-word; max-width: 90px; overflow: hidden; text-overflow: ellipsis; text-align: left;">
                                        {{ $item->uraian }}
                                    </td>
                                    <td
                                        style="word-wrap: break-word; max-width: 90px; overflow: hidden; text-overflow: ellipsis; text-align: left;">
                                        {{ $item->spek }}
                                    </td>
                                    <td style="text-align: center">{{ $item->spphrfq_qty }}</td>
                                    <td style="text-align: center">{{ $item->satuan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if (!$loop->last)
                        <div class="page-break"></div>
                    @endif
                @endforeach



                {{-- Jika teks mengandung :, maka akan dipisahkan menjadi label dan isi, Jika teks tidak mengandung :, maka seluruh teks ditampilkan dalam satu kolom --}}
                <table class="tabel-2" style="width:100%; font-size: 10px !important;">
                    <tr>
                        <td>
                            @php
                                $data = $spphrfq->keterangan_spphrfq ?? '';
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
                                        <td style="width: 5%; vertical-align: top;">-</td>
                                        @if ($label)
                                            <td style="width: 20%; vertical-align: top;">{{ $label }}</td>
                                            <td style="width: 2%; vertical-align: top; white-space: nowrap;">:</td>
                                            <td style="width: 70%;">{{ $value }}</td>
                                        @else
                                            <td colspan="3" style="width: 92%; vertical-align: top;">
                                                {{ $value }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                </table>

                <p>Thank you.</p>
            </div>

            <div style="margin-left: 65%; width: 50%; margin-top: 0; page-break-inside: avoid;">
                <table class="w-100">
                    <tr>
                        <td class="text-center"><b>PT INKA MULTI SOLUSI SERVICE</b></td>
                    </tr>

                    <tr>
                        <td style="height: 70px"></td>
                    </tr>
                    <tr>
                        <td class="text-center" style="text-align: center"><b style="text-decoration: underline; ">RUDY
                                SUSANTO</b>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center" style="text-align: center"><b>Head of Logistic Department</b></td>
                    </tr>
                </table>
            </div>



            @if ($count > 1 && $loop->iteration < $count)
                <div class="page-break"></div>
            @endif
        @endforeach
    </div>
</body>

</html>
