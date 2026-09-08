<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Print - {{ $folder->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 20px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .header-table td {
            border: none;
            vertical-align: middle;
        }

        .logo {
            width: 120px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            text-transform: uppercase;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }

        table.data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-left {
            text-align: left !important;
        }

        .bold-row {
            background-color: #f9f9f9;
            font-weight: bold;
            text-align: left !important;
        }

        @media print {
            @page {
                size: landscape;
                margin: 10mm;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="no-print" style="margin-bottom: 15px;">
        <button onclick="window.print()">Cetak Dokumen</button>
    </div>

    <!-- Header Logo IMST & Judul -->
    <table class="header-table">
        <tr>
            <td width="20%">
                <img src="{{ asset('images/logo-imst.png') }}" alt="Logo IMST" class="logo">
            </td>
            <td width="60%" class="title">
                {{ $folder->title }}<br>
                <span style="font-size: 13px;">TAHUN {{ $folder->year }}</span>
            </td>
            <td width="20%"></td>
        </tr>
    </table>

    <!-- Table Main Output -->
    <table class="data-table">
        <thead>
            <tr>
                <th rowspan="2" width="3%">NO</th>
                <th rowspan="2" width="15%">KOMPONEN</th>
                <th rowspan="2" width="25%">SPESIFIKASI</th>
                <th colspan="12">BULAN</th>
                <th rowspan="2" width="5%">TOTAL</th>
                <th rowspan="2" width="5%">SAT</th>
                <th rowspan="2" width="12%">KETERANGAN</th>
            </tr>
            <tr>
                <th>APR</th>
                <th>MEI</th>
                <th>JUNI</th>
                <th>JULI</th>
                <th>AGUS</th>
                <th>SEPT</th>
                <th>OKT</th>
                <th>NOV</th>
                <th>DES</th>
                <th>JAN</th>
                <th>FEB</th>
                <th>MAR</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groupedItems as $subHeader => $items)
                <tr>
                    <td colspan="18" class="bold-row"><strong>{{ strtoupper($subHeader) }}</strong></td>
                </tr>
                @foreach ($items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="text-left">{{ $item->komponen }}</td>
                        <td class="text-left">{{ $item->spesifikasi }}</td>
                        <td>{{ $item->apr ?: '' }}</td>
                        <td>{{ $item->mei ?: '' }}</td>
                        <td>{{ $item->juni ?: '' }}</td>
                        <td>{{ $item->juli ?: '' }}</td>
                        <td>{{ $item->agus ?: '' }}</td>
                        <td>{{ $item->sept ?: '' }}</td>
                        <td>{{ $item->okt ?: '' }}</td>
                        <td>{{ $item->nov ?: '' }}</td>
                        <td>{{ $item->des ?: '' }}</td>
                        <td>{{ $item->jan ?: '' }}</td>
                        <td>{{ $item->feb ?: '' }}</td>
                        <td>{{ $item->mar ?: '' }}</td>
                        <td><strong>{{ $item->total }}</strong></td>
                        <td>{{ $item->satuan }}</td>
                        <td class="text-left">{{ $item->keterangan }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

</body>

</html>
