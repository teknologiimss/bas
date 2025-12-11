@extends('layouts.main')
@section('title', __('Stok Barang MRO'))
@section('custom-css')
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endsection
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2"></div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-mro"
                        onclick="addMro()"><i class="fas fa-plus"></i> Tambah Barang</button>

                    <button type="button" class="btn btn-primary"
                        onclick="window.location.href='{{ route('mro.export') }}'">
                        <i class="fas fa-file-excel"></i> Export MRO (XLS)
                    </button>


                    <div class="card-tools">
                        <form>
                            <div class="input-group input-group">
                                <input type="text" class="form-control" name="q" placeholder="Search"
                                    value="{{ Request::get('q') }}">
                                <input type="hidden" name="category" value="{{ Request::get('category') }}">
                                <input type="hidden" name="sort" value="{{ Request::get('sort') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="form-group row col-sm-3">
                        <label for="sort" class="col-sm-3 col-form-label">Sort</label>
                        <div class="col-sm-9">
                            <form id="sorting" action="" method="get">
                                <input type="hidden" name="q" value="{{ Request::get('q') }}">
                                <input type="hidden" name="category" value="{{ Request::get('category') }}">
                                <select class="form-control select2" id="sort" name="sort">
                                    <option value="" {{ Request::get('sort') == null ? 'selected' : '' }}>-</option>
                                    <option value="name_az" {{ Request::get('sort') == 'name_az' ? 'selected' : '' }}>Nama
                                        (A-Z)</option>
                                    <option value="name_za" {{ Request::get('sort') == 'name_za' ? 'selected' : '' }}>Nama
                                        (Z-A)</option>
                                    <option value="proyek_az" {{ Request::get('sort') == 'proyek_az' ? 'selected' : '' }}>
                                        Proyek (A-Z)
                                    </option>
                                    <option value="proyek_za" {{ Request::get('sort') == 'proyek_za' ? 'selected' : '' }}>
                                        Proyek (Z-A)
                                    </option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <button type="button" class="btn-sm btn-danger" id="btnDeleteMultiple">
                            <i class="fas fa-trash"></i> Hapus Terpilih
                        </button>

                        <table class="table table-sm table-hover table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>No.</th>
                                    <th>Kode Material</th>
                                    <th>Nama Barang</th>
                                    <th>Spesifikasi</th>
                                    <th>Stok</th>
                                    <th>Satuan</th>
                                    <th>Proyek</th>
                                    {{-- <th>Kategori</th> --}}
                                    <th>Tombol</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($mro) > 0)
                                    @foreach ($mro as $key => $row)
                                        @php
                                            $data = [
                                                'no' => $mro->firstItem() + $key,
                                                'mro_id' => $row->mro_id,
                                                'code' => $row->mro_code,
                                                'barcode' => $row->barcode,
                                                'name' => $row->mro_name,
                                                'spesifikasi' => $row->spesifikasi,
                                                'stock' => $row->stock,
                                                'satuan' => $row->satuan,
                                                'proyek' => $row->proyek,
                                                'cat_id' => $row->category_id,
                                                'cat_name' => $row->category_name,
                                            ];
                                        @endphp
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" class="checkItem" value="{{ $row->mro_id }}">
                                            </td>
                                            <td class="text-center">{{ $data['no'] }}</td>
                                            <td class="text-center">{{ $data['code'] }}</td>
                                            <td>{{ $data['name'] }}</td>
                                            <td>{{ $data['spesifikasi'] }}</td>
                                            <td class="text-center">
                                                <span
                                                    class="{{ $data['stock'] <= 10 ? 'badge bg-warning' : '' }}">{{ $data['stock'] }}</span>
                                            </td>
                                            <td class="text-center">{{ $data['satuan'] }}</td>
                                            <td class="text-center">{{ $data['proyek'] }}</td>
                                            {{-- <td>{{ $data['cat_name'] }}</td> --}}
                                            <td class="text-center">
                                                <button type="button" class="btn btn-success btn-xs" data-toggle="modal"
                                                    data-target="#add-mro"
                                                    onclick='editMro(@json($data))'><i
                                                        class="fas fa-edit"></i></button>

                                                <button class="btn btn-dark btn-xs qrcode-btn"
                                                    data-id="{{ $row->mro_id }}" data-code="{{ $row->barcode }}"
                                                    data-name="{{ $row->mro_name }}"
                                                    data-spesifikasi="{{ $row->spesifikasi }}">
                                                    <i class="fas fa-qrcode"></i>
                                                </button>



                                                @if (Auth::user()->role == 0 || Auth::user()->role == 14)
                                                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                                        data-target="#delete-mro"
                                                        onclick='deleteMro(@json($data))'><i
                                                            class="fas fa-trash"></i></button>
                                                @endif

                                                <button class="btn-xs btn-success" data-toggle="modal"
                                                    data-target="#modalStockIn">
                                                    <i class="fas fa-plus"></i> Stock In
                                                </button>

                                                <button class="btn-xs btn-danger" data-toggle="modal"
                                                    data-target="#modalStockOut">
                                                    <i class="fas fa-minus"></i> Stock Out
                                                </button>

                                            </td>

                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="text-center">
                                        <td colspan="8">No data.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div>
                {{ $mro->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
            </div>
        </div>

        {{-- Modal Barcode --}}
        <div class="modal fade" id="modalBarcode" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">QR Code</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <div id="qrcode-view"></div>
                        <div id="barcode-title" class="fw-bold mt-2"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary" id="btnPrintBarcode">Print</button>
                    </div>
                </div>
            </div>
        </div>



        {{-- Modal Stock In --}}
        <div class="modal fade" id="modalStockIn">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('mro.stockin') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Stock In</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">

                            <label>Scan Barcode</label>
                            <input type="text" name="barcode" id="barcode-in" class="form-control" autofocus>

                            <label class="mt-2">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" value="1">
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button class="btn btn-primary">Tambah Stok</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Stock Out --}}
        <div class="modal fade" id="modalStockOut">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('mro.stockout') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Stock Out</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">

                            <label>Scan Barcode</label>
                            <input type="text" name="barcode" id="barcode-out" class="form-control" autofocus>

                            <label class="mt-2">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" value="1">
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button class="btn btn-danger">Kurangi Stok</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>




        {{-- Modal Add / Edit --}}
        <div class="modal fade" id="add-mro">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title">Tambah Stok Barang MRO</h4>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form id="save" action="{{ route('mro.save') }}" method="post">
                            @csrf
                            <input type="hidden" id="save_id" name="mro_id">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Kode Material</label>
                                <div class="col-sm-8"><input type="text" class="form-control" id="mro_code"
                                        name="mro_code" autocomplete="off"></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Nama Barang</label>
                                <div class="col-sm-8"><input type="text" class="form-control" id="mro_name"
                                        name="mro_name" autocomplete="off"></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Spesifikasi</label>
                                <div class="col-sm-8"><input type="text" class="form-control" id="spesifikasi"
                                        name="spesifikasi" autocomplete="off"></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Satuan</label>
                                <div class="col-sm-8"><input type="text" class="form-control" id="satuan"
                                        name="satuan" autocomplete="off"></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Stock</label>
                                <div class="col-sm-8"><input type="number" class="form-control" id="stock"
                                        name="stock" autocomplete="off"></div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Proyek</label>
                                <div class="col-sm-8"><input type="text" class="form-control" id="proyek"
                                        name="proyek" autocomplete="off"></div>
                            </div>


                            {{-- <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Kategori</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" id="category" name="category"></select>
                                </div>
                            </div> --}}

                            {{-- <div class="form-group mt-2">
                                <label>Barcode</label><br>
                                <svg id="barcode-preview"></svg>
                            </div> --}}

                            <div class="form-group mt-2">
                                <label>Barcode</label><br>
                                {{-- <svg id="barcode-preview"></svg> --}}
                                <div id="qrcode-preview" class="mt-3"></div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" onclick="$('#save').submit();">Simpan</button>
                    </div>
                </div>
            </div>
        </div>


        {{-- Modal Delete --}}
        <div class="modal fade" id="delete-mro">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Hapus MRO</h4>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form id="delete" action="{{ route('mro.delete') }}" method="post">
                            @csrf @method('delete')
                            <input type="hidden" id="delete_id" name="id">
                        </form>
                        <p>Anda yakin ingin menghapus kode MRO <span id="mrocode" class="font-weight-bold"></span>?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button class="btn btn-danger" onclick="$('#delete').submit();">Ya, hapus</button>
                    </div>
                </div>
            </div>
        </div>


        {{-- Modal Hapus Multiple --}}
        <div class="modal fade" id="modalDeleteMultiple">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formDeleteMultiple" method="POST" action="{{ route('mro.multidelete') }}">
                        @csrf @method('DELETE')
                        <input type="hidden" name="ids" id="delete_ids">

                        <div class="modal-header">
                            <h5 class="modal-title">Hapus Data Terpilih</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            Yakin ingin menghapus <span id="totalSelected"></span> data MRO?
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>






    </section>
