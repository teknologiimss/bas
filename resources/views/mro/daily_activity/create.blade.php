@extends('layouts.main')

@section('content')
    <div class="container-fluid">

        <form action="{{ route('mro.daily-activity.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">Tambah Daily Activity</h3>
                </div>

                <div class="card-body">

                    {{-- Proyek --}}
                    <div class="form-group">
                        <label>Proyek</label>

                        <select name="monitoring_id" class="form-control" required>

                            <option value="">-- Pilih Proyek --</option>

                            @foreach ($monitoring as $m)
                                <option value="{{ $m->id }}">
                                    {{ $m->po_nota_dinas }} - {{ $m->nama_pekerjaan }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                    {{-- Kegiatan --}}
                    <div class="form-group">

                        <label>Kegiatan</label>

                        <textarea name="kegiatan" class="form-control" rows="3" required></textarea>

                    </div>

                    {{-- Status --}}
                    <div class="form-group">

                        <label>Status</label>

                        <select name="status" class="form-control">

                            <option value="Open">Open</option>
                            <option value="Closed">Closed</option>

                        </select>

                    </div>

                    {{-- Tanggal --}}
                    <div class="form-group">

                        <label>Tanggal</label>

                        <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>

                    </div>

                    {{-- Keterangan --}}
                    <div class="form-group">

                        <label>Keterangan</label>

                        <textarea name="keterangan" class="form-control" rows="3"></textarea>

                    </div>

                    <hr>

                    <h5><b>Nama Personil</b></h5>

                    <div id="personil-wrapper">

                        <div class="input-group mb-2">

                            <input type="text" name="personil[]" class="form-control"
                                placeholder="Masukkan Nama Personil" required>

                            <div class="input-group-append">

                                <button type="button" class="btn btn-success" id="btnTambahPersonil">

                                    <i class="fa fa-plus"></i>

                                </button>

                            </div>

                        </div>

                    </div>

                    <hr>

                    <div class="form-group">

                        <label>Upload Lampiran</label>

                        <div id="lampiran-wrapper">

                            <div class="input-group mb-2">

                                <input type="file" name="lampiran[]" class="form-control">

                                <div class="input-group-append">

                                    <button type="button" class="btn btn-success" id="btnTambahLampiran">

                                        <i class="fa fa-plus"></i>

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="card-footer">

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan
                    </button>

                    <a href="{{ route('mro.daily-activity.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                </div>

            </div>

        </form>

    </div>

    {{-- Javascript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const wrapper = document.getElementById('personil-wrapper');

            document.getElementById('btnTambahPersonil').addEventListener('click', function() {

                let html = `
            <div class="input-group mb-2">

                <input
                    type="text"
                    name="personil[]"
                    class="form-control"
                    placeholder="Masukkan Nama Personil"
                    required>

                <div class="input-group-append">

                    <button
                        type="button"
                        class="btn btn-danger btnHapusPersonil">

                        <i class="fa fa-minus"></i>

                    </button>

                </div>

            </div>
        `;

                wrapper.insertAdjacentHTML('beforeend', html);

            });

            document.addEventListener('click', function(e) {

                if (e.target.closest('.btnHapusPersonil')) {

                    e.target.closest('.input-group').remove();

                }

            });

        });
    </script>

    <script>
        const lampiranWrapper = document.getElementById('lampiran-wrapper');

        document.getElementById('btnTambahLampiran').addEventListener('click', function() {

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

        document.addEventListener('click', function(e) {

            if (e.target.closest('.btnHapusLampiran')) {

                e.target.closest('.input-group').remove();

            }

        });
    </script>
@endsection
