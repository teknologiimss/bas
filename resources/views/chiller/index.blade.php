@extends('layouts.main')

@section('content')
    {{-- Script Bootstrap 5 untuk fungsionalitas Modal & Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background: #eef4fb;
            font-family: 'Segoe UI', sans-serif;
        }

        .top-card {
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            border-radius: 24px;
            padding: 24px;
            color: white;
        }

        .table-card {
            background: white;
            border-radius: 24px;
            padding: 20px;
            margin-top: 20px;
        }

        .badge-jenis {
            background: #dbeafe;
            color: #1e3a8a;
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
        {{-- Flash Message dengan ID success-alert --}}
        @if (session('success'))
            <div id="success-alert" class="alert alert-success alert-dismissible fade show rounded-3 mb-3" role="alert">
                <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="top-card d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1">❄️ Checksheet Chiller AC</h3>
                <p class="mb-0 text-white-50">Monitoring & Pemeliharaan Unit Chiller</p>
            </div>
            <a href="{{ route('chiller.create') }}" class="btn btn-light rounded-pill px-4 font-weight-bold">
                <i class="fa fa-plus me-1"></i> Buat Checksheet
            </a>
        </div>

        {{-- Filter --}}
        <div class="table-card mb-3">
            <form method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">No Chiller</label>
                        <input type="text" name="no_chiller" value="{{ request('no_chiller') }}" class="form-control"
                            placeholder="Cari No Chiller...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">No Aset</label>
                        <input type="text" name="no_aset" value="{{ request('no_aset') }}" class="form-control"
                            placeholder="Cari No Aset...">
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button class="btn btn-primary w-100"><i class="fa fa-search me-1"></i> Cari</button>
                        <a href="{{ route('chiller.index') }}" class="btn btn-secondary"><i
                                class="fa fa-rotate-left"></i></a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="table-card">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th>
                            <th>Judul</th>
                            <th>Jenis Perawatan</th>
                            <th>No Chiller</th>
                            <th>No Aset</th>
                            <th>Lokasi</th>
                            <th>Tanggal</th>
                            <th class="text-center">Scan Checksheet</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $i => $d)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td><strong>{{ $d->judul }}</strong></td>
                                <td><span class="badge-jenis">{{ $d->jenis_perawatan }}</span></td>
                                <td>{{ $d->no_chiller ?? '-' }}</td>
                                <td>{{ $d->no_aset ?? '-' }}</td>
                                <td>{{ $d->lokasi ?? '-' }}</td>
                                <td>{{ $d->tanggal_pelaksanaan ? \Carbon\Carbon::parse($d->tanggal_pelaksanaan)->format('d/m/Y') : '-' }}
                                </td>

                                {{-- KOLOM DOKUMEN LAMPIRAN --}}
                                <td class="text-center">
                                    <div class="action-group">
                                        @if ($d->dokumen)
                                            <a href="{{ asset('storage/' . $d->dokumen) }}" target="_blank"
                                                class="btn btn-outline-primary" title="Lihat Dokumen">
                                                <i class="fa fa-file-lines me-1"></i> Lihat
                                            </a>

                                            <form action="{{ route('chiller.delete.dokumen', $d->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus dokumen lampiran ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Hapus Dokumen">
                                                    <i class="fa fa-xmark"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                                                data-bs-target="#uploadModal{{ $d->id }}">
                                                <i class="fa fa-paperclip me-1"></i> Upload
                                            </button>
                                        @endif
                                    </div>
                                </td>

                                {{-- KOLOM AKSI --}}
                                <td class="text-center">
                                    <div class="action-group">
                                        <a href="{{ route('chiller.mobile', $d->id) }}" class="btn btn-success"
                                            title="Isi Checksheet">
                                            <i class="fa fa-mobile-screen me-1"></i> Isi
                                        </a>
                                        <a href="{{ route('chiller.show', $d->id) }}" class="btn btn-info text-white"
                                            title="Detail">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('chiller.edit', $d->id) }}" class="btn btn-warning text-white"
                                            title="Edit">
                                            <i class="fa fa-pen"></i>
                                        </a>

                                        <form action="{{ route('chiller.duplicate', $d->id) }}" method="POST" onsubmit="return confirm('Duplikasi format checksheet ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-dark" title="Duplikasi Format">
                                                <i class="fa fa-clone"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('chiller.print', $d->id) }}" target="_blank"
                                            class="btn btn-secondary" title="Cetak">
                                            <i class="fa fa-print"></i>
                                        </a>
                                        <form action="{{ route('chiller.destroy', $d->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">Belum ada data checksheet Chiller.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
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
                        <form action="{{ route('chiller.upload.dokumen', $d->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <p class="mb-2 text-muted small">
                                    Checksheet: <strong>{{ $d->judul }}</strong> ({{ $d->no_chiller ?? '-' }})
                                </p>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Pilih File (PDF, DOC, XLS, Gambar)</label>
                                    <input type="file" name="dokumen" class="form-control"
                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" required>
                                    <div class="form-text text-muted">Maksimal ukuran file: 10MB</div>
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

    {{-- Script untuk auto-hide alert --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alertElement = document.getElementById('success-alert');
            if (alertElement) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alertElement);
                    bsAlert.close();
                }, 3000); // Durasi tampil: 3000ms (3 detik)
            }
        });
    </script>
@endsection
