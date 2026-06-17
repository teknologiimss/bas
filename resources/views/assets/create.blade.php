@extends('layouts.main')

@section('content')
    <style>
        :root {
            --primary: #c62828;
            --primary-dark: #8e0000;
            --primary-light: #ffebee;
        }

        body {
            background: #f5f6fa;
        }

        /* CARD */

        .asset-card {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .08);
            animation: fadeUp .6s ease;
        }

        .asset-header {
            background: linear-gradient(135deg,
                    var(--primary),
                    var(--primary-dark));
            padding: 22px;
        }

        .asset-header h4 {
            color: white;
            margin: 0;
            font-weight: 700;
            letter-spacing: .5px;
        }

        /* FORM */

        .form-label {
            font-weight: 600;
            color: #444;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 14px;
            border: 2px solid #f1f1f1;
            min-height: 52px;
            transition: .3s;
            box-shadow: none !important;
        }

        .form-control:focus {
            border-color: #c62828;
            box-shadow: 0 0 0 4px rgba(198, 40, 40, .12) !important;
            transform: translateY(-2px);
        }

        /* BUTTON */

        .btn-save {
            background: linear-gradient(135deg,
                    #c62828,
                    #8e0000);
            color: white;
            border: none;
            border-radius: 14px;
            padding: 12px 28px;
            font-weight: 600;
            transition: .3s;
        }

        .btn-save:hover {
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(198, 40, 40, .35);
        }

        .btn-back {
            border-radius: 14px;
            padding: 12px 28px;
            font-weight: 600;
            transition: .3s;
        }

        .btn-back:hover {
            transform: translateY(-3px);
        }

        /* ICON BOX */

        .top-banner {
            background: linear-gradient(135deg,
                    #ef5350,
                    #c62828);
            border-radius: 20px;
            padding: 20px;
            color: white;
            margin-bottom: 20px;
            box-shadow: 0 8px 20px rgba(198, 40, 40, .25);
            animation: fadeUp .4s ease;
        }

        .top-banner h2 {
            margin: 0;
            font-weight: 700;
        }

        .top-banner p {
            margin: 0;
            opacity: .9;
        }

        /* INPUT ANIMATION */

        .form-group {
            animation: fadeUp .5s ease;
        }

        /* CARD BODY */

        .card-body {
            padding: 30px;
        }

        /* MOBILE */

        @media(max-width:768px) {

            .card-body {
                padding: 20px;
            }

            .top-banner {
                text-align: center;
            }

            .btn-save,
            .btn-back {
                width: 100%;
                margin-bottom: 10px;
            }

            .action-group {
                display: block !important;
            }
        }

        /* ANIMATION */

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
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }

        }

        .pulse-icon {
            animation: pulse 2s infinite;
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

            <div class="card-body">

                <form action="{{ route('assets.store') }}" method="POST">

                    @csrf

                    <div class="form-group mb-4">

                        <label class="form-label">

                            <i class="fas fa-building text-danger me-2"></i>

                            Unit

                        </label>

                        <input type="text" name="unit" class="form-control" placeholder="Masukkan nama unit" required>

                    </div>

                    <div class="form-group mb-4">

                        <label class="form-label">

                            <i class="fas fa-hashtag text-danger me-2"></i>

                            No Lambung

                        </label>

                        <input type="text" name="no_lambung" class="form-control" placeholder="Masukkan nomor lambung"
                            required>

                    </div>

                    <div class="form-group mb-4">

                        <label class="form-label">

                            <i class="fas fa-map-marker-alt text-danger me-2"></i>

                            Lokasi

                        </label>

                        <input type="text" name="lokasi" class="form-control" placeholder="Masukkan lokasi asset"
                            required>

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
