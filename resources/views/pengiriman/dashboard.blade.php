@extends('layouts.main')

@section('title', 'Dashboard Pengiriman')

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

    <style>
        body {
            background: #f4f7fb;
        }

        /* =========================
           HEADER NAVY BLUE
        ========================= */
        .dashboard-header {
            background: linear-gradient(135deg, #0b1f3a, #163a6b);
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
            opacity: .85;
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
            box-shadow: 0 6px 20px rgba(11, 31, 58, .15);
        }

        .stat-value {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #163a6b;
        }

        .stat-title {
            color: #5b6b82;
            font-size: 13px;
        }

        /* =========================
           CARD DASHBOARD
        ========================= */
        .card-dashboard {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 3px 15px rgba(11, 31, 58, .08);
            border: 1px solid #e6eef8;
        }

        .card-dashboard h5 {
            color: #163a6b;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .big-number {
            font-size: 50px;
            font-weight: bold;
            color: #163a6b;
        }

        /* =========================
           PROGRESS BAR
        ========================= */
        .progress {
            height: 28px;
            border-radius: 30px;
        }

        .progress-bar {
            font-weight: bold;
        }

        .progress-delivery-bar {
            font-weight: bold;
            background: linear-gradient(90deg, #1e3a8a, #2563eb);
        }

        /* =========================
           DELIVERY PROJECT CARD
        ========================= */
        .delivery-project-card {
            background: #fff;
            border: 1px solid #dbe6f5;
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
            color: #1e3a8a;
        }

        .delivery-title h4 {
            margin: 0;
            color: #1e3a8a;
            font-weight: 700;
        }

        .delivery-title small {
            font-style: italic;
            font-weight: 600;
            color: #4b5d78;
        }

        /* =========================
           ACCORDION PROJECT
        ========================= */
        .project-accordion {
            border: 1px solid #dbe6f5;
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
            background: #eef4ff;
            border-bottom: 1px solid #dbe6f5;
            padding: 14px 18px;
            cursor: pointer;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .project-name {
            font-size: 16px;
            font-weight: 700;
            color: #1e3a8a;
        }

        .project-arrow {
            font-size: 14px;
            color: #5b6b82;
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

        /* =========================
           TRAIN ITEM
        ========================= */
        .train-item {
            margin-bottom: 18px;
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

        /* =========================
           PROGRESS BAR PROJECT
        ========================= */
        .progress-rail {
            height: 14px;
            background: #e8eef7;
            border-radius: 4px;
            overflow: hidden;
        }

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

        /* BLUE GRADIENT STATUS */
        .progress-green {
            background: linear-gradient(90deg, #1e3a8a, #2563eb);
        }

        .progress-yellow {
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
        }

        .progress-red {
            background: linear-gradient(90deg, #1e40af, #1d4ed8);
        }

        /* =========================
           TRAIN ANIMATION
        ========================= */
        .progress-wrapper {
            position: relative;
            margin-top: 20px;
        }

        .train-runner {
            position: absolute;
            top: -28px;
            left: 0;
            font-size: 28px;
            z-index: 10;
            transition: left 2s ease;
            animation: train-bounce .6s infinite alternate;
            color: #1e3a8a;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, .25));
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
                <a href="{{ route('pengiriman.dashboard.detail', 'pengiriman') }}" style="text-decoration:none;color:inherit">
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
                <a href="{{ route('pengiriman.dashboard.detail', 'vendor') }}" style="text-decoration:none;color:inherit">
                    <div class="stat-card">
                        <div class="stat-value">
                            {{ $vendorCount }}
                        </div>
                        <div class="stat-title">
                            Vendor Aktif
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
