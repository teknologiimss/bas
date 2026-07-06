@extends('layouts.main')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')
    <style>
        body {
            background: #eef3f9;
        }

        .personil-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
        }

        .personil-header {
            background: linear-gradient(135deg, #081f5c, #123a9b);
            color: #fff;
            padding: 18px 20px;
        }

        .personil-header h3 {
            font-size: 22px;
            font-weight: 700;
            margin: 0;
        }

        .btn-add {
            background: #fff;
            color: #123a9b;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            padding: 8px 16px;
            transition: .2s;
        }

        .btn-add:hover {
            background: #edf3ff;
            color: #123a9b;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #0d2c7a;
            color: #fff;
            border: none;
            white-space: nowrap;
            vertical-align: middle;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: #f5f9ff;
        }

        .badge-status {
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-organik {
            background: #d8f7e4;
            color: #198754;
        }

        .badge-pkwt {
            background: #fff3cd;
            color: #ed0303;
        }



        .btn-action {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            margin: 2px;
        }

        .table-responsive {
            border-radius: 12px;
        }

        @media(max-width:768px) {

            .personil-header {
                padding: 15px;
            }

            .personil-header h3 {
                font-size: 18px;
            }

            .btn-add {
                width: 100%;
                margin-top: 12px;
            }

            .header-flex {
                display: block !important;
            }

            .table {
                font-size: 13px;
            }

            .btn-action {
                width: 32px;
                height: 32px;
            }
        }
    </style>

    <div class="container-fluid">

        <div class="card personil-card">

            <div class="personil-header">

                <div class="d-flex justify-content-between align-items-center header-flex">

                    <h3>
                        <i class="fas fa-users mr-2"></i>
                        Master Personil MRO
                    </h3>

                    <div>
                        <a href="{{ route('master-personil.print') }}" target="_blank" class="btn btn-danger mr-2">
                            <i class="fas fa-file-pdf"></i>
                            Export PDF
                        </a>

                        <a href="{{ route('master-personil.create') }}" class="btn btn-add">
                            <i class="fa fa-plus"></i>
                            Tambah Personil
                        </a>
                    </div>

                </div>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover">

                        <thead>

                            <tr>

                                <th width="60">No</th>

                                <th>Nama</th>

                                <th>NIP</th>

                                <th>Jabatan</th>

                                <th>Status</th>

                                <th>Jobdesc</th>

                                <th>Spesialisasi / Basic</th>

                                <th>Catatan</th>

                                <th>Penempatan</th>

                                <th width="120" class="text-center">

                                    Aksi

                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($data as $row)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>

                                        <strong>

                                            {{ $row->nama }}

                                        </strong>

                                    </td>

                                    <td>

                                        {{ $row->nip }}

                                    </td>

                                    <td>{{ $row->jabatan }}</td>

                                    <td>

                                        @if ($row->status == 'Organik')
                                            <span class="badge badge-status badge-organik">

                                                {{ $row->status }}

                                            </span>
                                        @elseif($row->status == 'PKWT')
                                            <span class="badge badge-status badge-pkwt">

                                                {{ $row->status }}

                                            </span>
                                        @endif

                                    </td>

                                    <td>{!! nl2br(e($row->jobdesk)) !!}</td>
                                    <td>{{ $row->spesialisasi }}</td>
                                    <td>{!! nl2br(e($row->catatan)) !!}</td>

                                    <td>

                                        {{ $row->penempatan }}

                                    </td>

                                    <td class="text-center">

                                        <a href="{{ route('master-personil.edit', $row->id) }}"
                                            class="btn btn-warning btn-action" title="Edit">

                                            <i class="fa fa-edit"></i>

                                        </a>

                                        <form action="{{ route('master-personil.destroy', $row->id) }}" method="POST"
                                            style="display:inline">

                                            @csrf
                                            @method('DELETE')

                                            <button onclick="return confirm('Hapus data ini?')"
                                                class="btn btn-danger btn-action" title="Hapus">

                                                <i class="fa fa-trash"></i>

                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="10" class="text-center text-muted py-5">

                                        <i class="fa fa-users fa-3x mb-3"></i>

                                        <br>

                                        Belum ada data personil.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
@endsection
