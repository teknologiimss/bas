@extends('layouts.main')

@section('title', 'Monitoring Rewinding')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')

    <style>
        body {
            background: #f7f8fc;
        }

        .card-rewinding {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(255, 0, 0, .08);
        }

        .header-red {
            background: linear-gradient(135deg, #dc3545, #ff4d4d);
            color: white;
            padding: 20px;
        }

        .header-red h3 {
            margin: 0;
            font-weight: 600;
        }

        .table thead {
            background: #dc3545;
            color: white;
        }

        .table td,
        .table th {
            vertical-align: middle !important;
        }

        .badge-open {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffe69c;
            padding: 3px 8px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            line-height: 1;
        }

        .badge-closed {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #d4edda;
            color: #155724;
            border: 1px solid #b8dfc2;
            padding: 3px 8px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            line-height: 1;
        }

        .animate-card {
            animation: slideUp .6s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .empty-state {
            padding: 60px 20px;
        }

        .empty-state i {
            color: #dc3545;
            opacity: .4;
        }

        .btn-group .btn {
            margin-right: 2px;
        }

        @media(max-width:768px) {

            .header-red {
                padding: 15px;
            }

            .header-red h3 {
                font-size: 18px;
            }

            .table-responsive {
                font-size: 12px;
            }

            .btn-group {
                display: flex;
                flex-direction: column;
                gap: 3px;
            }
        }



        .action-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }

        .action-group .btn {
            width: 38px;
            height: 38px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-group form {
            margin: 0;
        }


        .search-box .form-control {
            border-radius: 12px 0 0 12px;
        }

        .search-box .btn {
            border-radius: 0;
        }

        .search-box .btn:last-child {
            border-radius: 0 12px 12px 0;
        }
    </style>

    <div class="card card-rewinding animate-card">

        <div class="header-red">

            <div class="d-flex justify-content-between align-items-center">

                <h3>
                    <i class="fas fa-sync-alt"></i>
                    Monitoring Rewinding
                </h3>

                <a href="{{ route('rewinding.create') }}" class="btn btn-light">

                    <i class="fas fa-plus"></i>
                    Tambah

                </a>

            </div>

        </div>

        <div class="card-body">

            {{-- Search --}}
            <div class="row mb-3">

                <div class="col-md-6">

                    <form method="GET" action="{{ route('rewinding.index') }}" class="search-box">

                        <div class="input-group">

                            <input type="text" name="search" autocomplete="off" class="form-control"
                                placeholder="Cari No SJN / Deskripsi / No SPPJP..." value="{{ request('search') }}">

                            <div class="input-group-append">

                                <button class="btn btn-danger">

                                    <i class="fas fa-search"></i>

                                </button>

                                @if (request('search'))
                                    <a href="{{ route('rewinding.index') }}" class="btn btn-secondary">

                                        <i class="fas fa-sync"></i>

                                    </a>
                                @endif

                            </div>

                        </div>

                    </form>

                </div>

            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">

                    <button type="button" class="close" data-dismiss="alert">

                        <span>&times;</span>

                    </button>

                    {{ session('success') }}

                </div>
            @endif

            <div class="table-responsive">

                <table class="table table-hover table-bordered">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>No SJN</th>

                            <th>Tgl SJN Keluar</th>

                            <th>Lampiran Keluar</th>

                            <th>Tgl SJN Masuk</th>

                            <th>Lampiran Masuk</th>

                            <th>Deskripsi</th>

                            <th>Status</th>

                            <th>Keterangan</th>

                            <th>No SPPJP</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($data as $item)
                            <tr>

                                <td>
                                    {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                                </td>

                                <td>{{ $item->no_sjn }}</td>

                                <td>
                                    {{ $item->tanggal_sjn_keluar ? \Carbon\Carbon::parse($item->tanggal_sjn_keluar)->format('d-m-Y') : '-' }}
                                </td>

                                <td>

                                    @if ($item->lampiran_sjn_keluar)
                                        <a href="{{ asset($item->lampiran_sjn_keluar) }}" target="_blank"
                                            class="btn btn-success btn-sm">

                                            View

                                        </a>
                                    @else
                                        -
                                    @endif

                                </td>

                                <td>

                                    {{ $item->tanggal_sjn_masuk ? \Carbon\Carbon::parse($item->tanggal_sjn_masuk)->format('d-m-Y') : '-' }}

                                </td>

                                <td>

                                    @if ($item->lampiran_sjn_masuk)
                                        <a href="{{ asset($item->lampiran_sjn_masuk) }}" target="_blank"
                                            class="btn btn-primary btn-sm">

                                            View

                                        </a>
                                    @else
                                        -
                                    @endif

                                </td>

                                <td>{{ $item->deskripsi }}</td>

                                <td>

                                    @if ($item->status == 'Open')
                                        <span class="badge-open">
                                            OPEN
                                        </span>
                                    @else
                                        <span class="badge-closed">
                                            CLOSED
                                        </span>
                                    @endif

                                </td>

                                <td>{{ $item->keterangan }}</td>

                                <td>{{ $item->no_sppjp }}</td>

                                <td>

                                    <div class="action-group">

                                        <a href="{{ route('rewinding.detail', $item->id) }}" class="btn btn-info btn-sm"
                                            title="Detail">

                                            <i class="fas fa-list"></i>

                                        </a>

                                        <a href="{{ route('rewinding.edit', $item->id) }}" class="btn btn-warning btn-sm"
                                            title="Edit">

                                            <i class="fas fa-edit"></i>

                                        </a>

                                        <form action="{{ route('rewinding.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">

                                                <i class="fas fa-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="12">

                                    <div class="empty-state text-center">

                                        <i class="fas fa-folder-open fa-5x mb-3"></i>

                                        <h4 class="text-muted">
                                            Tidak Ada Data
                                        </h4>

                                        <p class="text-muted">
                                            Belum ada data Monitoring Rewinding yang tersimpan.
                                        </p>


                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            @if ($data->count())
                <div class="mt-3">
                    {{ $data->links() }}
                </div>
            @endif

        </div>

    </div>

@endsection
