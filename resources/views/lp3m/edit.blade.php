@extends('layouts.main')

@section('title', 'Edit Lembar Pekerjaan Perbaikan Perawatan Fasilitas')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')

    <style>
        :root {
            --navy: #0b1f3a;
            --navy-2: #102a52;
            --navy-soft: #163a63;
            --accent: #1f4b82;
        }

        body {
            background: #f5f6fa;
        }

        .card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            animation: fadeIn .4s ease;
        }

        .card-header {
            background: linear-gradient(135deg, var(--navy), var(--navy-2)) !important;
            border: none;
            padding: 18px 25px;
        }

        .card-header h5 {
            font-weight: 700;
            letter-spacing: .5px;
            color: #fff;
        }

        .card-body {
            padding: 30px;
            background: #fff;
        }

        label {
            font-weight: 600;
            margin-bottom: 6px;
            color: #2d3748;
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #d6dbe3;
            padding: 12px;
            transition: .3s;
            box-shadow: none !important;
        }

        .form-control:focus {
            border-color: var(--navy);
            box-shadow: 0 0 0 0.2rem rgba(11, 31, 58, .15) !important;
            transform: translateY(-1px);
        }

        textarea.form-control {
            min-height: 110px;
        }

        hr {
            border-top: 2px dashed #e5e7eb;
            margin: 28px 0;
        }

        /* BUTTON STYLE (NAVY THEME) */
        .btn {
            border-radius: 12px;
            padding: 10px 18px;
            font-weight: 600;
            transition: .3s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-warning,
        .btn-primary,
        .btn-danger {
            background: var(--navy) !important;
            border: none !important;
            color: #fff !important;
        }

        .btn-warning:hover,
        .btn-primary:hover,
        .btn-danger:hover {
            background: var(--navy-2) !important;
            color: #fff !important;
        }

        .btn-secondary {
            background: #6b7280;
            border: none;
        }

        .btn-outline-danger.btn-riwayat {
            border: 1px solid var(--navy);
            color: var(--navy);
            background: transparent;
        }

        .btn-outline-danger.btn-riwayat:hover {
            background: var(--navy);
            color: #fff;
        }

        /* CHECKBOX */
        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--navy);
            cursor: pointer;
            margin-right: 6px;
        }

        /* INPUT GROUP ANIMATION */
        .input-group {
            animation: slideUp .3s ease;
        }

        /* MODAL HEADER */
        .modal-header.bg-danger {
            background: linear-gradient(135deg, var(--navy), var(--navy-2)) !important;
        }

        /* TABLE STICKY HEADER */
        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 10;
            background: var(--navy) !important;
            color: #fff;
        }

        /* SCROLLBAR */
        .riwayat-modal-body::-webkit-scrollbar {
            width: 8px;
        }

        .riwayat-modal-body::-webkit-scrollbar-thumb {
            background: var(--navy);
            border-radius: 10px;
        }

        .riwayat-modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* ANIMATION */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* RESPONSIVE */
        @media(max-width:768px) {
            .card-body {
                padding: 20px;
            }

            .btn {
                width: 100%;
                margin-bottom: 10px;
            }

            .text-end {
                text-align: center !important;
            }

            .input-group {
                flex-direction: column;
            }

            .input-group .btn {
                width: 100%;
                margin-top: 8px;
            }
        }
    </style>

    <div class="container mt-3">

        <div class="card shadow">

            <div class="card-header bg-warning text-white">

                <h5 class="mb-0">

                    <i class="fas fa-edit"></i>
                    Edit Form Pekerjaan Perbaikan Perawatan Fasilitas

                </h5>

            </div>

            <div class="card-body">

                <form action="{{ route('lp3m.update', $data->id) }}" method="POST">

                    @csrf

                    {{-- =========================
                    INFORMASI AWAL
                ========================== --}}


                    <div class="mb-3">

                        <label>Status</label>

                        <select name="status" class="form-control">

                            <option value="OPEN" {{ $data->status == 'OPEN' ? 'selected' : '' }}>

                                OPEN

                            </option>

                            <option value="CLOSED" {{ $data->status == 'CLOSED' ? 'selected' : '' }}>

                                CLOSED

                            </option>

                        </select>

                    </div>
                    {{-- <div class="mb-3">

                        <label>SPR No</label>

                        <input type="text" name="spr_no" autocomplete="off" class="form-control" value="{{ $data->spr_no }}">

                    </div> --}}

                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <input type="text" name="deskripsi" autocomplete="off" class="form-control"
                            value="{{ old('deskripsi', $data->deskripsi) }}">
                    </div>

                    <div class="mb-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" autocomplete="off" class="form-control" rows="4">{{ old('keterangan', $data->keterangan) }}</textarea>
                    </div>

                    <div class="row align-items-center mb-2">

                        <div class="col-12 col-md-6">

                            <label class="mb-2 mb-md-0 fw-bold">
                                SPR No
                            </label>

                        </div>

                        <div class="col-12 col-md-6 text-md-end">

                            <button type="button" class="btn btn-outline-danger btn-riwayat" data-bs-toggle="modal"
                                data-bs-target="#modalRiwayatSpr">

                                <i class="fas fa-history me-1"></i>
                                Riwayat No. SPR

                            </button>

                        </div>

                    </div>

                    <input type="text" name="spr_no" autocomplete="off" class="form-control"
                        value="{{ $data->spr_no }}">


                    <div class="mb-3">

                        <label>Hasil Pengukuran</label>

                        <textarea name="hasil_pengukuran" autocomplete="off" class="form-control" rows="3">{{ $data->hasil_pengukuran }}</textarea>

                    </div>

                    <div class="mb-3">

                        <label>Penyebab Kerusakan</label>

                        <textarea name="penyebab_kerusakan" autocomplete="off" class="form-control" rows="3">{{ $data->penyebab_kerusakan }}</textarea>

                    </div>

                    <hr>

                    {{-- =========================
                    PENYEBAB KERUSAKAN
                ========================== --}}

                    <h5 class="mb-3">
                        Penyebab Kerusakan
                    </h5>

                    <div class="row">

                        <div class="col-md-4 mb-2">

                            <input type="checkbox" name="aus" {{ $data->aus ? 'checked' : '' }}>

                            Aus

                        </div>

                        <div class="col-md-4 mb-2">

                            <input type="checkbox" name="retak" {{ $data->retak ? 'checked' : '' }}>

                            Retak / Patah

                        </div>

                        <div class="col-md-4 mb-2">

                            <input type="checkbox" name="komponen_tak_berfungsi"
                                {{ $data->komponen_tak_berfungsi ? 'checked' : '' }}>

                            Komponen Tak Berfungsi

                        </div>

                        <div class="col-md-4 mb-2">

                            <input type="checkbox" name="kelebihan_beban" {{ $data->kelebihan_beban ? 'checked' : '' }}>

                            Kelebihan Beban

                        </div>

                        <div class="col-md-4 mb-2">

                            <input type="checkbox" name="salah_operasi" {{ $data->salah_operasi ? 'checked' : '' }}>

                            Salah Operasi

                        </div>

                        <div class="col-md-4 mb-2">

                            <input type="checkbox" name="kelainan" {{ $data->kelainan ? 'checked' : '' }}>

                            Kelainan

                        </div>

                        <div class="col-md-4 mb-2">

                            <input type="checkbox" name="kecelakaan" {{ $data->kecelakaan ? 'checked' : '' }}>

                            Kecelakaan

                        </div>

                        <div class="col-md-4 mb-2">

                            <input type="checkbox" name="lain_lain_kerusakan"
                                {{ $data->lain_lain_kerusakan ? 'checked' : '' }}>

                            Lain-lain

                        </div>

                    </div>

                    <hr>

                    {{-- =========================
                    PEKERJAAN
                ========================== --}}

                    <h5 class="mb-3">
                        Eksekusi
                    </h5>

                    <div class="row">

                        {{-- <div class="col-md-6 mb-3">

                            <label>Nama Teknisi</label>

                            <input type="text" name="nama" class="form-control" value="{{ $data->nama }}">

                        </div> --}}

                        <div class="col-md-12 mb-3">

                            <label>Nama Teknisi</label>

                            <div id="teknisi-wrapper">

                                @php
                                    $teknisi = json_decode($data->nama, true);
                                @endphp

                                @if ($teknisi)

                                    @foreach ($teknisi as $t)
                                        <div class="input-group mb-2">

                                            <input type="text" name="nama[]" autocomplete="off" class="form-control"
                                                value="{{ $t }}">

                                            <button type="button" class="btn btn-danger remove-teknisi">
                                                Hapus
                                            </button>

                                        </div>
                                    @endforeach
                                @else
                                    <div class="input-group mb-2">

                                        <input type="text" name="nama[]" autocomplete="off" class="form-control">

                                        <button type="button" class="btn btn-danger remove-teknisi">
                                            Hapus
                                        </button>

                                    </div>

                                @endif

                            </div>

                            <button type="button" class="btn btn-primary btn-sm" id="add-teknisi">

                                + Tambah Teknisi

                            </button>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Tanggal</label>

                            <input type="date" name="tanggal" class="form-control" value="{{ $data->tanggal }}">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Jam Mulai</label>

                            <input type="time" name="jam_mulai" class="form-control" value="{{ $data->jam_mulai }}">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Jam Selesai</label>

                            <input type="time" name="jam_selesai" class="form-control"
                                value="{{ $data->jam_selesai }}">

                        </div>

                        <div class="col-md-12 mb-3">

                            <label>Pekerjaan</label>

                            <textarea name="pekerjaan" autocomplete="off" class="form-control" rows="4">{{ $data->pekerjaan }}</textarea>

                        </div>

                    </div>

                    <hr>

                    {{-- =========================
                    TINDAKAN
                ========================== --}}

                    <h5 class="mb-3">
                        Tindakan
                    </h5>

                    <div class="row">

                        <div class="col-md-4 mb-2">

                            <input type="checkbox" name="komponen_diganti"
                                {{ $data->komponen_diganti ? 'checked' : '' }}>

                            Komponen Diganti

                        </div>

                        <div class="col-md-4 mb-2">

                            <input type="checkbox" name="diperiksa_disetel"
                                {{ $data->diperiksa_disetel ? 'checked' : '' }}>

                            Diperiksa dan Disetel

                        </div>

                        <div class="col-md-4 mb-2">

                            <input type="checkbox" name="diperbaiki_dibuat"
                                {{ $data->diperbaiki_dibuat ? 'checked' : '' }}>

                            Diperbaiki dengan Dibuat

                        </div>

                        <div class="col-md-4 mb-2">

                            <input type="checkbox" name="dimodifikasi" {{ $data->dimodifikasi ? 'checked' : '' }}>

                            Dimodifikasi

                        </div>

                        <div class="col-md-4 mb-2">

                            <input type="checkbox" name="dipindah_pasang_baru"
                                {{ $data->dipindah_pasang_baru ? 'checked' : '' }}>

                            Dipindah Pasang Baru

                        </div>

                        <div class="col-md-4 mb-2">

                            <input type="checkbox" name="diperlukan_evaluasi"
                                {{ $data->diperlukan_evaluasi ? 'checked' : '' }}>

                            Diperlukan Evaluasi

                        </div>

                        <div class="col-md-4 mb-2">

                            <input type="checkbox" name="lain_lain_tindakan"
                                {{ $data->lain_lain_tindakan ? 'checked' : '' }}>

                            Lain-lain

                        </div>

                    </div>

                    <hr>

                    {{-- =========================
                    SPAREPART
                ========================== --}}

                    <h5 class="mb-3">
                        Sparepart / material yang digunakan
                    </h5>

                    <div class="row">

                        {{-- Edit Form --}}

                        @php

                            $namaBarang = json_decode($data->nama_barang, true) ?? [];
                            $kodeBarang = json_decode($data->kode_barang, true) ?? [];
                            $jumlahBarang = json_decode($data->jumlah, true) ?? [];

                        @endphp

                        <div class="mb-3">

                            <div id="sparepart-wrapper">

                                @if (count($namaBarang))

                                    @foreach ($namaBarang as $i => $barang)
                                        <div class="row sparepart-item mb-2">

                                            <div class="col-md-4">

                                                <input type="text" autocomplete="off" name="nama_barang[]"
                                                    class="form-control" value="{{ $barang }}">

                                            </div>

                                            <div class="col-md-4">

                                                <input type="text" autocomplete="off" name="kode_barang[]"
                                                    class="form-control" value="{{ $kodeBarang[$i] ?? '' }}">

                                            </div>

                                            <div class="col-md-3">

                                                <input type="text" autocomplete="off" name="jumlah[]"
                                                    class="form-control" value="{{ $jumlahBarang[$i] ?? '' }}">

                                            </div>

                                            <div class="col-md-1">

                                                <button type="button" class="btn btn-danger remove-sparepart">

                                                    Hapus

                                                </button>

                                            </div>

                                        </div>
                                    @endforeach
                                @else
                                    <div class="row sparepart-item mb-2">

                                        <div class="col-md-4">
                                            <label>Nama Barang</label>
                                            <input type="text" name="nama_barang[]" class="form-control">

                                        </div>

                                        <div class="col-md-4">
                                            <label>Kode Barang</label>
                                            <input type="text" name="kode_barang[]" class="form-control">

                                        </div>

                                        <div class="col-md-3">
                                            <label>Jumlah</label>
                                            <input type="text" name="jumlah[]" class="form-control">

                                        </div>

                                        <div class="col-md-1">

                                            <button type="button" class="btn btn-danger remove-sparepart">

                                                Hapus

                                            </button>

                                        </div>

                                    </div>

                                @endif

                            </div>

                            <button type="button" class="btn btn-primary btn-sm mt-2" id="add-sparepart">

                                + Tambah Barang

                            </button>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Tanggal Selesai</label>

                            <input type="date" name="tanggal_selesai" class="form-control"
                                value="{{ $data->tanggal_selesai }}">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Jam Selesai</label>

                            <input type="time" name="jam_selesai_detail" class="form-control"
                                value="{{ $data->jam_selesai_detail }}">

                        </div>

                        <div class="col-md-12 mb-3">

                            <label>Detail Penyelesaian</label>

                            <textarea name="detail_penyelesaian" autocomplete="off" class="form-control" rows="4">{{ $data->detail_penyelesaian }}</textarea>

                        </div>

                    </div>

                    <div class="text-end">

                        <button type="submit" class="btn btn-warning">

                            <i class="fas fa-save"></i>
                            Update Data

                        </button>

                        <a href="{{ route('lp3m.index') }}" class="btn btn-secondary">

                            Kembali

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>
        document.getElementById('add-teknisi').addEventListener('click', function() {

            let wrapper = document.getElementById('teknisi-wrapper');

            let html = `
            <div class="input-group mb-2">

                <input type="text"
                       name="nama[]"
                       class="form-control" autocomplete="off"
                       placeholder="Masukkan nama teknisi">

                <button type="button"
                        class="btn btn-danger remove-teknisi">
                    Hapus
                </button>

            </div>
        `;

            wrapper.insertAdjacentHTML('beforeend', html);

        });

        document.addEventListener('click', function(e) {

            if (e.target.classList.contains('remove-teknisi')) {

                e.target.parentElement.remove();

            }

        });
    </script>

    {{-- Sparepart --}}
    <script>
        document.getElementById('add-sparepart')
            .addEventListener('click', function() {

                let wrapper = document.getElementById('sparepart-wrapper');

                let html = `
        <div class="row sparepart-item mb-2">

            <div class="col-md-4">
                <input type="text"
                       name="nama_barang[]"
                       class="form-control"
                       placeholder="Nama Barang">
            </div>

            <div class="col-md-4">
                <input type="text"
                       name="kode_barang[]"
                       class="form-control"
                       placeholder="Kode Barang">
            </div>

            <div class="col-md-3">
                <input type="text"
                       name="jumlah[]"
                       class="form-control"
                       placeholder="Jumlah">
            </div>

            <div class="col-md-1">
                <button type="button"
                        class="btn btn-danger remove-sparepart">
                    Hapus
                </button>
            </div>

        </div>
    `;

                wrapper.insertAdjacentHTML('beforeend', html);

            });

        document.addEventListener('click', function(e) {

            if (e.target.classList.contains('remove-sparepart')) {

                e.target.closest('.sparepart-item').remove();

            }

        });
    </script>

    {{-- Modal Riwayat No.SPR --}}
    <div class="modal fade" id="modalRiwayatSpr" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content border-0 shadow">

                <div class="modal-header bg-danger text-white">

                    <h5 class="modal-title">

                        <i class="fas fa-history me-2"></i>

                        Riwayat SPR

                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body riwayat-modal-body">

                    <table class="table table-bordered table-hover align-middle mb-0">

                        <thead>

                            <tr class="sticky-header">

                                <th width="60" class="text-center">
                                    No
                                </th>

                                <th>
                                    Nomor SPR
                                </th>

                                <th width="180">
                                    Tanggal Dibuat
                                </th>

                            </tr>

                        </thead>

                        <tbody id="riwayatSprBody">

                            <tr>

                                <td colspan="3" class="text-center">

                                    <div class="py-3">

                                        <i class="fas fa-spinner fa-spin"></i>

                                        Loading...

                                    </div>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                        Tutup

                    </button>

                </div>

            </div>

        </div>

    </div>

    {{-- Riwayat No.SPR --}}
    <script>
        document.getElementById('modalRiwayatSpr')
            .addEventListener('show.bs.modal', function() {

                fetch("{{ route('lp3m.riwayatSpr') }}")

                    .then(response => response.json())

                    .then(data => {

                        let html = '';

                        if (data.length === 0) {

                            html = `
                    <tr>
                        <td colspan="3" class="text-center">
                            Belum ada data SPR
                        </td>
                    </tr>
                `;

                        } else {

                            data.forEach((item, index) => {

                                html += `
                        <tr>

                            <td>${index+1}</td>

                            <td>

                                <span class="badge bg-danger">

                                    ${item.spr_no}

                                </span>

                            </td>

                            <td>

                                ${new Date(item.created_at)
                                    .toLocaleDateString('id-ID')}

                            </td>

                        </tr>
                    `;

                            });

                        }

                        document
                            .getElementById('riwayatSprBody')
                            .innerHTML = html;

                    });

            });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
