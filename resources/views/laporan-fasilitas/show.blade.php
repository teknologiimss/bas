@extends('layouts.main')
@section('title', 'Detail Laporan Harian Fasilitas & Jasa Lainnya')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

<style>
    @media (max-width: 575.98px) {
        .detail-laporan-header {
            flex-direction: column;
            align-items: flex-start !important;
        }

        .detail-laporan-header h1 {
            font-size: 1.25rem !important;
            margin-bottom: 10px !important;
        }

        .detail-laporan-actions {
            width: 100%;
            text-align: left !important;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .detail-laporan-actions .btn {
            flex: 1 1 auto;
            font-size: 0.82rem;
            padding: 6px 10px;
        }

        .detail-laporan-card-body {
            padding: 12px !important;
            font-size: 0.88rem;
            line-height: 1.5 !important;
        }

        .detail-laporan-card-body h5 {
            font-size: 0.98rem !important;
            word-break: break-word;
        }

        .detail-laporan-card-body h6 {
            font-size: 0.9rem !important;
            word-break: break-word;
        }

        .detail-laporan-card-body .tilde-item,
        .detail-laporan-card-body .team-item {
            word-break: break-word;
        }

        .detail-laporan-card-body ol {
            padding-left: 18px !important;
        }

        #wa-report-text {
            font-size: 12px !important;
            min-height: 260px;
        }
    }
</style>

