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
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 8px 24px rgba(15, 23, 42, .06);
            transition: all .25s ease;
        }

        .card-dashboard:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(15, 23, 42, .1);
        }

        /* Chart Canvas Size Optimization */
        .chart-container-large {
            position: relative;
            margin: auto;
            height: 300px;
            width: 100%;
        }

        .chart-container-gauge {
            position: relative;
            margin: auto;
            height: 220px;
            width: 220px;
        }

        /* Scrollable Table Container */
        .table-scroll-container {
            max-height: 420px;
            overflow-y: auto;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        /* Custom Scrollbar */
        .table-scroll-container::-webkit-scrollbar {
            width: 6px;
        }

        .table-scroll-container::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .table-scroll-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .table-scroll-container::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Sticky Table Header */
        .table-dashboard thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: linear-gradient(135deg, var(--navy), var(--blue)) !important;
            color: white;
            border: none;
            font-size: 13px;
            white-space: nowrap;
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

        {{-- BARIS 1: DUA PIE CHART (DIPERBESAR & PROPOSIONAL) --}}
        <div class="row mb-4">

            {{-- 1. PIE CHART STATUS PROYEK --}}
            <div class="col-lg-5 col-md-12 mb-3">
                <div class="card card-dashboard h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="font-weight-bold text-dark mb-0">
                            <i class="fas fa-chart-pie mr-2 text-primary"></i>Status Proyek MRO
                        </h6>
                    </div>
                    <div class="chart-container-large">
                        <canvas id="statusProyekChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- 2. PIE CHART NOTIFIKASI KONTRAK --}}
            <div class="col-lg-7 col-md-12 mb-3">
                <div class="card card-dashboard h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="font-weight-bold text-dark mb-0">
                            <i class="fas fa-bell mr-2 text-warning"></i>Status Notifikasi Kontrak
                        </h6>
                    </div>
                    <div class="chart-container-large">
                        <canvas id="notifikasiChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

        {{-- BARIS 2: TABEL PROGRES & GAUGE PREVENTIVE MAINTENANCE --}}
        <div class="row">

            {{-- 3. TABEL DAFTAR PROGRES MRO (BISA DI-SCROLL) --}}
            <div class="col-lg-8 mb-3">
                <div class="card card-dashboard h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="font-weight-bold text-dark mb-0">
                                <i class="fas fa-list-alt mr-2 text-info"></i>Daftar Progres Kontrak Pekerjaan
                            </h6>
                            <small class="text-muted">Total Pekerjaan: <b>{{ $monitorings->count() }}</b> Data</small>
                        </div>
                        <a href="{{ route('mro.progress.index') }}"
                            class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            Kelola Data <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    {{-- Kontainer Scroll --}}
                    <div class="table-scroll-container">
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
                                            {{ \Carbon\Carbon::parse($m->tanggal_kontrak)->format('d-m-Y') }}
                                        </td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($m->tanggal_selesai_kontrak)->format('d-m-Y') }}
                                        </td>
                                        <td>
                                            @if ($latestDoc)
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <small class="font-weight-bold text-truncate" style="max-width: 140px;"
                                                        title="{{ $latestDoc->nama_dokumen }}">
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
                                        <td colspan="5" class="text-center text-muted py-4">Tidak ada data progres
                                            proyek.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- 4. PREVENTIVE MAINTENANCE (PM) GAUGE CHART --}}
            <div class="col-lg-4 mb-3">
                <div class="card card-dashboard h-100 p-4 text-center d-flex flex-column justify-content-between">
                    <div>
                        <h6 class="font-weight-bold text-dark text-left mb-1">
                            <i class="fas fa-tools mr-2 text-success"></i>Preventive Maintenance (PM)
                        </h6>
                        <p class="text-muted small text-left mb-3">Rata-rata kalkulasi realisasi per tahun</p>
                    </div>

                    <div class="my-auto">
                        <div class="chart-container-gauge d-flex justify-content-center align-items-center">
                            <canvas id="pmGaugeChart"></canvas>
                            <div class="position-absolute text-center">
                                <h2 class="font-weight-bold text-dark mb-0">{{ $pmYearlyPercentage }}%</h2>
                                <small class="text-muted font-weight-bold">Tahun {{ $tahun }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 border-top pt-3">
                        <div class="d-flex justify-content-between align-items-center small">
                            <span class="text-muted">Target Tahunan</span>
                            <span class="font-weight-bold text-success">100%</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    {{-- SCRIPT CHART JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // 1. Chart Status Proyek
            new Chart(document.getElementById('statusProyekChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Open', 'Closed', 'On Hold'],
                    datasets: [{
                        data: [
                            {{ $statusCounts['Open'] }},
                            {{ $statusCounts['Closed'] }},
                            {{ $statusCounts['On Hold'] }}
                        ],
                        backgroundColor: ['#2563eb', '#22c55e', '#ef4444'],
                        borderWidth: 2,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 12,
                                    weight: '500'
                                }
                            }
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
                        borderWidth: 2,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 12,
                                    weight: '500'
                                }
                            }
                        }
                    }
                }
            });

            // 3. Gauge Chart PM 1 Tahun
            const pmValue = {{ $pmYearlyPercentage }};
            new Chart(document.getElementById('pmGaugeChart'), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [pmValue, Math.max(0, 100 - pmValue)],
                        backgroundColor: ['#2563eb', '#e2e8f0'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '82%',
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
