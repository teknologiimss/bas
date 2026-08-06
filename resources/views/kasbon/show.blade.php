@extends('layouts.main')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')
    <style>
        /* Theme Variables & Base Styles */
        :root {
            --navy-dark: #0a192f;
            --navy-main: #1e293b;
            --navy-card: #0f172a;
            --accent-blue: #38bdf8;
            --accent-glow: rgba(56, 189, 248, 0.25);
        }

        /* Header & General Layout */
        .content-header {
            padding: 20px 0;
        }

        .custom-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .custom-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.12);
        }

        /* Navy Header Styling */
        .navy-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #ffffff;
            border-top-left-radius: 12px !important;
            border-top-right-radius: 12px !important;
            padding: 16px 20px;
        }

        /* Animated Interactive Buttons */
        .btn-navy-primary {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-navy-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(29, 78, 216, 0.4);
        }

        /* Subtle Pulse Effect for Add Button */
        .btn-pulse {
            animation: pulse-glow 2s infinite;
        }

        @keyframes pulse-glow {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(37, 99, 235, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(37, 99, 235, 0);
            }
        }

        /* Custom Badges & Tags */
        .badge-navy {
            background: #1e293b;
            color: #38bdf8;
            border: 1px solid rgba(56, 189, 248, 0.3);
            border-radius: 6px;
        }

        /* Animated Info Box Components */
        .stat-card {
            border-radius: 10px;
            padding: 16px;
            color: #ffffff;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px) scale(1.02);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            transition: all 0.5s ease;
        }

        .stat-card:hover::after {
            transform: rotate(45deg) translate(50%, 50%);
        }

        .bg-stat-masuk {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        }

        .bg-stat-keluar {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        }

        .bg-stat-selisih {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
        }

        .bg-stat-deviasi {
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
        }

        /* Mobile Responsive Optimizations */
        @media (max-width: 767.98px) {
            .mobile-header-stack {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 12px;
            }

            .mobile-btn-block {
                width: 100%;
                display: flex;
                justify-content: space-between;
            }

            .mobile-btn-block .btn {
                flex: 1;
            }

            .table-responsive {
                border: 0;
            }
        }

        /* Smooth Fade-In Animation for Content */
        .fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
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
    </style>

    <div class="content-header fade-in-up">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-md-7 col-12 mb-2 mb-md-0">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <a href="{{ route('kasbon.index') }}" class="btn btn-outline-dark btn-sm mr-2 shadow-sm"
                            style="border-radius: 6px;">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        <h1 class="m-0 font-weight-bold text-dark h4">{{ $folder->judul }}</h1>
                    </div>
                </div>
                <div class="col-md-5 col-12 text-md-right text-left">
                    <div class="d-flex align-items-center justify-content-md-end justify-content-between">
                        <a href="{{ route('kasbon.printPdf', $folder->id) }}" target="_blank"
                            class="btn btn-danger btn-sm mr-2 shadow-sm">
                            <i class="fas fa-file-pdf mr-1"></i> Cetak PDF
                        </a>
                        <span class="badge badge-navy p-2 shadow-sm" style="font-size: 13px;">
                            <i class="fas fa-bookmark mr-1"></i> PO/Nota: {{ $folder->po_nota_dinas }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="content fade-in-up">
        <div class="container-fluid">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert"
                    style="border-left: 5px solid #10b981 !important;">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert"
                    style="border-left: 5px solid #ef4444 !important;">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card custom-card">
                <div class="card-header navy-header d-flex flex-wrap justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold m-0 h6 text-white">
                        <i class="fas fa-list-alt mr-2 text-info"></i>Daftar Transaksi
                    </h3>
                    <button type="button" class="btn btn-navy-primary btn-sm btn-pulse mt-2 mt-sm-0 ml-auto"
                        data-toggle="modal" data-target="#modalTambahItem">
                        <i class="fas fa-plus-circle mr-1"></i> Tambah Transaksi / Dokumen
                    </button>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped text-nowrap mb-0" id="sortable-table">
                        <thead style="background-color: #f8fafc; color: #334155;">
                            <tr>
                                <th style="width: 40px;" class="text-center"></th>
                                <th style="width: 50px;" class="text-center">No</th>
                                <th>Deskripsi</th>
                                <th>Tanggal</th>
                                <th>Uang Masuk</th>
                                <th>Uang Keluar</th>
                                <th>Dokumen</th>
                                <th>Keterangan</th>
                                <th style="width: 120px;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-tbody">
                            @forelse($folder->items as $index => $item)
                                <tr data-id="{{ $item->id }}">
                                    <td class="text-center align-middle drag-handle" style="cursor: grab;">
                                        <i class="fas fa-grip-vertical text-muted"></i>
                                    </td>
                                    <td class="text-center font-weight-bold row-number">{{ $index + 1 }}</td>
                                    <td style="max-width: 250px; white-space: normal;">{{ $item->deskripsi }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            <i
                                                class="far fa-calendar-alt mr-1"></i>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                                        </span>
                                    </td>
                                    <td class="text-success font-weight-bold">
                                        Rp {{ number_format($item->uang_masuk, 0, ',', '.') }}
                                    </td>
                                    <td class="text-danger font-weight-bold">
                                        Rp {{ number_format($item->uang_keluar, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        @if ($item->dokumen)
                                            <a href="{{ asset('storage/' . $item->dokumen) }}" target="_blank"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-file-alt mr-1"></i>Lihat
                                            </a>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td style="max-width: 200px; white-space: normal;">{{ $item->keterangan ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5 text-muted">
                                        <i class="fas fa-folder-open fa-2x mb-2 d-block text-secondary"></i>
                                        Belum ada rincian transaksi di dalam kasbon ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer" style="background-color: #f8fafc; border-top: 1px solid #e2e8f0;">
                    <h6 class="mb-3 font-weight-bold text-dark">
                        <i class="fas fa-chart-pie mr-2 text-primary"></i>Ringkasan Total & Selisih:
                    </h6>
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <div class="stat-card bg-stat-masuk shadow-sm">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-uppercase small font-weight-bold opacity-75">Total Masuk</div>
                                        <div class="h5 font-weight-bold mb-0 mt-1">Rp
                                            {{ number_format($totalMasuk, 0, ',', '.') }}</div>
                                    </div>
                                    <i class="fas fa-arrow-down fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <div class="stat-card bg-stat-keluar shadow-sm">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-uppercase small font-weight-bold opacity-75">Total Keluar</div>
                                        <div class="h5 font-weight-bold mb-0 mt-1">Rp
                                            {{ number_format($totalKeluar, 0, ',', '.') }}</div>
                                    </div>
                                    <i class="fas fa-arrow-up fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <div class="stat-card bg-stat-selisih shadow-sm">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-uppercase small font-weight-bold opacity-75">Selisih (Sisa)</div>
                                        <div class="h5 font-weight-bold mb-0 mt-1">Rp
                                            {{ number_format($selisih, 0, ',', '.') }}</div>
                                    </div>
                                    <i class="fas fa-calculator fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <div class="stat-card bg-stat-deviasi shadow-sm">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-uppercase small font-weight-bold opacity-75">Deviasi</div>
                                        <div class="h5 font-weight-bold mb-0 mt-1">{{ number_format($persen, 2) }}%</div>
                                    </div>
                                    <i class="fas fa-percentage fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Hidden Form Delete Items & Documents -->
    @foreach ($folder->items as $item)
        <form id="delete-item-{{ $item->id }}" action="{{ route('kasbon.item.destroy', $item->id) }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

        @if ($item->dokumen && count((array) $item->dokumen) > 0)
            @foreach ((array) $item->dokumen as $docIndex => $docPath)
                <form id="delete-doc-{{ $item->id }}-{{ $docIndex }}"
                    action="{{ route('kasbon.item.destroyDoc', $item->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="file_name" value="{{ $docPath }}">
                </form>
            @endforeach
        @endif
    @endforeach

    <!-- MODAL TAMBAH LAMPIRAN KHUSUS (Direct Upload) -->
    @foreach ($folder->items as $item)
        <div class="modal fade" id="modalUploadDoc{{ $item->id }}" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                    <div class="modal-header navy-header">
                        <h5 class="modal-title font-weight-bold text-white">
                            <i class="fas fa-paperclip mr-2 text-info"></i>Tambah Lampiran Dokumen
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="{{ route('kasbon.item.update', $item->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Field Tersembunyi agar data lama tidak ter-overwrite saat update -->
                        <input type="hidden" name="deskripsi" value="{{ $item->deskripsi }}">
                        <input type="hidden" name="tanggal"
                            value="{{ \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') }}">
                        <input type="hidden" name="uang_masuk" value="{{ $item->uang_masuk }}">
                        <input type="hidden" name="uang_keluar" value="{{ $item->uang_keluar }}">
                        <input type="hidden" name="keterangan" value="{{ $item->keterangan }}">

                        <div class="modal-body p-4 text-left">
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-dark">Transaksi:</label>
                                <div class="p-2 bg-light rounded border text-muted" style="font-size: 14px;">
                                    {{ $item->deskripsi }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold text-dark">Pilih File Lampiran Baru <span
                                        class="text-danger">*</span></label>
                                <input type="file" name="dokumen[]" class="form-control-file p-2 border rounded"
                                    multiple required style="border-radius: 8px;">
                                <small class="form-text text-muted mt-2">
                                    <i class="fas fa-info-circle mr-1 text-primary"></i> Anda dapat memilih <b>lebih dari 1
                                        file</b> sekaligus (Tahan tombol Ctrl / Shift saat memilih file).
                                </small>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                style="border-radius: 6px;">Batal</button>
                            <button type="submit" class="btn btn-navy-primary px-4">Upload Lampiran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- MODAL EDIT ITEMS -->
    @foreach ($folder->items as $item)
        <div class="modal fade" id="modalEditItem{{ $item->id }}" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                    <div class="modal-header navy-header">
                        <h5 class="modal-title font-weight-bold text-white"><i
                                class="fas fa-edit mr-2 text-warning"></i>Edit Transaksi Kasbon</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="{{ route('kasbon.item.update', $item->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body p-4 text-left">
                            <div class="form-group">
                                <label class="font-weight-bold">Deskripsi Transaksi <span
                                        class="text-danger">*</span></label>
                                <textarea name="deskripsi" class="form-control" rows="2" required style="border-radius: 8px;">{{ $item->deskripsi }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-12 form-group">
                                    <label class="font-weight-bold">Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal" class="form-control"
                                        style="border-radius: 8px;"
                                        value="{{ \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-4 col-12 form-group">
                                    <label class="font-weight-bold">Uang Masuk (Rp)</label>
                                    <input type="number" name="uang_masuk" class="form-control"
                                        style="border-radius: 8px;" value="{{ $item->uang_masuk }}" min="0">
                                </div>
                                <div class="col-md-4 col-12 form-group">
                                    <label class="font-weight-bold">Uang Keluar (Rp)</label>
                                    <input type="number" name="uang_keluar" class="form-control"
                                        style="border-radius: 8px;" value="{{ $item->uang_keluar }}" min="0">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Tambah Dokumen Baru</label>
                                <input type="file" name="dokumen[]" class="form-control-file p-1 border rounded"
                                    multiple style="border-radius: 8px;">
                                <small class="form-text text-muted">Abaikan jika tidak ingin menambah/mengubah
                                    file.</small>
                            </div>

                            @if ($item->dokumen && count((array) $item->dokumen) > 0)
                                <div class="form-group">
                                    <label class="font-weight-bold">Dokumen Ter-upload Saat Ini:</label>
                                    <ul class="list-group">
                                        @foreach ((array) $item->dokumen as $docIndex => $docPath)
                                            <li class="list-group-item d-flex justify-content-between align-items-center p-2"
                                                style="border-radius: 6px;">
                                                <a href="{{ asset('img/' . $docPath) }}" target="_blank"
                                                    class="text-primary">
                                                    <i class="fas fa-file-alt mr-1"></i> Dokumen {{ $docIndex + 1 }}
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger border-0"
                                                    onclick="if(confirm('Yakin ingin menghapus dokumen ini?')) document.getElementById('delete-doc-{{ $item->id }}-{{ $docIndex }}').submit();">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group">
                                <label class="font-weight-bold">Keterangan</label>
                                <textarea name="keterangan" autocomplete="off" class="form-control" rows="2" style="border-radius: 8px;">{{ $item->keterangan }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                style="border-radius: 6px;">Batal</button>
                            <button type="submit" class="btn btn-warning font-weight-bold text-dark"
                                style="border-radius: 6px;">Update Transaksi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- MODAL TAMBAH ITEM -->
    <div class="modal fade" id="modalTambahItem" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header navy-header">
                    <h5 class="modal-title font-weight-bold text-white"><i
                            class="fas fa-plus-circle mr-2 text-info"></i>Tambah Transaksi Kasbon</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('kasbon.item.store', $folder->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Deskripsi Transaksi <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" class="form-control" rows="2" placeholder="Masukkan deskripsi transaksi..."
                                required style="border-radius: 8px;"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-12 form-group">
                                <label class="font-weight-bold">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" class="form-control" required
                                    style="border-radius: 8px;">
                            </div>
                            <div class="col-md-4 col-12 form-group">
                                <label class="font-weight-bold">Uang Masuk (Rp)</label>
                                <input type="number" name="uang_masuk" class="form-control" placeholder="0"
                                    value="0" min="0" style="border-radius: 8px;">
                            </div>
                            <div class="col-md-4 col-12 form-group">
                                <label class="font-weight-bold">Uang Keluar (Rp)</label>
                                <input type="number" name="uang_keluar" class="form-control" placeholder="0"
                                    value="0" min="0" style="border-radius: 8px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Upload Dokumen</label>
                            <input type="file" name="dokumen[]" class="form-control-file p-1 border rounded" multiple
                                style="border-radius: 8px;">
                            <small class="form-text text-muted">Gunakan tombol Shift/Ctrl saat memilih untuk mengunggah
                                beberapa dokumen sekaligus.</small>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Keterangan</label>
                            <textarea name="keterangan" autocomplete="off" class="form-control" rows="2"
                                placeholder="Catatan tambahan (opsional)" style="border-radius: 8px;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            style="border-radius: 6px;">Batal</button>
                        <button type="submit" class="btn btn-navy-primary px-4">Simpan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CDN SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <!-- Script Drag & Drop dan Update AJAX -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tbody = document.getElementById('sortable-tbody');
            if (!tbody) return;

            Sortable.create(tbody, {
                handle: '.drag-handle', // Drag hanya berlaku jika memegang icon grip
                animation: 150,
                ghostClass: 'table-active', // Efek warna highlight saat baris ditarik
                onEnd: function() {
                    const rows = tbody.querySelectorAll('tr[data-id]');
                    const orderData = [];

                    // Update penomoran angka 'No' di tabel secara real-time
                    rows.forEach((row, index) => {
                        const numberCell = row.querySelector('.row-number');
                        if (numberCell) {
                            numberCell.textContent = index + 1;
                        }

                        // Masukkan data ID dan posisi baru ke array
                        orderData.push({
                            id: row.getAttribute('data-id'),
                            position: index + 1
                        });
                    });

                    // Kirim urutan baru ke backend Laravel via Fetch API
                    fetch("{{ route('kasbon.item.reorder') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                order: orderData
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (!data.success) {
                                alert('Gagal menyimpan urutan data.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan jaringan.');
                        });
                }
            });
        });
    </script>
@endsection
