@extends('layouts.main') {{-- Sesuaikan dengan nama layout utama aplikasi Anda --}}
@section('title', 'Menu Pekerjaan MRO')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <h1 class="m-0 text-dark">Pilih Menu</h1>

                {{-- LONCENG NOTIFIKASI KONTRAK MRO --}}
                <div class="d-flex align-items-center">
                    <div class="nav-item dropdown mro-notif-wrapper">
                        <a class="nav-link position-relative d-inline-flex align-items-center px-2 py-1"
                            data-toggle="dropdown" data-bs-toggle="dropdown" href="#" id="kontrakNotifDropdown"
                            aria-expanded="false" title="Notifikasi Kontrak MRO">

                            <i class="fas fa-bell text-primary" style="font-size: 30px;"></i>

                            @if (isset($notifications) && count($notifications) > 0)
                                <span class="badge badge-danger bg-danger text-white navbar-badge mro-notif-badge">
                                    {{ count($notifications) }}
                                </span>
                            @endif
                        </a>

                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-end mro-notif-menu shadow border p-0"
                            aria-labelledby="kontrakNotifDropdown">
                            {{-- HEADER DROPDOWN --}}
                            <div class="mro-notif-header text-center py-2 px-3 border-bottom">
                                <span class="fw-bold font-weight-bold text-secondary" style="font-size: 13.5px;">
                                    🔔 Notifikasi Kontrak MRO
                                </span>
                            </div>

                            {{-- ISI NOTIFIKASI DARI MONITORING->notifMessage() --}}
                            <div class="mro-notif-body">
                                @if (isset($notifications) && count($notifications) > 0)
                                    @foreach ($notifications as $notif)
                                        @php
                                            $msg = $notif->notifMessage();
                                            $queryParams = array_filter([
                                                'monitoring_id' => $notif->id,
                                                'po' => $notif->po_nota_dinas,
                                            ]);

                                            if (
                                                !empty($notif->proyek_id) &&
                                                \Illuminate\Support\Facades\Route::has('monitoring.index')
                                            ) {
                                                $url = route(
                                                    'monitoring.index',
                                                    array_merge(['id' => $notif->proyek_id], $queryParams),
                                                );
                                            } elseif (\Illuminate\Support\Facades\Route::has('mro.progress')) {
                                                $url = route('mro.progress', $queryParams);
                                            } else {
                                                $url = '#';
                                            }
                                        @endphp

                                        @if ($msg)
                                            <a href="{{ $url }}"
                                                class="dropdown-item mro-notif-item py-2 px-3 border-bottom">
                                                <div class="d-flex align-items-start gap-2">
                                                    <div class="mro-notif-icon-wrap mt-1 mr-2 me-2">
                                                        <i class="{{ $msg['icon'] }} text-{{ $msg['class'] }}"
                                                            style="font-size: 18px;"></i>
                                                    </div>

                                                    <div class="mro-notif-text">
                                                        <div class="fw-bold font-weight-bold text-dark"
                                                            style="font-size: 14px; line-height: 1.3;">
                                                            {{ $notif->po_nota_dinas ?: '-' }}
                                                        </div>
                                                        <div class="text-dark" style="font-size: 13px; line-height: 1.35;">
                                                            {{ $msg['message'] }}
                                                        </div>
                                                        <div class="text-muted text-wrap"
                                                            style="font-size: 12.5px; line-height: 1.3;">
                                                            {{ $notif->nama_pekerjaan }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="text-center py-4 px-3 text-muted small">
                                        Tidak ada notifikasi kontrak MRO
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center mt-4">

                <!-- Card 1: Proyek MRO -->
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="{{ route('proyek.index') }}" class="text-decoration-none">
                        <div class="card card-outline card-primary h-100 shadow-sm hover-card">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="fas fa-chart-bar fa-3x text-primary"></i>
                                </div>
                                <h4 class="font-weight-bold text-dark mb-2">Manajemen Dokumen Proyek MRO</h4>
                                <p class="text-muted mb-0 small">
                                    Klik untuk melihat daftar dan mengelola data proyek MRO.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card 2: Progress MRO -->
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="{{ route('mro.progress') }}" class="text-decoration-none">
                        <div class="card card-outline card-info h-100 shadow-sm hover-card">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="fas fa-chart-line fa-3x text-info"></i>
                                </div>
                                <h4 class="font-weight-bold text-dark mb-2">Progress MRO</h4>
                                <p class="text-muted mb-0 small">
                                    Klik untuk memantau status dan perkembangan pekerjaan MRO.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card 3: Pekerjaan MRO (Menu Tambahan Baru) -->
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="{{ route('pekerjaanmro.index') }}" class="text-decoration-none">
                        <div class="card card-outline card-success h-100 shadow-sm hover-card">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="fas fa-briefcase fa-3x text-success"></i>
                                </div>
                                <h4 class="font-weight-bold text-dark mb-2">Manajemen Pekerjaan Proyek MRO</h4>
                                <p class="text-muted mb-0 small">
                                    Klik untuk mengelola data dan rincian pekerjaan MRO secara lengkap.
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

        .mro-notif-wrapper .mro-notif-badge {
            position: absolute;
            top: -2px;
            right: -3px;
            font-size: 10px;
            line-height: 1;
            padding: 3px 6px;
            border-radius: 999px;
        }

        .mro-notif-menu {
            width: 340px;
            max-width: 92vw;
            border-radius: 10px;
            overflow: hidden;
            z-index: 1060;
            background: #ffffff;
        }

        .mro-notif-header {
            background: #ffffff;
        }

        .mro-notif-body {
            max-height: 360px;
            overflow-y: auto;
            background: #ffffff;
        }

        .mro-notif-item {
            white-space: normal;
        }

        .mro-notif-item:hover {
            background-color: #f8fafc;
        }

        .mro-notif-text {
            min-width: 0;
            flex: 1;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trigger = document.getElementById('kontrakNotifDropdown');
            if (!trigger) return;

            const menu = trigger.nextElementSibling;
            if (!menu) return;

            const hasBootstrap = typeof window.bootstrap !== 'undefined' && window.bootstrap.Dropdown;
            const hasJqueryDropdown = typeof window.jQuery !== 'undefined' && typeof window.jQuery.fn.dropdown ===
                'function';

            if (!hasBootstrap && !hasJqueryDropdown) {
                trigger.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const isOpen = menu.classList.toggle('show');
                    trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                });

                document.addEventListener('click', function(e) {
                    if (!trigger.contains(e.target) && !menu.contains(e.target)) {
                        menu.classList.remove('show');
                        trigger.setAttribute('aria-expanded', 'false');
                    }
                });
            }
        });
    </script>
@endsection
