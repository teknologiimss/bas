@extends('layouts.main')

@section('title', 'Tambah Rewinding')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')

    <style>
        body {
            background: #f4f6fb;
        }

        .card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(10, 25, 60, 0.10);
            overflow: hidden;
            animation: fadeUp 0.5s ease;
        }

        .card-header {
            background: linear-gradient(135deg, #0b1f3a, #142d55) !important;
            color: #fff;
            border: none;
            padding: 18px 22px;
        }

        .card-header h4 {
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.3px;
        }

        .card-body {
            padding: 24px;
            background: #fff;
        }

        label {
            font-weight: 600;
            color: #1f2d3d;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #d0d7e2;
            padding: 10px 12px;
            transition: 0.2s;
        }

        .form-control:focus {
            border-color: #0b1f3a;
            box-shadow: 0 0 0 0.2rem rgba(11, 31, 58, 0.15);
        }

        textarea.form-control {
            min-height: 100px;
        }

        .btn {
            border-radius: 10px;
            transition: 0.2s;
            font-weight: 600;
        }

        .btn-danger {
            background: linear-gradient(135deg, #0b1f3a, #142d55);
            border: none;
            color: #fff;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(11, 31, 58, 0.25);
        }

        .btn-secondary {
            background: #e9eef6;
            border: none;
            color: #0b1f3a;
        }

        .btn-secondary:hover {
            background: #dbe4f3;
            transform: translateY(-2px);
        }

        .row>div {
            margin-bottom: 10px;
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

        button:active,
        a:active {
            transform: scale(0.97);
        }

        /* MOBILE */
        @media (max-width: 768px) {
            .card-body {
                padding: 16px;
            }

            .btn {
                width: 100%;
                margin-bottom: 8px;
            }
        }
    </style>

    <div class="card shadow">
        <div class="card-header bg-danger text-white">
            <h4>
                <i class="fas fa-plus-circle"></i>
                Tambah Data Rewinding
            </h4>
        </div>

        <div class="card-body">

            <form action="{{ route('rewinding.store') }}" method="POST" enctype="multipart/form-data">

                @csrf
                <input type="hidden" name="rewinding_folder_id" value="{{ $folder->id }}">
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>No SJN</label>
                        <input type="text" name="no_sjn" autocomplete="off" class="form-control" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Tanggal SJN Keluar</label>
                        <input type="date" name="tanggal_sjn_keluar" class="form-control" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Lampiran SJN Keluar</label>
                        <input type="file" name="lampiran_sjn_keluar" class="form-control">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Tanggal SJN Masuk</label>
                        <input type="date" name="tanggal_sjn_masuk" class="form-control">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Lampiran SJN Masuk</label>
                        <input type="file" name="lampiran_sjn_masuk" class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" autocomplete="off" class="form-control"></textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" autocomplete="off" class="form-control"></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>No SPPJP</label>
                        <input type="text" autocomplete="off" name="no_sppjp" class="form-control">
                    </div>

                </div>

                <button class="btn btn-danger">
                    <i class="fas fa-save"></i>
                    Simpan
                </button>

                <a href="{{ route('rewinding.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>

@endsection
