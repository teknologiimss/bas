@extends('layouts.main')

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background: #edf2f8;
            font-family: 'Segoe UI', sans-serif;
        }

        .mobile-container {
            max-width: 850px;
            margin: auto;
            padding-bottom: 100px;
        }

        /* ===========================
                HEADER
        =========================== */

        .header-card {

            background: linear-gradient(135deg,
                    #0f172a,
                    #1e3a8a,
                    #2563eb);

            color: white;

            border-radius: 22px;

            padding: 22px;

            margin-bottom: 20px;

            box-shadow: 0 12px 28px rgba(30, 58, 138, .25);
        }

        .header-title {

            font-size: 24px;

            font-weight: 700;

        }

        .header-info {

            margin-top: 12px;

            font-size: 14px;

            line-height: 1.8;

            color: rgba(255, 255, 255, .9);

        }

        /* ===========================
                CARD
        =========================== */

        .progress-card,
        .item-card {

            background: white;

            border: none;

            border-radius: 18px;

            box-shadow: 0 8px 24px rgba(15, 23, 42, .08);

            margin-bottom: 18px;

        }

        .item-card {

            padding: 18px;

            transition: .3s;

        }

        .item-card:hover {

            transform: translateY(-4px);

            box-shadow: 0 12px 30px rgba(30, 58, 138, .15);

        }

        .progress-card {

            padding: 18px;

        }

        /* ===========================
                TITLE
        =========================== */

        .item-title {

            font-size: 17px;

            font-weight: 700;

            color: #0f172a;

            margin-bottom: 10px;

        }

        .item-sub {

            color: #64748b;

            font-size: 14px;

            line-height: 1.8;

        }

        /* ===========================
                INPUT
        =========================== */

        .form-control {

            border-radius: 12px;

            border: 1px solid #cbd5e1;

        }

        .form-control:focus {

            border-color: #2563eb;

            box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .15);

        }

        /* ===========================
                PROGRESS
        =========================== */

        .progress {

            height: 10px;

            border-radius: 20px;

            background: #dbeafe;

        }

        .progress-bar {

            background: linear-gradient(90deg,
                    #1e3a8a,
                    #2563eb) !important;

        }

        /* ===========================
            STATUS BUTTON
        =========================== */

        .status-group {

            display: flex;

            gap: 10px;

            margin-top: 18px;

        }

        .status-group input {

            display: none;

        }

        .btn-status {

            flex: 1;

            padding: 13px;

            border-radius: 12px;

            text-align: center;

            font-weight: 700;

            cursor: pointer;

            transition: .25s;

        }

        .btn-status:hover {

            transform: translateY(-2px);

        }

        /* ===========================
                    V
        =========================== */

        .btn-v {

            background: #eff6ff;

            border: 1px solid #93c5fd;

            color: #2563eb;

        }

        input:checked+.btn-v {

            background: #2563eb;

            color: white;

            border-color: #2563eb;

        }

        /* ===========================
                    X
        =========================== */

        .btn-x {

            background: #fef2f2;

            border: 1px solid #fca5a5;

            color: #dc2626;

        }

        input:checked+.btn-x {

            background: #dc2626;

            color: white;

            border-color: #dc2626;

        }

        /* ===========================
                    O
        =========================== */

        .btn-o {

            background: #fefce8;

            border: 1px solid #fde047;

            color: #ca8a04;

        }

        input:checked+.btn-o {

            background: #facc15;

            color: #111827;

            border-color: #facc15;

        }

        /* ===========================
                SPR
        =========================== */

        .spr-box {

            display: none;

            margin-top: 12px;

            animation: fade .3s ease;

        }

        @keyframes fade {

            from {

                opacity: 0;

                transform: translateY(10px);

            }

            to {

                opacity: 1;

                transform: translateY(0);

            }

        }

        /* ===========================
                STICKY SAVE
        =========================== */

        .sticky-save {

            position: fixed;

            left: 0;

            right: 0;

            bottom: 0;

            background: white;

            padding: 14px;

            border-top: 1px solid #dbeafe;

            box-shadow: 0 -8px 20px rgba(15, 23, 42, .08);

            z-index: 999;

        }

        .save-btn {

            width: 100%;

            height: 54px;

            border: none;

            border-radius: 14px;

            background: linear-gradient(135deg,
                    #0f172a,
                    #1e3a8a);

            color: white;

            font-size: 16px;

            font-weight: 700;

            transition: .3s;

        }

        .save-btn:hover {

            transform: translateY(-2px);

            background: linear-gradient(135deg,
                    #1e3a8a,
                    #2563eb);

        }

        /* ===========================
                SCROLL TOP
        =========================== */

        .scroll-top {

            position: fixed;

            right: 20px;

            bottom: 90px;

            width: 50px;

            height: 50px;

            border: none;

            border-radius: 50%;

            background: linear-gradient(135deg,
                    #0f172a,
                    #1e3a8a);

            color: white;

            box-shadow: 0 6px 20px rgba(30, 58, 138, .30);

            display: none;

            transition: .3s;

            z-index: 999;

        }

        .scroll-top:hover {

            transform: scale(1.08);

        }

        /* ===========================
                STATUS INFO
        =========================== */

        .status-info {

            display: flex;

            align-items: center;

            gap: 12px;

            margin-bottom: 10px;

            font-size: 14px;

            color: #475569;

        }

        .status-badge {

            width: 40px;

            text-align: center;

            font-weight: 700;

            border-radius: 10px;

            padding: 8px 0;

        }

        .status-v {

            background: #2563eb;

            color: white;

        }

        .status-x {

            background: #dc2626;

            color: white;

        }

        .status-o {

            background: #facc15;

            color: #111827;

        }

        /* ===========================
                BUTTON
        =========================== */

        .btn-light {

            border-radius: 12px;

            color: #1e3a8a;

            font-weight: 600;

        }

        .btn-light:hover {

            background: #dbeafe;

        }

        /* ===========================
                MOBILE
        =========================== */

        @media(max-width:768px) {

            .mobile-container {

                padding: 12px;

                padding-bottom: 100px;

            }

            .header-card {

                padding: 18px;

            }

            .header-title {

                font-size: 20px;

            }

            .status-group {

                flex-direction: row;

                gap: 8px;

            }

            .btn-status {

                font-size: 13px;

                padding: 11px;

            }

            .item-title {

                font-size: 15px;

            }

            .item-sub {

                font-size: 13px;

            }

            .save-btn {

                height: 50px;

                font-size: 15px;

            }

        }
    </style>

    <div class="mobile-container py-3">

        {{-- HEADER --}}
        <div class="header-card">

            <div class="d-flex justify-content-between">

                <div>

                    <div class="header-title">

                        📋 {{ $checksheet->judul }}

                    </div>

                </div>

                <a href="{{ route('fasilitas-harian.index') }}" class="btn btn-light">

                    <i class="fa fa-arrow-left"></i>

                </a>

            </div>

            <div class="header-info">

                📍 {{ $checksheet->lokasi }}

                <br>

                📅 {{ $checksheet->bulan }}
                {{ $checksheet->tahun }}

            </div>

        </div>


        <div class="progress-card">

            <form method="GET">

                <label>
                    <strong>Tanggal Pemeriksaan</strong>
                </label>

                <input type="date" name="tanggal" class="form-control mt-2" value="{{ $tanggal }}"
                    max="{{ date('Y-m-d') }}" onchange="this.form.submit()">

            </form>

        </div>

        {{-- PROGRESS --}}
        <div class="progress-card">

            <div class="d-flex justify-content-between mb-2">

                <strong>Progress</strong>

                <span id="progressText">
                    0/{{ $checksheet->items->count() }}
                </span>

            </div>

            <div class="progress">

                <div id="progressBar" class="progress-bar bg-success" style="width:0%">

                </div>

            </div>

        </div>


        {{-- Keterangan Status --}}
        <div class="progress-card">

            <h6 class="mb-3">
                <i class="fa fa-circle-info"></i>
                Keterangan
            </h6>

            <div class="status-info">
                <span class="status-badge status-v">V</span>
                <span>Pemeriksaan Bagus</span>
            </div>

            <div class="status-info">
                <span class="status-badge status-x">X</span>
                <span>Pemeriksaan Jelek di TL dan dibuatkan SPR</span>
            </div>

            <div class="status-info">
                <span class="status-badge status-o">O</span>
                <span>Pemeriksaan Bagus, tetapi tidak beroperasi</span>
            </div>

        </div>

        {{-- FORM --}}
        <form action="{{ route('fasilitas.mobile.save') }}" method="POST">

            @csrf

            <input type="hidden" name="tanggal" value="{{ $tanggal }}">

            @foreach ($checksheet->items as $item)
                @php

                    $currentResult = $item->results->first(function ($r) use ($tanggal) {
                        return $r->tanggal->format('Y-m-d') == $tanggal;
                    });

                @endphp

                <div class="item-card">

                    <div class="item-title">
                        {{ $item->nomor }}.
                        {{ $item->uraian_pekerjaan }}
                    </div>

                    <div class="item-sub">

                        @foreach ($item->aktivitas as $a)
                            • {{ $a->aktivitas }}
                            <br>
                        @endforeach

                    </div>

                    {{-- STATUS --}}
                    <div class="status-group">

                        {{-- V --}}
                        <label class="w-100">

                            <input type="radio" class="status-radio" data-item="{{ $item->id }}"
                                name="results[{{ $item->id }}][status]" value="V"
                                {{ optional($currentResult)->status == 'V' ? 'checked' : '' }}>

                            <div class="btn-status btn-v">

                                ✔ V

                            </div>

                        </label>

                        {{-- X --}}
                        <label class="w-100">

                            <input type="radio" class="status-radio" data-item="{{ $item->id }}"
                                name="results[{{ $item->id }}][status]" value="X"
                                {{ optional($currentResult)->status == 'X' ? 'checked' : '' }}>

                            <div class="btn-status btn-x">

                                ✖ X

                            </div>

                        </label>

                        {{-- O --}}
                        <label class="w-100">

                            <input type="radio" class="status-radio" data-item="{{ $item->id }}"
                                name="results[{{ $item->id }}][status]" value="O"
                                {{ optional($currentResult)->status == 'O' ? 'checked' : '' }}>

                            <div class="btn-status btn-o">

                                ⭕ O

                            </div>

                        </label>

                    </div>

                    {{-- KETERANGAN --}}
                    {{-- <textarea class="form-control mt-3" rows="2" autocomplete="off" name="results[{{ $item->id }}][keterangan]"
                        placeholder="Keterangan...">{{ $currentResult->keterangan ?? '' }}</textarea> --}}

                    {{-- SPR --}}
                    {{-- <div class="spr-box" id="spr-{{ $item->id }}"
                        style="{{ optional($currentResult)->status == 'X' ? 'display:block' : '' }}">

                        <input type="text" autocomplete="off" class="form-control mt-2"
                            name="results[{{ $item->id }}][nomor_spr]" value="{{ $currentResult->nomor_spr ?? '' }}"
                            placeholder="Nomor SPR">

                    </div> --}}

                </div>
            @endforeach

            {{-- SAVE --}}
            <div class="sticky-save">

                <button type="submit" class="btn btn-success save-btn">

                    <i class="fa fa-save"></i>

                    Simpan Checksheet

                </button>

            </div>

        </form>

    </div>

    <button id="scrollTop" class="scroll-top">

        <i class="fa fa-arrow-up"></i>

    </button>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif

    <script>
        /* progress */

        function updateProgress() {
            let total =
                document.querySelectorAll(
                    '.item-card'
                ).length;

            let checked =
                document.querySelectorAll(
                    '.status-radio:checked'
                ).length;

            let percent =
                total ?
                Math.round(
                    checked / total * 100
                ) :
                0;

            document
                .getElementById(
                    'progressText'
                ).innerHTML =
                checked + '/' + total;

            document
                .getElementById(
                    'progressBar'
                ).style.width =
                percent + '%';
        }

        /* radio */

        document
            .querySelectorAll(
                '.status-radio'
            )
            .forEach(el => {

                el.addEventListener(
                    'change',
                    function() {

                        updateProgress();

                        let item =
                            this.dataset.item;

                        let spr =
                            document.getElementById(
                                'spr-' + item
                            );

                        if (this.value === 'X') {
                            spr.style.display = 'block';
                        } else {
                            spr.style.display = 'none';
                        }

                    });

            });

        /* scroll top */

        const btn =
            document.getElementById(
                'scrollTop'
            );

        window.addEventListener(
            'scroll',
            function() {

                if (window.scrollY > 300) {
                    btn.style.display = 'block';
                } else {
                    btn.style.display = 'none';
                }

            });

        btn.addEventListener(
            'click',
            function() {

                window.scrollTo({

                    top: 0,
                    behavior: 'smooth'

                });

            });
    </script>
@endsection
