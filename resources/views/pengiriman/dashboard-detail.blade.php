@extends('layouts.main')

@section('title', $title)

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

    <style>
        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, .08);
        }

        .header-page {
            background: linear-gradient(135deg, #b30000, #ff3333);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .table th {
            background: #b30000;
            color: white;
            white-space: nowrap;
        }

        .table td {
            white-space: nowrap;
        }
    </style>

    <div class="container-fluid">

        <div class="header-page">

            <h3 class="mb-1">
                {{ $title }}
            </h3>

            <small>
                Total Data :
                {{ count($data) }}
            </small>

        </div>

        <div class="card card-custom">

            <div class="card-body">

                <a href="{{ route('pengiriman.dashboard') }}" class="btn btn-secondary mb-3">

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

                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>
                                            {{ $row->trainset }}
                                        </td>

                                        <td>
                                            {{ $row->tipe_kereta }}
                                        </td>

                                        <td>
                                            {{ $row->nomor_lambung }}
                                        </td>

                                        <td>
                                            {{ $row->batch }}
                                        </td>

                                        <td>
                                            {{ $row->trucking }}
                                        </td>

                                        <td>
                                            {{ $row->no_sjn }}
                                        </td>

                                        <td>
                                            {{ $row->plan_delivery }}
                                        </td>

                                        <td>
                                            {{ $row->actual_delivery }}
                                        </td>

                                        <td>

                                            @if ($row->status_delivery == 'On Time')
                                                <span class="badge badge-success">
                                                    On Time
                                                </span>
                                            @elseif($row->status_delivery == 'Overdue')
                                                <span class="badge badge-danger">
                                                    Overdue
                                                </span>
                                            @endif

                                        </td>

                                        <td>
                                            {{ $row->vendor }}
                                        </td>

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
