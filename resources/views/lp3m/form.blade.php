@extends('layouts.main')
@section('title', 'Form Lembar Pekerjaan Perbaikan Perawatan Fasilitas')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')
    <style>
        body {
            background: #f5f6fa;
        }

        .main-card {
            border-radius: 18px;
            overflow: hidden;
            animation: fadeIn 0.5s ease;
        }

        .card {
            border: none;
        }

        .card-body {
            padding: 25px;
        }

        h5 {
            color: #c82333;
            font-weight: 700;
            margin-bottom: 15px;
        }

        hr {
            border-top: 2px solid #f1b0b7;
        }

        label {
            font-weight: 600;
            margin-bottom: 6px;
            color: #444;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
            padding: 10px 12px;
        }

        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 10px rgba(220, 53, 69, 0.2);
        }

        .btn {
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #b02a37);
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff4d4d, #dc3545);
            border: none;
        }

        .input-group .btn {
            border-radius: 0 10px 10px 0;
        }

        input[type="checkbox"] {
            transform: scale(1.2);
            accent-color: #dc3545;
            margin-right: 5px;
        }

        .row>div {
            margin-bottom: 10px;
        }

        @keyframes fadeIn {

            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }

        /* MOBILE */
        @media (max-width:768px) {

            .card-body {
                padding: 15px;
            }

            h5 {
                font-size: 18px;
            }

            .btn {
                width: 100%;
                margin-top: 5px;
            }

            .input-group {
                flex-direction: column;
            }

            .input-group .form-control {
                width: 100%;
                border-radius: 10px;
                margin-bottom: 5px;
            }

            .input-group .btn {
                width: 100%;
                border-radius: 10px;
            }

            .btn-riwayat {
                width: 100%;
                margin-top: 5px;
            }

        }


        .btn-riwayat {
            min-width: 140px;
            font-weight: 600;
            border-radius: 10px;
        }

        .riwayat-modal-body {
            max-height: 500px;
            overflow-y: auto;
        }

        .riwayat-modal-body::-webkit-scrollbar {
            width: 8px;
        }

        .riwayat-modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .riwayat-modal-body::-webkit-scrollbar-thumb {
            background: #dc3545;
            border-radius: 10px;
        }

        .riwayat-modal-body::-webkit-scrollbar-thumb:hover {
            background: #b02a37;
        }

        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 10;
            background: #dc3545;
            color: white;
        }
    </style>

    {{-- <div class="container"> --}}
    <div class="container-fluid mt-3">

        {{-- <div class="card"> --}}
        <div class="card shadow-lg border-0 main-card">
            <div class="card-header bg-danger text-white py-3">

                <h4 class="mb-0">

                    <i class="fas fa-tools me-2"></i>

                    Form Pekerjaan Perbaikan Perawatan Fasilitas

                </h4>

            </div>
            <div class="card-body">

                <form action="{{ route('lp3m.saveForm', $data->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">

                        <label>Status</label>

                        <select name="status" class="form-control">

                            <option value="OPEN">
                                OPEN
                            </option>

                            <option value="CLOSED">
                                CLOSED
                            </option>

                        </select>

                    </div>
                    {{-- <div class="mb-3">
                        <label>SPR No</label>
                        <input type="text" name="spr_no" autocomplete="off" class="form-control">
                    </div> --}}

                    <div class="mb-3">

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

                        <input type="text" name="spr_no" autocomplete="off" class="form-control">

                    </div>

                    <div class="mb-3">
                        <label>Hasil Pengukuran</label>
                        <textarea name="hasil_pengukuran" autocomplete="off" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Penyebab Kerusakan</label>
                        <textarea name="penyebab_kerusakan" autocomplete="off" class="form-control"></textarea>
                    </div>

                    <hr>

                    <h5>Penyebab Kerusakan</h5>

                    <div class="row">

                        <div class="col-md-4">
                            <input type="checkbox" name="aus"> Aus
                        </div>

                        <div class="col-md-4">
                            <input type="checkbox" name="retak"> Retak/Patah
                        </div>

                        <div class="col-md-4">
                            <input type="checkbox" name="komponen_tak_berfungsi"> Komponen Tak Berfungsi
                        </div>

                        <div class="col-md-4">
                            <input type="checkbox" name="kelebihan_beban"> Kelebihan Beban
                        </div>

                        <div class="col-md-4">
                            <input type="checkbox" name="salah_operasi"> Salah Operasi
                        </div>

                        <div class="col-md-4">
                            <input type="checkbox" name="kelainan"> Kelainan
                        </div>

                        <div class="col-md-4">
                            <input type="checkbox" name="kecelakaan"> Kecelakaan
                        </div>

                        <div class="col-md-4">
                            <input type="checkbox" name="lain_lain_kerusakan"> Lain-lain
                        </div>

                    </div>

                    <hr>

                    <h5>Eksekusi</h5>

                    <div class="row">

                        {{-- <div class="col-md-6 mb-3">
                            <label>Nama Teknisi</label>
                            <input type="text" name="nama" class="form-control">
                        </div> --}}

                        <div class="col-md-12 mb-3">

                            <label>Nama Teknisi</label>

                            <div id="teknisi-wrapper">

                                <div class="input-group mb-2">

                                    <input type="text" name="nama[]" autocomplete="off" class="form-control"
                                        placeholder="Masukkan nama teknisi">

                                    <button type="button" class="btn btn-danger remove-teknisi">
                                        Hapus
                                    </button>

                                </div>

                            </div>

                            <button type="button" class="btn btn-primary btn-sm" id="add-teknisi">

                                + Tambah Teknisi

                            </button>

                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Jam Mulai</label>
                            <input type="time" name="jam_mulai" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Jam Selesai</label>
                            <input type="time" name="jam_selesai" class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Pekerjaan</label>
                            <textarea name="pekerjaan" autocomplete="off" class="form-control"></textarea>
                        </div>

                    </div>

                    <hr>

                    <h5>Tindakan</h5>

                    <div class="row">

                        <div class="col-md-4">
                            <input type="checkbox" name="komponen_diganti"> Komponen Diganti
                        </div>

                        <div class="col-md-4">
                            <input type="checkbox" name="diperiksa_disetel"> Diperiksa dan disetel
                        </div>

                        <div class="col-md-4">
                            <input type="checkbox" name="diperbaiki_dibuat"> Diperbaiki dengan dibuat
                        </div>

                        <div class="col-md-4">
                            <input type="checkbox" name="dimodifikasi"> Dimodifikasi
                        </div>

                        <div class="col-md-4">
                            <input type="checkbox" name="dipindah_pasang_baru"> Dipindah pasang baru
                        </div>

                        <div class="col-md-4">
                            <input type="checkbox" name="diperlukan_evaluasi"> Diperlukan evaluasi
                        </div>

                        <div class="col-md-4">
                            <input type="checkbox" name="lain_lain_tindakan"> Lain-lain
                        </div>

                    </div>

                    <hr>

                    <h5>Sparepart / material yang digunakan</h5>

                    <div class="row">

                        {{-- <div class="col-md-4 mb-3">
                            <label>Nama Barang</label>
                            <input type="text" name="nama_barang" autocomplete="off" class="form-control"
                                placeholder="Masukkan nama barang">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Kode</label>
                            <input type="text" name="kode_barang" autocomplete="off" class="form-control"
                                placeholder="Masukkan kode barang">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" placeholder="0">
                        </div> --}}

                        <div class="col-md-12 mb-3">

                            <label>Sparepart / Material</label>

                            <div id="sparepart-wrapper">

                                <div class="row sparepart-item mb-2">

                                    <div class="col-md-4">
                                        <input type="text" name="nama_barang[]" class="form-control"
                                            placeholder="Nama Barang">
                                    </div>

                                    <div class="col-md-4">
                                        <input type="text" name="kode_barang[]" class="form-control"
                                            placeholder="Kode Barang">
                                    </div>

                                    <div class="col-md-3">
                                        <input type="text" name="jumlah[]" class="form-control" placeholder="Jumlah">
                                    </div>

                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger remove-sparepart">
                                            X
                                        </button>
                                    </div>

                                </div>

                            </div>

                            <button type="button" class="btn btn-primary btn-sm" id="add-sparepart">

                                + Tambah Barang

                            </button>

                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal_selesai" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Jam</label>
                            <input type="time" name="jam_selesai_detail" class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Detail Penyelesaian</label>
                            <textarea name="detail_penyelesaian" autocomplete="off" class="form-control"></textarea>
                        </div>

                    </div>

                    <div class="text-end mt-3">

                        <button class="btn btn-danger px-4 py-2">

                            <i class="fas fa-save"></i>

                            Simpan

                        </button>
                        <a href="{{ route('lp3m.index') }}" class="btn btn-secondary">

                            Kembali

                        </a>

                    </div>

                </form>

            </div>
        </div>

    </div>

    {{-- Teknisi --}}
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
                            X
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
