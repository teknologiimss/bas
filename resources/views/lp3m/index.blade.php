@extends('layouts.main')

@section('title', 'Lembar Pekerjaan Perbaikan Perawatan Fasilitas')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')
    <style>
        :root {
            --navy: #0f172a;
            --navy2: #1e3a8a;
            --navy3: #2563eb;
            --bg: #edf4fb;
            --border: #d8e3f0;
            --shadow: 0 8px 25px rgba(15, 23, 42, .08);
        }

        body {
            background: var(--bg);
            font-family: 'Segoe UI', sans-serif;
        }

        /* MODERN TOAST NOTIFICATION */
        .lp3m-toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 420px;
            width: calc(100% - 40px);
            pointer-events: none;
        }

        .lp3m-toast {
            pointer-events: auto;
            position: relative;
            display: flex;
            align-items: center;
            gap: 14px;
            background: #08182b;
            color: #f8fafc;
            border-radius: 14px;
            padding: 14px 16px 14px 20px;
            box-shadow: 0 14px 32px rgba(2, 6, 23, 0.35);
            overflow: hidden;
            opacity: 0;
            transform: translateX(28px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .lp3m-toast.show {
            opacity: 1;
            transform: translateX(0);
        }

        .lp3m-toast.hide {
            opacity: 0;
            transform: translateX(28px);
        }

        .lp3m-toast::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 6px;
            background: #10b981;
        }

        .lp3m-toast.toast-error::before {
            background: #ef4444;
        }

        .lp3m-toast-icon {
            flex-shrink: 0;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(16, 185, 129, 0.16);
            color: #22c55e;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .lp3m-toast.toast-error .lp3m-toast-icon {
            background: rgba(239, 68, 68, 0.18);
            color: #f87171;
        }

        .lp3m-toast-content {
            flex: 1;
            min-width: 0;
        }

        .lp3m-toast-title {
            font-size: 15px;
            font-weight: 700;
            line-height: 1.25;
            color: #ffffff;
            margin-bottom: 2px;
        }

        .lp3m-toast-message {
            font-size: 13px;
            line-height: 1.35;
            color: #cbd5e1;
            word-break: break-word;
        }

        .lp3m-toast-close {
            background: transparent;
            border: none;
            color: #94a3b8;
            font-size: 20px;
            line-height: 1;
            padding: 4px 6px;
            cursor: pointer;
            border-radius: 6px;
            transition: color 0.2s ease, background 0.2s ease;
        }

        .lp3m-toast-close:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }

        .header-title {
            font-size: 18px;
            font-weight: 700;
            line-height: 1.4;
            color: #fff;
        }

        /* CARD STYLE */
        .card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .card-header {
            background: linear-gradient(135deg, var(--navy), var(--navy2)) !important;
            border: none;
            padding: 18px 22px;
        }

        .card-body {
            background: #fff;
        }

        /* BUTTON STYLE */
        .btn {
            border-radius: 10px;
            font-weight: 600;
            transition: .25s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: var(--navy2);
            border-color: var(--navy2);
        }

        .btn-primary:hover {
            background: var(--navy);
            border-color: var(--navy);
        }

        .btn-danger {
            background: #dc2626;
            border-color: #dc2626;
        }

        .btn-secondary {
            background: #334155;
            border-color: #334155;
        }

        .btn-info {
            background: #0284c7;
            border-color: #0284c7;
            color: #fff;
        }

        .btn-warning {
            background: #f59e0b;
            border-color: #f59e0b;
            color: #fff;
        }

        .btn-dark {
            background: var(--navy);
            border-color: var(--navy);
        }

        /* ACTION BUTTON */
        .btn-action {
            width: 100px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 10px;
            transition: .25s;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(15, 23, 42, .18);
        }

        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        /* FORM CONTROL */
        .form-control {
            border-radius: 10px;
            border: 1px solid var(--border);
            height: 42px;
        }

        .form-control:focus {
            border-color: var(--navy2);
            box-shadow: 0 0 0 .15rem rgba(37, 99, 235, .15);
        }

        /* TABLE */
        .table {
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 0;
        }

        .table thead {
            background: #eaf2ff;
        }

        .table thead th {
            border: none;
            color: var(--navy);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .3px;
            padding: 14px;
        }

        .table tbody td {
            vertical-align: middle !important;
            padding: 14px;
            border-color: #edf2f7;
        }

        .table-hover tbody tr:hover {
            background: #f8fbff;
        }

        /* CHECKBOX STYLING FIXED */
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

        /* BADGE */
        .badge-danger {
            background: #dc2626;
            color: #fff;
            padding: 7px 12px;
            border-radius: 30px;
        }

        .badge-success {
            background: #2563eb;
            color: #fff;
            padding: 7px 12px;
            border-radius: 30px;
        }

        /* FILE CARD */
        .file-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .file-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 10px 12px;
            transition: .2s;
        }

        .file-card:hover {
            box-shadow: 0 6px 16px rgba(15, 23, 42, .08);
        }

        .file-name {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--navy);
            word-break: break-word;
        }

        .file-actions {
            display: flex;
            gap: 6px;
            margin-top: 8px;
        }

        .btn-file {
            height: 30px;
            min-width: 72px;
            border-radius: 8px;
            font-size: 11.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 0 10px;
        }

        .selected-files-preview {
            margin-top: 10px;
            padding: 8px 12px;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 10px;
            font-size: 12px;
            color: #334155;
            display: none;
        }

        /* DASHBOARD STYLES */
        .stat-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: var(--shadow);
            transition: .3s;
            height: 100%;
            display: block;
            text-decoration: none;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(15, 23, 42, .15);
        }

        .stat-value {
            font-size: 28px;
            font-weight: bold;
            color: var(--navy2);
        }

        .stat-title {
            font-size: 13px;
            color: #64748b;
        }

        .scroll-table {
            max-height: 280px;
            overflow-y: auto;
        }

        /* RESPONSIVE */
        @media(max-width:768px) {
            .lp3m-toast-container {
                top: 14px;
                right: 14px;
                left: 14px;
                width: auto;
                max-width: none;
            }

            .header-title {
                font-size: 15px;
            }

            .header-actions {
                width: 100%;
            }

            .header-actions .btn {
                flex: 1;
            }

            .btn-action {
                width: 82px;
                height: 34px;
                font-size: 10px;
                padding: 4px;
            }

            .btn-action i {
                font-size: 10px;
            }

            .action-buttons {
                gap: 4px;
            }

            td {
                vertical-align: middle !important;
            }

            .table {
                min-width: 1100px;
            }

            .file-card {
                min-width: 220px;
            }

            .btn-file {
                min-width: 68px;
                font-size: 11px;
            }
        }
    </style>

    @php
        $extractLampiran = function ($lampiran): array {
            if (empty($lampiran)) {
                return [];
            }
            if (is_array($lampiran)) {
                return array_values(array_filter($lampiran));
            }
            $decoded = json_decode($lampiran, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return array_values(array_filter($decoded));
            }
            return [(string) $lampiran];
        };
    @endphp

    {{-- TOAST NOTIFICATION CONTAINER --}}
    @if (session('success') || session('error') || $errors->any())
        <div class="lp3m-toast-container" id="lp3mToastContainer">
            @if (session('success'))
                <div class="lp3m-toast toast-success" role="alert" data-timeout="3000">
                    <div class="lp3m-toast-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="lp3m-toast-content">
                        <div class="lp3m-toast-title">Berhasil</div>
                        <div class="lp3m-toast-message">{{ session('success') }}</div>
                    </div>
                    <button type="button" class="lp3m-toast-close" aria-label="Tutup">&times;</button>
                </div>
            @endif

            @if (session('error'))
                <div class="lp3m-toast toast-error" role="alert" data-timeout="3000">
                    <div class="lp3m-toast-icon">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="lp3m-toast-content">
                        <div class="lp3m-toast-title">Gagal</div>
                        <div class="lp3m-toast-message">{{ session('error') }}</div>
                    </div>
                    <button type="button" class="lp3m-toast-close" aria-label="Tutup">&times;</button>
                </div>
            @endif

            @if ($errors->any())
                <div class="lp3m-toast toast-error" role="alert" data-timeout="3000">
                    <div class="lp3m-toast-icon">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="lp3m-toast-content">
                        <div class="lp3m-toast-title">Gagal</div>
                        <div class="lp3m-toast-message">{{ $errors->first() }}</div>
                    </div>
                    <button type="button" class="lp3m-toast-close" aria-label="Tutup">&times;</button>
                </div>
            @endif
        </div>
    @endif

    <div class="container-fluid mt-3">

        <div class="card shadow-sm border-0 mb-4">
            {{-- HEADER BAR --}}
            <div
                class="card-header bg-danger text-white d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                <h5 class="mb-0 d-flex align-items-center flex-wrap">
                    <i class="fas fa-tools me-2"></i>
                    <span class="header-title">Data Pekerjaan Perbaikan Perawatan Fasilitas</span>
                </h5>

                {{-- TOMBOL DI POJOK KANAN --}}
                <div class="d-flex gap-2 align-items-center ms-auto header-actions">
                    <button type="button" class="btn btn-warning btn-sm text-white fw-bold" id="btn-delete-selected"
                        style="display: none;" onclick="confirmBulkDelete()">
                        <i class="fas fa-trash me-1"></i> Hapus Terpilih (<span id="selected-count">0</span>)
                    </button>

                    <button class="btn btn-info btn-sm text-light fw-bold" type="button" data-bs-toggle="collapse"
                        data-bs-target="#dashboardCollapse" aria-expanded="false" id="btnToggleDashboard">
                        <i class="fas fa-chart-line me-1"></i> Lihat Dashboard
                    </button>

                    <a href="{{ route('lp3m.create') }}" class="btn btn-secondary btn-sm text-light fw-bold">
                        <i class="fas fa-plus me-1"></i> Buat Data Baru
                    </a>
                </div>
            </div>

            {{-- SECTION DASHBOARD COLLAPSIBLE --}}
            <div class="collapse" id="dashboardCollapse">
                <div class="card-body bg-light border-bottom p-4">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('lp3m.spr.list') }}" class="stat-card">
                                <i class="fas fa-database fa-2x text-primary mb-2"></i>
                                <div class="stat-value">{{ $total }}</div>
                                <div class="stat-title">Total Data LP3M</div>
                            </a>
                        </div>

                        <div class="col-md-3 mb-3">
                            <a href="{{ route('lp3m.spr.list', ['status' => 'OPEN']) }}" class="stat-card">
                                <i class="fas fa-folder-open fa-2x text-danger mb-2"></i>
                                <div class="stat-value text-danger">{{ $open }}</div>
                                <div class="stat-title">Status Open</div>
                            </a>
                        </div>

                        <div class="col-md-3 mb-3">
                            <a href="{{ route('lp3m.spr.list', ['status' => 'CLOSED']) }}" class="stat-card">
                                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                <div class="stat-value text-success">{{ $closed }}</div>
                                <div class="stat-title">Status Closed</div>
                            </a>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="stat-card">
                                <i class="fas fa-chart-pie fa-2x text-info mb-2"></i>
                                <div class="stat-value text-info">{{ $progress }}%</div>
                                <div class="stat-title">Tingkat Penyelesaian</div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 border">
                                <div class="card-header bg-dark text-white fw-bold py-2">
                                    <i class="fas fa-chart-pie me-1"></i> Grafik Status
                                </div>
                                <div class="card-body d-flex align-items-center justify-content-center p-2">
                                    <div style="width: 100%; height: 220px;">
                                        <canvas id="sprChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8 mb-3">
                            <div class="card h-100 border">
                                <div
                                    class="card-header bg-dark text-white fw-bold py-2 d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-exclamation-circle me-1"></i> Daftar LP3M Status OPEN</span>
                                    <a href="{{ route('lp3m.spr.list', ['status' => 'OPEN']) }}"
                                        class="badge bg-danger text-white text-decoration-none">
                                        {{ $openData->count() }} Items (Lihat Semua)
                                    </a>
                                </div>
                                <div class="card-body p-0">
                                    <div class="scroll-table">
                                        <table class="table table-striped table-sm mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No. SPR</th>
                                                    <th>Deskripsi</th>
                                                    <th>Status</th>
                                                    <th>Durasi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($openData as $item)
                                                    <tr>
                                                        <td>{{ $item->spr_no ?? '-' }}</td>
                                                        <td>{{ Str::limit($item->deskripsi, 40) }}</td>
                                                        <td><span class="badge badge-danger">OPEN</span></td>
                                                        <td>{{ $item->created_at->diffInDays(now()) }} Hari</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center py-3">Tidak ada pekerjaan
                                                            berpilihan OPEN</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BODY UTAMA DATA INDEX --}}
            <div class="card-body">

                {{-- SEARCH --}}
                <form action="{{ route('lp3m.index') }}" method="GET" class="mb-3">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-4 col-12">
                            <label class="form-label fw-bold">Cari Deskripsi</label>
                            <input type="text" name="search" class="form-control" autocomplete="off"
                                placeholder="Masukkan deskripsi..." value="{{ request('search') }}">
                        </div>

                        <div class="col-md-3 col-12">
                            <label class="form-label fw-bold">Cari No. SPR</label>
                            <input type="text" name="spr_no" class="form-control" autocomplete="off"
                                placeholder="Masukkan No SPR..." value="{{ request('spr_no') }}">
                        </div>

                        <div class="col-md-2 col-12 d-grid gap-1">
                            <button type="submit" class="btn btn-danger fw-bold">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            <a href="{{ route('lp3m.index') }}" class="btn btn-secondary fw-bold">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>

                {{-- FORM BULK DELETE --}}
                <form action="{{ route('lp3m.bulk-destroy') }}" method="POST" id="form-bulk-delete">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th class="col-checkbox text-center">
                                        <input type="checkbox" id="select-all" class="form-check-input">
                                    </th>
                                    <th class="text-center">No</th>
                                    <th>No. SPR</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal</th>
                                    <th>Lampiran</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($data as $d)
                                    @php
                                        $lampiranList = $extractLampiran($d->lampiran);
                                    @endphp
                                    <tr>
                                        <td class="col-checkbox text-center">
                                            <input type="checkbox" name="ids[]" value="{{ $d->id }}"
                                                class="form-check-input check-item">
                                        </td>
                                        <td class="text-center">
                                            {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                                        </td>
                                        <td>
                                            @if ($d->spr_no)
                                                <span>{{ $d->spr_no }}</span>
                                            @else
                                                <span class="text-muted">Belum Ada</span>
                                            @endif
                                        </td>
                                        <td>{{ $d->deskripsi }}</td>
                                        <td>
                                            @if ($d->status == 'OPEN')
                                                <span class="badge badge-danger">OPEN</span>
                                            @else
                                                <span class="badge badge-success">CLOSED</span>
                                            @endif
                                        </td>
                                        <td>{{ $d->keterangan }}</td>
                                        <td>{{ date('d-m-Y H:i', strtotime($d->created_at)) }}</td>
                                        <td style="min-width:290px">
                                            @if (count($lampiranList) > 0)
                                                <div class="file-list">
                                                    @foreach ($lampiranList as $fileItem)
                                                        @php
                                                            $baseItem = basename($fileItem);
                                                            $namaFile = preg_replace(
                                                                '/^\d+_\d+_[A-Za-z0-9]+_/',
                                                                '',
                                                                $baseItem,
                                                            );
                                                            if ($namaFile === $baseItem) {
                                                                $namaFile = preg_replace('/^\d+_/', '', $baseItem);
                                                            }
                                                            $ext = strtoupper(pathinfo($baseItem, PATHINFO_EXTENSION));
                                                        @endphp

                                                        <div class="file-card">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="me-2">
                                                                    <div class="file-name">
                                                                        <i class="fas fa-file-alt text-primary me-1"></i>
                                                                        {{ $namaFile }}
                                                                    </div>
                                                                    <span
                                                                        class="badge bg-light text-dark border mt-1">{{ $ext ?: 'FILE' }}</span>
                                                                </div>
                                                            </div>

                                                            <div class="file-actions">
                                                                <a href="{{ asset('lampiran/' . $baseItem) }}"
                                                                    target="_blank" class="btn btn-success btn-file">
                                                                    <i class="fas fa-eye"></i> Lihat
                                                                </a>

                                                                <button type="button"
                                                                    class="btn btn-outline-danger btn-file"
                                                                    onclick="deleteSingleLampiran('{{ route('lp3m.deleteLampiran', $d->id) }}', '{{ $baseItem }}', '{{ addslashes($namaFile) }}')">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="badge bg-secondary">Tidak Ada Lampiran</span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="d-flex flex-wrap action-buttons justify-content-center">
                                                <a href="{{ route('lp3m.form', $d->id) }}"
                                                    class="btn btn-primary btn-action">
                                                    <i class="fas fa-file-alt"></i> Form
                                                </a>

                                                <a href="{{ route('lp3m.edit', $d->id) }}"
                                                    class="btn btn-warning btn-action">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>

                                                <a href="{{ route('lp3m.show', $d->id) }}"
                                                    class="btn btn-info btn-action">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>

                                                <button type="button" class="btn btn-secondary btn-action btn-upload"
                                                    data-id="{{ $d->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#uploadLampiranModal">
                                                    <i class="fas fa-upload"></i> Upload
                                                </button>

                                                <a href="{{ route('lp3m.print', $d->id) }}"
                                                    class="btn btn-dark btn-action">
                                                    <i class="fas fa-print"></i> Print
                                                </a>

                                                <button type="button" class="btn btn-danger btn-action"
                                                    onclick="deleteSingle('{{ route('lp3m.destroy', $d->id) }}')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-3">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </form>

                {{-- Pagination --}}
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    {{ $data->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Form Single Delete Data --}}
    <form id="form-single-delete" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    {{-- Form Single Delete Lampiran --}}
    <form id="form-single-delete-lampiran" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
        <input type="hidden" name="file" id="delete_lampiran_file">
    </form>

    {{-- Modal Lampiran (Multiple) --}}
    <div class="modal fade" id="uploadLampiranModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('lp3m.uploadLampiran') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="lampiran_id">

                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Upload Lampiran (Bisa Lebih dari 1)</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <label class="fw-bold">Pilih File (Bisa pilih banyak file sekaligus)</label>
                        <input type="file" name="lampiran[]" id="lampiranInput" class="form-control"
                            accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" multiple required>
                        <small class="text-muted"><b>(MAKSIMAL 3 lampiran)</b> PDF, JPG, JPEG, PNG, DOC, DOCX • Maks. 50MB per file</small>

                        <div class="selected-files-preview" id="selectedFilesPreview"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-upload me-1"></i> Upload Semua
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-dismiss Toast Notification setelah 3 detik
            document.querySelectorAll('.lp3m-toast').forEach(function(toast) {
                requestAnimationFrame(() => {
                    toast.classList.add('show');
                });

                const timeout = parseInt(toast.dataset.timeout || '3000', 10);
                let dismissed = false;

                const dismissToast = () => {
                    if (dismissed) return;
                    dismissed = true;
                    toast.classList.remove('show');
                    toast.classList.add('hide');
                    setTimeout(() => {
                        toast.remove();
                        const container = document.getElementById('lp3mToastContainer');
                        if (container && container.children.length === 0) {
                            container.remove();
                        }
                    }, 300);
                };

                const timer = setTimeout(dismissToast, timeout);

                const closeBtn = toast.querySelector('.lp3m-toast-close');
                if (closeBtn) {
                    closeBtn.addEventListener('click', function() {
                        clearTimeout(timer);
                        dismissToast();
                    });
                }
            });

            // Checkbox Handler untuk Bulk Delete
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

            // Set ID Lampiran Modal & Reset Preview
            const lampiranInput = document.getElementById('lampiranInput');
            const selectedFilesPreview = document.getElementById('selectedFilesPreview');

            document.querySelectorAll('.btn-upload').forEach(function(button) {
                button.addEventListener('click', function() {
                    document.getElementById('lampiran_id').value = this.dataset.id;
                    if (lampiranInput) {
                        lampiranInput.value = '';
                    }
                    if (selectedFilesPreview) {
                        selectedFilesPreview.style.display = 'none';
                        selectedFilesPreview.innerHTML = '';
                    }
                });
            });

            if (lampiranInput && selectedFilesPreview) {
                lampiranInput.addEventListener('change', function() {
                    const files = Array.from(this.files || []);
                    if (files.length === 0) {
                        selectedFilesPreview.style.display = 'none';
                        selectedFilesPreview.innerHTML = '';
                        return;
                    }

                    const items = files.map((f, idx) => {
                        const sizeKb = (f.size / 1024).toFixed(1);
                        return `<div>${idx + 1}. <strong>${f.name}</strong> <span class="text-muted">(${sizeKb} KB)</span></div>`;
                    }).join('');

                    selectedFilesPreview.innerHTML =
                        `<div class="fw-bold mb-1">File dipilih (${files.length}):</div>${items}`;
                    selectedFilesPreview.style.display = 'block';
                });
            }

            // Toggle Teks Tombol Dashboard
            const dashCollapse = document.getElementById('dashboardCollapse');
            const btnToggle = document.getElementById('btnToggleDashboard');

            if (dashCollapse && btnToggle) {
                dashCollapse.addEventListener('shown.bs.collapse', function() {
                    btnToggle.innerHTML = '<i class="fas fa-eye-slash me-1"></i> Sembunyikan Dashboard';
                });

                dashCollapse.addEventListener('hidden.bs.collapse', function() {
                    btnToggle.innerHTML = '<i class="fas fa-chart-line me-1"></i> Lihat Dashboard';
                });
            }

            // Chart Configuration & Click Handler
            const ctx = document.getElementById('sprChart');
            if (ctx) {
                const sprChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Open', 'Closed'],
                        datasets: [{
                            data: [{{ $open }}, {{ $closed }}],
                            backgroundColor: ['#dc2626', '#2563eb']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                        onClick: (evt, activeElements) => {
                            if (activeElements.length > 0) {
                                const index = activeElements[0].index;
                                const status = index === 0 ? 'OPEN' : 'CLOSED';
                                window.location.href = "{{ route('lp3m.spr.list') }}?status=" + status;
                            }
                        }
                    }
                });
            }
        });

        // Function Confirm Bulk Delete
        function confirmBulkDelete() {
            const checkedCount = document.querySelectorAll('.check-item:checked').length;
            if (confirm(`Apakah Anda yakin ingin menghapus ${checkedCount} data LP3M yang dipilih?`)) {
                document.getElementById('form-bulk-delete').submit();
            }
        }

        // Function Single Data Delete
        function deleteSingle(url) {
            if (confirm('Yakin ingin menghapus data ini?')) {
                const form = document.getElementById('form-single-delete');
                form.action = url;
                form.submit();
            }
        }

        // Function Single Lampiran Delete (per file atau semua)
        function deleteSingleLampiran(url, filename = '', displayName = '') {
            const label = displayName ? `lampiran "${displayName}"` : 'semua lampiran ini';
            if (confirm(`Yakin ingin menghapus ${label}?`)) {
                const form = document.getElementById('form-single-delete-lampiran');
                const fileInput = document.getElementById('delete_lampiran_file');
                fileInput.value = filename;
                form.action = url;
                form.submit();
            }
        }
    </script>
@endsection
