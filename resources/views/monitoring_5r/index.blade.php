@extends('layouts.main')

@section('title', 'Monitoring 5R & Scrap')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@section('content')
    <style>
        :root {
            --navy-primary: #0d3b66;
            --navy-hover: #082846;
            --bg-page: #f8fafc;
            --border-color: #e2e8f0;
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }

        body {
            background-color: var(--bg-page);
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, sans-serif;
            color: var(--text-dark);
        }

        /* Top Action Bar Layout */
        .top-action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .btn-add-main {
            background: var(--navy-primary);
            color: #ffffff !important;
            font-weight: 600;
            font-size: 13.5px;
            padding: 9px 16px;
            border-radius: 8px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 6px rgba(13, 59, 102, 0.15);
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .btn-add-main:hover {
            background: var(--navy-hover);
            transform: translateY(-1px);
        }

        /* Search Form Modern */
        .search-container {
            max-width: 380px;
            width: 100%;
        }

        .search-group {
            display: flex;
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        }

        .search-group input {
            border: none;
            padding: 8px 14px;
            outline: none;
            width: 100%;
            font-size: 13.5px;
            color: var(--text-dark);
        }

        .search-group button {
            background: var(--navy-primary);
            color: white;
            border: none;
            padding: 0 16px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .search-group button:hover {
            background: var(--navy-hover);
        }

        /* Card Folder Style Clean */
        .folder-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-left: 5px solid var(--navy-primary);
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .folder-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            border-color: #cbd5e1;
            border-left-color: var(--navy-primary);
            transform: translateY(-1px);
        }

        .folder-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 4px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .folder-title i {
            color: #f59e0b;
        }

        .folder-badge {
            font-size: 12px;
            font-weight: 500;
            color: var(--text-muted);
            background: #f1f5f9;
            padding: 2px 8px;
            border-radius: 5px;
            display: inline-block;
        }

        /* Action Buttons Group & Alignment Fix */
        .btn-group-action {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Reset form margin/padding agar tombol sejajar sempurna */
        .btn-group-action form {
            margin: 0 !important;
            padding: 0 !important;
            display: inline-flex;
            align-items: center;
        }

        .btn-action-item {
            border: none;
            font-size: 12.5px;
            font-weight: 600;
            padding: 0 14px;
            height: 36px;
            /* Menyamakan tinggi semua tombol */
            line-height: 36px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none !important;
            transition: all 0.15s ease;
            cursor: pointer;
            white-space: nowrap;
            box-sizing: border-box;
        }

        .btn-action-item:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-view {
            background-color: #0284c7;
            color: #ffffff !important;
        }

        .btn-edit-item {
            background-color: #f59e0b;
            color: #ffffff !important;
        }

        .btn-delete-item {
            background-color: #ef4444;
            color: #ffffff !important;
        }

        /* Responsive Mobile Screen (< 768px) */
        @media (max-width: 768px) {
            .top-action-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-add-main {
                justify-content: center;
                width: 100%;
            }

            .search-container {
                max-width: 100%;
            }

            .folder-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
                padding: 14px;
            }

            .btn-group-action {
                width: 100%;
                justify-content: space-between;
            }

            .btn-group-action form {
                flex: 1;
            }

            .btn-action-item {
                flex: 1;
                width: 100%;
                padding: 0 6px;
            }
        }
    </style>

    <div class="container-fluid px-2 px-md-4 py-2">
        {{-- Top Bar Section --}}
        <div class="top-action-bar">
            <div>
                <button class="btn-add-main" data-toggle="modal" data-target="#modalCreate" data-bs-toggle="modal"
                    data-bs-target="#modalCreate">
                    <i class="fa-solid fa-plus"></i> Tambah Folder 5R & Scrap
                </button>
            </div>

            <div class="search-container">
                <form method="GET" action="" class="m-0">
                    <div class="search-group">
                        <input type="text" name="search" placeholder="Cari Tahun / Nama Folder..."
                            value="{{ request('search') }}">
                        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-8 mb-3 py-2 px-3 small"
                role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            </div>
        @endif

        {{-- List Folder --}}
        <div class="row">
            <div class="col-12">
                @forelse($folders as $folder)
                    <div class="folder-card">
                        {{-- Info Folder --}}
                        <div>
                            <h3 class="folder-title">
                                <i class="fa-solid fa-folder"></i>
                                {{ $folder->nama_folder }} ({{ $folder->tahun }})
                            </h3>
                            <span class="folder-badge">Total Data: {{ $folder->items->count() }} Item</span>
                        </div>

                        {{-- Tombol Aksi Sejajar --}}
                        <div class="btn-group-action">
                            <a href="{{ route('monitoring_5r.monitor', $folder->id) }}" class="btn-action-item btn-view"
                                title="Lihat Monitor">
                                <i class="fa-regular fa-eye"></i> Lihat Monitor
                            </a>

                            <button type="button" class="btn-action-item btn-edit-item" data-toggle="modal"
                                data-target="#modalEdit{{ $folder->id }}" data-bs-toggle="modal"
                                data-bs-target="#modalEdit{{ $folder->id }}" title="Edit Folder">
                                <i class="fa-regular fa-pen-to-square"></i> Edit
                            </button>

                            <form action="{{ route('monitoring_5r.folder.destroy', $folder->id) }}" method="POST"
                                class="m-0 d-inline-flex align-items-center" onsubmit="return confirm('Hapus folder ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action-item btn-delete-item" title="Hapus Folder">
                                    <i class="fa-regular fa-trash-can"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Modal Edit Folder --}}
                    <div class="modal fade" id="modalEdit{{ $folder->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <form action="{{ route('monitoring_5r.folder.update', $folder->id) }}" method="POST"
                                class="w-100">
                                @csrf
                                @method('PUT')
                                <div class="modal-content border-0 shadow rounded-12">
                                    <div class="modal-header bg-warning text-white py-2 px-3">
                                        <h6 class="modal-title font-weight-bold text-white"><i
                                                class="fa-regular fa-pen-to-square me-2"></i>Edit Folder</h6>
                                        <button type="button" class="close text-white" data-dismiss="modal"
                                            data-bs-dismiss="modal" aria-label="Close">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body p-3">
                                        <div class="form-group mb-2">
                                            <label class="font-weight-bold small text-muted mb-1">Tahun</label>
                                            <input type="text" autocomplete="off" name="tahun" class="form-control form-control-sm"
                                                value="{{ $folder->tahun }}" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="font-weight-bold small text-muted mb-1">Nama Folder /
                                                Proyek</label>
                                            <input type="text" autocomplete="off" name="nama_folder" class="form-control form-control-sm"
                                                value="{{ $folder->nama_folder }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light py-2 px-3">
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-sm btn-primary font-weight-bold">Simpan
                                            Perubahan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 bg-white rounded-8 border">
                        <i class="fa-solid fa-folder-open text-muted fa-2x mb-2"></i>
                        <p class="text-muted small mb-0">Belum ada folder data yang dibuat.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Modal Tambah Folder Baru --}}
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('monitoring_5r.folder.store') }}" method="POST" class="w-100">
                @csrf
                <div class="modal-content border-0 shadow rounded-12">
                    <div class="modal-header text-white py-2 px-3" style="background: var(--navy-primary);">
                        <h6 class="modal-title font-weight-bold text-white"><i
                                class="fa-solid fa-folder-plus me-2"></i>Tambah Folder Baru</h6>
                        <button type="button" class="close text-white" data-dismiss="modal" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-3">
                        <div class="form-group mb-2">
                            <label class="font-weight-bold small text-muted mb-1">Tahun</label>
                            <input type="text" autocomplete="off" name="tahun" class="form-control form-control-sm" required
                                placeholder="Contoh: 2026">
                        </div>
                        <div class="form-group mb-2">
                            <label class="font-weight-bold small text-muted mb-1">Nama Folder / Proyek</label>
                            <input type="text" autocomplete="off" name="nama_folder" class="form-control form-control-sm" required
                                placeholder="Contoh: Monitoring 5R PT.INKA">
                        </div>
                    </div>
                    <div class="modal-footer bg-light py-2 px-3">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"
                            data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-success font-weight-bold">Simpan Folder</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
