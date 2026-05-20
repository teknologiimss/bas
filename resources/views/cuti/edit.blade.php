@extends('layouts.main')

@section('content')
    <div class="container-fluid">

        <div class="card shadow">

            <div class="card-header bg-warning">

                <h5 class="mb-0">

                    EDIT CUTI

                </h5>

            </div>

            <div class="card-body">

                <form action="{{ route('cuti.update', $cuti->id) }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-md-3">

                            <label>Pegawai</label>

                            {{-- <select name="user_id" --}}
                            <select name="nama_pegawai" class="form-control" required>

                                {{-- @foreach ($pegawai as $p)

                                <option value="{{ $p->id }}"
                                    {{ $cuti->user_id == $p->id ? 'selected' : '' }}>

                                    {{ $p->nip ?? '-' }}
                                    -
                                    {{ $p->name }}

                                </option>

                            @endforeach --}}

                                @foreach ($pegawai as $p)
                                    <option value="{{ $p->nama_pegawai }}"
                                        {{ $cuti->nama_pegawai == $p->nama_pegawai ? 'selected' : '' }}>

                                        {{ $p->nama_pegawai }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-2">

                            <label>Jenis</label>

                            <select name="jenis" class="form-control" required>

                                <option value="CT" {{ $cuti->jenis == 'CT' ? 'selected' : '' }}>

                                    CUTI TAHUNAN

                                </option>

                                <option value="CS" {{ $cuti->jenis == 'CS' ? 'selected' : '' }}>

                                    CUTI SAKIT

                                </option>

                                <option value="CP" {{ $cuti->jenis == 'CP' ? 'selected' : '' }}>

                                    CUTI PENTING

                                </option>

                                <option value="CB" {{ $cuti->jenis == 'CB' ? 'selected' : '' }}>

                                    CUTI BESAR

                                </option>

                                <option value="CD" {{ $cuti->jenis == 'CD' ? 'selected' : '' }}>

                                    CUTI DISPENSASI

                                </option>

                            </select>

                        </div>

                        <div class="col-md-2">

                            <label>Tanggal Mulai</label>

                            <input type="date" name="tanggal_mulai" class="form-control"
                                value="{{ $cuti->tanggal_mulai }}" required>

                        </div>

                        <div class="col-md-2">

                            <label>Tanggal Selesai</label>

                            <input type="date" name="tanggal_selesai" class="form-control"
                                value="{{ $cuti->tanggal_selesai }}" required>

                        </div>

                        <div class="col-md-3">

                            <label>Keterangan</label>

                            <input type="text" name="keterangan" class="form-control" value="{{ $cuti->keterangan }}">

                        </div>

                    </div>

                    <div class="row mt-3">

                        <div class="col-md-6">

                            <label>Ganti Lampiran</label>

                            <input type="file" name="lampiran" class="form-control">

                        </div>

                    </div>

                    <br>

                    @if ($cuti->lampiran)
                        <a href="{{ asset('lampiran_cuti/' . $cuti->lampiran) }}" target="_blank" class="btn btn-info">

                            LIHAT LAMPIRAN

                        </a>
                    @endif

                    <button class="btn btn-success">

                        <i class="fas fa-save"></i>

                        UPDATE

                    </button>

                    <a href="{{ route('cuti.index') }}" class="btn btn-secondary">

                        KEMBALI

                    </a>

                </form>

            </div>

        </div>

    </div>
@endsection
