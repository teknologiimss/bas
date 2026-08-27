@extends('layouts.main')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('title', 'Dashboard Monitoring')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 font-weight-bold text-dark">Menu Monitoring</h1>
            <p class="text-muted">Pilih jenis monitoring yang ingin Anda akses.</p>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                {{-- 1. Monitoring Pengiriman --}}
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow border-0">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper bg-primary-soft mb-3 mx-auto">
                                <i class="fas fa-truck-loading fa-3x text-primary"></i>
                            </div>
                            <h5 class="font-weight-bold">Monitoring Pengiriman</h5>
                            <p class="text-muted small">Lacak status dan jadwal pengiriman barang secara real-time ke
                                tujuan.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <a href="{{ route('pengiriman.index') }}"
                                class="btn btn-outline-primary btn-block rounded-pill">
                                Buka Menu <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 2. Monitoring Alat Angkat-Angkut --}}
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow border-0">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper bg-warning-soft mb-3 mx-auto">
                                <i class="fas fa-solid fa-truck fa-3x text-warning"></i>
                            </div>
                            <h5 class="font-weight-bold">Monitoring Alat Angkat-Angkut</h5>
                            <p class="text-muted small">Pantau kelayakan, penggunaan, dan masa berlaku izin peralatan
                                angkat.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <a href="{{ route('alat.index') }}" class="btn btn-outline-warning btn-block rounded-pill">
                                Buka Menu <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 3. Checksheet Harian Fasilitas --}}
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow border-0">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper bg-info-soft mb-3 mx-auto">
                                <i class="fas fa-solid fa-clipboard fa-3x text-info"></i>
                            </div>
                            <h5 class="font-weight-bold">Checksheet Harian Fasilitas</h5>
                            <p class="text-muted small">Pengecekan dan verifikasi berkala untuk kondisi sarana serta
                                fasilitas harian.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <a href="{{ route('fasilitas-harian.index') }}"
                                class="btn btn-outline-info btn-block rounded-pill">
                                Buka Menu <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 4. Master Matrix Perawatan Asset --}}
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow border-0">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper bg-secondary-soft mb-3 mx-auto">
                                <i class="fas fa-solid fa-truck fa-3x text-secondary"></i>
                            </div>
                            <h5 class="font-weight-bold">Master Matrix Perawatan Asset</h5>
                            <p class="text-muted small">Kelola data induk dan standar parameter perawatan berkala seluruh
                                aset.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <a href="{{ route('assets.index') }}" class="btn btn-outline-secondary btn-block rounded-pill">
                                Buka Menu <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 5. Matrix Perawatan Asset --}}
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow border-0">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper bg-success-soft mb-3 mx-auto">
                                <i class="fas fa-solid fa-table fa-3x text-success"></i>
                            </div>
                            <h5 class="font-weight-bold">Matrix Perawatan Asset</h5>
                            <p class="text-muted small">Matriks integrasi jadwal dan histori pelaksanaan pemeliharaan aset
                                operasional.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <a href="{{ route('asset-maintenance.index') }}"
                                class="btn btn-outline-success btn-block rounded-pill">
                                Buka Menu <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 6. Checksheet Preventive Maintenance --}}
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow border-0">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper bg-danger-soft mb-3 mx-auto">
                                <i class="fas fa-solid fa-clipboard-list fa-3x text-danger"></i>
                            </div>
                            <h5 class="font-weight-bold">Checksheet PM</h5>
                            <p class="text-muted small">Formulir inspeksi pencegahan kerusakan mesin dan peralatan secara
                                rutin.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <a href="{{ route('checksheet.index') }}" class="btn btn-outline-danger btn-block rounded-pill">
                                Buka Menu <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 7. Monitoring SPR --}}
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow border-0">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper bg-purple-soft mb-3 mx-auto">
                                <i class="fas fa-clipboard-check fa-3x text-purple"></i>
                            </div>
                            <h5 class="font-weight-bold">Monitoring SPR</h5>
                            <p class="text-muted small">Pantau pengajuan, alur perbaikan, serta penyelesaian Surat
                                Permintaan Perbaikan.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <a href="{{ route('lp3m.index') }}" class="btn btn-outline-purple btn-block rounded-pill">
                                Buka Menu <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 8. Monitoring Rewinding --}}
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow border-0">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper bg-indigo-soft mb-3 mx-auto">
                                <i class="fas fa-bolt fa-3x text-indigo"></i>
                            </div>
                            <h5 class="font-weight-bold">Monitoring Rewinding</h5>
                            <p class="text-muted small">Tracking proses penggulungan ulang dinamo/motor listrik dari
                                penerimaan hingga selesai.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <a href="{{ route('rewinding.index') }}" class="btn btn-outline-indigo btn-block rounded-pill">
                                Buka Menu <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 9. Monitoring 5R & Scrap --}}
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow border-0">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper bg-teal-soft mb-3 mx-auto">
                                <i class="fas fa-recycle fa-3x text-teal"></i>
                            </div>
                            <h5 class="font-weight-bold">Monitoring 5R & Scrap</h5>
                            <p class="text-muted small">Kelola evaluasi budaya 5R lingkungan kerja serta catatan
                                inventarisasi barang scrap.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <a href="{{ route('monitoring_5r.index') }}"
                                class="btn btn-outline-teal btn-block rounded-pill">
                                Buka Menu <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>


                {{-- 10. Monitoring FCU --}}
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow border-0">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper bg-info-soft mb-3 mx-auto">
                                <i class="fas fa-fan fa-3x text-info"></i>
                            </div>
                            <h5 class="font-weight-bold">Monitoring FCU</h5>
                            <p class="text-muted small">Kelola pemeliharaan berkala dan inspeksi unit Fan Coil Unit (FCU).
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <a href="{{ route('fcu.index') }}" class="btn btn-outline-info btn-block rounded-pill">
                                Buka Menu <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 11. Monitoring Chiller --}}
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow border-0">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper bg-primary-soft mb-3 mx-auto">
                                <i class="fas fa-snowflake fa-3x text-primary"></i>
                            </div>
                            <h5 class="font-weight-bold">Monitoring Chiller</h5>
                            <p class="text-muted small">Kelola pemeliharaan berkala dan inspeksi unit Chiller AC secara
                                rinci.
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <a href="{{ route('chiller.index') }}"
                                class="btn btn-outline-primary btn-block rounded-pill">
                                Buka Menu <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 12.Monitoring Pompa --}}
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow border-0">
                        <div class="card-body text-center p-4">
                            <div class="icon-wrapper bg-primary-soft mb-3 mx-auto">
                                <!-- Ganti fa-gears dengan fa-cogs -->
                                <i class="fas fa-cogs fa-3x text-primary"></i>
                            </div>
                            <h5 class="font-weight-bold">Monitoring Pompa</h5>
                            <p class="text-muted small">Kelola pemeliharaan berkala dan inspeksi unit Pompa secara rinci.
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-4 text-center">
                            <a href="{{ route('pompa.index') }}" class="btn btn-outline-primary btn-block rounded-pill">
                                Buka Menu <i class="fas fa-arrow-right ml-1"></i>
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

        .bg-warning-soft {
            background-color: #fef5e7;
        }

        .bg-info-soft {
            background-color: #e3f2fd;
        }

        .bg-secondary-soft {
            background-color: #f0f1f2;
        }

        .bg-success-soft {
            background-color: #e8f5e9;
        }

        .bg-danger-soft {
            background-color: #ffebee;
        }

        .bg-purple-soft {
            background-color: #f3e5f5;
        }

        .bg-indigo-soft {
            background-color: #e8eaf6;
        }

        .bg-teal-soft {
            background-color: #e0f2f1;
        }

        .text-purple {
            color: #8e24aa;
        }

        .btn-outline-purple {
            color: #8e24aa;
            border-color: #8e24aa;
        }

        .btn-outline-purple:hover {
            background-color: #8e24aa;
            color: #fff;
        }

        .text-indigo {
            color: #3f51b5;
        }

        .btn-outline-indigo {
            color: #3f51b5;
            border-color: #3f51b5;
        }

        .btn-outline-indigo:hover {
            background-color: #3f51b5;
            color: #fff;
        }

        .text-teal {
            color: #00897b;
        }

        .btn-outline-teal {
            color: #00897b;
            border-color: #00897b;
        }

        .btn-outline-teal:hover {
            background-color: #00897b;
            color: #fff;
        }
    </style>
@endsection
