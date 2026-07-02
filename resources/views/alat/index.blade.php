@extends('layouts.main')

@section('title', 'Monitoring Alat Angkat Angkut MRO')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        body {
            background: #f4f7fb;
            font-family: 'Segoe UI', sans-serif;
        }

        /* HEADER BUTTON AREA */
        .d-flex.justify-content-between.mb-3 {
            animation: fadeDown .5s ease;
        }

        /* CARD */
        .card {
            border: none;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 10px 25px rgba(13, 42, 84, .08);
            animation: fadeUp .5s ease;
        }

        /* ITEM ROW */
        .border {
            border: none !important;
            border-left: 5px solid #0d3b66 !important;
            border-radius: 14px !important;
            background: #fff;
            transition: .3s;
        }

        .border:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 22px rgba(13, 42, 84, .15);
        }

        /* TITLE */
        h5 {
            color: #0d3b66;
            font-weight: 700;
        }

        /* PRIMARY BUTTON */
        .btn-success {
            background: linear-gradient(135deg, #0d3b66, #1d4f91) !important;
            border: none !important;
            color: #fff !important;
            border-radius: 10px !important;
            transition: .25s;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #0a2f55, #2d5ea6) !important;
            transform: translateY(-2px);
            box-shadow: 0 10px 18px rgba(13, 59, 102, .25);
        }

        /* MONITOR BUTTON */
        .btn-light {
            background: #fff;
            color: #0d3b66;
            border: 1px solid #0d3b66;
            border-radius: 10px;
            transition: .25s;
        }

        .btn-light:hover {
            background: #0d3b66;
            color: #fff;
            border-color: #0d3b66;
            transform: translateY(-2px);
        }

        /* DELETE BUTTON */
        .btn-danger {
            background: linear-gradient(135deg, #d63031, #b71c1c);
            border: none;
            border-radius: 10px;
            transition: .25s;
        }

        .btn-danger:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(214, 48, 49, .25);
        }

        /* MODAL */
        .modal-content {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            animation: pop .3s ease;
        }

        .modal-header {
            background: linear-gradient(135deg, #0d3b66, #1d4f91);
            color: white;
            border: none;
        }

        /* INPUT */
        .form-control {
            border-radius: 10px;
            border: 1px solid #d6dee8;
            transition: .25s;
        }

        .form-control:focus {
            border-color: #0d3b66;
            box-shadow: 0 0 0 .2rem rgba(13, 59, 102, .15);
        }

        /* PAGINATION */
        .pagination {
            justify-content: center;
        }

        .page-link {
            color: #0d3b66;
            border-radius: 8px;
            margin: 0 2px;
        }

        .page-item.active .page-link {
            background: #0d3b66;
            border-color: #0d3b66;
            color: #fff;
        }

        /* SEARCH */
        .search-box {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 18px;
        }

        .search-wrapper {
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 460px;
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #d8e1eb;
            box-shadow: 0 8px 18px rgba(13, 42, 84, .08);
            transition: .3s;
        }

        .search-wrapper:focus-within {
            border-color: #0d3b66;
            box-shadow: 0 10px 20px rgba(13, 59, 102, .18);
        }

        .search-icon {
            padding: 12px;
            color: #0d3b66;
            font-size: 16px;
        }

        .search-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 12px;
            background: transparent;
        }

        .search-btn {
            background: linear-gradient(135deg, #0d3b66, #1d4f91);
            color: white;
            border: none;
            padding: 12px 18px;
            transition: .3s;
        }

        .search-btn:hover {
            background: linear-gradient(135deg, #0a2f55, #2d5ea6);
        }

        /* BUTTON */
        button,
        a {
            transition: .25s;
        }

        button:active,
        a:active {
            transform: scale(.97);
        }

        /* ANIMATION */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

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

        @keyframes pop {
            from {
                transform: scale(.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* =========================
           RESPONSIVE MOBILE
        ========================= */

        @media (max-width:768px) {

            .card {
                padding: 15px !important;
            }

            .d-flex.justify-content-between.mb-3 {
                flex-direction: column;
            }

            .d-flex.justify-content-between.mb-3 .btn {
                width: 100%;
                margin: 0 !important;
                height: 42px;
                font-size: 14px;
            }

            .search-box {
                justify-content: center;
            }

            .search-wrapper {
                width: 100%;
                max-width: 100%;
            }

            .search-input {
                font-size: 13px;
            }

            .search-btn {
                font-size: 13px;
                padding: 10px 15px;
            }

            .border.p-3 {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 14px;
                padding: 15px !important;
            }

            .border h5 {
                font-size: 16px;
                margin-bottom: 0;
                word-break: break-word;
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
                height: 38px;
                font-size: 12px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .modal-dialog {
                margin: 12px;
            }

            .modal-content {
                border-radius: 15px;
            }

            .modal-footer {
                flex-direction: column;
                gap: 8px;
            }

            .modal-footer .btn {
                width: 100%;
            }

            .pagination {
                flex-wrap: wrap;
            }

            .page-link {
                font-size: 12px;
                padding: 6px 10px;
            }
        }
    </style>

    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-success" data-toggle="modal" data-target="#modalCreate" style="margin: 10px;">
            + Tambah Data
        </button>
    </div>

    <!-- MODERN SEARCH -->
    <div class="search-box">
        <form method="GET" action="">
            <div class="search-wrapper">
                <span class="search-icon">🔍</span>
                <input type="text" name="search" class="search-input" autocomplete="off" placeholder="Cari Tahun..."
                    value="{{ request('search') }}">
                <button class="search-btn">Cari</button>
            </div>
        </form>
    </div>

    <!-- LIST PROYEK -->
    <div class="card p-3">
        <h5 class="mb-3">Daftar Data Alat Angkat - Angkut MRO</h5>

        @foreach ($data as $p)
            <div class="d-flex justify-content-between align-items-center border p-3 mb-2 rounded">
                <div>
                    <h5 class="mb-1">{{ $p->nama_proyek }}</h5>
                </div>

                <div>
                    <a href="{{ route('alat.monitor', $p->id) }}" class="btn btn-light">📊 Monitor</a>

                    <button class="btn btn-success" data-toggle="modal" data-target="#modalEdit{{ $p->id }}">
                        ✏️ Edit
                    </button>

                    <form action="{{ route('alat.delete', $p->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Hapus proyek ini?')">
                            🗑️Delete
                        </button>
                    </form>
                </div>
            </div>

            <!-- Modal Edit -->
            <div class="modal fade" id="modalEdit{{ $p->id }}">
                <div class="modal-dialog">
                    <form class="modal-content" action="{{ route('alat.update', $p->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5>Edit Proyek</h5>
                        </div>
                        <div class="modal-body">
                            <label>Nama Proyek *</label>
                            <input type="text" name="nama_proyek" value="{{ $p->nama_proyek }}" class="form-control"
                                required>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success">Submit</button>
                            <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach

        <div class="mt-3">
            {{ $data->appends(['search' => request('search')])->links() }}
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="modalCreate">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('alat.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5>Buat Proyek Baru</h5>
                </div>
                <div class="modal-body">
                    <label>Nama Proyek *</label>
                    <input type="text" name="nama_proyek" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>

@endsection
