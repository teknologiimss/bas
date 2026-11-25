@extends('layouts.main') {{-- Sesuaikan dengan nama layout utama aplikasi Anda --}}
@section('title', 'Menu Pekerjaan MRO')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')
    @php
        $expiringItems = collect($notifications ?? [])
            ->filter(function ($notif) {
                if (strtolower((string) ($notif->status ?? '')) === 'closed') {
                    return false;
                }

                $msg = method_exists($notif, 'notifMessage') ? $notif->notifMessage() : null;
                if (!$msg || empty($msg['message'])) {
                    return false;
                }

                return str_contains(strtolower($msg['message']), 'akan berakhir');
            })
            ->values();
    @endphp

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

    {{-- POP UP KONTRAK AKAN BERAKHIR --}}
    @if ($expiringItems->count() > 0)
        <div id="popupKontrakOverlay" class="kontrak-custom-backdrop" role="dialog" aria-modal="true"
            aria-labelledby="modalKontrakAkanBerakhirLabel">
            <div class="kontrak-custom-dialog">
                <div class="kontrak-popup-card border-0 shadow-lg">
                    <div class="kontrak-popup-header d-flex justify-content-between align-items-start p-4 text-white">
                        <div>
                            <span class="kontrak-pill mb-2 d-inline-block">
                                <i class="fas fa-hourglass-half mr-1 me-1"></i> REMINDER KONTRAK MRO
                            </span>
                            <h4 class="modal-title font-weight-bold fw-bold mb-1" id="modalKontrakAkanBerakhirLabel">
                                kontrak akan berakhir, hiiihuuuu
                            </h4>
                            <p class="mb-0 small kontrak-subtext">
                                Ada {{ $expiringItems->count() }} kontrak pekerjaan MRO yang segera mendekati tenggat
                                waktu.
                            </p>
                        </div>

                        <button type="button" class="kontrak-close-btn" id="closeKontrakPopupTop" aria-label="Tutup">
                            &times;
                        </button>
                    </div>

                    <div class="modal-body p-4 kontrak-popup-body">
                        {{-- BANNER ANIMASI / GIF LUCU --}}
                        <div class="kontrak-fun-banner d-flex align-items-center justify-content-between gap-3 p-3 mb-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="kontrak-mascot-box" title="kontrak akan berakhir, hiiihuuuu">
                                    <img src="https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExa3p0Y3FtbzZ3Z25xOXR6bGR2d2N0YnV1bTZ0bGRmYnpuY2J2dyZlcD12MV9naWZzX3NlYXJjaCZjdD1n/l0HlBO7eyXzSZkJri/giphy.gif"
                                        alt="Animasi lucu kontrak akan berakhir" class="kontrak-gif-img"
                                        onerror="this.style.display='none'; document.getElementById('fallbackFunEmoji').style.display='flex';">
                                    <div id="fallbackFunEmoji" class="kontrak-emoji-fallback" style="display: none;">
                                        🏃‍♂️💨
                                    </div>
                                </div>

                                <div>
                                    <div class="font-weight-bold fw-bold text-dark kontrak-fun-title">
                                        kontrak akan berakhir, hiiihuuuu
                                    </div>
                                    <div class="small text-muted">
                                        Cek dulu daftar PO/Nota Dinas di bawah ini sebelum waktunya habis!
                                    </div>
                                </div>
                            </div>

                            <span class="badge badge-warning bg-warning text-dark px-3 py-2 kontrak-count-badge">
                                {{ $expiringItems->count() }} Kontrak
                            </span>
                        </div>

                        {{-- DAFTAR KONTRAK YANG AKAN BERAKHIR SAJA --}}
                        <div class="kontrak-list-scroll">
                            @foreach ($expiringItems as $item)
                                @php
                                    $msg = $item->notifMessage();
                                    $queryParams = array_filter([
                                        'monitoring_id' => $item->id,
                                        'po' => $item->po_nota_dinas,
                                    ]);

                                    if (
                                        !empty($item->proyek_id) &&
                                        \Illuminate\Support\Facades\Route::has('monitoring.index')
                                    ) {
                                        $itemUrl = route(
                                            'monitoring.index',
                                            array_merge(['id' => $item->proyek_id], $queryParams),
                                        );
                                    } elseif (\Illuminate\Support\Facades\Route::has('mro.progress')) {
                                        $itemUrl = route('mro.progress', $queryParams);
                                    } else {
                                        $itemUrl = '#';
                                    }

                                    $tglSelesai = !empty($item->tanggal_selesai_kontrak)
                                        ? \Carbon\Carbon::parse($item->tanggal_selesai_kontrak)->format('d-m-Y')
                                        : '-';
                                @endphp

                                <a href="{{ $itemUrl }}"
                                    class="kontrak-item-card d-block text-decoration-none mb-3">
                                    <div class="d-flex justify-content-between align-items-center gap-3">
                                        <div class="min-w-0 flex-grow-1">
                                            <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                                <span class="font-weight-bold fw-bold text-dark kontrak-po-text">
                                                    {{ $item->po_nota_dinas ?: '-' }}
                                                </span>
                                                <span class="badge badge-warning bg-warning text-dark kontrak-status-chip">
                                                    <i class="{{ $msg['icon'] ?? 'fas fa-bell' }} mr-1 me-1"></i>
                                                    {{ $msg['message'] }}
                                                </span>
                                            </div>
                                            <div class="text-secondary small text-truncate">
                                                {{ $item->nama_pekerjaan ?: '-' }}
                                            </div>
                                            <div class="text-muted mt-1" style="font-size: 11.5px;">
                                                <i class="far fa-calendar-alt mr-1 me-1"></i>
                                                Batas Kontrak: <strong>{{ $tglSelesai }}</strong>
                                                @if (!empty($item->proyek) && !empty($item->proyek->nama_proyek))
                                                    <span class="mx-1">•</span>
                                                    <span>{{ $item->proyek->nama_proyek }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="kontrak-go-arrow">
                                            <i class="fas fa-chevron-right"></i>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div
                        class="modal-footer bg-white border-top px-4 py-3 d-flex justify-content-between align-items-center">
                        <span class="small text-muted">
                            Klik salah satu kontrak untuk membuka detailnya langsung.
                        </span>
                        <button type="button" class="btn btn-dark px-4 rounded-pill" id="closeKontrakPopupBottom">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

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

        /* Styling Pop-up Kontrak Akan Berakhir */
        .kontrak-custom-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(3px);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            overflow-y: auto;
        }

        .kontrak-custom-dialog {
            width: 100%;
            max-width: 760px;
            margin: auto;
            animation: popInBounce 0.32s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .kontrak-popup-card {
            border-radius: 18px;
            overflow: hidden;
            background: #ffffff;
        }

        .kontrak-popup-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #b45309 100%);
        }

        .kontrak-pill {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.6px;
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(251, 191, 36, 0.22);
            color: #fde68a;
            border: 1px solid rgba(251, 191, 36, 0.45);
        }

        .kontrak-subtext {
            color: #cbd5e1;
        }

        .kontrak-close-btn {
            background: rgba(255, 255, 255, 0.14);
            border: none;
            color: #ffffff;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            line-height: 1;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .kontrak-close-btn:hover {
            background: rgba(255, 255, 255, 0.28);
            transform: rotate(90deg);
        }

        .kontrak-popup-body {
            background: #f8fafc;
        }

        .kontrak-fun-banner {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border: 1px solid #fde68a;
            border-radius: 14px;
        }

        .kontrak-mascot-box {
            width: 66px;
            height: 66px;
            border-radius: 16px;
            background: #ffffff;
            border: 2px solid #fbbf24;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            animation: wiggleMascot 2.2s ease-in-out infinite;
        }

        .kontrak-gif-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .kontrak-emoji-fallback {
            width: 100%;
            height: 100%;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }

        .kontrak-fun-title {
            font-size: 16px;
            color: #92400e;
        }

        .kontrak-count-badge {
            border-radius: 999px;
            font-size: 12px;
            flex-shrink: 0;
        }

        .kontrak-list-scroll {
            max-height: 300px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .kontrak-item-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #f59e0b;
            border-radius: 12px;
            padding: 12px 16px;
            transition: all 0.2s ease;
        }

        .kontrak-item-card:hover {
            transform: translateX(4px);
            border-color: #f59e0b;
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.14);
        }

        .kontrak-po-text {
            font-size: 14.5px;
        }

        .kontrak-status-chip {
            font-size: 11px;
            border-radius: 999px;
            padding: 4px 10px;
        }

        .kontrak-go-arrow {
            color: #94a3b8;
            font-size: 14px;
            flex-shrink: 0;
            transition: transform 0.2s ease, color 0.2s ease;
        }

        .kontrak-item-card:hover .kontrak-go-arrow {
            color: #d97706;
            transform: translateX(3px);
        }

        @keyframes popInBounce {
            0% {
                opacity: 0;
                transform: scale(0.9) translateY(14px);
            }

            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        @keyframes wiggleMascot {

            0%,
            100% {
                transform: rotate(0deg) scale(1);
            }

            20% {
                transform: rotate(-7deg) scale(1.04);
            }

            40% {
                transform: rotate(7deg) scale(1.04);
            }

            60% {
                transform: rotate(-4deg) scale(1.02);
            }

            80% {
                transform: rotate(4deg) scale(1);
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trigger = document.getElementById('kontrakNotifDropdown');
            if (trigger) {
                const menu = trigger.nextElementSibling;
                if (menu) {
                    const hasBootstrap = typeof window.bootstrap !== 'undefined' && window.bootstrap.Dropdown;
                    const hasJqueryDropdown = typeof window.jQuery !== 'undefined' && typeof window.jQuery.fn
                        .dropdown === 'function';

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
                }
            }

            const popupOverlay = document.getElementById('popupKontrakOverlay');
            if (popupOverlay) {
                document.body.appendChild(popupOverlay);
                document.body.style.overflow = 'hidden';

                const closePopup = function() {
                    popupOverlay.style.display = 'none';
                    document.body.style.overflow = '';
                };

                const btnTop = document.getElementById('closeKontrakPopupTop');
                const btnBottom = document.getElementById('closeKontrakPopupBottom');

                if (btnTop) btnTop.addEventListener('click', closePopup);
                if (btnBottom) btnBottom.addEventListener('click', closePopup);

                popupOverlay.addEventListener('click', function(e) {
                    if (e.target === popupOverlay) {
                        closePopup();
                    }
                });
            }
        });
    </script>
@endsection
```[cite: 8, 9, 13, 19]
