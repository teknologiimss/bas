<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Kasbon - {{ $folder->judul }}</title>
    <style>
        @page {
            margin: 100px 40px 40px 40px;
            /* Margin atas diberikan ruang untuk header logo fixed */
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Header Logo Fixed di Setiap Halaman */
        .page-header-logo {
            position: fixed;
            top: -120px;
            right: 0;
            left: 0;
            height: 80px;
            text-align: right;
        }

        .page-header-logo img {
            max-height: 100px;
            width: auto;
            object-fit: contain;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 0 0 5px 0;
            text-transform: uppercase;
            font-size: 16pt;
        }

        .header p {
            margin: 0;
            font-size: 9pt;
            color: #666;
        }

        .meta-table {
            width: 100%;
            margin-bottom: 15px;
        }

        .meta-table td {
            padding: 3px 0;
            vertical-align: top;
            font-size: 10pt;
        }

        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .table-data th,
        .table-data td {
            border: 1px solid #777;
            padding: 6px 8px;
            font-size: 9pt;
            vertical-align: top;
        }

        .table-data th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }

        .summary-box {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        .summary-box td {
            padding: 5px 10px;
            border: 1px solid #ccc;
            font-size: 9pt;
        }

        .footer-sign {
            margin-top: 30px;
            width: 100%;
            page-break-inside: avoid;
        }

        .footer-sign td {
            text-align: center;
            vertical-align: bottom;
            height: 60px;
            font-size: 10pt;
        }

        /* ================= LAMPIRAN FOTO SEJAJAR ================= */
        .page-break {
            page-break-before: always;
        }

        .attachment-section {
            margin-top: 10px;
        }

        .attachment-card {
            border: 1px solid #999;
            padding: 10px;
            margin-bottom: 15px;
            page-break-inside: avoid;
            background-color: #fafafa;
        }

        .attachment-title {
            font-weight: bold;
            font-size: 10pt;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 4px;
        }

        /* Table khusus untuk menyusun foto sejajar ke samping */
        .gallery-table {
            width: 100%;
            border-collapse: collapse;
        }

        .gallery-table td {
            text-align: center;
            vertical-align: top;
            padding: 6px;
            border: none;
        }

        /* Ukuran Foto Lebih Besar & Jelas */
        .thumb-img {
            max-width: 100%;
            max-height: 260px;
            object-fit: contain;
            border: 1px solid #bbb;
            background-color: #fff;
            padding: 4px;
            border-radius: 4px;
            display: inline-block;
        }

        .img-caption {
            font-size: 8.5pt;
            color: #444;
            margin-top: 5px;
            font-weight: 500;
        }
    </style>
</head>

<body>

    <!-- ================= LOGO DIPOSISIKAN DI SINI (AKAN OTOMATIS MUNCUL DI SETIAP HALAMAN) ================= -->
    <div class="page-header-logo">
        <img src="{{ public_path('img/IMST.png') }}" alt="Logo Perusahaan">
    </div>

    <!-- ================= LAPORAN UTAMA (TANPA FOTO) ================= -->
    <div class="header">
        <h2>LAPORAN RINCIAN KASBON</h2>
        {{-- <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p> --}}
    </div>

    <table class="meta-table">
        <tr>
            <td style="width: 15%;"><strong>Judul Pekerjaan</strong></td>
            <td style="width: 2%;">:</td>
            <td style="width: 33%;">{{ $folder->judul }}</td>
            <td style="width: 20%;"><strong>PO / Nota Dinas</strong></td>
            <td style="width: 2%;">:</td>
            <td style="width: 28%;">{{ $folder->po_nota_dinas }}</td>
        </tr>
    </table>

    <table class="table-data">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 33%;">Deskripsi</th>
                <th style="width: 17%;">Uang Masuk</th>
                <th style="width: 17%;">Uang Keluar</th>
                <th style="width: 13%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($folder->items as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $item->deskripsi }}</td>
                    <td class="text-right">Rp {{ number_format($item->uang_masuk, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->uang_keluar, 0, ',', '.') }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada rincian transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="summary-box">
        <tr>
            <td style="width: 60%;" class="font-bold">Total Uang Masuk</td>
            <td style="width: 40%;" class="text-right font-bold">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="font-bold">Total Uang Keluar</td>
            <td class="text-right font-bold">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="font-bold" style="background-color: #f9f9f9;">Selisih (Sisa Kasbon)</td>
            <td class="text-right font-bold" style="background-color: #f9f9f9;">Rp
                {{ number_format($selisih, 0, ',', '.') }}</td>
        </tr>
        {{-- <tr>
            <td class="font-bold">Persentase Sisa Kasbon</td>
            <td class="text-right font-bold">{{ number_format($persen, 2) }}%</td>
        </tr> --}}
    </table>

    <!-- ================= BLOK TANDA TANGAN (SEBELAH KANAN) ================= -->
    <table class="footer-sign">
        <tr>
            <td style="width: 60%;"></td> <!-- Elemen penyeimbang di sebelah kiri -->
            <td style="width: 40%;">
                Dibuat Oleh,<br><br><br><br>
                ( ______________________ )
            </td>
        </tr>
    </table>


    <!-- ================= HALAMAN LAMPIRAN FOTO SEJAJAR ================= -->
    @php
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $hasAnyImage = false;

        foreach ($folder->items as $item) {
            foreach ((array) $item->dokumen as $doc) {
                $ext = strtolower(pathinfo($doc, PATHINFO_EXTENSION));
                if (in_array($ext, $imageExtensions)) {
                    $hasAnyImage = true;
                    break 2;
                }
            }
        }
    @endphp

    @if ($hasAnyImage)
        <div class="page-break"></div>

        <div class="header">
            <h2>LAMPIRAN DOKUMENTASI</h2>
            <p>Proyek: {{ $folder->judul }} ({{ $folder->po_nota_dinas }})</p>
        </div>

        <div class="attachment-section">
            @foreach ($folder->items as $itemIndex => $item)
                @php
                    $docs = (array) $item->dokumen;
                    $validImages = [];

                    foreach ($docs as $docPath) {
                        $ext = strtolower(pathinfo($docPath, PATHINFO_EXTENSION));
                        $fullPath = public_path('img/' . $docPath);
                        if (in_array($ext, $imageExtensions) && file_exists($fullPath)) {
                            $validImages[] = [
                                'path' => $fullPath,
                                'filename' => $docPath,
                            ];
                        }
                    }
                @endphp

                @if (count($validImages) > 0)
                    <div class="attachment-card">
                        <div class="attachment-title">
                            Item #{{ $itemIndex + 1 }}: {{ $item->deskripsi }}
                            <span style="font-weight: normal; font-size: 8.5pt; color: #555;">
                                (Total Foto: {{ count($validImages) }})
                            </span>
                        </div>

                        {{-- Menampilkan foto sejajar ke samping dengan penanganan maksimal 3 foto per baris --}}
                        <table class="gallery-table">
                            @php
                                $maxPerRow = 3; // Maksimal 3 foto sejajar per baris agar foto tetap besar
                                $chunks = array_chunk($validImages, $maxPerRow);
                            @endphp

                            @foreach ($chunks as $chunk)
                                <tr>
                                    @php
                                        $colWidth = floor(100 / count($chunk));
                                    @endphp

                                    @foreach ($chunk as $imgIndex => $img)
                                        <td style="width: {{ $colWidth }}%;">
                                            <img src="{{ $img['path'] }}" class="thumb-img"
                                                alt="Bukti {{ $imgIndex + 1 }}">
                                            <div class="img-caption">Foto #{{ $imgIndex + 1 }}</div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @endif
            @endforeach
        </div>
    @endif

</body>

</html>
