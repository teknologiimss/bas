@extends('layouts.main')

@section('title', 'List SPR')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        body {
            background: #f4f6f9;
        }

        /* HEADER */
        .page-header {
            background: linear-gradient(135deg, #dc3545, #ff4d4d);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 8px 20px rgba(220, 53, 69, .25);
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

        /* CARD */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, .08);
            animation: fadeUp .6s ease;
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
            background: #dc3545;
            color: white;
            font-weight: bold;
            border-radius: 15px 15px 0 0 !important;
        }

        /* TABLE */
        .table thead {
            background: #f8f9fa;
        }

        .table tbody tr {
            transition: .2s;
        }

        .table tbody tr:hover {
            background: #fff5f5;
            transform: scale(1.01);
        }

        /* BUTTON */
        .btn-back {
            border-radius: 10px;
            font-weight: 600;
        }

        /* BADGE */
        .badge {
            font-size: 12px;
            padding: 6px 10px;
            border-radius: 8px;
        }

        /* MOBILE CARD MODE */
        @media (max-width: 768px) {

            table {
                display: none;
            }

            .mobile-card {
                display: block;
            }

            .spr-card {
                background: white;
                border-radius: 12px;
                padding: 12px;
                margin-bottom: 10px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, .06);
                border-left: 4px solid #dc3545;
                animation: fadeUp .4s ease;
            }

            .spr-title {
                font-weight: bold;
                font-size: 14px;
            }

            .spr-text {
                font-size: 13px;
                color: #555;
            }

        }

        @media (min-width: 769px) {
            .mobile-card {
                display: none;
            }
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

                <a href="{{ route('lp3m.dashboard') }}" class="btn btn-secondary btn-back mb-3">
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
