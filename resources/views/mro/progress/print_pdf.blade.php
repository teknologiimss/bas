<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Progress MRO</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            color: #0f172a;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0 0 0;
            color: #64748b;
            font-size: 9px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #cbd5e1;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background-color: #0f172a;
            color: #ffffff;
            text-align: center;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        /* Badge Status */
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
            color: #fff;
        }

        .badge-warning {
            background-color: #f59e0b;
            color: #fff;
        }

        .badge-success {
            background-color: #10b981;
            color: #fff;
        }

        .badge-danger {
            background-color: #ef4444;
            color: #fff;
        }

        .badge-secondary {
            background-color: #64748b;
            color: #fff;
        }

        .badge-info {
            background-color: #0ea5e9;
            color: #fff;
        }

        .badge-primary {
            background-color: #3b82f6;
            color: #fff;
        }

        /* Progress Bar Container */
        .progress {
            background-color: #e2e8f0;
            border-radius: 4px;
            height: 14px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        /* Fill Warna Progress Bar */
        .progress-bar {
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        /* Warna Sesuai Aturan */
        .bg-danger {
            background-color: #dc3545;
        }

        .bg-warning {
            background-color: #fd7e14;
        }

        .bg-success {
            background-color: #198754;
        }

        .progress-text {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            text-align: center;
            line-height: 14px;
            font-size: 8px;
            font-weight: bold;
            color: #000;
            z-index: 2;
        }

        .doc-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 4px;
            border-radius: 4px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Laporan Progress MRO</h2>
        <p>Dicetak Pada: {{ date('d-m-Y H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="20">No</th>
                <th width="70">PO / Nota Dinas</th>
                <th>Nama Pekerjaan</th>
                <th width="60">Tanggal Kontrak</th>
                <th width="60">Selesai Kontrak</th>
                <th width="45">Status</th>
                <th width="65">Progress</th>
                <th>Keterangan Progress</th>
                <th width="140">Status Dokumen Terakhir</th>
                <th width="65">Status Kontrak</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($monitorings->sortByDesc('created_at') as $m)
                @php
                    $statusClass = match ($m->status) {
                        'Open' => 'badge-warning',
                        'Closed' => 'badge-success',
                        'On Hold' => 'badge-danger',
                        default => 'badge-secondary',
                    };

                    $latestDoc = $m->documents->last();

                    // Logika Penentuan Warna Progress Bar
                    $progressVal = (float) $m->progress;
                    $poNota = strtoupper($m->po_nota_dinas ?? '');

                    if ($progressVal >= 100) {
                        $progressBarClass = 'bg-success';
                    } elseif (str_contains($poNota, 'ND') || str_contains($poNota, 'NOTA')) {
                        $progressBarClass = 'bg-danger';
                    } else {
                        $progressBarClass = 'bg-warning';
                    }

                    // Panggilan helper/method Notif Kontrak
                    $notif = $m->notifKontrak();
                @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="font-bold">{{ $m->po_nota_dinas }}</td>
                    <td>{{ $m->nama_pekerjaan }}</td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($m->tanggal_kontrak)->format('d-m-Y') }}
                    </td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($m->tanggal_selesai_kontrak)->format('d-m-Y') }}
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $statusClass }}">{{ $m->status }}</span>
                    </td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar {{ $progressBarClass }}" style="width: {{ $progressVal }}%;">
                            </div>
                            <div class="progress-text">{{ $m->progress }}%</div>
                        </div>
                    </td>
                    <td>
                        @php
                            $text = trim($m->keterangan2 ?? '-');
                            if (str_starts_with($text, '-')) {
                                $lines = preg_split('/\r\n|\r|\n/', $text);
                                echo implode('<br>', $lines);
                            } else {
                                $lines = preg_split('/\r\n|\r|\n/', $text);
                                echo implode(', ', $lines);
                            }
                        @endphp
                    </td>
                    <td>
                        @if ($latestDoc)
                            <div class="doc-card">
                                <div><b>Doc:</b> {{ $latestDoc->nama_dokumen }}</div>
                                <div><b>Status:</b>
                                    @if ($latestDoc->status == 'Closed')
                                        <span style="color: #10b981; font-weight: bold;">OK</span>
                                    @elseif ($latestDoc->status == 'Nok')
                                        <span style="color: #ef4444; font-weight: bold;">NOK</span>
                                    @else
                                        -
                                    @endif
                                </div>
                                @if ($latestDoc->tanggal_closed)
                                    <div><b>Tgl:</b>
                                        {{ \Carbon\Carbon::parse($latestDoc->tanggal_closed)->format('d-m-Y') }}</div>
                                @endif
                                @if ($latestDoc->keterangan_closed)
                                    <div style="color: #ef4444; font-weight: bold;">
                                        <b>Ket:</b> {{ $latestDoc->keterangan_closed }}
                                    </div>
                                @endif
                            </div>
                        @else
                            <span style="color: #94a3b8; font-style: italic;">Belum ada dokumen</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge badge-{{ $notif['class'] }}">
                            {{ $notif['text'] }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center" style="color: #64748b;">Tidak ada data monitoring</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>
