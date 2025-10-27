@extends('layouts.main')
@section('title', __('Purchase Order Luar Negeri'))
@section('custom-css')
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <style>
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
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-po"
                        onclick="addPo()"><i class="fas fa-plus"></i> Add New PO</button>
                    <div class="card-tools">
                        <form>
                            {{-- <div class="input-group input-group">
                                <input type="text" class="form-control" name="q" placeholder="Search">
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

                        {{-- Filter by Nomor Po dan Tanggal --}}
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="filter-po-no">Filter Nomor PO</label>
                                    <input type="text" class="form-control" id="filter-po-no"
                                        placeholder="Masukkan Nomor PO">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="filter-po-date">Filter Tanggal PO</label>
                                    <input type="date" class="form-control" id="filter-po-date">
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
                                    <th>{{ __('No PO') }}</th>
                                    {{-- <th>{{ __('No PR') }}</th> --}}
                                    <th>{{ __('Proyek') }}</th>
                                    <th>{{ __('Vendor') }}</th>
                                    <th>{{ __('Tanggal PO') }}</th>
                                    <th>{{ __('Batas Akhir PO') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($purchaseluars) > 0)
                                    @foreach ($purchaseluars as $key => $d)
                                        @php
                                            $data = [
                                                'id' => $d->id,
                                                'no' => $purchaseluars->firstItem() + $key,
                                                'vid' => $d->vendor_id,
                                                'nama_vendor' => $d->vendor_name,
                                                'no_poluar' => $d->no_poluar,
                                                'proyek_id' => $d->proyek_id,
                                                'pr_id' => $d->pr_id,
                                                'tgpo' => date('d/m/Y', strtotime($d->tanggal_poluar)),
                                                'reference' => $d->reference,
                                                'rfq' => $d->rfq,
                                                'quotation' => $d->quotation,
                                                'no_nego' => $d->no_nego,
                                                'final_quotation' => $d->final_quotation,
                                                'btpo' => date('d/m/Y', strtotime($d->batas_poluar)),
                                                'keterangan_nama' => $d->keterangan_nama,
                                                'signature_imss' => $d->signature_imss,
                                                'signature_vendor' => $d->signature_vendor,
                                                'keterangan_shipment' => $d->keterangan_shipment,
                                                'keterangan_payment' => $d->keterangan_payment,
                                                'delivery' => $d->delivery,
                                                'shipment' => $d->shipment,
                                                'delivery_term' => $d->delivery_term,
                                                'destination' => $d->destination,
                                                'payment' => $d->payment,




                                                'nama_proyek' => $d->proyek_name,
                                                
                                                
                                                
                                                
                                                'pr_no' => $d->pr_no,
                                                
                                                
                                                
                                                
                                                'vendor_id' => $d->vendor_id,
                                                'detail' => $d->detail,
                                                
                                                'pr_no' => $d->pr_no,
                                            ];
                                        @endphp
                                        <tr>
                                            <td class="text-center"><input type="checkbox" name="hapus[]"
                                                    value="{{ $d->id }}"></td>
                                            <td class="text-center">{{ $data['no'] }}</td>
                                            <td>{{ $data['no_poluar'] }}</td>
                                            {{-- <td>{{ $data['pr_no'] }}</td> --}}
                                            <td class="text-center">{{ $data['nama_proyek'] }}</td>
                                            <td class="text-center">{{ $data['nama_vendor'] }}</td>
                                            <td class="text-center">{{ $data['tgpo'] }}</td>
                                            <td class="text-center">{{ $data['btpo'] }}</td>
                                            <td class="text-center">
                                                <button title="Edit PO" type="button" class="btn btn-success btn-xs"
                                                    data-toggle="modal" data-target="#add-po"
                                                    onclick="editPo({{ json_encode($data) }})"><i
                                                        class="fas fa-edit"></i></button>

                                                <button title="Lihat Detail" type="button" data-toggle="modal"
                                                    data-target="#detail-po" class="btn-lihat btn btn-info btn-xs"
                                                    data-detail="{{ json_encode($data) }}"><i
                                                        class="fas fa-list"></i></button>

                                                @if ((Auth::user() && Auth::user()->role == 0) || Auth::user()->role == 1)
                                                    <button title="Hapus PO" type="button" class="btn btn-danger btn-xs"
                                                        data-toggle="modal" data-target="#delete-po"
                                                        onclick="deletePo({{ json_encode($data) }})"><i
                                                            class="fas fa-trash"></i></button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="text-center">
                                        <td colspan="7">{{ __('No data.') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-danger" id="delete-selected"
                            data-token="{{ csrf_token() }}">Hapus yang dipilih</button>
                    </div>
                </div>
            </div>
            <div>
                {{ $purchaseluars->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </section>

    {{-- modal tambah --}}
    <div class="modal fade" id="add-po">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title">{{ __('Add New PO') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="save" action="{{ route('purchase_orderluar.store') }}" method="post">
                        @csrf
                        <input type="hidden" id="save_id" name="id">
                        <input type="hidden" id="pr_id" name="pr_id">
                        <div class="form-group row">
                            <label for="no_poluar" class="col-sm-4 col-form-label">{{ __('Nomor PO') }} </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="no_poluar" name="no_poluar">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nomor_pr" class="col-sm-4 col-form-label">{{ __('Nomor PR') }} </label>
                            <div class="col-sm-8">
                                <select class="form-control" name="nomor_pr[]" id="nomor_pr">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="vendor_id" class="col-sm-4 col-form-label">{{ __('Vendor') }} </label>
                            <div class="col-sm-8">
                                {{-- <input type="text" class="form-control" id="vendor_id" name="vendor_id"> --}}
                                <select class="form-control" id="vendor_id" name="vendor_id">
                                    <option value="">Pilih Vendor</option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="proyek_id" class="col-sm-4 col-form-label">{{ __('Project') }} </label>
                            <div class="col-sm-8">
                                <input type="hidden" id="proyeks" name="proyeks">
                                <select class="form-select" name="proyek_id[]" id="proyek_id" multiple>
                                    {{-- <option>Pilih Proyek</option> --}}
                                    @foreach ($proyeks as $proyek)
                                        <option value="{{ $proyek->id }}">{{ $proyek->nama_pekerjaan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tanggal_poluar" class="col-sm-4 col-form-label w-50">{{ __('Date PO') }} </label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control w-50" id="tanggal_poluar" name="tanggal_poluar">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="reference" class="col-sm-4 col-form-label">{{ __('Reference') }} </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="reference" name="reference">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="rfq" class="col-sm-4 col-form-label">{{ __('RFQ') }} </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="rfq" name="rfq">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="quotation" class="col-sm-4 col-form-label">{{ __('Quotation') }} </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="quotation" name="quotation">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="no_nego" class="col-sm-4 col-form-label">{{ __('No Nego') }} </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="no_nego" name="no_nego">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="final_quotation" class="col-sm-4 col-form-label">{{ __('Final Quotation') }} </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="final_quotation" name="final_quotation">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="batas_poluar" class="col-sm-4 col-form-label">{{ __('Deadline PO') }} </label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control w-50" id="batas_poluar" name="batas_poluar">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="keterangan_nama"
                                class="col-sm-4 col-form-label">{{ __('Name of leader, position and company address') }}</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="keterangan_nama" name="keterangan_nama" rows="4"
                                    placeholder="contoh penulisan                            Delivery:2(dua) minggu setelah PO setelah itu enter untuk nomor selanjutnya"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="signature_imss" class="col-sm-4 col-form-label">{{ __('Signature PT IMSS') }} </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="signature_imss" name="signature_imss">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="signature_vendor" class="col-sm-4 col-form-label">{{ __('Signature Vendor') }} </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="signature_vendor" name="signature_vendor">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="keterangan_shipment"
                                class="col-sm-4 col-form-label">{{ __('Shipment Information') }}</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="keterangan_shipment" name="keterangan_shipment" rows="4"
                                    placeholder="contoh penulisan                            Delivery:2(dua) minggu setelah PO setelah itu enter untuk nomor selanjutnya"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="keterangan_payment"
                                class="col-sm-4 col-form-label">{{ __('Payment Information') }}</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="keterangan_payment" name="keterangan_payment" rows="4"
                                    placeholder="contoh penulisan                            Delivery:2(dua) minggu setelah PO setelah itu enter untuk nomor selanjutnya"></textarea>
                            </div>
                        </div>
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        


                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button id="button-save" type="button" class="btn btn-primary"
                        onclick="document.getElementById('save').submit();">{{ __('Tambahkan') }}</button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal detail --}}
    <div class="modal fade" id="detail-po">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title">{{ __('Detail Purchase Order') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12" id="container-form">
                                <form id="cetak-po" method="GET" action="{{ route('cetak_poluar') }}" target="_blank">
                                    <input type="hidden" name="id_poluar" id="id_poluar">
                                    
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
                                <button id="button-cetak-po" type="button" class="btn btn-primary"
                                    onclick="document.getElementById(
                                        'cetak-po').submit();">{{ __('Cetak') }}</button>
                                <table class="align-top w-100">
                                    <tr>
                                        <td style="width: 8%;"><b>ID PR</b></td>
                                        <td style="width:2%">:</td>
                                        <td style="width: 55%"><span id="pr_id2"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 8%;"><b>No Surat</b></td>
                                        <td style="width:2%">:</td>
                                        <td style="width: 55%"><span id="po_no"></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>Proyek</b></td>
                                        <td>:</td>
                                        <td><span id="id_proyek"></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>Vendor</b></td>
                                        <td>:</td>
                                        <td><span id="id_vendor"></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>Tanggal PO</b></td>
                                        <td>:</td>
                                        <td><span id="po_tanggal"></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>Batas PO</b></td>
                                        <td>:</td>
                                        <td><span id="po_batas"></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>Detail</b></td>
                                        <input type="hidden" name="id" id="id">
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <button id="button-tambah-detail" type="button"
                                                class="btn btn-info">{{ __('Tambah Item Detail') }}</button>
                                        </td>
                                    </tr>
                                </table>
                                <div class="table-responsive mt-2">
                                    <table class="table table-bordered">
                                        <thead>
                                            <th>Item</th>
                                            <th>Kode Material</th>
                                            <th>Deskripsi</th>
                                            <th>Batas Akhir Diterima</th>
                                            <th>Kuantitas</th>
                                            <th>Unit</th>
                                            <th>Harga Per Unit</th>
                                            <th>Mata Uang</th>
                                            <th>Vat</th>
                                            <th>Total</th>
                                            <th>Aksi</th>
                                        </thead>

                                        <tbody id="tabel-po">
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-0 d-none" id="container-product">
                                <div id="form" class="card">
                                    <div class="card-body">
                                        <!-- <button type="button" class="btn btn-primary mb-3"
                                                    onclick="addToDetails()"></i>Tambah Pilihan</button> -->
                                        <button id="btn-save-then-add" type="button" class="btn btn-primary mb-3">Tambah
                                            Pilihan</button>


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
                                                    <th>Pilih</th>
                                                    <th>No</th>
                                                    <th>Deskripsi</th>
                                                    <th>Spesifikasi</th>
                                                    <th>QTY</th>
                                                    <th>QTY</th>
                                                    <th>Sat</th>
                                                    <th>No PR</th>
                                                    <th>No SPPH</th>
                                                    <th>No PO</th>
                                                    <th>Proyek</th>
                                                </tr>
                                            </thead>
                                            <tbody id='detail-material'>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                {{-- <div class="card">
                                    <div class="card-body">
                                        <div class="input-group input-group-lg">
                                            <input type="text" class="form-control" id="pcode" name="pcode"
                                                min="0" placeholder="Product Code">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" id="button-check"
                                                    onclick="productCheck()">
                                                    <i class="fas fa-add"></i>
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
                                {{-- <div id="form" class="card">
                                    <div class="card-body">
                                        <form role="form" id="material-update" method="post">
                                            @csrf
                                            <input type="hidden" id="pid" name="pid">
                                            <input type="hidden" id="type" name="type">
                                            <div class="form-group row">
                                                <label for="deskripsi"
                                                    class="col-sm-4 col-form-label">{{ __('Deskripsi Barang') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="deskripsi"
                                                        name="deskripsi">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="batas"
                                                    class="col-sm-4 col-form-label">{{ __('Batas Akhir Diterima') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control" id="batas"
                                                        name="batas">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="qty"
                                                    class="col-sm-4 col-form-label">{{ __('Kuantitas') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="qty"
                                                        name="qty">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="unit"
                                                    class="col-sm-4 col-form-label">{{ __('Unit') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="unit"
                                                        name="unit">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="hunit"
                                                    class="col-sm-4 col-form-label">{{ __('Harga Per Unit') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="hunit"
                                                        name="hunit">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="mata-uang"
                                                    class="col-sm-4 col-form-label">{{ __('Mata Uang') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="mata-uang"
                                                        name="mata-uang">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="vat"
                                                    class="col-sm-4 col-form-label">{{ __('VAT') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="vat"
                                                        name="vat">
                                                </div>
                                            </div>
                                        </form>
                                        <button id="button-update-sjn" type="button" class="btn btn-primary w-100"
                                            onclick="PoUpdate()">{{ __('Tambahkan') }}</button>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal delete --}}
    <div class="modal fade" id="delete-po">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title">{{ __('Delete PO') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="delete" action="{{ route('purchase_orderluar.destroy') }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="hidden" id="delete_id" name="id">
                    </form>
                    <div>
                        <p>Anda yakin ingin menghapus purchase order <span id="pcode"
                                class="font-weight-bold"></span>?
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

@endsection
@section('custom-js')
    <script src="/plugins/toastr/toastr.min.js"></script>
    <script src="/plugins/select2/js/select2.full.min.js"></script>

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
                    url: 'poluar-imss/hapus-multiple',
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

        var selectedDataProyek = [];

        //Filter by Nomor dan tgl PO
        $(document).ready(function() {
            //init multiselect
            // sessionStorage.removeItem('proyek_id');

            // var dataProyekId = JSON.parse(sessionStorage.getItem('proyek_id'));


            $("#proyek_id").val('').trigger('change')

            $('#proyek_id').select2({
                multiple: true,
                theme: "bootstrap-5",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                placeholder: "Pilih Proyek",
                closeOnSelect: false,
            }).on('select2:select', function(e) {
                // var carValue = $("#proyek_id").val();
                var tsValue = e.params.data.id;

                // Jika 'Pilih Semua' dipilih, tambahkan nilai ts sebanyak jumlah koma dalam id
                // if (e.params.data.text === 'Pilih Semua') {
                //     var numberOfCommas = e.params.data.id.split(',').length;
                //     for (var i = 0; i < numberOfCommas; i++) {
                //         trainsetValues.push(tsValue);
                //     }
                // } else {
                selectedDataProyek.push(tsValue);
                // }
                console.log(selectedDataProyek)
                $('#proyeks').val(selectedDataProyek);

                // $("#car3").val(carValue);
                // $("#trainset_kode3").val(trainsetValues);
            })

            

            $('#clear-filter').on('click', function() {
                $('#filter-po-no, #filter-po-date').val('');
                filterTable();
            });

            $('#filter-po-no, #filter-po-date').on('keyup change', function() {
                filterTable();
            });

            function filterTable() {
                var filterNoPO = $('#filter-po-no').val().toUpperCase();
                var filterDatePO = $('#filter-po-date').val();

                $('table tbody tr').each(function() {
                    var noPO = $(this).find('td:nth-child(3)').text().toUpperCase();
                    var datePO = $(this).find('td:nth-child(6)').text();
                    var id = $(this).find('td:nth-child(1)')
                        .text(); // Ubah indeks kolom ke indeks ID PO jika perlu

                    // Ubah string tanggal ke objek Date untuk perbandingan
                    var dateParts = datePO.split("/");
                    var poDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[
                        0]); // Format: tahun, bulan, tanggal

                    // Ubah string filterDatePO ke objek Date
                    var filterDateParts = filterDatePO.split("-");
                    var filterPODate = new Date(filterDateParts[0], filterDateParts[1] - 1, filterDateParts[
                        2]); // Format: tahun, bulan, tanggal

                    if ((noPO.indexOf(filterNoPO) > -1 || filterNoPO === '') &&
                        (poDate.getTime() === filterPODate.getTime() || filterDatePO === '')) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }



            let selectedDataArray = []; // Array untuk menyimpan ID yang dipilih

            $("#nomor_pr").select2({
                placeholder: 'Pilih Tempat',
                width: '100%',
                data: [{
                    id: 'all',
                    text: 'Semua'
                }],
                multiple: true, // Menambahkan properti multiple untuk mendukung banyak pilihan
                ajax: {
                    url: "{{ route('nopr.index') }}",
                    processResults: function({
                        data
                    }) {
                        // Menggabungkan opsi "Semua" dengan data dari database
                        let results = $.map(data, function(item) {
                            return {
                                id: item.id,
                                ids: item.id, // ID sebenarnya
                                text: item.no_pr // Teks untuk dropdown
                            };
                        });
                        return {
                            results: results
                        };
                    }
                }
            });

            // Saat opsi dipilih
            $('#nomor_pr').on('select2:select', function(e) {
                let selectedData = e.params.data;

                // Tambahkan ID ke array jika belum ada
                if (!selectedDataArray.includes(selectedData.ids)) {
                    selectedDataArray.push(selectedData.ids);
                }

                // Update input tersembunyi dengan string ID dipisahkan koma
                $("#pr_id").val(selectedDataArray.join(','));
                console.log("Selected IDs (String):", selectedDataArray.join(','));
            });

            // Saat opsi batal dipilih
            $('#nomor_pr').on('select2:unselect', function(e) {
                let unselectedData = e.params.data;

                // Hapus ID dari array
                selectedDataArray = selectedDataArray.filter(id => id !== unselectedData.ids);

                // Update input tersembunyi dengan string ID dipisahkan koma
                $("#pr_id").val(selectedDataArray.join(','));
                console.log("Updated Selected IDs (String):", selectedDataArray.join(','));
            });

        });
        //End Filter by Nomor dan tgl PO




        function resetForm() {
            $('#save').trigger("reset");
            //remove the selected select option all
            $('#vendor_id').find('option').each(function() {
                $(this).attr('selected', false);
            });
            $('#pr_id').find('option').each(function() {
                $(this).attr('selected', false);
            });
            $('#proyek_id').find('option').each(function() {
                $(this).attr('selected', false);
            });
            $('#barcode_preview_container').hide();
        }

        function addPo() {
            $('#modal-title').text("Add Purchase Order");
            $('#button-save').text("Tambahkan");
            resetForm();
        }


        function loader(status = 1) {
            if (status == 1) {
                $('#loader').show();
            } else {
                $('#loader').hide();
            }
        }

        function emptyTablePo() {
            $('#tabel-po').empty();
            $('#po_tanggal').text("");
            $('#po_batas').text("");
            $('#po_no').text("");
            $('#id_proyek').text("");
            $('#id_vendor').text("");

        }

        function editPo(data) {
            console.log(data);
            $('#modal-title').text("Edit PO");
            $('#button-save').text("Simpan");
            resetForm();
            $('#save_id').val(data.id);
            $('#no_poluar').val(data.no_poluar);
            $('#vendor_id').val(data.vendor_id);
            $('#vendor_id').find('option').each(function() {
                if ($(this).val() == data.vid) {
                    console.log($(this).val());
                    $(this).attr('selected', true);
                } else {
                    $(this).attr('selected', false);
                }
            });
            var date = data.tgpo.split('/');
            var newDate = date[2] + '-' + date[1] + '-' + date[0];
            $('#tanggal_poluar').val(newDate);
            var date = data.btpo.split('/');
            var newDate = date[2] + '-' + date[1] + '-' + date[0];
            $('#batas_poluar').val(newDate);
           
            $('#pr_id').find('option').each(function() {
                if ($(this).val() == data.pr_id) {
                    console.log('pr', $(this).val());
                    $(this).attr('selected', true);
                } else {
                    $(this).attr('selected', false);
                }
            });
            $('#reference').val(data.reference);
            $('#rfq').val(data.rfq);
            $('#quotation').val(data.quotation);
            $('#no_nego').val(data.no_nego);
            $('#final_quotation').val(data.final_quotation);
            $('#keterangan_nama').val(data.keterangan_nama);
            $('#signature_imss').val(data.signature_imss);
            $('#signature_vendor').val(data.signature_vendor);
            $('#keterangan_shipment').val(data.keterangan_shipment);
            $('#keterangan_payment').val(data.keterangan_payment);
            $('#delivery').val(data.delivery);
            $('#shipment').val(data.shipment);
            $('#delivery_term').val(data.delivery_term);
            $('#destination').val(data.destination);
            $('#payment').val(data.payment);



            
            // $('#proyek_id').find('option').each(function() {
            //     if ($(this).val() == data.proyek_id) {
            //         console.log('proyek', $(this).val());
            //         $(this).attr('selected', true);
            //     } else {
            //         $(this).attr('selected', false);
            //     }
            // });
            const valProyeks = data.proyek_id
            const split = valProyeks.split(',')
            split.forEach(function(item) {
                selectedDataProyek.push(item)
            })
            $("#proyek_id").val(split).change();
            


            // Ambil `no_pr` berdasarkan `pr_id` dari database
            $.ajax({
                url: "{{ route('nopr.getByIdspo') }}", // Pastikan route ini dibuat di backend untuk mengembalikan daftar no_pr
                type: "GET",
                data: {
                    pr_ids: data.pr_id
                },
                success: function(response) {
                    let prOptions = response.map(item => ({
                        id: item.id,
                        text: item.no_pr
                    }));

                    $('#nomor_pr').empty().select2({
                        placeholder: 'Pilih Nomor PR',
                        width: '100%',
                        multiple: true,
                        data: prOptions,
                        ajax: {
                            url: "{{ route('nopr.index') }}",
                            processResults: function({
                                data
                            }) {
                                return {
                                    results: $.map(data, function(item) {
                                        return {
                                            id: item.id,
                                            text: item.no_pr
                                        };
                                    })
                                };
                            }
                        }
                    });

                    // Set nilai yang sudah dipilih
                    let selectedIds = prOptions.map(item => item.id);
                    $('#nomor_pr').val(selectedIds).trigger('change');

                    // Simpan ke dalam array
                    selectedDataArray = [...selectedIds];
                    $("#pr_id").val(selectedDataArray.join(','));
                },
                error: function(xhr) {
                    console.log("Gagal mengambil data PR", xhr);
                }
            });



        }






        $('#detail-po').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var data = button.data('detail');
            console.log('d', data);
            lihatPo(data);
        });



        function lihatPo(data) {
            console.log('PRRRR', data.pr_id)
            emptyTablePo();
            const pr = data.pr_id.split(',').map(item => item.trim());
            $('modal-title').text("Detail PO");
            $('#button-save').text("Simpan");
            resetForm();
            // $('#pr_id2').text(data.pr_id);
            $('#pr_id2').text(data.pr_no);
            $('#button-tambah-detail').val(data.pr_id);
            $('#button-tambah-detail').attr('onclick', `showAddItem(${data.pr_id}); getPODetail(${JSON.stringify(pr)});`);
            $('#po_no').text(data.no_poluar);
            $('#id_proyek').text(data.proyek_name);
            $('#id_vendor').text(data.vendor_name);
            $('#po_tanggal').text(data.tgpo);
            $('#po_batas').text(data.btpo);
            $('#tabel-po').empty();
            console.log(data);

            $.ajax({
                url: "{{ url('products/purchase_orderluar_detail') }}" + "/" + data.id,
                type: "GET",
                data: {
                    id: data.id
                },
                dataType: "json",
                beforeSend: function() {
                    $('#tabel-po').append('<tr><td colspan="12" class="text-center">Loading...</td></tr>');
                    $('#button-cetak-po').html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                    );
                    $('#button-cetak-po').attr('disabled', true);
                },

                success: function(data) {
                    console.log('f', data);
                    $('#no_poluar').text(data.poluar.no_poluar);
                    $('#id_proyek').text(data.poluar.nama_proyek);
                    $('#id_vendor').text(data.poluar.nama_vendor);
                    $('#po_tanggal').text(data.poluar.tgpo);
                    $('#po_batas').text(data.poluar.btpo);
                    $('#id_poluar').val(data.poluar.id);
                    $('#button-cetak-po').html('<i class="fas fa-print"></i> Cetak');
                    $('#button-cetak-po').attr('disabled', false);
                    var no = 1;
                    var id_poluar = data.poluar.id;

                    if (data?.poluar?.details?.length == 0) {
                        $('#tabel-po').append(
                            '<tr><td colspan="11" class="text-center">Tidak ada data</td></tr>');
                    } else {
                        $.each(data?.poluar?.details, function(index, value) {
                            var id = value.id_detail_poluar;
                            var id_detail_pr = value.id
                            var kode_material = value.kode_material;
                            var deskripsi = value.uraian;
                            var batas = value.batas ?? '-';
                            var date = value.batas_poluar?.split('/') ?? '-';
                            // var newDate = date[2] + '/' + date[1] + '/' + date[0];
                            var newDate = batas;
                            var poluar_qty = value.poluar_qty;
                            // var total = value.qty * value.harga_per_unit ?? 0;
                            var satuan = value.satuan;
                            var harga_per_unit = value.harga_per_unit ?? 0;
                            var mata_uang = value.mata_uang ?? '-';
                            var vat = value.vat ?? '-';
                            var total = poluar_qty * harga_per_unit;
                            console.log({
                                kode_material,
                                deskripsi,
                                batas,
                                newDate,
                                poluar_qty,
                                total,
                                vat,
                                satuan,
                                harga_per_unit,
                                mata_uang,
                                id_detail_pr,
                            })
                            var html = '<tr>' +
                                '<td>' + no + '</td>' +
                                '<td>' + kode_material + '</td>' +
                                '<td>' + deskripsi + '</td>' +
                                '<td><input type="date" value="' + newDate +
                                '" class="form-control" id="batas' + id + '" name="batas' + id +
                                '"></td>' +
                                '<td>' + poluar_qty + '</td>' +
                                '<td>' + satuan + '</td>' +
                                '<td><input type="text" value="' + harga_per_unit +
                                '" class="form-control" id="harga_per_unit' + id +
                                '" name="harga_per_unit' + id + '"></td>' +
                                '<td><input type="text" value="' + mata_uang +
                                '" class="form-control" id="mata_uang' + id + '" name="mata_uang' + id +
                                '"></td>' +
                                '<td><input type="text" value="' + vat +
                                '" class="form-control" id="vat' + id + '" name="vat' + id + '"></td>' +
                                '<td>' + total + '</td>' +
                                '<td><button title="simpan" id="edit_poluar_save" type="button" class="btn btn-success btn-xs" data-id="' +
                                id + '" data-idpoluar="' + id_poluar + '" ><i class="fas fa-save"></i>' +
                                '</button>' +
                                '<button title="hapus" id="delete_poluar_save" type="button" class="btn btn-danger btn-xs" data-id="' +
                                id +
                                '" data-idpoluar="' + id_poluar + '" data-id_detail_pr="' + id_detail_pr +
                                '" ><i class="fas fa-trash"></i>' +
                                '</button>' +
                                '</tr>';
                            $('#tabel-po').append(html);
                            no++;
                        });
                    }
                    //remove loading
                    $('#tabel-po').find('tr:first').remove();
                }
            })

        }

        // Fungsi helper untuk render tabel data
        function renderTableData(details, id_poluar) {
            var no = 1;
            if (details.length == 0) {
                $('#tabel-po').append(
                    '<tr><td colspan="11" class="text-center">Tidak ada data</td></tr>');
            } else {
                $.each(details, function(index, value) {
                    var id = value.id_detail_poluar;
                    var id_detail_pr = value.id
                    var kode_material = value.kode_material;
                    var deskripsi = value.uraian;
                    var batas = value.batas ?? '-';
                    var newDate = batas;
                    var poluar_qty = value.poluar_qty;
                    var satuan = value.satuan;
                    var harga_per_unit = value.harga_per_unit ?? 0;
                    var mata_uang = value.mata_uang ?? '-';
                    var vat = value.vat ?? '-';
                    var total = poluar_qty * harga_per_unit;
                    
                    var html = '<tr>' +
                        '<td>' + no + '</td>' +
                        '<td>' + kode_material + '</td>' +
                        '<td>' + deskripsi + '</td>' +
                        '<td><input type="date" value="' + newDate +
                        '" class="form-control" id="batas' + id + '" name="batas' + id +
                        '"></td>' +
                        '<td>' + poluar_qty + '</td>' +
                        '<td>' + satuan + '</td>' +
                        '<td><input type="text" value="' + harga_per_unit +
                        '" class="form-control" id="harga_per_unit' + id +
                        '" name="harga_per_unit' + id + '"></td>' +
                        '<td><input type="text" value="' + mata_uang +
                        '" class="form-control" id="mata_uang' + id + '" name="mata_uang' + id +
                        '"></td>' +
                        '<td><input type="text" value="' + vat +
                        '" class="form-control" id="vat' + id + '" name="vat' + id +
                        '"></td>' +
                        '<td>' + total + '</td>' +
                        '<td><button title="simpan" id="edit_poluar_save" type="button" class="btn btn-success btn-xs" data-id="' +
                        id + '" data-idpoluar="' + id_poluar +
                        '" ><i class="fas fa-save"></i>' +
                        '</button>' +
                        '<button title="hapus" id="delete_poluar_save" type="button" class="btn btn-danger btn-xs" data-id="' +
                        id +
                        '" data-idpoluar="' + id_poluar + '" data-id_detail_pr="' +
                        id_detail_pr + '" ><i class="fas fa-trash"></i>' +
                        '</button>' +
                        '</tr>';
                    $('#tabel-po').append(html);
                    no++;
                });
            }
        }

        //action edit_poluar_save
        $(document).on('click', '#edit_poluar_save', function() {
            var id = $(this).data('id');
            var id_poluar = $('#id_poluar').val(); // Ambil dari input hidden agar tidak null
            var batas = $('#batas' + id).val();
            var harga_per_unit = $('#harga_per_unit' + id).val();
            var mata_uang = $('#mata_uang' + id).val();
            var vat = $('#vat' + id).val();

            // Validasi sebelum AJAX
            if (!id_poluar || isNaN(parseInt(id_poluar))) {
                toastr.error('ID PO Luar tidak boleh kosong!');
                return;
            }
            if (!batas) {
                toastr.error('Batas akhir wajib diisi!');
                return;
            }
            if (!harga_per_unit || isNaN(parseFloat(harga_per_unit))) {
                toastr.error('Harga per unit wajib diisi dan harus angka!');
                return;
            }
            if (!mata_uang) {
                toastr.error('Mata uang wajib diisi!');
                return;
            }
            if (!vat) {
                toastr.error('VAT wajib diisi!');
                return;
            }

            $('#tabel-po').empty();

            //ajax post to products/detail_pr_save

            $.ajax({
                url: "{{ route('detail_poluar_save') }}",
                type: "POST",
                data: {
                    id,
                    id_poluar,
                    batas,
                    harga_per_unit,
                    mata_uang,
                    vat,
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                beforeSend: function() {
                    $('#tabel-po').append(
                        '<tr><td colspan="11" class="text-center">Loading...</td></tr>');
                    $('#button-cetak-po').html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                    );
                    $('#button-cetak-po').attr('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    $('#no_poluar').text(data.poluar.no_poluar);
                    $('#id_proyek').text(data.poluar.nama_proyek);
                    $('#id_vendor').text(data.poluar.nama_vendor);
                    $('#po_tanggal').text(data.poluar.tgpo);
                    $('#po_batas').text(data.poluar.btpo);
                    $('#id_poluar').val(data.poluar.id);
                    $('#button-cetak-po').html('<i class="fas fa-print"></i> Cetak');
                    $('#button-cetak-po').attr('disabled', false);
                    var id_poluar = data.poluar.id;

                    // Cek apakah data details ada dan valid
                    if (data?.poluar?.details && data.poluar.details.length > 0) {
                        renderTableData(data.poluar.details, id_poluar);
                    } else if (data?.poluar?.details == null || data?.poluar?.details == undefined) {
                        // Fallback: jika data detail kosong/null, ambil ulang dari server
                        $.ajax({
                            url: "{{ url('products/purchase_orderluar_detail') }}" + "/" + id_poluar,
                            type: "GET",
                            dataType: "json",
                            success: function(fallbackData) {
                                if (fallbackData?.poluar?.details && fallbackData.poluar.details.length > 0) {
                                    // Render ulang dengan data dari fallback
                                    renderTableData(fallbackData.poluar.details, id_poluar);
                                } else {
                                    $('#tabel-po').append(
                                        '<tr><td colspan="11" class="text-center">Tidak ada data</td></tr>');
                                }
                            },
                            error: function() {
                                $('#tabel-po').append(
                                    '<tr><td colspan="11" class="text-center">Tidak ada data</td></tr>');
                            }
                        });
                    } else {
                        $('#tabel-po').append(
                            '<tr><td colspan="11" class="text-center">Tidak ada data</td></tr>');
                    }
                    //remove loading
                    $('#tabel-po').find('tr:first').remove();
                    setTimeout(function() {
                        toastr.success('Berhasil menyimpan detail Purchase Order Luar!');
                    }, 200);
                },
                error: function(xhr) {
                    // Tampilkan pesan error validasi dari backend jika ada
                    if(xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors){
                        var msg = Object.values(xhr.responseJSON.errors).map(function(e){return e.join('<br>')}).join('<br>');
                        toastr.error(msg);
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Gagal menyimpan detail Purchase Order Luar!');
                    }
                }
            })

        });



        //action delete_poluar_save
        $(document).on('click', '#delete_poluar_save', function() {
            var id = $(this).data('id');
            var id_poluar = $('#id_poluar').val(); // Ambil dari input hidden agar tidak null
            var id_detail_pr = $(this).data('id_detail_pr');
            //get the batas{id} input
            var batas = $('#batas' + id).val();
            var harga_per_unit = $('#harga_per_unit' + id).val();
            var mata_uang = $('#mata_uang' + id).val();
            var vat = $('#vat' + id).val();

            // Validasi sebelum AJAX
            if (!id_poluar || isNaN(parseInt(id_poluar))) {
                toastr.error('ID PO Luar tidak boleh kosong!');
                return;
            }

            $('#tabel-po').empty();

            $.ajax({
                url: "{{ route('detail_poluar_delete') }}",
                type: "DELETE",
                data: {
                    id,
                    id_poluar,
                    batas,
                    harga_per_unit,
                    mata_uang,
                    vat,
                    id_detail_pr,
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                beforeSend: function() {
                    $('#tabel-po').append(
                        '<tr><td colspan="11" class="text-center">Loading...</td></tr>');
                    $('#button-cetak-po').html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                    );
                    $('#button-cetak-po').attr('disabled', true);
                },
                success: function(data) {
                    console.log(data);
                    // $('#no_po').text(data.po.no_po);
                    // $('#id_proyek').text(data.po.nama_proyek);
                    // $('#id_vendor').text(data.po.nama_vendor);
                    // $('#po_tanggal').text(data.po.tgpo);
                    // $('#po_batas').text(data.po.btpo);
                    // $('#id_po').val(data.po.id);
                    $('#button-cetak-po').html('<i class="fas fa-print"></i> Cetak');
                    $('#button-cetak-po').attr('disabled', false);
                    $('#detail-po').find('#container-product').addClass('d-none');
                    $('#detail-po').find('#container-product').removeClass('col-5');
                    $('#detail-po').find('#container-form').addClass('col-12');
                    $('#detail-po').find('#container-form').removeClass('col-7');
                    $('#button-tambah-detail').text('Tambah Item Detail');
                    var no = 1;
                    // var id_po = data.po.id;

                    if (data?.poluar?.details && data.poluar.details.length > 0) {
                        renderTableData(data.poluar.details, id_poluar);
                    } else {
                        $('#tabel-po').append(
                            '<tr><td colspan="11" class="text-center">Tidak ada data</td></tr>');
                    }
                    //remove loading
                    $('#tabel-po').find('tr:first').remove();
                    setTimeout(function() {
                        toastr.success('Berhasil menghapus detail Purchase Order Luar!');
                    }, 200);
                },
                error: function(xhr) {
                    // Tampilkan pesan error validasi dari backend jika ada
                    if(xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors){
                        var msg = Object.values(xhr.responseJSON.errors).map(function(e){return e.join('<br>')}).join('<br>');
                        toastr.error(msg);
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Gagal menghapus detail Purchase Order Luar!');
                    }
                }
            })

        });

        $('#detail-po').on('hidden.bs.modal', function() {
            $('#container-product').addClass('d-none');
            $('#container-product').removeClass('col-4');
            $('#container-form').addClass('col-12');
            $('#container-form').removeClass('col-8');
            $('#button-tambah-detail').text('Tambah Item Detail');
        });

        function showAddItem(pr_id) {
            //detect #detail-po where id container-product has class d-none
            if ($('#detail-po').find('#container-product').hasClass('d-none')) {
                $('#detail-po').find('#container-product').removeClass('d-none');
                $('#detail-po').find('#container-product').addClass('col-5');
                $('#detail-po').find('#container-form').removeClass('col-12');
                $('#detail-po').find('#container-form').addClass('col-7');
                $('#button-tambah-detail').text('Kembali');
            } else {
                $('#detail-po').find('#container-product').addClass('d-none');
                $('#detail-po').find('#container-product').removeClass('col-5');
                $('#detail-po').find('#container-form').addClass('col-12');
                $('#detail-po').find('#container-form').removeClass('col-7');
                $('#button-tambah-detail').text('Tambah Item Detail');
                $('#proyek_name').val("");
            }

            // getPODetail();
        }

        // function getPODetail() {

        //     loader();
        //     $('#button-check').prop("disabled", true);
        //     $.ajax({
        //         url: "{{ url('products/products_pr') }}",
        //         type: "GET",
        //         data: {
        //             "format": "json"
        //         },
        //         dataType: "json",
        //         beforeSend: function() {
        //             $('#loader').show();
        //             $('#form').hide();
        //         },
        //         success: function(data) {
        //             loader(0);
        //             $('#form').show();
        //             //append to #detail-material
        //             $('#detail-material').empty();
        //             $.each(data.products, function(key, value) {
        //                 console.table('a', value)
        //                 var no_spph
        //                 if (!value.id_spph) {
        //                     no_spph = '-'
        //                 } else {
        //                     no_spph = value.nomor_spph
        //                 }

        //                 var no_pr
        //                 if (!value.id_pr) {
        //                     no_pr = '-'
        //                 } else {
        //                     no_pr = value.pr_no
        //                 }

        //                 var no_po
        //                 if (!value.id_po) {
        //                     no_po = '-'
        //                 } else {
        //                     no_po = value.po_no
        //                 }

        //                 var checkbox
        //                 if (value.id_spph && !value.id_po) {
        //                     checkbox = '<input type="checkbox" id="addToDetails" value="' + value.id +
        //                         '" onclick="addToDetailsJS(' + value.id + ')" >'
        //                 } else {
        //                     checkbox = '<input type="checkbox" id="addToDetails" value="' + value.id +
        //                         '" onclick="addToDetailsJS(' + value.id + ')" disabled>'
        //                 }


        //                 $('#detail-material').append(
        //                     '<tr><td>' + checkbox + '</td><td>' + (key + 1) + '</td><td>' + value.uraian +
        //                     '</td><td>' + value.spek + '</td><td>' + value.qty + '</td><td>' + value
        //                     .satuan + '</td><td>' + value.nama_proyek + '</td><td>' + no_spph +
        //                     '</td><td>' + no_pr + '</td><td>' +
        //                     no_po + '</td></tr>'
        //                 );
        //             });
        //         },
        //         error: function() {
        //             $('#pcode').prop("disabled", false);
        //             $('#button-check').prop("disabled", false);
        //         }
        //     });
        // // }

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
                var qty_poluar1 = $row.find('.qty_poluar1-input').val();
                var isChecked = $row.find('.row-checkbox').prop('checked'); // Cek checkbox

                // if (isChecked) {
                //     selectedRows++; // Hitung jumlah yang dicentang
                //     if (qty_po1 !== '' && !isNaN(qty_po1)) { // Pastikan qty2 valid
                //         dataToSend.push({
                //             id: id,
                //             qty_po1: qty_po1
                //         });
                //     }
                // }

                if (isChecked) {
                    selectedRows++; // Hitung jumlah yang dicentang
                    if (qty_poluar1 !== '' && !isNaN(qty_poluar1)) { // Pastikan qty2 valid
                        dataToSend.push({
                            id: id,
                            qty_poluar1: qty_poluar1,
                            id_poluar: $('#id_poluar').val()
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
                url: "{{ route('qty_poluar_save') }}", // Sesuaikan dengan route
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
        $(document).on('input', '.qty_poluar1-input', function() {
            var $row = $(this).closest('tr');
            var qtyPoluarCell = $row.find('td:eq(4)');
            var initialQtyPoluar = parseFloat(qtyPoluarCell.data('original-qty')) || 0;
            var inputQty_poluar1 = parseFloat($(this).val()) || 0;

            if (inputQty_poluar1 > initialQtyPoluar) {
                alert("Qty tidak boleh lebih besar dari Qty");
                $(this).val(initialQtyPoluar);
                inputQty_poluar1 = initialQtyPoluar;
            }

            var newQtyPoluar = initialQtyPoluar - inputQty_poluar1;

            qtyPoluarCell.text(newQtyPoluar);
        });




        function getPODetail(pr_id) {
            console.log("PRRRR XXX", pr_id)
            // alert(pr_id);
            loader();

            $('#button-check').prop("disabled", true);
            $.ajax({
                url: "{{ url('products/products_pr_poluar/') }}/" + pr_id,
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
                    $('#btn-save-then-add').prop('disabled', true);
                    $.each(data.products, function(key, value) {
                        console.log(value);
                        var no_spph
                        if (!value.id_spph) {
                            no_spph = '-'
                        } else {
                            no_spph = value.nomor_spph
                        }

                        var no_pr
                        if (!value.pr_no) {
                            no_pr = '-'
                        } else {
                            no_pr = value.pr_no
                        }
                        var no_po
                        if (!value.p_no) {
                            no_po = '-'
                        } else {
                            no_po = value.po_no
                        }

                        var no_poluar
                        if (!value.p_no) {
                            no_poluar = '-'
                        } else {
                            no_poluar = value.poluar_no
                        }



                        var checkbox;
                        if (value.qty_poluar === null || value.qty_poluar === "" || value.qty_poluar >= 0) {
                            checkbox = '<input type="checkbox" id="addToDetails-' + value.id +
                                '" class="row-checkbox" value="' + value.id +
                                '" onclick="addToDetailsJS(' + value.id + ')">';
                        } else {
                            checkbox = '<input type="checkbox" id="addToDetails-' + value.id +
                                '" class="row-checkbox" value="' + value.id +
                                '" onclick="addToDetailsJS(' + value.id + ')" disabled>';
                        }



                        $('#detail-material').append(
                            '<tr id="row-' + key + '" data-id="' + value.id + '">' +
                            '<td>' + checkbox + '</td>' +
                            '<td>' + (key + 1) + '</td>' +
                            '<td>' + value.uraian + '</td>' +
                            '<td>' + value.spek + '</td>' +
                            '<td data-original-qty="' + value.qty_poluar + '">' + value.qty_poluar +
                            // '<td><input type="text" class="form-control qty_po1-input" style="width: 50px;" value="' + value.qty_po1 + '" data-qty="' + value.qty_po1 + '"></td>' +
                            '<td>' +
                            '<div style="display: block;">' +
                            // Menggunakan block untuk menata vertikal
                            '<input type="text" class="form-control qty_poluar1-input" style="width: 50px;" value="' +
                            value.qty_poluar1 + '" data-qty="' + value.qty_poluar1 + '">' +


                            '</td>' +
                            '<td>' + value.satuan + '</td>' +
                            '<td>' + no_pr + '</td>' +
                            '<td>' + no_spph + '</td>' +
                            '<td>' + no_poluar + '</td>' +
                            '<td>' + value.nama_pekerjaan + '</td>' +
                            '</tr>'
                        );

                    });
                },
                error: function() {
                    $('#pcode').prop("disabled", false);
                    $('#button-check').prop("disabled", false);
                }
            });
        }

        var selected = []

        function addToDetailsJS(id) {
            if (selected.includes(id)) {
                selected = selected.filter(item => item !== id)
            } else {
                selected.push(id)
            }
            console.log(selected)
        }

        function addToDetails() {
            $.ajax({
                url: "{{ url('products/tambah_detail_poluar') }}",
                type: "POST",
                data: {
                    "id_poluar": $('#id_poluar').val(),
                    "selected": selected,
                    "_token": "{{ csrf_token() }}",
                },
                dataType: "json",
                beforeSend: function() {
                    $('#loader').show();
                    $('#form').hide();
                },
                success: function(data) {
                    var pr_id = data.poluar.pr_id;
                    getPODetail(pr_id);
                    console.log(data);
                    $('#no_poluar').text(data.poluar.no_poluar);
                    $('#id_proyek').text(data.poluar.nama_proyek);
                    $('#id_vendor').text(data.poluar.nama_vendor);
                    $('#po_tanggal').text(data.poluar.tgpo);
                    $('#po_batas').text(data.poluar.btpo);
                    $('#id_poluar').val(data.poluar.id_poluar);
                    $('#button-cetak-po').html('<i class="fas fa-print"></i> Cetak');
                    $('#button-cetak-po').attr('disabled', false);
                    $('#tabel-po').empty();
                    var no = 1;
                    var id_poluar = data.poluar.id_poluar;
                    selected = [];

                    if (data?.poluar?.details && data.poluar.details.length > 0) {
                        renderTableData(data.poluar.details, id_poluar);
                    } else {
                        $('#tabel-po').append(
                            '<tr><td colspan="11" class="text-center">Tidak ada data</td></tr>');
                    }
                    //remove loading
                    // if(data?.po?.details?.length > 1){
                    //     $('#tabel-po').find('tr:first').remove();
                    // }
                    $('#loader').hide();
                    $('#form').show();
                    // getPODetail();
                    setTimeout(function() {
                        toastr.success('Berhasil menambahkan detail Purchase Order Luar!');
                    }, 200);
                },
                error: function(xhr) {
                    // Tampilkan pesan error validasi dari backend jika ada
                    if(xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors){
                        var msg = Object.values(xhr.responseJSON.errors).map(function(e){return e.join('<br>')}).join('<br>');
                        toastr.error(msg);
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Gagal menambahkan detail Purchase Order Luar!');
                    }
                }


            });

        }

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
                            if (!value.id_spph) {
                                no_spph = '-'
                            } else {
                                no_spph = value.nomor_spph
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
                            var no_poluar
                            if (!value.id_poluar) {
                                no_poluar = '-'
                            } else {
                                no_poluar = value.poluar_no
                            }

                            var checkbox
                            if (value.id_spph && !value.id_poluar) {
                                checkbox = '<input type="checkbox" id="addToDetails" value="' + value
                                    .id +
                                    '" onclick="addToDetailsJS(' + value.id + ')" >'
                            } else {
                                checkbox = '<input type="checkbox" id="addToDetails" value="' + value
                                    .id +
                                    '" onclick="addToDetailsJS(' + value.id + ')" disabled>'
                            }

                            $('#detail-material').append(

                                '<tr><td>' + (key + 1) + '</td><td>' + value.uraian +
                                '</td><td>' + value.spek + '</td><td>' + value.poluar_qty +
                                '</td><td>' +
                                value
                                .satuan + '</td><td>' + value.nama_pekerjaan + '</td><td>' +
                                no_spph +
                                '</td><td>' + no_pr + '</td><td>' +
                                no_poluar + '</td><td>' + checkbox + '</td></tr>'
                            );
                        });
                        $('#detail-material').append(
                            '<tr><td colspan="8" class="text-center">Tidak ada produk</td></tr>');
                    },
                    error: function(xhr) {
                        $('#pcode').prop("disabled", false);
                        $('#button-check').prop("disabled", false);
                        toastr.error(xhr.responseJSON?.message || 'Gagal mengambil data produk!');
                    }
                });
            } else {
                toastr.error("Nama Proyek tidak ditemukan");
            }
        }

        function PoUpdate() {
            var id = $('#id').val();
            var pid = $('#pid').val();
            var type = $('#type').val();
            var deskripsi = $('#pname').val();
            var batas = $('#batas').val();
            var poluar_qty = $('#qty').val();
            var unit = $('#unit').val();
            var token = $('input[name=_token]').val();
            var url = "{{ url('products/purchase_orderluar_detail/update') }}";
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    id: id,
                    pid: pid,
                    type: type,
                    deskripsi: deskripsi,
                    batas: batas,
                    poluar_qty: poluar_qty,
                    unit: unit,
                    _token: token
                },
                dataType: "json",

                success: function(data) {
                    console.log(data);
                    if (data.status == 1) {
                        toastr.success(data.message);
                        $('#detail-po').modal('hide');
                        location.reload();
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function(xhr) {
                    // Tampilkan pesan error validasi dari backend jika ada
                    if(xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors){
                        var msg = Object.values(xhr.responseJSON.errors).map(function(e){return e.join('<br>')}).join('<br>');
                        toastr.error(msg);
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Gagal memperbarui data!');
                    }
                }
            })
        }

        function deletePo(data) {
            $('#delete_id').val(data.id);
        }

        function download(type) {
            window.location.href = "{{ route('products.wip.history') }}?search={{ Request::get('search') }}&dl=" + type;
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
