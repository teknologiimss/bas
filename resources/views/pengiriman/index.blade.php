@extends('layouts.main')

@section('title', 'Monitoring Pekerjaan Pengiriman MRO')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        body {
            background: #f4f7fc;
        }

        :root {
            --navy: #0F172A;
            --navy-dark: #020617;
            --navy-light: #1E3A8A;
            --navy-soft: #EFF6FF;
            --border: #D6E4F5;
            --text: #334155;
        }

        /* ================= HEADER ================= */
        .d-flex.justify-content-between.mb-3 {
            animation: fadeDown .45s ease;
        }

        /* ================= CARD ================= */
        .card {
            border: none;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .08);
            animation: fadeUp .5s ease;
        }

        /* ================= TITLE ================= */
        h5 {
            color: var(--navy);
            font-weight: 700;
        }

        /* ================= ITEM ================= */
        .border {
            border: none !important;
            border-left: 5px solid var(--navy-light) !important;
            border-radius: 14px !important;
            background: white;
            transition: .25s;
        }

        .border:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(15, 23, 42, .12);
            background: #fbfdff;
        }

        /* ================= BUTTON PRIMARY ================= */
        .btn-success {
            background: linear-gradient(135deg, var(--navy-light), var(--navy)) !important;
            border: none !important;
            border-radius: 10px !important;
            color: #fff !important;
            font-weight: 600;
            box-shadow: 0 6px 18px rgba(30, 58, 138, .25);
            transition: .25s;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(30, 58, 138, .35);
        }

        /* ================= BUTTON MONITOR ================= */
        .btn-light {
            background: white;
            color: var(--navy);
            border: 1px solid var(--navy-light);
            border-radius: 10px;
            font-weight: 600;
            transition: .25s;
        }

        .btn-light:hover {
            background: var(--navy-light);
            color: white;
            border-color: var(--navy-light);
        }

        /* ================= DELETE ================= */
        .btn-danger {
            border-radius: 10px;
            transition: .25s;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
        }

        /* ================= SEARCH ================= */

        .search-box {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 18px;
        }

        .search-wrapper {
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 450px;

            background: white;
            border-radius: 14px;
            overflow: hidden;

            border: 1px solid var(--border);
            box-shadow: 0 8px 20px rgba(15, 23, 42, .08);
            transition: .25s;
        }

        .search-wrapper:focus-within {
            border-color: var(--navy-light);
            box-shadow: 0 10px 25px rgba(30, 58, 138, .18);
        }

        .search-icon {
            padding: 12px;
            color: var(--navy-light);
            font-size: 18px;
        }

        .search-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 12px;
            background: white;
        }

        .search-btn {
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px 20px;
            background: linear-gradient(135deg, var(--navy-light), var(--navy));
            transition: .25s;
        }

        .search-btn:hover {
            background: linear-gradient(135deg, var(--navy), var(--navy-dark));
        }

        /* ================= MODAL ================= */

        .modal-content {
            border: none;
            border-radius: 18px;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--navy-light), var(--navy));
            color: white;
        }

        .modal-header h5 {
            color: white;
            margin: 0;
        }

        /* ================= INPUT ================= */

        .form-control {
            border-radius: 10px;
            border: 1px solid var(--border);
        }

        .form-control:focus {
            border-color: var(--navy-light);
            box-shadow: 0 0 0 .2rem rgba(30, 58, 138, .12);
        }

        /* ================= PAGINATION ================= */

        .pagination {
            justify-content: center;
        }

        .page-item.active .page-link {
            background: var(--navy-light);
            border-color: var(--navy-light);
        }

        .page-link {
            color: var(--navy);
        }

        .page-link:hover {
            color: white;
            background: var(--navy-light);
            border-color: var(--navy-light);
        }

        /* ================= ANIMATION ================= */

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
                transform: translateY(-15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        button,
        a {
            transition: .25s;
        }

        button:active,
        a:active {
            transform: scale(.96);
        }

        /* ================= MOBILE ================= */

        @media(max-width:768px) {

            .d-flex.justify-content-between.mb-3 {
                flex-direction: column;
                gap: 10px;
            }

            .d-flex.justify-content-between.mb-3 .btn {
                width: 100%;
            }

            .search-box {
                justify-content: center;
            }

            .search-wrapper {
                max-width: 100%;
            }

            .border.p-3 {
                flex-direction: column !important;
                align-items: flex-start !important;
            }

            .border>div:last-child {
                width: 100%;
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .border .btn {
                width: 100%;
            }

            .modal-dialog {
                margin: 12px;
            }

            .pagination {
                flex-wrap: wrap;
            }
        }
    </style>

    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-success" data-toggle="modal" data-target="#modalCreate" style="margin: 10px;">
            + Buat Pekerjaan Baru
        </button>
    </div>

    <!-- MODERN SEARCH -->
    <div class="search-box">
        <form method="GET" action="">
            <div class="search-wrapper">
                <span class="search-icon">🔍</span>
                <input type="text" name="search" class="search-input" autocomplete="off"
                    placeholder="Cari nama proyek..." value="{{ request('search') }}">
                <button class="search-btn">Cari</button>
            </div>
        </form>
    </div>

    <!-- LIST PROYEK -->
    <div class="card p-3">
        <h5 class="mb-3">Daftar Pekerjaan MRO</h5>

        @foreach ($data as $p)
            <div class="d-flex justify-content-between align-items-center border p-3 mb-2 rounded">
                <div>
                    <h5 class="mb-1">{{ $p->nama_proyek }}</h5>
                </div>

                <div>
                    <a href="{{ route('pengiriman.monitor', $p->id) }}" class="btn btn-light">📊 Monitor</a>

                    <button class="btn btn-success" data-toggle="modal" data-target="#modalEdit{{ $p->id }}">
                        ✏️ Edit
                    </button>

                    <form action="{{ route('pengiriman.delete', $p->id) }}" method="POST" class="d-inline">
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
                    <form class="modal-content" action="{{ route('pengiriman.update', $p->id) }}" method="POST">
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
            <form class="modal-content" action="{{ route('pengiriman.store') }}" method="POST">
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
