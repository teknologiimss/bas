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

        .table thead th {
            background: #0f172a;
            color: white;
            border: none;
            padding: 15px;
            font-size: 13px;
            text-transform: uppercase;
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

        .action-group {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            flex-wrap: nowrap;
            white-space: nowrap;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            padding: 0;
            border-radius: 10px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white !important;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
            font-size: 14px;
            line-height: 1;
            box-sizing: border-box;
            cursor: pointer;
            position: relative;
            z-index: 5;
        }

        .btn-action:hover {
            opacity: 0.85;
            transform: translateY(-1px);
        }

        .btn-mobile-modern {
            height: 36px;
            border-radius: 10px;
            padding: 0 12px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            border: none;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white !important;
            text-decoration: none;
            white-space: nowrap;
            line-height: 1;
            box-sizing: border-box;
        }

        .btn-mobile-disabled {
            height: 36px;
            border-radius: 10px;
            padding: 0 12px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
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
        <div class="top-card d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <div class="page-title">❄️ Monitoring FCU</div>
                <p class="mb-0">Manajemen Checksheet & Perawatan Fan Coil Unit</p>
            </div>
            <div>
                <a href="{{ route('fcu.create') }}" class="btn btn-light btn-modern"><i class="fa fa-plus me-1"></i> Buat
                    Monitoring FCU</a>
            </div>
        </div>

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
                        <a href="{{ route('fcu.index') }}" class="btn btn-secondary btn-modern"><i
                                class="fa fa-rotate-left me-1"></i> Reset</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-card">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>No FCU</th>
                            <th>Tanggal</th>
                            <th>Jenis Perawatan</th>
                            <th>Kesimpulan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $i => $d)
                            <tr>
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
                                        class="badge {{ $d->kesimpulan == 'SO' ? 'bg-success' : ($d->kesimpulan == 'TSO' ? 'bg-danger' : 'bg-warning') }}">
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
                                        <form action="{{ route('fcu.copy', $d->id) }}" method="POST"
                                            class="d-inline m-0 p-0">
                                            @csrf
                                            <button type="submit"
                                                onclick="return confirm('Duplikat format monitoring ini?')"
                                                class="btn-action bg-warning text-dark" title="Copy Format">
                                                <i class="fa fa-copy"></i>
                                            </button>
                                        </form>

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

                                        {{-- 8. Hapus Data --}}
                                        <form action="{{ route('fcu.destroy', $d->id) }}" method="POST"
                                            class="d-inline m-0 p-0">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus data monitoring ini?')"
                                                class="btn-action bg-danger" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">Tidak ada data monitoring FCU.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL UPLOAD GLOBAL (PERBAIKAN: STRUKTUR FORM MANDIRI) --}}
    <div class="modal fade" id="globalUploadModal" tabindex="-1" aria-labelledby="globalUploadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="globalUploadModalLabel">Upload Dokumen FCU</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal"
                        aria-label="Close" onclick="closeUploadModal()"></button>
                </div>

                {{-- FORM 1: UPLOAD DOKUMEN (POST) --}}
                <form id="globalUploadForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Dokumen (PDF, JPG, PNG)</label>
                            <input type="file" name="file_dokumen" class="form-control" accept=".pdf,.jpg,.jpeg,.png"
                                required>
                            <small class="text-muted mt-1 d-block">Maksimal ukuran file: 5MB.</small>
                        </div>

                        {{-- CONTAINER INFORMASI FILE EXISTING --}}
                        <div id="fileExistingAlert" class="alert alert-info mb-0 d-none">
                            <i class="fa fa-info-circle me-1"></i> File saat ini:
                            <a href="#" id="fileExistingUrl" target="_blank"
                                class="fw-bold text-decoration-underline">
                                Lihat File
                            </a>
                        </div>
                    </div>
                </form>

                {{-- FORM 2: HAPUS DOKUMEN (DELETE) - BERDIRI SENDIRI DI LUAR FORM UPLOAD --}}
                <form id="deleteDocumentForm" action="" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>

                {{-- FOOTER MODAL --}}
                <div class="modal-footer justify-content-between">
                    <div>
                        {{-- Tombol ini mengirimkan #deleteDocumentForm via atribut form="" --}}
                        <button type="submit" id="btnDeleteDocument" form="deleteDocumentForm"
                            class="btn btn-outline-danger d-none"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus lampiran dokumen ini?')">
                            <i class="fa fa-trash me-1"></i> Hapus Lampiran
                        </button>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-dismiss="modal"
                            onclick="closeUploadModal()">Batal</button>
                        {{-- Tombol ini mengirimkan #globalUploadForm via atribut form="" --}}
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
        function openUploadModal(uploadUrl, fileUrl, deleteUrl) {
            // Reset form upload utama
            const form = document.getElementById('globalUploadForm');
            form.action = uploadUrl;
            const fileInput = form.querySelector('input[type="file"]');
            if (fileInput) fileInput.value = '';

            // Dapatkan referensi elemen
            const fileAlert = document.getElementById('fileExistingAlert');
            const fileLink = document.getElementById('fileExistingUrl');
            const deleteForm = document.getElementById('deleteDocumentForm');
            const deleteBtn = document.getElementById('btnDeleteDocument');

            // Cek jika data sudah memiliki file lampiran
            if (fileUrl && fileUrl.trim() !== '') {
                fileLink.href = fileUrl;
                fileAlert.classList.remove('d-none');

                // Atur action rute DELETE dan tampilkan tombol hapus
                if (deleteForm && deleteUrl) {
                    deleteForm.action = deleteUrl;
                }
                if (deleteBtn) {
                    deleteBtn.classList.remove('d-none');
                }
            } else {
                fileAlert.classList.add('d-none');
                if (deleteForm) {
                    deleteForm.action = '';
                }
                if (deleteBtn) {
                    deleteBtn.classList.add('d-none');
                }
            }

            // Buka Modal (Kompatibel dengan Bootstrap 4/5 dan jQuery)
            var modalElem = document.getElementById('globalUploadModal');

            if (window.jQuery && typeof $(modalElem).modal === 'function') {
                $(modalElem).modal('show');
            } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                var myModal = bootstrap.Modal.getOrCreateInstance(modalElem);
                myModal.show();
            } else {
                modalElem.classList.add('show');
                modalElem.style.display = 'block';
                document.body.classList.add('modal-open');

                if (!document.querySelector('.modal-backdrop')) {
                    var backdrop = document.createElement('div');
                    backdrop.className = 'modal-backdrop fade show';
                    backdrop.id = 'customModalBackdrop';
                    document.body.appendChild(backdrop);
                }
            }
        }

        function closeUploadModal() {
            var modalElem = document.getElementById('globalUploadModal');

            if (window.jQuery && typeof $(modalElem).modal === 'function') {
                $(modalElem).modal('hide');
            } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                var myModal = bootstrap.Modal.getInstance(modalElem);
                if (myModal) myModal.hide();
            } else {
                modalElem.classList.remove('show');
                modalElem.style.display = 'none';
                document.body.classList.remove('modal-open');

                var backdrop = document.getElementById('customModalBackdrop') || document.querySelector('.modal-backdrop');
                if (backdrop) backdrop.remove();
            }
        }
    </script>
@endsection
