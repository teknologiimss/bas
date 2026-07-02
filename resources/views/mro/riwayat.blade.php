@extends('layouts.main')
@section('title', __('Riwayat PR/SPPJP'))
@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

    <style>
        :root {
            --navy: #0F172A;
            --navy-dark: #020617;
            --blue: #2563EB;
            --blue-light: #EFF6FF;
            --blue-soft: #F8FBFF;
            --border: #BFDBFE;
        }

        body {
            background: linear-gradient(135deg, #f8fafc, #eff6ff);
        }

        /* =========================
           CARD
        ========================= */

        .card-modern {
            border: none;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 8px 24px rgba(15, 23, 42, .08);
            overflow: hidden;
            transition: .25s;
        }

        .card-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 34px rgba(15, 23, 42, .12);
        }

        /* =========================
           HEADER
        ========================= */

        .header-red {
            background: linear-gradient(135deg, var(--navy), var(--blue));
            color: #fff;
            padding: 18px 22px;
        }

        .header-red h5 {
            margin: 0;
            font-weight: 600;
            letter-spacing: .5px;
        }

        /* =========================
           FILTER
        ========================= */

        .filter-box {
            background: #fff;
            padding: 16px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, .05);
            margin-bottom: 18px;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid var(--border);
            padding: 10px 12px;
            transition: .25s;
        }

        .form-control:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .15);
        }

        /* =========================
           BUTTON
        ========================= */

        .btn-red {
            background: linear-gradient(135deg, var(--blue), var(--navy));
            color: #fff;
            border: none;
            border-radius: 10px;
        }

        .btn-red:hover {
            background: linear-gradient(135deg, var(--navy), var(--blue));
            color: #fff;
        }

        .btn-icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: .25s;
        }

        .btn-icon:hover {
            transform: scale(1.05);
        }

        .btn-reset-icon {

            width: 42px;
            height: 42px;

            background: #64748b;
            color: #fff;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;

            text-decoration: none;

            transition: .25s;
        }

        .btn-reset-icon:hover {

            background: #475569;
            color: white;

            transform: scale(1.05);

        }

        /* =========================
           TABLE
        ========================= */

        .table {
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead {

            background: var(--blue-soft);

        }

        .table th {

            background: linear-gradient(135deg, var(--navy), var(--blue));

            color: white;

            border: none;

            font-weight: 600;

            text-align: center;

        }

        .table td {

            vertical-align: middle;

        }

        .table tbody tr {

            transition: .2s;

        }

        .table tbody tr:hover {

            background: #f4f8ff;

            transform: scale(1.002);

        }

        /* =========================
           QTY
        ========================= */

        .qty-highlight {

            color: var(--blue);

            font-weight: 700;

        }

        /* =========================
           REKAP
        ========================= */

        .total-box {

            background: #f8fbff;

            border-left: 5px solid var(--blue);

            border-radius: 10px;

            padding: 14px 16px;

        }

        tfoot {

            background: #eef5ff;

            font-weight: bold;

        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media(max-width:768px) {

            .card-modern {

                border-radius: 10px;

            }

            .header-red {

                padding: 14px;
                text-align: center;

            }

            .header-red h5 {

                font-size: 16px;

            }

            .filter-box {

                padding: 12px;

            }

            .filter-box .row>div {

                margin-bottom: 10px;

            }

            .form-control {

                font-size: 12px;
                height: 38px;

            }

            .btn-icon,
            .btn-reset-icon {

                width: 36px !important;
                height: 36px !important;
                font-size: 13px !important;

            }

            .table-responsive {

                overflow-x: auto;

            }

            .table {

                min-width: 950px;
                font-size: 11px;

            }

            .table th,
            .table td {

                white-space: nowrap;
                padding: 7px 6px;

            }

            .total-box {

                font-size: 12px;

            }

        }

        @media(max-width:480px) {

            .header-red h5 {

                font-size: 14px;

            }

            .table {

                font-size: 10px;

            }

            .btn-icon,
            .btn-reset-icon {

                width: 34px !important;
                height: 34px !important;

            }

        }
    </style>

    <div class="container-fluid">
        <div class="card card-modern">

            {{-- HEADER --}}
            <div class="header-red">
                <h5>Riwayat PR / SPPJP</h5>
            </div>

            <div class="card-body">

                {{-- 🔍 FILTER --}}
                <div class="filter-box">
                    <form method="GET" autocomplete="off">
                        <div class="row">

                            <div class="col-md-3">
                                <input type="text" name="nomor_kontrak" class="form-control"
                                    placeholder="🔎 Nomor Kontrak" value="{{ request('nomor_kontrak') }}"
                                    autocomplete="off">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="nama_pekerjaan" class="form-control"
                                    placeholder="🔎 Nama Pekerjaan" value="{{ request('nama_pekerjaan') }}"
                                    autocomplete="off">
                            </div>

                            <div class="col-md-3">
                                <input type="text" name="no_pr" class="form-control" placeholder="🔎 No PR / SPPJP"
                                    value="{{ request('no_pr') }}" autocomplete="off">
                            </div>

                            <div class="col-md-3">
                                <input type="text" name="kode_material" class="form-control"
                                    placeholder="🔎 Kode Material" value="{{ request('kode_material') }}"
                                    autocomplete="off">
                            </div>

                            <div class="col-md-3">
                                <input type="text" name="barang" class="form-control" placeholder="🔎 Nama Barang"
                                    value="{{ request('barang') }}" autocomplete="off">
                            </div>

                            <div class="col-md-3 d-flex align-items-center gap-2">

                                {{-- FILTER --}}
                                <button type="submit" class="btn btn-red btn-icon" data-toggle="tooltip" title="Filter">
                                    <i class="fas fa-search"></i>
                                </button>

                                {{-- RESET --}}
                                <a href="{{ url()->current() }}" class="btn btn-reset-icon" data-toggle="tooltip"
                                    title="Reset">
                                    <i class="fas fa-undo"></i>
                                </a>

                            </div>

                        </div>
                    </form>
                </div>

                {{-- LOGIC --}}
                @php
                    // $isFilter = request()->filled('nomor_kontrak') ||
                    //             request()->filled('no_pr') ||
                    //             request()->filled('barang');

                    // ✅ HANYA AKTIF JIKA FILTER BARANG
                    $isFilter = request()->filled('barang') || request()->filled('kode_material');

                    $totalQty = $riwayat->sum(function ($item) {
                        return (int) $item->qty;
                    });
                @endphp

                {{-- 🔢 TOTAL --}}
                {{-- @if ($isFilter)
                    <div class="total-box mb-3">
                        Total QTY: <strong>{{ number_format($totalQty, 0, ',', '.') }}</strong>
                    </div>
                @endif --}}

                @if ($isFilter)
                    <div class="total-box mb-3">
                        <strong>Rekap Barang & Spesifikasi:</strong>

                        <div class="table-responsive mt-2">
                            <table class="table table-sm table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>Kode Material</th>
                                        <th>Barang</th>
                                        <th>Spesifikasi</th>
                                        <th>Total Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($grouped as $g)
                                        <tr>
                                            <td>{{ $g->kode_material }}</td>
                                            <td>{{ $g->nama_barang }}</td>
                                            <td>{{ $g->spek }}</td>
                                            <td class="text-center">
                                                {{ number_format((int) $g->total_qty, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                {{-- 📋 TABLE --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>No Kontrak</th>
                                <th>Nama Pekerjaan</th>
                                <th>No PR/SPPJP</th>
                                <th>Tanggal</th>
                                <th>Dasar PR/SPPJP</th>
                                <th>Kode Material</th>
                                <th>Barang</th>
                                <th>Spesifikasi</th>
                                <th>Qty</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($riwayat as $r)
                                <tr class="text-center">
                                    <td>{{ $r->nomor_kontrak ?? '-' }}</td>
                                    <td>{{ $r->nama_pekerjaan ?? '-' }}</td>
                                    <td>{{ $r->no_pr }}</td>
                                    <td>{{ date('d/m/Y', strtotime($r->tgl_pr)) }}</td>
                                    <td>{{ $r->dasar_pr }}</td>
                                    <td>{{ $r->kode_material }}</td>
                                    <td class="text-left">{{ $r->nama_barang }}</td>
                                    <td class="text-left">{{ $r->spek }}</td>
                                    <td class="qty-highlight">
                                        {{ number_format((int) $r->qty, 0, ',', '.') }}
                                    </td>
                                    <td>{{ $r->satuan }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">
                                        Belum ada data
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        {{-- FOOTER --}}
                        {{-- @if ($isFilter)
                            <tfoot>
                                <tr class="text-center">
                                    <td colspan="8">TOTAL</td>
                                    <td>{{ number_format($totalQty, 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        @endif --}}

                    </table>
                </div>

            </div>
        </div>
    </div>

    {{-- TOOLTIP INIT (WAJIB kalau pakai Bootstrap) --}}
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

@endsection
