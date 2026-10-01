@extends('layouts.main')

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

    <style>
        :root {
            --primary: #0f172a;
            --primary-dark: #020617;
            --primary-light: #1e3a8a;
            --secondary: #2563eb;
            --bg: #eef4fb;
            --border: #cbd5e1;

            --planning: #3b82f6;
            --realisasi: #10b981;
        }

        body {
            background: var(--bg);
        }

        /* CARD STYLING */
        .card-matrix {
            border: none;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 12px 35px rgba(15, 23, 42, .12);
        }

        .card-header-red {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            padding: 22px;
        }

        .card-header-red h4 {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: .5px;
        }

        /* BUTTONS & SELECT */
        .header-action .btn {
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            transition: .3s;
        }

        .header-action .btn-light {
            background: white;
            color: var(--primary);
            border: none;
        }

        .header-action .btn-warning {
            background: var(--secondary);
            color: white;
            border: none;
        }

        .header-action .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, .18);
        }

        .card-header-red select {
            border-radius: 12px;
            border: none;
            min-width: 120px;
            font-weight: 600;
            font-size: 14px;
        }

        /* SUMMARY CARDS */
        .card-body>.row .card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 6px 18px rgba(15, 23, 42, .08);
            transition: .3s;
        }

        .card-body>.row .card:hover {
            transform: translateY(-3px);
        }

        .card-body>.row small {
            font-size: 13px;
            font-weight: 600;
        }

        .card-body>.row h3 {
            color: var(--primary);
            font-weight: 700;
            font-size: 2rem;
        }

        /* TABLE WRAPPER & FREEZE STYLING */
        .matrix-wrapper {
            overflow: auto;
            max-height: 80vh;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #ffffff;
        }

        .matrix-wrapper::-webkit-scrollbar {
            height: 10px;
            width: 10px;
        }

        .matrix-wrapper::-webkit-scrollbar-track {
            background: #dbe7f5;
        }

        .matrix-wrapper::-webkit-scrollbar-thumb {
            background: var(--primary-light);
            border-radius: 20px;
        }

        .matrix-table {
            min-width: 5800px;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 13px;
        }

        .matrix-table th,
        .matrix-table td {
            border: 1px solid #cbd5e1 !important;
            text-align: center;
            vertical-align: middle;
            padding: 6px 4px;
        }

        /* HEADER STICKY & MONTH COLORS */
        .matrix-table thead th {
            position: sticky;
            z-index: 30;
            font-weight: 700;
            white-space: nowrap;
        }

        .matrix-table thead tr:nth-child(1) th {
            top: 0;
            font-size: 13px;
        }

        .matrix-table thead tr:nth-child(2) th {
            top: 36px;
        }

        .matrix-table thead tr:nth-child(3) th {
            top: 66px;
            border-bottom: 3px solid #0f172a !important;
        }

        .month-header-even {
            background: #0f172a !important;
            color: #ffffff !important;
            letter-spacing: 1px;
            border-bottom: 2px solid #ffffff !important;
            border-right: 2px solid #ffffff !important;
        }

        .month-header-odd {
            background: #1e3a8a !important;
            color: #ffffff !important;
            letter-spacing: 1px;
            border-bottom: 2px solid #ffffff !important;
            border-right: 2px solid #ffffff !important;
        }

        .week-header {
            background: #f1f5f9 !important;
            color: #0f172a !important;
            font-weight: 700;
            font-size: 12px;
        }

        /* PEMBATAS ANTAR BULAN */
        .month-divider-right {
            border-right: 3px solid #0f172a !important;
        }

        /* STICKY COLUMNS (FREEZE PANES) */
        .sticky-col {
            position: sticky;
            z-index: 25;
            background: #ffffff;
            font-size: 13px;
        }

        .sticky-1 {
            left: 0px;
            width: 55px;
            min-width: 55px;
        }

        .sticky-2 {
            left: 55px;
            width: 160px;
            min-width: 160px;
            text-align: left !important;
            padding-left: 10px !important;
            /* STYLE KHUSUS ISI UNIT */
            font-weight: 700;
            color: #0f172a;
        }

        .sticky-3 {
            left: 215px;
            width: 120px;
            min-width: 120px;
            /* STYLE KHUSUS ISI NO LAMBUNG */
            font-weight: 700;
            color: #dc2626;
        }

        .sticky-4 {
            left: 335px;
            width: 140px;
            min-width: 140px;
            text-align: left !important;
            padding-left: 10px !important;
            border-right: 3px solid #0f172a !important;
            /* STYLE KHUSUS ISI LOKASI */
            font-weight: 700;
            color: #0f172a;
        }

        thead .sticky-col {
            background: #0f172a !important;
            color: #ffffff !important;
            z-index: 50 !important;
            font-weight: 700 !important;
        }

        /* ROW & CELL STYLING */
        .asset-row:nth-child(even) td {
            background: #f8fafc;
        }

        .asset-row:nth-child(odd) td {
            background: #ffffff;
        }

        .asset-row:hover td {
            background: #e2e8f0 !important;
        }

        .matrix-cell {
            width: 24px;
            min-width: 24px;
            height: 28px;
            cursor: pointer;
            transition: .2s;
            padding: 0 !important;
        }

        .matrix-cell:hover {
            opacity: 0.8;
            transform: scale(1.1);
            position: relative;
            z-index: 10;
        }

        .planning {
            background: var(--planning) !important;
        }

        .realisasi {
            background: var(--realisasi) !important;
        }

        .legend-box {
            width: 20px;
            height: 20px;
            display: inline-block;
            border-radius: 4px;
            vertical-align: middle;
        }

        /* FOOTER PROGRESS */
        tfoot td {
            position: sticky;
            bottom: 0;
            background: #f1f5f9;
            font-weight: 600;
            font-size: 13px;
            z-index: 20;
            border-top: 3px solid #0f172a !important;
        }

        .progress {
            height: 24px;
            border-radius: 12px;
            background: #e2e8f0;
        }

        .progress-bar {
            font-weight: 700;
            font-size: 12px;
            line-height: 24px;
            background: linear-gradient(90deg, #10b981, #22c55e) !important;
        }

        /* RESPONSIVE */
        @media(max-width:768px) {
            .sticky-col {
                position: static !important;
            }

            thead .sticky-col {
                position: sticky !important;
                top: 0;
            }
        }
    </style>

    <div class="container-fluid mt-3">
        <div class="card card-matrix">
            <div class="card-header card-header-red">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <div>
                        <h4 class="mb-2">
                            <i class="fas fa-calendar-check"></i>
                            MATRIX PERAWATAN ASSET
                        </h4>
                        <div class="header-action d-flex flex-column flex-md-row">
                            <a href="{{ route('assets.index') }}" class="btn btn-light mr-md-2 mb-2 mb-md-0">
                                <i class="fas fa-database"></i> Master Asset
                            </a>
                            <a href="{{ route('assets.create') }}" class="btn btn-warning">
                                <i class="fas fa-plus"></i> Tambah Asset
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
                                <h3 class="text-danger">{{ $totalAsset }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <small>Tahun</small>
                                <h3 class="text-primary">{{ $tahun }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center h-100">
                                <div style="font-size: 14px; font-weight: 600;">
                                    <span class="legend-box mr-1" style="background:#3b82f6"></span> Planning
                                    &nbsp;&nbsp;&nbsp;
                                    <span class="legend-box mr-1" style="background:#10b981"></span> Realisasi
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $bulanNama = [
                        'JANUARI',
                        'FEBRUARI',
                        'MARET',
                        'APRIL',
                        'MEI',
                        'JUNI',
                        'JULI',
                        'AGUSTUS',
                        'SEPTEMBER',
                        'OKTOBER',
                        'NOVEMBER',
                        'DESEMBER',
                    ];
                @endphp

                <div class="matrix-wrapper">
                    <table class="table table-bordered matrix-table">
                        <thead>
                            <tr>
                                <th rowspan="3" class="sticky-col sticky-1">NO</th>
                                <th rowspan="3" class="sticky-col sticky-2">UNIT</th>
                                <th rowspan="3" class="sticky-col sticky-3">NO LAMBUNG</th>
                                <th rowspan="3" class="sticky-col sticky-4">LOKASI</th>

                                @foreach ($bulanNama as $index => $bulan)
                                    <th colspan="10"
                                        class="{{ $index % 2 == 0 ? 'month-header-even' : 'month-header-odd' }} month-divider-right">
                                        {{ $bulan }}
                                    </th>
                                @endforeach
                            </tr>
                            <tr>
                                @for ($bulan = 1; $bulan <= 12; $bulan++)
                                    @for ($minggu = 1; $minggu <= 5; $minggu++)
                                        <th colspan="2"
                                            class="week-header {{ $minggu == 5 ? 'month-divider-right' : '' }}">
                                            M{{ $minggu }}
                                        </th>
                                    @endfor
                                @endfor
                            </tr>
                            <tr>
                                @for ($bulan = 1; $bulan <= 12; $bulan++)
                                    @for ($minggu = 1; $minggu <= 5; $minggu++)
                                        <th style="background:#f8fafc; font-size:11px;">P</th>
                                        <th style="background:#f8fafc; font-size:11px;"
                                            class="{{ $minggu == 5 ? 'month-divider-right' : '' }}">R</th>
                                    @endfor
                                @endfor
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($assets as $asset)
                                <tr class="asset-row">
                                    <td class="sticky-col sticky-1">{{ $loop->iteration }}</td>
                                    <td class="sticky-col sticky-2">{{ $asset->unit }}</td>
                                    <td class="sticky-col sticky-3">{{ $asset->no_lambung }}</td>
                                    <td class="sticky-col sticky-4">{{ $asset->lokasi }}</td>

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
                                            <td class="matrix-cell {{ $item && $item->realisasi ? 'realisasi' : '' }} {{ $minggu == 5 ? 'month-divider-right' : '' }}"
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
                                <td colspan="4" class="sticky-col sticky-1 text-center font-weight-bold"
                                    style="z-index:30;">
                                    PROGRESS (%)
                                </td>
                                @for ($bulan = 1; $bulan <= 12; $bulan++)
                                    <td colspan="10" class="month-divider-right">
                                        <div class="progress">
                                            <div class="progress-bar bg-success"
                                                style="width: {{ $monthlyProgress[$bulan] }}%">
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
        $(document).on('click', '.matrix-cell', function() {
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
                    cell.css('opacity', '0.5');
                },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Gagal menyimpan data');
                }
            });
        });
    </script>
@endsection
