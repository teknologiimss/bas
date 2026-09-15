@extends('layouts.main')

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary: #0f172a;
            --secondary: #1e3a8a;
        }

        body {
            background: #f1f5f9;
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }

        .top-card {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 20px;
            padding: 24px 30px;
            color: white;
            box-shadow: 0 10px 25px rgba(15, 23, 42, .15);
        }

        .kpi-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease-in-out;
            height: 100%;
        }

        .kpi-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        }

        .kpi-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            flex-shrink: 0;
        }

        .chart-card {
            background: white;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid #e2e8f0;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .chart-container {
            position: relative;
            flex-grow: 1;
            min-height: 280px;
            width: 100%;
        }

        .btn-modern {
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
        }

        .card-title-custom {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .card-title-custom i {
            width: 28px;
            height: 28px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }
    </style>

    <div class="container py-4">
        {{-- TOP CARD --}}
        <div class="top-card d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <div class="h3 fw-bold mb-1 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-chart-line fs-4"></i> Dashboard Monitoring Chiller
                </div>
                <p class="mb-0 text-white-50">Ringkasan statistik dan kondisi perawatan unit Chiller</p>
            </div>
            <div>
                <a href="{{ route('chiller.index') }}" class="btn btn-light btn-modern shadow-sm">
                    <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Data Tabel
                </a>
            </div>
        </div>

        {{-- METRIC CARDS / KPI --}}
        <div class="row g-3 mb-4">
            <div class="col-xl col-sm-6">
                <div class="kpi-card d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase fw-bold text-muted" style="font-size: 11px; letter-spacing: 0.5px;">
                            TOTAL MONITORING</div>
                        <h2 class="fw-bold mb-0 mt-1 text-dark">{{ $totalMonitoring }}</h2>
                    </div>
                    <div class="kpi-icon bg-primary shadow-sm">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl col-sm-6">
                <div class="kpi-card d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase fw-bold text-muted" style="font-size: 11px; letter-spacing: 0.5px;">
                            SIAP OPERASI (SO)</div>
                        <h2 class="fw-bold text-success mb-0 mt-1">{{ $totalSo }}</h2>
                    </div>
                    <div class="kpi-icon bg-success shadow-sm">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl col-sm-6">
                <div class="kpi-card d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase fw-bold text-muted" style="font-size: 11px; letter-spacing: 0.5px;">
                            SO DENGAN CATATAN</div>
                        <h2 class="fw-bold text-warning mb-0 mt-1">{{ $totalSoCatatan }}</h2>
                    </div>
                    <div class="kpi-icon bg-warning text-white shadow-sm">
                        <i class="fa-solid fa-clipboard-check"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl col-sm-6">
                <div class="kpi-card d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase fw-bold text-muted" style="font-size: 11px; letter-spacing: 0.5px;">
                            TIDAK SIAP OPERASI (TSO)</div>
                        <h2 class="fw-bold text-danger mb-0 mt-1">{{ $totalTso }}</h2>
                    </div>
                    <div class="kpi-icon bg-danger shadow-sm">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl col-sm-6">
                <div class="kpi-card d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase fw-bold text-muted" style="font-size: 11px; letter-spacing: 0.5px;">
                            UNSCHEDULED FORM</div>
                        <h2 class="fw-bold text-secondary mb-0 mt-1">{{ $totalUnscheduled }}</h2>
                    </div>
                    <div class="kpi-icon bg-secondary text-white shadow-sm">
                        <i class="fa-solid fa-wrench"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- GRAFIK STATISTIK --}}
        <div class="row g-4 mb-4">
            <div class="col-lg-5">
                <div class="chart-card">
                    <div class="card-title-custom">
                        <i class="fa-solid fa-chart-pie"></i> Kondisi Unit (Kesimpulan)
                    </div>
                    <div class="chart-container">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="chart-card">
                    <div class="card-title-custom">
                        <i class="fa-solid fa-chart-column"></i> Jenis Perawatan Chiller
                    </div>
                    <div class="chart-container">
                        <canvas id="perawatanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABEL AKTIVITAS TERBARU --}}
        <div class="chart-card">
            <div class="card-title-custom">
                <i class="fa-solid fa-clock-rotate-left"></i> 5 Perawatan Terbaru
            </div>
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3">JUDUL</th>
                            <th class="py-3">NO CHILLER</th>
                            <th class="py-3">TANGGAL</th>
                            <th class="py-3">JENIS PERAWATAN</th>
                            <th class="py-3">KESIMPULAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestMonitoring as $item)
                            <tr>
                                <td class="fw-semibold text-dark">{{ $item->judul }}</td>
                                <td>
                                    <span class="badge bg-secondary px-3 py-2">
                                        {{ $item->no_chiller ?? '-' }}
                                    </span>
                                </td>
                                <td>{{ $item->tanggal_pelaksanaan ? \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->format('d/m/Y') : '-' }}
                                </td>
                                <td><span class="badge bg-info text-dark px-3 py-2">{{ $item->jenis_perawatan }}</span>
                                </td>
                                <td>
                                    <span
                                        class="badge px-3 py-2 {{ $item->kesimpulan == 'SO' ? 'bg-success' : (in_array($item->kesimpulan, ['SO DENGAN CATATAN', 'SO_NOTE']) ? 'bg-warning text-dark' : ($item->kesimpulan == 'TSO' ? 'bg-danger' : 'bg-secondary')) }}">
                                        {{ $item->kesimpulan ?? 'Belum Diisi' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada data perawatan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- INITIALIZE CHARTS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Doughnut Chart - Status Kesimpulan
            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Siap Operasi (SO)', 'SO dengan Catatan', 'Tidak Siap Operasi (TSO)',
                        'Belum Diisi'
                    ],
                    datasets: [{
                        data: [
                            {{ $totalSo }},
                            {{ $totalSoCatatan }},
                            {{ $totalTso }},
                            {{ $totalPending }}
                        ],
                        backgroundColor: ['#10b981', '#f59e0b', '#ef4444', '#64748b'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                font: {
                                    size: 12,
                                    family: "'Segoe UI', sans-serif"
                                }
                            }
                        }
                    },
                    cutout: '70%'
                }
            });

            // Bar Chart - Jenis Perawatan
            new Chart(document.getElementById('perawatanChart'), {
                type: 'bar',
                data: {
                    labels: ['P1', 'P3', 'P6', 'P12', 'Unscheduled'],
                    datasets: [{
                        label: 'Jumlah Perawatan',
                        data: [
                            {{ $perawatanCounts['P1'] }},
                            {{ $perawatanCounts['P3'] }},
                            {{ $perawatanCounts['P6'] }},
                            {{ $perawatanCounts['P12'] }},
                            {{ $perawatanCounts['Unscheduled'] }}
                        ],
                        backgroundColor: ['#3b82f6', '#6366f1', '#8b5cf6', '#ec4899', '#f97316'],
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                font: {
                                    family: "'Segoe UI', sans-serif"
                                }
                            },
                            grid: {
                                color: '#f1f5f9'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    family: "'Segoe UI', sans-serif"
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
