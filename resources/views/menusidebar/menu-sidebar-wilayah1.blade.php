@extends('layouts.main')
@section('title', 'Menu Pekerjaan Wilayah 1')

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

                <!-- Card 1: Proyek Wilayah 1 -->
                @if (in_array(Auth::user()->role, [0, 2, 8, 9, 14]))
                    <div class="col-md-4 col-sm-6 mb-4">
                        <a href="{{ route('proyekwil1.index') }}" class="text-decoration-none">
                            <div class="card card-outline card-primary h-100 shadow-sm hover-card">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3">
                                        <i class="fas fa-chart-bar fa-3x text-primary"></i>
                                    </div>
                                    <h4 class="font-weight-bold text-dark mb-2">Proyek Wilayah 1</h4>
                                    <p class="text-muted mb-0 small">
                                        Klik untuk melihat daftar dan mengelola data proyek Wilayah 1.
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

                <!-- Card 2: Progress Wilayah 1 -->
                @if (in_array(Auth::user()->role, [0, 2, 8, 9, 14, 17]))
                    <div class="col-md-4 col-sm-6 mb-4">
                        <a href="{{ route('monitoringwil1.resume_progress') }}" class="text-decoration-none">
                            <div class="card card-outline card-info h-100 shadow-sm hover-card">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3">
                                        <i class="fas fa-chart-line fa-3x text-info"></i>
                                    </div>
                                    <h4 class="font-weight-bold text-dark mb-2">Progress Wilayah 1</h4>
                                    <p class="text-muted mb-0 small">
                                        Klik untuk memantau status dan perkembangan pekerjaan Wilayah 1.
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

                <!-- Card 3: Pekerjaan Wilayah 1 (Menu Baru) -->
                @if (in_array(Auth::user()->role, [0, 2, 8, 9, 14]))
                    <div class="col-md-4 col-sm-6 mb-4">
                        <a href="{{ route('pekerjaanwil1.index') }}" class="text-decoration-none">
                            <div class="card card-outline card-success h-100 shadow-sm hover-card">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3">
                                        <i class="fas fa-briefcase fa-3x text-success"></i>
                                    </div>
                                    <h4 class="font-weight-bold text-dark mb-2">Pekerjaan Wilayah 1</h4>
                                    <p class="text-muted mb-0 small">
                                        Klik untuk mengelola data dan rincian pekerjaan Wilayah 1 secara lengkap.
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

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
