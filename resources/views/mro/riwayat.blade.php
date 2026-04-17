@extends('layouts.main')
@section('title', __('Riwayat PR/SPPJP'))
@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

    <style>
        body {
            background-color: #f8f9fc;
        }

        .card-modern {
            border: none;
            border-radius: 14px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .header-red {
            background: linear-gradient(135deg, #b30000, #ff3333);
            color: white;
            padding: 18px 22px;
        }

        .header-red h5 {
            margin: 0;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .filter-box {
            background: #ffffff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            margin-bottom: 15px;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #eee;
            padding: 10px 12px;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #cc0000;
            box-shadow: 0 0 0 2px rgba(204, 0, 0, 0.1);
        }

        .btn-red {
            background: linear-gradient(135deg, #cc0000, #ff1a1a);
            color: white;
            border: none;
            border-radius: 10px;
        }

        .btn-red:hover {
            background: linear-gradient(135deg, #a30000, #e60000);
        }

        /* ICON BUTTON */
        .btn-icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 16px;
        }

        .btn-reset-icon {
            width: 42px;
            height: 42px;
            background-color: #6c757d;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-reset-icon:hover {
            background-color: #5a6268;
            color: white;
            transform: scale(1.05);
        }

        .btn-icon:hover {
            transform: scale(1.05);
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead {
            background-color: #fff5f5;
        }

        .table th {
            color: #b30000;
            font-weight: 600;
            border-bottom: 2px solid #f1f1f1;
        }

        .table tbody tr {
            transition: all 0.15s ease;
        }

        .table tbody tr:hover {
            background-color: #fff0f0;
            transform: scale(1.002);
        }

        .table td {
            vertical-align: middle;
        }

        .qty-highlight {
            font-weight: 600;
            color: #cc0000;
        }

        .total-box {
            background: #fff5f5;
            border-left: 6px solid #cc0000;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 15px;
        }

        tfoot {
            background-color: #fff0f0;
            font-weight: bold;
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
                    $isFilter = request()->filled('barang') || request()->filled('kode_material')|| request()->filled('nama_pekerjaan');

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
                                    <td colspan="8" class="text-center text-muted">
                                        Belum ada data
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        {{-- FOOTER --}}
                        @if ($isFilter)
                            <tfoot>
                                <tr class="text-center">
                                    <td colspan="7">TOTAL</td>
                                    <td>{{ number_format($totalQty, 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        @endif

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
