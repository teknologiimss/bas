@extends('layouts.main')

@section('title', 'Monitor 5R & Scrap')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')
    <style>
        :root {
            --navy: #0b2545;
            --navy-light: #12355b;
            --bg: #f4f7fb;
            --border-color: #e2e8f0;
        }

        body {
            background: var(--bg);
            font-family: "Segoe UI", sans-serif;
        }

        .header-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .project-header {
            width: 100%;
            max-width: 650px;
            text-align: center;
            background: linear-gradient(135deg, var(--navy), var(--navy-light));
            color: white;
            padding: 24px;
            border-radius: 18px;
            box-shadow: 0 4px 15px rgba(11, 37, 69, 0.15);
        }

        .table-container {
            overflow-x: auto;
            max-height: 550px;
            border-radius: 12px;
        }

        .table-monitoring th {
            position: sticky;
            top: 0;
            background: linear-gradient(135deg, var(--navy), var(--navy-light));
            color: white;
            white-space: nowrap;
            vertical-align: middle;
            z-index: 10;
        }

        /* STYLING ACTION BUTTONS */
        .action-btns {
            display: flex;
            gap: 6px;
            align-items: center;
            justify-content: center;
            flex-wrap: nowrap;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            transition: all 0.2s ease-in-out;
            text-decoration: none !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            white-space: nowrap;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-action-info {
            background-color: #0284c7;
            color: #ffffff !important;
        }

        .btn-action-warning {
            background-color: #f59e0b;
            color: #ffffff !important;
        }

        .btn-action-danger {
            background-color: #ef4444;
            color: #ffffff !important;
        }

        /* RESPONSIVE DESIGN (MOBILE CARD VIEW) */
        @media (max-width: 768px) {
            .project-header {
                padding: 16px;
                border-radius: 14px;
            }

            .project-title {
                font-size: 1.25rem;
            }

            /* Sembunyikan Header Tabel di Mobile */
            .table-monitoring thead {
                display: none;
            }

            .table-monitoring,
            .table-monitoring tbody,
            .table-monitoring tr,
            .table-monitoring td {
                display: block;
                width: 100%;
            }

            .table-monitoring tr {
                margin-bottom: 16px;
                background: #ffffff;
                border: 1px solid var(--border-color);
                border-radius: 14px;
                padding: 12px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
            }

            .table-monitoring td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-align: right;
                padding: 8px 6px;
                border: none !important;
                border-bottom: 1px dashed var(--border-color) !important;
            }

            .table-monitoring td:last-child {
                border-bottom: none !important;
                padding-top: 12px;
            }

            /* Tambahkan Label Kolom Secara Otomatis di HP */
            .table-monitoring td::before {
                content: attr(data-label);
                font-weight: 700;
                color: #475569;
                text-align: left;
                font-size: 13px;
                padding-right: 10px;
            }

            .table-monitoring td[data-label="Select"]::before,
            .table-monitoring td[data-label="No."]::before {
                content: attr(data-label);
            }

            .action-btns {
                width: 100%;
                justify-content: space-between;
                gap: 8px;
            }

            .btn-action {
                flex: 1;
                padding: 8px 6px;
                font-size: 12px;
            }
        }
    </style>

    <div class="header-wrapper">
        <div class="project-header">
            <div class="project-title font-weight-bold">Monitoring 5R & Scrap</div>
            <div class="project-name small opacity-75">{{ $folder->nama_folder }} ({{ $folder->tahun }})</div>
        </div>
        <button class="btn btn-success mt-3 px-4 py-2 font-weight-bold shadow-sm rounded-pill" data-toggle="modal"
            data-target="#modalTambah">
            ➕ Tambah Data
        </button>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-12 shadow-sm" role="alert">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter Card --}}
    <div class="card mt-3 p-3 border-0 shadow-sm rounded-12">
        <form method="GET">
            <div class="row g-3">
                <div class="col-md-5 mb-2 mb-md-0">
                    <label class="form-label small font-weight-bold text-muted">Nomor Kontrak</label>
                    <input type="text" name="no_kontrak" value="{{ request('no_kontrak') }}"
                        class="form-control rounded-8" placeholder="Cari No Kontrak...">
                </div>
                <div class="col-md-5 mb-2 mb-md-0">
                    <label class="form-label small font-weight-bold text-muted">Deskripsi Pekerjaan</label>
                    <input type="text" name="deskripsi" value="{{ request('deskripsi') }}" class="form-control rounded-8"
                        placeholder="Cari Deskripsi...">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100 font-weight-bold rounded-8 py-2">🔍 Filter</button>
                </div>
            </div>
        </form>
    </div>

    <button id="btnDeleteSelected" class="btn btn-danger btn-sm mt-3 mb-2 rounded-8">
        🗑️ Hapus Data Dipilih
    </button>

    {{-- Table / Card Container --}}
    <div class="card p-2 p-md-3 border-0 shadow-sm rounded-12">
        <div class="table-container">
            <table class="table table-bordered table-monitoring mb-0">
                <thead>
                    <tr>
                        <th width="40" class="text-center"><input type="checkbox" id="checkAll"></th>
                        <th width="50" class="text-center">No.</th>
                        <th>Deskripsi Pekerjaan</th>
                        <th>Nomor Kontrak</th>
                        <th>Tanggal Kontrak</th>
                        <th>Selesai Kontrak</th>
                        <th>Keterangan</th>
                        <th width="220" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $index => $item)
                        <tr>
                            <td data-label="Select" class="text-center">
                                <input type="checkbox" class="checkItem" value="{{ $item->id }}">
                            </td>
                            <td data-label="No." class="text-center font-weight-bold">
                                {{ $items->firstItem() + $index }}
                            </td>
                            <td data-label="Deskripsi Pekerjaan" class="text-start">
                                {{ $item->deskripsi_pekerjaan }}
                            </td>
                            <td data-label="Nomor Kontrak">
                                <span class="badge bg-light text-dark border">{{ $item->nomor_kontrak }}</span>
                            </td>
                            <td data-label="Tanggal Kontrak">
                                {{ $item->tanggal_kontrak ? \Carbon\Carbon::parse($item->tanggal_kontrak)->format('d-m-Y') : '-' }}
                            </td>
                            <td data-label="Selesai Kontrak">
                                {{ $item->selesai_kontrak ? \Carbon\Carbon::parse($item->selesai_kontrak)->format('d-m-Y') : '-' }}
                            </td>
                            <td data-label="Keterangan">
                                {{ $item->keterangan ?? '-' }}
                            </td>
                            <td data-label="Aksi">
                                <div class="action-btns">
                                    <a href="{{ route('monitoring_5r.detail', $item->id) }}"
                                        class="btn-action btn-action-info" title="Detail Checksheet">
                                        👁️ <span>Detail</span>
                                    </a>

                                    <button type="button" class="btn-action btn-action-warning btn-edit"
                                        data-id="{{ $item->id }}" data-deskripsi="{{ $item->deskripsi_pekerjaan }}"
                                        data-nomor="{{ $item->nomor_kontrak }}"
                                        data-tanggal="{{ $item->tanggal_kontrak }}"
                                        data-selesai="{{ $item->selesai_kontrak }}"
                                        data-keterangan="{{ $item->keterangan }}" title="Edit Item">
                                        ✏️ <span>Edit</span>
                                    </button>

                                    <button type="button" class="btn-action btn-action-danger btn-delete-single"
                                        data-url="{{ route('monitoring_5r.item.delete', $item->id) }}" title="Hapus Data">
                                        🗑️ <span>Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Data belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $items->links() }}
        </div>
    </div>

    {{-- Hidden Form Delete Single Item --}}
    <form id="singleDeleteForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    {{-- Hidden Form Bulk Delete --}}
    <form id="bulkDeleteForm" action="{{ route('monitoring_5r.item.bulk_delete') }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="ids" id="bulkIds">
    </form>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form action="{{ route('monitoring_5r.item.store', $folder->id) }}" method="POST" class="w-100">
                @csrf
                <div class="modal-content border-0 shadow-lg rounded-12">
                    <div class="modal-header bg-navy text-white" style="background: var(--navy);">
                        <h5 class="modal-title font-weight-bold text-white">Tambah Data Monitoring 5R & Scrap</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold small">Deskripsi Pekerjaan</label>
                            <textarea name="deskripsi_pekerjaan" autocomplete="off" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold small">Nomor Kontrak</label>
                            <input type="text" autocomplete="off" name="nomor_kontrak" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold small">Tanggal Kontrak</label>
                                <input type="date" name="tanggal_kontrak" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold small">Selesai Kontrak</label>
                                <input type="date" name="selesai_kontrak" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold small">Keterangan</label>
                            <textarea name="keterangan" autocomplete="off" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success font-weight-bold">Simpan Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form id="formEdit" method="POST" class="w-100">
                @csrf
                @method('PUT')
                <div class="modal-content border-0 shadow-lg rounded-12">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title font-weight-bold text-white">Edit Data Monitoring</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold small">Deskripsi Pekerjaan</label>
                            <textarea name="deskripsi_pekerjaan" autocomplete="off" id="edit_deskripsi" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold small">Nomor Kontrak</label>
                            <input type="text" autocomplete="off" name="nomor_kontrak" id="edit_nomor" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold small">Tanggal Kontrak</label>
                                <input type="date" name="tanggal_kontrak" id="edit_tanggal" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold small">Selesai Kontrak</label>
                                <input type="date" name="selesai_kontrak" id="edit_selesai" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold small">Keterangan</label>
                            <textarea name="keterangan" autocomplete="off" id="edit_keterangan" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Check All
        document.getElementById('checkAll').addEventListener('click', function() {
            document.querySelectorAll('.checkItem').forEach(cb => cb.checked = this.checked);
        });

        // Delete Selected (Bulk)
        document.getElementById('btnDeleteSelected').addEventListener('click', function() {
            let ids = [];
            document.querySelectorAll('.checkItem:checked').forEach(cb => ids.push(cb.value));
            if (ids.length === 0) {
                alert('Pilih data terlebih dahulu!');
                return;
            }
            if (confirm('Hapus semua data yang terpilih?')) {
                document.getElementById('bulkIds').value = ids.join(',');
                document.getElementById('bulkDeleteForm').submit();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Handler Tombol Hapus per Item
            const deleteButtons = document.querySelectorAll('.btn-delete-single');
            const singleDeleteForm = document.getElementById('singleDeleteForm');

            deleteButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const deleteUrl = this.getAttribute('data-url');
                    if (confirm('Yakin ingin menghapus data ini?')) {
                        singleDeleteForm.action = deleteUrl;
                        singleDeleteForm.submit();
                    }
                });
            });

            // Handler Tombol Edit Item
            const editButtons = document.querySelectorAll('.btn-edit');
            const formEdit = document.getElementById('formEdit');

            editButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.getAttribute('data-id');
                    const deskripsi = this.getAttribute('data-deskripsi');
                    const nomor = this.getAttribute('data-nomor');
                    const tanggal = this.getAttribute('data-tanggal');
                    const selesai = this.getAttribute('data-selesai');
                    const keterangan = this.getAttribute('data-keterangan');

                    let updateUrl = "{{ route('monitoring_5r.item.update_item', ':id') }}";
                    formEdit.action = updateUrl.replace(':id', id);

                    document.getElementById('edit_deskripsi').value = deskripsi ?? '';
                    document.getElementById('edit_nomor').value = nomor ?? '';
                    document.getElementById('edit_tanggal').value = tanggal ?? '';
                    document.getElementById('edit_selesai').value = selesai ?? '';
                    document.getElementById('edit_keterangan').value = keterangan ?? '';

                    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        let modal = new bootstrap.Modal(document.getElementById('modalEdit'));
                        modal.show();
                    } else if (typeof $ !== 'undefined') {
                        $('#modalEdit').modal('show');
                    }
                });
            });
        });
    </script>
@endsection
