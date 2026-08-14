@extends('layouts.main')

@section('title', 'Menu Gudang MRO')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        body {
            background: #f4f7fb;
            font-family: 'Segoe UI', sans-serif;
        }

        .welcome-card {
            background: linear-gradient(135deg, #163a6b, #0d2342);
            color: white;
            border-radius: 18px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(13, 42, 84, .15);
            margin-bottom: 25px;
            animation: fadeDown .5s ease;
        }

        .card-menu {
            border: none;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 10px 25px rgba(13, 42, 84, .08);
            transition: all .3s ease;
            height: 100%;
        }

        .card-menu:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(13, 42, 84, .18);
        }

        .icon-wrapper {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }

        .bg-blue-soft {
            background-color: #e3f2fd;
            color: #0d47a1;
        }

        .bg-orange-soft {
            background-color: #fff3e0;
            color: #e65100;
        }

        .btn-outline-custom {
            border-radius: 10px;
            font-weight: 600;
            transition: .25s;
        }

        .btn-blue {
            border: 1px solid #0d47a1;
            color: #0d47a1;
        }

        .btn-blue:hover {
            background: #0d47a1;
            color: #fff;
        }

        .btn-orange {
            border: 1px solid #e65100;
            color: #e65100;
        }

        .btn-orange:hover {
            background: #e65100;
            color: #fff;
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

        .row-cards {
            animation: fadeUp .5s ease;
        }
    </style>

    <!-- BANNER WELCOME -->
    <div class="welcome-card text-center">
        <h3 class="font-weight-bold mb-1">📦 Warehouse & Inventory MRO</h3>
        <p class="mb-0 text-white-50">Pilih menu di bawah ini untuk mengelola stok barang atau memantau mutasi barang gudang.
        </p>
    </div>

    <!-- GRID KARTU MENU GUDANG -->
    <div class="row row-cards">
        <!-- 1. STOK BARANG MRO -->
        <div class="col-lg-6 col-md-6 col-12 mb-4">
            <div class="card card-menu">
                <div class="card-body text-center p-4">
                    <div class="icon-wrapper bg-blue-soft">
                        <i class="fas fa-boxes fa-2x"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark">Stok Barang MRO</h5>
                    <p class="text-muted small">Kelola data inventaris, ketersediaan barang MRO, jumlah stok, serta
                        penambahan item baru.</p>
                </div>
                <div class="card-footer bg-transparent border-0 pb-4 text-center">
                    <a href="{{ route('mro') }}" class="btn btn-outline-custom btn-blue btn-block">
                        Buka Stok Barang <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- 2. MUTASI STOK MRO -->
        <div class="col-lg-6 col-md-6 col-12 mb-4">
            <div class="card card-menu">
                <div class="card-body text-center p-4">
                    <div class="icon-wrapper bg-orange-soft">
                        <i class="fas fa-exchange-alt fa-2x"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark">Mutasi Stok MRO</h5>
                    <p class="text-muted small">Pantau riwayat barang masuk, barang keluar, log transaksi, dan pergerakan
                        stok gudang.</p>
                </div>
                <div class="card-footer bg-transparent border-0 pb-4 text-center">
                    <a href="{{ route('mro.stock.log') }}" class="btn btn-outline-custom btn-orange btn-block">
                        Lihat Mutasi Stok <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
