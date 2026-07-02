@extends('layouts.main')

@section('title', 'Data Rewinding')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')

    <style>
        body {
            background: #f4f7fb;
        }

        /* =========================
           CARD
        ========================= */
        .modern-card {
            border: 1px solid #e6eef8;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(11, 31, 58, .08);
            animation: fadeIn .4s ease-in-out;
            background: #fff;
        }

        /* =========================
           HEADER
        ========================= */
        .modern-header {
            background: linear-gradient(135deg, #0b1f3a, #163a6b);
            color: white;
            padding: 18px 20px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(11, 31, 58, .15);
        }

        /* =========================
           BUTTON BACK
        ========================= */
        .btn-back {
            background: white;
            color: #163a6b;
            border: 1px solid #dbe6f5;
            border-radius: 10px;
            padding: 6px 14px;
            font-weight: 600;
            transition: .3s;
            text-decoration: none;
        }

        .btn-back:hover {
            background: #eef4ff;
            color: #0b1f3a;
            transform: translateY(-2px);
        }

        /* =========================
           TABLE
        ========================= */
        .modern-table {
            width: 100%;
            margin: 0;
        }

        .modern-table thead,
        .modern-table thead th {
            background: #163a6b;
            color: white;
            border-color: #163a6b;
            white-space: nowrap;
        }

        .modern-table th,
        .modern-table td {
            padding: 12px;
            vertical-align: middle;
            white-space: nowrap;
        }

        .modern-table tbody tr {
            transition: .25s;
        }

        .modern-table tbody tr:hover {
            background: #eef4ff;
        }

        /* =========================
           BADGE
        ========================= */
        .badge-open {
            background: #2563eb;
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-closed {
            background: #1e3a8a;
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        /* =========================
           TABLE RESPONSIVE
        ========================= */
        .table-responsive-custom {
            overflow-x: auto;
        }

        .table-responsive-custom::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive-custom::-webkit-scrollbar-thumb {
            background: #163a6b;
            border-radius: 10px;
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
           ANIMATION
        ========================= */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
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

            .modern-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .btn-back {
                width: 100%;
                text-align: center;
            }

        }
    </style>

    <div class="container-fluid">

        <div class="modern-card">

            {{-- HEADER --}}
            <div class="modern-header">

                <div>
                    @if ($status)
                        Data Rewinding {{ $status }}
                    @else
                        Semua Data Rewinding
                    @endif
                </div>

                <a href="{{ route('rewinding.dashboard') }}" class="btn-back">
                    ⬅ Dashboard
                </a>

            </div>

            {{-- BODY --}}
            <div class="p-3">

                <div class="table-responsive-custom">

                    <table class="table modern-table table-bordered mb-0">

                        <thead>

                            <tr>
                                <th>No</th>
                                <th>Folder</th>
                                <th>No SJN</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>No SPPJP</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($data as $item)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $item->folder->nama_folder ?? '-' }}</td>

                                    <td><strong>{{ $item->no_sjn }}</strong></td>

                                    <td>{{ $item->deskripsi }}</td>

                                    <td>
                                        @if ($item->status == 'Open')
                                            <span class="badge-open">Open</span>
                                        @else
                                            <span class="badge-closed">Closed</span>
                                        @endif
                                    </td>

                                    <td>{{ $item->no_sppjp }}</td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Tidak ada data
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        {{-- PAGINATION --}}
        <div class="mt-3">
            {{ $data->withQueryString()->links() }}
        </div>

    </div>

@endsection
