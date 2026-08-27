<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Checksheet Pompa</title>
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
            padding: 4px 6px;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }

        .logo {
            max-width: 160px;
            max-height: 70px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .jenis-box {
            font-size: {{ $pompa->jenis_perawatan == 'Unscheduled' ? '14px' : '26px' }};
            font-weight: bold;
        }

        .symbol {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 13px;
            font-weight: bold;
        }

        .page-break {
            page-break-before: always;
        }

        .photo-img {
            max-width: 100%;
            max-height: 160px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>

<body>

    {{-- HEADER KOP SESUAI GAMBAR --}}
    <table>
        <tr>
            <td width="25%" class="text-center" style="padding: 5px;">
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
                    <strong style="font-size: 18px; color: #c00;">IMSS</strong>
                @endif
            </td>
            <td width="60%" class="text-center">
                <div style="font-size: 14px; font-weight: bold;">{{ strtoupper($pompa->judul) }}</div>
                @if ($pompa->jenis_perawatan == 'Unscheduled' && $pompa->no_form_unscheduled)
                    <div style="font-size: 10px; margin-top: 4px;">NO. FORM: {{ $pompa->no_form_unscheduled }}</div>
                @endif
            </td>
            <td width="15%" class="text-center jenis-box">
                {{ $pompa->jenis_perawatan }}
            </td>
        </tr>
    </table>

    {{-- METADATA --}}
    <table style="border-top: none;">
        <tr class="text-bold">
            <td width="50%" style="border-right: none;">
                TANGGAL PERAWATAN :
                {{ $pompa->tanggal_pelaksanaan ? \Carbon\Carbon::parse($pompa->tanggal_pelaksanaan)->format('d/m/Y') : '-' }}
            </td>
            <td width="50%" class="text-end" style="border-left: none; text-align: right;">
                No POMPA: {{ $pompa->no_pompa ?? '-' }}
            </td>
        </tr>
    </table>

    @if ($pompa->jenis_perawatan == 'Unscheduled')
        <table style="border-top: none;">
            <tr>
                <td width="30%" class="text-bold">STATUS KONDISI</td>
                <td width="70%">
                    <span class="symbol">{{ $pompa->status_kondisi == 'OK' ? '[ ✓ ] OK' : '[  ] OK' }}</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="symbol">{{ $pompa->status_kondisi == 'NOK' ? '[ ✓ ] NOK' : '[  ] NOK' }}</span>
                </td>
            </tr>
            <tr>
                <td class="text-bold">JENIS KERUSAKAN</td>
                <td>{!! nl2br(e($pompa->jenis_kerusakan ?? '-')) !!}</td>
            </tr>
            <tr>
                <td class="text-bold">TINDAK LANJUT PERBAIKAN</td>
                <td>{!! nl2br(e($pompa->tindak_lanjut ?? '-')) !!}</td>
            </tr>
        </table>
    @else
        {{-- TABEL UTAMA SESUAI FOTO DISAMPAIKAN USER --}}
        <table style="border-top: none;">
            <thead>
                <tr style="background: #f2f2f2;">
                    <th width="5%" rowspan="2">No.</th>
                    <th width="25%" rowspan="2">Uraian pekerjaan</th>
                    <th width="40%" rowspan="2">Aktivitas Pekerjaan</th>
                    <th width="20%" rowspan="2">Standar</th>
                    <th width="10%" colspan="2">Status</th>
                </tr>
                <tr style="background: #f2f2f2;">
                    <th width="5%">OK</th>
                    <th width="5%">NOK</th>
                </tr>
            </thead>
            <tbody>
                @php $groupedItems = $pompa->items->groupBy('uraian_pekerjaan'); @endphp
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

        {{-- KESIMPULAN & CATATAN SESUAI GAMBAR --}}
        <table style="border-top: none;">
            <tr>
                <td style="padding: 6px;">
                    <div><b>Kesimpulan :</b></div>
                    <div>
                        Berdasarkan hasil perawatan, maka Pompa dinyatakan :
                        <span
                            style="{{ $pompa->kesimpulan == 'SO' ? 'text-decoration: underline; font-weight: bold;' : '' }}">SO</span>
                        /
                        <span
                            style="{{ $pompa->kesimpulan == 'SO DENGAN CATATAN' ? 'text-decoration: underline; font-weight: bold;' : '' }}">SO
                            dengan catatan</span> /
                        <span
                            style="{{ $pompa->kesimpulan == 'TSO' ? 'text-decoration: underline; font-weight: bold;' : '' }}">TSO</span>
                        <br><small><i>( pilih salah satu )</i></small>
                    </div>
                    <div style="margin-top: 6px;"><b>Catatan:</b></div>
                    <div style="min-height: 50px;">{{ $pompa->catatan ?? '' }}</div>
                </td>
            </tr>
        </table>
    @endif

    {{-- TANDA TANGAN 3 PILAR (PEMILIK ASET, KADEP PEMELIHARAAN, USER) SESUAI GAMBAR --}}
    <table style="border-top: none;">
        <tr class="text-center text-bold" style="font-size: 10px;">
            <td width="33%">KEPALA DEPARTEMEN MRO</td>
            {{-- <td width="34%">KADEP PEMELIHARAAN</td> --}}
            <td width="33%">PELAKSANA</td>
        </tr>
        <tr class="text-center">
            <td style="height: 55px;"></td>
            {{-- <td style="height: 55px;"></td> --}}
            <td style="height: 55px;"></td>
        </tr>
        <tr class="text-center">
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
            {{-- <td>(
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                )</td> --}}
            <td>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
        </tr>
    </table>

    {{-- LAMPIRAN FOTO --}}
    @php $hasPhotos = $pompa->items->pluck('photos')->flatten()->isNotEmpty(); @endphp
    @if ($hasPhotos)
        <div class="page-break"></div>
        <div
            style="font-size: 13px; font-weight: bold; text-align: center; margin-bottom: 10px; padding: 5px; background: #eee; border: 1px solid #000;">
            LAMPIRAN FOTO INSPEKSI MAINTENANCE POMPA
        </div>
        <table>
            <thead>
                <tr style="background: #f2f2f2;">
                    <th width="5%">No.</th>
                    <th width="35%">Aktivitas Pekerjaan & Status</th>
                    <th width="60%">Foto Inspeksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($pompa->items as $item)
                    @if ($item->photos->isNotEmpty())
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td>
                                <strong>{{ $item->uraian_pekerjaan }}</strong><br>
                                <span>{{ $item->aktivitas_pekerjaan }}</span><br>
                                <strong>Status:</strong> {{ $item->status ?? '-' }}
                            </td>
                            <td>
                                <table style="border: none;">
                                    @foreach ($item->photos as $photo)
                                        @php
                                            $photoPath = public_path('uploads/pompa/' . $photo->foto);
                                            $photoData = '';
                                            if (file_exists($photoPath) && !empty($photo->foto)) {
                                                $ext = pathinfo($photoPath, PATHINFO_EXTENSION);
                                                $photoData =
                                                    'data:image/' .
                                                    $ext .
                                                    ';base64,' .
                                                    base64_encode(file_get_contents($photoPath));
                                            }
                                        @endphp
                                        <tr style="border: none;">
                                            <td style="border: none; text-align: center;">
                                                @if ($photoData)
                                                    <img src="{{ $photoData }}" class="photo-img">
                                                @endif
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
