@extends('layouts.main')

@section('title', 'Dashboard Pengiriman')

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

    <style>
        body {
            background: #f4f6f9;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #b30000, #ff3333);
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
        }

        .stat-value {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-title {
            color: #666;
            font-size: 13px;
        }

        .card-dashboard {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, .08);
        }

        .card-dashboard h5 {
            color: #b30000;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .progress {
            height: 28px;
            border-radius: 30px;
        }

        .progress-bar {
            font-weight: bold;
        }

        .big-number {
            font-size: 50px;
            font-weight: bold;
            color: #b30000;
        }

        @media(max-width:768px) {
            .stat-value {
                font-size: 24px;
            }
        }
    </style>

    <div class="container-fluid">

        <div class="dashboard-header">
            <h3>📊 Dashboard Pengiriman</h3>
            <p>Monitoring Seluruh Proyek Pengiriman</p>
        </div>

        {{-- KPI --}}
        <div class="row">

            <div class="col-md-3 mb-3">
                <a href="{{ route('pengiriman.dashboard.detail', 'proyek') }}" style="text-decoration:none;color:inherit">
                    <div class="stat-card">
                        <div class="stat-value">
                            {{ $projectCount }}
                        </div>
                        <div class="stat-title">
                            Total Proyek
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mb-3">
                <a href="{{ route('pengiriman.dashboard.detail', 'pengiriman') }}"
                    style="text-decoration:none;color:inherit">
                    <div class="stat-card">
                        <div class="stat-value text-primary">
                            {{ $totalData }}
                        </div>
                        <div class="stat-title">
                            Total Pengiriman
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mb-3">
                <a href="{{ route('pengiriman.dashboard.detail', 'ontime') }}" style="text-decoration:none;color:inherit">
                    <div class="stat-card">
                        <div class="stat-value text-success">
                            {{ $onTime }}
                        </div>
                        <div class="stat-title">
                            On Time
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mb-3">
                <a href="{{ route('pengiriman.dashboard.detail', 'overdue') }}" style="text-decoration:none;color:inherit">
                    <div class="stat-card">
                        <div class="stat-value text-danger">
                            {{ $overdue }}
                        </div>
                        <div class="stat-title">
                            Overdue
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <div class="row">

            <div class="col-md-3 mb-3">
                <a href="{{ route('pengiriman.dashboard.detail', 'delivery') }}" style="text-decoration:none;color:inherit">
                    <div class="stat-card">
                        <div class="stat-value text-info">
                            {{ $delivered }}
                        </div>
                        <div class="stat-title">
                            Sudah Delivery
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mb-3">
                <a href="{{ route('pengiriman.dashboard.detail', 'unloading') }}"
                    style="text-decoration:none;color:inherit">
                    <div class="stat-card">
                        <div class="stat-value text-warning">
                            {{ $unloading }}
                        </div>
                        <div class="stat-title">
                            Sudah Unloading
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="stat-value">
                        {{ $vendorCount }}
                    </div>
                    <div class="stat-title">
                        Vendor Aktif
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <a href="{{ route('pengiriman.dashboard.detail', 'trainset') }}"
                    style="text-decoration:none;color:inherit">
                    <div class="stat-card">
                        <div class="stat-value">
                            {{ $trainsetCount }}
                        </div>
                        <div class="stat-title">
                            Trainset
                        </div>
                    </div>
                </a>
            </div>

        </div>

        {{-- Progress --}}
        <div class="card-dashboard">

            <h5>Progress Delivery</h5>

            @php
                $progress = $totalData > 0 ? round(($delivered / $totalData) * 100, 1) : 0;
            @endphp

            <div class="progress">

                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%">

                    {{ $progress }}%

                </div>

            </div>

        </div>

        {{-- Summary --}}
        <div class="row">

            <div class="col-md-6">

                <div class="card-dashboard">

                    <h5>Status Delivery</h5>

                    @php
                        $onTimePercent = $totalData > 0 ? round(($onTime / $totalData) * 100, 1) : 0;
                    @endphp

                    <div class="big-number">
                        {{ $onTimePercent }}%
                    </div>

                    <p>Pengiriman Tepat Waktu</p>

                </div>

            </div>

            <div class="col-md-6">

                <div class="card-dashboard">

                    <h5>Data Overdue</h5>

                    @php
                        $overduePercent = $totalData > 0 ? round(($overdue / $totalData) * 100, 1) : 0;
                    @endphp

                    <div class="big-number text-danger">
                        {{ $overduePercent }}%
                    </div>

                    <p>Pengiriman Terlambat</p>

                </div>

            </div>

        </div>


        {{-- By Tipe Kereta --}}
        <div class="card-dashboard">

            <h5>🚆 Progress Delivery Per Proyek</h5>

            @foreach ($tipeKeretaProgress as $namaProyek => $items)
                <details class="mb-3">

                    <summary
                        style="
                    cursor:pointer;
                    font-weight:bold;
                    padding:10px;
                    background:#f8f9fa;
                    border-radius:8px;
                ">

                        📦 {{ $namaProyek }}

                    </summary>

                    <div class="mt-3">

                        @foreach ($items as $row)
                            <div class="mb-3">

                                <div class="d-flex justify-content-between">

                                    <strong>
                                        {{ $row->tipe_kereta }}
                                    </strong>

                                    <span>
                                        {{ $row->delivered }}
                                        /
                                        {{ $row->total_unit }}
                                    </span>

                                </div>

                                <div class="progress mt-1">

                                    <div class="progress-bar bg-success" style="width:{{ $row->progress }}%">

                                        {{ $row->progress }}%

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>

                </details>
            @endforeach

        </div>

        {{-- Ringkasan --}}
        {{-- <div class="card-dashboard">

            <h5>Ringkasan Dashboard</h5>

            <table class="table table-bordered">

                <tr>
                    <th width="250">Total Proyek</th>
                    <td>{{ $projectCount }}</td>
                </tr>

                <tr>
                    <th>Total Pengiriman</th>
                    <td>{{ $totalData }}</td>
                </tr>

                <tr>
                    <th>On Time</th>
                    <td>{{ $onTime }}</td>
                </tr>

                <tr>
                    <th>Overdue</th>
                    <td>{{ $overdue }}</td>
                </tr>

                <tr>
                    <th>Vendor Aktif</th>
                    <td>{{ $vendorCount }}</td>
                </tr>

                <tr>
                    <th>Trainset Aktif</th>
                    <td>{{ $trainsetCount }}</td>
                </tr>

            </table>

        </div> --}}

    </div>

@endsection
