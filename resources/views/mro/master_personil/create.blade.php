@extends('layouts.main')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')
    <style>
        body {
            background: #eef3f9;
        }

        .personil-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
        }

        .personil-header {
            background: linear-gradient(135deg, #081f5c, #123a9b);
            color: #fff;
            padding: 22px;
        }

        .personil-header h3 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
        }

        .personil-header p {
            margin: 6px 0 0;
            opacity: .85;
            font-size: 14px;
        }

        .card-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            font-weight: 600;
            color: #163a7a;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #d6dceb;
            height: 46px;
            box-shadow: none !important;
            transition: .2s;
        }

        textarea.form-control {
            height: auto;
        }

        .form-control:focus {
            border-color: #123a9b;
            box-shadow: 0 0 0 .18rem rgba(18, 58, 155, .15) !important;
        }

        .btn-save {

            background: #123a9b;
            border: none;
            border-radius: 12px;
            padding: 10px 24px;
            font-weight: 600;
        }

        .btn-save:hover {

            background: #0d2c7a;
        }

        .btn-back {

            border-radius: 12px;
            padding: 10px 24px;
            font-weight: 600;
        }

        .card-footer {

            background: #fff;
            border-top: 1px solid #edf1f7;
            padding: 20px 30px;
        }

        @media(max-width:768px) {

            .personil-header {

                padding: 18px;
            }

            .personil-header h3 {

                font-size: 19px;
            }

            .personil-header p {

                font-size: 13px;
            }

            .card-body {

                padding: 18px;
            }

            .card-footer {

                padding: 18px;
            }

            .btn-save,
            .btn-back {

                width: 100%;
                margin-bottom: 10px;
            }

            .form-control {

                height: 44px;
            }

        }
    </style>

    <div class="container-fluid">

        <form action="{{ route('master-personil.store') }}" method="POST">

            @csrf

            <div class="card personil-card">

                <div class="personil-header">

                    <h3>

                        <i class="fas fa-user-plus mr-2"></i>

                        Tambah Personil MRO

                    </h3>

                    <p>

                        Lengkapi data personil di bawah ini.

                    </p>

                </div>

                <div class="card-body">

                    <div class="form-group">

                        <label>

                            Nama Personil

                        </label>

                        <input type="text" name="nama" class="form-control" autocomplete="off" placeholder="Masukkan nama personil"
                            required>

                    </div>

                    <div class="form-group">

                        <label>

                            NIP

                        </label>

                        <input type="text" name="nip" autocomplete="off" class="form-control" placeholder="Masukkan NIP">

                    </div>

                    <div class="form-group">

                        <label>Jabatan</label>

                        <input type="text" name="jabatan" autocomplete="off" class="form-control" placeholder="Contoh : Kadiv, Kadep ,Staf">

                    </div>

                    <div class="form-group">

                        <label>

                            Status

                        </label>

                        <select name="status" class="form-control">

                            <option value="Organik">

                                Organik

                            </option>

                            <option value="PKWT">

                                PKWT

                            </option>



                        </select>

                    </div>


                    <div class="form-group">

                        <label>Jobdesk</label>

                        <textarea name="jobdesk" autocomplete="off" class="form-control" rows="4" placeholder="Masukkan Jobdesk"></textarea>

                    </div>


                    <div class="form-group">

                        <label>Spesialisasi</label>

                        <input type="text" autocomplete="off" name="spesialisasi" class="form-control"
                            placeholder="Contoh : IT,Elektikal, Sipil">

                    </div>


                    <div class="form-group">

                        <label>Catatan</label>

                        <textarea name="catatan" autocomplete="off" class="form-control" rows="3" placeholder="Catatan tambahan"></textarea>

                    </div>



                    <div class="form-group">

                        <label>

                            Penempatan

                        </label>

                        <input type="text" name="penempatan" autocomplete="off" class="form-control" placeholder="Contoh : MRO 1" required>

                    </div>










                </div>

                <div class="card-footer">

                    <button type="submit" class="btn btn-save text-white">

                        <i class="fa fa-save mr-1"></i>

                        Simpan

                    </button>

                    <a href="{{ route('master-personil.index') }}" class="btn btn-secondary btn-back">

                        <i class="fa fa-arrow-left mr-1"></i>

                        Kembali

                    </a>

                </div>

            </div>

        </form>

    </div>
@endsection
