@extends('layouts.main')

@section('title', 'Buat Lembar Pekerjaan Perbaikan Perawatan Fasilitas')

<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        .bg-navy {
            background-color: #0b1f3a !important;
        }

        .btn-navy {
            background-color: #0b1f3a;
            color: #fff;
            border: none;
        }

        .btn-navy:hover {
            background-color: #102a52;
            color: #fff;
        }

        .card {
            border: none;
            border-radius: 12px;
        }

        .card-header {
            border-radius: 12px 12px 0 0 !important;
        }
    </style>

    <div class="container mt-4">

        <div class="card shadow">

            <div class="card-header bg-navy text-white">

                <h5 class="mb-0">
                    Buat Data Pekerjaan Perbaikan Perawatan Fasilitas
                </h5>

            </div>

            <div class="card-body">

                <form action="{{ route('lp3m.store') }}" method="POST">

                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" autocomplete="off" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" autocomplete="off" rows="4" required></textarea>
                    </div>

                    <button class="btn btn-navy">
                        <i class="fas fa-save"></i>
                        Simpan
                    </button>

                </form>

            </div>

        </div>

    </div>

@endsection
