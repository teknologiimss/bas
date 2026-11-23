@extends('layouts.main')
@section('title', 'Menu Laporan Harian Fasilitas')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')
    @php
        $itemsHariIni = $laporanHariIni ? $laporanHariIni->items : collect();
        $teamsHariIni = $laporanHariIni ? $laporanHariIni->teams : collect();
        $jumlahItemHariIni = $itemsHariIni->count();
        $jumlahTimHariIni = $teamsHariIni->count();
    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-between align-items-center" style="gap: 10px;">
                <h1 class="m-0 text-dark">Pilih Menu</h1>
                <button type="button" class="btn btn-sm btn-navy shadow-sm today-trigger-pill" onclick="openTodayPopup()"
                    style="background: #0a1f3d; color: #fff; border-radius: 20px; padding: 6px 14px;">
                    <span class="live-dot mr-1"></span>
                    Pekerjaan Hari Ini ({{ $jumlahItemHariIni }} Item)
                </button>
            </div>
        </div>
    </div>

    <div class="content pb-4">
        <div class="container-fluid">
            <div class="row justify-content-center mt-3">

                <!-- Card 1: Laporan Harian Fasilitas -->
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="{{ route('laporan-fasilitas.index') }}" class="text-decoration-none">
                        <div class="card card-outline card-primary h-100 shadow-sm hover-card">
                            <div class="card-body text-center p-4">
                                <div class="mb-3 icon-float">
                                    <i class="fas fa-clipboard-list fa-3x text-primary"></i>
                                </div>
                                <h4 class="font-weight-bold text-dark mb-2">Rekap Laporan Harian Fasilitas & Jasa Lainnya</h4>
                                <p class="text-muted mb-0 small">
                                    Klik untuk melihat, membuat, dan mengelola rekap job desk harian fasilitas & jasa
                                    lainnya.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card 2: Laporan Mingguan Fasilitas -->
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="{{ route('laporan-mingguan.index') }}" class="text-decoration-none">
                        <div class="card card-outline card-info h-100 shadow-sm hover-card">
                            <div class="card-body text-center p-4">
                                <div class="mb-3 icon-float" style="animation-delay: 0.4s;">
                                    <i class="fas fa-calendar-week fa-3x text-info"></i>
                                </div>
                                <h4 class="font-weight-bold text-dark mb-2">Rekap Laporan Mingguan Fasilitas & Jasa Lainnya</h4>
                                <p class="text-muted mb-0 small">
                                    Klik untuk melihat rincian pekerjaan mingguan Senin–Jumat beserta tanggal, bulan, dan
                                    tahun.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card 3: Pekerjaan Hari Ini (Pop-Up Dashboard) -->
                <div class="col-md-4 col-sm-6 mb-4">
                    <div role="button" tabindex="0" onclick="openTodayPopup()"
                        onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();openTodayPopup();}"
                        class="card card-outline h-100 shadow-sm hover-card today-dashboard-card"
                        style="border-top: 3px solid #0a1f3d; cursor: pointer;">
                        <div class="card-body text-center p-4 position-relative">
                            <span class="badge badge-pill today-live-badge"
                                style="background: #0a1f3d; color: #4ade80; font-size: 0.72rem; padding: 5px 10px;">
                                <span class="live-dot mr-1"></span> HARI INI
                            </span>
                            <div class="mb-3 mt-2 icon-float" style="animation-delay: 0.8s;">
                                <i class="fas fa-bolt fa-3x" style="color: #0a1f3d;"></i>
                            </div>
                            <h4 class="font-weight-bold text-dark mb-2">Pekerjaan Hari Ini</h4>
                            <p class="text-muted mb-2 small">
                                Lihat ringkasan cepat pekerjaan & tim yang bertugas pada {{ $hariIniLabel }}.
                            </p>
                            <span class="badge badge-light border text-dark px-3 py-1">
                                {{ $jumlahItemHariIni }} Pekerjaan &bull; {{ $jumlahTimHariIni }} Personil
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- POP-UP DASHBOARD PEKERJAAN HARI INI --}}
    <div id="today-job-modal" class="today-modal-backdrop" onclick="handleBackdropClick(event)"
        style="display: none; position: fixed; inset: 0; z-index: 100000; background: rgba(6, 18, 36, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 16px; opacity: 0; transition: opacity 0.28s ease;">
        <div id="today-job-panel" class="today-modal-panel"
            style="width: 100%; max-width: 780px; max-height: 88vh; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 24px 60px rgba(6, 18, 36, 0.42); display: flex; flex-direction: column; transform: translateY(22px) scale(0.97); opacity: 0; transition: transform 0.32s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.28s ease;">

            {{-- Header Navy --}}
            <div
                style="background: linear-gradient(135deg, #07172e 0%, #0f2d59 100%); color: #ffffff; padding: 18px 22px; display: flex; align-items: center; justify-content: space-between; gap: 12px;">
                <div>
                    <div class="d-flex align-items-center mb-1" style="gap: 8px;">
                        <span class="live-dot"></span>
                        <span
                            style="font-size: 11.5px; letter-spacing: 0.8px; text-transform: uppercase; color: #93c5fd; font-weight: 700;">
                            Dashboard Pekerjaan Hari Ini
                        </span>
                    </div>
                    <h5 class="m-0 font-weight-bold" style="font-size: 1.08rem;">
                        {{ $hariIniLabel }}
                    </h5>
                </div>
                <button type="button" onclick="closeTodayPopup()" aria-label="Tutup Pop-up"
                    style="width: 36px; height: 36px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.08); color: #ffffff; font-size: 20px; line-height: 1; cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    &times;
                </button>
            </div>

            {{-- Mini Stat Bar --}}
            <div class="row no-gutters border-bottom" style="background: #f8fafc;">
                <div class="col-6 p-3 border-right">
                    <div class="small text-muted">Total Item Pekerjaan</div>
                    <div class="h5 font-weight-bold m-0" style="color: #0a1f3d;">
                        <i class="fas fa-wrench mr-1 text-primary" style="font-size: 0.9rem;"></i>
                        <span class="count-anim">{{ $jumlahItemHariIni }}</span> Item
                    </div>
                </div>
                <div class="col-6 p-3">
                    <div class="small text-muted">Personil Bertugas</div>
                    <div class="h5 font-weight-bold m-0" style="color: #0a1f3d;">
                        <i class="fas fa-users mr-1 text-success" style="font-size: 0.9rem;"></i>
                        <span class="count-anim">{{ $jumlahTimHariIni }}</span> Orang
                    </div>
                </div>
            </div>

            {{-- Isi Rincian Pekerjaan Hari Ini --}}
            <div style="padding: 18px 22px; overflow-y: auto; flex: 1;">
                @if ($laporanHariIni && $itemsHariIni->count() > 0)
                    <div class="mb-3">
                        <div class="font-weight-bold mb-2" style="color: #0a1f3d; font-size: 0.95rem;">
                            <i class="fas fa-list-check mr-1"></i> Rincian Pekerjaan Hari Ini
                        </div>

                        @foreach ($itemsHariIni as $idx => $item)
                            @php
                                $descLines = [];
                                if (!empty($item->deskripsi)) {
                                    foreach (preg_split('/\r\n|\r|\n/', (string) $item->deskripsi) as $line) {
                                        $clean = ltrim(trim($line), "~ \t");
                                        if ($clean !== '') {
                                            $descLines[] = $clean;
                                        }
                                    }
                                }
                            @endphp
                            <div class="today-item-card p-3 mb-2 rounded"
                                style="background: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #0a1f3d; animation-delay: {{ $idx * 65 }}ms;">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-1"
                                    style="gap: 6px;">
                                    <div>
                                        <span class="badge" style="background: #0a1f3d; color: #fff;">
                                            Bagian {{ $item->kelompok }}
                                        </span>
                                        <strong class="ml-1" style="color: #0f172a;">{{ $item->sub_kategori }}</strong>
                                    </div>
                                    <span class="badge badge-light border text-muted">#{{ $idx + 1 }}</span>
                                </div>

                                @foreach ($descLines as $dLine)
                                    <div class="pl-2 small text-dark" style="line-height: 1.5;">~ {{ $dLine }}
                                    </div>
                                @endforeach

                                @if (!empty($item->sub_items) && is_array($item->sub_items))
                                    <ol class="mb-0 mt-1 pl-4 small text-secondary">
                                        @foreach ($item->sub_items as $sub)
                                            <li>{{ $sub }}</li>
                                        @endforeach
                                    </ol>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    @if ($teamsHariIni->count() > 0)
                        <div class="mt-3 pt-2 border-top">
                            <div class="font-weight-bold mb-2" style="color: #0a1f3d; font-size: 0.92rem;">
                                <i class="fas fa-user-hard-hat mr-1"></i> Team Bertugas Hari Ini
                            </div>
                            <div class="d-flex flex-wrap" style="gap: 6px;">
                                @foreach ($teamsHariIni as $team)
                                    <span class="badge badge-pill px-3 py-2"
                                        style="background: #e2e8f0; color: #0a1f3d; font-size: 0.8rem;">
                                        {{ $team->nama_personil }}{{ $team->keterangan ? ' (' . $team->keterangan . ')' : '' }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @else
                    <div class="text-center py-4">
                        <div class="mb-3 icon-float">
                            <i class="fas fa-inbox fa-3x text-muted"></i>
                        </div>
                        <h6 class="font-weight-bold text-dark">Belum Ada Laporan Harian untuk Hari Ini</h6>
                        <p class="text-muted small mb-3">
                            Belum ada data pekerjaan yang tercatat pada tanggal <strong>{{ $hariIniLabel }}</strong>.
                        </p>
                        <a href="{{ route('laporan-fasilitas.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus mr-1"></i> Buat Laporan Hari Ini
                        </a>
                    </div>
                @endif
            </div>

            {{-- Footer Aksi --}}
            <div class="border-top px-4 py-3 d-flex flex-wrap justify-content-between align-items-center"
                style="background: #f8fafc; gap: 8px;">
                <button type="button" class="btn btn-sm btn-secondary" onclick="closeTodayPopup()">
                    Tutup
                </button>
                <div class="d-flex flex-wrap" style="gap: 8px;">
                    @if ($laporanHariIni)
                        {{-- <a href="{{ route('laporan-fasilitas.show', $laporanHariIni->id) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye mr-1"></i> Lihat Detail & WA
                        </a>
                        <a href="{{ route('laporan-fasilitas.edit', $laporanHariIni->id) }}"
                            class="btn btn-sm btn-warning">
                            <i class="fas fa-edit mr-1"></i> Edit Hari Ini
                        </a> --}}
                    @else
                        <a href="{{ route('laporan-fasilitas.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus mr-1"></i> Input Laporan
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-card {
            transition: transform 0.25s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.25s ease;
            border-radius: 14px;
        }

        .hover-card:hover {
            transform: translateY(-6px) scale(1.01);
            box-shadow: 0 12px 24px rgba(10, 31, 61, 0.14) !important;
        }

        .today-live-badge {
            position: absolute;
            top: 12px;
            right: 12px;
        }

        .live-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #4ade80;
            box-shadow: 0 0 0 0 rgba(74, 222, 128, 0.75);
            animation: pulseDot 1.8s infinite;
        }

        @keyframes pulseDot {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(74, 222, 128, 0.75);
            }

            70% {
                transform: scale(1.05);
                box-shadow: 0 0 0 8px rgba(74, 222, 128, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(74, 222, 128, 0);
            }
        }

        .icon-float {
            animation: gentleFloat 3s ease-in-out infinite;
        }

        @keyframes gentleFloat {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .today-modal-backdrop.is-open {
            opacity: 1 !important;
        }

        .today-modal-backdrop.is-open .today-modal-panel {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
        }

        .today-modal-backdrop.is-open .today-item-card {
            opacity: 0;
            animation: slideItemIn 0.35s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        @keyframes slideItemIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @media (max-width: 575.98px) {
            .today-modal-panel {
                max-height: 92vh !important;
                border-radius: 14px !important;
            }
        }
    </style>

    <script>
        function openTodayPopup() {
            const modal = document.getElementById('today-job-modal');
            if (!modal) return;
            modal.style.display = 'flex';
            requestAnimationFrame(() => {
                modal.classList.add('is-open');
            });
        }

        function closeTodayPopup() {
            const modal = document.getElementById('today-job-modal');
            if (!modal) return;
            modal.classList.remove('is-open');
            setTimeout(() => {
                if (!modal.classList.contains('is-open')) {
                    modal.style.display = 'none';
                }
            }, 280);
        }

        function handleBackdropClick(e) {
            if (e.target && e.target.id === 'today-job-modal') {
                closeTodayPopup();
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeTodayPopup();
            }
        });

        // Muncul otomatis saat halaman dibuka
        window.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                openTodayPopup();
            }, 600);
        });
    </script>
@endsection
