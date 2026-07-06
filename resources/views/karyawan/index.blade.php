@extends('layouts.main')
@section('title', 'data karyawan')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('custom-css')
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">

    <style>
        /* =====================================================
           🎨 ROOT COLOR (NAVY BLUE)
        ===================================================== */
        :root {
            --maroon: #1E3A5F;
            --maroon-dark: #0D2340;
            --maroon-light: #3E6A9E;
            --maroon-soft: #EEF4FB;
            --maroon-border: #C8D7EA;
        }

        /* =====================================================
           🌍 GLOBAL MOBILE FIX
        ===================================================== */
        * {
            box-sizing: border-box;
        }

        body {
            overflow-x: hidden;
            background: #f5f7fb;
        }

        .container-fluid,
        .content-wrapper,
        .content,
        .card,
        .card-body {
            max-width: 100%;
            overflow-x: hidden;
        }

        /* =====================================================
           📦 CARD
        ===================================================== */
        .card {
            border-radius: 14px;
            border: none;
            box-shadow: 0 12px 30px rgba(13, 35, 64, .18);
            animation: fadeUp .5s ease;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, var(--maroon), var(--maroon-light));
            color: #fff;
            font-weight: 700;

            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .card-body {
            background: #fff;
            width: 100%;
            overflow-x: auto;
        }

        /* =====================================================
           🔘 BUTTON
        ===================================================== */
        .btn,
        button {
            position: relative;
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark)) !important;
            color: #fff !important;
            border: none !important;
            border-radius: 10px;
            font-weight: 600;
            transition: all .25s ease;
            box-shadow: 0 6px 16px rgba(13, 35, 64, .28);
        }

        .btn-primary,
        .btn-success,
        .btn-danger,
        .btn-info,
        .btn-warning,
        .btn-secondary,
        .btn-default {
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark)) !important;
        }

        .btn:hover,
        button:hover {
            background: linear-gradient(135deg, var(--maroon-light), var(--maroon)) !important;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 14px 30px rgba(13, 35, 64, .35);
        }

        .btn:active,
        button:active {
            transform: scale(.95);
        }

        .btn i {
            transition: transform .25s ease;
        }

        .btn:hover i {
            transform: scale(1.2) rotate(-5deg);
        }

        .btn-xs {
            padding: 6px 10px !important;
            font-size: 12px !important;
            min-width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 2px;
        }

        /* =====================================================
           📊 TABLE
        ===================================================== */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 12px;
        }

        #table,
        .table {
            width: 100%;
            min-width: 900px;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 12px 30px rgba(13, 35, 64, .18);
            margin-bottom: 0;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--maroon), var(--maroon-light));
            color: #fff;
            text-align: center;
            border: none;
            white-space: nowrap;
            vertical-align: middle;
        }

        .table tbody tr {
            background: var(--maroon-soft);
            transition: all .3s ease;
        }

        .table tbody tr:nth-child(even) {
            background: #E2ECF8;
        }

        .table tbody tr:hover {
            background: linear-gradient(135deg, #F8FBFF, #DCE8F7);
            transform: translateY(-4px) scale(1.01);
            box-shadow: 0 10px 24px rgba(13, 35, 64, .18);
        }

        .table td {
            border-color: var(--maroon-border);
            vertical-align: middle;
            white-space: nowrap;
        }

        /* =====================================================
           🪟 MODAL
        ===================================================== */
        .modal-dialog {
            max-width: 95%;
        }

        .modal-content {
            border-radius: 16px;
            animation: zoomIn .4s ease;
            overflow: hidden;
            box-shadow: 0 16px 40px rgba(13, 35, 64, .25);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--maroon), var(--maroon-light));
            color: #fff;
        }

        .modal-body {
            max-height: calc(100vh - 180px);
            overflow-y: auto;
        }

        /* =====================================================
           🧾 INPUT
        ===================================================== */
        .form-control {
            border-radius: 10px;
            transition: all .25s ease;
            border: 1px solid var(--maroon-border);
        }

        .form-control:focus {
            border-color: var(--maroon-light);
            box-shadow: 0 0 0 3px rgba(62, 106, 158, .20);
        }

        /* =====================================================
           📱 MOBILE RESPONSIVE
        ===================================================== */
        @media (max-width:768px) {

            body {
                font-size: 13px;
            }

            .container-fluid {
                padding-left: 8px !important;
                padding-right: 8px !important;
            }

            .card {
                border-radius: 10px;
            }

            .card-header {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
                padding: 12px;
            }

            .card-header .btn {
                width: 100%;
            }

            .card-tools {
                width: 100%;
            }

            .card-tools .input-group {
                width: 100%;
            }

            .btn {
                font-size: 12px !important;
                padding: 7px 10px !important;
                min-height: 38px;
            }

            .btn-xs {
                width: 38px !important;
                height: 38px !important;
                padding: 0 !important;
                font-size: 12px !important;
                margin: 2px !important;
            }

            #table,
            .table {
                min-width: 850px;
            }

            .table th,
            .table td {
                font-size: 12px;
                padding: 8px;
            }

            .modal-dialog {
                margin: 10px auto;
                max-width: 98%;
            }

            .modal-body {
                padding: 12px;
            }

            .form-group.row {
                display: block;
                margin-bottom: 12px;
            }

            .form-group.row label {
                margin-bottom: 6px;
                display: block;
            }

            .form-group.row .col-sm-4,
            .form-group.row .col-sm-8 {
                max-width: 100%;
                flex: 100%;
            }

            .form-control {
                font-size: 13px;
            }

            .modal-footer {
                flex-direction: column;
                gap: 10px;
            }

            .modal-footer .btn {
                width: 100%;
                margin: 0 !important;
            }
        }

        /* =====================================================
           ✨ ANIMATION
        ===================================================== */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
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


    {{-- Chart jumlah Karyawan --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="container mt-3">
        <button id="btnLihatGrafik" class="btn btn-primary mb-3">
            <i class="fas fa-chart-bar"></i> Lihat Grafik
        </button>

        <div id="grafikContainer" style="display: none;">
            <div class="row">
                <!-- Card Grafik Jenis Kelamin -->
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 rounded-3 h-100 text-center">
                        <div class="card-header fw-bold">
                            <b>Jenis Kelamin Pegawai</b>
                        </div>
                        <div class="card-body">
                            <canvas id="genderChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Card Grafik Status Pegawai -->
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 rounded-3 h-100 text-center">
                        <div class="card-header fw-bold">
                            <b>Status Pegawai</b>
                        </div>
                        <div class="card-body">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Card Grafik Lokasi Kerja -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-3 h-100 text-center">
                        <div class="card-header fw-bold">
                            <b>Lokasi Kerja Pegawai</b>
                        </div>
                        <div class="card-body">
                            <canvas id="lokasiKerjaChart"></canvas>

                            <div style="margin-top: 20px; max-height: 250px; overflow-y: auto;">
                                <table class="table table-sm table-bordered table-striped mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 60%;">Lokasi Kerja</th>
                                            <th style="width: 40%;">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lokasiKerjaCounts as $lokasi => $jumlah)
                                            <tr>
                                                <td class="text-start">{{ $lokasi }}</td>
                                                <td class="text-end">{{ $jumlah }} orang</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light fw-bold">
                                        <tr>
                                            <td><b>Total Pegawai</b></td>
                                            <td class="text-end"><b>{{ array_sum($lokasiKerjaCounts) }}</b> orang</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.getElementById('btnLihatGrafik').addEventListener('click', function() {
            const grafikContainer = document.getElementById('grafikContainer');

            // Toggle tampilan (buka/tutup)
            if (grafikContainer.style.display === 'none') {
                grafikContainer.style.display = 'block';
                this.innerHTML = '<i class="fas fa-eye-slash"></i> Sembunyikan Grafik';
                renderCharts(); // panggil fungsi untuk render chart
            } else {
                grafikContainer.style.display = 'none';
                this.innerHTML = '<i class="fas fa-chart-bar"></i> Lihat Grafik';
            }
        });

        function renderCharts() {
            // Hanya render sekali
            if (window.chartsRendered) return;
            window.chartsRendered = true;

            // Jenis Kelamin
            var ctxGender = document.getElementById('genderChart').getContext('2d');
            new Chart(ctxGender, {
                type: 'pie',
                data: {
                    labels: ['Laki-laki', 'Perempuan'],
                    datasets: [{
                        data: [{{ $maleCount }}, {{ $femaleCount }}],
                        backgroundColor: ['#36A2EB', '#FF6384'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                    }
                }
            });

            // Status Pegawai
            var ctxStatus = document.getElementById('statusChart').getContext('2d');
            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode(array_keys($statusCounts)) !!},
                    datasets: [{
                        data: {!! json_encode(array_values($statusCounts)) !!},
                        backgroundColor: ['#4CAF50', '#FF9800', '#9C27B0', '#03A9F4', '#FFC107'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                    }
                }
            });

            // Lokasi Kerja
            var ctxLokasi = document.getElementById('lokasiKerjaChart').getContext('2d');
            new Chart(ctxLokasi, {
                type: 'bar',
                data: {
                    labels: @json(array_keys($lokasiKerjaCounts)),
                    datasets: [{
                        label: 'Jumlah Pegawai',
                        data: @json(array_values($lokasiKerjaCounts)),
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }
                    }
                }
            });
        }
    </script>


    {{-- End Chart Karyawan --}}


    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    @auth
                        @if (Auth::user()->role == 0 || Auth::user()->role == 6)
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-kode-aset"
                                onclick="addKodeAset()"><i class="fas fa-plus"></i> Add New Karyawan</button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#import-karyawan"
                                onclick="importKaryawan()"><i class="fas fa-file-excel"></i> Import Karyawan (Excel)</button>
                            <a type="button" class="btn btn-primary" href="{{ route('karyawan.export') }}"><i
                                    class="fas fa-file-excel"></i> Export Karyawan (Excel)</a>
                        @endif
                    @endauth
                    <div class="card-tools">
                        <form>
                            <div class="input-group input-group">
                                <input type="text" class="form-control" name="q" placeholder="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">


                        <table id="table" class="table table-sm table-bordered table-hover table-striped">
                            <thead>
                                <tr class="text-center">

                                    <th><input type="checkbox" id="select-all"></th>
                                    <th>Nomor</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Rekening Mandiri</th>
                                    <th>Rekening BSI</th>
                                    <th>Rekrutmen</th>
                                    <th>Domisili</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Masa Kerja Tahun</th>
                                    <th>Masa Kerja Bulan</th>
                                    <th>Status Pegawai</th>
                                    <th>Karyawan</th>
                                    <th>SK Pengangkatan / Kontrak</th>
                                    <th>Tanggal Pengangkatan / Kontrak</th>
                                    <th>Jabatan INKA</th>
                                    <th>Jabatan IMSS</th>
                                    <th>Column2</th>
                                    <th>Administrasi / Teknisi</th>
                                    <th>Lokasi Kerja</th>
                                    <th>Bagian / Proyek</th>
                                    <th>Departemen / Subproyek</th>
                                    <th>Divisi</th>
                                    <th>Direktorat</th>
                                    <th>Sertifikat</th>
                                    <th>Surat Peringatan</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Usia</th>
                                    <th>Nomor KTP</th>
                                    <th>Alamat</th>
                                    <th>Nomor HP</th>
                                    <th>Nomor Whatsapp</th>
                                    <th>Nomor Link Aja</th>
                                    <th>Email</th>
                                    <th>BPJS Kesehatan</th>
                                    <th>BPJS Ketenagakerjaan</th>
                                    <th>Status Pernikahan</th>
                                    <th>Suami / Istri</th>
                                    <th>Anak ke 1</th>
                                    <th>Anak ke 2</th>
                                    <th>Anak ke 3</th>
                                    <th>Tambahan</th>
                                    <th>Ayah Kandung</th>
                                    <th>Ibu Kandung</th>
                                    <th>Ayah Mertua</th>
                                    <th>Ibu Mertua</th>
                                    <th>Jumlah Tanggungan</th>
                                    <th>Status Pajak</th>
                                    <th>Column1</th>
                                    <th>NPWP</th>
                                    <th>Agama</th>
                                    <th>Pendidikan Diakui</th>
                                    <th>Jurusan</th>
                                    <th>Almamater</th>
                                    <th>Tahun Lulus</th>
                                    <th>Pendidikan Terakhir</th>
                                    <th>Jurusan Terakhir</th>
                                    <th>Almamater Terakhir</th>
                                    <th>Tahun Lulus Terakhir</th>
                                    <th>MPP</th>
                                    <th>Pensiun</th>
                                    <th>Ukuran Baju</th>
                                    <th>Ukuran Celana</th>
                                    <th>Ukuran Sepatu</th>
                                    <th>Vaksin ke 1</th>
                                    <th>Vaksin ke 2</th>
                                    <th>Vaksin ke 3</th>
                                    <th>Nomor Kontrak</th>
                                    <th>Awal</th>
                                    <th>Akhir</th>
                                    <th>PB 1</th>
                                    <th>Nomor Kontrak 2</th>
                                    <th>Awal 2</th>
                                    <th>Akhir 2</th>
                                    <th>PB 2</th>
                                    <th>Nomor Kontrak 3</th>
                                    <th>Awal 3</th>
                                    <th>Akhir 3</th>
                                    <th>PB 3</th>
                                    <th>{{ __('Aksi') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $key => $d)
                                    @php
                                        $data = $d->toArray();
                                    @endphp

                                    <tr>
                                        <td class="text-center"><input type="checkbox" name="hapus[]"
                                                value="{{ $d->id }}"></td>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $d->nama }}</td>
                                        <td>{{ $d->nip }}</td>
                                        <td>{{ $d->rekening_mandiri }}</td>
                                        <td>{{ $d->rekening_bsi }}</td>
                                        <td>{{ $d->rekrutmen }}</td>
                                        <td>{{ $d->domisili }}</td>
                                        <td>{{ $d->tanggal_masuk }}</td>
                                        <td>{{ $d->masa_kerja_tahun }}</td>
                                        <td>{{ $d->masa_kerja_bulan }}</td>
                                        <td>{{ $d->status_pegawai }}</td>
                                        <td>{{ $d->karyawan }}</td>
                                        <td>{{ $d->sk_pengangkatan_atau_kontrak }}</td>
                                        <td>{{ $d->tanggal_pengangkatan_atau_akhir_kontrak }}</td>
                                        <td>{{ $d->jabatan_inka }}</td>
                                        <td>{{ $d->jabatan_imss }}</td>
                                        <td>{{ $d->column2 }}</td>
                                        <td>{{ $d->administrasi_atau_teknisi }}</td>
                                        <td>{{ $d->lokasi_kerja }}</td>
                                        <td>{{ $d->bagian_atau_proyek }}</td>
                                        <td>{{ $d->departemen_atau_subproyek }}</td>
                                        <td>{{ $d->divisi }}</td>
                                        <td>{{ $d->direktorat }}</td>
                                        <td>{{ $d->sertifikat }}</td>
                                        <td>{{ $d->surat_peringatan }}</td>
                                        <td>{{ $d->jenis_kelamin }}</td>
                                        <td>{{ $d->tempat_lahir }}</td>
                                        <td>{{ $d->tanggal_lahir }}</td>
                                        <td>{{ $d->usia }}</td>
                                        <td>{{ $d->nomor_ktp }}</td>
                                        <td>{{ $d->alamat }}</td>
                                        <td>{{ $d->nomor_hp }}</td>
                                        <td>{{ $d->nomor_whatsapp }}</td>
                                        <td>{{ $d->nomor_linkaja }}</td>
                                        <td>{{ $d->email }}</td>
                                        <td>{{ $d->bpjs_kesehatan }}</td>
                                        <td>{{ $d->bpjs_ketenagakerjaan }}</td>
                                        <td>{{ $d->status_pernikahan }}</td>
                                        <td>{{ $d->suami_atau_istri }}</td>
                                        <td>{{ $d->anak_ke_1 }}</td>
                                        <td>{{ $d->anak_ke_2 }}</td>
                                        <td>{{ $d->anak_ke_3 }}</td>
                                        <td>{{ $d->tambahan }}</td>
                                        <td>{{ $d->ayah_kandung }}</td>
                                        <td>{{ $d->ibu_kandung }}</td>
                                        <td>{{ $d->ayah_mertua }}</td>
                                        <td>{{ $d->ibu_mertua }}</td>
                                        <td>{{ $d->jumlah_tanggungan }}</td>
                                        <td>{{ $d->status_pajak }}</td>
                                        <td>{{ $d->column1 }}</td>
                                        <td>{{ $d->npwp }}</td>
                                        <td>{{ $d->agama }}</td>
                                        <td>{{ $d->pendidikan_diakui }}</td>
                                        <td>{{ $d->jurusan }}</td>
                                        <td>{{ $d->almamater }}</td>
                                        <td>{{ $d->tahun_lulus }}</td>
                                        <td>{{ $d->pendidikan_terakhir }}</td>
                                        <td>{{ $d->jurusan_terakhir }}</td>
                                        <td>{{ $d->almamater_terakhir }}</td>
                                        <td>{{ $d->tahun_lulus_terakhir }}</td>
                                        <td>{{ $d->mpp }}</td>
                                        <td>{{ $d->pensiun }}</td>
                                        <td>{{ $d->ukuran_baju }}</td>
                                        <td>{{ $d->ukuran_celana }}</td>
                                        <td>{{ $d->ukuran_sepatu }}</td>
                                        <td>{{ $d->vaksin_1 }}</td>
                                        <td>{{ $d->vaksin_2 }}</td>
                                        <td>{{ $d->vaksin_3 }}</td>
                                        <td>{{ $d->nomor_kontrak }}</td>
                                        <td>{{ $d->awal }}</td>
                                        <td>{{ $d->akhir }}</td>
                                        <td>{{ $d->pb_1 }}</td>
                                        <td>{{ $d->nomor_kontrak2 }}</td>
                                        <td>{{ $d->awal2 }}</td>
                                        <td>{{ $d->akhir2 }}</td>
                                        <td>{{ $d->pb_2 }}</td>
                                        <td>{{ $d->nomor_kontrak3 }}</td>
                                        <td>{{ $d->awal3 }}</td>
                                        <td>{{ $d->akhir3 }}</td>
                                        <td>{{ $d->pb_3 }}</td>
                                        <td class="text-center">
                                            @if (Auth::user()->role == 0 || Auth::user()->role == 6)
                                                <button title="Edit Shelf" type="button" class="btn btn-success btn-xs"
                                                    data-toggle="modal" data-target="#add-kode-aset"
                                                    onclick="editKaryawan({{ json_encode($data) }})"><i
                                                        class="fas fa-edit"></i></button>
                                                <button title="Hapus Produk" type="button" class="btn btn-danger btn-xs"
                                                    data-toggle="modal" data-target="#delete-suratkeluar"
                                                    onclick="deletekaryawan({{ json_encode($data) }})"><i
                                                        class="fas fa-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="11">{{ __('No data.') }}</td>
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
                {{ $items->links('pagination::bootstrap-4') }}
            </div>
        </div>
        @auth

            @if (Auth::user()->role == 0 || Auth::user()->role == 6)
                <div class="modal fade" id="add-kode-aset">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="modal-title" class="modal-title">{{ __('Add New Karyawan') }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form" id="save" action="{{ route('karyawan.store') }}" method="post"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <input type="hidden" id="id" name="id">


                                    {{-- <div class="form-group row">
                                        <label for="nomor_aset" class="col-sm-4 col-form-label">{{ __('Nomor Aset') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nomor_aset" name="nomor_aset">
                                        </div>
                                    </div> --}}
                                    <div class="form-group row">
                                        <label for="nama" class="col-sm-4 col-form-label">{{ __('Nama') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nama" name="nama">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nip" class="col-sm-4 col-form-label">{{ __('NIP') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nip" name="nip">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="rekening_mandiri"
                                            class="col-sm-4 col-form-label">{{ __('Rekening Mandiri') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="rekening_mandiri"
                                                name="rekening_mandiri">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="rekening_bsi"
                                            class="col-sm-4 col-form-label">{{ __('Rekening BSI') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="rekening_bsi"
                                                name="rekening_bsi">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="rekrutmen" class="col-sm-4 col-form-label">{{ __('Rekrutmen') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="rekrutmen" name="rekrutmen">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="domisili" class="col-sm-4 col-form-label">{{ __('Domisili') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="domisili" name="domisili">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tanggal_masuk" class="col-sm-4 col-form-label">Tanggal Masuk</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="tanggal_masuk"
                                                name="tanggal_masuk">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="masa_kerja_tahun" class="col-sm-4 col-form-label">Masa Kerja Tahun</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="masa_kerja_tahun"
                                                name="masa_kerja_tahun" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="masa_kerja_bulan" class="col-sm-4 col-form-label">Masa Kerja Bulan</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="masa_kerja_bulan"
                                                name="masa_kerja_bulan" readonly>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="status_pegawai"
                                            class="col-sm-4 col-form-label">{{ __('Status Pegawai') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="status_pegawai"
                                                name="status_pegawai">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="karyawan" class="col-sm-4 col-form-label">{{ __('Karyawan') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="karyawan" name="karyawan">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="sk_pengangkatan_atau_kontrak"
                                            class="col-sm-4 col-form-label">{{ __('SK Pengangkatan / Kontrak') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="sk_pengangkatan_atau_kontrak"
                                                name="sk_pengangkatan_atau_kontrak">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tanggal_pengangkatan_atau_akhir_kontrak"
                                            class="col-sm-4 col-form-label">{{ __('Tanggal Pengangkatan / Akhir Kontrak') }}</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control"
                                                id="tanggal_pengangkatan_atau_akhir_kontrak"
                                                name="tanggal_pengangkatan_atau_akhir_kontrak">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="jabatan_inka"
                                            class="col-sm-4 col-form-label">{{ __('Jabatan INKA') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="jabatan_inka"
                                                name="jabatan_inka">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="jabatan_imss"
                                            class="col-sm-4 col-form-label">{{ __('Jabatan IMSS') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="jabatan_imss"
                                                name="jabatan_imss">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="column2" class="col-sm-4 col-form-label">{{ __('Column 2') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="column2" name="column2">
                                        </div>
                                    </div>










                                    {{-- <div class="form-group row">
                                        <label for="kondisi" class="col-sm-4 col-form-label">{{ __('Kondisi') }} </label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="kondisi" name="kondisi">
                                                <option value="Baik">Baik</option>
                                                <option value="Rusak">Rusak</option>
                                                <option value="Hilang">Hilang</option>
                                            </select>
                                        </div>
                                    </div> --}}







                                    <div class="form-group row">
                                        <label for="administrasi_atau_teknisi"
                                            class="col-sm-4 col-form-label">{{ __('Administrasi / Teknisi') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="administrasi_atau_teknisi"
                                                name="administrasi_atau_teknisi">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="lokasi_kerja"
                                            class="col-sm-4 col-form-label">{{ __('Lokasi Kerja') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="lokasi_kerja"
                                                name="lokasi_kerja">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="bagian_atau_proyek"
                                            class="col-sm-4 col-form-label">{{ __('Bagian / Proyek') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="bagian_atau_proyek"
                                                name="bagian_atau_proyek">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="departemen_atau_subproyek"
                                            class="col-sm-4 col-form-label">{{ __('Departemen / Subproyek') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="departemen_atau_subproyek"
                                                name="departemen_atau_subproyek">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="divisi" class="col-sm-4 col-form-label">{{ __('Divisi') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="divisi" name="divisi">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="direktorat"
                                            class="col-sm-4 col-form-label">{{ __('Direktorat') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="direktorat" name="direktorat">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="sertifikat"
                                            class="col-sm-4 col-form-label">{{ __('Sertifikat') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="sertifikat" name="sertifikat">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="surat_peringatan"
                                            class="col-sm-4 col-form-label">{{ __('Surat Peringatan') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="surat_peringatan"
                                                name="surat_peringatan">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="jenis_kelamin" class="col-sm-4 col-form-label">{{ __('Jenis Kelamin') }}
                                        </label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                                <option value="-">-</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tempat_lahir"
                                            class="col-sm-4 col-form-label">{{ __('Tempat Lahir') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="tempat_lahir"
                                                name="tempat_lahir">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tanggal_lahir"
                                            class="col-sm-4 col-form-label">{{ __('Tanggal Lahir') }}</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="tanggal_lahir"
                                                name="tanggal_lahir">
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label for="nomor_ktp" class="col-sm-4 col-form-label">{{ __('Nomor KTP') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nomor_ktp" name="nomor_ktp">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="alamat" class="col-sm-4 col-form-label">{{ __('Alamat') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="alamat" name="alamat">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="nomor_hp" class="col-sm-4 col-form-label">{{ __('Nomor HP') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nomor_hp" name="nomor_hp">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nomor_whatsapp"
                                            class="col-sm-4 col-form-label">{{ __('Nomor Whatsapp') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nomor_whatsapp"
                                                name="nomor_whatsapp">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nomor_linkaja"
                                            class="col-sm-4 col-form-label">{{ __('Nomor LinkAja') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nomor_linkaja"
                                                name="nomor_linkaja">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-sm-4 col-form-label">{{ __('Email') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="email" name="email">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="bpjs_kesehatan"
                                            class="col-sm-4 col-form-label">{{ __('BPJS Kesehatan') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="bpjs_kesehatan"
                                                name="bpjs_kesehatan">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="bpjs_ketenagakerjaan"
                                            class="col-sm-4 col-form-label">{{ __('BPJS Ketenagakerjaan') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="bpjs_ketenagakerjaan"
                                                name="bpjs_ketenagakerjaan">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="status_pernikahan"
                                            class="col-sm-4 col-form-label">{{ __('Status Pernikahan') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="status_pernikahan"
                                                name="status_pernikahan">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="suami_atau_istri"
                                            class="col-sm-4 col-form-label">{{ __('Suami / Istri') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="suami_atau_istri"
                                                name="suami_atau_istri">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="anak_ke_1" class="col-sm-4 col-form-label">{{ __('Anak Ke-1') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="anak_ke_1" name="anak_ke_1">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="anak_ke_2" class="col-sm-4 col-form-label">{{ __('Anak Ke-2') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="anak_ke_2" name="anak_ke_2">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="anak_ke_3" class="col-sm-4 col-form-label">{{ __('Anak Ke-3') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="anak_ke_3" name="anak_ke_3">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tambahan" class="col-sm-4 col-form-label">{{ __('Tambahan') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="tambahan" name="tambahan">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="ayah_kandung"
                                            class="col-sm-4 col-form-label">{{ __('Ayah Kandung') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="ayah_kandung"
                                                name="ayah_kandung">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="ibu_kandung"
                                            class="col-sm-4 col-form-label">{{ __('Ibu Kandung') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="ibu_kandung" name="ibu_kandung">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="ayah_mertua"
                                            class="col-sm-4 col-form-label">{{ __('Ayah Mertua') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="ayah_mertua" name="ayah_mertua">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="ibu_mertua"
                                            class="col-sm-4 col-form-label">{{ __('Ibu Mertua') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="ibu_mertua" name="ibu_mertua">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="jumlah_tanggungan"
                                            class="col-sm-4 col-form-label">{{ __('Jumlah Tanggungan') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="jumlah_tanggungan"
                                                name="jumlah_tanggungan">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="status_pajak"
                                            class="col-sm-4 col-form-label">{{ __('Status Pajak') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="status_pajak"
                                                name="status_pajak">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="column1" class="col-sm-4 col-form-label">{{ __('Column 1') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="column1" name="column1">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="npwp" class="col-sm-4 col-form-label">{{ __('NPWP') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="npwp" name="npwp">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="agama" class="col-sm-4 col-form-label">{{ __('Agama') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="agama" name="agama">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="pendidikan_diakui"
                                            class="col-sm-4 col-form-label">{{ __('Pendidikan Diakui') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="pendidikan_diakui"
                                                name="pendidikan_diakui">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="jurusan" class="col-sm-4 col-form-label">{{ __('Jurusan') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="jurusan" name="jurusan">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="almamater" class="col-sm-4 col-form-label">{{ __('Almamater') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="almamater" name="almamater">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tahun_lulus"
                                            class="col-sm-4 col-form-label">{{ __('Tahun Lulus') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="tahun_lulus" name="tahun_lulus">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="pendidikan_terakhir"
                                            class="col-sm-4 col-form-label">{{ __('Pendidikan Terakhir') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="pendidikan_terakhir"
                                                name="pendidikan_terakhir">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="jurusan_terakhir"
                                            class="col-sm-4 col-form-label">{{ __('Jurusan Terakhir') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="jurusan_terakhir"
                                                name="jurusan_terakhir">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="almamater_terakhir"
                                            class="col-sm-4 col-form-label">{{ __('Almamater Terakhir') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="almamater_terakhir"
                                                name="almamater_terakhir">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tahun_lulus_terakhir"
                                            class="col-sm-4 col-form-label">{{ __('Tahun Lulus Terakhir') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="tahun_lulus_terakhir"
                                                name="tahun_lulus_terakhir">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="mpp" class="col-sm-4 col-form-label">{{ __('MPP') }}</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="mpp" name="mpp">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="pensiun" class="col-sm-4 col-form-label">{{ __('Pensiun') }}</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="pensiun" name="pensiun">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="ukuran_baju"
                                            class="col-sm-4 col-form-label">{{ __('Ukuran Baju') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="ukuran_baju" name="ukuran_baju">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="ukuran_celana"
                                            class="col-sm-4 col-form-label">{{ __('Ukuran Celana') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="ukuran_celana"
                                                name="ukuran_celana">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="ukuran_sepatu"
                                            class="col-sm-4 col-form-label">{{ __('Ukuran Sepatu') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="ukuran_sepatu"
                                                name="ukuran_sepatu">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="vaksin_1"
                                            class="col-sm-4 col-form-label">{{ __('Vaksin ke-1') }}</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="vaksin_1" name="vaksin_1">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="vaksin_2"
                                            class="col-sm-4 col-form-label">{{ __('Vaksin ke-2') }}</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="vaksin_2" name="vaksin_2">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="vaksin_3"
                                            class="col-sm-4 col-form-label">{{ __('Vaksin ke-3') }}</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="vaksin_3" name="vaksin_3">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="nomor_kontrak"
                                            class="col-sm-4 col-form-label">{{ __('Nomor Kontrak') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nomor_kontrak"
                                                name="nomor_kontrak">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="awal" class="col-sm-4 col-form-label">{{ __('Awal') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="awal" name="awal">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="akhir" class="col-sm-4 col-form-label">{{ __('Akhir') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="akhir" name="akhir">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pb_1" class="col-sm-4 col-form-label">{{ __('PB 1') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="pb_1" name="pb_1">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="nomor_kontrak2"
                                            class="col-sm-4 col-form-label">{{ __('Nomor Kontrak 2') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nomor_kontrak2"
                                                name="nomor_kontrak2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="awal2" class="col-sm-4 col-form-label">{{ __('Awal 2') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="awal2" name="awal2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="akhir2" class="col-sm-4 col-form-label">{{ __('Akhir 2') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="akhir2" name="akhir2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pb_2" class="col-sm-4 col-form-label">{{ __('PB 2') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="pb_2" name="pb_2">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="nomor_kontrak3"
                                            class="col-sm-4 col-form-label">{{ __('Nomor Kontrak 3') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nomor_kontrak3"
                                                name="nomor_kontrak3">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="awal3" class="col-sm-4 col-form-label">{{ __('Awal 3') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="awal3" name="awal3">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="akhir3" class="col-sm-4 col-form-label">{{ __('Akhir 3') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="akhir3" name="akhir3">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pb_3" class="col-sm-4 col-form-label">{{ __('PB 3') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="pb_3" name="pb_3">
                                        </div>
                                    </div>


                                </form>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default"
                                    data-dismiss="modal">{{ __('Cancel') }}</button>
                                <button id="button-save" type="button" class="btn btn-primary"
                                    onclick="$('#save').submit();">{{ __('Add') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="delete-suratkeluar">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="modal-title" class="modal-title">{{ __('Delete Karyawan') }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form" id="delete" action="{{ route('karyawan.destroy') }}"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" id="delete_id" name="delete_id">
                                </form>
                                <div>
                                    <p>Anda yakin ingin menghapus karyawan <span id="delete_name"
                                            class="font-weight-bold"></span>?</p>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default"
                                    data-dismiss="modal">{{ __('Batal') }}</button>
                                <button id="button-save" type="button" class="btn btn-danger"
                                    onclick="$('#delete').submit();">{{ __('Ya, hapus') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="import-karyawan">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Import Karyawan (Excel)</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form role="form" enctype="multipart/form-data" id="import"
                                    action="{{ route('karyawan.import') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <div class="">
                                            <input type="file" class="" id="file" name="file">
                                            {{-- <label class="" for="file">Choose file</label> --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default"
                                    data-dismiss="modal">{{ __('Batal') }}</button>
                                {{-- <button type="button" class="btn btn-default"
                                    id="download-template">{{ __('Download Template') }}</button> --}}
                                <button type="button" class="btn btn-primary"
                                    onclick="$('#import').submit();">{{ __('Import') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endauth
    </section>
@endsection
@section('custom-js')








    {{-- menghitung umur, pensiun , dan mpp --}}
    <script>
        $(document).ready(function() {
            // Fungsi untuk menghitung umur dan tanggal pensiun
            function hitungUmur() {
                // Ambil nilai tanggal lahir dari input
                var tanggalLahir = $('#tanggal_lahir').val();

                // Hitung umur
                var today = new Date();
                var birthDate = new Date(tanggalLahir);
                var age = today.getFullYear() - birthDate.getFullYear();
                var months = today.getMonth() - birthDate.getMonth();
                if (months < 0 || (months === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                // Tampilkan umur
                $('#umur').val(age + ' Tahun ' + months + ' Bulan');

                // Hitung tanggal pensiun (tambah 56 tahun)
                // var mppDate = new Date(birthDate);
                // mppDate.setFullYear(mppDate.getFullYear() + 55);
                // mppDate.setMonth(mppDate.getMonth() + 9);
                // mppDate.setDate(mppDate.getDate() + 20);
                // var pensiunDate = new Date(birthDate);
                // pensiunDate.setFullYear(pensiunDate.getFullYear() + 56);
                // pensiunDate.setMonth(pensiunDate.getMonth() + 9);
                // pensiunDate.setDate(pensiunDate.getDate() + 20);

                // Tampilkan tanggal pensiun
                $('#mpp').val(mppDate.toISOString().split('T')[0]);
                $('#pensiun').val(pensiunDate.toISOString().split('T')[0]);
            }

            // Panggil fungsi saat input tanggal lahir berubah
            $('#tanggal_lahir').on('change', function() {
                hitungUmur();
            });
        });
    </script>



    {{-- menghitung masa kerja --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function hitungMasaKerja(tglMasukStr) {
                if (!tglMasukStr) return {
                    tahun: 0,
                    bulan: 0
                };

                const masuk = new Date(tglMasukStr);
                const sekarang = new Date();

                let tahun = sekarang.getFullYear() - masuk.getFullYear();
                let bulan = sekarang.getMonth() - masuk.getMonth();
                let hari = sekarang.getDate() - masuk.getDate();

                // Jika selisih hari negatif, berarti bulan ini belum genap
                if (hari < 0) {
                    bulan -= 1;
                }

                // Jika selisih bulan negatif, berarti tahun ini belum genap
                if (bulan < 0) {
                    tahun -= 1;
                    bulan += 12;
                }

                return {
                    tahun,
                    bulan
                };
            }

            const inputTanggal = document.getElementById("tanggal_masuk");
            const inputTahun = document.getElementById("masa_kerja_tahun");
            const inputBulan = document.getElementById("masa_kerja_bulan");

            function updateMasaKerja() {
                if (!inputTanggal.value) return;
                const hasil = hitungMasaKerja(inputTanggal.value);
                inputTahun.value = hasil.tahun;
                inputBulan.value = hasil.bulan;
            }

            if (inputTanggal) {
                inputTanggal.addEventListener("change", updateMasaKerja);

                // Hitung otomatis saat halaman diload (misal saat edit data)
                if (inputTanggal.value) {
                    updateMasaKerja();
                }
            }
        });
    </script>
    {{-- end menghitung masa kerja --}}









    <script>
        // $(document).ready(function() {
        //     $("#nomor").inputmask({
        //         "mask": "999/EDP-FJ/99/9999",
        //     });
        // });

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
                    url: 'karyawan-warehouse-imss/hapus-multiple',
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

        function resetForm() {
            $('#save').trigger("reset");
            $('#kode').val('');
            $('#keterangan').val('');
        }

        function addKodeAset() {
            resetForm();
            // $('#modal-title').text("Add New Kode Aset");
            $('#button-save').text("Add");
        }

        function editKaryawan(data) {
            console.log(data)
            var title = "karyawan"
            resetForm();
            $('#modal-title').text("Edit " + title);
            $('#button-save').text("Simpan");
            $('#id').val(data.id);
            $('#nama').val(data.nama);
            $('#nip').val(data.nip);
            $('#rekening_mandiri').val(data.rekening_mandiri);
            $('#rekening_bsi').val(data.rekening_bsi);
            $('#rekrutmen').val(data.rekrutmen);
            $('#domisili').val(data.domisili);
            $('#tanggal_masuk').val(data.tanggal_masuk_asli);
            $('#masa_kerja_tahun').val(data.masa_kerja_tahun);
            $('#masa_kerja_bulan').val(data.masa_kerja_bulan);
            $('#status_pegawai').val(data.status_pegawai);
            $('#karyawan').val(data.karyawan);
            $('#sk_pengangkatan_atau_kontrak').val(data.sk_pengangkatan_atau_kontrak);
            $('#tanggal_pengangkatan_atau_akhir_kontrak').val(data.tanggal_pengangkatan_atau_akhir_kontrak_asli);
            $('#jabatan_inka').val(data.jabatan_inka);
            $('#jabatan_imss').val(data.jabatan_imss);
            $('#column2').val(data.column2);
            $('#administrasi_atau_teknisi').val(data.administrasi_atau_teknisi);
            $('#lokasi_kerja').val(data.lokasi_kerja);
            $('#bagian_atau_proyek').val(data.bagian_atau_proyek);
            $('#departemen_atau_subproyek').val(data.departemen_atau_subproyek);
            $('#divisi').val(data.divisi);
            $('#direktorat').val(data.direktorat);
            $('#sertifikat').val(data.sertifikat);
            $('#surat_peringatan').val(data.surat_peringatan);
            $('#jenis_kelamin').val(data.jenis_kelamin);
            $('#tempat_lahir').val(data.tempat_lahir);
            $('#tanggal_lahir').val(data.tanggal_lahir_asli);
            $('#nomor_ktp').val(data.nomor_ktp);
            $('#alamat').val(data.alamat);
            $('#nomor_hp').val(data.nomor_hp);
            $('#nomor_whatsapp').val(data.nomor_whatsapp);
            $('#nomor_linkaja').val(data.nomor_linkaja);
            $('#email').val(data.email);
            $('#bpjs_kesehatan').val(data.bpjs_kesehatan);
            $('#bpjs_ketenagakerjaan').val(data.bpjs_ketenagakerjaan);
            $('#status_pernikahan').val(data.status_pernikahan);
            $('#suami_atau_istri').val(data.suami_atau_istri);
            $('#anak_ke_1').val(data.anak_ke_1);
            $('#anak_ke_2').val(data.anak_ke_2);
            $('#anak_ke_3').val(data.anak_ke_3);
            $('#tambahan').val(data.tambahan);
            $('#ayah_kandung').val(data.ayah_kandung);
            $('#ibu_kandung').val(data.ibu_kandung);
            $('#ayah_mertua').val(data.ayah_mertua);
            $('#ibu_mertua').val(data.ibu_mertua);
            $('#jumlah_tanggungan').val(data.jumlah_tanggungan);
            $('#status_pajak').val(data.status_pajak);
            $('#column1').val(data.column1);
            $('#npwp').val(data.npwp);
            $('#agama').val(data.agama);
            $('#pendidikan_diakui').val(data.pendidikan_diakui);
            $('#jurusan').val(data.jurusan);
            $('#almamater').val(data.almamater);
            $('#tahun_lulus').val(data.tahun_lulus);
            $('#pendidikan_terakhir').val(data.pendidikan_terakhir);
            $('#jurusan_terakhir').val(data.jurusan_terakhir);
            $('#almamater_terakhir').val(data.almamater_terakhir);
            $('#tahun_lulus_terakhir').val(data.tahun_lulus_terakhir);
            $('#mpp').val(data.mpp_asli);
            $('#pensiun').val(data.pensiun_asli);
            $('#ukuran_baju').val(data.ukuran_baju);
            $('#ukuran_celana').val(data.ukuran_celana);
            $('#ukuran_sepatu').val(data.ukuran_sepatu);
            $('#vaksin_1').val(data.vaksin_1_asli);
            $('#vaksin_2').val(data.vaksin_2_asli);
            $('#vaksin_3').val(data.vaksin_3_asli);
            $('#nomor_kontrak').val(data.nomor_kontrak);
            $('#awal').val(data.awal);
            $('#akhir').val(data.akhir);
            $('#pb_1').val(data.pb_1);
            $('#nomor_kontrak2').val(data.nomor_kontrak2);
            $('#awal2').val(data.awal2);
            $('#akhir2').val(data.akhir2);
            $('#pb_2').val(data.pb_2);
            $('#nomor_kontrak3').val(data.nomor_kontrak3);
            $('#awal3').val(data.awal3);
            $('#akhir3').val(data.akhir3);
            $('#pb_3').val(data.pb_3);



        }

        function deletekaryawan(data) {
            $('#delete_id').val(data.id);
            $('#delete_name').text(data.nama);
        }
    </script>
    <script src="/plugins/toastr/toastr.min.js"></script>
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
