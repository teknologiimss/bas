@extends('layouts.main')

@section('title', 'Perencanaan Pekerjaan MRO')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')

    <style>
        body {
            background: #f5f6fa;
        }

        /* CARD */
        .card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            animation: fadeUp 0.6s ease;
        }

        /* ITEM */
        .border {
            border: none !important;
            border-left: 5px solid #c40000 !important;
            border-radius: 14px !important;
            background: #fff;
            transition: 0.25s ease;
        }

        .border:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(196, 0, 0, 0.15);
        }

        /* TITLE */
        h5 {
            color: #b30000;
            font-weight: 700;
        }

        /* BUTTON */
        .btn-success {
            background: linear-gradient(135deg, #c40000, #7a0000) !important;
            border: none !important;
            border-radius: 10px !important;
        }

        .btn-success:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(196, 0, 0, 0.3);
        }

        .btn-primary {
            border-radius: 10px;
        }

        .btn-warning {
            border-radius: 10px;
        }

        .btn-danger {
            border-radius: 10px;
        }

        /* MODAL */
        .modal-content {
            border-radius: 18px;
            overflow: hidden;
            animation: pop 0.3s ease;
        }

        .modal-header {
            background: linear-gradient(135deg, #c40000, #7a0000);
            color: white;
        }

        /* INPUT */
        .form-control {
            border-radius: 10px;
        }

        /* ANIMATION */
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
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        button,
        a {
            transition: 0.2s ease;
        }

        button:active,
        a:active {
            transform: scale(0.95);
        }



        /* =========================================
       RESPONSIVE MOBILE
    ========================================= */
        @media (max-width: 768px) {

            /* CARD */
            .card {
                padding: 15px !important;
                border-radius: 14px;
            }

            /* HEADER BUTTON */
            .d-flex.justify-content-between.mb-3 {
                flex-direction: column;
            }

            .d-flex.justify-content-between.mb-3 .btn {
                width: 100%;
                height: 42px;
                font-size: 14px;
                border-radius: 10px !important;
            }

            /* SEARCH */
            .d-flex.justify-content-end.mb-3 {
                justify-content: center !important;
            }

            .input-group {
                width: 100%;
            }

            .input-group .form-control {
                font-size: 13px;
                height: 40px;
            }

            .input-group .btn {
                font-size: 13px;
                padding: 0 14px;
                height: 40px;
            }

            /* ITEM CARD */
            .border.p-3 {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 12px;
                padding: 14px !important;
            }

            /* TITLE */
            .border h5 {
                font-size: 15px;
                margin-bottom: 0;
                word-break: break-word;
            }

            /* BUTTON AREA */
            .border>div:last-child {
                width: 100%;
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
            }

            /* BUTTON */
            .border .btn,
            .border form {
                width: 100%;
                margin: 0 !important;
            }

            .border .btn {
                height: 38px;
                font-size: 12px;
                border-radius: 8px !important;
                padding: 6px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* FORM DELETE */
            .border form {
                display: flex;
            }

            /* MODAL */
            .modal-dialog {
                margin: 12px;
            }

            .modal-content {
                border-radius: 14px;
            }

            .modal-footer {
                flex-direction: column;
                gap: 8px;
            }

            .modal-footer .btn {
                width: 100%;
            }

            /* PAGINATION */
            .pagination {
                flex-wrap: wrap;
                gap: 5px;
                justify-content: center;
            }

            .page-link {
                font-size: 12px;
                padding: 6px 10px;
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
