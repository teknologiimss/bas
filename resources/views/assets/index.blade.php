@extends('layouts.main')

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <style>
        :root {
            --primary: #0f172a;
            --primary-dark: #020617;
            --primary-light: #1e3a8a;
            --secondary: #3b82f6;
            --soft: #dbeafe;
            --bg: #f1f5f9;
            --text: #1e293b;
        }

        body {
            background: linear-gradient(135deg, #eef4ff, #f8fafc);
            font-family: 'Segoe UI', sans-serif;
            color: var(--text);
        }

        /* =========================
            SUMMARY CARD
        ========================= */

        .asset-count {
            background: linear-gradient(135deg,
                    var(--primary),
                    var(--primary-light));
            color: white;
            border-radius: 22px;
            padding: 28px;
            margin-bottom: 25px;
            box-shadow: 0 15px 35px rgba(15, 23, 42, .25);
        }

        .asset-count h2 {
            font-size: 40px;
            font-weight: 700;
            margin: 0;
        }

        .asset-count small {
            opacity: .9;
            letter-spacing: .5px;
            font-size: 14px;
        }

        /* =========================
            CARD
        ========================= */

        .asset-card {
            border: none;
            border-radius: 22px;
            overflow: hidden;
            background: white;
            box-shadow: 0 10px 35px rgba(15, 23, 42, .08);
            animation: fadeUp .5s ease;
        }

        .asset-header {
            background: linear-gradient(135deg,
                    var(--primary),
                    var(--primary-light));
            padding: 20px 25px;
        }

        .asset-header h5 {
            font-weight: 700;
            letter-spacing: .5px;
        }

        /* =========================
            BUTTON
        ========================= */

        .btn-modern {
            border: none;
            border-radius: 12px;
            padding: 10px 18px;
            font-weight: 600;
            transition: .3s;
        }

        .btn-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(15, 23, 42, .18);
        }

        .btn-edit {
            background: #2563eb;
            color: white;
        }

        .btn-edit:hover {
            background: #1d4ed8;
            color: white;
        }

        .btn-delete {
            background: #dc2626;
            color: white;
        }

        .btn-delete:hover {
            background: #b91c1c;
            color: white;
        }

        /* =========================
            TABLE
        ========================= */

        .table-responsive {
            border-radius: 18px;
            overflow: hidden;
        }

        .table-modern {
            margin-bottom: 0;
        }

        .table-modern thead th {

            background: linear-gradient(135deg,
                    var(--primary),
                    var(--primary-light));

            color: white;
            border: none;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
            padding: 15px;
            font-size: 14px;
            letter-spacing: .3px;
        }

        .table-modern tbody td {
            padding: 15px;
            vertical-align: middle;
        }

        .table-modern tbody tr {
            transition: .25s;
        }

        .table-modern tbody tr:nth-child(even) {
            background: #f8fbff;
        }

        .table-modern tbody tr:hover {
            background: #dbeafe;
            transform: scale(1.002);
        }

        /* =========================
            NUMBER BADGE
        ========================= */

        .number-badge {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;

            background: linear-gradient(135deg,
                    var(--primary),
                    var(--primary-light));

            color: white;
            font-weight: bold;
            box-shadow: 0 5px 15px rgba(15, 23, 42, .2);
        }

        /* =========================
            PAGINATION
        ========================= */

        .pagination {
            justify-content: center;
            margin-top: 25px;
        }

        .page-link {
            color: var(--primary);
            border-radius: 10px !important;
            margin: 0 3px;
            border: 1px solid #dbeafe;
        }

        .page-link:hover {
            background: #dbeafe;
            color: var(--primary);
        }

        .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
        }

        /* =========================
            EMPTY DATA
        ========================= */

        .empty-data {
            padding: 50px;
            text-align: center;
            color: #64748b;
        }

        .empty-data i {
            font-size: 55px;
            margin-bottom: 15px;
            color: #94a3b8;
        }

        /* =========================
            ANIMATION
        ========================= */

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

        /* =========================
            RESPONSIVE
        ========================= */

        @media (max-width:768px) {

            .container-fluid {
                padding-left: 12px;
                padding-right: 12px;
            }

            .asset-header .header-flex {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .asset-header .btn {
                width: 100%;
            }

            .asset-count {
                text-align: center;
            }

            .asset-count .text-end {
                text-align: center !important;
                margin-top: 15px;
            }

            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table-modern {
                min-width: 720px;
            }

            .table-modern th,
            .table-modern td {
                font-size: 13px;
                padding: 10px;
            }

            .btn-action {
                width: 100%;
                display: block;
                margin-bottom: 6px;
            }

            .number-badge {
                width: 34px;
                height: 34px;
                font-size: 13px;
            }

            .asset-count h2 {
                font-size: 32px;
            }
        }
    </style>

    <div class="container-fluid mt-3">


        <div class="asset-count">

            <div class="row align-items-center">

                <div class="col-md-6">

                    <small>Total Asset Terdaftar</small>

                    <h2>{{ $assets->total() }}</h2>

                </div>

                <div class="col-md-6 text-end">

                    <i class="fas fa-truck fa-3x opacity-75"></i>

                </div>

            </div>

        </div>

        <div class="card asset-card">

            <div class="card-header asset-header">

                <div class="d-flex justify-content-between align-items-center header-flex">

                    <h5 class="text-white mb-0">

                        <i class="fas fa-truck me-2"></i>

                        MASTER ASSET

                    </h5>

                    <a href="{{ route('assets.create') }}" class="btn btn-light btn-modern">

                        <i class="fas fa-plus-circle"></i>

                        Tambah Asset

                    </a>

                </div>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover table-modern align-middle">

                        <thead>

                            <tr>

                                <th width="80">No</th>
                                <th>Unit</th>
                                <th>No Lambung</th>
                                <th>Lokasi</th>
                                <th width="220">Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($assets as $asset)
                                <tr>

                                    <td>

                                        <div class="number-badge">

                                            {{ $loop->iteration }}

                                        </div>

                                    </td>

                                    <td>

                                        <strong>{{ $asset->unit }}</strong>

                                    </td>

                                    <td>

                                        {{ $asset->no_lambung }}

                                    </td>

                                    <td>

                                        {{ $asset->lokasi }}

                                    </td>

                                    <td>

                                        <a href="{{ route('assets.edit', $asset->id) }}"
                                            class="btn btn-edit btn-sm btn-modern btn-action">

                                            <i class="fas fa-edit"></i>

                                            Edit

                                        </a>

                                        <form action="{{ route('assets.destroy', $asset->id) }}" method="POST"
                                            style="display:inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                onclick="return confirm('Yakin ingin menghapus asset ini?')"
                                                class="btn btn-delete btn-sm btn-modern btn-action">

                                                <i class="fas fa-trash"></i>

                                                Hapus

                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5" class="text-center py-5">

                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>

                                        <br>

                                        Belum ada data asset

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-4">

                    {{ $assets->links() }}

                </div>

            </div>

        </div>


    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const buttons = document.querySelectorAll('.btn-modern');

            buttons.forEach(btn => {

                btn.addEventListener('mouseenter', function() {

                    this.style.transform = 'translateY(-3px)';

                });

                btn.addEventListener('mouseleave', function() {

                    this.style.transform = 'translateY(0px)';

                });

            });

        });
    </script>
@endsection
