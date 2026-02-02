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
<style>
    /* Background dashboard */
    #tab-pemasaran {
        /* background: linear-gradient(180deg, #0f172a, #020617); */
        /* min-height: 100vh; */
        /* padding: 30px; */
    }

    /* Card */
    .card-tv {
        border-radius: 18px;
        border: none;
        box-shadow: 0 12px 30px rgba(0, 0, 0, .4);
    }

    /* Header */
    .card-header-tv {
        background: transparent;
        padding: 12px 16px;
        font-weight: 700;
        font-size: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, .1);
    }

    /* Chart kecil di header */
    .chart-mini {
        height: 100px;
        margin-top: 6px;
    }

    /* List kontrak */
    .list-kontrak-tv {
        overflow: hidden;
        width: 100%;
        min-height: 360px;
    }

    /* Item kontrak */
    .item-kontrak-tv {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        font-size: 1.0rem;
        height: 60px;

    }

    /* Badge status kecil */
    .status-kontrak {
        min-width: 110px;
        padding: 6px 10px;
        font-size: 0.8rem;
        border-radius: 10px;
        text-align: center;
    }

    /* Nama pekerjaan */
    .nama-kontrak {
        line-height: 1.3;
        font-weight: 500;
    }

    /* Chart kanan */
    .chart-body {
        height: 250px;
        padding: 10px;
    }

    /* Scrollbar */

    /* daftar kontrak */


    .kontrak-slide {
        display: grid !important;
        grid-auto-flow: column;
        grid-template-rows: repeat(10, 1fr);
        grid-auto-columns: 100%;
        gap: 10px;
        transition: transform 1.5s ease-in-out;
    }

    .kontrak-col {
        display: contents;
        /* biar grid ngatur itemnya */
    }


    #dashboardFullscreen:fullscreen {
        background: #fff;
        padding: 15px;
        overflow: auto;
    }

    /* Firefox */
    #dashboardFullscreen:-moz-full-screen {
        background: #fff;
        padding: 15px;
    }

    /* Safari */
    #dashboardFullscreen:-webkit-full-screen {
        background: #fff;
        padding: 15px;
    }

    /* Optional: grafik biar maksimal */
    #dashboardFullscreen canvas {
        max-height: 90vh;
    }



    #tab-pemasaran {
        /* background: linear-gradient(135deg, #dc3545, #8c1d18); */
        padding: 1px;
        /* min-height: 100vh; */
    }

    .slide-pemasaran {
        background: transparent;
    }

    .card-tv {
        background: linear-gradient(180deg, #ffffff, #e9e9e9);
        border-radius: 16px;
        border: none;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        overflow: hidden;
    }

    .card-tv.mt-3 {
        margin-top: 2px !important;
    }


    /* Responsive HP grafik PO&PR */
    .chart-scroll {
        width: 100%;
        overflow-x: auto;
    }

    .chart-wrapper {
        position: relative;
        min-width: 720px;
        height: 650px;
    }

    @media (max-width: 576px) {
        .chart-wrapper {
            min-width: 900px;
            height: 320px;
        }
    }
</style>
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

            <button id="btnFullscreen" class="btn btn-sm btn-danger mb-2">
                ⛶ Fullscreen
            </button>

            <div id="dashboardFullscreen">
                {{-- ================= TAB NAV ================= --}}
                <ul class="nav nav-tabs mb-3" id="dashboardTabs">
                    <li class="nav-item">
                        <a class="nav-link" data-tab="pemasaran" href="javascript:void(0)">Pemasaran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" data-tab="wilayah" href="javascript:void(0)">Wilayah & Log</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-tab="sdm" href="javascript:void(0)">SDM</a>
                    </li>
                </ul>

                {{-- ================= TAB WILAYAH ================= --}}
                <div class="dashboard-tab" id="tab-wilayah">

                    <div class="card card-tv">
                        <div class="card-header card-header-tv text-center">
                            Jumlah PO & PR/SPPJP per Proyek
                        </div>

                        <div class="card-body slide slide-wilayah">

                            <!-- ISI TETAP -->
                            <h5 class="fw-bold mb-3 d-none">
                                Jumlah PO & PR/SPPJP per Proyek
                            </h5>

                            <div class="chart-scroll">
                                <div class="chart-wrapper">
                                    <canvas id="poPrPerProyekChart"></canvas>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>


                {{-- ================= TAB PEMASARAN ================= --}}
                <div class="dashboard-tab d-none" id="tab-pemasaran">
                    <div class="slide slide-pemasaran container-fluid">

                        <h5 id="judulTahun" class="fw-bold mb-3 text-center"></h5>

                        <div class="row g-3 justify-content-center">

                            <!-- KIRI : DAFTAR KONTRAK -->
                            <div class="col-md-4">
                                <div class="card card-tv">

                                    <div class="card-header card-header-tv">
                                        <div>Daftar Kontrak</div>
                                        {{-- <div class="chart-mini">
                                        <canvas id="kontrakChart"></canvas>
                                    </div> --}}
                                    </div>

                                    <div class="list-group list-group-flush list-kontrak-tv" id="kontrakSlideshow">
                                        <div class="kontrak-slide">

                                            @foreach ($kontraks->chunk(10) as $chunk)
                                                <div class="kontrak-col">
                                                    @foreach ($chunk as $kontrak)
                                                        <div
                                                            class="list-group-item item-kontrak-tv d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <div class="fw-bold"><b>{{ $kontrak->nama_pekerjaan }}</b>
                                                                </div>
                                                                <small class="text-muted">Tahun
                                                                    {{ $kontrak->tahun }}</small>
                                                            </div>
                                                            {{-- <span class="badge pelanggan-badge">
                                                            {{ $kontrak->nama_pelanggan }}
                                                        </span> --}}
                                                            <span class="badge pelanggan-badge"
                                                                data-pelanggan="{{ $kontrak->nama_pelanggan }}">
                                                                {{ $kontrak->nama_pelanggan }}
                                                            </span>

                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach


                                        </div>
                                    </div>



                                </div>
                            </div>

                            <!-- KANAN : DISTRIBUSI PELANGGAN -->
                            <div class="col-md-8">
                                <div class="card card-tv ">

                                    <div class="card-header card-header-tv text-center">
                                        Distribusi Pelanggan
                                    </div>

                                    <div class="card-body chart-body">
                                        <canvas id="pelangganPieChart"></canvas>
                                    </div>

                                </div>
                                <div class="card card-tv mt-3">
                                    <div class="card-header card-header-tv text-center">
                                        Jumlah Kontrak per Tahun
                                    </div>
                                    <div class="card-body">
                                        <canvas id="kontrakBarChart"></canvas>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>



                {{-- ================= TAB SDM ================= --}}
                <div class="dashboard-tab d-none" id="tab-sdm">
                    <div class="slide slide-sdm">
                        <div class="row">

                            <!-- BAR CHART - LOKASI KERJA -->
                            <div class="col-md-7">
                                <div class="card card-tv">
                                    <div class="card-header py-2 bg-white">
                                        <h6 class="m-0 font-weight-bold" style="text-align: center">
                                            Lokasi Kerja Karyawan
                                        </h6>
                                    </div>
                                    <div class="card-body p-2">
                                        <canvas id="lokasiKerjaChart" style="height:250px;"></canvas>
                                    </div>
                                </div>
                            </div>

                            <!-- PIE CHARTS -->
                            <div class="col-md-5">
                                <div class="row">

                                    <!-- PIE GENDER -->
                                    <div class="col-12 mb-2">
                                        <div class="card card-tv">
                                            <div class="card-header py-2 bg-white">
                                                <h6 class="m-0 font-weight-bold" style="text-align: center">
                                                    Jenis Kelamin
                                                </h6>
                                            </div>
                                            <div class="card-body p-2">
                                                <canvas id="genderChart" style="height:30px;"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- PIE STATUS -->
                                    <div class="col-12">
                                        <div class="card card-tv">
                                            <div class="card-header py-2 bg-white">
                                                <h6 class="m-0 font-weight-bold" style="text-align: center">
                                                    Status Pegawai
                                                </h6>
                                            </div>
                                            <div class="card-body p-2">
                                                <canvas id="statusChart" style="height:30px;"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>



            {{-- Button untuk Fullscreen --}}
            <script>
                document.getElementById('btnFullscreen').addEventListener('click', function() {
                    const el = document.getElementById('dashboardFullscreen');

                    if (!document.fullscreenElement) {
                        el.requestFullscreen().catch(err => {
                            alert(`Fullscreen error: ${err.message}`);
                        });
                    } else {
                        document.exitFullscreen();
                    }
                });
            </script>
            <script>
                document.addEventListener('fullscreenchange', () => {
                    if (window.Chart) {
                        Chart.helpers.each(Chart.instances, chart => {
                            chart.resize();
                        });
                    }
                });
            </script>

            {{-- End Button untuk Fullscreen --}}



            {{-- Grafik Lokasi Kerja SDM --}}
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>


            <script>
                Chart.register(ChartDataLabels);

                const lokasiKerjaData = @json($lokasiKerjaCounts);

                const lokasiLabels = Object.keys(lokasiKerjaData);
                const lokasiValues = Object.values(lokasiKerjaData);

                const ctxLokasi = document.getElementById('lokasiKerjaChart');

                new Chart(ctxLokasi, {
                    type: 'bar',
                    data: {
                        labels: lokasiLabels,
                        datasets: [{
                            label: 'Jumlah Lokasi Kerja',
                            data: lokasiValues,
                            backgroundColor: [
                                '#4e73df',
                                '#1cc88a',
                                '#36b9cc',
                                '#f6c23e',
                                '#e74a3b'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Lokasi Kerja Karyawan'
                            },
                            datalabels: {
                                anchor: 'end',
                                align: 'top',
                                color: '#000',
                                font: {
                                    weight: 'bold'
                                },
                                formatter: (value) => value
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            </script>







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




            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            {{-- Menampilkan Grafik PR dan PO --}}
            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    const proyekData = @json($poPrPerProyek);

                    const isMobile = window.innerWidth <= 576;

                    const fontSizeLabel = isMobile ? 10 : 12;
                    const fontSizeLegend = isMobile ? 11 : 14;
                    const fontSizeValue = isMobile ? 10 : 12;

                    const barThicknessSize = isMobile ? 14 : 22;

                    /* =============================
                       FUNGSI MULTI BARIS (TIDAK POTONG TEKS)
                    ============================== */
                    function wrapLabel(text, maxLength = isMobile ? 10 : 16) {
                        if (!text) return [''];

                        const words = text.split(' ');
                        const lines = [];
                        let currentLine = '';

                        words.forEach(word => {
                            if ((currentLine + ' ' + word).trim().length <= maxLength) {
                                currentLine = (currentLine + ' ' + word).trim();
                            } else {
                                lines.push(currentLine);
                                currentLine = word;
                            }
                        });

                        if (currentLine) lines.push(currentLine);

                        return lines; // ← PENTING: array
                    }

                    const labels = proyekData.map(item => wrapLabel(item.nama_pekerjaan));
                    const dataPO = proyekData.map(item => item.total_po);
                    const dataPR = proyekData.map(item => item.total_pr);

                    const ctx = document.getElementById('poPrPerProyekChart').getContext('2d');

                    /* =============================
                       ANGKA DI ATAS BAR
                    ============================== */
                    const valueLabelPlugin = {
                        id: 'valueLabel',
                        afterDatasetsDraw(chart) {
                            const ctx = chart.ctx;
                            ctx.save();
                            ctx.font = `bold ${fontSizeValue}px Arial`;
                            ctx.fillStyle = '#111';
                            ctx.textAlign = 'center';

                            chart.data.datasets.forEach((dataset, i) => {
                                if (!chart.isDatasetVisible(i)) return;

                                const meta = chart.getDatasetMeta(i);
                                meta.data.forEach((bar, index) => {
                                    const value = dataset.data[index];
                                    if (value > 0) {
                                        ctx.fillText(value, bar.x, bar.y - 4);
                                    }
                                });
                            });

                            ctx.restore();
                        }
                    };

                    /* =============================
                       CHART
                    ============================== */
                    new Chart(ctx, {
                        type: 'bar',
                        plugins: [valueLabelPlugin],
                        data: {
                            labels,
                            datasets: [{
                                    label: 'PO',
                                    data: dataPO,
                                    backgroundColor: '#2E86DE',
                                    borderRadius: 8,
                                    barThickness: barThicknessSize
                                },
                                {
                                    label: 'PR',
                                    data: dataPR,
                                    backgroundColor: '#E74C3C',
                                    borderRadius: 8,
                                    barThickness: barThicknessSize
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,

                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        font: {
                                            size: fontSizeLegend,
                                            weight: 'bold'
                                        }
                                    }
                                }
                            },

                            scales: {
                                x: {
                                    ticks: {
                                        autoSkip: false,
                                        maxRotation: 0,
                                        minRotation: 0,
                                        padding: 10,
                                        font: {
                                            size: fontSizeLabel,
                                            weight: 'bold'
                                        }
                                    },
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        font: {
                                            size: 11
                                        }
                                    },
                                    title: {
                                        display: true,
                                        text: 'Jumlah Dokumen',
                                        font: {
                                            size: 13,
                                            weight: 'bold'
                                        }
                                    }
                                }
                            }
                        }
                    });

                });
            </script>



            {{-- End Grafik PO & PR --}}



            {{-- <hr class="mb-4" /> --}}


            {{-- Grafik Nama pekerjaan, status dan nilai pekerjaan --}}
            {{-- <div class="row mt-3">
                <!-- Card Daftar Kontrak -->
                <div class="col-md-8">
                    <div class="card shadow-sm border-0 rounded-3 h-100">
                        <div class="card-header fw-bold">
                            <canvas id="kontrakChart"></canvas>
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


                <div class="col-md-6 mt-4">
                    <div class="card shadow-sm border-0 rounded-3 h-100 text-center">
                        <div class="card-header fw-bold">
                            <b>Nama Pekerjaan</b>
                        </div>
                        <div class="card-body">
                            <canvas id="nilaiPekerjaanChart"></canvas>

                            <!-- Tabel dengan scroll -->
                            <div style="margin-top: 20px; max-height: 250px; overflow-y: auto;">
                                <table class="table table-sm table-bordered table-striped mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 60%;">Nama Pekerjaan</th>
                                            <th style="width: 40%;">Total Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($nilaiPekerjaanCounts as $nama => $nilai)
                                            <tr>
                                                <td class="text-start">{{ $nama }}</td>
                                                <td class="text-end">Rp {{ number_format($nilai, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>







            </div> --}}





            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            {{-- Nilai Pekerjaan grafik Pemasaran --}}
            {{-- <script>
                document.addEventListener('DOMContentLoaded', function() {

                    const rawData = @json($nilaiPekerjaanPerTahun);
                    if (!rawData.length) return;

                    /* ================= SPLIT LABEL MULTI BARIS ================= */
                    function splitLabel(text, maxLength = 18) {
                        if (!text) return '';
                        const words = text.split(' ');
                        let lines = [''];

                        words.forEach(word => {
                            const last = lines[lines.length - 1];
                            if ((last + ' ' + word).trim().length <= maxLength) {
                                lines[lines.length - 1] = (last + ' ' + word).trim();
                            } else {
                                lines.push(word);
                            }
                        });

                        return lines;
                    }

                    const proyekList = [...new Set(rawData.map(d => d.nama_pekerjaan))]
                        .map(nama => splitLabel(nama));

                    const tahunList = [...new Set(rawData.map(d => d.tahun))].sort();

                    /* ================= WARNA SOLID MODERN ================= */
                    const solidColors = [
                        '#4F8DF7', // biru
                        '#F76C6C', // merah
                        '#43C59E', // hijau
                        '#8E7CFF', // ungu
                        '#F4B942' // kuning
                    ];

                    const ctx = document
                        .getElementById('nilaiPekerjaanPerTahunChart')
                        .getContext('2d');

                    /* ================= SHADOW 3D ================= */
                    const shadowPlugin = {
                        id: 'shadow',
                        beforeDatasetsDraw(chart) {
                            const ctx = chart.ctx;
                            ctx.save();
                            ctx.shadowColor = 'rgba(0,0,0,0.30)';
                            ctx.shadowBlur = 12;
                            ctx.shadowOffsetX = 4;
                            ctx.shadowOffsetY = 6;
                        },
                        afterDatasetsDraw(chart) {
                            chart.ctx.restore();
                        }
                    };

                    /* ================= ANGKA DI ATAS BAR ================= */
                    const valueLabelPlugin = {
                        id: 'valueLabel',
                        afterDatasetsDraw(chart) {
                            const ctx = chart.ctx;
                            ctx.save();
                            ctx.font = 'bold 12px Arial';
                            ctx.fillStyle = '#111';
                            ctx.textAlign = 'center';

                            chart.data.datasets.forEach((dataset, i) => {
                                if (!chart.isDatasetVisible(i)) return;

                                const meta = chart.getDatasetMeta(i);
                                meta.data.forEach((bar, index) => {
                                    const value = dataset.data[index];
                                    if (value > 0) {
                                        ctx.fillText(
                                            (value / 1_000_000).toLocaleString('id-ID') + ' jt',
                                            bar.x,
                                            bar.y - 8
                                        );
                                    }
                                });
                            });

                            ctx.restore();
                        }
                    };

                    /* ================= DATASET ================= */
                    const datasets = tahunList.map((tahun, index) => {

                        const data = proyekList.map(labelArr => {
                            const namaAsli = labelArr.join(' ');
                            const row = rawData.find(
                                d => d.tahun === tahun && d.nama_pekerjaan === namaAsli
                            );
                            return row ? row.total_nilai : 0;
                        });

                        return {
                            label: tahun,
                            data,
                            backgroundColor: solidColors[index % solidColors.length],
                            borderRadius: 10,
                            barThickness: 28,
                            maxBarThickness: 32
                        };
                    });

                    /* ================= RENDER CHART ================= */
                    new Chart(ctx, {
                        type: 'bar',
                        plugins: [shadowPlugin, valueLabelPlugin],
                        data: {
                            labels: proyekList,
                            datasets
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,

                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        padding: 18,
                                        font: {
                                            size: 14,
                                            weight: 'bold'
                                        },
                                        generateLabels(chart) {
                                            return chart.data.datasets.map((ds, i) => ({
                                                text: ds.label,
                                                fillStyle: ds.backgroundColor,
                                                strokeStyle: ds.backgroundColor,
                                                hidden: !chart.isDatasetVisible(i),
                                                datasetIndex: i
                                            }));
                                        }
                                    }
                                    // legend default → clickable ✔
                                },

                                tooltip: {
                                    callbacks: {
                                        label: ctx =>
                                            ctx.dataset.label +
                                            ' : Rp ' +
                                            ctx.parsed.y.toLocaleString('id-ID')
                                    },
                                    titleFont: {
                                        size: 14,
                                        weight: 'bold'
                                    },
                                    bodyFont: {
                                        size: 13
                                    }
                                }
                            },

                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        autoSkip: false,
                                        font: {
                                            size: 12
                                        },
                                        padding: 10
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0,0,0,0.08)',
                                        borderDash: [5, 5]
                                    },
                                    ticks: {
                                        font: {
                                            size: 12
                                        },
                                        callback: v =>
                                            'Rp ' + (v / 1_000_000).toLocaleString('id-ID') + ' jt'
                                    }
                                }
                            }
                        }
                    });

                });
            </script> --}}

            <script>
                document.addEventListener("DOMContentLoaded", function() {

                    /* =========================================================
                       🏷️ WARNA BADGE / DAFTAR KONTRAK (TETAP SENDIRI)
                    ========================================================= */
                    const badgeColors = [
                        '#fd7e14', '#198754', '#0d6efd', '#dc3545',
                        '#6f42c1', '#20c997', '#0dcaf0', '#6c757d'
                    ];

                    function hashString(str) {
                        let hash = 0;
                        for (let i = 0; i < str.length; i++) {
                            hash = str.charCodeAt(i) + ((hash << 5) - hash);
                        }
                        return Math.abs(hash);
                    }

                    function getBadgeColor(name) {
                        return badgeColors[hashString(name) % badgeColors.length];
                    }

                    document.querySelectorAll('.pelanggan-badge').forEach(badge => {
                        const nama = badge.dataset.pelanggan;
                        if (!nama) return;
                        badge.style.backgroundColor = getBadgeColor(nama);
                        badge.style.color = '#fff';
                    });

                    /* =========================================================
                       🎨 AUTO COLOR GENERATOR (UNTUK PIE CHART SAJA)
                       - TIDAK DIPATOK WARNA
                       - TIDAK TERKAIT BADGE
                    ========================================================= */
                    function generateAutoColors(count) {
                        return Array.from({
                            length: count
                        }, (_, i) => {
                            const hue = Math.round((360 / count) * i);
                            return `hsl(${hue}, 65%, 55%)`;
                        });
                    }

                    /* =========================================================
                       📊 DOUGHNUT CHART DISTRIBUSI PELANGGAN
                    ========================================================= */
                    const pelangganData = @json($pelangganCounts);

                    const labels = Object.keys(pelangganData);
                    const values = Object.values(pelangganData);

                    const backgroundColors = generateAutoColors(labels.length);

                    const ctx = document
                        .getElementById('pelangganPieChart')
                        .getContext('2d');

                    /* 🔢 Plugin angka di setiap slice */
                    const valueLabelPlugin = {
                        id: 'valueLabel',
                        afterDatasetDraw(chart) {
                            const {
                                ctx
                            } = chart;
                            const meta = chart.getDatasetMeta(0);
                            const data = chart.data.datasets[0].data;

                            ctx.save();
                            ctx.font = '600 13px Inter, sans-serif';
                            ctx.fillStyle = '#ffffff';
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';

                            meta.data.forEach((arc, i) => {
                                if (!data[i]) return;
                                const pos = arc.tooltipPosition();
                                ctx.fillText(data[i], pos.x, pos.y);
                            });

                            ctx.restore();
                        }
                    };

                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: values,
                                backgroundColor: backgroundColors, // ⬅️ AUTO WARNA
                                borderWidth: 3,
                                borderColor: '#ffffff',
                                hoverOffset: 10,
                                spacing: 3
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '65%',
                            animation: {
                                duration: 1000,
                                easing: 'easeOutQuart'
                            },
                            plugins: {
                                legend: {
                                    position: 'right',
                                    labels: {
                                        boxWidth: 14,
                                        boxHeight: 14,
                                        padding: 14,
                                        font: {
                                            size: 14,
                                            weight: '600'
                                        }
                                    }
                                },
                                tooltip: {
                                    backgroundColor: '#020617',
                                    titleColor: '#f8fafc',
                                    bodyColor: '#e5e7eb',
                                    padding: 12,
                                    cornerRadius: 10,
                                    callbacks: {
                                        label: (ctx) => `${ctx.label}: ${ctx.raw}`
                                    }
                                }
                            }
                        },
                        plugins: [valueLabelPlugin]
                    });

                });
            </script>



            {{-- Jumlah Kontrak Pemasaran Grafik Bar --}}
            <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

            <script>
                const kontrakPerTahunLabels = {!! json_encode(array_keys($kontrakPerTahun)) !!};
                const kontrakPerTahunData = {!! json_encode(array_values($kontrakPerTahun)) !!};

                const warnaTahun = [
                    '#4e73df',
                    '#1cc88a',
                    '#36b9cc',
                    '#f6c23e',
                    '#e74a3b',
                    '#858796',
                    '#6f42c1',
                ];

                const ctxKontrak = document.getElementById('kontrakBarChart').getContext('2d');

                new Chart(ctxKontrak, {
                    type: 'bar',
                    data: {
                        labels: kontrakPerTahunLabels,
                        datasets: [{
                            data: kontrakPerTahunData,
                            backgroundColor: kontrakPerTahunLabels.map(
                                (_, index) => warnaTahun[index % warnaTahun.length]
                            ),
                            borderRadius: 8,
                            barThickness: 32
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                top: 30 // ⬅️ RUANG KHUSUS ANGKA
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            datalabels: {
                                display: true, // ⬅️ PAKSA TAMPIL
                                anchor: 'end',
                                align: 'end',
                                offset: 4,
                                clamp: true, // ⬅️ ANTI KEPOTONG
                                clip: false, // ⬅️ ANTI KEHILANGAN
                                color: '#111',
                                font: {
                                    weight: 'bold',
                                    size: 12
                                },
                                formatter: (value) => value
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 14, // opsional: biar lebih kebaca
                                        weight: 'bold' // ⬅️ INI KUNCINYA
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grace: '10%',
                                ticks: {
                                    precision: 0
                                },
                                grid: {
                                    color: '#f1f1f1'
                                }
                            }
                        }

                    },
                    plugins: [ChartDataLabels]
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












            {{-- <hr class="mb-4" /> --}}


            {{-- Chart SDM --}}
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            {{-- <div class="row mt-3">
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







            </div> --}}

            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    /* =====================================================
                       GLOBAL STYLE
                    ===================================================== */
                    Chart.defaults.font.family = 'Arial, sans-serif';
                    Chart.defaults.font.size = 12;
                    Chart.defaults.color = '#333';

                    /* =====================================================
                       SHADOW PLUGIN (EFEK MODERN)
                    ===================================================== */
                    const shadowPlugin = {
                        id: 'shadow',
                        beforeDatasetsDraw(chart) {
                            const ctx = chart.ctx;
                            ctx.save();
                            ctx.shadowColor = 'rgba(0,0,0,0.25)';
                            ctx.shadowBlur = 10;
                            ctx.shadowOffsetX = 3;
                            ctx.shadowOffsetY = 4;
                        },
                        afterDatasetsDraw(chart) {
                            chart.ctx.restore();
                        }
                    };

                    /* =====================================================
                       PIE VALUE (ANGKA DI SLICE PIE)
                    ===================================================== */
                    const pieValuePlugin = {
                        id: 'pieValue',
                        afterDatasetsDraw(chart) {
                            if (!['pie', 'doughnut'].includes(chart.config.type)) return;

                            const ctx = chart.ctx;
                            ctx.save();
                            ctx.font = 'bold 13px Arial';
                            ctx.fillStyle = '#fff';
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';

                            chart.getDatasetMeta(0).data.forEach((arc, i) => {
                                const value = chart.data.datasets[0].data[i];
                                if (!value) return;

                                const pos = arc.tooltipPosition();
                                ctx.fillText(value, pos.x, pos.y);
                            });

                            ctx.restore();
                        }
                    };

                    /* =====================================================
                       CENTER TEXT DOUGHNUT
                    ===================================================== */
                    const centerTextPlugin = {
                        id: 'centerText',
                        afterDraw(chart) {
                            if (chart.config.type !== 'doughnut') return;

                            const {
                                ctx,
                                chartArea
                            } = chart;
                            if (!chartArea) return;

                            const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            const x = (chartArea.left + chartArea.right) / 2;
                            const y = (chartArea.top + chartArea.bottom) / 2;

                            ctx.save();
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';

                            ctx.font = 'bold 22px Arial';
                            ctx.fillStyle = '#111';
                            ctx.fillText(total, x, y - 8);

                            ctx.font = '12px Arial';
                            ctx.fillStyle = '#666';
                            ctx.fillText('Total Pegawai', x, y + 16);

                            ctx.restore();
                        }
                    };

                    /* =====================================================
                       BAR VALUE (ANGKA DI ATAS BAR)
                    ===================================================== */
                    const barValuePlugin = {
                        id: 'barValue',
                        afterDatasetsDraw(chart) {
                            if (chart.config.type !== 'bar') return;

                            const ctx = chart.ctx;
                            ctx.save();
                            ctx.font = 'bold 12px Arial';
                            ctx.fillStyle = '#111';
                            ctx.textAlign = 'center';

                            chart.data.datasets.forEach((dataset, i) => {
                                const meta = chart.getDatasetMeta(i);
                                meta.data.forEach((bar, index) => {
                                    const value = dataset.data[index];
                                    ctx.fillText(value, bar.x, bar.y - 8);
                                });
                            });

                            ctx.restore();
                        }
                    };

                    /* =====================================================
                       PIE GENDER
                    ===================================================== */
                    new Chart(document.getElementById('genderChart'), {
                        type: 'pie',
                        plugins: [shadowPlugin, pieValuePlugin],
                        data: {
                            labels: ['Laki-laki', 'Perempuan'],
                            datasets: [{
                                data: [{{ $maleCount }}, {{ $femaleCount }}],
                                backgroundColor: ['#4FACFE', '#FA709A'],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        boxWidth: 14,
                                        font: {
                                            weight: 'bold'
                                        }
                                    }
                                }
                            }
                        }
                    });

                    /* =====================================================
                       DOUGHNUT STATUS PEGAWAI
                    ===================================================== */
                    new Chart(document.getElementById('statusChart'), {
                        type: 'doughnut',
                        plugins: [shadowPlugin, centerTextPlugin, pieValuePlugin],
                        data: {
                            labels: {!! json_encode(array_keys($statusCounts)) !!},
                            datasets: [{
                                data: {!! json_encode(array_values($statusCounts)) !!},
                                backgroundColor: [
                                    '#43E97B',
                                    '#F9D423',
                                    '#667EEA',
                                    '#38F9D7',
                                    '#FA709A'
                                ],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '68%',
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        boxWidth: 14,
                                        font: {
                                            weight: 'bold'
                                        }
                                    }
                                }
                            }
                        }
                    });




                });
            </script>




            {{-- End Grafik SDM --}}








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

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const colors = [
                '#fd7e14', // orange (PT KAI)
                '#198754', // hijau (PT KCI)
                '#0d6efd', // biru
                '#dc3545', // merah
                '#6f42c1', // ungu
                '#20c997', // tosca
                '#0dcaf0', // cyan
                '#6c757d' // abu
            ];

            function hashString(str) {
                let hash = 0;
                for (let i = 0; i < str.length; i++) {
                    hash = str.charCodeAt(i) + ((hash << 5) - hash);
                }
                return Math.abs(hash);
            }

            document.querySelectorAll('.pelanggan-badge').forEach(badge => {
                const nama = badge.dataset.pelanggan;
                if (!nama) return;

                const colorIndex = hashString(nama) % colors.length;
                badge.style.backgroundColor = colors[colorIndex];
                badge.style.color = '#fff';
            });

        });
    </script>



    {{-- kontrak slide --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const container = document.getElementById("kontrakSlideshow");
            const slide = container.querySelector(".kontrak-slide");
            const cols = slide.querySelectorAll(".kontrak-col");

            if (cols.length <= 1) return;

            const transitionDuration = 1200; // animasi geser
            const viewDuration = 3500; // waktu diam terbaca
            const resetDelay = 800; // jeda sebelum reset

            let index = 0;

            slide.style.transition = `transform ${transitionDuration}ms ease-in-out`;

            function goTo(target) {
                const width = container.offsetWidth;
                slide.style.transform = `translateX(-${target * width}px)`;
            }

            function runSlide() {
                index++;
                goTo(index);

                // SLIDE TERAKHIR
                if (index === cols.length - 1) {
                    setTimeout(() => {
                        // BIARKAN TERBACA
                        setTimeout(() => {
                            // RESET HALUS
                            slide.style.transition = "none";
                            slide.style.transform = "translateX(0)";
                            index = 0;

                            // reflow
                            slide.offsetHeight;

                            // AKTIFKAN LAGI TRANSISI
                            slide.style.transition =
                                `transform ${transitionDuration}ms ease-in-out`;

                            // 🔁 LANJUT LOOP
                            setTimeout(runSlide, viewDuration);

                        }, resetDelay);
                    }, viewDuration);
                } else {
                    // SLIDE BIASA
                    setTimeout(runSlide, viewDuration);
                }
            }

            // mulai loop
            setTimeout(runSlide, viewDuration);
        });
    </script>











    {{-- TAB Slide Show --}}
    <script>
        let activeTab = 'pemasaran';
        let slideInterval = null;
        let tabInterval = null;

        const tabs = ['pemasaran', 'wilayah', 'sdm'];
        let tabIndex = 0;

        /* ================= SHOW TAB ================= */
        function showTab(tab) {

            // sembunyikan semua tab
            document.querySelectorAll('.dashboard-tab').forEach(el => {
                el.classList.add('d-none');
            });

            // reset active nav
            document.querySelectorAll('#dashboardTabs .nav-link').forEach(el => {
                el.classList.remove('active');
            });

            // tampilkan tab aktif
            document.getElementById('tab-' + tab).classList.remove('d-none');
            document
                .querySelector(`#dashboardTabs .nav-link[data-tab="${tab}"]`)
                .classList.add('active');

            activeTab = tab;

            // mulai slideshow per tab
            startSlideShow(tab);
        }

        /* ================= CLICK TAB ================= */
        document.querySelectorAll('#dashboardTabs .nav-link').forEach(tab => {
            tab.addEventListener('click', function() {

                // hentikan auto tab sementara
                stopAutoTab();

                // tampilkan tab yg diklik
                showTab(this.dataset.tab);

                // 🔥 nyalakan lagi auto tab
                startAutoTab();
            });
        });

        /* ================= SLIDESHOW PER TAB ================= */
        function startSlideShow(tab) {
            clearInterval(slideInterval);

            const slides = document.querySelectorAll('.slide-' + tab);
            if (slides.length <= 1) return;

            let index = 0;

            // tampilkan slide pertama
            slides.forEach((s, i) => {
                s.classList.toggle('d-none', i !== 0);
            });

            slideInterval = setInterval(() => {
                slides[index].classList.add('d-none');
                index = (index + 1) % slides.length;
                slides[index].classList.remove('d-none');
            }, 30000); // 30 detik per slide
        }

        /* ================= AUTO TAB ================= */
        function startAutoTab() {
            clearInterval(tabInterval); // ⛔ hindari interval numpuk
            tabInterval = setInterval(() => {
                tabIndex = (tabIndex + 1) % tabs.length;
                showTab(tabs[tabIndex]);
            }, 30000); // 30 detik per tab
        }

        function stopAutoTab() {
            clearInterval(tabInterval);
        }

        /* ================= INIT ================= */
        document.addEventListener('DOMContentLoaded', function() {
            showTab('pemasaran');
            startAutoTab();
        });
    </script>




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
