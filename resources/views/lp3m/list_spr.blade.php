@extends('layouts.main')

@section('title', 'List SPR')
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
            box-shadow: 0 8px 20px rgba(11, 31, 58, .20);
            animation: fadeDown .6s ease;
        }

        @keyframes fadeDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* =========================
           CARD
        ========================= */
        .card {
            border: 1px solid #e6eef8;
            border-radius: 15px;
            box-shadow: 0 3px 15px rgba(11, 31, 58, .08);
            animation: fadeUp .6s ease;
            overflow: hidden;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-header {
            background: #163a6b;
            color: white;
            font-weight: bold;
            border-radius: 15px 15px 0 0 !important;
            border: none;
        }

        /* =========================
           TABLE
        ========================= */
        .table thead,
        .table thead th {
            background: #163a6b;
            color: white;
            border-color: #163a6b;
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
            transform: scale(1.005);
        }

        /* =========================
           BUTTON
        ========================= */
        .btn-back {
            background: #163a6b;
            border: none;
            color: white;
            border-radius: 10px;
            font-weight: 600;
            transition: .3s;
        }

        .btn-back:hover {
            background: #0b1f3a;
            color: white;
            transform: translateY(-2px);
        }

        /* =========================
           BADGE
        ========================= */
        .badge {
            font-size: 12px;
            padding: 6px 10px;
            border-radius: 8px;
        }

        .bg-warning {
            background: #2563eb !important;
            color: white !important;
        }

        .bg-success {
            background: #1e3a8a !important;
            color: white !important;
        }

        /* =========================
           MOBILE CARD
        ========================= */
        @media (max-width:768px) {

            table {
                display: none;
            }

            .mobile-card {
                display: block;
            }

            .spr-card {
                background: white;
                border-radius: 12px;
                padding: 15px;
                margin-bottom: 12px;
                box-shadow: 0 3px 12px rgba(11, 31, 58, .08);
                border-left: 5px solid #163a6b;
                animation: fadeUp .4s ease;
            }

            .spr-title {
                font-weight: bold;
                font-size: 15px;
                color: #163a6b;
            }

            .spr-text {
                font-size: 13px;
                color: #6b7280;
            }

        }

        @media (min-width:769px) {
            .mobile-card {
                display: none;
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
            <h4 class="mb-1">📄 List Data SPR</h4>
            <small>Monitoring data berdasarkan status SPR</small>
        </div>

        {{-- CARD --}}
        <div class="card">

            <div class="card-header">
                @if ($status)
                    Data SPR {{ $status }}
                @else
                    Semua Data SPR
                @endif
            </div>

            <div class="card-body">

                <a href="{{ route('lp3m.index') }}" class="btn btn-secondary btn-back mb-3">
                    ⬅ Kembali Dashboard
                </a>

                {{-- TABLE DESKTOP --}}
                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No SPR</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->spr_no }}</td>
                                    <td>{{ $item->deskripsi }}</td>
                                    <td>
                                        @if ($item->status == 'OPEN')
                                            <span class="badge bg-warning text-dark">OPEN</span>
                                        @else
                                            <span class="badge bg-success">CLOSED</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- MOBILE CARD --}}
                <div class="mobile-card">

                    @forelse($data as $item)
                        <div class="spr-card">

                            <div class="spr-title">
                                SPR: {{ $item->spr_no }}
                            </div>

                            <div class="spr-text">
                                {{ $item->deskripsi }}
                            </div>

                            <div class="mt-2">
                                @if ($item->status == 'OPEN')
                                    <span class="badge bg-warning text-dark">OPEN</span>
                                @else
                                    <span class="badge bg-success">CLOSED</span>
                                @endif
                            </div>

                            <div class="spr-text mt-1">
                                📅 {{ $item->created_at->format('d-m-Y') }}
                            </div>

                        </div>
                    @empty
                        <div class="text-center text-muted">
                            Tidak ada data
                        </div>
                    @endforelse

                </div>

                {{-- PAGINATION --}}
                <div class="mt-3">
                    {{ $data->withQueryString()->links() }}
                </div>

            </div>

        </div>

    </div>

@endsection
