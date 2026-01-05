<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Print Progress MRO</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        @media print {

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body {
                font-size: 12px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 6px;
                vertical-align: top;
            }

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

    <h3 style="text-align:center; margin-bottom:15px;">
        <b>LAPORAN PROGRESS MRO</b>
    </h3>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark text-center">
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
                        'Open' => 'badge badge-warning',
                        'Closed' => 'badge badge-success',
                        'On Hold' => 'badge badge-danger',
                        default => 'badge badge-secondary',
                    };
                @endphp

                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $m->po_nota_dinas }}</td>
                    <td>{{ $m->nama_pekerjaan }}</td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($m->tanggal_kontrak)->format('d-m-Y') }}
                    </td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($m->tanggal_selesai_kontrak)->format('d-m-Y') }}
                    </td>
                    <td class="text-center">
                        <span class="{{ $statusClass }}">
                            {{ $m->status }}
                        </span>
                    </td>
                    <td>
                        <div class="progress" style="height:16px;">
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

                            if (str_starts_with($text, '-')) {
                                echo implode('<br>', preg_split('/\r\n|\r|\n/', $text));
                            } else {
                                echo implode(', ', preg_split('/\r\n|\r|\n/', $text));
                            }
                        @endphp
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">
                        Tidak ada data
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>
