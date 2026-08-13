@extends('layouts.main') {{-- Sesuaikan dengan nama layout utama aplikasi Anda --}}
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0 text-dark">Menu Pekerjaan</h1>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row justify-content-center mt-4">
            
            <!-- Card 1: Proyek MRO -->
            <div class="col-md-5 col-sm-6 mb-4">
                <a href="{{ route('proyek.index') }}" class="text-decoration-none">
                    <div class="card card-outline card-primary h-100 shadow-sm hover-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-chart-bar fa-4x text-primary"></i>
                            </div>
                            <h4 class="font-weight-bold text-dark mb-2">Proyek MRO</h4>
                            <p class="text-muted mb-0">
                                Klik untuk melihat daftar dan mengelola data proyek MRO.
                            </p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card 2: Progress MRO -->
            <div class="col-md-5 col-sm-6 mb-4">
                <a href="{{ route('mro.progress') }}" class="text-decoration-none">
                    <div class="card card-outline card-info h-100 shadow-sm hover-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-chart-line fa-4x text-info"></i>
                            </div>
                            <h4 class="font-weight-bold text-dark mb-2">Progress MRO</h4>
                            <p class="text-muted mb-0">
                                Klik untuk memantau status dan perkembangan pekerjaan MRO.
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