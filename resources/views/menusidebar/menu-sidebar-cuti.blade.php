@extends('layouts.main')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('title', 'Manajemen Cuti')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 font-weight-bold text-dark">Layanan Cuti</h1>
            <p class="text-muted">Pilih modul pengelolaan dan pengajuan cuti yang Anda perlukan.</p>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                {{-- 1. Master Cuti Tahunan --}}
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow border-0">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper bg-primary-soft mb-3 mx-auto">
                                <i class="fas fa-user-clock fa-3x text-primary"></i>
                            </div>
                            <h5 class="font-weight-bold">Master Cuti Tahunan</h5>
                            <p class="text-muted small">Pengaturan dan kuota hak cuti tahunan bagi seluruh karyawan.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <a href="{{ route('cuti.tahunan') }}" class="btn btn-outline-primary btn-block rounded-pill">
                                Buka Master Cuti <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 2. Management Cuti --}}
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow border-0">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper bg-success-soft mb-3 mx-auto">
                                <i class="fas fa-tasks fa-3x text-success"></i>
                            </div>
                            <h5 class="font-weight-bold">Management Cuti</h5>
                            <p class="text-muted small">Kelola permohonan, persetujuan, dan pengajuan cuti karyawan.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <a href="{{ route('cuti.index') }}" class="btn btn-outline-success btn-block rounded-pill">
                                Buka Management <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 3. Rekap Cuti Bulanan --}}
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow border-0">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper bg-info-soft mb-3 mx-auto">
                                <i class="fas fa-file-invoice fa-3x text-info"></i>
                            </div>
                            <h5 class="font-weight-bold">Rekap Cuti Bulanan</h5>
                            <p class="text-muted small">Laporan riwayat dan rekapitulasi penggunaan cuti secara bulanan.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <a href="{{ route('cuti.rekap') }}" class="btn btn-outline-info btn-block rounded-pill">
                                Buka Rekap <i class="fas fa-arrow-right ml-1"></i>
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

        .bg-info-soft {
            background-color: #e3f2fd;
        }
    </style>
@endsection
