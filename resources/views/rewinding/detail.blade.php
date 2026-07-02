@extends('layouts.main')

@section('title', 'Detail Rewinding')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        body {
            background: #f4f7fc;
        }

        .card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .12);
            animation: fadeUp .5s ease;
        }

        .card-header {
            background: linear-gradient(135deg, #0f172a, #1e3a8a) !important;
            color: #fff !important;
            border: none;
            padding: 18px 22px;
        }

        .card-header h4 {
            margin: 0;
            font-weight: 700;
            letter-spacing: .5px;
        }

        .card-body {
            background: #fff;
            padding: 25px;
        }

        /* TABLE */
        .table {
            margin-bottom: 0;
        }

        .table-bordered {
            border-color: #d7e3f5;
        }

        .table th {
            background: #edf4ff;
            color: #0f172a;
            font-weight: 700;
            width: 200px;
            vertical-align: middle;
        }

        .table td {
            vertical-align: middle;
            background: #fff;
        }

        .table tbody tr:hover {
            background: #f7fbff;
        }

        /* FORM */
        label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            transition: .25s;
            padding: 10px 12px;
        }

        .form-control:focus {
            border-color: #1e40af;
            box-shadow: 0 0 0 .2rem rgba(30, 64, 175, .15);
        }

        textarea.form-control {
            resize: vertical;
        }

        /* BUTTON */
        .btn {
            border-radius: 10px;
            font-weight: 600;
            transition: .25s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            border: none;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #1d4ed8, #3b82f6);
        }

        .btn-primary {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb, #60a5fa);
        }

        .btn-danger {
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            border: none;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #1e293b, #2563eb);
        }

        .btn-secondary {
            background: #64748b;
            border: none;
        }

        .btn-secondary:hover {
            background: #475569;
        }

        /* CARD LAMPIRAN */
        .card.mb-3 {
            border-radius: 14px;
            border: 1px solid #dbeafe;
            box-shadow: 0 4px 12px rgba(15, 23, 42, .08);
            transition: .25s;
        }

        .card.mb-3:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 24px rgba(15, 23, 42, .15);
        }

        .card.mb-3 .card-body {
            padding: 18px;
        }

        /* HR */
        hr {
            border-top: 1px solid #dbeafe;
        }

        /* Animation */
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

        /* MOBILE */
        @media(max-width:768px) {

            .card-body {
                padding: 16px;
            }

            .card-header {
                padding: 15px;
            }

            .card-header h4 {
                font-size: 18px;
            }

            .table-responsive {
                overflow-x: auto;
            }

            .table {
                min-width: 650px;
            }

            .btn {
                width: 100%;
                margin-bottom: 8px;
            }

            form[style="display:inline"] {
                display: block !important;
                margin-top: 8px;
            }

            .col-md-4 {
                margin-bottom: 15px;
            }
        }
    </style>

    <div class="card shadow">

        <div class="card-header bg-danger text-white">

            <h4>

                Detail Rewinding

            </h4>

        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('rewinding.detail.store', $rewinding->id) }}" enctype="multipart/form-data">

                @csrf

                <table class="table table-bordered">

                    <tr>

                        <th width="200">
                            Status
                        </th>

                        <td>

                            <select name="status" class="form-control">

                                <option value="Open" {{ $detail->status == 'Open' ? 'selected' : '' }}>

                                    Open

                                </option>

                                <option value="Closed" {{ $detail->status == 'Closed' ? 'selected' : '' }}>

                                    Closed

                                </option>

                            </select>

                        </td>

                    </tr>

                    <tr>

                        <th>
                            Tanggal
                        </th>

                        <td>

                            <input type="date" name="tanggal" value="{{ $detail->tanggal }}" class="form-control">

                        </td>

                    </tr>

                    <tr>

                        <th>
                            Keterangan
                        </th>

                        <td>

                            <textarea name="keterangan" rows="4" class="form-control">{{ $detail->keterangan }}</textarea>

                        </td>

                    </tr>

                    <tr>

                        <th>
                            Lampiran
                        </th>

                        <td>

                            <input type="file" name="lampiran[]" multiple class="form-control">

                        </td>

                    </tr>

                </table>

                <div class="mt-3">

                    <button type="submit" class="btn btn-success">

                        <i class="fas fa-save"></i>
                        Simpan

                    </button>

                    <a href="{{ route('rewinding.index') }}" class="btn btn-secondary">

                        <i class="fas fa-arrow-left"></i>
                        Kembali

                    </a>

                </div>

            </form>

            <hr>

            <div class="row">

                @foreach ($detail->lampirans as $lampiran)
                    <div class="col-md-4">

                        <div class="card mb-3">

                            <div class="card-body">

                                {{ $lampiran->nama_file }}

                                <hr>

                                <a href="{{ asset($lampiran->file) }}" target="_blank" class="btn btn-primary btn-sm">

                                    Lihat

                                </a>

                                <a href="{{ asset($lampiran->file) }}" download class="btn btn-success btn-sm">

                                    Download

                                </a>

                                <form action="{{ route('rewinding.lampiran.delete', $lampiran->id) }}" method="POST"
                                    style="display:inline">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

        </div>

    </div>

@endsection
