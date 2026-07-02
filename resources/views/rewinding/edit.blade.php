@extends('layouts.main')

@section('title', 'Edit Rewinding')

<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')
    <style>
        body {
            background: #f4f6fb;
        }

        .card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(11, 31, 58, 0.10);
            animation: fadeUp .5s ease;
        }

        .card-header {
            background: linear-gradient(135deg, #0b1f3a, #163b69) !important;
            color: #fff;
            border: none;
            padding: 18px 24px;
        }

        .card-header h4 {
            margin: 0;
            font-weight: 700;
            letter-spacing: .4px;
        }

        .card-body {
            padding: 28px;
            background: #fff;
        }

        label {
            font-weight: 600;
            color: #1f2d3d;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #d5dbe7;
            padding: 10px 12px;
            transition: .25s;
            box-shadow: none !important;
        }

        .form-control:focus {
            border-color: #163b69;
            box-shadow: 0 0 0 .2rem rgba(22, 59, 105, .15) !important;
        }

        textarea.form-control {
            min-height: 100px;
        }

        .alert-success {
            background: #e8f5e9;
            border: 1px solid #c8e6c9;
            color: #2e7d32;
            border-radius: 10px;
        }

        .alert-info {
            background: #eef5ff;
            border: 1px solid #c7d7ef;
            color: #163b69;
            border-radius: 10px;
        }

        /* Badge Status */
        .badge-success {
            background: #163b69 !important;
            color: #fff;
            border-radius: 30px;
            font-size: 12px;
            padding: 8px 14px !important;
        }

        .badge-warning {
            background: #355c8c !important;
            color: #fff;
            border-radius: 30px;
            font-size: 12px;
            padding: 8px 14px !important;
        }

        /* BUTTON */
        .btn {
            border-radius: 10px;
            font-weight: 600;
            transition: .25s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-danger {
            background: linear-gradient(135deg, #0b1f3a, #163b69);
            border: none;
            color: #fff;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #08172d, #102f55);
        }

        .btn-primary {
            background: linear-gradient(135deg, #244d7d, #163b69);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #163b69, #0b1f3a);
        }

        .btn-success {
            background: linear-gradient(135deg, #204d74, #163b69);
            border: none;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #163b69, #0b1f3a);
        }

        .btn-warning {
            background: linear-gradient(135deg, #355c8c, #244d7d);
            border: none;
            color: #fff;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #244d7d, #163b69);
            color: #fff;
        }

        .btn-secondary {
            background: #6c7a89;
            border: none;
        }

        .btn-secondary:hover {
            background: #566270;
        }

        hr {
            margin: 30px 0;
            border-top: 2px dashed #d8e0ec;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width:768px) {

            .card-body {
                padding: 18px;
            }

            .card-header h4 {
                font-size: 20px;
            }

            .btn {
                width: 100%;
                margin-bottom: 10px;
            }

            .d-inline {
                display: block !important;
                width: 100%;
            }

            .d-inline .btn {
                width: 100%;
            }
        }
    </style>

    <div class="card shadow">


        <div class="card-header bg-danger text-white">
            <h4>
                <i class="fas fa-edit"></i>
                Edit Data Rewinding
            </h4>
        </div>

        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('rewinding.update', $rewinding->id) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>No SJN</label>
                        <input type="text" name="no_sjn" autocomplete="off" class="form-control"
                            value="{{ $rewinding->no_sjn }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>No SPPJP</label>
                        <input type="text" name="no_sppjp" autocomplete="off" class="form-control"
                            value="{{ $rewinding->no_sppjp }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Tanggal SJN Keluar</label>
                        <input type="date" name="tanggal_sjn_keluar" class="form-control"
                            value="{{ $rewinding->tanggal_sjn_keluar }}" required>
                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Lampiran SJN Keluar</label>

                        <input type="file" name="lampiran_sjn_keluar" class="form-control">

                        @if ($rewinding->lampiran_sjn_keluar)
                            <div class="alert alert-info mt-2">

                                <strong>File Saat Ini :</strong>

                                <br>

                                {{ $rewinding->nama_lampiran_keluar }}

                            </div>

                            <a href="{{ asset($rewinding->lampiran_sjn_keluar) }}" target="_blank"
                                class="btn btn-success btn-sm">

                                <i class="fas fa-eye"></i>
                                Lihat

                            </a>

                            <a href="{{ asset($rewinding->lampiran_sjn_keluar) }}" download class="btn btn-primary btn-sm">

                                <i class="fas fa-download"></i>
                                Download

                            </a>
                        @endif

                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Tanggal SJN Masuk</label>
                        <input type="date" name="tanggal_sjn_masuk" class="form-control"
                            value="{{ $rewinding->tanggal_sjn_masuk }}">
                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Lampiran SJN Masuk</label>

                        <input type="file" name="lampiran_sjn_masuk" class="form-control">

                        @if ($rewinding->lampiran_sjn_masuk)
                            <div class="alert alert-info mt-2">

                                <strong>File Saat Ini :</strong>

                                <br>

                                {{ $rewinding->nama_lampiran_masuk }}

                            </div>

                            <a href="{{ asset($rewinding->lampiran_sjn_masuk) }}" target="_blank"
                                class="btn btn-success btn-sm">

                                <i class="fas fa-eye"></i>
                                Lihat

                            </a>

                            <a href="{{ asset($rewinding->lampiran_sjn_masuk) }}" download class="btn btn-primary btn-sm">

                                <i class="fas fa-download"></i>
                                Download

                            </a>
                        @endif

                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" rows="3" autocomplete="off" class="form-control">{{ $rewinding->deskripsi }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" rows="3" autocomplete="off" class="form-control">{{ $rewinding->keterangan }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">

                        <label>Status</label>

                        <div>

                            @if ($rewinding->status == 'Closed')
                                <span class="badge badge-success p-2">
                                    CLOSED
                                </span>
                            @else
                                <span class="badge badge-warning p-2">
                                    OPEN
                                </span>
                            @endif

                        </div>

                        <small class="text-muted">
                            Status otomatis CLOSED jika Lampiran SJN Masuk sudah diupload.
                        </small>

                    </div>

                </div>

                <button type="submit" class="btn btn-danger">

                    <i class="fas fa-save"></i>
                    Update

                </button>

                <a href="{{ route('rewinding.index') }}" class="btn btn-secondary">

                    Kembali

                </a>

            </form>

            <hr>

            {{-- HAPUS LAMPIRAN SJN KELUAR --}}
            @if ($rewinding->lampiran_sjn_keluar)
                <form action="{{ route('rewinding.hapusLampiranKeluar', $rewinding->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Hapus lampiran SJN keluar?')">

                    @csrf

                    <button class="btn btn-danger">

                        <i class="fas fa-trash"></i>

                        Hapus Lampiran Keluar

                    </button>

                </form>
            @endif

            {{-- HAPUS LAMPIRAN SJN MASUK --}}
            @if ($rewinding->lampiran_sjn_masuk)
                <form action="{{ route('rewinding.hapusLampiranMasuk', $rewinding->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Hapus lampiran SJN masuk?')">

                    @csrf

                    <button class="btn btn-warning">

                        <i class="fas fa-trash"></i>

                        Hapus Lampiran Masuk

                    </button>

                </form>
            @endif

        </div>

    </div>

@endsection
