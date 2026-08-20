@extends('layouts.main')

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #0f172a;
            --secondary: #1e3a8a;
        }

        body {
            background: #eef4fb;
            font-family: 'Segoe UI', sans-serif;
        }

        .card-custom {
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 25px rgba(15, 23, 42, .08);
            background: white;
            margin-bottom: 20px;
        }

        .table-custom th {
            background: #0f172a;
            color: white;
            text-align: center;
        }

        .img-thumb {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.2s;
        }

        .img-thumb:hover {
            transform: scale(1.08);
        }

        .nav-pills .nav-link.active {
            background-color: #0f172a !important;
            color: #ffffff !important;
        }

        .nav-pills .nav-link {
            color: #0f172a;
            font-weight: 600;
            cursor: pointer;
        }
    </style>

    @php
        // Mengambil nilai No FCU secara dinamis sesuai inputan
        $noFcu1 = $fcu->no_fcu_1 ?? $fcu->no_fcu;
        $noFcu2 = $fcu->no_fcu_2 ?? ($fcu->no_fcu ? $fcu->no_fcu . '-02' : '');
    @endphp

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark mb-0">📄 Detail Monitoring FCU</h3>
            <div class="d-flex gap-2">
                <a href="{{ route('fcu.print', $fcu->id) }}" target="_blank" class="btn btn-danger rounded-pill px-3">
                    <i class="fa fa-print me-1"></i> Cetak PDF / Print
                </a>
                <a href="{{ route('fcu.index') }}" class="btn btn-secondary rounded-pill px-3">
                    <i class="fa fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        {{-- Header Info --}}
        <div class="card card-custom p-4">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <span class="text-muted">Judul Monitoring:</span>
                    <h5 class="fw-bold">{{ $fcu->judul }}</h5>
                </div>
                <div class="col-md-3 mb-2">
                    <span class="text-muted">No. FCU:</span>
                    {{-- Tampilan dinamis No FCU di header --}}
                    <h5 class="fw-bold text-primary" id="display-no-fcu">{{ $noFcu1 }}</h5>
                </div>
                <div class="col-md-3 mb-2">
                    <span class="text-muted">Jenis Perawatan:</span>
                    <h5 class="fw-bold"><span class="badge bg-info text-dark">{{ $fcu->jenis_perawatan }}</span></h5>
                </div>
                <div class="col-md-6 mb-2">
                    <span class="text-muted">Tanggal:</span>
                    <h6 class="fw-bold">{{ \Carbon\Carbon::parse($fcu->tanggal)->format('d F Y') }}</h6>
                </div>
                <div class="col-md-6 mb-2">
                    <span class="text-muted">Kesimpulan Akhir:</span>
                    <h5>
                        <span
                            class="badge {{ $fcu->kesimpulan == 'SO' ? 'bg-success' : ($fcu->kesimpulan == 'TSO' ? 'bg-danger' : 'bg-warning') }}">
                            {{ $fcu->kesimpulan ?? 'Belum Ditentukan' }}
                        </span>
                    </h5>
                </div>
            </div>

            @if ($fcu->jenis_perawatan === 'Unscheduled' && $fcu->unscheduledForm)
                <hr>
                <div class="alert alert-warning mb-0">
                    <h6 class="fw-bold text-danger"><i class="fa fa-circle-exclamation me-1"></i> Detail Unscheduled
                        Maintenance</h6>
                    <div class="row mt-2">
                        <div class="col-md-4"><b>Personil:</b> {{ $fcu->unscheduledForm->personil }}</div>
                        <div class="col-md-4"><b>Status:</b> {{ $fcu->unscheduledForm->status }}</div>
                        <div class="col-md-4"><b>Tanggal Form:</b>
                            {{ \Carbon\Carbon::parse($fcu->unscheduledForm->tanggal)->format('d/m/Y') }}</div>
                        <div class="col-md-6 mt-2"><b>Jenis Kerusakan:</b> {{ $fcu->unscheduledForm->jenis_kerusakan }}
                        </div>
                        <div class="col-md-6 mt-2"><b>Tindak Lanjut:</b> {{ $fcu->unscheduledForm->tindak_lanjut }}</div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Checklist Data Dikelompokkan dengan Tab FCU 1 & FCU 2 --}}
        <div class="card card-custom p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0"><i class="fa fa-list-check me-2"></i> Hasil Inspection Checksheet</h5>

                {{-- Nav Tabs Dinamis --}}
                <ul class="nav nav-pills" id="fcuTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="fcu1-tab" data-bs-toggle="pill" data-bs-target="#fcu1"
                            type="button" role="tab" aria-controls="fcu1" aria-selected="true">
                            <i class="fa fa-fan me-1"></i> FCU 1 ({{ $noFcu1 }})
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="fcu2-tab" data-bs-toggle="pill" data-bs-target="#fcu2" type="button"
                            role="tab" aria-controls="fcu2" aria-selected="false">
                            <i class="fa fa-fan me-1"></i> FCU 2 ({{ $noFcu2 }})
                        </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content" id="fcuTabContent">
                @php
                    $units = [
                        'fcu1' => 'FCU 1',
                        'fcu2' => 'FCU 2',
                    ];
                @endphp

                @foreach ($units as $unitKey => $unitLabel)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $unitKey }}"
                        role="tabpanel" aria-labelledby="{{ $unitKey }}-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle table-custom">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Uraian / Pekerjaan & Standar</th>
                                        <th style="width: 100px;">Status</th>
                                        <th>Keterangan</th>
                                        <th style="width: 180px;">Foto Dokumentasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fcu->sections as $sec)
                                        <tr class="table-secondary fw-bold">
                                            <td colspan="5">{{ $sec->kode }} {{ $sec->nama_section }}</td>
                                        </tr>
                                        @foreach ($sec->items as $item)
                                            <tr>
                                                <td class="text-center fw-bold">{{ $item->nomor }}</td>
                                                <td colspan="4" class="fw-bold bg-light">{{ $item->uraian }}</td>
                                            </tr>
                                            @foreach ($item->details as $det)
                                                @php
                                                    $res = $det->results
                                                        ? $det->results->where('unit', $unitKey)->first()
                                                        : null;
                                                @endphp
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <div><b>Aktivitas:</b> {{ $det->aktivitas }}</div>
                                                        <div class="small text-muted"><b>Standar:</b> {{ $det->standar }}
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        @if (optional($res)->status == 'OK')
                                                            <span class="badge bg-success">OK</span>
                                                        @elseif(optional($res)->status == 'NOK')
                                                            <span class="badge bg-danger">NOK</span>
                                                        @else
                                                            <span class="badge bg-secondary">-</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ optional($res)->keterangan ?? '-' }}</td>
                                                    <td>
                                                        <div class="d-flex flex-wrap gap-1">
                                                            @if ($res && $res->photos->count())
                                                                @foreach ($res->photos as $p)
                                                                    <a href="{{ asset('uploads/fcu/' . $p->foto) }}"
                                                                        target="_blank">
                                                                        <img src="{{ asset('uploads/fcu/' . $p->foto) }}"
                                                                            class="img-thumb"
                                                                            title="Klik untuk memperbesar">
                                                                    </a>
                                                                @endforeach
                                                            @else
                                                                <small class="text-muted">- Tidak ada foto -</small>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Notes Card --}}
        @if ($fcu->notes->count())
            <div class="card card-custom p-4">
                <h5 class="fw-bold mb-3"><i class="fa fa-sticky-note me-2"></i> Catatan Monitoring</h5>
                <ul>
                    @foreach ($fcu->notes as $note)
                        <li>{{ $note->catatan }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    {{-- Script untuk ganti Tab dan ubah No. FCU secara otomatis --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var tabButtons = document.querySelectorAll('#fcuTab button');
            var displayNoFcu = document.getElementById('display-no-fcu');

            // Variabel dinamis No FCU dari Blade
            var noFcu1 = "{{ $noFcu1 }}";
            var noFcu2 = "{{ $noFcu2 }}";

            tabButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    // 1. Reset state aktif semua tab
                    tabButtons.forEach(btn => {
                        btn.classList.remove('active');
                        btn.setAttribute('aria-selected', 'false');
                    });

                    document.querySelectorAll('.tab-pane').forEach(pane => {
                        pane.classList.remove('show', 'active');
                    });

                    // 2. Aktifkan tab yang dipilih
                    this.classList.add('active');
                    this.setAttribute('aria-selected', 'true');

                    var targetId = this.getAttribute('data-bs-target');
                    var targetPane = document.querySelector(targetId);
                    if (targetPane) {
                        targetPane.classList.add('show', 'active');
                    }

                    // 3. Ubah No. FCU pada Header Info secara dinamis
                    if (targetId === '#fcu1') {
                        displayNoFcu.innerText = noFcu1;
                    } else if (targetId === '#fcu2') {
                        displayNoFcu.innerText = noFcu2;
                    }
                });
            });
        });
    </script>
@endsection
