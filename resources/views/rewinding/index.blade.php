@extends('layouts.main')

@section('title', 'Monitoring Rewinding')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')

    <style>
        body {
            background: #f7f8fc;
        }

        .card-rewinding {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(11, 31, 58, .10);
        }

        .header-red {
            background: linear-gradient(135deg, #0b1f3a, #102a52);
            color: white;
            padding: 20px;
        }

        .header-red h3 {
            margin: 0;
            font-weight: 600;
        }

        .table thead {
            background: #0b1f3a;
            color: white;
        }

        .table td,
        .table th {
            vertical-align: middle !important;
        }

        .badge-open {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #e8eef7;
            color: #0b1f3a;
            border: 1px solid #cfdcf0;
            padding: 3px 8px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            line-height: 1;
        }

        .badge-closed {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #e6f4ec;
            color: #1f7a4d;
            border: 1px solid #bfe6d0;
            padding: 3px 8px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            line-height: 1;
        }

        .animate-card {
            animation: slideUp .6s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .empty-state {
            padding: 60px 20px;
        }

        .empty-state i {
            color: #0b1f3a;
            opacity: .4;
        }

        .table-hover tbody tr:hover {
            background: #eef4ff;
            transition: 0.3s;
        }

        .action-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }

        .action-group .btn {
            width: 38px;
            height: 38px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search-box .form-control {
            border-radius: 12px 0 0 12px;
        }

        .search-box .btn {
            border-radius: 0;
            background: #0b1f3a;
            color: #fff;
            border: none;
        }

        .search-box .btn:last-child {
            border-radius: 0 12px 12px 0;
        }

        .search-box .btn:hover {
            background: #102a52;
        }

        .btn-primary,
        .btn-danger,
        .btn-warning,
        .btn-info {
            background: #0b1f3a !important;
            border: none !important;
            color: #fff !important;
        }

        .btn-primary:hover,
        .btn-danger:hover,
        .btn-warning:hover,
        .btn-info:hover {
            background: #102a52 !important;
        }

        .btn-secondary {
            background: #6b7280;
            border: none;
        }

        /* PERBAIKAN STYLING CHECKBOX */
        .col-checkbox {
            width: 45px !important;
            text-align: center !important;
            vertical-align: middle !important;
        }

        .table .form-check-input {
            position: static !important;
            margin: 0 auto !important;
            display: block !important;
            width: 18px !important;
            height: 18px !important;
            cursor: pointer;
        }

        @media(max-width:768px) {
            .header-red {
                padding: 15px;
            }

            .header-red h3 {
                font-size: 18px;
            }

            .table-responsive {
                font-size: 12px;
            }
        }
    </style>

    <div class="card card-rewinding animate-card">
        <div class="header-red">
            <div class="d-flex justify-content-between align-items-center">
                <h3>
                    <i class="fas fa-sync-alt"></i>
                    Monitoring Rewinding
                </h3>

                <a href="{{ route('rewinding.create', $folder->id) }}" class="btn btn-light">
                    <i class="fas fa-plus"></i> Tambah
                </a>
            </div>
        </div>

        <div class="card-body">
            {{-- Search & Bulk Actions --}}
            <div class="row mb-3 align-items-center">
                <div class="col-md-6 mb-2 mb-md-0">
                    <form method="GET" action="{{ route('rewinding.monitor', $folder->id) }}" class="search-box">
                        <div class="input-group">
                            <input type="text" name="search" autocomplete="off" class="form-control"
                                placeholder="Cari No SJN / Deskripsi / No SPPJP..." value="{{ request('search') }}">

                            <div class="input-group-append">
                                <button class="btn btn-danger" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>

                                @if (request('search'))
                                    <a href="{{ route('rewinding.monitor', $folder->id) }}" class="btn btn-secondary">
                                        <i class="fas fa-sync"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-6 text-md-right">
                    <button type="button" class="btn btn-danger" id="btn-delete-selected" style="display: none;"
                        onclick="confirmBulkDelete()">
                        <i class="fas fa-trash me-1"></i> Hapus Terpilih (<span id="selected-count">0</span>)
                    </button>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    {{ session('error') }}
                </div>
            @endif

            {{-- FORM BULK DELETE --}}
            <form action="{{ route('rewinding.bulk-destroy') }}" method="POST" id="form-bulk-delete">
                @csrf
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="col-checkbox text-center">
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                </th>
                                <th class="text-center">No</th>
                                <th>No SJN</th>
                                <th>Tgl SJN Keluar</th>
                                <th>Lampiran Keluar</th>
                                <th>Tgl SJN Masuk</th>
                                <th>Lampiran Masuk</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>No SPPJP</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <td class="col-checkbox text-center">
                                        <input type="checkbox" name="ids[]" value="{{ $item->id }}"
                                            class="form-check-input check-item">
                                    </td>
                                    <td class="text-center">
                                        {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                                    </td>
                                    <td>{{ $item->no_sjn }}</td>
                                    <td>
                                        {{ $item->tanggal_sjn_keluar ? \Carbon\Carbon::parse($item->tanggal_sjn_keluar)->format('d-m-Y') : '-' }}
                                    </td>
                                    <td>
                                        @if ($item->lampiran_sjn_keluar)
                                            <a href="{{ asset($item->lampiran_sjn_keluar) }}" target="_blank"
                                                class="btn btn-success btn-sm">
                                                View
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        {{ $item->tanggal_sjn_masuk ? \Carbon\Carbon::parse($item->tanggal_sjn_masuk)->format('d-m-Y') : '-' }}
                                    </td>
                                    <td>
                                        @if ($item->lampiran_sjn_masuk)
                                            <a href="{{ asset($item->lampiran_sjn_masuk) }}" target="_blank"
                                                class="btn btn-primary btn-sm">
                                                View
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $item->deskripsi }}</td>
                                    <td>
                                        @if ($item->status == 'Open')
                                            <span class="badge-open">OPEN</span>
                                        @else
                                            <span class="badge-closed">CLOSED</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>{{ $item->no_sppjp }}</td>
                                    <td>
                                        <div class="action-group">
                                            <a href="{{ route('rewinding.detail', $item->id) }}"
                                                class="btn btn-info btn-sm" title="Detail">
                                                <i class="fas fa-list"></i>
                                            </a>

                                            <a href="{{ route('rewinding.edit', $item->id) }}"
                                                class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <button type="button" class="btn btn-danger btn-sm" title="Hapus"
                                                onclick="deleteSingle('{{ route('rewinding.destroy', $item->id) }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12">
                                        <div class="empty-state text-center">
                                            <i class="fas fa-folder-open fa-5x mb-3"></i>
                                            <h4 class="text-muted">Tidak Ada Data</h4>
                                            <p class="text-muted">Belum ada data Monitoring Rewinding yang tersimpan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>

            @if ($data->count())
                <div class="mt-3">
                    {{ $data->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Form Single Delete --}}
    <form id="form-single-delete" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

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
            if (confirm(`Apakah Anda yakin ingin menghapus ${checkedCount} data rewinding yang dipilih?`)) {
                document.getElementById('form-bulk-delete').submit();
            }
        }

        function deleteSingle(url) {
            if (confirm('Yakin ingin menghapus data ini?')) {
                const form = document.getElementById('form-single-delete');
                form.action = url;
                form.submit();
            }
        }
    </script>

@endsection
