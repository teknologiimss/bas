@extends('layouts.main')

@section('title', 'Monitoring Pekerjaan Pengiriman MRO')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        body {
            background: #f4f6fb;
        }

        /* HEADER BUTTON AREA */
        .d-flex.justify-content-between.mb-3 {
            animation: fadeDown 0.5s ease;
        }

        /* CARD LIST */
        .card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(10, 25, 60, 0.10);
            animation: fadeUp 0.6s ease;
        }

        /* ITEM ROW */
        .border {
            border: none !important;
            border-left: 5px solid #0b1f3a !important;
            border-radius: 14px !important;
            transition: all 0.25s ease;
            background: #ffffff;
        }

        .border:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(11, 31, 58, 0.18);
        }

        /* TITLE */
        h5 {
            color: #0b1f3a;
            font-weight: 700;
        }

        /* BUTTON STYLE */
        .btn-success {
            background: linear-gradient(135deg, #0b1f3a, #142d55) !important;
            border: none !important;
            border-radius: 10px !important;
            transition: 0.2s;
        }

        .btn-success:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(11, 31, 58, 0.35);
        }

        /* DASHBOARD BUTTON */
        .btn-dashboard {
            background: linear-gradient(135deg, #1e3c72, #2a5298) !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 10px !important;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-dashboard:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(30, 60, 114, 0.35);
            color: #ffffff !important;
        }

        /* LIGHT BUTTON */
        .btn-light {
            border-radius: 10px;
            border: 1px solid #0b1f3a;
            color: #0b1f3a;
            transition: 0.2s;
            background: #fff;
        }

        .btn-light:hover {
            background: #0b1f3a;
            color: white;
            transform: translateY(-2px);
        }

        /* DELETE BUTTON */
        .btn-danger {
            border-radius: 10px;
            transition: 0.2s;
            background: #c0392b;
            border: none;
        }

        .btn-danger:hover {
            transform: scale(1.05);
            background: #a93226;
        }

        /* MODAL */
        .modal-content {
            border-radius: 18px;
            overflow: hidden;
            animation: pop 0.3s ease;
        }

        .modal-header {
            background: linear-gradient(135deg, #0b1f3a, #142d55);
            color: white;
        }

        /* INPUT */
        .form-control {
            border-radius: 10px;
            border: 1px solid #d0d7e2;
        }

        .form-control:focus {
            border-color: #0b1f3a;
            box-shadow: 0 0 0 0.2rem rgba(11, 31, 58, 0.15);
        }

        /* PAGINATION */
        .pagination {
            justify-content: center;
        }

        .page-item.active .page-link {
            background: #0b1f3a;
            border-color: #0b1f3a;
        }

        /* SEARCH MODERN */
        .search-box {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 15px;
        }

        .search-wrapper {
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(10, 25, 60, 0.10);
            border: 1px solid rgba(11, 31, 58, 0.2);
            max-width: 450px;
            width: 100%;
            transition: 0.3s;
        }

        .search-wrapper:focus-within {
            box-shadow: 0 10px 25px rgba(11, 31, 58, 0.25);
            transform: translateY(-2px);
        }

        .search-icon {
            padding: 10px 12px;
            color: #0b1f3a;
        }

        .search-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 12px;
        }

        .search-btn {
            background: linear-gradient(135deg, #0b1f3a, #142d55);
            color: #fff;
            border: none;
            padding: 12px 18px;
            cursor: pointer;
        }

        .search-btn:hover {
            transform: scale(1.05);
        }

        /* DASHBOARD STYLES INSIDE MODAL */
        .dashboard-header-modal {
            background: linear-gradient(135deg, #0b1f3a, #163a6b);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 8px 20px rgba(11, 31, 58, .18);
        }

        .dashboard-header-modal h4 {
            margin: 0;
            font-weight: bold;
        }

        .dashboard-header-modal p {
            margin: 5px 0 0;
            opacity: .9;
        }

        .stat-card-modal {
            background: white;
            border: 1px solid #e6eef8;
            border-radius: 15px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 3px 15px rgba(11, 31, 58, .08);
            transition: .3s;
            height: 100%;
            display: block;
            text-decoration: none !important;
            cursor: pointer;
        }

        .stat-card-modal:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(11, 31, 58, .15);
        }

        .stat-value-modal {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #163a6b;
        }

        .stat-title-modal {
            color: #6b7280;
            font-size: 13px;
        }

        .text-blue-custom {
            color: #2563eb !important;
        }

        .card-dash {
            border: 1px solid #e6eef8;
            border-radius: 15px;
            box-shadow: 0 3px 15px rgba(11, 31, 58, .08);
            overflow: hidden;
        }

        .card-dash-header {
            background: #163a6b;
            color: white;
            font-weight: bold;
            border: none;
            padding: 12px 20px;
        }

        .scroll-table-modal {
            max-height: 380px;
            overflow-y: auto;
        }

        .scroll-table-modal::-webkit-scrollbar {
            width: 8px;
        }

        .scroll-table-modal::-webkit-scrollbar-thumb {
            background: #163a6b;
            border-radius: 10px;
        }

        .table-dash thead th {
            background: #163a6b !important;
            color: white !important;
            border-color: #163a6b !important;
        }

        .table-dash td,
        .table-dash th {
            vertical-align: middle;
            font-size: 13px;
        }

        .table-dash tbody tr:hover {
            background: #eef4ff;
        }

        /* ANIMATION */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
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
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        button,
        a {
            transition: all 0.2s ease;
        }

        button:active,
        a:active {
            transform: scale(0.95);
        }

        /* RESPONSIVE MOBILE */
        @media (max-width: 768px) {

            .d-flex.justify-content-between.mb-3 {
                flex-direction: column;
                align-items: stretch !important;
            }

            .header-buttons {
                flex-direction: column;
                width: 100%;
            }

            .header-buttons .btn {
                width: 100%;
                margin: 5px 0 !important;
                height: 42px;
                font-size: 14px;
            }

            .search-box {
                justify-content: center;
            }

            .search-wrapper {
                max-width: 100%;
            }

            .search-input {
                font-size: 14px;
                padding: 10px;
            }

            .search-btn {
                padding: 10px 14px;
                font-size: 14px;
            }

            .border.p-3 {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 12px;
            }

            .border h5 {
                font-size: 16px;
                margin-bottom: 0;
            }

            .border .btn,
            .border form {
                width: 100%;
            }

            .border .btn {
                width: 100%;
                height: 40px;
                font-size: 13px;
                border-radius: 8px !important;
                margin-bottom: 6px;
            }

            .border>div:last-child {
                width: 100%;
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .btn-danger,
            .btn-success,
            .btn-light {
                padding: 8px 10px !important;
            }

            .modal-dialog {
                margin: 15px;
            }

            .modal-content {
                border-radius: 14px;
            }

            .pagination {
                flex-wrap: wrap;
                gap: 5px;
            }

            .page-link {
                font-size: 13px;
                padding: 6px 10px;
            }
        }

        .action-buttons {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .action-buttons form {
            margin: 0;
        }

        .btn-folder {
            min-width: 110px;
            height: 42px;
            display: flex !important;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 10px;
        }
    </style>

    <!-- AREA TOMBOL ATAS -->
    <div class="d-flex justify-content-between mb-3">
        <div class="d-flex gap-2 header-buttons">
            <button class="btn btn-success" data-toggle="modal" data-target="#modalCreate" style="margin: 10px 5px 10px 10px;">
                + Buat Data Baru
            </button>

            <!-- TOMBOL LIHAT DASHBOARD LENGKAP -->
            <button type="button" class="btn btn-dashboard" data-toggle="modal" data-target="#modalDashboard"
                style="margin: 10px 10px 10px 5px;">
                <i class="fas fa-chart-pie"></i> Lihat Dashboard
            </button>
        </div>
    </div>

    <!-- MODERN SEARCH -->
    <div class="search-box">
        <form method="GET" action="">
            <div class="search-wrapper">
                <span class="search-icon">🔍</span>
                <input type="text" name="search" class="search-input" autocomplete="off" placeholder="Cari rewinding..."
                    value="{{ request('search') }}">
                <button class="search-btn">Cari</button>
            </div>
        </form>
    </div>

    <!-- LIST PROYEK -->
    <div class="card p-3">
        <h5 class="mb-3">Daftar Rewinding MRO</h5>

        @foreach ($data as $folder)
            <div class="d-flex justify-content-between align-items-center border p-3 mb-2 rounded">

                <div>
                    <h5>
                        {{ $folder->nama_folder }}
                    </h5>
                </div>

                <div class="action-buttons">

                    <a href="{{ route('rewinding.monitor', $folder->id) }}" class="btn btn-info btn-folder">
                        <i class="fas fa-chart-bar"></i>
                        Monitor
                    </a>

                    <button type="button" class="btn btn-warning btn-folder" data-toggle="modal"
                        data-target="#editFolder{{ $folder->id }}">
                        <i class="fas fa-edit"></i>
                        Edit
                    </button>

                    <form action="{{ route('rewinding.folder.delete', $folder->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus folder ini?')">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger btn-folder">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>

                    </form>

                </div>

            </div>
        @endforeach

        {{-- Modal Edit --}}
        @foreach ($data as $folder)
            <div class="modal fade" id="editFolder{{ $folder->id }}">
                <div class="modal-dialog">
                    <form action="{{ route('rewinding.folder.update', $folder->id) }}" method="POST" class="modal-content">

                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="text-white m-0">Edit Folder</h5>
                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            <label>Nama Folder</label>
                            <input type="text" name="nama_folder" class="form-control" value="{{ $folder->nama_folder }}"
                                required>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success">
                                Simpan
                            </button>

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Batal
                            </button>
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
            <form class="modal-content" action="{{ route('rewinding.folder.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="text-white m-0">Buat Proyek Baru</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Nama Proyek *</label>
                    <input type="text" name="nama_folder" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL DASHBOARD LENGKAP -->
    @php
        $dashTotal = \App\Models\Rewinding::count();
        $dashOpen = \App\Models\Rewinding::where('status', 'Open')->count();
        $dashClosed = \App\Models\Rewinding::where('status', 'Closed')->count();
        $dashProgress = $dashTotal > 0 ? round(($dashClosed / $dashTotal) * 100, 2) : 0;
        $dashOpenData = \App\Models\Rewinding::where('status', 'Open')->orderBy('tanggal_sjn_keluar')->get();
    @endphp

    <div class="modal fade" id="modalDashboard" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-white m-0"><i class="fas fa-chart-line mr-2"></i> Dashboard Monitoring Rewinding</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4" style="background: #f4f7fb;">

                    {{-- HEADER DASHBOARD --}}
                    <div class="dashboard-header-modal">
                        <h4>📊 Dashboard Monitoring Rewinding</h4>
                        <p>Monitoring Data Rewinding</p>
                    </div>

                    {{-- KPI CARDS WITH LINK INTEGRATION --}}
                    <div class="row">

                        {{-- Total --}}
                        <div class="col-md-3 col-6 mb-3">
                            <a href="{{ route('rewinding.list', ['status' => 'all']) }}" class="stat-card-modal">
                                <i class="fas fa-sync-alt fa-2x text-blue-custom mb-2"></i>
                                <div class="stat-value-modal text-blue-custom">{{ $dashTotal }}</div>
                                <div class="stat-title-modal">Total Rewinding</div>
                            </a>
                        </div>

                        {{-- Open --}}
                        <div class="col-md-3 col-6 mb-3">
                            <a href="{{ route('rewinding.list', ['status' => 'Open']) }}" class="stat-card-modal">
                                <i class="fas fa-folder-open fa-2x text-blue-custom mb-2"></i>
                                <div class="stat-value-modal text-blue-custom">{{ $dashOpen }}</div>
                                <div class="stat-title-modal">Open</div>
                            </a>
                        </div>

                        {{-- Closed --}}
                        <div class="col-md-3 col-6 mb-3">
                            <a href="{{ route('rewinding.list', ['status' => 'Closed']) }}" class="stat-card-modal">
                                <i class="fas fa-check-circle fa-2x text-blue-custom mb-2"></i>
                                <div class="stat-value-modal text-blue-custom">{{ $dashClosed }}</div>
                                <div class="stat-title-modal">Closed</div>
                            </a>
                        </div>

                        {{-- Progress --}}
                        <div class="col-md-3 col-6 mb-3">
                            <div class="stat-card-modal" style="cursor: default;">
                                <i class="fas fa-chart-pie fa-2x text-blue-custom mb-2"></i>
                                <div class="stat-value-modal text-blue-custom">{{ $dashProgress }}%</div>
                                <div class="stat-title-modal">Completion</div>
                            </div>
                        </div>

                    </div>

                    {{-- CHART + TABLE OPEN --}}
                    <div class="row mt-2">

                        {{-- CHART DOUGHNUT --}}
                        <div class="col-md-4 mb-3">
                            <div class="card-dash bg-white">
                                <div class="card-dash-header">
                                    Status Rewinding
                                </div>
                                <div class="card-body text-center">
                                    <div style="max-width:240px; margin:auto;">
                                        <canvas id="modalStatusChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- TABLE OPEN --}}
                        <div class="col-md-8 mb-3">
                            <div class="card-dash bg-white">
                                <div class="card-dash-header d-flex justify-content-between align-items-center">
                                    <span>Data Rewinding Open</span>
                                    <span class="badge badge-light">
                                        {{ $dashOpenData->count() }} Data
                                    </span>
                                </div>
                                <div class="card-body p-0">
                                    <div class="scroll-table-modal">
                                        <table class="table table-bordered table-hover mb-0 table-dash">
                                            <thead>
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
                                                @forelse($dashOpenData as $item)
                                                    @php
                                                        $durasi = 0;
                                                        if ($item->tanggal_sjn_keluar) {
                                                            $tglKeluar = \Carbon\Carbon::parse(
                                                                $item->tanggal_sjn_keluar,
                                                            );
                                                            if ($item->tanggal_sjn_masuk) {
                                                                $tglMasuk = \Carbon\Carbon::parse(
                                                                    $item->tanggal_sjn_masuk,
                                                                );
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
                                                                <span class="badge badge-success">Closed</span>
                                                            @else
                                                                <span class="badge badge-warning">Open</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($item->status == 'Closed')
                                                                <span class="badge badge-success">{{ $durasi }}
                                                                    Hari</span>
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
                                                            Tidak ada data open
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- CHART SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const statusCtx = document.getElementById('modalStatusChart');
            if (statusCtx) {
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Open', 'Closed'],
                        datasets: [{
                            data: [
                                {{ $dashOpen }},
                                {{ $dashClosed }}
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
            }
        });
    </script>

@endsection
