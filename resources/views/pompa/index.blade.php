@extends('layouts.main')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #0f172a;
            --primary-dark: #020617;
            --secondary: #1e3a8a;
            --accent: #2563eb;
            --table-border: #cbd5e1;
        }

        body {
            background: #eef4fb;
            font-family: 'Segoe UI', sans-serif;
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

        /* GRID TABLE */
        .table-custom-grid {
            margin-bottom: 0;
            width: 100%;
            border-collapse: collapse;
            border: 1px solid var(--table-border);
        }

        .table-custom-grid th,
        .table-custom-grid td {
            vertical-align: middle !important;
            padding: 12px 14px;
            white-space: nowrap;
            border: 1px solid var(--table-border);
        }

        .table-custom-grid thead th {
            background-color: #123057;
            color: white;
            font-size: 13px;
            font-weight: 700;
        }

        /* CHECKBOX STYLING */
        .col-checkbox {
            width: 50px;
            text-align: center;
        }

        .table-custom-grid thead th.col-checkbox {
            background-color: #0d2442;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            margin: 0 auto;
            cursor: pointer;
            border: 1.5px solid #94a3b8;
            border-radius: 4px;
            display: inline-block;
            vertical-align: middle;
            position: static;
        }

        .form-check-input:checked {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        .badge-jenis {
            background: #dbeafe;
            color: #1e3a8a;
            padding: 6px 12px;
            border-radius: 999px;
            font-weight: 600;
        }

        .badge-unscheduled {
            background: #fee2e2;
            color: #991b1b;
            padding: 6px 12px;
            border-radius: 999px;
            font-weight: 600;
        }

        .action-group {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            white-space: nowrap;
        }

        .action-group .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 32px;
            padding: 0 10px;
            font-size: 0.85rem;
        }

        .action-group form {
            margin: 0;
            display: inline-block;
        }
    </style>

    <div class="container py-4">
        @if (session('success'))
            <div id="success-alert" class="alert alert-success alert-dismissible fade show rounded-3 mb-3" role="alert">
                <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3" role="alert">
                <i class="fa fa-triangle-exclamation me-1"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="top-card d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1">⚙️ Checksheet Pompa</h3>
                <p class="mb-0 text-white-50">Monitoring & Pemeliharaan Unit Pompa</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('pompa.dashboard') }}" class="btn btn-warning btn-modern text-dark">
                    <i class="fa fa-chart-pie me-1"></i> Lihat Dashboard
                </a>
                <a href="{{ route('pompa.create') }}"
                    class="btn btn-light rounded-pill px-4 font-weight-bold d-flex align-items-center">
                    <i class="fa fa-plus me-1"></i> Buat Checksheet
                </a>
            </div>
        </div>

        {{-- FILTER --}}
        <div class="table-card mb-3">
            <form method="GET" action="{{ route('pompa.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">No Pompa</label>
                        <input type="text" autocomplete="off" name="no_pompa" value="{{ request('no_pompa') }}"
                            class="form-control" placeholder="Cari No Pompa...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Jenis Perawatan</label>
                        <select name="jenis_perawatan" class="form-control">
                            <option value="">-- Semua Jenis --</option>
                            <option value="P1" {{ request('jenis_perawatan') == 'P1' ? 'selected' : '' }}>P1</option>
                            <option value="P3" {{ request('jenis_perawatan') == 'P3' ? 'selected' : '' }}>P3</option>
                            <option value="P6" {{ request('jenis_perawatan') == 'P6' ? 'selected' : '' }}>P6</option>
                            <option value="P12" {{ request('jenis_perawatan') == 'P12' ? 'selected' : '' }}>P12</option>
                            <option value="Unscheduled"
                                {{ request('jenis_perawatan') == 'Unscheduled' ? 'selected' : '' }}>
                                Unscheduled</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search me-1"></i> Cari</button>
                        <a href="{{ route('pompa.index') }}" class="btn btn-secondary"><i
                                class="fa fa-rotate-left"></i></a>
                    </div>
                </div>
            </form>
        </div>

        {{-- FORM BULK DELETE & TABLE --}}
        <form action="{{ route('pompa.bulk-destroy') }}" method="POST" id="form-bulk-delete">
            @csrf
            <div class="table-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark m-0"><i class="fa-solid fa-list me-2"></i>Daftar Checksheet Pompa</h5>
                    <button type="button" class="btn btn-danger btn-modern" id="btn-delete-selected" style="display: none;"
                        onclick="confirmBulkDelete()">
                        <i class="fa-solid fa-trash me-1"></i> Hapus Terpilih (<span id="selected-count">0</span>)
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom-grid align-middle">
                        <thead>
                            <tr>
                                <th class="col-checkbox">
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                </th>
                                <th class="text-center" style="width: 50px;">NO</th>
                                <th>JUDUL</th>
                                <th>JENIS PERAWATAN</th>
                                <th>NO POMPA</th>
                                <th>NO ASET</th>
                                <th>LOKASI</th>
                                <th>TANGGAL</th>
                                <th>KESIMPULAN</th>
                                <th class="text-center">SCAN CHECKSHEET</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $i => $d)
                                <tr>
                                    <td class="col-checkbox">
                                        <input type="checkbox" name="ids[]" value="{{ $d->id }}"
                                            class="form-check-input check-item">
                                    </td>
                                    <td class="text-center fw-bold">{{ $i + 1 }}</td>
                                    <td>
                                        <strong>{{ $d->judul }}</strong>
                                        @if ($d->jenis_perawatan == 'Unscheduled' && $d->no_form_unscheduled)
                                            <br><small class="text-muted">Form: {{ $d->no_form_unscheduled }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span
                                            class="{{ $d->jenis_perawatan == 'Unscheduled' ? 'badge-unscheduled' : 'badge-jenis' }}">
                                            {{ $d->jenis_perawatan }}
                                        </span>
                                    </td>
                                    <td>{{ $d->no_pompa ?? '-' }}</td>
                                    <td>{{ $d->no_aset ?? '-' }}</td>
                                    <td>{{ $d->lokasi ?? '-' }}</td>
                                    <td>{{ $d->tanggal_pelaksanaan ? \Carbon\Carbon::parse($d->tanggal_pelaksanaan)->format('d/m/Y') : '-' }}
                                    </td>

                                    {{-- KOLOM KESIMPULAN --}}
                                    <td>
                                        <span
                                            class="badge {{ $d->kesimpulan == 'SO' ? 'bg-success' : (in_array($d->kesimpulan, ['SO DENGAN CATATAN', 'SO_NOTE']) ? 'bg-warning text-dark' : ($d->kesimpulan == 'TSO' ? 'bg-danger' : 'bg-secondary')) }}">
                                            {{ $d->kesimpulan ?? 'Belum Diisi' }}
                                        </span>
                                    </td>

                                    {{-- KOLOM DOKUMEN LAMPIRAN --}}
                                    <td class="text-center">
                                        <div class="action-group">
                                            @if ($d->dokumen)
                                                <a href="{{ asset('storage/' . $d->dokumen) }}" target="_blank"
                                                    class="btn btn-outline-primary" title="Lihat Dokumen">
                                                    <i class="fa fa-file-lines me-1"></i> Lihat
                                                </a>

                                                <button type="button" class="btn btn-outline-danger"
                                                    onclick="deleteSingleDoc('{{ route('pompa.delete.dokumen', $d->id) }}')"
                                                    title="Hapus Dokumen">
                                                    <i class="fa fa-xmark"></i>
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#uploadModal{{ $d->id }}">
                                                    <i class="fa fa-paperclip me-1"></i> Upload
                                                </button>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- KOLOM AKSI --}}
                                    <td class="text-center">
                                        <div class="action-group">
                                            @if ($d->jenis_perawatan != 'Unscheduled')
                                                <a href="{{ route('pompa.mobile', $d->id) }}" class="btn btn-success"
                                                    title="Isi Checksheet">
                                                    <i class="fa fa-mobile-screen me-1"></i> Isi
                                                </a>
                                            @endif
                                            <a href="{{ route('pompa.show', $d->id) }}" class="btn btn-info text-white"
                                                title="Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('pompa.edit', $d->id) }}"
                                                class="btn btn-warning text-white" title="Edit">
                                                <i class="fa fa-pen"></i>
                                            </a>

                                            @if ($d->jenis_perawatan != 'Unscheduled')
                                                <button type="button" class="btn btn-dark" title="Duplikasi Format"
                                                    onclick="duplicateSingle('{{ route('pompa.duplicate', $d->id) }}')">
                                                    <i class="fa fa-clone"></i>
                                                </button>
                                            @endif

                                            <a href="{{ route('pompa.print', $d->id) }}" target="_blank"
                                                class="btn btn-secondary" title="Cetak">
                                                <i class="fa fa-print"></i>
                                            </a>

                                            <button type="button" class="btn btn-danger" title="Hapus"
                                                onclick="deleteSingle('{{ route('pompa.destroy', $d->id) }}')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-4 text-muted">Belum ada data checksheet
                                        Pompa.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>

    {{-- MODAL UPLOAD DOKUMEN --}}
    @foreach ($data as $d)
        @if (!$d->dokumen)
            <div class="modal fade" id="uploadModal{{ $d->id }}" tabindex="-1"
                aria-labelledby="uploadModalLabel{{ $d->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 16px;">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="uploadModalLabel{{ $d->id }}">
                                <i class="fa fa-upload me-1 text-primary"></i> Upload Dokumen Lampiran
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ route('pompa.upload.dokumen', $d->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <p class="mb-2 text-muted small">
                                    Checksheet: <strong>{{ $d->judul }}</strong> ({{ $d->no_pompa ?? '-' }})
                                </p>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Pilih File (PDF, DOC, XLS, Gambar)</label>
                                    <input type="file" name="dokumen" class="form-control"
                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" required>
                                    <div class="form-text text-muted">Maksimal ukuran file: 60MB</div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-upload me-1"></i> Simpan Dokumen
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    {{-- FORM TERSEMBUNYI UNTUK AKSI SINGLE --}}
    <form id="form-single-action" method="POST" style="display: none;">
        @csrf
        <div id="form-method-container"></div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto hide alert
            const alertElement = document.getElementById('success-alert');
            if (alertElement) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alertElement);
                    bsAlert.close();
                }, 3000);
            }

            // Bulk Delete Checkbox Logic
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.check-item');
            const btnDeleteSelected = document.getElementById('btn-delete-selected');
            const selectedCount = document.getElementById('selected-count');

            function updateDeleteButton() {
                const checkedCount = document.querySelectorAll('.check-item:checked').length;
                selectedCount.textContent = checkedCount;

                if (checkedCount > 0) {
                    btnDeleteSelected.style.display = 'inline-block';
                } else {
                    btnDeleteSelected.style.display = 'none';
                }
            }

            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = this.checked);
                    updateDeleteButton();
                });
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    if (!this.checked && selectAll.checked) {
                        selectAll.checked = false;
                    }
                    updateDeleteButton();
                });
            });
        });

        function confirmBulkDelete() {
            const checkedCount = document.querySelectorAll('.check-item:checked').length;
            if (confirm(`Apakah Anda yakin ingin menghapus ${checkedCount} data checksheet yang dipilih?`)) {
                document.getElementById('form-bulk-delete').submit();
            }
        }

        function deleteSingle(url) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                const form = document.getElementById('form-single-action');
                form.action = url;
                document.getElementById('form-method-container').innerHTML = '@method('DELETE')';
                form.submit();
            }
        }

        function deleteSingleDoc(url) {
            if (confirm('Hapus dokumen lampiran ini?')) {
                const form = document.getElementById('form-single-action');
                form.action = url;
                document.getElementById('form-method-container').innerHTML = '@method('DELETE')';
                form.submit();
            }
        }

        function duplicateSingle(url) {
            if (confirm('Duplikasi format checksheet ini?')) {
                const form = document.getElementById('form-single-action');
                form.action = url;
                document.getElementById('form-method-container').innerHTML = '';
                form.submit();
            }
        }
    </script>
@endsection
