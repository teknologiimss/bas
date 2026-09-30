@extends('layouts.main')

@section('title', 'Dashboard MRO')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')
    <style>
        :root {
            --navy: #0f172a;
            --blue: #2563eb;
            --green: #22c55e;
            --yellow: #eab308;
            --red: #ef4444;
        }

        .card-dashboard {
            border: none;
            border-radius: 14px;
            background: #ffffff;
            box-shadow: 0 8px 24px rgba(15, 23, 42, .06);
            transition: all .25s ease;
        }

        .card-dashboard:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(15, 23, 42, .1);
        }

        .chart-container {
            position: relative;
            margin: auto;
            height: 230px;
        }

        .table-dashboard th {
            background: linear-gradient(135deg, var(--navy), var(--blue)) !important;
            color: white;
            border: none;
            font-size: 13px;
        }

        .table-dashboard td {
            font-size: 13px;
            vertical-align: middle;
        }
    </style>

    <div class="container-fluid mt-4 mb-5">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="font-weight-bold text-dark mb-0">Dashboard MRO</h3>
                <p class="text-muted small mb-0">Ringkasan Statistik Proyek dan Perawatan Aset MRO</p>
            </div>
            <span class="badge badge-light p-2 shadow-sm border">
                🗓️ {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </span>
        </div>

        {{-- BARIS 1: DUA PIE CHART --}}
        <div class="row mb-4">

            {{-- 1. PIE CHART STATUS PROYEK (TOTAL PROYEK - OPEN/CLOSED) --}}
            <div class="col-lg-5 col-md-6 mb-3">
                <div class="card card-dashboard h-100 p-3">
                    <h6 class="font-weight-bold text-dark mb-3">
                        <i class="fas fa-chart-pie mr-1 text-primary"></i> Status Proyek MRO
                    </h6>
                    <div class="chart-container">
                        <canvas id="statusProyekChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- 2. PIE CHART NOTIFIKASI KONTRAK --}}
            <div class="col-lg-7 col-md-6 mb-3">
                <div class="card card-dashboard h-100 p-3">
                    <h6 class="font-weight-bold text-dark mb-3">
                        <i class="fas fa-bell mr-1 text-warning"></i> Status Notifikasi Kontrak
                    </h6>
                    <div class="chart-container">
                        <canvas id="notifikasiChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

        {{-- BARIS 2: TABEL PROGRES & GAUGE PREVENTIVE MAINTENANCE --}}
        <div class="row">

            {{-- 3. TABEL DAFTAR PROGRES MRO --}}
            <div class="col-lg-8 mb-3">
                <div class="card card-dashboard h-100 p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="font-weight-bold text-dark mb-0">
                            <i class="fas fa-list-alt mr-1 text-info"></i> Ringkasan Progres MRO Terbaru
                        </h6>
                        <a href="{{ route('mro.progress.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-dashboard mb-0">
                            <thead class="text-center">
                                <tr>
                                    <th>PO / Nota Dinas</th>
                                    <th>Nama Pekerjaan</th>
                                    <th>Tgl Kontrak</th>
                                    <th>Selesai Kontrak</th>
                                    <th>Status Dokumen Terakhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($monitorings as $m)
                                    @php
                                        $latestDoc = $m->documents->last();
                                    @endphp
                                    <tr>
                                        <td class="font-weight-bold text-primary">{{ $m->po_nota_dinas }}</td>
                                        <td>{{ $m->nama_pekerjaan }}</td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($m->tanggal_kontrak)->format('d-m-Y') }}</td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($m->tanggal_selesai_kontrak)->format('d-m-Y') }}</td>
                                        <td>
                                            @if ($latestDoc)
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <small class="font-weight-bold text-truncate" style="max-width: 120px;">
                                                        {{ $latestDoc->nama_dokumen }}
                                                    </small>
                                                    @if ($latestDoc->status == 'Closed')
                                                        <span class="badge badge-success">🟢 OK</span>
                                                    @elseif ($latestDoc->status == 'Nok')
                                                        <span class="badge badge-danger">🔴 NOK</span>
                                                    @else
                                                        <span class="badge badge-secondary">-</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted small italic">Belum Ada</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">Tidak ada data progres.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- 4. PREVENTIVE MAINTENANCE (PM) 1 TAHUN --}}
            <div class="col-lg-4 mb-3">
                <div class="card card-dashboard h-100 p-3 text-center">
                    <h6 class="font-weight-bold text-dark text-left mb-2">
                        <i class="fas fa-tools mr-1 text-success"></i> Preventive Maintenance (PM)
                    </h6>
                    <p class="text-muted small text-left mb-3">Rata-rata kalkulasi realisasi per tahun</p>

                    <div class="d-flex flex-column align-items-center justify-content-center my-auto">
                        <div class="position-relative d-inline-flex justify-content-center align-items-center"
                            style="width: 180px; height: 180px;">
                            <canvas id="pmGaugeChart"></canvas>
                            <div class="position-absolute text-center">
                                <h2 class="font-weight-bold text-dark mb-0">{{ $pmYearlyPercentage }}%</h2>
                                <small class="text-muted font-weight-bold">Tahun {{ date('Y') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 border-top pt-2">
                        <small class="text-muted">Target Tahunan: <b>100%</b></small>
                    </div>
                </div>
            </div>

        </div>

    </div>

    {{-- SCRIPT CHART JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // 1. Chart Status Proyek (Open / Closed / On Hold)
            new Chart(document.getElementById('statusProyekChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Open', 'Closed', 'On Hold'],
                    datasets: [{
                        data: [{{ $statusCounts['Open'] }}, {{ $statusCounts['Closed'] }},
                            {{ $statusCounts['On Hold'] }}
                        ],
                        backgroundColor: ['#2563eb', '#22c55e', '#ef4444'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // 2. Chart Notifikasi Kontrak
            new Chart(document.getElementById('notifikasiChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Kontrak Berjalan', 'Akan Berakhir (H-7)', 'Telah Berakhir', 'Selesai'],
                    datasets: [{
                        data: [
                            {{ $notifCounts['berjalan'] }},
                            {{ $notifCounts['h7'] }},
                            {{ $notifCounts['berakhir'] }},
                            {{ $notifCounts['selesai'] }}
                        ],
                        backgroundColor: ['#22c55e', '#eab308', '#ef4444', '#2563eb'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // 4. Gauge Chart Preventive Maintenance (PM) 1 Tahun
            const pmValue = {{ $pmYearlyPercentage }};
            new Chart(document.getElementById('pmGaugeChart'), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [pmValue, 100 - pmValue],
                        backgroundColor: ['#2563eb', '#e2e8f0'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '80%',
                    plugins: {
                        tooltip: {
                            enabled: false
                        }
                    }
                }
            });

        });
    </script>
@endsection
