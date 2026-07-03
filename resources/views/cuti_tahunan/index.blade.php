@extends('layouts.main')

@section('content')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <style>
        

        :root {

            --navy-main: #1e3a8a;
            --navy-dark: #0f172a;
            --navy-soft: #eff6ff;
            --navy-border: #bfdbfe;
            --navy-hover: #2563eb;

        }

        body {

            background: #f4f6f9;

        }

        /* =====================================================
                                   CARD
                                ===================================================== */

        .modern-card {

            border: none;
            border-radius: 22px;
            overflow: hidden;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.08);

            animation: fadeUp .5s ease;

        }

        .modern-header {

            background: linear-gradient(135deg,
                    var(--navy-main),
                    var(--navy-dark));

            padding: 22px 25px;

            position: relative;

            overflow: hidden;

        }

        .modern-header::after {

            content: '';

            position: absolute;

            width: 250px;
            height: 250px;

            background: rgba(255, 255, 255, 0.08);

            border-radius: 50%;

            top: -120px;
            right: -80px;

        }

        .modern-header h5 {

            font-weight: 700;
            letter-spacing: .5px;

            position: relative;
            z-index: 2;

        }

        /* =====================================================
                                   ALERT
                                ===================================================== */

        .alert {

            border: none;
            border-radius: 14px;

            animation: fadeDown .4s ease;

        }

        /* =====================================================
                                   FORM
                                ===================================================== */

        .form-box {

            background: #ffffff;

            border-radius: 18px;

            padding: 20px;

            border: 1px solid #eeeeee;

            margin-bottom: 20px;

            animation: fadeUp .6s ease;

        }

        label {

            font-size: 13px;
            font-weight: 600;

            color: #444444;

            margin-bottom: 6px;

        }

        .form-control {

            border-radius: 12px;
            border: 1px solid #dddddd;

            height: 45px;

            transition: .3s;

        }

        .form-control:focus {

            border-color: var(--navy-main);

            box-shadow:
                0 0 0 .15rem rgba(67, 53, 220, 0.15);

        }

        /* =====================================================
                                   BUTTON
                                ===================================================== */

        .btn {

            border-radius: 12px;
            font-weight: 600;

            transition: .3s;

        }

        .btn-success {

            background: linear-gradient(135deg,
                    #28a745,
                    #1d7f34);

            border: none;

        }

        .btn-success:hover {

            transform: translateY(-2px);

            box-shadow:
                0 8px 18px rgba(40, 167, 69, .25);

        }

        .btn-warning {

            border: none;

        }

        .btn-warning:hover {

            transform: translateY(-2px);

        }

        .btn-danger {

            border: none;

        }

        .btn-danger:hover {

            transform: translateY(-2px);

        }

        /* =====================================================
                                   TABLE
                                ===================================================== */

        .table {

            border-radius: 16px;
            overflow: hidden;

            margin-bottom: 0;

        }

        .table thead {

            background: linear-gradient(135deg,
                    var(--navy-main),
                    var(--navy-dark));

            color: white;

        }

        .table th {

            font-size: 13px;
            font-weight: 700;

            border: none;

            white-space: nowrap;

            text-align: center;

        }

        .table td {

            font-size: 13px;

            vertical-align: middle;

            border-color: #f1f1f1;

            text-align: center;

        }

        .table tbody tr {

            transition: .25s;

        }

        .table tbody tr:hover {

            background: #f9f8ff;

            transform: scale(1.002);

        }

        .table-total {

            font-size: 14px;
            font-weight: 700;

            color: var(--navy-dark);

        }

        /* =====================================================
                                   MODAL
                                ===================================================== */

        .modal-content {

            border: none;
            border-radius: 18px;

            overflow: hidden;

        }

        .modal-header {

            border: none;

        }

        .modal-title {

            font-weight: 700;

        }

        .modal-footer {

            border: none;

        }

        /* =====================================================
                                   ACTION BUTTON
                                ===================================================== */

        .action-group {

            display: flex;
            gap: 5px;
            justify-content: center;

        }

        /* =====================================================
                                   ANIMATION
                                ===================================================== */

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

        @keyframes fadeDown {

            from {

                opacity: 0;
                transform: translateY(-20px);

            }

            to {

                opacity: 1;
                transform: translateY(0);

            }

        }

        /* =====================================================
                                   MOBILE
                                ===================================================== */

        @media(max-width:768px) {

            .modern-header {

                padding: 18px;

            }

            .modern-header h5 {

                font-size: 16px;

            }

            .form-control {

                height: 42px;
                font-size: 12px;

            }

            .table th,
            .table td {

                font-size: 11px;

                padding: 8px;

            }

            .btn {

                font-size: 11px;

            }

            .action-group {

                flex-direction: column;

            }

        }

        .table-total-total {

            background: #ece9ff;
            color: #271e8b;

            border: 1px solid #c2b8f5;

            font-size: 14px;
            font-weight: 700;

            border-radius: 10px;

            min-width: 45px;

            display: inline-block;

            transition: .3s;

        }

        .table-total-total:hover {

            transform: scale(1.08);

            background: #ddd7ff;

        }

        

        .modal-content {

            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);

            animation: modalFade .3s ease;

        }

        .modal-header-red {

            background: linear-gradient(135deg,
                    #5135dc,
                    #2d1e8b);

            border: none;

        }

        .modal-title {

            font-weight: 700;
            letter-spacing: .5px;

        }

        .modal-body {

            background: #fff;

        }

        .modal-body .form-group label {

            font-weight: 600;
            font-size: 13px;
            color: #2e1e8b;

        }

        .modal-body .form-control {

            border-radius: 12px;
            border: 1px solid #e4e4e4;
            height: 45px;

            transition: .2s;

        }

        .modal-body .form-control:focus {

            border-color: #4635dc;
            box-shadow: 0 0 0 0.15rem rgba(220, 53, 69, .15);

        }

        .modal-footer {

            border: none;
            background: #fff8f8;

        }

        .modal-footer .btn-secondary {

            border-radius: 10px;

        }

        .modal-footer .btn-warning {

            background: #5435dc;
            border: none;
            color: white;
            border-radius: 10px;
            font-weight: 600;

            transition: .2s;

        }

        .modal-footer .btn-warning:hover {

            background: #201e8b;
            transform: translateY(-2px);

        }

        @keyframes modalFade {

            from {

                opacity: 0;
                transform: translateY(-20px) scale(.95);

            }

            to {

                opacity: 1;
                transform: translateY(0) scale(1);

            }

        }
    </style>

    <div class="container-fluid">

        {{-- ALERT --}}
        @if (session('success'))
            <div class="alert alert-success">

                <i class="fas fa-check-circle"></i>

                {{ session('success') }}

            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">

                <i class="fas fa-times-circle"></i>

                {{ session('error') }}

            </div>
        @endif

        <div class="card modern-card">

            {{-- HEADER --}}
            <div class="modern-header text-white">

                <h5 class="mb-0">

                    <i class="fas fa-calendar-check"></i>

                    MASTER JATAH CUTI TAHUNAN

                </h5>

            </div>

            <div class="card-body">

                {{-- FORM --}}
                <div class="form-box">

                    <form action="{{ route('cuti.tahunan.store') }}" method="POST">

                        @csrf

                        <div class="row">

                            <div class="col-md-3 mb-3">

                                <label>Pegawai</label>

                                {{-- <select name="user_id" class="form-control" required>

                                    <option value="">
                                        -- PILIH --
                                    </option>

                                    @foreach ($pegawai as $p)
                                        <option value="{{ $p->id }}">

                                            {{ $p->name }}

                                        </option>
                                    @endforeach

                                </select> --}}
                                <input type="text" name="nama_pegawai" class="form-control"
                                    placeholder="Masukkan nama pegawai" required>

                            </div>

                            <div class="col-md-2 mb-3">

                                <label>Tahun</label>

                                <input type="number" name="tahun" class="form-control" required>

                            </div>

                            <div class="col-md-2 mb-3">

                                <label>Jatah</label>

                                <input type="number" name="jatah" class="form-control" value="8">

                            </div>

                            <div class="col-md-2 mb-3">

                                <label>Sisa Tahun Sebelumnya</label>

                                <input type="number" name="carry_over" class="form-control" value="0">

                            </div>

                            <div class="col-md-2 mb-3">

                                <label>Tambahan</label>

                                <input type="number" name="tambahan" class="form-control" value="0">

                            </div>

                            <div class="col-md-1 mb-3 d-flex align-items-end">

                                <button class="btn btn-success w-100">

                                    <i class="fas fa-save"></i>

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

                {{-- FILTER --}}
                <form method="GET" class="mb-3">

                    <div class="row">

                        <div class="col-md-3">

                            <label>Tahun</label>

                            <input type="number" name="tahun" class="form-control" value="{{ $tahun }}">

                        </div>

                        <div class="col-md-2 d-flex align-items-end">

                            <button class="btn btn-primary w-100">

                                FILTER

                            </button>

                        </div>

                    </div>

                </form>

                {{-- TABLE --}}
                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                <th>No</th>
                                <th>Nama</th>
                                <th>Tahun</th>
                                <th>Jatah</th>
                                <th>Sisa Tahun Sebelumnya</th>
                                <th>Tambahan</th>
                                <th>Pengurangan</th>
                                <th>Total</th>
                                <th width="160">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($data as $key => $d)
                                @php

                                    $total = $d->jatah + $d->carry_over + $d->tambahan - $d->pengurangan;

                                @endphp

                                <tr>

                                    <td>

                                        {{ $key + 1 }}

                                    </td>

                                    <td>

                                        <b>

                                            {{-- {{ $d->user->name ?? '-' }} --}}
                                            {{ $d->nama_pegawai }}

                                        </b>

                                    </td>

                                    <td>

                                        {{ $d->tahun }}

                                    </td>

                                    <td>

                                        {{ $d->jatah }}

                                    </td>

                                    <td>

                                        <b>{{ $d->carry_over }}</b>

                                    </td>

                                    <td>

                                        {{ $d->tambahan }}

                                    </td>

                                    <td>

                                        {{ $d->pengurangan }}

                                    </td>

                                    <td>

                                        <span class="badge p-2 table-total-total">

                                            {{ $total }}

                                        </span>

                                    </td>

                                    <td>

                                        <div class="action-group">

                                            {{-- EDIT --}}
                                            <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#edit{{ $d->id }}">

                                                <i class="fas fa-edit"></i>

                                            </button>

                                            {{-- DELETE --}}
                                            <form action="{{ route('cuti.tahunan.destroy', $d->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus data?')">

                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-danger btn-sm">

                                                    <i class="fas fa-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                                {{-- MODAL EDIT --}}
                                <div class="modal fade" id="edit{{ $d->id }}" tabindex="-1">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <form action="{{ route('cuti.tahunan.update', $d->id) }}" method="POST">

                                                @csrf
                                                @method('PUT')

                                                <div class="modal-header modal-header-red text-white">

                                                    <h5 class="modal-title">

                                                        <i class="fas fa-edit"></i>

                                                        EDIT JATAH CUTI

                                                    </h5>

                                                    <button type="button" class="close" data-dismiss="modal">

                                                        <span>&times;</span>

                                                    </button>

                                                </div>

                                                <div class="modal-body">

                                                    <div class="form-group">

                                                        <label>Pegawai</label>

                                                        {{-- <input type="text" class="form-control"
                                                            value="{{ $d->user->name ?? '-' }}" readonly> --}}

                                                        <input type="text" name="nama_pegawai" class="form-control"
                                                            value="{{ $d->nama_pegawai }}">

                                                    </div>

                                                    <div class="form-group">

                                                        <label>Tahun</label>

                                                        <input type="text" class="form-control"
                                                            value="{{ $d->tahun }}" readonly>

                                                    </div>

                                                    <div class="form-group">

                                                        <label>Jatah</label>

                                                        <input type="number" name="jatah" class="form-control"
                                                            value="{{ $d->jatah }}">

                                                    </div>

                                                    <div class="form-group">

                                                        <label>Carry Over (sisa tahun sebelumnya)</label>

                                                        <input type="number" name="carry_over" class="form-control"
                                                            value="{{ $d->carry_over }}">

                                                    </div>

                                                    <div class="form-group">

                                                        <label>Tambahan</label>

                                                        <input type="number" name="tambahan" class="form-control"
                                                            value="{{ $d->tambahan }}">

                                                    </div>

                                                    <div class="form-group">

                                                        <label>Pengurangan</label>

                                                        <input type="number" name="pengurangan" class="form-control"
                                                            value="{{ $d->pengurangan }}">

                                                    </div>

                                                </div>

                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">

                                                        BATAL

                                                    </button>

                                                    <button class="btn btn-warning">

                                                        <i class="fas fa-save"></i>

                                                        UPDATE

                                                    </button>

                                                </div>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <tr>

                                    <td colspan="9" class="text-center text-muted">

                                        Tidak ada data jatah cuti

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
@endsection
