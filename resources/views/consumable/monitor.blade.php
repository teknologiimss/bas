@extends('layouts.main')

<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

<style>
    /* ================= PALET WARNA NAVY & EFEK DYNAMIS ================= */
    :root {
        --navy-dark: #0f172a;
        --navy-primary: #1e293b;
        --navy-light: #334155;
        --accent-blue: #38bdf8;
        --accent-hover: #0284c7;
        --accent-glow: rgba(56, 189, 248, 0.35);
    }

    /* Container Styling & Animation */
    .navy-wrapper {
        animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Header Banner Modern */
    .navy-header-card {
        background: linear-gradient(135deg, var(--navy-dark) 0%, var(--navy-primary) 100%);
        border-radius: 16px;
        padding: 20px 25px;
        color: #ffffff;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.08);
        position: relative;
        overflow: hidden;
    }

    .navy-header-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.1) 0%, transparent 60%);
        animation: pulseGlow 6s infinite alternate;
        pointer-events: none;
    }

    @keyframes pulseGlow {
        0% {
            transform: scale(0.9) translate(-10px, -10px);
        }

        100% {
            transform: scale(1.1) translate(10px, 10px);
        }
    }

    /* Modern Animated Buttons */
    .btn-navy-add {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff !important;
        border: none;
        border-radius: 8px;
        padding: 10px 18px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-navy-add:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.45);
    }

    .btn-navy-print {
        background: linear-gradient(135deg, #475569 0%, #334155 100%);
        color: #fff !important;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        padding: 10px 18px;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-navy-print:hover {
        transform: translateY(-3px) scale(1.02);
        background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        box-shadow: 0 8px 20px rgba(51, 65, 85, 0.35);
    }

    /* Table Container Card */
    .navy-table-card {
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        background: #ffffff;
        overflow: hidden;
    }

    /* Tabel Styling & Header Navy */
    .navy-table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .navy-table thead th {
        background-color: var(--navy-dark) !important;
        color: #f8fafc !important;
        border-color: #334155 !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    /* Sub-Header Row Styling */
    .sub-header-row {
        background: linear-gradient(90deg, #1e293b 0%, #334155 100%) !important;
        color: #38bdf8 !important;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .sub-header-row td {
        border-color: #334155 !important;
        padding: 8px 15px !important;
    }

    /* Interactive Sub-Header Button (Tersamar/Tidak Kelihatan Sebelumnya) */
    .btn-add-item-sub {
        background-color: #0284c7 !important;
        color: #ffffff !important;
        border: 1px solid #38bdf8 !important;
        border-radius: 6px;
        font-weight: 600;
        padding: 4px 12px;
        font-size: 0.75rem;
        white-space: nowrap;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        transition: all 0.2s ease;
    }

    .btn-add-item-sub:hover {
        background-color: #38bdf8 !important;
        color: #0f172a !important;
        transform: scale(1.05);
        box-shadow: 0 0 10px var(--accent-glow);
    }

    /* Custom Action Buttons (Edit & Hapus) */
    .btn-action-equal {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
    }

    /* Table Hover & Animated Rows */
    .navy-table tbody tr:not(.sub-header-row) {
        transition: all 0.25s ease;
    }

    .navy-table tbody tr:not(.sub-header-row):hover {
        background-color: #f0f9ff !important;
        transform: scale(1.002);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    /* Modern Modal Styling */
    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.3);
        overflow: hidden;
        animation: modalBounce 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes modalBounce {
        from {
            transform: scale(0.85);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .modal-header {
        background: linear-gradient(135deg, var(--navy-dark) 0%, var(--navy-primary) 100%);
        color: #ffffff;
        border-bottom: none;
        padding: 18px 24px;
    }

    .modal-header .close {
        color: #ffffff;
        opacity: 0.8;
        text-shadow: none;
        transition: transform 0.2s;
    }

    .modal-header .close:hover {
        opacity: 1;
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 24px;
        background-color: #f8fafc;
    }

    .modal-footer {
        background-color: #f1f5f9;
        border-top: 1px solid #e2e8f0;
        padding: 12px 24px;
    }

    /* Custom Form Controls */
    .form-control {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25);
    }

    /* Tooltip / Badges Animation */
    .badge-total {
        background-color: #e0f2fe;
        color: #0369a1;
        padding: 5px 10px;
        border-radius: 6px;
        display: inline-block;
        transition: transform 0.2s;
    }

    .navy-table tr:hover .badge-total {
        transform: scale(1.1);
        background-color: #0284c7;
        color: #ffffff;
    }
</style>

@section('content')
    <div class="container-fluid navy-wrapper my-3">
        <!-- Header Banner -->
        <div class="navy-header-card d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
            <div class="mb-3 mb-md-0 position-relative">
                <h3 class="font-weight-bold mb-1 text-white">
                    <i class="fas fa-boxes text-info mr-2"></i>{{ $folder->title }}
                    <span class="badge badge-info ml-2"
                        style="font-size: 0.5em; vertical-align: middle;">{{ $folder->year }}</span>
                </h3>
                <small class="text-light opacity-75">Rekapitulasi Konsumsi Komponen Tahunan</small>
            </div>
            <div class="d-flex flex-wrap gap-2 position-relative">
                <button class="btn btn-navy-add mr-2 mb-2 mb-sm-0" data-toggle="modal" data-target="#modalAddItem">
                    <i class="fas fa-plus-circle mr-1"></i> Tambah Komponen
                </button>
                <a href="{{ route('consumable.print', $folder->id) }}" target="_blank" class="btn btn-navy-print">
                    <i class="fas fa-print mr-1"></i> Print / Cetak
                </a>
            </div>
        </div>

        <!-- Card Container Tabel -->
        <div class="card navy-table-card">
            <div class="card-body p-0 table-responsive">
                <table class="table table-bordered table-sm text-center align-middle navy-table">
                    <thead>
                        <tr>
                            <th rowspan="2" class="align-middle">NO</th>
                            <th rowspan="2" class="align-middle" style="min-width: 180px;">KOMPONEN</th>
                            <th rowspan="2" class="align-middle" style="min-width: 200px;">SPESIFIKASI</th>
                            <th colspan="12" class="align-middle">BULAN</th>
                            <th rowspan="2" class="align-middle">TOTAL</th>
                            <th rowspan="2" class="align-middle">SAT</th>
                            <th rowspan="2" class="align-middle" style="min-width: 150px;">KETERANGAN</th>
                            <th rowspan="2" class="align-middle" style="min-width: 100px;">AKSI</th>
                        </tr>
                        <tr>
                            <th>JAN</th>
                            <th>FEB</th>
                            <th>MAR</th>
                            <th>APR</th>
                            <th>MEI</th>
                            <th>JUNI</th>
                            <th>JULI</th>
                            <th>AGUS</th>
                            <th>SEPT</th>
                            <th>OKT</th>
                            <th>NOV</th>
                            <th>DES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($groupedItems as $subHeader => $items)
                            <!-- Baris Sub Header -->
                            @php $subHeaderSlug = Str::slug($subHeader); @endphp
                            <tr class="sub-header-row font-weight-bold text-left">
                                <td colspan="18" class="align-middle pl-3">
                                    <i class="fas fa-layer-group mr-2"></i>{{ strtoupper($subHeader) }}
                                </td>
                                <td class="text-center align-middle">
                                    <button class="btn btn-add-item-sub" data-toggle="modal"
                                        data-target="#modalAddItem{{ $subHeaderSlug }}"
                                        title="Tambah Item ke {{ $subHeader }}">
                                        <i class="fas fa-plus mr-1"></i> Item
                                    </button>
                                </td>
                            </tr>

                            <!-- Item Dalam Sub Header -->
                            @foreach ($items as $index => $item)
                                <tr>
                                    <td class="align-middle">{{ $index + 1 }}</td>
                                    <td class="text-left align-middle font-weight-bold text-dark">{{ $item->komponen }}</td>
                                    <td class="text-left align-middle text-muted">{{ $item->spesifikasi }}</td>
                                    <td class="align-middle">{{ $item->jan ?: '' }}</td>
                                    <td class="align-middle">{{ $item->feb ?: '' }}</td>
                                    <td class="align-middle">{{ $item->mar ?: '' }}</td>
                                    <td class="align-middle">{{ $item->apr ?: '' }}</td>
                                    <td class="align-middle">{{ $item->mei ?: '' }}</td>
                                    <td class="align-middle">{{ $item->juni ?: '' }}</td>
                                    <td class="align-middle">{{ $item->juli ?: '' }}</td>
                                    <td class="align-middle">{{ $item->agus ?: '' }}</td>
                                    <td class="align-middle">{{ $item->sept ?: '' }}</td>
                                    <td class="align-middle">{{ $item->okt ?: '' }}</td>
                                    <td class="align-middle">{{ $item->nov ?: '' }}</td>
                                    <td class="align-middle">{{ $item->des ?: '' }}</td>
                                    <td class="align-middle"><span class="badge-total">{{ $item->total }}</span></td>
                                    <td class="align-middle"><span
                                            class="badge badge-light border">{{ $item->satuan }}</span></td>
                                    <td class="text-left align-middle text-secondary">
                                        <small>{{ $item->keterangan }}</small>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center justify-content-center" style="gap: 4px;">
                                            <button class="btn btn-sm btn-outline-warning btn-action-equal"
                                                data-toggle="modal" data-target="#modalEditItem{{ $item->id }}"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('consumable.item.destroy', $item->id) }}" method="POST"
                                                class="d-inline m-0" onsubmit="return confirm('Hapus item ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-outline-danger btn-action-equal" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Edit Item -->
                                <div class="modal fade" id="modalEditItem{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg text-left modal-dialog-centered">
                                        <form action="{{ route('consumable.item.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title font-weight-bold"><i
                                                            class="fas fa-edit mr-2"></i>Edit Item Komponen</h5>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                            <label class="font-weight-bold">Sub Judul (Kategori)</label>
                                                            <input type="text" name="sub_header" class="form-control"
                                                                value="{{ $item->sub_header }}" required>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label class="font-weight-bold">Komponen</label>
                                                            <input type="text" name="komponen" class="form-control"
                                                                value="{{ $item->komponen }}" required>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <label class="font-weight-bold">Spesifikasi</label>
                                                            <input type="text" name="spesifikasi" class="form-control"
                                                                value="{{ $item->spesifikasi }}">
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label class="font-weight-bold">Satuan</label>
                                                            <input type="text" name="satuan" class="form-control"
                                                                value="{{ $item->satuan }}" required>
                                                        </div>
                                                    </div>

                                                    <label class="font-weight-bold text-navy mt-2">Jumlah Alokasi per
                                                        Bulan:</label>
                                                    <div class="row p-2 rounded bg-white border mb-3">
                                                        @php $bulanList = ['jan', 'feb', 'mar', 'apr', 'mei', 'juni', 'juli', 'agus', 'sept', 'okt', 'nov', 'des']; @endphp
                                                        @foreach ($bulanList as $b)
                                                            <div class="col-3 col-md-2 form-group mb-2">
                                                                <label
                                                                    class="text-uppercase small font-weight-bold text-muted mb-1">{{ $b }}</label>
                                                                <input type="number" name="{{ $b }}"
                                                                    class="form-control form-control-sm text-center"
                                                                    value="{{ $item->$b }}" min="0">
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <div class="form-group mb-0">
                                                        <label class="font-weight-bold">Keterangan</label>
                                                        <textarea name="keterangan" class="form-control" rows="2">{{ $item->keterangan }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success"><i
                                                            class="fas fa-save mr-1"></i>Simpan Perubahan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Modal Tambah Item Khusus Sub Header Ini -->
                            <div class="modal fade" id="modalAddItem{{ $subHeaderSlug }}" tabindex="-1">
                                <div class="modal-dialog modal-lg text-left modal-dialog-centered">
                                    <form action="{{ route('consumable.item.store', $folder->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="sub_header" value="{{ $subHeader }}">

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title font-weight-bold"><i
                                                        class="fas fa-plus-circle mr-2"></i>Tambah Komponen ke <span
                                                        class="text-info">{{ strtoupper($subHeader) }}</span></h5>
                                                <button type="button" class="close"
                                                    data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label class="font-weight-bold">Komponen</label>
                                                        <input type="text" name="komponen" class="form-control"
                                                            placeholder="Misal: Bearing, Oil Seal" required>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label class="font-weight-bold">Spesifikasi</label>
                                                        <input type="text" name="spesifikasi" class="form-control"
                                                            placeholder="Misal: Bearing 6311 C3 SKF">
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label class="font-weight-bold">Satuan</label>
                                                        <input type="text" name="satuan" class="form-control"
                                                            placeholder="pcs, set, pack" required>
                                                    </div>
                                                </div>

                                                <label class="font-weight-bold text-navy mt-2">Jumlah Alokasi per
                                                    Bulan:</label>
                                                <div class="row p-2 rounded bg-white border mb-3">
                                                    @php $bulanList = ['jan', 'feb', 'mar', 'apr', 'mei', 'juni', 'juli', 'agus', 'sept', 'okt', 'nov', 'des']; @endphp
                                                    @foreach ($bulanList as $b)
                                                        <div class="col-3 col-md-2 form-group mb-2">
                                                            <label
                                                                class="text-uppercase small font-weight-bold text-muted mb-1">{{ $b }}</label>
                                                            <input type="number" name="{{ $b }}"
                                                                class="form-control form-control-sm text-center"
                                                                value="0" min="0">
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="form-group mb-0">
                                                    <label class="font-weight-bold">Keterangan</label>
                                                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Keterangan opsional / Tools"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary"><i
                                                        class="fas fa-save mr-1"></i>Simpan Item</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="19" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-folder-open fa-3x mb-3 text-secondary"></i>
                                        <p class="mb-0 font-weight-bold">Data masih kosong.</p>
                                        <small>Silakan klik tombol "Tambah Komponen" di atas untuk menambah
                                            data.</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Item Komponen Umum / Sub Header Baru -->
    <div class="modal fade" id="modalAddItem" tabindex="-1">
        <div class="modal-dialog modal-lg text-left modal-dialog-centered">
            <form action="{{ route('consumable.item.store', $folder->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold"><i class="fas fa-folder-plus mr-2"></i>Tambah Item
                            Consumable Baru</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Sub Judul (Kategori)</label>
                                <input type="text" name="sub_header" class="form-control"
                                    placeholder="Misal: POMPA DISTRIBUSI, FCU" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Komponen</label>
                                <input type="text" name="komponen" class="form-control"
                                    placeholder="Misal: Bearing, Oil Seal" required>
                            </div>
                            <div class="col-md-8 form-group">
                                <label class="font-weight-bold">Spesifikasi</label>
                                <input type="text" name="spesifikasi" class="form-control"
                                    placeholder="Misal: Bearing 6311 C3 SKF">
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Satuan</label>
                                <input type="text" name="satuan" class="form-control"
                                    placeholder="pcs, set, pack, unit" required>
                            </div>
                        </div>

                        <label class="font-weight-bold text-navy mt-2">Jumlah Alokasi per Bulan:</label>
                        <div class="row p-2 rounded bg-white border mb-3">
                            @php $bulanList = ['jan', 'feb', 'mar', 'apr', 'mei', 'juni', 'juli', 'agus', 'sept', 'okt', 'nov', 'des']; @endphp
                            @foreach ($bulanList as $b)
                                <div class="col-3 col-md-2 form-group mb-2">
                                    <label
                                        class="text-uppercase small font-weight-bold text-muted mb-1">{{ $b }}</label>
                                    <input type="number" name="{{ $b }}"
                                        class="form-control form-control-sm text-center" value="0" min="0">
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group mb-0">
                            <label class="font-weight-bold">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Keterangan opsional / Tools"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Simpan
                            Item</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
