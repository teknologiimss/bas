@extends('layouts.main')

@section('content')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

    <style>
        :root {
            --primary: #c62828;
            --primary-dark: #8e0000;
            --primary-light: #ffebee;

            --planning: #42a5f5;
            --realisasi: #00c853;
        }

        body {
            background: #fafafa;
        }

        .card-matrix {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
        }

        .card-header-red {
            background: linear-gradient(135deg,
                    var(--primary),
                    var(--primary-dark));
            color: white;
        }

        .matrix-wrapper {
            overflow: auto;
            max-height: 80vh;
            border: 1px solid #f5c6cb;
        }

        .matrix-table {
            min-width: 5000px;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .matrix-table th,
        .matrix-table td {
            border: 1px solid #f1d4d4 !important;
        }

        /* HEADER */

        .matrix-table thead th {
            position: sticky;
            top: 0;
            z-index: 30;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
            font-size: 11px;
            font-weight: 700;
        }

        .month-header {
            background: linear-gradient(180deg,
                    #ef5350,
                    #c62828) !important;
            color: white !important;
        }

        .week-header {
            background: #ffcdd2 !important;
            color: #7f0000 !important;
            font-weight: 700;
        }

        /* STICKY COLUMN */

        .sticky-1,
        .sticky-2,
        .sticky-3,
        .sticky-4 {
            position: sticky;
            z-index: 25;
            font-weight: 600;
            border-right: 2px solid #d32f2f !important;
            box-shadow: 3px 0 8px rgba(0, 0, 0, .08);
        }

        .sticky-1 {
            left: 0;
            min-width: 70px;
            background: #ffebee;
        }

        .sticky-2 {
            left: 70px;
            min-width: 180px;
            background: #fff5f5;
        }

        .sticky-3 {
            left: 250px;
            min-width: 150px;
            background: #ffebee;
        }

        .sticky-4 {
            left: 400px;
            min-width: 200px;
            background: #fff5f5;
        }

        /* HEADER STICKY */

        thead .sticky-1,
        thead .sticky-2,
        thead .sticky-3,
        thead .sticky-4 {
            background: linear-gradient(180deg,
                    #c62828,
                    #8e0000) !important;

            color: white !important;
            z-index: 50;
        }

        /* ROW */

        .asset-row:nth-child(even) {
            background: #fffafa;
        }

        .asset-row:hover {
            background: #ffebee !important;
        }

        /* CELL */

        .matrix-cell {
            width: 24px;
            min-width: 24px;
            height: 24px;
            cursor: pointer;
            transition: .2s;
        }

        .matrix-cell:hover {
            transform: scale(1.2);
            box-shadow: 0 0 10px rgba(0, 0, 0, .3);
            z-index: 10;
            position: relative;
        }

        /* STATUS */

        .planning {
            background: #42a5f5;
        }

        .realisasi {
            background: #00c853;
        }

        /* LEGEND */

        .legend-box {
            width: 20px;
            height: 20px;
            display: inline-block;
            border-radius: 5px;
        }

        /* FOOTER */

        tfoot td {
            background: #fff5f5;
            font-weight: 600;
        }

        .progress {
            height: 28px;
            background: #f8d7da;
        }

        .progress-bar {
            font-weight: bold;
        }

        /* SCROLLBAR */

        .matrix-wrapper::-webkit-scrollbar {
            height: 12px;
        }

        .matrix-wrapper::-webkit-scrollbar-track {
            background: #f5f5f5;
        }

        .matrix-wrapper::-webkit-scrollbar-thumb {
            background: #c62828;
            border-radius: 10px;
        }

        .matrix-wrapper::-webkit-scrollbar-thumb:hover {
            background: #8e0000;
        }

        @media (max-width:768px) {

            /* =====================
                   HEADER RESPONSIVE
                   ===================== */

            .card-header-red .d-flex {
                flex-direction: column;
                align-items: stretch !important;
                gap: 10px;
            }

            .header-action {
                display: flex !important;
                flex-direction: column;
                gap: 8px;
                width: 100%;
            }

            .header-action .btn {
                width: 100%;
            }

            .card-header-red select {
                width: 100%;
                margin-top: 10px;
            }

            /* =====================
                   SUMMARY CARD
                   ===================== */

            .row.mb-4>div {
                margin-bottom: 10px;
            }

            /* =====================
                   TABLE MOBILE
                   ===================== */

            .matrix-wrapper {
                overflow-x: auto;
                overflow-y: auto;
                max-height: 70vh;
                -webkit-overflow-scrolling: touch;
            }

            .matrix-table {
                min-width: 2200px;
                font-size: 10px;
            }

            .matrix-table th,
            .matrix-table td {
                padding: 2px;
            }

            /* HAPUS STICKY DI HP */

            .sticky-1,
            .sticky-2,
            .sticky-3,
            .sticky-4 {
                position: static !important;
                left: auto !important;
                box-shadow: none !important;
            }

            thead .sticky-1,
            thead .sticky-2,
            thead .sticky-3,
            thead .sticky-4 {
                position: sticky;
                top: 0;
                z-index: 50;
            }

            .matrix-cell {
                width: 18px;
                min-width: 18px;
                height: 18px;
            }

            .month-header {
                font-size: 9px !important;
            }

            .week-header {
                font-size: 8px !important;
            }

        }
    </style>

    <div class="container-fluid mt-3">

        <div class="card card-matrix">

            <div class="card-header card-header-red">

                {{-- <div class="d-flex justify-content-between align-items-center"> --}}
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">

                    <div>

                        <h4 class="mb-2">

                            <i class="fas fa-calendar-check"></i>
                            MATRIX PERAWATAN ASSET

                        </h4>

                        {{-- <div class="header-action">

                            <a href="{{ route('assets.index') }}" class="btn btn-light">

                                <i class="fas fa-database"></i>
                                Master Asset

                            </a>

                            <a href="{{ route('assets.create') }}" class="btn btn-warning">

                                <i class="fas fa-plus"></i>
                                Tambah Asset

                            </a>

                        </div> --}}

                        <div class="header-action d-flex flex-column flex-md-row">

                            <a href="{{ route('assets.index') }}" class="btn btn-light mr-md-2 mb-2 mb-md-0">
                                <i class="fas fa-database"></i>
                                Master Asset
                            </a>

                            <a href="{{ route('assets.create') }}" class="btn btn-warning">
                                <i class="fas fa-plus"></i>
                                Tambah Asset
                            </a>

                        </div>

                    </div>

                    <div>

                        <select class="form-control" onchange="window.location='?tahun='+this.value">

                            @for ($i = 2024; $i <= 2035; $i++)
                                <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>

                                    {{ $i }}

                                </option>
                            @endfor

                        </select>

                    </div>

                </div>

            </div>

            <div class="card-body">

                {{-- SUMMARY --}}

                <div class="row mb-4">

                    <div class="col-md-3">

                        <div class="card border-0 shadow-sm">

                            <div class="card-body">

                                <small>Total Asset</small>

                                <h3 class="text-danger">

                                    {{ $totalAsset }}

                                </h3>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="card border-0 shadow-sm">

                            <div class="card-body">

                                <small>Tahun</small>

                                <h3 class="text-primary">

                                    {{ $tahun }}

                                </h3>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="card border-0 shadow-sm">

                            <div class="card-body">

                                <span class="legend-box" style="background:#42a5f5"></span>

                                Planning

                                &nbsp;&nbsp;&nbsp;

                                <span class="legend-box" style="background:#00c853"></span>

                                Realisasi

                            </div>

                        </div>

                    </div>

                </div>

                @php

                    $bulanNama = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGS', 'SEP', 'OKT', 'NOV', 'DES'];

                @endphp

                <div class="matrix-wrapper">

                    <table class="table table-bordered matrix-table">

                        <thead>

                            <tr>

                                <th rowspan="3" class="sticky-1">NO</th>
                                <th rowspan="3" class="sticky-2">UNIT</th>
                                <th rowspan="3" class="sticky-3">NO LAMBUNG</th>
                                <th rowspan="3" class="sticky-4">LOKASI</th>

                                @foreach ($bulanNama as $bulan)
                                    <th colspan="10" class="month-header">

                                        {{ $bulan }}

                                    </th>
                                @endforeach

                            </tr>

                            <tr>

                                @for ($bulan = 1; $bulan <= 12; $bulan++)
                                    @for ($minggu = 1; $minggu <= 5; $minggu++)
                                        <th colspan="2" class="week-header">

                                            M{{ $minggu }}

                                        </th>
                                    @endfor
                                @endfor

                            </tr>

                            <tr>

                                @for ($bulan = 1; $bulan <= 12; $bulan++)
                                    @for ($minggu = 1; $minggu <= 5; $minggu++)
                                        <th>P</th>
                                        <th>R</th>
                                    @endfor
                                @endfor

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($assets as $asset)
                                <tr class="asset-row">

                                    <td class="sticky-1">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="sticky-2">
                                        {{ $asset->unit }}
                                    </td>

                                    <td class="sticky-3">
                                        {{ $asset->no_lambung }}
                                    </td>

                                    <td class="sticky-4">
                                        {{ $asset->lokasi }}
                                    </td>

                                    @for ($bulan = 1; $bulan <= 12; $bulan++)
                                        @for ($minggu = 1; $minggu <= 5; $minggu++)
                                            @php

                                                $item = $asset->maintenances
                                                    ->where('bulan', $bulan)
                                                    ->where('minggu', $minggu)
                                                    ->first();

                                            @endphp

                                            {{-- Planning --}}

                                            <td class="matrix-cell {{ $item && $item->planning ? 'planning' : '' }}"
                                                data-type="planning" data-asset="{{ $asset->id }}"
                                                data-bulan="{{ $bulan }}" data-minggu="{{ $minggu }}">
                                            </td>

                                            {{-- Realisasi --}}

                                            <td class="matrix-cell {{ $item && $item->realisasi ? 'realisasi' : '' }}"
                                                data-type="realisasi" data-asset="{{ $asset->id }}"
                                                data-bulan="{{ $bulan }}" data-minggu="{{ $minggu }}">
                                            </td>
                                        @endfor
                                    @endfor

                                </tr>
                            @endforeach

                        </tbody>

                        <tfoot>

                            <tr>

                                <td colspan="4">

                                    <b>Progress Realisasi</b>

                                </td>

                                @for ($bulan = 1; $bulan <= 12; $bulan++)
                                    <td colspan="10">

                                        <div class="progress">

                                            <div class="progress-bar bg-success"
                                                style="width:
                                            {{ $monthlyProgress[$bulan] }}%">

                                                {{ $monthlyProgress[$bulan] }}%

                                            </div>

                                        </div>

                                    </td>
                                @endfor

                            </tr>

                        </tfoot>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).on(
            'click',
            '.matrix-cell',
            function() {

                let cell = $(this);

                $.ajax({

                    url: "{{ route('asset-maintenance.mark') }}",

                    type: 'POST',

                    data: {

                        _token: "{{ csrf_token() }}",

                        asset_id: cell.data('asset'),

                        tahun: "{{ $tahun }}",

                        bulan: cell.data('bulan'),

                        minggu: cell.data('minggu'),

                        type: cell.data('type')

                    },

                    beforeSend: function() {

                        cell.css(
                            'opacity',
                            '0.5'
                        );

                    },

                    success: function(response) {

                        location.reload();

                    },

                    error: function() {

                        alert(
                            'Gagal menyimpan data'
                        );

                    }

                });

            });
    </script>

@endsection
