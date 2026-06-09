@extends('layouts.main')

@section('title', 'Buat Checksheet Harian Fasilitas')

@section('content')

    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background: #f4f6f9;
        }

        /* HEADER */

        .page-title {

            font-weight: 700;

            color: #b30000;

            margin-bottom: 20px;
        }

        /* CARD */

        .main-card {

            border: none;

            border-radius: 20px;

            box-shadow:
                0 5px 20px rgba(0, 0, 0, .08);

            overflow: hidden;
        }

        .card-header-red {

            background:
                linear-gradient(135deg,
                    #b30000,
                    #ff2d2d);

            color: white;
        }

        /* ITEM */

        .item-row {

            background: #fff;

            border-radius: 15px;

            padding: 15px;

            margin-bottom: 15px;

            border-left: 5px solid #b30000;

            box-shadow:
                0 2px 10px rgba(0, 0, 0, .05);

            animation: fadeIn .3s ease;
        }

        @keyframes fadeIn {

            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: none;
            }

        }

        /* BUTTON */

        .btn-add {

            border-radius: 12px;

            font-weight: 600;
        }

        .btn-save {

            border-radius: 12px;

            height: 50px;

            font-weight: 700;
        }

        .btn-remove {

            border-radius: 10px;
        }

        /* MOBILE */

        @media(max-width:768px) {

            .item-row {

                padding: 12px;
            }

            .btn {

                width: 100%;
                margin-bottom: 5px;
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

            {{-- SAVE --}}
            <button class="btn btn-success btn-save">

                <i class="fa fa-save"></i>

                Simpan Checksheet

            </button>

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
    function addAktivitas(index)
    {
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
