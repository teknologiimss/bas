@extends('layouts.main')

@section('title', 'Data Rewinding')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')

    <style>
        body {
            background: #f4f6f9;
        }

        /* CARD UTAMA */
        .modern-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
            animation: fadeIn .4s ease-in-out;
        }

        /* HEADER GRADIENT MERAH */
        .modern-header {
            background: linear-gradient(135deg, #dc3545, #ff4d4d);
            color: white;
            padding: 18px 20px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* BUTTON BACK */
        .btn-back {
            background: white;
            color: #dc3545;
            border-radius: 10px;
            padding: 6px 12px;
            font-weight: 600;
            transition: .3s;
        }

        .btn-back:hover {
            background: #ffe5e5;
            transform: scale(1.05);
        }

        /* TABLE */
        .modern-table {
            width: 100%;
            margin: 0;
        }

        .modern-table thead {
            background: #dc3545;
            color: white;
        }

        .modern-table th,
        .modern-table td {
            padding: 12px;
            vertical-align: middle;
            white-space: nowrap;
        }

        .modern-table tbody tr {
            transition: .2s;
        }

        .modern-table tbody tr:hover {
            background: #fff1f1;
            transform: scale(1.01);
        }

        /* BADGE */
        .badge-open {
            background: #ffc107;
            color: #000;
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 12px;
        }

        .badge-closed {
            background: #28a745;
            color: #fff;
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 12px;
        }

        /* SCROLL MOBILE */
        .table-responsive-custom {
            overflow-x: auto;
        }

        /* ANIMASI */
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

        /* MOBILE */
        @media(max-width:768px) {
            .modern-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
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
