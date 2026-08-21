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
            display: flex;
            gap: 6px;
            justify-content: center;
            align-items: center;
            flex-wrap: nowrap;
        }

        .btn-action {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .btn-action:hover {
            color: white;
            opacity: 0.85;
        }

        .btn-mobile-modern {
            border-radius: 12px;
            padding: 8px 12px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            border: none;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white;
            text-decoration: none;
        }

        .btn-mobile-modern:hover {
            color: white;
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
                                            {{-- Mengambil No FCU dari relasi unscheduledForm --}}
                                            <span class="badge-modern">
                                                {{ $d->unscheduledForm->no_fcu ?? ($d->no_fcu ?? '-') }}
                                            </span>
                                        @else
                                            {{-- Untuk perawatan terjadwal (P1, P3, P6, P12) --}}
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
                                <td>
                                    <div class="action-group">
                                        {{-- Tombol Isi Checksheet --}}
                                        <a href="{{ route('fcu.mobile', $d->id) }}" class="btn-mobile-modern"
                                            title="Isi Checksheet">
                                            <i class="fa fa-circle-check"></i> Checksheet
                                        </a>

                                        {{-- Tombol Show (Detail) --}}
                                        <a href="{{ route('fcu.show', $d->id) }}" class="btn-action bg-info"
                                            title="Lihat Detail">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        {{-- Tombol Copy (Duplikat Format) --}}
                                        <form action="{{ route('fcu.copy', $d->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit"
                                                onclick="return confirm('Duplikat format monitoring ini?')"
                                                class="btn-action bg-warning text-dark" title="Copy Format">
                                                <i class="fa fa-copy"></i>
                                            </button>
                                        </form>

                                        {{-- Tombol Print (Cetak/PDF) --}}
                                        <a href="{{ route('fcu.print', $d->id) }}" target="_blank"
                                            class="btn-action bg-secondary" title="Cetak / PDF">
                                            <i class="fa fa-print"></i>
                                        </a>

                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('fcu.edit', $d->id) }}" class="btn-action bg-primary"
                                            title="Edit">
                                            <i class="fa fa-pen"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('fcu.destroy', $d->id) }}" method="POST" class="d-inline">
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
@endsection
