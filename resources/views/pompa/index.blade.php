@extends('layouts.main')

@section('content')
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
    </style>

    <div class="container py-4">
        @if (session('success'))
            <div id="success-alert" class="alert alert-success alert-dismissible fade show rounded-3 mb-3" role="alert">
                <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="top-card d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1">⚙️ Checksheet Pompa</h3>
                <p class="mb-0 text-white-50">Monitoring & Pemeliharaan Unit Pompa</p>
            </div>
            <a href="{{ route('pompa.create') }}" class="btn btn-light rounded-pill px-4 font-weight-bold">
                <i class="fa fa-plus me-1"></i> Buat Checksheet
            </a>
        </div>

        <div class="table-card mb-3">
            <form method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">No Pompa</label>
                        <input type="text" name="no_pompa" value="{{ request('no_pompa') }}" class="form-control"
                            placeholder="Cari No Pompa...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">No Aset</label>
                        <input type="text" name="no_aset" value="{{ request('no_aset') }}" class="form-control"
                            placeholder="Cari No Aset...">
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button class="btn btn-primary w-100"><i class="fa fa-search me-1"></i> Cari</button>
                        <a href="{{ route('pompa.index') }}" class="btn btn-secondary"><i class="fa fa-rotate-left"></i></a>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-card">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Judul</th>
                            <th>Jenis Perawatan</th>
                            <th>No Pompa</th>
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

                                <td class="text-center">
                                    <div class="action-group">
                                        @if ($d->dokumen)
                                            <a href="{{ asset('storage/' . $d->dokumen) }}" target="_blank"
                                                class="btn btn-outline-primary" title="Lihat">
                                                <i class="fa fa-file-lines me-1"></i> Lihat
                                            </a>
                                            <form action="{{ route('pompa.delete.dokumen', $d->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus dokumen ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger"><i
                                                        class="fa fa-xmark"></i></button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                                                data-bs-target="#uploadModal{{ $d->id }}">
                                                <i class="fa fa-paperclip me-1"></i> Upload
                                            </button>
                                        @endif
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="action-group">
                                        @if ($d->jenis_perawatan != 'Unscheduled')
                                            <a href="{{ route('pompa.mobile', $d->id) }}" class="btn btn-success"
                                                title="Isi Checksheet">
                                                <i class="fa fa-mobile-screen me-1"></i> Isi
                                            </a>
                                        @endif
                                        <a href="{{ route('pompa.show', $d->id) }}" class="btn btn-info text-white"><i
                                                class="fa fa-eye"></i></a>
                                        <a href="{{ route('pompa.edit', $d->id) }}" class="btn btn-warning text-white"><i
                                                class="fa fa-pen"></i></a>

                                        @if ($d->jenis_perawatan != 'Unscheduled')
                                            <form action="{{ route('pompa.duplicate', $d->id) }}" method="POST"
                                                onsubmit="return confirm('Duplikasi format ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-dark"><i
                                                        class="fa fa-clone"></i></button>
                                            </form>
                                        @endif

                                        <a href="{{ route('pompa.print', $d->id) }}" target="_blank"
                                            class="btn btn-secondary"><i class="fa fa-print"></i></a>
                                        <form action="{{ route('pompa.destroy', $d->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus data ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">Belum ada data checksheet Pompa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($data as $d)
        @if (!$d->dokumen)
            <div class="modal fade" id="uploadModal{{ $d->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 16px;">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold"><i class="fa fa-upload me-1 text-primary"></i> Upload Dokumen
                                Lampiran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('pompa.upload.dokumen', $d->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Pilih File (PDF, DOC, XLS, Gambar)</label>
                                    <input type="file" name="dokumen" class="form-control"
                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Dokumen</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <!-- Tambahkan Script Auto Dismiss Alert di bawah ini -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const alert = document.getElementById('success-alert');
            if (alert) {
                setTimeout(function() {
                    // Menggunakan Bootstrap Alert instance untuk menghilang dengan animasi
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 3000); // 3000 ms = 3 detik
            }
        });
    </script>
@endsection
