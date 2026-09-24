@extends('layouts.main')

<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')
    {{-- =========================================================
        CSS CUSTOM
    ========================================================== --}}
    <style>
        :root {
            --navy-dark: #0f172a;
            --navy-card: #1e293b;
            --navy-primary: #1e40af;
            --navy-accent: #3b82f6;
            --navy-light: #f8fafc;
            --border-color: #e2e8f0;
        }

        /* =====================================================
                   CARD
                ====================================================== */
        .card-navy {
            background: #ffffff;
            border: none;
            border-radius: 16px;
            box-shadow:
                0 10px 25px -5px rgba(15, 23, 42, 0.08),
                0 8px 10px -6px rgba(15, 23, 42, 0.04);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card-navy-header {
            background: linear-gradient(135deg,
                    #0f172a 0%,
                    #1e3a8a 100%);
            color: #ffffff;
            padding: 1.25rem 1.5rem;
            border-bottom: none;

            display: flex;
            align-items: center;
            justify-content: space-between;

            flex-wrap: wrap;
            gap: 12px;
        }

        /* =====================================================
                   BUTTON
                ====================================================== */
        .btn-navy-primary {
            background: linear-gradient(135deg,
                    #2563eb 0%,
                    #1d4ed8 100%);

            color: #ffffff;
            border: none;
            border-radius: 10px;

            padding: 0.55rem 1.25rem;

            font-weight: 600;

            box-shadow:
                0 4px 12px rgba(37, 99, 235, 0.3);

            transition: all 0.3s ease;
        }

        .btn-navy-primary:hover {
            transform: translateY(-2px);

            box-shadow:
                0 6px 18px rgba(37, 99, 235, 0.45);

            color: #ffffff;
        }

        .btn-navy-primary:active {
            transform: translateY(0);
        }

        /* =====================================================
                   TOAST ALERT
                ====================================================== */
        .toast-alert {
            position: fixed;

            top: 24px;
            right: 24px;

            z-index: 9999;

            min-width: 300px;
            max-width: 90vw;

            background: #ffffff;

            border-left: 6px solid #10b981;

            border-radius: 12px;

            box-shadow:
                0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 8px 10px -6px rgba(0, 0, 0, 0.1);

            animation:
                slideInRight 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideInRight {
            from {
                transform: translateX(120%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* =====================================================
                   TABLE
                ====================================================== */

        .custom-table-container {
            border-radius: 12px;
            overflow-x: auto;
            overflow-y: hidden;
        }

        .table-navy {
            margin-bottom: 0;
            width: 100%;

            /* Penting agar isi tabel dapat wrap */
            table-layout: auto;
        }

        .table-navy thead {
            background-color: #f1f5f9;
            color: #334155;

            font-weight: 700;

            text-transform: uppercase;

            font-size: 0.8rem;

            letter-spacing: 0.05em;
        }

        .table-navy th,
        .table-navy td {
            padding: 1rem;

            vertical-align: middle;

            border-color: var(--border-color);

            /*
                     * PENTING:
                     * Membuat teks panjang turun ke baris berikutnya.
                     */
            white-space: normal !important;

            word-wrap: break-word;

            overflow-wrap: anywhere;

            word-break: normal;

            line-height: 1.5;
        }

        .table-navy tbody tr {
            transition: all 0.2s ease;
        }

        .table-navy tbody tr:hover {
            background-color: #f8fafc;
        }

        /* =====================================================
                   KOLOM DESKRIPSI
                ====================================================== */

        .table-navy td.deskripsi-cell {
            min-width: 250px;

            max-width: 420px;

            white-space: normal !important;

            word-wrap: break-word;

            overflow-wrap: anywhere;

            word-break: normal;

            line-height: 1.6;
        }

        /* =====================================================
                   KOLOM KETERANGAN
                ====================================================== */

        .table-navy td.keterangan-cell {
            min-width: 180px;

            max-width: 320px;

            white-space: normal !important;

            word-wrap: break-word;

            overflow-wrap: anywhere;

            word-break: normal;

            line-height: 1.6;
        }

        /* =====================================================
                   KOLOM PENGIRIM
                ====================================================== */

        .table-navy td.sender-cell {
            min-width: 150px;

            max-width: 220px;

            white-space: normal !important;

            word-wrap: break-word;

            overflow-wrap: anywhere;

            line-height: 1.5;
        }

        /* =====================================================
                   KOLOM PENERIMA
                ====================================================== */

        .table-navy td.penerima-cell {
            min-width: 150px;

            max-width: 220px;

            white-space: normal !important;

            word-wrap: break-word;

            overflow-wrap: anywhere;

            line-height: 1.5;
        }

        /* Badge penerima juga boleh wrap */
        .table-navy td.penerima-cell .badge {
            white-space: normal !important;

            word-wrap: break-word;

            overflow-wrap: anywhere;

            line-height: 1.4;

            display: inline-block;
        }

        /* =====================================================
                   TANGGAL
                ====================================================== */

        .table-navy td.tanggal-cell {
            white-space: nowrap !important;
            min-width: 100px;
        }

        /* =====================================================
                   KOLOM DOKUMEN
                ====================================================== */

        .table-navy td.dokumen-cell {
            min-width: 120px;

            white-space: nowrap !important;
        }

        /* =====================================================
                   KOLOM AKSI
                ====================================================== */

        .table-navy td.aksi-cell {
            min-width: 110px;

            white-space: nowrap !important;
        }

        /* =====================================================
                   ACTION BUTTON
                ====================================================== */

        .action-btn {
            width: 36px;
            height: 36px;

            display: inline-flex;

            align-items: center;
            justify-content: center;

            border-radius: 8px;

            transition: all 0.2s ease;

            border: none;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        /* =====================================================
                   MOBILE CARD
                ====================================================== */

        .mobile-card-item {
            background: #ffffff;

            border: 1px solid var(--border-color);

            border-radius: 12px;

            padding: 16px;

            margin-bottom: 12px;

            box-shadow:
                0 2px 8px rgba(0, 0, 0, 0.04);

            transition: all 0.3s ease;

            /*
                     * Pastikan teks panjang tidak keluar card
                     */
            word-wrap: break-word;

            overflow-wrap: anywhere;
        }

        .mobile-card-item:hover {
            box-shadow:
                0 8px 16px rgba(15, 23, 42, 0.08);

            border-color: var(--navy-accent);
        }

        .mobile-card-item p,
        .mobile-card-item strong,
        .mobile-card-item span {
            white-space: normal !important;

            word-wrap: break-word;

            overflow-wrap: anywhere;

            word-break: normal;
        }

        /* =====================================================
                   MOBILE
                ====================================================== */

        @media (max-width: 767.98px) {

            .desktop-table-view {
                display: none !important;
            }

            .card-navy-header {
                flex-direction: column;

                align-items: stretch;

                text-align: center;
            }

            .btn-navy-primary {
                width: 100%;
            }

            .toast-alert {
                top: 15px;

                right: 15px;

                left: 15px;

                min-width: unset;

                max-width: none;
            }
        }

        /* =====================================================
                   TABLET
                ====================================================== */

        @media (min-width: 768px) {

            .mobile-card-view {
                display: none !important;
            }
        }

        /* =====================================================
                   MODAL
                ====================================================== */

        .modal.fade .modal-dialog {
            transform: scale(0.9);

            transition:
                transform 0.3s ease-out;
        }

        .modal.show .modal-dialog {
            transform: scale(1);
        }

        .modal-content-navy {
            border-radius: 16px;

            border: none;

            overflow: hidden;
        }

        .modal-header-navy {
            background: linear-gradient(135deg,
                    #0f172a 0%,
                    #1e3a8a 100%);

            color: #ffffff;
        }

        /* =====================================================
                   TEXTAREA
                ====================================================== */

        textarea.form-control {
            resize: vertical;

            min-height: 80px;
        }

        /* =====================================================
                   FILE BUTTON
                ====================================================== */

        .btn-file {
            white-space: nowrap;
        }
    </style>


    {{-- =========================================================
        MAIN CONTENT
    ========================================================== --}}

    <div class="container-fluid py-4">

        <div class="row">

            <div class="col-12">


                {{-- =================================================
                    SUCCESS ALERT
                ================================================== --}}

                @if (session('success'))
                    <div id="success-alert" class="alert alert-dismissible fade show toast-alert" role="alert">

                        <div class="d-flex align-items-center p-2">

                            <i class="fas fa-check-circle fa-2x text-success mr-3"></i>

                            <div>

                                <strong class="text-dark" style="font-size: 0.95rem;">

                                    Berhasil!

                                </strong>

                                <div class="text-muted small">

                                    {{ session('success') }}

                                </div>

                            </div>

                        </div>

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="top: 12px;">

                            <span aria-hidden="true">
                                &times;
                            </span>

                        </button>

                    </div>
                @endif


                {{-- =================================================
                    CARD UTAMA
                ================================================== --}}

                <div class="card card-navy">


                    {{-- HEADER --}}

                    <div class="card-navy-header">

                        <div class="d-flex align-items-center">

                            <i class="fas fa-shipping-fast fa-lg mr-2 text-info"></i>

                            <h4 class="card-title mb-0 font-weight-bold" style="letter-spacing: 0.5px;">

                                Data Ekspedisi Dokumen

                            </h4>

                        </div>


                        <button type="button" class="btn btn-navy-primary" data-toggle="modal" data-target="#modalTambah">

                            <i class="fas fa-plus-circle mr-1"></i>

                            Tambah Ekspedisi

                        </button>

                    </div>


                    {{-- =================================================
                        CARD BODY
                    ================================================== --}}

                    <div class="card-body p-3 p-md-4">


                        {{-- =================================================
                            DESKTOP / TABLET
                        ================================================== --}}

                        <div class="table-responsive desktop-table-view custom-table-container">

                            <table class="table table-navy align-items-center">

                                <thead>

                                    <tr>

                                        <th class="no-column">
                                            No
                                        </th>

                                        <th>
                                            Pengirim
                                        </th>

                                        <th>
                                            Deskripsi
                                        </th>

                                        <th>
                                            Diterima Oleh
                                        </th>

                                        <th>
                                            Tanggal
                                        </th>

                                        <th>
                                            Keterangan
                                        </th>

                                        <th>
                                            Dokumen
                                        </th>

                                        <th style="width: 120px;" class="text-center">

                                            Aksi

                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse ($dokumens as $index => $item)
                                        <tr>


                                            {{-- NO --}}

                                            <td class="font-weight-bold text-muted">

                                                {{ $index + 1 }}

                                            </td>


                                            {{-- PENGIRIM --}}

                                            <td class="sender-cell">

                                                <span class="font-weight-bold text-dark">

                                                    {{ $item->sender->name ?? 'N/A' }}

                                                </span>

                                            </td>


                                            {{-- DESKRIPSI --}}
                                            {{-- TIDAK LAGI MENGGUNAKAN Str::limit --}}

                                            <td class="deskripsi-cell">

                                                {{ $item->deskripsi }}

                                            </td>


                                            {{-- DITERIMA OLEH --}}

                                            <td class="penerima-cell">

                                                <span class="badge badge-light p-2 border">

                                                    {{ $item->diterima_oleh }}

                                                </span>

                                            </td>


                                            {{-- TANGGAL --}}

                                            <td class="tanggal-cell">

                                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}

                                            </td>


                                            {{-- KETERANGAN --}}

                                            <td class="keterangan-cell">

                                                {{ $item->keterangan ?? '-' }}

                                            </td>


                                            {{-- DOKUMEN --}}

                                            <td class="dokumen-cell">

                                                @if ($item->file_dokumen)
                                                    <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-info rounded-pill px-3">

                                                        <i class="fas fa-file-alt mr-1"></i>

                                                        Lihat File

                                                    </a>
                                                @else
                                                    <span class="badge badge-secondary badge-pill px-3 py-2">

                                                        Tidak ada file

                                                    </span>
                                                @endif

                                            </td>


                                            {{-- AKSI --}}

                                            <td class="text-center aksi-cell">

                                                <div class="d-flex justify-content-center">

                                                    {{-- EDIT --}}

                                                    <button type="button" class="action-btn btn-warning text-white mr-1"
                                                        data-toggle="modal" data-target="#modalEdit{{ $item->id }}"
                                                        title="Edit">

                                                        <i class="fas fa-edit"></i>

                                                    </button>


                                                    {{-- DELETE --}}

                                                    <form action="{{ route('ekspedisi.destroy', $item->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                                        @csrf

                                                        @method('DELETE')

                                                        <button type="submit" class="action-btn btn-danger text-white"
                                                            title="Hapus">

                                                            <i class="fas fa-trash"></i>

                                                        </button>

                                                    </form>

                                                </div>

                                            </td>

                                        </tr>


                                    @empty


                                        <tr>

                                            <td colspan="8" class="text-center py-5 text-muted">

                                                <i class="fas fa-folder-open fa-3x mb-3 text-secondary d-block">
                                                </i>

                                                Belum ada data ekspedisi dokumen.

                                            </td>

                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>

                        </div>


                        {{-- =================================================
                            MOBILE CARD VIEW
                        ================================================== --}}

                        <div class="mobile-card-view d-md-none">

                            @forelse ($dokumens as $index => $item)
                                <div class="mobile-card-item">


                                    {{-- HEADER CARD --}}

                                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">

                                        <span class="badge badge-primary px-2 py-1">

                                            #{{ $index + 1 }}

                                        </span>


                                        <small class="text-muted">

                                            <i class="far fa-calendar-alt mr-1"></i>

                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}

                                        </small>

                                    </div>


                                    {{-- PENGIRIM --}}

                                    <div class="mb-2">

                                        <strong class="text-dark d-block" style="font-size: 1.05rem;">

                                            {{ $item->sender->name ?? 'N/A' }}

                                        </strong>


                                        {{-- DESKRIPSI FULL --}}

                                        <p class="text-muted small mb-1">

                                            {{ $item->deskripsi }}

                                        </p>

                                    </div>


                                    {{-- PENERIMA & KETERANGAN --}}

                                    <div class="row text-small mb-3 bg-light p-2 rounded mx-0">

                                        <div class="col-6 px-1">

                                            <small class="text-muted d-block">

                                                Penerima:

                                            </small>

                                            <strong>

                                                {{ $item->diterima_oleh }}

                                            </strong>

                                        </div>


                                        <div class="col-6 px-1">

                                            <small class="text-muted d-block">

                                                Ket:

                                            </small>

                                            <span>

                                                {{ $item->keterangan ?? '-' }}

                                            </span>

                                        </div>

                                    </div>


                                    {{-- FILE & ACTION --}}

                                    <div class="d-flex justify-content-between align-items-center pt-2">

                                        <div>

                                            @if ($item->file_dokumen)
                                                <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank"
                                                    class="btn btn-sm btn-info rounded-pill">

                                                    <i class="fas fa-file-alt mr-1"></i>

                                                    File

                                                </a>
                                            @else
                                                <span class="badge badge-secondary">

                                                    No File

                                                </span>
                                            @endif

                                        </div>


                                        <div>

                                            {{-- EDIT --}}

                                            <button type="button"
                                                class="btn btn-sm btn-warning text-white rounded-circle mr-1"
                                                data-toggle="modal" data-target="#modalEdit{{ $item->id }}"
                                                title="Edit">

                                                <i class="fas fa-edit"></i>

                                            </button>


                                            {{-- DELETE --}}

                                            <form action="{{ route('ekspedisi.destroy', $item->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                                @csrf

                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-danger rounded-circle"
                                                    title="Hapus">

                                                    <i class="fas fa-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                </div>


                            @empty


                                <div class="text-center py-4 text-muted bg-light rounded">

                                    <i class="fas fa-folder-open fa-2x mb-2 text-secondary d-block">
                                    </i>

                                    Belum ada data ekspedisi dokumen.

                                </div>
                            @endforelse

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        MODAL EDIT
    ========================================================== --}}

    @foreach ($dokumens as $item)
        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="modalEditLabel{{ $item->id }}" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered" role="document">

                <form action="{{ route('ekspedisi.update', $item->id) }}" method="POST" enctype="multipart/form-data"
                    class="w-100">

                    @csrf

                    @method('PUT')


                    <div class="modal-content modal-content-navy shadow-lg">


                        {{-- HEADER MODAL --}}

                        <div class="modal-header modal-header-navy">

                            <h5 class="modal-title font-weight-bold" id="modalEditLabel{{ $item->id }}">

                                <i class="fas fa-edit mr-2"></i>

                                Edit Ekspedisi Dokumen

                            </h5>


                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">

                                <span aria-hidden="true">
                                    &times;
                                </span>

                            </button>

                        </div>


                        {{-- BODY --}}

                        <div class="modal-body p-4">


                            {{-- PENGIRIM --}}

                            <div class="form-group">

                                <label class="font-weight-bold text-secondary">

                                    Nama Pengirim

                                </label>

                                <input type="text" class="form-control bg-light"
                                    value="{{ $item->sender->name ?? 'N/A' }}" readonly>

                            </div>


                            {{-- DESKRIPSI --}}

                            <div class="form-group">

                                <label class="font-weight-bold text-secondary">

                                    Deskripsi

                                </label>

                                <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi', $item->deskripsi) }}</textarea>

                            </div>


                            {{-- DITERIMA OLEH --}}

                            <div class="form-group">

                                <label class="font-weight-bold text-secondary">

                                    Diterima Oleh

                                </label>

                                <input type="text" name="diterima_oleh" class="form-control"
                                    value="{{ old('diterima_oleh', $item->diterima_oleh) }}" required>

                            </div>


                            {{-- TANGGAL --}}

                            <div class="form-group">

                                <label class="font-weight-bold text-secondary">

                                    Tanggal

                                </label>

                                <input type="date" name="tanggal" class="form-control"
                                    value="{{ old('tanggal', $item->tanggal) }}" required>

                            </div>


                            {{-- KETERANGAN --}}

                            <div class="form-group">

                                <label class="font-weight-bold text-secondary">

                                    Keterangan

                                </label>

                                <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $item->keterangan) }}</textarea>

                            </div>


                            {{-- FILE --}}

                            <div class="form-group mb-0">

                                <label class="font-weight-bold text-secondary">

                                    Upload Dokumen Baru

                                </label>

                                <input type="file" name="file_dokumen" class="form-control-file">


                                @if ($item->file_dokumen)
                                    <small class="form-text text-info mt-2">

                                        <i class="fas fa-info-circle mr-1"></i>

                                        File saat ini:

                                        <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank"
                                            class="font-weight-bold">

                                            Lihat Dokumen

                                        </a>

                                    </small>
                                @endif

                            </div>

                        </div>


                        {{-- FOOTER --}}

                        <div class="modal-footer bg-light">

                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">

                                Batal

                            </button>


                            <button type="submit" class="btn btn-navy-primary rounded-pill px-4">

                                Simpan Perubahan

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>
    @endforeach


    {{-- =========================================================
        MODAL TAMBAH
    ========================================================== --}}

    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">

            <form action="{{ route('ekspedisi.store') }}" method="POST" enctype="multipart/form-data" class="w-100">

                @csrf


                <div class="modal-content modal-content-navy shadow-lg">


                    {{-- HEADER --}}

                    <div class="modal-header modal-header-navy">

                        <h5 class="modal-title font-weight-bold" id="modalTambahLabel">

                            <i class="fas fa-plus-circle mr-2"></i>

                            Tambah Ekspedisi Dokumen

                        </h5>


                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">
                                &times;
                            </span>

                        </button>

                    </div>


                    {{-- BODY --}}

                    <div class="modal-body p-4">


                        {{-- PENGIRIM --}}

                        <div class="form-group">

                            <label class="font-weight-bold text-secondary">

                                Nama Pengirim

                            </label>

                            <input type="text" class="form-control bg-light" value="{{ auth()->user()->name }}"
                                readonly>

                        </div>


                        {{-- DESKRIPSI --}}

                        <div class="form-group">

                            <label class="font-weight-bold text-secondary">

                                Deskripsi

                            </label>

                            <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi') }}</textarea>

                        </div>


                        {{-- DITERIMA OLEH --}}

                        <div class="form-group">

                            <label class="font-weight-bold text-secondary">

                                Diterima Oleh

                            </label>

                            <input type="text" name="diterima_oleh" class="form-control"
                                value="{{ old('diterima_oleh') }}" required>

                        </div>


                        {{-- TANGGAL --}}

                        <div class="form-group">

                            <label class="font-weight-bold text-secondary">

                                Tanggal

                            </label>

                            <input type="date" name="tanggal" class="form-control"
                                value="{{ old('tanggal', date('Y-m-d')) }}" required>

                        </div>


                        {{-- KETERANGAN --}}

                        <div class="form-group">

                            <label class="font-weight-bold text-secondary">

                                Keterangan

                            </label>

                            <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>

                        </div>


                        {{-- FILE --}}

                        <div class="form-group mb-0">

                            <label class="font-weight-bold text-secondary">

                                Upload Dokumen

                            </label>

                            <input type="file" name="file_dokumen" class="form-control-file">

                        </div>

                    </div>


                    {{-- FOOTER --}}

                    <div class="modal-footer bg-light">

                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">

                            Batal

                        </button>


                        <button type="submit" class="btn btn-navy-primary rounded-pill px-4">

                            Simpan Data

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- =========================================================
        JAVASCRIPT
    ========================================================== --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const successAlert =
                document.getElementById('success-alert');

            if (successAlert) {

                setTimeout(function() {

                    if (typeof $ !== 'undefined') {

                        $('#success-alert').alert('close');

                    } else {

                        successAlert.style.transition =
                            "opacity 0.5s ease";

                        successAlert.style.opacity = "0";


                        setTimeout(() => {

                            successAlert.remove();

                        }, 500);

                    }

                }, 4000);

            }

        });
    </script>
@endsection
