@extends('layouts.main')

@section('title', 'Buat Checksheet Harian Fasilitas')

@section('content')

    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background: #eef3f8;
            font-family: "Segoe UI", sans-serif;
        }

        /* ===========================
           PAGE TITLE
        =========================== */

        .page-title {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 22px;
        }

        .page-title i {
            color: #1e3a8a;
            margin-right: 6px;
        }

        /* ===========================
           CARD
        =========================== */

        .main-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .08);
            animation: fadeUp .4s ease;
        }

        .card-header-red {
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            color: white;
            border: none;
            padding: 18px 24px;
        }

        .card-header-red h5 {
            margin: 0;
            font-weight: 600;
        }

        /* ===========================
           FORM
        =========================== */

        label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-control,
        .form-select,
        select {
            height: 46px;
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            transition: .25s;
            box-shadow: none;
        }

        textarea.form-control {
            height: auto;
        }

        .form-control:focus,
        .form-select:focus,
        select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 .18rem rgba(37, 99, 235, .15);
        }

        /* ===========================
           ITEM
        =========================== */

        .item-row {
            background: #ffffff;
            border-radius: 15px;
            padding: 18px;
            margin-bottom: 18px;
            border-left: 5px solid #1e3a8a;
            box-shadow: 0 4px 18px rgba(15, 23, 42, .06);
            transition: .25s;
            animation: fadeUp .3s ease;
        }

        .item-row:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(15, 23, 42, .12);
        }

        /* ===========================
           BUTTON
        =========================== */

        .btn {
            border-radius: 12px;
            transition: .25s;
            font-weight: 600;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            border: none;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #172554, #1d4ed8);
            box-shadow: 0 10px 25px rgba(37, 99, 235, .25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
        }

        .btn-secondary {
            background: #64748b;
            border: none;
        }

        .btn-secondary:hover {
            background: #475569;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            border: none;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #b91c1c, #dc2626);
        }

        .btn-light {
            background: white;
            color: #1e3a8a;
            border: 1px solid #cbd5e1;
        }

        .btn-light:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        /* ===========================
           ACTION BUTTON
        =========================== */

        .action-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn-action {
            min-width: 190px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            border-radius: 12px;
            font-weight: 600;
        }

        /* ===========================
           INPUT GROUP
        =========================== */

        #itemsContainer input[type=text],
        #itemsContainer input[type=number] {
            border-radius: 10px;
        }

        /* ===========================
           SCROLLBAR
        =========================== */

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 20px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        /* ===========================
           ANIMATION
        =========================== */

        @keyframes fadeUp {

            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===========================
           MOBILE
        =========================== */

        @media (max-width:768px) {

            .container-fluid {
                padding-left: 10px;
                padding-right: 10px;
            }

            .page-title {
                font-size: 22px;
                text-align: center;
            }

            .card-header-red {
                padding: 14px 16px;
            }

            .item-row {
                padding: 14px;
            }

            .item-row .row>div {
                margin-bottom: 10px;
            }

            .btn {
                width: 100%;
                margin-bottom: 8px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
                min-width: 100%;
                height: 46px;
            }

            .form-control,
            select {
                height: 42px;
                font-size: 14px;
            }

            label {
                font-size: 13px;
            }
        }
    </style>

    <div class="container-fluid mt-3">

        <h3 class="page-title">

            <i class="fa fa-clipboard-list"></i>

            Buat Checksheet Harian Fasilitas

        </h3>

        <form action="{{ route('fasilitas-harian.store') }}" method="POST">

            @csrf

            {{-- HEADER --}}
            <div class="card main-card mb-4">

                <div class="card-header card-header-red">

                    <h5 class="mb-0">

                        Data Checksheet

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="fw-bold">
                                Judul
                            </label>

                            <input type="text" name="judul" class="form-control" required autocomplete="off"
                                placeholder="Contoh : Checksheet Harian Fasilitas">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-bold">
                                Nomor Dokumen
                            </label>

                            <input type="text" name="nomor_dokumen" class="form-control" autocomplete="off">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-bold">
                                Nomor Fasilitas
                            </label>

                            <input type="text" name="nomor_fasilitas" class="form-control" autocomplete="off">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-bold">
                                Nomor Sertifikasi
                            </label>

                            <input type="text" name="nomor_sertifikasi" class="form-control" autocomplete="off">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-bold">
                                Nama Alat
                            </label>

                            <input type="text" name="nama_alat" class="form-control" autocomplete="off">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-bold">
                                Lokasi
                            </label>

                            <input type="text" name="lokasi" class="form-control" autocomplete="off"
                                placeholder="Workshop PPC Timur">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-bold">
                                Bulan
                            </label>

                            <select name="bulan" class="form-control" required>

                                <option value="">
                                    Pilih Bulan
                                </option>

                                <option>Januari</option>
                                <option>Februari</option>
                                <option>Maret</option>
                                <option>April</option>
                                <option>Mei</option>
                                <option>Juni</option>
                                <option>Juli</option>
                                <option>Agustus</option>
                                <option>September</option>
                                <option>Oktober</option>
                                <option>November</option>
                                <option>Desember</option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-bold">
                                Tahun
                            </label>

                            <input type="number" name="tahun" class="form-control" value="{{ date('Y') }}" required>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ITEM --}}
            <div class="card main-card mb-4">

                <div class="card-header card-header-red">

                    <div class="d-flex justify-content-between">

                        <span>

                            Daftar Pekerjaan

                        </span>

                        <button type="button" class="btn btn-light btn-sm" onclick="addItem()">

                            <i class="fa fa-plus"></i>

                            Tambah Item

                        </button>

                    </div>

                </div>

                <div class="card-body">

                    <div id="itemsContainer">

                    </div>

                </div>

            </div>

            {{-- ACTION BUTTON --}}
            <div class="mt-4 d-flex flex-wrap action-buttons">

                <a href="{{ route('fasilitas-harian.index') }}" class="btn btn-secondary btn-action">

                    <i class="fa fa-arrow-left"></i>
                    Kembali

                </a>

                <button type="submit" class="btn btn-success btn-action">

                    <i class="fa fa-save"></i>
                    Simpan Checksheet

                </button>

            </div>

        </form>

    </div>

    <script>
        let indexItem = 0;

        function addItem() {

            let html = `

    <div class="item-row">

        <div class="row">

            <div class="col-md-2 mb-2">

                <label>
                    Nomor
                </label>

                <input
                    type="number"
                    class="form-control"
                    name="items[${indexItem}][nomor]"
                    value="${indexItem + 1}"
                    required>

            </div>

            <div class="col-md-4 mb-2">

                <label>
                    Uraian Pekerjaan
                </label>

                <input
                    type="text"
                    class="form-control"
                    name="items[${indexItem}][uraian]"
                    required
                    autocomplete="off">

            </div>

            <div class="col-md-5 mb-2">

    <label>Aktivitas Pekerjaan</label>

    <div id="aktivitas-${indexItem}">
    
        <input
            type="text"
            class="form-control mb-2"
            name="items[${indexItem}][aktivitas][]"
            placeholder="Aktivitas 1">

    </div>

    <button
        type="button"
        class="btn btn-success btn-sm mt-1"
        onclick="addAktivitas(${indexItem})">

        + Aktivitas

    </button>

</div>

            <div class="col-md-1 mb-2">

                <label>
                    Hapus
                </label>

                <button
                    type="button"
                    class="btn btn-danger"
                    onclick="removeItem(this)">

                    <i class="fa fa-trash"></i>

                </button>

            </div>

        </div>

    </div>

    `;

            document
                .getElementById(
                    'itemsContainer'
                )
                .insertAdjacentHTML(
                    'beforeend',
                    html
                );

            indexItem++;

        }

        function removeItem(btn) {
            btn.closest('.item-row').remove();
        }

        /* otomatis 1 item */

        window.onload = function() {
            addItem();
        };
    </script>

    <script>
        function addAktivitas(index) {
            let html = `

    <input type="text" class="form-control mb-2" name="items[${index}][aktivitas][]" placeholder="Aktivitas">

    `;

            document
                .getElementById(
                    'aktivitas-' + index
                )
                .insertAdjacentHTML(
                    'beforeend',
                    html
                );
        }
    </script>

@endsection
