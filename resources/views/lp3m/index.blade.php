@extends('layouts.main')

@section('title', 'Lembar Pekerjaan Perbaikan Perawatan Fasilitas')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')
    <style>
        :root {
            --navy: #0f172a;
            --navy2: #1e3a8a;
            --navy3: #2563eb;
            --bg: #edf4fb;
            --border: #d8e3f0;
            --shadow: 0 8px 25px rgba(15, 23, 42, .08);
        }

        body {
            background: var(--bg);
            font-family: 'Segoe UI', sans-serif;
        }

        .header-title {
            font-size: 18px;
            font-weight: 700;
            line-height: 1.4;
            color: #fff;
        }

        /* CARD STYLE */
        .card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .card-header {
            background: linear-gradient(135deg, var(--navy), var(--navy2)) !important;
            border: none;
            padding: 18px 22px;
        }

        .card-body {
            background: #fff;
        }

        /* BUTTON STYLE */
        .btn {
            border-radius: 10px;
            font-weight: 600;
            transition: .25s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: var(--navy2);
            border-color: var(--navy2);
        }

        .btn-primary:hover {
            background: var(--navy);
            border-color: var(--navy);
        }

        .btn-danger {
            background: #dc2626;
            border-color: #dc2626;
        }

        .btn-secondary {
            background: #334155;
            border-color: #334155;
        }

        .btn-info {
            background: #0284c7;
            border-color: #0284c7;
            color: #fff;
        }

        .btn-warning {
            background: #f59e0b;
            border-color: #f59e0b;
            color: #fff;
        }

        .btn-dark {
            background: var(--navy);
            border-color: var(--navy);
        }

        /* ACTION BUTTON */
        .btn-action {
            width: 100px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 10px;
            transition: .25s;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(15, 23, 42, .18);
        }

        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        /* FORM CONTROL */
        .form-control {
            border-radius: 10px;
            border: 1px solid var(--border);
            height: 42px;
        }

        .form-control:focus {
            border-color: var(--navy2);
            box-shadow: 0 0 0 .15rem rgba(37, 99, 235, .15);
        }

        /* TABLE */
        .table {
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 0;
        }

        .table thead {
            background: #eaf2ff;
        }

        .table thead th {
            border: none;
            color: var(--navy);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .3px;
            padding: 14px;
        }

        .table tbody td {
            vertical-align: middle;
            padding: 14px;
            border-color: #edf2f7;
        }

        .table-hover tbody tr:hover {
            background: #f8fbff;
        }

        /* BADGE */
        .badge-danger {
            background: #dc2626;
            color: #fff;
            padding: 7px 12px;
            border-radius: 30px;
        }

        .badge-success {
            background: #2563eb;
            color: #fff;
            padding: 7px 12px;
            border-radius: 30px;
        }

        /* FILE CARD */
        .file-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 12px;
            transition: .2s;
        }

        .file-card:hover {
            box-shadow: 0 8px 20px rgba(15, 23, 42, .08);
        }

        .file-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--navy);
            word-break: break-word;
        }

        .file-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .btn-file {
            height: 34px;
            min-width: 80px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        /* DASHBOARD STYLES */
        .stat-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: var(--shadow);
            transition: .3s;
            height: 100%;
            display: block;
            text-decoration: none;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(15, 23, 42, .15);
        }

        .stat-value {
            font-size: 28px;
            font-weight: bold;
            color: var(--navy2);
        }

        .stat-title {
            font-size: 13px;
            color: #64748b;
        }

        .scroll-table {
            max-height: 280px;
            overflow-y: auto;
        }

        /* RESPONSIVE */
        @media(max-width:768px) {
            .header-title {
                font-size: 15px;
            }

            .header-actions {
                width: 100%;
            }

            .header-actions .btn {
                flex: 1;
            }

            .btn-action {
                width: 82px;
                height: 34px;
                font-size: 10px;
                padding: 4px;
            }

            .btn-action i {
                font-size: 10px;
            }

            .action-buttons {
                gap: 4px;
            }

            td {
                vertical-align: middle !important;
            }

            .table {
                min-width: 1100px;
            }

            .file-card {
                min-width: 230px;
            }

            .btn-file {
                min-width: 70px;
                font-size: 11px;
            }
        }
    </style>

    <div class="container-fluid mt-3">

        <div class="card shadow-sm border-0 mb-4">
            {{-- HEADER BAR --}}
            <div
                class="card-header bg-danger text-white d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                <h5 class="mb-0 d-flex align-items-center flex-wrap">
                    <i class="fas fa-tools me-2"></i>
                    <span class="header-title">Data Pekerjaan Perbaikan Perawatan Fasilitas</span>
                </h5>

                {{-- DUA TOMBOL DI POJOK KANAN --}}
                <div class="d-flex gap-2 align-items-center ms-auto header-actions">
                    <button class="btn btn-info btn-sm text-light fw-bold" type="button" data-bs-toggle="collapse"
                        data-bs-target="#dashboardCollapse" aria-expanded="false" id="btnToggleDashboard">
                        <i class="fas fa-chart-line me-1"></i> Lihat Dashboard
                    </button>

                    <a href="{{ route('lp3m.create') }}" class="btn btn-secondary btn-sm text-light fw-bold">
                        <i class="fas fa-plus me-1"></i> Buat Data Baru
                    </a>
                </div>
            </div>

            {{-- SECTION DASHBOARD COLLAPSIBLE --}}
            <div class="collapse" id="dashboardCollapse">
                <div class="card-body bg-light border-bottom p-4">
                    <div class="row">
                        {{-- KPI STATS (Bisa Diklik Mengarah ke list_spr) --}}
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('lp3m.spr.list') }}" class="stat-card">
                                <i class="fas fa-database fa-2x text-primary mb-2"></i>
                                <div class="stat-value">{{ $total }}</div>
                                <div class="stat-title">Total Data LP3M</div>
                            </a>
                        </div>

                        <div class="col-md-3 mb-3">
                            <a href="{{ route('lp3m.spr.list', ['status' => 'OPEN']) }}" class="stat-card">
                                <i class="fas fa-folder-open fa-2x text-danger mb-2"></i>
                                <div class="stat-value text-danger">{{ $open }}</div>
                                <div class="stat-title">Status Open</div>
                            </a>
                        </div>

                        <div class="col-md-3 mb-3">
                            <a href="{{ route('lp3m.spr.list', ['status' => 'CLOSED']) }}" class="stat-card">
                                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                <div class="stat-value text-success">{{ $closed }}</div>
                                <div class="stat-title">Status Closed</div>
                            </a>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="stat-card">
                                <i class="fas fa-chart-pie fa-2x text-info mb-2"></i>
                                <div class="stat-value text-info">{{ $progress }}%</div>
                                <div class="stat-title">Tingkat Penyelesaian</div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        {{-- CHART --}}
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 border">
                                <div class="card-header bg-dark text-white fw-bold py-2">
                                    <i class="fas fa-chart-pie me-1"></i> Grafik Status
                                </div>
                                <div class="card-body d-flex align-items-center justify-content-center p-2">
                                    <div style="width: 100%; height: 220px;">
                                        <canvas id="sprChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- TABEL QUICK LIST OPEN --}}
                        <div class="col-md-8 mb-3">
                            <div class="card h-100 border">
                                <div
                                    class="card-header bg-dark text-white fw-bold py-2 d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-exclamation-circle me-1"></i> Daftar LP3M Status OPEN</span>
                                    <a href="{{ route('lp3m.spr.list', ['status' => 'OPEN']) }}"
                                        class="badge bg-danger text-white text-decoration-none">
                                        {{ $openData->count() }} Items (Lihat Semua)
                                    </a>
                                </div>
                                <div class="card-body p-0">
                                    <div class="scroll-table">
                                        <table class="table table-striped table-sm mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No. SPR</th>
                                                    <th>Deskripsi</th>
                                                    <th>Status</th>
                                                    <th>Durasi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($openData as $item)
                                                    <tr>
                                                        <td>{{ $item->spr_no ?? '-' }}</td>
                                                        <td>{{ Str::limit($item->deskripsi, 40) }}</td>
                                                        <td><span class="badge badge-danger">OPEN</span></td>
                                                        <td>{{ $item->created_at->diffInDays(now()) }} Hari</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center py-3">Tidak ada pekerjaan
                                                            berpilihan OPEN</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BODY UTAMA DATA INDEX --}}
            <div class="card-body">

                {{-- SEARCH --}}
                <form action="{{ route('lp3m.index') }}" method="GET" class="mb-3">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-4 col-12">
                            <label class="form-label fw-bold">Cari Deskripsi</label>
                            <input type="text" name="search" class="form-control" autocomplete="off"
                                placeholder="Masukkan deskripsi..." value="{{ request('search') }}">
                        </div>

                        <div class="col-md-3 col-12">
                            <label class="form-label fw-bold">Cari No. SPR</label>
                            <input type="text" name="spr_no" class="form-control" autocomplete="off"
                                placeholder="Masukkan No SPR..." value="{{ request('spr_no') }}">
                        </div>

                        <div class="col-md-2 col-12 d-grid gap-1">
                            <button type="submit" class="btn btn-danger fw-bold">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            <a href="{{ route('lp3m.index') }}" class="btn btn-secondary fw-bold">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-bordered table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>No. SPR</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Tanggal</th>
                                <th>Lampiran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($d->spr_no)
                                            <span>{{ $d->spr_no }}</span>
                                        @else
                                            <span class="text-muted">Belum Ada</span>
                                        @endif
                                    </td>
                                    <td>{{ $d->deskripsi }}</td>
                                    <td>
                                        @if ($d->status == 'OPEN')
                                            <span class="badge badge-danger">OPEN</span>
                                        @else
                                            <span class="badge badge-success">CLOSED</span>
                                        @endif
                                    </td>
                                    <td>{{ $d->keterangan }}</td>
                                    <td>{{ date('d-m-Y H:i', strtotime($d->created_at)) }}</td>
                                    <td style="min-width:280px">
                                        @if ($d->lampiran)
                                            @php
                                                $namaFile = preg_replace('/^\d+_/', '', $d->lampiran);
                                                $ext = strtoupper(pathinfo($d->lampiran, PATHINFO_EXTENSION));
                                            @endphp

                                            <div class="file-card">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="me-2">
                                                        <div class="file-name">
                                                            <i class="fas fa-file-alt text-primary me-1"></i>
                                                            {{ $namaFile }}
                                                        </div>
                                                        <span
                                                            class="badge bg-light text-dark border mt-1">{{ $ext }}</span>
                                                    </div>
                                                </div>

                                                <div class="file-actions">
                                                    <a href="{{ asset('lampiran/' . $d->lampiran) }}" target="_blank"
                                                        class="btn btn-success btn-file">
                                                        <i class="fas fa-eye"></i> Lihat
                                                    </a>

                                                    <form action="{{ route('lp3m.deleteLampiran', $d->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus lampiran ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-file">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @else
                                            <span class="badge bg-secondary">Tidak Ada Lampiran</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-flex flex-wrap action-buttons">
                                            <a href="{{ route('lp3m.form', $d->id) }}"
                                                class="btn btn-primary btn-action">
                                                <i class="fas fa-file-alt"></i> Form
                                            </a>

                                            <a href="{{ route('lp3m.edit', $d->id) }}"
                                                class="btn btn-warning btn-action">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>

                                            <a href="{{ route('lp3m.show', $d->id) }}" class="btn btn-info btn-action">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>

                                            <button type="button" class="btn btn-secondary btn-action btn-upload"
                                                data-id="{{ $d->id }}" data-bs-toggle="modal"
                                                data-bs-target="#uploadLampiranModal">
                                                <i class="fas fa-upload"></i> Upload
                                            </button>

                                            <a href="{{ route('lp3m.print', $d->id) }}" class="btn btn-dark btn-action">
                                                <i class="fas fa-print"></i> Print
                                            </a>

                                            <form action="{{ route('lp3m.destroy', $d->id) }}" method="POST"
                                                style="display:inline-block;"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-action">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-3">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Lampiran --}}
    <div class="modal fade" id="uploadLampiranModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('lp3m.uploadLampiran') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="lampiran_id">

                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Upload Lampiran</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <label class="fw-bold">Pilih File</label>
                        <input type="file" name="lampiran" class="form-control"
                            accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>
                        <small class="text-muted">PDF, JPG, JPEG, PNG, DOC, DOCX</small>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Set ID Lampiran Modal
        document.querySelectorAll('.btn-upload').forEach(function(button) {
            button.addEventListener('click', function() {
                document.getElementById('lampiran_id').value = this.dataset.id;
            });
        });

        // Toggle Teks Tombol Dashboard
        const dashCollapse = document.getElementById('dashboardCollapse');
        const btnToggle = document.getElementById('btnToggleDashboard');

        dashCollapse.addEventListener('shown.bs.collapse', function() {
            btnToggle.innerHTML = '<i class="fas fa-eye-slash me-1"></i> Sembunyikan Dashboard';
        });

        dashCollapse.addEventListener('hidden.bs.collapse', function() {
            btnToggle.innerHTML = '<i class="fas fa-chart-line me-1"></i> Lihat Dashboard';
        });

        // Chart Configuration & Click Handler
        const ctx = document.getElementById('sprChart');
        if (ctx) {
            const sprChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Open', 'Closed'],
                    datasets: [{
                        data: [{{ $open }}, {{ $closed }}],
                        backgroundColor: ['#dc2626', '#2563eb']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    onClick: (evt, activeElements) => {
                        if (activeElements.length > 0) {
                            const index = activeElements[0].index;
                            const status = index === 0 ? 'OPEN' : 'CLOSED';
                            window.location.href = "{{ route('lp3m.spr.list') }}?status=" + status;
                        }
                    }
                }
            });
        }
    </script>
@endsection
