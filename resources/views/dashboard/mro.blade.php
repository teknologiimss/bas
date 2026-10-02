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
            box-shadow: 0 4px 16px rgba(15, 23, 42, .05);
            transition: all .25s ease;
        }

        /* Metric KPI Cards */
        .kpi-card {
            border: none;
            border-radius: 14px;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(15, 23, 42, .05);
            position: relative;
            overflow: hidden;
        }

        .kpi-icon-wrapper {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        /* Chart Canvas Containers */
        .chart-container-large {
            position: relative;
            margin: auto;
            height: 220px;
            width: 100%;
        }

        .chart-container-compact {
            position: relative;
            margin: auto;
            height: 180px;
            width: 100%;
        }

        .chart-container-gauge {
            position: relative;
            margin: auto;
            height: 130px;
            width: 130px;
        }

        /* Scrollable Table Container dengan Autoscroll */
        .table-scroll-container {
            max-height: 520px;
            overflow-y: auto;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            position: relative;
        }

        .table-scroll-container::-webkit-scrollbar {
            width: 5px;
        }

        .table-scroll-container::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .table-scroll-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 8px;
        }

        /* Sticky Table Header */
        .table-dashboard thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: linear-gradient(135deg, var(--navy), var(--blue)) !important;
            color: white;
            border: none;
            font-size: 12px;
            white-space: nowrap;
        }

        .table-dashboard td {
            font-size: 12px;
            vertical-align: middle;
        }
    </style>

    <div class="container-fluid py-3 px-4">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="font-weight-bold text-dark mb-0">Dashboard MRO</h4>
                <p class="text-muted small mb-0">Monitoring Ringkasan Proyek & Perawatan Aset MRO</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                {{-- Filter Tahun --}}
                <form action="{{ route('dashboard.mro') }}" method="GET" class="form-inline mr-2">
                    <select name="tahun" class="form-control form-control-sm border-secondary font-weight-bold"
                        onchange="this.form.submit()">
                        @for ($i = date('Y'); $i >= date('Y') - 4; $i--)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>Tahun
                                {{ $i }}</option>
                        @endfor
                    </select>
                </form>

                <span class="badge badge-light p-2 shadow-sm border">
                    🗓️ {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                </span>
            </div>
        </div>

        {{-- METRIC CARDS / SUMMARY KPI --}}
        <div class="row mb-3">
            <div class="col-xl-3 col-md-6 mb-2">
                <div class="card kpi-card p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small font-weight-bold text-uppercase">Total Pekerjaan MRO</span>
                            <h3 class="font-weight-bold text-dark mt-1 mb-0">{{ $totalKontrak }}</h3>
                            <small class="text-muted">Total Kontrak Terdaftar</small>
                        </div>
                        <div class="kpi-icon-wrapper bg-primary text-white">
                            <i class="fas fa-file-contract"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-2">
                <div class="card kpi-card p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small font-weight-bold text-uppercase">Pekerjaan Selesai</span>
                            <h3 class="font-weight-bold text-success mt-1 mb-0">{{ $totalSelesai }}</h3>
                            <small class="text-muted">Status Closed</small>
                        </div>
                        <div class="kpi-icon-wrapper bg-success text-white">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-2">
                <div class="card kpi-card p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small font-weight-bold text-uppercase">Kontrak Kritis</span>
                            <h3 class="font-weight-bold text-danger mt-1 mb-0">{{ $kontrakKritis }}</h3>
                            <small class="text-muted">H-7 & Telah Berakhir</small>
                        </div>
                        <div class="kpi-icon-wrapper bg-danger text-white">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-2">
                <div class="card kpi-card p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small font-weight-bold text-uppercase">Rata-rata Progress</span>
                            <h3 class="font-weight-bold text-info mt-1 mb-0">{{ $avgProgressPekerjaan }}%</h3>
                            <small class="text-muted">Capaian Progres MRO</small>
                        </div>
                        <div class="kpi-icon-wrapper bg-info text-white">
                            <i class="fas fa-tasks"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BARIS UTAMA --}}
        <div class="row">

            {{-- SISI KIRI: TABEL DAFTAR PROGRES MRO (WITH AUTO SCROLL) --}}
            <div class="col-lg-7 col-xl-7 mb-3">
                <div class="card card-dashboard h-100 p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h6 class="font-weight-bold text-dark mb-0">
                                <i class="fas fa-list-alt mr-2 text-info"></i>Daftar Progres Kontrak Pekerjaan
                            </h6>
                            <small class="text-muted">Total: <b>{{ $monitorings->count() }}</b> Pekerjaan</small>
                        </div>
                        <a href="{{ route('mro.progress.index') }}"
                            class="btn btn-xs btn-outline-primary rounded-pill px-3">
                            Kelola Data <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <div class="table-scroll-container" id="autoScrollTableContainer">
                        <table class="table table-hover table-striped table-dashboard mb-0">
                            <thead class="text-center">
                                <tr>
                                    <th>PO / Nota Dinas</th>
                                    <th>Nama Pekerjaan</th>
                                    <th>Tgl Kontrak</th>
                                    <th>Selesai Kontrak</th>
                                    <th>Dokumen Terakhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($monitorings as$m)
                                    @php
                                        $latestDoc = $m->documents->last();
                                    @endphp
                                    <tr>
                                        <td class="font-weight-bold text-primary">{{ $m->po_nota_dinas ?? '-' }}</td>
                                        <td>{{ $m->nama_pekerjaan ?? '-' }}</td>
                                        <td class="text-center">
                                            {{ $m->tanggal_kontrak ? \Carbon\Carbon::parse($m->tanggal_kontrak)->format('d-m-Y') : '-' }}
                                        </td>
                                        <td class="text-center">
                                            {{ $m->tanggal_selesai_kontrak ? \Carbon\Carbon::parse($m->tanggal_selesai_kontrak)->format('d-m-Y') : '-' }}
                                        </td>
                                        <td>
                                            @if ($latestDoc)
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <small class="font-weight-bold text-truncate" style="max-width: 120px;"
                                                        title="{{ $latestDoc->nama_dokumen }}">
                                                        {{ $latestDoc->nama_dokumen }}
                                                    </small>
                                                    @if (($latestDoc->status ?? '') == 'Closed')
                                                        <span class="badge badge-success">🟢 OK</span>
                                                    @elseif (($latestDoc->status ?? '') == 'Nok')
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

            {{-- SISI KANAN: CHART JATUH TEMPO, NOTIFIKASI & PM --}}
            <div class="col-lg-5 col-xl-5 mb-3">

                {{-- 1. STACKED BAR CHART JATUH TEMPO KONTRAK --}}
                <div class="card card-dashboard mb-3 p-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="font-weight-bold text-dark mb-0">
                            <i class="fas fa-calendar-alt mr-2 text-info"></i>Jatuh Tempo Kontrak ({{ $tahun }})
                        </h6>
                    </div>
                    <div class="chart-container-large">
                        <canvas id="jatuhTempoChart"></canvas>
                    </div>
                </div>

                {{-- 2. COMBINED CARD: NOTIFIKASI KONTRAK & PREVENTIVE MAINTENANCE --}}
                <div class="card card-dashboard p-3">
                    <div class="row align-items-center">

                        {{-- SEKSI A: NOTIFIKASI KONTRAK --}}
                        <div class="col-6 border-right">
                            <h6 class="font-weight-bold text-dark mb-1 text-center">
                                <i class="fas fa-bell mr-1 text-warning"></i>Notifikasi Kontrak
                            </h6>
                            <p class="text-muted style-small text-center mb-2" style="font-size: 11px;">Status Garansi &
                                Kontrak</p>
                            <div class="chart-container-compact">
                                <canvas id="notifikasiChart"></canvas>
                            </div>
                        </div>

                        {{-- SEKSI B: PREVENTIVE MAINTENANCE (PM) --}}
                        <div class="col-6 text-center">
                            <h6 class="font-weight-bold text-dark mb-1">
                                <i class="fas fa-tools mr-1 text-success"></i>Realisasi PM
                            </h6>
                            <p class="text-muted style-small mb-2" style="font-size: 11px;">Kalkulasi Rata-rata
                                {{ $tahun }}</p>

                            <div class="chart-container-gauge d-flex justify-content-center align-items-center">
                                <canvas id="pmGaugeChart"></canvas>
                                <div class="position-absolute text-center">
                                    <h4 class="font-weight-bold text-dark mb-0">{{ $pmYearlyPercentage }}%</h4>
                                    <small class="text-muted font-weight-bold" style="font-size: 10px;">Target
                                        100%</small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

    {{-- SCRIPT CHART JS, DATALABELS PLUGIN & AUTO SCROLL --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- Library Plugin DataLabels untuk Menampilkan Indikator Angka Langsung di Chart --}}
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Register ChartDataLabels Plugin untuk Chart.js v3+
            Chart.register(ChartDataLabels);

            // ==========================================
            // AUTO SCROLL TABEL DAFTAR PROGRES PEKERJAAN
            // ==========================================
            const tableContainer = document.getElementById('autoScrollTableContainer');
            if (tableContainer) {
                let scrollSpeed = 1;
                let scrollInterval = null;
                let isHovered = false;

                function startAutoScroll() {
                    if (scrollInterval) return;

                    scrollInterval = setInterval(function() {
                        if (!isHovered) {
                            if (tableContainer.scrollTop + tableContainer.clientHeight >= tableContainer
                                .scrollHeight - 1) {
                                tableContainer.scrollTop = 0;
                            } else {
                                tableContainer.scrollTop += scrollSpeed;
                            }
                        }
                    }, 30);
                }

                tableContainer.addEventListener('mouseenter', function() {
                    isHovered = true;
                });

                tableContainer.addEventListener('mouseleave', function() {
                    isHovered = false;
                });

                startAutoScroll();
            }

            // ==========================================
            // 1. Stacked Bar Chart Monitoring Jatuh Tempo
            // ==========================================
            new Chart(document.getElementById('jatuhTempoChart'), {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov',
                        'Des'
                    ],
                    datasets: [{
                            label: 'Selesai',
                            data: @json($dueDateSelesai),
                            backgroundColor: '#22c55e',
                            borderRadius: 4
                        },
                        {
                            label: 'Belum Selesai',
                            data: @json($dueDateBelumSelesai),
                            backgroundColor: '#ef4444',
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true,
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 8,
                                font: {
                                    size: 10,
                                    weight: '500'
                                }
                            }
                        },
                        // Matikan datalabels pada bar chart agar tidak menumpuk/kotor
                        datalabels: {
                            display: false
                        }
                    }
                }
            });

            // ==========================================
            // 2. Chart Notifikasi Kontrak (Doughnut) dengan Indikator Angka
            // ==========================================
            const notifData = [
                {{ $notifCounts['berjalan'] ?? 0 }},
                {{ $notifCounts['h7'] ?? 0 }},
                {{ $notifCounts['berakhir'] ?? 0 }},
                {{ $notifCounts['selesai'] ?? 0 }}
            ];
            const notifLabels = ['Berjalan', 'H-7', 'Telah Berakhir', 'Selesai'];

            new Chart(document.getElementById('notifikasiChart'), {
                type: 'doughnut',
                data: {
                    labels: notifLabels,
                    datasets: [{
                        data: notifData,
                        backgroundColor: ['#22c55e', '#eab308', '#ef4444', '#2563eb'],
                        borderWidth: 2,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: 10
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 10,
                                padding: 6,
                                font: {
                                    size: 10,
                                    weight: 'bold'
                                },
                                // Menambahkan angka langsung di teks Legend (contoh: Berjalan: 5)
                                generateLabels: function(chart) {
                                    const data = chart.data;
                                    if (data.labels.length && data.datasets.length) {
                                        return data.labels.map((label, i) => {
                                            const value = data.datasets[0].data[i];
                                            return {
                                                text: `${label}: ${value}`,
                                                fillStyle: data.datasets[0].backgroundColor[i],
                                                strokeStyle: '#fff',
                                                lineWidth: 1,
                                                hidden: false,
                                                index: i
                                            };
                                        });
                                    }
                                    return [];
                                }
                            }
                        },
                        // KONFIGURASI DATALABELS (Menampilkan angka langsung di atas segmen chart)
                        datalabels: {
                            display: function(context) {
                                // Sembunyikan angka jika nilainya 0 agar chart tetap bersih
                                return context.dataset.data[context.dataIndex] > 0;
                            },
                            color: '#ffffff',
                            font: {
                                weight: 'bold',
                                size: 12
                            },
                            formatter: function(value) {
                                return value; // Menampilkan nilai angka
                            },
                            backgroundColor: function(context) {
                                return context.dataset.backgroundColor[context.dataIndex];
                            },
                            borderRadius: 4,
                            padding: {
                                top: 2,
                                bottom: 2,
                                left: 6,
                                right: 6
                            }
                        }
                    }
                }
            });

            // ==========================================
            // 3. Gauge Chart PM (Doughnut)
            // ==========================================
            const pmValue = {{ $pmYearlyPercentage ?? 0 }};
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
                    cutout: '80%',
                    plugins: {
                        tooltip: {
                            enabled: false
                        },
                        datalabels: {
                            display: false
                        } // Sembunyikan datalabels untuk gauge chart
                    }
                }
            });

        });
    </script>
@endsection
