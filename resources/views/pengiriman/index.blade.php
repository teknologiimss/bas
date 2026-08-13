@extends('layouts.main')

@section('title', 'Monitoring Pekerjaan Pengiriman MRO')

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

    <style>
        body {
            background: #f4f7fc;
        }

        :root {
            --navy: #0F172A;
            --navy-dark: #020617;
            --navy-light: #1E3A8A;
            --navy-soft: #EFF6FF;
            --border: #D6E4F5;
            --text: #334155;
        }

        /* ================= HEADER & ACTION BUTTONS ================= */
        .top-action-bar {
            animation: fadeDown .45s ease;
        }

        /* ================= DASHBOARD CONTAINER ================= */
        .dashboard-container {
            display: none; /* Hidden by default, toggled via JS */
            animation: fadeUp .5s ease;
            margin-bottom: 25px;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #0b1f3a, #163a6b);
            color: white;
            padding: 20px 25px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .dashboard-header h4 {
            margin: 0;
            font-weight: bold;
        }

        .dashboard-header p {
            margin: 0;
            opacity: .85;
            font-size: 14px;
        }

        /* ================= STAT CARD ================= */
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
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #163a6b;
        }

        .stat-title {
            color: #5b6b82;
            font-size: 13px;
        }

        .card-dashboard {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-top: 15px;
            box-shadow: 0 3px 15px rgba(11, 31, 58, .08);
            border: 1px solid #e6eef8;
        }

        .card-dashboard h5 {
            color: #163a6b;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .big-number {
            font-size: 42px;
            font-weight: bold;
            color: #163a6b;
        }

        /* ================= PROGRESS BAR ================= */
        .progress {
            height: 26px;
            border-radius: 30px;
        }

        .progress-bar {
            font-weight: bold;
        }

        .progress-delivery-bar {
            font-weight: bold;
            background: linear-gradient(90deg, #1e3a8a, #2563eb);
        }

        .progress-wrapper {
            position: relative;
            margin-top: 20px;
        }

        .train-runner {
            position: absolute;
            top: -28px;
            left: 0;
            font-size: 24px;
            z-index: 10;
            transition: left 2s ease;
            animation: train-bounce .6s infinite alternate;
            color: #1e3a8a;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, .25));
        }

        @keyframes train-bounce {
            from { transform: translateY(0px); }
            to { transform: translateY(-3px); }
        }

        /* ================= DELIVERY PROJECT CARD ================= */
        .delivery-project-card {
            background: #fff;
            border: 1px solid #dbe6f5;
            border-radius: 12px;
            overflow: hidden;
        }

        .delivery-title {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 15px;
        }

        .delivery-title-icon {
            font-size: 30px;
            color: #1e3a8a;
        }

        .delivery-title h5 {
            margin: 0;
            color: #1e3a8a;
            font-weight: 700;
        }

        .project-accordion {
            border: 1px solid #dbe6f5;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 12px;
            background: #fff;
        }

        .project-accordion summary { list-style: none; }
        .project-accordion summary::-webkit-details-marker { display: none; }

        .project-header {
            background: #eef4ff;
            border-bottom: 1px solid #dbe6f5;
            padding: 12px 18px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .project-name {
            font-size: 15px;
            font-weight: 700;
            color: #1e3a8a;
        }

        .project-content { padding: 15px 18px; }

        .train-item { margin-bottom: 15px; }

        .train-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        .progress-rail {
            height: 14px;
            background: #e8eef7;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-custom {
            height: 100%;
            color: white;
            font-size: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            background-size: 20px 20px;
            background-image: linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
            animation: progress-stripes 1s linear infinite;
        }

        @keyframes progress-stripes {
            from { background-position: 0 0; }
            to { background-position: 20px 0; }
        }

        .progress-green { background: linear-gradient(90deg, #1e3a8a, #2563eb); }
        .progress-yellow { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
        .progress-red { background: linear-gradient(90deg, #1e40af, #1d4ed8); }

        /* ================= INDEX CARD & LIST ================= */
        .card {
            border: none;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .08);
            animation: fadeUp .5s ease;
        }

        h5 { color: var(--navy); font-weight: 700; }

        .border-item {
            border: none !important;
            border-left: 5px solid var(--navy-light) !important;
            border-radius: 14px !important;
            background: white;
            transition: .25s;
        }

        .border-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(15, 23, 42, .12);
            background: #fbfdff;
        }

        .btn-success {
            background: linear-gradient(135deg, var(--navy-light), var(--navy)) !important;
            border: none !important;
            border-radius: 10px !important;
            color: #fff !important;
            font-weight: 600;
            box-shadow: 0 6px 18px rgba(30, 58, 138, .25);
            transition: .25s;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(30, 58, 138, .35);
        }

        .btn-info-custom {
            background: #2563eb;
            color: white;
            border-radius: 10px;
            font-weight: 600;
            border: none;
            padding: 8px 16px;
            transition: .25s;
        }

        .btn-info-custom:hover {
            background: #1d4ed8;
            color: white;
            transform: translateY(-2px);
        }

        .btn-light {
            background: white;
            color: var(--navy);
            border: 1px solid var(--navy-light);
            border-radius: 10px;
            font-weight: 600;
            transition: .25s;
        }

        .btn-light:hover {
            background: var(--navy-light);
            color: white;
            border-color: var(--navy-light);
        }

        .btn-danger {
            border-radius: 10px;
            transition: .25s;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
        }

        .search-box {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 18px;
        }

        .search-wrapper {
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 450px;
            background: white;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid var(--border);
            box-shadow: 0 8px 20px rgba(15, 23, 42, .08);
            transition: .25s;
        }

        .search-wrapper:focus-within {
            border-color: var(--navy-light);
            box-shadow: 0 10px 25px rgba(30, 58, 138, .18);
        }

        .search-icon {
            padding: 12px;
            color: var(--navy-light);
            font-size: 18px;
        }

        .search-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 12px;
            background: white;
        }

        .search-btn {
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px 20px;
            background: linear-gradient(135deg, var(--navy-light), var(--navy));
            transition: .25s;
        }

        .modal-content {
            border: none;
            border-radius: 18px;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--navy-light), var(--navy));
            color: white;
        }

        .modal-header h5 { color: white; margin: 0; }

        .form-control {
            border-radius: 10px;
            border: 1px solid var(--border);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media(max-width:768px) {
            .top-action-bar {
                flex-direction: column;
                gap: 10px;
            }
            .top-action-bar .btn {
                width: 100%;
            }
            .search-box { justify-content: center; }
            .search-wrapper { max-width: 100%; }
            .border-item {
                flex-direction: column !important;
                align-items: flex-start !important;
            }
            .border-item > div:last-child {
                width: 100%;
                display: flex;
                flex-direction: column;
                gap: 8px;
                margin-top: 10px;
            }
            .border-item .btn { width: 100%; }
        }
    </style>

    <!-- TOP BAR ACTIONS -->
    <div class="d-flex justify-content-between align-items-center mb-3 top-action-bar">
        <button class="btn btn-success" data-toggle="modal" data-target="#modalCreate">
            + Buat Pekerjaan Baru
        </button>

        <button class="btn btn-info-custom" id="btnToggleDashboard">
            📊 <span id="toggleText">Lihat Dashboard</span>
        </button>
    </div>

    <!-- DASHBOARD CONTAINER (COLLAPSIBLE) -->
    <div class="dashboard-container" id="dashboardSection">
        <div class="dashboard-header">
            <h4>📊 Dashboard Monitoring Pengiriman</h4>
            <p>Ringkasan statistik seluruh proyek pengiriman MRO</p>
        </div>

        {{-- KPI STATS --}}
        <div class="row">
            <div class="col-md-4 col-sm-6 mb-3">
                <a href="{{ route('pengiriman.dashboard.detail', 'pengiriman') }}" style="text-decoration:none;color:inherit">
                    <div class="stat-card">
                        <div class="stat-value text-primary">{{ $totalData ?? 0 }}</div>
                        <div class="stat-title">Total Pengiriman</div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <a href="{{ route('pengiriman.dashboard.detail', 'ontime') }}" style="text-decoration:none;color:inherit">
                    <div class="stat-card">
                        <div class="stat-value text-success">{{ $onTime ?? 0 }}</div>
                        <div class="stat-title">On Time</div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <a href="{{ route('pengiriman.dashboard.detail', 'overdue') }}" style="text-decoration:none;color:inherit">
                    <div class="stat-card">
                        <div class="stat-value text-danger">{{ $overdue ?? 0 }}</div>
                        <div class="stat-title">Overdue</div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <a href="{{ route('pengiriman.dashboard.detail', 'delivery') }}" style="text-decoration:none;color:inherit">
                    <div class="stat-card">
                        <div class="stat-value text-info">{{ $delivered ?? 0 }}</div>
                        <div class="stat-title">Sudah Delivery</div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <a href="{{ route('pengiriman.dashboard.detail', 'unloading') }}" style="text-decoration:none;color:inherit">
                    <div class="stat-card">
                        <div class="stat-value text-warning">{{ $unloading ?? 0 }}</div>
                        <div class="stat-title">Sudah Unloading</div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <a href="{{ route('pengiriman.dashboard.detail', 'vendor') }}" style="text-decoration:none;color:inherit">
                    <div class="stat-card">
                        <div class="stat-value">{{ $vendorCount ?? 0 }}</div>
                        <div class="stat-title">Vendor Aktif</div>
                    </div>
                </a>
            </div>
        </div>

        {{-- PROGRESS DELIVERY --}}
        <div class="card-dashboard">
            <h5>Progress Delivery</h5>
            @php
                $tot = $totalData ?? 0;
                $del = $delivered ?? 0;
                $progress = $tot > 0 ? round(($del / $tot) * 100, 1) : 0;
            @endphp
            <div class="progress-wrapper">
                <div class="train-runner">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="progress">
                    <div class="progress-bar progress-delivery-bar" role="progressbar"
                        data-width="{{ $progress }}" style="width:0%;">
                        {{ $progress }}%
                    </div>
                </div>
            </div>
        </div>

        {{-- PERCENTAGE SUMMARY --}}
        <div class="row">
            <div class="col-md-6 mb-2">
                <div class="card-dashboard text-center">
                    <h5>Status Delivery Tepat Waktu</h5>
                    @php
                        $onTimePercent = $tot > 0 ? round((($onTime ?? 0) / $tot) * 100, 1) : 0;
                    @endphp
                    <div class="big-number">{{ $onTimePercent }}%</div>
                    <p class="text-muted mb-0">Pengiriman Tepat Waktu</p>
                </div>
            </div>
            <div class="col-md-6 mb-2">
                <div class="card-dashboard text-center">
                    <h5>Data Terlambat (Overdue)</h5>
                    @php
                        $overduePercent = $tot > 0 ? round((($overdue ?? 0) / $tot) * 100, 1) : 0;
                    @endphp
                    <div class="big-number text-danger">{{ $overduePercent }}%</div>
                    <p class="text-muted mb-0">Pengiriman Terlambat</p>
                </div>
            </div>
        </div>

        {{-- PROGRESS PER PROYEK --}}
        @if(isset($tipeKeretaProgress) && count($tipeKeretaProgress) > 0)
        <div class="delivery-project-card p-3 mt-3">
            <div class="delivery-title">
                <div class="delivery-title-icon">🚆</div>
                <div>
                    <h5>Progress Delivery Per Proyek</h5>
                    <small class="text-muted">*Mengambil data tipe kereta</small>
                </div>
            </div>

            @foreach ($tipeKeretaProgress as $namaProyek => $items)
                <details class="project-accordion">
                    <summary class="project-header">
                        <div class="project-name">🚆 {{ $namaProyek }}</div>
                        <div class="project-arrow"><i class="fas fa-chevron-right"></i></div>
                    </summary>
                    <div class="project-content">
                        @foreach ($items as $row)
                            @php
                                $pVal = $row->progress;
                                $colorClass = ($pVal >= 90) ? 'progress-green' : (($pVal >= 60) ? 'progress-yellow' : 'progress-red');
                            @endphp
                            <div class="train-item">
                                <div class="train-header">
                                    <div class="train-name">{{ $row->tipe_kereta }}</div>
                                    <div class="train-total">{{ $row->delivered }} / {{ $row->total_unit }}</div>
                                </div>
                                <div class="progress-rail">
                                    <div class="progress-custom {{ $colorClass }}" data-width="{{ $pVal }}" style="width:0%;">
                                        {{ $pVal }}%
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </details>
            @endforeach
        </div>
        @endif
    </div>

    <!-- MODERN SEARCH -->
    <div class="search-box">
        <form method="GET" action="">
            <div class="search-wrapper">
                <span class="search-icon">🔍</span>
                <input type="text" name="search" class="search-input" autocomplete="off"
                    placeholder="Cari nama proyek..." value="{{ request('search') }}">
                <button class="search-btn">Cari</button>
            </div>
        </form>
    </div>

    <!-- LIST PROYEK -->
    <div class="card p-3">
        <h5 class="mb-3">Daftar Pekerjaan MRO</h5>

        @foreach ($data as $p)
            <div class="d-flex justify-content-between align-items-center border-item p-3 mb-2 rounded">
                <div>
                    <h5 class="mb-1">{{ $p->nama_proyek }}</h5>
                </div>

                <div>
                    <a href="{{ route('pengiriman.monitor', $p->id) }}" class="btn btn-light">📊 Monitor</a>

                    <button class="btn btn-success" data-toggle="modal" data-target="#modalEdit{{ $p->id }}">
                        ✏️ Edit
                    </button>

                    <form action="{{ route('pengiriman.delete', $p->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Hapus proyek ini?')">
                            🗑️ Delete
                        </button>
                    </form>
                </div>
            </div>

            <!-- Modal Edit -->
            <div class="modal fade" id="modalEdit{{ $p->id }}">
                <div class="modal-dialog">
                    <form class="modal-content" action="{{ route('pengiriman.update', $p->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5>Edit Proyek</h5>
                        </div>
                        <div class="modal-body">
                            <label>Nama Proyek *</label>
                            <input type="text" name="nama_proyek" value="{{ $p->nama_proyek }}" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success">Submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach

        <div class="mt-3">
            {{ $data->appends(['search' => request('search')])->links() }}
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="modalCreate">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('pengiriman.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5>Buat Proyek Baru</h5>
                </div>
                <div class="modal-body">
                    <label>Nama Proyek *</label>
                    <input type="text" name="nama_proyek" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT TOGGLE & ANIMASI PROGRESS BAR -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnToggle = document.getElementById('btnToggleDashboard');
            const dashboardSection = document.getElementById('dashboardSection');
            const toggleText = document.getElementById('toggleText');

            let isDashboardVisible = false;

            // Function animation progress bar
            function animateBars() {
                const deliveryBar = document.querySelector('.progress-delivery-bar');
                const train = document.querySelector('.train-runner');

                if (deliveryBar) {
                    const width = parseFloat(deliveryBar.dataset.width);
                    setTimeout(() => {
                        deliveryBar.style.transition = 'width 1.5s ease';
                        deliveryBar.style.width = width + '%';
                        if (train) {
                            train.style.left = `calc(${width}% - 20px)`;
                        }
                    }, 200);
                }

                document.querySelectorAll('.progress-custom').forEach(bar => {
                    const width = bar.dataset.width;
                    setTimeout(() => {
                        bar.style.transition = 'width 1.2s ease';
                        bar.style.width = width + '%';
                    }, 300);
                });
            }

            // Event Click Toggle Dashboard
            btnToggle.addEventListener('click', function() {
                isDashboardVisible = !isDashboardVisible;

                if (isDashboardVisible) {
                    dashboardSection.style.display = 'block';
                    toggleText.innerText = 'Sembunyikan Dashboard';
                    animateBars();
                } else {
                    dashboardSection.style.display = 'none';
                    toggleText.innerText = 'Lihat Dashboard';
                }
            });
        });
    </script>
@endsection