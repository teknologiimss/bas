@extends('layouts.main')

@section('title', 'Checksheet Harian Fasilitas')

@section('content')

    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background: #edf2f7;
            font-family: "Segoe UI", sans-serif;
        }

        /* ===============================
               HEADER
            =============================== */
        .page-header {
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            color: white;
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 12px 28px rgba(15, 23, 42, .25);
            animation: fadeDown .4s ease;
        }

        .page-header h3 {
            margin: 0;
            font-weight: 700;
        }

        .page-header small {
            opacity: .9;
            font-size: 13px;
        }

        /* ===============================
               CARD
            =============================== */

        .stat-card,
        .card-table {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .08);
            animation: fadeUp .4s ease;
        }

        .stat-card {
            transition: .3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 35px rgba(30, 58, 138, .18);
        }

        .card-table {
            border-radius: 20px;
        }

        /* ===============================
               ICON
            =============================== */

        .stat-icon {
            width: 62px;
            height: 62px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 22px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, .15);
        }

        .bg-danger {
            background: linear-gradient(135deg, #1e3a8a, #2563eb) !important;
        }

        .bg-success {
            background: linear-gradient(135deg, #0f766e, #14b8a6) !important;
        }

        .bg-primary {
            background: linear-gradient(135deg, #312e81, #4338ca) !important;
        }

        /* ===============================
               TABLE
            =============================== */

        .table-responsive {
            border-radius: 15px;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            color: white;
            border: none;
            vertical-align: middle;
            white-space: nowrap;
        }

        .table tbody td {
            vertical-align: middle;
            border-color: #e5e7eb;
        }

        .table-hover tbody tr:hover {
            background: #eff6ff;
        }

        /* ===============================
               BUTTON
            =============================== */

        .btn {
            border-radius: 10px;
            transition: .25s;
            font-weight: 500;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-light {
            background: white;
            color: #1e3a8a;
            border: none;
        }

        .btn-light:hover {
            background: #dbeafe;
            color: #1e3a8a;
        }

        .btn-success {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            border: none;
        }

        .btn-success:hover {
            box-shadow: 0 8px 20px rgba(37, 99, 235, .35);
        }

        .btn-info {
            background: linear-gradient(135deg, #0284c7, #0ea5e9);
            border: none;
        }

        .btn-info:hover {
            box-shadow: 0 8px 20px rgba(2, 132, 199, .35);
        }

        .btn-primary {
            background: linear-gradient(135deg, #4338ca, #6366f1);
            border: none;
        }

        .btn-primary:hover {
            box-shadow: 0 8px 20px rgba(67, 56, 202, .35);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            color: white;
            border: none;
        }

        .btn-warning:hover {
            box-shadow: 0 8px 20px rgba(245, 158, 11, .35);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            border: none;
        }

        .btn-danger:hover {
            box-shadow: 0 8px 20px rgba(220, 38, 38, .35);
        }

        .btn-dark {
            background: linear-gradient(135deg, #334155, #1e293b);
            border: none;
        }

        .btn-dark:hover {
            box-shadow: 0 8px 20px rgba(30, 41, 59, .35);
        }

        .btn-action {
            margin: 3px;
            border-radius: 8px;
        }

        /* ===============================
               SEARCH
            =============================== */

        .search-box {
            border-radius: 12px;
            border: 1px solid #dbe4f0;
            height: 42px;
        }

        .search-box:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .15);
        }

        .input-group .btn {
            border-radius: 0 12px 12px 0;
        }

        /* ===============================
               PAGINATION
            =============================== */

        .pagination {
            justify-content: center;
        }

        .page-item.active .page-link {
            background: #1e3a8a;
            border-color: #1e3a8a;
        }

        .page-link {
            color: #1e3a8a;
        }

        /* ===============================
               ANIMATION
            =============================== */

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

        /* ===============================
               RESPONSIVE
            =============================== */

        /* ===============================
       RESPONSIVE
    =============================== */

        @media (max-width: 768px) {

            .container-fluid {
                padding-left: 10px;
                padding-right: 10px;
            }

            /* Header */
            .page-header {
                padding: 18px;
                border-radius: 15px;
            }

            .page-header h3 {
                font-size: 20px;
            }

            .page-header small {
                font-size: 12px;
            }

            .page-header .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 12px;
            }

            .page-header .btn {
                width: 100%;
            }

            /* Statistik */
            .stat-card {
                margin-bottom: 15px;
            }

            .stat-icon {
                width: 48px;
                height: 48px;
                font-size: 18px;
            }

            .stat-card h2 {
                font-size: 24px;
            }

            .stat-card h5 {
                font-size: 15px;
            }

            /* Search */
            .input-group {
                display: flex;
                width: 100%;
            }

            .search-box {
                flex: 1;
                height: 40px;
            }

            .input-group .btn {
                white-space: nowrap;
            }

            /* Table */
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table {
                min-width: 900px;
            }

            .table thead th {
                white-space: nowrap;
                font-size: 13px;
            }

            .table tbody td {
                white-space: nowrap;
                font-size: 13px;
            }

            /* Tombol aksi */
            .btn-action {
                margin: 2px;
                padding: 5px 8px;
                font-size: 11px;
                width: auto;
            }

            .pagination {
                justify-content: center;
                flex-wrap: wrap;
            }

        }
    </style>

    <div class="container-fluid mt-3">

        {{-- HEADER --}}
        <div class="page-header">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <div>

                    <h3>
                        <i class="fas fa-clipboard-list"></i>
                        Checksheet Harian Fasilitas
                    </h3>

                    <small>
                        Monitoring Pemeriksaan Harian Fasilitas
                    </small>

                </div>

                <a href="{{ route('fasilitas-harian.create') }}" class="btn btn-light mt-2">

                    <i class="fa fa-plus"></i>
                    Buat Checksheet

                </a>

            </div>

        </div>

        {{-- STATISTIK --}}
        <div class="row mb-4">

            <div class="col-md-4 mb-3">

                <div class="card stat-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h5>Total Checksheet</h5>

                                <h2>

                                    {{ $data->total() }}

                                </h2>

                            </div>

                            <div class="stat-icon bg-danger">

                                <i class="fa fa-file-alt"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-4 mb-3">

                <div class="card stat-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h5>Bulan Aktif</h5>

                                <h2>

                                    {{ now()->format('F') }}

                                </h2>

                            </div>

                            <div class="stat-icon bg-success">

                                <i class="fa fa-calendar"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-4 mb-3">

                <div class="card stat-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h5>Tahun</h5>

                                <h2>

                                    {{ now()->year }}

                                </h2>

                            </div>

                            <div class="stat-icon bg-primary">

                                <i class="fa fa-clock"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="card card-table">

            <div class="card-header bg-white">

                <div class="row">

                    <div class="col-md-4">

                        <form method="GET">

                            <div class="input-group">

                                <input type="text" name="search" class="form-control search-box"
                                    placeholder="Cari checksheet..." value="{{ request('search') }}">

                                <div class="input-group-append">

                                    <button class="btn btn-danger">

                                        <i class="fa fa-search"></i>

                                        Cari

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover" id="tableData">

                        <thead>

                            <tr>

                                <th width="50">
                                    No
                                </th>

                                <th>
                                    Judul
                                </th>

                                <th>No Dokumen</th>

                                <th>No Fasilitas</th>

                                <th>Nama Alat</th>

                                <th>
                                    Lokasi
                                </th>

                                <th>
                                    Bulan
                                </th>

                                <th>
                                    Tahun
                                </th>

                                <th width="500">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($data as $row)
                                <tr>

                                    <td>
                                        {{ $data->firstItem() + $loop->index }}
                                    </td>

                                    <td>

                                        {{ $row->judul }}

                                    </td>

                                    <td>{{ $row->nomor_dokumen }}</td>

                                    <td>{{ $row->nomor_fasilitas }}</td>

                                    <td>{{ $row->nama_alat }}</td>

                                    <td>

                                        {{ $row->lokasi }}

                                    </td>

                                    <td>

                                        {{ $row->bulan }}

                                    </td>

                                    <td>

                                        {{ $row->tahun }}

                                    </td>

                                    <td>

                                        {{-- MOBILE --}}
                                        <a href="{{ route('fasilitas.mobile', $row->id) }}"
                                            class="btn btn-success btn-sm btn-action">

                                            <i class="fa fa-mobile"></i>

                                            Isi HP

                                        </a>

                                        {{-- MATRIX --}}
                                        <a href="{{ route('fasilitas-harian.show', $row->id) }}"
                                            class="btn btn-info btn-sm btn-action">

                                            <i class="fa fa-table"></i>

                                            Matrix

                                        </a>

                                        {{-- PDF --}}
                                        <a href="{{ route('fasilitas.print', $row->id) }}" target="_blank"
                                            class="btn btn-danger btn-sm btn-action">

                                            <i class="fa fa-file-pdf"></i>

                                            PDF

                                        </a>

                                        {{-- EDIT --}}
                                        <a href="{{ route('fasilitas-harian.edit', $row->id) }}"
                                            class="btn btn-warning btn-sm btn-action">

                                            <i class="fa fa-edit"></i>

                                            Edit

                                        </a>

                                        {{-- DUPLICATE --}}
                                        <a href="{{ route('fasilitas-harian.duplicate', $row->id) }}"
                                            class="btn btn-primary btn-sm btn-action">

                                            <i class="fa fa-copy"></i>
                                            Duplicate

                                        </a>

                                        {{-- DELETE --}}
                                        <form action="{{ route('fasilitas-harian.destroy', $row->id) }}" method="POST"
                                            class="d-inline">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-dark btn-sm btn-action btn-delete">

                                                <i class="fa fa-trash"></i>

                                                Hapus

                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6" class="text-center">

                                        Belum ada data

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-3">

                    {{ $data->appends(request()->query())->links('pagination::bootstrap-4') }}

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({

                icon: 'success',

                title: 'Berhasil',

                text: '{{ session('success') }}',

                timer: 2000,

                showConfirmButton: false

            });
        </script>
    @endif

    {{-- <script>
        document
            .getElementById('searchInput')
            .addEventListener('keyup', function() {

                let value =
                    this.value.toLowerCase();

                let rows =
                    document.querySelectorAll(
                        '#tableData tbody tr'
                    );

                rows.forEach(row => {

                    row.style.display =
                        row.innerText.toLowerCase()
                        .includes(value) ?
                        '' :
                        'none';

                });

            });

        document
            .querySelectorAll('.btn-delete')
            .forEach(btn => {

                btn.addEventListener(
                    'click',
                    function(e) {

                        e.preventDefault();

                        let form =
                            this.closest('form');

                        Swal.fire({

                            title: 'Hapus data?',

                            icon: 'warning',

                            showCancelButton: true,

                            confirmButtonColor: '#dc3545',

                            confirmButtonText: 'Ya Hapus'

                        }).then((r) => {

                            if (r.isConfirmed) {

                                form.submit();

                            }

                        });

                    });

            });
    </script> --}}

@endsection
