@extends('layouts.main')

@section('title', 'Data Alat Angkut')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        :root {
            --navy: #0b2545;
            --navy-dark: #071a32;
            --navy-light: #12355b;
            --blue: #2563eb;
            --blue-dark: #1d4ed8;
            --sky: #eff6ff;
            --border: #d9e2ef;
            --bg: #f4f7fb;
            --white: #ffffff;
            --text: #1f2937;
            --shadow: 0 10px 30px rgba(15, 23, 42, .08);
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: "Segoe UI", sans-serif;
        }

        /* ===========================
                HEADER
        ============================ */

        .header-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            animation: fadeDown .5s ease;
        }

        .project-header {
            width: 100%;
            max-width: 650px;
            text-align: center;
            background: linear-gradient(135deg,
                    var(--navy),
                    var(--navy-light));
            color: white;
            padding: 24px;
            border-radius: 18px;
            box-shadow: 0 15px 35px rgba(11, 37, 69, .28);
        }

        .project-title {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: .8;
        }

        .project-name {
            font-size: 24px;
            font-weight: 700;
            margin-top: 5px;
        }

        /* ===========================
                CARD
        ============================ */

        .card {
            border: none;
            border-radius: 18px;
            background: white;
            box-shadow: var(--shadow);
            animation: fadeUp .45s ease;
        }

        /* ===========================
                BUTTON
        ============================ */

        .btn {
            border-radius: 10px;
            transition: .25s;
            font-weight: 600;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(135deg,
                    var(--navy),
                    var(--navy-light));
            border: none;
        }

        .btn-success:hover {
            box-shadow: 0 10px 20px rgba(11, 37, 69, .28);
        }

        .btn-primary {
            background: var(--blue);
            border: none;
        }

        .btn-primary:hover {
            background: var(--blue-dark);
        }

        .btn-info {
            background: #0ea5e9;
            border: none;
            color: white;
        }

        .btn-info:hover {
            background: #0284c7;
        }

        .btn-warning {
            background: #f59e0b;
            border: none;
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .btn-danger {
            background: #dc2626;
            border: none;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .btn-secondary {
            border: none;
            background: #64748b;
        }

        /* ===========================
                FILTER CARD
        ============================ */

        #filterArea {
            border: none;
            border-radius: 16px;
            box-shadow: var(--shadow);
            background: white;
        }

        /* ===========================
                FORM
        ============================ */

        label {
            font-weight: 600;
            color: var(--navy);
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid var(--border);
            transition: .25s;
        }

        .form-control:focus {
            border-color: var(--navy);
            box-shadow: 0 0 0 .2rem rgba(11, 37, 69, .12);
        }

        /* ===========================
                TABLE
        ============================ */

        .table-container {
            overflow: auto;
            max-height: 550px;
            border-radius: 15px;
        }

        .table-monitoring {
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-monitoring th {
            position: sticky;
            top: 0;
            background: linear-gradient(135deg,
                    var(--navy),
                    var(--navy-light));
            color: white;
            border: none;
            z-index: 10;
        }

        .table-monitoring td {
            background: white;
            vertical-align: middle;
        }

        .table-monitoring tbody tr {
            transition: .25s;
        }

        .table-monitoring tbody tr:hover td {
            background: #f5f9ff;
        }

        .table-monitoring td:first-child {
            position: sticky;
            left: 0;
            background: white;
            z-index: 8;
        }

        .table-monitoring th:first-child {
            position: sticky;
            left: 0;
            background: linear-gradient(135deg,
                    var(--navy),
                    var(--navy-light));
            z-index: 15;
        }

        /* ===========================
                ACTION BUTTON
        ============================ */

        .action-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .action-buttons .btn {
            min-width: 38px;
        }

        /* ===========================
                MODAL
        ============================ */

        .modal-content {
            border: none;
            border-radius: 18px;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg,
                    var(--navy),
                    var(--navy-light));
            color: white;
        }

        .modal-footer {
            background: #f8fafc;
            border-top: 1px solid #e5e7eb;
        }

        /* ===========================
                BADGE
        ============================ */

        .badge.bg-primary {
            background: var(--navy) !important;
        }

        .badge.bg-success {
            background: #16a34a !important;
        }

        .badge.bg-danger {
            background: #dc2626 !important;
        }

        /* ===========================
                STICKY HEADER
        ============================ */

        .sticky-top-section {
            position: sticky;
            top: 0;
            z-index: 999;
            background: var(--bg);
            padding-bottom: 10px;
        }

        /* ===========================
                SCROLLBAR
        ============================ */

        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }

        ::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 20px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--navy);
        }

        /* ===========================
                ANIMATION
        ============================ */

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeDown {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===========================================
                    SUMMARY CARD
        =========================================== */

        .summary-card {
            background: #fff;
            border: 1px solid #dbe6f5;
            border-radius: 18px;
            padding: 18px;
            position: relative;
            overflow: hidden;
            transition: all .3s ease;
            box-shadow: 0 8px 25px rgba(15, 23, 42, .05);
        }

        .summary-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg,
                    var(--navy),
                    var(--blue));
        }

        .summary-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 35px rgba(11, 37, 69, .15);
        }

        .summary-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .summary-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--navy);
        }

        .unit-icon {
            font-size: 22px;
        }

        /* ===========================================
                    SUMMARY SECTION
        =========================================== */

        .summary-section {
            background: #f8fbff;
            border-left: 4px solid var(--navy);
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 12px;
            transition: .3s;
        }

        .summary-section:hover {
            background: #eef5ff;
        }

        .summary-section .fw-bold {
            font-size: 14px;
            margin-bottom: 6px;
        }

        .summary-section div {
            font-size: 13px;
            color: #475569;
            line-height: 1.7;
        }

        /* ===========================================
                    BADGE SOFT
        =========================================== */

        .badge-soft-primary {
            background: #e8f0ff;
            color: var(--navy);
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 30px;
        }

        .badge-soft-success {
            background: #e9f9ef;
            color: #15803d;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 30px;
        }

        .badge-soft-danger {
            background: #fdecec;
            color: #dc2626;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 30px;
        }

        .badge-soft-warning {
            background: #fff8e6;
            color: #b45309;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 30px;
        }

        /* ===========================================
                    DETAIL LOKASI
        =========================================== */

        .scroll-area {
            max-height: 160px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .scroll-area .d-flex {
            transition: .25s;
            border-bottom: 1px solid #edf2f7 !important;
        }

        .scroll-area .d-flex:hover {
            background: #f5f9ff;
            border-radius: 8px;
            padding-left: 6px;
        }

        .scroll-area span:first-child {
            color: #334155;
            font-weight: 600;
        }

        .scroll-area span:last-child {
            color: #64748b;
            font-size: 12px;
        }

        /* ===========================================
                    CUSTOM SCROLLBAR
        =========================================== */

        .scroll-area::-webkit-scrollbar {
            width: 6px;
        }

        .scroll-area::-webkit-scrollbar-track {
            background: #edf2f7;
            border-radius: 20px;
        }

        .scroll-area::-webkit-scrollbar-thumb {
            background: var(--navy);
            border-radius: 20px;
        }

        .scroll-area::-webkit-scrollbar-thumb:hover {
            background: var(--blue);
        }

        /* ===========================================
                    TABLE ROW
        =========================================== */

        .table-monitoring tbody tr {
            transition: .25s;
        }

        .table-monitoring tbody tr:hover td {
            background: #f4f8ff;
        }

        .table-monitoring tbody tr:nth-child(even) td {
            background: #fcfdff;
        }

        /* ===========================================
                    INPUT
        =========================================== */

        input.form-control,
        select.form-control,
        textarea.form-control {
            background: #fff;
            border: 1px solid #d6dfeb;
        }

        input.form-control:hover,
        select.form-control:hover,
        textarea.form-control:hover {
            border-color: var(--blue);
        }

        /* ===========================================
                    MODAL
        =========================================== */

        .modal-content {
            animation: popup .35s ease;
        }

        @keyframes popup {
            from {
                opacity: 0;
                transform: scale(.92);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* ===========================================
                    TITLE
        =========================================== */

        h5,
        h4,
        h3 {
            color: var(--navy);
            font-weight: 700;
        }

        /* ===========================================
                    HR
        =========================================== */

        hr {
            border-top: 1px solid #d8e4f3;
        }

        /* ===========================================
                    CARD HOVER
        =========================================== */

        .card:hover {
            box-shadow: 0 15px 35px rgba(15, 23, 42, .10);
        }

        /* ===========================================
                    LINK
        =========================================== */

        a {
            color: var(--navy);
            transition: .25s;
        }

        a:hover {
            color: var(--blue);
            text-decoration: none;
        }

        /* ===========================================
                    ICON BUTTON
        =========================================== */

        .action-buttons .btn {
            width: 38px;
            height: 38px;
            padding: 0;
            border-radius: 10px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }

        .action-buttons .btn:hover {
            transform: translateY(-3px);
        }

        /* ===========================================
                    ANIMATION
        =========================================== */

        .summary-card {
            animation: fadeUp .45s ease;
        }

        .card {
            animation: fadeUp .45s ease;
        }

        .project-header {
            animation: fadeDown .45s ease;
        }

        /* =========================================
                    RESPONSIVE MOBILE
        ========================================= */

        .mobile-filter-toggle {
            display: none;
        }

        @media (max-width:768px) {

            body {
                overflow-x: hidden;
                background: var(--bg);
            }

            .container-fluid,
            .content-wrapper,
            .content {
                padding-left: 8px !important;
                padding-right: 8px !important;
            }

            /* =============================
                    HEADER
            ============================== */

            .header-wrapper {
                margin-bottom: 15px;
            }

            .project-header {
                width: 100%;
                max-width: 100%;
                padding: 16px;
                border-radius: 14px;
            }

            .project-title {
                font-size: 11px;
                letter-spacing: .8px;
            }

            .project-name {
                font-size: 18px;
                line-height: 1.4;
            }

            /* =============================
                    BUTTON
            ============================== */

            .btn,
            .btn-success,
            .btn-danger,
            .btn-warning,
            .btn-info,
            .btn-secondary,
            .btn-primary {
                height: 36px;
                min-height: 36px;
                border-radius: 9px;
                padding: 0 12px;
                font-size: 12px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                white-space: nowrap;
            }

            /* =============================
                    FILTER
            ============================== */

            .mobile-filter-toggle {
                display: block;
                width: 100%;
                margin-bottom: 10px;
            }

            #filterArea {
                display: none;
                animation: fadeFilter .3s ease;
            }

            #filterArea.show {
                display: block;
            }

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

            #filterArea .row>.col-md-3,
            #filterArea .row>.col-md-4,
            #filterArea .row>.col-md-6,
            #filterArea .row>.col-md-12 {
                width: 100%;
                max-width: 100%;
                flex: 100%;
            }

            #filterArea label {
                font-size: 12px;
                margin-bottom: 5px;
            }

            /* =============================
                    FORM
            ============================== */

            .form-control {
                height: 38px;
                font-size: 12px;
                border-radius: 10px;
            }

            textarea.form-control {
                height: auto;
            }

            /* =============================
                    CARD
            ============================== */

            .card {
                border-radius: 14px;
                padding: 14px !important;
            }

            /* =============================
                    SUMMARY
            ============================== */

            .summary-card {
                padding: 14px;
                border-radius: 14px;
            }

            .summary-title {
                font-size: 14px;
            }

            .summary-header {
                margin-bottom: 10px;
            }

            .summary-section {
                padding: 10px;
            }

            .summary-section div {
                font-size: 12px;
            }

            .scroll-area {
                max-height: 130px;
            }

            /* =============================
                    TABLE
            ============================== */

            .table-container {
                overflow-x: auto;
                overflow-y: auto;
                max-height: 72vh;
                border-radius: 12px;
                position: relative;
            }

            .table-monitoring {
                min-width: 1550px;
                font-size: 11px;
            }

            .table-monitoring th,
            .table-monitoring td {
                white-space: nowrap;
                padding: 6px;
                font-size: 11px;
            }

            .table-monitoring thead th {
                position: sticky;
                top: 0;
                z-index: 500;
                background: linear-gradient(135deg,
                        var(--navy),
                        var(--navy-light));
            }

            .table-monitoring th:first-child {
                position: sticky;
                left: 0;
                z-index: 700;
                background: linear-gradient(135deg,
                        var(--navy),
                        var(--navy-light));
            }

            .table-monitoring td:first-child {
                position: sticky;
                left: 0;
                background: white;
                z-index: 600;
            }

            /* =============================
                    ACTION BUTTON
            ============================== */

            .action-buttons {
                display: flex;
                gap: 4px;
                flex-wrap: nowrap;
            }

            .action-buttons .btn {
                width: 32px;
                height: 32px;
                min-width: 32px;
                padding: 0;
                font-size: 12px;
            }

            /* =============================
                    MODAL
            ============================== */

            .modal-dialog {
                margin: 10px;
                max-width: calc(100% - 20px);
            }

            .modal-content {
                border-radius: 14px;
            }

            .modal-body .col-md-3,
            .modal-body .col-md-4,
            .modal-body .col-md-6 {
                width: 100%;
                max-width: 100%;
                flex: 100%;
            }

            .modal-body label {
                font-size: 12px;
            }

            .modal-footer {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .modal-footer .btn {
                width: 100%;
            }

            /* =============================
                    DELETE BUTTON
            ============================== */

            #btnDeleteSelected {
                width: 100%;
                margin-top: 10px;
            }

            /* =============================
                    TITLE
            ============================== */

            h5 {
                font-size: 16px;
            }

            h4 {
                font-size: 18px;
            }

            /* =============================
                    BADGE
            ============================== */

            .badge {
                font-size: 10px;
                padding: 5px 8px;
            }

            /* =============================
                    SCROLLBAR
            ============================== */

            ::-webkit-scrollbar {
                height: 5px;
                width: 5px;
            }

            /* =============================
                    STICKY
            ============================== */

            .sticky-top-section {
                padding-bottom: 10px;
            }

        }
    </style>

    <div class="sticky-top-section">

        <div class="header-wrapper">

            <div class="project-header">
                <div class="project-title">
                    Data Alat Angkat - Angkut
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
        {{-- BUTTON TOGGLE FILTER MOBILE --}}
        <button type="button" class="btn btn-dark mobile-filter-toggle" id="toggleFilter">
            🔍 Tampilkan / Sembunyikan Filter
        </button>
        <div class="card mt-3 p-3" id="filterArea">

            <form method="GET">
                <div class="row">

                    <div class="col-md-3">
                        <label>Unit</label>
                        <input type="text" name="unit" value="{{ request('unit') }}" class="form-control"
                            autocomplete="off">
                    </div>

                    <div class="col-md-3">
                        <label>No Lambung</label>
                        <input type="text" name="no_lambung" value="{{ request('no_lambung') }}" class="form-control"
                            autocomplete="off">
                    </div>

                    <div class="col-md-3">
                        <label>No Kontrak</label>
                        <input type="text" name="no_kontrak" value="{{ request('no_kontrak') }}" class="form-control"
                            autocomplete="off">
                    </div>

                    <div class="col-md-3">
                        <label>Aset</label>
                        <input type="text" name="aset" value="{{ request('aset') }}" class="form-control"
                            autocomplete="off">
                    </div>

                    <div class="col-md-12 mt-3">
                        <button class="btn btn-primary btn-sm">🔍 Filter</button>
                        <a href="{{ url()->current() }}" class="btn btn-secondary btn-sm">Reset</a>
                    </div>

                </div>
            </form>

        </div>
        <button id="btnDeleteSelected" class="btn btn-danger btn-sm mt-2">
            🗑️ Hapus Data Dipilih/centang
        </button>

    </div>

    <div class="card mt-3 p-3">
        <h5 class="mb-3 fw-bold">📊 Ringkasan Data Alat Angkat - Angkut</h5>

        <div class="row">
            @forelse($summary as $unit => $data)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-3">

                    <div class="summary-card p-3 h-100">

                        {{-- HEADER --}}
                        <div class="summary-header mb-2">
                            <div class="summary-title">
                                🚛 {{ $unit }}
                            </div>
                            <span class="badge bg-primary">
                                {{ $data['total'] }}
                            </span>
                        </div>

                        {{-- 🔴 IMSS --}}
                        <div class="summary-section">
                            <div class="fw-bold text-danger mb-1">
                                🔴 IMSS ({{ $data['imss']['total'] }})
                            </div>

                            <div style="font-size: 13px;">
                                📍
                                {{ count($data['imss']['lokasi']) ? implode(', ', $data['imss']['lokasi']->toArray()) : '-' }}
                            </div>

                            <div style="font-size: 13px;">
                                🏷️
                                {{ count($data['imss']['no_lambung']) ? implode(', ', $data['imss']['no_lambung']->toArray()) : '-' }}
                            </div>
                        </div>

                        {{-- 🟢 NON --}}
                        <div class="summary-section">
                            <div class="fw-bold text-success mb-1">
                                🟢 Non IMSS ({{ $data['non']['total'] }})
                            </div>

                            <div style="font-size: 13px;">
                                📍
                                {{ count($data['non']['lokasi']) ? implode(', ', $data['non']['lokasi']->toArray()) : '-' }}
                            </div>

                            <div style="font-size: 13px;">
                                🏷️
                                {{ count($data['non']['no_lambung']) ? implode(', ', $data['non']['no_lambung']->toArray()) : '-' }}
                            </div>
                        </div>

                        {{-- 📍 DETAIL LOKASI --}}
                        <div>
                            <div class="fw-bold mb-1">📍 Detail Lokasi</div>

                            <div class="scroll-area" style="font-size: 12px;">
                                @foreach ($data['lokasi_map'] as $lok => $lambungs)
                                    <div class="d-flex justify-content-between border-bottom py-1">
                                        <span>{{ $lok ?: '-' }}</span>
                                        <span class="text-muted">
                                            {{ count($lambungs) ? implode(', ', $lambungs->toArray()) : '-' }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    Tidak ada data
                </div>
            @endforelse
        </div>
    </div>

    <div class="card mt-3 p-3">

        <div class="table-container">
            <table class="table table-bordered table-monitoring text-center">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="checkAll">
                        </th>
                        <th>No</th>
                        <th>Unit</th>
                        <th>No Lambung</th>
                        <th>Kapasitas</th>
                        <th>Lokasi</th>
                        <th>No Kontrak</th>
                        <th>Aset</th>
                        <th>Model/SN</th>
                        <th>Tanggal Kontrak</th>
                        <th>Selesai Kontrak</th>
                        <th>Kontrak Dengan</th>
                        <th>Tahun Kedatangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($detail as $d)
                        <tr>
                            <td>
                                <input type="checkbox" class="checkItem" value="{{ $d->id }}">
                            </td>
                            <td>{{ $loop->iteration }}</td>
                            <td><b>{{ $d->unit }}</b></td>
                            <td>{{ $d->no_lambung }}</td>
                            <td>{{ $d->kapasitas }}</td>
                            <td>{{ $d->lokasi }}</td>
                            <td>{{ $d->no_kontrak }}</td>
                            {{-- <td>{{ $d->aset }}</td> --}}
                            <td>
                                @if (str_contains(strtoupper($d->aset), 'IMSS'))
                                    <span class="badge bg-danger">🔴 {{ $d->aset }}</span>
                                @else
                                    <span class="badge bg-success">🟢 {{ $d->aset }}</span>
                                @endif
                            </td>
                            <td>{{ $d->model_sn }}</td>
                            {{-- <td>{{ $d->tgl_kontrak }}</td> --}}
                            <td>
                                {{ $d->tgl_kontrak ? \Carbon\Carbon::parse($d->tgl_kontrak)->format('d/m/Y') : '-' }}
                            </td>
                            {{-- <td>{{ $d->tgl_habis }}</td> --}}
                            <td>
                                {{ $d->tgl_habis ? \Carbon\Carbon::parse($d->tgl_habis)->format('d/m/Y') : '-' }}
                            </td>
                            <td>{{ $d->kontrak_dgn }}</td>
                            <td>{{ $d->thn_kedatangan }}</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#edit{{ $d->id }}">✏️</button>

                                    <a href="{{ route('alat.detail.monitor', $d->id) }}" class="btn btn-info btn-sm">
                                        📋
                                    </a>

                                    <button class="btn btn-danger btn-sm btn-delete"
                                        data-id="{{ $d->id }}">🗑️</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

    </div>


    {{-- MODAL TAMBAH --}}
    <div class="modal fade" id="modalTambah">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ route('alat.detail.store') }}">
                @csrf
                <input type="hidden" name="alat_id" value="{{ $proyek->id }}">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Tambah Data Alat Angkut</h5>
                    </div>

                    <div class="modal-body row">

                        <div class="col-md-4 mb-2">
                            <label>Unit</label>
                            <input name="unit" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>No Lambung</label>
                            <input name="no_lambung" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Kapasitas</label>
                            <input name="kapasitas" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Lokasi</label>
                            <input name="lokasi" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>No Kontrak</label>
                            <input name="no_kontrak" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Aset</label>
                            <input name="aset" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Model / Serial Number</label>
                            <input name="model_sn" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Tanggal Kontrak</label>
                            <input type="date" name="tgl_kontrak" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Tanggal Habis Kontrak</label>
                            <input type="date" name="tgl_habis" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Kontrak Dengan</label>
                            <input name="kontrak_dgn" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Tahun Kedatangan</label>
                            <input name="thn_kedatangan" class="form-control" autocomplete="off">
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

    {{-- MODAL EDIT --}}
    @foreach ($detail as $d)
        <div class="modal fade" id="edit{{ $d->id }}">
            <div class="modal-dialog modal-lg">
                <form method="POST" action="{{ route('alat.detail.update', $d->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Edit Data</h5>
                        </div>

                        <div class="modal-body row">

                            <div class="col-md-4 mb-2">
                                <label>Unit</label>
                                <input name="unit" value="{{ $d->unit }}" class="form-control"
                                    autocomplete="off">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>No Lambung</label>
                                <input name="no_lambung" value="{{ $d->no_lambung }}" class="form-control"
                                    autocomplete="off">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Kapasitas</label>
                                <input name="kapasitas" value="{{ $d->kapasitas }}" class="form-control"
                                    autocomplete="off">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Lokasi</label>
                                <input name="lokasi" value="{{ $d->lokasi }}" class="form-control"
                                    autocomplete="off">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>No Kontrak</label>
                                <input name="no_kontrak" value="{{ $d->no_kontrak }}" class="form-control"
                                    autocomplete="off">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Aset</label>
                                <input name="aset" value="{{ $d->aset }}" class="form-control"
                                    autocomplete="off">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Model / Serial Number</label>
                                <input name="model_sn" value="{{ $d->model_sn }}" class="form-control"
                                    autocomplete="off">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Tanggal Kontrak</label>
                                <input type="date" name="tgl_kontrak" value="{{ $d->tgl_kontrak }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Tanggal Habis Kontrak</label>
                                <input type="date" name="tgl_habis" value="{{ $d->tgl_habis }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Kontrak Dengan</label>
                                <input name="kontrak_dgn" value="{{ $d->kontrak_dgn }}" class="form-control"
                                    autocomplete="off">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Tahun Kedatangan</label>
                                <input name="thn_kedatangan" value="{{ $d->thn_kedatangan }}" class="form-control"
                                    autocomplete="off">
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

    <form id="bulkDeleteForm" method="POST" action="{{ route('alat.detail.bulkDelete') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="ids" id="bulkIds">
    </form>

