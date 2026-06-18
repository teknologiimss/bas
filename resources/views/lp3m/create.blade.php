@extends('layouts.main')

@section('title', 'Buat LP3M')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-danger text-white">

            <h5 class="mb-0">
                Buat Data Pekerjaan Perbaikan Perawatan Fasilitas
            </h5>

        </div>

        <div class="card-body">

            <form action="{{ route('lp3m.store') }}" method="POST">

                @csrf

                <div class="mb-3">

                    <label>Deskripsi</label>

                    <textarea name="deskripsi"
                              class="form-control" autocomplete="off"
                              rows="4"
                              required></textarea>

                </div>

                <div class="mb-3">

                    <label>Keterangan</label>

                    <textarea name="keterangan"
                              class="form-control" autocomplete="off"
                              rows="4"
                              required></textarea>

                </div>

                <button class="btn btn-danger">

                    <i class="fas fa-save"></i>
                    Simpan

                </button>

            </form>

        </div>

    </div>

</div>

@endsection