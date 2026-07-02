@extends('layouts.main')

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <style>
        :root {
            --primary: #0f172a;
            --primary-dark: #020617;
            --primary-light: #1d4ed8;
            --secondary: #2563eb;
            --soft-blue: #dbeafe;
            --bg: #f1f5f9;
            --text: #1e293b;
        }

        body {
            background: linear-gradient(135deg, #eef4ff, #f8fafc);
            font-family: 'Segoe UI', sans-serif;
            color: var(--text);
        }

        /* ===============================
            CARD
        =============================== */

        .edit-card {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 15px 40px rgba(15, 23, 42, .08);
            animation: fadeUp .6s ease;
        }

        .edit-header {
            background: linear-gradient(135deg,
                    var(--primary),
                    var(--primary-light));
            padding: 22px;
        }

        .edit-header h4 {
            color: white;
            margin: 0;
            font-weight: 700;
            letter-spacing: .5px;
        }

        /* ===============================
            TOP BANNER
        =============================== */

        .top-banner {
            background: linear-gradient(135deg,
                    var(--primary),
                    var(--primary-light));
            border-radius: 22px;
            padding: 25px;
            color: white;
            margin-bottom: 25px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, .22);
            animation: fadeUp .4s ease;
        }

        .top-banner h2 {
            margin: 0;
            font-weight: 700;
            font-size: 30px;
        }

        .top-banner p {
            margin-top: 8px;
            opacity: .9;
        }

        /* ===============================
            INFO CARD
        =============================== */

        .info-card {
            background: #eff6ff;
            border-left: 6px solid var(--secondary);
            border-radius: 16px;
            padding: 18px;
            margin-bottom: 25px;
            color: var(--text);
        }

        .info-card strong {
            color: var(--primary);
        }

        /* ===============================
            FORM
        =============================== */

        .card-body {
            padding: 35px;
        }

        .form-group {
            transition: .3s;
            animation: fadeUp .5s ease;
        }

        .form-label {
            font-weight: 600;
            color: var(--text);
            margin-bottom: 8px;
        }

        .form-label i {
            color: var(--secondary) !important;
        }

        .form-control {
            min-height: 55px;
            border-radius: 14px;
            border: 2px solid #dbeafe;
            box-shadow: none !important;
            transition: .3s;
        }

        .form-control:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .15) !important;
            transform: translateY(-2px);
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        /* ===============================
            BUTTON
        =============================== */

        .btn-update {
            background: linear-gradient(135deg,
                    var(--primary),
                    var(--primary-light));
            color: white;
            border: none;
            border-radius: 14px;
            padding: 12px 30px;
            font-weight: 600;
            transition: .3s;
        }

        .btn-update:hover {
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(15, 23, 42, .25);
        }

        .btn-back {
            background: #64748b;
            color: white;
            border: none;
            border-radius: 14px;
            padding: 12px 30px;
            font-weight: 600;
            transition: .3s;
        }

        .btn-back:hover {
            background: #475569;
            color: white;
            transform: translateY(-3px);
        }

        /* ===============================
            ICON
        =============================== */

        .pulse-icon {
            animation: pulse 2s infinite;
        }

        /* ===============================
            ANIMATION
        =============================== */

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

        @keyframes pulse {

            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }

            100% {
                transform: scale(1);
            }

        }

        /* ===============================
            MOBILE
        =============================== */

        @media (max-width:768px) {

            .container-fluid {
                padding-left: 12px;
                padding-right: 12px;
            }

            .card-body {
                padding: 20px;
            }

            .top-banner {
                text-align: center;
            }

            .top-banner h2 {
                font-size: 24px;
            }

            .action-group {
                display: block !important;
            }

            .btn-update,
            .btn-back {
                width: 100%;
                margin-bottom: 10px;
            }

            .form-control {
                min-height: 50px;
            }
        }
    </style>

    <div class="container-fluid mt-3">


        <div class="top-banner">

            <div class="row align-items-center">

                <div class="col-md-8">

                    <h2>

                        <i class="fas fa-edit pulse-icon"></i>

                        Edit Asset

                    </h2>

                    <p>

                        Perbarui informasi asset yang sudah terdaftar

                    </p>

                </div>

                <div class="col-md-4 text-end d-none d-md-block">

                    <i class="fas fa-tools fa-4x opacity-75"></i>

                </div>

            </div>

        </div>

        <div class="card edit-card">

            <div class="card-header edit-header">

                <h4>

                    <i class="fas fa-database me-2"></i>

                    Form Edit Asset

                </h4>

            </div>

            <div class="card-body">

                <div class="info-card">

                    <strong>
                        <i class="fas fa-info-circle"></i>
                        Informasi Asset
                    </strong>

                    <div class="mt-2">

                        Asset saat ini:
                        <b>{{ $asset->unit }}</b>
                        -
                        <b>{{ $asset->no_lambung }}</b>

                    </div>

                </div>

                {{-- Edit Form --}}
                <form action="{{ route('assets.update', $asset->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="form-group mb-4">

                        <label class="form-label">

                            <i class="fas fa-building text-danger me-2"></i>

                            Unit

                        </label>

                        <input type="text" name="unit" autocomplete="off" value="{{ $asset->unit }}"
                            class="form-control" placeholder="Masukkan nama unit" required>

                    </div>

                    <div class="form-group mb-4">

                        <label class="form-label">

                            <i class="fas fa-hashtag text-danger me-2"></i>

                            No Lambung

                        </label>

                        <input type="text" name="no_lambung" autocomplete="off" value="{{ $asset->no_lambung }}"
                            class="form-control" placeholder="Masukkan nomor lambung" required>

                    </div>

                    <div class="form-group mb-4">

                        <label class="form-label">

                            <i class="fas fa-map-marker-alt text-danger me-2"></i>

                            Lokasi

                        </label>

                        <input type="text" name="lokasi" autocomplete="off" value="{{ $asset->lokasi }}"
                            class="form-control" placeholder="Masukkan lokasi asset" required>

                    </div>

                    <div class="d-flex gap-2 action-group">

                        <a href="{{ route('assets.index') }}" class="btn btn-secondary btn-back">

                            <i class="fas fa-arrow-left"></i>

                            Kembali

                        </a>

                        <button type="submit" class="btn btn-update">

                            <i class="fas fa-save"></i>

                            Update Asset

                        </button>

                    </div>

                </form>

            </div>

        </div>


    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const inputs = document.querySelectorAll('.form-control');

            inputs.forEach(input => {

                input.addEventListener('focus', function() {

                    this.parentElement.style.transform = 'translateX(5px)';

                });

                input.addEventListener('blur', function() {

                    this.parentElement.style.transform = 'translateX(0px)';

                });

            });

        });
    </script>
@endsection
