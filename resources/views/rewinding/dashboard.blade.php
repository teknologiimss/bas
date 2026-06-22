@extends('layouts.main')

@section('title', 'Dashboard Rewinding')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        body {
            background: #f4f6f9;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #dc3545, #ff4d4d);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .dashboard-header h3 {
            margin: 0;
            font-weight: bold;
        }

        .dashboard-header p {
            margin: 0;
            opacity: .9;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 3px 15px rgba(0, 0, 0, .08);
            transition: .3s;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, .12);
        }

        .stat-value {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-title {
            color: #666;
            font-size: 13px;
        }

        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 3px 15px rgba(0, 0, 0, .08);
        }

        .card-header {
            background: #dc3545;
            color: white;
            font-weight: bold;
            border-radius: 15px 15px 0 0 !important;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .scroll-table {
            max-height: 450px;
            overflow-y: auto;
        }

        @media(max-width:768px) {
            .stat-value {
                font-size: 24px;
            }
        }
    </style>

    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="dashboard-header">
            <h3>
                <i class="fas fa-sync-alt"></i>
                Dashboard Rewinding
            </h3>
            <p>Monitoring Seluruh Data Rewinding</p>
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
                        Status
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

                        Data Rewinding Status Open

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
                                        <th>Tanggal</th>
                                        <th>Deskripsi</th>
                                        <th>No SPPJP</th>
                                        <th>Jumlah Hari</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse($openData as $item)
                                        <tr>

                                            <td>{{ $loop->iteration }}</td>

                                            <td>{{ $item->no_sjn }}</td>

                                            <td>
                                                {{ $item->tanggal_sjn_keluar ? \Carbon\Carbon::parse($item->tanggal_sjn_keluar)->format('d-m-Y') : '-' }}
                                            </td>

                                            <td>{{ $item->deskripsi }}</td>

                                            <td>{{ $item->no_sppjp }}</td>

                                            <td>
                                                @if ($item->tanggal_sjn_keluar)
                                                    @php
                                                        $umur = \Carbon\Carbon::parse(
                                                            $item->tanggal_sjn_keluar,
                                                        )->diffInDays(now());
                                                    @endphp

                                                    <span
                                                        class="badge {{ $umur > 14 ? 'badge-danger' : 'badge-warning' }}">
                                                        {{ $umur }} Hari
                                                    </span>
                                                @else
                                                    -
                                                @endif
                                            </td>

                                        </tr>

                                    @empty

                                        <tr>
                                            <td colspan="6" class="text-center">
                                                Tidak ada data Open
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
