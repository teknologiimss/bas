<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Print Progress MRO</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        /* =====================================================
           FORCE COLOR PRINT (WAJIB AGAR WARNA MUNCUL)
        ===================================================== */
        @media print {

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body {
                font-size: 12px;
                background: #fff !important;
                color: #000;
            }

            /* ================= TABLE ================= */
            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #000 !important;
                padding: 6px !important;
                vertical-align: top;
            }

            /* ================= HEADER ================= */
            thead th {
                background-color: #dc3545 !important;
                color: #ffffff !important;
                text-align: center;
                font-weight: bold;
                font-size: 11px;
                text-transform: uppercase;
            }

            /* ================= STRIPED ================= */
            tbody tr:nth-child(even) td {
                background-color: #f8d7da !important;
            }

            /* ================= BADGE ================= */
            .badge {
                padding: 4px 10px;
                border-radius: 12px;
                font-size: 10px;
                font-weight: bold;
                color: #fff !important;
                display: inline-block;
            }

            .badge-warning {
                background-color: #ffc107 !important;
                color: #000 !important;
            }

            .badge-success {
                background-color: #28a745 !important;
            }

            .badge-danger {
                background-color: #dc3545 !important;
            }

            .badge-secondary {
                background-color: #6c757d !important;
            }

            /* ================= PROGRESS ================= */
            .progress {
                background-color: #e9ecef !important;
                border: 1px solid #999 !important;
                height: 16px;
            }

            .progress-bar {
                font-size: 10px;
                font-weight: bold;
                color: #fff !important;
                line-height: 16px;
            }

            .bg-danger {
                background-color: #dc3545 !important;
            }

            .bg-warning {
                background-color: #ffc107 !important;
                color: #000 !important;
            }

            .bg-success {
                background-color: #28a745 !important;
            }

            /* ================= PAGE ================= */
            thead {
                display: table-header-group;
            }

            tr {
                page-break-inside: avoid;
            }

            @page {
                size: A4 landscape;
                margin: 10mm;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <h3 style="text-align:center; margin-bottom:15px; color:#dc3545;">
        <b>LAPORAN PROGRESS MRO</b>
    </h3>

    <table>
        <thead>
            <tr>
                <th width="40">No</th>
                <th>PO / Nota Dinas</th>
                <th>Nama Pekerjaan</th>
                <th>Tgl Kontrak</th>
                <th>Selesai Kontrak</th>
                <th>Status</th>
                <th width="150">Progress</th>
                <th>Keterangan Progress</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($monitorings as $index => $m)
                @php
                    $statusClass = match ($m->status) {
                        'Open' => 'badge-warning',
                        'Closed' => 'badge-success',
                        'On Hold' => 'badge-danger',
                        default => 'badge-secondary',
                    };
                @endphp

                <tr>
                    <td style="text-align:center">{{ $index + 1 }}</td>
                    <td>{{ $m->po_nota_dinas }}</td>
                    <td>{{ $m->nama_pekerjaan }}</td>
                    <td style="text-align:center">
                        {{ \Carbon\Carbon::parse($m->tanggal_kontrak)->format('d-m-Y') }}
                    </td>
                    <td style="text-align:center">
                        {{ \Carbon\Carbon::parse($m->tanggal_selesai_kontrak)->format('d-m-Y') }}
                    </td>
                    <td style="text-align:center">
                        <span class="badge {{ $statusClass }}">
                            {{ $m->status }}
                        </span>
                    </td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar
                                {{ $m->progress < 50 ? 'bg-danger' : ($m->progress < 100 ? 'bg-warning' : 'bg-success') }}"
                                style="width: {{ $m->progress }}%">
                                {{ $m->progress }}%
                            </div>
                        </div>
                    </td>
                    <td>
                        @php
                            $text = trim($m->keterangan2 ?? '-');
                            $lines = preg_split('/\r\n|\r|\n/', $text);
                            echo str_starts_with($text, '-')
                                ? implode('<br>', $lines)
                                : implode(', ', $lines);
                        @endphp
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center">
                        Tidak ada data
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>
