<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Mutasi Stok MRO</title>

    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            color: #dc3545;
        }

        .header small {
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #dc3545;
            color: #fff;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px 8px;
        }

        th {
            text-transform: uppercase;
            font-size: 11px;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .badge-in {
            color: #198754;
            font-weight: bold;
        }

        .badge-out {
            color: #dc3545;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
            color: #666;
        }

        @media print {
            @page {
                size: A4 landscape;
                margin: 15mm;
            }


        }

        /* FORCE PRINT COLOR */
        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
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
