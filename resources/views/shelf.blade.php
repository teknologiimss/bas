@extends('layouts.main')
@section('title', __('Shelf'))
@section('custom-css')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
@endsection
@section('content')

    <style>
        :root {
            --navy-main: #163A6B;
            --navy-hover: #24528F;
            --navy-dark: #0B2343;
            --navy-soft: #EEF4FB;
            --navy-border: #C8D8EE;
            --navy-text: #163A6B;
        }

        /* =========================
       CARD
    ========================= */

        .card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(22, 58, 107, .15);
        }

        .card-header {
            background: linear-gradient(135deg, var(--navy-main), var(--navy-hover));
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
        }

        /* =========================
       BUTTON
    ========================= */

        .btn {
            border: none;
            border-radius: 10px;
            font-weight: 600;
            transition: .25s;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--navy-main), var(--navy-hover));
        }

        .btn-success {
            background: linear-gradient(135deg, #198754, #157347);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #b02a37);
        }

        .btn-default {
            background: #f8f9fa;
            color: #444;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(22, 58, 107, .25);
        }

        .btn-xs {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border-radius: 8px;
            margin: 2px;
        }

        /* =========================
       TABLE
    ========================= */

        .table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 18px rgba(0, 0, 0, .05);
        }

        .table thead th {
            background: linear-gradient(135deg, var(--navy-main), var(--navy-hover));
            color: #fff;
            text-align: center;
            border: none;
            vertical-align: middle;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .table-striped tbody tr:nth-child(odd) {
            background: #f8fbff;
        }

        .table-hover tbody tr:hover {
            background: #eaf2fc;
            transition: .25s;
        }

        /* =========================
       MODAL
    ========================= */

        .modal-content {
            border: none;
            border-radius: 16px;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--navy-main), var(--navy-hover));
            color: #fff;
            border: none;
        }

        .modal-header .close {
            color: #fff;
            opacity: 1;
        }

        .modal-footer {
            border-top: none;
        }

        /* =========================
       FORM
    ========================= */

        .form-control {
            border-radius: 10px;
            border: 1px solid #ced4da;
        }

        .form-control:focus {
            border-color: var(--navy-main);
            box-shadow: 0 0 0 .2rem rgba(22, 58, 107, .18);
        }

        /* =========================
       ALERT DELETE
    ========================= */

        .text-danger {
            background: #fff3f3;
            border-left: 4px solid #dc3545;
            padding: 10px;
            border-radius: 8px;
        }

        /* =========================
       PAGINATION
    ========================= */

        .page-item.active .page-link {
            background: var(--navy-main);
            border-color: var(--navy-main);
        }

        .page-link {
            color: var(--navy-main);
        }

        .page-link:hover {
            color: #fff;
            background: var(--navy-hover);
        }

        /* =========================
       RESPONSIVE
    ========================= */

        @media(max-width:768px) {

            .card-header {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .card-header .btn {
                width: 100%;
            }

            .btn-xs {
                width: 32px;
                height: 32px;
            }

            .table {
                font-size: 13px;
            }

            .modal-footer {
                flex-direction: column;
            }

            .modal-footer .btn {
                width: 100%;
            }

        }
    </style>

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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-shelf"
                        onclick="addShelf()"><i class="fas fa-plus"></i> Add New Shelf</button>
                </div>
                <div class="card-body">
                    <table id="table" class="table table-sm table-bordered table-hover table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>{{ __('Shelf Name') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($shelf) > 0)
                                @foreach ($shelf as $key => $d)
                                    @php
                                        $data = ['shelf_id' => $d->shelf_id, 'shelf_name' => $d->shelf_name];
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $shelf->firstItem() + $key }}</td>
                                        <td>{{ $data['shelf_name'] }}</td>
                                        <td class="text-center">
                                            @if (Auth::user()->role == 0 || Auth::user()->role == 4)
                                                <button title="Edit Shelf" type="button" class="btn btn-success btn-xs"
                                                    data-toggle="modal" data-target="#add-shelf"
                                                    onclick="editShelf({{ json_encode($data) }})"><i
                                                        class="fas fa-edit"></i></button> <button title="Hapus Shelf"
                                                    type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                                    data-target="#delete-shelf"
                                                    onclick="deleteShelf({{ json_encode($data) }})"><i
                                                        class="fas fa-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="text-center">
                                    <td colspan="3">{{ __('No data.') }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                {{ $shelf->links('pagination::bootstrap-4') }}
            </div>
        </div>
        <div class="modal fade" id="add-shelf">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Add New Shelf') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="update" action="{{ route('products.shelf.save') }}" method="post">
                            @csrf
                            <input type="hidden" id="shelf_id" name="shelf_id">
                            <div class="form-group row">
                                <label for="shelf_name" class="col-sm-4 col-form-label">{{ __('Name') }}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="shelf_name" name="shelf_name">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button id="button-save" type="button" class="btn btn-primary"
                            onclick="$('#update').submit();">{{ __('Add') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="delete-shelf">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Hapus Shelf') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="delete" action="{{ route('products.shelf.delete') }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" id="delete_id" name="delete_id">
                        </form>
                        <div>
                            <p class="text-danger">Perhatian! Stok serta history yang berada di shelf ini juga akan ikut
                                terhapus!</p>
                            <p>Anda yakin ingin tetap menghapus shelf <span id="delete_name"
                                    class="font-weight-bold"></span>?</p>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button id="button-delete" type="button" class="btn btn-danger"
                            onclick="$('#delete').submit();">{{ __('Ya, hapus') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('custom-js')
    <script>
        function resetForm() {
            $('#update').trigger("reset");
            $('#shelf_id').val('');
        }

        function addShelf() {
            resetForm();
            $('#modal-title').text("Add New Shelf");
            $('#button-save').text("Add");
        }

        function editShelf(data) {
            resetForm();
            $('#modal-title').text("Edit Shelf");
            $('#button-save').text("Simpan");
            $('#shelf_id').val(data.shelf_id);
            $('#shelf_name').val(data.shelf_name);
        }

        function deleteShelf(data) {
            $('#delete_id').val(data.shelf_id);
            $('#delete_name').text(data.shelf_name);
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
