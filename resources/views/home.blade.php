@extends('layouts.main')
@section('title', __('Dashboard'))
{{-- @section('custom-css')
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
@endsection --}}
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
@section('content')
    {{-- <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            </div>
        </div>
    </div> --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6 d-flex align-items-center">
                    <i class="bi bi-person-circle" style="font-size: 2rem;"></i>
                    <h1 class="ml-2">Hi, {{ Auth::user()->name }}</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid pb-5">
            {{-- <div class="row">
                <div class="col-lg-3 col-6">
                    <a href="{{ route('surat_keluar.index') }}">
                        <div class="small-box bg-success">
                            <div class="inner" style="background-color: green;">
                                <p>Surat</p>
                                <h3>Keluar</h3>
                            </div>
                            <div class="icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                        </div>
                    </a>
                </div>





            </div> --}}


            {{-- Start Grafik PR dan PO --}}

            {{-- <div class="container">
                <p>Statistik Purchase Order & Request</p>

                <!-- Grafik PO & PR -->
                <canvas id="poChart" width="400" height="300"></canvas> <!-- Ukuran lebih kecil -->

                @php
                    // Mengambil jumlah data Purchase Order
                    $poCount = DB::table('purchase_order')->count();

                    // Mengambil jumlah data Purchase Request
                    $prCount = DB::table('purchase_request')->count();
                @endphp
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                // Data untuk grafik
                const ctx = document.getElementById('poChart').getContext('2d');

                const data = {
                    labels: ['Purchase Order', 'Purchase Request'], // Label untuk grafik
                    datasets: [{
                        label: 'Jumlah Dokumen',
                        data: [{{ $poCount }}, {{ $prCount }}], // Jumlah PO & PR
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.2)', // PO
                            'rgba(255, 99, 132, 0.2)' // PR
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)', // PO
                            'rgba(255, 99, 132, 1)' // PR
                        ],
                        borderWidth: 1
                    }]
                };

                const config = {
                    type: 'bar',
                    data: data,
                    options: {
                        responsive: false, // Non-aktifkan responsif agar ukuran tetap
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                };

                // Inisialisasi grafik
                new Chart(ctx, config);
            </script> --}}


            <div class="container mt-4">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="row g-0 align-items-center">

                        <!-- Kolom kiri (ucapan + grafik) -->
                        <div class="col-md-7 p-4">
                            <h5 class="fw-bold text-primary mb-2">
                                Selamat Datang {{ Auth::user()->name ?? 'John' }}! 🎉
                            </h5>
                            <p class="mb-3">
                                Halo Insan IMSS yang luar biasa 🎯.<br>
                                Saat Ini Total Purchase Request:
                                <strong>{{ $prCount }}</strong> dokumen dan
                                Purchase Order:
                                <strong>{{ $poCount }}</strong> dokumen.
                                {{-- <strong>{{ $poCount + $prCount }}</strong> dokumen. --}}
                            </p>

                            <!-- Grafik PO & PR -->
                            <div style="height:250px;">
                                <canvas id="poChart"></canvas>
                            </div>


                        </div>

                        <!-- Kolom kanan (ilustrasi) -->
                        <div class="col-md-5 text-center">
                            <img src="{{ asset('img/orangimss.png') }}" alt="Illustration" class="img-fluid p-3"
                                style="max-height: 420px;">

                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    let ctxPo = document.getElementById('poChart').getContext('2d');

                    new Chart(ctxPo, {
                        type: 'bar',
                        data: {
                            labels: ['Purchase Order', 'Purchase Request'],
                            datasets: [{
                                label: 'Jumlah Dokumen',
                                data: [{{ $poCount ?? 0 }}, {{ $prCount ?? 0 }}],
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 99, 132, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 99, 132, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
            </script>




            {{-- End Grafik PO & PR --}}



            <hr class="mb-4" />


            {{-- Grafik Nama pekerjaan, status dan nilai pekerjaan --}}

            <div class="row mt-3">
                <!-- Card Daftar Kontrak -->
                <div class="col-md-8">
                    <div class="card shadow-sm border-0 rounded-3 h-100">
                        <div class="card-header fw-bold">
                            <b>Daftar Kontrak Pekerjaan PT.IMSS</b>
                        </div>
                        <div class="list-group list-group-flush">
                            @foreach ($kontraks as $kontrak)
                                <div class="list-group-item d-flex align-items-start">
                                    <!-- Status -->
                                    <div style="min-width: 120px;">
                                        <span
                                            class="badge 
                                @if ($kontrak->status == 'Kontrak') bg-success 
                                @elseif($kontrak->status == 'Konfirmasi Order') bg-warning text-dark
                                @else bg-secondary @endif
                            ">
                                            {{ $kontrak->status }}
                                        </span>
                                    </div>
                                    <!-- Nama Pekerjaan -->
                                    <div class="flex-grow-1 ms-2 text-wrap">
                                        {{ $kontrak->nama_pekerjaan }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Card Ringkasan Nilai -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-3 text-center h-100">
                        <div class="card-body">
                            <div class="mb-2">
                                <img src="{{ asset('img/wallet.png') }}" alt="icon" width="140">
                            </div>
                            <h6 class="text-muted">Total Nilai Pekerjaan</h6>
                            <h4 class="fw-bold text-dark">
                                <b>Rp {{ number_format($totalNilaiPekerjaan, 0, ',', '.') }}</b>
                            </h4>
                        </div>
                    </div>
                </div>

            </div>





            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const kontraks = @json($kontraks);

                const labels = kontraks.map(item => item.nama_pekerjaan);
                const statuses = kontraks.map(item => item.status);

                const ctx = document.getElementById('kontrakChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Status Kontrak',
                            data: statuses.map(() => 1),
                            backgroundColor: statuses.map(s => {
                                if (s === 'Kontrak') return 'green';
                                if (s === 'Konfirmasi Order') return 'blue';
                                if (s === '-') return 'gray';
                                return 'red';
                            }),
                        }]
                    },
                    options: {
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Status: ' + statuses[context.dataIndex];
                                    }
                                }
                            },
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                display: false
                            } // Y-axis tidak penting, hanya tampil bar
                        }
                    }
                });
            </script>


            {{-- End Grafik Nama pekerjaan, status dan nilai pekerjaan  --}}







            {{-- Grafik Domisili --}}
            {{-- <div style="flex: 1 1 400px; max-width: 500px; text-align: center;">
                <p>Distribusi Domisili Pegawai</p>
                <canvas id="domisiliChart"></canvas>

                
                <div style="margin-top: 20px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f2f2f2;">
                                <th style="padding: 8px; border: 1px solid #ddd;">Domisili</th>
                                <th style="padding: 8px; border: 1px solid #ddd;">Jumlah Pegawai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($domisiliCounts as $domisili => $jumlah)
                                <tr>
                                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $domisili }}</td>
                                    <td style="padding: 8px; border: 1px solid #ddd; text-align: right;">{{ $jumlah }}
                                        orang</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background-color: #f2f2f2;">
                                <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Total Pegawai</td>
                                <td style="padding: 8px; border: 1px solid #ddd; text-align: right; font-weight: bold;">
                                    {{ array_sum($domisiliCounts) }} orang</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var ctxDomisili = document.getElementById('domisiliChart').getContext('2d');
                var domisiliChart = new Chart(ctxDomisili, {
                    type: 'bar',
                    data: {
                        labels: @json(array_keys($domisiliCounts)),
                        datasets: [{
                            label: 'Jumlah Pegawai',
                            data: @json(array_values($domisiliCounts)),
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Pegawai'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Domisili'
                                }
                            }
                        }
                    }
                });
            </script> --}}
            {{-- End Grafik Domisili --}}












            <hr class="mb-4" />

            {{-- Chart jumlah Karyawan --}}
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <div class="row mt-3">
                <!-- Card Grafik Jenis Kelamin -->
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 rounded-3 h-100 text-center">
                        <div class="card-header fw-bold">
                            <b>Jenis Kelamin Pegawai</b>
                        </div>
                        <div class="card-body">
                            <canvas id="genderChart"></canvas>

                            <!-- Rincian Jumlah -->
                            {{-- <div style="margin-top: 15px; text-align:center;">
                                <p style="margin: 0;"><strong>Laki-laki:</strong> {{ $maleCount }} orang</p>
                                <p style="margin: 0;"><strong>Perempuan:</strong> {{ $femaleCount }} orang</p>
                                <p style="margin: 0;"><strong>Total:</strong> {{ $maleCount + $femaleCount }} orang</p>
                            </div> --}}
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

                            <!-- Rincian Jumlah -->
                            {{-- <div style="margin-top: 15px; text-align:left;">
                                @foreach ($statusCounts as $status => $jumlah)
                                    <p style="margin: 0;">
                                        <strong>{{ $status }}:</strong> {{ $jumlah }} orang
                                    </p>
                                @endforeach
                                <p style="margin: 0;"><strong>Total:</strong> {{ array_sum($statusCounts) }} orang</p>
                            </div> --}}
                        </div>
                    </div>
                </div>




                {{-- Card Grafik Domisili --}}
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-3 h-100 text-center">
                        <div class="card-header fw-bold">
                            <b>Domisili Pegawai</b>
                        </div>
                        <div class="card-body">
                            <canvas id="domisiliChart"></canvas>

                            <!-- Wrapper tabel dengan scroll -->
                            <div style="margin-top: 20px; max-height: 250px; overflow-y: auto;">
                                <table class="table table-sm table-bordered table-striped mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 60%;">Domisili</th>
                                            <th style="width: 40%;">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($domisiliCounts as $domisili => $jumlah)
                                            <tr>
                                                <td class="text-start">{{ $domisili }}</td>
                                                <td class="text-end">{{ $jumlah }} orang</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light fw-bold">
                                        <tr>
                                            <td><b>Total Pegawai</b></td>
                                            <td class="text-end"><b>{{ array_sum($domisiliCounts) }}</b> orang</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>






            </div>

            <script>
                var ctxGender = document.getElementById('genderChart').getContext('2d');
                var genderChart = new Chart(ctxGender, {
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
                            tooltip: {
                                enabled: true
                            }
                        }
                    }
                });


                // Grafik Status Pegawai
                var ctxStatus = document.getElementById('statusChart').getContext('2d');
                var statusChart = new Chart(ctxStatus, {
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
                            tooltip: {
                                enabled: true
                            }
                        }
                    }
                });


                // Grafik Domisili
                var ctxDomisili = document.getElementById('domisiliChart').getContext('2d');
                var domisiliChart = new Chart(ctxDomisili, {
                    type: 'bar',
                    data: {
                        labels: @json(array_keys($domisiliCounts)),
                        datasets: [{
                            label: 'Jumlah Pegawai',
                            data: @json(array_values($domisiliCounts)),
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Pegawai'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Domisili'
                                }
                            }
                        }
                    }
                });
            </script>

            {{-- End Grafik Jenis Kelamin --}}








            <div class="row">




















                {{-- modal --}}
                <div class="modal fade" id="stock-form">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="modal-title" class="modal-title">{{ __('Stock In') }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row justify-content-center">
                                    <img width="300px" src="{{ asset('img/scan.jpg') }}" />
                                </div>
                                <div class="card">
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
                                        <form role="form" id="stock-update" method="post">
                                            @csrf
                                            <input type="hidden" id="pid" name="pid">
                                            <input type="hidden" id="type" name="type">
                                            <div class="form-group row">
                                                <label for="pname"
                                                    class="col-sm-4 col-form-label">{{ __('Nama Barang') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="pname" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="no_nota"
                                                    class="col-sm-4 col-form-label">{{ __('No. SJN') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="no_nota"
                                                        name="no_nota">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="name"
                                                    class="col-sm-4 col-form-label">{{ __('Nama') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="name"
                                                        name="name">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="pamount"
                                                    class="col-sm-4 col-form-label">{{ __('Jumlah') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" id="pamount"
                                                        name="pamount" min="1" value="1">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="shelf" class="col-sm-4 col-form-label">Lokasi</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control select2" style="width: 100%;"
                                                        id="shelf" name="shelf">
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="date" class="form-group row">
                                                <label for="stock_date" class="col-sm-4 col-form-label">Date</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group date" id="stock_date"
                                                        data-target-input="nearest">
                                                        <input type="text"
                                                            class="form-control datetimepicker-input stock_date_text"
                                                            id="stock_date_text" name="stock_date"
                                                            data-target="#stock_date" />
                                                        <div class="input-group-append" data-target="#stock_date"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default"
                                    data-dismiss="modal">{{ __('Close') }}</button>
                                <button id="button-update" type="button" class="btn btn-primary"
                                    onclick="stockUpdate()">{{ __('Stock In') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- coba SJN -->
                <div class="modal fade" id="stock-form1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="modal-title" class="modal-title">{{ __('SJN') }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row justify-content-center">
                                    <img width="300px" src="{{ asset('img/scan.jpg') }}" />
                                </div>
                                <div class="card">
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
                                        <form role="form" id="stock-update" method="post">
                                            @csrf
                                            <input type="hidden" id="pid" name="pid">
                                            <input type="hidden" id="type" name="type">
                                            <div class="form-group row">
                                                <label for="pname"
                                                    class="col-sm-4 col-form-label">{{ __('Nama Barang') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="pname" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="no_nota"
                                                    class="col-sm-4 col-form-label">{{ __('No. SJN') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="no_nota"
                                                        name="no_nota">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="name"
                                                    class="col-sm-4 col-form-label">{{ __('Spesifikasi') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="name"
                                                        name="name">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="pamount"
                                                    class="col-sm-4 col-form-label">{{ __('Jumlah') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" id="pamount"
                                                        name="pamount" min="1" value="1">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="shelf" class="col-sm-4 col-form-label">Lokasi</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control select2" style="width: 100%;"
                                                        id="shelf" name="shelf">
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="date" class="form-group row">
                                                <label for="stock_date" class="col-sm-4 col-form-label">Date</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group date" id="stock_date"
                                                        data-target-input="nearest">
                                                        <input type="text"
                                                            class="form-control datetimepicker-input stock_date_text"
                                                            id="stock_date_text" name="stock_date"
                                                            data-target="#stock_date" />
                                                        <div class="input-group-append" data-target="#stock_date"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default"
                                    data-dismiss="modal">{{ __('Close') }}</button>
                                <button id="button-update" type="button" class="btn btn-primary"
                                    onclick="stockUpdate()">{{ __('Stock In') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- coba SJN -->



    </section>
@endsection
@section('custom-js')
    {{-- <script src="/plugins/toastr/toastr.min.js"></script>
    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <script src="/plugins/moment/moment.min.js"></script>
    <script src="/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
    <script src="/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            $('#bisnis-menu-toggle').click(function(e) {
                e.preventDefault();
                $('#bisnis-submenu').toggle();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#pr-menu-toggle').click(function(e) {
                e.preventDefault();
                $('#pr-submenu').toggle();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#log-menu-toggle').click(function(e) {
                e.preventDefault();
                $('#log-submenu').toggle();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#sar-menu-toggle').click(function(e) {
                e.preventDefault();
                $('#sar-submenu').toggle();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#eks-menu-toggle').click(function(e) {
                e.preventDefault();
                $('#eks-submenu').toggle();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#qc-menu-toggle').click(function(e) {
                e.preventDefault();
                $('#qc-submenu').toggle();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#warehouse-menu-toggle').click(function(e) {
                e.preventDefault();
                $('#warehouse-submenu').toggle();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#sdm-menu-toggle').click(function(e) {
                e.preventDefault();
                $('#sdm-submenu').toggle();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#keu-menu-toggle').click(function(e) {
                e.preventDefault();
                $('#keu-submenu').toggle();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#ser-menu-toggle').click(function(e) {
                e.preventDefault();
                $('#ser-submenu').toggle();
            });
        });
    </script>




    <script>
        $(function() {
            $('#form').hide();
            loader(0);
            $('.select2').select2({
                theme: 'bootstrap4'
            });
            $('#stock_date').datetimepicker({
                viewMode: 'years',
                format: 'MM/DD/YYYY HH:mm:ss'
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $('#pcode').on('input', function() {
            $("#form").hide();
            $("#button-update").hide();
        });

        function resetForm() {
            $('#form').trigger("reset");
            $('#pcode').val('');
            $("#button-update").hide();
            $("#date").hide();
            $('#pcode').prop("disabled", false);
            $('#button-check').prop("disabled", false);
        }

        function stockForm(type = 1) {
            $("#form").hide();
            resetForm();
            $("#type").val(type);
            //remove #proyek_id first
            $('#form').find('.card-body').find('#proyek_id').parent().parent().remove();
            if (type == 0) {
                $('#modal-title').text("Stock Out");
                $('#button-update').text("Stock Out");
                $("#date").show();

                //find child in #form with class .card-body then append
                $('#form').find('.card-body').append(
                    '<div class="form-group row"><label for="proyek_id" class="col-sm-4 col-form-label">Keproyekan</label><div class="col-sm-8"><select class="form-control select2" style="width: 100%;" id="proyek_id" name="proyek_id"></select></div></div>'
                );

            } else if (type == 1) {
                $('#modal-title').text("Stock In");
                $('#button-update').text("Stock In");
                $("#date").show();
                //remove the proyek_id
                $('#form').find('.card-body').find('#proyek_id').parent().parent().remove();
            } else {
                $('#modal-title').text("Retur");
                $('#button-update').text("Retur");
                $("#date").hide();
                //remove the proyek_id
                $('#form').find('.card-body').find('#proyek_id').parent().parent().remove();
            }
        }

        function getProyek(val) {
            $.ajax({
                url: "{{ url('products/keproyekan') }}",
                type: "GET",
                data: {
                    "format": "json"
                },
                dataType: "json",
                success: function(data) {
                    $('#proyek_id').empty();
                    $('#proyek_id').append('<option value="">.:: Select Proyek::.</option>');
                    $.each(data, function(key, value) {
                        if (value.id == val) {
                            $('#proyek_id').append('<option value="' + value.id + '" selected>' + value
                                .nama_proyek + '</option>');
                        } else {

                            $('#proyek_id').append('<option value="' + value.id + '">' + value
                                .nama_proyek + '</option>');
                        }
                    });
                }
            });
        }

        function getShelf(pid = null) {
            var type = $('#type').val();
            $.ajax({
                url: "{{ url('/products/shelf') }}",
                type: "GET",
                data: {
                    "format": "json",
                    "product_id": pid
                },
                dataType: "json",
                success: function(data) {
                    $('#shelf').empty();
                    $('#shelf').append('<option value="">.:: Select Shelf ::.</option>');
                    $.each(data, function(key, value) {
                        if (type == 0) {
                            $('#shelf').append('<option value="' + value.shelf_id + '">' + value
                                .shelf_name + '</option>');
                        } else {
                            $('#shelf').append('<option value="' + value.shelf_id + '">' + value
                                .shelf_name + '</option>');
                        }
                    });
                }
            });
        }

        function enableStockInput() {
            $('#button-update').prop("disabled", false);
            $("#button-update").show();
            $('#form').show();
        }

        function disableStockInput() {
            $('#button-update').prop("disabled", true);
            $("#button-update").hide();
            $('#form').hide();
        }

        function loader(status = 1) {
            if (status == 1) {
                $('#loader').show();
            } else {
                $('#loader').hide();
            }
        }

        function productCheck() {
            var pcode = $('#pcode').val();
            if (pcode.length > 0) {
                loader();
                $('#form').hide();
                $('#pcode').prop("disabled", true);
                $('#button-check').prop("disabled", true);
                $.ajax({
                    url: "{{ url('/products/check/') }}" + "/" + pcode,
                    type: "GET",
                    data: {
                        "format": "json"
                    },
                    dataType: "json",
                    success: function(data) {
                        loader(0);
                        if (data.status == 1) {
                            $('#pid').val(data.data.product_id);
                            $('#pcode').val(data.data.product_code);
                            $('#pname').val(data.data.product_name);
                            if ($('#type').val() == 0) {
                                getShelf($('#pid').val());
                                getProyek();
                            } else {
                                getShelf();
                            }
                            enableStockInput();
                        } else {
                            disableStockInput();
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

        function stockUpdate() {
            loader();
            $('#pcode').prop("disabled", true);
            $('#button-check').prop("disabled", true);
            $('#button-update').prop("disabled", true);
            disableStockInput();
            var data = {
                product_id: $('#pid').val(),
                name: $('#name').val(),
                no_nota: $('#no_nota').val(),
                amount: $('#pamount').val(),
                stock_date: $('#stock_date_text').val(),
                shelf: $('#shelf').val(),
                type: $('#type').val(),
                proyek_id: $('#proyek_id').val()
            }

            $.ajax({
                url: "{{ url('/products/stockUpdate') }}",
                type: "post",
                data: JSON.stringify(data),
                dataType: "json",
                contentType: 'application/json',
                success: function(data) {
                    loader(0);
                    if (data.status == 1) {
                        toastr.success(data.message);
                        resetForm();
                    } else {
                        toastr.error(data.message);
                        enableStockInput();
                        $('#pcode').prop("disabled", false);
                        $('#button-check').prop("disabled", false);
                    }
                },
                error: function() {
                    loader(0);
                    toastr.error("Unknown error! Please try again later!");
                    resetForm();
                }
            });
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
