@extends('layouts.main')

@section('title', 'Perencanaan Pekerjaan MRO')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')

    <style>
        body {
            background: #eef3f9;
            font-family: 'Segoe UI', sans-serif;
        }

        /* ==========================
            CARD
        ========================== */
        .card {
            border: none;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .10);
            animation: fadeUp .5s ease;
        }

        /* ==========================
            LIST ITEM
        ========================== */
        .border {
            border: none !important;
            border-left: 6px solid #0f172a !important;
            border-radius: 14px !important;
            background: #fff;
            transition: .3s ease;
            box-shadow: 0 4px 12px rgba(15, 23, 42, .05);
        }

        .border:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(15, 23, 42, .15);
            border-left-color: #2563eb !important;
            background: #f8fbff;
        }

        /* ==========================
            TITLE
        ========================== */
        h5 {
            color: #0f172a;
            font-weight: 700;
        }

        /* ==========================
            BUTTON
        ========================== */

        .btn-success {
            background: linear-gradient(135deg, #0f172a, #1e3a8a) !important;
            border: none !important;
            border-radius: 10px !important;
            color: white;
            font-weight: 600;
            transition: .25s;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #1e3a8a, #2563eb) !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, .30);
        }

        .btn-primary {
            background: #2563eb;
            border: none;
            border-radius: 10px;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-warning {
            background: #f59e0b;
            border: none;
            color: white;
            border-radius: 10px;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .btn-danger {
            background: #dc2626;
            border: none;
            border-radius: 10px;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .btn-secondary {
            border-radius: 10px;
        }

        /* ==========================
            SEARCH
        ========================== */

        .input-group .form-control {
            border-radius: 10px 0 0 10px;
            border: 1px solid #cbd5e1;
        }

        .input-group .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .15);
        }

        .input-group .btn {
            border-radius: 0 10px 10px 0;
        }

        /* ==========================
            MODAL
        ========================== */

        .modal-content {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            animation: pop .3s ease;
        }

        .modal-header {
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            color: white;
            border: none;
        }

        .modal-footer {
            border-top: 1px solid #e5e7eb;
        }

        /* ==========================
            INPUT
        ========================== */

        .form-control {
            border-radius: 10px;
            border: 1px solid #d1d5db;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .15);
        }

        /* ==========================
            PAGINATION
        ========================== */

        .pagination .page-link {
            color: #1e3a8a;
            border-radius: 8px;
            margin: 0 2px;
        }

        .pagination .active .page-link {
            background: #1e3a8a;
            border-color: #1e3a8a;
            color: white;
        }

        /* ==========================
            ANIMATION
        ========================== */

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

        @keyframes pop {
            from {
                opacity: 0;
                transform: scale(.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        button,
        a {
            transition: .25s ease;
        }

        button:active,
        a:active {
            transform: scale(.97);
        }

        /* ==========================
            MOBILE
        ========================== */

        @media (max-width:768px) {

            .card {
                padding: 15px !important;
            }

            .d-flex.justify-content-between.mb-3 {
                flex-direction: column;
                gap: 10px;
            }

            .d-flex.justify-content-between.mb-3 .btn {
                width: 100%;
            }

            .d-flex.justify-content-end.mb-3 {
                justify-content: center !important;
            }

            .input-group {
                width: 100%;
            }

            .border.p-3 {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 15px;
            }

            .border>div:last-child {
                width: 100%;
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
            }

            .border .btn,
            .border form {
                width: 100%;
            }

            .border .btn {
                font-size: 12px;
                height: 38px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .modal-dialog {
                margin: 10px;
            }

            .modal-footer {
                flex-direction: column;
                gap: 10px;
            }

            .modal-footer .btn {
                width: 100%;
            }

            .pagination {
                justify-content: center;
                flex-wrap: wrap;
            }

            h5 {
                font-size: 17px;
            }
        }
    </style>

    <!-- HEADER BUTTON -->
    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-success" data-toggle="modal" data-target="#modalTambah">
            + Tambah Perencanaan
        </button>
    </div>

    <div class="d-flex justify-content-end mb-3">

        <form method="GET" action="" style="max-width: 400px; width: 100%;">
            <div class="input-group">

                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Cari nama proyek...">

                <button class="btn btn-success">
                    🔍 Cari
                </button>

            </div>
        </form>

    </div>

    <!-- CARD LIST -->
    <div class="card p-3">

        <h5 class="mb-3">Daftar Proyek Perencanaan MRO</h5>

        @foreach ($data as $p)
            <div class="d-flex justify-content-between align-items-center border p-3 mb-2 rounded">

                <div>
                    <h5 class="mb-1">{{ $p->nama_proyek }}</h5>
                </div>

                <div>

                    <a href="{{ route('perencanaan.index', $p->id) }}" class="btn btn-primary btn-sm">
                        📋 Open
                    </a>

                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit{{ $p->id }}">
                        ✏️ Edit
                    </button>

                    <form action="{{ route('perencanaan.proyek.delete', $p->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus proyek?')">
                            🗑️ Delete
                        </button>
                    </form>

                </div>

            </div>

            <!-- MODAL EDIT -->
            <div class="modal fade" id="edit{{ $p->id }}">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('perencanaan.proyek.update', $p->id) }}" class="modal-content">

                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5>Edit Proyek</h5>
                        </div>

                        <div class="modal-body">
                            <input type="text" name="nama_proyek" value="{{ $p->nama_proyek }}" class="form-control"
                                required>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success">Update</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>

                    </form>
                </div>
            </div>
        @endforeach

        <div class="mt-3">
            {{ $data->links() }}
        </div>

    </div>

    <!-- MODAL TAMBAH -->
    <div class="modal fade" id="modalTambah">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('perencanaan.proyek.store') }}" class="modal-content">

                @csrf

                <div class="modal-header">
                    <h5>Tambah Proyek Baru</h5>
                </div>

                <div class="modal-body">
                    <input type="text" name="nama_proyek" class="form-control" placeholder="Nama Proyek" required>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </form>
        </div>
    </div>

@endsection
