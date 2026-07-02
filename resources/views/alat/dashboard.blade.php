@extends('layouts.main')

@section('title', 'Dashboard Alat Angkat-Angkut')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        body {
            background: #f4f7fb;
        }

        /* =========================
           HEADER NAVY
        ========================= */
        .dashboard-header {
            background: linear-gradient(135deg, #0b1f3a, #163a6b);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        /* =========================
           STAT CARD
        ========================= */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 3px 15px rgba(11, 31, 58, .08);
            transition: .3s;
            height: 100%;
            border: 1px solid #e6eef8;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(11, 31, 58, .15);
        }

        .stat-value {
            font-size: 32px;
            font-weight: bold;
            color: #163a6b;
        }

        .stat-title {
            color: #5b6b82;
            font-size: 13px;
        }

        /* =========================
           CARD
        ========================= */
        .card {
            border: 1px solid #e6eef8;
            border-radius: 15px;
            box-shadow: 0 3px 15px rgba(11, 31, 58, .08);
        }

        .card-header {
            background: #163a6b;
            color: white;
            font-weight: bold;
            border-bottom: none;
        }

        

        /* =========================
           TABLE
        ========================= */
        .table th {
            background: #163a6b;
            color: white;
            white-space: nowrap;
        }

        .table td {
            white-space: nowrap;
            color: #1f2d3d;
        }

        .table-hover tbody tr:hover {
            background: #eef4ff;
        }

        @media(max-width:768px) {
            .stat-value {
                font-size: 24px;
            }
        }
    </style>

    <div class="container-fluid">

        <div class="dashboard-header">

            <h3>
                <i class="fas fa-truck"></i>
                Dashboard Alat Angkat-Angkut
            </h3>

            <p>
                Monitoring Seluruh Unit Alat Angkat-Angkut
            </p>

        </div>

        <div class="row">

            {{-- TOTAL UNIT --}}
            <div class="col-md-3 mb-3">

                <a href="{{ route('alat.list') }}" style="text-decoration:none;color:inherit">

                    <div class="stat-card">

                        <i class="fas fa-truck fa-2x text-danger mb-2"></i>

                        <div class="stat-value text-danger">
                            {{ $totalUnit }}
                        </div>

                        <div class="stat-title">
                            Total Unit
                        </div>

                    </div>

                </a>

            </div>

            {{-- IMSS --}}
            <div class="col-md-3 mb-3">

                <a href="{{ route('alat.list', ['aset' => 'IMSS']) }}" style="text-decoration:none;color:inherit">

                    <div class="stat-card">

                        <i class="fas fa-industry fa-2x text-success mb-2"></i>

                        <div class="stat-value text-success">
                            {{ $imss }}
                        </div>

                        <div class="stat-title">
                            IMSS
                        </div>

                    </div>

                </a>

            </div>

            {{-- NON IMSS --}}
            <div class="col-md-3 mb-3">

                <a href="{{ route('alat.list', ['aset' => 'NON']) }}" style="text-decoration:none;color:inherit">

                    <div class="stat-card">

                        <i class="fas fa-warehouse fa-2x text-warning mb-2"></i>

                        <div class="stat-value text-warning">
                            {{ $nonImss }}
                        </div>

                        <div class="stat-title">
                            Non IMSS
                        </div>

                    </div>

                </a>

            </div>

            {{-- LOKASI --}}
            <div class="col-md-3 mb-3">

                <a href="{{ route('alat.lokasi.list') }}" style="text-decoration:none;color:inherit">

                    <div class="stat-card">

                        <i class="fas fa-map-marker-alt fa-2x text-info mb-2"></i>

                        <div class="stat-value text-info">
                            {{ $totalLokasi }}
                        </div>

                        <div class="stat-title">
                            Total Lokasi
                        </div>

                    </div>

                </a>

            </div>

        </div>

        <div class="row">

            {{-- CHART --}}
            <div class="col-md-4">

                <div class="card">

                    <div class="card-header">

                        Jumlah Aset

                    </div>

                    <div class="card-body">

                        <canvas id="statusChart"></canvas>

                    </div>

                </div>

            </div>

            {{-- SUMMARY UNIT --}}
            <div class="col-md-8">

                <div class="card">

                    <div class="card-header">

                        Ringkasan Unit

                    </div>

                    <div class="card-body p-0">

                        <div style="max-height:400px;overflow-y:auto;">

                            <table class="table table-bordered table-hover mb-0">

                                <thead>

                                    <tr>

                                        <th>Unit</th>
                                        <th>Total</th>
                                        <th>IMSS</th>
                                        <th>Non IMSS</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($unitSummary as $unit => $item)
                                        <tr>

                                            <td>

                                                <strong>
                                                    {{ $unit }}
                                                </strong>

                                            </td>

                                            <td>

                                                <span class="badge badge-success">

                                                    {{ $item['total'] }}

                                                </span>

                                            </td>

                                            <td>

                                                <span class="badge badge-danger">

                                                    {{ $item['imss'] }}

                                                </span>

                                            </td>

                                            <td>

                                                <span class="badge badge-warning">

                                                    {{ $item['non_imss'] }}

                                                </span>

                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>



    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        new Chart(
            document.getElementById('statusChart'), {
                type: 'doughnut',

                data: {
                    labels: ['IMSS', 'Non IMSS'],

                    datasets: [{
                        data: [
                            {{ $statusChart['imss'] }},
                            {{ $statusChart['non'] }}
                        ],

                        backgroundColor: [
                            '#dc3545',
                            '#ffd43b'
                        ]
                    }]
                }
            }
        );
    </script>

@endsection
