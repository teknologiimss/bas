@extends('layouts.main')

@section('title', 'Monitoring Pekerjaan')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        body {
            background: #eef3f9;
            font-family: 'Segoe UI', sans-serif;
        }

        /* ==========================
            CARD
        ========================== */
        .card {
            border: none;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 8px 24px rgba(15, 23, 42, .08);
            animation: fadeIn .5s ease;
        }

        h4 {
            font-weight: 700;
            color: #173B6C;
        }

        /* ==========================
            PROJECT HEADER
        ========================== */

        .header-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .project-header {
            width: 100%;
            max-width: 650px;
            text-align: center;
            padding: 22px;
            border-radius: 15px;
            color: white;
            background: linear-gradient(135deg, #0B1F3A, #173B6C);
            box-shadow: 0 10px 25px rgba(11, 31, 58, .25);
        }

        .project-title {
            font-size: 14px;
            opacity: .9;
        }

        .project-name {
            font-size: 24px;
            font-weight: bold;
        }

        /* ==========================
            BUTTON
        ========================== */

        .btn {
            border-radius: 10px;
            transition: .25s;
            font-weight: 600;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(135deg, #173B6C, #28528C);
            border: none;
            color: white;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #0B1F3A, #173B6C);
            box-shadow: 0 8px 18px rgba(23, 59, 108, .3);
        }

        .btn-primary {
            background: #173B6C;
            border: none;
        }

        .btn-primary:hover {
            background: #0B1F3A;
        }

        .btn-secondary {
            background: #64748B;
            border: none;
        }

        .btn-secondary:hover {
            background: #475569;
        }

        .btn-warning {
            background: #F59E0B;
            border: none;
            color: white;
        }

        .btn-warning:hover {
            background: #D97706;
        }

        .btn-danger {
            background: #DC2626;
            border: none;
        }

        .btn-danger:hover {
            background: #B91C1C;
        }

        /* ==========================
            FORM
        ========================== */

        .form-control {
            border-radius: 10px;
            border: 1px solid #CBD5E1;
        }

        .form-control:focus {
            border-color: #173B6C;
            box-shadow: 0 0 0 .2rem rgba(23, 59, 108, .15);
        }

        /* ==========================
            TABLE
        ========================== */

        .table-container {
            overflow: auto;
            max-height: 500px;
            position: relative;
            border-radius: 10px;
        }

        .table-monitoring {
            border-collapse: separate !important;
            border-spacing: 0;
            white-space: nowrap;
            font-size: 13px;
        }

        .table-monitoring th,
        .table-monitoring td {
            padding: 8px 10px;
            vertical-align: middle;
        }

        .table-monitoring thead th {
            position: sticky;
            top: 0;
            z-index: 200;
            color: white;
            background: linear-gradient(135deg, #0B1F3A, #173B6C) !important;
            text-align: center;
        }

        .table-monitoring tbody tr {
            transition: .2s;
        }

        .table-monitoring tbody tr:hover {
            background: #EAF2FF;
        }

        /* ==========================
            STICKY FIRST COLUMN
        ========================== */

        .table-monitoring th:first-child {
            position: sticky;
            left: 0;
            background: #173B6C !important;
            z-index: 300;
        }

        .table-monitoring td:first-child {
            position: sticky;
            left: 0;
            background: white;
            z-index: 100;
        }

        .table-monitoring thead th:first-child {
            z-index: 400;
        }

        /* ==========================
            BADGE
        ========================== */

        .badge-success {
            background: #001e5e;
            color: white;
            border-radius: 20px;
            padding: 6px 10px;
        }

        .badge-danger {
            background: #DC2626;
            color: white;
            border-radius: 20px;
            padding: 6px 10px;
        }

        /* ==========================
            MODAL
        ========================== */

        .modal-content {
            border-radius: 15px;
            border: none;
            overflow: hidden;
            animation: zoomIn .3s;
        }

        .modal-header {
            background: linear-gradient(135deg, #0B1F3A, #173B6C);
            color: white;
        }

        /* ==========================
            STICKY HEADER
        ========================== */

        .sticky-top-section {
            position: sticky;
            top: 0;
            z-index: 999;
            background: #eef3f9;
        }

        .sticky-inner {
            background: #eef3f9;
        }

        /* ==========================
            ANIMATION
        ========================== */

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* ==========================
            MOBILE
        ========================== */

        .filter-toggle-btn {
            display: none;
        }

        @media (max-width:768px) {

            body {
                background: #eef3f9;
            }

            .sticky-top-section {
                z-index: 999;
            }

            .project-header {
                max-width: 100%;
                padding: 16px;
            }

            .project-title {
                font-size: 11px;
            }

            .project-name {
                font-size: 18px;
            }

            .card {
                border-radius: 12px;
            }

            .card-body {
                padding: 10px;
            }

            .form-control {
                height: 36px;
                font-size: 12px;
            }

            .btn {
                height: 36px;
                font-size: 12px;
                border-radius: 8px;
            }

            .table-container {
                max-height: 75vh;
                overflow: auto;
            }

            .table-monitoring {
                min-width: 1700px;
                font-size: 11px;
            }

            .table-monitoring th,
            .table-monitoring td {
                padding: 6px;
                font-size: 10px;
            }

            .table-monitoring th:first-child {
                min-width: 50px;
                left: 0;
                background: #173B6C !important;
                z-index: 600;
            }

            .table-monitoring td:first-child {
                min-width: 50px;
                left: 0;
                background: white;
                z-index: 500;
            }

            .table-monitoring thead th:first-child {
                z-index: 700;
            }

            .badge {
                font-size: 10px;
            }

            .modal-dialog {
                margin: 10px;
                max-width: calc(100% - 20px);
            }

            .filter-toggle-btn {
                display: block;
                width: 100%;
                margin: 10px 0;
                background: #173B6C;
                color: white;
                border: none;
            }

            #filterArea {
                display: none;
            }

            #filterArea.show {
                display: block;
                animation: fadeIn .3s;
            }
        }

        @media (max-width:480px) {

            .project-name {
                font-size: 15px;
            }

            .project-title {
                font-size: 10px;
            }

            .table-monitoring th,
            .table-monitoring td {
                font-size: 9px;
                padding: 5px;
            }

            .btn {
                font-size: 10px;
            }

            .form-control {
                font-size: 11px;
            }
        }
    </style>


    {{-- Freeze seperti excel --}}
    <div class="sticky-top-section">

        <div class="header-wrapper sticky-inner">

            <div class="project-header text-center">
                <div class="project-title">
                    Monitoring Pekerjaan
                </div>
                <div class="project-name">
                    {{ $proyek->nama_proyek }}
                </div>
            </div>

            <button class="btn btn-success mt-3 px-4 py-2" data-toggle="modal" data-target="#modalTambah">
                ➕ Tambah Data
            </button>

        </div>

        {{-- FILTER --}}
        {{-- <div class="card mt-3 p-3 sticky-inner">

            <form method="GET" class="mb-3">
                <div class="row">

                    <div class="col-md-2">
                        <label>Trainset</label>
                        <input type="text" name="trainset" autocomplete="off" value="{{ request('trainset') }}"
                            class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label>No.Lambung</label>
                        <input type="text" name="nomor_lambung" autocomplete="off" value="{{ request('nomor_lambung') }}"
                            class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label>Batch</label>
                        <input type="text" name="batch" autocomplete="off" value="{{ request('batch') }}"
                            class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label>No.SJN</label>
                        <input type="text" name="no_sjn" autocomplete="off" value="{{ request('no_sjn') }}"
                            class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label>Actual Delivery</label>
                        <input type="date" name="actual_delivery" value="{{ request('actual_delivery') }}"
                            class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label>Status</label>
                        <select name="status_delivery" class="form-control">
                            <option value="">-- Status --</option>
                            <option value="On Time" {{ request('status_delivery') == 'On Time' ? 'selected' : '' }}>On Time
                            </option>
                            <option value="Overdue" {{ request('status_delivery') == 'Overdue' ? 'selected' : '' }}>Overdue
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2 mt-2">
                        <label>Loading Truck</label>
                        <input type="date" name="loading_truck" value="{{ request('loading_truck') }}"
                            class="form-control">
                    </div>

                    <div class="col-md-2 mt-2">
                        <label>Actual Unloading</label>
                        <input type="date" name="actual_unloading" value="{{ request('actual_unloading') }}"
                            class="form-control">
                    </div>

                    <div class="col-md-11 mt-2">
                        <button class="btn btn-primary btn-sm">🔍 Filter</button>
                        <a href="{{ url()->current() }}" class="btn btn-secondary btn-sm">Reset</a>
                    </div>

                </div>
            </form>

        </div> --}}

        {{-- BUTTON FILTER MOBILE --}}
        <button type="button" class="btn btn-primary filter-toggle-btn d-md-none" id="toggleFilterBtn">
            🔍 Tampilkan Filter
        </button>

        {{-- FILTER --}}
        <div class="card mt-3 p-3 sticky-inner" id="filterArea">

            <form method="GET" class="mb-3">
                <div class="row">

                    <div class="col-md-2">
                        <label>Trainset</label>
                        <input type="text" name="trainset" autocomplete="off" value="{{ request('trainset') }}"
                            class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label>No.Lambung</label>
                        <input type="text" name="nomor_lambung" autocomplete="off" value="{{ request('nomor_lambung') }}"
                            class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label>Batch</label>
                        <input type="text" name="batch" autocomplete="off" value="{{ request('batch') }}"
                            class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label>No.SJN</label>
                        <input type="text" name="no_sjn" autocomplete="off" value="{{ request('no_sjn') }}"
                            class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label>Actual Delivery</label>
                        <input type="date" name="actual_delivery" value="{{ request('actual_delivery') }}"
                            class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label>Status</label>

                        <select name="status_delivery" class="form-control">
                            <option value="">-- Status --</option>

                            <option value="On Time" {{ request('status_delivery') == 'On Time' ? 'selected' : '' }}>
                                On Time
                            </option>

                            <option value="Overdue" {{ request('status_delivery') == 'Overdue' ? 'selected' : '' }}>
                                Overdue
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2 mt-2">
                        <label>Loading Truck</label>

                        <input type="date" name="loading_truck" value="{{ request('loading_truck') }}"
                            class="form-control">
                    </div>

                    <div class="col-md-2 mt-2">
                        <label>Actual Unloading</label>

                        <input type="date" name="actual_unloading" value="{{ request('actual_unloading') }}"
                            class="form-control">
                    </div>

                    <div class="col-md-12 mt-3 d-flex gap-2 flex-wrap">

                        <button class="btn btn-primary btn-sm">
                            🔍 Filter
                        </button>

                        <a href="{{ url()->current() }}" class="btn btn-secondary btn-sm">
                            Reset
                        </a>

                    </div>

                </div>
            </form>

        </div>

    </div>

    <div class="card mt-3 p-3">



        <!-- SCROLL AREA -->
        <div class="table-container">
            <form method="POST" action="{{ route('pengiriman.detail.bulkDelete') }}">
                @csrf
                @method('DELETE')
                <table class="table table-bordered table-sm table-monitoring">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th>Trainset</th>
                            <th>Tipe Kereta</th>
                            <th>No Lambung</th>
                            <th>Batch</th>
                            <th>Trucking</th>
                            <th>Nopol</th>
                            <th>No SJN</th>
                            <th>Code Armada</th>
                            <th>Plan Delivery</th>
                            <th>Actual Delivery</th>
                            <th>Lead Time Delivery</th>
                            <th>Status</th>
                            <th>Loading Truck</th>
                            <th>Loading Vessel</th>
                            <th>Plan Unloading</th>
                            <th>Actual Unloading</th>
                            <th>Lead Time Unloading</th>
                            <th>Vendor</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($detail as $d)
                            <tr>
                                <td>
                                    <input type="checkbox" name="ids[]" value="{{ $d->id }}" class="checkItem">
                                </td>
                                <td>{{ $d->trainset }}</td>
                                <td>{{ $d->tipe_kereta }}</td>
                                <td>{{ $d->nomor_lambung }}</td>
                                <td>{{ $d->batch }}</td>
                                <td>{{ $d->trucking }}</td>
                                <td>{{ $d->nopol }}</td>
                                <td>{{ $d->no_sjn }}</td>
                                <td>{{ $d->code_armada }}</td>
                                <td>{{ $d->plan_delivery ? \Carbon\Carbon::parse($d->plan_delivery)->format('d/m/Y') : '-' }}
                                </td>
                                <td>{{ $d->actual_delivery ? \Carbon\Carbon::parse($d->actual_delivery)->format('d/m/Y') : '-' }}
                                </td>
                                {{-- <td>{{ $d->leadtime_delivery }}</td> --}}
                                {{-- <td>
                                    @if ($d->plan_delivery && $d->actual_delivery)
                                        {{ \Carbon\Carbon::parse($d->plan_delivery)->diffInDays(\Carbon\Carbon::parse($d->actual_delivery)) }}
                                        hari
                                    @else
                                        -
                                    @endif
                                </td> --}}
                                {{-- Leadtime delivery --}}
                                <td>
                                    @if ($d->plan_delivery && $d->actual_delivery)
                                        @php
                                            $plan = \Carbon\Carbon::parse($d->plan_delivery);
                                            $actual = \Carbon\Carbon::parse($d->actual_delivery);

                                            // beda hari (bisa minus)
                                            $selisih = $plan->diffInDays($actual, false);
                                        @endphp

                                        @if ($selisih > 0)
                                            +{{ $selisih }} hari
                                        @elseif($selisih < 0)
                                            {{ $selisih }} hari
                                        @else
                                            0 hari
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="
                    {{ $d->status_delivery == 'Overdue' ? 'badge badge-danger' : '' }}
                    {{ $d->status_delivery == 'On Time' ? 'badge badge-success' : '' }}
                ">
                                        {{ $d->status_delivery }}
                                    </span>
                                </td>

                                <td>{{ $d->loading_truck ? \Carbon\Carbon::parse($d->loading_truck)->format('d/m/Y') : '-' }}
                                </td>
                                <td>{{ $d->loading_vessel ? \Carbon\Carbon::parse($d->loading_vessel)->format('d/m/Y') : '-' }}
                                </td>
                                <td>{{ $d->plan_unloading ? \Carbon\Carbon::parse($d->plan_unloading)->format('d/m/Y') : '-' }}
                                </td>
                                <td>{{ $d->actual_unloading ? \Carbon\Carbon::parse($d->actual_unloading)->format('d/m/Y') : '-' }}
                                </td>
                                {{-- <td>{{ $d->leadtime_unloading }}</td> --}}
                                <td>
                                    @if ($d->plan_unloading && $d->actual_unloading)
                                        {{ \Carbon\Carbon::parse($d->plan_unloading)->diffInDays(\Carbon\Carbon::parse($d->actual_unloading)) }}
                                        hari
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $d->vendor }}</td>
                                <td>{{ $d->keterangan }}</td>

                                <td>
                                    <!-- EDIT -->
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#edit{{ $d->id }}" style="transition:0.2s">
                                        ✏️
                                    </button>

                                    <!-- DELETE -->

                                    <button type="button" class="btn btn-danger btn-sm btn-delete"
                                        data-id="{{ $d->id }}">
                                        🗑️
                                    </button>

                                </td>
                            </tr>



                        @empty
                            <tr>
                                <td colspan="20" class="text-center text-muted">
                                    Tidak ada data pengiriman
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <button class="btn btn-danger mt-2" onclick="return confirm('Hapus data terpilih?')">
                    🗑️ Hapus Terpilih
                </button>
            </form>


            {{-- MODAL EDIT --}}
            @foreach ($detail as $d)
                <div class="modal fade" id="edit{{ $d->id }}">
                    <div class="modal-dialog modal-lg">
                        <form method="POST" action="{{ route('pengiriman.detail.update', $d->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5>Edit Data Pengiriman</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body row">

                                    <div class="col-md-4 mb-2">
                                        <label>Trainset</label>
                                        <input type="text" name="trainset" value="{{ $d->trainset }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Tipe Kereta</label>
                                        <input type="text" name="tipe_kereta" value="{{ $d->tipe_kereta }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Nomor Lambung</label>
                                        <input type="text" name="nomor_lambung" value="{{ $d->nomor_lambung }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Batch</label>
                                        <input type="text" name="batch" value="{{ $d->batch }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Trucking</label>
                                        <input type="text" name="trucking" value="{{ $d->trucking }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Nopol</label>
                                        <input type="text" name="nopol" value="{{ $d->nopol }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>No SJN</label>
                                        <input type="text" name="no_sjn" value="{{ $d->no_sjn }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Code Armada</label>
                                        <input type="text" name="code_armada" value="{{ $d->code_armada }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Plan Delivery</label>
                                        <input type="date" name="plan_delivery" value="{{ $d->plan_delivery }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Actual Delivery</label>
                                        <input type="date" name="actual_delivery" value="{{ $d->actual_delivery }}"
                                            class="form-control">
                                    </div>

                                    {{-- <div class="col-md-4 mb-2">
                                        <label>Status Delivery</label>
                                        <input type="text" name="status_delivery" value="{{ $d->status_delivery }}"
                                            class="form-control">
                                    </div> --}}

                                    {{-- <div class="col-md-4 mb-2">
                                        <label>Status Delivery</label>

                                        <select name="status_delivery" class="form-control">
                                            <option value="">-- Pilih Status --</option>

                                            <option value="-">
                                                -
                                            </option>
                                            <option value="On Time">
                                                On Time
                                            </option>

                                            <option value="Overdue">
                                                Overdue
                                            </option>
                                        </select>
                                    </div> --}}

                                    <div class="col-md-4 mb-2">
                                        <label>Loading Truck</label>
                                        <input type="date" name="loading_truck" value="{{ $d->loading_truck }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Loading Vessel</label>
                                        <input type="date" name="loading_vessel" value="{{ $d->loading_vessel }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Plan Unloading</label>
                                        <input type="date" name="plan_unloading" value="{{ $d->plan_unloading }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Actual Unloading</label>
                                        <input type="date" name="actual_unloading" value="{{ $d->actual_unloading }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Vendor</label>
                                        <input type="text" name="vendor" value="{{ $d->vendor }}"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <label>Keterangan</label>
                                        <input type="text" name="keterangan" value="{{ $d->keterangan }}"
                                            class="form-control">
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-success">Update</button>
                                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            @endforeach

            <form id="deleteForm" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>

        </div>
    </div>

    {{-- MODAL TAMBAH DATA --}}
    <div class="modal fade" id="modalTambah">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ route('pengiriman.detail.store') }}">
                @csrf
                <input type="hidden" name="pengiriman_id" value="{{ $proyek->id }}">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Tambah Data Pengiriman</h5>
                    </div>

                    <div class="modal-body row">

                        <div class="col-md-4 mb-2">
                            <label>Trainset</label>
                            <input type="text" name="trainset" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Tipe Kereta</label>
                            <input type="text" name="tipe_kereta" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Nomor Lambung</label>
                            <input type="text" name="nomor_lambung" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Batch</label>
                            <input type="text" name="batch" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Trucking</label>
                            <input type="text" name="trucking" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Nopol</label>
                            <input type="text" name="nopol" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>No SJN</label>
                            <input type="text" name="no_sjn" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Code Armada</label>
                            <input type="text" name="code_armada" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Plan Delivery</label>
                            <input type="date" name="plan_delivery" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Actual Delivery</label>
                            <input type="date" name="actual_delivery" class="form-control" autocomplete="off">
                        </div>

                        {{-- <div class="col-md-4 mb-2">
                            <label>Leadtime Delivery</label>
                            <input type="text" name="leadtime_delivery" class="form-control" autocomplete="off">
                        </div> --}}

                        {{-- <div class="col-md-4 mb-2">
                            <label>Status Delivery</label>
                            <input type="text" name="status_delivery" class="form-control" list="statusList"
                                autocomplete="off">

                            <datalist id="statusList">
                                <option value="Overdue">
                                <option value="On Time">
                            </datalist>
                        </div> --}}

                        {{-- <div class="col-md-4 mb-2">
                            <label>Status Delivery</label>

                            <select name="status_delivery" class="form-control">
                                <option value="">-- Pilih Status --</option>

                                <option value="-">
                                    -
                                </option>
                                <option value="On Time">
                                    On Time
                                </option>

                                <option value="Overdue">
                                    Overdue
                                </option>
                            </select>
                        </div> --}}

                        <div class="col-md-4 mb-2">
                            <label>Loading Truck</label>
                            <input type="date" name="loading_truck" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Loading Vessel</label>
                            <input type="date" name="loading_vessel" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Plan Unloading</label>
                            <input type="date" name="plan_unloading" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Actual Unloading</label>
                            <input type="date" name="actual_unloading" class="form-control" autocomplete="off">
                        </div>

                        {{-- <div class="col-md-4 mb-2">
                            <label>Leadtime Unloading</label>
                            <input type="text" name="leadtime_unloading" class="form-control" autocomplete="off">
                        </div> --}}

                        <div class="col-md-4 mb-2">
                            <label>Vendor</label>
                            <input type="text" name="vendor" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-12 mb-2">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" autocomplete="off">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success">Simpan</button>
                        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('custom-js')

    {{-- efek ketika halaman dibuka --}}
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.body.style.opacity = 0;
            setTimeout(() => {
                document.body.style.transition = "2.5s";
                document.body.style.opacity = 1;
            }, 100);
        });
    </script> --}}

    <script>
        document.getElementById('checkAll').addEventListener('click', function() {
            let checkboxes = document.querySelectorAll('.checkItem');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    </script>

    <script>
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                let id = this.dataset.id;

                if (confirm('Hapus data?')) {
                    let form = document.getElementById('deleteForm');

                    let url = "{{ route('pengiriman.detail.delete', ':id') }}";
                    form.action = url.replace(':id', id);

                    form.submit();
                }
            });
        });
    </script>

    <script>
        const toggleBtn = document.getElementById('toggleFilterBtn');
        const filterArea = document.getElementById('filterArea');

        if (toggleBtn) {

            toggleBtn.addEventListener('click', function() {

                filterArea.classList.toggle('show');

                if (filterArea.classList.contains('show')) {

                    toggleBtn.innerHTML = '❌ Sembunyikan Filter';

                } else {

                    toggleBtn.innerHTML = '🔍 Tampilkan Filter';

                }

            });

        }
    </script>
@endsection
