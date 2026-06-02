<!DOCTYPE html>
<html>

<head>

    <title>Print LP3M</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: middle;
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
            font-size: 20px;
            font-weight: 900;
            font-weight: bold;
        }

        .logo-box {
            text-align: center;
            vertical-align: middle;
        }

        .logo {
            width: 100px;
            height: auto;
            display: block;
            margin: auto;
        }
    </style>

</head>

<body>

    {{-- HEADER --}}
    <table>

        <tr>

            <td width="120" class="logo-box">

                <img class="logo"
                    src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('img/imss-remove.png'))) }}">

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

    <br>

    {{-- DATA UTAMA --}}
    <table>

        {{-- <tr>
            <td width="20%" class="fw">SPR No.</td>
            <td width="30%">
                {{ $data->spr_no }}
            </td>

            <td width="20%" class="fw">Status</td>
            <td width="30%">
                {{ $data->status }}
            </td>
        </tr>

        <tr>
            <td class="fw">Deskripsi</td>
            <td colspan="3">
                {{ $data->deskripsi }}
            </td>
        </tr> --}}

        {{-- <tr>
            <td class="fw">Keterangan</td>
            <td colspan="3">
                {{ $data->keterangan }}
            </td>
        </tr> --}}

        <tr>
            <td class="fw">
                Hasil Pengukuran / Pengecekan
            </td>

            <td colspan="3">
                {{ $data->hasil_pengukuran }}
            </td>
        </tr>

        <tr>
            <td class="fw">
                Penyebab Kerusakan
            </td>

            <td colspan="3">
                {{ $data->penyebab_kerusakan }}
            </td>
        </tr>

    </table>

    <br>

    {{-- PENYEBAB --}}
    <table>

        <tr>

            <td colspan="4" class="fw text-center">
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

    <br>

    {{-- PEKERJAAN --}}
    <table>

        <tr>
            <td colspan="4" class="fw text-center">
                EKSEKUSI
            </td>
        </tr>

        {{-- <tr>

            <td width="20%" class="fw">
                Nama
            </td>

            <td width="30%">
                {{ $data->nama }}
            </td>

            <td width="20%" class="fw">
                Tanggal
            </td>

            <td width="30%">
                {{ $data->tanggal }}
            </td>

        </tr> --}}


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
                        • {{ $t }} <br>
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
                {{ $data->pekerjaan }}
            </td>

        </tr>

    </table>

    <br>

    {{-- TINDAKAN --}}
    <table>

        <tr>

            <td colspan="4" class="fw text-center">
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

    <br>

    {{-- SPAREPART --}}
    <table>

        <tr>

            <td colspan="5" class="fw text-center">
                SPAREPART / MATERIAL YANG DIGUNAKAN
            </td>

        </tr>

        <tr>

            <th>Nama</th>
            <th>Kode</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
            <th>Jam</th>

        </tr>

        <tr>

            <td>{{ $data->nama_barang }}</td>
            <td>{{ $data->kode_barang }}</td>
            <td>{{ $data->jumlah }}</td>
            {{-- <td>{{ $data->tanggal_selesai }}</td> --}}
            <td>
                {{ $data->tanggal_selesai ? \Carbon\Carbon::parse($data->tanggal_selesai)->format('d-m-Y') : '-' }}
            </td>
            <td>{{ $data->jam_selesai_detail }}</td>

        </tr>

        <tr>

            <td class="fw">
                Detail Penyelesaian
            </td>

            <td colspan="4">
                {{ $data->detail_penyelesaian }}
            </td>

        </tr>

    </table>

    <br><br>

    {{-- TTD --}}
    <table class="no-border">

        <tr class="no-border">

            <td class="no-border text-center">

                Pemakai Fasilitas
                <br><br><br><br>

                ____________________

            </td>

            <td class="no-border text-center">

                Personel Pemeliharaan
                <br><br><br><br>

                ____________________

            </td>

        </tr>

    </table>

</body>

</html>
