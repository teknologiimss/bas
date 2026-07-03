@extends('layouts.main')

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <style>
        :root {

            --navy-main: #1e3a8a;
            --navy-dark: #0f172a;
            --navy-soft: #eff6ff;
            --navy-border: #bfdbfe;
            --navy-hover: #2563eb;

        }

        body {

            background: #f5f6fa;

        }

        /* =====================================================
                                                   CARD
                                                ===================================================== */

        .cuti-card {

            border: none;
            border-radius: 22px;
            overflow: hidden;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, .08);

            animation: fadeUp .5s ease;

        }

        .cuti-header {

            background: linear-gradient(135deg,
                    var(--navy-dark),
                    var(--navy-main));

            padding: 20px 25px;

            position: relative;

            overflow: hidden;

        }

        .cuti-header::after {

            content: '';

            position: absolute;

            width: 250px;
            height: 250px;

            background: rgba(255, 255, 255, .08);

            border-radius: 50%;

            top: -120px;
            right: -80px;

        }

        .cuti-header h5 {

            font-weight: 700;
            letter-spacing: .5px;

            position: relative;
            z-index: 2;

        }

        /* =====================================================
                                                   FORM
                                                ===================================================== */

        .form-control {

            border-radius: 14px;
            border: 1px solid #ddd;

            height: 45px;

            transition: .3s;

        }

        .form-control:focus {

            border-color: var(--navy-main);

            box-shadow:
                0 0 0 .15rem rgba(37, 99, 235, .15);

        }

        label {

            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;

            color: #444;

        }

        /* =====================================================
                                                   BUTTON
                                                ===================================================== */

        .btn {

            border-radius: 12px;
            transition: .3s;

            font-weight: 600;

        }

        .btn-success {

            background: linear-gradient(135deg,
                    #1e3a8a,
                    #2563eb);

            border: none;

            padding: 10px 20px;

        }

        .btn-success:hover {

            transform: translateY(-2px);

            box-shadow:
                0 8px 20px rgba(37, 99, 235, .35);

        }

        .btn-primary {

            background: linear-gradient(135deg,
                    var(--navy-main),
                    var(--navy-dark));

            border: none;

        }

        .btn-primary:hover {

            background: linear-gradient(135deg,
                    var(--navy-hover),
                    var(--navy-main));

            transform: translateY(-2px);

        }

        .btn-warning {

            border: none;

        }

        .btn-danger {

            border: none;

        }

        /* =====================================================
                                                   TABLE
                                                ===================================================== */

        .table {

            border-radius: 16px;
            overflow: hidden;

            margin-bottom: 0;

        }

        .table thead {

            background: linear-gradient(135deg,
                    var(--navy-dark),
                    var(--navy-main));

            color: white;

        }

        .table th {

            font-size: 13px;
            font-weight: 700;

            border: none;

            white-space: nowrap;

        }

        .table td {

            font-size: 13px;

            vertical-align: middle;

            border-color: #f1f1f1;

        }

        .table tbody tr {

            transition: .25s;

        }

        .table tbody tr:hover {

            background:#eff6ff;

            transform: scale(1.003);

        }

        /* =====================================================
                                                   ALERT
                                                ===================================================== */

        .alert {

            border: none;
            border-radius: 14px;

            animation: fadeDown .4s ease;

        }

        /* =====================================================
                                                   FILTER AREA
                                                ===================================================== */

        .filter-box {

            background: var(--navy-soft);

            border: 1px solid var(--navy-border);

            border-radius: 18px;

            padding: 18px;

            margin-bottom: 20px;

        }

        /* =====================================================
                                                   ACTION BUTTON
                                                ===================================================== */

        .action-group {

            display: flex;
            gap: 5px;
            justify-content: center;

        }

        /* =====================================================
                                                   ANIMATION
                                                ===================================================== */

        @keyframes fadeUp {

            from {

                opacity: 0;
                transform: translateY(20px);

            }

            to {

                opacity: 1;
                transform: translateY(0);

            }

        }

        @keyframes fadeDown {

            from {

                opacity: 0;
                transform: translateY(-20px);

            }

            to {

                opacity: 1;
                transform: translateY(0);

            }

        }

        /* =====================================================
                                                   MOBILE
                                                ===================================================== */

        @media(max-width:768px) {

            .cuti-header {

                padding: 16px;

            }

            .cuti-header h5 {

                font-size: 16px;

            }

            .form-control {

                height: 42px;
                font-size: 12px;

            }

            .table th,
            .table td {

                font-size: 11px;

                padding: 8px;

            }

            .btn {

                font-size: 11px;

            }

            .action-group {

                flex-direction: column;

            }

        }
    </style>

    <div class="container-fluid">

        @if (session('success'))
            <div class="alert alert-success">

                <i class="fas fa-check-circle"></i>

                {{ session('success') }}

            </div>
        @endif

        <div class="card cuti-card">

            {{-- HEADER --}}
            <div class="cuti-header text-white">

                <h5 class="mb-0">

                    <i class="fas fa-calendar-check"></i>

                    INPUT CUTI PEGAWAI MRO

                </h5>

            </div>

            <div class="card-body">

                {{-- FORM INPUT --}}
                <form action="{{ route('cuti.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="row">

                        <div class="col-md-3 mb-3">

                            <label>Pegawai</label>

                            {{-- <select name="user_id"
                            class="form-control"
                            required>

                            <option value="">
                                -- Pilih Pegawai --
                            </option>

                            @foreach ($pegawai as $p)

                                <option value="{{ $p->id }}">

                                    {{ $p->nip ?? '-' }}
                                    -
                                    {{ $p->name }}

                                </option>

                            @endforeach

                        </select> --}}

                            <select name="nama_pegawai" class="form-control" required>

                                <option value="">
                                    -- Pilih Pegawai --
                                </option>

                                @foreach ($pegawai as $p)
                                    <option value="{{ $p->nama_pegawai }}">

                                        {{ $p->nama_pegawai }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-2 mb-3">

                            <label>Jenis</label>

                            <select name="jenis" class="form-control" required>

                                <option value="CT">
                                    CUTI TAHUNAN
                                </option>

                                <option value="CS">
                                    CUTI SAKIT
                                </option>

                                <option value="CP">
                                    CUTI PENTING
                                </option>

                                <option value="CB">
                                    CUTI BESAR
                                </option>

                                <option value="CD">
                                    CUTI DISPENSASI
                                </option>

                            </select>

                        </div>

                        <div class="col-md-2 mb-3">

                            <label>Tanggal Mulai</label>

                            <input type="date" name="tanggal_mulai" class="form-control" required>

                        </div>

                        <div class="col-md-2 mb-3">

                            <label>Tanggal Selesai</label>

                            <input type="date" name="tanggal_selesai" class="form-control" required>

                        </div>

                        <div class="col-md-3 mb-3">

                            <label>Keterangan</label>

                            <input type="text" name="keterangan" class="form-control">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Lampiran</label>

                            <input type="file" name="lampiran" class="form-control">

                            <small class="text-muted">

                                PDF / JPG / PNG / DOCX

                            </small>

                        </div>

                    </div>

                    <button class="btn btn-success">

                        <i class="fas fa-save"></i>

                        Simpan Data

                    </button>

                </form>

                <hr>

                {{-- FILTER --}}
                <div class="filter-box">

                    <form method="GET">

                        <div class="row">

                            <div class="col-md-2 mb-2">

                                <label>Bulan</label>

                                <select name="bulan" class="form-control">

                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>

                                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}

                                        </option>
                                    @endfor

                                </select>

                            </div>

                            <div class="col-md-2 mb-2">

                                <label>Tahun</label>

                                <input type="number" name="tahun" class="form-control" value="{{ $tahun }}">

                            </div>

                            <div class="col-md-2 mb-2 d-flex align-items-end">

                                <button class="btn btn-primary w-100">

                                    <i class="fas fa-search"></i>

                                    FILTER

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

                {{-- TITLE --}}
                <h5 class="mb-3">

                    <i class="fas fa-history" style="color:#1e3a8a"></i>

                    RIWAYAT CUTI

                </h5>

                {{-- TABLE --}}
                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                <th>No</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Lampiran</th>
                                <th width="150">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($cuti as $key => $c)
                                <tr>

                                    <td>

                                        {{ $key + 1 }}

                                    </td>

                                    <td>

                                        {{-- {{ $c->user->name ?? '-' }} --}}
                                        {{ $c->nama_pegawai }}

                                    </td>

                                    <td>

                                        @if ($c->jenis == 'CT')
                                            <span class="badge badge-success p-2">

                                                CT

                                            </span>
                                        @elseif($c->jenis == 'CS')
                                            <span class="badge badge-info p-2">

                                                CS

                                            </span>
                                        @elseif($c->jenis == 'CP')
                                            <span class="badge badge-warning p-2">

                                                CP

                                            </span>
                                        @elseif($c->jenis == 'CD')
                                            <span class="badge badge-secondary p-2">

                                                CD

                                            </span>
                                        @else
                                            <span class="badge badge-danger p-2">

                                                CB

                                            </span>
                                        @endif

                                    </td>

                                    <td>

                                        {{ \Carbon\Carbon::parse($c->tanggal_mulai)->format('d/m/Y') }}

                                        <br>

                                        <small class="text-muted">

                                            s/d

                                        </small>

                                        <br>

                                        {{ \Carbon\Carbon::parse($c->tanggal_selesai)->format('d/m/Y') }}

                                    </td>

                                    <td>

                                        {{ $c->keterangan }}

                                    </td>

                                    <td>

                                        @if ($c->lampiran)
                                            <a href="{{ asset('lampiran_cuti/' . $c->lampiran) }}" target="_blank"
                                                class="btn btn-sm btn-primary">

                                                <i class="fas fa-file"></i>

                                                LIHAT

                                            </a>
                                        @else
                                            <span class="text-muted">

                                                -

                                            </span>
                                        @endif

                                    </td>

                                    <td>

                                        <div class="action-group">

                                            <a href="{{ route('cuti.edit', $c->id) }}" class="btn btn-warning btn-sm">

                                                <i class="fas fa-edit"></i>

                                            </a>

                                            <form action="{{ route('cuti.destroy', $c->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin hapus data cuti ini?')">

                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-danger btn-sm">

                                                    <i class="fas fa-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="7" class="text-center text-muted">

                                        Tidak ada data cuti

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
@endsection
