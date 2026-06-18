@extends('layouts.main')

@section('title', 'Monitoring Pekerjaan Pengiriman MRO')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        body {
            background: #f5f6fa;
        }

        /* HEADER BUTTON AREA */
        .d-flex.justify-content-between.mb-3 {
            animation: fadeDown 0.5s ease;
        }

        /* CARD LIST */
        .card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            animation: fadeUp 0.6s ease;
        }

        /* ITEM ROW */
        .border {
            border: none !important;
            border-left: 5px solid #c40000 !important;
            border-radius: 14px !important;
            transition: all 0.25s ease;
            background: #fff;
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

        /* BUTTON STYLE */
        .btn-success {
            background: linear-gradient(135deg, #c40000, #7a0000) !important;
            border: none !important;
            border-radius: 10px !important;
            transition: 0.2s;
        }

        .btn-success:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(196, 0, 0, 0.3);
        }

        /* LIGHT BUTTON */
        .btn-light {
            border-radius: 10px;
            border: 1px solid #c40000;
            color: #c40000;
            transition: 0.2s;
        }

        .btn-light:hover {
            background: #c40000;
            color: white;
            transform: translateY(-2px);
        }

        /* DELETE BUTTON */
        .btn-danger {
            border-radius: 10px;
            transition: 0.2s;
        }

        .btn-danger:hover {
            transform: scale(1.05);
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

        /* PAGINATION */
        .pagination {
            justify-content: center;
        }

        .page-item.active .page-link {
            background: #c40000;
            border-color: #c40000;
        }

        /* SEARCH MODERN */
        .search-box {
            display: flex;
            justify-content: flex-end;
            /* pindah ke kanan */
            margin-bottom: 15px;
        }

        .search-wrapper {
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(196, 0, 0, 0.2);
            max-width: 450px;
            width: 100%;
            transition: 0.3s;
        }

        .search-wrapper:focus-within {
            box-shadow: 0 10px 25px rgba(196, 0, 0, 0.25);
            transform: translateY(-2px);
        }

        .search-icon {
            padding: 10px 12px;
            color: #c40000;
        }

        .search-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 12px;
        }

        .search-btn {
            background: linear-gradient(135deg, #c40000, #7a0000);
            color: #fff;
            border: none;
            padding: 12px 18px;
            cursor: pointer;
        }

        .search-btn:hover {
            transform: scale(1.05);
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
            transition: all 0.2s ease;
        }

        button:active,
        a:active {
            transform: scale(0.95);
        }



        /* =========================
                           RESPONSIVE MOBILE
                        ========================= */
        @media (max-width: 768px) {

            /* HEADER BUTTON */
            .d-flex.justify-content-between.mb-3 {
                flex-direction: column;
                align-items: stretch !important;
            }

            .d-flex.justify-content-between.mb-3 .btn {
                width: 100%;
                margin: 0 !important;
                height: 42px;
                font-size: 14px;
            }

            /* SEARCH */
            .search-box {
                justify-content: center;
            }

            .search-wrapper {
                max-width: 100%;
            }

            .search-input {
                font-size: 14px;
                padding: 10px;
            }

            .search-btn {
                padding: 10px 14px;
                font-size: 14px;
            }

            /* CARD ITEM */
            .border.p-3 {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 12px;
            }

            /* TITLE */
            .border h5 {
                font-size: 16px;
                margin-bottom: 0;
            }

            /* BUTTON AREA */
            .border .btn,
            .border form {
                width: 100%;
            }

            .border .btn {
                width: 100%;
                height: 40px;
                font-size: 13px;
                border-radius: 8px !important;
                margin-bottom: 6px;
            }

            /* BUTTON GROUP */
            .border>div:last-child {
                width: 100%;
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            /* DELETE BUTTON */
            .btn-danger,
            .btn-success,
            .btn-light {
                padding: 8px 10px !important;
            }

            /* MODAL */
            .modal-dialog {
                margin: 15px;
            }

            .modal-content {
                border-radius: 14px;
            }

            /* PAGINATION */
            .pagination {
                flex-wrap: wrap;
                gap: 5px;
            }

            .page-link {
                font-size: 13px;
                padding: 6px 10px;
            }
        }

        .action-buttons {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .action-buttons form {
            margin: 0;
        }

        .btn-folder {
            min-width: 110px;
            height: 42px;
            display: flex !important;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 10px;
        }
    </style>

    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-success" data-toggle="modal" data-target="#modalCreate" style="margin: 10px;">
            + Buat Data Baru
        </button>
    </div>

    <!-- MODERN SEARCH -->
    <div class="search-box">
        <form method="GET" action="">
            <div class="search-wrapper">
                <span class="search-icon">🔍</span>
                <input type="text" name="search" class="search-input" autocomplete="off"
                    placeholder="Cari rewinding..." value="{{ request('search') }}">
                <button class="search-btn">Cari</button>
            </div>
        </form>
    </div>

    <!-- LIST PROYEK -->
    <div class="card p-3">
        <h5 class="mb-3">Daftar Rewinding MRO</h5>

        @foreach ($data as $folder)
            <div class="d-flex justify-content-between align-items-center border p-3 mb-2 rounded">

                <div>

                    <h5>

                        {{ $folder->nama_folder }}

                    </h5>

                </div>

                <div class="action-buttons">

                    <a href="{{ route('rewinding.monitor', $folder->id) }}" class="btn btn-info btn-folder">
                        <i class="fas fa-chart-bar"></i>
                        Monitor
                    </a>

                    <button type="button" class="btn btn-warning btn-folder" data-toggle="modal"
                        data-target="#editFolder{{ $folder->id }}">
                        <i class="fas fa-edit"></i>
                        Edit
                    </button>

                    <form action="{{ route('rewinding.folder.delete', $folder->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus folder ini?')">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger btn-folder">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>

                    </form>

                </div>

            </div>
        @endforeach

        {{-- Modal Edit --}}
        @foreach ($data as $folder)
            <div class="modal fade" id="editFolder{{ $folder->id }}">
                <div class="modal-dialog">
                    <form action="{{ route('rewinding.folder.update', $folder->id) }}" method="POST" class="modal-content">

                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5>Edit Folder</h5>
                        </div>

                        <div class="modal-body">

                            <label>Nama Folder</label>

                            <input type="text" name="nama_folder" class="form-control" value="{{ $folder->nama_folder }}"
                                required>

                        </div>

                        <div class="modal-footer">

                            <button class="btn btn-success">
                                Simpan
                            </button>

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">

                                Batal

                            </button>

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
            <form class="modal-content" action="{{ route('rewinding.folder.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5>Buat Proyek Baru</h5>
                </div>
                <div class="modal-body">
                    <label>Nama Proyek *</label>
                    <input type="text" name="nama_folder" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>

@endsection
