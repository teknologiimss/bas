@extends('layouts.main')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')

    <style>
        .card-primary-custom {
            border-top: 4px solid #0b3d91;
        }

        .card-header-custom {
            background: #0b3d91;
            color: white;
        }

        .btn-navy {
            background: #0b3d91;
            color: #fff;
            border: none;
        }

        .btn-navy:hover {
            background: #062b66;
            color: #fff;
        }

        .table thead {
            background: #0b3d91;
            color: white;
        }

        .table tbody tr:hover {
            background: #eef5ff;
        }

        .badge-open {
            background: #198754;
            color: #fff;
        }

        .badge-close {
            background: #dc3545;
            color: #fff;
        }

        .personil-badge {
            background: #0b3d91;
            color: white;
            padding: 5px 8px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 4px;
            font-size: 12px;
        }

        /* 🔥 FIX RESPONSIVE TABLE */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Mobile card default disembunyikan */
        .mobile-card {
            display: none;
        }

        @media(max-width:768px) {

            /* ❌ JANGAN sembunyikan tabel */
            .table-responsive {
                display: block;
            }

            /* kalau nanti mau pakai mobile card */
            .mobile-card {
                display: none;
            }
        }
    </style>

    <div class="container-fluid">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card card-primary-custom">

            <div class="card-header card-header-custom d-flex justify-content-between align-items-center">

                <h4 class="mb-0">
                    Daily Activity
                </h4>

                <a href="{{ route('mro.daily-activity.create') }}" class="btn btn-light">

                    <i class="fa fa-plus"></i>

                    Tambah

                </a>

            </div>

            <div class="card-body table-responsive">

                <table class="table table-bordered table-striped">

                    <thead class="text-center">

                        <tr>

                            <th width="50">No</th>

                            <th>Proyek</th>

                            <th>Kegiatan</th>

                            <th>Status</th>

                            <th>Tanggal</th>

                            <th>Keterangan</th>

                            <th>Personil</th>

                            <th>Lampiran</th>

                            <th width="140">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($data as $d)
                            <tr>

                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td>

                                    @if ($d->monitoring)
                                        <strong>{{ $d->monitoring->po_nota_dinas }}</strong>

                                        <br>

                                        {{ $d->monitoring->nama_pekerjaan }}
                                    @else
                                        -
                                    @endif

                                </td>

                                <td>
                                    {{ $d->kegiatan }}
                                </td>

                                <td class="text-center">

                                    @if ($d->status == 'Open')
                                        <span class="badge badge-open">

                                            Open

                                        </span>
                                    @else
                                        <span class="badge badge-close">

                                            Closed

                                        </span>
                                    @endif

                                </td>

                                <td>

                                    {{ date('d-m-Y', strtotime($d->tanggal)) }}

                                </td>

                                <td>

                                    {!! nl2br(e($d->keterangan)) !!}

                                </td>

                                <td>

                                    @foreach ($d->personil ?? [] as $nama)
                                        <span class="badge badge-primary mb-1">

                                            {{ $nama }}

                                        </span>

                                        <br>
                                    @endforeach

                                </td>

                                <td>

                                    @forelse($d->attachments as $file)
                                        <a href="{{ asset('uploads/daily_activity/' . $file->file) }}" target="_blank"
                                            class="btn btn-sm btn-info mb-1">

                                            <i class="fa fa-file"></i>

                                            Lihat File

                                        </a>

                                        <br>

                                    @empty

                                        <span class="text-muted">

                                            Tidak ada lampiran

                                        </span>
                                    @endforelse

                                </td>


                                <td class="text-center">

                                    <a href="{{ route('mro.daily-activity.edit', $d->id) }}" class="btn btn-warning btn-sm">

                                        <i class="fa fa-edit"></i>

                                    </a>

                                    <form action="{{ route('mro.daily-activity.destroy', $d->id) }}" method="POST"
                                        style="display:inline-block"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm">

                                            <i class="fa fa-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9" class="text-center">

                                    Belum ada data.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection
