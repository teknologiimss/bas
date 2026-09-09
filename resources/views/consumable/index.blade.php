@extends('layouts.main')

<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

<style>
    /* ================= PALET WARNA NAVY & ANIMASI ================= */
    :root {
        --navy-dark: #0f172a;
        --navy-primary: #1e293b;
        --navy-light: #334155;
        --accent-blue: #38bdf8;
        --accent-glow: rgba(56, 189, 248, 0.35);
    }

    /* Container Animation */
    .navy-wrapper {
        animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Header Banner Modern dengan Animated Glow */
    .navy-header-card {
        background: linear-gradient(135deg, var(--navy-dark) 0%, var(--navy-primary) 100%);
        border-radius: 16px;
        padding: 24px;
        color: #ffffff;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.08);
        position: relative;
        overflow: hidden;
    }

    .navy-header-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.12) 0%, transparent 60%);
        animation: pulseGlow 6s infinite alternate ease-in-out;
        pointer-events: none;
    }

    @keyframes pulseGlow {
        0% {
            transform: scale(0.9) translate(-10px, -10px);
        }

        100% {
            transform: scale(1.1) translate(10px, 10px);
        }
    }

    /* Tombol Utama Bertema Navy-Green Glow */
    .btn-navy-add {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff !important;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-navy-add:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 22px rgba(16, 185, 129, 0.45);
    }

    /* Card & Tabel Styling */
    .navy-card {
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        background: #ffffff;
        overflow: hidden;
    }

    .navy-table {
        margin-bottom: 0;
    }

    .navy-table thead th {
        background-color: var(--navy-dark) !important;
        color: #f8fafc !important;
        border-color: #334155 !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 14px;
    }

    /* Hover & Transisi Baris Tabel */
    .navy-table tbody tr {
        transition: all 0.25s ease-in-out;
    }

    .navy-table tbody tr:hover {
        background-color: #f0f9ff !important;
        transform: scale(1.002);
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
    }

    /* Floating Action Buttons */
    .btn-action-animated {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 8px;
    }

    .btn-action-animated:hover {
        transform: translateY(-2px);
    }

    /* Badge Tahun Modern */
    .badge-year {
        background-color: rgba(56, 189, 248, 0.15);
        color: #0284c7;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 20px;
        border: 1px solid rgba(56, 189, 248, 0.3);
    }

    /* Modern Modal Styling */
    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.25);
        overflow: hidden;
        animation: modalBounce 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes modalBounce {
        from {
            transform: scale(0.9);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .modal-header {
        background: linear-gradient(135deg, var(--navy-dark) 0%, var(--navy-primary) 100%);
        color: #ffffff;
        border-bottom: none;
        padding: 18px 24px;
    }

    .modal-header .close {
        color: #ffffff;
        opacity: 0.8;
        transition: transform 0.2s ease;
    }

    .modal-header .close:hover {
        opacity: 1;
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 28px;
        background-color: #f8fafc;
    }

    .modal-footer {
        background-color: #f1f5f9;
        border-top: 1px solid #e2e8f0;
        padding: 16px 28px;
    }

    /* Form Inputs Custom */
    .form-control {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        padding: 10px 14px;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--accent-blue);
        box-shadow: 0 0 0 3px var(--accent-glow);
    }
</style>

@section('content')
    <div class="container-fluid navy-wrapper my-3">
        <!-- Banner Header Modern -->
        <div class="navy-header-card d-flex flex-column flex-sm-row justify-content-between align-items-center mb-4">
            <div class="mb-3 mb-sm-0 position-relative text-center text-sm-left">
                <h3 class="font-weight-bold mb-1 text-white">
                    <i class="fas fa-folder-open text-info mr-2"></i>Perencanaan Consumable
                </h3>
                <small class="text-light opacity-75">Kelola dan pantau seluruh folder perencanaan tahunan</small>
            </div>
            <div class="position-relative">
                <button class="btn btn-navy-add" data-toggle="modal" data-target="#modalAddFolder">
                    <i class="fas fa-folder-plus mr-2"></i>Buat Folder Baru
                </button>
            </div>
        </div>

        <!-- Card Container Tabel -->
        <div class="card navy-card">
            <div class="card-body p-0 table-responsive">
                <table class="table align-middle navy-table text-center mb-0">
                    <thead>
                        <tr>
                            <th width="8%">NO</th>
                            <th class="text-left">JUDUL PERENCANAAN</th>
                            <th width="15%">TAHUN</th>
                            <th width="30%">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($folders as $index => $folder)
                            <tr>
                                <td class="align-middle font-weight-bold text-secondary">{{ $index + 1 }}</td>
                                <td class="text-left align-middle font-weight-bold text-dark">
                                    <i class="fas fa-folder text-warning mr-2"></i>{{ $folder->title }}
                                </td>
                                <td class="align-middle">
                                    <span class="badge badge-year">{{ $folder->year }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center justify-content-center flex-wrap gap-1"
                                        style="gap: 6px;">
                                        <a href="{{ route('consumable.monitor', $folder->id) }}"
                                            class="btn btn-sm btn-info btn-action-animated px-3">
                                            <i class="fas fa-desktop mr-1"></i> Monitor
                                        </a>
                                        <button class="btn btn-sm btn-warning btn-action-animated px-3 text-white"
                                            data-toggle="modal" data-target="#modalEditFolder{{ $folder->id }}">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </button>
                                        <form action="{{ route('consumable.folder.destroy', $folder->id) }}" method="POST"
                                            class="d-inline m-0" onsubmit="return confirm('Yakin hapus folder ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger btn-action-animated px-3">
                                                <i class="fas fa-trash mr-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Edit Folder (Diperlebar dengan modal-lg dan grid layout) -->
                            <div class="modal fade" id="modalEditFolder{{ $folder->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <form action="{{ route('consumable.folder.update', $folder->id) }}" method="POST"
                                        class="w-100">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content text-left">
                                            <div class="modal-header">
                                                <h5 class="modal-title font-weight-bold"><i
                                                        class="fas fa-edit mr-2"></i>Edit Folder Perencanaan</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-8 form-group mb-3 mb-md-0">
                                                        <label class="font-weight-bold text-dark">Judul Perencanaan</label>
                                                        <input type="text" name="title" class="form-control"
                                                            value="{{ $folder->title }}" required>
                                                    </div>
                                                    <div class="col-md-4 form-group mb-0">
                                                        <label class="font-weight-bold text-dark">Tahun</label>
                                                        <input type="number" name="year" class="form-control"
                                                            value="{{ $folder->year }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success px-4"><i
                                                        class="fas fa-save mr-1"></i>Simpan Perubahan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-folder-open fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                                        <p class="mb-0 font-weight-bold">Belum ada folder perencanaan.</p>
                                        <small>Klik tombol "Buat Folder Baru" di atas untuk memulai.</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Folder Baru (Diperlebar dengan modal-lg dan grid layout) -->
    <div class="modal fade" id="modalAddFolder" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form action="{{ route('consumable.folder.store') }}" method="POST" class="w-100">
                @csrf
                <div class="modal-content text-left">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold"><i class="fas fa-folder-plus mr-2"></i>Folder Perencanaan
                            Baru</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8 form-group mb-3 mb-md-0">
                                <label class="font-weight-bold text-dark">Judul Perencanaan</label>
                                <input type="text" name="title" class="form-control"
                                    placeholder="Contoh: Perencanaan Consumable Gedung A" required>
                            </div>
                            <div class="col-md-4 form-group mb-0">
                                <label class="font-weight-bold text-dark">Tahun</label>
                                <input type="number" name="year" class="form-control" value="{{ date('Y') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4"><i class="fas fa-plus-circle mr-1"></i>Buat
                            Folder</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
