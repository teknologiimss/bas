@extends('layouts.main')
@section('title', __('Home - PT. IMST'))

@section('custom-css')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --imst-navy-dark: #061838;
            --imst-navy: #0B3D91;
            --imst-blue: #1E5BB8;
            --imst-accent: #38BDF8;
            --imst-gold: #F59E0B;
            --imst-bg: #F4F7FC;
        }

        /* ===============================
                           ANIMASI KEYFRAMES
                        =============================== */
        @keyframes floatSlow {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-14px) rotate(2deg);
            }
        }

        @keyframes pulseGlow {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(56, 189, 248, 0.45);
            }

            50% {
                box-shadow: 0 0 25px 8px rgba(56, 189, 248, 0.15);
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bgShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes gearSpin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes gearSpinReverse {
            from {
                transform: rotate(360deg);
            }

            to {
                transform: rotate(0deg);
            }
        }

        /* ===============================
                           HERO SECTION MODERN
                        =============================== */
        .imst-home-wrapper {
            padding: 10px 5px 40px 5px;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        .hero-banner {
            position: relative;
            background: linear-gradient(135deg, var(--imst-navy-dark) 0%, var(--imst-navy) 50%, var(--imst-blue) 100%);
            background-size: 200% 200%;
            animation: bgShift 12s ease infinite;
            border-radius: 24px;
            padding: 45px 40px;
            color: #ffffff;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(11, 61, 145, 0.22);
            margin-bottom: 30px;
        }

        /* Dekorasi Lingkaran & Gear Bergerak */
        .hero-orb-1 {
            position: absolute;
            top: -60px;
            right: -60px;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.28) 0%, rgba(56, 189, 248, 0) 70%);
            animation: floatSlow 6s ease-in-out infinite;
            pointer-events: none;
        }

        .hero-orb-2 {
            position: absolute;
            bottom: -80px;
            left: 35%;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.18) 0%, rgba(245, 158, 11, 0) 70%);
            animation: floatSlow 8s ease-in-out infinite reverse;
            pointer-events: none;
        }

        .hero-gear-bg {
            position: absolute;
            right: 40px;
            bottom: -30px;
            font-size: 13rem;
            color: rgba(255, 255, 255, 0.05);
            animation: gearSpin 35s linear infinite;
            pointer-events: none;
        }

        .hero-gear-bg-small {
            position: absolute;
            right: 210px;
            top: -20px;
            font-size: 6.5rem;
            color: rgba(56, 189, 248, 0.08);
            animation: gearSpinReverse 22s linear infinite;
            pointer-events: none;
        }

        .welcome-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 16px;
            animation: fadeUp 0.6s ease-out;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background-color: #22C55E;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 8px #22C55E;
        }

        .hero-title {
            font-size: 2.35rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 12px;
            animation: fadeUp 0.8s ease-out;
        }

        .hero-title span {
            color: var(--imst-accent);
        }

        .hero-subtitle {
            font-size: 1.05rem;
            color: #CBD5E1;
            max-width: 650px;
            line-height: 1.6;
            margin-bottom: 24px;
            animation: fadeUp 1s ease-out;
        }

        .hero-logo-box {
            background: rgba(255, 255, 255, 0.95);
            padding: 22px;
            border-radius: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
            animation: floatSlow 5s ease-in-out infinite, pulseGlow 4s infinite;
        }

        .hero-logo-box img {
            max-width: 130px;
            height: auto;
        }

        /* Live Clock Widget */
        .live-clock-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 16px;
            padding: 14px 20px;
            display: inline-flex;
            align-items: center;
            gap: 15px;
            animation: fadeUp 1.1s ease-out;
        }

        .live-clock-time {
            font-size: 1.45rem;
            font-weight: 700;
            letter-spacing: 1px;
            color: #ffffff;
        }

        .live-clock-date {
            font-size: 0.82rem;
            color: #93C5FD;
        }

        /* ===============================
                           FEATURE / MODULE CARDS
                        =============================== */
        .section-heading {
            font-weight: 700;
            color: var(--imst-navy-dark);
            font-size: 1.25rem;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-heading::before {
            content: '';
            width: 5px;
            height: 24px;
            background: linear-gradient(180deg, var(--imst-navy), var(--imst-accent));
            border-radius: 4px;
            display: inline-block;
        }

        .modern-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #E2E8F0;
            padding: 24px;
            height: 100%;
            transition: all 0.35s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04);
            animation: fadeUp 0.9s ease-out;
        }

        .modern-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--imst-navy), var(--imst-accent));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.35s ease;
        }

        .modern-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 18px 35px rgba(11, 61, 145, 0.14);
            border-color: #BFDBFE;
        }

        .modern-card:hover::after {
            transform: scaleX(1);
        }

        .icon-box {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 18px;
            transition: transform 0.35s ease;
        }

        .modern-card:hover .icon-box {
            transform: scale(1.1) rotate(-5deg);
        }

        .bg-soft-blue {
            background: #EFF6FF;
            color: #1D4ED8;
        }

        .bg-soft-cyan {
            background: #ECFEFF;
            color: #0891B2;
        }

        .bg-soft-amber {
            background: #FFFBEB;
            color: #D97706;
        }

        .bg-soft-emerald {
            background: #ECFDF5;
            color: #059669;
        }

        .card-title-modern {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 8px;
        }

        .card-desc-modern {
            font-size: 0.9rem;
            color: #64748B;
            line-height: 1.55;
            margin-bottom: 0;
        }

        /* ===============================
                           INFO PANEL & TATA NILAI
                        =============================== */
        .info-panel {
            background: linear-gradient(135deg, #ffffff 0%, #F8FAFC 100%);
            border-radius: 20px;
            border: 1px solid #E2E8F0;
            padding: 28px;
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.04);
        }

        .core-value-badge {
            display: inline-block;
            background: #EFF6FF;
            color: var(--imst-navy);
            border: 1px solid #BFDBFE;
            padding: 6px 14px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.85rem;
            margin: 4px;
            transition: all 0.25s ease;
        }

        .core-value-badge:hover {
            background: var(--imst-navy);
            color: #ffffff;
            transform: translateY(-2px);
        }

        /* ===============================
                           RESPONSIVE
                        =============================== */
        @media (max-width: 768px) {
            .hero-banner {
                padding: 30px 22px;
                text-align: center;
            }

            .hero-title {
                font-size: 1.75rem;
            }

            .hero-logo-box {
                margin-top: 24px;
            }

            .live-clock-card {
                justify-content: center;
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="imst-home-wrapper container-fluid">

        {{-- ================= HERO BANNER ================= --}}
        <div class="hero-banner">
            <div class="hero-orb-1"></div>
            <div class="hero-orb-2"></div>
            <i class="bi bi-gear-fill hero-gear-bg"></i>
            <i class="bi bi-gear-wide-connected hero-gear-bg-small"></i>

            <div class="row align-items-center position-relative" style="z-index: 2;">
                <div class="col-lg-8">
                    <div class="welcome-pill">
                        <span class="status-dot"></span>
                        <span>BUSINESS APPLICATION SYSTEM &bull; PT. IMST</span>
                    </div>

                    <h1 class="hero-title">
                        Selamat Datang, <span>{{ Auth::user()->name }}</span>!
                    </h1>

                    <p class="hero-subtitle">
                        Portal Operasional & Manajemen Terintegrasi <strong>PT. INKA Multi Solusi Trading (IMST)</strong>.
                        Kelola aktivitas administrasi proyek secara cepat, akurat, dan transparan yang terhubung seluruh unit kerja.
                    </p>

                    <div class="live-clock-card">
                        <i class="bi bi-clock-history text-info" style="font-size: 1.8rem;"></i>
                        <div>
                            <div class="live-clock-time" id="liveClock">00:00:00</div>
                            <div class="live-clock-date" id="liveDate">Memuat tanggal...</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 text-center text-lg-right">
                    <div class="hero-logo-box">
                        <img src="{{ asset('img/IMST.png') }}" alt="Logo PT. IMST"
                            onerror="this.src='https://via.placeholder.com/130x80?text=PT+IMST'">
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= PILAR LAYANAN & OPERASIONAL ================= --}}
        <div class="section-heading">
            Pilar Operasional & Layanan Utama PT. IMST
        </div>

        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="modern-card">
                    <div class="icon-box bg-soft-blue">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <h5 class="card-title-modern">Warehouse & Logistik</h5>
                    <p class="card-desc-modern">
                        Pengelolaan keluar-masuk barang, pelacakan stok real-time, surat jalan (SJN), dan distribusi
                        material proyek yang terukur.
                    </p>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="modern-card">
                    <div class="icon-box bg-soft-cyan">
                        <i class="bi bi-tools"></i>
                    </div>
                    <h5 class="card-title-modern">Maintenance, Repair & Overhaul</h5>
                    <p class="card-desc-modern">
                        Pemeliharaan berkala sarana perkeretaapian, peralatan MRO, serta monitoring kesiapan unit
                        operasional di lapangan.
                    </p>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="modern-card">
                    <div class="icon-box bg-soft-amber">
                        <i class="bi bi-cart-check-fill"></i>
                    </div>
                    <h5 class="card-title-modern">Procurement & Trading</h5>
                    <p class="card-desc-modern">
                        Pengadaan komponen dan suku cadang berkualitas tinggi melalui manajemen Purchase Request (PR) dan
                        Purchase Order (PO).
                    </p>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="modern-card">
                    <div class="icon-box bg-soft-emerald">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h5 class="card-title-modern">Quality & Project Control</h5>
                    <p class="card-desc-modern">
                        Pengawasan standar mutu pekerjaan, dokumentasi proyek wilayah, dan pelaporan progres yang akuntabel.
                    </p>
                </div>
            </div>
        </div>

        {{-- ================= INFORMASI PERUSAHAAN ================= --}}
        <div class="row">
            <div class="col-12 mb-3">
                <div class="info-panel">
                    <div class="section-heading">
                        Tentang PT. INKA Multi Solusi Trading
                    </div>
                    <p class="text-muted" style="line-height: 1.7;">
                        <strong>PT. IMST</strong> berkomitmen menjadi mitra terpercaya dalam penyediaan suku cadang, jasa
                        perawatan (MRO), dan solusi perdagangan industri transportasi serta perkeretaapian nasional. Melalui
                        digitalisasi sistem informasi ini, seluruh unit kerja terhubung dalam satu ekosistem yang efisien.
                    </p>

                    <hr class="my-3">

                    <div class="mb-2 font-weight-bold text-dark" style="font-size: 0.95rem;">
                        <i class="bi bi-stars text-warning mr-1"></i> Tata Nilai Perusahaan (AKHLAK):
                    </div>
                    <div>
                        <span class="core-value-badge">Amanah</span>
                        <span class="core-value-badge">Kompeten</span>
                        <span class="core-value-badge">Harmonis</span>
                        <span class="core-value-badge">Loyal</span>
                        <span class="core-value-badge">Adaptif</span>
                        <span class="core-value-badge">Kolaboratif</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= MODAL STOCK IN / OUT (TETAP DIPERTAHANKAN JIKA DIPERLUKAN) ================= --}}
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
                    <div class="row justify-content-center mb-3">
                        <img width="260px" src="{{ asset('img/scan.jpg') }}" alt="Scan Barcode" />
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="input-group input-group-lg">
                                <input type="text" class="form-control" id="pcode" name="pcode" min="0"
                                    placeholder="Product Code">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" id="button-check" onclick="productCheck()">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="loader" class="card" style="display: none;">
                        <div class="card-body text-center">
                            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div id="form" class="card" style="display: none;">
                        <div class="card-body">
                            <form role="form" id="stock-update" method="post">
                                @csrf
                                <input type="hidden" id="pid" name="pid">
                                <input type="hidden" id="type" name="type">
                                <div class="form-group row">
                                    <label for="pname" class="col-sm-4 col-form-label">{{ __('Nama Barang') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="pname" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="no_nota" class="col-sm-4 col-form-label">{{ __('No. SJN') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="no_nota" name="no_nota">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-sm-4 col-form-label">{{ __('Nama') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="name" name="name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pamount" class="col-sm-4 col-form-label">{{ __('Jumlah') }}</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="pamount" name="pamount"
                                            min="1" value="1">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="shelf" class="col-sm-4 col-form-label">Lokasi</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" style="width: 100%;" id="shelf"
                                            name="shelf"></select>
                                    </div>
                                </div>
                                <div id="date" class="form-group row">
                                    <label for="stock_date" class="col-sm-4 col-form-label">Date</label>
                                    <div class="col-sm-8">
                                        <div class="input-group date" id="stock_date" data-target-input="nearest">
                                            <input type="text"
                                                class="form-control datetimepicker-input stock_date_text"
                                                id="stock_date_text" name="stock_date" data-target="#stock_date" />
                                            <div class="input-group-append" data-target="#stock_date"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</button>
                    <button id="button-update" type="button" class="btn btn-primary" style="display: none;"
                        onclick="stockUpdate()">{{ __('Stock In') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script>
        // ================= JAM & TANGGAL REAL-TIME =================
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('liveClock').textContent = `${hours}:${minutes}:${seconds} WIB`;

            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            document.getElementById('liveDate').textContent = now.toLocaleDateString('id-ID', options);
        }
        setInterval(updateClock, 1000);
        updateClock();

        // ================= SCRIPT BAWAAN STOCK IN/OUT =================
        $(function() {
            $('#form').hide();
            loader(0);
            if ($.fn.select2) {
                $('.select2').select2({
                    theme: 'bootstrap4'
                });
            }
            if ($.fn.datetimepicker) {
                $('#stock_date').datetimepicker({
                    viewMode: 'years',
                    format: 'MM/DD/YYYY HH:mm:ss'
                });
            }
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
            $('#form').find('.card-body').find('#proyek_id').parent().parent().remove();
            if (type == 0) {
                $('#modal-title').text("Stock Out");
                $('#button-update').text("Stock Out");
                $("#date").show();
                $('#form').find('.card-body').append(
                    '<div class="form-group row"><label for="proyek_id" class="col-sm-4 col-form-label">Keproyekan</label><div class="col-sm-8"><select class="form-control select2" style="width: 100%;" id="proyek_id" name="proyek_id"></select></div></div>'
                );
            } else if (type == 1) {
                $('#modal-title').text("Stock In");
                $('#button-update').text("Stock In");
                $("#date").show();
            } else {
                $('#modal-title').text("Retur");
                $('#button-update').text("Retur");
                $("#date").hide();
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
                        $('#proyek_id').append('<option value="' + value.id + '" ' + (value.id == val ?
                            'selected' : '') + '>' + value.nama_proyek + '</option>');
                    });
                }
            });
        }

        function getShelf(pid = null) {
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
                        $('#shelf').append('<option value="' + value.shelf_id + '">' + value
                            .shelf_name + '</option>');
                    });
                }
            });
        }

        function enableStockInput() {
            $('#button-update').prop("disabled", false).show();
            $('#form').show();
        }

        function disableStockInput() {
            $('#button-update').prop("disabled", true).hide();
            $('#form').hide();
        }

        function loader(status = 1) {
            status == 1 ? $('#loader').show() : $('#loader').hide();
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
                            if (typeof toastr !== 'undefined') toastr.error("Product Code tidak dikenal!");
                        }
                        $('#pcode').prop("disabled", false);
                        $('#button-check').prop("disabled", false);
                    },
                    error: function() {
                        loader(0);
                        $('#pcode').prop("disabled", false);
                        $('#button-check').prop("disabled", false);
                    }
                });
            } else {
                if (typeof toastr !== 'undefined') toastr.error("Product Code belum diisi!");
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
            };

            $.ajax({
                url: "{{ url('/products/stockUpdate') }}",
                type: "post",
                data: JSON.stringify(data),
                dataType: "json",
                contentType: 'application/json',
                success: function(data) {
                    loader(0);
                    if (data.status == 1) {
                        if (typeof toastr !== 'undefined') toastr.success(data.message);
                        resetForm();
                    } else {
                        if (typeof toastr !== 'undefined') toastr.error(data.message);
                        enableStockInput();
                        $('#pcode').prop("disabled", false);
                        $('#button-check').prop("disabled", false);
                    }
                },
                error: function() {
                    loader(0);
                    if (typeof toastr !== 'undefined') toastr.error("Unknown error! Please try again later!");
                    resetForm();
                }
            });
        }
    </script>

    @if (Session::has('success'))
        <script>
            if (typeof toastr !== 'undefined') toastr.success('{!! Session::get('success') !!}');
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            if (typeof toastr !== 'undefined') toastr.error('{!! Session::get('error') !!}');
        </script>
    @endif
    @if (!empty($errors->all()))
        <script>
            if (typeof toastr !== 'undefined') toastr.error('{!! implode('', $errors->all('<li>:message</li>')) !!}');
        </script>
    @endif
@endsection
