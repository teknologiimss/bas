@extends('layouts.main')
@section('title', __('Purchase Request'))
@section('custom-css')
    <link rel="icon" href="{{ asset('public/img/logoimss.png') }}" type="image/png">
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection
{{-- <style>
    .table-success {
        background-color: #d4edda !important;
        /* Hijau muda */
        color: #155724 !important;
        /* Hijau gelap untuk teks */
    }

    /* 🌈 Gaya header File Explorer */
    #table th {
        position: relative;
        cursor: pointer;
        user-select: none;
        background-color: #f8f9fa;
        transition: background-color 0.2s ease;
        padding-right: 30px;
        text-align: center;
    }

    #table th:hover {
        background-color: #e9ecef;
    }

    #table th.active-sort {
        background-color: #dbeafe;
        color: #0d6efd;
        font-weight: 600;
    }

    /* 🔼🔽 Tombol panah permanen */
    .sort-buttons {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        flex-direction: column;
        line-height: 10px;
        font-size: 10px;
    }

    .sort-buttons span {
        cursor: pointer;
        color: #9ca3af;
        transition: color 0.2s ease, transform 0.1s ease;
    }

    .sort-buttons span:hover {
        color: #0d6efd;
        transform: scale(1.2);
    }

    .sort-buttons span.active {
        color: #0d6efd;
        font-weight: bold;
    }
</style> --}}

<style>
    /* ===============================
   THEME COLOR
================================= */
    :root {
        --maroon: #800020;
        --maroon-dark: #5e0018;
        --maroon-soft: #f7e9ed;
        --gray-bg: #f8f9fa;
    }

    /* ===============================
   CARD
================================= */
    .card {
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        border: none;
    }

    .card-header {
        background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
        color: #fff;
        border-radius: 12px 12px 0 0;
    }

    /* ===============================
   BUTTON
================================= */
    .btn {
        border-radius: 8px;
        font-weight: 500;
    }

    .btn-primary {
        background-color: var(--maroon);
        border-color: var(--maroon);
    }

    .btn-primary:hover {
        background-color: var(--maroon-dark);
        border-color: var(--maroon-dark);
    }

    .btn-danger {
        border-radius: 8px;
    }

    .btn-xs {
        padding: 4px 8px;
        font-size: 12px;
    }

    /* ===============================
   TABLE
================================= */
    #table {
        border-radius: 10px;
        overflow: hidden;
        background-color: #fff;
    }

    /* HEADER */
    #table thead th {
        background-color: var(--maroon);
        color: #fff;
        text-align: center;
        vertical-align: middle;
        font-weight: 600;
        border: none;
        position: relative;
    }

    /* SORT ACTIVE */
    #table th.active-sort {
        background-color: var(--maroon-dark);
    }

    /* BODY */
    #table tbody tr {
        transition: background-color 0.2s ease, transform 0.15s ease;
    }

    #table tbody tr:hover {
        background-color: var(--maroon-soft);
        transform: scale(1.003);
    }

    #table td {
        vertical-align: middle;
        border-color: #eee;
    }

    /* STRIPED */
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #fcfcfc;
    }

    /* ===============================
   CHECKBOX
================================= */
    input[type="checkbox"] {
        transform: scale(1.1);
        accent-color: var(--maroon);
    }

    /* ===============================
   SORT ICON
================================= */
    .sort-buttons span {
        color: #f3c6d0;
    }

    .sort-buttons span.active,
    .sort-buttons span:hover {
        color: #fff;
    }

    /* ===============================
   FILTER FORM
================================= */
    .form-control {
        border-radius: 8px;
    }

    label {
        font-weight: 600;
        color: #555;
    }

    /* ===============================
   MODAL
================================= */
    .modal-content {
        border-radius: 12px;
    }

    .modal-header {
        background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
        color: #fff;
        border-radius: 12px 12px 0 0;
    }



    /* ===============================
   BUTTON MAROON ANIMATED
================================= */
    .btn-maroon-animated {
        background: linear-gradient(135deg, #800020, #5e0018);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
        letter-spacing: 0.3px;
        box-shadow: 0 6px 14px rgba(128, 0, 32, 0.35);
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
    }

    /* ICON ANIMATION */
    .btn-maroon-animated i {
        animation: pulseIcon 1.6s infinite;
    }

    /* HOVER */
    .btn-maroon-animated:hover {
        background: linear-gradient(135deg, #8f0024, #6b001c);
        transform: translateY(-3px);
        box-shadow: 0 10px 22px rgba(128, 0, 32, 0.45);
        color: #fff;
    }

    /* ACTIVE / CLICK */
    .btn-maroon-animated:active {
        transform: scale(0.96);
        box-shadow: 0 4px 10px rgba(128, 0, 32, 0.4);
    }

    /* SOFT SHINE EFFECT */
    .btn-maroon-animated::after {
        content: "";
        position: absolute;
        top: 0;
        left: -120%;
        width: 120%;
        height: 100%;
        background: linear-gradient(120deg,
                transparent,
                rgba(255, 255, 255, 0.25),
                transparent);
        transition: 0.6s;
    }

    .btn-maroon-animated:hover::after {
        left: 120%;
    }

    /* ===============================
   KEYFRAMES
================================= */
    @keyframes pulseIcon {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.18);
        }

        100% {
            transform: scale(1);
        }
    }

    .btn-maroon-animated,
    .btn-maroon-animated:hover,
    .btn-maroon-animated:focus,
    .btn-maroon-animated:active {
        color: #ffffff !important;
    }

    /* Pastikan icon juga putih */
    .btn-maroon-animated i {
        color: #ffffff !important;
    }
