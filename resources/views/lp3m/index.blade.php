@extends('layouts.main')

@section('title', 'LP3M Mesin')

@section('content')
    <style>
        .header-title {
            font-size: 18px;
            font-weight: bold;
            line-height: 1.4;
        }


        .btn-action {
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
            margin: 2px;
        }

        .action-buttons {
            min-width: 220px;
        }


        @media (max-width: 768px) {

            .header-title {
                font-size: 15px;
            }

            .card-header .btn {
                width: 100%;
                text-align: center;
            }

            .btn-action {
                font-size: 10px;
                padding: 3px 6px;
            }

            .btn-action i {
                font-size: 10px;
            }

            .action-buttons {
                gap: 4px;
            }

            td {
                vertical-align: middle !important;
            }


        }
    </style>

    <div class="container-fluid mt-3">

        <div class="card shadow-sm border-0">

            {{-- <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    <i class="fas fa-tools"></i>
                    Data Pekerjaan Perbaikan Perawatan Fasilitas
                </h5>

                <a href="{{ route('lp3m.create') }}" class="btn btn-secondary btn-sm">

                    <i class="fas fa-plus"></i>
                    Buat LP3

                </a>

            </div> --}}

            <div
                class="card-header bg-danger text-white d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">

                <h5 class="mb-0 d-flex align-items-center flex-wrap">

                    <i class="fas fa-tools me-2"></i>

                    <span class="header-title">
                        Data Pekerjaan Perbaikan Perawatan Fasilitas
                    </span>

                </h5>

                <a href="{{ route('lp3m.create') }}" class="btn btn-secondary btn-sm text-light fw-bold">

                    <i class="fas fa-plus"></i>
                    Buat Data Baru

                </a>

            </div>

            <div class="card-body">

                {{-- SEARCH --}}
                <form action="{{ route('lp3m.index') }}" method="GET" class="mb-3">

                    <div class="row g-2 align-items-end">

                        <div class="col-md-5 col-12">

                            <label class="form-label fw-bold">
                                Cari Deskripsi
                            </label>

                            <input type="text" name="search" class="form-control" placeholder="Masukkan deskripsi..."
                                value="{{ request('search') }}">

                        </div>

                        <div class="col-md-4 col-12">

                            <label class="form-label fw-bold">
                                Cari Tanggal
                            </label>

                            <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">

                        </div>

                        <div class="col-md-3 col-12 d-grid">

                            <button type="submit" class="btn btn-danger fw-bold">

                                <i class="fas fa-search"></i>
                                Cari

                            </button>

                        </div>

                    </div>

                </form>

                <div class="table-responsive">

                    @if (session('success'))
                        <div class="alert alert-success">

                            {{ session('success') }}

                        </div>
                    @endif

                    <table class="table table-bordered table-hover">

                        <thead class="bg-light">

                            <tr>
                                <th>No</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($data as $d)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $d->deskripsi }}</td>

                                    <td>

                                        @if ($d->status == 'OPEN')
                                            <span class="badge badge-danger">
                                                OPEN
                                            </span>
                                        @else
                                            <span class="badge badge-success">
                                                CLOSED
                                            </span>
                                        @endif

                                    </td>

                                    <td>{{ $d->keterangan }}</td>

                                    <td>
                                        {{ date('d-m-Y H:i', strtotime($d->created_at)) }}
                                    </td>

                                    {{-- <td>

                                        <a href="{{ route('lp3m.form', $d->id) }}" class="btn btn-sm btn-primary">

                                            <i class="fas fa-file-alt"></i>
                                            Buat LP3M

                                        </a>

                                        
                                        <a href="{{ route('lp3m.show', $d->id) }}" class="btn btn-sm btn-info">

                                            <i class="fas fa-eye"></i>
                                            Lihat

                                        </a>

                                        <a href="{{ route('lp3m.print', $d->id) }}" class="btn btn-sm btn-danger">

                                            <i class="fas fa-print"></i>
                                            Print

                                        </a>

                                    </td> --}}

                                    <td>

                                        <div class="d-flex flex-wrap gap-1 action-buttons">

                                            {{-- FORM --}}
                                            <a href="{{ route('lp3m.form', $d->id) }}" class="btn btn-primary btn-action">

                                                <i class="fas fa-file-alt"></i>
                                                <span>Form</span>

                                            </a>

                                            {{-- EDIT --}}
                                            <a href="{{ route('lp3m.edit', $d->id) }}" class="btn btn-warning btn-action">

                                                <i class="fas fa-edit"></i>
                                                <span>Edit</span>

                                            </a>

                                            {{-- LIHAT --}}
                                            <a href="{{ route('lp3m.show', $d->id) }}" class="btn btn-info btn-action">

                                                <i class="fas fa-eye"></i>
                                                <span>Lihat</span>

                                            </a>

                                            {{-- HAPUS --}}
                                            <form action="{{ route('lp3m.destroy', $d->id) }}" method="POST"
                                                style="display:inline-block;"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-action">

                                                    <i class="fas fa-trash"></i>
                                                    <span>Hapus</span>

                                                </button>

                                            </form>

                                            {{-- PRINT --}}
                                            <a href="{{ route('lp3m.print', $d->id) }}" class="btn btn-dark btn-action">

                                                <i class="fas fa-print"></i>
                                                <span>Print</span>

                                            </a>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6" class="text-center">
                                        Tidak ada data
                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-3">
                    {{ $data->links() }}
                </div>

            </div>

        </div>

    </div>

@endsection
