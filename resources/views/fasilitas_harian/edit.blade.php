@extends('layouts.main')

@section('title', 'Edit Checksheet Harian Fasilitas')

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
            margin-bottom: 24px;
        }

        .page-title i {
            color: #1e3a8a;
            margin-right: 8px;
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
            color: #fff;
            border: none;
            padding: 18px 24px;
        }

        .card-header-red h5 {
            margin: 0;
            font-weight: 600;
        }

        /* ===========================
           LABEL
        =========================== */

        label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        /* ===========================
           FORM CONTROL
        =========================== */

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
            min-height: 90px;
        }

        .form-control:focus,
        .form-select:focus,
        select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .15);
        }

        /* ===========================
           ITEM
        =========================== */

        .item-row {
            background: #fff;
            border-radius: 16px;
            padding: 18px;
            margin-bottom: 18px;
            border-left: 5px solid #1e3a8a;
            box-shadow: 0 4px 16px rgba(15, 23, 42, .06);
            transition: .25s;
            animation: fadeUp .35s ease;
        }

        .item-row:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(15, 23, 42, .12);
        }

        /* ===========================
           INPUT GROUP
        =========================== */

        .input-group .form-control {
            border-radius: 10px 0 0 10px;
        }

        .input-group .btn {
            border-radius: 0 10px 10px 0;
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

        .btn-danger {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            border: none;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #b91c1c, #dc2626);
        }

        .btn-secondary {
            background: #64748b;
            border: none;
        }

        .btn-secondary:hover {
            background: #475569;
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
           SAVE BUTTON
        =========================== */

        .btn-save {
            height: 50px;
            min-width: 190px;
            border-radius: 12px;
            font-weight: 700;
        }

        /* ===========================
           ACTION FOOTER
        =========================== */

        .action-footer {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .action-footer .btn {
            min-width: 190px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
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
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===========================
           MOBILE
        =========================== */

        @media(max-width:768px) {

            .container-fluid {
                padding-left: 10px;
                padding-right: 10px;
            }

            .page-title {
                font-size: 22px;
                text-align: center;
            }

            .card-header-red {
                padding: 15px;
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

            .btn-save {
                width: 100%;
                min-width: 100%;
                height: 46px;
            }

            .action-footer {
                flex-direction: column;
            }

            .form-control,
            select {
                height: 42px;
                font-size: 14px;
            }

            label {
                font-size: 13px;
            }

            .input-group {
                flex-wrap: nowrap;
            }

            .input-group .btn {
                width: auto;
                min-width: 45px;
            }
        }
    </style>

    <div class="container-fluid mt-3">

        <h3 class="page-title">

            <i class="fa fa-edit"></i>

            Edit Checksheet Harian Fasilitas

        </h3>

        <form action="{{ route('fasilitas-harian.update', $data->id) }}" method="POST">

            @csrf
            @method('PUT')

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

                            <input type="text" name="judul" class="form-control" value="{{ $data->judul }}" required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-bold">
                                Nomor Dokumen
                            </label>

                            <input type="text" name="nomor_dokumen" class="form-control"
                                value="{{ $data->nomor_dokumen }}">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-bold">
                                Nomor Fasilitas
                            </label>

                            <input type="text" name="nomor_fasilitas" class="form-control"
                                value="{{ $data->nomor_fasilitas }}">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-bold">
                                Nomor Sertifikasi
                            </label>

                            <input type="text" name="nomor_sertifikasi" class="form-control"
                                value="{{ $data->nomor_sertifikasi }}">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-bold">
                                Nama Alat
                            </label>

                            <input type="text" name="nama_alat" class="form-control" value="{{ $data->nama_alat }}">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-bold">
                                Lokasi
                            </label>

                            <input type="text" name="lokasi" class="form-control" value="{{ $data->lokasi }}">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-bold">
                                Bulan
                            </label>

                            <select name="bulan" class="form-control">

                                @php

                                    $bulan = [
                                        'Januari',
                                        'Februari',
                                        'Maret',
                                        'April',
                                        'Mei',
                                        'Juni',
                                        'Juli',
                                        'Agustus',
                                        'September',
                                        'Oktober',
                                        'November',
                                        'Desember',
                                    ];

                                @endphp

                                @foreach ($bulan as $b)
                                    <option value="{{ $b }}" {{ $data->bulan == $b ? 'selected' : '' }}>

                                        {{ $b }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="fw-bold">
                                Tahun
                            </label>

                            <input type="number" name="tahun" class="form-control" value="{{ $data->tahun }}">

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

                        @foreach ($data->items as $i => $item)
                            <div class="item-row">

                                <input type="hidden" name="items[{{ $i }}][id]" value="{{ $item->id }}">

                                <div class="row">

                                    <div class="col-md-2 mb-2">

                                        <label>
                                            Nomor
                                        </label>

                                        <input type="number" class="form-control" name="items[{{ $i }}][nomor]"
                                            value="{{ $item->nomor }}" required>

                                    </div>

                                    <div class="col-md-4 mb-2">

                                        <label>
                                            Uraian Pekerjaan
                                        </label>

                                        <input type="text" class="form-control"
                                            name="items[{{ $i }}][uraian]"
                                            value="{{ $item->uraian_pekerjaan }}" required>

                                    </div>

                                    {{-- <div class="col-md-5 mb-2">

                                        <label>
                                            Aktivitas Pekerjaan
                                        </label>

                                        <textarea rows="2" class="form-control" name="items[{{ $i }}][aktivitas]" required>{{ $item->aktivitas_pekerjaan }}</textarea>

                                    </div> --}}

                                    <div class="col-md-5 mb-2">

                                        <label class="fw-bold">
                                            Aktivitas Pekerjaan
                                        </label>

                                        <div id="aktivitas-{{ $i }}">

                                            @if ($item->aktivitas->count())
                                                @foreach ($item->aktivitas as $aktivitas)
                                                    <div class="input-group mb-2">

                                                        <input type="text" class="form-control"
                                                            name="items[{{ $i }}][aktivitas][]"
                                                            value="{{ $aktivitas->aktivitas }}" required>

                                                        <button type="button" class="btn btn-danger"
                                                            onclick="removeAktivitas(this)">

                                                            <i class="fa fa-times"></i>

                                                        </button>

                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="input-group mb-2">

                                                    <input type="text" class="form-control"
                                                        name="items[{{ $i }}][aktivitas][]" required>

                                                    <button type="button" class="btn btn-danger"
                                                        onclick="removeAktivitas(this)">

                                                        <i class="fa fa-times"></i>

                                                    </button>

                                                </div>
                                            @endif

                                        </div>

                                        <button type="button" class="btn btn-success btn-sm mt-1"
                                            onclick="addAktivitas({{ $i }})">

                                            <i class="fa fa-plus"></i>
                                            Tambah Aktivitas

                                        </button>

                                    </div>

                                    <div class="col-md-1 mb-2">

                                        <label>
                                            Hapus
                                        </label>

                                        <button type="button" class="btn btn-danger" onclick="removeItem(this)">

                                            <i class="fa fa-trash"></i>

                                        </button>

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>

                </div>

            </div>

            <div class="action-footer d-flex flex-wrap mt-4">

                <a href="{{ route('fasilitas-harian.index') }}" class="btn btn-secondary btn-save">

                    <i class="fa fa-arrow-left"></i>

                    Kembali

                </a>

                <button type="submit" class="btn btn-success btn-save">

                    <i class="fa fa-save"></i>

                    Update Checksheet

                </button>

            </div>

        </form>

    </div>

    <script>
        let indexItem =
            {{ $data->items->count() }};

        //     function addItem() {

        //         let html = `

    // <div class="item-row">

    //     <div class="row">

    //         <div class="col-md-2 mb-2">

    //             <label>Nomor</label>

    //             <input
    //                 type="number"
    //                 class="form-control"
    //                 name="items[${indexItem}][nomor]"
    //                 value="${indexItem + 1}"
    //                 required>

    //         </div>

    //         <div class="col-md-4 mb-2">

    //             <label>
    //                 Uraian Pekerjaan
    //             </label>

    //             <input
    //                 type="text"
    //                 class="form-control"
    //                 name="items[${indexItem}][uraian]"
    //                 required>

    //         </div>

    //         <div class="col-md-5 mb-2">

    //             <label>
    //                 Aktivitas Pekerjaan
    //             </label>

    //             <textarea
    //                 rows="2"
    //                 class="form-control"
    //                 name="items[${indexItem}][aktivitas]"
    //                 required></textarea>

    //         </div>

    //         <div class="col-md-1 mb-2">

    //             <label>
    //                 Hapus
    //             </label>

    //             <button
    //                 type="button"
    //                 class="btn btn-danger"
    //                 onclick="removeItem(this)">

    //                 <i class="fa fa-trash"></i>

    //             </button>

    //         </div>

    //     </div>

    // </div>

    // `;

        //         document
        //             .getElementById('itemsContainer')
        //             .insertAdjacentHTML(
        //                 'beforeend',
        //                 html
        //             );

        //         indexItem++;

        //     }

        function addItem() {

            let html = `

    <div class="item-row">

        <div class="row">

            <div class="col-md-2 mb-2">

                <label>Nomor</label>

                <input type="hidden"
    name="items[{{ $i }}][id]"
    value="{{ $item->id }}">
                <input
                    type="number"
                    class="form-control"
                    name="items[${indexItem}][nomor]"
                    value="${indexItem + 1}"
                    required>

            </div>

            <div class="col-md-4 mb-2">

                <label>Uraian Pekerjaan</label>

                <input
                    type="text"
                    class="form-control"
                    name="items[${indexItem}][uraian]"
                    required>

            </div>

            <div class="col-md-5 mb-2">

                <label>Aktivitas Pekerjaan</label>

                <div id="aktivitas-${indexItem}">

                    <div class="input-group mb-2">

                        <input
                            type="text"
                            class="form-control"
                            name="items[${indexItem}][aktivitas][]"
                            required>

                        <button
                            type="button"
                            class="btn btn-danger"
                            onclick="removeAktivitas(this)">

                            <i class="fa fa-times"></i>

                        </button>

                    </div>

                </div>

                <button
                    type="button"
                    class="btn btn-success btn-sm mt-1"
                    onclick="addAktivitas(${indexItem})">

                    <i class="fa fa-plus"></i>
                    Tambah Aktivitas

                </button>

            </div>

            <div class="col-md-1 mb-2">

                <label>Hapus</label>

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
                .getElementById('itemsContainer')
                .insertAdjacentHTML(
                    'beforeend',
                    html
                );

            indexItem++;
        }


        function addAktivitas(index) {
            let html = `

    <div class="input-group mb-2">

        <input
            type="text"
            class="form-control"
            name="items[${index}][aktivitas][]"
            required>

        <button
            type="button"
            class="btn btn-danger"
            onclick="removeAktivitas(this)">

            <i class="fa fa-times"></i>

        </button>

    </div>

    `;

            document
                .getElementById('aktivitas-' + index)
                .insertAdjacentHTML(
                    'beforeend',
                    html
                );
        }

        function removeAktivitas(btn) {
            btn.closest('.input-group').remove();
        }

        function removeItem(btn) {

            if (!confirm('Hapus item ini?')) {
                return;
            }

            btn.closest('.item-row').remove();
        }
    </script>

@endsection