@endsection

@section('custom-js')
    <script>
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                let id = this.dataset.id;
                if (confirm('Hapus data?')) {
                    let form = document.getElementById('deleteForm');
                    let url = "{{ route('alat.detail.delete', ':id') }}";
                    form.action = url.replace(':id', id);
                    form.submit();
                }
            });
        });
    </script>

    <script>
        // CHECK ALL
        document.getElementById('checkAll').addEventListener('click', function() {
            document.querySelectorAll('.checkItem').forEach(cb => {
                cb.checked = this.checked;
            });
        });

        // DELETE SELECTED
        document.getElementById('btnDeleteSelected').addEventListener('click', function() {

            let ids = [];
            document.querySelectorAll('.checkItem:checked').forEach(cb => {
                ids.push(cb.value);
            });

            if (ids.length === 0) {
                alert('Pilih data dulu!');
                return;
            }

            if (confirm('Hapus data terpilih?')) {
                document.getElementById('bulkIds').value = ids.join(',');
                document.getElementById('bulkDeleteForm').submit();
            }
        });
    </script>

    <script>
        // TOGGLE FILTER MOBILE
        const toggleBtn = document.getElementById('toggleFilter');
        const filterArea = document.getElementById('filterArea');

        toggleBtn.addEventListener('click', function() {
            filterArea.classList.toggle('show');
        });

        // AUTO HIDE FILTER SAAT MOBILE
        if (window.innerWidth > 768) {
            filterArea.classList.add('show');
        }
    </script>
@endsection
