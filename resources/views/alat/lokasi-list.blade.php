@extends('layouts.main')

@section('title', 'Rincian Lokasi Unit')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        body {
            background: #f4f7fb;
        }

        /* =========================
           HEADER
        ========================= */
        .page-header {
            background: linear-gradient(135deg, #0b1f3a, #163a6b);
            color: white;
            padding: 25px;
            border-radius: 20px;
            margin-bottom: 20px;
            box-shadow: 0 8px 25px rgba(11, 31, 58, .25);
            animation: fadeInDown .5s ease;
        }

        /* =========================
           CARD
        ========================= */
        .modern-card {
            background: white;
            border: 1px solid #e6eef8;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(11, 31, 58, .08);
            overflow: hidden;
            animation: fadeInUp .6s ease;
        }

        .modern-card .card-header {
            background: #163a6b;
            color: white;
            font-weight: 600;
            border: none;
            padding: 15px 20px;
        }

        /* =========================
           SUMMARY CARD
        ========================= */
        .stat-box {
            background: white;
            border: 1px solid #e6eef8;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(11, 31, 58, .08);
            transition: .3s;
            height: 100%;
        }

        .stat-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(11, 31, 58, .15);
        }

        .stat-value {
            font-size: 28px;
            font-weight: bold;
            color: #163a6b;
        }

        .stat-title {
            color: #6b7280;
            font-size: 13px;
        }

        /* =========================
           ICON COLOR
        ========================= */
        .fa-truck,
        .fa-map-marked-alt,
        .fa-map-marker-alt,
        .text-danger,
        .text-success,
        .text-info {
            color: #2563eb !important;
        }

        /* =========================
           SEARCH
        ========================= */
        .search-box {
            border-radius: 12px;
            border: 1px solid #dbe6f5;
            padding: 10px 15px;
        }

        /* =========================
           TABLE
        ========================= */
        .table thead {
            background: #163a6b;
            color: white;
        }

        .table thead th {
            border: none;
            white-space: nowrap;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .table tbody tr {
            transition: .25s;
        }

        .table tbody tr:hover {
            background: #eef4ff;
            transform: translateX(4px);
        }

        /* =========================
           BADGE
        ========================= */
        .badge-aset {
            padding: 8px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-lokasi {
            padding: 8px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success {
            background: #1e3a8a;
        }

        .badge-warning {
            background: #60a5fa;
            color: white;
        }

        .badge-info {
            background: #2563eb;
            color: white;
        }

        /* =========================
           BUTTON
        ========================= */
        .btn-back {
            border-radius: 10px;
            padding: 10px 18px;
            background: #163a6b;
            border: none;
            color: white;
            transition: .3s;
        }

        .btn-back:hover {
            background: #0b1f3a;
            color: white;
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

        /* =========================
           MOBILE
        ========================= */
        @media(max-width:768px) {

            .page-header {
                text-align: center;
            }

            .page-header h3 {
                font-size: 22px;
            }

            .stat-value {
                font-size: 22px;
            }

            .table {
                font-size: 13px;
            }

            .btn-back {
                width: 100%;
                margin-bottom: 15px;
            }
        }

        /* =========================
           ANIMATION
        ========================= */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="page-header">

            <h3>
                <i class="fas fa-map-marker-alt"></i>
                Rincian Lokasi Unit
            </h3>

            <p class="mb-0">
                Monitoring Seluruh Unit Berdasarkan Lokasi
            </p>

        </div>

        {{-- SUMMARY --}}
        <div class="row mb-3">

            <div class="col-md-4 mb-3">

                <div class="stat-box">

                    <i class="fas fa-truck fa-2x text-danger mb-2"></i>

                    <div class="stat-value">
                        {{ $data->total() }}
                    </div>

                    <div class="stat-title">
                        Total Unit
                    </div>

                </div>

            </div>

            <div class="col-md-4 mb-3">

                <div class="stat-box">

                    <i class="fas fa-map-marked-alt fa-2x text-info mb-2"></i>

                    <div class="stat-value text-info">
                        {{ $data->pluck('lokasi')->unique()->count() }}
                    </div>

                    <div class="stat-title">
                        Total Lokasi
                    </div>

                </div>

            </div>

            <div class="col-md-4 mb-3">

                <div class="stat-box">

                    <i class="fas fa-industry fa-2x text-success mb-2"></i>

                    <div class="stat-value text-success">
                        {{ $data->where('aset', 'LIKE', '%IMSS%')->count() }}
                    </div>

                    <div class="stat-title">
                        Data IMSS
                    </div>

                </div>

            </div>

        </div>

        {{-- CARD --}}
        <div class="modern-card">

            <div class="card-header">

                <i class="fas fa-table"></i>
                Data Lokasi Unit

            </div>

            <div class="card-body">

                <div class="d-flex justify-content-between flex-wrap mb-3">

                    <a href="{{ route('alat.index') }}" class="btn btn-secondary btn-back">

                        <i class="fas fa-arrow-left"></i>
                        Kembali Dashboard

                    </a>

                </div>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover mb-0">

                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th>Lokasi</th>
                                <th>Unit</th>
                                <th>No Lambung</th>
                                <th>Aset</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($data as $item)
                                <tr>

                                    <td>
                                        {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                                    </td>

                                    <td>
                                        <span class="badge badge-info badge-lokasi">
                                            {{ $item->lokasi }}
                                        </span>
                                    </td>

                                    <td>
                                        <strong>{{ $item->unit }}</strong>
                                    </td>

                                    <td>
                                        {{ $item->no_lambung }}
                                    </td>

                                    <td>

                                        @if (str_contains(strtoupper($item->aset ?? ''), 'IMSS'))
                                            <span class="badge badge-success badge-aset">
                                                {{ $item->aset }}
                                            </span>
                                        @else
                                            <span class="badge badge-warning badge-aset">
                                                {{ $item->aset }}
                                            </span>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5" class="text-center py-4">
                                        Tidak ada data
                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="row mt-3 align-items-center">

                    <div class="col-md-6">

                        <small class="text-muted">

                            Menampilkan
                            {{ $data->firstItem() ?? 0 }}
                            -
                            {{ $data->lastItem() ?? 0 }}

                            dari

                            {{ $data->total() }}

                            data

                        </small>

                    </div>

                    <div class="col-md-6 d-flex justify-content-md-end justify-content-center mt-2 mt-md-0">

                        {{ $data->links('pagination::bootstrap-4') }}

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
