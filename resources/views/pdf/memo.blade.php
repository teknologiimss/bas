<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>MEMO - {{ $memo->nomor_memo }}</title>
    <style>
        @page {
            margin: 0mm 15mm 20mm 15mm;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10pt;
            color: #000;
            line-height: 1.3;
            margin-top: 0;
            padding-top: 0;
        }

        .header-logo {
            text-align: right;
            margin-top: 0;
            margin-bottom: 5px;
        }

        .header-logo img {
            height: 100px;
            width: auto;
        }

        .title {
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .meta-table td {
            padding: 2px 0;
            vertical-align: top;
            font-size: 10pt;
        }

        .divider {
            border-bottom: 1.5px solid #000;
            margin-bottom: 12px;
        }

        .box-container {
            width: 100%;
            border: 1px solid #000;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .box-container td {
            width: 50%;
            padding: 6px 10px;
            border: 1px solid #000;
            vertical-align: top;
            font-size: 9.5pt;
        }

        .content {
            margin-bottom: 12px;
        }

        .content p {
            margin: 0 0 6px 0;
            text-align: justify;
        }

        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
        }

        .item-table th,
        .item-table td {
            border: 1px solid #000;
            padding: 5px;
            font-size: 9pt;
            vertical-align: top;
        }

        .item-table th {
            text-align: center;
            font-weight: bold;
        }

        .note {
            font-weight: bold;
            font-size: 9.5pt;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        /* Tabel Tanda Tangan */
        .footer-ttd {
            width: 100%;
            margin-top: 25px;
        }

        .footer-ttd td {
            text-align: center;
            vertical-align: top;
        }

        .ttd-img {
            height: 70px;
            width: auto;
            margin: 5px 0;
        }

        /* Style Halaman Lampiran Baru */
        .page-break {
            page-break-before: always;
        }

        .lampiran-container {
            text-align: center;
            margin-top: 20px;
        }

        .lampiran-img {
            max-width: 100%;
            max-height: 700px;
            height: auto;
            border: 1px solid #ccc;
            margin-top: 15px;
        }

        .footer-address {
            position: fixed;
            bottom: -10mm;
            left: 0;
            right: 0;
            border-top: 1px solid #000;
            padding-top: 4px;
            font-size: 7.5pt;
            color: #000;
        }

        .footer-address strong {
            color: #070707;
        }
    </style>
</head>

<body>

    <!-- Header Logo -->
    <div class="header-logo">
        @if (file_exists(public_path('img/imst.png')))
            <img src="{{ public_path('img/imst.png') }}" alt="Logo IMST">
        @else
            <strong style="font-size: 20pt; color: #002060;">IMST</strong>
        @endif
    </div>

    <!-- Judul -->
    <div class="title">MEMO</div>

    <!-- Info Header -->
    <table class="meta-table">
        <tr>
            <td width="12%">Tanggal</td>
            <td width="3%">:</td>
            <td>{{ \Carbon\Carbon::parse($memo->tanggal)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>Nomor</td>
            <td>:</td>
            <td>{{ $memo->nomor_memo }}</td>
        </tr>
        <tr>
            <td>Hal</td>
            <td>:</td>
            <td>{{ $memo->hal }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <!-- Dari & Kepada Box -->
    <table class="box-container">
        <tr>
            <td>
                <strong>Dari :</strong><br>
                <b>{{ $memo->dari }}</b>
            </td>
            <td>
                <strong>Kepada Yth. :</strong><br>
                <b>{{ $memo->kepada }}</b>
            </td>
        </tr>
    </table>

    <!-- Paragraf Pembuka -->
    <div class="content">
        <p>Dengan hormat,</p>
        @if ($memo->pembuka)
            <p>{!! nl2br(e($memo->pembuka)) !!}</p>
        @endif

        @if ($memo->isi_utama)
            <p>{!! nl2br(e($memo->isi_utama)) !!}</p>
        @endif
    </div>

    <!-- Tabel Rincian -->
    @if ($memo->has_table && count($memo->items) > 0)
        <table class="item-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">Uraian Barang</th>
                    <th width="40%">Spesifikasi</th>
                    <th width="7%">Qty</th>
                    <th width="8%">Sat</th>
                    <th width="20%">Ket</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($memo->items as $index => $item)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td>{{ $item->uraian_barang }}</td>
                        <td>{!! nl2br(e($item->spesifikasi)) !!}</td>
                        <td style="text-align: center;">{{ $item->qty }}</td>
                        <td style="text-align: center;">{{ $item->satuan }}</td>
                        <td>{{ $item->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Note -->
    @if ($memo->catatan_note)
        <div class="note">
            <u>Note :</u><br>
            {!! nl2br(e($memo->catatan_note)) !!}
        </div>
    @endif

    <!-- Paragraf Penutup -->
    @if ($memo->penutup)
        <div class="content">
            <p>{!! nl2br(e($memo->penutup)) !!}</p>
        </div>
    @endif

    <!-- Tanda Tangan -->
    <table class="footer-ttd">
        <tr>
            <td width="60%"></td>
            <td width="40%">
                <strong>PT INKA Multi Solusi Trading,</strong><br>
                <strong>{{ $memo->jabatan_penandatangan ?? 'Kepala Divisi Wilayah II' }}</strong>
                <br>

                {{-- Opsi 1: Tampil Gambar Tanda Tangan Jika Ada --}}
                @if ($memo->ttd_path && file_exists(public_path($memo->ttd_path)))
                    <img src="{{ public_path($memo->ttd_path) }}" class="ttd-img"><br>
                @else
                    <br><br><br><br>
                @endif

                <strong><u>{{ $memo->nama_penandatangan }}</u></strong>
            </td>
        </tr>
    </table>

    <!-- 🎯 HALAMAN LAMPIRAN (OTOMATIS PINDAH HALAMAN BARU) -->
    <!-- HALAMAN LAMPIRAN -->
    <!-- HALAMAN LAMPIRAN (KHUSUS GAMBAR) -->
    @php
        $ext = $memo->lampiran_path
            ? strtolower(pathinfo(public_path($memo->lampiran_path), PATHINFO_EXTENSION))
            : null;
    @endphp

    @if (
        $memo->lampiran_path &&
            file_exists(public_path($memo->lampiran_path)) &&
            in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
        <div style="page-break-before: always;"></div>

        <div style="text-align: center; font-weight: bold; font-size: 14pt; margin-top: 20px;">
            LAMPIRAN MEMO
        </div>
        <p style="text-align: center; font-size: 11pt; font-weight: bold; margin-bottom: 20px;">
            {{ $memo->judul_lampiran ?? 'Dokumen Pendukung / Lampiran' }}
        </p>

        <div style="text-align: center;">
            <img src="{{ public_path($memo->lampiran_path) }}"
                style="max-width: 100%; max-height: 700px; height: auto; border: 1px solid #ddd; padding: 5px;">
        </div>
    @endif

    <!-- Footer Alamat -->
    <div class="footer-address">
        <strong>PT INKA MULTI SOLUSI TRADING</strong><br>
        Jl. Ring Road Barat, Ngegong, Manguharjo, Kota Madiun - 63125 | Telp : (0351) 2810737 | Website : imst.id |
        Email : corporate@imst.id
    </div>

</body>

</html>
