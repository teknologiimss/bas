@extends('layouts.main')

@section('content')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <style>
        :root {
            --primary: #c62828;
            --primary-dark: #8e0000;
            --primary-light: #ffebee;
        }

        body {
            background: #f8f9fa;
        }

        .asset-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 12px 35px rgba(0, 0, 0, .08);
            animation: fadeUp .5s ease;
        }

        .asset-header {
            background: linear-gradient(135deg,
                    var(--primary),
                    var(--primary-dark));
            padding: 20px;
        }

        .asset-header h5 {
            font-weight: 700;
            letter-spacing: .5px;
        }

        .btn-modern {
            border: none;
            border-radius: 12px;
            font-weight: 600;
            transition: .3s;
        }

        .btn-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, .15);
        }

        .table-modern {
            margin-bottom: 0;
        }

        .table-modern thead th {
            background: #c62828;
            color: white;
            text-align: center;
            vertical-align: middle;
            border: none;
            white-space: nowrap;
            padding: 14px;
        }

        .table-modern tbody td {
            vertical-align: middle;
            padding: 14px;
        }

        .table-modern tbody tr {
            transition: .25s;
        }

        .table-modern tbody tr:hover {
            background: #ffebee;
            transform: scale(1.002);
        }

        .number-badge {
            width: 38px;
            height: 38px;
            background: #c62828;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin: auto;
        }

        .btn-edit {
            background: #ff9800;
            color: white;
        }

        .btn-edit:hover {
            background: #f57c00;
            color: white;
        }

        .btn-delete {
            background: #e53935;
            color: white;
        }

        .btn-delete:hover {
            background: #c62828;
            color: white;
        }

        .asset-count {
            background: linear-gradient(135deg,
                    #ef5350,
                    #c62828);
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(198, 40, 40, .25);
        }

        .asset-count h2 {
            margin: 0;
            font-weight: 700;
        }

        .asset-count small {
            opacity: .9;
        }

        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
        }

        .pagination {
            justify-content: center;
            margin-top: 25px;
        }

        .page-link {
            color: #c62828;
            border-radius: 10px !important;
            margin: 0 3px;
        }

        .page-item.active .page-link {
            background: #c62828;
            border-color: #c62828;
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

        /* RESPONSIVE MOBILE */
        @media (max-width: 768px) {

            .container-fluid {
                padding-left: 10px;
                padding-right: 10px;
            }

            /* Header */
            .asset-header .header-flex {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .asset-header .btn {
                width: 100%;
            }

            /* Summary */
            .asset-count {
                text-align: center;
            }

            .asset-count .text-end {
                text-align: center !important;
                margin-top: 10px;
            }

            /* Table Scroll */
            .table-responsive {
                overflow-x: auto;
                overflow-y: hidden;
                -webkit-overflow-scrolling: touch;
                border-radius: 15px;
            }

            .table-modern {
                min-width: 700px;
                white-space: nowrap;
            }

            .table-modern th,
            .table-modern td {
                padding: 10px;
                font-size: 13px;
            }

            /* Tombol aksi */
            .btn-action {
                display: block;
                width: 100%;
                margin-bottom: 5px;
            }

            .number-badge {
                width: 32px;
                height: 32px;
                font-size: 13px;
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
