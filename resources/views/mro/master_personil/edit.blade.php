@extends('layouts.main')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

    <style>
        body {
            background: #eef3f9;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #0f172a;
        }

        .personil-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .08);
        }

        .personil-header {
            background: linear-gradient(135deg, #071c4d, #123a8b);
            color: #fff;
            padding: 22px;
        }

        .personil-header h4 {
            margin: 0;
            font-weight: 700;
        }

        .personil-body {
            padding: 30px;
            background: #fff;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 7px;
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #d8dee8;
            min-height: 46px;
        }

        .form-control:focus {
            border-color: #123a8b;
            box-shadow: 0 0 0 .15rem rgba(18, 58, 139, .15);
        }

        .btn-save {
            background: #123a8b;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 10px 24px;
            font-weight: 600;
        }

        .btn-save:hover {
            background: #0c2d6d;
            color: white;
        }

        .btn-back {
            border-radius: 12px;
            padding: 10px 24px;
            font-weight: 600;
        }

        .icon-box {
            width: 55px;
            height: 55px;
            border-radius: 15px;
            background: rgba(255, 255, 255, .15);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
        }

        @media(max-width:768px) {

            .page-title {
                font-size: 22px;
            }

            .personil-body {
                padding: 18px;
            }

            .personil-header {
                padding: 18px;
            }

            .btn-save,
            .btn-back {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>

    <div class="container-fluid">

        <div class="personil-card">

            <div class="personil-header">

                <div class="d-flex align-items-center">

                    <div class="icon-box me-3">
                        <i class="fas fa-user-edit"></i>
                    </div>

                    <div>

                        <h4>Edit Personil MRO</h4>

                        <small>
                            Ubah data personil MRO
                        </small>

                    </div>

                </div>

            </div>

            <form action="{{ route('master-personil.update', $personil->id) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="personil-body">

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label class="form-label">

                                    <i class="fas fa-user text-primary"></i>

                                    Nama Personil

                                </label>

                                <input type="text" name="nama" value="{{ $personil->nama }}" class="form-control"
                                    required>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label class="form-label">

                                    <i class="fas fa-id-card text-primary"></i>

                                    NIP

                                </label>

                                <input type="text" name="nip" value="{{ $personil->nip }}" class="form-control">

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label class="form-label">

                                    <i class="fas fa-user-check text-primary"></i>

                                    Status

                                </label>

                                <select name="status" class="form-control">

                                    <option {{ $personil->status == 'Tetap' ? 'selected' : '' }}>
                                        Tetap
                                    </option>

                                    <option {{ $personil->status == 'Kontrak' ? 'selected' : '' }}>
                                        Kontrak
                                    </option>

                                    <option {{ $personil->status == 'Outsourcing' ? 'selected' : '' }}>
                                        Outsourcing
                                    </option>

                                </select>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label class="form-label">

                                    <i class="fas fa-map-marker-alt text-primary"></i>

                                    Penempatan

                                </label>

                                <input type="text" name="penempatan" value="{{ $personil->penempatan }}"
                                    class="form-control" required>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="card-footer bg-white border-0 px-4 pb-4">

                    <button class="btn btn-save">

                        <i class="fas fa-save"></i>

                        Update Data

                    </button>

                    <a href="{{ route('master-personil.index') }}" class="btn btn-secondary btn-back">

                        <i class="fas fa-arrow-left"></i>

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>
@endsection
