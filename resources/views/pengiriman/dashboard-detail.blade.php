@extends('layouts.main')

@section('title', $title)

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

    <style>
        body {
            background: #f4f7fb;
        }

        /* =========================
           CARD
        ========================= */
        .card-custom {
            border: 1px solid #e6eef8;
            border-radius: 15px;
            box-shadow: 0 3px 15px rgba(11, 31, 58, .08);
        }

        /* =========================
           HEADER PAGE (NAVY)
        ========================= */
        .header-page {
            background: linear-gradient(135deg, #0b1f3a, #163a6b);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .header-page h3 {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .header-page small {
            opacity: .85;
        }

        /* =========================
           TABLE HEADER
        ========================= */
        .table th {
            background: #163a6b;
            color: white;
            white-space: nowrap;
            border: none !important;
        }

        .table td {
            white-space: nowrap;
            color: #1f2d3d;
        }

        .table-hover tbody tr:hover {
            background: #eef4ff;
        }

        /* =========================
           BUTTON BACK
        ========================= */
        .btn-secondary {
            background: #1e3a8a;
            border: none;
        }

        .btn-secondary:hover {
            background: #163a6b;
        }

        /* =========================
           BADGE STYLE (BLUE VERSION)
        ========================= */
        .badge-success {
            background: #1e3a8a;
        }

        .badge-danger {
            background: #dc2626;
        }
    </style>

    <div class="container-fluid">

        <div class="header-page">

            <h3 class="mb-1">
                {{ $title }}
            </h3>

            <small>
                Total Data : {{ count($data) }}
            </small>

        </div>

        <div class="card card-custom">

            <div class="card-body">

                <a href="{{ route('pengiriman.index') }}" class="btn btn-secondary mb-3">
                    ← Kembali Dashboard
                </a>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        @if ($type == 'proyek')

                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Proyek</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->nama_proyek }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @elseif($type == 'vendor')
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Vendor</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->vendor }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @elseif($type == 'trainset')
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Trainset</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->trainset }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Trainset</th>
                                    <th>Tipe Kereta</th>
                                    <th>No Lambung</th>
                                    <th>Batch</th>
                                    <th>Trucking</th>
                                    <th>No SJN</th>
                                    <th>Plan Delivery</th>
                                    <th>Actual Delivery</th>
                                    <th>Status</th>
                                    <th>Vendor</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->trainset }}</td>
                                        <td>{{ $row->tipe_kereta }}</td>
                                        <td>{{ $row->nomor_lambung }}</td>
                                        <td>{{ $row->batch }}</td>
                                        <td>{{ $row->trucking }}</td>
                                        <td>{{ $row->no_sjn }}</td>
                                        <td>{{ $row->plan_delivery }}</td>
                                        <td>{{ $row->actual_delivery }}</td>
                                        <td>
                                            @if ($row->status_delivery == 'On Time')
                                                <span class="badge badge-success">On Time</span>
                                            @elseif($row->status_delivery == 'Overdue')
                                                <span class="badge badge-danger">Overdue</span>
                                            @endif
                                        </td>
                                        <td>{{ $row->vendor }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                        @endif

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection
