@extends('layouts.main')
@section('title', 'Edit Harian Fasilitas & Jasa Lainnya')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Laporan Harian Fasilitas & Jasa Lainnya</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('laporan-fasilitas.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Rekap
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('laporan-fasilitas.update', $laporan->id) }}" method="POST" id="form-laporan-fasilitas">
                @csrf
                @method('PUT')
                @include('laporan-fasilitas._form', ['laporan' => $laporan])
            </form>
        </div>
    </section>
@endsection
