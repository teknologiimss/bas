@extends('layouts.main')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')
    <style>
        :root {
            --navy-dark: #0f172a;
            --navy-main: #1e293b;
            --navy-light: #334155;
            --accent-blue: #2563eb;
            --accent-hover: #1d4ed8;
        }

        /* Custom Theme & Global Tweaks */
        .bg-navy-main {
            background-color: var(--navy-main) !important;
        }

        .text-navy-dark {
            color: var(--navy-dark) !important;
        }

        .card-modern {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        /* Badge Styling */
        .badge-soft-success {
            background-color: #dcfce7;
            color: #15803d;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .badge-soft-warning {
            background-color: #fef9c3;
            color: #a16207;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .badge-soft-danger {
            background-color: #fee2e2;
            color: #b91c1c;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .badge-soft-navy {
            background-color: #e2e8f0;
            color: #1e293b;
            font-weight: 600;
            font-size: 1rem;
        }

        /* Custom Table Style */
        .table-modern thead th {
            background-color: var(--navy-main);
            color: #f8fafc;
            border: none;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
            padding: 16px 14px;
        }

        .table-modern tbody td {
            vertical-align: middle !important;
            border-color: #f1f5f9;
            font-size: 1.05rem;
            padding: 14px 12px;
        }

        .btn-action {
            width: 38px;
            height: 38px;
            padding: 0;
            font-size: 1rem;
            line-height: 38px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }

        /* Styling Drag Handle */
        .drag-handle {
            cursor: grab;
            color: #94a3b8;
            transition: color 0.2s;
        }

        .drag-handle:hover {
            color: #1e293b;
        }

        .drag-handle:active {
            cursor: grabbing;
        }

        .sortable-ghost {
            background-color: #e2e8f0 !important;
            opacity: 0.6;
        }

        /* Form & Input Styling */
        .form-control,
        .custom-select {
            font-size: 1rem !important;
            height: auto;
            padding: 10px 14px;
        }

        label,
        .form-group label {
            font-size: 1rem !important;
        }

        .form-control:focus,
        .custom-select:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.15);
        }

        .modal-title {
            font-size: 1.25rem;
        }

        .modal-body table th,
        .modal-body table td {
            font-size: 1.05rem;
            padding: 10px 8px;
        }

        @media (max-width: 767.98px) {
            .page-header-title {
                font-size: 1.5rem !important;
            }

            .table-modern thead th {
                font-size: 0.88rem;
            }

            .table-modern tbody td {
                font-size: 0.98rem;
            }
        }
    </style>

    <div class="container-fluid p-2 p-md-4">

        {{-- Toast Alert Notifikasi Reorder JS --}}
        <div id="reorderAlert" class="alert alert-success border-0 shadow-sm rounded-lg mb-3 font-weight-bold"
            style="display: none; font-size: 1.05rem;" role="alert">
            <i class="fas fa-check-circle mr-2"></i> Urutan posisi item berhasil diperbarui!
        </div>

        {{-- Alert Notification PHP --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-lg mb-3 font-weight-bold"
                style="font-size: 1.05rem;" role="alert">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Header Bar --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
            <div>
                <h3 class="font-weight-bold text-navy-dark page-header-title m-0" style="font-size: 1.75rem;">
                    <i class="fas fa-tools mr-2 text-primary"></i>Data Tools MRO
                </h3>
                <span class="text-muted" style="font-size: 1.05rem;">Kelola inventaris dan ketersediaan peralatan MRO</span>
            </div>

            {{-- <div class="mt-3 mt-md-0">
                <button type="button"
                    class="btn btn-primary shadow-sm font-weight-bold px-4 py-2.5 rounded-lg w-100 w-md-auto"
                    data-toggle="modal" data-target="#modalTambah"
                    style="background-color: var(--accent-blue); border: none; font-size: 1.05rem;">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Tools
                </button>
            </div> --}}
            <div class="mt-3 mt-md-0">
                <a href="{{ route('mro.mutations.index') }}"
                    class="btn btn-outline-primary font-weight-bold px-3 py-2.5 rounded-lg mr-2">
                    <i class="fas fa-exchange-alt mr-1"></i> Mutasi / Peminjaman
                </a>
                <button type="button"
                    class="btn btn-primary shadow-sm font-weight-bold px-4 py-2.5 rounded-lg w-100 w-md-auto"
                    data-toggle="modal" data-target="#modalTambah"
                    style="background-color: var(--accent-blue); border: none; font-size: 1.05rem;">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Tools
                </button>
            </div>
        </div>

        {{-- Main Card Wrapper --}}
        <div class="card card-modern shadow-sm">

            {{-- Card Controls (Search, Filter Jenis, & Sort Bar) --}}
            <div class="card-header bg-navy-main p-3 border-0">
                <form action="{{ route('mro.tools.index') }}" method="GET" id="filterForm">
                    <div class="row align-items-center gy-2">

                        {{-- Search Input --}}
                        <div class="col-12 col-md-5 col-lg-4 mb-2 mb-md-0">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control border-0 rounded-left"
                                    placeholder="Cari nama tools, jenis, lokasi, spesifikasi..."
                                    value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary px-3 rounded-right" type="submit"
                                        style="background-color: var(--accent-blue); border: none;">
                                        <i class="fas fa-search" style="font-size: 1.1rem;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Filter & Sort Options --}}
                        <div
                            class="col-12 col-md-7 col-lg-8 d-flex flex-column flex-md-row justify-content-md-end align-items-md-center gap-2">

                            {{-- Filter Jenis --}}
                            <div class="d-flex align-items-center mb-2 mb-md-0 mr-md-2">
                                <label class="text-white mr-2 mb-0 font-weight-bold text-nowrap"
                                    style="font-size: 0.95rem;">
                                    <i class="fas fa-filter mr-1"></i>Jenis:
                                </label>
                                <select name="jenis" class="form-control rounded-lg border-0 bg-white"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">-- Semua Jenis --</option>
                                    @foreach ($listJenis as $j)
                                        <option value="{{ $j }}" {{ request('jenis') == $j ? 'selected' : '' }}>
                                            {{ $j }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Sort Select --}}
                            <div class="d-flex align-items-center mb-2 mb-md-0">
                                <label class="text-white mr-2 mb-0 font-weight-bold text-nowrap"
                                    style="font-size: 0.95rem;">
                                    <i class="fas fa-sort mr-1"></i>Sort:
                                </label>
                                <select name="sort" class="form-control rounded-lg border-0 bg-white"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">Default (Posisi)</option>
                                    <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama (A -
                                        Z)</option>
                                    <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama (Z
                                        - A)</option>
                                    <option value="qty_asc" {{ request('sort') == 'qty_asc' ? 'selected' : '' }}>QTY
                                        Terkecil</option>
                                    <option value="qty_desc" {{ request('sort') == 'qty_desc' ? 'selected' : '' }}>QTY
                                        Terbanyak</option>
                                </select>
                            </div>

                            {{-- Tombol Reset jika sedang melakukan filter --}}
                            @if (request('search') || request('jenis') || request('sort'))
                                <a href="{{ route('mro.tools.index') }}"
                                    class="btn btn-sm btn-light font-weight-bold ml-md-2" title="Reset Filter">
                                    <i class="fas fa-undo mr-1"></i> Reset
                                </a>
                            @endif

                        </div>

                    </div>
                </form>
            </div>

            {{-- Table Section --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-modern w-100 m-0">
                        <thead>
                            <tr>
                                <th class="text-center" width="3%"><i class="fas fa-arrows-alt-v"></i></th>
                                <th class="text-center" width="5%">NO.</th>
                                <th>NAMA TOOLS</th>
                                <th>SPESIFIKASI</th>
                                <th class="text-center">QTY</th>
                                <th class="text-center">SATUAN</th>
                                <th class="text-center">KONDISI</th>
                                <th>LOKASI</th> {{-- Kolom Lokasi ditambahkan di sebelah kanan Kondisi --}}
                                <th>JENIS</th>
                                <th>KETERANGAN</th>
                                <th class="text-center" width="12%">AKSI</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-table">
                            @forelse($tools as $index => $tool)
                                <tr data-id="{{ $tool->id }}">
                                    <td class="text-center align-middle">
                                        <i class="fas fa-grip-vertical drag-handle"
                                            title="Tahan dan geser untuk mengubah posisi"></i>
                                    </td>
                                    <td class="text-center text-muted font-weight-bold row-number">
                                        {{ $tools->firstItem() + $index }}
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)"
                                            class="font-weight-bold text-primary btn-show-detail text-decoration-none"
                                            data-id="{{ $tool->id }}" data-nama="{{ $tool->nama_tools }}"
                                            data-spesifikasi="{{ $tool->spesifikasi ?? '-' }}"
                                            data-qty="{{ $tool->qty }}" data-satuan="{{ $tool->satuan }}"
                                            data-kondisi="{{ $tool->kondisi }}" data-lokasi="{{ $tool->lokasi ?? '-' }}"
                                            data-jenis="{{ $tool->jenis ?? '-' }}"
                                            data-keterangan="{{ $tool->keterangan ?? '-' }}"
                                            data-gambar="{{ $tool->gambar ? asset('storage/' . $tool->gambar) : '' }}">
                                            {{ $tool->nama_tools }}
                                        </a>
                                    </td>
                                    <td><span class="text-dark">{{ $tool->spesifikasi ?? '-' }}</span></td>
                                    <td class="text-center">
                                        <span class="badge badge-soft-navy px-3 py-1.5 rounded-pill">
                                            {{ $tool->qty }}
                                        </span>
                                    </td>
                                    <td class="text-center text-dark">{{ $tool->satuan }}</td>
                                    <td class="text-center">
                                        @if ($tool->kondisi == 'Baik')
                                            <span class="badge badge-soft-success px-3 py-1.5 rounded-pill">Baik</span>
                                        @elseif($tool->kondisi == 'Rusak')
                                            <span class="badge badge-soft-warning px-3 py-1.5 rounded-pill">Rusak</span>
                                        @else
                                            <span class="badge badge-soft-danger px-3 py-1.5 rounded-pill">Scrap</span>
                                        @endif
                                    </td>
                                    <td><span class="text-dark font-weight-bold">{{ $tool->lokasi ?? '-' }}</span></td>
                                    {{-- Tampilan Lokasi --}}
                                    <td><span class="badge badge-light border text-dark p-2"
                                            style="font-size: 0.95rem;">{{ $tool->jenis ?? '-' }}</span></td>
                                    <td><span class="text-dark">{{ Str::limit($tool->keterangan ?? '-', 35) }}</span></td>
                                    <td class="text-center text-nowrap">
                                        <button type="button"
                                            class="btn btn-action btn-soft-info text-info bg-light mr-1 btn-show-detail"
                                            data-id="{{ $tool->id }}" data-nama="{{ $tool->nama_tools }}"
                                            data-spesifikasi="{{ $tool->spesifikasi ?? '-' }}"
                                            data-qty="{{ $tool->qty }}" data-satuan="{{ $tool->satuan }}"
                                            data-kondisi="{{ $tool->kondisi }}" data-lokasi="{{ $tool->lokasi ?? '-' }}"
                                            data-jenis="{{ $tool->jenis ?? '-' }}"
                                            data-keterangan="{{ $tool->keterangan ?? '-' }}"
                                            data-gambar="{{ $tool->gambar ? asset('storage/' . $tool->gambar) : '' }}"
                                            title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button type="button"
                                            class="btn btn-action btn-soft-warning text-warning bg-light mr-1"
                                            data-toggle="modal" data-target="#modalEdit{{ $tool->id }}"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <form action="{{ route('mro.tools.destroy', $tool->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-action btn-soft-danger text-danger bg-light"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="modalEdit{{ $tool->id }}" tabindex="-1" role="dialog"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content border-0 shadow-lg rounded-lg">
                                            <div class="modal-header bg-navy-main text-white">
                                                <h5 class="modal-title font-weight-bold"><i
                                                        class="fas fa-edit mr-2"></i>Edit Data Tools</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('mro.tools.update', $tool->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body p-4">
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                            <label class="font-weight-bold">Nama Tools <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" autocomplete="off" name="nama_tools"
                                                                class="form-control rounded-lg"
                                                                value="{{ $tool->nama_tools }}" required>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label class="font-weight-bold">Jenis</label>
                                                            <input type="text" autocomplete="off" name="jenis"
                                                                class="form-control rounded-lg"
                                                                value="{{ $tool->jenis }}">
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="font-weight-bold">Qty <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="number" name="qty"
                                                                class="form-control rounded-lg"
                                                                value="{{ $tool->qty }}" required min="0">
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="font-weight-bold">Satuan <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" autocomplete="off" name="satuan"
                                                                class="form-control rounded-lg"
                                                                value="{{ $tool->satuan }}" required>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="font-weight-bold">Kondisi <span
                                                                    class="text-danger">*</span></label>
                                                            <select name="kondisi" class="form-control rounded-lg"
                                                                required>
                                                                <option value="Baik"
                                                                    {{ $tool->kondisi == 'Baik' ? 'selected' : '' }}>Baik
                                                                </option>
                                                                <option value="Rusak"
                                                                    {{ $tool->kondisi == 'Rusak' ? 'selected' : '' }}>Rusak
                                                                </option>
                                                                <option value="Scrap"
                                                                    {{ $tool->kondisi == 'Scrap' ? 'selected' : '' }}>Scrap
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="font-weight-bold">Lokasi</label>
                                                            <input type="text" autocomplete="off" name="lokasi"
                                                                class="form-control rounded-lg"
                                                                value="{{ $tool->lokasi }}"
                                                                placeholder="Contoh: Rak A-1">
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            <label class="font-weight-bold">Spesifikasi</label>
                                                            <textarea name="spesifikasi" autocomplete="off" class="form-control rounded-lg" rows="2">{{ $tool->spesifikasi }}</textarea>
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            <label class="font-weight-bold">Keterangan</label>
                                                            <textarea name="keterangan" autocomplete="off" class="form-control rounded-lg" rows="2">{{ $tool->keterangan }}</textarea>
                                                        </div>
                                                        <div class="col-md-12 form-group mb-0">
                                                            <label class="font-weight-bold">Upload Gambar Tools
                                                                Baru</label>
                                                            <input type="file" name="gambar"
                                                                class="form-control-file" accept="image/*"
                                                                style="font-size: 1rem;">
                                                            @if ($tool->gambar)
                                                                <small class="text-muted d-block mt-2"
                                                                    style="font-size: 0.95rem;">
                                                                    <i class="fas fa-image mr-1"></i> Gambar saat ini:
                                                                    <strong>{{ basename($tool->gambar) }}</strong>
                                                                </small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-secondary rounded-lg px-4 py-2"
                                                        style="font-size: 1rem;" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary rounded-lg px-4 py-2"
                                                        style="background-color: var(--accent-blue); font-size: 1rem;">Simpan
                                                        Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center text-muted py-5" style="font-size: 1.1rem;">
                                        <i class="fas fa-box-open fa-3x mb-3 text-secondary d-block"></i>
                                        Tidak ada data tools yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Link Pagination --}}
            @if ($tools->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-end">
                        {{ $tools->links() }}
                    </div>
                </div>
            @endif

        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg rounded-lg">
                <div class="modal-header bg-navy-main text-white">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle mr-2"></i>Tambah Data Tools MRO
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('mro.tools.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Nama Tools <span class="text-danger">*</span></label>
                                <input type="text" autocomplete="off" name="nama_tools"
                                    class="form-control rounded-lg" placeholder="Contoh: Impact Dewalt" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Jenis</label>
                                <input type="text" autocomplete="off" name="jenis" class="form-control rounded-lg"
                                    placeholder="Contoh: Power Tools / Hand Tools">
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="font-weight-bold">Qty <span class="text-danger">*</span></label>
                                <input type="number" name="qty" class="form-control rounded-lg" value="1"
                                    required min="0">
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="font-weight-bold">Satuan <span class="text-danger">*</span></label>
                                <input type="text" autocomplete="off" name="satuan" class="form-control rounded-lg"
                                    value="unit" placeholder="unit / pcs" required>
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="font-weight-bold">Kondisi <span class="text-danger">*</span></label>
                                <select name="kondisi" class="form-control rounded-lg" required>
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak">Rusak</option>
                                    <option value="Scrap">Scrap</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="font-weight-bold">Lokasi</label>
                                <input type="text" autocomplete="off" name="lokasi" class="form-control rounded-lg"
                                    placeholder="Contoh: Palembang / Rak A-1">
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="font-weight-bold">Spesifikasi</label>
                                <textarea name="spesifikasi" autocomplete="off" class="form-control rounded-lg" rows="2"
                                    placeholder="Masukkan spesifikasi rinci..."></textarea>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="font-weight-bold">Keterangan</label>
                                <textarea name="keterangan" autocomplete="off" class="form-control rounded-lg" rows="2"
                                    placeholder="Contoh: Untuk unloading"></textarea>
                            </div>
                            <div class="col-md-12 form-group mb-0">
                                <label class="font-weight-bold">Upload Gambar Tools</label>
                                <input type="file" name="gambar" class="form-control-file" accept="image/*"
                                    style="font-size: 1rem;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary rounded-lg px-4 py-2" style="font-size: 1rem;"
                            data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-lg px-4 py-2"
                            style="background-color: var(--accent-blue); font-size: 1rem;">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail Tools Global -->
    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg rounded-lg overflow-hidden">
                <div class="modal-header bg-navy-main text-white">
                    <h5 class="modal-title font-weight-bold" id="detailNamaTools">Detail Tools</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4 bg-light p-3 rounded-lg border">
                        <img id="detailGambar" src="" class="img-fluid rounded shadow-sm"
                            style="max-height: 250px; object-fit: contain; display: none;" alt="Gambar Tools">
                        <p id="noGambarText" class="text-muted font-italic mb-0" style="display: none; font-size: 1rem;">
                            <i class="fas fa-image-slash mr-1"></i> Tidak ada gambar tools.
                        </p>
                    </div>
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr class="border-bottom">
                                <th width="35%" class="text-muted">Jenis</th>
                                <td id="detailJenis" class="font-weight-bold text-dark"></td>
                            </tr>
                            <tr class="border-bottom">
                                <th class="text-muted">Spesifikasi</th>
                                <td id="detailSpesifikasi" class="text-dark"></td>
                            </tr>
                            <tr class="border-bottom">
                                <th class="text-muted">Jumlah Stok</th>
                                <td id="detailQtySatuan" class="font-weight-bold text-dark"></td>
                            </tr>
                            <tr class="border-bottom">
                                <th class="text-muted">Kondisi</th>
                                <td id="detailKondisi"></td>
                            </tr>
                            <tr class="border-bottom">
                                <th class="text-muted">Lokasi</th>
                                <td id="detailLokasi" class="font-weight-bold text-dark"></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Keterangan</th>
                                <td id="detailKeterangan" class="text-dark"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-lg px-4 py-2" style="font-size: 1rem;"
                        data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- CDN Pustaka SortableJS untuk Drag & Drop Baris Tabel -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
    $(document).ready(function() {

        // ==========================================
        // 1. Notifikasi Laravel / Blade Hilang 3 Detik
        // ==========================================
        setTimeout(function() {
            $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);

        // ==========================================
        // 2. Inisialisasi Fitur Drag & Drop Reorder
        // ==========================================
        var el = document.getElementById('sortable-table');
        if (el) {
            var sortable = Sortable.create(el, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'sortable-ghost',
                onEnd: function(evt) {
                    var order = [];
                    var startNumber = {{ $tools->firstItem() ?? 1 }};

                    $('#sortable-table tr').each(function(index) {
                        var id = $(this).data('id');
                        if (id) {
                            order.push({
                                id: id,
                                position: startNumber + index
                            });
                            $(this).find('.row-number').text(startNumber + index);
                        }
                    });

                    $.ajax({
                        url: "{{ route('mro.tools.reorder') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            order: order
                        },
                        success: function(response) {
                            $('#reorderAlert')
                                .text(response.message)
                                .stop(true, true)
                                .fadeIn()
                                .delay(3000)
                                .fadeOut();
                        },
                        error: function(xhr) {
                            alert('Gagal menyimpan urutan baru!');
                        }
                    });
                }
            });
        }

        // ==========================================
        // 3. Event Handler Modal Detail
        // ==========================================
        $(document).on('click', '.btn-show-detail', function(e) {
            e.preventDefault();

            var nama = $(this).data('nama');
            var spesifikasi = $(this).data('spesifikasi');
            var qty = $(this).data('qty');
            var satuan = $(this).data('satuan');
            var kondisi = $(this).data('kondisi');
            var lokasi = $(this).data('lokasi');
            var jenis = $(this).data('jenis');
            var keterangan = $(this).data('keterangan');
            var gambar = $(this).data('gambar');

            var kondisiBadge = '';
            if (kondisi === 'Baik') {
                kondisiBadge =
                    '<span class="badge badge-soft-success px-3 py-1.5 rounded-pill">Baik</span>';
            } else if (kondisi === 'Rusak') {
                kondisiBadge =
                    '<span class="badge badge-soft-warning px-3 py-1.5 rounded-pill">Rusak</span>';
            } else {
                kondisiBadge =
                    '<span class="badge badge-soft-danger px-3 py-1.5 rounded-pill">Scrap</span>';
            }

            $('#detailNamaTools').text(nama);
            $('#detailJenis').text(jenis);
            $('#detailSpesifikasi').text(spesifikasi);
            $('#detailQtySatuan').text(qty + ' ' + satuan);
            $('#detailKondisi').html(kondisiBadge);
            $('#detailLokasi').text(lokasi);
            $('#detailKeterangan').text(keterangan);

            if (gambar && gambar.trim() !== '') {
                $('#detailGambar').attr('src', gambar).show();
                $('#noGambarText').hide();
            } else {
                $('#detailGambar').hide();
                $('#noGambarText').show();
            }

            $('#modalDetail').modal('show');
        });
    });
</script>
