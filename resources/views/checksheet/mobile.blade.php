@extends('layouts.main')

@section('content')

{{-- FONT AWESOME --}}
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

    body {
        background: #eef2f7;
        font-family: 'Segoe UI', sans-serif;
    }

    .mobile-container {
        max-width: 720px;
        margin: auto;
        padding-bottom: 90px;
    }

    /* HEADER */

    .header-card {
        background: linear-gradient(135deg, #b30000, #ff2d2d);
        color: white;
        border-radius: 22px;
        padding: 20px;
        margin-bottom: 18px;
        box-shadow: 0 8px 24px rgba(0,0,0,.12);
    }

    .header-title {
        font-size: 21px;
        font-weight: 700;
        letter-spacing: .3px;
    }

    .header-info {
        font-size: 13px;
        opacity: .95;
        margin-top: 12px;
        line-height: 1.8;
    }

    /* PROGRESS */

    .progress-wrapper {
        background: white;
        border-radius: 18px;
        padding: 16px;
        margin-bottom: 18px;
        box-shadow: 0 3px 12px rgba(0,0,0,.05);
    }

    .progress {
        height: 8px;
        border-radius: 20px;
        overflow: hidden;
        background: #e9ecef;
    }

    .progress-bar {
        border-radius: 20px;
    }

    /* ACCORDION */

    .accordion-item {
        border: none !important;
        border-radius: 18px !important;
        overflow: hidden;
        margin-bottom: 14px;
        box-shadow: 0 4px 14px rgba(0,0,0,.06);
    }

    .accordion-button {
        background: white;
        font-weight: 600;
        padding: 15px 18px;
        font-size: 15px;
        border: none;
    }

    .accordion-button:not(.collapsed) {
        background: #fff0f0;
        color: #b30000;
    }

    .accordion-button:focus {
        box-shadow: none;
    }

    /* ITEM */

    .item-box {
        background: #fff;
        border-radius: 14px;
        padding: 14px;
        margin-bottom: 12px;
        border: 1px solid #edf0f3;
    }

    .uraian-title {
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 12px;
        color: #222;
    }

    /* DETAIL */

    .detail-box {
        background: #f8fafc;
        border-radius: 14px;
        padding: 12px;
        margin-bottom: 12px;
        border-left: 4px solid #b30000;
    }

    .detail-label {
        font-size: 11px;
        color: #888;
        margin-bottom: 3px;
    }

    .detail-value {
        font-size: 13px;
        color: #222;
        font-weight: 500;
        line-height: 1.5;
    }

    /* BUTTON OK NOK */

    .radio-wrapper {
        display: flex;
        gap: 8px;
        margin-top: 12px;
    }

    .radio-wrapper input {
        display: none;
    }

    .btn-ok,
    .btn-nok {
        flex: 1;
        text-align: center;
        padding: 8px 10px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s;
        font-size: 12px;
    }

    .btn-ok {
        background: #ecfff3;
        color: #198754;
        border: 1.5px solid #bfe8cf;
    }

    .btn-nok {
        background: #fff1f1;
        color: #dc3545;
        border: 1.5px solid #ffc8c8;
    }

    input:checked + .btn-ok {
        background: #198754;
        color: white;
        border-color: #198754;
        box-shadow: 0 3px 10px rgba(25,135,84,.25);
    }

    input:checked + .btn-nok {
        background: #dc3545;
        color: white;
        border-color: #dc3545;
        box-shadow: 0 3px 10px rgba(220,53,69,.25);
    }

    /* TEXTAREA */

    textarea.form-control {
        border-radius: 12px !important;
        resize: none;
        font-size: 13px;
        border: 1px solid #dfe5ec;
        box-shadow: none !important;
        padding: 10px;
    }

    textarea.form-control:focus {
        border-color: #b30000;
    }

    /* STICKY SAVE */

    .sticky-save {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: rgba(255,255,255,.96);
        backdrop-filter: blur(10px);
        padding: 10px 14px;
        box-shadow: 0 -3px 12px rgba(0,0,0,.08);
        z-index: 999;

        display: flex;
        justify-content: center;
    }

    .save-btn {
        height: 42px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .2px;
        box-shadow: 0 3px 10px rgba(25,135,84,.18);

        width: 100%;
        max-width: 260px;
    }

    /* MOBILE */

    @media(max-width:768px){

        .mobile-container {
            padding: 10px;
        }

        .header-title {
            font-size: 18px;
        }

        .accordion-button {
            font-size: 14px;
        }

        .detail-value {
            font-size: 12px;
        }

        .save-btn {
            max-width: 100%;
        }

    }

</style>

<div class="mobile-container py-3">

    {{-- HEADER --}}
    <div class="header-card">

        <div class="header-title">
            📋 {{ $checksheet->judul }}
        </div>

        <div class="header-info">

            <div>
                🚛 Unit :
                {{ $checksheet->unit }}
            </div>

            <div>
                🏷️ No Lambung :
                {{ $checksheet->no_lambung }}
            </div>

            <div>
                📅 Tanggal :
                {{ $checksheet->tanggal }}
            </div>

        </div>

    </div>

    {{-- PROGRESS --}}
    <div class="progress-wrapper">

        <div class="d-flex justify-content-between mb-2">

            <div>
                <strong>Progress Checksheet</strong>
            </div>

            <div>

                @php

                    $total = 0;
                    $filled = 0;

                    foreach($checksheet->sections as $s){
                        foreach($s->items as $i){
                            foreach($i->details as $d){

                                $total++;

                                if(optional($d->result)->status){
                                    $filled++;
                                }
                            }
                        }
                    }

                    $percent = $total > 0
                        ? round(($filled / $total) * 100)
                        : 0;

                @endphp

                {{ $filled }}/{{ $total }}

            </div>

        </div>

        <div class="progress">

            <div class="progress-bar bg-success"
                style="width: {{ $percent }}%">

            </div>

        </div>

    </div>

    {{-- FORM --}}
    <form method="POST"
        action="{{ route('checksheet.mobile.save') }}">

        @csrf

        <div class="accordion"
            id="accordionChecksheet">

            @foreach($checksheet->sections as $section)

                <div class="accordion-item">

                    {{-- HEADER --}}
                    <h2 class="accordion-header">

                        <button class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#section{{ $section->id }}">

                            {{ $section->nama_section }}

                        </button>

                    </h2>

                    {{-- BODY --}}
                    <div id="section{{ $section->id }}"
                        class="accordion-collapse collapse"
                        data-bs-parent="#accordionChecksheet">

                        <div class="accordion-body">

                            {{-- ITEMS --}}
                            @foreach($section->items as $item)

                                <div class="item-box">

                                    {{-- URAIAN --}}
                                    <div class="uraian-title">

                                        {{ $item->nomor }}
                                        .
                                        {{ $item->uraian }}

                                    </div>

                                    {{-- DETAILS --}}
                                    @foreach($item->details as $detail)

                                        <div class="detail-box">

                                            {{-- AKTIVITAS --}}
                                            <div class="detail-label">
                                                Aktivitas
                                            </div>

                                            <div class="detail-value">
                                                {{ $detail->aktivitas }}
                                            </div>

                                            {{-- STANDAR --}}
                                            <div class="detail-label mt-2">
                                                Standar
                                            </div>

                                            <div class="detail-value">
                                                {{ $detail->standar }}
                                            </div>

                                            {{-- RADIO --}}
                                            <div class="radio-wrapper">

                                                {{-- OK --}}
                                                <label class="w-100">

                                                    <input type="radio"
                                                        name="details[{{ $detail->id }}][status]"
                                                        value="OK"
                                                        {{ optional($detail->result)->status == 'OK' ? 'checked' : '' }}>

                                                    <div class="btn-ok">
                                                        ✔ OK
                                                    </div>

                                                </label>

                                                {{-- NOK --}}
                                                <label class="w-100">

                                                    <input type="radio"
                                                        name="details[{{ $detail->id }}][status]"
                                                        value="NOK"
                                                        {{ optional($detail->result)->status == 'NOK' ? 'checked' : '' }}>

                                                    <div class="btn-nok">
                                                        ✖ NOK
                                                    </div>

                                                </label>

                                            </div>

                                            {{-- KETERANGAN --}}
                                            <textarea
                                                name="details[{{ $detail->id }}][keterangan]"
                                                class="form-control mt-3"
                                                rows="2"
                                                placeholder="Tambahkan keterangan jika diperlukan...">{{ optional($detail->result)->keterangan }}</textarea>

                                        </div>

                                    @endforeach

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        {{-- STICKY SAVE --}}
        <div class="sticky-save">

            <button type="submit"
                class="btn btn-success save-btn">

                <i class="fa fa-save me-1"></i>

                Simpan Checksheet

            </button>

        </div>

    </form>

</div>

{{-- BOOTSTRAP JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection