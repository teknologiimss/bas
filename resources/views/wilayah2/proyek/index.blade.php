@extends('layouts.main')

@section('title', 'Pekerjaan Wilayah 2')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css"
        rel="stylesheet" />

    <style>
        body {
            background-color: #f4f6f9;
        }

        .card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 0.5rem 1rem rgba(11, 37, 69, 0.08);
            background: #ffffff;
        }

        .btn-success {
            background-color: #1d3557;
            border-color: #1d3557;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-success:hover {
            background-color: #0b2545;
            border-color: #0b2545;
        }

        .search-wrapper {
            display: flex;
            background: #ffffff;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            width: 100%;
        }

        .search-input {
            flex: 1;
            border: none;
            padding: 10px 16px;
            outline: none;
            font-size: 14px;
            color: #334155;
        }

        .search-btn {
            background-color: #1d3557;
            color: white;
            border: none;
            padding: 0 20px;
            font-weight: 500;
            white-space: nowrap;
        }

        .proyek-item-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-left: 5px solid #1d3557;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .action-group {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .modal-header {
            background-color: #0b2545 !important;
            color: #ffffff;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-container .select2-selection--single {
            height: 38px !important;
            border: 1px solid #ced4da !important;
            padding-top: 4px;
        }

        @media (max-width: 768px) {
            .proyek-item-card {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 12px;
            }

            .action-group {
                width: 100%;
                justify-content: flex-end;
                border-top: 1px solid #f1f5f9;
                padding-top: 10px;
            }
        }
    </style>

    <div class="container-fluid px-2 px-md-4 py-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-stretch gap-3 mb-4">
            <button class="btn btn-success px-4 py-2 shadow-sm" data-toggle="modal" data-target="#modalCreate">
                <i class="fa fa-plus mr-1"></i> Buat Pekerjaan Wilayah 2 Baru
            </button>
            <form method="GET" action="{{ route('pekerjaanwil2.index') }}" class="flex-grow-1 ml-md-3 mb-0">
                <div class="search-wrapper">
                    <input type="text" name="search" class="search-input" placeholder="Cari nama proyek / no kontrak..."
                        value="{{ request('search') }}">
                    <button class="search-btn" type="submit"><i class="fa fa-search mr-1"></i> Cari</button>
                </div>
            </form>
        </div>

        <div class="card p-3 p-md-4 shadow-sm">
            <h5 class="mb-3 font-weight-bold text-dark">Daftar Pekerjaan Wilayah 2</h5>

            @forelse ($proyeks as $p)
                @php
                    $monInfo = \App\Models\MonitoringWil2::where('po_nota_dinas', $p->no_kontrak)->first();
                    $tglMulai = $p->tanggal_kontrak ?? ($monInfo->tanggal_kontrak ?? null);
                    $tglSelesai = $p->tanggal_selesai_kontrak ?? ($monInfo->tanggal_selesai_kontrak ?? null);

                    // ==========================================
                    // PERHITUNGAN PROGRESS S/D MINGGU INI TERAKHIR
                    // ==========================================
                    $totalHargaGlobal = $p->items->sum(function ($item) {
                        return $item->harga_satuan ? $item->vol_rencana * $item->harga_satuan : 0;
                    });
                    $hasHargaGlobal = $p->items->contains(function ($item) {
                        return !empty($item->harga_satuan) && $item->harga_satuan > 0;
                    });
                    $totalItemCount = $p->items->count();

                    // Hitung total minggu berdasarkan durasi kontrak
                    $startDateVal = $tglMulai ? \Carbon\Carbon::parse($tglMulai)->startOfDay() : now();
                    $endDateVal = $tglSelesai ? \Carbon\Carbon::parse($tglSelesai)->startOfDay() : now();
                    $diffDays = $startDateVal->diffInDays($endDateVal) + 1;
                    $totalWeeksCalc = max(1, ceil($diffDays / 7));

                    $sumSmpaiMingguIniPerMgg = array_fill(1, $totalWeeksCalc, 0);

                    foreach ($p->items as $item) {
                        $bobotRencana = 0;
                        if ($totalHargaGlobal > 0) {
                            $jumlahItem = $item->harga_satuan ? $item->vol_rencana * $item->harga_satuan : 0;
                            $bobotRencana = ($jumlahItem / $totalHargaGlobal) * 100;
                        }

                        $progressMingguanData = $item->progress_mingguan ?? [];
                        $smpaiMingguIniAcc = 0;

                        for ($w = 1; $w <= $totalWeeksCalc; $w++) {
                            $volRealisasi = $progressMingguanData[$w]['vol'] ?? '';
                            $progMingguIni = 0;

                            if ($item->vol_rencana > 0 && is_numeric($volRealisasi)) {
                                if ($item->harga_satuan) {
                                    $progMingguIni = ($bobotRencana * $volRealisasi) / $item->vol_rencana;
                                } else {
                                    $progMingguIni = ($volRealisasi / $item->vol_rencana) * 100;
                                }
                            }
                            $smpaiMingguIniAcc += $progMingguIni;
                            $sumSmpaiMingguIniPerMgg[$w] += $smpaiMingguIniAcc;
                        }
                    }

                    $latestProgress = 0;
                    if ($totalWeeksCalc > 0) {
                        $wLast = $totalWeeksCalc;
                        if ($hasHargaGlobal) {
                            $latestProgress = $sumSmpaiMingguIniPerMgg[$wLast] ?? 0;
                        } else {
                            $latestProgress =
                                $totalItemCount > 0 ? ($sumSmpaiMingguIniPerMgg[$wLast] ?? 0) / $totalItemCount : 0;
                        }
                    }
                @endphp

                <div class="proyek-item-card shadow-sm">
                    <div>
                        <h5 class="mb-1 text-dark"><strong>{{ $p->nama_proyek }}</strong></h5>
                        <small class="text-muted d-block"><i class="fa fa-file-text-o mr-1"></i> No. Kontrak/SO/Nodin:
                            {{ $p->no_kontrak ?? '-' }}</small>
                        <small class="text-muted d-block mt-1">
                            <i class="fa fa-calendar-o mr-1"></i> Periode Kontrak:
                            <strong>{{ $tglMulai ? \Carbon\Carbon::parse($tglMulai)->format('d/m/Y') : '-' }}</strong> s/d
                            <strong>{{ $tglSelesai ? \Carbon\Carbon::parse($tglSelesai)->format('d/m/Y') : '-' }}</strong>
                        </small>
                    </div>
                    <div class="action-group">
                        <!-- Badge Progress S/D Minggu Ini Terakhir -->
                        <div class="px-3 py-1 bg-light border rounded text-center mr-1" style="min-width: 110px;">
                            <span class="d-block text-muted" style="font-size: 10px; font-weight: 600;">PROGRESS
                                AKHIR</span>
                            <strong class="text-success"
                                style="font-size: 13px;">{{ number_format($latestProgress, 2, ',', '.') }}%</strong>
                        </div>

                        <a href="{{ route('pekerjaanwil2.monitor', $p->id) }}" class="btn btn-light border btn-sm"><i
                                class="fa fa-desktop text-primary mr-1"></i> Monitor</a>
                        <button type="button" class="btn btn-warning text-white btn-sm" data-toggle="modal"
                            data-target="#modalEdit{{ $p->id }}"><i class="fa fa-edit mr-1"></i> Edit</button>
                        <form action="{{ route('pekerjaanwil2.delete', $p->id) }}" method="POST" class="d-inline m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Hapus pekerjaan ini?')"><i class="fa fa-trash mr-1"></i>
                                Delete</button>
                        </form>
                    </div>
                </div>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit{{ $p->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <form class="modal-content shadow" action="{{ route('pekerjaanwil2.update', $p->id) }}"
                            method="POST">
                            @csrf
                            <div class="modal-header px-4 py-3">
                                <h5 class="modal-title font-weight-bold">Edit Pekerjaan Wilayah 2</h5>
                                <button type="button" class="close text-white" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body p-4">
                                {{-- Mengambil data secara spesifik dari tabel monitoringwil2s via Model MonitoringWil2 --}}
                                @php $monitoringsListEdit = \App\Models\MonitoringWil2::all(); @endphp
                                <div class="form-group mb-3">
                                    <label class="small font-weight-bold text-dark">No. Kontrak / SO / Nodin *</label>
                                    <select name="no_kontrak" class="form-control select2-search edit-no-kontrak"
                                        data-id="{{ $p->id }}" required>
                                        <option value="">-- Pilih No. Kontrak --</option>
                                        @foreach ($monitoringsListEdit as $mon)
                                            <option value="{{ $mon->po_nota_dinas }}"
                                                data-nama="{{ $mon->nama_pekerjaan }}"
                                                data-tgl-mulai="{{ $mon->tanggal_kontrak ?? '' }}"
                                                data-tgl-selesai="{{ $mon->tanggal_selesai_kontrak ?? '' }}"
                                                {{ $p->no_kontrak == $mon->po_nota_dinas ? 'selected' : '' }}>
                                                - {{ $mon->po_nota_dinas }} {{ $mon->nama_pekerjaan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="small font-weight-bold text-dark">Nama Proyek *</label>
                                    <input type="text" name="nama_proyek" id="edit_nama_proyek_{{ $p->id }}"
                                        value="{{ $p->nama_proyek }}" class="form-control" required readonly>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="small font-weight-bold text-dark">Tanggal Kontrak</label>
                                        <input type="date" name="tanggal_kontrak"
                                            id="edit_tgl_mulai_{{ $p->id }}" value="{{ $tglMulai }}"
                                            class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label class="small font-weight-bold text-dark">Selesai Kontrak</label>
                                        <input type="date" name="tanggal_selesai_kontrak"
                                            id="edit_tgl_selesai_{{ $p->id }}" value="{{ $tglSelesai }}"
                                            class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer bg-light px-4 py-3">
                                <button type="button" class="btn btn-secondary px-4 shadow-sm"
                                    data-dismiss="modal">Cancel</button>
                                <button class="btn btn-success px-4 shadow-sm">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <p class="mb-0">Belum ada data Pekerjaan Wilayah 2.</p>
                </div>
            @endforelse

            <div class="mt-3 d-flex justify-content-center">
                {{ $proyeks->appends(['search' => request('search')])->links() }}</div>
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form class="modal-content shadow" action="{{ route('pekerjaanwil2.store') }}" method="POST">
                @csrf
                <div class="modal-header px-4 py-3">
                    <h5 class="modal-title font-weight-bold">Buat Pekerjaan Wilayah 2 Baru</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body p-4">
                    {{-- Mengambil data secara spesifik dari tabel monitoringwil2s via Model MonitoringWil2 --}}
                    @php $monitoringsListCreate = \App\Models\MonitoringWil2::all(); @endphp
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-dark">No. Kontrak / SO / Nodin *</label>
                        <select name="no_kontrak" id="create_no_kontrak" class="form-control select2-search" required>
                            <option value="">-- Pilih No. Kontrak --</option>
                            @foreach ($monitoringsListCreate as $mon)
                                <option value="{{ $mon->po_nota_dinas }}" data-nama="{{ $mon->nama_pekerjaan }}"
                                    data-tgl-mulai="{{ $mon->tanggal_kontrak ?? '' }}"
                                    data-tgl-selesai="{{ $mon->tanggal_selesai_kontrak ?? '' }}">
                                    - {{ $mon->po_nota_dinas }} {{ $mon->nama_pekerjaan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-dark">Nama Proyek *</label>
                        <input type="text" name="nama_proyek" id="create_nama_proyek" class="form-control" required
                            readonly placeholder="Otomatis terisi...">
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="small font-weight-bold text-dark">Tanggal Kontrak</label>
                            <input type="date" name="tanggal_kontrak" id="create_tgl_mulai" class="form-control"
                                readonly>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="small font-weight-bold text-dark">Selesai Kontrak</label>
                            <input type="date" name="tanggal_selesai_kontrak" id="create_tgl_selesai"
                                class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-secondary px-4 shadow-sm" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success px-4 shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.select2-search').select2({
                theme: 'bootstrap4',
                dropdownParent: $('#modalCreate')
            });
            @foreach ($proyeks as $p)
                $('#modalEdit{{ $p->id }}').on('shown.bs.modal', function() {
                    $(this).find('.select2-search').select2({
                        theme: 'bootstrap4',
                        dropdownParent: $(this)
                    });
                });
            @endforeach
            $('#create_no_kontrak').on('change', function() {
                const opt = this.options[this.selectedIndex];
                document.getElementById('create_nama_proyek').value = opt.getAttribute('data-nama') || '';
                document.getElementById('create_tgl_mulai').value = opt.getAttribute('data-tgl-mulai') ||
                    '';
                document.getElementById('create_tgl_selesai').value = opt.getAttribute(
                    'data-tgl-selesai') || '';
            });
            $('.edit-no-kontrak').on('change', function() {
                const id = this.getAttribute('data-id');
                const opt = this.options[this.selectedIndex];
                document.getElementById('edit_nama_proyek_' + id).value = opt.getAttribute('data-nama') ||
                    '';
                document.getElementById('edit_tgl_mulai_' + id).value = opt.getAttribute(
                    'data-tgl-mulai') || '';
                document.getElementById('edit_tgl_selesai_' + id).value = opt.getAttribute(
                    'data-tgl-selesai') || '';
            });
        });
    </script>
@endsection
