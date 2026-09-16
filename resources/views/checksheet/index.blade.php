@extends('layouts.main')

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    {{-- FONT AWESOME --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #0f172a;
            --primary-dark: #020617;
            --primary-light: #e0f2fe;
            --secondary: #1e3a8a;
            --accent: #2563eb;
            --info: #38bdf8;
            --success: #16a34a;
            --danger: #dc2626;
            --warning: #f59e0b;
        }

        body {
            background: #eef4fb;
            font-family: 'Segoe UI', sans-serif;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #fff;
        }

        /* HEADER */

        .top-card {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 24px;
            padding: 24px;
            color: white;
            box-shadow: 0 12px 30px rgba(15, 23, 42, .25);
            animation: fadeDown .5s ease;
        }

        .top-card p {
            margin-bottom: 0;
            opacity: .9;
        }

        /* BUTTON */

        .btn-modern {
            border: none;
            border-radius: 14px;
            padding: 11px 18px;
            font-weight: 600;
            transition: .25s;
            margin-left: 4px;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(37, 99, 235, .25);
        }

        /* TABLE CARD */

        .table-card {
            background: white;
            border-radius: 24px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, .08);
            animation: fadeUp .5s ease;
        }

        /* TABLE */

        .table {
            margin-bottom: 0;
            width: 100%;
        }

        .table thead th {
            background: #0f172a;
            color: white;
            border: none;
            padding: 15px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .4px;
            white-space: nowrap;
        }

        .table tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: .25s;
        }

        .table tbody tr:hover {
            background: #eff6ff;
        }

        .table tbody td {
            border: none;
            padding: 16px 12px;
            vertical-align: middle;
            font-size: 14px;
            white-space: nowrap;
        }

        /* BADGE */

        .badge-modern {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 14px;
            border-radius: 999px;
            background: #dbeafe;
            color: #1e3a8a;
            font-weight: 600;
            font-size: 12px;
            line-height: 1.2;
            white-space: nowrap;
        }

        .badge-success-custom {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .badge-warning-custom {
            background: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        /* ACTION GROUP & BUTTONS */

        .action-group {
            display: flex;
            gap: 6px;
            justify-content: center;
            align-items: center;
            flex-wrap: nowrap;
        }

        .form-delete-inline {
            display: inline-block;
            margin: 0;
            padding: 0;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: .25s;
            color: white !important;
            font-size: 14px;
            text-decoration: none;
            cursor: pointer;
            box-sizing: border-box;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .btn-view {
            background: #0ea5e9;
        }

        .btn-view:hover {
            background: #0284c7;
        }

        .btn-edit {
            background: #2563eb;
        }

        .btn-edit:hover {
            background: #1d4ed8;
        }

        .btn-copy {
            background: #f59e0b;
        }

        .btn-copy:hover {
            background: #d97706;
        }

        .btn-delete {
            background: #dc2626;
        }

        .btn-delete:hover {
            background: #b91c1c;
        }

        /* BUTTON ISI */

        .btn-mobile-modern {
            height: 36px;
            border-radius: 10px;
            padding: 0 14px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            border: none;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white !important;
            text-decoration: none;
            transition: .25s;
            white-space: nowrap;
            box-sizing: border-box;
        }

        .btn-mobile-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, .35);
        }

        /* FORM CONTROL */

        .form-control {
            border-radius: 12px;
            border: 2px solid #dbeafe;
            height: 46px;
            transition: .25s;
            box-shadow: none !important;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 .25rem rgba(37, 99, 235, .15) !important;
        }

        .form-label {
            color: #334155;
            font-weight: 600;
        }

        /* SEARCH BUTTON */

        .btn-danger {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
        }

        .btn-danger:hover {
            background: #1e40af;
        }

        .btn-secondary {
            background: #64748b;
            border: none;
        }

        .btn-secondary:hover {
            background: #475569;
        }

        /* EMPTY */

        .empty-box {
            text-align: center;
            padding: 55px 20px;
            color: #64748b;
        }

        .empty-box i {
            font-size: 60px;
            color: #94a3b8;
            margin-bottom: 15px;
        }

        /* ANIMATION */

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

        /* MOBILE RESPONSIVE */

        @media(max-width:768px) {
            body {
                font-size: 13px;
            }

            .container {
                padding-left: 10px;
                padding-right: 10px;
            }

            .page-title {
                font-size: 21px;
            }

            .top-card {
                padding: 18px;
                border-radius: 18px;
            }

            .top-card p {
                font-size: 12px;
            }

            .btn-modern {
                width: 100%;
                text-align: center;
                padding: 10px 14px;
                font-size: 13px;
            }

            .table-card {
                border-radius: 18px;
                padding: 14px;
            }

            .form-control {
                font-size: 13px;
                height: 42px;
            }

            .table-responsive {
                overflow-x: auto;
                border-radius: 14px;
            }
        }
    </style>

    <div class="container py-4">

        {{-- HEADER --}}
        <div class="top-card d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <div class="page-title">
                    📋 Data Checksheet
                </div>
                <p>
                    Monitoring & Management Checksheet Perawatan Unit
                </p>
            </div>
            <div>
                <a href="{{ route('checksheet.create') }}" class="btn btn-light btn-modern">
                    <i class="fa fa-plus me-1"></i>
                    Buat Checksheet
                </a>
            </div>
        </div>

        {{-- FILTER --}}
        <div class="table-card mb-3">
            <form method="GET">
                <div class="row g-3 align-items-end">

                    {{-- UNIT --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            Cari Unit
                        </label>
                        <input type="text" name="unit" value="{{ request('unit') }}" class="form-control"
                            placeholder="Masukkan unit" autocomplete="off">
                    </div>

                    {{-- NO LAMBUNG --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            Cari No Lambung
                        </label>
                        <input type="text" name="no_lambung" value="{{ request('no_lambung') }}" class="form-control"
                            placeholder="Masukkan no lambung" autocomplete="off">
                    </div>

                    {{-- BUTTON --}}
                    <div class="col-md-4 d-flex gap-2">
                        <button class="btn btn-danger btn-modern w-100">
                            <i class="fa fa-search me-1"></i>
                            Cari
                        </button>
                        <a href="{{ route('checksheet.index') }}" class="btn btn-secondary btn-modern w-100 text-center">
                            <i class="fa fa-rotate-left me-1"></i>
                            Reset
                        </a>
                    </div>

                </div>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="table-card">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th>Judul</th>
                            <th>Unit</th>
                            <th>No Lambung</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th class="text-center">Status Pengisian</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $i => $d)
                            <tr>
                                <td class="text-center">
                                    <strong>{{ $i + 1 }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $d->judul }}</strong>
                                </td>
                                <td>{{ $d->unit }}</td>
                                <td>
                                    <span class="badge-modern">
                                        {{ $d->no_lambung }}
                                    </span>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y') }}
                                </td>
                                <td>{{ $d->jenis_perawatan ?? '-' }}</td>
                                <td class="text-center">
                                    @if ($d->is_completed)
                                        <span class="badge-modern badge-success-custom">
                                            <i class="fa fa-circle-check me-1"></i> Lengkap
                                            ({{ $d->filled_details }}/{{ $d->total_details }})
                                        </span>
                                    @else
                                        <span class="badge-modern badge-warning-custom">
                                            <i class="fa fa-hourglass-half me-1"></i> Belum Lengkap
                                            ({{ $d->filled_details }}/{{ $d->total_details }})
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-group">
                                        {{-- ISI CHECKSHEET --}}
                                        <a href="{{ route('checksheet.mobile', $d->id) }}" class="btn-mobile-modern">
                                            <i class="fa fa-circle-check"></i>
                                            Isi Checksheet
                                        </a>

                                        {{-- DETAIL --}}
                                        <a href="{{ route('checksheet.show', $d->id) }}" class="btn-action btn-view"
                                            title="Detail">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        {{-- EDIT --}}
                                        <a href="{{ route('checksheet.edit', $d->id) }}" class="btn-action btn-edit"
                                            title="Edit">
                                            <i class="fa fa-pen"></i>
                                        </a>

                                        {{-- DUPLICATE --}}
                                        <a href="{{ route('checksheet.duplicate', $d->id) }}" class="btn-action btn-copy"
                                            title="Duplicate">
                                            <i class="fa fa-copy"></i>
                                        </a>

                                        {{-- DELETE --}}
                                        <form action="{{ route('checksheet.destroy', $d->id) }}" method="POST"
                                            class="form-delete-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus checksheet ini?')"
                                                class="btn-action btn-delete" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-box">
                                        <i class="fa fa-folder-open"></i>
                                        <h5>Tidak ada data checksheet</h5>
                                        <p>Silakan buat checksheet baru terlebih dahulu.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
