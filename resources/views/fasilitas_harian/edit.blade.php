@extends('layouts.main')

@section('title', 'Edit Checksheet Harian Fasilitas')

@section('content')

    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background: #f4f6f9;
        }

        .page-title {
            font-weight: 700;
            color: #b30000;
            margin-bottom: 20px;
        }

        .main-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
        }

        .card-header-red {
            background: linear-gradient(135deg,
                    #b30000,
                    #ff2d2d);
            color: white;
        }

        .item-row {

            background: white;

            border-radius: 15px;

            padding: 15px;

            margin-bottom: 15px;

            border-left: 5px solid #b30000;

            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);

            animation: fadeIn .25s ease;
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

        .btn-save {

            height: 50px;

            border-radius: 12px;

            font-weight: 700;
        }

        @media(max-width:768px) {

            .btn {
                width: 100%;
                margin-bottom: 5px;
            }

            .item-row {
                padding: 12px;
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

            <button class="btn btn-success btn-save">

                <i class="fa fa-save"></i>

                Update Checksheet

            </button>

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
    </script>

@endsection
