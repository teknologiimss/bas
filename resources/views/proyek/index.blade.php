@extends('layouts.main')

@section('title', 'Proyek MRO')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        body {
            background: #eef3f9;
            font-family: 'Segoe UI', sans-serif;
        }

        /* HEADER */
        .d-flex.justify-content-between.mb-3 {
            animation: fadeDown .5s ease;
        }

        /* ===========================
           CARD
        ============================ */

        .card {
            border: none;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .10);
            animation: fadeUp .6s ease;
        }

        /* ===========================
           LIST ITEM
        ============================ */

        .border {
            border: none !important;
            border-left: 6px solid #0f172a !important;
            border-radius: 14px !important;
            background: #fff;
            transition: .3s ease;
            box-shadow: 0 4px 12px rgba(15, 23, 42, .06);
        }

        .border:hover {
            transform: translateY(-4px);
            border-left-color: #2563eb !important;
            background: #f8fbff;
            box-shadow: 0 12px 25px rgba(15, 23, 42, .15);
        }

        /* ===========================
           TITLE
        ============================ */

        h5 {
            color: #0f172a;
            font-weight: 700;
        }

        /* ===========================
           BUTTON PRIMARY
        ============================ */

        .btn-success {
            background: linear-gradient(135deg, #0f172a, #1e3a8a) !important;
            border: none !important;
            color: #fff;
            border-radius: 10px !important;
            font-weight: 600;
            transition: .25s;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #1e3a8a, #2563eb) !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, .30);
        }

        /* ===========================
           BUTTON MONITOR
        ============================ */

        .btn-light {
            background: #fff;
            border: 1px solid #1e3a8a;
            color: #1e3a8a;
            border-radius: 10px;
            font-weight: 600;
            transition: .25s;
        }

        .btn-light:hover {
            background: #1e3a8a;
            color: white;
            transform: translateY(-2px);
        }

        /* ===========================
           DELETE BUTTON
        ============================ */

        .btn-danger {
            border-radius: 10px;
            transition: .25s;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
        }

        .btn-secondary {
            border-radius: 10px;
        }

        /* ===========================
           SEARCH
        ============================ */

        .search-wrapper-box {
            display: flex;
            justify-content: flex-end;
        }

        .search-wrapper {
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            max-width: 400px;
            width: 100%;
            border: 1px solid #cbd5e1;
            box-shadow: 0 8px 20px rgba(15, 23, 42, .08);
            transition: .3s;
        }

        .search-wrapper:focus-within {
            border-color: #2563eb;
            box-shadow: 0 10px 25px rgba(37, 99, 235, .20);
            transform: translateY(-2px);
        }

        .search-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 12px;
            font-size: 14px;
        }

        .search-btn {
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            color: white;
            border: none;
            padding: 12px 16px;
            transition: .25s;
        }

        .search-btn:hover {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
        }

        /* ===========================
           MODAL
        ============================ */

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

        /* ===========================
           INPUT
        ============================ */

        .form-control {
            border-radius: 10px;
            border: 1px solid #cbd5e1;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .15);
        }

        /* ===========================
           PAGINATION
        ============================ */

        .pagination {
            justify-content: center;
        }

        .page-link {
            color: #1e3a8a;
            border-radius: 8px;
            margin: 0 2px;
        }

        .page-item.active .page-link {
            background: #1e3a8a;
            border-color: #1e3a8a;
            color: white;
        }

        /* ===========================
           ANIMATION
        ============================ */

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
                transform: scale(.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
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

        /* ===========================
           MOBILE
        ============================ */

        @media (max-width:768px) {

            .card {
                padding: 15px !important;
                border-radius: 14px;
            }

            .d-flex.justify-content-between.mb-3 {
                flex-direction: column;
            }

            .d-flex.justify-content-between.mb-3 .btn {
                width: 100%;
                margin: 0 !important;
                height: 42px;
            }

            .search-wrapper-box {
                justify-content: center;
            }

            .search-wrapper {
                width: 100%;
                max-width: 100%;
            }

            .search-input {
                font-size: 13px;
                padding: 10px;
            }

            .search-btn {
                padding: 10px 14px;
                font-size: 13px;
            }

            .border.p-3 {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 12px;
                padding: 14px !important;
            }

            .border h5 {
                font-size: 15px;
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
                margin: 0 !important;
            }

            .border .btn {
                height: 38px;
                font-size: 12px;
                border-radius: 8px !important;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .border form {
                display: flex;
            }

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

            .pagination {
                flex-wrap: wrap;
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
