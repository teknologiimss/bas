@extends('layouts.main')

@section('title', 'Checksheet')

@section('content')

    <style>
        body {
            background: #f8f9fa;
        }

        /* CONTAINER SCROLL */
        .table-container {
            overflow-x: auto;
            width: 100%;
            border-radius: 10px;
        }

        /* TABLE */
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

        /* HEADER */
        .table-check th {
            background: linear-gradient(45deg, #b30000, #ff3333);
            color: white;
            position: sticky;
            top: 0;
            z-index: 4;
        }

        /* KOLOM PERTAMA (freeze seperti Excel) */
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

        /* WARNA STATUS */
        .ok {
            background: #00cc66 !important;
            color: white;
        }

        .nok {
            background: #ff1a1a !important;
            color: white;
        }

        /* INPUT STYLE */
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

        input:focus,
        select:focus {
            outline: none;
            box-shadow: none;
        }

        /* HEADER BOX */
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

        /* BUTTON */
        .btn-success {
            background: linear-gradient(45deg, #ff1a1a, #cc0000);
            border: none;
            border-radius: 8px;
        }

        .btn-success:hover {
            transform: scale(1.05);
        }

        /* WRAPPER HEADER (biar center) */
        .header-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* center horizontal */
            justify-content: center;
            margin-bottom: 20px;
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

        <form method="POST" action="{{ route('alat.detail.checksheet.store') }}">
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
                                @php $c = $checksheets[$i] ?? null; @endphp

                                <td
                                    class="status-cell {{ $c && $c->status == 'OK' ? 'ok' : ($c && $c->status == 'NOK' ? 'nok' : '') }}">
                                    <select name="status[{{ $i }}]" class="status-select">
                                        <option value="">-</option>
                                        <option value="OK" {{ $c && $c->status == 'OK' ? 'selected' : '' }}>OK</option>
                                        <option value="NOK" {{ $c && $c->status == 'NOK' ? 'selected' : '' }}>NOK</option>
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

                    </tbody>

                </table>
            </div>

            <div class="text-center">
                <button class="btn btn-success mt-3 px-4">💾 Simpan</button>
            </div>

        </form>

    </div>

@endsection


@section('custom-js')

    <script>
        // AUTO WARNA SAAT PILIH STATUS
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
    </script>

@endsection
