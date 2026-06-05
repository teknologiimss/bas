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

            {{-- FORM UPDATE --}}
            <form action="{{ route('rewinding.update', $rewinding->id) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>No SJN</label>
                        <input type="text" name="no_sjn" autocomplete="off" class="form-control" value="{{ $rewinding->no_sjn }}" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Tanggal SJN</label>
                        <input type="date" name="tanggal_sjn" class="form-control" value="{{ $rewinding->tanggal_sjn }}"
                            required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Tanggal Masuk SJN</label>
                        <input type="date" name="tanggal_masuk_sjn" class="form-control"
                            value="{{ $rewinding->tanggal_masuk_sjn }}" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" autocomplete="off" class="form-control" rows="3">{{ $rewinding->deskripsi }}</textarea>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Qty</label>
                        <input type="text" name="qty" autocomplete="off" class="form-control" value="{{ $rewinding->qty }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Satuan</label>
                        <input type="text" name="satuan" autocomplete="off" class="form-control" value="{{ $rewinding->satuan }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>No SPPJP</label>
                        <input type="text" name="no_sppjp" autocomplete="off" class="form-control" value="{{ $rewinding->no_sppjp }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Keterangan</label>
                        <textarea name="keterangan" autocomplete="off" class="form-control" rows="3">{{ $rewinding->keterangan }}</textarea>
                    </div>

                    {{-- LAMPIRAN --}}
                    <div class="col-md-12 mb-3">

                        <label>Lampiran Baru</label>

                        <input type="file" name="lampiran" class="form-control">

                        @if ($rewinding->lampiran)
                            <div class="alert alert-info mt-3">

                                <strong>File Saat Ini :</strong>

                                <br>

                                <i class="fas fa-file-pdf text-danger"></i>

                                {{ $rewinding->nama_lampiran ?? basename($rewinding->lampiran) }}

                            </div>

                            <a href="{{ asset($rewinding->lampiran) }}" target="_blank" class="btn btn-success btn-sm">

                                <i class="fas fa-eye"></i>
                                Lihat Lampiran

                            </a>

                            <a href="{{ asset($rewinding->lampiran) }}" download class="btn btn-primary btn-sm">

                                <i class="fas fa-download"></i>
                                Download

                            </a>
                        @endif

                    </div>

                    {{-- STATUS --}}
                    <div class="col-md-12 mb-3">

                        <label>Status</label>

                        <div>

                            @if ($rewinding->status == 'Closed')
                                <span class="badge badge-success">
                                    CLOSED
                                </span>
                            @else
                                <span class="badge badge-warning">
                                    OPEN
                                </span>
                            @endif

                        </div>

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

            {{-- FORM HAPUS LAMPIRAN TERPISAH --}}
            @if ($rewinding->lampiran)
                <hr>

                <form action="{{ route('rewinding.hapusLampiran', $rewinding->id) }}" method="POST"
                    onsubmit="return confirm('Yakin hapus lampiran ini?')">

                    @csrf

                    <button type="submit" class="btn btn-danger">

                        <i class="fas fa-trash"></i>
                        Hapus Lampiran

                    </button>

                </form>
            @endif

        </div>

    </div>

@endsection
