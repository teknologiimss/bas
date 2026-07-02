@extends('layouts.main')

@section('title', 'List Data Alat Angkat-Angkut')
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
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            animation: fadeDown .5s ease;
        }

        /* =========================
           CARD
        ========================= */
        .modern-card {
            border: 1px solid #e6eef8;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(11, 31, 58, .08);
            animation: fadeUp .5s ease;
        }

        .modern-card .card-header {
            background: #163a6b;
            color: white;
            font-weight: 600;
            border: none;
        }

        /* =========================
           BUTTON
        ========================= */
        .btn-back {
            border-radius: 10px;
            font-weight: 600;
            padding: 8px 15px;
            transition: .3s;
            background: white;
            color: #163a6b;
            border: 1px solid #dbe6f5;
        }

        .btn-back:hover {
            background: #eef4ff;
            color: #0b1f3a;
            transform: translateY(-2px);
        }

        /* =========================
           TABLE
        ========================= */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #163a6b;
            color: white;
            border-bottom: none;
            font-size: 13px;
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
            transform: scale(1.002);
        }

        /* =========================
           BADGE
        ========================= */
        .badge-imss {
            background: #1e3a8a;
            color: white;
            padding: 7px 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        .badge-non {
            background: #60a5fa;
            color: white;
            padding: 7px 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        /* =========================
           ICON
        ========================= */
        .unit-icon {
            color: #1e3a8a;
            margin-right: 5px;
        }

        .fa-map-marker-alt {
            color: #2563eb !important;
        }

        /* =========================
           ANIMATION
        ========================= */
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

        /* =========================
           MOBILE
        ========================= */
        @media(max-width:768px) {

            .page-header h3 {
                font-size: 20px;
            }

            .table thead {
                display: none;
            }

            .table,
            .table tbody,
            .table tr,
            .table td {
                display: block;
                width: 100%;
            }

            .table tr {
                background: white;
                margin-bottom: 12px;
                border-radius: 12px;
                padding: 10px;
                box-shadow: 0 2px 10px rgba(11, 31, 58, .08);
                border: 1px solid #e6eef8;
            }

            .table td {
                text-align: right;
                padding: 8px;
                border: none;
                position: relative;
            }

            .table td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                font-weight: bold;
                text-align: left;
                color: #163a6b;
            }
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
    </style>

    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="page-header">

            <h3 class="mb-1">
                <i class="fas fa-truck"></i>

                @if ($filter)
                    Data {{ $filter }}
                @else
                    Semua Data Unit
                @endif

            </h3>

            <small>
                Monitoring Data Alat Angkat & Angkut
            </small>

        </div>

        <div class="card modern-card">

            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">

                <span>

                    <i class="fas fa-list"></i>
                    Daftar Unit

                </span>

                <a href="{{ route('alat.dashboard') }}" class="btn btn-light btn-back">

                    <i class="fas fa-arrow-left"></i>
                    Dashboard

                </a>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover">

                        <thead>

                            <tr>
                                <th width="60">No</th>
                                <th>Unit</th>
                                <th>No Lambung</th>
                                <th>Lokasi</th>
                                <th>Aset</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($data as $item)
                                <tr>

                                    <td data-label="No">

                                        {{ $data->firstItem() + $loop->index }}

                                    </td>

                                    <td data-label="Unit">

                                        <i class="fas fa-truck unit-icon"></i>

                                        {{ $item->unit }}

                                    </td>

                                    <td data-label="No Lambung">

                                        {{ $item->no_lambung }}

                                    </td>

                                    <td data-label="Lokasi">

                                        <i class="fas fa-map-marker-alt text-danger"></i>

                                        {{ $item->lokasi }}

                                    </td>

                                    <td data-label="Aset">

                                        @if (str_contains(strtoupper($item->aset), 'IMSS'))
                                            <span class="badge-imss">

                                                {{ $item->aset }}

                                            </span>
                                        @else
                                            <span class="badge-non">

                                                {{ $item->aset }}

                                            </span>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5" class="text-center py-4">

                                        <i class="fas fa-folder-open fa-2x text-muted mb-2"></i>

                                        <br>

                                        Tidak ada data

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <div class="mt-3">

            {{ $data->links('pagination::bootstrap-4') }}

        </div>

    </div>

@endsection
