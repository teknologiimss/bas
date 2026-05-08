@extends('layouts.main')

@section('title', 'Checksheet')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')

    <style>
        body {
            background: #f8f9fa;
        }

        .table-container {
            overflow-x: auto;
            width: 100%;
            border-radius: 10px;
        }

        .table-check {
            min-width: 1400px;
            border-collapse: separate !important;
            border-spacing: 0;
        }

        .table-check th,
        .table-check td {
            text-align: center;
            vertical-align: middle;
            padding: 6px;
        }

        .table-check th {
            background: linear-gradient(45deg, #b30000, #ff3333);
            color: white;
            position: sticky;
            top: 0;
            z-index: 4;
        }

        .table-check th:first-child {
            position: sticky;
            left: 0;
            z-index: 5;
        }

        .table-check td:first-child {
            position: sticky;
            left: 0;
            background: #fff;
            z-index: 3;
            font-weight: bold;
        }

        .ok {
            background: #00cc66 !important;
            color: white;
        }

        .nok {
            background: #ff1a1a !important;
            color: white;
        }

        select {
            border: none;
            background: transparent;
            width: 100%;
            text-align: center;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="date"],
        input[type="text"] {
            border: none;
            text-align: center;
            font-size: 12px;
        }

        input[type="file"] {
            font-size: 11px;
        }

        input:focus,
        select:focus {
            outline: none;
            box-shadow: none;
        }

        .header-box {
            background: linear-gradient(135deg, #b30000, #ff1a1a);
            color: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 15px;
        }

        .header-title {
            font-size: 14px;
        }

        .header-name {
            font-size: 20px;
            font-weight: bold;
        }

        .btn-success {
            background: linear-gradient(45deg, #094701, #36bc01);
            border: none;
            border-radius: 8px;
        }

        .header-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .lampiran-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 5px;
            margin-bottom: 8px;
            background: #fff;
        }

        .img-thumbnail {
            border-radius: 8px;
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
