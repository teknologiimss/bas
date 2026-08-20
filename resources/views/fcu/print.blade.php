<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Checksheet FCU - {{ $fcu->no_fcu }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 8mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8.5pt;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .border-box {
            border: 1.5px solid #000;
            padding: 0;
        }

        /* Header Layout Utama */
        .table-header {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 1.5px solid #000;
        }

        .table-header td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: middle;
        }

        .logo-cell {
            width: 25%;
            text-align: center;
        }

        .logo-img {
            max-width: 110px;
            height: auto;
        }

        .title-cell {
            width: 60%;
            text-align: center;
            font-weight: bold;
            font-size: 10.5pt;
            line-height: 1.2;
        }

        .code-cell {
            width: 15%;
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
        }

        /* Info Section (Tanggal & No FCU) */
        .table-info {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 1.5px solid #000;
            border-top: 1.5px solid #000;
            font-weight: bold;
            font-size: 8.5pt;
        }

        .table-info td {
            padding: 4px 8px;
        }

        /* Main Form Table */
        .table-data {
            width: 100%;
            border-collapse: collapse;
        }

        .table-data th,
        .table-data td {
            border: 1px solid #000;
            padding: 3px 5px;
            font-size: 8pt;
        }

        .table-data th {
            text-align: center;
            font-weight: bold;
            background-color: #ffffff;
        }

        .text-center {
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }

        /* Kesimpulan & Catatan Section */
        .section-kesimpulan {
            border-top: 1.5px solid #000;
            padding: 6px 8px;
            font-size: 8.5pt;
            line-height: 1.3;
        }

        /* Signature Section */
        .table-ttd {
            width: 100%;
            border-collapse: collapse;
            border-top: 1.5px solid #000;
            margin-top: 5px;
        }

        .table-ttd td {
            width: 33.33%;
            text-align: center;
            vertical-align: top;
            font-size: 7.5pt;
            font-weight: bold;
            padding-top: 4px;
        }

        .ttd-space {
            height: 40px;
        }

        .checkmark {
            font-family: 'DejaVu Sans', sans-serif;
        }

        /* CSS Lampiran Foto */
        .page-break {
            page-break-before: always;
        }

        .attachment-header {
            font-weight: bold;
            font-size: 11pt;
            text-align: center;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1.5px solid #000;
        }

        .attachment-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .attachment-card {
            width: 48%;
            border: 1px solid #ccc;
            padding: 5px;
            vertical-align: top;
            text-align: center;
            margin-bottom: 10px;
        }

        .attachment-img {
            max-width: 100%;
            max-height: 180px;
            object-fit: contain;
            display: block;
            margin: 0 auto 5px auto;
        }

        .attachment-caption {
            font-size: 7.5pt;
            color: #333;
            text-align: left;
        }
    </style>
</head>

