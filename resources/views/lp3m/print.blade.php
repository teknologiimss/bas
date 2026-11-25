<!DOCTYPE html>
<html>

<head>

    <title>Print LP3M</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11.5px;
            color: #000;
            margin: 12px 20px;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: -1px;
        }

        table:first-of-type {
            margin-top: 0;
        }

        tr {
            page-break-inside: avoid;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 4px 5px;
            vertical-align: middle;
        }

        /* Warna penanda subjudul antar bagian tabel */
        .section-header {
            background-color: #E5E7EB;
            font-weight: bold;
            text-align: center;
        }

        .no-border {
            border: none !important;
        }

        .text-center {
            text-align: center;
        }

        .fw {
            font-weight: bold;
        }

        .header-title {
            font-size: 12px;
            font-weight: bold;
            text-align: center;
        }

        .sub {
            font-size: 11px;
        }

        .checkbox {
            font-family: DejaVu Sans, sans-serif;
            font-size: 18px;
            font-weight: 900;
            font-weight: bold;
        }

        .logo-box {
            text-align: center;
            vertical-align: middle;
        }

        .logo {
            width: 95px;
            height: auto;
            display: block;
            margin: auto;
        }

        /* Styling khusus list di dalam tabel print / DomPDF */
        .print-list {
            margin: 0;
            padding-left: 16px;
            list-style-type: disc;
        }

        .print-list li {
            margin-bottom: 1px;
            line-height: 1.3;
        }

        .print-list li:last-child {
            margin-bottom: 0;
        }

        /* Menjaga blok TTD tetap menyatu dan tidak terpisah halaman */
        .ttd-table {
            page-break-inside: avoid;
            margin-top: 8px;
        }
    </style>

</head>

