@extends('layouts.main')

@section('title', 'Pekerjaan MRO')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')
    <style>
        /* ==========================================================
               TEMA NAVY BLUE, MODERN & DYNAMIC STYLING
               ========================================================== */
        body {
            background-color: #f4f6f9;
        }

        /* Container Card Utama */
        .card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 0.5rem 1rem rgba(11, 37, 69, 0.08);
            background: #ffffff;
            transition: transform 0.3s ease;
        }

        /* Styling Tombol Utama (Buat Proyek Baru) */
        .btn-success {
            background-color: #1d3557;
            border-color: #1d3557;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(29, 53, 87, 0.15);
            white-space: nowrap;
        }

        .btn-success:hover {
            background-color: #0b2545;
            border-color: #0b2545;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(11, 37, 69, 0.25);
        }

        /* Search Bar Styling Modern */
        .search-wrapper {
            display: flex;
            background: #ffffff;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            width: 100%;
        }

        .search-wrapper:focus-within {
            border-color: #1d3557;
            box-shadow: 0 0 0 3px rgba(29, 53, 87, 0.15);
        }

        .search-input {
            flex: 1;
            border: none;
            padding: 10px 16px;
            outline: none;
            font-size: 14px;
            color: #334155;
            min-width: 0;
        }

        .search-btn {
            background-color: #1d3557;
            color: white;
            border: none;
            padding: 0 20px;
            font-weight: 500;
            transition: background 0.2s;
            white-space: nowrap;
        }

        .search-btn:hover {
            background-color: #0b2545;
        }

        /* List Item Proyek dengan Efek Bergerak (Hover & Transition) */
        .proyek-item-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-left: 5px solid #1d3557;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }

        .proyek-item-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 0.75rem 1.5rem rgba(11, 37, 69, 0.12);
            border-color: #cbd5e1;
            border-left-color: #457b9d;
        }

        /* Group Tombol Aksi agar Sejajar Sempurna */
        .action-group {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        /* Penyeragaman Ukuran & Padding Tombol Aksi */
        .action-group .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 34px;
            padding: 0 14px;
            font-size: 13px;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .btn-light.border:hover {
            background-color: #f1f5f9;
            color: #1d3557;
        }

        .btn-warning {
            background-color: #f4a261;
            border-color: #f4a261;
            color: #fff !important;
        }

        .btn-warning:hover {
            background-color: #e76f51;
            border-color: #e76f51;
        }

        .btn-danger:hover {
            background-color: #d90429;
        }

        /* Header Modal Bernuansa Navy */
        .modal-header {
            background-color: #0b2545 !important;
            color: #ffffff;
            border-bottom: none;
        }

        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 1rem rgba(11, 37, 69, 0.2);
        }

        /* Penyesuaian Tampilan Mobile / Layar HP */
        @media (max-width: 768px) {
            .proyek-item-card {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 12px;
                padding: 14px;
            }

            .action-group {
                width: 100%;
                justify-content: flex-end;
                border-top: 1px solid #f1f5f9;
                padding-top: 10px;
            }

            .search-wrapper {
                flex-direction: row;
                border-radius: 10px;
            }
        }
    </style>

    <div class="container-fluid px-2 px-md-4 py-3">
        <!-- HEADER ACTION BAR: TOMBOL BUAT & BARIS CARI DALAM SATU BARIS SEJAJAR -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center gap-3 mb-4">
            <!-- Tombol Buat Pekerjaan Baru -->
            <button class="btn btn-success px-4 py-2 shadow-sm" data-toggle="modal" data-target="#modalCreate">
                <i class="fa fa-plus mr-1"></i> Buat Pekerjaan MRO Baru
            </button>

            <!-- Baris Pencarian (Flex 1 agar Mengisi Sisa Ruang) -->
            <form method="GET" action="{{ route('pekerjaanmro.index') }}" class="flex-grow-1 ml-md-3 mb-0">
                <div class="search-wrapper">
                    <input type="text" name="search" class="search-input" autocomplete="off"
                        placeholder="Cari nama proyek / no kontrak..." value="{{ request('search') }}">
                    <button class="search-btn" type="submit">
                        <i class="fa fa-search mr-1"></i> Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- LIST PROYEK -->
        <div class="card p-3 p-md-4 shadow-sm">
            <h5 class="mb-3 font-weight-bold text-dark">Daftar Pekerjaan MRO</h5>

            @forelse ($proyeks as $p)
                <div class="proyek-item-card shadow-sm">
                    <div>
                        <h5 class="mb-1 text-dark"><strong>{{ $p->nama_proyek }}</strong></h5>
                        <small class="text-muted"><i class="fa fa-file-text-o mr-1"></i> No. Kontrak/SO/Nodin:
                            {{ $p->no_kontrak ?? '-' }}</small>
                    </div>

                    <!-- KELOMPOK TOMBOL AKSI YANG SUDAH DISEJAJARKAN -->
                    <div class="action-group">
                        <a href="{{ route('pekerjaanmro.monitor', $p->id) }}" class="btn btn-light border">
                            <i class="fa fa-desktop text-primary mr-1"></i> Monitor
                        </a>
                        <button type="button" class="btn btn-warning text-white" data-toggle="modal"
                            data-target="#modalEdit{{ $p->id }}">
                            <i class="fa fa-edit mr-1"></i> Edit
                        </button>
                        <form action="{{ route('pekerjaanmro.delete', $p->id) }}" method="POST" class="d-inline m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus pekerjaan ini?')">
                                <i class="fa fa-trash mr-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit{{ $p->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        {{-- PERBAIKAN: Menggunakan method POST agar sesuai dengan routes/web.php --}}
                        <form class="modal-content shadow" action="{{ route('pekerjaanmro.update', $p->id) }}"
                            method="POST">
                            @csrf
                            @method('POST')
                            <div class="modal-header px-4 py-3">
                                <h5 class="modal-title font-weight-bold">Edit Pekerjaan MRO</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-4">
                                @php
                                    $monitoringsListEdit = \App\Models\Monitoring::all();
                                @endphp
                                <div class="form-group mb-3">
                                    <label class="small font-weight-bold text-dark">No. Kontrak / SO / Nodin *</label>
                                    <select name="no_kontrak" class="form-control edit-no-kontrak"
                                        data-id="{{ $p->id }}" required>
                                        <option value="">-- Pilih No. Kontrak / SO / Nodin --</option>
                                        @foreach ($monitoringsListEdit as $mon)
                                            <option value="{{ $mon->po_nota_dinas }}"
                                                data-nama="{{ $mon->nama_pekerjaan }}"
                                                {{ $p->no_kontrak == $mon->po_nota_dinas ? 'selected' : '' }}>
                                                {{ $mon->po_nota_dinas }} - {{ $mon->nama_pekerjaan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="small font-weight-bold text-dark">Nama Proyek *</label>
                                    <input type="text" name="nama_proyek" id="edit_nama_proyek_{{ $p->id }}"
                                        value="{{ $p->nama_proyek }}" class="form-control" required readonly>
                                </div>
                            </div>
                            <div class="modal-footer bg-light px-4 py-3">
                                <button type="button" class="btn btn-secondary px-4 shadow-sm"
                                    data-dismiss="modal">Cancel</button>
                                <button class="btn btn-success px-4 shadow-sm"
                                    style="background-color: #1d3557; border-color: #1d3557;">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <i class="fa fa-folder-open-o fa-3x mb-3 text-secondary"></i>
                    <p class="mb-0">Belum ada data Pekerjaan MRO yang tersedia.</p>
                </div>
            @endforelse

            <div class="mt-3 d-flex justify-content-center">
                {{ $proyeks->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form class="modal-content shadow" action="{{ route('pekerjaanmro.store') }}" method="POST">
                @csrf
                <div class="modal-header px-4 py-3">
                    <h5 class="modal-title font-weight-bold">Buat Pekerjaan MRO Baru</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    @php
                        $monitoringsListCreate = \App\Models\Monitoring::all();
                    @endphp
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-dark">No. Kontrak / SO / Nodin *</label>
                        <select name="no_kontrak" id="create_no_kontrak" class="form-control" required>
                            <option value="">-- Pilih No. Kontrak / SO / Nodin --</option>
                            @foreach ($monitoringsListCreate as $mon)
                                <option value="{{ $mon->po_nota_dinas }}" data-nama="{{ $mon->nama_pekerjaan }}">
                                    {{ $mon->po_nota_dinas }} - {{ $mon->nama_pekerjaan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-dark">Nama Proyek *</label>
                        <input type="text" name="nama_proyek" id="create_nama_proyek" class="form-control" required
                            readonly placeholder="Otomatis terisi sesuai No. Kontrak...">
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-secondary px-4 shadow-sm" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success px-4 shadow-sm"
                        style="background-color: #1d3557; border-color: #1d3557;">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script untuk Auto Fill Nama Proyek Berdasarkan No Kontrak yang Dipilih --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Untuk Modal Create
            const createSelect = document.getElementById('create_no_kontrak');
            const createInput = document.getElementById('create_nama_proyek');

            if (createSelect) {
                createSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const namaPekerjaan = selectedOption.getAttribute('data-nama');
                    createInput.value = namaPekerjaan ? namaPekerjaan : '';
                });
            }

            // Untuk Modal Edit
            const editSelects = document.querySelectorAll('.edit-no-kontrak');
            editSelects.forEach(select => {
                select.addEventListener('change', function() {
                    const id = this.getAttribute('data-id');
                    const selectedOption = this.options[this.selectedIndex];
                    const namaPekerjaan = selectedOption.getAttribute('data-nama');
                    const inputNama = document.getElementById('edit_nama_proyek_' + id);
                    if (inputNama) {
                        inputNama.value = namaPekerjaan ? namaPekerjaan : '';
                    }
                });
            });
        });
    </script>
@endsection
