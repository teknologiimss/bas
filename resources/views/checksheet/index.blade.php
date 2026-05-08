@extends('layouts.main')

@section('content')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    {{-- FONT AWESOME --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background: #eef2f7;
            font-family: 'Segoe UI', sans-serif;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
        }

        /* HEADER */

        .top-card {
            background: linear-gradient(135deg, #b30000, #ff2d2d);
            border-radius: 24px;
            padding: 24px;
            color: white;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .12);

            animation: fadeDown .5s ease;
        }

        .top-card p {
            margin-bottom: 0;
            opacity: .9;
        }

        /* BUTTON */

        .btn-modern {
            border: none;
            border-radius: 14px;
            padding: 11px 18px;
            font-weight: 600;
            transition: .25s;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, .12);
        }

        /* CARD TABLE */

        .table-card {
            background: white;
            border-radius: 24px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, .06);

            animation: fadeUp .5s ease;
        }

        /* TABLE */

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f8fafc;
            border: none;
            padding: 15px;
            font-size: 13px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .table tbody tr {
            border-bottom: 1px solid #edf0f5;
            transition: .2s;
        }

        .table tbody tr:hover {
            background: #fafafa;
            transform: scale(1.003);
        }

        .table tbody td {
            border: none;
            padding: 16px 12px;
            vertical-align: middle;
            font-size: 14px;
        }

        /* BADGE */

        .badge-modern {
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            background: #fff0f0;
            color: #b30000;
        }

        /* ACTION */

        .action-group {
            display: flex;
            gap: 8px;
            justify-content: center;
            flex-wrap: wrap;
            align-items: center;
        }

        .btn-action {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .2s;
            color: white;
            font-size: 14px;
            text-decoration: none;
        }

        .btn-action:hover {
            transform: translateY(-3px) scale(1.05);
            color: white;
        }

        .btn-view {
            background: #0dcaf0;
        }

        .btn-edit {
            background: #0d6efd;
        }

        .btn-copy {
            background: #ffc107;
            color: black !important;
        }

        .btn-delete {
            background: #dc3545;
        }

        /* BUTTON MOBILE */

        .btn-mobile-modern {
            border-radius: 12px;
            padding: 8px 14px;
            font-size: 13px;
            font-weight: 600;
            border: none;

            display: flex;
            align-items: center;
            gap: 5px;

            transition: .2s;

            background: #198754;
            color: white;
            text-decoration: none;
        }

        .btn-mobile-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(25, 135, 84, .25);
            color: white;
        }

        /* EMPTY */

        .empty-box {
            text-align: center;
            padding: 50px 20px;
            color: #888;
        }

        .empty-box i {
            font-size: 55px;
            margin-bottom: 15px;
            color: #ccc;
        }

        /* ANIMATION */

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

        /* MOBILE */

        @media(max-width:768px) {

            .table-responsive {
                overflow-x: auto;
            }

            .page-title {
                font-size: 22px;
            }

            .top-card {
                padding: 18px;
            }

            .btn-modern {
                width: 100%;
            }

            .action-group {
                justify-content: start;
            }

        }
    </style>

    <div class="container py-4">

        {{-- HEADER --}}
        <div class="top-card d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>

                <div class="page-title">
                    📋 Data Checksheet
                </div>

                <p>
                    Monitoring & Management Checksheet Perawatan Unit
                </p>

            </div>

            <div>

                <a href="{{ route('checksheet.create') }}" class="btn btn-light btn-modern">

                    <i class="fa fa-plus me-1"></i>

                    Buat Checksheet

                </a>

            </div>

        </div>

        {{-- FILTER --}}
        <div class="table-card mb-3">

            <form method="GET">

                <div class="row g-3 align-items-end">

                    {{-- UNIT --}}
                    <div class="col-md-4">

                        <label class="form-label fw-bold">
                            Cari Unit
                        </label>

                        <input type="text" name="unit" value="{{ request('unit') }}" class="form-control"
                            placeholder="Masukkan unit" autocomplete="off">

                    </div>

                    {{-- NO LAMBUNG --}}
                    <div class="col-md-4">

                        <label class="form-label fw-bold">
                            Cari No Lambung
                        </label>

                        <input type="text" name="no_lambung" value="{{ request('no_lambung') }}" class="form-control"
                            placeholder="Masukkan no lambung" autocomplete="off">

                    </div>

                    {{-- BUTTON --}}
                    <div class="col-md-4 d-flex gap-2">

                        <button class="btn btn-danger btn-modern">

                            <i class="fa fa-search me-1"></i>

                            Cari

                        </button>

                        <a href="{{ route('checksheet.index') }}" class="btn btn-secondary btn-modern">

                            <i class="fa fa-rotate-left me-1"></i>

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

        {{-- TABLE --}}
        <div class="table-card">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Judul</th>

                            <th>Unit</th>

                            <th>No Lambung</th>

                            <th>Tanggal</th>

                            <th>Jenis</th>

                            <th class="text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($data as $i => $d)
                            <tr>

                                <td width="60">

                                    <strong>
                                        {{ $i + 1 }}
                                    </strong>

                                </td>

                                <td>

                                    <strong>
                                        {{ $d->judul }}
                                    </strong>

                                </td>

                                <td>

                                    {{ $d->unit }}

                                </td>

                                <td>

                                    <span class="badge-modern">

                                        {{ $d->no_lambung }}

                                    </span>

                                </td>

                                <td>

                                    {{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y') }}

                                </td>

                                <td>

                                    {{ $d->jenis_perawatan ?? '-' }}

                                </td>

                                <td>

                                    <div class="action-group">

                                        {{-- ISI CHECKSHEET --}}
                                        <a href="{{ route('checksheet.mobile', $d->id) }}" class="btn-mobile-modern">

                                            <i class="fa fa-circle-check"></i>

                                            Isi Checksheet

                                        </a>

                                        {{-- DETAIL --}}
                                        <a href="{{ route('checksheet.show', $d->id) }}" class="btn-action btn-view"
                                            title="Detail">

                                            <i class="fa fa-eye"></i>

                                        </a>

                                        {{-- EDIT --}}
                                        <a href="{{ route('checksheet.edit', $d->id) }}" class="btn-action btn-edit"
                                            title="Edit">

                                            <i class="fa fa-pen"></i>

                                        </a>

                                        {{-- DUPLICATE --}}
                                        <a href="{{ route('checksheet.duplicate', $d->id) }}" class="btn-action btn-copy"
                                            title="Duplicate">

                                            <i class="fa fa-copy"></i>

                                        </a>

                                        {{-- DELETE --}}
                                        <form action="{{ route('checksheet.destroy', $d->id) }}" method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" onclick="return confirm('Hapus checksheet ini?')"
                                                class="btn-action btn-delete" title="Delete">

                                                <i class="fa fa-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7">

                                    <div class="empty-box">

                                        <i class="fa fa-folder-open"></i>

                                        <h5>
                                            Tidak ada data checksheet
                                        </h5>

                                        <p>
                                            Silakan buat checksheet baru terlebih dahulu.
                                        </p>

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
@endsection
