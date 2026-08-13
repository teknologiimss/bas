@extends('layouts.main')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('title', 'Administrasi Keuangan')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 font-weight-bold text-dark">Administrasi Keuangan</h1>
            <p class="text-muted">Pilih menu administrasi keuangan yang ingin Anda kelola.</p>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                {{-- 1. Arsip SPPD MRO --}}
                <div class="col-lg-6 col-md-6 col-12 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow border-0">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper bg-primary-soft mb-3 mx-auto">
                                <i class="fas fa-file-archive fa-3x text-primary"></i>
                            </div>
                            <h4 class="font-weight-bold">Arsip SPPD MRO</h4>
                            <p class="text-muted">Kelola dan pantau arsip Surat Perintah Perjalanan Dinas (SPPD) MRO secara
                                terpusat.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <a href="{{ route('sppd.index') }}" class="btn btn-outline-primary btn-block rounded-pill">
                                Buka Arsip SPPD <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 2. Kasbon MRO --}}
                <div class="col-lg-6 col-md-6 col-12 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow border-0">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper bg-success-soft mb-3 mx-auto">
                                <i class="fas fa-wallet fa-3x text-success"></i>
                            </div>
                            <h4 class="font-weight-bold">Kasbon MRO</h4>
                            <p class="text-muted">Kelola pengajuan, pencairan, serta pertanggungjawaban dana kasbon MRO.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <a href="{{ route('kasbon.index') }}" class="btn btn-outline-success btn-block rounded-pill">
                                Buka Kasbon <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Styling Tambahan --}}
    <style>
        .icon-wrapper {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hover-shadow {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .bg-primary-soft {
            background-color: #e8f0fe;
        }

        .bg-success-soft {
            background-color: #e8f5e9;
        }
    </style>
@endsection
