@extends('layouts.main')

@section('content')
    <style>
        :root {
            --navy-main: #1e3a8a;
            --navy-dark: #0f172a;
            --navy-light: #2563eb;
            --navy-soft: #eff6ff;
            --navy-border: #bfdbfe;
        }

        body {
            background: #f5f7fb;
        }

        .card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 12px 28px rgba(15, 23, 42, .12);
            animation: fadeUp .4s ease;
        }

        .card-header {
            background: linear-gradient(135deg, var(--navy-dark), var(--navy-main)) !important;
            color: #fff;
            border: none;
            padding: 18px 25px;
        }

        .card-header h5 {
            margin: 0;
            font-weight: 700;
            letter-spacing: .3px;
            color: #fff;
        }

        .card-body {
            padding: 25px;
            background: #fff;
        }

        label {
            font-weight: 600;
            color: #334155;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #dbe4f0;
            height: 45px;
            transition: .3s;
        }

        .form-control:focus {
            border-color: var(--navy-light);
            box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .15);
        }

        .btn {
            border-radius: 10px;
            font-weight: 600;
            transition: .3s;
        }

        .btn-success {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            border: none;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(37, 99, 235, .35);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #64748b, #475569);
            border: none;
        }

        .btn-secondary:hover {
            box-shadow: 0 8px 18px rgba(71, 85, 105, .30);
        }

        .btn-info {
            background: linear-gradient(135deg, #0284c7, #0ea5e9);
            border: none;
            color: #fff;
        }

        .btn-info:hover {
            color: #fff;
            box-shadow: 0 8px 18px rgba(14, 165, 233, .35);
        }

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

        @media(max-width:768px) {

            .card-body {
                padding: 18px;
            }

            .card-header {
                padding: 16px;
            }

            .card-header h5 {
                font-size: 18px;
            }

            .form-control {
                height: 42px;
                font-size: 13px;
                margin-bottom: 10px;
            }

            .btn {
                width: 100%;
                margin-bottom: 10px;
            }

        }
    </style>

    <div class="container-fluid">

        <div class="card shadow">

            <div class="card-header bg-warning">

                <h5 class="mb-0">

                    EDIT CUTI

                </h5>

            </div>

            <div class="card-body">

                <form action="{{ route('cuti.update', $cuti->id) }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-md-3">

                            <label>Pegawai</label>

                            {{-- <select name="user_id" --}}
                            <select name="nama_pegawai" class="form-control" required>

                                {{-- @foreach ($pegawai as $p)

                                <option value="{{ $p->id }}"
                                    {{ $cuti->user_id == $p->id ? 'selected' : '' }}>

                                    {{ $p->nip ?? '-' }}
                                    -
                                    {{ $p->name }}

                                </option>

                            @endforeach --}}

                                @foreach ($pegawai as $p)
                                    <option value="{{ $p->nama_pegawai }}"
                                        {{ $cuti->nama_pegawai == $p->nama_pegawai ? 'selected' : '' }}>

                                        {{ $p->nama_pegawai }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-2">

                            <label>Jenis</label>

                            <select name="jenis" class="form-control" required>

                                <option value="CT" {{ $cuti->jenis == 'CT' ? 'selected' : '' }}>

                                    CUTI TAHUNAN

                                </option>

                                <option value="CS" {{ $cuti->jenis == 'CS' ? 'selected' : '' }}>

                                    CUTI SAKIT

                                </option>

                                <option value="CP" {{ $cuti->jenis == 'CP' ? 'selected' : '' }}>

                                    CUTI PENTING

                                </option>

                                <option value="CB" {{ $cuti->jenis == 'CB' ? 'selected' : '' }}>

                                    CUTI BESAR

                                </option>

                                <option value="CD" {{ $cuti->jenis == 'CD' ? 'selected' : '' }}>

                                    CUTI DISPENSASI

                                </option>

                            </select>

                        </div>

                        <div class="col-md-2">

                            <label>Tanggal Mulai</label>

                            <input type="date" name="tanggal_mulai" class="form-control"
                                value="{{ $cuti->tanggal_mulai }}" required>

                        </div>

                        <div class="col-md-2">

                            <label>Tanggal Selesai</label>

                            <input type="date" name="tanggal_selesai" class="form-control"
                                value="{{ $cuti->tanggal_selesai }}" required>

                        </div>

                        <div class="col-md-3">

                            <label>Keterangan</label>

                            <input type="text" name="keterangan" class="form-control" value="{{ $cuti->keterangan }}">

                        </div>

                    </div>

                    <div class="row mt-3">

                        <div class="col-md-6">

                            <label>Ganti Lampiran</label>

                            <input type="file" name="lampiran" class="form-control">

                        </div>

                    </div>

                    <br>

                    @if ($cuti->lampiran)
                        <a href="{{ asset('lampiran_cuti/' . $cuti->lampiran) }}" target="_blank" class="btn btn-info">

                            LIHAT LAMPIRAN

                        </a>
                    @endif

                    <button class="btn btn-success">

                        <i class="fas fa-save"></i>

                        UPDATE

                    </button>

                    <a href="{{ route('cuti.index') }}" class="btn btn-secondary">

                        KEMBALI

                    </a>

                </form>

            </div>

        </div>

    </div>
@endsection