@endsection

@section('custom-js')
    <script src="/plugins/toastr/toastr.min.js"></script>
    <script src="/plugins/select2/js/select2.full.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>


    {{-- <script>
        function generateBarcode() {
            let code = document.getElementById('mro_code').value;
            if (code !== "") {
                JsBarcode("#barcode-preview", code, {
                    format: "CODE128",
                    displayValue: true,
                    height: 50
                });
            } else {
                document.getElementById('barcode-preview').innerHTML = "";
            }
        }

        document.getElementById('mro_code').addEventListener('keyup', generateBarcode);
        document.getElementById('mro_code').addEventListener('change', generateBarcode);
    </script> --}}

    <script>
        let qrCodeGenerator = null;

        function generateQRCode() {
            let code = document.getElementById('mro_code').value;

            // hapus QR lama
            document.getElementById('qrcode-preview').innerHTML = "";

            if (code !== "") {

                // buat QR baru
                qrCodeGenerator = new QRCode(document.getElementById("qrcode-preview"), {
                    text: code,
                    width: 150,
                    height: 150,
                    correctLevel: QRCode.CorrectLevel.H
                });
            }
        }

        document.getElementById('mro_code').addEventListener('keyup', generateQRCode);
        document.getElementById('mro_code').addEventListener('change', generateQRCode);
    </script>




    {{-- <script>
        $(document).on("click", ".barcode-btn", function() {
            let code = $(this).data("code");
            let name = $(this).data("name");
            let spesifikasi = $(this).data("spesifikasi");

            // buat barcode
            JsBarcode("#barcode-view", code, {
                format: "CODE128",
                displayValue: true,
                height: 60
            });

            $("#barcode-title").text(name + " — " + spesifikasi);
            $("#modalBarcode").modal("show");
        });
    </script> --}}

    <script>
        const stockInRoute = "{{ route('mro.scan.stockin', ':barcode') }}";
        const stockOutRoute = "{{ route('mro.scan.stockout', ':barcode') }}";
    </script>


    <Script>
        $(document).on("click", ".qrcode-btn", function() {
            let code = $(this).data("code");
            let name = $(this).data("name");
            let spesifikasi = $(this).data("spesifikasi");

            $("#qrcode-view").html("");

            let urlIn = stockInRoute.replace(':barcode', code);
            let urlOut = stockOutRoute.replace(':barcode', code);

            new QRCode(document.getElementById("qrcode-view"), {
                text: urlIn,
                width: 150,
                height: 150
            });

            $("#barcode-title").html(`
        ${name} — ${spesifikasi}<br>
        <small>Scan QR untuk Stock In.</small><br><br>
        <a href="${urlIn}" target="_blank" class="btn btn-success btn-sm">Stock In</a>
        <a href="${urlOut}" target="_blank" class="btn btn-danger btn-sm ml-2">Stock Out</a>
    `);

            $("#modalBarcode").modal("show");
        });
    </Script>

    {{-- <script>
        $("#btnPrintBarcode").on("click", function() {
            let printContents = document.querySelector("#modalBarcode .modal-body").innerHTML;
            let windowPrint = window.open('', '', 'height=500,width=900');
            windowPrint.document.write('<html><head><title>Print Barcode</title>');
            windowPrint.document.write('</head><body class="text-center">');
            windowPrint.document.write(printContents);
            windowPrint.document.write('</body></html>');
            windowPrint.document.close();
            windowPrint.print();
        });
    </script> --}}

    <script>
        $("#btnPrintBarcode").on("click", function() {
            let printContents = document.querySelector("#modalBarcode .modal-body").innerHTML;
            let windowPrint = window.open('', '', 'height=500,width=900');
            windowPrint.document.write('<html><head><title>Print QR Code</title>');
            windowPrint.document.write('</head><body class="text-center">');
            windowPrint.document.write(printContents);
            windowPrint.document.write('</body></html>');
            windowPrint.document.close();
            windowPrint.print();
        });
    </script>




    <script>
        $('#modalStockIn').on('shown.bs.modal', function() {
            $('#barcode-in').focus();
        });

        $('#modalStockOut').on('shown.bs.modal', function() {
            $('#barcode-out').focus();
        });
    </script>



    {{-- Hapus Multiple --}}
    <Script>
        // Check all
        $("#checkAll").on("change", function() {
            $(".checkItem").prop("checked", $(this).prop("checked"));
        });

        // Button delete multiple
        $("#btnDeleteMultiple").on("click", function() {
            let selected = [];

            $(".checkItem:checked").each(function() {
                selected.push($(this).val());
            });

            if (selected.length === 0) {
                toastr.error("Tidak ada data yang dipilih!");
                return;
            }

            $("#delete_ids").val(JSON.stringify(selected));
            $("#totalSelected").text(selected.length + " item");
            $("#modalDeleteMultiple").modal("show");
        });
    </Script>



    <script>
        $(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });

        $('#sort').on('change', () => $("#sorting").submit());

        function resetForm() {
            $('#save').trigger("reset");
            $('#save_id').val(''); // ← Tambahkan supaya ID terhapus
        }

        function getCategory(val = null) {
            $.ajax({
                url: '/mro/categories',
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#category').empty().append('<option value="">.:: Pilih Kategori ::.</option>');
                    $.each(data, function(_, v) {
                        $('#category').append('<option value="' + v.category_id + '"' + (val == v
                                .category_id ? ' selected' : '') + '>' + v.category_name +
                            '</option>');
                    });
                }
            });
        }

        function addMro() {
            $('#modal-title').text("Tambah Stok Barang MRO");
            $('#button-save').text("Tambahkan");
            resetForm();
            $('#save_id').val(''); // ← PENTING !!! Reset ID supaya create, bukan update
            getCategory();
        }

        function editMro(data) {
            $('#modal-title').text("Edit Stok Barang MRO");
            $('#button-save').text("Simpan");
            resetForm();
            $('#save_id').val(data.mro_id);
            $('#mro_code').val(data.code);
            $('#mro_name').val(data.name);
            $('#spesifikasi').val(data.spesifikasi);
            $('#satuan').val(data.satuan);
            $('#stock').val(data.stock);
            $('#proyek').val(data.proyek);
            getCategory(data.cat_id);
        }

        function deleteMro(data) {
            $('#delete_id').val(data.mro_id);
            $('#mrocode').text(data.code);
        }

        function download(type) {
            window.location.href = "{{ route('mro') }}?q={{ Request::get('q') }}&dl=" + type;
        }
    </script>

    @if (Session::has('success'))
        <script>
            toastr.success('{!! Session::get('success') !!}')
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            toastr.error('{!! Session::get('error') !!}')
        </script>
    @endif
    @if (!empty($errors->all()))
        <script>
            toastr.error('{!! implode('', $errors->all('<li>:message</li>')) !!}')
        </script>
    @endif
@endsection
