@extends('layouts.main')

@section('title', 'Checksheet Harian Fasilitas')

@section('content')

    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background: #f4f6f9;
        }

        /* HEADER */

        .page-header {

            background: linear-gradient(135deg,
                    #b30000,
                    #ff2d2d);

            color: white;

            border-radius: 20px;

            padding: 25px;

            margin-bottom: 25px;

            box-shadow: 0 10px 25px rgba(179,
                    0,
                    0,
                    .20);
        }

        .page-header h3 {

            font-weight: 700;

            margin: 0;
        }

        /* CARD */

        .stat-card {

            border: none;

            border-radius: 18px;

            overflow: hidden;

            transition: .25s;

            box-shadow:
                0 4px 12px rgba(0, 0, 0, .06);

        }

        .stat-card:hover {

            transform: translateY(-4px);

        }

        .stat-icon {

            width: 60px;
            height: 60px;

            border-radius: 50%;

            display: flex;

            align-items: center;

            justify-content: center;

            color: white;

            font-size: 22px;
        }

        .card-table {

            border: none;

            border-radius: 20px;

            overflow: hidden;

            box-shadow:
                0 5px 15px rgba(0, 0, 0, .05);
        }

        .table th {

            background: #b30000;

            color: white;

            border: none;

            vertical-align: middle;
        }

        .table td {
            vertical-align: middle;
        }

        .btn-action {

            border-radius: 10px;

            margin: 2px;
        }

        .search-box {

            border-radius: 12px;
        }

        @media(max-width:768px) {

            .table-responsive {

                font-size: 12px;

            }

            .btn-action {

                width: 100%;

                margin-bottom: 5px;

            }

            .page-header {

                padding: 18px;
            }

            .page-header h3 {

                font-size: 20px;
            }
        }
    </style>

    <div class="container-fluid mt-3">

        {{-- HEADER --}}
        <div class="page-header">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <div>

                    <h3>
                        <i class="fas fa-clipboard-list"></i>
                        Checksheet Harian Fasilitas
                    </h3>

                    <small>
                        Monitoring Pemeriksaan Harian Fasilitas
                    </small>

                </div>

                <a href="{{ route('fasilitas-harian.create') }}" class="btn btn-light mt-2">

                    <i class="fa fa-plus"></i>
                    Buat Checksheet

                </a>

            </div>

        </div>

        {{-- STATISTIK --}}
        <div class="row mb-4">

            <div class="col-md-4 mb-3">

                <div class="card stat-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h5>Total Checksheet</h5>

                                <h2>

                                    {{ $data->total() }}

                                </h2>

                            </div>

                            <div class="stat-icon bg-danger">

                                <i class="fa fa-file-alt"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-4 mb-3">

                <div class="card stat-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h5>Bulan Aktif</h5>

                                <h2>

                                    {{ now()->format('F') }}

                                </h2>

                            </div>

                            <div class="stat-icon bg-success">

                                <i class="fa fa-calendar"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-4 mb-3">

                <div class="card stat-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <h5>Tahun</h5>

                                <h2>

                                    {{ now()->year }}

                                </h2>

                            </div>

                            <div class="stat-icon bg-primary">

                                <i class="fa fa-clock"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="card card-table">

            <div class="card-header bg-white">

                <div class="row">

                    <div class="col-md-4">

                        <form method="GET">

                            <div class="input-group">

                                <input type="text" name="search" class="form-control search-box"
                                    placeholder="Cari checksheet..." value="{{ request('search') }}">

                                <div class="input-group-append">

                                    <button class="btn btn-danger">

                                        <i class="fa fa-search"></i>

                                        Cari

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover" id="tableData">

                        <thead>

                            <tr>

                                <th width="50">
                                    No
                                </th>

                                <th>
                                    Judul
                                </th>

                                <th>No Dokumen</th>

                                <th>No Fasilitas</th>

                                <th>Nama Alat</th>

                                <th>
                                    Lokasi
                                </th>

                                <th>
                                    Bulan
                                </th>

                                <th>
                                    Tahun
                                </th>

                                <th width="500">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($data as $row)
                                <tr>

                                    <td>
                                        {{ $data->firstItem() + $loop->index }}
                                    </td>

                                    <td>

                                        {{ $row->judul }}

                                    </td>

                                    <td>{{ $row->nomor_dokumen }}</td>

                                    <td>{{ $row->nomor_fasilitas }}</td>

                                    <td>{{ $row->nama_alat }}</td>

                                    <td>

                                        {{ $row->lokasi }}

                                    </td>

                                    <td>

                                        {{ $row->bulan }}

                                    </td>

                                    <td>

                                        {{ $row->tahun }}

                                    </td>

                                    <td>

                                        {{-- MOBILE --}}
                                        <a href="{{ route('fasilitas.mobile', $row->id) }}"
                                            class="btn btn-success btn-sm btn-action">

                                            <i class="fa fa-mobile"></i>

                                            Isi HP

                                        </a>

                                        {{-- MATRIX --}}
                                        <a href="{{ route('fasilitas-harian.show', $row->id) }}"
                                            class="btn btn-info btn-sm btn-action">

                                            <i class="fa fa-table"></i>

                                            Matrix

                                        </a>

                                        {{-- PDF --}}
                                        <a href="{{ route('fasilitas.print', $row->id) }}" target="_blank"
                                            class="btn btn-danger btn-sm btn-action">

                                            <i class="fa fa-file-pdf"></i>

                                            PDF

                                        </a>

                                        {{-- EDIT --}}
                                        <a href="{{ route('fasilitas-harian.edit', $row->id) }}"
                                            class="btn btn-warning btn-sm btn-action">

                                            <i class="fa fa-edit"></i>

                                            Edit

                                        </a>

                                        {{-- DUPLICATE --}}
                                        <a href="{{ route('fasilitas-harian.duplicate', $row->id) }}"
                                            class="btn btn-primary btn-sm btn-action">

                                            <i class="fa fa-copy"></i>
                                            Duplicate

                                        </a>

                                        {{-- DELETE --}}
                                        <form action="{{ route('fasilitas-harian.destroy', $row->id) }}" method="POST"
                                            class="d-inline">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-dark btn-sm btn-action btn-delete">

                                                <i class="fa fa-trash"></i>

                                                Hapus

                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6" class="text-center">

                                        Belum ada data

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-3">

                    {{ $data->appends(request()->query())->links('pagination::bootstrap-4') }}

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({

                icon: 'success',

                title: 'Berhasil',

                text: '{{ session('success') }}',

                timer: 2000,

                showConfirmButton: false

            });
        </script>
    @endif

    {{-- <script>
        document
            .getElementById('searchInput')
            .addEventListener('keyup', function() {

                let value =
                    this.value.toLowerCase();

                let rows =
                    document.querySelectorAll(
                        '#tableData tbody tr'
                    );

                rows.forEach(row => {

                    row.style.display =
                        row.innerText.toLowerCase()
                        .includes(value) ?
                        '' :
                        'none';

                });

            });

        document
            .querySelectorAll('.btn-delete')
            .forEach(btn => {

                btn.addEventListener(
                    'click',
                    function(e) {

                        e.preventDefault();

                        let form =
                            this.closest('form');

                        Swal.fire({

                            title: 'Hapus data?',

                            icon: 'warning',

                            showCancelButton: true,

                            confirmButtonColor: '#dc3545',

                            confirmButtonText: 'Ya Hapus'

                        }).then((r) => {

                            if (r.isConfirmed) {

                                form.submit();

                            }

                        });

                    });

            });
    </script> --}}

@endsection
