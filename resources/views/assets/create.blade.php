@extends('layouts.main')

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <style>
        :root {
            --primary: #0f172a;
            --primary-dark: #020617;
            --primary-light: #1e3a8a;
            --secondary: #2563eb;
            --soft: #dbeafe;
            --bg: #f1f5f9;
            --text: #1e293b;
        }

        body {
            background: linear-gradient(135deg, #eef4ff, #f8fafc);
            font-family: 'Segoe UI', sans-serif;
            color: var(--text);
        }

        /* ==========================
            TOP BANNER
        ========================== */

        .top-banner {
            background: linear-gradient(135deg,
                    var(--primary),
                    var(--primary-light));
            color: white;
            border-radius: 22px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 15px 35px rgba(15, 23, 42, .25);
            animation: fadeUp .5s ease;
        }

        .top-banner h2 {
            margin: 0;
            font-weight: 700;
            font-size: 30px;
        }

        .top-banner p {
            margin-top: 8px;
            opacity: .9;
            font-size: 15px;
        }

        /* ==========================
            CARD
        ========================== */

        .asset-card {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            background: white;
            box-shadow: 0 12px 35px rgba(15, 23, 42, .08);
            animation: fadeUp .6s ease;
        }

        .asset-header {
            background: linear-gradient(135deg,
                    var(--primary),
                    var(--primary-light));
            padding: 22px 25px;
        }

        .asset-header h4 {
            color: white;
            margin: 0;
            font-weight: 700;
            letter-spacing: .5px;
        }

        .card-body {
            padding: 35px;
        }

        /* ==========================
            FORM
        ========================== */

        .form-group {
            animation: fadeUp .5s ease;
            transition: .3s;
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
            border: 2px solid #dbeafe;
            border-radius: 14px;
            min-height: 54px;
            box-shadow: none !important;
            transition: .3s;
            font-size: 15px;
        }

        .form-control:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .15) !important;
            transform: translateY(-2px);
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        /* ==========================
            BUTTON
        ========================== */

        .btn-save {
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

        .btn-save:hover {
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

        /* ==========================
            INPUT EFFECT
        ========================== */

        .form-group:hover {
            transform: translateX(4px);
        }

        /* ==========================
            ICON
        ========================== */

        .pulse-icon {
            animation: pulse 2s infinite;
        }

        /* ==========================
            ANIMATION
        ========================== */

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

        /* ==========================
            MOBILE
        ========================== */

        @media(max-width:768px) {

            .container-fluid {
                padding-left: 12px;
                padding-right: 12px;
            }

            .top-banner {
                text-align: center;
                padding: 20px;
            }

            .top-banner h2 {
                font-size: 24px;
            }

            .asset-header {
                text-align: center;
            }

            .card-body {
                padding: 20px;
            }

            .action-group {
                display: block !important;
            }

            .btn-save,
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

                        <i class="fas fa-plus-circle pulse-icon"></i>

                        Tambah Asset

                    </h2>

                    <p>

                        Tambahkan data asset baru ke dalam sistem

                    </p>

                </div>

                <div class="col-md-4 text-end d-none d-md-block">

                    <i class="fas fa-truck fa-4x opacity-75"></i>

                </div>

            </div>

        </div>

        <div class="card asset-card">

            <div class="card-header asset-header">

                <h4>

                    <i class="fas fa-database me-2"></i>

                    Form Data Asset

                </h4>

            </div>

            {{-- Isi data Asset --}}
            <div class="card-body">

                <form action="{{ route('assets.store') }}" method="POST">

                    @csrf

                    <div class="form-group mb-4">

                        <label class="form-label">

                            <i class="fas fa-building text-danger me-2"></i>

                            Unit

                        </label>

                        <input type="text" name="unit" autocomplete="off" class="form-control"
                            placeholder="Masukkan nama unit" required>

                    </div>

                    <div class="form-group mb-4">

                        <label class="form-label">

                            <i class="fas fa-hashtag text-danger me-2"></i>

                            No Lambung

                        </label>

                        <input type="text" name="no_lambung" autocomplete="off" class="form-control"
                            placeholder="Masukkan nomor lambung" required>

                    </div>

                    <div class="form-group mb-4">

                        <label class="form-label">

                            <i class="fas fa-map-marker-alt text-danger me-2"></i>

                            Lokasi

                        </label>

                        <input type="text" name="lokasi" autocomplete="off" class="form-control"
                            placeholder="Masukkan lokasi asset" required>

                    </div>

                    <div class="d-flex gap-2 action-group">

                        <a href="{{ route('assets.index') }}" class="btn btn-secondary btn-back">

                            <i class="fas fa-arrow-left"></i>

                            Kembali

                        </a>

                        <button type="submit" class="btn btn-save">

                            <i class="fas fa-save"></i>

                            Simpan Asset

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
