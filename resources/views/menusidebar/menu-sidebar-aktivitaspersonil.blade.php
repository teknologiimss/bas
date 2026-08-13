@extends('layouts.main') {{-- Sesuaikan nama layout utama aplikasi Anda --}}
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
            
            <!-- Card 1: Daily Activity -->
            <div class="col-md-5 col-sm-6 mb-4">
                <a href="{{ route('mro.daily-activity.index') }}" class="text-decoration-none">
                    <div class="card card-outline card-primary h-100 shadow-sm hover-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-calendar-check fa-4x text-primary"></i>
                            </div>
                            <h4 class="font-weight-bold text-dark mb-2">Daily Activity</h4>
                            <p class="text-muted mb-0">
                                Klik untuk melihat dan mencatat aktivitas harian personil MRO.
                            </p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card 2: Weekly Activity -->
            <div class="col-md-5 col-sm-6 mb-4">
                <a href="{{ route('mro.weekly-activity') }}" class="text-decoration-none">
                    <div class="card card-outline card-success h-100 shadow-sm hover-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-chart-line fa-4x text-success"></i>
                            </div>
                            <h4 class="font-weight-bold text-dark mb-2">Weekly Activity</h4>
                            <p class="text-muted mb-0">
                                Klik untuk memantau dan mengelola laporan aktivitas mingguan.
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
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endsection