</style>
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">

                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-pr"
                        onclick="addPR()"><i class="fas fa-plus"></i> Add PR / SPPJP</button> --}}

                    <button type="button" class="btn btn-maroon-animated" data-toggle="modal" data-target="#add-pr"
                        onclick="addPR()">
                        <i class="fas fa-plus mr-1"></i> Add PR / SPPJP
                    </button>



                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#import-product" onclick="importProduct()"><i class="fas fa-file-excel"></i> Import Product (Excel)</button> -->
                    <!-- <button type="button" class="btn btn-primary" onclick="download('xls')"><i class="fas fa-file-excel"></i> Export Product (XLS)</button> -->
                    <div class="card-tools">
                        <form>
                            {{-- <div class="input-group input-group">
                                <input type="text" class="form-control" name="q" placeholder="Search">
                                <input type="hidden" name="category" value="{{ Request::get('category') }}">
                        <input type="hidden" name="sort" value="{{ Request::get('sort') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                </div> --}}
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        {{-- Filter by Nomor Pr dan Tanggal --}}
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="filter-pr-no">Filter Nomor PR/SPPJP</label>
                                    <input type="text" class="form-control" id="filter-pr-no"
                                        placeholder="Masukkan Nomor pr">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="filter-pr-date">Filter Tanggal PR/SPPJP</label>
                                    <input type="date" class="form-control" id="filter-pr-date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-secondary mt-4" id="clear-filter">Clear Filter</button>
                            </div>
                        </div>
                        {{-- End Filter by Nomor Pr dan Tanggal --}}

                        <table id="table" class="table table-sm table-bordered table-hover table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th><input type="checkbox" id="select-all"></th>
                                    {{-- <th>No.</th> --}}
                                    <th>{{ __('Nomor PR/SPPJP') }}</th>
                                    <th>{{ __('Proyek') }}</th>
                                    <th>{{ __('Tanggal') }}</th>
                                    {{-- <th>{{ __('Dasar PR/SPPJP') }}</th> --}}
                                    <th>{{ auth()->user()->role == 14 ? 'Dasar SPP/SPPJP' : 'Dasar PR/SPPJP' }}</th>

                                    <th>{{ __('Arsip') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($requests as $key => $d)
                                    @php
                                        $data = [
                                            'no' => $requests->firstItem() + $key,
                                            'no_pr' => $d->no_pr,
                                            'proyek' => $d->proyek_name,
                                            'tanggal' => date('d/m/Y', strtotime($d->tgl_pr)),
                                            'dasar_pr' => $d->dasar_pr,
                                            'lampiran' => $d->lampiran,
                                            'proyek_id' => $d->proyek_id,
                                            'id' => $d->id,
                                            'editable' => $d->editable,
                                            'revisi' => $d->revisi,
                                            'catatan' => $d->catatan,
                                            'dasar' => $d->dasar,
                                        ];
                                    @endphp

                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="hapus[]" value="{{ $d->id }}">
                                        </td>

                                        <td class="text-center">{{ $data['no_pr'] }}</td>
                                        <td class="text-center">{{ $data['proyek'] }}</td>
                                        <td class="text-center">{{ $data['tanggal'] }}</td>
                                        {{-- <td class="text-center">{!! nl2br(e($data['dasar_pr'])) !!}</td> Backup dasar pr/sppjp tanpa MRO --}}
                                        <td class="text-center">
                                            {!! nl2br(e(auth()->user()->role == 14 ? $data['dasar'] ?? '' : $data['dasar_pr'] ?? '')) !!}
                                        </td>


                                        {{-- Lampiran --}}
                                        <td class="text-center">
                                            @php $lampiran = explode(',', $d->lampiran); @endphp

                                            @forelse ($lampiran as $file)
                                                @if (trim($file))
                                                    <a href="{{ asset('/lampiran/' . trim($file)) }}" target="_blank">
                                                        <i class="fa fa-eye"></i> Lihat
                                                    </a><br>
                                                @endif
                                            @empty
                                                -
                                            @endforelse
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="text-center">
                                            <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#add-pr"
                                                onclick="editPR({{ json_encode($data) }})"
                                                @if (!$data['editable']) disabled @endif>
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button class="btn btn-info btn-xs" data-toggle="modal" data-target="#detail-pr"
                                                data-detail="{{ json_encode($data) }}">
                                                <i class="fas fa-list"></i>
                                            </button>

                                            @if (in_array(Auth::user()->role, [0, 2, 3, 14, 1]))
                                                <button class="btn btn-danger btn-xs" data-toggle="modal"
                                                    data-target="#delete-pr" onclick="deletePR({{ json_encode($data) }})"
                                                    @if (!$data['editable']) disabled @endif>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="7">No data.</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                        <button type="button" class="btn btn-danger" id="delete-selected"
                            data-token="{{ csrf_token() }}">Hapus yang dipilih</button>
                    </div>
                </div>
            </div>
            <div>
                {{ $requests->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
            </div>
        </div>

        {{-- modal --}}
        <div class="modal fade" id="add-pr">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Add Purchase Request') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="save" action="{{ route('products.pr.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="save_id" name="id">
                            <input type="hidden" id="lampiran_awal" name="lampiran_awal">
                            <input type="hidden" id="nama_lampiran" name="nama_lampiran">
                            <div class="form-group row">
                                <label for="no_pr" class="col-sm-4 col-form-label">{{ __('Nomor PR/SPPJP') }} </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="no_pr" name="no_pr"
                                        autocomplete="off">
                                </div>
                            </div>
                            <!--<div class="form-group row">-->
                            <!--    <div class="col-sm-8">-->
                            <!--     <input type="text" class="form-control" id="no_pr" name="no_pr" autocomplete="off" hidden>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <div class="form-group row">
                                <label for="tgl_pr" class="col-sm-4 col-form-label">{{ __('Tanggal') }}
                                </label>
                                <div class="col-sm-8">
                                    {{-- <input type="date" class="form-control" id="tgl_pr" name="tgl_pr"
                                        min="{{ date('Y-m-d', strtotime('-7 days')) }}"> --}}

                                    <input type="date" class="form-control w-50" id="tgl_pr" name="tgl_pr">
                                </div>
                            </div>
                            <div class="form-group
                                        row">
                                <label for="proyek" class="col-sm-4 col-form-label">{{ __('Proyek') }}
                                </label>
                                <div class="col-sm-8">
                                    {{-- <input type="text" class="form-control" id="proyek" name="proyek"> --}}
                                    <select class="form-control" name="proyek_id" id="proyek_id">
                                        <option value="">Pilih Proyek</option>
                                        @foreach ($proyeks as $proyek)
                                            <option value="{{ $proyek->id }}">{{ $proyek->nama_pekerjaan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                                <label for="dasar_pr" class="col-sm-4 col-form-label">{{ __('Dasar PR/SPPJP') }}
                                </label>
                                <div class="col-sm-8">
                                    
                                    <textarea class="form-control" name="dasar_pr" id="dasar_pr" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="no_pr" class="col-sm-4 col-form-label">{{ __('Revisi') }} </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="revisi" name="revisi"
                                        autocomplete="off">
                                </div>
                            </div> --}}

                            @if (auth()->user()->role == 14)
                                {{-- ===== USER MRO ===== --}}

                                <div class="form-group row">
                                    <label for="catatan" class="col-sm-4 col-form-label">Catatan</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="dasar" class="col-sm-4 col-form-label">Dasar</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="dasar" name="dasar"
                                            autocomplete="off">
                                    </div>
                                </div>
                            @else
                                {{-- ===== USER NORMAL ===== --}}

                                <div class="form-group row">
                                    <label for="dasar_pr" class="col-sm-4 col-form-label">Dasar PR/SPPJP</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" id="dasar_pr" name="dasar_pr" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="catatan" class="col-sm-4 col-form-label">Catatan</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="revisi" class="col-sm-4 col-form-label">Revisi</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="revisi" name="revisi"
                                            autocomplete="off">
                                    </div>
                                </div>
                            @endif



                            <input type="text" id="data_lampiran" value="--" style="display: none">
                            <h6 id="lampiran_text">Lampiran</h6>

                            <div id="lampiran-row">

                            </div>

                            <a id="tambah-lampiran" style="cursor: pointer">Tambah Lampiran</a>
                            <hr>



                            {{-- @if (Auth::user()->role == 0 || Auth::user()->role == 1)
                                <div class="form-group row">
                                    <label for="proyek" class="col-sm-4 col-form-label">{{ __('Status') }}
                        </label>
                        <div class="col-sm-8">
                            <select class="form-control" name="proyek_id" id="proyek_id">
                                <option value="0">Pilih Status</option>
                                <option value="1">SPPH</option>
                                <option value="2">SPH</option>
                                <option value="3">JUSTIFIKASI</option>
                                <option value="4">NEGO 1</option>
                                <option value="5">NEGO 2</option>
                            </select>
                        </div>
                </div>
                @endif --}}


                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                        {{-- <button id="button-save" type="button" class="btn btn-primary"
                            onclick="document.getElementById('save').submit();">{{ __('Tambahkan') }}</button> --}}
                        {{-- <button id="button-save" type="button" class="btn btn-primary" onclick="setSaveIdAndSubmit();">
                            {{ __('Simpan') }}
                        </button> --}}
                        <button id="button-save" type="button" class="btn btn-maroon-animated"
                            onclick="setSaveIdAndSubmit();">
                            <i class="fas fa-save mr-1"></i> {{ __('Simpan') }}
                        </button>


                    </div>
                </div>
            </div>
        </div>

        {{-- modal lihat detail --}}
        <div class="modal fade" id="detail-pr">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Detail Purchase Request') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="row">


                                <div class="col-12" id="container-form">
                                    <b>Pilih PR / SPPJP</b>
                                    <form id="cetak-form" method="GET" action="" target="_blank">
                                        <input type="hidden" name="id" id="id">
                                        <select name="jenis_cetak" id="jenis_cetak" class="form-control">
                                            <option value="pr">Cetak PR</option>
                                            <option value="sppjp">Cetak SPPJP</option>
                                        </select>
                                    </form>
                                    {{-- <button id="button-cetak" type="button" class="btn btn-primary"
                                        onclick="submitCetak();">
                                        {{ __('Cetak') }}
                                    </button> --}}
                                    <button id="button-cetak" type="button" class="btn btn-maroon-animated"
                                        onclick="submitCetak();">
                                        <i class="fas fa-print mr-1"></i> {{ __('Cetak') }}
                                    </button>

                                    <table class="align-top w-100">
                                        <tr>
                                            <td style="width: 3%;"><b>No PR/SPPJP</b></td>
                                            <td style="width:2%">:</td>
                                            <td style="width: 55%"><span id="no_surat"></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Tanggal</b></td>
                                            <td>:</td>
                                            <td><span id="tgl_surat"></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Proyek</b></td>
                                            <td>:</td>
                                            <td><span id="proyek"></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Revisi</b></td>
                                            <td>:</td>
                                            <td><span id="revisi_detail"></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Produk</b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                {{-- <button id="button-tambah-produk" type="button"
                                                    class="btn btn-info mb-3"
                                                    onclick="showAddProduct()">{{ __('Tambah Item Detail') }}</button> --}}

                                                <button id="button-tambah-produk" type="button"
                                                    class="btn btn-maroon-animated mb-3" onclick="showAddProduct()">
                                                    <i class="fas fa-plus-circle mr-1"></i> {{ __('Tambah Item Detail') }}
                                                </button>

                                            </td>
                                        </tr>
                                    </table>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead style="text-align: center">
                                                <th>{{ __('NO') }}</th>
                                                <th>{{ __('Kode Material') }}</th>
                                                <th>{{ __('Uraian Barang/Jasa') }}</th>
                                                <th>{{ __('Spesifikasi') }}</th>
                                                <th>{{ __('QTY') }}</th>
                                                <th>{{ __('SAT') }}</th>
                                                <th>{{ __('Waktu Penyelesaian') }}</th>
                                                {{-- <th>{{ __('Lampiran') }}</th> --}}
                                                <th>{{ __('Keterangan') }}</th>
                                                {{-- <th>{{ __('SPPH') }}</th>
                                            <th>{{ __('PO') }}</th> --}}
                                                <th>{{ __('STATUS SPPH') }}</th>
                                                <th>{{ __('STATUS SPPH LUAR NEGERI') }}</th>
                                                <th>{{ __('STATUS LOI') }}</th>
                                                <th>{{ __('STATUS LOI LUAR NEGERI') }}</th>
                                                <th>{{ __('STATUS NEGO') }}</th>
                                                <th>{{ __('STATUS NEGOTIATION LETTER') }}</th>
                                                <th>{{ __('STATUS PO') }}</th>
                                                <th>{{ __('STATUS PO LUAR NEGERI') }}</th>
                                                <th>{{ __('AKSI') }}</th>

                                            </thead>
                                            <tbody id="table-pr">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>




                                <div class="col-0 d-none" id="container-product">
                                    <div class="card">
                                        {{-- <div class="card-body">
                                            
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio1" name="ptype"
                                                    class="custom-control-input" checked value="inka">
                                                <label class="custom-control-label" for="customRadio1">INKA</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio2" name="ptype"
                                                    class="custom-control-input" value="imss">
                                                <label class="custom-control-label" for="customRadio2">IMSS</label>
                                            </div>

                                            <div class="input-group input-group-lg">

                                                <input type="text" class="form-control" id="pcode" name="pcode"
                                                    min="0" placeholder="Product Code">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" id="button-check"
                                                        onclick="productCheck()">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div id="loader" class="card">
                                        <div class="card-body text-center">
                                            <div class="spinner-border text-danger" style="width: 3rem; height: 3rem;"
                                                role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="form" class="card">
                                        <div class="card-body">
                                            <form role="form" id="stock-update" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" id="pid" name="pid">
                                                <input type="hidden" id="type" name="type">
                                                <input type="hidden" id="proyek_id_val" name="proyek_id_val">
                                                <div class="form-group row">
                                                    <label for="material_kode"
                                                        class="col-sm-4 col-form-label">{{ __('Kode Material') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="material_kode">
                                                        <input type="hidden" class="form-control" id="pr_id"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="pname"
                                                        class="col-sm-4 col-form-label">{{ __('Uraian Barang/Jasa') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="pname">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="spek"
                                                        class="col-sm-4 col-form-label">{{ __('Spesifikasi') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="spek">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="no_nota"
                                                        class="col-sm-4 col-form-label">{{ __('QTY') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="stock"
                                                            name="stock">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="satuan"
                                                        class="col-sm-4 col-form-label">{{ __('Satuan') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="satuan"
                                                            name="satuan">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="waktu"
                                                        class="col-sm-4 col-form-label">{{ __('Waktu Penyelesaian') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control" id="waktu"
                                                            name="waktu">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="keterangan"
                                                        class="col-sm-4 col-form-label">{{ __('Keterangan') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="keterangan"
                                                            name="keterangan">
                                                    </div>
                                                </div>

                                                {{-- <div class="form-group row">
                                                    <label for="lampiran"
                                                        class="col-sm-4 col-form-label">{{ __('Lampiran') }}</label>
                                                    <div class="col-sm-8">
                                                        <input type="file" class="form-control" id="lampiran"
                                                            name="lampiran" />
                                                    </div>
                                                </div> --}}

                                            </form>
                                            <button id="button-update-pr" type="button"
                                                class="btn btn-maroon-animated w-100">
                                                <i class="fas fa-plus mr-1"></i> {{ __('Tambahkan') }}
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal delete --}}
        <div class="modal fade" id="delete-pr">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Delete Purchase Request') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="delete" action="{{ route('purchase_request.destroy') }}"
                            method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" id="delete_id" name="id">
                        </form>
                        <div>
                            <p>Anda yakin ingin menghapus purchase request ini <span id="pcode"
                                    class="font-weight-bold"></span>?</p>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Batal') }}</button>
                        <button id="button-save" type="button" class="btn btn-danger"
                            onclick="document.getElementById('delete').submit();">{{ __('Ya, hapus') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

{{-- custom Js --}}
@section('custom-js')
    <script src="/plugins/toastr/toastr.min.js"></script>
    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <script src="/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        //Fungsi tambah lampiran & Vendor
        function generateLampiranList(data) {
            if (data) {
                $('#lampiran-row').empty();
                var length = data.length;
                data.map((item, index) => {
                    const counter = index + 1
                    var formGroup =
                        '<div class="group">' +
                        '<div class="form-group custom-file row">' +
                        '<label for="lampiran' + counter + '" class="col-sm-4 col-form-label">Lampiran ' + counter +
                        '</label>' +
                        '<div class="col-sm-8 d-flex align-items-center ">' +
                        '<input type="file" class="form-control custom-file-input" id="lampiran' + counter +
                        '" name="lampiran[]" value="' + item + '">' +
                        '<button type="button" class="ml-2 btn btn-danger btn-sm" onclick="removeLampiran(' +
                        counter + ')"><i class="fas fa-trash"></i></button>' +
                        '</div>' +
                        '</div>' +
                        // '<hr/>' +
                        '</div>';
                    $("#lampiran-row").append(formGroup);
                })
            } else {
                var length = $("#lampiran-row").children().length;
                var counter = length + 1;

                var formGroup =
                    '<div class="group">' +
                    '<div class="form-group row">' +
                    '<label for="lampiran' + counter + '" class="col-sm-4 col-form-label">Lampiran ' + counter +
                    '</label>' +
                    '<div class="col-sm-8 d-flex align-items-center">' +
                    '<input type="file" class="form-control" id="lampiran' + counter + '" name="lampiran[]">' +
                    //remove button
                    '<button type="button" class="ml-2 btn btn-danger btn-sm" onclick="removeLampiran(' + counter +
                    ')"><i class="fas fa-trash"></i></button>' +
                    '</div>' +
                    '</div>' +
                    // '<hr/>' +
                    '</div>';
                $("#lampiran-row").append(formGroup);
            }
        }

        function generateLampiranList(data) {
            if (data) {
                $('#lampiran-row').empty();
                data.forEach((item, index) => {
                    const counter = index + 1;
                    var formGroup =
                        '<div class="form-group row">' +
                        '<label for="lampiran' + counter + '" class="col-sm-4 col-form-label">Lampiran ' + counter +
                        '</label>' +
                        '<div class="col-sm-8">' +
                        '<div class="custom-file">' +
                        '<input type="file" class="custom-file-input" id="lampiran' + counter +
                        '" name="lampiran[]" onchange="showFileName(this, ' + counter + ')">' +
                        '<label class="custom-file-label" for="lampiran' + counter + '">Pilih file</label>' +
                        '</div>' +
                        '<small id="file-name' + counter + '" class="form-text text-muted">' + item + '</small>' +
                        '<button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeLampiran(' +
                        counter + ')"><i class="fas fa-trash"></i> Hapus</button>' +
                        '</div>' +
                        '</div>';
                    $("#lampiran-row").append(formGroup);
                });
            } else {
                var length = $("#lampiran-row").children().length;
                var counter = length + 1;

                var formGroup =
                    '<div class="form-group row">' +
                    '<label for="lampiran' + counter + '" class="col-sm-4 col-form-label">Lampiran ' + counter +
                    '</label>' +
                    '<div class="col-sm-8">' +
                    '<div class="custom-file">' +
                    '<input type="file" class="custom-file-input" id="lampiran' + counter +
                    '" name="lampiran[]" onchange="showFileName(this, ' + counter + ')">' +
                    '<label class="custom-file-label" for="lampiran' + counter + '">Pilih file</label>' +
                    '</div>' +
                    '<small id="file-name' + counter + '" class="form-text text-muted"></small>' +
                    '<button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeLampiran(' + counter +
                    ')"><i class="fas fa-trash"></i> Hapus</button>' +
                    '</div>' +
                    '</div>';
                $("#lampiran-row").append(formGroup);
            }
        }

        function removeLampiran(index) {
            $('#lampiran' + index).closest('.form-group').remove();
        }

        $(document).ready(function() {
            $('#add-lampiran').click(function() {
                generateLampiranList();
            });

            // Example of initializing with data
            // var initialData = ["file1.pdf", "file2.jpg"];
            // generateLampiranList(initialData);
        });

        $(document).ready(function() {
            $("#tambah-lampiran").click(function() {
                generateLampiranList(null);
            });
        });


        //Agar ketika klik simpan, dapat submit
        // function setSaveIdAndSubmit() {
        //     // Submit the form
        //     var allFileNames = getAllFileNames();
        //     $('#nama_lampiran').val(allFileNames);
        //     // alert($('#nama_lampiran').val());
        //     // alert($('#lampiran_awal').val());
        //     document.getElementById('save').submit();
        // }

        function setSaveIdAndSubmit() {
            const id = $('#save_id').val();
            console.log('Submitting form with ID:', id);

            // Pastikan input lampiran terkumpul (kalau kamu pakai getAllFileNames)
            var allFileNames = typeof getAllFileNames === 'function' ? getAllFileNames() : '';
            $('#nama_lampiran').val(allFileNames);

            // Submit form
            $('#save').submit();
        }


        //Mengambil semua nama file (lampiran)
        function getAllFileNames() {
            var fileNames = [];
            var counter = 1;
            var maxTries = 100; // Batas atas untuk menghentikan loop jika terlalu banyak percobaan

            while (counter <= maxTries) {
                var element = $("#file-name" + counter);
                if (element.length) {
                    var fileName = element.text().trim();
                    fileNames.push(fileName);
                }
                counter++;
            }

            return fileNames.join(", ");
        }

        function showFileName(input, counter) {
            var fileName = input.files[0].name;
            $('#file-name' + counter).text(fileName);
            // Update the label with the selected file's name
            $(input).next('.custom-file-label').html(fileName);
        }
    </script>

    <script>
        function submitCetak() {
            let jenisCetak = document.getElementById("jenis_cetak").value;
            let form = document.getElementById("cetak-form");

            if (jenisCetak === "pr") {
                form.action = "{{ route('cetak_pr') }}";
            } else if (jenisCetak === "sppjp") {
                form.action = "{{ route('cetak_sppjp') }}";
            }

            form.submit();
        }
    </script>

    {{-- ASC-DSC kolom seperti windows explorer --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const table = document.getElementById("table");
            const headers = table.querySelectorAll("th");
            let sortState = {};

            headers.forEach((header, index) => {
                // Lewati kolom checkbox dan kolom kosong
                if (index === 0 || header.textContent.trim() === "") return;

                // Tambahkan tombol panah ke setiap kolom
                const sortBtns = document.createElement("div");
                sortBtns.className = "sort-buttons";
                sortBtns.innerHTML = `
            <span class="sort-up" title="Urutkan naik (A-Z)">▲</span>
            <span class="sort-down" title="Urutkan turun (Z-A)">▼</span>
        `;
                header.appendChild(sortBtns);

                // === Fungsi Sorting Aman ===
                function sortTable(ascending) {
                    const tbody = table.querySelector("tbody");
                    const rows = Array.from(tbody.querySelectorAll("tr"))
                        .filter(r => !r.classList.contains("text-center-no-data"));

                    rows.sort((a, b) => {
                        // Hindari error kalau kolom tidak ada
                        const cellA = a.children[index] ? a.children[index].innerText.trim()
                            .toLowerCase() : "";
                        const cellB = b.children[index] ? b.children[index].innerText.trim()
                            .toLowerCase() : "";

                        // Parsing tanggal dd/mm/yyyy
                        const dateA = cellA.match(/(\d{2})\/(\d{2})\/(\d{4})/);
                        const dateB = cellB.match(/(\d{2})\/(\d{2})\/(\d{4})/);
                        let valA = cellA,
                            valB = cellB;

                        if (dateA && dateB) {
                            valA = new Date(`${dateA[3]}-${dateA[2]}-${dateA[1]}`);
                            valB = new Date(`${dateB[3]}-${dateB[2]}-${dateB[1]}`);
                        } else if (!isNaN(cellA) && !isNaN(cellB) && cellA !== "" && cellB !== "") {
                            valA = parseFloat(cellA);
                            valB = parseFloat(cellB);
                        }

                        if (valA < valB) return ascending ? -1 : 1;
                        if (valA > valB) return ascending ? 1 : -1;
                        return 0;
                    });

                    // Reset tampilan
                    headers.forEach(h => {
                        h.classList.remove("active-sort");
                        h.querySelectorAll(".sort-up, .sort-down").forEach(btn => btn.classList
                            .remove("active"));
                    });

                    // Kolom aktif
                    header.classList.add("active-sort");
                    if (ascending) {
                        sortBtns.querySelector(".sort-up").classList.add("active");
                    } else {
                        sortBtns.querySelector(".sort-down").classList.add("active");
                    }

                    sortState[index] = ascending;

                    // Render ulang tabel
                    rows.forEach(r => tbody.appendChild(r));
                }

                // Klik teks header = toggle urutan naik/turun
                header.addEventListener("click", (e) => {
                    if (e.target.classList.contains("sort-up") || e.target.classList.contains(
                            "sort-down")) return;
                    const ascending = !sortState[index];
                    sortTable(ascending);
                });

                // Klik panah atas/bawah = langsung urut
                sortBtns.querySelector(".sort-up").addEventListener("click", (e) => {
                    e.stopPropagation();
                    sortTable(true);
                });
                sortBtns.querySelector(".sort-down").addEventListener("click", (e) => {
                    e.stopPropagation();
                    sortTable(false);
                });
            });
        });
    </script>

    {{-- Menampilkan form otomatis Dasar Proyek --}}
    <!-- <script>
        $(document).ready(function() {
            $('#proyek_id').change(function() {
                var proyek_id = $(this).val();
                if (proyek_id) {
                    $.ajax({
                        url: '{{ route('get-dasar-proyek') }}',
                        type: 'GET',
                        data: {
                            proyek_id: proyek_id
                        },
                        success: function(response) {
                            $('#dasar_pr').val(response.nomor_kontrak);
                        },
                        error: function() {
                            $('#dasar_pr').val('');
                        }
                    });
                } else {
                    $('#dasar_pr').val('');
                }
            });
        });
    </script> -->
    {{-- End Menampilkan form otomatis Dasar Proyek --}}


    <script>
        var urlLampiran = "{{ asset('lampiran') }}";
        $(function() {
            bsCustomFileInput.init();
            var user_id;
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            $('#loader').hide();

            $(".btn-lihat").on('click', function() {
                const code = $(this).attr('code');
                $("#pcode_print").val(code);
                $("#barcode").attr("src", "/products/barcode/" + code);
            });

            $('#product_code').on('change', function() {
                var code = $('#product_code').val();
                if (code != null && code != "") {
                    $("#barcode_preview").attr("src", "/products/barcode/" + code);
                    $('#barcode_preview_container').show();
                }
            });
        });

        $('#sort').on('change', function() {
            $("#sorting").submit();
        });

        // function resetForm() {
        //     $('#save').trigger("reset");
        //     $('#barcode_preview_container').hide();
        // }

        // function resetForm() {
        //     // Reset semua input kecuali ID dan CSRF token
        //     $('#save').find('input').not('#save_id, [name="_token"]').val('');
        //     $('#barcode_preview_container').hide();
        // }

        function resetForm() {
            // Reset semua input dan textarea kecuali CSRF & ID
            $('#save').find('input').not('#save_id, #revisi, [name="_token"]').val('');
            $('#save').find('textarea').val('');
            $('#proyek_id').val('');
            $('#barcode_preview_container').hide();
        }


        //Filter by Nomor dan tgl PO
        $(document).ready(function() {
            $('#clear-filter').on('click', function() {
                $('#filter-pr-no, #filter-pr-date').val('');
                filterTable();
            });

            $('#filter-pr-no, #filter-pr-date').on('keyup change', function() {
                filterTable();
            });

            function filterTable() {
                var filterNoPR = $('#filter-pr-no').val().toUpperCase();
                var filterDatePR = $('#filter-pr-date').val();

                $('table tbody tr').each(function() {
                    var noPR = $(this).find('td:nth-child(2)').text().toUpperCase();
                    var datePR = $(this).find('td:nth-child(4)')
                        .text(); // Ubah indeks kolom ke indeks tgl_pr jika perlu
                    var id = $(this).find('td:nth-child(1)')
                        .text(); // Ubah indeks kolom ke indeks ID PO jika perlu

                    // Ubah string tanggal ke objek Date untuk perbandingan
                    var dateParts = datePR.split("/");
                    var prDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[
                        0]); // Format: tahun, bulan, tanggal

                    // Ubah string filterDatePR ke objek Date
                    var filterDateParts = filterDatePR.split("-");
                    var filterPRDate = new Date(filterDateParts[0], filterDateParts[1] - 1, filterDateParts[
                        2]); // Format: tahun, bulan, tanggal

                    if ((noPR.indexOf(filterNoPR) > -1 || filterNoPR === '') &&
                        (prDate.getTime() === filterPRDate.getTime() || filterDatePR === '')) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
        }); //End Filter by Nomor dan tgl PO

        function addPR() {
            $('#modal-title').text("Add Purchase Request");
            $('#button-save').text("Tambahkan");
            $('#save_id').val("");
            resetForm();
        }

        $('#select-all').change(function() {
            var checkboxes = $(this).closest('table').find(':checkbox');
            checkboxes.prop('checked', $(this).is(':checked'));
        });

        // Function to handle delete selected items
        $('#delete-selected').click(function() {
            var ids = [];
            $('input[name="hapus[]"]:checked').each(function() {
                ids.push($(this).val());
            });

            if (ids.length > 0) {
                var token = $(this).data('token');
                $.ajax({
                    url: 'pr-imss/hapus-multiple',
                    type: 'POST',
                    data: {
                        _token: token,
                        ids: ids
                    },
                    success: function(response) {
                        if (response.success) {
                            // Menghapus status checked dari semua checkbox
                            $('input[name="hapus[]"]').prop('checked', false);
                            $('#select-all').prop('checked', false);
                            // Memuat ulang halaman setelah berhasil menghapus data
                            location.reload();
                            alert('Data berhasil dihapus');
                        } else {
                            alert('Gagal menghapus data');
                        }
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan saat menghapus data');
                    }
                });
            } else {
                alert('Pilih setidaknya satu item untuk dihapus');
            }
        });

        $('#detail-pr').on('hidden.bs.modal', function() {
            $('#container-product').addClass('d-none');
            $('#container-product').removeClass('col-5');
            $('#container-form').addClass('col-12');
            $('#container-form').removeClass('col-7');
            $('#button-tambah-detail').text('Tambah Item Detail');
        });

        function showAddProduct() {
            if ($('#detail-pr').find('#container-product').hasClass('d-none')) {
                $('#detail-pr').find('#container-product').removeClass('d-none');
                $('#detail-pr').find('#container-product').addClass('col-5');
                $('#detail-pr').find('#container-form').removeClass('col-12');
                $('#detail-pr').find('#container-form').addClass('col-7');
                $('#button-tambah-produk').text('Kembali');
                $('#button-update-pr').off('click');
                // Menambahkan event listener baru untuk menghandle klik pada tombol
                $('#button-update-pr').text("Simpan").on('click', function() {
                    // Ubah teks tombol menjadi "Loading"
                    // $(this).text("Loading...");

                    // // Nonaktifkan tombol
                    // $(this).prop('disabled', true);

                    // Jalankan fungsi PRinsert()
                    PRinsert();

                    // Setelah 2 detik, kembalikan teks tombol ke semula, aktifkan kembali tombol, dan tampilkan pesan Toastr
                    // setTimeout(function() {
                    //     $('#button-update-pr').text("Simpan").prop('disabled', false);
                    //     toastr.success('Data Berhasil ditambahkan');
                    // }, 2000); // 2000 milidetik = 2 detik
                });

            } else {
                $('#detail-pr').find('#container-product').removeClass('col-5');
                $('#detail-pr').find('#container-product').addClass('d-none');
                $('#detail-pr').find('#container-form').addClass('col-12');
                $('#detail-pr').find('#container-form').removeClass('col-7');
                $('#button-tambah-produk').text('Tambah Item Detail');
                clearForm();

            }
        }

        function editPR(data) {
            $('#modal-title').text("Edit Request");
            $('#button-save').text("Simpan");
            resetForm();

            console.log("DATA EDIT:", data);

            // Periksa apakah data.lampiran tidak kosong sebelum memprosesnya
            if (data.lampiran && data.lampiran.trim() !== "") {
                var lampiranArray = data.lampiran.split(", ");
                var nilaiLampiran = lampiranArray.length;

                $('#lampiran_awal').val(data.lampiran);
                $('#nama_lampiran').val(data.lampiran);

                document.getElementById('lampiran_text').innerHTML = 'Total Lampiran <b>' + nilaiLampiran + '</b>';
                generateLampiranList(lampiranArray);
            } else {
                $('#lampiran_awal').val("");
                $('#nama_lampiran').val("");
                document.getElementById('lampiran_text').innerHTML = 'Total Lampiran <b>0</b>';
            }


            $('#save_id').val(data.id);
            $('#no_pr').val(data.no_pr);
            // $('#tgl_pr').val(data.tgl_pr);
            // $('#proyek_id').val(data.proyek);
            //console.log("VALUE YANG MASUK KE dasar_pr:", data.dasar_pr);
            $('#dasar_pr').val(data.dasar_pr);
            var date = data.tanggal.split('/');
            var newDate = date[2] + '-' + date[1] + '-' + date[0];
            $('#tgl_pr').val(newDate);
            $('#proyek_id').find('option').each(function() {
                if ($(this).val() == data.proyek_id) {
                    console.log($(this).val());
                    $(this).attr('selected', true);
                }
            });
            $('#revisi').val(data.revisi);
            $('#catatan').val(data.catatan);
            $('#dasar').val(data.dasar);
        }

        function emptyTableProducts() {
            $('#table-pr').empty();
            $('#no_surat').text("");
            $('#tgl_surat').text("");
            $('proyek').text("");
        }

        function loader(status = 1) {
            if (status == 1) {
                $('#loader').show();
            } else {
                $('#loader').hide();
            }
        }

        // $('#form').hide();

        function productCheck() {
            var pcode = $('#pcode').val();
            var ptype = $('input[name="ptype"]:checked').val();
            if (pcode.length > 0) {
                loader();
                $('#pcode').prop("disabled", true);
                $('#button-check').prop("disabled", true);
                $.ajax({
                    url: "{{ url('materials?type=') }}" + ptype + '&kode=' + pcode,
                    type: "GET",
                    data: {
                        "format": "json"
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $('#loader').show();
                        $('#form').hide();

                    },
                    success: function(data) {
                        loader(0);
                        if (data.success) {
                            $('#form').show();
                            $('#pname').val(data.materials.nama_barang);
                            $('#material_kode').val(data.materials.kode_material);
                            $('#spek').val(data.materials.spesifikasi);
                            $('#satuan').val(data.materials.satuan);
                        } else {
                            $('#form').show();
                            toastr.error("Product Code tidak dikenal!");
                        }
                        $('#pcode').prop("disabled", false);
                        $('#button-check').prop("disabled", false);
                    },
                    error: function() {
                        $('#pcode').prop("disabled", false);
                        $('#button-check').prop("disabled", false);
                    }
                });
            } else {
                toastr.error("Product Code belum diisi!");
            }
        }

        function clearForm() {
            $('#pname').val("");
            $('#stock').val("");
            $('#spek').val("");
            $('#satuan').val("");
            $('#keterangan').val("");
            $('#waktu').val("");
            $('#pcode').val("");
            $('#material_kode').val("");
            $('#lampiran').val("");
            // $('#form').hide();
        }

        function PRinsert() {
            const id_pr = $('#pr_id').val()
            // const id = $('#id').val()

            var inputFile = $("#lampiran")[0].files[0];
            var formData = new FormData();
            formData.append('lampiran', inputFile);
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('id_pr', id_pr);
            // formData.append('id', id);
            formData.append('id_proyek', $('#proyek_id_val').val());
            formData.append('kode_material', $('#material_kode').val());
            formData.append('uraian', $('#pname').val());
            formData.append('stock', $('#stock').val());
            formData.append('spek', $('#spek').val());
            formData.append('satuan', $('#satuan').val());
            formData.append('waktu', $('#waktu').val());
            formData.append('keterangan', $('#keterangan').val());

            if ($('#waktu').val() == null || $('#waktu').val() == "") {
                toastr.error("Waktu Penyelesaian belum diisi!");
                return
            }


            // // Menentukan apakah akan melakukan insert atau update berdasarkan keberadaan id
            if (id) {
                // //     // Jika id sudah ada, lakukan update
                createData(formData);
            } else {
                // Jika id belum ada, lakukan insert
                createData(formData);
            }
        }

        function PRupdate() {
            const id_pr = $('#pr_id').val()
            const id = $('#id').val()

            var inputFile = $("#lampiran")[0].files[0];
            var formData = new FormData();
            formData.append('lampiran', inputFile);
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('id_pr', id_pr);
            formData.append('id', id);
            formData.append('id_proyek', $('#proyek_id_val').val());
            formData.append('kode_material', $('#material_kode').val());
            formData.append('uraian', $('#pname').val());
            formData.append('stock', $('#stock').val());
            formData.append('spek', $('#spek').val());
            formData.append('satuan', $('#satuan').val());
            formData.append('waktu', $('#waktu').val());
            formData.append('keterangan', $('#keterangan').val());

            if ($('#waktu').val() == null || $('#waktu').val() == "") {
                toastr.error("Waktu Penyelesaian belum diisi!");
                return
            }


            // // Menentukan apakah akan melakukan insert atau update berdasarkan keberadaan id
            if (id) {
                // //     // Jika id sudah ada, lakukan update
                updateData(formData);
            } else {
                // Jika id belum ada, lakukan insert
                createData(formData);
            }
        }

        function createData(formData) {
            $.ajax({
                url: "{{ url('products/update_purchase_request_detail') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#table-pr').append('<tr><td colspan="15" class="text-center">Loading...</td></tr>');
                    $('#button-cetak-pr').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                    $('#button-cetak-pr').attr('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#id').val(data.pr.id);
                    $('#no_surat').text(data.pr.no_pr);
                    $('#tgl_surat').text(data.pr.tanggal);
                    $('#proyek').text(data.pr.proyek);
                    $('#button-cetak-pr').html('<i class="fas fa-print"></i> Cetak');
                    $('#button-cetak-pr').attr('disabled', false);
                    if ($('#detail-pr').find('#container-product').hasClass('d-none')) {
                        $('#detail-pr').find('#container-product').removeClass('d-none');
                        $('#detail-pr').find('#container-product').addClass('col-5');
                        $('#detail-pr').find('#container-form').removeClass('col-12');
                        $('#detail-pr').find('#container-form').addClass('col-7');
                        $('#button-tambah-produk').text('Kembali');
                    } else {
                        $('#detail-pr').find('#container-product').removeClass('col-5');
                        $('#detail-pr').find('#container-product').addClass('d-none');
                        $('#detail-pr').find('#container-form').addClass('col-12');
                        $('#detail-pr').find('#container-form').removeClass('col-7');
                        $('#button-tambah-produk').text('Tambah Item Detail');
                        clearForm();
                    }
                    var no = 1;

                    if (data.pr.details.length == 0) {
                        $('#table-pr').empty();
                        $('#table-pr').append(
                            '<tr><td colspan="17" class="text-center">Tidak ada produk</td></tr>'
                        ); // Tambahkan pesan bahwa tidak ada produk
                    } else {
                        $('#table-pr').empty();
                        // $.each(data.pr.details, function(key, value) {
                        //     console.log(value);
                        //     var selisih = Math.abs(value.selisih_qty || 0);
                        //     var qty = value.qty || 0;
                        //     var selisihQtySpphrfq = Math.abs(value.selisih_qty_spphrfq || 0);
                        //     var selisihQtyLoi = Math.abs(value.selisih_qty_loi || 0);
                        //     var selisihQtyLoiluar = Math.abs(value.selisih_qty_loiluar || 0);
                        //     var selisihQtyNego = Math.abs(value.selisih_qty_nego || 0);
                        //     var selisihQtyNegoluar = Math.abs(value.selisih_qty_negoluar || 0);
                        //     var selisihQtyPo = Math.abs(value.selisih_qty_po || 0);
                        //     var selisihQtyPoluar = Math.abs(value.selisih_qty_poluar || 0);

                        //     // Status langsung diambil
                        //     var spphStatus = 'Proses SPPH (' + selisih + '/' + qty + ') ';
                        //     var spphRfqStatus = 'Proses SPPH RFQ (' + selisihQtySpphrfq + '/' + qty +
                        //         ') ';
                        //     var loiStatus = 'Proses LOI (' + selisihQtyLoi + '/' + qty + ') ';
                        //     var loiluarStatus = 'Proses LOI LUAR NEGERI (' + selisihQtyLoiluar + '/' +
                        //         qty + ') ';
                        //     var negoStatus = 'Proses NEGO (' + selisihQtyNego + '/' + qty + ') ';
                        //     var negoluarStatus = 'Proses NEGO LUAR NEGERI (' + selisihQtyNegoluar +
                        //         '/' + qty + ') ';
                        //     var poStatus = 'Proses PO (' + selisihQtyPo + '/' + qty + ') ';
                        //     var poluarStatus = 'Proses PO LUAR NEGERI (' + selisihQtyPoluar + '/' +
                        //         qty + ') ';

                        //     if (!status) {
                        //         status = 'PR DONE';
                        //     }

                        //     // Menampilkan data tanpa pengecekan if
                        //     var spph = value.nomor_spph || '-';
                        //     var spphrfq = value.nomor_spphrfq || '-';
                        //     var loi = value.no_loi || '-';
                        //     var loiluar = value.no_loiluar || '-';
                        //     var nego = value.nomor_nego || '-';
                        //     var negoluar = value.nomor_negoluar || '-';
                        //     var po = value.no_po || '-';
                        //     var poluar = value.no_poluar || '-';
                        //     var keterangan = value.keterangan || '';
                        //     var kode_material = value.kode_material || '';
                        //     var lampiran = value.lampiran ?
                        //         '<a href="' + urlLampiran + '/' + value.lampiran +
                        //         '"><i class="fa fa-eye"></i> Lihat</a>' :
                        //         '-';

                        //     var editButton =
                        //         '<button type="button" class="btn btn-success btn-xs mr-1" data-row-id="' +
                        //         value.id + '" title="Edit" onclick="editRow(\'' + value.id + '\', \'' +
                        //         value.kode_material + '\', \'' + value.uraian + '\', \'' + value.spek +
                        //         '\', \'' + value.qty + '\', \'' + value.satuan + '\', \'' + value
                        //         .waktu +
                        //         '\', \'' + value.lampiran + '\', \'' + value.keterangan +
                        //         '\')"><i class="fas fa-edit"></i></button>';

                        //     var deleteButton =
                        //         '<button type="button" class="btn btn-danger btn-xs mr-1"' +
                        //         ' onclick="deleteDetail(' + value.id + ', \'' + value.uraian
                        //         .toString() + '\')"' +
                        //         ' title="Delete">' +
                        //         '<i class="fas fa-trash"></i>' +
                        //         '</button>';

                        //     $('#table-pr').append('<tr><td>' + (key + 1) + '</td><td>' + kode_material +
                        //         '</td><td>' + value.uraian + '</td><td>' + value.spek +
                        //         '</td><td>' + value.qty + '</td><td>' + value.satuan +
                        //         '</td><td>' + value.waktu + '</td><td>' + lampiran +
                        //         '</td><td>' + keterangan + '</td><td><b>' + spphStatus +
                        //         '</b></td><td><b>' + spphRfqStatus +
                        //         '</b></td><td><b>' + loiStatus +
                        //         '</b></td><td><b>' + loiluarStatus +
                        //         '</b></td><td><b>' + negoStatus +
                        //         '</b></td><td><b>' + negoluarStatus + // ⬅️ Tambahkan di sini
                        //         '</b></td><td><b>' + poStatus +
                        //         '</b></td><td><b>' + poluarStatus + // ⬅️ Tambahkan di sini
                        //         '</b></td><td>' + editButton + deleteButton + '</td></tr>');

                        // });

                        $.each(data.pr.details, function(key, value) {
                            console.log(value);
                            var selisih = Math.abs(value.selisih_qty || 0);
                            var qty = value.qty || 0;
                            var selisihQtySpphrfq = Math.abs(value.selisih_qty_spphrfq || 0);
                            var selisihQtyLoi = Math.abs(value.selisih_qty_loi || 0);
                            var selisihQtyLoiluar = Math.abs(value.selisih_qty_loiluar || 0);
                            var selisihQtyNego = Math.abs(value.selisih_qty_nego || 0);
                            var selisihQtyNegoluar = Math.abs(value.selisih_qty_negoluar || 0);
                            var selisihQtyPo = Math.abs(value.selisih_qty_po || 0);
                            var selisihQtyPoluar = Math.abs(value.selisih_qty_poluar || 0);

                            // Status langsung diambil
                            var spphStatus = 'Proses SPPH (' + selisih + '/' + qty + ') ';
                            var spphRfqStatus = 'Proses SPPH RFQ (' + selisihQtySpphrfq + '/' + qty +
                                ') ';
                            var loiStatus = 'Proses LOI (' + selisihQtyLoi + '/' + qty + ') ';
                            var loiluarStatus = 'Proses LOI LUAR NEGERI (' + selisihQtyLoiluar + '/' +
                                qty + ') ';
                            var negoStatus = 'Proses NEGO (' + selisihQtyNego + '/' + qty + ') ';
                            var negoluarStatus = 'Proses NEGO LUAR NEGERI (' + selisihQtyNegoluar +
                                '/' + qty + ') ';
                            var poStatus = 'Proses PO (' + selisihQtyPo + '/' + qty + ') ';
                            var poluarStatus = 'Proses PO LUAR NEGERI (' + selisihQtyPoluar + '/' +
                                qty + ') ';

                            if (!status) {
                                status = 'PR DONE';
                            }

                            // Menampilkan data tanpa lampiran
                            var kode_material = value.kode_material || '';
                            var keterangan = value.keterangan || '';

                            var editButton =
                                '<button type="button" class="btn btn-success btn-xs mr-1" data-row-id="' +
                                value.id + '" title="Edit" onclick="editRow(\'' + value.id + '\', \'' +
                                value.kode_material + '\', \'' + value.uraian + '\', \'' + value.spek +
                                '\', \'' + value.qty + '\', \'' + value.satuan + '\', \'' + value
                                .waktu + '\', \'' + value.keterangan +
                                '\')"><i class="fas fa-edit"></i></button>';

                            var deleteButton =
                                '<button type="button" class="btn btn-danger btn-xs mr-1"' +
                                ' onclick="deleteDetail(' + value.id + ', \'' + value.uraian
                                .toString() + '\')"' +
                                ' title="Delete">' +
                                '<i class="fas fa-trash"></i>' +
                                '</button>';

                            $('#table-pr').append('<tr><td>' + (key + 1) + '</td><td>' + kode_material +
                                '</td><td>' + value.uraian + '</td><td>' + value.spek +
                                '</td><td>' + value.qty + '</td><td>' + value.satuan +
                                '</td><td>' + value.waktu + '</td><td>' + keterangan +
                                '</td><td><b>' + spphStatus +
                                '</b></td><td><b>' + spphRfqStatus +
                                '</b></td><td><b>' + loiStatus +
                                '</b></td><td><b>' + loiluarStatus +
                                '</b></td><td><b>' + negoStatus +
                                '</b></td><td><b>' + negoluarStatus +
                                '</b></td><td><b>' + poStatus +
                                '</b></td><td><b>' + poluarStatus +
                                '</b></td><td>' + editButton + deleteButton + '</td></tr>');
                        });



                    }
                }
            });
        }

        function updateData(formData) {
            // Lakukan operasi insert data
            // Misalnya, Anda dapat menggunakan AJAX untuk mengirim permintaan ke backend
            // atau menggunakan fungsi JavaScript lainnya yang sesuai dengan logika aplikasi Anda
            $.ajax({
                url: "{{ url('products/purchase_request/update_detail') }}", // Ganti URL sesuai dengan endpoint untuk operasi insert
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#table-pr').append('<tr><td colspan="15" class="text-center">Loading...</td></tr>');
                    $('#button-cetak-pr').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                    $('#button-cetak-pr').attr('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#id').val(data.pr.id);
                    $('#no_surat').text(data.pr.no_pr);
                    $('#tgl_surat').text(data.pr.tanggal);
                    $('#proyek').text(data.pr.proyek);
                    $('#button-cetak-pr').html('<i class="fas fa-print"></i> Cetak');
                    $('#button-cetak-pr').attr('disabled', false);
                    if ($('#detail-pr').find('#container-product').hasClass('d-none')) {
                        $('#detail-pr').find('#container-product').removeClass('d-none');
                        $('#detail-pr').find('#container-product').addClass('col-5');
                        $('#detail-pr').find('#container-form').removeClass('col-12');
                        $('#detail-pr').find('#container-form').addClass('col-7');
                        $('#button-tambah-produk').text('Kembali');
                    } else {
                        $('#detail-pr').find('#container-product').removeClass('col-5');
                        $('#detail-pr').find('#container-product').addClass('d-none');
                        $('#detail-pr').find('#container-form').addClass('col-12');
                        $('#detail-pr').find('#container-form').removeClass('col-7');
                        $('#button-tambah-produk').text('Tambah Item Detail');
                        clearForm();
                    }
                    // $('#detail-pr').find('#container-product').removeClass('d-none');
                    // $('#detail-pr').find('#container-product').addClass('col-5');
                    // $('#detail-pr').find('#container-form').removeClass('col-12');
                    // $('#detail-pr').find('#container-form').addClass('col-7');
                    var no = 1;

                    if (data.pr.details.length == 0) {
                        $('#table-pr').empty();
                        $('#table-pr').append(
                            '<tr><td colspan="17" class="text-center">Tidak ada produk</td></tr>'
                        ); // Tambahkan pesan bahwa tidak ada produk
                    } else {
                        $('#table-pr').empty();
                        // $.each(data.pr.details, function(key, value) {
                        //     console.log(value);
                        //     var selisih = Math.abs(value.selisih_qty || 0);
                        //     var qty = value.qty || 0;
                        //     var selisihQtySpphrfq = Math.abs(value.selisih_qty_spphrfq || 0);
                        //     var selisihQtyLoi = Math.abs(value.selisih_qty_loi || 0);
                        //     var selisihQtyLoiluar = Math.abs(value.selisih_qty_loiluar || 0);
                        //     var selisihQtyNego = Math.abs(value.selisih_qty_nego || 0);
                        //     var selisihQtyNegoluar = Math.abs(value.selisih_qty_negoluar || 0);
                        //     var selisihQtyPo = Math.abs(value.selisih_qty_po || 0);
                        //     var selisihQtyPoluar = Math.abs(value.selisih_qty_poluar || 0);

                        //     // Status langsung diambil
                        //     var spphStatus = 'Proses SPPH (' + selisih + '/' + qty + ') ';
                        //     var spphRfqStatus = 'Proses SPPH RFQ (' + selisihQtySpphrfq + '/' + qty +
                        //         ') ';
                        //     var loiStatus = 'Proses LOI (' + selisihQtyLoi + '/' + qty + ') ';
                        //     var loiluarStatus = 'Proses LOI LUAR NEGERI (' + selisihQtyLoiluar + '/' +
                        //         qty + ') ';
                        //     var negoStatus = 'Proses NEGO (' + selisihQtyNego + '/' + qty + ') ';
                        //     var negoluarStatus = 'Proses NEGO LUAR NEGERI (' + selisihQtyNegoluar +
                        //         '/' + qty + ') ';
                        //     var poStatus = 'Proses PO (' + selisihQtyPo + '/' + qty + ') ';
                        //     var poluarStatus = 'Proses PO LUAR NEGERI (' + selisihQtyPoluar + '/' +
                        //         qty + ') ';

                        //     if (!status) {
                        //         status = 'PR DONE';
                        //     }

                        //     // Menampilkan data tanpa pengecekan if
                        //     var spph = value.nomor_spph || '-';
                        //     var spphrfq = value.nomor_spphrfq || '-';
                        //     var loi = value.no_loi || '-';
                        //     var loiluar = value.no_loiluar || '-';
                        //     var nego = value.nomor_nego || '-';
                        //     var negoluar = value.nomor_negoluar || '-';
                        //     var po = value.no_po || '-';
                        //     var poluar = value.no_poluar || '-';
                        //     var keterangan = value.keterangan || '';
                        //     var kode_material = value.kode_material || '';
                        //     var lampiran = value.lampiran ?
                        //         '<a href="' + urlLampiran + '/' + value.lampiran +
                        //         '"><i class="fa fa-eye"></i> Lihat</a>' :
                        //         '-';

                        //     var editButton =
                        //         '<button type="button" class="btn btn-success btn-xs mr-1" data-row-id="' +
                        //         value.id + '" title="Edit" onclick="editRow(\'' + value.id + '\', \'' +
                        //         value.kode_material + '\', \'' + value.uraian + '\', \'' + value.spek +
                        //         '\', \'' + value.qty + '\', \'' + value.satuan + '\', \'' + value
                        //         .waktu +
                        //         '\', \'' + value.lampiran + '\', \'' + value.keterangan +
                        //         '\')"><i class="fas fa-edit"></i></button>';

                        //     var deleteButton =
                        //         '<button type="button" class="btn btn-danger btn-xs mr-1"' +
                        //         ' onclick="deleteDetail(' + value.id + ', \'' + value.uraian
                        //         .toString() + '\')"' +
                        //         ' title="Delete">' +
                        //         '<i class="fas fa-trash"></i>' +
                        //         '</button>';

                        //     $('#table-pr').append('<tr><td>' + (key + 1) + '</td><td>' + kode_material +
                        //         '</td><td>' + value.uraian + '</td><td>' + value.spek +
                        //         '</td><td>' + value.qty + '</td><td>' + value.satuan +
                        //         '</td><td>' + value.waktu + '</td><td>' + lampiran +
                        //         '</td><td>' + keterangan + '</td><td><b>' + spphStatus +
                        //         '</b></td><td><b>' + spphRfqStatus +
                        //         '</b></td><td><b>' + loiStatus +
                        //         '</b></td><td><b>' + loiluarStatus +
                        //         '</b></td><td><b>' + negoStatus +
                        //         '</b></td><td><b>' + negoluarStatus + // ⬅️ Tambahkan di sini
                        //         '</b></td><td><b>' + poStatus +
                        //         '</b></td><td><b>' + poluarStatus + // ⬅️ Tambahkan di sini
                        //         '</b></td><td>' + editButton + deleteButton + '</td></tr>');

                        // });

                        $.each(data.pr.details, function(key, value) {
                            console.log(value);
                            var selisih = Math.abs(value.selisih_qty || 0);
                            var qty = value.qty || 0;
                            var selisihQtySpphrfq = Math.abs(value.selisih_qty_spphrfq || 0);
                            var selisihQtyLoi = Math.abs(value.selisih_qty_loi || 0);
                            var selisihQtyLoiluar = Math.abs(value.selisih_qty_loiluar || 0);
                            var selisihQtyNego = Math.abs(value.selisih_qty_nego || 0);
                            var selisihQtyNegoluar = Math.abs(value.selisih_qty_negoluar || 0);
                            var selisihQtyPo = Math.abs(value.selisih_qty_po || 0);
                            var selisihQtyPoluar = Math.abs(value.selisih_qty_poluar || 0);

                            // Status langsung diambil
                            var spphStatus = 'Proses SPPH (' + selisih + '/' + qty + ') ';
                            var spphRfqStatus = 'Proses SPPH RFQ (' + selisihQtySpphrfq + '/' + qty +
                                ') ';
                            var loiStatus = 'Proses LOI (' + selisihQtyLoi + '/' + qty + ') ';
                            var loiluarStatus = 'Proses LOI LUAR NEGERI (' + selisihQtyLoiluar + '/' +
                                qty + ') ';
                            var negoStatus = 'Proses NEGO (' + selisihQtyNego + '/' + qty + ') ';
                            var negoluarStatus = 'Proses NEGO LUAR NEGERI (' + selisihQtyNegoluar +
                                '/' + qty + ') ';
                            var poStatus = 'Proses PO (' + selisihQtyPo + '/' + qty + ') ';
                            var poluarStatus = 'Proses PO LUAR NEGERI (' + selisihQtyPoluar + '/' +
                                qty + ') ';

                            if (!status) {
                                status = 'PR DONE';
                            }

                            // Menampilkan data tanpa lampiran
                            var kode_material = value.kode_material || '';
                            var keterangan = value.keterangan || '';

                            var editButton =
                                '<button type="button" class="btn btn-success btn-xs mr-1" data-row-id="' +
                                value.id + '" title="Edit" onclick="editRow(\'' + value.id + '\', \'' +
                                value.kode_material + '\', \'' + value.uraian + '\', \'' + value.spek +
                                '\', \'' + value.qty + '\', \'' + value.satuan + '\', \'' + value
                                .waktu + '\', \'' + value.keterangan +
                                '\')"><i class="fas fa-edit"></i></button>';

                            var deleteButton =
                                '<button type="button" class="btn btn-danger btn-xs mr-1"' +
                                ' onclick="deleteDetail(' + value.id + ', \'' + value.uraian
                                .toString() + '\')"' +
                                ' title="Delete">' +
                                '<i class="fas fa-trash"></i>' +
                                '</button>';

                            $('#table-pr').append('<tr><td>' + (key + 1) + '</td><td>' + kode_material +
                                '</td><td>' + value.uraian + '</td><td>' + value.spek +
                                '</td><td>' + value.qty + '</td><td>' + value.satuan +
                                '</td><td>' + value.waktu + '</td><td>' + keterangan +
                                '</td><td><b>' + spphStatus +
                                '</b></td><td><b>' + spphRfqStatus +
                                '</b></td><td><b>' + loiStatus +
                                '</b></td><td><b>' + loiluarStatus +
                                '</b></td><td><b>' + negoStatus +
                                '</b></td><td><b>' + negoluarStatus +
                                '</b></td><td><b>' + poStatus +
                                '</b></td><td><b>' + poluarStatus +
                                '</b></td><td>' + editButton + deleteButton + '</td></tr>');
                        });



                    }
                }
            });
        }

        function deleteDetail(id, uraian) {
            if (confirm('Apakah Anda yakin ingin menghapus item dengan nama komponen: ' + uraian + '?')) {
                $.ajax({
                    url: 'detail_purchase_request/' + id + '/delete',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Pastikan token CSRF sudah disediakan di dalam template Anda
                    },
                    success: function(result) {
                        // Menghapus baris dari tabel
                        $('button[data-id="' + result.deletedId + '"]').closest('tr').remove();
                        // alert(result.success); // Tampilkan pesan sukses
                        // alert("Nilai id_pr adalah: " + id_pr);
                        // alert(result.id_pr);
                        $.ajax({
                            url: "{{ url('products/purchase_request_detail') }}" + "/" + result.id_pr,
                            type: "GET",
                            dataType: "json",
                            beforeSend: function() {
                                $('#table-pr').append(
                                    '<tr><td colspan="15" class="text-center">Loading...</td></tr>'
                                );
                                $('#button-cetak-pr').html(
                                    '<i class="fas fa-spinner fa-spin"></i> Loading...');
                                $('#button-cetak-pr').attr('disabled', true);
                            },
                            success: function(data) {
                                console.log(data);
                                $('#id').val(data.pr.id);
                                $('#no_surat').text(data.pr.no_pr);
                                $('#tgl_surat').text(data.pr.tanggal);
                                $('#proyek').text(data.pr.proyek);
                                $('#button-cetak-pr').html('<i class="fas fa-print"></i> Cetak');
                                $('#button-cetak-pr').attr('disabled', false);
                                var no = 1;

                                if (data.pr.details.length == 0) {
                                    $('#table-pr').empty();
                                    $('#table-pr').append(
                                        '<tr><td colspan="17" class="text-center">Tidak ada produk</td></tr>'
                                    ); // Tambahkan pesan bahwa tidak ada produk
                                } else {
                                    $('#table-pr').empty();
                                    // $.each(data.pr.details, function(key, value) {
                                    //     console.log(value);
                                    //     var selisih = Math.abs(value.selisih_qty || 0);
                                    //     var qty = value.qty || 0;
                                    //     var selisihQtySpphrfq = Math.abs(value
                                    //         .selisih_qty_spphrfq || 0);
                                    //     var selisihQtyLoi = Math.abs(value
                                    //         .selisih_qty_loi || 0);
                                    //     var selisihQtyLoiluar = Math.abs(value
                                    //         .selisih_qty_loiluar || 0);
                                    //     var selisihQtyNego = Math.abs(value
                                    //         .selisih_qty_nego || 0);
                                    //     var selisihQtyNegoluar = Math.abs(value
                                    //         .selisih_qty_negoluar || 0);
                                    //     var selisihQtyPo = Math.abs(value.selisih_qty_po ||
                                    //         0);
                                    //     var selisihQtyPoluar = Math.abs(value
                                    //         .selisih_qty_poluar || 0);

                                    //     // Status langsung diambil
                                    //     var spphStatus = 'Proses SPPH (' + selisih + '/' +
                                    //         qty + ') ';
                                    //     var spphRfqStatus = 'Proses SPPH RFQ (' +
                                    //         selisihQtySpphrfq + '/' + qty +
                                    //         ') ';
                                    //     var loiStatus = 'Proses LOI (' + selisihQtyLoi +
                                    //         '/' + qty + ') ';
                                    //     var loiluarStatus = 'Proses LOI LUAR NEGERI (' +
                                    //         selisihQtyLoiluar + '/' +
                                    //         qty + ') ';
                                    //     var negoStatus = 'Proses NEGO (' + selisihQtyNego +
                                    //         '/' + qty + ') ';
                                    //     var negoluarStatus = 'Proses NEGO LUAR NEGERI (' +
                                    //         selisihQtyNegoluar +
                                    //         '/' + qty + ') ';
                                    //     var poStatus = 'Proses PO (' + selisihQtyPo + '/' +
                                    //         qty + ') ';
                                    //     var poluarStatus = 'Proses PO LUAR NEGERI (' +
                                    //         selisihQtyPoluar + '/' +
                                    //         qty + ') ';

                                    //     if (!status) {
                                    //         status = 'PR DONE';
                                    //     }

                                    //     // Menampilkan data tanpa pengecekan if
                                    //     var spph = value.nomor_spph || '-';
                                    //     var spphrfq = value.nomor_spphrfq || '-';
                                    //     var loi = value.no_loi || '-';
                                    //     var loiluar = value.no_loiluar || '-';
                                    //     var nego = value.nomor_nego || '-';
                                    //     var negoluar = value.nomor_negoluar || '-';
                                    //     var po = value.no_po || '-';
                                    //     var poluar = value.no_poluar || '-';
                                    //     var keterangan = value.keterangan || '';
                                    //     var kode_material = value.kode_material || '';
                                    //     var lampiran = value.lampiran ?
                                    //         '<a href="' + urlLampiran + '/' + value
                                    //         .lampiran +
                                    //         '"><i class="fa fa-eye"></i> Lihat</a>' :
                                    //         '-';

                                    //     var editButton =
                                    //         '<button type="button" class="btn btn-success btn-xs mr-1" data-row-id="' +
                                    //         value.id +
                                    //         '" title="Edit" onclick="editRow(\'' + value
                                    //         .id + '\', \'' +
                                    //         value.kode_material + '\', \'' + value.uraian +
                                    //         '\', \'' + value.spek +
                                    //         '\', \'' + value.qty + '\', \'' + value.satuan +
                                    //         '\', \'' + value
                                    //         .waktu +
                                    //         '\', \'' + value.lampiran + '\', \'' + value
                                    //         .keterangan +
                                    //         '\')"><i class="fas fa-edit"></i></button>';

                                    //     var deleteButton =
                                    //         '<button type="button" class="btn btn-danger btn-xs mr-1"' +
                                    //         ' onclick="deleteDetail(' + value.id + ', \'' +
                                    //         value.uraian
                                    //         .toString() + '\')"' +
                                    //         ' title="Delete">' +
                                    //         '<i class="fas fa-trash"></i>' +
                                    //         '</button>';

                                    //     $('#table-pr').append('<tr><td>' + (key + 1) +
                                    //         '</td><td>' + kode_material +
                                    //         '</td><td>' + value.uraian + '</td><td>' +
                                    //         value.spek +
                                    //         '</td><td>' + value.qty + '</td><td>' +
                                    //         value.satuan +
                                    //         '</td><td>' + value.waktu + '</td><td>' +
                                    //         lampiran +
                                    //         '</td><td>' + keterangan + '</td><td><b>' +
                                    //         spphStatus +
                                    //         '</b></td><td><b>' + spphRfqStatus +
                                    //         '</b></td><td><b>' + loiStatus +
                                    //         '</b></td><td><b>' + loiluarStatus +
                                    //         '</b></td><td><b>' + negoStatus +
                                    //         '</b></td><td><b>' + negoluarStatus +
                                    //         // ⬅️ Tambahkan di sini
                                    //         '</b></td><td><b>' + poStatus +
                                    //         '</b></td><td><b>' + poluarStatus +
                                    //         // ⬅️ Tambahkan di sini
                                    //         '</b></td><td>' + editButton +
                                    //         deleteButton + '</td></tr>');

                                    // });

                                    $.each(data.pr.details, function(key, value) {
                                        console.log(value);
                                        var selisih = Math.abs(value.selisih_qty || 0);
                                        var qty = value.qty || 0;
                                        var selisihQtySpphrfq = Math.abs(value
                                            .selisih_qty_spphrfq || 0);
                                        var selisihQtyLoi = Math.abs(value
                                            .selisih_qty_loi || 0);
                                        var selisihQtyLoiluar = Math.abs(value
                                            .selisih_qty_loiluar || 0);
                                        var selisihQtyNego = Math.abs(value
                                            .selisih_qty_nego || 0);
                                        var selisihQtyNegoluar = Math.abs(value
                                            .selisih_qty_negoluar || 0);
                                        var selisihQtyPo = Math.abs(value.selisih_qty_po ||
                                            0);
                                        var selisihQtyPoluar = Math.abs(value
                                            .selisih_qty_poluar || 0);

                                        // Status langsung diambil
                                        var spphStatus = 'Proses SPPH (' + selisih + '/' +
                                            qty + ') ';
                                        var spphRfqStatus = 'Proses SPPH RFQ (' +
                                            selisihQtySpphrfq + '/' + qty + ') ';
                                        var loiStatus = 'Proses LOI (' + selisihQtyLoi +
                                            '/' + qty + ') ';
                                        var loiluarStatus = 'Proses LOI LUAR NEGERI (' +
                                            selisihQtyLoiluar + '/' + qty + ') ';
                                        var negoStatus = 'Proses NEGO (' + selisihQtyNego +
                                            '/' + qty + ') ';
                                        var negoluarStatus = 'Proses NEGO LUAR NEGERI (' +
                                            selisihQtyNegoluar + '/' + qty + ') ';
                                        var poStatus = 'Proses PO (' + selisihQtyPo + '/' +
                                            qty + ') ';
                                        var poluarStatus = 'Proses PO LUAR NEGERI (' +
                                            selisihQtyPoluar + '/' + qty + ') ';

                                        if (!status) {
                                            status = 'PR DONE';
                                        }

                                        // Menampilkan data tanpa lampiran
                                        var kode_material = value.kode_material || '';
                                        var keterangan = value.keterangan || '';

                                        var editButton =
                                            '<button type="button" class="btn btn-success btn-xs mr-1" data-row-id="' +
                                            value.id +
                                            '" title="Edit" onclick="editRow(\'' + value
                                            .id + '\', \'' +
                                            value.kode_material + '\', \'' + value.uraian +
                                            '\', \'' + value.spek +
                                            '\', \'' + value.qty + '\', \'' + value.satuan +
                                            '\', \'' + value
                                            .waktu + '\', \'' + value.keterangan +
                                            '\')"><i class="fas fa-edit"></i></button>';

                                        var deleteButton =
                                            '<button type="button" class="btn btn-danger btn-xs mr-1"' +
                                            ' onclick="deleteDetail(' + value.id + ', \'' +
                                            value.uraian.toString() + '\')"' +
                                            ' title="Delete">' +
                                            '<i class="fas fa-trash"></i>' +
                                            '</button>';

                                        $('#table-pr').append('<tr><td>' + (key + 1) +
                                            '</td><td>' + kode_material +
                                            '</td><td>' + value.uraian + '</td><td>' +
                                            value.spek +
                                            '</td><td>' + value.qty + '</td><td>' +
                                            value.satuan +
                                            '</td><td>' + value.waktu + '</td><td>' +
                                            keterangan + '</td><td><b>' + spphStatus +
                                            '</b></td><td><b>' + spphRfqStatus +
                                            '</b></td><td><b>' + loiStatus +
                                            '</b></td><td><b>' + loiluarStatus +
                                            '</b></td><td><b>' + negoStatus +
                                            '</b></td><td><b>' + negoluarStatus +
                                            '</b></td><td><b>' + poStatus +
                                            '</b></td><td><b>' + poluarStatus +
                                            '</b></td><td>' + editButton +
                                            deleteButton + '</td></tr>');
                                    });




                                }
                            }
                        });













                    },
                    error: function(err) {
                        alert('Terjadi kesalahan saat menghapus item');
                    }
                });



            }
        }


        $('#detail-pr').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var data = button.data('detail');
            console.log(data);
            lihatPR(data);
        });

        function lihatPR(data) {
            emptyTableProducts();
            clearForm()
            $('#modal-title').text("Detail Request");
            $('#button-save').text("Cetak");
            resetForm();
            $('#button-tambah-produk').text('Tambah Item Detail');
            $('#id').val(data.id);
            $('#no_surat').text(data.no_pr);
            $('#tgl_surat').text(data.tanggal);
            $('#revisi').text(data.revisi);
            $('#proyek').text(data.proyek);
            $('#proyek_id_val').val(data.proyek_id);
            $('#pr_id').val(data.id);
            $('#table-pr').empty();

            //#button-tambah-produk disabled when editable is false
            if (data.editable == 0) {
                $('#button-tambah-produk').attr('disabled', true);
            } else {
                $('#button-tambah-produk').attr('disabled', false);
            }

            $.ajax({
                url: "{{ url('products/purchase_request_detail') }}" + "/" + data.id,
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    $('#table-pr').append('<tr><td colspan="15" class="text-center">Loading...</td></tr>');
                    $('#button-cetak-pr').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                    $('#button-cetak-pr').attr('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#id').val(data.pr.id);
                    $('#no_surat').text(data.pr.no_pr);
                    $('#tgl_surat').text(data.pr.tanggal);
                    $('#proyek').text(data.pr.proyek);
                    $('#revisi_detail').text(data.pr.revisi ?? "-");
                    $('#button-cetak-pr').html('<i class="fas fa-print"></i> Cetak');
                    $('#button-cetak-pr').attr('disabled', false);

                    if (data.pr.details.length == 0) {
                        $('#table-pr').empty();
                        $('#table-pr').append(
                            '<tr><td colspan="17" class="text-center">Tidak ada produk</td></tr>'
                        );
                    } else {
                        $('#table-pr').empty();


                        // $.each(data.pr.details, function(key, value) {
                        //     console.log(value);
                        //     var selisih = Math.abs(value.selisih_qty || 0);
                        //     var qty = value.qty || 0;
                        //     var selisihQtySpphrfq = Math.abs(value.selisih_qty_spphrfq || 0);
                        //     var selisihQtyLoi = Math.abs(value.selisih_qty_loi || 0);
                        //     var selisihQtyLoiluar = Math.abs(value.selisih_qty_loiluar || 0);
                        //     var selisihQtyNego = Math.abs(value.selisih_qty_nego || 0);
                        //     var selisihQtyNegoluar = Math.abs(value.selisih_qty_negoluar || 0);
                        //     var selisihQtyPo = Math.abs(value.selisih_qty_po || 0);
                        //     var selisihQtyPoluar = Math.abs(value.selisih_qty_poluar || 0);

                        //     // Status langsung diambil
                        //     var spphStatus = 'Proses SPPH (' + selisih + '/' + qty + ') ';
                        //     var spphRfqStatus = 'Proses SPPH RFQ (' + selisihQtySpphrfq + '/' + qty +
                        //         ') ';
                        //     var loiStatus = 'Proses LOI (' + selisihQtyLoi + '/' + qty + ') ';
                        //     var loiluarStatus = 'Proses LOI LUAR NEGERI (' + selisihQtyLoiluar + '/' +
                        //         qty + ') ';
                        //     var negoStatus = 'Proses NEGO (' + selisihQtyNego + '/' + qty + ') ';
                        //     var negoluarStatus = 'Proses NEGO LUAR NEGERI (' + selisihQtyNegoluar +
                        //         '/' + qty + ') ';
                        //     var poStatus = 'Proses PO (' + selisihQtyPo + '/' + qty + ') ';
                        //     var poluarStatus = 'Proses PO LUAR NEGERI (' + selisihQtyPoluar + '/' +
                        //         qty + ') ';

                        //     if (!status) {
                        //         status = 'PR DONE';
                        //     }

                        //     // Menampilkan data tanpa pengecekan if
                        //     var spph = value.nomor_spph || '-';
                        //     var spphrfq = value.nomor_spphrfq || '-';
                        //     var loi = value.no_loi || '-';
                        //     var loiluar = value.no_loiluar || '-';
                        //     var nego = value.nomor_nego || '-';
                        //     var negoluar = value.nomor_negoluar || '-';
                        //     var po = value.no_po || '-';
                        //     var poluar = value.no_poluar || '-';
                        //     var keterangan = value.keterangan || '';
                        //     var kode_material = value.kode_material || '';
                        //     var lampiran = value.lampiran ?
                        //         '<a href="' + urlLampiran + '/' + value.lampiran +
                        //         '"><i class="fa fa-eye"></i> Lihat</a>' :
                        //         '-';

                        //     var editButton =
                        //         '<button type="button" class="btn btn-success btn-xs mr-1" data-row-id="' +
                        //         value.id + '" title="Edit" onclick="editRow(\'' + value.id + '\', \'' +
                        //         value.kode_material + '\', \'' + value.uraian + '\', \'' + value.spek +
                        //         '\', \'' + value.qty + '\', \'' + value.satuan + '\', \'' + value
                        //         .waktu +
                        //         '\', \'' + value.lampiran + '\', \'' + value.keterangan +
                        //         '\')"><i class="fas fa-edit"></i></button>';

                        //     var deleteButton =
                        //         '<button type="button" class="btn btn-danger btn-xs mr-1"' +
                        //         ' onclick="deleteDetail(' + value.id + ', \'' + value.uraian
                        //         .toString() + '\')"' +
                        //         ' title="Delete">' +
                        //         '<i class="fas fa-trash"></i>' +
                        //         '</button>';

                        //     $('#table-pr').append('<tr><td>' + (key + 1) + '</td><td>' + kode_material +
                        //         '</td><td>' + value.uraian + '</td><td>' + value.spek +
                        //         '</td><td>' + value.qty + '</td><td>' + value.satuan +
                        //         '</td><td>' + value.waktu + '</td><td>' + lampiran +
                        //         '</td><td>' + keterangan + '</td><td><b>' + spphStatus +
                        //         '</b></td><td><b>' + spphRfqStatus +
                        //         '</b></td><td><b>' + loiStatus +
                        //         '</b></td><td><b>' + loiluarStatus +
                        //         '</b></td><td><b>' + negoStatus +
                        //         '</b></td><td><b>' + negoluarStatus + // ⬅️ Tambahkan di sini
                        //         '</b></td><td><b>' + poStatus +
                        //         '</b></td><td><b>' + poluarStatus + // ⬅️ Tambahkan di sini
                        //         '</b></td><td>' + editButton + deleteButton + '</td></tr>');

                        // });

                        $.each(data.pr.details, function(key, value) {
                            console.log(value);
                            var selisih = Math.abs(value.selisih_qty || 0);
                            var qty = value.qty || 0;
                            var selisihQtySpphrfq = Math.abs(value.selisih_qty_spphrfq || 0);
                            var selisihQtyLoi = Math.abs(value.selisih_qty_loi || 0);
                            var selisihQtyLoiluar = Math.abs(value.selisih_qty_loiluar || 0);
                            var selisihQtyNego = Math.abs(value.selisih_qty_nego || 0);
                            var selisihQtyNegoluar = Math.abs(value.selisih_qty_negoluar || 0);
                            var selisihQtyPo = Math.abs(value.selisih_qty_po || 0);
                            var selisihQtyPoluar = Math.abs(value.selisih_qty_poluar || 0);

                            // Status langsung diambil
                            var spphStatus = 'Proses SPPH (' + selisih + '/' + qty + ') ';
                            var spphRfqStatus = 'Proses SPPH RFQ (' + selisihQtySpphrfq + '/' + qty +
                                ') ';
                            var loiStatus = 'Proses LOI (' + selisihQtyLoi + '/' + qty + ') ';
                            var loiluarStatus = 'Proses LOI LUAR NEGERI (' + selisihQtyLoiluar + '/' +
                                qty + ') ';
                            var negoStatus = 'Proses NEGO (' + selisihQtyNego + '/' + qty + ') ';
                            var negoluarStatus = 'Proses NEGO LUAR NEGERI (' + selisihQtyNegoluar +
                                '/' + qty + ') ';
                            var poStatus = 'Proses PO (' + selisihQtyPo + '/' + qty + ') ';
                            var poluarStatus = 'Proses PO LUAR NEGERI (' + selisihQtyPoluar + '/' +
                                qty + ') ';

                            if (!status) {
                                status = 'PR DONE';
                            }

                            // Menampilkan data tanpa lampiran
                            var kode_material = value.kode_material || '';
                            var keterangan = value.keterangan || '';

                            var editButton =
                                '<button type="button" class="btn btn-success btn-xs mr-1" data-row-id="' +
                                value.id + '" title="Edit" onclick="editRow(\'' + value.id + '\', \'' +
                                value.kode_material + '\', \'' + value.uraian + '\', \'' + value.spek +
                                '\', \'' + value.qty + '\', \'' + value.satuan + '\', \'' + value
                                .waktu + '\', \'' + value.keterangan +
                                '\')"><i class="fas fa-edit"></i></button>';

                            var deleteButton =
                                '<button type="button" class="btn btn-danger btn-xs mr-1"' +
                                ' onclick="deleteDetail(' + value.id + ', \'' + value.uraian
                                .toString() + '\')"' +
                                ' title="Delete">' +
                                '<i class="fas fa-trash"></i>' +
                                '</button>';

                            $('#table-pr').append('<tr><td>' + (key + 1) + '</td><td>' + kode_material +
                                '</td><td>' + value.uraian + '</td><td>' + value.spek +
                                '</td><td>' + value.qty + '</td><td>' + value.satuan +
                                '</td><td>' + value.waktu + '</td><td>' + keterangan +
                                '</td><td><b>' + spphStatus +
                                '</b></td><td><b>' + spphRfqStatus +
                                '</b></td><td><b>' + loiStatus +
                                '</b></td><td><b>' + loiluarStatus +
                                '</b></td><td><b>' + negoStatus +
                                '</b></td><td><b>' + negoluarStatus +
                                '</b></td><td><b>' + poStatus +
                                '</b></td><td><b>' + poluarStatus +
                                '</b></td><td>' + editButton + deleteButton + '</td></tr>');
                        });



                    }
                }
            });
        }

        function editRow(id, kode_material, uraian, spek, qty, satuan, waktu, lampiran, keterangan) {
            console.log(id, kode_material, uraian, spek, qty, satuan, waktu, lampiran, keterangan);
            resetForm();
            $('#modal-title').text("Edit Detail");
            $('#button-update-pr').text("Simpan");
            $('#button-update-pr').off('click');
            $('#button-update-pr').on('click', function() {
                // Tangani event klik di sini
                PRupdate();
            });

            $('#id').val(id);
            // $('#kode_tempat').val(data.kode_tempat);
            $('#material_kode').val(kode_material) // Mengosongkan nilai input dengan ID 'kode_material'
            $('#pname').val(uraian) // Mengosongkan nilai input dengan ID 'kode_material'
            $('#spek').val(spek); // Mengosongkan nilai input dengan ID 'desc_material'
            $('#stock').val(qty); // Mengosongkan nilai input dengan ID 'spek'
            $('#waktu').val(waktu); // Mengosongkan nilai input dengan ID 'p1'
            $('#satuan').val(satuan); // Mengosongkan nilai input dengan ID 'p3'
            // $('#lampiran').val(lampiran); // Mengosongkan nilai input dengan ID 'p3'
            // $('#lampiran-label').text(lampiran);
            $('#keterangan').val(keterangan);
            if (keterangan === 'null') {
                $('#keterangan').val('');
                // alert(keterangan);
            }
            if (kode_material === 'null') {
                $('#material_kode').val('');
                // alert(keterangan);
            }


            if ($('#detail-pr').find('#container-product').hasClass('d-none')) {
                $('#detail-pr').find('#container-product').removeClass('d-none');
                $('#detail-pr').find('#container-product').addClass('col-5');
                $('#detail-pr').find('#container-form').removeClass('col-12');
                $('#detail-pr').find('#container-form').addClass('col-7');
                $('#button-tambah-produk').text('Kembali');
            } else {
                $('#detail-pr').find('#container-product').removeClass('col-5');
                $('#detail-pr').find('#container-product').addClass('d-none');
                $('#detail-pr').find('#container-form').addClass('col-12');
                $('#detail-pr').find('#container-form').removeClass('col-7');
                $('#button-tambah-produk').text('Tambah Item Detail');
                clearForm();
            }
        }

        // Handler klik tombol Delete
        $(document).on('click', '.btnDelete', function() {
            var id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                $.ajax({
                    url: 'products/purchase_request/delete_detail/{id}' + id,
                    type: 'DELETE',
                    success: function(result) {
                        // Menghapus baris dari tabel
                        $('button[data-id="' + id + '"]').closest('tr').remove();
                    },
                    error: function(err) {
                        alert('Terjadi kesalahan saat menghapus item');
                    }
                });
            }
        });

        function detailPR(data) {
            $('#modal-title').text("Edit Request");
            $('#button-save').text("Simpan");
            resetForm();
            $('#save_id').val(data.id);
            $('#no_pr').val(data.no_pr);
            $('#tgl_pr').val(data.tgl_pr);
            $('#proyek_id').val(data.proyek_id);
            $('#dasar_pr').val(data.dasar_pr);
            $('#revisi').val(data.revisi);
            // alert(proyek_id)
        }

        function barcode(code) {
            $("#pcode_print").val(code);
            $("#barcode").attr("src", "/products/barcode/" + code);
        }

        function printBarcode() {
            var code = $("#pcode_print").val();
            var url = "/products/barcode/" + code + "?print=true";
            window.open(url, 'window_print', 'menubar=0,resizable=0');
        }

        function deletePR(data) {
            $('#delete_id').val(data.id);
        }

        $("#download-template").click(function() {
            $.ajax({
                url: '/downloads/template_import_product.xls',
                type: "GET",
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(data) {
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(data);
                    a.href = url;
                    a.download = "template_import_product.xls";
                    document.body.append(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);
                }
            });
        });

        function download(type) {
            window.location.href = "{{ route('products') }}?search={{ Request::get('search') }}&dl=" + type;
        }
    </script>
    {{-- ================= TOASTR MESSAGE ================= --}}

    {{-- SUCCESS --}}
    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif

    {{-- ERROR (SESSION) --}}
    @if (session('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
    @endif

    {{-- VALIDATION ERRORS --}}
    @if ($errors->any())
        <script>
            toastr.error("{!! implode('<br>', $errors->all()) !!}");
        </script>
    @endif
@endsection