<body>

    @php
        /**
         * Mengubah teks berbaris (hasil Enter / \n / \r\n) atau array JSON menjadi array item bersih.
         */
        $pecahBaris = function ($nilai): array {
            if (is_null($nilai) || $nilai === '') {
                return [];
            }

            if (is_array($nilai)) {
                $items = $nilai;
            } else {
                $decoded = json_decode($nilai, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $items = $decoded;
                } else {
                    $items = preg_split('/\r\n|\r|\n/', (string) $nilai) ?: [];
                }
            }

            $hasil = [];
            foreach ($items as $item) {
                $teks = trim((string) $item);
                $teks = preg_replace('/^([-•*]|\d+[\.\)])\s+/', '', $teks);
                if ($teks !== '') {
                    $hasil[] = $teks;
                }
            }

            return $hasil;
        };

        $listHasilPengukuran = $pecahBaris($data->hasil_pengukuran ?? '');
        $listPenyebabKerusakan = $pecahBaris($data->penyebab_kerusakan ?? '');
        $listPekerjaan = $pecahBaris($data->pekerjaan ?? '');
        $listDetailPenyelesaian = $pecahBaris($data->detail_penyelesaian ?? '');
    @endphp

    {{-- HEADER --}}
    <table>

        <tr>

            <td width="120" class="logo-box">

                <img class="logo"
                    src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('img/ptimst.png'))) }}">

            </td>

            <td class="text-center">

                <div class="header-title">
                    LAPORAN PEKERJAAN PERBAIKAN DAN PERAWATAN FASILITAS
                </div>

                {{-- <div class="sub">
                    LP3M
                </div> --}}

            </td>

            <td width="180">

                <table>

                    <tr>
                        <td>No. Dok</td>
                        <td>{{ $data->spr_no }}</td>
                    </tr>

                    <tr>
                        <td>Tanggal</td>
                        <td>{{ date('d-m-Y') }}</td>
                    </tr>

                    <tr>
                        <td>Hal</td>
                        <td>1/1</td>
                    </tr>

                </table>

            </td>

        </tr>

    </table>

    {{-- DATA UTAMA --}}
    <table>

        <tr>
            <td width="25%" class="fw">
                Hasil Pengukuran / Pengecekan
            </td>

            <td colspan="3">
                @if (count($listHasilPengukuran) > 0)
                    <ul class="print-list">
                        @foreach ($listHasilPengukuran as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                @else
                    -
                @endif
            </td>
        </tr>

        <tr>
            <td class="fw">
                Penyebab Kerusakan
            </td>

            <td colspan="3">
                @if (count($listPenyebabKerusakan) > 0)
                    <ul class="print-list">
                        @foreach ($listPenyebabKerusakan as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                @else
                    -
                @endif
            </td>
        </tr>

    </table>

    {{-- PENYEBAB --}}
    <table>

        <tr>

            <td colspan="4" class="section-header">
                PENYEBAB KERUSAKAN
            </td>

        </tr>

        <tr>

            <td>
                <span class="checkbox">
                    {!! $data->aus ? '&#9745;' : '&#9744;' !!}
                </span>
                Aus
            </td>

            <td>
                <span class="checkbox">
                    {!! $data->retak ? '&#9745;' : '&#9744;' !!}
                </span>
                Retak / Patah
            </td>

            <td>
                <span class="checkbox">
                    {!! $data->komponen_tak_berfungsi ? '&#9745;' : '&#9744;' !!}
                </span>
                Komponen Tak Berfungsi
            </td>

            <td>
                <span class="checkbox">
                    {!! $data->kelebihan_beban ? '&#9745;' : '&#9744;' !!}
                </span>
                Kelebihan Beban
            </td>

        </tr>

        <tr>

            <td>
                <span class="checkbox">
                    {!! $data->salah_operasi ? '&#9745;' : '&#9744;' !!}
                </span>
                Salah Operasi
            </td>

            <td>
                <span class="checkbox">
                    {!! $data->kelainan ? '&#9745;' : '&#9744;' !!}
                </span>
                Kelainan
            </td>

            <td>
                <span class="checkbox">
                    {!! $data->kecelakaan ? '&#9745;' : '&#9744;' !!}
                </span>
                Kecelakaan
            </td>

            <td>
                <span class="checkbox">
                    {!! $data->lain_lain_kerusakan ? '&#9745;' : '&#9744;' !!}
                </span>
                Lain-lain
            </td>

        </tr>

    </table>

    {{-- PEKERJAAN --}}
    <table>

        <tr>
            <td colspan="4" class="section-header">
                EKSEKUSI
            </td>
        </tr>

        <tr>

            <td width="20%" class="fw">
                Nama Teknisi
            </td>

            <td width="30%">

                @php
                    $teknisi = json_decode($data->nama, true);
                @endphp

                @if ($teknisi)

                    @foreach ($teknisi as $t)
                        - {{ $t }} <br>
                    @endforeach

                @endif

            </td>

            <td width="20%" class="fw">
                Tanggal
            </td>

            <td width="30%">
                {{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}
            </td>

        </tr>

        <tr>

            <td class="fw">
                Jam Mulai
            </td>

            <td>
                {{ $data->jam_mulai }}
            </td>

            <td class="fw">
                Jam Selesai
            </td>

            <td>
                {{ $data->jam_selesai }}
            </td>

        </tr>

        <tr>

            <td class="fw">
                Pekerjaan
            </td>

            <td colspan="3">
                @if (count($listPekerjaan) > 0)
                    <ul class="print-list">
                        @foreach ($listPekerjaan as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                @else
                    -
                @endif
            </td>

        </tr>

    </table>

    {{-- TINDAKAN --}}
    <table>

        <tr>

            <td colspan="4" class="section-header">
                TINDAKAN
            </td>

        </tr>

        <tr>

            <td>
                <span class="checkbox">
                    {!! $data->komponen_diganti ? '&#9745;' : '&#9744;' !!}
                </span>
                Komponen Diganti
            </td>

            <td>
                <span class="checkbox">
                    {!! $data->diperiksa_disetel ? '&#9745;' : '&#9744;' !!}
                </span>
                Diperiksa dan Disetel
            </td>

            <td>
                <span class="checkbox">
                    {!! $data->diperbaiki_dibuat ? '&#9745;' : '&#9744;' !!}
                </span>
                Diperbaiki Dengan Dibuat
            </td>

            <td>
                <span class="checkbox">
                    {!! $data->dimodifikasi ? '&#9745;' : '&#9744;' !!}
                </span>
                Dimodifikasi
            </td>

        </tr>

        <tr>

            <td>
                <span class="checkbox">
                    {!! $data->dipindah_pasang_baru ? '&#9745;' : '&#9744;' !!}
                </span>
                Dipindah Pasang Baru
            </td>

            <td>
                <span class="checkbox">
                    {!! $data->diperlukan_evaluasi ? '&#9745;' : '&#9744;' !!}
                </span>
                Diperlukan Evaluasi
            </td>

            <td colspan="2">
                <span class="checkbox">
                    {!! $data->lain_lain_tindakan ? '&#9745;' : '&#9744;' !!}
                </span>
                Lain-lain
            </td>

        </tr>

    </table>

    {{-- SPAREPART --}}
    @php
        $namaBarang = json_decode($data->nama_barang, true) ?? [];
        $kodeBarang = json_decode($data->kode_barang, true) ?? [];
        $jumlahBarang = json_decode($data->jumlah, true) ?? [];
    @endphp

    <table>

        <tr>
            <td colspan="5" class="section-header">
                SPAREPART / MATERIAL YANG DIGUNAKAN
            </td>
        </tr>

        <tr>
            <th width="35%">Nama Barang</th>
            <th width="20%">Kode Barang</th>
            <th width="15%">Jumlah</th>
            <th width="15%">Tanggal</th>
            <th width="15%">Jam</th>
        </tr>

        @if (count($namaBarang) > 0)

            @foreach ($namaBarang as $i => $nama)
                <tr>

                    <td>
                        {{ $nama }}
                    </td>

                    <td>
                        {{ $kodeBarang[$i] ?? '-' }}
                    </td>

                    <td>
                        {{ $jumlahBarang[$i] ?? '-' }}
                    </td>

                    @if ($loop->first)
                        <td rowspan="{{ count($namaBarang) }}">
                            {{ $data->tanggal_selesai ? \Carbon\Carbon::parse($data->tanggal_selesai)->format('d-m-Y') : '' }}
                        </td>

                        <td rowspan="{{ count($namaBarang) }}">
                            {{ $data->jam_selesai_detail }}
                        </td>
                    @endif

                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5" class="text-center">
                    Tidak ada sparepart
                </td>
            </tr>

        @endif

        <tr>

            <td class="fw">
                Detail Penyelesaian
            </td>

            <td colspan="4">
                @if (count($listDetailPenyelesaian) > 0)
                    <ul class="print-list">
                        @foreach ($listDetailPenyelesaian as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                @else
                    -
                @endif
            </td>

        </tr>

    </table>

    {{-- TTD --}}
    <table class="no-border ttd-table">

        <tr class="no-border">

            <td class="no-border text-center">

                <b>USER</b>
                <br><br><br><br>

                ____________________

            </td>

            <td class="no-border text-center">

                <b>IMST</b>
                <br><br><br><br>

                ____________________

            </td>

        </tr>

    </table>

</body>

</html>
