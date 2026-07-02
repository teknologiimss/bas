@extends('layouts.main')

@section('title', 'Checksheet')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')

    <style>
        body {
            background: #eef3f8;
            font-family: "Segoe UI", sans-serif;
        }

        /* HEADER */
        .header-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
        }

        .header-box {
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            color: #fff;
            padding: 20px;
            border-radius: 16px;
            text-align: center;
            width: 100%;
            max-width: 650px;
            box-shadow: 0 12px 28px rgba(15, 23, 42, .25);
            animation: fadeDown .4s ease;
        }

        .header-title {
            font-size: 13px;
            letter-spacing: 2px;
            text-transform: uppercase;
            opacity: .85;
        }

        .header-name {
            font-size: 22px;
            font-weight: 700;
            margin-top: 5px;
        }

        /* CARD */
        .card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .08);
            animation: fadeUp .4s ease;
        }

        /* TABLE */
        .table-container {
            overflow-x: auto;
            width: 100%;
            border-radius: 14px;
        }

        .table-check {
            min-width: 1450px;
            border-collapse: separate !important;
            border-spacing: 0;
        }

        .table-check th,
        .table-check td {
            text-align: center;
            vertical-align: middle;
            padding: 8px;
            border: 1px solid #d9e2ef;
        }

        .table-check th {
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            color: white;
            position: sticky;
            top: 0;
            z-index: 4;
            font-weight: 600;
        }

        .table-check th:first-child {
            position: sticky;
            left: 0;
            z-index: 6;
        }

        .table-check td:first-child {
            position: sticky;
            left: 0;
            background: white;
            z-index: 5;
            font-weight: bold;
        }

        .table-check tbody tr:hover td {
            background: #edf4ff;
        }

        /* STATUS */
        .ok {
            background: #16a34a !important;
            color: white;
            font-weight: bold;
        }

        .nok {
            background: #dc2626 !important;
            color: white;
            font-weight: bold;
        }

        /* INPUT */
        select,
        input[type=text],
        input[type=date] {
            width: 100%;
            border: none;
            background: transparent;
            text-align: center;
            font-size: 13px;
        }

        input[type=file] {
            font-size: 12px;
        }

        input:focus,
        select:focus {
            outline: none;
            box-shadow: none;
        }

        /* BUTTON */
        .btn {
            border-radius: 10px;
            transition: .25s;
            font-weight: 500;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
        }

        .btn-primary:hover {
            box-shadow: 0 8px 20px rgba(37, 99, 235, .3);
        }

        .btn-success {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            border: none;
            color: white;
        }

        .btn-success:hover {
            box-shadow: 0 8px 20px rgba(30, 58, 138, .35);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            border: none;
        }

        .btn-danger:hover {
            box-shadow: 0 8px 20px rgba(220, 38, 38, .3);
        }

        /* LAMPIRAN */
        .lampiran-box {
            border: 1px solid #dbe5f0;
            border-radius: 12px;
            background: white;
            padding: 10px;
            margin-bottom: 10px;
            transition: .25s;
        }

        .lampiran-box:hover {
            box-shadow: 0 8px 20px rgba(30, 58, 138, .15);
            transform: translateY(-2px);
        }

        .img-thumbnail {
            border-radius: 10px;
            border: 2px solid #dbeafe;
        }

        /* SCROLLBAR */
        .table-container::-webkit-scrollbar {
            height: 8px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 20px;
        }

        .table-container::-webkit-scrollbar-track {
            background: #e5e7eb;
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

        /* RESPONSIVE */
        @media(max-width:768px) {

            body {
                overflow-x: hidden;
            }

            .header-box {
                padding: 15px;
                border-radius: 14px;
            }

            .header-title {
                font-size: 11px;
            }

            .header-name {
                font-size: 17px;
            }

            .card {
                border-radius: 14px;
                padding: 12px !important;
            }

            .table-container {
                max-height: 75vh;
                overflow: auto;
            }

            .table-check {
                min-width: 1400px;
                font-size: 11px;
            }

            .table-check th,
            .table-check td {
                padding: 5px;
                font-size: 10px;
            }

            .table-check th {
                position: sticky;
                top: 0;
                z-index: 100;
            }

            .table-check th:first-child {
                left: 0;
                z-index: 200;
            }

            .table-check td:first-child {
                left: 0;
                z-index: 150;
                background: white;
            }

            .btn {
                height: 34px;
                font-size: 11px;
                padding: 0 12px;
            }

            input[type=file] {
                font-size: 10px;
            }

            .lampiran-box {
                padding: 8px;
            }

            .img-thumbnail {
                width: 65px;
            }
        }
    </style>

    <div class="header-wrapper">
        <div class="header-box">
            <div class="header-title">BAKP & CHECKSHEET</div>
            <div class="header-name">{{ $data->unit ?? '-' }}</div>
            <div class="header-name">{{ $data->no_lambung ?? '-' }}</div>
        </div>
    </div>

    <div class="card p-3">

        <form method="POST" action="{{ route('alat.detail.checksheet.store') }}" enctype="multipart/form-data">

            @csrf

            <input type="hidden" name="detail_id" value="{{ $data->id }}">

            <div class="table-container">

                <table class="table table-bordered table-check">

                    <thead>
                        <tr>
                            <th>Bulan</th>

                            @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'] as $bln)
                                <th>{{ $bln }}</th>
                            @endforeach

                        </tr>
                    </thead>

                    <tbody>

                        {{-- STATUS --}}
                        <tr>

                            <td>Status</td>

                            @for ($i = 1; $i <= 12; $i++)
                                @php
                                    $c = $checksheets[$i] ?? null;
                                @endphp

                                <td
                                    class="status-cell {{ $c && $c->status == 'OK' ? 'ok' : ($c && $c->status == 'NOK' ? 'nok' : '') }}">

                                    <select name="status[{{ $i }}]" class="status-select">

                                        <option value="">-</option>

                                        <option value="OK" {{ $c && $c->status == 'OK' ? 'selected' : '' }}>
                                            OK
                                        </option>

                                        <option value="NOK" {{ $c && $c->status == 'NOK' ? 'selected' : '' }}>
                                            NOK
                                        </option>

                                    </select>

                                </td>
                            @endfor

                        </tr>

                        {{-- TANGGAL --}}
                        <tr>

                            <td>Tanggal</td>

                            @for ($i = 1; $i <= 12; $i++)
                                @php $c = $checksheets[$i] ?? null; @endphp

                                <td>

                                    <input type="date" name="tanggal[{{ $i }}]"
                                        value="{{ $c ? $c->tanggal : '' }}">

                                </td>
                            @endfor

                        </tr>

                        {{-- KETERANGAN --}}
                        <tr>

                            <td>Keterangan</td>

                            @for ($i = 1; $i <= 12; $i++)
                                @php $c = $checksheets[$i] ?? null; @endphp

                                <td>

                                    <input type="text" name="keterangan[{{ $i }}]"
                                        value="{{ $c ? $c->keterangan : '' }}">

                                </td>
                            @endfor

                        </tr>

                        {{-- LAMPIRAN --}}
                        <tr>

                            <td>Lampiran</td>

                            @for ($i = 1; $i <= 12; $i++)

                                @php
                                    $c = $checksheets[$i] ?? null;
                                @endphp

                                <td style="min-width:300px">

                                    {{-- MULTIPLE FILE --}}
                                    <input type="file" name="lampiran[{{ $i }}][]" multiple
                                        class="form-control form-control-sm">

                                    {{-- LIST FILE --}}
                                    @if ($c && $c->lampirans->count())
                                        <div class="mt-2">

                                            @foreach ($c->lampirans as $lampiran)
                                                @php
                                                    $ext = pathinfo($lampiran->file, PATHINFO_EXTENSION);
                                                @endphp

                                                <div class="lampiran-box">

                                                    {{-- PREVIEW IMAGE --}}
                                                    @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                                                        <img src="{{ asset($lampiran->file) }}" width="80"
                                                            class="img-thumbnail mb-2">
                                                    @endif

                                                    <div style="font-size:11px">
                                                        {{ $lampiran->nama_file }}
                                                    </div>

                                                    <div class="d-flex gap-1 justify-content-center mt-2">

                                                        {{-- LIHAT --}}
                                                        <a href="{{ asset($lampiran->file) }}" target="_blank"
                                                            class="btn btn-primary btn-sm">

                                                            Lihat

                                                        </a>

                                                        {{-- DOWNLOAD --}}
                                                        <a href="{{ asset($lampiran->file) }}" download
                                                            class="btn btn-success btn-sm">

                                                            Download

                                                        </a>

                                                        {{-- HAPUS --}}
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="deleteLampiran('{{ route('lampiran.delete', $lampiran->id) }}')">

                                                            Hapus

                                                        </button>

                                                    </div>

                                                </div>
                                            @endforeach

                                        </div>
                                    @endif

                                </td>

                            @endfor

                        </tr>

                    </tbody>

                </table>

            </div>

            <div class="text-center">
                <button class="btn btn-success mt-3 px-4">
                    💾 Simpan
                </button>
            </div>

        </form>

    </div>

    {{-- FORM HIDDEN DELETE --}}
    <form id="deleteForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

@endsection

@section('custom-js')

    <script>
        // AUTO WARNA STATUS
        document.querySelectorAll('.status-select').forEach(select => {

            select.addEventListener('change', function() {

                let td = this.closest('td');

                td.classList.remove('ok', 'nok');

                if (this.value === 'OK') {
                    td.classList.add('ok');
                } else if (this.value === 'NOK') {
                    td.classList.add('nok');
                }

            });

        });

        // DELETE LAMPIRAN
        function deleteLampiran(url) {
            if (confirm('Hapus lampiran ini ?')) {
                let form = document.getElementById('deleteForm');

                form.action = url;

                form.submit();
            }
        }
    </script>

@endsection
