@extends('layouts.main')

@section('title', 'Lembar Pekerjaan Perbaikan Perawatan Fasilitas')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')
    <style>
        .header-title {
            font-size: 18px;
            font-weight: bold;
            line-height: 1.4;
        }


        .btn-action {
            width: 100px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 5px;
            font-size: 12px;
            font-weight: 600;

            border-radius: 8px;
        }

        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
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

                        {{-- Cari Deskripsi --}}
                        <div class="col-md-4 col-12">

                            <label class="form-label fw-bold">
                                Cari Deskripsi
                            </label>

                            <input type="text" name="search" class="form-control" autocomplete="off" placeholder="Masukkan deskripsi..."
                                value="{{ request('search') }}">

                        </div>

                        {{-- Cari No SPR --}}
                        <div class="col-md-3 col-12">

                            <label class="form-label fw-bold">
                                Cari No. SPR
                            </label>

                            <input type="text" name="spr_no" class="form-control" autocomplete="off" placeholder="Masukkan No SPR..."
                                value="{{ request('spr_no') }}">

                        </div>

                        {{-- Cari Tanggal --}}
                        {{-- <div class="col-md-3 col-12">

                            <label class="form-label fw-bold">
                                Cari Tanggal
                            </label>

                            <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">

                        </div> --}}

                        {{-- Tombol --}}
                        <div class="col-md-2 col-12 d-grid">

                            <button type="submit" class="btn btn-danger fw-bold">

                                <i class="fas fa-search"></i>
                                Cari

                            </button>

                            <a href="{{ route('lp3m.index') }}" class="btn btn-secondary fw-bold">

                                Reset

                            </a>

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
                                <th>No. SPR</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Tanggal</th>
                                <th>Lampiran</th>
                                <th>Aksi</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($data as $d)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>

                                        @if ($d->spr_no)
                                            <span>
                                                {{ $d->spr_no }}
                                            </span>
                                        @else
                                            <span class="text-muted">
                                                Belum Ada
                                            </span>
                                        @endif

                                    </td>

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

                                    <td>

                                        @if ($d->lampiran)
                                            <a href="{{ asset('lampiran/' . $d->lampiran) }}" target="_blank"
                                                class="btn btn-success btn-action">

                                                <i class="fas fa-paperclip"></i>
                                                <span>Lihat</span>

                                            </a>
                                        @else
                                            <span class="badge bg-secondary">

                                                Tidak Ada

                                            </span>
                                        @endif

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

                                        <div class="d-flex flex-wrap action-buttons">
                                            {{-- Form --}}
                                            <a href="{{ route('lp3m.form', $d->id) }}" class="btn btn-primary btn-action">
                                                <i class="fas fa-file-alt"></i>
                                                Form
                                            </a>

                                            {{-- Edit --}}
                                            <a href="{{ route('lp3m.edit', $d->id) }}" class="btn btn-warning btn-action">
                                                <i class="fas fa-edit"></i>
                                                Edit
                                            </a>

                                            {{-- Lihat --}}
                                            <a href="{{ route('lp3m.show', $d->id) }}" class="btn btn-info btn-action">
                                                <i class="fas fa-eye"></i>
                                                Lihat
                                            </a>


                                            {{-- Upload --}}
                                            <button type="button" class="btn btn-secondary btn-action btn-upload"
                                                data-id="{{ $d->id }}" data-bs-toggle="modal"
                                                data-bs-target="#uploadLampiranModal">

                                                <i class="fas fa-upload"></i>
                                                Upload

                                            </button>

                                            {{-- Print --}}
                                            <a href="{{ route('lp3m.print', $d->id) }}" class="btn btn-dark btn-action">

                                                <i class="fas fa-print"></i>
                                                Print

                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{ route('lp3m.destroy', $d->id) }}" method="POST"
                                                style="display:inline-block;"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-action">

                                                    <i class="fas fa-trash"></i>
                                                    Hapus

                                                </button>

                                            </form>

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

    {{-- Modal Lampiran --}}
    <div class="modal fade" id="uploadLampiranModal" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <form action="{{ route('lp3m.uploadLampiran') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <input type="hidden" name="id" id="lampiran_id">

                    <div class="modal-header bg-danger text-white">

                        <h5 class="modal-title">

                            Upload Lampiran

                        </h5>

                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                        </button>

                    </div>

                    <div class="modal-body">

                        <label class="fw-bold">

                            Pilih File

                        </label>

                        <input type="file" name="lampiran" class="form-control" required>

                        <small class="text-muted">

                            PDF, JPG, JPEG, PNG, DOC, DOCX

                        </small>

                    </div>

                    <div class="modal-footer">

                        <button type="submit" class="btn btn-danger">

                            Upload

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>
        document.querySelectorAll('.btn-upload')
            .forEach(function(button) {

                button.addEventListener('click', function() {

                    document.getElementById('lampiran_id').value =
                        this.dataset.id;

                });

            });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
