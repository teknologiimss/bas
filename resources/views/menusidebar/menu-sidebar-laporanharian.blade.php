@extends('layouts.main')
@section('title', 'Menu Laporan Harian Fasilitas')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 text-dark">Pilih Menu</h1>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center mt-4">

                <!-- Card 1: Laporan Harian Fasilitas -->
                <div class="col-md-5 col-sm-6 mb-4">
                    <a href="{{ route('laporan-fasilitas.index') }}" class="text-decoration-none">
                        <div class="card card-outline card-primary h-100 shadow-sm hover-card">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="fas fa-clipboard-list fa-3x text-primary"></i>
                                </div>
                                <h4 class="font-weight-bold text-dark mb-2">Laporan Harian Fasilitas</h4>
                                <p class="text-muted mb-0 small">
                                    Klik untuk melihat, membuat, dan mengelola rekap job desk harian fasilitas & jasa
                                    lainnya.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card 2: Laporan Mingguan Fasilitas -->
                <div class="col-md-5 col-sm-6 mb-4">
                    <a href="{{ route('laporan-mingguan.index') }}" class="text-decoration-none">
                        <div class="card card-outline card-info h-100 shadow-sm hover-card">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="fas fa-calendar-week fa-3x text-info"></i>
                                </div>
                                <h4 class="font-weight-bold text-dark mb-2">Laporan Mingguan Fasilitas</h4>
                                <p class="text-muted mb-0 small">
                                    Klik untuk melihat rincian pekerjaan mingguan Senin–Jumat beserta tanggal, bulan, dan
                                    tahun.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <style>
        .hover-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            border-radius: 12px;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15) !important;
        }
    </style>
@endsection
