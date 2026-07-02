@extends('layouts.main')

@section('title', 'Stock Out')

<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        body {
            background: #f4f7fb;
        }

        /* CARD */
        .stock-wrapper {
            max-width: 650px;
            margin: auto;
        }

        .stock-card {
            background: #fff;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 12px 35px rgba(15, 23, 42, .12);
            animation: fadeUp .4s ease;
        }

        /* HEADER */
        .stock-header {
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            padding: 24px;
            color: #fff;
        }

        .stock-header h3 {
            margin: 0;
            font-weight: 700;
            font-size: 24px;
        }

        .stock-header p {
            margin: 6px 0 0;
            opacity: .9;
            font-size: 14px;
        }

        /* BODY */
        .stock-body {
            padding: 28px;
        }

        /* LABEL */
        .form-label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        /* INPUT */
        .form-control {
            height: 48px;
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            padding: 10px 14px;
            transition: .25s;
            font-size: 14px;
            background: #fff;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .18);
        }

        /* BUTTON */
        .btn-stockout {
            width: 100%;
            height: 48px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            transition: .25s;
        }

        .btn-stockout:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #1e293b, #2563eb);
            box-shadow: 0 12px 28px rgba(30, 58, 138, .28);
        }

        .btn-stockout:active {
            transform: scale(.98);
        }

        /* INFO BOX */
        .info-box {
            background: #eff6ff;
            border-left: 5px solid #1e3a8a;
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .info-box strong {
            color: #0f172a;
        }

        .info-box small {
            color: #64748b;
        }

        /* ANIMATION */
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

        /* MOBILE */
        @media (max-width:768px) {

            .container {
                padding-left: 10px;
                padding-right: 10px;
            }

            .stock-card {
                border-radius: 16px;
            }

            .stock-header {
                padding: 18px;
            }

            .stock-header h3 {
                font-size: 19px;
            }

            .stock-header p {
                font-size: 12px;
            }

            .stock-body {
                padding: 18px;
            }

            .form-label {
                font-size: 12px;
            }

            .form-control {
                height: 40px;
                font-size: 12px;
                border-radius: 9px;
            }

            .btn-stockout {
                height: 40px;
                font-size: 12px;
                border-radius: 9px;
            }

            .swal2-popup {
                width: 85% !important;
            }

            .swal2-title {
                font-size: 18px !important;
            }

            .swal2-html-container {
                font-size: 13px !important;
            }
        }
    </style>

    <div class="container mt-4">

        <div class="stock-wrapper">

            <div class="stock-card">

                {{-- HEADER --}}
                <div class="stock-header">
                    <h3>Stok Keluar Barang</h3>
                    <p>{{ $item->mro_name }}</p>
                </div>

                {{-- BODY --}}
                <div class="stock-body">

                    {{-- INFO --}}
                    <div class="info-box">
                        <strong>Kode Material:</strong>
                        {{ $item->mro_code ?? '-' }}
                        <br>

                    </div>

                    <form action="{{ route('mro.stockout') }}" method="POST">
                        @csrf

                        <input type="hidden" name="barcode" value="{{ $item->barcode }}">

                        {{-- JUMLAH --}}
                        <div class="mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="text" name="jumlah" class="form-control" value="0" min="0"
                                required>
                        </div>

                        {{-- PROYEK --}}
                        {{-- <div class="mb-3">
                            <label class="form-label">Proyek</label>
                            <input type="text" name="proyek" class="form-control"
                                placeholder="Contoh: Cuci Kereta KRL KCI" required>
                        </div> --}}

                        <div class="mb-3">
                            <label class="form-label">Proyek</label>

                            <input type="text" class="form-control" value="{{ $item->proyek }}" readonly>

                            <input type="hidden" name="proyek" value="{{ $item->proyek }}">
                        </div>

                        {{-- SPP --}}
                        {{-- <div class="mb-4">
                            <label class="form-label">Nomor SPP / PR</label>
                            <input type="text" name="spp" class="form-control" placeholder="Masukkan nomor SPP/PR"
                                required>
                        </div> --}}

                        {{-- BUTTON --}}
                        <button class="btn-stockout">
                            Kurangi Stok
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

    {{-- SWEET ALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#c40000',
                timer: 2500,
                timerProgressBar: true
            });
        </script>
    @endif

@endsection
