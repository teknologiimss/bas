@extends('layouts.main')

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

    <style>
        body {
            background: #f4f6f9;
        }

        .main-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .section-header {
            background: #c98f8f;
            color: #000;
            font-weight: bold;
            font-size: 16px;
        }

        .table-checksheet th,
        .table-checksheet td {
            vertical-align: middle !important;
        }

        .table-checksheet th {
            background: #f1f1f1;
        }

        .badge-ok {
            background: #198754;
            color: #fff;
            padding: 5px 10px;
            border-radius: 8px;
        }

        .badge-nok {
            background: #dc3545;
            color: #fff;
            padding: 5px 10px;
            border-radius: 8px;
        }

        .badge-empty {
            background: #6c757d;
            color: #fff;
            padding: 5px 10px;
            border-radius: 8px;
        }

        .table-checksheet {
            font-size: 14px;
        }

        .detail-row {
            background: #fafafa;
        }

        .detail-row:hover {
            background: #f3f3f3;
        }

        @media(max-width:768px) {

            .table-checksheet {
                font-size: 12px;
            }

            /* BADGE MOBILE */
            .badge-ok,
            .badge-nok,
            .badge-empty {

                display: inline-block;
                font-size: 10px;
                padding: 3px 6px;
                border-radius: 6px;
                min-width: 42px;
                text-align: center;
                font-weight: 600;

            }

            /* TABLE MOBILE */
            .table-checksheet td,
            .table-checksheet th {

                padding: 8px 5px;
                vertical-align: middle !important;

            }

        }
    </style>

    <div class="container mt-4 mb-5">

        {{-- HEADER --}}
        <div class="card main-card p-4 mb-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <div>

                    <h3 class="mb-2">
                        📋 {{ $checksheet->judul }}
                    </h3>

                    <div class="row">

                        <div class="col-md-4 mb-2">
                            <b>Unit:</b>
                            {{ $checksheet->unit }}
                        </div>

                        <div class="col-md-4 mb-2">
                            <b>No Lambung:</b>
                            {{ $checksheet->no_lambung }}
                        </div>

                        {{-- <div class="col-md-4 mb-2">
                        <b>Tanggal:</b>
                        {{ $checksheet->tanggal }}
                    </div> --}}
                        <div class="col-md-4 mb-2">
                            <b>Tanggal:</b>
                            {{ \Carbon\Carbon::parse($checksheet->tanggal)->format('d/m/Y') }}
                        </div>

                        <div class="col-md-4 mb-2">

                            <b>Jenis Perawatan:</b>

                            {{ $checksheet->jenis_perawatan ?? '-' }}

                        </div>

                    </div>

                </div>

                <div class="mt-2">
                    <a href="{{ route('checksheet.mobile', $checksheet->id) }}" class="btn btn-success">
                        📱 Isi dari HP
                    </a>
                    <a href="{{ route('checksheet.pdf', $checksheet->id) }}" target="_blank" class="btn btn-primary">

                        🖨️ Print PDF

                    </a>
                </div>

            </div>

        </div>

        {{-- SECTION --}}
        @forelse($checksheet->sections as $section)
            <div class="card main-card mb-4">

                {{-- HEADER SECTION --}}
                <div class="card-header section-header">
                    {{ $section->nama_section }}
                </div>

                <div class="table-responsive">

                    <table class="table table-bordered table-checksheet mb-0">

                        <thead>

                            <tr class="text-center">

                                <th width="5%">
                                    No
                                </th>

                                <th width="20%">
                                    Uraian Pekerjaan
                                </th>

                                <th width="25%">
                                    Aktivitas Pekerjaan
                                </th>

                                <th width="20%">
                                    Standar
                                </th>

                                <th width="10%">
                                    Status
                                </th>

                                <th width="20%">
                                    Keterangan
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($section->items as $i => $item)
                                @php
                                    $detailCount = $item->details->count();
                                @endphp

                                {{-- JIKA ADA DETAIL --}}
                                @if ($detailCount > 0)
                                    @foreach ($item->details as $dIndex => $detail)
                                        <tr class="detail-row">

                                            {{-- NOMOR --}}
                                            @if ($dIndex == 0)
                                                <td rowspan="{{ $detailCount }}" class="text-center align-middle">

                                                    {{ $item->nomor }}

                                                </td>

                                                {{-- URAIAN --}}
                                                <td rowspan="{{ $detailCount }}" class="align-middle">

                                                    <b>{{ $item->uraian }}</b>

                                                </td>
                                            @endif

                                            {{-- AKTIVITAS --}}
                                            <td>
                                                {{ $detail->aktivitas ?: '-' }}
                                            </td>

                                            {{-- STANDAR --}}
                                            <td>
                                                {{ $detail->standar ?: '-' }}
                                            </td>

                                            {{-- STATUS --}}
                                            <td class="text-center">

                                                @if (optional($detail->result)->status == 'OK')
                                                    <span class="badge-ok">
                                                        OK
                                                    </span>
                                                @elseif(optional($detail->result)->status == 'NOK')
                                                    <span class="badge-nok">
                                                        NOK
                                                    </span>
                                                @else
                                                    <span class="badge-empty">
                                                        -
                                                    </span>
                                                @endif

                                            </td>

                                            {{-- KETERANGAN --}}
                                            <td>

                                                {{ optional($detail->result)->keterangan ?: '-' }}

                                            </td>

                                        </tr>
                                    @endforeach
                                @else
                                    {{-- JIKA TIDAK ADA DETAIL --}}
                                    <tr>

                                        <td class="text-center">
                                            {{ $i + 1 }}
                                        </td>

                                        <td>
                                            {{ $item->uraian }}
                                        </td>

                                        <td colspan="4" class="text-center text-muted">

                                            Tidak ada aktivitas

                                        </td>

                                    </tr>
                                @endif

                            @empty

                                <tr>

                                    <td colspan="6" class="text-center text-muted p-4">

                                        Tidak ada item checksheet

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        @empty

            <div class="card main-card p-5 text-center text-muted">

                Tidak ada section checksheet

            </div>
        @endforelse

    </div>

@endsection
