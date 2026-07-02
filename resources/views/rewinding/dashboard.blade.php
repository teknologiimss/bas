@extends('layouts.main')

@section('title', 'Dashboard Rewinding')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        body {
            background: #f4f7fb;
        }

        /* =========================
           HEADER
        ========================= */
        .dashboard-header {
            background: linear-gradient(135deg, #0b1f3a, #163a6b);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 8px 20px rgba(11, 31, 58, .18);
        }

        .dashboard-header h3 {
            margin: 0;
            font-weight: bold;
        }

        .dashboard-header p {
            margin: 5px 0 0;
            opacity: .9;
        }

        /* =========================
           KPI CARD
        ========================= */
        .stat-card {
            background: white;
            border: 1px solid #e6eef8;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 3px 15px rgba(11, 31, 58, .08);
            transition: .3s;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(11, 31, 58, .18);
        }

        .stat-value {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #163a6b;
        }

        .stat-title {
            color: #6b7280;
            font-size: 13px;
        }

        /* =========================
           ICON
        ========================= */
        .text-danger,
        .text-warning,
        .text-success,
        .text-info {
            color: #2563eb !important;
        }

        /* =========================
           CARD
        ========================= */
        .card {
            border: 1px solid #e6eef8;
            border-radius: 15px;
            box-shadow: 0 3px 15px rgba(11, 31, 58, .08);
            overflow: hidden;
        }

        .card-header {
            background: #163a6b;
            color: white;
            font-weight: bold;
            border: none;
        }

        /* =========================
           TABLE
        ========================= */
        .table thead,
        .table thead th,
        .thead-light th {
            background: #163a6b !important;
            color: white !important;
            border-color: #163a6b !important;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .table tbody tr {
            transition: .25s;
        }

        .table tbody tr:hover {
            background: #eef4ff;
        }

        

        /* =========================
           SCROLLBAR
        ========================= */
        .scroll-table {
            max-height: 450px;
            overflow-y: auto;
        }

        .scroll-table::-webkit-scrollbar {
            width: 8px;
        }

        .scroll-table::-webkit-scrollbar-thumb {
            background: #163a6b;
            border-radius: 10px;
        }

        /* =========================
           MOBILE
        ========================= */
        @media(max-width:768px) {

            .stat-value {
                font-size: 24px;
            }

            .dashboard-header {
                text-align: center;
            }
        }

        /* =========================
           PAGINATION
        ========================= */
        .pagination .page-link {
            color: #163a6b;
            border-radius: 8px;
            margin: 0 2px;
        }

        .pagination .page-item.active .page-link {
            background: #163a6b;
            border-color: #163a6b;
        }

        .pagination .page-link:hover {
            background: #eef4ff;
            color: #0b1f3a;
        }
    </style>

    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="dashboard-header">
            <h3>📊 Dashboard Monitoring Rewinding</h3>
            <p>Monitoring Data Rewinding</p>
        </div>

        {{-- KPI --}}
        <div class="row">

            {{-- Total --}}
            <div class="col-md-3 mb-3">
                <a href="{{ route('rewinding.list') }}" style="text-decoration:none;color:inherit">
                    <div class="stat-card">
                        <i class="fas fa-sync-alt fa-2x text-danger mb-2"></i>
                        <div class="stat-value text-danger">{{ $total }}</div>
                        <div class="stat-title">Total Rewinding</div>
                    </div>
                </a>
            </div>

            {{-- Open --}}
            <div class="col-md-3 mb-3">
                <a href="{{ route('rewinding.list', ['status' => 'Open']) }}" style="text-decoration:none;color:inherit">
                    <div class="stat-card">
                        <i class="fas fa-folder-open fa-2x text-warning mb-2"></i>
                        <div class="stat-value text-warning">{{ $open }}</div>
                        <div class="stat-title">Open</div>
                    </div>
                </a>
            </div>

            {{-- Closed --}}
            <div class="col-md-3 mb-3">
                <a href="{{ route('rewinding.list', ['status' => 'Closed']) }}" style="text-decoration:none;color:inherit">
                    <div class="stat-card">
                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                        <div class="stat-value text-success">{{ $closed }}</div>
                        <div class="stat-title">Closed</div>
                    </div>
                </a>
            </div>

            {{-- Progress --}}
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <i class="fas fa-chart-pie fa-2x text-info mb-2"></i>
                    <div class="stat-value text-info">{{ $progress }}%</div>
                    <div class="stat-title">Completion</div>
                </div>
            </div>

        </div>

        {{-- CHART + TABLE --}}
        <div class="row mt-3">

            {{-- CHART --}}
            <div class="col-md-4 mb-3">

                <div class="card">

                    <div class="card-header">
                        Status Rewinding
                    </div>

                    <div class="card-body text-center">

                        <div style="max-width:280px; margin:auto;">
                            <canvas id="statusChart"></canvas>
                        </div>

                    </div>

                </div>

            </div>

            {{-- TABLE OPEN --}}
            <div class="col-md-8 mb-3">

                <div class="card">

                    <div class="card-header">

                        Data Rewinding Open

                        <span class="badge badge-light float-right">
                            {{ $openData->count() }} Data
                        </span>

                    </div>

                    <div class="card-body p-0">

                        <div class="scroll-table">

                            <table class="table table-bordered table-hover mb-0">

                                <thead class="thead-light">

                                    <tr>
                                        <th>No</th>
                                        <th>No SJN</th>
                                        <th>Tgl Keluar</th>
                                        <th>Tgl Masuk</th>
                                        <th>Deskripsi</th>
                                        <th>No SPPJP</th>
                                        <th>Status</th>
                                        <th>Durasi</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse($openData as $item)
                                        @php

                                            $durasi = 0;

                                            if ($item->tanggal_sjn_keluar) {
                                                $tglKeluar = \Carbon\Carbon::parse($item->tanggal_sjn_keluar);

                                                if ($item->tanggal_sjn_masuk) {
                                                    $tglMasuk = \Carbon\Carbon::parse($item->tanggal_sjn_masuk);

                                                    $durasi = $tglKeluar->diffInDays($tglMasuk);
                                                } else {
                                                    $durasi = $tglKeluar->diffInDays(now());
                                                }
                                            }

                                        @endphp

                                        <tr>

                                            <td>{{ $loop->iteration }}</td>

                                            <td>{{ $item->no_sjn }}</td>

                                            <td>
                                                {{ $item->tanggal_sjn_keluar ? \Carbon\Carbon::parse($item->tanggal_sjn_keluar)->format('d-m-Y') : '-' }}
                                            </td>

                                            <td>
                                                {{ $item->tanggal_sjn_masuk ? \Carbon\Carbon::parse($item->tanggal_sjn_masuk)->format('d-m-Y') : '-' }}
                                            </td>

                                            <td>{{ $item->deskripsi }}</td>

                                            <td>{{ $item->no_sppjp }}</td>

                                            <td>

                                                @if ($item->status == 'Closed')
                                                    <span class="badge badge-success">
                                                        Closed
                                                    </span>
                                                @else
                                                    <span class="badge badge-warning">
                                                        Open
                                                    </span>
                                                @endif

                                            </td>

                                            <td>

                                                @if ($item->status == 'Closed')
                                                    <span class="badge badge-success">
                                                        {{ $durasi }} Hari
                                                    </span>
                                                @else
                                                    <span
                                                        class="badge {{ $durasi > 14 ? 'badge-danger' : 'badge-warning' }}">
                                                        {{ $durasi }} Hari
                                                    </span>
                                                @endif

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

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- CHART --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const statusCtx = document.getElementById('statusChart');

        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Open', 'Closed'],
                datasets: [{
                    data: [
                        {{ $statusChart['open'] }},
                        {{ $statusChart['closed'] }}
                    ],
                    backgroundColor: ['#ffc107', '#28a745']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

@endsection
