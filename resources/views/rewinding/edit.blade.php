@extends('layouts.main')

@section('title', 'Edit Rewinding')

<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <div class="card shadow">

        
        <div class="card-header bg-danger text-white">
            <h4>
                <i class="fas fa-edit"></i>
                Edit Data Rewinding
            </h4>
        </div>

        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('rewinding.update', $rewinding->id) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>No SJN</label>
                        <input type="text" name="no_sjn" autocomplete="off" class="form-control"
                            value="{{ $rewinding->no_sjn }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>No SPPJP</label>
                        <input type="text" name="no_sppjp" autocomplete="off" class="form-control"
                            value="{{ $rewinding->no_sppjp }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Tanggal SJN Keluar</label>
                        <input type="date" name="tanggal_sjn_keluar" class="form-control"
                            value="{{ $rewinding->tanggal_sjn_keluar }}" required>
                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Lampiran SJN Keluar</label>

                        <input type="file" name="lampiran_sjn_keluar" class="form-control">

                        @if ($rewinding->lampiran_sjn_keluar)
                            <div class="alert alert-info mt-2">

                                <strong>File Saat Ini :</strong>

                                <br>

                                {{ $rewinding->nama_lampiran_keluar }}

                            </div>

                            <a href="{{ asset($rewinding->lampiran_sjn_keluar) }}" target="_blank"
                                class="btn btn-success btn-sm">

                                <i class="fas fa-eye"></i>
                                Lihat

                            </a>

                            <a href="{{ asset($rewinding->lampiran_sjn_keluar) }}" download class="btn btn-primary btn-sm">

                                <i class="fas fa-download"></i>
                                Download

                            </a>
                        @endif

                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Tanggal SJN Masuk</label>
                        <input type="date" name="tanggal_sjn_masuk" class="form-control"
                            value="{{ $rewinding->tanggal_sjn_masuk }}">
                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Lampiran SJN Masuk</label>

                        <input type="file" name="lampiran_sjn_masuk" class="form-control">

                        @if ($rewinding->lampiran_sjn_masuk)
                            <div class="alert alert-info mt-2">

                                <strong>File Saat Ini :</strong>

                                <br>

                                {{ $rewinding->nama_lampiran_masuk }}

                            </div>

                            <a href="{{ asset($rewinding->lampiran_sjn_masuk) }}" target="_blank"
                                class="btn btn-success btn-sm">

                                <i class="fas fa-eye"></i>
                                Lihat

                            </a>

                            <a href="{{ asset($rewinding->lampiran_sjn_masuk) }}" download class="btn btn-primary btn-sm">

                                <i class="fas fa-download"></i>
                                Download

                            </a>
                        @endif

                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" rows="3" autocomplete="off" class="form-control">{{ $rewinding->deskripsi }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" rows="3" autocomplete="off" class="form-control">{{ $rewinding->keterangan }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">

                        <label>Status</label>

                        <div>

                            @if ($rewinding->status == 'Closed')
                                <span class="badge badge-success p-2">
                                    CLOSED
                                </span>
                            @else
                                <span class="badge badge-warning p-2">
                                    OPEN
                                </span>
                            @endif

                        </div>

                        <small class="text-muted">
                            Status otomatis CLOSED jika Lampiran SJN Masuk sudah diupload.
                        </small>

                    </div>

                </div>

                <button type="submit" class="btn btn-danger">

                    <i class="fas fa-save"></i>
                    Update

                </button>

                <a href="{{ route('rewinding.index') }}" class="btn btn-secondary">

                    Kembali

                </a>

            </form>

            <hr>

            {{-- HAPUS LAMPIRAN SJN KELUAR --}}
            @if ($rewinding->lampiran_sjn_keluar)
                <form action="{{ route('rewinding.hapusLampiranKeluar', $rewinding->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Hapus lampiran SJN keluar?')">

                    @csrf

                    <button class="btn btn-danger">

                        <i class="fas fa-trash"></i>

                        Hapus Lampiran Keluar

                    </button>

                </form>
            @endif

            {{-- HAPUS LAMPIRAN SJN MASUK --}}
            @if ($rewinding->lampiran_sjn_masuk)
                <form action="{{ route('rewinding.hapusLampiranMasuk', $rewinding->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Hapus lampiran SJN masuk?')">

                    @csrf

                    <button class="btn btn-warning">

                        <i class="fas fa-trash"></i>

                        Hapus Lampiran Masuk

                    </button>

                </form>
            @endif

        </div>

    </div>

@endsection
