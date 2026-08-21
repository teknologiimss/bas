@extends('layouts.main')

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #0f172a;
            --primary-dark: #020617;
            --secondary: #1e3a8a;
            --border: #dbeafe;
        }

        body {
            background: #eef4fb;
            font-family: 'Segoe UI', sans-serif;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #fff;
        }

        .top-card {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 24px;
            padding: 24px;
            color: white;
            box-shadow: 0 12px 30px rgba(15, 23, 42, .25);
        }

        .btn-modern {
            border: none;
            border-radius: 14px;
            padding: 11px 18px;
            font-weight: 600;
            transition: .25s;
        }

        .table-card {
            background: white;
            border-radius: 24px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, .08);
        }

        /* --- PENYESUAIAN ALIGNMENT TABEL & CHECKBOX --- */
        .table {
            margin-bottom: 0;
            vertical-align: middle;
        }

        .table thead th {
            background: #0f172a;
            color: white;
            border: none;
            padding: 15px 10px;
            font-size: 13px;
            text-transform: uppercase;
            vertical-align: middle !important;
        }

        .table tbody td {
            vertical-align: middle !important;
            padding: 12px 10px;
        }

        /* Fix Checkbox Keluar / Lepas dari Header */
        .checkbox-cell {
            width: 40px;
            text-align: center;
            vertical-align: middle !important;
        }

        .form-check-input {
            cursor: pointer;
            width: 18px;
            height: 18px;
            margin: 0 auto !important;
            display: block;
        }

        .badge-modern {
            padding: 6px 10px;
            border-radius: 999px;
            background: #dbeafe;
            color: #1e3a8a;
            font-weight: 600;
            font-size: 12px;
            display: inline-block;
        }

        /* --- STYLING GROUP ACTION BUTTONS (8 TOMBOL) --- */
        .action-group {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            flex-wrap: nowrap;
            white-space: nowrap;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            padding: 0;
            border-radius: 8px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white !important;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
            font-size: 13px;
            line-height: 1;
            box-sizing: border-box;
            cursor: pointer;
        }

        .btn-action:hover {
            opacity: 0.85;
            transform: translateY(-1px);
        }

        .btn-mobile-modern {
            height: 32px;
            border-radius: 8px;
            padding: 0 10px;
            font-size: 11px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            border: none;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white !important;
            text-decoration: none;
            white-space: nowrap;
            line-height: 1;
            box-sizing: border-box;
        }

        .btn-mobile-disabled {
            height: 32px;
            border-radius: 8px;
            padding: 0 10px;
            font-size: 11px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            border: none;
            background: #94a3b8;
            color: #ffffff !important;
            cursor: not-allowed;
            opacity: 0.65;
            pointer-events: none;
            white-space: nowrap;
            line-height: 1;
            box-sizing: border-box;
        }

        .bg-purple {
            background-color: #8b5cf6;
        }

        .bg-teal {
            background-color: #0d9488;
        }
    </style>

    <div class="container py-4">
        {{-- TOP CARD --}}
        <div class="top-card d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <div class="page-title">❄️ Monitoring FCU</div>
                <p class="mb-0">Manajemen Checksheet & Perawatan Fan Coil Unit</p>
            </div>
            <div>
                <a href="{{ route('fcu.create') }}" class="btn btn-light btn-modern">
                    <i class="fa fa-plus me-1"></i> Buat Monitoring FCU
                </a>
            </div>
        </div>

        {{-- FILTER CARD --}}
        <div class="table-card mb-3">
            <form method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">No. FCU</label>
                        <input type="text" name="no_fcu" value="{{ request('no_fcu') }}" class="form-control"
                            placeholder="Masukkan No FCU">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Jenis Perawatan</label>
                        <select name="jenis_perawatan" class="form-control">
                            <option value="">-- Semua Jenis --</option>
                            <option value="P1" {{ request('jenis_perawatan') == 'P1' ? 'selected' : '' }}>P1</option>
                            <option value="P3" {{ request('jenis_perawatan') == 'P3' ? 'selected' : '' }}>P3</option>
                            <option value="P6" {{ request('jenis_perawatan') == 'P6' ? 'selected' : '' }}>P6</option>
                            <option value="P12" {{ request('jenis_perawatan') == 'P12' ? 'selected' : '' }}>P12</option>
                            <option value="Unscheduled" {{ request('jenis_perawatan') == 'Unscheduled' ? 'selected' : '' }}>
                                Unscheduled</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button class="btn btn-primary btn-modern"><i class="fa fa-search me-1"></i> Cari</button>
                        <a href="{{ route('fcu.index') }}" class="btn btn-secondary btn-modern">
                            <i class="fa fa-rotate-left me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- FORM BULK DELETE & TABEL DATA --}}
        <form id="bulkDeleteForm" action="{{ route('fcu.bulk-delete') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="table-card">
                {{-- TOMBOL HAPUS YANG DIPILIH --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <button type="button" id="btnBulkDelete" class="btn btn-danger btn-modern" disabled
                        onclick="confirmBulkDelete()">
                        <i class="fa fa-trash me-1"></i> Hapus yang Dipilih (<span id="selectedCount">0</span>)
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th class="checkbox-cell">
                                    <input type="checkbox" id="selectAll" class="form-check-input">
                                </th>
                                <th>NO</th>
                                <th>JUDUL</th>
                                <th>NO FCU</th>
                                <th>TANGGAL</th>
                                <th>JENIS PERAWATAN</th>
                                <th>KESIMPULAN</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $i => $d)
                                <tr>
                                    <td class="checkbox-cell">
                                        <input type="checkbox" name="ids[]" value="{{ $d->id }}"
                                            class="form-check-input item-checkbox">
                                    </td>
                                    <td><strong>{{ $i + 1 }}</strong></td>
                                    <td><strong>{{ $d->judul }}</strong></td>
                                    <td>
                                        <div class="d-flex gap-1 flex-wrap">
                                            @if ($d->jenis_perawatan === 'Unscheduled')
                                                <span class="badge-modern">
                                                    {{ $d->unscheduledForm->no_fcu ?? ($d->no_fcu ?? '-') }}
                                                </span>
                                            @else
                                                @if (!empty($d->no_fcu_1))
                                                    <span class="badge-modern">{{ $d->no_fcu_1 }}</span>
                                                @elseif(!empty($d->no_fcu))
                                                    <span class="badge-modern">{{ $d->no_fcu }}</span>
                                                @endif

                                                @if (!empty($d->no_fcu_2))
                                                    <span class="badge-modern">{{ $d->no_fcu_2 }}</span>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y') }}</td>
                                    <td><span class="badge bg-info text-dark">{{ $d->jenis_perawatan }}</span></td>
                                    <td>
                                        <span
                                            class="badge {{ $d->kesimpulan == 'SO' ? 'bg-success' : ($d->kesimpulan == 'TSO' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                            {{ $d->kesimpulan ?? 'Belum Diisi' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="action-group">
                                            {{-- 1. Checksheet --}}
                                            @if ($d->jenis_perawatan === 'Unscheduled')
                                                <button type="button" class="btn-mobile-disabled"
                                                    title="Checksheet tidak tersedia untuk Unscheduled" disabled>
                                                    <i class="fa fa-circle-check"></i> Checksheet
                                                </button>
                                            @else
                                                <a href="{{ route('fcu.mobile', $d->id) }}" class="btn-mobile-modern"
                                                    title="Isi Checksheet">
                                                    <i class="fa fa-circle-check"></i> Checksheet
                                                </a>
                                            @endif

                                            {{-- 2. Lihat Detail --}}
                                            <a href="{{ route('fcu.show', $d->id) }}" class="btn-action bg-info"
                                                title="Lihat Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            {{-- 3. Edit --}}
                                            <a href="{{ route('fcu.edit', $d->id) }}" class="btn-action bg-primary"
                                                title="Edit">
                                                <i class="fa fa-pen"></i>
                                            </a>

                                            {{-- 4. Cetak PDF --}}
                                            <a href="{{ route('fcu.print', $d->id) }}" target="_blank"
                                                class="btn-action bg-secondary" title="Cetak / PDF">
                                                <i class="fa fa-print"></i>
                                            </a>

                                            {{-- 5. Copy Format --}}
                                            <button type="button" class="btn-action bg-warning text-dark"
                                                title="Copy Format"
                                                onclick="submitCopyForm('{{ route('fcu.copy', $d->id) }}')">
                                                <i class="fa fa-copy"></i>
                                            </button>

                                            {{-- 6. Upload Dokumen --}}
                                            <button type="button" class="btn-action bg-purple"
                                                onclick="openUploadModal(
                                                    '{{ route('fcu.upload', $d->id) }}', 
                                                    '{{ $d->file_dokumen ? asset('storage/' . $d->file_dokumen) : '' }}',
                                                    '{{ route('fcu.delete-document', $d->id) }}'
                                                )"
                                                title="Upload Dokumen">
                                                <i class="fa fa-upload"></i>
                                            </button>

                                            {{-- 7. Lihat File Dokumen --}}
                                            @if (!empty($d->file_dokumen))
                                                <a href="{{ asset('storage/' . $d->file_dokumen) }}" target="_blank"
                                                    class="btn-action bg-teal" title="Lihat File Dokumen">
                                                    <i class="fa fa-file-pdf"></i>
                                                </a>
                                            @else
                                                <button type="button" class="btn-action bg-secondary"
                                                    style="opacity: 0.5; cursor: not-allowed;" title="File belum diupload"
                                                    disabled>
                                                    <i class="fa fa-file-pdf"></i>
                                                </button>
                                            @endif

                                            {{-- 8. Hapus Single Data --}}
                                            <button type="button" class="btn-action bg-danger" title="Hapus"
                                                onclick="submitSingleDelete('{{ route('fcu.destroy', $d->id) }}')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">Tidak ada data monitoring FCU.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>

    {{-- FORM INDEPENDEN UNTUK ACTION SINGLE --}}
    <form id="actionSingleForm" action="" method="POST" class="d-none">
        @csrf
        <input type="hidden" name="_method" id="singleFormMethod" value="POST">
    </form>

    {{-- MODAL UPLOAD GLOBAL --}}
    <div class="modal fade" id="globalUploadModal" tabindex="-1" aria-labelledby="globalUploadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="globalUploadModalLabel">Upload Dokumen FCU</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal"
                        aria-label="Close" onclick="closeUploadModal()"></button>
                </div>

                <form id="globalUploadForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Dokumen (PDF, JPG, PNG)</label>
                            <input type="file" name="file_dokumen" class="form-control" accept=".pdf,.jpg,.jpeg,.png"
                                required>
                            <small class="text-muted mt-1 d-block">Maksimal ukuran file: 5MB.</small>
                        </div>

                        <div id="fileExistingAlert" class="alert alert-info mb-0 d-none">
                            <i class="fa fa-info-circle me-1"></i> File saat ini:
                            <a href="#" id="fileExistingUrl" target="_blank"
                                class="fw-bold text-decoration-underline">
                                Lihat File
                            </a>
                        </div>
                    </div>
                </form>

                <form id="deleteDocumentForm" action="" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>

                <div class="modal-footer justify-content-between">
                    <div>
                        <button type="submit" id="btnDeleteDocument" form="deleteDocumentForm"
                            class="btn btn-outline-danger d-none"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus lampiran dokumen ini?')">
                            <i class="fa fa-trash me-1"></i> Hapus Lampiran
                        </button>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-dismiss="modal"
                            onclick="closeUploadModal()">Batal</button>
                        <button type="submit" form="globalUploadForm" class="btn btn-primary">
                            <i class="fa fa-upload me-1"></i> Simpan File
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            const btnBulkDelete = document.getElementById('btnBulkDelete');
            const selectedCount = document.getElementById('selectedCount');

            // Select All Logic
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    itemCheckboxes.forEach(cb => cb.checked = this.checked);
                    updateBulkDeleteButton();
                });
            }

            // Single Checkbox Logic
            itemCheckboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    const allChecked = Array.from(itemCheckboxes).every(c => c.checked);
                    if (selectAll) selectAll.checked = allChecked;
                    updateBulkDeleteButton();
                });
            });

            function updateBulkDeleteButton() {
                const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
                const count = checkedBoxes.length;

                selectedCount.textContent = count;
                if (count > 0) {
                    btnBulkDelete.removeAttribute('disabled');
                } else {
                    btnBulkDelete.setAttribute('disabled', 'disabled');
                }
            }
        });

        function confirmBulkDelete() {
            const count = document.querySelectorAll('.item-checkbox:checked').length;
            if (confirm(`Apakah Anda yakin ingin menghapus ${count} data monitoring yang dipilih?`)) {
                document.getElementById('bulkDeleteForm').submit();
            }
        }

        function submitSingleDelete(url) {
            if (confirm('Hapus data monitoring ini?')) {
                const form = document.getElementById('actionSingleForm');
                form.action = url;
                document.getElementById('singleFormMethod').value = 'DELETE';
                form.submit();
            }
        }

        function submitCopyForm(url) {
            if (confirm('Duplikat format monitoring ini?')) {
                const form = document.getElementById('actionSingleForm');
                form.action = url;
                document.getElementById('singleFormMethod').value = 'POST';
                form.submit();
            }
        }

        function openUploadModal(uploadUrl, fileUrl, deleteUrl) {
            const form = document.getElementById('globalUploadForm');
            form.action = uploadUrl;
            const fileInput = form.querySelector('input[type="file"]');
            if (fileInput) fileInput.value = '';

            const fileAlert = document.getElementById('fileExistingAlert');
            const fileLink = document.getElementById('fileExistingUrl');
            const deleteForm = document.getElementById('deleteDocumentForm');
            const deleteBtn = document.getElementById('btnDeleteDocument');

            if (fileUrl && fileUrl.trim() !== '') {
                fileLink.href = fileUrl;
                fileAlert.classList.remove('d-none');

                if (deleteForm && deleteUrl) deleteForm.action = deleteUrl;
                if (deleteBtn) deleteBtn.classList.remove('d-none');
            } else {
                fileAlert.classList.add('d-none');
                if (deleteForm) deleteForm.action = '';
                if (deleteBtn) deleteBtn.classList.add('d-none');
            }

            var modalElem = document.getElementById('globalUploadModal');
            if (window.jQuery && typeof $(modalElem).modal === 'function') {
                $(modalElem).modal('show');
            } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                var myModal = bootstrap.Modal.getOrCreateInstance(modalElem);
                myModal.show();
            }
        }

        function closeUploadModal() {
            var modalElem = document.getElementById('globalUploadModal');
            if (window.jQuery && typeof $(modalElem).modal === 'function') {
                $(modalElem).modal('hide');
            } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                var myModal = bootstrap.Modal.getInstance(modalElem);
                if (myModal) myModal.hide();
            }
        }
    </script>
@endsection
