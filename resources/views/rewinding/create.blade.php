@extends('layouts.main')

@section('title', 'Tambah Rewinding')

@section('content')

    <div class="card shadow">
        <div class="card-header bg-danger text-white">
            <h4>
                <i class="fas fa-plus-circle"></i>
                Tambah Data Rewinding
            </h4>
        </div>

        <div class="card-body">

            <form action="{{ route('rewinding.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>No SJN</label>
                        <input type="text" autocomplete="off" name="no_sjn" class="form-control" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Tanggal SJN</label>
                        <input type="date" name="tanggal_sjn" class="form-control" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Tanggal Masuk SJN</label>
                        <input type="date" name="tanggal_masuk_sjn" class="form-control" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" autocomplete="off" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Qty</label>
                        <input type="text" autocomplete="off" name="qty" class="form-control">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Satuan</label>
                        <input type="text" autocomplete="off" name="satuan" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>No SPPJP</label>
                        <input type="text" autocomplete="off" name="no_sppjp" class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" autocomplete="off" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Lampiran</label>
                        <input type="file" name="lampiran" class="form-control">
                        <small class="text-muted">
                            Jika lampiran diupload maka status otomatis CLOSED.
                        </small>
                    </div>

                </div>

                <button class="btn btn-danger">
                    <i class="fas fa-save"></i>
                    Simpan
                </button>

                <a href="{{ route('rewinding.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>

@endsection
