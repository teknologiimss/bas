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
            --table-border: #cbd5e1;
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

        /* TABLE & GRID STYLING LIKE IMAGE */
        .table-custom-grid {
            margin-bottom: 0;
            width: 100%;
            border-collapse: collapse;
            border: 1px solid var(--table-border);
        }

        .table-custom-grid th,
        .table-custom-grid td {
            vertical-align: middle !important;
            padding: 12px 14px;
            white-space: nowrap;
            border: 1px solid var(--table-border);
        }

        .table-custom-grid thead th {
            background-color: #123057;
            color: white;
            font-size: 13px;
            font-weight: 700;
            text-transform: none;
            letter-spacing: .3px;
        }

        .table-custom-grid tbody tr {
            transition: .25s;
        }

        .table-custom-grid tbody tr:hover {
            background: #eff6ff;
        }

        .table-custom-grid tbody td {
            font-size: 14px;
        }

        /* CHECKBOX COLUMN STYLING */
        .col-checkbox {
            width: 50px;
            text-align: center;
        }

        .table-custom-grid thead th.col-checkbox {
            background-color: #0d2442;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            margin: 0 auto;
            cursor: pointer;
            border: 1.5px solid #94a3b8;
            border-radius: 4px;
            display: inline-block;
            vertical-align: middle;
            position: static; /* Memastikan posisi tidak absolute */
        }

        .form-check-input:checked {
            background-color: var(--accent);
            border-color: var(--accent);
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

        .btn-action {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: .25s;
            color: white !important;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
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

        .btn-mobile-modern {
            height: 34px;
            border-radius: 10px;
            padding: 0 12px;
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

        /* BUTTON VARIANT */
        .btn-danger {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            border: none;
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

        {{-- ALERT MESSAGES --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 14px;">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 14px;">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- HEADER --}}
        <div class="top-card d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <div class="page-title">📋 Data Checksheet</div>
                <p>Monitoring & Management Checksheet Perawatan Unit</p>
            </div>
            <div>
                <a href="{{ route('checksheet.create') }}" class="btn btn-light btn-modern">
                    <i class="fa-solid fa-plus me-1"></i> Buat Checksheet
                </a>
            </div>
        </div>

        {{-- FILTER --}}
        <div class="table-card mb-3">
            <form method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Cari Unit</label>
                        <input type="text" name="unit" value="{{ request('unit') }}" class="form-control"
                            placeholder="Masukkan unit" autocomplete="off">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Cari No Lambung</label>
                        <input type="text" name="no_lambung" value="{{ request('no_lambung') }}" class="form-control"
                            placeholder="Masukkan no lambung" autocomplete="off">
                    </div>

                    <div class="col-md-4 d-flex gap-2">
                        <button class="btn btn-primary btn-modern w-100"
                            style="background: linear-gradient(135deg, #2563eb, #1d4ed8);">
                            <i class="fa-solid fa-search me-1"></i> Cari
                        </button>
                        <a href="{{ route('checksheet.index') }}" class="btn btn-secondary btn-modern w-100 text-center">
                            <i class="fa-solid fa-rotate-left me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- FORM BULK DELETE & TABLE --}}
        <form action="{{ route('checksheet.bulk-destroy') }}" method="POST" id="form-bulk-delete">
            @csrf
            <div class="table-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark m-0"><i class="fa-solid fa-list me-2"></i>Daftar Checksheet</h5>
                    <button type="button" class="btn btn-danger btn-modern" id="btn-delete-selected" style="display: none;"
                        onclick="confirmBulkDelete()">
                        <i class="fa-solid fa-trash me-1"></i> Hapus Terpilih (<span id="selected-count">0</span>)
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom-grid">
                        <thead>
                            <tr>
                                <th class="col-checkbox">
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                </th>
                                <th width="50" class="text-center">NO</th>
                                <th>JUDUL</th>
                                <th>UNIT</th>
                                <th class="text-center">NO LAMBUNG</th>
                                <th class="text-center">TANGGAL</th>
                                <th class="text-center">JENIS</th>
                                <th class="text-center">STATUS PENGISIAN</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $i => $d)
                                <tr>
                                    <td class="col-checkbox">
                                        <input type="checkbox" name="ids[]" value="{{ $d->id }}"
                                            class="form-check-input check-item">
                                    </td>
                                    <td class="text-center fw-bold">{{ $i + 1 }}</td>
                                    <td>
                                        <strong class="text-dark">{{ $d->judul }}</strong>
                                    </td>
                                    <td>{{ $d->unit }}</td>
                                    <td class="text-center">
                                        <span class="badge-modern">
                                            {{ $d->no_lambung }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y') }}
                                    </td>
                                    <td class="text-center">{{ $d->jenis_perawatan ?? '-' }}</td>
                                    <td class="text-center">
                                        @if ($d->is_completed)
                                            <span class="badge-modern badge-success-custom">
                                                <i class="fa-solid fa-circle-check me-1"></i> Lengkap
                                                ({{ $d->filled_details }}/{{ $d->total_details }})
                                            </span>
                                        @else
                                            <span class="badge-modern badge-warning-custom">
                                                <i class="fa-solid fa-hourglass-half me-1"></i> Belum Lengkap
                                                ({{ $d->filled_details }}/{{ $d->total_details }})
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="action-group">
                                            {{-- ISI CHECKSHEET --}}
                                            <a href="{{ route('checksheet.mobile', $d->id) }}" class="btn-mobile-modern">
                                                <i class="fa-solid fa-circle-check"></i> Isi Checksheet
                                            </a>

                                            {{-- DETAIL --}}
                                            <a href="{{ route('checksheet.show', $d->id) }}" class="btn-action btn-view"
                                                title="Detail">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            {{-- EDIT --}}
                                            <a href="{{ route('checksheet.edit', $d->id) }}" class="btn-action btn-edit"
                                                title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            {{-- DUPLICATE --}}
                                            <a href="{{ route('checksheet.duplicate', $d->id) }}"
                                                class="btn-action btn-copy" title="Duplicate">
                                                <i class="fa-solid fa-copy"></i>
                                            </a>

                                            {{-- DELETE SINGLE --}}
                                            <button type="button"
                                                onclick="deleteSingle('{{ route('checksheet.destroy', $d->id) }}')"
                                                class="btn-action btn-delete" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">
                                        <div class="empty-box">
                                            <i class="fa-solid fa-folder-open"></i>
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
        </form>

        {{-- FORM HAPUS SATUAN (HIDDEN) --}}
        <form id="form-delete-single" action="" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.check-item');
            const btnDeleteSelected = document.getElementById('btn-delete-selected');
            const selectedCount = document.getElementById('selected-count');

            function updateDeleteButton() {
                const checkedCount = document.querySelectorAll('.check-item:checked').length;
                selectedCount.textContent = checkedCount;

                if (checkedCount > 0) {
                    btnDeleteSelected.style.display = 'inline-block';
                } else {
                    btnDeleteSelected.style.display = 'none';
                }
            }

            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = this.checked);
                    updateDeleteButton();
                });
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    if (!this.checked && selectAll.checked) {
                        selectAll.checked = false;
                    }
                    updateDeleteButton();
                });
            });
        });

        function confirmBulkDelete() {
            const checkedCount = document.querySelectorAll('.check-item:checked').length;
            if (confirm(`Apakah Anda yakin ingin menghapus ${checkedCount} checksheet yang dipilih?`)) {
                document.getElementById('form-bulk-delete').submit();
            }
        }

        function deleteSingle(url) {
            if (confirm('Apakah Anda yakin ingin menghapus checksheet ini?')) {
                const form = document.getElementById('form-delete-single');
                form.action = url;
                form.submit();
            }
        }
    </script>
@endsection
