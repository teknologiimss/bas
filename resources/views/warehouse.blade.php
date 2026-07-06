@extends('layouts.main')
@section('title', __('Warehouse'))
@section('custom-css')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
@endsection
@section('content')

    <style>
        :root {
            --navy: #0F172A;
            --navy-dark: #020617;
            --navy-light: #1E3A8A;
            --navy-soft: #EFF6FF;
            --navy-border: #BFDBFE;
            --navy-hover: #2563EB;
        }

        /* ===========================
       CARD
    =========================== */
        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .08);
        }

        .card-header {
            background: linear-gradient(135deg, var(--navy), var(--navy-light));
            color: #fff;
            border: none;
            padding: 15px 20px;
        }

        .card-body {
            background: #fff;
        }

        /* ===========================
       BUTTON
    =========================== */

        .btn-primary {
            background: linear-gradient(135deg, var(--navy), var(--navy-light));
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--navy-light), var(--navy-hover));
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(30, 58, 138, .35);
        }

        .btn-success {
            background: #2563EB;
            border: none;
        }

        .btn-success:hover {
            background: #1D4ED8;
        }

        .btn-danger {
            background: #DC2626;
            border: none;
        }

        .btn-danger:hover {
            background: #B91C1C;
        }

        .btn-default {
            background: #E5E7EB;
            color: #374151;
            border: none;
        }

        .btn-default:hover {
            background: #D1D5DB;
        }

        /* tombol kecil */

        .btn-xs {
            width: 38px;
            height: 38px;
            padding: 0;
            border-radius: 10px;
        }

        /* ===========================
       TABLE
    =========================== */

        .table {
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--navy), var(--navy-light));
            color: white;
            text-align: center;
            border: none;
            padding: 13px;
        }

        .table tbody tr {
            transition: .25s;
        }

        .table tbody tr:hover {
            background: var(--navy-soft);
            transform: scale(1.002);
        }

        .table td {
            vertical-align: middle;
        }

        /* ===========================
       MODAL
    =========================== */

        .modal-content {
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--navy), var(--navy-light));
            color: white;
        }

        .modal-header .close {
            color: white;
            opacity: 1;
        }

        .modal-footer {
            background: #F8FAFC;
        }

        /* ===========================
       FORM
    =========================== */

        .form-control {
            border-radius: 10px;
            border: 1px solid #CBD5E1;
        }

        .form-control:focus {
            border-color: #2563EB;
            box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .2);
        }

        /* ===========================
       PAGINATION
    =========================== */

        .page-item.active .page-link {
            background: var(--navy);
            border-color: var(--navy);
        }

        .page-link {
            color: var(--navy);
        }

        .page-link:hover {
            color: white;
            background: var(--navy-light);
        }

        /* ===========================
       ANIMATION
    =========================== */

        .btn,
        .table tbody tr,
        .card {
            transition: all .3s ease;
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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-warehouse"
                        onclick="addWarehouse()"><i class="fas fa-plus"></i> Add New Warehouse</button>
                </div>
                <div class="card-body">
                    <table id="table" class="table table-sm table-bordered table-hover table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>{{ __('Name') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($warehouse) > 0)
                                @foreach ($warehouse as $key => $d)
                                    @php
                                        $data = [
                                            'warehouse_id' => $d->warehouse_id,
                                            'warehouse_name' => $d->warehouse_name,
                                        ];
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $warehouse->firstItem() + $key }}</td>
                                        <td>{{ $data['warehouse_name'] }}</td>
                                        <td class="text-center"><button title="Edit" type="button"
                                                class="btn btn-success btn-xs" data-toggle="modal"
                                                data-target="#add-warehouse"
                                                onclick="editWarehouse({{ json_encode($data) }})"><i
                                                    class="fas fa-edit"></i></button> <button title="Hapus" type="button"
                                                class="btn btn-danger btn-xs" data-toggle="modal"
                                                data-target="#delete-warehouse"
                                                onclick="deleteWarehouse({{ json_encode($data) }})"><i
                                                    class="fas fa-trash"></i></button></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="text-center">
                                    <td colspan="4">{{ __('No Warehouse.') }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div>
                {{ $warehouse->links('pagination::bootstrap-4') }}
            </div>
        </div>
        <div class="modal fade" id="add-warehouse">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Add New Warehouse') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="update" action="{{ route('warehouse.save') }}" method="post">
                            @csrf
                            <input type="hidden" id="warehouse_id" name="warehouse_id">
                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label">{{ __('Warehouse Name') }}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="name" name="name">
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
        <div class="modal fade" id="delete-warehouse">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Hapus') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="delete" action="{{ route('warehouse.delete') }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" id="delete_id" name="delete_id">
                        </form>
                        <div>
                            <p>Anda yakin ingin menghapus warehouse <span id="delete_name" class="font-weight-bold"></span>?
                            </p>
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
            $('#warehouse_id').val('');
        }

        function addWarehouse() {
            resetForm();
            $('#modal-title').text("Add New Warehouse");
            $('#button-save').text("Add");
        }

        function editWarehouse(data) {
            resetForm();
            $('#modal-title').text("Edit");
            $('#button-save').text("Simpan");
            $('#warehouse_id').val(data.warehouse_id);
            $('#name').val(data.warehouse_name);
        }

        function deleteWarehouse(data) {
            $('#delete_id').val(data.warehouse_id);
            $('#delete_name').text(data.warehouse_name);
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
