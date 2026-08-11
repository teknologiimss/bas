@extends('layouts.main')

<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

@section('content')
    <style>
        :root {
            --primary-color: #0b3d91;
            --secondary-bg: #f8f9fa;
        }

        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Executive Header Card */
        .exec-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }

        .kpi-title {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            font-weight: 600;
        }

        .kpi-value {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .chart-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            background: #ffffff;
        }

        .badge-soft-danger {
            background-color: #f8d7da;
            color: #842029;
        }

        .badge-soft-success {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .badge-soft-warning {
            background-color: #fff3cd;
            color: #664d03;
        }

        /* Print / Presentation Mode */
        @media print {
            .no-print {
                display: none !important;
            }

            .card {
                border: 1px solid #ddd !important;
                box-shadow: none !important;
            }
        }
    </style>

    <div class="container-fluid py-3">

        {{-- HEADER LAPORAN & ACTION --}}
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <div>
                <h3 class="fw-bold mb-1" style="color: var(--primary-color);">
                    <i class="bi bi-bar-chart-line-fill me-2"></i>Weekly MRO Activity Report
                </h3>
                <p class="text-muted mb-0">Periode: {{ $start->format('d M Y') }} - {{ $end->format('d M Y') }}</p>
            </div>
            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-outline-secondary">
                    <i class="bi bi-printer me-1"></i> Print / PDF
                </button>
                <a href="{{ route('mro.weekly.export', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
                    class="btn btn-success">
                    <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                </a>
            </div>
        </div>

        {{-- FILTER CONTROL --}}
        <div class="card exec-card mb-4 no-print">
            <div class="card-body p-3">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-secondary">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control"
                            value="{{ request('start_date', $start->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-secondary">Tanggal Selesai</label>
                        <input type="date" name="end_date" class="form-control"
                            value="{{ request('end_date', $end->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100"
                            style="background-color: var(--primary-color);">
                            <i class="bi bi-filter me-1"></i> Terapkan Filter
                        </button>
                        <a href="{{ url()->current() }}" class="btn btn-light border" title="Reset">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- KPI METRICS (SCORECARD) --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card exec-card p-3 border-start border-primary border-4" data-bs-toggle="modal"
                    data-bs-target="#modalTotal" style="cursor:pointer;">
                    <div class="kpi-title">Total Kegiatan</div>
                    <div class="d-flex align-items-baseline justify-content-between mt-2">
                        <div class="kpi-value text-dark">{{ $total }}</div>
                        <span class="badge bg-primary rounded-pill"><i class="bi bi-list-task"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card exec-card p-3 border-start border-success border-4" data-bs-toggle="modal"
                    data-bs-target="#modalClosed" style="cursor:pointer;">
                    <div class="kpi-title">Kegiatan Closed</div>
                    <div class="d-flex align-items-baseline justify-content-between mt-2">
                        <div class="kpi-value text-success">{{ $closed }}</div>
                        <span class="badge bg-success rounded-pill"><i class="bi bi-check-circle"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card exec-card p-3 border-start border-warning border-4" data-bs-toggle="modal"
                    data-bs-target="#modalOpen" style="cursor:pointer;">
                    <div class="kpi-title">Open / In-Progress</div>
                    <div class="d-flex align-items-baseline justify-content-between mt-2">
                        <div class="kpi-value text-warning">{{ $open }}</div>
                        <span class="badge bg-warning text-dark rounded-pill"><i class="bi bi-clock-history"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card exec-card p-3 border-start border-info border-4">
                    <div class="kpi-title">Completion Rate</div>
                    <div class="d-flex align-items-baseline justify-content-between mt-2">
                        <div class="kpi-value text-info">{{ $completionRate }}%</div>
                        <span class="badge bg-info rounded-pill"><i class="bi bi-pie-chart"></i></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- VISUAL DASHBOARD SECTION --}}
        <div class="row g-3 mb-4">
            {{-- TREND CHART --}}
            <div class="col-lg-7">
                <div class="card chart-card p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-graph-up-arrow me-2 text-primary"></i>Tren
                            Aktivitas Harian</h6>
                        <small class="text-muted">Status Aktivitas / Hari</small>
                    </div>
                    <div id="trendChart" style="min-height: 280px;"></div>
                </div>
            </div>

            {{-- EXECUTIVE SUMMARY & BLOCKERS --}}
            <div class="col-lg-5">
                <div class="card chart-card p-3 h-100">
                    <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-exclamation-triangle-fill me-2 text-warning"></i>Key
                        Issues & Blockers</h6>
                    <div style="max-height: 280px; overflow-y: auto;">
                        @php $hasIssue = false; @endphp
                        @foreach ($projectSummary as $p)
                            @if ($p['open'] > 0)
                                @php $hasIssue = true; @endphp
                                <div class="p-2 mb-2 rounded bg-light border-start border-danger border-3">
                                    <div class="fw-bold text-dark small">{{ $p['project'] }}</div>
                                    <div class="text-danger small mt-1">
                                        <i class="bi bi-info-circle me-1"></i> {{ $p['open'] }} kendala unresolved.
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        @if (!$hasIssue)
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-shield-check text-success display-6"></i>
                                <p class="mt-2 mb-0 small">Semua aktivitas berjalan lancar tanpa kendala kritis.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- PROJECT PROGRESS METRICS --}}
        <div class="card chart-card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-kanban me-2 text-primary"></i>Ringkasan Progress Per
                    Proyek</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach ($projectSummary as $p)
                        <div class="col-md-6 col-lg-4">
                            <div class="p-3 border rounded bg-white">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold text-truncate text-dark" style="max-width: 70%;"
                                        title="{{ $p['project'] }}">{{ $p['project'] }}</span>
                                    <span
                                        class="badge {{ $p['rate'] == 100 ? 'bg-success' : 'bg-primary' }}">{{ $p['rate'] }}%</span>
                                </div>
                                <div class="progress mb-2" style="height: 6px;">
                                    <div class="progress-bar {{ $p['rate'] == 100 ? 'bg-success' : 'bg-primary' }}"
                                        role="progressbar" style="width: {{ $p['rate'] }}%"></div>
                                </div>
                                <div class="d-flex justify-content-between text-muted extra-small"
                                    style="font-size: 0.8rem;">
                                    <span>Total: {{ $p['total'] }}</span>
                                    <span>Done: <strong class="text-success">{{ $p['closed'] }}</strong> | Open: <strong
                                            class="text-danger">{{ $p['open'] }}</strong></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ACTIVITY DETAILS (ACCORDION STYLE FOR CLEANER LOOK) --}}
        {{-- ACTIVITY DETAILS (ALL OPEN BY DEFAULT) --}}
        <div class="card chart-card">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-journal-text me-2 text-primary"></i>Rincian Activity Log Mingguan
                </h6>
            </div>
            <div class="card-body">
                <div class="accordion" id="accordionProject">
                    @foreach ($projectSummary as $index => $p)
                        <div class="accordion-item border mb-3 rounded overflow-hidden">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button bg-light" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $index }}" aria-expanded="true">
                                    <div class="d-flex justify-content-between align-items-center w-100 me-3">
                                        <span class="fw-bold text-dark">{{ $p['project'] }}</span>
                                        <div>
                                            <span class="badge badge-soft-success me-1">{{ $p['closed'] }} Closed</span>
                                            @if ($p['open'] > 0)
                                                <span class="badge badge-soft-danger">{{ $p['open'] }} Open</span>
                                            @endif
                                        </div>
                                    </div>
                                </button>
                            </h2>
                            {{-- Hapus data-bs-parent agar antar item tidak saling menutup --}}
                            <div id="collapse{{ $index }}" class="accordion-collapse collapse show">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 12%;">Tanggal</th>
                                                    <th style="width: 45%;">Kegiatan</th>
                                                    <th style="width: 13%;">Status</th>
                                                    <th style="width: 30%;">Keterangan / Kendala</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($p['items'] as $item)
                                                    <tr>
                                                        <td class="text-nowrap">
                                                            {{ date('d M Y', strtotime($item->tanggal)) }}
                                                        </td>
                                                        <td>{!! nl2br(e($item->kegiatan)) !!}</td>
                                                        <td>
                                                            @if ($item->status == 'open')
                                                                <span class="badge badge-soft-danger">
                                                                    <i class="bi bi-exclamation-circle me-1"></i>OPEN
                                                                </span>
                                                            @else
                                                                <span class="badge badge-soft-success">
                                                                    <i class="bi bi-check-circle me-1"></i>CLOSED
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($item->keterangan)
                                                                <span
                                                                    class="{{ $item->status == 'open' ? 'text-danger fw-bold' : 'text-muted' }}">
                                                                    {!! nl2br(e($item->keterangan)) !!}
                                                                </span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- MODALS LIST --}}
    {{-- MODAL TOTAL --}}
    <div class="modal fade" id="modalTotal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: var(--primary-color);">
                    <h5 class="modal-title"><i class="bi bi-list-task me-2"></i>Semua Aktivitas</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Tanggal</th>
                                <th>Proyek</th>
                                <th>Kegiatan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr>
                                    <td class="text-nowrap">{{ date('d-m-Y', strtotime($d->tanggal)) }}</td>
                                    <td>{{ optional($d->monitoring)->nama_pekerjaan ?? 'Tanpa Proyek' }}</td>
                                    <td>{!! nl2br(e($d->kegiatan)) !!}</td>
                                    <td>
                                        <span
                                            class="badge {{ $d->status == 'open' ? 'bg-danger' : 'bg-success' }}">{{ strtoupper($d->status) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL OPEN --}}
    <div class="modal fade" id="modalOpen" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle me-2"></i>Daftar Kendala (Open)</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Tanggal</th>
                                <th>Proyek</th>
                                <th>Kegiatan</th>
                                <th>Kendala / Issues</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->where('status', 'open') as $d)
                                <tr>
                                    <td class="text-nowrap">{{ date('d-m-Y', strtotime($d->tanggal)) }}</td>
                                    <td>{{ optional($d->monitoring)->nama_pekerjaan ?? 'Tanpa Proyek' }}</td>
                                    <td>{!! nl2br(e($d->kegiatan)) !!}</td>
                                    <td class="text-danger font-weight-bold">{!! nl2br(e($d->keterangan ?? '-')) !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL CLOSED --}}
    <div class="modal fade" id="modalClosed" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-check-circle me-2"></i>Aktivitas Selesai (Closed)</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Tanggal</th>
                                <th>Proyek</th>
                                <th>Kegiatan</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->where('status', 'closed') as $d)
                                <tr>
                                    <td class="text-nowrap">{{ date('d-m-Y', strtotime($d->tanggal)) }}</td>
                                    <td>{{ optional($d->monitoring)->nama_pekerjaan ?? 'Tanpa Proyek' }}</td>
                                    <td>{!! nl2br(e($d->kegiatan)) !!}</td>
                                    <td>{!! nl2br(e($d->keterangan ?? '-')) !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- APEXCHARTS --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var options = {
                chart: {
                    type: 'bar',
                    height: 280,
                    stacked: true,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '40%',
                        borderRadius: 4
                    },
                },
                series: [{
                        name: 'Closed',
                        data: @json($trendClosed)
                    },
                    {
                        name: 'Open Issue',
                        data: @json($trendOpen)
                    }
                ],
                xaxis: {
                    categories: @json($trendLabels)
                },
                colors: ['#198754', '#dc3545'],
                legend: {
                    position: 'top',
                    horizontalAlign: 'right'
                },
                fill: {
                    opacity: 1
                },
                dataLabels: {
                    enabled: false
                }
            };

            new ApexCharts(document.querySelector("#trendChart"), options).render();
        });
    </script>
@endsection
