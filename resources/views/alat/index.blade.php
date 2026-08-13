@extends('layouts.main')

@section('title', 'Monitoring Alat Angkat Angkut MRO')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        body {
            background: #f4f7fb;
            font-family: 'Segoe UI', sans-serif;
        }

        /* HEADER BUTTON AREA */
        .d-flex.justify-content-between.mb-3 {
            animation: fadeDown .5s ease;
        }

        /* CARD */
        .card {
            border: none;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 10px 25px rgba(13, 42, 84, .08);
            animation: fadeUp .5s ease;
        }

        .card-header-navy {
            background: #163a6b;
            color: white;
            font-weight: bold;
            border-top-left-radius: 18px;
            border-top-right-radius: 18px;
            padding: 15px 20px;
        }

        /* ITEM ROW */
        .border-custom {
            border: none !important;
            border-left: 5px solid #0d3b66 !important;
            border-radius: 14px !important;
            background: #fff;
            transition: .3s;
            box-shadow: 0 4px 12px rgba(13, 42, 84, .05);
        }

        .border-custom:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 22px rgba(13, 42, 84, .15);
        }

        /* TITLE */
        h5 {
            color: #0d3b66;
            font-weight: 700;
        }

        /* PRIMARY BUTTON */
        .btn-success {
            background: linear-gradient(135deg, #0d3b66, #1d4f91) !important;
            border: none !important;
            color: #fff !important;
            border-radius: 10px !important;
            transition: .25s;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #0a2f55, #2d5ea6) !important;
            transform: translateY(-2px);
            box-shadow: 0 10px 18px rgba(13, 59, 102, .25);
        }

        /* DASHBOARD BUTTON */
        .btn-info-dashboard {
            background: linear-gradient(135deg, #17a2b8, #117a8b) !important;
            border: none !important;
            color: #fff !important;
            border-radius: 10px !important;
            transition: .25s;
        }

        .btn-info-dashboard:hover {
            background: linear-gradient(135deg, #138496, #0b515d) !important;
            transform: translateY(-2px);
            box-shadow: 0 10px 18px rgba(23, 162, 184, .25);
        }

        /* MONITOR BUTTON */
        .btn-light {
            background: #fff;
            color: #0d3b66;
            border: 1px solid #0d3b66;
            border-radius: 10px;
            transition: .25s;
        }

        .btn-light:hover {
            background: #0d3b66;
            color: #fff;
            border-color: #0d3b66;
            transform: translateY(-2px);
        }

        /* DELETE BUTTON */
        .btn-danger {
            background: linear-gradient(135deg, #d63031, #b71c1c);
            border: none;
            border-radius: 10px;
            transition: .25s;
        }

        .btn-danger:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(214, 48, 49, .25);
        }

        /* STAT CARDS IN DASHBOARD */
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

        /* MODAL */
        .modal-content {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            animation: pop .3s ease;
        }

        .modal-header {
            background: linear-gradient(135deg, #0d3b66, #1d4f91);
            color: white;
            border: none;
        }

        /* INPUT */
        .form-control {
            border-radius: 10px;
            border: 1px solid #d6dee8;
            transition: .25s;
        }

        .form-control:focus {
            border-color: #0d3b66;
            box-shadow: 0 0 0 .2rem rgba(13, 59, 102, .15);
        }

        /* TABLE */
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

        /* PAGINATION */
        .pagination {
            justify-content: center;
        }

        .page-link {
            color: #0d3b66;
            border-radius: 8px;
            margin: 0 2px;
        }

        .page-item.active .page-link {
            background: #0d3b66;
            border-color: #0d3b66;
            color: #fff;
        }

        /* SEARCH */
        .search-box {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 18px;
        }

        .search-wrapper {
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 460px;
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #d8e1eb;
            box-shadow: 0 8px 18px rgba(13, 42, 84, .08);
            transition: .3s;
        }

        .search-wrapper:focus-within {
            border-color: #0d3b66;
            box-shadow: 0 10px 20px rgba(13, 59, 102, .18);
        }

        .search-icon {
            padding: 12px;
            color: #0d3b66;
            font-size: 16px;
        }

        .search-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 12px;
            background: transparent;
        }

        .search-btn {
            background: linear-gradient(135deg, #0d3b66, #1d4f91);
            color: white;
            border: none;
            padding: 12px 18px;
            transition: .3s;
        }

        .search-btn:hover {
            background: linear-gradient(135deg, #0a2f55, #2d5ea6);
        }

        button,
        a {
            transition: .25s;
        }

        button:active,
        a:active {
            transform: scale(.97);
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pop {
            from {
                transform: scale(.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* RESPONSIVE MOBILE */
        @media (max-width:768px) {
            .card {
                padding: 15px !important;
            }

            .d-flex.justify-content-between.mb-3 {
                flex-direction: column;
                gap: 10px;
            }

            .d-flex.justify-content-between.mb-3 .btn {
                width: 100%;
                margin: 0 !important;
                height: 42px;
                font-size: 14px;
            }

            .search-box {
                justify-content: center;
            }

            .search-wrapper {
                width: 100%;
                max-width: 100%;
            }

            .search-input {
                font-size: 13px;
            }

            .search-btn {
                font-size: 13px;
                padding: 10px 15px;
            }

            .border-custom {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 14px;
                padding: 15px !important;
            }

            .border-custom h5 {
                font-size: 16px;
                margin-bottom: 0;
                word-break: break-word;
            }

            .border-custom>div:last-child {
                width: 100%;
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
            }

            .border-custom .btn,
            .border-custom form {
                width: 100%;
            }

            .border-custom .btn {
                height: 38px;
                font-size: 12px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .modal-dialog {
                margin: 12px;
            }

            .modal-content {
                border-radius: 15px;
            }

            .modal-footer {
                flex-direction: column;
                gap: 8px;
            }

            .modal-footer .btn {
                width: 100%;
            }

            .pagination {
                flex-wrap: wrap;
            }

            .page-link {
                font-size: 12px;
                padding: 6px 10px;
            }

            .stat-value {
                font-size: 24px;
            }
        }
    </style>

    <!-- ACTION BUTTONS -->
    <div class="d-flex justify-content-between mb-3">
        <div>
            <button class="btn btn-success mr-2" data-toggle="modal" data-target="#modalCreate">
                + Tambah Data
            </button>
            <button class="btn btn-info-dashboard" data-toggle="modal" data-target="#modalDashboard">
                📊 Lihat Dashboard
            </button>
        </div>
    </div>

    <!-- MODERN SEARCH -->
    <div class="search-box">
        <form method="GET" action="">
            <div class="search-wrapper">
                <span class="search-icon">🔍</span>
                <input type="text" name="search" class="search-input" autocomplete="off" placeholder="Cari Tahun..."
                    value="{{ request('search') }}">
                <button class="search-btn">Cari</button>
            </div>
        </form>
    </div>

    <!-- LIST PROYEK -->
    <div class="card p-3">
        <h5 class="mb-3">Daftar Data Alat Angkat - Angkut MRO</h5>

        @foreach ($data as $p)
            <div class="d-flex justify-content-between align-items-center border-custom p-3 mb-2">
                <div>
                    <h5 class="mb-1">{{ $p->nama_proyek }}</h5>
                </div>

                <div>
                    <a href="{{ route('alat.monitor', $p->id) }}" class="btn btn-light">📊 Monitor</a>

                    <button class="btn btn-success" data-toggle="modal" data-target="#modalEdit{{ $p->id }}">
                        ✏️ Edit
                    </button>

                    <form action="{{ route('alat.delete', $p->id) }}" method="POST" class="d-inline">
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
                    <form class="modal-content" action="{{ route('alat.update', $p->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="text-white mb-0">Edit Proyek</h5>
                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <label>Nama Proyek *</label>
                            <input type="text" name="nama_proyek" value="{{ $p->nama_proyek }}" class="form-control"
                                required>
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
            <form class="modal-content" action="{{ route('alat.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="text-white mb-0">Buat Proyek Baru</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
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

    <!-- MODAL DASHBOARD FULL-SCREEN -->
    <div class="modal fade" id="modalDashboard" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content" style="background: #f4f7fb;">
                <div class="modal-header">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-truck mr-2"></i> Dashboard Monitoring Alat Angkat-Angkut
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- STAT CARDS -->
                    <div class="row mb-4">
                        <div class="col-md-3 col-6 mb-3">
                            <a href="{{ route('alat.list') }}" style="text-decoration:none;color:inherit">
                                <div class="stat-card">
                                    <i class="fas fa-truck fa-2x text-danger mb-2"></i>
                                    <div class="stat-value text-danger">{{ $totalUnit }}</div>
                                    <div class="stat-title">Total Unit</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <a href="{{ route('alat.list', ['aset' => 'IMSS']) }}"
                                style="text-decoration:none;color:inherit">
                                <div class="stat-card">
                                    <i class="fas fa-industry fa-2x text-success mb-2"></i>
                                    <div class="stat-value text-success">{{ $imss }}</div>
                                    <div class="stat-title">IMSS</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <a href="{{ route('alat.list', ['aset' => 'NON']) }}"
                                style="text-decoration:none;color:inherit">
                                <div class="stat-card">
                                    <i class="fas fa-warehouse fa-2x text-warning mb-2"></i>
                                    <div class="stat-value text-warning">{{ $nonImss }}</div>
                                    <div class="stat-title">Non IMSS</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <a href="{{ route('alat.lokasi.list') }}" style="text-decoration:none;color:inherit">
                                <div class="stat-card">
                                    <i class="fas fa-map-marker-alt fa-2x text-info mb-2"></i>
                                    <div class="stat-value text-info">{{ $totalLokasi }}</div>
                                    <div class="stat-title">Total Lokasi</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- CHARTS & SUMMARY TABLE -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-header-navy">Jumlah Aset</div>
                                <div class="card-body d-flex align-items-center justify-content-center">
                                    <div style="width: 100%; max-width: 280px;">
                                        <canvas id="statusChartModal"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <div class="card h-100">
                                <div class="card-header-navy">Ringkasan Unit</div>
                                <div class="card-body p-0">
                                    <div style="max-height: 380px; overflow-y: auto;">
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
                                                        <td><strong>{{ $unit }}</strong></td>
                                                        <td><span class="badge badge-success">{{ $item['total'] }}</span>
                                                        </td>
                                                        <td><span class="badge badge-danger">{{ $item['imss'] }}</span>
                                                        </td>
                                                        <td><span
                                                                class="badge badge-warning">{{ $item['non_imss'] }}</span>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('statusChartModal').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['IMSS', 'Non IMSS'],
                    datasets: [{
                        data: [
                            {{ $statusChart['imss'] }},
                            {{ $statusChart['non'] }}
                        ],
                        backgroundColor: ['#dc3545', '#ffd43b']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true
                }
            });
        });
    </script>

@endsection
