@extends('layouts.main')

@section('title', 'Lembar Pekerjaan Perbaikan Perawatan Fasilitas')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')
    <style>
        :root {
            --navy: #0f172a;
            --navy2: #1e3a8a;
            --navy3: #2563eb;
            --bg: #edf4fb;
            --border: #d8e3f0;
            --shadow: 0 8px 25px rgba(15, 23, 42, .08);
        }

        body {
            background: var(--bg);
            font-family: 'Segoe UI', sans-serif;
        }

        .header-title {
            font-size: 18px;
            font-weight: 700;
            line-height: 1.4;
            color: #fff;
        }

        /* ===========================
           CARD
        ============================*/

        .card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .card-header {
            background: linear-gradient(135deg, var(--navy), var(--navy2)) !important;
            border: none;
            padding: 18px 22px;
        }

        .card-body {
            background: #fff;
        }

        /* ===========================
           BUTTON
        ============================*/

        .btn {
            border-radius: 10px;
            font-weight: 600;
            transition: .25s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: var(--navy2);
            border-color: var(--navy2);
        }

        .btn-primary:hover {
            background: var(--navy);
            border-color: var(--navy);
        }

        .btn-danger {
            background: #dc2626;
            border-color: #dc2626;
        }

        .btn-secondary {
            background: #334155;
            border-color: #334155;
        }

        .btn-info {
            background: #0284c7;
            border-color: #0284c7;
            color: #fff;
        }

        .btn-warning {
            background: #f59e0b;
            border-color: #f59e0b;
            color: #fff;
        }

        .btn-dark {
            background: var(--navy);
            border-color: var(--navy);
        }

        /* ===========================
           ACTION BUTTON
        ============================*/

        .btn-action {

            width: 100px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 5px;

            font-size: 12px;
            font-weight: 600;

            border-radius: 10px;

            transition: .25s;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(15, 23, 42, .18);
        }

        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        /* ===========================
           FORM
        ============================*/

        .form-control {
            border-radius: 10px;
            border: 1px solid var(--border);
            height: 42px;
        }

        .form-control:focus {
            border-color: var(--navy2);
            box-shadow: 0 0 0 .15rem rgba(37, 99, 235, .15);
        }

        /* ===========================
           TABLE
        ============================*/

        .table {
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 0;
        }

        .table thead {
            background: #eaf2ff;
        }

        .table thead th {
            border: none;
            color: var(--navy);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .3px;
            padding: 14px;
        }

        .table tbody td {
            vertical-align: middle;
            padding: 14px;
            border-color: #edf2f7;
        }

        .table-hover tbody tr {
            transition: .2s;
        }

        .table-hover tbody tr:hover {
            background: #f8fbff;
        }

        /* ===========================
           BADGE
        ============================*/

        .badge-danger {
            background: #dc2626;
            color: #fff;
            padding: 7px 12px;
            border-radius: 30px;
        }

        .badge-success {
            background: #2563eb;
            color: #fff;
            padding: 7px 12px;
            border-radius: 30px;
        }

        /* ===========================
           FILE
        ============================*/

        .file-card {

            background: #fff;

            border: 1px solid var(--border);

            border-radius: 14px;

            padding: 12px;

            transition: .2s;
        }

        .file-card:hover {

            box-shadow: 0 8px 20px rgba(15, 23, 42, .08);

        }

        .file-name {

            font-size: 13px;
            font-weight: 600;
            color: var(--navy);

            word-break: break-word;
        }

        .file-actions {

            display: flex;

            gap: 8px;

            margin-top: 12px;

        }

        .btn-file {

            height: 34px;

            min-width: 80px;

            border-radius: 10px;

            font-size: 12px;

            font-weight: 600;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 5px;

        }

        /* ===========================
           MODAL
        ============================*/

        .modal-content {
            border: none;
            border-radius: 18px;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--navy), var(--navy2));
            color: #fff;
            border: none;
        }

        .modal-footer {
            border: none;
        }

        /* ===========================
           PAGINATION
        ============================*/

        .pagination .page-link {
            color: var(--navy2);
            border-radius: 8px;
            margin: 0 2px;
        }

        .pagination .active .page-link {
            background: var(--navy2);
            border-color: var(--navy2);
        }

        /* ===========================
           RESPONSIVE
        ============================*/

        @media(max-width:768px) {

            .header-title {
                font-size: 15px;
            }

            .card-header .btn {
                width: 100%;
            }

            .btn-action {

                width: 82px;

                height: 34px;

                font-size: 10px;

                padding: 4px;
            }

            .btn-action i {
                font-size: 10px;
            }

            .action-buttons {
                gap: 4px;
            }

            td {
                vertical-align: middle !important;
            }

            .table {
                min-width: 1100px;
            }

            .file-card {
                min-width: 230px;
            }

            .btn-file {

                min-width: 70px;

                font-size: 11px;
            }

        }
    </style>

    <div class="container-fluid mt-3">

        <div class="card shadow-sm border-0">

            {{-- <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    <i class="fas fa-tools"></i>
                    Data Pekerjaan Perbaikan Perawatan Fasilitas
                </h5>

                <a href="{{ route('lp3m.create') }}" class="btn btn-secondary btn-sm">

                    <i class="fas fa-plus"></i>
                    Buat LP3

                </a>

            </div> --}}

            <div
                class="card-header bg-danger text-white d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">

                <h5 class="mb-0 d-flex align-items-center flex-wrap">

                    <i class="fas fa-tools me-2"></i>

                    <span class="header-title">
                        Data Pekerjaan Perbaikan Perawatan Fasilitas
                    </span>

                </h5>

                <a href="{{ route('lp3m.create') }}" class="btn btn-secondary btn-sm text-light fw-bold">

                    <i class="fas fa-plus"></i>
                    Buat Data Baru

                </a>

            </div>

            <div class="card-body">

                {{-- SEARCH --}}
                <form action="{{ route('lp3m.index') }}" method="GET" class="mb-3">

                    <div class="row g-2 align-items-end">

                        {{-- Cari Deskripsi --}}
                        <div class="col-md-4 col-12">

                            <label class="form-label fw-bold">
                                Cari Deskripsi
                            </label>

                            <input type="text" name="search" class="form-control" autocomplete="off"
                                placeholder="Masukkan deskripsi..." value="{{ request('search') }}">

                        </div>

                        {{-- Cari No SPR --}}
                        <div class="col-md-3 col-12">

                            <label class="form-label fw-bold">
                                Cari No. SPR
                            </label>

                            <input type="text" name="spr_no" class="form-control" autocomplete="off"
                                placeholder="Masukkan No SPR..." value="{{ request('spr_no') }}">

                        </div>

                        {{-- Cari Tanggal --}}
                        {{-- <div class="col-md-3 col-12">

                            <label class="form-label fw-bold">
                                Cari Tanggal
                            </label>

                            <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">

                        </div> --}}

                        {{-- Tombol --}}
                        <div class="col-md-2 col-12 d-grid">

                            <button type="submit" class="btn btn-danger fw-bold">

                                <i class="fas fa-search"></i>
                                Cari

                            </button>

                            <a href="{{ route('lp3m.index') }}" class="btn btn-secondary fw-bold">

                                Reset

                            </a>

                        </div>


                    </div>

                </form>

                <div class="table-responsive">

                    @if (session('success'))
                        <div class="alert alert-success">

                            {{ session('success') }}

                        </div>
                    @endif

                    <table class="table table-bordered table-hover">

                        <thead class="bg-light">

                            <tr>
                                <th>No</th>
                                <th>No. SPR</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Tanggal</th>
                                <th>Lampiran</th>
                                <th>Aksi</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($data as $d)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>

                                        @if ($d->spr_no)
                                            <span>
                                                {{ $d->spr_no }}
                                            </span>
                                        @else
                                            <span class="text-muted">
                                                Belum Ada
                                            </span>
                                        @endif

                                    </td>

                                    <td>{{ $d->deskripsi }}</td>

                                    <td>

                                        @if ($d->status == 'OPEN')
                                            <span class="badge badge-danger">
                                                OPEN
                                            </span>
                                        @else
                                            <span class="badge badge-success">
                                                CLOSED
                                            </span>
                                        @endif

                                    </td>

                                    <td>{{ $d->keterangan }}</td>

                                    <td>
                                        {{ date('d-m-Y H:i', strtotime($d->created_at)) }}
                                    </td>

                                    <td style="min-width:280px">

                                        @if ($d->lampiran)
                                            @php
                                                $namaFile = preg_replace('/^\d+_/', '', $d->lampiran);
                                                $ext = strtoupper(pathinfo($d->lampiran, PATHINFO_EXTENSION));
                                            @endphp

                                            <div class="file-card">

                                                <div class="d-flex align-items-center justify-content-between">

                                                    <div class="me-2">

                                                        <div class="file-name">
                                                            <i class="fas fa-file-alt text-primary me-1"></i>
                                                            {{ $namaFile }}
                                                        </div>

                                                        <span class="badge bg-light text-dark border mt-1">
                                                            {{ $ext }}
                                                        </span>

                                                    </div>

                                                </div>

                                                <div class="file-actions">

                                                    {{-- Lihat --}}
                                                    <a href="{{ asset('lampiran/' . $d->lampiran) }}" target="_blank"
                                                        class="btn btn-success btn-file">

                                                        <i class="fas fa-eye"></i>
                                                        Lihat

                                                    </a>

                                                    {{-- Hapus --}}
                                                    <form action="{{ route('lp3m.deleteLampiran', $d->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus lampiran ini?')">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-outline-danger btn-file">

                                                            <i class="fas fa-trash"></i>
                                                            Hapus

                                                        </button>

                                                    </form>

                                                </div>

                                            </div>
                                        @else
                                            <span class="badge bg-secondary">
                                                Tidak Ada Lampiran
                                            </span>
                                        @endif

                                    </td>

                                    {{-- <td>

                                        <a href="{{ route('lp3m.form', $d->id) }}" class="btn btn-sm btn-primary">

                                            <i class="fas fa-file-alt"></i>
                                            Buat LP3M

                                        </a>

                                        
                                        <a href="{{ route('lp3m.show', $d->id) }}" class="btn btn-sm btn-info">

                                            <i class="fas fa-eye"></i>
                                            Lihat

                                        </a>

                                        <a href="{{ route('lp3m.print', $d->id) }}" class="btn btn-sm btn-danger">

                                            <i class="fas fa-print"></i>
                                            Print

                                        </a>

                                    </td> --}}

                                    <td>

                                        <div class="d-flex flex-wrap action-buttons">
                                            {{-- Form --}}
                                            <a href="{{ route('lp3m.form', $d->id) }}" class="btn btn-primary btn-action">
                                                <i class="fas fa-file-alt"></i>
                                                Form
                                            </a>

                                            {{-- Edit --}}
                                            <a href="{{ route('lp3m.edit', $d->id) }}" class="btn btn-warning btn-action">
                                                <i class="fas fa-edit"></i>
                                                Edit
                                            </a>

                                            {{-- Lihat --}}
                                            <a href="{{ route('lp3m.show', $d->id) }}" class="btn btn-info btn-action">
                                                <i class="fas fa-eye"></i>
                                                Lihat
                                            </a>


                                            {{-- Upload --}}
                                            <button type="button" class="btn btn-secondary btn-action btn-upload"
                                                data-id="{{ $d->id }}" data-bs-toggle="modal"
                                                data-bs-target="#uploadLampiranModal">

                                                <i class="fas fa-upload"></i>
                                                Upload

                                            </button>

                                            {{-- Print --}}
                                            <a href="{{ route('lp3m.print', $d->id) }}" class="btn btn-dark btn-action">

                                                <i class="fas fa-print"></i>
                                                Print

                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{ route('lp3m.destroy', $d->id) }}" method="POST"
                                                style="display:inline-block;"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-action">

                                                    <i class="fas fa-trash"></i>
                                                    Hapus

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6" class="text-center">
                                        Tidak ada data
                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-3">
                    {{ $data->links() }}
                </div>

            </div>

        </div>

    </div>

    {{-- Modal Lampiran --}}
    <div class="modal fade" id="uploadLampiranModal" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <form action="{{ route('lp3m.uploadLampiran') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <input type="hidden" name="id" id="lampiran_id">

                    <div class="modal-header bg-danger text-white">

                        <h5 class="modal-title">

                            Upload Lampiran

                        </h5>

                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                        </button>

                    </div>

                    <div class="modal-body">

                        <label class="fw-bold">

                            Pilih File

                        </label>

                        {{-- <input type="file" name="lampiran" class="form-control" required> --}}
                        <input type="file" name="lampiran" class="form-control"
                            accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>

                        <small class="text-muted">

                            PDF, JPG, JPEG, PNG, DOC, DOCX

                        </small>

                    </div>

                    <div class="modal-footer">

                        <button type="submit" class="btn btn-danger">

                            Upload

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>
        document.querySelectorAll('.btn-upload')
            .forEach(function(button) {

                button.addEventListener('click', function() {

                    document.getElementById('lampiran_id').value =
                        this.dataset.id;

                });

            });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
