@extends('layouts.main')
@section('title', 'Perencanaan Pekerjaan')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')

    <style>
        body {
            background: #f4f7fb;
        }

        /* ====== CARD TABLE ====== */
        .table-excel {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(11, 31, 58, 0.10);
            animation: fadeUp .5s ease;
        }

        .table-excel th,
        .table-excel td {
            border: 1px solid #d6e2f0;
            padding: 8px;
            font-size: 13px;
            vertical-align: middle;
        }

        /* HEADER TABLE */
        .header {
            background: linear-gradient(135deg, #0B1F3A, #1E3A5F);
            color: #fff;
            font-weight: bold;
        }

        /* ====== ROW PLAN ====== */
        .plan {
            background: #fff;
            transition: .25s ease;
        }

        .plan:hover {
            background: #eef5ff;
            transform: scale(1.01);
        }

        /* ====== ROW REALISASI ====== */
        .realisasi {
            background: #fff;
            transition: .25s ease;
        }

        .realisasi:hover {
            background: #e8f2ff;
            transform: scale(1.01);
        }

        /* ====== TITLE ====== */
        h5 {
            color: #0B1F3A;
            font-weight: 700;
        }

        /* ====== BUTTON SUCCESS ====== */
        .btn-success {
            background: linear-gradient(135deg, #0B1F3A, #1E3A5F) !important;
            border: none !important;
            border-radius: 10px !important;
            transition: .25s;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #102B4E, #284C7A) !important;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(11, 31, 58, .35);
        }

        /* ====== BUTTON PRIMARY ====== */
        .btn-primary {
            background: #1E3A5F;
            border: none;
            border-radius: 10px;
            transition: .25s;
        }

        .btn-primary:hover {
            background: #284C7A;
            transform: translateY(-2px);
        }

        /* ====== BUTTON WARNING ====== */
        .btn-warning {
            background: #2E5B88;
            border: none;
            color: white;
            border-radius: 10px;
            transition: .25s;
        }

        .btn-warning:hover {
            background: #24486D;
            color: white;
        }

        /* ====== BUTTON DANGER ====== */
        .btn-danger {
            background: #D9534F;
            border: none;
            border-radius: 10px;
            transition: .25s;
        }

        .btn-danger:hover {
            background: #C9302C;
        }

        /* ====== MODAL ====== */
        .modal-content {
            border-radius: 18px;
            overflow: hidden;
            animation: pop .25s ease;
            border: none;
            box-shadow: 0 10px 30px rgba(11, 31, 58, .15);
        }

        .modal-header {
            background: linear-gradient(135deg, #0B1F3A, #1E3A5F);
            color: white;
            border-bottom: none;
        }

        .edit-judul {
            color: white;
            font-weight: bold;
        }

        /* ====== INPUT ====== */
        .form-control {
            border-radius: 10px;
            border: 1px solid #cfd8e3;
            transition: .25s;
        }

        .form-control:focus {
            border-color: #1E3A5F;
            box-shadow: 0 0 0 .2rem rgba(30, 58, 95, .15);
        }

        /* ====== TABLE EFFECT ====== */
        .plan-table,
        .realisasi-table {
            transition: .25s;
        }

        .plan-table:hover,
        .realisasi-table:hover {
            box-shadow: 0 12px 30px rgba(11, 31, 58, .15);
        }

        /* ====== ANIMATION ====== */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pop {
            from {
                transform: scale(.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* ====== BUTTON ANIMATION ====== */
        button,
        a {
            transition: .2s ease;
        }

        button:active,
        a:active {
            transform: scale(.95);
        }

        /* ====== COLUMN ANIMATION ====== */
        .col-md-6 {
            animation: fadeUp .6s ease;
        }

        /* =========================
           RESPONSIVE MOBILE
        ========================= */

        @media (max-width:768px) {

            body {
                overflow-x: hidden;
            }

            .row {
                margin: 0 !important;
            }

            .col-md-6 {
                padding: 0 !important;
                margin-bottom: 20px;
            }

            h5 {
                font-size: 16px;
                text-align: center;
            }

            .btn-success.mb-3 {
                width: 100%;
                height: 42px;
                font-size: 13px !important;
            }

            .table-excel {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
                border-radius: 12px;
            }

            .table-excel th,
            .table-excel td {
                font-size: 11px;
                padding: 6px;
                vertical-align: middle;
            }

            .header td {
                font-size: 11px;
                padding: 8px 6px;
            }

            .table-excel .btn {
                width: 32px;
                height: 32px;
                padding: 0 !important;
                font-size: 12px !important;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 8px !important;
            }

            .table-excel form {
                display: inline-flex !important;
            }

            .modal-dialog {
                margin: 10px;
            }

            .modal-content {
                border-radius: 14px;
            }

            .modal-body {
                padding: 15px;
            }

            .form-control,
            select.form-control {
                font-size: 13px;
                height: 40px;
            }

            textarea.form-control {
                height: auto;
            }

            .modal-footer {
                gap: 10px;
            }

            .modal-footer .btn {
                flex: 1;
                height: 40px;
                font-size: 13px !important;
            }

            .lampiran-item {
                flex-direction: column;
            }

            .lampiran-item .col-md-5,
            .lampiran-item .col-md-2,
            .row.align-items-center .col-md-4,
            .row.align-items-center .col-md-3,
            .row.align-items-center .col-md-1 {
                width: 100%;
                max-width: 100%;
                flex: 100%;
                margin-bottom: 8px;
            }

            .lampiran-item .btn-danger {
                width: 100%;
                height: 38px;
            }

            .btn-sm.btn-primary {
                width: 100%;
                height: 40px;
                margin-top: 10px;
                font-size: 12px !important;
            }

            a[target="_blank"] {
                font-size: 12px;
                word-break: break-word;
            }

            td,
            small,
            label {
                font-size: 11px;
            }
        }

        /* BUTTON AKSI */
        .btn-action-mobile {
            width: 22px;
            height: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 !important;
            border-radius: 8px !important;
        }
    </style>

    <!-- ================= BUTTON TAMBAH ================= -->
    <button class="btn btn-success mb-3" data-toggle="modal" data-target="#modalTambah">
        + Tambah Data
    </button>

    <div class="row">

        <!-- ================= PLAN ================= -->
        <div class="col-md-6">
            <h5>PERENCANAAN</h5>

            @foreach ($plan as $kategori => $items)
                <table class="table-excel mb-3 plan-table">

                    <tr class="header">
                        <td colspan="6">{{ strtoupper($kategori) }}</td>
                    </tr>

                    <tr class="header">
                        <td>No</td>
                        <td>Uraian</td>
                        <td>Qty</td>
                        <td>Satuan</td>
                        <td>Keterangan</td>
                        <td>Aksi</td>
                    </tr>

                    @foreach ($items as $i => $d)
                        <tr class="plan">
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $d->uraian }}</td>
                            <td>{{ $d->qty }}</td>
                            <td>{{ $d->satuan }}</td>
                            <td>{{ $d->keterangan }}</td>
                            <td>

                                <button class="btn btn-warning btn-action-mobile" data-toggle="modal"
                                    data-target="#edit-plan-{{ $d->id }}">
                                    ✏️
                                </button>

                                <form action="{{ route('perencanaan.delete', $d->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-action-mobile"
                                        onclick="return confirm('hapus data?')">
                                        🗑️
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </table>
            @endforeach
        </div>

        <!-- ================= REALISASI ================= -->
        <div class="col-md-6">
            <h5>REALISASI</h5>

            @foreach ($realisasi as $kategori => $items)
                <table class="table-excel mb-3 realisasi-table">

                    <tr class="header">
                        <td colspan="7">{{ strtoupper($kategori) }}</td>
                    </tr>

                    <tr class="header">
                        <td>No</td>
                        <td>Uraian</td>
                        <td>Qty</td>
                        <td>Satuan</td>
                        <td>Keterangan</td>
                        <td>lampiran</td>
                        <td>Aksi</td>
                    </tr>

                    @foreach ($items as $i => $d)
                        <tr class="realisasi">
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $d->uraian }}</td>
                            <td>{{ $d->qty }}</td>
                            <td>{{ $d->satuan }}</td>
                            <td>{{ $d->keterangan }}</td>
                            <td>
                                @foreach ($d->lampiran as $l)
                                    <div>
                                        <a href="{{ asset('lampiran/' . $l->file) }}" target="_blank">
                                            📎 Lihat File
                                        </a>
                                        <small>({{ $l->keterangan }})</small>
                                    </div>
                                @endforeach
                            </td>
                            {{-- <td>

                                <button class="btn btn-xs btn-warning" data-toggle="modal"
                                    data-target="#edit-real-{{ $d->id }}">
                                    ✏️
                                </button>

                                <form action="{{ route('perencanaan.delete', $d->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-danger">
                                        🗑️
                                    </button>
                                </form>

                            </td> --}}

                            <td>

                                <button class="btn btn-warning btn-action-mobile" data-toggle="modal"
                                    data-target="#edit-real-{{ $d->id }}">
                                    ✏️
                                </button>

                                <form action="{{ route('perencanaan.delete', $d->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-action-mobile"
                                        onclick="return confirm('hapus data?')">
                                        🗑️
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach

                </table>
            @endforeach
        </div>

    </div>

    <!-- ================= MODAL TAMBAH ================= -->
    <div class="modal fade" id="modalTambah">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('perencanaan.store') }}" class="modal-content">

                @csrf

                <div class="modal-header">
                    <h5 class="edit-judul">Tambah Data</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="proyek_id" value="{{ $proyek_id }}">

                    <select name="tipe" class="form-control mb-2">
                        <option value="plan">PLAN</option>
                        <option value="realisasi">REALISASI</option>
                    </select>

                    <select name="kategori" class="form-control mb-2">
                        <option>Tools</option>
                        <option>Consumable</option>
                        <option>Packing & Loading</option>
                        <option>Tenaga Orang</option>
                    </select>

                    <input type="text" name="uraian" class="form-control mb-2" autocomplete="off" placeholder="Uraian">
                    <input type="text" name="qty" class="form-control mb-2" autocomplete="off" placeholder="Qty">
                    <input type="text" name="satuan" class="form-control mb-2" autocomplete="off" placeholder="Satuan">
                    <input type="text" name="keterangan" class="form-control mb-2" autocomplete="off"
                        placeholder="Keterangan">


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-success">Simpan</button>
                </div>

            </form>
        </div>
    </div>

    <!-- MODAL EDIT PLAN -->
    @foreach ($plan as $kategori => $items)
        @foreach ($items as $d)
            <div class="modal fade" id="edit-plan-{{ $d->id }}">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('perencanaan.update', $d->id) }}" class="modal-content">

                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="edit-judul">Edit PLAN</h5>
                        </div>

                        <div class="modal-body">

                            <label>Uraian Pekerjaan</label>
                            <input type="text" name="uraian" autocomplete="off" value="{{ $d->uraian }}"
                                class="form-control mb-3">

                            <label>Qty</label>
                            <input type="text" name="qty" autocomplete="off" value="{{ $d->qty }}"
                                class="form-control mb-3">

                            <label>Satuan</label>
                            <input type="text" name="satuan" autocomplete="off" value="{{ $d->satuan }}"
                                class="form-control mb-3">

                            <label>Keterangan</label>
                            <input type="text" name="keterangan" autocomplete="off" value="{{ $d->keterangan }}"
                                class="form-control">

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success">Update</button>
                        </div>

                    </form>
                </div>
            </div>
        @endforeach
    @endforeach

    <!-- MODAL EDIT REALISASI -->
    @foreach ($realisasi as $kategori => $items)
        @foreach ($items as $d)
            <div class="modal fade" id="edit-real-{{ $d->id }}">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('perencanaan.update', $d->id) }}"
                        enctype="multipart/form-data" class="modal-content">

                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="edit-judul">Edit REALISASI</h5>
                        </div>

                        <div class="modal-body">
                            <label>Uraian Pekerjaan</label>
                            <input type="text" name="uraian" autocomplete="off" value="{{ $d->uraian }}"
                                class="form-control mb-3">

                            <label>Qty</label>
                            <input type="text" name="qty" autocomplete="off" value="{{ $d->qty }}"
                                class="form-control mb-3">

                            <label>Satuan</label>
                            <input type="text" name="satuan" autocomplete="off" value="{{ $d->satuan }}"
                                class="form-control mb-3">

                            <label>Keterangan Pekerjaan</label>
                            <input type="text" name="keterangan" autocomplete="off" value="{{ $d->keterangan }}"
                                class="form-control mb-3">




                            <hr>
                            <h6>Lampiran Lama</h6>

                            @foreach ($d->lampiran as $l)
                                <div class="row mb-2 align-items-center">
                                    <div class="col-md-4">
                                        <a href="{{ asset('lampiran/' . $l->file) }}" target="_blank">
                                            📎 Lihat File
                                        </a>
                                    </div>

                                    <div class="col-md-4">
                                        <input type="text" autocomplete="off"
                                            name="old_keterangan[{{ $l->id }}]" value="{{ $l->keterangan }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-3">
                                        <input type="file" name="replace_file[{{ $l->id }}]"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-1">
                                        <input type="checkbox" name="hapus_lampiran[]" value="{{ $l->id }}">
                                    </div>
                                </div>
                            @endforeach

                            <hr>
                            <h6>Lampiran Baru</h6>

                            <div id="lampiran-wrapper-{{ $d->id }}">
                                <div class="row mb-2 lampiran-item">
                                    <div class="col-md-5">
                                        <input type="file" name="lampiran[]" class="form-control">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" autocomplete="off" name="lampiran_keterangan[]"
                                            class="form-control" placeholder="Keterangan file">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="hapusLampiran(this)">
                                            ❌
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-sm btn-primary"
                                onclick="tambahLampiran({{ $d->id }})">
                                + Tambah Lampiran
                            </button>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success">Update</button>
                        </div>

                    </form>
                </div>
            </div>
        @endforeach
    @endforeach

