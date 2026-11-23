@extends('layouts.main')
@section('title', 'Laporan Mingguan Fasilitas & Jasa Lainnya')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')
    @if (session('success') || session('error'))
        @php
            $isError = session()->has('error');
            $notifMessage = $isError ? session('error') : session('success');
        @endphp
        <div id="mingguan-toast-wrapper"
            style="position: fixed; top: 20px; right: 20px; z-index: 99999; max-width: 360px; width: calc(100% - 40px); opacity: 0; transform: translateY(-12px); transition: opacity 0.25s ease, transform 0.25s ease;">
            <div
                style="display: flex; align-items: center; gap: 12px; background: #0a1f3d; color: #ffffff; border-radius: 10px; padding: 12px 14px; box-shadow: 0 10px 25px rgba(10, 31, 61, 0.28); border-left: 4px solid {{ $isError ? '#ef4444' : '#22c55e' }};">
                <div
                    style="width: 32px; height: 32px; min-width: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; background: {{ $isError ? 'rgba(239, 68, 68, 0.18)' : 'rgba(34, 197, 94, 0.18)' }}; color: {{ $isError ? '#f87171' : '#4ade80' }}; font-size: 15px;">
                    <i class="fas {{ $isError ? 'fa-exclamation-triangle' : 'fa-check' }}"
                        style="font-size: 15px; line-height: 1;"></i>
                </div>
                <div style="flex: 1; min-width: 0; line-height: 1.35;">
                    <div style="font-size: 13px; font-weight: 700; color: #ffffff; margin-bottom: 2px;">
                        {{ $isError ? 'Gagal' : 'Berhasil' }}
                    </div>
                    <div style="font-size: 12.5px; color: #dbeafe; word-break: break-word;">
                        {{ $notifMessage }}
                    </div>
                </div>
                <button type="button" id="btn-close-mingguan-toast" aria-label="Tutup"
                    style="background: transparent; border: none; color: #94a3b8; font-size: 18px; line-height: 1; padding: 2px 4px; cursor: pointer; flex-shrink: 0;">
                    &times;
                </button>
            </div>
        </div>
    @endif

    @php
        $seninId = $senin->copy()->locale('id');
        $jumatId = $jumat->copy()->locale('id');
        $prevWeek = $senin->copy()->subWeek()->toDateString();
        $nextWeek = $senin->copy()->addWeek()->toDateString();
    @endphp

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-12 col-md-6">
                    <h1 class="m-0 text-dark">Laporan Mingguan Fasilitas (Senin – Jumat)</h1>
                </div>
                <div class="col-12 col-md-6 text-md-right mt-2 mt-md-0">
                    <a href="{{ route('laporan-fasilitas.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-calendar-day mr-1"></i> Rekap Harian
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section class="content pb-4">
        <div class="container-fluid">
            {{-- Filter Minggu --}}
            <div class="card card-navy card-outline">
                <div class="card-body py-3">
                    <form method="GET" action="{{ route('laporan-mingguan.index') }}" class="row align-items-end">
                        <div class="col-md-4 mb-2 mb-md-0">
                            <label for="tanggal-acuan" class="small font-weight-bold mb-1">Pilih Tanggal dalam Minggu
                                (Otomatis Senin–Jumat)</label>
                            <div class="input-group input-group-sm">
                                <input type="date" id="tanggal-acuan" name="tanggal"
                                    value="{{ request('tanggal', $senin->toDateString()) }}" class="form-control">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter mr-1"></i> Tampilkan
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 mb-2 mb-md-0">
                            <label class="small font-weight-bold mb-1 d-block">Navigasi Cepat Minggu</label>
                            <a href="{{ route('laporan-mingguan.index', ['tanggal' => $prevWeek]) }}"
                                class="btn btn-sm btn-outline-secondary mr-1">
                                <i class="fas fa-chevron-left"></i> Minggu Lalu
                            </a>
                            <a href="{{ route('laporan-mingguan.index') }}" class="btn btn-sm btn-outline-primary mr-1">
                                Minggu Ini
                            </a>
                            <a href="{{ route('laporan-mingguan.index', ['tanggal' => $nextWeek]) }}"
                                class="btn btn-sm btn-outline-secondary">
                                Minggu Depan <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                        <div class="col-md-3 text-md-right">
                            <div class="small text-muted">Periode Aktif</div>
                            <div class="font-weight-bold text-dark">
                                {{ $seninId->translatedFormat('d M') }} – {{ $jumatId->translatedFormat('d M Y') }}
                            </div>
                            <div class="badge badge-info">{{ $mingguanData['total_item'] }} Item Pekerjaan</div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Rincian Hari Senin - Jumat --}}
            <div class="card card-navy card-outline">
                <div class="card-header bg-navy text-white">
                    <h3 class="card-title font-weight-bold mb-0">
                        Rincian Pekerjaan Senin – Jumat ({{ $jumatId->translatedFormat('F Y') }})
                    </h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th width="11%">Hari</th>
                                <th width="10%" class="text-center">Tanggal</th>
                                <th width="12%">Bulan</th>
                                <th width="9%" class="text-center">Tahun</th>
                                <th>Rincian Item Pekerjaan</th>
                                <th width="12%" class="text-center">Aksi Harian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mingguanData['hari_list'] as $hariRow)
                                <tr>
                                    <td><strong>{{ $hariRow['hari'] }}</strong></td>
                                    <td class="text-center"><strong>{{ $hariRow['tanggal'] }}</strong></td>
                                    <td>{{ $hariRow['bulan'] }}</td>
                                    <td class="text-center">{{ $hariRow['tahun'] }}</td>
                                    <td>
                                        @if (!empty($hariRow['items']))
                                            @foreach ($hariRow['items'] as $itm)
                                                <div class="mb-2 pb-1 border-bottom">
                                                    <div>- <strong>{{ $itm['sub_kategori'] }}</strong></div>
                                                    @if (!empty($itm['desc_lines']))
                                                        @foreach ($itm['desc_lines'] as $dLine)
                                                            <div class="pl-3">~ {{ $dLine }}</div>
                                                        @endforeach
                                                    @endif
                                                    @if (!empty($itm['sub_items']))
                                                        <ol class="mb-0 pl-5 small text-muted">
                                                            @foreach ($itm['sub_items'] as $sub)
                                                                <li>{{ $sub }}</li>
                                                            @endforeach
                                                        </ol>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="text-muted font-italic">Belum ada item pekerjaan tercatat pada hari
                                                ini.</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        @if ($hariRow['laporan'])
                                            <a href="{{ route('laporan-fasilitas.show', $hariRow['laporan']->id) }}"
                                                class="btn btn-xs btn-info mb-1">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            <a href="{{ route('laporan-fasilitas.edit', $hariRow['laporan']->id) }}"
                                                class="btn btn-xs btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        @else
                                            <a href="{{ route('laporan-fasilitas.create') }}"
                                                class="btn btn-xs btn-outline-primary">
                                                <i class="fas fa-plus"></i> Input
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Arsip Catatan Mingguan --}}
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold mb-0">Simpan Catatan Rekap Mingguan</h3>
                </div>
                <form action="{{ route('laporan-mingguan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tanggal_acuan" value="{{ $senin->toDateString() }}">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Judul Laporan Mingguan</label>
                            <input type="text" name="judul" class="form-control" required
                                value="{{ old('judul', $arsipMingguan->judul ?? 'REKAP MINGGUAN PEMELIHARAAN FASILITAS & JASA LAINNYA') }}">
                        </div>
                        <div class="form-group mb-0">
                            <label>Catatan / Ringkasan Mingguan (Opsional)</label>
                            <textarea name="catatan_mingguan" rows="4" class="form-control"
                                placeholder="Catatan evaluasi, kendala, atau rencana minggu depan...">{{ old('catatan_mingguan', $arsipMingguan->catatan_mingguan ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save mr-1"></i> Simpan Rekap Mingguan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        (function() {
            const wrapper = document.getElementById('mingguan-toast-wrapper');
            const closeBtn = document.getElementById('btn-close-mingguan-toast');
            if (!wrapper) return;

            requestAnimationFrame(() => {
                wrapper.style.opacity = '1';
                wrapper.style.transform = 'translateY(0)';
            });

            let isClosed = false;
            const closeToast = () => {
                if (isClosed) return;
                isClosed = true;
                wrapper.style.opacity = '0';
                wrapper.style.transform = 'translateY(-12px)';
                setTimeout(() => {
                    if (wrapper && wrapper.parentNode) {
                        wrapper.parentNode.removeChild(wrapper);
                    }
                }, 250);
            };

            if (closeBtn) {
                closeBtn.addEventListener('click', closeToast);
            }

            setTimeout(closeToast, 3000);
        })();
    </script>
@endsection
