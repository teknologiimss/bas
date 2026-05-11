@extends('layouts.main')
@section('title', __('LOI Luar Negeri'))
@section('custom-css')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    {{-- <style>
        /* Important part */
        .modal-dialog {
            overflow-y: initial !important
        }

        .modal-body {
            max-height: calc(100vh - 200px);
            overflow-y: auto;
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
        /* =====================================================
       🔴 GLOBAL MAROON THEME – FULL VERSION
       ===================================================== */

        /* ===== ROOT COLOR SYSTEM ===== */
        :root {
            --maroon-main: #dc3545;
            --maroon-dark: #5a1620;
            
            --maroon-soft: #f4e6e8;
            --maroon-hover: #8f2735;
            --maroon-border: #e3c2c7;
            --maroon-muted: #b88a92;
            --maroon-text: #3a0f15;
        }

        /* ===== RESET SMALL ===== */
        * {
            transition: background-color .25s ease, color .25s ease,
                transform .25s ease, box-shadow .25s ease;
        }

        /* =====================================================
       🪟 MODAL
       ===================================================== */
        .modal-dialog {
            overflow-y: initial !important;
        }

        .modal-body {
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }

        /* =====================================================
       📊 TABLE
       ===================================================== */
        #table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
        }

        /* ===== TABLE HEADER ===== */
        #table thead th {
            background: linear-gradient(135deg, var(--maroon-main), var(--maroon-hover));
            color: #fff;
            padding: 12px 36px 12px 12px;
            text-align: center;
            font-weight: 600;
            position: relative;
            cursor: pointer;
        }

        /* Hover header */
        #table thead th:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(122, 31, 43, .35);
        }

        /* Active sort */
        #table thead th.active-sort {
            box-shadow: inset 0 -4px 0 var(--maroon-dark);
        }

        /* ===== SORT BUTTON ===== */
        .sort-buttons {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            font-size: 11px;
            gap: 2px;
        }

        .sort-buttons span {
            color: #f1c6cc;
            cursor: pointer;
        }

        .sort-buttons span:hover {
            color: #fff;
            transform: scale(1.3);
        }

        .sort-buttons span.active {
            color: #fff;
            animation: pulseMaroon 1.2s infinite;
        }

        /* ===== TABLE BODY ===== */
        #table tbody td {
            padding: 12px;
            color: var(--maroon-text);
            border-bottom: 1px solid var(--maroon-border);
        }

        /* Hover row */
        #table tbody tr:hover td {
            background: var(--maroon-soft);
            transform: scale(1.01);
        }

        /* =====================================================
       🔘 BUTTON
       ===================================================== */
        button,
        .btn {
            background: linear-gradient(135deg, var(--maroon-main), var(--maroon-hover));
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 600;
            cursor: pointer;
        }

        /* Hover button */
        button:hover,
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(122, 31, 43, .4);
        }

        /* Active button */
        button:active,
        .btn:active {
            transform: scale(.96);
        }

        /* =====================================================
       📄 PAGINATION
       ===================================================== */
        .page-item .page-link {
            background: #fff;
            color: var(--maroon-main);
            border: 1px solid var(--maroon-border);
        }

        .page-item .page-link:hover {
            background: var(--maroon-soft);
            transform: translateY(-2px);
        }

        .page-item.active .page-link {
            background: var(--maroon-main);
            color: #fff;
            border-color: var(--maroon-main);
        }

        /* =====================================================
       🧾 INPUT, SELECT, CHECKBOX
       ===================================================== */
        input,
        select,
        textarea {
            border: 1px solid var(--maroon-border);
            border-radius: 6px;
            padding: 6px 10px;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--maroon-main);
            box-shadow: 0 0 0 3px rgba(122, 31, 43, .2);
            outline: none;
        }

        input[type="checkbox"]:checked {
            accent-color: var(--maroon-main);
        }

        /* =====================================================
       📜 SCROLLBAR
       ===================================================== */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--maroon-soft);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--maroon-main);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--maroon-hover);
        }

        /* =====================================================
       🌊 ANIMATION
       ===================================================== */
        @keyframes pulseMaroon {
            0% {
                box-shadow: 0 0 0 0 rgba(122, 31, 43, .6);
            }

            70% {
                box-shadow: 0 0 0 8px rgba(122, 31, 43, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(122, 31, 43, 0);
            }
        }
    </style>



@endsection
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">

            {{-- Tab menu LOI dalam dan Luar --}}
            <ul class="nav nav-tabs mb-3">
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'loi.all' ? 'active' : '' }}"
                        href="{{ route('loi.all') }}">
                        <i class="fas fa-scroll"></i> Semua Data
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'loi.index' ? 'active' : '' }}"
                        href="{{ route('loi.index') }}">
                        <i class="fas fa-scroll"></i> LOI Dalam Negeri
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'loiluar.index' ? 'active' : '' }}"
                        href="{{ route('loiluar.index') }}">
                        <i class="fas fa-scroll"></i> LOI Luar Negeri
                    </a>
                </li>
            </ul>
            {{-- Tab menu LOI dalam dan Luar --}}

            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-LOI"
                        onclick="addLOI()"><i class="fas fa-plus"></i> Add New LOI</button>
                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#import-product" onclick="importProduct()"><i class="fas fa-file-excel"></i> Import Product (Excel)</button> -->
                    <!-- <button type="button" class="btn btn-primary" onclick="download('xls')"><i class="fas fa-file-excel"></i> Export Product (XLS)</button> -->
                    {{-- <div class="card-tools">
                        <form>
                            <div class="input-group input-group">
                                <input type="text" class="form-control" name="q" placeholder="Search">
                                <input type="hidden" name="category" value="{{ Request::get('category') }}">
                                <input type="hidden" name="sort" value="{{ Request::get('sort') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div> --}}
                </div>

                <div class="card-body">
                    <div class="table-responsive">

                        {{-- Filter by Nomor Po dan Tanggal --}}
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="filter-loi-no">Filter Nomor LOI</label>
                                    <input type="text" class="form-control" id="filter-loi-no"
                                        placeholder="Masukkan Nomor loi">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="filter-loi-date">Filter Tanggal LOI</label>
                                    <input type="date" class="form-control" id="filter-loi-date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-secondary mt-4" id="clear-filter">Clear Filter</button>
                            </div>
                        </div>
                        {{-- End Filter by Nomor Po dan Tanggal --}}

                        <table id="table" class="table table-sm table-bordered table-hover table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th><input type="checkbox" id="select-all"></th>
                                    <th>No.</th>
                                    <th>{{ __('Nomor LOI') }}</th>
                                    <th>{{ __('Nomor PR') }}</th>
                                    <th>{{ __('Lampiran') }}</th>
                                    <th>{{ __('Perihal') }}</th>
                                    <th>{{ __('Tanggal LOI') }}</th>
                                    <th>{{ __('Batas LOI') }}</th>
                                    <th>{{ __('Vendor') }}</th>
                                    <th>{{ __('Nomor PO') }}</th>
                                    <th>{{ __('Tanggal PO') }}</th>
                                    <th>{{ __('Aksi') }}</th>
                                    {{-- <th>{{ __('Penerima') }}</th> --}}

                                </tr>
                            </thead>
                            <tbody>
                                @if (count($loiluares) > 0)
                                    @foreach ($loiluares as $key => $d)
                                        @php
                                            // $penerima = $d->penerima;
                                            // $penerima = json_decode($penerima);
                                            // $penerima = implode(', ', $penerima);
                                            $vendor = $d->vendor;
                                            $data = [
                                                'no' => $loiluares->firstItem() + $key,
                                                'nomor_loiluar' => $d->nomor_loiluar,
                                                'id_pr' => $d->id_pr,
                                                'nomor_pr' => $d->nomor_pr,
                                                'nomor_po' => $d->nomor_po,
                                                'lampiran' => $d->lampiran,
                                                'vendor_id' => $d->vendor_id,
                                                'vendor' => $vendor,
                                                'perihal' => $d->perihal,
                                                'tanggal' => date('d/m/Y', strtotime($d->tanggal_loiluar)),
                                                'batas' => date('d/m/Y', strtotime($d->batas_loiluar)),
                                                'tanggal_po' => date('d/m/Y', strtotime($d->tanggal_po)),
                                                'penerima' => $d->penerima,
                                                'alamat' => $d->alamat,

                                                'keterangan_loiluar' => $d->keterangan_loiluar,
                                                'signature_imss' => $d->signature_imss,
                                                'signature_vendor' => $d->signature_vendor,
                                                'id' => $d->id,
                                                'penerima_asli' => $d->penerima,
                                                'alamat_asli' => $d->alamat,
                                            ];
                                        @endphp

                                        <tr>
                                            <td class="text-center"><input type="checkbox" name="hapus[]"
                                                    value="{{ $d->id }}"></td>
                                            <td class="text-center">{{ $data['no'] }}</td>
                                            <td class="text-center">{{ $data['nomor_loiluar'] }}</td>
                                            <td class="text-center">{{ $data['nomor_pr'] }}</td>

                                            {{-- membuat lampiran lebih dari 1 --}}
                                            <td class="text-center">
                                                @php
                                                    // Memisahkan lampiran berdasarkan koma
                                                    $lampiran = explode(',', $d->lampiran);
                                                @endphp

                                                @if (!empty($lampiran) && is_array($lampiran) && count($lampiran) > 0)
                                                    @foreach ($lampiran as $index => $file)
                                                        @if (!empty($file))
                                                            <a href="{{ asset('/lampiran/' . trim($file)) }}"
                                                                target="_blank">
                                                                <i class="fa fa-eye"></i> Lihat
                                                            </a>
                                                            @if ($index < count($lampiran) - 1)
                                                                <br>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            {{-- membuat lampiran lebih dari 1 --}}


                                            <td class="text-center">{{ $data['perihal'] }}</td>
                                            <td class="text-center">{{ $data['tanggal'] }}</td>
                                            <td class="text-center">{{ $data['batas'] }}</td>
                                            <td class="text-center">{{ $data['vendor'] }}</td>
                                            <td class="text-center">{{ $data['nomor_po'] }}</td>
                                            <td class="text-center">{{ $data['tanggal_po'] }}</td>
                                            {{-- <td class="text-center">{{ $data['penerima'] }}</td> --}}
                                            <td class="text-center">
                                                <button title="Edit LOI" type="button" class="btn btn-success btn-xs"
                                                    data-toggle="modal" data-target="#add-LOI"
                                                    onclick="editLOI({{ json_encode($data) }})"><i
                                                        class="fas fa-edit"></i></button>

                                                <button title="Lihat Detail" type="button" data-toggle="modal"
                                                    data-target="#detail-loi" class="btn-lihat btn btn-info btn-xs"
                                                    data-detail="{{ json_encode($data) }}"><i
                                                        class="fas fa-list"></i></button>
                                                @if (Auth::user()->role == 0 || Auth::user()->role == 1)
                                                    <button title="Hapus LOI" type="button" class="btn btn-danger btn-xs"
                                                        data-toggle="modal" data-target="#delete-loi"
                                                        onclick="deleteloi({{ json_encode($data) }})"><i
                                                            class="fas fa-trash"></i></button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="text-center">
                                        <td colspan="12">{{ __('No data.') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-danger" id="delete-selected"
                            data-token="{{ csrf_token() }}">Hapus yang dipilih</button>
                    </div>
                </div>
            </div>
            <div class="mt-3 d-flex justify-content-end">
                {{ $loiluares->links('pagination::bootstrap-4') }}
            </div>
        </div>

        {{-- modal --}}
        <div class="modal fade" id="add-LOI">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Add New LOI') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="save" action="{{ route('loiluar.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="save_id" name="id">
                            <input type="hidden" id="id_pr" name="id_pr">
                            <input type="hidden" id="lampiran_awal" name="lampiran_awal">
                            <input type="hidden" id="nama_lampiran" name="nama_lampiran">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="nomor_loiluar"
                                            class="col-sm-4 col-form-label">{{ __('Nomor LOI') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nomor_loiluar" name="nomor_loiluar">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nomor_po"
                                            class="col-sm-4 col-form-label">{{ __('Nomor PO') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nomor_po" name="nomor_po">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nomor_pr"
                                            class="col-sm-4 col-form-label">{{ __('Nomor PR') }}</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="nomor_pr" id="nomor_pr">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="perihal" class="col-sm-4 col-form-label">{{ __('Regarding') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="perihal" name="perihal">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="signature_imss" class="col-sm-4 col-form-label">{{ __('Signature PT Imss') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="signature_imss" name="signature_imss">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="signature_vendor" class="col-sm-4 col-form-label">{{ __('Signature Vendor') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="signature_vendor" name="signature_vendor">
                                        </div>
                                    </div>

                                </div>

                                {{-- Pemisah kolom --}}
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="tanggal_loiluar"
                                            class="col-sm-4 col-form-label">{{ __('Date Loi') }}</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="tanggal_loiluar"
                                                name="tanggal_loiluar">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="batas_loiluar"
                                            class="col-sm-4 col-form-label">{{ __('Deadline Loi') }}</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="batas_loiluar" name="batas_loiluar">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tanggal_po"
                                            class="col-sm-4 col-form-label">{{ __('Date PO') }}</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="tanggal_po"
                                                name="tanggal_po">
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label for="keterangan_loiluar"
                                            class="col-sm-4 col-form-label">{{ __('Information') }}</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" id="keterangan_loiluar" name="keterangan_loiluar" rows="4"
                                                placeholder="contoh penulisan                            Delivery:2(dua) minggu setelah PO setelah itu enter untuk nomor selanjutnya"></textarea>
                                        </div>
                                    </div>


                                </div>
                                {{-- Pemisah kolom --}}

                            </div>
                            <hr>

                            {{-- <h6>Penerima -- </h6>

                            <div id="penerima-row">

                            </div>

                            <a id="tambah" style="cursor: pointer">Tambah Penerima</a> --}}

                            <input type="text" id="data_lampiran" value="--" style="display: none">
                            <input type="text" id="data_vendor" value="--" style="display: none">
                            <h6 id="lampiran_text">Lampiran</h6>

                            <div id="lampiran-row">

                            </div>

                            <a id="tambah-lampiran" style="cursor: pointer">Tambah Lampiran</a>
                            <hr>

                            <h6 id="vendor_text">Vendor -- </h6>

                            <div id="vendor-row">

                            </div>

                            <a id="tambah" style="cursor: pointer">Tambah vendor</a>

                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button id="button-save" type="button" class="btn btn-primary"
                            onclick="setSaveIdAndSubmit();">{{ __('Tambahkan') }}</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal lihat detail --}}
        <div class="modal fade" id="detail-loi">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Detail Loi') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <form id="cetak-loi" method="GET" action="{{ route('loiluar.print') }}" target="_blank">
                                <input type="hidden" name="loiluar_id" id="loiluar_id">
                                
                                <label for="currency">Pilih Mata Uang:</label>
                                <select name="currency" id="currency" required>
                                    <option value="IDR">IDR (Rupiah)</option>
                                    <option value="USD">USD (Dollar)</option>
                                    <option value="EUR">EUR (Euro)</option>
                                    <option value="JPY">JPY (Yen Jepang)</option>
                                    <option value="AUD">AUD (Dollar Australia)</option>
                                    <option value="CNY">CNY (Yuan China)</option>
                                    <option value="PHP">PHP (Peso Filipina)</option>
                                    <option value="INR">INR (Rupee India)</option>
                                    <option value="KRW">KRW (Won Korea Selatan)</option>
                                    <option value="SAR">SAR (Riyal Arab Saudi)</option>
                                    <option value="MYR">MYR (Ringgit Malaysia)</option>
                                    <option value="ARS">ARS (Peso Argentina)</option>
                                    <option value="BRL">BRL (Real Brazil)</option>
                                    <option value="THB">THB (Baht Thailand)</option>
                                    <option value="KHR">KHR (Riel Kamboja)</option>
                                    <option value="IRR">IRR (Rial Iran)</option>
                                    <option value="BND">BND (Dollar Brunei)</option>
                                    <option value="QAR">QAR (Riyal Qatar)</option>
                                </select>
                            </form>
                            <div class="row">
                                
                                
                                
                                <div class="col-12" id="container-form">
                                    <button id="button-cetak-loi" type="button" class="btn btn-primary"
                                        onclick="document.getElementById('cetak-loi').submit();">{{ __('Cetak') }}</button>
                                    <table class="align-top w-100">
                                        {{-- <tr>
                                            <td style="width: 3%;"><b>ID PR</b></td>
                                            <td style="width:2%">:</td>
                                            <td style="width: 55%"><span id="id_pr2"></span></td>
                                        </tr> --}}
                                        <tr>
                                            <td style="width: 3%;"><b>No.Loi</b></td>
                                            <td style="width:2%">:</td>
                                            <td style="width: 55%"><span id="no_surat"></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Penerima</b></td>
                                            <td>:</td>
                                            <td><span id="nama_penerima"></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>tanggal</b></td>
                                            <td>:</td>
                                            <td><span id="tgl_loi"></span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Produk</b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <button id="button-tambah-produk" type="button"
                                                    class="btn btn-info mb-3">{{ __('Tambah Produk') }}</button>
                                            </td>
                                            {{-- <button title="Edit SPPH" type="button" class="btn btn-success btn-xs"
                                            data-toggle="modal" data-target="#add-SPPH"
                                            onclick="editSPPH({{ json_encode($data) }})"> --}}
                                        </tr>
                                    </table>
                                    <div class="table-responsive">
                                        {{-- <table class="table table-bordered">
                                            <thead>
                                                <th>NO</th>
                                                <th>Nama Barang</th>
                                                <th>Spesifikasi</th>
                                                <th>QTY</th>
                                                <th>Satuan</th>
                                                <th>Harga Satuan Rp.</th>
                                                <th>Harga Total</th>
                                                <th>Aksi</th>
                                            </thead>

                                            <tbody id="table-nego">
                                            </tbody>
                                        </table> --}}
                                        <table class="table table-bordered" style="text-align: center">
                                            <thead>
                                                <tr>
                                                    <th>NO</th>
                                                    <th>Deskripsi</th>
                                                    <th>Spesifikasi</th>
                                                    <th>QTY</th>
                                                    <th>Satuan</th>
                                                    <th>Harga Satuan Rp.</th>
                                                    <th>Harga Total</th>
                                                    <th>Aksi</th>
                                                </tr>

                                            </thead>
                                            <tbody id="table-loi">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-0 d-none" id="container-product">
                                    {{-- <div class="card">
                                        <div class="card-body">
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
                                        </div>
                                    </div> --}}
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
                                            <!-- <button type="button" class="btn btn-primary mb-3"
                                                    onclick="addToDetails()"></i>Tambah Pilihan</button> -->
                                            <button id="btn-save-then-add" type="button"
                                                class="btn btn-primary mb-3">Tambah Pilihan</button>

                                            {{-- <div class="input-group input-group-lg">
                                                <input type="text" class="form-control" id="proyek_name"
                                                    name="proyek_name" placeholder="Search By Proyek">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" id="check-proyek"
                                                        onclick="productCheck()">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div> --}}
                                        </div>
                                        <div class="table-responsive card-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Pilih</th>
                                                        <th>Deskripsi</th>
                                                        <th>Spesifikasi</th>
                                                        <th>QTY</th>
                                                        <th>QTY</th>
                                                        <th>Sat</th>
                                                        <th>NO PR</th>
                                                        <th>No SPPH</th>
                                                        <th>Proyek</th>

                                                    </tr>
                                                </thead>
                                                <tbody id='detail-material'>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>








        

        {{-- modal delete sjn --}}
        <div class="modal fade" id="delete-loi">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">{{ __('Delete LOI') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="delete" action="{{ route('loiluar.destroy') }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" id="delete_id" name="id">
                        </form>
                        <div>
                            <p>Anda yakin ingin menghapus LOI <span id="pcode" class="font-weight-bold"></span>?
                            </p>
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

    {{-- Untuk Filter ASC-DSC Seperti Windows Explorer --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const table = document.getElementById("table");
            const headers = table.querySelectorAll("th");
            let sortState = {};

            headers.forEach((header, index) => {
                // Lewati kolom checkbox, kolom No., dan kolom terakhir (aksi kosong)
                const headerText = header.textContent.trim().toLowerCase();
                if (index === 0 || headerText === "no." || headerText === "") return;

                // Tambahkan tombol panah permanen
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

                    // Reset tampilan aktif
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

    <script>
        // Konfigurasi toastr agar selalu di pojok kanan atas dan animasi konsisten
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        var selected = [];

        function addToDetailsJs(id) {
            console.log(id, selected);

            if (selected.includes(id)) {
                selected = selected.filter(item => item !== id)
            } else {
                selected.push(id)
            }

            console.log(selected);
        }

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

        //function delete checkbox
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
                    url: 'loiluar-imss/hapus-multiple',
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

        //Filter by Nomor dan tgl Loi
        $(document).ready(function() {

            $('#clear-filter').on('click', function() {
                $('#filter-loi-no, #filter-loi-date').val('');
                filterTable();
            });


            $("#nomor_pr").select2({
                placeholder: 'Pilih PR',
                width: '100%',
                data: [{
                    id: 'all',
                    text: 'Semua'
                }],
                ajax: {
                    url: "{{ route('nopr.index') }}",
                    processResults: function({
                        data
                    }) {
                        // Menggabungkan opsi "Semua" dengan data dari database
                        let results = $.map(data, function(item) {
                            return {
                                id: item.no_pr,
                                ids: item.id,
                                text: item.no_pr,
                            }
                        });
                        return {
                            results: results
                        }
                    }
                }
            })
            $('#nomor_pr').on('select2:select', function(e) {
                var selectedData = e.params.data;
                $("#id_pr").val(selectedData.ids);
                // alert($("#id_pr").val());
            });


            $('#filter-loi-no, #filter-loi-date').on('keyup change', function() {
                filterTable();
            });

            function filterTable() {
                var filterNoLOI = $('#filter-loi-no').val().toUpperCase();
                var filterDateLOI = $('#filter-loi-date').val();

                $('table tbody tr').each(function() {
                    var noLOI = $(this).find('td:nth-child(3)').text().toUpperCase();
                    var dateLOI = $(this).find('td:nth-child(7)').text();
                    var id = $(this).find('td:nth-child(1)')
                        .text(); // Ubah indeks kolom ke indeks ID PO jika perlu

                    // Ubah string tanggal ke objek Date untuk perbandingan
                    var dateParts = dateLOI.split("/");
                    var loiDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[
                        0]); // Format: tahun, bulan, tanggal

                    // Ubah string filterDatePO ke objek Date
                    var filterDateParts = filterDateLOI.split("-");
                    var filterLOIDate = new Date(filterDateParts[0], filterDateParts[1] - 1,
                        filterDateParts[
                            2]); // Format: tahun, bulan, tanggal

                    if ((noLOI.indexOf(filterNoLOI) > -1 || filterNoLOI === '') &&
                        (loiDate.getTime() === filterLOIDate.getTime() || filterDateLOI === '')) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
        });
        //End Filter by Nomor dan tgl SPPH


        function resetForm() {
            $('#save').trigger("reset");
            $('#barcode_preview_container').hide();
        }

        function addLOI() {
            $('#modal-title').text("Add New LOI");
            $('#button-save').text("Tambahkan");
            $('#save_id').val("");
            resetForm();
        }

        //fungsi generate alamat

        // function generateNamaAlamat(data) {
        //     if (data) {
        //         $('#penerima-row').empty();
        //         var length = data.length;

        //         data.map((item, index) => {
        //             const counter = index + 1
        //             var formGroup =
        //                 '<div class="group">' +
        //                 '<div class="form-group row">' +
        //                 '<label for="penerima' + counter + '" class="col-sm-4 col-form-label">Penerima ' + counter +
        //                 '</label>' +
        //                 '<div class="col-sm-8 d-flex align-items-center">' +
        //                 '<input type="text" class="form-control" id="penerima' + counter +
        //                 '" name="penerima[]" value="' + item.penerima + '">' +
        //                 //remove button
        //                 '<button type="button" class="ml-2 btn btn-danger btn-sm" onclick="removeNamaAlamat(' +
        //                 counter +
        //                 ')"><i class="fas fa-trash"></i></button>' +
        //                 '</div>' +
        //                 '</div>' +
        //                 '<div class="form-group row">' +
        //                 '<label for="alamat' + counter + '" class="col-sm-4 col-form-label">Alamat ' + counter +
        //                 '</label>' +
        //                 '<div class="col-sm-8">' +
        //                 '<textarea class="form-control" id="alamat' + counter +
        //                 '" name="alamat[]" rows="3">' + item.alamat + '</textarea>' +
        //                 '</div>' +
        //                 '</div>' +
        //                 '<hr/>' +
        //                 '</div>';
        //             $("#penerima-row").append(formGroup);
        //         })
        //     } else {
        //         var length = $("#penerima-row").children().length;
        //         var counter = length + 1;

        //         var formGroup =
        //             '<div class="group">' +
        //             '<div class="form-group row">' +
        //             '<label for="penerima' + counter + '" class="col-sm-4 col-form-label">Penerima ' + counter +
        //             '</label>' +
        //             '<div class="col-sm-8 d-flex align-items-center">' +
        //             '<input type="text" class="form-control" id="penerima' + counter + '" name="penerima[]">' +
        //             //remove button
        //             '<button type="button" class="ml-2 btn btn-danger btn-sm" onclick="removeNamaAlamat(' + counter +
        //             ')"><i class="fas fa-trash"></i></button>' +
        //             '</div>' +
        //             '</div>' +
        //             '<div class="form-group row">' +
        //             '<label for="alamat' + counter + '" class="col-sm-4 col-form-label">Alamat ' + counter + '</label>' +
        //             '<div class="col-sm-8">' +
        //             '<textarea class="form-control" id="alamat' + counter + '" name="alamat[]"></textarea>' +
        //             '</div>' +
        //             '</div>' +
        //             '<hr/>' +
        //             '</div>';
        //         $("#penerima-row").append(formGroup);
        //     }
        // }


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

        function generateVendorList(data) {
            if (data) {
                $('#vendor-row').empty();
                var length = data.length;

                data.map((item, index) => {
                    const counter = index + 1;
                    var formGroup =
                        '<div class="group">' +
                        '<div class="form-group row">' +
                        '<label for="vendor' + counter + '" class="col-sm-4 col-form-label">Vendor ' + counter +
                        '</label>' +
                        '<div class="col-sm-8 d-flex align-items-center">' +
                        '<select class="form-control" id="vendor' + counter + '" name="vendor[]">' +
                        '<option value="">Pilih Vendor</option>' +
                        '@foreach ($vendors as $vendor)' +
                        '<option value="{{ $vendor->nama }}">{{ $vendor->nama }}</option>' +
                        // Use vendor name for both value and text
                        '@endforeach' +
                        '</select>' +
                        '<button type="button" class="ml-2 btn btn-danger btn-sm" onclick="removeNamaAlamat(' +
                        counter + ')"><i class="fas fa-trash"></i></button>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    $("#vendor-row").append(formGroup);

                    // Set the selected value after appending the form group
                    $('#vendor' + counter).val(item);
                });
            } else {
                var length = $("#vendor-row").children().length;
                var counter = length + 1;

                var formGroup =
                    '<div class="group">' +
                    '<div class="form-group row">' +
                    '<label for="vendor' + counter + '" class="col-sm-4 col-form-label">Vendor ' + counter + '</label>' +
                    '<div class="col-sm-8 d-flex align-items-center">' +
                    '<select class="form-control" id="vendor' + counter + '" name="vendor[]">' +
                    '<option value="">Pilih Vendor</option>' +
                    '@foreach ($vendors as $vendor)' +
                    '<option value="{{ $vendor->nama }}">{{ $vendor->nama }}</option>' +
                    // Use vendor name for both value and text
                    '@endforeach' +
                    '</select>' +
                    '<button type="button" class="ml-2 btn btn-danger btn-sm" onclick="removeNamaAlamat(' + counter +
                    ')"><i class="fas fa-trash"></i></button>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                $("#vendor-row").append(formGroup);
            }
        }


        function removeNamaAlamat(counter) {
            // $('#penerima' + counter).closest('.group').remove();
            $('#vendor' + counter).closest('.group').remove();
        }

        // function removeLampiran(counter) {
        //     $('#lampiran' + counter).closest('.group').remove();
        // }

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


        function showFileName(input, counter) {
            var fileName = input.files[0].name;
            $('#file-name' + counter).text(fileName);
            // Update the label with the selected file's name
            $(input).next('.custom-file-label').html(fileName);
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
            $("#tambah").click(function() {
                // generateNamaAlamat(null);
                generateVendorList(null);
            });
        });
        $(document).ready(function() {
            $("#tambah-lampiran").click(function() {
                generateLampiranList(null);
            });
        });

        function showAddProduct(data) {
            //if .modal-dialog in #detail-spph has class modal-lg, change to modal-xl, otherwise change to modal-lg
            if ($('#container-product').hasClass('d-none')) {
                $('#detail-loi').find('.modal-dialog').removeClass('modal-xl');
                $('#detail-loi').find('.modal-dialog').addClass('modal-xl');
                $('#button-tambah-produk').text('Kembali');
                $('#container-form').removeClass('col-12');
                $('#container-form').addClass('col-6');
                $('#container-product').removeClass('col-0');
                $('#container-product').addClass('col-6');
                $('#container-product').removeClass('d-none');
                // console.log(data);
            } else {
                $('#detail-loi').find('.modal-dialog').removeClass('modal-xl');
                $('#detail-loi').find('.modal-dialog').addClass('modal-xl');
                $('#button-tambah-produk').text('Tambah Produk');
                $('#container-form').removeClass('col-6');
                $('#container-form').addClass('col-12');
                $('#container-product').removeClass('col-6');
                $('#container-product').addClass('col-0');
                $('#container-product').addClass('d-none');
                $('#proyek_name').val("");
            }

            // getSpphDetail(data);


        }


        //Edit Nego *Lampiran yang membuat edit error
        // function editNEGO(data) {
        //     $('#modal-title').text("Edit NEGO");
        //     $('#button-save').text("Simpan");
        //     console.log(data);
        //     resetForm();
        //     var lampiranArray = data.lampiran.split(", ");
        //     // Mengambil nilai dari elemen input
        //     $('#lampiran_awal').val(data.lampiran).length;
        //     var nilaiLampiran = lampiranArray.length;

        //     $('#nama_lampiran').val(data.lampiran).length;

        //     // alert($('#nama_lampiran').val());

        //     var vendorArray = data.vendor.split(", ");
        //     // Mengambil nilai dari elemen input
        //     $('#data_vendor').val(data.lampiran).length;
        //     var nilaiVendor = vendorArray.length;

        //     // Menambahkan nilai dari elemen input ke teks elemen <h6>
        //     document.getElementById('lampiran_text').innerHTML = 'Total Lampiran <b>' + nilaiLampiran + '</b>';
        //     generateLampiranList(lampiranArray);

        //     // Menambahkan nilai dari elemen input ke teks elemen <h6>
        //     document.getElementById('vendor_text').innerHTML = 'Total Vendor <b>' + nilaiVendor + '</b>';
        //     generateVendorList(vendorArray);
        //     // alert(vendorArray);

        //     $('#save_id').val(data.id);
        //     $('#id_pr').val(data.id_pr);
        //     $('#nomor_nego').val(data.nomor_nego);
        //     // $('#nomor_pr').val(data.nomor_pr);
        //     var pr = data.nomor_pr; // edit nomor pr biar muncul di form
        //     $('#lampiran').val(data.lampiran);
        //     $('#vendor').val(data.vendor);
        //     $('#penerima').val(data.penerima);
        //     $('#alamat').val(data.alamat);
        //     $('#perihal').val(data.perihal);
        //     $('#no_jawaban_vendor').val(data.no_jawaban_vendor);
        //     $('#franco').val(data.franco);
        //     // Ensure the komponen option is present in Select2
        //     // data edit nomor_pr
        //     if ($("#nomor_pr option[value='" + pr + "']").length == 0) {
        //         var newOption = new Option(pr, pr, true, true);
        //         $('#nomor_pr').append(newOption).trigger('change');
        //     } else {
        //         $('#nomor_pr').val(pr).trigger('change');
        //     }
        //     // $('#tanggal_spph').val(data.tanggal);
        //     var date = data.tanggal.split('/');
        //     var newDate = date[2] + '-' + date[1] + '-' + date[0];
        //     $('#tanggal_nego').val(newDate)
        //     // $('#batas_spph').val(data.batas);
        //     var date = data.batas.split('/');
        //     var newDate = date[2] + '-' + date[1] + '-' + date[0];
        //     $('#batas_nego').val(newDate)
        //     const penerima = JSON.parse(data.penerima_asli);
        //     const alamat = JSON.parse(data.alamat_asli);
        //     const dataPenerima = penerima.map((item, index) => {
        //         return {
        //             penerima: item,
        //             alamat: alamat[index]
        //         }
        //     })
        //     generateNamaAlamat(dataPenerima);
        // }
        //END Edit Nego *Lampiran yang membuat edit error

        // Mengaktifkan tombol jika ada checkbox yang dicentang
        $(document).on('change', '.row-checkbox', function() {
            let anyChecked = $('.row-checkbox:checked').length > 0;
            $('#btn-save-then-add').prop('disabled', !anyChecked);
        });

        $('#btn-save-then-add').on('click', function() {
            var dataToSend = [];
            var selectedRows = 0; // Hitung jumlah baris yang dicentang

            $('#detail-material tr').each(function() { // Loop semua baris
                var $row = $(this);
                var id = $row.data('id');
                var qty_loiluar1 = $row.find('.qty_loiluar1-input').val();
                var isChecked = $row.find('.row-checkbox').prop('checked'); // Cek checkbox

                // if (isChecked) {
                //     selectedRows++; // Hitung jumlah yang dicentang
                //     if (qty_loi1 !== '' && !isNaN(qty_loi1)) { // Pastikan qty2 valid
                //         dataToSend.push({
                //             id: id,
                //             qty_loi1: qty_loi1
                //         });
                //     }
                // }


                if (isChecked) {
                    selectedRows++; // Hitung jumlah yang dicentang
                    if (qty_loiluar1 !== '' && !isNaN(qty_loiluar1)) { // Pastikan qty2 valid
                        dataToSend.push({
                            id: id,
                            qty_loiluar1: qty_loiluar1,
                            loiluar_id: $('#loiluar_id').val()
                        });
                    }
                }



            });

            if (selectedRows === 0) { // Jika tidak ada checkbox yang dicentang
                alert('Pilih minimal 1 baris untuk disimpan!');
                return;
            }

            if (dataToSend.length === 0) {
                alert('Pastikan qty2 terisi dengan angka yang valid!');
                return;
            }

            //     // Kirim ke server
            //     $.ajax({
            //         url: "{{ route('qty_po_save') }}",
            //         type: "POST",
            //         data: {
            //             id: id,
            //             qty_po1: qty_po1,
            //             _token: '{{ csrf_token() }}'
            //         },
            //         dataType: "json",
            //         beforeSend: function() {
            //             $('#btn-save-then-add').prop('disabled', true).text('Menyimpan...');
            //         },
            //         success: function(response) {
            //             if (response.success) {
            //                 alert('Data berhasil disimpan!');
            //                 addToDetails(); // Setelah berhasil, tambah baris baru
            //             } else {
            //                 alert('Gagal menyimpan data');
            //             }
            //             $('#btn-save-then-add').prop('disabled', false).text('Tambah Pilihan');
            //         },
            //         error: function(xhr) {
            //             alert('Terjadi kesalahan saat menyimpan data!');
            //             console.log(xhr.responseText);
            //             $('#btn-save-then-add').prop('disabled', false).text('Tambah Pilihan');
            //         }
            //     });
            // });
            $.ajax({
                url: "{{ route('qty_loiluar_save') }}", // Sesuaikan dengan route
                type: "POST",
                data: {
                    data: dataToSend,
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                beforeSend: function() {
                    $('#btn-save-then-add').prop('disabled', true).text('Menyimpan...');
                },
                success: function(response) {
                    if (response.success) {
                        alert('Data berhasil disimpan!');

                        // Nonaktifkan checkbox setelah sukses
                        $('#detail-material tr').each(function() {
                            var $row = $(this);
                            if ($row.find('.row-checkbox').prop('checked')) {
                                $row.find('.row-checkbox').prop('disabled',
                                    true); // Tidak bisa dicentang ulang
                            }
                        });

                        addToDetails(); // Tambah baris baru
                    } else {
                        alert('Gagal menyimpan data');
                    }
                    $('#btn-save-then-add').prop('disabled', false).text('Tambah Pilihan');
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat menyimpan data!');
                    console.log(xhr.responseText);
                    $('#btn-save-then-add').prop('disabled', false).text('Tambah Pilihan');
                }
            });
        });

        //logika untuk menghitung otomatis
        $(document).on('input', '.qty_loiluar1-input', function() {
            var $row = $(this).closest('tr');
            var qtyLoiluarCell = $row.find('td:eq(4)');
            var initialQtyLoiluar = parseFloat(qtyLoiluarCell.data('original-qty')) || 0;
            var inputQty_loiluar1 = parseFloat($(this).val()) || 0;

            if (inputQty_loiluar1 > initialQtyLoiluar) {
                alert("Qty tidak boleh lebih besar dari Qty");
                $(this).val(initialQtyLoiluar);
                inputQty_loiluar1 = initialQtyLoiluar;
            }

            var newQtyLoiluar = initialQtyLoiluar - inputQty_loiluar1;

            qtyLoiluarCell.text(newQtyLoiluar);
        });




        //Edit Nego
        function editLOI(data) {
            $('#modal-title').text("Edit LOI");
            $('#button-save').text("Simpan");
            console.log(data);
            resetForm();

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

            var vendorArray = data.vendor.split(", ");
            var nilaiVendor = vendorArray.length;

            $('#data_vendor').val(data.vendor);
            document.getElementById('vendor_text').innerHTML = 'Total Vendor <b>' + nilaiVendor + '</b>';
            generateVendorList(vendorArray);

            $('#save_id').val(data.id);
            $('#id_pr').val(data.id_pr);
            $('#nomor_loiluar').val(data.nomor_loiluar);

            var pr = data.nomor_pr; // edit nomor pr biar muncul di form
            $('#vendor').val(data.vendor);
            $('#penerima').val(data.penerima);
            $('#alamat').val(data.alamat);
            $('#perihal').val(data.perihal);
            $('#signature_imss').val(data.signature_imss);
            $('#signature_vendor').val(data.signature_vendor);
            $('#nomor_po').val(data.nomor_po);

            $('#keterangan_loiluar').val(data.keterangan_loiluar);

            if ($("#nomor_pr option[value='" + pr + "']").length == 0) {
                var newOption = new Option(pr, pr, true, true);
                $('#nomor_pr').append(newOption).trigger('change');
            } else {
                $('#nomor_pr').val(pr).trigger('change');
            }

            var date = data.tanggal.split('/');
            var newDate = date[2] + '-' + date[1] + '-' + date[0];
            $('#tanggal_loiluar').val(newDate);

            var date = data.tanggal.split('/');
            var newDate = date[2] + '-' + date[1] + '-' + date[0];
            $('#tanggal_po').val(newDate);


            date = data.batas.split('/');
            newDate = date[2] + '-' + date[1] + '-' + date[0];
            $('#batas_loiluar').val(newDate);

            const penerima = JSON.parse(data.penerima_asli);
            const alamat = JSON.parse(data.alamat_asli);
            const dataPenerima = penerima.map((item, index) => {
                return {
                    penerima: item,
                    alamat: alamat[index]
                }
            });
            generateNamaAlamat(dataPenerima);
        }

        //End Edit Nego



        function emptyTableLoi() {
            $('#table-loi').empty();
            $('#no_surat').text("");
            $('#tanggal_loi').text("");
            $('#nama_penerima').text("");
        }

        function loader(status = 1) {
            if (status == 1) {
                $('#loader').show();
            } else {
                $('#loader').hide();
            }
        }



        // $('#form').hide();



        //SUMBER MASALAH HARI KAMIS BUAT HARI JUMAT 



        //Menampilkan Pilih Item LOI
        function getDetailLoi(id_pr) {
            // Menampilkan loader sebelum proses ajax dimulai
            loader();

            $('#button-check').prop("disabled", true);

            $.ajax({
                url: "{{ url('products/products_pr_loiluar/') }}/" + id_pr,
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
                    $('#form').show();

                    // Mengosongkan elemen sebelum diisi dengan data baru
                    $('#detail-material').empty();
                    $('#btn-save-then-add').prop('disabled', true);

                    // Pastikan data.products ada dan merupakan array
                    if (data.products && Array.isArray(data.products)) {
                        $.each(data.products, function(key, value) {
                            console.log(value);

                            // Menyiapkan nilai untuk nomor spph, nego, dan pr jika tidak ada
                            var no_spph = value.id_spph ? value.nomor_spph : '-';
                            var no_nego = value.id_nego ? value.nomor_nego : '-';
                            var no_pr = value.pr_no ? value.pr_no : '-';

                            // // Menyiapkan checkbox yang aktif atau tidak berdasarkan id_nego
                            // var checkbox;
                            // if (value.qty_loi && value.qty_loi > 0) {
                            //     checkbox = '<input type="checkbox" id="addToDetails-' + value.id +
                            //         '" class="row-checkbox" value="' + value.id +
                            //         '" onclick="addToDetailsJs(' + value.id + ')">';
                            // } else {
                            //     checkbox = '<input type="checkbox" id="addToDetails-' + value.id +
                            //         '" class="row-checkbox" value="' + value.id +
                            //         '" onclick="addToDetailsJs(' + value.id + ')" disabled>';
                            // }

                            if (value.qty_loiluar === null || value.qty_loiluar === "" || value.qty_loiluar >= 0) {
                                checkbox = '<input type="checkbox" id="addToDetails-' + value.id +
                                    '" class="row-checkbox" value="' + value.id +
                                    '" onclick="addToDetailsJs(' + value.id + ')">';
                            } else {
                                checkbox = '<input type="checkbox" id="addToDetails-' + value.id +
                                    '" class="row-checkbox" value="' + value.id +
                                    '" onclick="addToDetailsJs(' + value.id + ')" disabled>';
                            }


                            // Menambahkan data ke tabel
                            $('#detail-material').append(
                                '<tr id="row-' + key + '" data-id="' + value.id + '">' +
                                '<td>' + (key + 1) + '</td>' +
                                '<td>' + checkbox + '</td>' +
                                '<td>' + value.uraian + '</td>' +
                                '<td>' + value.spek + '</td>' +
                                '<td data-original-qty="' + value.qty_loiluar + '">' + value.qty_loiluar +
                                // '<td><input type="text" class="form-control qty_nego1-input" style="width: 50px;" value="' + value.qty_nego1 + '" data-qty="' + value.qty_nego1 + '"></td>' +
                                '<td>' +
                                '<div style="display: block;">' +
                                // Menggunakan block untuk menata vertikal
                                '<input type="text" class="form-control qty_loiluar1-input" style="width: 50px;" value="' +
                                value.qty_loiluar1 + '" data-qty="' + value.qty_loiluar1 + '">' +


                                '<td>' + value.satuan + '</td>' +
                                '<td>' + no_pr + '</td>' +
                                '<td>' + no_spph + '</td>' +
                                '<td>' + value.nama_pekerjaan + '</td>' +
                                '</tr>'
                            );
                        });

                        // Memaksa pembaruan tampilan setelah data di-append
                        setTimeout(function() {
                            // Gunakan jQuery untuk melakukan refresh secara manual pada elemen
                            $('#detail-material').html($('#detail-material').html());
                        }, 0); // Waktu delay yang sangat singkat untuk memaksa pembaruan tampilan
                    } else {
                        console.log("Tidak ada data produk.");
                    }
                },
                error: function() {
                    // Mengaktifkan kembali tombol jika terjadi error
                    $('#pcode').prop("disabled", false);
                    $('#button-check').prop("disabled", false);
                }
            });
        }

        //End Pilih item SPPH

        function clearForm() {
            $('#product_id').val("");
            $('#pname').val("");
            $('#stock').val("");
            $('#pcode').val("");
            $('#form').hide();
        }

        //Tambah Pilihan
        function addToDetails() {
            $.ajax({
                url: "{{ url('products/tambah_loiluar_detail') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "selected_id": selected,
                    "loiluar_id": $('#loiluar_id').val(),
                },
                dataType: "json",
                beforeSend: function() {
                    $('#loader').show();
                    $('#form').hide();
                },
                success: function(data) {
                    loader(0);
                    $('#form').show();
                    var id_pr = data.loiluar.id_pr;
                    getDetailLoi(id_pr);
                    if (!data.success) {
                        toastr.error(data?.message || 'Gagal menyimpan data detail LOI Luar!');
                        return
                    }
                    selected = [];
                    $('#table-loi').empty();
                    $('#loiluar_id').val(data.loiluar.id); // Pastikan #loiluar_id selalu diisi ulang setelah update
                    $.each(data.loiluar.details, function(key, value) {
                        var loiluar_qty = value.loiluar_qty || 0;
                        var id = value.id;
                        var id_loiluar = value.id_loiluar;
                        var id_detail_loiluar = value.id_detail_loiluar;
                        var harga_per_unit = value.harga_per_unit ?? 0;
                        var total = loiluar_qty * harga_per_unit;

                        var totalFormatted = total.toLocaleString('id-ID', {
                            minimumFractionDigits: 0
                        });

                        $('#table-loi').append(
                            '<tr>' +
                            '<td>' + (key + 1) + '</td>' +
                            '<td>' + value.uraian + '</td>' +
                            '<td>' + value.spek + '</td>' +
                            '<td>' + value.loiluar_qty + '</td>' +
                            '<td>' + value.satuan + '</td>' +
                            '<td><input type="text" value="' + harga_per_unit +
                            '" class="form-control harga-per-unit" id="harga_per_unit' + id +
                            '" name="harga_per_unit' + id + '" data-id="' + id +
                            '" data-qty="' + loiluar_qty + '"></td>' +
                            '<td class="total">' + total + '</td>' +
                            '<td>' +
                            '<button type="button" class="btn btn-danger btn-delete" data-id="' +
                            value.id + '" data-id_loiluar="' + value.id_loiluar +
                            '" data-id_detail_loiluar="' + id_detail_loiluar +
                            '" data-id_detail_pr="' + value.id_detail_pr + '">' +
                            '<i class="fas fa-trash"></i>' + // Ikon Hapus
                            '</button> ' +
                            '<button type="button" class="btn btn-success btn-save" data-id="' +
                            value.id + '" data-id_loiluar="' + value.id_loiluar +
                            '" data-id_detail_loiluar="' + id_detail_loiluar +
                            '" data-id_detail_pr="' + value.id_detail_pr + '">' +
                            '<i class="fas fa-save"></i>' + // Ikon Simpan
                            '</button>' +
                            '</td>' +
                            '</tr>'
                        );

                    });

                    // Event listener untuk menghitung total secara otomatis
                    $('.harga-per-unit').on('input', function() {
                        var id = $(this).data('id');
                        var loiluar_qty = $(this).data('qty');
                        var hargaPerUnit = parseFloat($('#harga_per_unit' + id).val()) || 0;

                        // Hitung total berdasarkan harga dan qty
                        var total = loiluar_qty * hargaPerUnit;

                        // Update tampilan total di tabel
                        $('#harga_per_unit' + id).closest('tr').find('.total').text(
                            total.toLocaleString('id-ID', {
                                minimumFractionDigits: 0
                            })
                        );
                    });
                    setTimeout(function() {
                        toastr.success(data?.message || 'Berhasil menyimpan data detail LOI Luar!');
                    }, 200);
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Gagal menyimpan data detail LOI Luar!');
                    $('#pcode').prop("disabled", false);
                    $('#button-check').prop("disabled", false);
                }
            });
        }

        //End Item Tambah Pilihan


        //Tampilan di dalam tambah pilihan
        function productCheck() {
            var proyek_name = $('#proyek_name').val();
            if (proyek_name.length > 0) {
                loader();
                $('#proyek_code').prop("disabled", true);
                $('#button-check').prop("disabled", true);
                $.ajax({
                    url: "{{ url('products/products_pr?proyek=') }}" + proyek_name,
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
                        $('#form').show();
                        //append to #detail-material
                        $('#detail-material').empty();
                        $.each(data.products, function(key, value) {
                            console.table('a', value)
                            var no_spph
                            if (!value.spph_id) {
                                no_spph = '-'
                            } else {
                                no_spph = value.nomor_spph
                            }

                            var no_loi
                            if (!value.id_loi) {
                                no_loi = '-'
                            } else {
                                no_loi = value.nomor_loi
                            }

                            var no_loiluar
                            if (!value.id_loiluar) {
                                no_loiluar = '-'
                            } else {
                                no_loiluar = value.nomor_loiluar
                            }

                            var no_nego
                            if (!value.id_nego) {
                                no_nego = '-'
                            } else {
                                no_nego = value.nomor_nego
                            }

                            var no_pr
                            if (!value.id_pr) {
                                no_pr = '-'
                            } else {
                                no_pr = value.pr_no
                            }

                            var no_po
                            if (!value.id_po) {
                                no_po = '-'
                            } else {
                                no_po = value.po_no
                            }

                            var checkbox;
                            if (value.id_spph && !value.id_loiluar) {
                                checkbox = '<input type="checkbox" id="addToDetails" value="' + value
                                    .id +
                                    '" onclick="addToDetailsJs(' + value.id + ')">'
                            } else {
                                checkbox = '<input type="checkbox" id="addToDetails" value="' + value
                                    .id +
                                    '" onclick="addToDetailsJs(' + value.id + ')" disabled>'
                            }

                            $('#detail-material').append(

                                '<tr><td>' + (key + 1) + '</td><td>' + value.uraian +
                                '</td><td>' + value.spek + '</td><td>' + value.loi_qty +
                                '</td><td>' +
                                value
                                .satuan + '</td><td>' + value.nama_pekerjaan + '</td><td>' +
                                no_loi +
                                '</td><td>' + no_pr + '</td><td>' +
                                no_po + '</td><td>' + checkbox + '</td></tr>'
                            );
                        });

                        $('#detail-material').append(
                            '<tr><td colspan="8" class="text-center">Tidak ada produk</td></tr>');
                    },
                    error: function() {
                        $('#pcode').prop("disabled", false);
                        $('#button-check').prop("disabled", false);
                    }
                });
            } else {
                toastr.error("Nama Proyek tidak ditemukan");
            }
        }

        function sjnProductUpdate() {
            const id = $('#product_id').val();
            $.ajax({
                url: "{{ url('products/update_detail_sjn/') }}",
                type: "POST",
                dataType: "json",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "product_id": id,
                    "stock": $('#stock').val(),
                    "loiluar_id": $('#loiluar_id').val(),
                },
                beforeSend: function() {
                    $('#button-update-loi').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                    $('#button-update-loi').attr('disabled', true);
                },
                success: function(data) {
                    if (!data.success) {
                        toastr.error(data.message);
                        $('#button-update-loi').html('Tambahkan');
                        $('#button-update-loi').attr('disabled', false);
                        return
                    }
                    $('#no_surat').text(data.sjn.no_sjn);
                    $('#tgl_surat').text(data.sjn.datetime);
                    $('#loiluar_id').val(data.sjn.loiluar_id);
                    $('#button-update-loi').html('Tambahkan');
                    $('#button-update-loi').attr('disabled', false);
                    clearForm();
                    if (data.sjn.products.length == 0) {
                        $('#table-loi').append(
                            '<tr><td colspan="7" class="text-center">Tidak ada produk</td></tr>');
                    } else {
                        $('#table-loi').empty();
                        $.each(data.sjn.products, function(key, value) {
                            $('#table-loi').append('<tr><td>' + (key + 1) + '</td><td>' + value
                                .uraian + '</td><td>' + value.spek + '</td><td>' + value.loiluar_qty +
                                '</td><td>' + value
                                .satuan +
                                '</td><td>' + value.nama_pekerjaan + '</td></tr>');
                        });
                    }
                }
            });
        }

        // on modal #detail-loi open
        $('#detail-loi').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var data = button.data('detail');
            console.log(data);
            lihatLoi(data);
            $('#detail-loi').find('.modal-dialog').removeClass('modal-xl');
            $('#detail-loi').find('.modal-dialog').addClass('modal-xl');
            $('#button-tambah-produk').text('Tambah Produk');
            $('#container-form').removeClass('col-6');
            $('#container-form').addClass('col-12');
            $('#container-product').removeClass('col-6');
            $('#container-product').addClass('col-0');
            $('#container-product').addClass('d-none');
            $('#proyek_name').val("");
        });



        //Lihat Detail
        function lihatLoi(data) {
            emptyTableLoi();
            $('#modal-title').text("Detail LOI");
            $('#button-save').text("Cetak");
            resetForm();
            $('#save_id').val(data.id);
            $('#button-tambah-produk').val(data.id_pr);
            $('#button-tambah-produk').attr('onclick', `showAddProduct(${data.id_pr}); getDetailLoi(${data.id_pr});`);
            $('#id_pr2').text(data.id_pr);
            $('#no_surat').text(data.nomor_loiluar);
            $('#nama_penerima').text(data.penerima);
            $('#tgl_loi').text(data.tanggal);
            $('#table-loi').empty();

            $.ajax({
                url: "{{ url('products/loiluar_detail') }}" + "/" + data.id,
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    $('#table-loi').append('<tr><td colspan="6" class="text-center">Loading...</td></tr>');
                    $('#button-cetak-loi').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                    $('#button-cetak-loi').attr('disabled', true);
                },
                success: function(response) {
                    $('#no_surat').text(response.loiluar.no_loiluar);
                    $('#nama_penerima').text(response.loiluar.penerima);
                    $('#tgl_loi').text(response.loiluar.tanggal_loiluar);
                    $('#loiluar_id').val(response.loiluar.id);
                    $('#button-cetak-loi').html('<i class="fas fa-print"></i> Cetak');
                    $('#button-cetak-loi').attr('disabled', false);

                    if (response.loiluar.details.length === 0) {
                        $('#table-loi').append(
                            '<tr><td colspan="15" class="text-center">Tidak ada produk</td></tr>');
                    } else {
                        $.each(response.loiluar.details, function(key, value) {
                            var loiluar_qty = value.loiluar_qty || 0;
                            var id = value.id;
                            var id_loiluar = value.id_loiluar;
                            var id_detail_loiluar = value.id_detail_loiluar;
                            var harga_per_unit = value.harga_per_unit ?? 0;
                            var total = loiluar_qty * harga_per_unit;

                            var totalFormatted = total.toLocaleString('id-ID', {
                                minimumFractionDigits: 0
                            });

                            $('#table-loi').append(
                                '<tr>' +
                                '<td>' + (key + 1) + '</td>' +
                                '<td>' + value.uraian + '</td>' +
                                '<td>' + value.spek + '</td>' +
                                '<td>' + value.loiluar_qty + '</td>' +
                                '<td>' + value.satuan + '</td>' +
                                '<td><input type="text" value="' + harga_per_unit +
                                '" class="form-control harga-per-unit" id="harga_per_unit' + id +
                                '" name="harga_per_unit' + id + '" data-id="' + id +
                                '" data-qty="' + loiluar_qty + '"></td>' +
                                '<td class="total">' + totalFormatted + '</td>' +
                                '<td>' +
                                '<button type="button" class="btn btn-danger btn-delete" data-id="' +
                                value.id + '" data-id_loiluar="' + id_loiluar +
                                '" data-id_detail_loiluar="' + id_detail_loiluar +
                                '" data-id_detail_pr="' + value.id_detail_pr + '">' +
                                '<i class="fas fa-trash"></i>' + // Ikon hapus
                                '</button> ' +
                                '<button type="button" class="btn btn-success btn-save" data-id="' +
                                value.id + '" data-id_loiluar="' + id_loiluar +
                                '" data-id_detail_loiluar="' + id_detail_loiluar +
                                '" data-id_detail_pr="' + value.id_detail_pr + '">' +
                                '<i class="fas fa-save"></i>' + // Ikon simpan
                                '</button>' +
                                '</td>' +
                                '</tr>'
                            );

                        });

                        $('.harga-per-unit').on('input', function() {
                            var id = $(this).data('id');
                            var loiluar_qty = $(this).data('qty');
                            var hargaPerUnit = parseFloat($('#harga_per_unit' + id).val()) || 0;
                            var total = loiluar_qty * hargaPerUnit;

                            $('#harga_per_unit' + id).closest('tr').find('.total').text(
                                total.toLocaleString('id-ID', {
                                    minimumFractionDigits: 0
                                })
                            );
                        });
                    }

                    $('#table-loi').find('tr:first').remove();
                }
            });
        }



        // Action save_loi

        $(document).off('click', '.btn-save');
        $(document).on('click', '.btn-save', function() {
            var id = $(this).data('id');
            var id_loiluar = $('#loiluar_id').val(); // Ambil dari input hidden agar tidak null
            var id_detail_loiluar = $(this).data('id_detail_loiluar');
            var id_detail_pr = parseInt($(this).data('id_detail_pr'), 10);
            var harga_per_unit = $('#harga_per_unit' + id).val();
            if (harga_per_unit === undefined || harga_per_unit === null || harga_per_unit === "") {
                toastr.error('Harga per unit wajib diisi!');
                return;
            }
            $.ajax({
                url: "{{ route('detail_loiluar_save') }}",
                type: "POST",
                data: {
                    id: id,
                    id_loiluar: id_loiluar, // Selalu ambil dari input hidden
                    id_detail_loiluar: id_detail_loiluar,
                    id_detail_pr: id_detail_pr,
                    harga_per_unit: harga_per_unit,
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                beforeSend: function() {
                    $('#table-loi').append(
                        '<tr><td colspan="15" class="text-center">Loading...</td></tr>');
                },
                success: function(data) {
                    if (data.loiluar.details.length > 0) {
                        $('#table-loi').empty();
                        $('#loiluar_id').val(data.loiluar.id); // Pastikan #loiluar_id selalu diisi ulang setelah update
                        $.each(data.loiluar.details, function(key, value) {
                            var id = value.id;
                            var id_loiluar = value.id_loiluar;
                            var loiluar_qty = value.loiluar_qty;
                            var id_detail_loiluar = value.id_detail_loiluar;
                            var id_detail_pr = value.id_detail_pr;

                            console.log(value)
                            var harga_per_unit = value.harga_per_unit ?? 0;
                            var total = loiluar_qty * harga_per_unit;

                            $('#table-loi').append(
                                '<tr>' +
                                '<td>' + (key + 1) + '</td>' +
                                '<td>' + value.uraian + '</td>' +
                                '<td>' + value.spek + '</td>' +
                                '<td>' + value.loiluar_qty + '</td>' +
                                '<td>' + value.satuan + '</td>' +
                                '<td><input type="text" value="' + harga_per_unit +
                                '" class="form-control harga-per-unit" id="harga_per_unit' +
                                id +
                                '" name="harga_per_unit' + id + '" data-id="' + id +
                                '" data-qty="' + loiluar_qty + '"></td>' +
                                '<td class="total">' + total + '</td>' +
                                '<td>' +
                                '<button type="button" class="btn btn-danger btn-delete" data-id="' +
                                value.id + '" data-id_loiluar="' + value.id_loiluar +
                                '" data-id_detail_loiluar="' + id_detail_loiluar +
                                '" data-id_detail_pr="' + value.id_detail_pr + '">' +
                                '<i class="fas fa-trash"></i>' + // Ikon Hapus
                                '</button> ' +
                                '<button type="button" class="btn btn-success btn-save" data-id="' +
                                value.id + '" data-id_loiluar="' + value.id_loiluar +
                                '" data-id_detail_loiluar="' + id_detail_loiluar +
                                '" data-id_detail_pr="' + value.id_detail_pr + '">' +
                                '<i class="fas fa-save"></i>' + // Ikon Simpan
                                '</button>' +
                                '</td>' +
                                '</tr>'
                            );

                        });

                        $('.harga-per-unit').on('input', function() {
                            var id = $(this).data('id');
                            var loiluar_qty = $(this).data('qty');
                            var hargaPerUnit = $('#harga_per_unit' + id).val();
                            var total = loiluar_qty * hargaPerUnit;

                            console.log(loiluar_qty, hargaPerUnit, total)

                            $('#harga_per_unit' + id).closest('tr').find('.total').text(total);
                        });
                        setTimeout(function() {
                            toastr.success(data?.message || 'Berhasil menyimpan detail LOI Luar!');
                        }, 200);
                    } else {
                        $('#table-loi').empty();
                        $('#table-loi').append(
                            '<tr><td colspan="15" class="text-center">Tidak ada data</td></tr>');
                    }
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Gagal menyimpan detail LOI Luar!');
                    console.log(xhr.responseText);
                },
                complete: function() {
                    $('#table-loi').find('tr:contains("Loading...")').remove();
                }
            });
        });


        //detail qty
        // $(document).on('input', '.qty_nego1-input', function() {
        // var id = $(this).closest('tr').data('id'); // Ambil ID dari data-id di <tr>
        // var qty = $(this).val(); // Ambil nilai input qty2 yang baru
        $(document).on('click', '.btn-save', function() {
            var row = $(this).closest('tr'); // Ambil baris <tr> tempat tombol berada
            var id = row.data('id'); // Ambil ID dari data-id di <tr>
            var qty = row.find('.qty2-input').val();

            // Kirim data ke server untuk disimpan
            $.ajax({
                url: "{{ route('qty_loiluar_save') }}", // Ganti dengan URL yang sesuai
                type: "POST",
                data: {
                    id: id, // ID dari baris yang bersangkutan
                    qty_loiluar1: qty, // Kirim nilai qty2 yang baru
                    _token: '{{ csrf_token() }}' // CSRF token untuk keamanan
                },
                dataType: "json",
                beforeSend: function() {
                    // Tampilkan indikator loading jika perlu
                },
                success: function(response) {
                    // Berhasil, lakukan sesuatu (misalnya update tampilan tabel)
                    if (response.success) {
                        alert('Data berhasil disimpan!');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText); // Tangani error jika terjadi
                }
            });
        });
        //detail qty


        //action delete_loi
        $(document).on('click', '.btn-delete', function() {
            var id = $(this).data('id');
            var id_loiluar = $(this).data('id_loiluar');
            var id_detail_pr = $(this).data('id_detail_pr');
            var id_detail_loiluar = $(this).data('id_detail_loiluar');

            $.ajax({
                url: "{{ route('detail_loiluar_delete') }}",
                type: "DELETE",
                data: {
                    id: id,
                    id_loiluar: id_loiluar,
                    id_detail_pr: id_detail_pr,
                    id_detail_loiluar: id_detail_loiluar,
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                beforeSend: function() {
                    $('#table-loi').append(
                        '<tr><td colspan="15" class="text-center">Loading...</td></tr>');
                },
                success: function(data) {
                    if (data.loiluar.details.length > 0) {
                        $('#table-loi').empty();
                        $.each(data.loiluar.details, function(key, value) {
                            var id = value.id;
                            var id_loiluar = value.id_loiluar;
                            var loiluar_qty = value.loiluar_qty;
                            var id_detail_loiluar = value.id_detail_loiluar;
                            var id_detail_pr = value.id_detail_pr;

                            var harga_per_unit = value.harga_per_unit ?? 0;
                            var total = loiluar_qty * harga_per_unit;

                            $('#table-loi').append(
                                '<tr>' +
                                '<td>' + (key + 1) + '</td>' +
                                '<td>' + value.uraian + '</td>' +
                                '<td>' + value.spek + '</td>' +
                                '<td>' + value.loiluar_qty + '</td>' +
                                '<td>' + value.satuan + '</td>' +
                                '<td><input type="text" value="' + harga_per_unit +
                                '" class="form-control harga-per-unit" id="harga_per_unit' +
                                id +
                                '" name="harga_per_unit' + id + '" data-id="' + id +
                                '" data-qty="' + loiluar_qty + '"></td>' +
                                '<td class="total">' + total + '</td>' +
                                '<td>' +
                                '<button type="button" class="btn btn-danger btn-delete" data-id="' +
                                value.id + '" data-id_loiluar="' + value.id_loiluar +
                                '" data-id_detail_loiluar="' + id_detail_loiluar +
                                '" data-id_detail_pr="' + value.id_detail_pr + '">' +
                                '<i class="fas fa-trash"></i>' + // Ikon Hapus
                                '</button> ' +
                                '<button type="button" class="btn btn-success btn-save" data-id="' +
                                value.id + '" data-id_loiluar="' + value.id_loiluar +
                                '" data-id_detail_loiluar="' + id_detail_loiluar +
                                '" data-id_detail_pr="' + value.id_detail_pr + '">' +
                                '<i class="fas fa-save"></i>' + // Ikon Simpan
                                '</button>' +
                                '</td>' +
                                '</tr>'
                            );

                        });

                        // Event listener untuk menghitung total secara otomatis
                        $('.harga-per-unit').on('input', function() {
                            var id = $(this).data('id');
                            var loiluar_qty = $(this).data('qty');
                            var hargaPerUnit = $('#harga_per_unit' + id).val();
                            var total = loiluar_qty * hargaPerUnit;

                            $('#harga_per_unit' + id).closest('tr').find('.total').text(total);
                        });

                    } else {
                        $('#table-loi').empty();
                        $('#table-loi').append(
                            '<tr><td colspan="15" class="text-center">Tidak ada data</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                },
                complete: function() {
                    $('#table-loi').find('tr:contains("Loading...")').remove();
                }
            });
        });







        //Agar ketika klik simpan, dapat submit
        function setSaveIdAndSubmit() {
            // Submit the form
            var allFileNames = getAllFileNames();
            $('#nama_lampiran').val(allFileNames);
            // alert($('#nama_lampiran').val());
            // alert($('#lampiran_awal').val());
            document.getElementById('save').submit();
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





        //End Lihat Detail

        function detailSjn(data) {
            $('#modal-title').text("Edit LOI");
            $('#button-save').text("Simpan");
            resetForm();
            $('#save_id').val(data.loiluar_id);
            $('#no_sjn').val(data.no_sjn);
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

        function deleteloi(data) {
            $('#delete_id').val(data.id);
        }
    </script>
    @if (Session::has('success'))
        <script>
            toastr.success('{!! Session::get('success') !!}');
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            toastr.error('{!! Session::get('error') !!}');
        </script>
    @endif
    @if (!empty($errors->all()))
        <script>
            toastr.error('{!! implode('', $errors->all('<li>:message</li>')) !!}');
        </script>
    @endif
@endsection
