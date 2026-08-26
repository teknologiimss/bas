<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Checksheet Chiller</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 8mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #000;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }

        .logo {
            max-width: 180px;
            max-height: 80px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .jenis-box {
            font-size: 26px;
            font-weight: bold;
        }

        .signature-title {
            font-weight: bold;
            font-size: 10px;
        }

        .signature-space {
            height: 60px;
        }

        .symbol {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 13px;
            font-weight: bold;
        }

        /* Styling Khusus Lampiran Foto */
        .page-break {
            page-break-before: always;
        }

        .attachment-title {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 12px;
            padding: 6px;
            background-color: #f2f2f2;
            border: 1px solid #000;
        }

        .photo-img {
            max-width: 100%;
            max-height: 180px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
            border: 1px solid #ddd;
        }

        .photo-meta {
            font-size: 9px;
            line-height: 1.3;
            margin-top: 4px;
        }
    </style>
</head>

<body>

    {{-- HEADER KOP --}}
    <table>
        <tr>
            <td width="25%" class="text-center" style="padding: 8px; height: 80px;">
                @php
                    $path = public_path('img/IMST.png');
                    $logoData = '';
                    if (file_exists($path)) {
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $logoData = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    }
                @endphp

                @if ($logoData)
                    <img src="{{ $logoData }}" class="logo" alt="Logo IMST">
                @else
                    <strong style="font-size: 20px; color: #c00;">IMST</strong>
                @endif
            </td>
            <td width="60%" class="text-center">
                <div style="font-size: 16px; font-weight: bold;">{{ strtoupper($chiller->judul) }}</div>
            </td>
            <td width="15%" class="text-center jenis-box">
                {{ $chiller->jenis_perawatan }}
            </td>
        </tr>
    </table>

    {{-- METADATA UNIT --}}
    <table style="border-top: none;">
        <tr class="text-bold text-center">
            <td width="33%">NO ASET : {{ $chiller->no_aset ?? '0' }}</td>
            <td width="33%">LOKASI : {{ $chiller->lokasi ?? '0' }}</td>
            <td width="34%">NO CHILLER : {{ $chiller->no_chiller }}</td>
        </tr>
    </table>

    {{-- TABEL PEKERJAAN --}}
    <table style="border-top: none;">
        <thead>
            <tr style="background: #f2f2f2;">
                <th width="5%" rowspan="2">No.</th>
                <th width="30%" rowspan="2">Uraian Pekerjaan</th>
                <th width="35%" rowspan="2">Aktivitas Pekerjaan</th>
                <th width="20%" rowspan="2">Standar</th>
                <th width="10%" colspan="2">Status</th>
            </tr>
            <tr style="background: #f2f2f2;">
                <th width="5%">OK</th>
                <th width="5%">NOK</th>
            </tr>
        </thead>
        <tbody>
            @php
                $groupedItems = $chiller->items->groupBy('uraian_pekerjaan');
            @endphp

            @foreach ($groupedItems as $uraian => $group)
                @php
                    $rowCount = $group->count();
                    $firstItem = $group->first();
                @endphp

                @foreach ($group as $index => $item)
                    <tr>
                        @if ($index === 0)
                            <td class="text-center" rowspan="{{ $rowCount }}">{{ $firstItem->nomor }}</td>
                            <td class="text-bold" rowspan="{{ $rowCount }}">{{ $uraian }}</td>
                        @endif

                        <td>{{ $item->aktivitas_pekerjaan }}</td>
                        <td>{{ $item->standar }}</td>
                        <td class="text-center symbol">{{ $item->status == 'OK' ? '✓' : '' }}</td>
                        <td class="text-center symbol">{{ $item->status == 'NOK' ? '✓' : '' }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    {{-- KESIMPULAN & CATATAN --}}
    <table style="border-top: none;">
        <tr>
            <td style="padding: 8px;">
                <div><b>Kesimpulan :</b></div>
                <div>
                    Berdasarkan hasil perawatan, maka Chiller dinyatakan :
                    <span
                        style="{{ $chiller->kesimpulan == 'SO' ? 'text-decoration: underline; font-weight: bold;' : '' }}">SO</span>
                    /
                    <span
                        style="{{ $chiller->kesimpulan == 'SO DENGAN CATATAN' ? 'text-decoration: underline; font-weight: bold;' : '' }}">SO
                        dengan catatan</span>
                    /
                    <span
                        style="{{ $chiller->kesimpulan == 'TSO' ? 'text-decoration: underline; font-weight: bold;' : '' }}">TSO</span>
                    <i>( Pilih salah satu )</i>
                </div>
                <div style="margin-top: 8px;"><b>Catatan:</b></div>
                <div style="min-height: 40px;">{{ $chiller->catatan ?? '-' }}</div>
            </td>
        </tr>
    </table>

    {{-- TANGGAL & DURASI --}}
    <table style="border-top: none;">
        <tr>
            <td width="30%" class="text-bold">TANGGAL PELAKSANAAN</td>
            <td width="70%">
                {{ $chiller->tanggal_pelaksanaan ? \Carbon\Carbon::parse($chiller->tanggal_pelaksanaan)->isoFormat('D MMMM Y') : '-' }}
            </td>
        </tr>
        <tr>
            <td class="text-bold">DURASI PEKERJAAN</td>
            <td>{{ $chiller->durasi_pekerjaan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="text-bold">JUMLAH PERSONIL</td>
            <td>{{ $chiller->personil ?? '-' }}</td>
        </tr>
    </table>

    {{-- TANDA TANGAN --}}
    <table style="border-top: none;">
        <tr class="text-center signature-title">
            <td width="50%">MENGETAHUI,<br>KEPALA DEPARTEMEN MRO</td>
            <td width="50%">PELAKSANA</td>
        </tr>
        <tr class="text-center">
            <td class="signature-space"></td>
            <td class="signature-space"></td>
        </tr>
        <tr class="text-center">
            <td>(
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                )</td>
            <td>(
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                )</td>
        </tr>
    </table>

    {{-- LAMPIRAN FOTO INSPEKSI (DIPISAH HALAMAN BARU HANYA JIKA ADA FOTO) --}}
    @php
        $hasPhotos = $chiller->items->pluck('photos')->flatten()->isNotEmpty();
    @endphp

    @if ($hasPhotos)
        <div class="page-break"></div>

        <div class="attachment-title">LAMPIRAN FOTO INSPEKSI MAINTENANCE CHILLER</div>

        <table>
            <thead>
                <tr style="background: #f2f2f2;">
                    <th width="5%">No.</th>
                    <th width="35%">Aktivitas Pekerjaan & Status</th>
                    <th width="60%">Dokumentasi Foto & Geolocation</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($chiller->items as $item)
                    @if ($item->photos->isNotEmpty())
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>
                                <strong>{{ $item->uraian_pekerjaan }}</strong><br>
                                <span style="color: #555;">{{ $item->aktivitas_pekerjaan }}</span><br><br>
                                <strong>Status:</strong> {{ $item->status ?? '-' }}<br>
                            </td>
                            <td>
                                <table style="border: none; width: 100%;">
                                    @foreach ($item->photos as $photo)
                                        @php
                                            $photoPath = public_path('uploads/chiller/' . $photo->foto);
                                            $photoData = '';
                                            if (file_exists($photoPath) && !empty($photo->foto)) {
                                                $ext = pathinfo($photoPath, PATHINFO_EXTENSION);
                                                $imgRaw = file_get_contents($photoPath);
                                                $photoData = 'data:image/' . $ext . ';base64,' . base64_encode($imgRaw);
                                            }
                                        @endphp
                                        <tr style="border: none;">
                                            <td style="border: none; text-align: center; padding: 5px;" width="50%">
                                                @if ($photoData)
                                                    <img src="{{ $photoData }}" class="photo-img"
                                                        alt="Foto Inspeksi">
                                                @else
                                                    <em style="color: red;">[Gambar tidak ditemukan]</em>
                                                @endif
                                            </td>
                                            <td style="border: none; padding: 5px;" width="50%">
                                                <div class="photo-meta">
                                                    @if ($photo->alamat)
                                                        <b>Lokasi:</b> {{ $photo->alamat }}<br>
                                                    @endif
                                                    <b>Waktu Upload:</b>
                                                    {{ $photo->created_at ? $photo->created_at->format('d-m-Y H:i') : '-' }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif

</body>

</html>
