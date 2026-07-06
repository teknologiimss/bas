@extends('layouts.main')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')
    <div class="container-fluid">

        <form action="{{ route('mro.daily-activity.update', $daily->id) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">Edit Daily Activity</h3>
                </div>

                <div class="card-body">

                    {{-- Proyek --}}
                    <div class="form-group">
                        <label>Proyek</label>

                        <select name="monitoring_id" class="form-control" required>

                            @foreach ($monitoring as $m)
                                <option value="{{ $m->id }}" {{ $daily->monitoring_id == $m->id ? 'selected' : '' }}>

                                    {{ $m->po_nota_dinas }}
                                    -
                                    {{ $m->nama_pekerjaan }}

                                </option>
                            @endforeach

                        </select>
                    </div>

                    {{-- Kegiatan --}}
                    <div class="form-group">

                        <label>Kegiatan</label>

                        <textarea name="kegiatan" autocomplete="off" class="form-control" rows="3" required>{{ $daily->kegiatan }}</textarea>

                    </div>

                    {{-- Status --}}
                    <div class="form-group">

                        <label>Status</label>

                        <select name="status" class="form-control">

                            <option value="Open" {{ $daily->status == 'Open' ? 'selected' : '' }}>

                                Open

                            </option>

                            <option value="Closed" {{ $daily->status == 'Closed' ? 'selected' : '' }}>

                                Closed

                            </option>

                        </select>

                    </div>

                    {{-- Tanggal --}}
                    <div class="form-group">

                        <label>Tanggal</label>

                        <input type="date" name="tanggal" class="form-control" value="{{ $daily->tanggal }}" required>

                    </div>

                    {{-- Keterangan --}}
                    <div class="form-group">

                        <label>Keterangan</label>

                        <textarea name="keterangan" autocomplete="off" class="form-control" rows="3">{{ $daily->keterangan }}</textarea>

                    </div>

                    <hr>

                    <h5>
                        <b>Nama Personil</b>
                    </h5>

                    <div id="personil-wrapper">

                        @foreach ($daily->personil ?? [] as $nama)
                            <div class="input-group mb-2">

                                <select name="personil[]" class="form-control" required>

                                    <option value="">-- Pilih Personil --</option>

                                    @foreach ($personils as $p)
                                        <option value="{{ $p->nama }}" {{ $nama == $p->nama ? 'selected' : '' }}>

                                            {{ $p->nama }}

                                            @if ($p->jabatan)
                                                - {{ $p->jabatan }}
                                            @endif

                                        </option>
                                    @endforeach

                                </select>

                                <div class="input-group-append">

                                    <button type="button" class="btn btn-danger btnHapusPersonil">

                                        <i class="fa fa-minus"></i>

                                    </button>

                                </div>

                            </div>
                        @endforeach

                    </div>

                    <button type="button" class="btn btn-success mb-3" id="btnTambahPersonil">

                        <i class="fa fa-plus"></i>

                        Tambah Personil

                    </button>

                    <hr>

                    <h5>
                        <b>Lampiran Saat Ini</b>
                    </h5>

                    @forelse($daily->attachments as $lampiran)
                        <div class="border rounded p-2 mb-2 d-flex justify-content-between align-items-center">

                            <a href="{{ asset('uploads/daily_activity/' . $lampiran->file) }}" target="_blank"
                                class="btn btn-info btn-sm">

                                <i class="fa fa-file"></i>

                                Lihat File

                            </a>

                            <button type="button" class="btn btn-danger btnDeleteLampiran" data-id="{{ $lampiran->id }}">

                                <i class="fa fa-trash"></i>

                                Hapus

                            </button>

                        </div>

                    @empty

                        <div class="alert alert-secondary">

                            Tidak ada lampiran

                        </div>
                    @endforelse

                    <hr>

                    <h5>
                        <b>Tambah Lampiran Baru</b>
                    </h5>

                    <div id="lampiran-wrapper">

                        <div class="input-group mb-2">

                            <input type="file" name="lampiran[]" class="form-control">

                            <div class="input-group-append">

                                <button type="button" class="btn btn-danger btnHapusLampiran">

                                    <i class="fa fa-minus"></i>

                                </button>

                            </div>

                        </div>

                    </div>

                    <button type="button" class="btn btn-success mb-3" id="btnTambahLampiran">

                        <i class="fa fa-plus"></i>

                        Tambah Lampiran

                    </button>

                </div>

                <div class="card-footer">

                    <button class="btn btn-primary">

                        <i class="fa fa-save"></i>

                        Update

                    </button>

                    <a href="{{ route('mro.daily-activity.index') }}" class="btn btn-secondary">

                        Kembali

                    </a>

                </div>

            </div>

        </form>



    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /*
            |--------------------------------------------------------------------------
            | PERSONIL
            |--------------------------------------------------------------------------
            */

            const personilWrapper = document.getElementById('personil-wrapper');
            const btnTambahPersonil = document.getElementById('btnTambahPersonil');

            btnTambahPersonil.addEventListener('click', function() {

                personilWrapper.insertAdjacentHTML('beforeend', `
            <div class="input-group mb-2">

                <select
                    name="personil[]"
                    class="form-control"
                    required>

                    <option value="">-- Pilih Personil --</option>

                    @foreach ($personils as $p)

                        <option value="{{ $p->nama }}">

                            {{ $p->nama }}

                            @if ($p->jabatan)
                            - {{ $p->jabatan }}
                            @endif

                        </option>

                    @endforeach

                </select>

                <div class="input-group-append">

                    <button
                        type="button"
                        class="btn btn-danger btnHapusPersonil">

                        <i class="fa fa-minus"></i>

                    </button>

                </div>

            </div>
        `);

            });

            /*
            |--------------------------------------------------------------------------
            | LAMPIRAN
            |--------------------------------------------------------------------------
            */

            const lampiranWrapper = document.getElementById('lampiran-wrapper');
            const btnTambahLampiran = document.getElementById('btnTambahLampiran');

            btnTambahLampiran.addEventListener('click', function() {

                lampiranWrapper.insertAdjacentHTML('beforeend', `
            <div class="input-group mb-2">

                <input
                    type="file"
                    name="lampiran[]"
                    class="form-control">

                <div class="input-group-append">

                    <button
                        type="button"
                        class="btn btn-danger btnHapusLampiran">

                        <i class="fa fa-minus"></i>

                    </button>

                </div>

            </div>
        `);

            });

            /*
            |--------------------------------------------------------------------------
            | HAPUS INPUT PERSONIL / LAMPIRAN
            |--------------------------------------------------------------------------
            */

            document.addEventListener('click', function(e) {

                // Hapus personil
                if (e.target.closest('.btnHapusPersonil')) {

                    const row = e.target.closest('.input-group');

                    if (personilWrapper.querySelectorAll('.input-group').length > 1) {
                        row.remove();
                    }

                }

                // Hapus lampiran baru
                if (e.target.closest('.btnHapusLampiran')) {

                    const row = e.target.closest('.input-group');

                    if (lampiranWrapper.querySelectorAll('.input-group').length > 1) {
                        row.remove();
                    }

                }

            });

        });
    </script>

    <script>
        document.addEventListener('click', function(e) {

            const btn = e.target.closest('.btnDeleteLampiran');

            if (!btn) return;

            Swal.fire({

                title: 'Hapus lampiran?',

                text: 'Data tidak dapat dikembalikan',

                icon: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Ya',

                cancelButtonText: 'Batal'

            }).then((result) => {

                if (result.isConfirmed) {

                    const form = document.getElementById('deleteLampiranForm');

                    form.action = "/products/mro/daily-activity/lampiran/" + btn.dataset.id;

                    form.submit();

                }

            });

        });
    </script>
@endsection
