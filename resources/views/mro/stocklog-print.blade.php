<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Mutasi Stok MRO</title>

    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 12px;
            color: #1f2937;
            background: #fff;
        }

        :root {
            --navy: #0b1f3a;
            --navy2: #17375e;
            --navy3: #214d84;
            --border: #d8e4f2;
            --light: #f5f8fc;
        }

        /* ==========================
       HEADER
    ========================== */
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid var(--navy2);
            padding-bottom: 12px;
        }

        .header h2 {
            margin: 0;
            color: var(--navy);
            font-size: 24px;
            letter-spacing: 1px;
            font-weight: bold;
        }

        .header small {
            color: #6b7280;
            font-size: 11px;
        }

        /* ==========================
       TABLE
    ========================== */

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background: linear-gradient(135deg, var(--navy), var(--navy2));
            color: white;
        }

        th {
            border: 1px solid var(--navy2);
            padding: 9px;
            text-transform: uppercase;
            font-size: 11px;
            text-align: center;
            letter-spacing: .4px;
        }

        td {
            border: 1px solid var(--border);
            padding: 7px 8px;
            vertical-align: middle;
            font-size: 11px;
        }

        tbody tr:nth-child(even) {
            background: var(--light);
        }

        tbody tr:hover {
            background: #edf4fc;
        }

        /* ==========================
       BADGE
    ========================== */

        .badge-in {
            display: inline-block;
            background: #0d6efd;
            color: white;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-out {
            display: inline-block;
            background: var(--navy2);
            color: white;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: bold;
        }

        /* ==========================
       ALIGNMENT
    ========================== */

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /* ==========================
       FOOTER
    ========================== */

        .footer {
            margin-top: 35px;
            border-top: 2px solid var(--navy2);
            padding-top: 10px;
            text-align: right;
            color: #6b7280;
            font-size: 11px;
        }

        /* ==========================
       PRINT
    ========================== */

        @media print {

            @page {
                size: A4 landscape;
                margin: 12mm;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body {
                zoom: 96%;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="header">
        <h2>LAPORAN MUTASI STOK MRO</h2>
        <small>Dicetak pada {{ now()->format('d/m/Y H:i') }}</small>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Tipe</th>
                <th>Qty</th>
                <th>Stok Sebelum</th>
                <th>Stok Sesudah</th>
                <th>Proyek</th>
                <th>No.SPP</th>
                <th>User</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $log->barcode }}</td>
                    <td>{{ $log->mro->mro_name ?? '-' }}</td>
                    <td>
                        @if ($log->type == 'IN')
                            <span class="badge-in">IN</span>
                        @else
                            <span class="badge-out">OUT</span>
                        @endif
                    </td>
                    <td style="text-align:center">{{ $log->qty }}</td>
                    <td style="text-align:center">{{ $log->stock_before }}</td>
                    <td style="text-align:center">{{ $log->stock_after }}</td>
                    <td>{!! nl2br(e($log->proyek ?? '-')) !!}</td>
                    <td>{{ $log->spp ?? '-' }}</td>
                    <td>{{ $log->user }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Sistem Inventory MRO
    </div>

</body>

</html>
