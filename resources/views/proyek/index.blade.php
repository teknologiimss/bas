@extends('layouts.main')

@section('title', 'Proyek MRO')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        body {
            background: #f5f6fa;
        }

        /* HEADER */
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

        /* ITEM LIST */
        .border {
            border: none !important;
            border-left: 5px solid #c40000 !important;
            border-radius: 14px !important;
            background: #fff;
            transition: 0.25s;
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

        /* BUTTON PRIMARY (CREATE + SUBMIT) */
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

        /* MONITOR BUTTON */
        .btn-light {
            border-radius: 10px;
            border: 1px solid #c40000;
            color: #c40000;
            transition: 0.2s;
        }

        .btn-light:hover {
            background: #c40000;
            color: #fff;
            transform: translateY(-2px);
        }

        /* DELETE */
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
            color: #fff;
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

        /* BUTTON CLICK EFFECT */
        button,
        a {
            transition: all 0.2s ease;
        }

        button:active,
        a:active {
            transform: scale(0.95);
        }

        /* SEARCH WRAPPER POSISI KANAN */
        .search-wrapper-box {
            display: flex;
            justify-content: flex-end;
            /* INI KUNCINYA */
        }

        /* SEARCH BOX MODERN */
        .search-wrapper {
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(196, 0, 0, 0.2);
            max-width: 380px;
            width: 100%;
            transition: 0.3s;
        }

        .search-wrapper:focus-within {
            box-shadow: 0 10px 25px rgba(196, 0, 0, 0.25);
            transform: translateY(-2px);
        }

        /* INPUT */
        .search-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 12px;
            font-size: 14px;
        }

        /* BUTTON */
        .search-btn {
            background: linear-gradient(135deg, #c40000, #7a0000);
            color: #fff;
            border: none;
            padding: 12px 16px;
            cursor: pointer;
            transition: 0.2s;
        }

        .search-btn:hover {
            transform: scale(1.05);
        }

        .search-btn:active {
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
                margin: 0 !important;
                height: 42px;
                font-size: 14px;
                border-radius: 10px !important;
            }

            /* SEARCH */
            .search-wrapper-box {
                justify-content: center;
            }

            .search-wrapper {
                width: 100%;
                max-width: 100%;
                border-radius: 12px;
            }

            .search-input {
                font-size: 13px;
                padding: 10px;
            }

            .search-btn {
                padding: 10px 14px;
                font-size: 13px;
            }

            /* ITEM LIST */
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
                justify-content: center;
                gap: 5px;
            }

            .page-link {
                font-size: 12px;
                padding: 6px 10px;
            }
        }
    </style>
    {{-- <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/adminlte.min.js') }}"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>

    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script> --}}


    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-success" data-toggle="modal" data-target="#modalCreate" style="margin: 10px;">
            + Buat Proyek Baru
        </button>
    </div>

    <!-- FILTER SEARCH -->
    <div class="search-wrapper-box mb-3">
        <form method="GET" action="">
            <div class="search-wrapper">

                <input type="text" name="search" class="search-input" autocomplete="off"
                    placeholder="Cari nama proyek..." value="{{ request('search') }}">

                <button class="search-btn">
                    🔍 Cari
                </button>

            </div>
        </form>
    </div>

    <!-- LIST PROYEK -->
    <div class="card p-3">
        <h5 class="mb-3">Daftar Proyek MRO</h5>

        @foreach ($proyeks as $p)
            <div class="d-flex justify-content-between align-items-center border p-3 mb-2 rounded">
                <div>
                    <h5 class="mb-1">{{ $p->nama_proyek }}</h5>
                    {{-- <small class="text-muted">Progress belum tersedia</small> --}}
                </div>

                <div>
                    <a href="{{ route('monitoring.index', $p->id) }}" class="btn btn-light">📊
                        Monitor
                    </a>

                    <!-- Edit -->
                    <button class="btn btn-success" data-toggle="modal" data-target="#modalEdit{{ $p->id }}">✏️
                        Edit
                    </button>


                    <!-- Delete -->
                    <form action="{{ route('proyek.delete', $p->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Hapus proyek ini?')">🗑️Delete</button>
                    </form>
                </div>
            </div>

            <!-- Modal Edit -->
            <div class="modal fade" id="modalEdit{{ $p->id }}">
                <div class="modal-dialog">
                    <form class="modal-content" action="{{ route('proyek.update', $p->id) }}" method="POST">
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
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach

        {{-- <div class="mt-3">
            {{ $proyeks->links() }}
        </div> --}}
        <div class="mt-3">
            {{ $proyeks->appends(['search' => request('search')])->links() }}
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="modalCreate">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('proyek.store') }}" method="POST">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
