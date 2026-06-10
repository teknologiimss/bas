@extends('layouts.main')

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background: #eef2f7;
            font-family: 'Segoe UI', sans-serif;
        }

        .mobile-container {
            max-width: 800px;
            margin: auto;
            padding-bottom: 100px;
        }

        /* HEADER */

        .header-card {

            background:
                linear-gradient(135deg,
                    #b30000,
                    #ff2d2d);

            color: white;

            border-radius: 22px;

            padding: 20px;

            margin-bottom: 18px;

            box-shadow:
                0 8px 24px rgba(0, 0, 0, .12);
        }

        .header-title {

            font-size: 22px;

            font-weight: 700;
        }

        .header-info {

            margin-top: 12px;

            font-size: 13px;

            line-height: 1.8;
        }

        /* PROGRESS */

        .progress-card {

            background: white;

            border-radius: 18px;

            padding: 15px;

            margin-bottom: 15px;

            box-shadow:
                0 3px 12px rgba(0, 0, 0, .05);
        }

        .progress {
            height: 8px;
            border-radius: 20px;
        }

        /* ITEM */

        .item-card {

            background: white;

            border-radius: 18px;

            padding: 15px;

            margin-bottom: 15px;

            box-shadow:
                0 4px 14px rgba(0, 0, 0, .06);

            transition: .25s;
        }

        .item-card:hover {
            transform: translateY(-2px);
        }

        .item-title {

            font-size: 16px;

            font-weight: 700;

            color: #222;

            margin-bottom: 10px;
        }

        .item-sub {

            font-size: 13px;

            color: #666;
        }

        /* BUTTON STATUS */

        .status-group {

            display: flex;

            gap: 8px;

            margin-top: 15px;
        }

        .status-group input {
            display: none;
        }

        .btn-status {

            flex: 1;

            padding: 12px;

            text-align: center;

            border-radius: 12px;

            font-weight: 700;

            cursor: pointer;

            transition: .25s;
        }

        /* V */

        .btn-v {

            background: #ecfff3;

            border: 1px solid #bfe8cf;

            color: #198754;
        }

        input:checked+.btn-v {

            background: #198754;

            color: white;
        }

        /* X */

        .btn-x {

            background: #fff0f0;

            border: 1px solid #ffc7c7;

            color: #dc3545;
        }

        input:checked+.btn-x {

            background: #dc3545;

            color: white;
        }

        /* O */

        .btn-o {

            background: #fff9e6;

            border: 1px solid #ffe69c;

            color: #d39e00;
        }

        input:checked+.btn-o {

            background: #ffc107;

            color: black;
        }

        /* TEXTAREA */

        .form-control {

            border-radius: 12px;
        }

        /* SPR */

        .spr-box {

            display: none;

            margin-top: 10px;

            animation: fade .3s ease;
        }

        @keyframes fade {

            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: none;
            }

        }

        /* SAVE */

        .sticky-save {

            position: fixed;

            left: 0;
            right: 0;
            bottom: 0;

            background: white;

            padding: 10px;

            box-shadow:
                0 -3px 12px rgba(0, 0, 0, .08);

            z-index: 999;
        }

        .save-btn {

            width: 100%;

            height: 48px;

            border-radius: 12px;

            font-weight: 700;
        }

        .scroll-top {

            position: fixed;

            right: 20px;

            bottom: 80px;

            width: 45px;

            height: 45px;

            border: none;

            border-radius: 50%;

            background: #b30000;

            color: white;

            display: none;

            z-index: 999;
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

        {{-- FORM --}}
        <form action="{{ route('fasilitas.mobile.save') }}" method="POST">

            @csrf

            <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">

            @foreach ($checksheet->items as $item)

    @php

        $currentResult = $item->results->first(function ($r) {

            return $r->tanggal->format('Y-m-d') == date('Y-m-d');

        });

    @endphp

    <div class="item-card">

        <div class="item-title">
            {{ $item->nomor }}.
            {{ $item->uraian_pekerjaan }}
        </div>

        <div class="item-sub">

            @foreach($item->aktivitas as $a)

                • {{ $a->aktivitas }}
                <br>

            @endforeach

        </div>

        {{-- STATUS --}}
        <div class="status-group">

            {{-- V --}}
            <label class="w-100">

                <input
                    type="radio"
                    class="status-radio"
                    data-item="{{ $item->id }}"
                    name="results[{{ $item->id }}][status]"
                    value="V"
                    {{ optional($currentResult)->status == 'V' ? 'checked' : '' }}>

                <div class="btn-status btn-v">

                    ✔ V

                </div>

            </label>

            {{-- X --}}
            <label class="w-100">

                <input
                    type="radio"
                    class="status-radio"
                    data-item="{{ $item->id }}"
                    name="results[{{ $item->id }}][status]"
                    value="X"
                    {{ optional($currentResult)->status == 'X' ? 'checked' : '' }}>

                <div class="btn-status btn-x">

                    ✖ X

                </div>

            </label>

            {{-- O --}}
            <label class="w-100">

                <input
                    type="radio"
                    class="status-radio"
                    data-item="{{ $item->id }}"
                    name="results[{{ $item->id }}][status]"
                    value="O"
                    {{ optional($currentResult)->status == 'O' ? 'checked' : '' }}>

                <div class="btn-status btn-o">

                    ⭕ O

                </div>

            </label>

        </div>

        {{-- KETERANGAN --}}
        <textarea
            class="form-control mt-3"
            rows="2"
            autocomplete="off"
            name="results[{{ $item->id }}][keterangan]"
            placeholder="Keterangan...">{{ $currentResult->keterangan ?? '' }}</textarea>

        {{-- SPR --}}
        <div
            class="spr-box"
            id="spr-{{ $item->id }}"
            style="{{ optional($currentResult)->status == 'X' ? 'display:block' : '' }}">

            <input
                type="text"
                autocomplete="off"
                class="form-control mt-2"
                name="results[{{ $item->id }}][nomor_spr]"
                value="{{ $currentResult->nomor_spr ?? '' }}"
                placeholder="Nomor SPR">

        </div>

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
