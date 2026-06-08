@extends('layouts.main')

@section('title', 'Detail Rewinding')

@section('content')

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
