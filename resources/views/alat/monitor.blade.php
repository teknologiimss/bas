@extends('layouts.main')

@section('title', 'Data Alat Angkut')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        body {
            background: #f8f9fa;
        }

        /* WRAPPER HEADER (biar center) */
        .header-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* center horizontal */
            justify-content: center;
            margin-bottom: 20px;
        }

        /* PROJECT HEADER */
        .project-header {
            width: 100%;
            max-width: 600px;
            /* 🔥 biar tidak full */
            text-align: center;
            background: linear-gradient(135deg, #b30000, #ff1a1a);
            color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .project-title {
            font-size: 14px;
            opacity: 0.9;
        }

        .project-name {
            font-size: 22px;
            font-weight: bold;
        }

        .table-container {
            overflow: auto;
            max-height: 500px;
        }

        .table-monitoring th {
            position: sticky;
            top: 0;
            background: #b30000;
            color: white;
            z-index: 2;
        }

        .table-monitoring td:first-child {
            position: sticky;
            left: 0;
            background: #fff;
            z-index: 3;
        }

        .sticky-top-section {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: #f8f9fa;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            /* jarak antar tombol */
            flex-wrap: wrap;
            /* kalau sempit tetap rapi */
        }

        /* samakan tinggi tombol */
        .action-buttons .btn {
            min-width: 40px;
        }

        /* BUTTON */
        .btn-success {
            background: linear-gradient(135deg, #ff1a1a, #cc0000);
            border: none;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(255, 0, 0, 0.4);
        }



        .summary-card {
            border-radius: 14px;
            transition: all 0.25s ease;
            background: #ffffff;
            border: 1px solid #fe0000;
            position: relative;
            overflow: hidden;
        }

        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .summary-title {
            font-size: 15px;
            font-weight: 600;
        }

        .summary-section {
            background: #f8f1f1;
            border-radius: 10px;
            padding: 8px 10px;
            margin-bottom: 8px;
        }

        .badge-soft-danger {
            background: #ffe5e5;
            color: #cc0000;
            font-weight: 600;
        }

        .badge-soft-success {
            background: #e6fff0;
            color: #00994d;
            font-weight: 600;
        }

        .scroll-area {
            max-height: 140px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .scroll-area::-webkit-scrollbar {
            width: 5px;
        }

        .scroll-area::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        .summary-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .unit-icon {
            font-size: 18px;
        }


        .summary-card {
            animation: fadeInUp 0.4s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }




        /* =========================================
       RESPONSIVE MOBILE
    ========================================= */

        .mobile-filter-toggle {
            display: none;
        }

        @media (max-width: 768px) {

            body {
                overflow-x: hidden;
            }

            .container-fluid,
            .content-wrapper,
            .content {
                padding-left: 6px !important;
                padding-right: 6px !important;
            }

            /* HEADER */
            .project-header {
                width: 100%;
                max-width: 100%;
                padding: 14px;
                border-radius: 10px;
            }

            .project-title {
                font-size: 11px !important;
            }

            .project-name {
                font-size: 16px !important;
                line-height: 1.4;
            }

            /* BUTTON */
            .btn,
            .btn-success,
            .btn-danger,
            .btn-warning,
            .btn-primary,
            .btn-secondary,
            .btn-info {
                height: 34px !important;
                min-height: 34px !important;
                padding: 0 10px !important;
                font-size: 11px !important;
                border-radius: 8px !important;

                display: inline-flex;
                align-items: center;
                justify-content: center;

                white-space: nowrap;
            }

            /* TOGGLE FILTER */
            .mobile-filter-toggle {
                display: block;
                width: 100%;
                margin-top: 10px;
                margin-bottom: 10px;
            }

            /* FILTER AREA */
            #filterArea {
                display: none;
                animation: fadeFilter .3s ease;
            }

            #filterArea.show {
                display: block;
            }

            @keyframes fadeFilter {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* FILTER */
            #filterArea .col-md-3,
            #filterArea .col-md-12 {
                width: 100%;
                max-width: 100%;
                flex: 100%;
            }

            #filterArea label {
                font-size: 11px;
                margin-bottom: 4px;
            }

            .form-control {
                height: 36px !important;
                font-size: 12px !important;
                border-radius: 8px !important;
            }

            /* SUMMARY CARD */
            .summary-card {
                padding: 12px !important;
            }

            .summary-title {
                font-size: 13px;
            }

            .summary-section {
                padding: 6px 8px;
            }

            .scroll-area {
                max-height: 120px;
            }

            /* TABLE */
            .table-container {
                overflow-x: auto;
                overflow-y: auto;
                max-height: 72vh;
                border-radius: 10px;
                position: relative;
            }

            .table-monitoring {
                min-width: 1500px;
                font-size: 10px !important;
                border-collapse: separate !important;
            }

            .table-monitoring th,
            .table-monitoring td {
                padding: 5px !important;
                font-size: 10px !important;
                white-space: nowrap;
            }

            /* STICKY HEADER */
            .table-monitoring thead th {
                position: sticky;
                top: 0;
                z-index: 500;
                background: #b30000 !important;
                color: white;
            }

            /* STICKY FIRST COLUMN */
            .table-monitoring th:first-child {
                position: sticky;
                left: 0;
                z-index: 700 !important;
                background: #b30000 !important;
                min-width: 50px;
            }

            .table-monitoring td:first-child {
                position: sticky;
                left: 0;
                z-index: 600;
                background: #fff !important;
                min-width: 50px;
            }

            /* ACTION BUTTON */
            .action-buttons {
                display: flex;
                gap: 4px;
                flex-wrap: nowrap;
            }

            .action-buttons .btn {
                width: 32px !important;
                height: 32px !important;
                padding: 0 !important;
            }

            /* MODAL */
            .modal-dialog {
                margin: 8px;
                max-width: calc(100% - 16px);
            }

            .modal-content {
                border-radius: 12px;
            }

            .modal-body .col-md-4,
            .modal-body .col-md-6 {
                width: 100%;
                max-width: 100%;
                flex: 100%;
            }

            .modal-body label {
                font-size: 12px;
            }

            .modal-footer .btn {
                flex: 1;
            }

            /* DELETE BUTTON */
            #btnDeleteSelected {
                width: 100%;
            }
        }
    </style>

    <div class="sticky-top-section">

        <div class="header-wrapper">

            <div class="project-header">
                <div class="project-title">
                    Data Alat Angkut
                </div>
                <div class="project-name">
                    {{ $proyek->nama_proyek }}
                </div>
            </div>

            <button class="btn btn-success mt-3 px-4 py-2" data-toggle="modal" data-target="#modalTambah">
                ➕ Tambah Data
            </button>

        </div>


        {{-- FILTER --}}
        {{-- BUTTON TOGGLE FILTER MOBILE --}}
        <button type="button" class="btn btn-dark mobile-filter-toggle" id="toggleFilter">
            🔍 Tampilkan / Sembunyikan Filter
        </button>
        <div class="card mt-3 p-3" id="filterArea">

            <form method="GET">
                <div class="row">

                    <div class="col-md-3">
                        <label>Unit</label>
                        <input type="text" name="unit" value="{{ request('unit') }}" class="form-control"
                            autocomplete="off">
                    </div>

                    <div class="col-md-3">
                        <label>No Lambung</label>
                        <input type="text" name="no_lambung" value="{{ request('no_lambung') }}" class="form-control"
                            autocomplete="off">
                    </div>

                    <div class="col-md-3">
                        <label>No Kontrak</label>
                        <input type="text" name="no_kontrak" value="{{ request('no_kontrak') }}" class="form-control"
                            autocomplete="off">
                    </div>

                    <div class="col-md-3">
                        <label>Aset</label>
                        <input type="text" name="aset" value="{{ request('aset') }}" class="form-control"
                            autocomplete="off">
                    </div>

                    <div class="col-md-12 mt-3">
                        <button class="btn btn-primary btn-sm">🔍 Filter</button>
                        <a href="{{ url()->current() }}" class="btn btn-secondary btn-sm">Reset</a>
                    </div>

                </div>
            </form>

        </div>
        <button id="btnDeleteSelected" class="btn btn-danger btn-sm mt-2">
            🗑️ Hapus Data Dipilih/centang
        </button>

    </div>

    <div class="card mt-3 p-3">
        <h5 class="mb-3 fw-bold">📊 Ringkasan Data Alat Angkut</h5>

        <div class="row">
            @forelse($summary as $unit => $data)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-3">

                    <div class="summary-card p-3 h-100">

                        {{-- HEADER --}}
                        <div class="summary-header mb-2">
                            <div class="summary-title">
                                🚛 {{ $unit }}
                            </div>
                            <span class="badge bg-primary">
                                {{ $data['total'] }}
                            </span>
                        </div>

                        {{-- 🔴 IMSS --}}
                        <div class="summary-section">
                            <div class="fw-bold text-danger mb-1">
                                🔴 IMSS ({{ $data['imss']['total'] }})
                            </div>

                            <div style="font-size: 13px;">
                                📍
                                {{ count($data['imss']['lokasi']) ? implode(', ', $data['imss']['lokasi']->toArray()) : '-' }}
                            </div>

                            <div style="font-size: 13px;">
                                🏷️
                                {{ count($data['imss']['no_lambung']) ? implode(', ', $data['imss']['no_lambung']->toArray()) : '-' }}
                            </div>
                        </div>

                        {{-- 🟢 NON --}}
                        <div class="summary-section">
                            <div class="fw-bold text-success mb-1">
                                🟢 Non IMSS ({{ $data['non']['total'] }})
                            </div>

                            <div style="font-size: 13px;">
                                📍
                                {{ count($data['non']['lokasi']) ? implode(', ', $data['non']['lokasi']->toArray()) : '-' }}
                            </div>

                            <div style="font-size: 13px;">
                                🏷️
                                {{ count($data['non']['no_lambung']) ? implode(', ', $data['non']['no_lambung']->toArray()) : '-' }}
                            </div>
                        </div>

                        {{-- 📍 DETAIL LOKASI --}}
                        <div>
                            <div class="fw-bold mb-1">📍 Detail Lokasi</div>

                            <div class="scroll-area" style="font-size: 12px;">
                                @foreach ($data['lokasi_map'] as $lok => $lambungs)
                                    <div class="d-flex justify-content-between border-bottom py-1">
                                        <span>{{ $lok ?: '-' }}</span>
                                        <span class="text-muted">
                                            {{ count($lambungs) ? implode(', ', $lambungs->toArray()) : '-' }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    Tidak ada data
                </div>
            @endforelse
        </div>
    </div>

    <div class="card mt-3 p-3">

        <div class="table-container">
            <table class="table table-bordered table-monitoring text-center">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="checkAll">
                        </th>
                        <th>No</th>
                        <th>Unit</th>
                        <th>No Lambung</th>
                        <th>Kapasitas</th>
                        <th>Lokasi</th>
                        <th>No Kontrak</th>
                        <th>Aset</th>
                        <th>Model/SN</th>
                        <th>Tanggal Kontrak</th>
                        <th>Selesai Kontrak</th>
                        <th>Kontrak Dengan</th>
                        <th>Tahun Kedatangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($detail as $d)
                        <tr>
                            <td>
                                <input type="checkbox" class="checkItem" value="{{ $d->id }}">
                            </td>
                            <td>{{ $loop->iteration }}</td>
                            <td><b>{{ $d->unit }}</b></td>
                            <td>{{ $d->no_lambung }}</td>
                            <td>{{ $d->kapasitas }}</td>
                            <td>{{ $d->lokasi }}</td>
                            <td>{{ $d->no_kontrak }}</td>
                            {{-- <td>{{ $d->aset }}</td> --}}
                            <td>
                                @if (str_contains(strtoupper($d->aset), 'IMSS'))
                                    <span class="badge bg-danger">🔴 {{ $d->aset }}</span>
                                @else
                                    <span class="badge bg-success">🟢 {{ $d->aset }}</span>
                                @endif
                            </td>
                            <td>{{ $d->model_sn }}</td>
                            {{-- <td>{{ $d->tgl_kontrak }}</td> --}}
                            <td>
                                {{ $d->tgl_kontrak ? \Carbon\Carbon::parse($d->tgl_kontrak)->format('d/m/Y') : '-' }}
                            </td>
                            {{-- <td>{{ $d->tgl_habis }}</td> --}}
                            <td>
                                {{ $d->tgl_habis ? \Carbon\Carbon::parse($d->tgl_habis)->format('d/m/Y') : '-' }}
                            </td>
                            <td>{{ $d->kontrak_dgn }}</td>
                            <td>{{ $d->thn_kedatangan }}</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#edit{{ $d->id }}">✏️</button>

                                    <a href="{{ route('alat.detail.monitor', $d->id) }}" class="btn btn-info btn-sm">
                                        📋
                                    </a>

                                    <button class="btn btn-danger btn-sm btn-delete"
                                        data-id="{{ $d->id }}">🗑️</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

    </div>


    {{-- MODAL TAMBAH --}}
    <div class="modal fade" id="modalTambah">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ route('alat.detail.store') }}">
                @csrf
                <input type="hidden" name="alat_id" value="{{ $proyek->id }}">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Tambah Data Alat Angkut</h5>
                    </div>

                    <div class="modal-body row">

                        <div class="col-md-4 mb-2">
                            <label>Unit</label>
                            <input name="unit" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>No Lambung</label>
                            <input name="no_lambung" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Kapasitas</label>
                            <input name="kapasitas" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Lokasi</label>
                            <input name="lokasi" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>No Kontrak</label>
                            <input name="no_kontrak" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Aset</label>
                            <input name="aset" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Model / Serial Number</label>
                            <input name="model_sn" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Tanggal Kontrak</label>
                            <input type="date" name="tgl_kontrak" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Tanggal Habis Kontrak</label>
                            <input type="date" name="tgl_habis" class="form-control">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Kontrak Dengan</label>
                            <input name="kontrak_dgn" class="form-control" autocomplete="off">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Tahun Kedatangan</label>
                            <input name="thn_kedatangan" class="form-control" autocomplete="off">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success">Simpan</button>
                        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    @foreach ($detail as $d)
        <div class="modal fade" id="edit{{ $d->id }}">
            <div class="modal-dialog modal-lg">
                <form method="POST" action="{{ route('alat.detail.update', $d->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Edit Data</h5>
                        </div>

                        <div class="modal-body row">

                            <div class="col-md-4 mb-2">
                                <label>Unit</label>
                                <input name="unit" value="{{ $d->unit }}" class="form-control"
                                    autocomplete="off">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>No Lambung</label>
                                <input name="no_lambung" value="{{ $d->no_lambung }}" class="form-control"
                                    autocomplete="off">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Kapasitas</label>
                                <input name="kapasitas" value="{{ $d->kapasitas }}" class="form-control"
                                    autocomplete="off">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Lokasi</label>
                                <input name="lokasi" value="{{ $d->lokasi }}" class="form-control"
                                    autocomplete="off">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>No Kontrak</label>
                                <input name="no_kontrak" value="{{ $d->no_kontrak }}" class="form-control"
                                    autocomplete="off">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Aset</label>
                                <input name="aset" value="{{ $d->aset }}" class="form-control"
                                    autocomplete="off">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Model / Serial Number</label>
                                <input name="model_sn" value="{{ $d->model_sn }}" class="form-control"
                                    autocomplete="off">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Tanggal Kontrak</label>
                                <input type="date" name="tgl_kontrak" value="{{ $d->tgl_kontrak }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Tanggal Habis Kontrak</label>
                                <input type="date" name="tgl_habis" value="{{ $d->tgl_habis }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Kontrak Dengan</label>
                                <input name="kontrak_dgn" value="{{ $d->kontrak_dgn }}" class="form-control"
                                    autocomplete="off">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Tahun Kedatangan</label>
                                <input name="thn_kedatangan" value="{{ $d->thn_kedatangan }}" class="form-control"
                                    autocomplete="off">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success">Update</button>
                            <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <form id="deleteForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <form id="bulkDeleteForm" method="POST" action="{{ route('alat.detail.bulkDelete') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="ids" id="bulkIds">
    </form>

@endsection

@section('custom-js')
    <script>
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                let id = this.dataset.id;
                if (confirm('Hapus data?')) {
                    let form = document.getElementById('deleteForm');
                    let url = "{{ route('alat.detail.delete', ':id') }}";
                    form.action = url.replace(':id', id);
                    form.submit();
                }
            });
        });
    </script>

    <script>
        // CHECK ALL
        document.getElementById('checkAll').addEventListener('click', function() {
            document.querySelectorAll('.checkItem').forEach(cb => {
                cb.checked = this.checked;
            });
        });

        // DELETE SELECTED
        document.getElementById('btnDeleteSelected').addEventListener('click', function() {

            let ids = [];
            document.querySelectorAll('.checkItem:checked').forEach(cb => {
                ids.push(cb.value);
            });

            if (ids.length === 0) {
                alert('Pilih data dulu!');
                return;
            }

            if (confirm('Hapus data terpilih?')) {
                document.getElementById('bulkIds').value = ids.join(',');
                document.getElementById('bulkDeleteForm').submit();
            }
        });
    </script>

    <script>
        // TOGGLE FILTER MOBILE
        const toggleBtn = document.getElementById('toggleFilter');
        const filterArea = document.getElementById('filterArea');

        toggleBtn.addEventListener('click', function() {
            filterArea.classList.toggle('show');
        });

        // AUTO HIDE FILTER SAAT MOBILE
        if (window.innerWidth > 768) {
            filterArea.classList.add('show');
        }
    </script>
@endsection
