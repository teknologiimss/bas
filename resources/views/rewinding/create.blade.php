@extends('layouts.main')

@section('title', 'Tambah Rewinding')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
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
                <input type="hidden" name="rewinding_folder_id" value="{{ $folder->id }}">
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>No SJN</label>
                        <input type="text" name="no_sjn" autocomplete="off" class="form-control" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Tanggal SJN Keluar</label>
                        <input type="date" name="tanggal_sjn_keluar" class="form-control" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Lampiran SJN Keluar</label>
                        <input type="file" name="lampiran_sjn_keluar" class="form-control">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Tanggal SJN Masuk</label>
                        <input type="date" name="tanggal_sjn_masuk" class="form-control">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Lampiran SJN Masuk</label>
                        <input type="file" name="lampiran_sjn_masuk" class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" autocomplete="off" class="form-control"></textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" autocomplete="off" class="form-control"></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>No SPPJP</label>
                        <input type="text" autocomplete="off" name="no_sppjp" class="form-control">
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