@endsection
<script>
    function tambahLampiran(id) {
        let html = `
    <div class="row mb-2 lampiran-item">
        <div class="col-md-5">
            <input type="file" name="lampiran[]" class="form-control">
        </div>
        <div class="col-md-5">
            <input type="text" name="lampiran_keterangan[]" class="form-control" placeholder="Keterangan file">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm" onclick="hapusLampiran(this)">
                ❌
            </button>
        </div>
    </div>`;

        document
            .getElementById('lampiran-wrapper-' + id)
            .insertAdjacentHTML('beforeend', html);
    }
</script>

<script>
    function hapusLampiran(btn) {
        btn.closest('.lampiran-item').remove();
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        function samakanTinggiTabel() {

            let planTables = document.querySelectorAll('.plan-table');
            let realTables = document.querySelectorAll('.realisasi-table');

            // reset height dulu
            planTables.forEach(t => t.style.height = 'auto');
            realTables.forEach(t => t.style.height = 'auto');

            let jumlah = Math.min(planTables.length, realTables.length);

            for (let i = 0; i < jumlah; i++) {

                let tinggiPlan = planTables[i].offsetHeight;
                let tinggiReal = realTables[i].offsetHeight;

                let tinggiTerbesar = Math.max(
                    tinggiPlan,
                    tinggiReal
                );

                planTables[i].style.height =
                    tinggiTerbesar + 'px';

                realTables[i].style.height =
                    tinggiTerbesar + 'px';
            }
        }

        samakanTinggiTabel();

        window.addEventListener('resize', function() {
            samakanTinggiTabel();
        });

    });
</script>
