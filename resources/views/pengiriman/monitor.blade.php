@extends('layouts.main')

@section('title', 'Monitoring Pekerjaan')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        body {
            background: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            animation: fadeIn 0.6s ease-in-out;
        }

        h4 {
            font-weight: 600;
            color: #b30000;
        }

        /* BUTTON */
        .btn-success {
            background: linear-gradient(45deg, #b30000, #ff4d4d);
            border: none;
            transition: 0.3s;
        }

        .btn-success:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(255, 0, 0, 0.3);
        }

        .btn-warning {
            background: #ffcc00;
            border: none;
        }

        .btn-danger {
            background: #e60000;
            border: none;
        }

        /* TABLE */
        .table-monitoring {
            font-size: 12px;
            white-space: nowrap;
            border-radius: 10px;
            overflow: hidden;
        }

        .table-monitoring th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: linear-gradient(45deg, #990000, #ff3333);
            color: white;
            text-align: center;
            vertical-align: middle;
        }

        .table-monitoring td {
            vertical-align: middle;
            transition: 0.2s;
        }

        .table-monitoring tbody tr {
            transition: all 0.25s ease;
        }

        .table-monitoring tbody tr:hover {
            background-color: #ffe6e6;
            transform: scale(1.01);
        }

        .table-monitoring th,
        .table-monitoring td {
            padding: 6px 10px;
        }

        /* Freeze kolom pertama */
        .table-monitoring td:first-child,
        .table-monitoring th:first-child {
            position: sticky;
            left: 0;
            background: #fff;
            z-index: 3;
        }

        .table-monitoring th:first-child {
            background: #990000;
        }

        /* BADGE STATUS */
        .badge-danger {
            background: #ff1a1a;
            padding: 5px 8px;
            border-radius: 20px;
        }

        /* SCROLL CONTAINER */
        .table-container {
            overflow: auto;
            max-height: 500px;
            /* WAJIB supaya header nempel */
            position: relative;
        }

        /* FIX TABLE */
        .table-monitoring {
            border-collapse: separate !important;
            border-spacing: 0;
        }

        /* HEADER TABLE (TH) FREEZE */
        .table-monitoring thead th {
            position: sticky !important;
            top: 0;
            z-index: 200;
            /* harus di bawah sticky atas */
            background: #b30000 !important;
            color: white;
        }

        /* KOLOM PERTAMA */
        .table-monitoring th:first-child {
            position: sticky;
            left: 0;
            z-index: 201;
        }

        .table-monitoring td:first-child {
            position: sticky;
            left: 0;
            background: #fff;
            z-index: 150;
        }

        /* POJOK KIRI ATAS */
        .table-monitoring thead th:first-child {
            z-index: 300;
        }

        .badge-success {
            background: #00cc66;
            padding: 5px 8px;
            border-radius: 20px;
        }

        /* MODAL */
        .modal-content {
            border-radius: 12px;
            animation: slideUp 0.4s ease;
        }

        .modal-header {
            background: linear-gradient(45deg, #990000, #ff3333);
            color: white;
        }

        /* ANIMATIONS */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(40px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* HEADER PROJECT */
        .project-header {
            background: linear-gradient(135deg, #b30000, #ff1a1a);
            color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            animation: fadeInDown 0.5s ease;
        }

        .project-title {
            font-size: 14px;
            opacity: 0.9;
        }

        .project-name {
            font-size: 22px;
            font-weight: bold;
        }

        /* CARD */
        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            animation: fadeInUp 0.4s ease;
        }

        /* BUTTON */
        .btn-success {
            background: linear-gradient(135deg, #ff1a1a, #cc0000);
            border: none;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(255, 0, 0, 0.4);
        }

        /* TABLE */
        .table-monitoring {
            font-size: 14px;
            white-space: nowrap;
        }

        .table-monitoring th {
            background: #b30000 !important;
            color: white;
            text-align: center;
            vertical-align: middle;
        }

        .table-monitoring tbody tr {
            transition: 0.2s;
        }

        .table-monitoring tbody tr:hover {
            background-color: #ffe5e5;
            transform: scale(1.01);
        }

        /* BADGE */
        .badge-danger {
            background-color: #ff1a1a;
        }

        .badge-success {
            background-color: #28a745;
        }

        /* MODAL */
        .modal-content {
            border-radius: 12px;
            animation: zoomIn 0.3s ease;
        }

        /* ANIMATIONS */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
        }

        .header-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* bikin center horizontal */
            justify-content: center;
            margin-bottom: 20px;
        }

        .project-header {
            width: 100%;
            max-width: 600px;
            /* ini penting biar tidak kepanjangan */
            text-align: center;
        }

        /* 🔥 HEADER + FILTER + BUTTON STICKY */
        .sticky-top-section {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: #f8f9fa;
        }

        /* biar tiap layer rapi */
        .sticky-inner {
            background: #f8f9fa;
        }


        /* =========================================
                                       RESPONSIVE MOBILE MONITORING
                                    ========================================= */

        @media (max-width: 768px) {

            /* CONTENT */
            .content,
            .container-fluid {
                padding-left: 8px !important;
                padding-right: 8px !important;
            }

            /* STICKY HEADER */
            .sticky-top-section {
                top: 0;
                z-index: 999;
                padding-bottom: 5px;
            }

            .sticky-inner {
                padding: 0;
            }

            /* PROJECT HEADER */
            .project-header {
                max-width: 100% !important;
                padding: 14px !important;
                border-radius: 10px;
            }

            .project-title {
                font-size: 11px !important;
            }

            .project-name {
                font-size: 16px !important;
                line-height: 1.4;
            }

            /* CARD */
            .card {
                border-radius: 10px;
            }

            .card-body {
                padding: 10px !important;
            }

            /* FILTER */
            .row .col-md-2,
            .row .col-md-11 {
                width: 100%;
                max-width: 100%;
                flex: 100%;
            }

            .row label {
                font-size: 11px;
                margin-bottom: 3px;
            }

            .form-control {
                height: 36px !important;
                font-size: 12px !important;
                border-radius: 8px !important;
            }

            /* BUTTONS */
            .btn,
            .btn-success,
            .btn-warning,
            .btn-danger,
            .btn-primary,
            .btn-secondary {
                height: 34px !important;
                min-height: 34px !important;
                padding: 0 12px !important;
                font-size: 11px !important;
                border-radius: 8px !important;

                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;

                white-space: nowrap;
            }

            /* BUTTON ICON */
            .btn i {
                font-size: 10px !important;
            }

            /* BUTTON ACTION TABLE */
            td .btn {
                width: 32px !important;
                height: 32px !important;
                padding: 0 !important;
            }

            /* BUTTON FILTER */
            .btn-primary.btn-sm,
            .btn-secondary.btn-sm {
                width: 100%;
                margin-top: 6px;
            }

            /* BUTTON TAMBAH */
            .header-wrapper .btn-success {
                width: 100%;
                max-width: 250px;
                font-size: 12px !important;
            }

            /* TABLE CONTAINER */
            .table-container {
                overflow-x: auto;
                overflow-y: auto;
                max-height: 70vh;
                border-radius: 10px;
            }

            /* TABLE */
            .table-monitoring {
                min-width: 1700px;
                font-size: 11px !important;
            }

            .table-monitoring th,
            .table-monitoring td {
                padding: 6px !important;
                font-size: 10px !important;
                white-space: nowrap;
            }

            /* FREEZE FIRST COLUMN */
            .table-monitoring th:first-child {
                position: sticky;
                left: 0;
                z-index: 600;
                background: #b30000 !important;
                min-width: 50px;
            }

            .table-monitoring td:first-child {
                position: sticky;
                left: 0;
                background: #ffffff !important;
                z-index: 500;
                min-width: 50px;
            }

            /* HEADER FREEZE */
            /* HEADER */
            .table-monitoring thead th {
                position: sticky;
                top: 0;
                z-index: 550;
                background: #b30000 !important;
            }

            /* POJOK KIRI ATAS */
            .table-monitoring thead th:first-child {
                z-index: 700 !important;
            }

            /* BADGE */
            .badge {
                font-size: 9px !important;
                padding: 4px 7px !important;
            }

            /* MODAL */
            .modal-dialog {
                margin: 10px;
                max-width: calc(100% - 20px);
            }

            .modal-content {
                border-radius: 12px;
            }

            .modal-header {
                padding: 12px;
            }

            .modal-header h5 {
                font-size: 15px;
                margin: 0;
            }

            .modal-body {
                padding: 12px;
            }

            .modal-footer {
                padding: 10px;
            }

            /* FORM DALAM MODAL */
            .modal-body .col-md-4,
            .modal-body .col-md-12 {
                width: 100%;
                max-width: 100%;
                flex: 100%;
            }

            .modal-body label {
                font-size: 12px;
                margin-bottom: 4px;
            }

            /* MODAL BUTTON */
            .modal-footer .btn {
                flex: 1;
            }

            /* CHECKBOX */
            input[type="checkbox"] {
                transform: scale(1);
            }

            /* HAPUS TERPILIH */
            .table-container>.btn-danger,
            form>.btn-danger.mt-2 {
                width: 100%;
                margin-top: 10px;
            }
        }

        /* =========================================
                                       EXTRA SMALL DEVICE
                                    ========================================= */

        @media (max-width: 480px) {

            .project-name {
                font-size: 14px !important;
            }

            .project-title {
                font-size: 10px !important;
            }

            .table-monitoring th,
            .table-monitoring td {
                font-size: 9px !important;
                padding: 5px !important;
            }

            .btn {
                font-size: 10px !important;
            }

            .form-control {
                font-size: 11px !important;
            }

            .modal-header h5 {
                font-size: 14px;
            }
        }



        /* =========================================
                               RESPONSIVE 768px
                            ========================================= */
        /* ======================================
                       FILTER MOBILE TOGGLE
                    ====================================== */

        .filter-toggle-btn {
            display: none;
        }

        /* MOBILE */
        @media (max-width: 768px) {

            /* tombol filter */
            .filter-toggle-btn {
                display: block;
                width: 100%;
                margin-top: 10px;
                margin-bottom: 10px;

                height: 38px !important;
                font-size: 12px !important;
                border-radius: 10px !important;

                font-weight: 600;
            }

            /* filter default disembunyikan */
            #filterArea {
                display: none;
                animation: fadeFilter .3s ease;
            }

            /* ketika dibuka */
            #filterArea.show {
                display: block;
            }

            /* animasi */
            @keyframes fadeFilter {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* card lebih kecil */
            .card.mt-3.p-3 {
                padding: 8px !important;
            }

            /* table area lebih luas */
            .table-container {
                max-height: 78vh;
            }

            /* table lebih nyaman */
            .table-monitoring {
                min-width: 1700px;
            }

            /* sticky tetap aman */
            .sticky-top-section {
                background: #f8f9fa;
                z-index: 999;
            }

            /* filter input */
            #filterArea .form-control {
                font-size: 12px !important;
                height: 36px !important;
            }

            /* tombol filter & reset */
            #filterArea .btn {
                flex: 1;
                min-width: 100px;
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
