@extends('layouts.main')

@section('title', 'Dashboard Monitoring SPR')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        body {
            background: #f4f6f9;
        }

        /* HEADER */
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

        /* KPI CARD */
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
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, .15);
        }

        .stat-value {
            font-size: 32px;
            font-weight: bold;
        }

        .stat-title {
            font-size: 13px;
            color: #666;
        }

        /* CARD */
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 3px 15px rgba(0, 0, 0, .08);
        }

        .card-header {
            background: #dc3545;
            color: white;
            font-weight: bold;
        }

        /* SCROLL TABLE */
        .scroll-table {
            max-height: 450px;
            overflow-y: auto;
        }

        /* MOBILE */
        @media(max-width:768px) {
            .stat-value {
                font-size: 24px;
            }
        }
    </style>

    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="dashboard-header">
            <h3>📊 Dashboard Monitoring SPR</h3>
            <p>Monitoring Data SPR</p>
        </div>

        {{-- KPI --}}
        <div class="row">

            {{-- TOTAL --}}
            <div class="col-md-3 mb-3">
                <a href="{{ route('lp3m.spr.list') }}" style="text-decoration:none;">
                    <div class="stat-card">
                        <i class="fas fa-database fa-2x text-danger mb-2"></i>
                        <div class="stat-value text-danger">{{ $total }}</div>
                        <div class="stat-title">Total SPR</div>
                    </div>
                </a>
            </div>

            {{-- OPEN --}}
            <div class="col-md-3 mb-3">
                <a href="{{ route('lp3m.spr.list', ['status' => 'OPEN']) }}" style="text-decoration:none;">
                    <div class="stat-card">
                        <i class="fas fa-folder-open fa-2x text-warning mb-2"></i>
                        <div class="stat-value text-warning">{{ $open }}</div>
                        <div class="stat-title">Open SPR</div>
                    </div>
                </a>
            </div>

            {{-- CLOSED --}}
            <div class="col-md-3 mb-3">
                <a href="{{ route('lp3m.spr.list', ['status' => 'CLOSED']) }}" style="text-decoration:none;">
                    <div class="stat-card">
                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                        <div class="stat-value text-success">{{ $closed }}</div>
                        <div class="stat-title">Closed SPR</div>
                    </div>
                </a>
            </div>

            {{-- PROGRESS --}}
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <i class="fas fa-chart-pie fa-2x text-info mb-2"></i>
                    <div class="stat-value text-info">{{ $progress }}%</div>
                    <div class="stat-title">Completion</div>
                </div>
            </div>

        </div>

        {{-- CHART + TABLE (SEJAJAR) --}}
        <div class="row mt-3">

            {{-- CHART --}}
            <div class="col-md-4 mb-3">

                <div class="card">

                    <div class="card-header">
                        Status SPR
                    </div>

                    <div class="card-body text-center">

                        <canvas id="sprChart" height="200"></canvas>

                    </div>

                </div>

            </div>

            {{-- TABLE OPEN --}}
            <div class="col-md-8 mb-3">

                <div class="card">

                    <div class="card-header">
                        Data SPR Open

                        <span class="badge badge-light float-right">
                            {{ $openData->count() }} Data
                        </span>
                    </div>

                    <div class="card-body p-0">

                        <div class="scroll-table">

                            <table class="table table-bordered mb-0">

                                <thead class="thead-light">
                                    <tr>
                                        <th>No SPR</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                        <th>Jumlah Hari</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse($openData as $item)
                                        <tr>
                                            <td>{{ $item->spr_no ?? '-' }}</td>
                                            <td>{{ $item->deskripsi }}</td>
                                            <td>
                                                <span class="badge badge-warning">OPEN</span>
                                            </td>
                                            <td>
                                                {{ $item->created_at->diffInDays(now()) }} Hari
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data</td>
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

    {{-- CHART JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('sprChart');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Open', 'Closed'],
                datasets: [{
                    data: [{{ $open }}, {{ $closed }}],
                    backgroundColor: ['#ffc107', '#28a745']
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
    </script>

@endsection
