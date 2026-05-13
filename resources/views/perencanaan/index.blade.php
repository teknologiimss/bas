@extends('layouts.main')
@section('title', 'Perencanaan Pekerjaan')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')

    <style>
        body {
            background: #f5f6fa;
        }

        /* ====== CARD TABLE ====== */
        .table-excel {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
            animation: fadeUp 0.5s ease;
        }

        .table-excel th,
        .table-excel td {
            border: 1px solid #eee;
            padding: 8px;
            font-size: 13px;
        }

        .header {
            background: linear-gradient(135deg, #c40000, #7a0000);
            color: #fff;
            font-weight: bold;
        }

        /* ====== ROW STYLE ====== */
        .plan {
            background: #fff;
            transition: 0.25s ease;
        }

        .plan:hover {
            background: #fff5f5;
            transform: scale(1.01);
        }

        .realisasi {
            background: #fff;
            transition: 0.25s ease;
        }

        .realisasi:hover {
            background: #fff0f0;
            transform: scale(1.01);
        }

        /* ====== TITLE ====== */
        h5 {
            color: #b30000;
            font-weight: 700;
        }

        /* ====== BUTTON RED THEME ====== */
        .btn-success {
            background: linear-gradient(135deg, #c40000, #7a0000) !important;
            border: none !important;
            border-radius: 10px !important;
            transition: 0.2s;
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(196, 0, 0, 0.3);
        }

        .btn-primary {
            border-radius: 10px;
        }

        .btn-warning {
            border-radius: 10px;
        }

        .btn-danger {
            border-radius: 10px;
        }

        /* ====== MODAL ====== */
        .modal-content {
            border-radius: 18px;
            overflow: hidden;
            animation: pop 0.25s ease;
        }

        .modal-header {
            background: linear-gradient(135deg, #c40000, #7a0000);
            color: white;
        }

        .edit-judul {
            color: #eee;
        }


        /* ====== INPUT ====== */
        .form-control {
            border-radius: 10px;
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
                transform: scale(0.9);
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
            transition: 0.2s ease;
        }

        button:active,
        a:active {
            transform: scale(0.95);
        }

        /* ====== SECTION ANIMATION ====== */
        .col-md-6 {
            animation: fadeUp 0.6s ease;
        }


        /* =========================
       RESPONSIVE MOBILE
    ========================= */
        @media (max-width: 768px) {

            body {
                overflow-x: hidden;
            }

            /* ROW */
            .row {
                margin: 0 !important;
            }

            .col-md-6 {
                padding: 0 !important;
                margin-bottom: 20px;
            }

            /* TITLE */
            h5 {
                font-size: 16px;
                text-align: center;
            }

            /* BUTTON TAMBAH */
            .btn-success.mb-3 {
                width: 100%;
                height: 42px;
                font-size: 13px !important;
            }

            /* TABLE */
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

            /* HEADER TABLE */
            .header td {
                font-size: 11px;
                padding: 8px 6px;
            }

            /* BUTTON DALAM TABLE */
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

            /* FORM DELETE */
            .table-excel form {
                display: inline-flex !important;
            }

            /* MODAL */
            .modal-dialog {
                margin: 10px;
            }

            .modal-content {
                border-radius: 14px;
            }

            .modal-body {
                padding: 15px;
            }

            /* INPUT */
            .form-control,
            select.form-control {
                font-size: 13px;
                height: 40px;
            }

            textarea.form-control {
                height: auto;
            }

            /* FOOTER BUTTON */
            .modal-footer {
                gap: 10px;
            }

            .modal-footer .btn {
                flex: 1;
                height: 40px;
                font-size: 13px !important;
            }

            /* LAMPIRAN */
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

            /* BUTTON HAPUS LAMPIRAN */
            .lampiran-item .btn-danger {
                width: 100%;
                height: 38px;
            }

            /* BUTTON TAMBAH LAMPIRAN */
            .btn-sm.btn-primary {
                width: 100%;
                height: 40px;
                margin-top: 10px;
                font-size: 12px !important;
            }

            /* FILE LINK */
            a[target="_blank"] {
                font-size: 12px;
                word-break: break-word;
            }

            /* TEXT */
            td,
            small,
            label {
                font-size: 11px;
            }

        }

        /* BUTTON AKSI */
.btn-action-mobile {
    width: 38px;
    height: 38px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    padding: 0 !important;
    border-radius: 10px !important;
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
                <table class="table-excel mb-3">

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
                                    <button class="btn btn-danger btn-action-mobile" onclick="return confirm('hapus data?')">
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
                <table class="table-excel mb-3">

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
                            <td>

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
                        <option>Packing</option>
                        <option>Loading</option>
                        <option>Tenaga Orang</option>
                    </select>

                    <input type="text" name="uraian" class="form-control mb-2" autocomplete="off" placeholder="Uraian">
                    <input type="number" name="qty" class="form-control mb-2" autocomplete="off" placeholder="Qty">
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
                            <input type="text" name="uraian" autocomplete="off" value="{{ $d->uraian }}"
                                class="form-control mb-2">
                            <input type="number" name="qty" autocomplete="off" value="{{ $d->qty }}"
                                class="form-control mb-2">
                            <input type="text" name="satuan" autocomplete="off" value="{{ $d->satuan }}"
                                class="form-control mb-2">
                            <input type="text" name="keterangan" autocomplete="off" value="{{ $d->keterangan }}"
                                class="form-control mb-2">
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
                            <input type="text" name="uraian" autocomplete="off" value="{{ $d->uraian }}"
                                class="form-control mb-2">
                            <input type="number" name="qty" autocomplete="off" value="{{ $d->qty }}"
                                class="form-control mb-2">
                            <input type="text" name="satuan" autocomplete="off" value="{{ $d->satuan }}"
                                class="form-control mb-2">
                            <input type="text" name="keterangan" autocomplete="off" value="{{ $d->keterangan }}"
                                class="form-control mb-2">

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