<body>

    <div class="border-box">
        {{-- Header Logo & Judul Utama --}}
        <table class="table-header">
            <tr>
                <td class="logo-cell">
                    <img src="{{ public_path('img/IMST.png') }}" class="logo-img" alt="INKA Logo">
                </td>
                <td class="title-cell">
                    {{ strtoupper($fcu->judul ?? ($fcu->nama_fcu ?? $fcu->nama)) }}
                </td>
                <td class="code-cell">
                    {{ $fcu->jenis_perawatan }}
                </td>
            </tr>
        </table>

        {{-- LOOPING CHECKSHEET (FCU 1 & FCU 2) --}}
        @foreach ($checksheets as $blockIndex => $blockData)
            {{-- Tanggal & No FCU --}}
            <table class="table-info" style="{{ $blockIndex > 0 ? 'border-top: 1.5px solid #000;' : '' }}">
                <tr>
                    <td width="60%">TANGGAL PERAWATAN :
                        {{ \Carbon\Carbon::parse($blockData['tanggal'])->format('d/m/Y') }}</td>
                    <td width="40%">No FCU: {{ $blockData['no_fcu'] }}</td>
                </tr>
            </table>

            {{-- Tabel Items Checksheet --}}
            <table class="table-data">
                <thead>
                    <tr>
                        <th width="5%" rowspan="2">No.</th>
                        <th width="25%" rowspan="2">Uraian pekerjaan</th>
                        <th width="40%" rowspan="2">Aktivitas Pekerjaan</th>
                        <th width="20%" rowspan="2">Standar</th>
                        <th width="10%" colspan="2">Status</th>
                    </tr>
                    <tr>
                        <th width="5%">OK</th>
                        <th width="5%">NOK</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fcu->sections as $sec)
                        {{-- Menampilkan Header Section --}}
                        @if (!empty($sec->nama_section))
                            <tr style="background-color: #e6e6e6; font-weight: bold;">
                                <td class="text-center">{{ $sec->kode }}</td>
                                <td colspan="5" style="padding: 3px 5px;">{{ $sec->nama_section }}</td>
                            </tr>
                        @endif

                        @foreach ($sec->items as $item)
                            @php $detailCount = count($item->details); @endphp
                            @foreach ($item->details as $index => $det)
                                <tr>
                                    @if ($index === 0)
                                        <td class="text-center" rowspan="{{ $detailCount }}">{{ $item->nomor }}</td>
                                        <td class="text-bold" rowspan="{{ $detailCount }}">{{ $item->uraian }}</td>
                                    @endif

                                    <td>{{ $det->aktivitas }}</td>
                                    <td>{{ $det->standar }}</td>

                                    {{-- Penentuan Centang Berdasarkan Unit (fcu1 / fcu2) --}}
                                    @php
                                        $unitKey = $blockIndex == 0 ? 'fcu1' : 'fcu2';
                                        $res = $det->results ? $det->results->where('unit', $unitKey)->first() : null;
                                        $status = $res ? $res->status : null;
                                    @endphp

                                    <td class="text-center checkmark">
                                        {!! $status == 'OK' || $status == 'SO' ? '&#10003;' : '' !!}
                                    </td>
                                    <td class="text-center checkmark">
                                        {!! $status == 'NOK' || $status == 'TSO' ? '&#10003;' : '' !!}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        @endforeach

        {{-- Form Unscheduled (Jika ada) --}}
        @if ($fcu->jenis_perawatan === 'Unscheduled' && $fcu->unscheduledForm)
            <div style="border-top: 1.5px solid #000; padding: 4px 8px; font-size: 8pt;">
                <b>FORM UNSCHEDULED MAINTENANCE</b><br>
                <span>
                    Kerusakan: {{ $fcu->unscheduledForm->jenis_kerusakan }} |
                    Tindak Lanjut: {{ $fcu->unscheduledForm->tindak_lanjut }} |
                    Status: <b>{{ $fcu->unscheduledForm->status }}</b>
                </span>
            </div>
        @endif

        {{-- Kesimpulan & Catatan --}}
        <div class="section-kesimpulan">
            <b>Kesimpulan :</b><br>
            Berdasarkan hasil perawatan, maka Saluran Pembuangan Air FCU dinyatakan :
            <b>
                @if ($fcu->kesimpulan == 'SO')
                    <u>SO</u> / <del>SO dengan catatan</del> / <del>TSO</del>
                @elseif($fcu->kesimpulan == 'SO DENGAN CATATAN' || $fcu->kesimpulan == 'SO_NOTE')
                    <del>SO</del> / <u>SO dengan catatan</u> / <del>TSO</del>
                @elseif($fcu->kesimpulan == 'TSO')
                    <del>SO</del> / <del>SO dengan catatan</del> / <u>TSO</u>
                @else
                    SO / SO dengan catatan / TSO
                @endif
            </b>
            <i>( coret yang tidak perlu )</i>
            <br>
            <b>Catatan:</b>
            @forelse ($fcu->notes as $note)
                {{ $note->catatan }}
            @empty
            @endforelse
        </div>

        {{-- Tanda Tangan --}}
        <table class="table-ttd">
            <tr>
                <td>
                    MENGETAHUI,<br>
                    KEPALA DEPARTEMEN MRO
                    <div class="ttd-space"></div>
                    (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
                </td>
                <td>
                    PELAKSANA
                    <div class="ttd-space"></div>
                    (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
                </td>
            </tr>
        </table>
    </div>

    {{-- DOKUMENTASI LAMPIRAN FOTO --}}
    @php
        $photos = collect();
        foreach ($fcu->sections as $sec) {
            foreach ($sec->items as $item) {
                foreach ($item->details as $det) {
                    if ($det->results) {
                        foreach ($det->results as $res) {
                            if ($res->photos && $res->photos->isNotEmpty()) {
                                foreach ($res->photos as $p) {
                                    $photos->push([
                                        'file' => $p->foto,
                                        'unit' => strtoupper($res->unit),
                                        'aktivitas' => $det->aktivitas,
                                        'keterangan' => $res->keterangan,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }
    @endphp

    @if ($photos->isNotEmpty())
        <div class="page-break"></div>
        <div class="attachment-header">LAMPIRAN DOKUMENTASI FOTO</div>

        <table class="attachment-grid">
            @foreach ($photos->chunk(2) as $row)
                <tr>
                    @foreach ($row as $photo)
                        <td class="attachment-card">
                            @if (file_exists(public_path('uploads/fcu/' . $photo['file'])))
                                <img src="{{ public_path('uploads/fcu/' . $photo['file']) }}" class="attachment-img">
                            @endif
                            <div class="attachment-caption">
                                <b>Unit:</b> {{ $photo['unit'] }}<br>
                                <b>Aktivitas:</b> {{ $photo['aktivitas'] }}<br>
                                @if (!empty($photo['keterangan']))
                                    <b>Ket:</b> {{ $photo['keterangan'] }}
                                @endif
                            </div>
                        </td>
                    @endforeach
                    @if ($row->count() < 2)
                        <td class="attachment-card" style="border: none;"></td>
                    @endif
                </tr>
            @endforeach
        </table>
    @endif

</body>

</html>
