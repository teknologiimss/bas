@extends('layouts.main')
@section('title', __('Kode Aset'))
@section('custom-css')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">

    <style>
        /* ===============================
                   🎨 ROOT COLOR
                ================================ */
        :root {
            --maroon: #1f4e79;
            --maroon-dark: #102a43;
            --maroon-light: #4f7cac;
            --maroon-soft: #edf4fc;
            --shadow-maroon: rgba(16, 42, 67, .35);
        }

        /* ===============================
                   🪟 MODAL SCROLL
                ================================ */
        .modal-dialog {
            overflow-y: initial !important;
        }

        .modal-body {
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }

        /* ===============================
                   🔘 BUTTON (ALL WAJIB MAROON)
                ================================ */
        .btn,
        .btn-primary,
        .btn-success,
        .btn-danger,
        .btn-default {
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark)) !important;
            border: none !important;
            color: #fff !important;
            box-shadow: 0 5px 15px var(--shadow-maroon);
            transition: all 0.3s ease;
        }

        /* Hover */
        .btn:hover {
            background: linear-gradient(135deg, var(--maroon-light), var(--maroon)) !important;
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 10px 25px var(--shadow-maroon);
        }

        /* Active / Click */
        .btn:active {
            transform: scale(0.95);
            box-shadow: inset 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        /* Button kecil */
        .btn-xs {
            padding: 4px 8px;
            font-size: 12px;
        }

        /* ===============================
                   🔍 INPUT & SEARCH
                ================================ */
        .form-control {
            border-radius: 6px;
            border: 1px solid var(--maroon);
            transition: all 0.25s ease;
        }

        .form-control:focus {
            border-color: var(--maroon-light);
            box-shadow: 0 0 0 0.2rem var(--maroon-soft);
        }

        /* ===============================
                   📊 TABLE GLOBAL
                ================================ */
        #table {
            border-collapse: separate;
            border-spacing: 0;
        }

        /* HEADER */
        #table th {
            position: relative;
            cursor: pointer;
            user-select: none;
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            color: #fff;
            padding-right: 30px;
            text-align: center;
            transition: all 0.3s ease;
        }

        /* HEADER HOVER */
        #table th:hover {
            background: var(--maroon-light);
        }

        /* SORT ACTIVE */
        #table th.active-sort {
            background: var(--maroon-dark);
            font-weight: bold;
        }

        /* BODY ROW */
        #table tbody tr {
            transition: all 0.25s ease;
        }

        /* ROW HOVER GERAK */
        #table tbody tr:hover {
            background-color: var(--maroon-soft);
            transform: scale(1.01);
            box-shadow: 0 6px 15px rgba(128, 0, 32, 0.2);
        }

        /* CELL */
        #table td {
            vertical-align: middle;
        }

        /* ===============================
                   🔼 SORT BUTTONS
                ================================ */
        .sort-buttons {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            font-size: 10px;
        }

        .sort-buttons span {
            cursor: pointer;
            color: #f3c0cb;
            transition: all 0.2s ease;
        }

        .sort-buttons span:hover {
            color: #fff;
            transform: scale(1.3);
        }

        .sort-buttons span.active {
            color: #fff;
            font-weight: bold;
        }

        /* ===============================
                   ☑️ CHECKBOX
                ================================ */
        input[type="checkbox"] {
            accent-color: var(--maroon);
            transform: scale(1.1);
        }

        /* ===============================
                   📄 PAGINATION
                ================================ */
        .page-item.active .page-link {
            background-color: var(--maroon);
            border-color: var(--maroon);
        }

        .page-link {
            color: var(--maroon);
            transition: all 0.2s ease;
        }

        .page-link:hover {
            background-color: var(--maroon-soft);
            color: var(--maroon-dark);
            transform: translateY(-2px);
        }

        /* ===============================
                   🪟 MODAL
                ================================ */
        .modal-content {
            border-radius: 10px;
            box-shadow: 0 10px 30px var(--shadow-maroon);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            color: #fff;
        }

        .modal-footer .btn {
            min-width: 120px;
        }

        /* ===============================
                   🧠 CARD
                ================================ */
        .card {
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        /* ===============================
                   💥 ANIMATION ENTRY (BONUS)
                ================================ */
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card,
        .table,
        .btn {
            animation: fadeSlideUp 0.5s ease;
        }

        /* =========================================
               RESPONSIVE MOBILE
            ========================================= */
        @media (max-width: 768px) {

            /* CARD */
            .card-body {
                padding: 12px;
            }

            /* TABLE RESPONSIVE */
            .table-responsive {
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                border-radius: 10px;
            }

            #table {
                min-width: 600px;
                font-size: 12px;
            }

            #table th,
            #table td {
                white-space: nowrap;
                padding: 8px 6px;
                vertical-align: middle;
            }

            /* BUTTON GLOBAL */
            .btn,
            .btn-primary,
            .btn-success,
            .btn-danger,
            .btn-default {
                font-size: 11px !important;
                padding: 6px 10px !important;
                border-radius: 6px !important;
                min-height: 34px;
            }

            /* BUTTON ACTION TABLE */
            td .btn {
                width: 34px !important;
                height: 34px !important;
                padding: 0 !important;
                display: inline-flex !important;
                align-items: center;
                justify-content: center;
                margin: 2px !important;
            }

            td .btn i {
                font-size: 12px;
            }

            /* BUTTON ADD */
            .card-header .btn {
                width: 100%;
                margin-bottom: 10px;
            }

            /* SEARCH */
            .card-tools {
                width: 100%;
                margin-top: 10px;
            }

            .card-tools .input-group {
                width: 100%;
            }

            .card-tools input.form-control {
                font-size: 13px;
            }

            /* FORM MODAL */
            .form-group.row {
                display: block;
                margin-bottom: 12px;
            }

            .form-group.row label {
                display: block;
                width: 100%;
                margin-bottom: 5px;
                font-size: 13px;
            }

            .form-group.row .col-sm-8,
            .form-group.row .col-sm-4 {
                width: 100%;
                max-width: 100%;
                flex: 100%;
            }

            .form-control {
                font-size: 13px;
                min-height: 38px;
            }

            /* MODAL */
            .modal-dialog {
                margin: 10px;
                max-width: calc(100% - 20px);
            }

            .modal-content {
                border-radius: 10px;
            }

            .modal-header h4 {
                font-size: 16px;
            }

            /* MODAL FOOTER BUTTON */
            .modal-footer {
                gap: 8px;
                flex-wrap: wrap;
            }

            .modal-footer .btn {
                flex: 1;
                min-width: 120px;
            }

            /* DELETE BUTTON */
            #delete-selected {
                width: 100%;
                margin-top: 10px;
            }

            /* PAGINATION */
            .pagination {
                justify-content: center;
                flex-wrap: wrap;
            }

            .page-link {
                padding: 6px 10px;
                font-size: 12px;
            }

            /* TEXT */
            h4,
            h5,
            h6 {
                font-size: 15px;
            }

            /* CHECKBOX */
            input[type="checkbox"] {
                transform: scale(1);
            }
        }

        /* EXTRA SMALL DEVICE */
        @media (max-width: 480px) {

            #table {
                font-size: 11px;
            }

            #table th,
            #table td {
                padding: 6px 5px;
            }

            .btn,
            .btn-primary,
            .btn-success,
            .btn-danger,
            .btn-default {
                font-size: 10px !important;
                padding: 5px 8px !important;
            }

            td .btn {
                width: 30px !important;
                height: 30px !important;
            }

            td .btn i {
                font-size: 11px;
            }

            .modal-header h4 {
                font-size: 14px;
            }

            .form-control {
                font-size: 12px;
            }
        }

        /* =========================================
           FIX TABLE MOBILE AGAR TIDAK OVERFLOW
        ========================================= */

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar {
            height: 6px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #b5b5b5;
            border-radius: 10px;
        }

        #table {
            width: 100% !important;
            min-width: unset !important;
            table-layout: auto;
        }

        #table th,
        #table td {
            white-space: nowrap;
            vertical-align: middle;
        }

        /* MOBILE */
        @media (max-width: 768px) {

            .card-body {
                overflow-x: hidden;
                padding: 10px;
            }

            .table-responsive {
                display: block;
                width: 100%;
                max-width: 100vw;
                overflow-x: auto;
            }

            #table {
                width: max-content !important;
                min-width: 100% !important;
            }

            #table th,
            #table td {
                font-size: 11px;
                padding: 7px 6px;
            }

            /* BUTTON AKSI */
            td .btn {
                width: 32px !important;
                height: 32px !important;
                padding: 0 !important;
                margin: 2px !important;

                display: inline-flex !important;
                align-items: center;
                justify-content: center;
            }

            td .btn i {
                font-size: 11px;
            }
        }

        /* EXTRA SMALL */
        @media (max-width: 480px) {

            .container-fluid {
                padding-left: 6px !important;
                padding-right: 6px !important;
            }

            .card-body {
                padding: 6px;
            }

            #table th,
            #table td {
                font-size: 10px;
                padding: 6px 5px;
            }

            td .btn {
                width: 28px !important;
                height: 28px !important;
            }

            td .btn i {
                font-size: 10px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    @auth
                        @if (Auth::user()->role == 0 || Auth::user()->role == 6)
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-kode-aset"
                                onclick="addKodeAset()"><i class="fas fa-plus"></i> Add New Kode Aset</button>
                        @endif
                    @endauth
                    <div class="card-tools">
                        <form>
                            <div class="input-group input-group">
                                <input type="text" class="form-control" name="q" placeholder="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table" class="table table-sm table-bordered table-hover table-striped">
                        <thead>
                            <tr class="text-center">
                                <th><input type="checkbox" id="select-all"></th>
                                <th>No.</th>
                                <th>{{ __('Kode') }}</th>
                                <th>{{ __('Keterangan') }}</th>
                                <th>{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $key => $d)
                                @php
                                    $data = $d->toArray();
                                @endphp
                                <tr>
                                    <td class="text-center"><input type="checkbox" name="hapus[]"
                                            value="{{ $d->id }}"></td>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $d->kode }}</td>
                                    <td>{{ $d->keterangan }}</td>
                                    <td class="text-center">
                                        @if (Auth::user()->role == 0 || Auth::user()->role == 6)
                                            <button title="Edit Shelf" type="button" class="btn btn-success btn-xs"
                                                data-toggle="modal" data-target="#add-kode-aset"
                                                onclick="editKodeAset({{ json_encode($data) }})"><i
                                                    class="fas fa-edit"></i></button>
                                            <button title="Hapus Produk" type="button" class="btn btn-danger btn-xs"
                                                data-toggle="modal" data-target="#delete-suratkeluar"
                                                onclick="deleteSuratKeluar({{ json_encode($data) }})"><i
                                                    class="fas fa-trash"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="8">{{ __('No data.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-danger" id="delete-selected"
                        data-token="{{ csrf_token() }}">Hapus yang dipilih</button>
                </div>
            </div>
            <div>
                {{ $items->links('pagination::bootstrap-4') }}
            </div>
        </div>
        @auth

            @if (Auth::user()->role == 0 || Auth::user()->role == 6)
                <div class="modal fade" id="add-kode-aset">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="modal-title" class="modal-title">{{ __('Add New Kode Aset') }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form" id="save" action="{{ route('kode_aset.save') }}" method="post"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <input type="hidden" id="kode_aset_id" name="kode_aset_id">
                                    <div class="form-group row">
                                        <label for="kode" class="col-sm-4 col-form-label">{{ __('Kode') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="kode" name="kode">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="keterangan" class="col-sm-4 col-form-label">{{ __('Keterangan') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="keterangan" name="keterangan">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default"
                                    data-dismiss="modal">{{ __('Cancel') }}</button>
                                <button id="button-save" type="button" class="btn btn-primary"
                                    onclick="$('#save').submit();">{{ __('Add') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="delete-suratkeluar">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="modal-title" class="modal-title">{{ __('Delete Surat Keluar') }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form" id="delete" action="{{ route('kode_aset.delete') }}"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" id="delete_id" name="delete_id">
                                </form>
                                <div>
                                    <p>Anda yakin ingin menghapus surat keluar nomor <span id="delete_name"
                                            class="font-weight-bold"></span>?</p>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default"
                                    data-dismiss="modal">{{ __('Batal') }}</button>
                                <button id="button-save" type="button" class="btn btn-danger"
                                    onclick="$('#delete').submit();">{{ __('Ya, hapus') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endauth
    </section>
@endsection
@section('custom-js')
    <script>
        // $(document).ready(function() {
        //     $("#nomor").inputmask({
        //         "mask": "999/EDP-FJ/99/9999",
        //     });
        // });

        $('#select-all').change(function() {
            var checkboxes = $(this).closest('table').find(':checkbox');
            checkboxes.prop('checked', $(this).is(':checked'));
        });

        // Function to handle delete selected items
        $('#delete-selected').click(function() {
            var ids = [];
            $('input[name="hapus[]"]:checked').each(function() {
                ids.push($(this).val());
            });

            if (ids.length > 0) {
                var token = $(this).data('token');
                $.ajax({
                    url: 'kodeaset-warehouse-imss/hapus-multiple',
                    type: 'POST',
                    data: {
                        _token: token,
                        ids: ids
                    },
                    success: function(response) {
                        if (response.success) {
                            // Menghapus status checked dari semua checkbox
                            $('input[name="hapus[]"]').prop('checked', false);
                            $('#select-all').prop('checked', false);
                            // Memuat ulang halaman setelah berhasil menghapus data
                            location.reload();
                            alert('Data berhasil dihapus');
                        } else {
                            alert('Gagal menghapus data');
                        }
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan saat menghapus data');
                    }
                });
            } else {
                alert('Pilih setidaknya satu item untuk dihapus');
            }
        });


        function resetForm() {
            $('#save').trigger("reset");
            $('#kode').val('');
            $('#keterangan').val('');
        }

        function addKodeAset() {
            resetForm();
            $('#modal-title').text("Add New Kode Aset");
            $('#button-save').text("Add");
        }

        function editKodeAset(data) {
            console.log(data)
            resetForm();
            $('#modal-title').text("Edit Kode Aset");
            $('#button-save').text("Simpan");
            $('#kode_aset_id').val(data.id);
            $('#kode').val(data.kode);
            $('#keterangan').val(data.keterangan);

        }

        function deleteSuratKeluar(data) {
            $('#delete_id').val(data.id);
            $('#delete_name').text(data.no_surat);
        }
    </script>
    <script src="/plugins/toastr/toastr.min.js"></script>
    @if (Session::has('success'))
        <script>
            toastr.success('{!! Session::get('success') !!}');
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            toastr.error('{!! Session::get('error') !!}');
        </script>
    @endif
    @if (!empty($errors->all()))
        <script>
            toastr.error('{!! implode('', $errors->all('<li>:message</li>')) !!}');
        </script>
    @endif
@endsection