@section('content')
    @if (session('success') || session('error'))
        @php
            $isError = session()->has('error');
            $notifMessage = $isError ? session('error') : session('success');
        @endphp
        <div id="show-laporan-toast-wrapper"
            style="position: fixed; top: 20px; right: 20px; z-index: 99999; max-width: 360px; width: calc(100% - 40px); opacity: 0; transform: translateY(-12px); transition: opacity 0.25s ease, transform 0.25s ease;">
            <div id="show-laporan-toast-box"
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
                <button type="button" id="btn-close-show-toast" aria-label="Tutup"
                    style="background: transparent; border: none; color: #94a3b8; font-size: 18px; line-height: 1; padding: 2px 4px; cursor: pointer; flex-shrink: 0;">
                    &times;
                </button>
            </div>
        </div>
    @endif

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center detail-laporan-header">
                <div class="col-12 col-sm-6">
                    <h1 class="m-0 text-dark">Detail Laporan Harian Fasilitas & Jasa Lainnya</h1>
                </div>
                <div class="col-12 col-sm-6 text-sm-right detail-laporan-actions">
                    <button type="button" class="btn btn-success" onclick="copyReportText()">
                        <i class="fab fa-whatsapp mr-1"></i> Salin Format WhatsApp
                    </button>
                    <a href="{{ route('laporan-fasilitas.edit', $laporan->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <a href="{{ route('laporan-fasilitas.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @php
                $formatTildeLines = function ($text) {
                    $lines = preg_split('/\r\n|\r|\n/', (string) $text);
                    $result = [];
                    foreach ($lines as $line) {
                        $trimmed = trim($line);
                        if ($trimmed === '') {
                            continue;
                        }
                        $clean = ltrim($trimmed, "~ \t");
                        $result[] = '~ ' . $clean;
                    }
                    return $result;
                };

                $groupedA = $laporan->itemsKelompokA->groupBy('sub_kategori');
                $groupedB = $laporan->itemsKelompokB->groupBy('sub_kategori');
            @endphp

            <div class="row">
                <div class="col-12 col-md-7 mb-3 mb-md-0">
                    <div class="card card-navy card-outline">
                        <div class="card-body detail-laporan-card-body" style="line-height: 1.6;">
                            <h5 class="font-weight-bold mb-0">{{ strtoupper($laporan->judul) }}</h5>
                            <p class="mb-3">Hari/Tgl/ : <strong>{{ $laporan->tanggal_indo }}.</strong></p>

                            <h6 class="font-weight-bold mt-3">A. Pelayanan Fasilitas angkat - angkut ( Pengecekan Harian ,PM
                                P1 dan SPR )</h6>
                            @foreach ($subKategoriList['A'] as $subA)
                                <div class="mt-2">
                                    <strong>{{ $subA }}</strong>
                                    @if (isset($groupedA[$subA]) && $groupedA[$subA]->count())
                                        @foreach ($groupedA[$subA] as $item)
                                            @foreach ($formatTildeLines($item->deskripsi) as $descLine)
                                                <div class="tilde-item">{{ $descLine }}</div>
                                            @endforeach
                                            @if (!empty($item->sub_items))
                                                <ol class="mb-1 pl-4">
                                                    @foreach ($item->sub_items as $subLine)
                                                        <li>{{ $subLine }}</li>
                                                    @endforeach
                                                </ol>
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="tilde-item">~</div>
                                    @endif
                                </div>
                            @endforeach

                            <h6 class="font-weight-bold mt-4">B. Pekerjaan lain ( Cuker , Pengiriman , Rewinding , Sipil ,
                                dll )</h6>
                            @foreach ($subKategoriList['B'] as $subB)
                                <div class="mt-2">
                                    <strong>{{ $subB }}</strong>
                                    @if (isset($groupedB[$subB]) && $groupedB[$subB]->count())
                                        @foreach ($groupedB[$subB] as $item)
                                            @foreach ($formatTildeLines($item->deskripsi) as $descLine)
                                                <div class="tilde-item">{{ $descLine }}</div>
                                            @endforeach
                                            @if (!empty($item->sub_items))
                                                <ol class="mb-1 pl-4">
                                                    @foreach ($item->sub_items as $subLine)
                                                        <li>{{ $subLine }}</li>
                                                    @endforeach
                                                </ol>
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="tilde-item">~</div>
                                    @endif
                                </div>
                            @endforeach

                            <div class="mt-4">
                                <strong>Team :</strong>
                                @forelse($laporan->teams as $t)
                                    <div class="team-item">~
                                        {{ $t->nama_personil }}{{ $t->keterangan ? ' ( ' . $t->keterangan . ' )' : '' }}
                                    </div>
                                @empty
                                    <div class="team-item">~</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-5">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fab fa-whatsapp mr-1"></i> Preview Teks WhatsApp</h3>
                        </div>
                        <div class="card-body p-2 p-sm-3">
                            <textarea id="wa-report-text" class="form-control" rows="28" readonly
                                style="font-size: 13px; background: #f8f9fa;">*{{ strtoupper($laporan->judul) }}*
Hari/Tgl/ : {{ $laporan->tanggal_indo }}.

*A. Pelayanan Fasilitas angkat - angkut ( Pengecekan Harian ,PM P1 dan SPR )*
@foreach ($subKategoriList['A'] as $subA)
*{{ $subA }}*
@if (isset($groupedA[$subA]) && $groupedA[$subA]->count())
@foreach ($groupedA[$subA] as $item)
@foreach ($formatTildeLines($item->deskripsi) as $descLine)
{{ $descLine }}
@endforeach
@if (!empty($item->sub_items))
@foreach ($item->sub_items as $idx => $subLine)
{{ $idx + 1 }}. {{ $subLine }}
@endforeach
@endif
@endforeach
@else
~
@endif
@endforeach

*B. Pekerjaan lain ( Cuker , Pengiriman , Rewinding , Sipil , dll )*
@foreach ($subKategoriList['B'] as $subB)
*{{ $subB }}*
@if (isset($groupedB[$subB]) && $groupedB[$subB]->count())
@foreach ($groupedB[$subB] as $item)
@foreach ($formatTildeLines($item->deskripsi) as $descLine)
{{ $descLine }}
@endforeach
@if (!empty($item->sub_items))
@foreach ($item->sub_items as $idx => $subLine)
{{ $idx + 1 }}. {{ $subLine }}
@endforeach
@endif
@endforeach
@else
~
@endif
@endforeach

Team :
@foreach ($laporan->teams as $t)
~ {{ $t->nama_personil }}{{ $t->keterangan ? ' ( ' . $t->keterangan . ' )' : '' }}
@endforeach
</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function copyReportText() {
            const textarea = document.getElementById('wa-report-text');
            if (!textarea) return;
            textarea.select();
            textarea.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(textarea.value).then(() => {
                alert('Teks laporan berhasil disalin! Siap ditempel ke WhatsApp.');
            });
        }

        (function() {
            const wrapper = document.getElementById('show-laporan-toast-wrapper');
            const closeBtn = document.getElementById('btn-close-show-toast');
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
