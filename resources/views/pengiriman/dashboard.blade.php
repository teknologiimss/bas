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


        /* =====================================
                                                           PROGRESS DELIVERY PER PROYEK
                                                        ===================================== */

        .delivery-project-card {
            background: #fff;
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            overflow: hidden;
        }

        .delivery-title {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 15px;
        }

        .delivery-title-icon {
            font-size: 34px;
            color: #c62828;
            line-height: 1;
        }

        .delivery-title h4 {
            margin: 0;
            color: #c62828;
            font-weight: 700;
        }

        .delivery-title small {
            font-style: italic;
            font-weight: 600;
            color: #222;
        }

        .project-accordion {
            border: 1px solid #dddddd;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 12px;
            background: #fff;
        }

        .project-accordion summary {
            list-style: none;
        }

        .project-accordion summary::-webkit-details-marker {
            display: none;
        }

        .project-header {
            background: #f3f3f3;
            border-bottom: 1px solid #dddddd;
            padding: 14px 18px;
            cursor: pointer;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .project-name {
            font-size: 16px;
            font-weight: 700;
            color: #222;
        }

        .project-arrow {
            font-size: 14px;
            color: #666;
        }

        .project-arrow i {
            transition: all .2s ease;
            transform: rotate(0deg);
        }

        .project-accordion[open] .project-arrow i {
            transform: rotate(90deg);
        }

        .project-content {
            padding: 15px 18px;
        }

        .train-item {
            margin-bottom: 18px;
        }

        .train-item:last-child {
            margin-bottom: 0;
        }

        .train-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }

        .train-name {
            font-size: 15px;
            color: #222;
        }

        .train-total {
            font-size: 15px;
            font-weight: 600;
            color: #222;
        }

        .progress-rail {
            height: 14px;
            background: #e8e8e8;
            border-radius: 4px;
            overflow: hidden;
        }

        /* Progress Bar per Proyek Gerak */
        .progress-custom {
            height: 100%;
            color: white;
            font-size: 11px;
            font-weight: 700;

            display: flex;
            align-items: center;
            justify-content: center;

            background-size: 20px 20px;
            background-image:
                linear-gradient(45deg,
                    rgba(255, 255, 255, .15) 25%,
                    transparent 25%,
                    transparent 50%,
                    rgba(255, 255, 255, .15) 50%,
                    rgba(255, 255, 255, .15) 75%,
                    transparent 75%,
                    transparent);

            animation: progress-stripes 1s linear infinite;
        }

        @keyframes progress-stripes {
            from {
                background-position: 0 0;
            }

            to {
                background-position: 20px 0;
            }
        }

        /* End Progress Bar per Proyek Gerak */

        .progress-green {
            background-color: #28a745;
        }

        .progress-yellow {
            background-color: #f0ad00;
        }

        .progress-red {
            background-color: #dc3545;
        }


        /* Progress Delivery Animasi */

        .progress-wrapper {
            position: relative;
            margin-top: 20px;
        }

        .progress-delivery {
            height: 32px;
            border-radius: 30px;
            overflow: hidden;
        }

        .progress-delivery-bar {

            font-weight: bold;

            background-size: 25px 25px;

            background-image:
                linear-gradient(45deg,
                    rgba(255, 255, 255, .15) 25%,
                    transparent 25%,
                    transparent 50%,
                    rgba(255, 255, 255, .15) 50%,
                    rgba(255, 255, 255, .15) 75%,
                    transparent 75%,
                    transparent);

            animation: delivery-stripes 1s linear infinite;
        }

        @keyframes delivery-stripes {

            from {
                background-position: 0 0;
            }

            to {
                background-position: 25px 0;
            }

        }

        /* Kereta */

        .train-runner {

            position: absolute;

            top: -28px;

            left: 0;

            font-size: 28px;

            z-index: 10;

            transition: left 2s ease;

            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, .3));

            animation: train-bounce .6s infinite alternate;
        }

        @keyframes train-bounce {

            from {
                transform: translateY(0px);
            }

            to {
                transform: translateY(-3px);
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

            <div class="progress-wrapper">

                <div class="train-runner">
                    <i class="fas fa-truck"></i>
                </div>

                <div class="progress progress-delivery">

                    <div class="progress-bar bg-success progress-delivery-bar" role="progressbar"
                        data-width="{{ $progress }}" style="width:0%;">

                        {{ $progress }}%

                    </div>

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
        {{-- =========================================
     PROGRESS DELIVERY PER PROYEK
        ========================================= --}}

        <div class="delivery-project-card p-3 mt-4">

            <div class="delivery-title">

                <div class="delivery-title-icon">
                    🚆
                </div>

                <div>
                    <h4>Progress Delivery Per Proyek</h4>
                    <small>*Mengambil data tipe kereta</small>
                </div>

            </div>

            @foreach ($tipeKeretaProgress as $namaProyek => $items)
                <details class="project-accordion">

                    <summary class="project-header">

                        <div class="project-name">
                            🚆 {{ $namaProyek }}
                        </div>

                        <div class="project-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>

                    </summary>

                    <div class="project-content">

                        @foreach ($items as $row)
                            @php
                                $progress = $row->progress;

                                if ($progress >= 90) {
                                    $colorClass = 'progress-green';
                                } elseif ($progress >= 60) {
                                    $colorClass = 'progress-yellow';
                                } else {
                                    $colorClass = 'progress-red';
                                }
                            @endphp

                            <div class="train-item">

                                <div class="train-header">

                                    <div class="train-name">
                                        {{ $row->tipe_kereta }}
                                    </div>

                                    <div class="train-total">
                                        {{ $row->delivered }} / {{ $row->total_unit }}
                                    </div>

                                </div>

                                <div class="progress-rail">

                                    <div class="progress-custom {{ $colorClass }}" data-width="{{ $progress }}"
                                        style="width:0%;">

                                        {{ $progress }}%

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>

                </details>
            @endforeach

        </div>

    </div>


    {{-- Progress Bar gerak gerak --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const deliveryBar =
                document.querySelector('.progress-delivery-bar');

            const train =
                document.querySelector('.train-runner');

            if (deliveryBar) {

                const width =
                    parseFloat(deliveryBar.dataset.width);

                setTimeout(() => {

                    deliveryBar.style.transition =
                        'width 2s ease';

                    deliveryBar.style.width =
                        width + '%';

                    train.style.left =
                        `calc(${width}% - 20px)`;

                }, 300);
            }

            document.querySelectorAll('.progress-custom')
                .forEach(bar => {

                    const width =
                        bar.dataset.width;

                    setTimeout(() => {

                        bar.style.transition =
                            'width 1.5s ease';

                        bar.style.width =
                            width + '%';

                    }, 500);

                });

        });
    </script>

@endsection
