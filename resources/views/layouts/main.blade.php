<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css"> --}}
    {{-- <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script> --}}

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    @hasSection('custom-css')
        @yield('custom-css')
    @endif

    <style>
        .notifi-container {
            max-height: 240px;
            overflow-y: auto;
        }

        .notifi-item {
            display: flex;
            border-top: 1px solid #d6dee8;
            padding: 5px 10px;
            margin-bottom: 0;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .notifi-item:hover {
            background-color: #eaf2ff;
        }

        .notifi-item .text h4 {
            color: #1e3a5f;
            font-size: 16px;
            margin-top: 1px;
        }

        .notifi-item .text p {
            color: #6c7a89;
            font-size: 12px;
        }

        /* ===== SUBMENU STYLE ===== */
        .sidebar .nav-treeview .nav-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 12px 5px 32px;
            font-size: 0.82rem;
            line-height: 1.2em;
            transition: all 0.3s ease;
        }

        .sidebar .nav-treeview .nav-link p {
            margin: 0;
            white-space: normal !important;
            word-break: break-word;
            flex: 1;
        }

        .sidebar .nav-treeview .nav-link i.nav-icon,
        .sidebar .nav-treeview .nav-link i.far,
        .sidebar .nav-treeview .nav-link i.fas {
            font-size: 0.7rem !important;
            width: 18px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 1px;
        }

        /* ===== SUBMENU AKTIF ===== */
        .sidebar-dark-primary .nav-treeview>.nav-item>.nav-link.active {
            background-color: #0b3d91 !important;
            color: #ffffff !important;
            border-left: 3px solid #64b5ff;
        }

        /* Hover submenu */
        .sidebar .nav-treeview .nav-link:hover {
            background-color: rgba(11, 61, 145, 0.18);
            color: #ffffff;
        }

        /* ===== MENU UTAMA AKTIF ===== */
        .nav-sidebar .nav-link.active {
            background: linear-gradient(90deg, #0b3d91, #1e5bb8);
            color: #ffffff !important;
            border-radius: 6px;
        }

        /* Hover menu utama */
        .nav-sidebar .nav-link:hover {
            background-color: rgba(30, 91, 184, 0.18);
            color: #ffffff;
        }
    </style>


</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <span class="nav-link">@yield('title')</span>
                </li>
            </ul>




            @if (!empty($warehouse) && !Request::is('dashboard'))
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                            @if (Session::has('selected_warehouse_name'))
                                <i class="fas fa-warehouse"></i>
                                <span>{{ Session::get('selected_warehouse_name') }}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right"
                            style="left: inherit; right: 0px;">
                            <span class="dropdown-item dropdown-header">Warehouse</span>
                            @foreach ($warehouse as $w)
                                <a href="{{ route('warehouse') }}/change/{{ $w->warehouse_id }}"
                                    class="dropdown-item">
                                    {{ $w->warehouse_name }}
                                </a>
                            @endforeach
                        </div>
                    </li>
                </ul>
            @endif


            @if (!empty($warehouse) && Request::is('dashboard'))

                <ul class="navbar-nav ml-auto">

                    {{-- ===================================================== --}}
                    {{-- NOTIFIKASI KONTRAK MRO --}}
                    {{-- HANYA ADMIN & USER MRO --}}
                    {{-- ===================================================== --}}
                    @if (Auth::user()->role == 0 || Auth::user()->role == 14)

                        <li class="nav-item dropdown">

                            <a class="nav-link position-relative" data-toggle="dropdown" href="#"
                                aria-expanded="false">

                                <i class="fas fa-bell text-primary" style="font-size: 22px;"></i>

                                @if (isset($notifications) && count($notifications) > 0)
                                    <span class="badge badge-danger navbar-badge">
                                        {{ count($notifications) }}
                                    </span>
                                @endif

                            </a>

                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow"
                                style="left: inherit; right: 0px;">

                                <span class="dropdown-item dropdown-header font-weight-bold">
                                    🔔 Notifikasi Kontrak MRO
                                </span>

                                <div class="dropdown-divider"></div>

                                {{-- 👇 INI WRAPPER SCROLL --}}
                                <div style="max-height: 350px; overflow-y: auto;">

                                    @forelse($notifications as $notif)
                                        @php
                                            $data = $notif->notifMessage();
                                        @endphp

                                        @if (is_array($data))
                                            <a href="{{ route('monitoring.index', $notif->proyek_id) }}?po={{ urlencode(trim($notif->po_nota_dinas)) }}"
                                                class="dropdown-item">

                                                <div class="d-flex">

                                                    <div class="mr-2 text-{{ $data['class'] }}">
                                                        <i class="{{ $data['icon'] }}"></i>
                                                    </div>

                                                    <div>

                                                        <strong>
                                                            {{ $notif->po_nota_dinas }}
                                                        </strong>

                                                        <br>

                                                        <small>
                                                            {{ $data['message'] }}
                                                        </small>

                                                        <br>

                                                        <small class="text-muted">
                                                            {{ $notif->nama_pekerjaan }}
                                                        </small>

                                                    </div>

                                                </div>

                                            </a>

                                            <div class="dropdown-divider"></div>
                                        @endif

                                    @empty

                                        <span class="dropdown-item text-muted">
                                            Tidak ada notifikasi kontrak
                                        </span>
                                    @endforelse

                                </div>

                            </div>

                        </li>

                    @endif

                    {{-- ===================================================== --}}
                    {{-- NOTIFIKASI SURAT MASUK --}}
                    {{-- ===================================================== --}}
                    @if (Auth::user()->role == 5 || Auth::user()->role == 7)

                        <li class="nav-item dropdown">

                            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">

                                <i class="material-icons text-secondary">
                                    notifications
                                </i>

                                <span class="badge badge-light text-danger font-weight-bold">
                                    {{ $jumlahDataHariIni }}
                                </span>

                            </a>

                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right"
                                style="left: inherit; right: 0px;">

                                <a href="" class="dropdown-item dropdown-header">

                                    Surat Masuk

                                    <span class="text-danger font-weight-bold">
                                        {{ $jumlahDataHariIni }}
                                    </span>

                                </a>

                                <div class="notifi-container">

                                    @foreach ($suratMasuks as $suratMasuk)
                                        <div class="notifi-item">

                                            <a href="{{ asset('sk/' . $suratMasuk['file']) }}" download>

                                                <div class="text">

                                                    <h4>
                                                        Asal:
                                                        {{ $suratMasuk['asal'] }}
                                                    </h4>

                                                    <p>
                                                        Waktu Masuk:
                                                        {{ date('d M Y H:i', strtotime($suratMasuk['tanggalMasuk'])) }}
                                                    </p>

                                                    <p>
                                                        Uraian:
                                                        {{ $suratMasuk['uraian'] }}
                                                    </p>

                                                </div>

                                            </a>

                                        </div>
                                    @endforeach

                                </div>

                            </div>

                        </li>

                    @endif

                    {{-- ===================================================== --}}
                    {{-- NOTIFIKASI PURCHASE REQUEST --}}
                    {{-- ===================================================== --}}
                    @if (Auth::user()->role == 2 || Auth::user()->role == 3 || Auth::user()->role == 0 || Auth::user()->role == 1)

                        <li class="nav-item dropdown">

                            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">

                                <i class="fas fa-shopping-cart text-primary"></i>

                                <span class="badge badge-light text-danger font-weight-bold">
                                    {{ $totalPurchaseRequests }}
                                </span>

                            </a>

                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right"
                                style="left: inherit; right: 0px;">

                                <a href="{{ route('product.trackingwil') }}" class="dropdown-item dropdown-header">

                                    Tracking Purchase Request

                                    <span class="text-danger font-weight-bold">
                                        {{ $totalPurchaseRequests }}
                                    </span>

                                </a>

                                <div class="notifi-container">

                                    @foreach ($purchaseRequests as $data)
                                        <div class="notifi-item">

                                            <a title="Lihat Detail" data-toggle="modal"
                                                data-target="#detail-track-pr"
                                                data-detail="{{ json_encode($data) }}">

                                                <div class="text">

                                                    <h4>
                                                        {{ $data->nama_pekerjaan }}
                                                    </h4>

                                                    <p>
                                                        Tanggal:
                                                        {{ $data->tgl_pr }}
                                                    </p>

                                                    <p>
                                                        Nomor PR:
                                                        {{ $data->no_pr }}
                                                    </p>

                                                </div>

                                            </a>

                                        </div>
                                    @endforeach

                                </div>

                            </div>

                        </li>

                    @endif

                    {{-- ===================================================== --}}
                    {{-- WAREHOUSE --}}
                    {{-- ===================================================== --}}
                    <li class="nav-item dropdown">

                        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">

                            @if (Session::has('selected_warehouse_name'))
                                <i class="fas fa-warehouse"></i>

                                <span>
                                    {{ Session::get('selected_warehouse_name') }}
                                </span>
                            @endif

                        </a>

                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right"
                            style="left: inherit; right: 0px;">

                            <span class="dropdown-item dropdown-header">
                                Warehouse
                            </span>

                            @foreach ($warehouse as $w)
                                <a href="{{ route('warehouse') }}/change/{{ $w->warehouse_id }}"
                                    class="dropdown-item">

                                    {{ $w->warehouse_name }}

                                </a>
                            @endforeach

                        </div>

                    </li>

                </ul>

            @endif




        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: navy;">
            <a href="/" class="brand-link text-center" style="background-color: rgb(255, 253, 253);">
                <img src="{{ asset('img/logobas.png') }}" class="d-block w-100" height="30" alt=""
                    style="object-fit: contain;height: 50px;">
                <!--  <span class="brand-text font-weight-bold">{{ config('app.name', 'Warehouse') }}</span> -->
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        @if (Auth::check())
                            <li class="nav-item">
                                <a class="nav-link {{ Route::current()->getName() == 'home' ? 'active' : '' }}"
                                    href="{{ route('home') }}">
                                    <i class="nav-icon fas fa-home"></i>
                                    <p class="text">{{ __('Dashboard') }}</p>
                                </a>
                            </li>

                            {{-- Menu --}}
                            @if (Auth::check())
                                {{-- <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'menu' ? 'active' : '' }}"
                                        href="{{ route('menu') }}">
                                        <i class="nav-icon fab fa-github"></i>
                                        <p class="text">{{ __('Menu') }}</p>
                                    </a>
                                </li> --}}

                                @php
                                    $menuActive = in_array(Route::currentRouteName(), [
                                        'kontrak.index',
                                        'riwayat_pembelian',
                                        'purchase_request.index',
                                        'product.trackingwil',
                                        'bpm.index',
                                        'spph.index',
                                        'spph_rfq.index',
                                        'loi.index',
                                        'loiluar.index',
                                        'nego.index',
                                        'negoluar.index',
                                        'purchase_order.index',
                                        'purchase_orderluar.index',
                                        'product.tracking',
                                        'surat_jalan.index',
                                        'penerimaan_barang',
                                        'lppb',
                                        'kode_aset.index',
                                        'aset.index',
                                        'karyawan.index',
                                        'proyek.index',
                                        'mro.progress',
                                        'mro',
                                        'mro.stock.log',
                                        'sppd.index',
                                        'mro.riwayat',
                                        'pengiriman.index',
                                        'perencanaan.proyek',
                                        'alat.index',
                                        'checksheet.index',
                                        'mro.profil',
                                        'cuti.index',
                                        'cuti.rekap',
                                        'cuti.tahunan',
                                        'products.stock.history',
                                        'lp3m.index',
                                        'rewinding.index',
                                        'fasilitas-harian.index',
                                        'asset-maintenance.index',
                                        'assets.index',
                                        'pengiriman.dashboard',
                                        'rewinding.dashboard',
                                        'lp3m.dashboard',
                                        'alat.dashboard',
                                        'mro.daily-activity.index',
                                        'mro.weekly-activity',
                                    ]);
                                    $menuPemasaranActive = in_array(Route::currentRouteName(), [
                                        'kontrak.index',
                                        'riwayat_pembelian',
                                    ]);
                                    $menuWilayahActive = in_array(Route::currentRouteName(), [
                                        'purchase_request.index',
                                        'product.trackingwil',
                                        'bpm.index',
                                    ]);
                                    $menuLogistikActive = in_array(Route::currentRouteName(), [
                                        'spph.index',
                                        'spph_rfq.index',
                                        'loi.index',
                                        'loiluar.index',
                                        'nego.index',
                                        'negoluar.index',
                                        'purchase_order.index',
                                        'purchase_orderluar.index',
                                        'product.tracking',
                                    ]);
                                    $menuEksActive = in_array(Route::currentRouteName(), [
                                        'surat_jalan.index',
                                        'penerimaan_barang',
                                    ]);
                                    $menuQcActive = in_array(Route::currentRouteName(), ['lppb']);
                                    $menuSdmActive = in_array(Route::currentRouteName(), [
                                        'kode_aset.index',
                                        'aset.index',
                                        'karyawan.index',
                                    ]);
                                    $menuMroActive = in_array(Route::currentRouteName(), [
                                        'proyek.index',
                                        'mro.progress',
                                        'mro',
                                        'mro.stock.log',
                                        'sppd.index',
                                        'mro.riwayat',
                                        'pengiriman.index',
                                        'perencanaan.proyek',
                                        'alat.index',
                                        'checksheet.index',
                                        'mro.profil',
                                        'cuti.index',
                                        'cuti.rekap',
                                        'cuti.tahunan',
                                        'lp3m.index',
                                        'rewinding.index',
                                        'fasilitas-harian.index',
                                        'asset-maintenance.index',
                                        'assets.index',
                                        'pengiriman.dashboard',
                                        'rewinding.dashboard',
                                        'lp3m.dashboard',
                                        'alat.dashboard',
                                        'mro.daily-activity.index',
                                        'mro.weekly-activity',
                                    ]);
                                @endphp

                                <li class="nav-item has-treeview {{ $menuActive ? 'menu-open' : '' }}">
                                    <a href="#" class="nav-link {{ $menuActive ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-bars"></i>
                                        <p>
                                            {{ __('Menu') }}
                                            {{-- <i class="right fas fa-angle-left"></i> --}}
                                        </p>
                                    </a>

                                    <ul class="nav nav-treeview">
                                        {{-- Contoh menu role Pemasaran --}}
                                        @if (Auth::user()->role == 0 || Auth::user()->role == 12 || Auth::user()->role == 15 || Auth::user()->role == 16)
                                            <li
                                                class="nav-item has-treeview {{ $menuPemasaranActive ? 'menu-open' : '' }}">
                                                <a href="#" class="nav-link">
                                                    <i class="nav-icon fas fa-bullhorn"></i>
                                                    <p class="">
                                                        {{ __('Pemasaran') }}
                                                        <i class="right fas fa-angle-left"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview pl-3">
                                                    <li class="nav-item">
                                                        <a href="{{ route('kontrak.index') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'kontrak.index' ? 'active' : '' }}">
                                                            <i class="fas fa-file-signature nav-icon"></i>
                                                            <p>{{ __('Kontrak') }}</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('riwayat_pembelian') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'riwayat_pembelian' ? 'active' : '' }}">
                                                            <i class="fas fa-shopping-cart  nav-icon"></i>
                                                            <p>{{ __('Riwayat Pembelian') }}</p>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endif
                                        {{-- Contoh menu role Pemasaran --}}


                                        {{-- Contoh menu role Wilayah --}}
                                        @if (in_array(Auth::user()->role, [0, 2, 3, 8, 9, 14]))
                                            <li
                                                class="nav-item has-treeview {{ $menuWilayahActive ? 'menu-open' : '' }}">
                                                <a href="#" class="nav-link">
                                                    <i class="nav-icon fas fa-map-marked-alt"></i>
                                                    <p class="">
                                                        {{ __('Wilayah,MRO') }}
                                                        <i class="right fas fa-angle-left"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview pl-3">
                                                    <li class="nav-item">
                                                        <a href="{{ route('purchase_request.index') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'purchase_request.index' ? 'active' : '' }}">
                                                            <i class="fas fa-newspaper nav-icon"></i>
                                                            <p>{{ __('Purchase Request') }}</p>
                                                        </a>
                                                    </li>

                                                    {{-- Tracking Wilayah TIDAK untuk MRO (role 14) --}}
                                                    @if (Auth::user()->role != 14)
                                                        <li class="nav-item">
                                                            <a href="{{ route('product.trackingwil') }}"
                                                                class="nav-link {{ Route::current()->getName() == 'product.trackingwil' ? 'active' : '' }}">
                                                                <i class="fas fa-route nav-icon"></i>
                                                                <p>{{ __('Tracking Wilayah') }}</p>
                                                            </a>
                                                        </li>
                                                    @endif

                                                    <li class="nav-item">
                                                        <a href="{{ route('bpm.index') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'bpm.index' ? 'active' : '' }}">
                                                            <i class="fas fa-hand-holding nav-icon"></i>
                                                            <p>{{ __('BPM') }}</p>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endif

                                        {{-- Contoh menu role Wilayah --}}



                                        {{-- Contoh menu role Logistik --}}
                                        @if (Auth::user()->role == 0 || Auth::user()->role == 1 || Auth::user()->role == 7)
                                            <li
                                                class="nav-item has-treeview {{ $menuLogistikActive ? 'menu-open' : '' }}">
                                                <a href="#" class="nav-link">
                                                    <i class="nav-icon fas fas fa-truck"></i>
                                                    <p class="">
                                                        {{ __('Logistik') }}
                                                        <i class="right fas fa-angle-left"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview pl-3">
                                                    {{-- Backup SPPH dipisah --}}
                                                    {{-- <li class="nav-item">
                                                        <a href="{{ route('spph.index') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'spph.index' ? 'active' : '' }}">
                                                            <i class="fas fa-hand-holding-usd nav-icon"></i>
                                                            <p>{{ __('SPPH') }}</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('spph_rfq.index') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'spph_rfq.index' ? 'active' : '' }}">
                                                            <i class="fas fa-newspaper nav-icon"></i>
                                                            <p>{{ __('REQUEST FOR QUOTATION (RFQ)') }}</p>
                                                        </a>
                                                    </li> --}}


                                                    {{-- SPPH Luar dan Dalam --}}
                                                    <li class="nav-item">
                                                        <a href="{{ route('spph.all') }}"
                                                            class="nav-link {{ in_array(Route::currentRouteName(), ['spph.all', 'spph.index', 'spph_rfq.index']) ? 'active' : '' }}">
                                                            <i class="fas fa-hand-holding-usd nav-icon"></i>
                                                            <p>{{ __('SPPH') }}</p>
                                                        </a>
                                                    </li>

                                                    {{-- LOI Luar dan Dalam --}}
                                                    <li class="nav-item">
                                                        <a href="{{ route('loi.all') }}"
                                                            class="nav-link {{ in_array(Route::currentRouteName(), ['loi.all', 'loi.index', 'loiluar.index']) ? 'active' : '' }}">
                                                            <i class="fas fa-scroll nav-icon"></i>
                                                            <p>{{ __('LETTER OF INTENT (LOI)') }}</p>
                                                        </a>
                                                    </li>

                                                    {{-- Backup LOI dipisah --}}
                                                    {{-- <li class="nav-item">
                                                        <a href="{{ route('loi.index') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'loi.index' ? 'active' : '' }}">
                                                            <i class="fas fa-scroll nav-icon"></i>
                                                            <p>{{ __('LETTER OF INTENT (LOI)') }}</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('loiluar.index') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'loiluar.index' ? 'active' : '' }}">
                                                            <i class="fas fa-scroll nav-icon"></i>
                                                            <p>{{ __('LETTER OF INTENT (LOI) LUAR NEGERI') }}</p>
                                                        </a>
                                                    </li> --}}

                                                    {{-- Nego Luar dan Dalam --}}
                                                    <li class="nav-item">
                                                        <a href="{{ route('nego.index') }}"
                                                            class="nav-link {{ in_array(Route::currentRouteName(), ['nego.index', 'negoluar.index']) ? 'active' : '' }}">
                                                            <i class="fas fa-handshake nav-icon"></i>
                                                            <p>{{ __('NEGOSIASI') }}</p>
                                                        </a>
                                                    </li>

                                                    {{-- Backup Nego dipisah --}}
                                                    {{-- <li class="nav-item">
                                                        <a href="{{ route('nego.index') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'nego.index' ? 'active' : '' }}">
                                                            <i class="fas fa-handshake nav-icon"></i>
                                                            <p>{{ __('NEGOTIATION (NEGO)') }}</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('negoluar.index') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'negoluar.index' ? 'active' : '' }}">
                                                            <i class="fas fa-handshake nav-icon"></i>
                                                            <p>{{ __('NEGOTIATION LETTER') }}</p>
                                                        </a>
                                                    </li> --}}


                                                    {{-- PO Luar dan Dalam --}}
                                                    <li class="nav-item">
                                                        <a href="{{ route('purchase_order.index') }}"
                                                            class="nav-link {{ in_array(Route::currentRouteName(), ['purchase_order.index', 'purchase_orderluar.index']) ? 'active' : '' }}">
                                                            <i class="fas fa-money-check-alt nav-icon"></i>
                                                            <p>{{ __('PURCHASE ORDER (PO)') }}</p>
                                                        </a>
                                                    </li>


                                                    {{-- Backup PO dipisah --}}
                                                    {{-- <li class="nav-item">
                                                        <a href="{{ route('purchase_order.index') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'purchase_order.index' ? 'active' : '' }}">
                                                            <i class="fas fa-money-check-alt nav-icon"></i>
                                                            <p>{{ __('PURCHASE ORDER (PO)') }}</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('purchase_orderluar.index') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'purchase_orderluar.index' ? 'active' : '' }}">
                                                            <i class="fas fa-money-check-alt nav-icon"></i>
                                                            <p>{{ __('PURCHASE ORDER (PO) LUAR NEGERI') }}</p>
                                                        </a>
                                                    </li> --}}
                                                    <li class="nav-item">
                                                        <a href="{{ route('product.tracking') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'product.tracking' ? 'active' : '' }}">
                                                            <i class="fas fa-map nav-icon"></i>
                                                            <p>{{ __('TRACKING') }}</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('riwayat_pembelian') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'riwayat_pembelian' ? 'active' : '' }}">
                                                            <i class="fas fa-shopping-cart nav-icon"></i>
                                                            <p>{{ __('RIWAYAT PEMBELIAN') }}</p>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endif
                                        {{-- Contoh menu role Logistik --}}


                                        {{-- Contoh menu role Ekspedisi --}}
                                        @if (Auth::user()->role == 0 || Auth::user()->role == 1 || Auth::user()->role == 7 || Auth::user()->role == 10)
                                            <li class="nav-item has-treeview {{ $menuEksActive ? 'menu-open' : '' }}">
                                                <a href="#" class="nav-link">
                                                    <i class="nav-icon fas fas fa-truck"></i>
                                                    <p class="">
                                                        {{ __('Ekspedisi') }}
                                                        <i class="right fas fa-angle-left"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview pl-3">
                                                    <li class="nav-item">
                                                        <a href="{{ route('surat_jalan.index') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'surat_jalan.index' ? 'active' : '' }}">
                                                            <i class="fas fa-envelope-open-text nav-icon"></i>
                                                            <p>{{ __('Surat Jalan') }}</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('penerimaan_barang') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'penerimaan_barang' ? 'active' : '' }}">
                                                            <i class="fas fa-clipboard-check nav-icon"></i>
                                                            <p>{{ __('Penerimaan Barang') }}</p>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endif
                                        {{-- Contoh menu role Ekspedisi --}}

                                        {{-- Contoh menu role QC --}}
                                        @if (Auth::user()->role == 0 || Auth::user()->role == 11 || Auth::user()->role == 7)
                                            <li class="nav-item has-treeview {{ $menuQcActive ? 'menu-open' : '' }}">
                                                <a href="#" class="nav-link">
                                                    <i class="nav-icon fas fa-check-circle"></i>
                                                    <p class="">
                                                        {{ __('QC') }}
                                                        <i class="right fas fa-angle-left"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview pl-3">
                                                    <li class="nav-item">
                                                        <a href="{{ route('lppb') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'lppb' ? 'active' : '' }}">
                                                            <i class="fas fa-check-square nav-icon"></i>
                                                            <p>{{ __('LPPB') }}</p>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endif
                                        {{-- Contoh menu role QC --}}

                                        {{-- Contoh menu role SDM --}}
                                        @if (Auth::user()->role == 0 || Auth::user()->role == 6)
                                            <li class="nav-item has-treeview {{ $menuSdmActive ? 'menu-open' : '' }}">
                                                <a href="#" class="nav-link">
                                                    <i class="nav-icon fas fa-users-cog"></i>
                                                    <p class="">
                                                        {{ __('SDM') }}
                                                        <i class="right fas fa-angle-left"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview pl-3">

                                                    <li class="nav-item">
                                                        <a href="{{ route('kode_aset.index') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'kode_aset.index' ? 'active' : '' }}">
                                                            <i class="fas fa-laptop-code nav-icon"></i>
                                                            <p>{{ __('Kode Aset SDM') }}</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('aset.index', ['type' => 1]) }}"
                                                            class="nav-link {{ Route::current()->getName() == 'aset.index' && request()->get('type') == 1 ? 'active' : '' }}">
                                                            <i class="fas fa-laptop nav-icon"></i>
                                                            <p>{{ __('Manajemen Aset SDM') }}</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('aset.index', ['type' => 2]) }}"
                                                            class="nav-link {{ Route::current()->getName() == 'aset.index' && request()->get('type') == 2 ? 'active' : '' }}">
                                                            <i class="fas fa-truck-moving nav-icon"></i>
                                                            <p>{{ __('Manajemen Inventaris SDM') }}</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('karyawan.index') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'karyawan.index' ? 'active' : '' }}">
                                                            <i class="fas fa-restroom nav-icon"></i>
                                                            <p>{{ __('Data Karyawan') }}</p>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endif
                                        {{-- Contoh menu role SDM --}}




                                        {{-- Contoh Menu role MRO --}}
                                        {{-- @if (Auth::user()->role == 0 || Auth::user()->role == 14)
                                            <li
                                                class="nav-item has-treeview {{ $menuMroActive ? 'menu-open' : '' }}">
                                                <a href="#" class="nav-link">
                                                    <i class="nav-icon fas fa-tools"></i>
                                                    <p class="">
                                                        {{ __('MRO') }}
                                                        <i class="right fas fa-angle-left"></i>
                                                    </p>
                                                </a>
                                                <ul class="nav nav-treeview pl-3">
                                                    <li class="nav-item">
                                                        <a href="{{ route('mro.profil') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'mro.profil' ? 'active' : '' }}">

                                                            <i class="nav-icon fas fa-video"></i>
                                                            <p>Personil MRO</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('pengiriman.index') }}"
                                                            class="nav-link {{ request()->routeIs('pengiriman.*') ? 'active' : '' }}">
                                                            <i class="nav-icon fas fa-truck"></i>
                                                            <p>Monitoring Pengiriman</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('checksheet.index') }}"
                                                            class="nav-link {{ request()->routeIs('checksheet.*') ? 'active' : '' }}">
                                                            <i class="nav-icon fas fa-clipboard-check"></i>
                                                            <p>Monitoring Preventive Maintenance</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('alat.index') }}"
                                                            class="nav-link {{ request()->routeIs('alat.*') ? 'active' : '' }}">
                                                            <i class="nav-icon fas fa-bus"></i>
                                                            <p>Monitoring Alat Angkut</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('mro.riwayat') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'mro.riwayat' ? 'active' : '' }}">
                                                            <i class="nav-icon fas fa-history"></i>
                                                            <p>Riwayat PR/SPPJP MRO</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('perencanaan.proyek') }}"
                                                            class="nav-link {{ request()->routeIs('perencanaan.*') ? 'active' : '' }}">
                                                            <i class="nav-icon fas fa-clipboard-list"></i>
                                                            <p>Perencanaan Pekerjaan</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('proyek.index') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'proyek.index' ? 'active' : '' }}">
                                                            <i class="fas fa-chart-bar nav-icon"></i>
                                                            <p>{{ __(' Proyek MRO') }}</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('mro.progress') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'mro.progress' ? 'active' : '' }}">
                                                            <i class="nav-icon fas fa-chart-line"></i>
                                                            <p>Progress MRO</p>
                                                        </a>
                                                    </li>


                                                    <li class="nav-item">
                                                        <a href="{{ route('mro') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'mro' ? 'active' : '' }}">
                                                            <i class="fas fa-box-open nav-icon"></i>
                                                            <p>{{ __(' Stok Barang MRO') }}</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('mro.stock.log') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'mro.stock.log' ? 'active' : '' }}">
                                                            <i class="nav-icon fas fa-people-carry"></i>
                                                            <p>Mutasi Stok MRO</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('sppd.index') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'sppd.index' ? 'active' : '' }}">
                                                            <i class="nav-icon far fa-file-archive"></i>
                                                            <p>Arsip SPPD MRO</p>
                                                        </a>
                                                    </li>

                                                    
                                                    <li class="nav-item">

                                                        <a href="{{ route('cuti.tahunan') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'cuti.tahunan' ? 'active' : '' }}">

                                                            <i class="nav-icon fas fa-calendar-check"></i>

                                                            <p>Master Cuti Tahunan</p>

                                                        </a>

                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{ route('cuti.index') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'cuti.index' ? 'active' : '' }}">

                                                            <i class="nav-icon fas fa-calendar-alt"></i>

                                                            <p>Management Cuti</p>

                                                        </a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a href="{{ route('cuti.rekap') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'cuti.rekap' ? 'active' : '' }}">

                                                            <i class="nav-icon fas fa-table"></i>

                                                            <p>Rekap Cuti Bulanan</p>

                                                        </a>
                                                    </li>

                                                    

                                                </ul>
                                            </li>
                                        @endif --}}

                                        {{-- MENU MRO --}}
                                        @if (Auth::user()->role == 0 || Auth::user()->role == 14 || Auth::user()->role == 17)
                                            <li
                                                class="nav-item has-treeview {{ $menuMroActive ? 'menu-open' : '' }}">
                                                <a href="#" class="nav-link">
                                                    <i class="nav-icon fas fa-tools"></i>
                                                    <p>
                                                        {{ __('MRO') }}
                                                        <i class="right fas fa-angle-left"></i>
                                                    </p>
                                                </a>

                                                <ul class="nav nav-treeview pl-3">

                                                    {{-- ADMIN & MRO FULL ACCESS --}}
                                                    @if (Auth::user()->role == 0 || Auth::user()->role == 14)
                                                        {{-- Personil MRO --}}

                                                        <li class="nav-item">
                                                            <a href="{{ route('mro.profil') }}"
                                                                class="nav-link {{ Route::current()->getName() == 'mro.profil' ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-video"></i>
                                                                <p>Personil MRO</p>
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="{{ route('mro.daily-activity.index') }}"
                                                                class="nav-link {{ request()->routeIs('mro.daily-activity.*') ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-calendar-check"></i>
                                                                <p>Daily Activity</p>
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="{{ route('mro.weekly-activity') }}"
                                                                class="nav-link {{ request()->routeIs('mro.weekly-activity') ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-chart-line"></i>
                                                                <p>Weekly Activity</p>
                                                            </a>
                                                        </li>

                                                        {{-- Dashboard --}}
                                                        <li
                                                            class="nav-item has-treeview {{ Route::is('pengiriman.dashboard*') || Route::is('rewinding.dashboard*') || Route::is('lp3m.dashboard*') || Route::is('alat.dashboard*') ? 'menu-open' : '' }}">

                                                            <a href="#"
                                                                class="nav-link {{ Route::is('pengiriman.dashboard*') || Route::is('rewinding.dashboard*') || Route::is('lp3m.dashboard*') || Route::is('alat.dashboard*') ? 'active' : '' }}">

                                                                <i class="nav-icon fas fa-tachometer-alt"></i>

                                                                <p>
                                                                    Dashboard
                                                                    <i class="right fas fa-angle-left"></i>
                                                                </p>

                                                            </a>

                                                            <ul class="nav nav-treeview">

                                                                <li class="nav-item">

                                                                    <a href="{{ route('pengiriman.dashboard') }}"
                                                                        class="nav-link {{ Route::currentRouteName() == 'pengiriman.dashboard' ? 'active' : '' }}">

                                                                        <i class="far fa-circle nav-icon"></i>

                                                                        <p>Dashboard Pengiriman</p>

                                                                    </a>

                                                                </li>

                                                                <li class="nav-item">

                                                                    <a href="{{ route('alat.dashboard') }}"
                                                                        class="nav-link {{ Route::currentRouteName() == 'alat.dashboard' ? 'active' : '' }}">

                                                                        <i class="far fa-circle nav-icon"></i>

                                                                        <p>
                                                                            Dashboard Alat Angkat-Angkut
                                                                        </p>

                                                                    </a>

                                                                </li>

                                                                <li class="nav-item">

                                                                    <a href="{{ route('lp3m.dashboard') }}"
                                                                        class="nav-link {{ Route::currentRouteName() == 'lp3m.dashboard' ? 'active' : '' }}">

                                                                        <i class="far fa-circle nav-icon"></i>

                                                                        <p>Dashboard SPR</p>

                                                                    </a>

                                                                </li>

                                                                <li class="nav-item">

                                                                    <a href="{{ route('rewinding.dashboard') }}"
                                                                        class="nav-link {{ Route::currentRouteName() == 'rewinding.dashboard' ? 'active' : '' }}">

                                                                        <i class="far fa-circle nav-icon"></i>

                                                                        <p>Dashboard Rewinding</p>

                                                                    </a>

                                                                </li>



                                                            </ul>

                                                        </li>




                                                        <li class="nav-item">
                                                            <a href="{{ route('perencanaan.proyek') }}"
                                                                class="nav-link {{ request()->routeIs('perencanaan.*') ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-clipboard-list"></i>
                                                                <p>Perencanaan Pekerjaan</p>
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="{{ route('proyek.index') }}"
                                                                class="nav-link {{ Route::current()->getName() == 'proyek.index' ? 'active' : '' }}">
                                                                <i class="fas fa-chart-bar nav-icon"></i>
                                                                <p>Proyek MRO</p>
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="{{ route('mro.progress') }}"
                                                                class="nav-link {{ Route::current()->getName() == 'mro.progress' ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-chart-line"></i>
                                                                <p>Progress MRO</p>
                                                            </a>
                                                        </li>


                                                        <li class="nav-item">
                                                            <a href="{{ route('mro.riwayat') }}"
                                                                class="nav-link {{ Route::current()->getName() == 'mro.riwayat' ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-history"></i>
                                                                <p>Riwayat PR/SPPJP MRO</p>
                                                            </a>
                                                        </li>

                                                        {{-- Monitoring --}}
                                                        <li
                                                            class="nav-item {{ request()->routeIs('pengiriman.index', 'checksheet.*', 'alat.index', 'rewinding.index', 'fasilitas-harian.*', 'asset-maintenance.*', 'assets.*', 'lp3m.index') ? 'menu-open' : '' }}">
                                                            <a href="#"
                                                                class="nav-link {{ request()->routeIs('pengiriman.index', 'checksheet.*', 'alat.index', 'rewinding.index', 'fasilitas-harian.*', 'asset-maintenance.*', 'assets.*', 'lp3m.index') ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-chart-line"></i>
                                                                <p>
                                                                    Monitoring
                                                                    <i class="right fas fa-angle-left"></i>
                                                                </p>
                                                            </a>

                                                            <ul class="nav nav-treeview">
                                                                {{-- Monitoring Pengiriman --}}
                                                                <li class="nav-item">
                                                                    <a href="{{ route('pengiriman.index') }}"
                                                                        class="nav-link {{ request()->routeIs('pengiriman.index') ? 'active' : '' }}">
                                                                        <i class="nav-icon far fa-circle"></i>
                                                                        <p>Monitoring Pengiriman</p>
                                                                    </a>
                                                                </li>

                                                                {{-- Monitoring Alat Angkat-angkut --}}
                                                                <li class="nav-item">
                                                                    <a href="{{ route('alat.index') }}"
                                                                        class="nav-link {{ request()->routeIs('alat.index') ? 'active' : '' }}">
                                                                        <i class="nav-icon far fa-circle"></i>
                                                                        <p>Monitoring Alat Angkat-Angkut</p>
                                                                    </a>
                                                                </li>

                                                                {{-- Checksheet Harian Fasilitas --}}
                                                                <li class="nav-item">

                                                                    <a href="{{ route('fasilitas-harian.index') }}"
                                                                        class="nav-link {{ request()->routeIs('fasilitas-harian.*') ? 'active' : '' }}">

                                                                        <i class="nav-icon far fa-circle"></i>

                                                                        <p>
                                                                            Checksheet Harian Fasilitas
                                                                        </p>

                                                                    </a>

                                                                </li>

                                                                {{-- Monitoring Preventive Maintenance --}}
                                                                <li
                                                                    class="nav-item has-treeview
                                                                    {{ request()->routeIs('assets.*') ||
                                                                    request()->routeIs('asset-maintenance.*') ||
                                                                    request()->routeIs('checksheet.*')
                                                                        ? 'menu-open'
                                                                        : '' }}">

                                                                    <a href="#"
                                                                        class="nav-link
                                                                        {{ request()->routeIs('assets.*') ||
                                                                        request()->routeIs('asset-maintenance.*') ||
                                                                        request()->routeIs('checksheet.*')
                                                                            ? 'active'
                                                                            : '' }}">

                                                                        <i class="nav-icon far fa-circle"></i>

                                                                        <p>
                                                                            Monitoring PM
                                                                            <i class="right fas fa-angle-left"></i>
                                                                        </p>

                                                                    </a>

                                                                    <ul class="nav nav-treeview">

                                                                        {{-- Matrix Asset --}}
                                                                        <li
                                                                            class="nav-item has-treeview
                                                                            {{ request()->routeIs('assets.*') || request()->routeIs('asset-maintenance.*') ? 'menu-open' : '' }}">

                                                                            <a href="#"
                                                                                class="nav-link
                                                                                {{ request()->routeIs('assets.*') || request()->routeIs('asset-maintenance.*') ? 'active' : '' }}">

                                                                                <i
                                                                                    class="far fa-dot-circle nav-icon"></i>

                                                                                <p>
                                                                                    Matrix Asset
                                                                                    <i
                                                                                        class="right fas fa-angle-left"></i>
                                                                                </p>

                                                                            </a>

                                                                            <ul class="nav nav-treeview">

                                                                                <li class="nav-item">

                                                                                    <a href="{{ route('assets.index') }}"
                                                                                        class="nav-link {{ request()->routeIs('assets.*') ? 'active' : '' }}">

                                                                                        <i
                                                                                            class="far fa-dot-circle nav-icon"></i>

                                                                                        <p>Master Matrix Perawatan Asset
                                                                                        </p>

                                                                                    </a>

                                                                                </li>

                                                                                <li class="nav-item">

                                                                                    <a href="{{ route('asset-maintenance.index') }}"
                                                                                        class="nav-link {{ request()->routeIs('asset-maintenance.*') ? 'active' : '' }}">

                                                                                        <i
                                                                                            class="far fa-dot-circle nav-icon"></i>

                                                                                        <p>Matrix Perawatan Asset</p>

                                                                                    </a>

                                                                                </li>

                                                                            </ul>

                                                                        </li>

                                                                        {{-- Checksheet --}}
                                                                        <li class="nav-item">

                                                                            <a href="{{ route('checksheet.index') }}"
                                                                                class="nav-link {{ request()->routeIs('checksheet.*') ? 'active' : '' }}">

                                                                                <i
                                                                                    class="far fa-dot-circle nav-icon"></i>

                                                                                <p>Checksheet Preventive Maintenance</p>

                                                                            </a>

                                                                        </li>

                                                                    </ul>

                                                                </li>

                                                                {{-- Monitroing SPR --}}
                                                                <li class="nav-item">
                                                                    <a href="{{ route('lp3m.index') }}"
                                                                        class="nav-link {{ request()->routeIs('lp3m.index') ? 'active' : '' }}">
                                                                        <i class="nav-icon far fa-circle"></i>
                                                                        <p>Monitoring SPR</p>
                                                                    </a>
                                                                </li>

                                                                {{-- Monitoring Rewinding --}}
                                                                <li class="nav-item">
                                                                    <a href="{{ route('rewinding.index') }}"
                                                                        class="nav-link {{ request()->routeIs('rewinding.index') ? 'active' : '' }}">
                                                                        <i class="nav-icon far fa-circle"></i>
                                                                        <p>Monitoring Rewinding</p>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </li>

                                                        {{-- End Monitoring --}}







                                                        {{-- <li class="nav-item">
                                                            <a href="{{ route('mro') }}"
                                                                class="nav-link {{ Route::current()->getName() == 'mro' ? 'active' : '' }}">
                                                                <i class="fas fa-box-open nav-icon"></i>
                                                                <p>Stok Barang MRO</p>
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="{{ route('mro.stock.log') }}"
                                                                class="nav-link {{ Route::current()->getName() == 'mro.stock.log' ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-people-carry"></i>
                                                                <p>Mutasi Stok MRO</p>
                                                            </a>
                                                        </li> --}}

                                                        {{-- Gudang --}}
                                                        <li
                                                            class="nav-item {{ request()->routeIs('mro', 'mro.stock.log') ? 'menu-open' : '' }}">
                                                            <a href="#"
                                                                class="nav-link {{ request()->routeIs('mro', 'mro.stock.log') ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-warehouse"></i>
                                                                <p>
                                                                    Gudang
                                                                    <i class="right fas fa-angle-left"></i>
                                                                </p>
                                                            </a>

                                                            <ul class="nav nav-treeview">

                                                                <li class="nav-item">
                                                                    <a href="{{ route('mro') }}"
                                                                        class="nav-link {{ Route::current()->getName() == 'mro' ? 'active' : '' }}">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Stok Barang MRO</p>
                                                                    </a>
                                                                </li>

                                                                <li class="nav-item">
                                                                    <a href="{{ route('mro.stock.log') }}"
                                                                        class="nav-link {{ Route::current()->getName() == 'mro.stock.log' ? 'active' : '' }}">
                                                                        <i class="nav-icon far fa-circle"></i>
                                                                        <p>Mutasi Stok MRO</p>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </li>

                                                        {{-- SPPD --}}
                                                        <li class="nav-item">
                                                            <a href="{{ route('sppd.index') }}"
                                                                class="nav-link {{ Route::current()->getName() == 'sppd.index' ? 'active' : '' }}">
                                                                <i class="nav-icon far fa-file-archive"></i>
                                                                <p>Arsip SPPD MRO</p>
                                                            </a>
                                                        </li>

                                                        {{-- Cuti --}}
                                                        <li
                                                            class="nav-item has-treeview {{ request()->routeIs('cuti.*') ? 'menu-open' : '' }}">
                                                            <a href="#"
                                                                class="nav-link {{ request()->routeIs('cuti.*') ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-calendar-check"></i>
                                                                <p>
                                                                    Cuti
                                                                    <i class="right fas fa-angle-left"></i>
                                                                </p>
                                                            </a>

                                                            <ul class="nav nav-treeview">

                                                                <li class="nav-item">
                                                                    <a href="{{ route('cuti.tahunan') }}"
                                                                        class="nav-link {{ request()->routeIs('cuti.tahunan*') ? 'active' : '' }}">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Master Cuti Tahunan</p>
                                                                    </a>
                                                                </li>

                                                                <li class="nav-item">
                                                                    <a href="{{ route('cuti.index') }}"
                                                                        class="nav-link {{ request()->routeIs('cuti.index') || request()->routeIs('cuti.edit') ? 'active' : '' }}">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Management Cuti</p>
                                                                    </a>
                                                                </li>

                                                                <li class="nav-item">
                                                                    <a href="{{ route('cuti.rekap') }}"
                                                                        class="nav-link {{ request()->routeIs('cuti.rekap') ? 'active' : '' }}">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Rekap Cuti Bulanan</p>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </li>
                                                    @endif


                                                    {{-- KHUSUS TEKNISI MRO --}}
                                                    @if (Auth::user()->role == 17)
                                                        <li class="nav-item">
                                                            <a href="{{ route('mro.profil') }}"
                                                                class="nav-link {{ Route::current()->getName() == 'mro.profil' ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-video"></i>
                                                                <p>Personil MRO</p>
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="{{ route('mro.daily-activity.index') }}"
                                                                class="nav-link {{ request()->routeIs('mro.daily-activity.*') ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-calendar-check"></i>
                                                                <p>Daily Activity</p>
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">

                                                            <a href="{{ route('fasilitas-harian.index') }}"
                                                                class="nav-link {{ request()->routeIs('fasilitas-harian.*') ? 'active' : '' }}">

                                                                <i class="nav-icon far fa-circle"></i>

                                                                <p>
                                                                    Checksheet Harian Fasilitas
                                                                </p>

                                                            </a>

                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="{{ route('checksheet.index') }}"
                                                                class="nav-link {{ request()->routeIs('checksheet.*') ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-clipboard-check"></i>
                                                                <p>Checksheet Preventive Maintenance</p>
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="{{ route('rewinding.index') }}"
                                                                class="nav-link {{ request()->routeIs('rewinding.*') ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-sync-alt"></i>
                                                                <p>Monitoring Rewinding</p>
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="{{ route('lp3m.index') }}"
                                                                class="nav-link {{ request()->routeIs('lp3m.*') ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-tools"></i>
                                                                <p>Monitoring SPR</p>
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="{{ route('mro.progress') }}"
                                                                class="nav-link {{ Route::current()->getName() == 'mro.progress' ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-chart-line"></i>
                                                                <p>Progress MRO</p>
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="{{ route('mro.riwayat') }}"
                                                                class="nav-link {{ Route::current()->getName() == 'mro.riwayat' ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-history"></i>
                                                                <p>Riwayat PR/SPPJP MRO</p>
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="{{ route('mro') }}"
                                                                class="nav-link {{ Route::current()->getName() == 'mro' ? 'active' : '' }}">
                                                                <i class="fas fa-box-open nav-icon"></i>
                                                                <p>Stok Barang MRO</p>
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="{{ route('mro.stock.log') }}"
                                                                class="nav-link {{ Route::current()->getName() == 'mro.stock.log' ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-people-carry"></i>
                                                                <p>Mutasi Stok MRO</p>
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="{{ route('cuti.rekap') }}"
                                                                class="nav-link {{ Route::current()->getName() == 'cuti.rekap' ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-table"></i>
                                                                <p>Rekap Cuti Bulanan</p>
                                                            </a>
                                                        </li>
                                                    @endif

                                                </ul>
                                            </li>
                                        @endif







                                        {{-- Contoh menu role Warehouse --}}
                                        @if (Auth::user()->role == 0 || Auth::user()->role == 4)
                                            <li class="nav-item has-treeview">
                                                <a href="#" class="nav-link">
                                                    <i class="nav-icon fas fa-warehouse"></i>
                                                    <p>
                                                        {{ __('Warehouse') }}
                                                        <i class="right fas fa-angle-left"></i>
                                                    </p>
                                                </a>

                                                <ul class="nav nav-treeview">

                                                    {{-- Stock In --}}
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link" data-toggle="modal"
                                                            data-target="#stock-form" onclick="stockForm(1)">
                                                            <i class="far fa-circle nav-icon"></i>
                                                            <p>{{ __('Stock In') }}</p>
                                                        </a>
                                                    </li>

                                                    {{-- Stock Out --}}
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link" data-toggle="modal"
                                                            data-target="#stock-form" onclick="stockForm(0)">
                                                            <i class="far fa-circle nav-icon"></i>
                                                            <p>{{ __('Stock Out') }}</p>
                                                        </a>
                                                    </li>

                                                    {{-- Stock History --}}
                                                    <li class="nav-item">
                                                        <a href="{{ route('products.stock.history') }}"
                                                            class="nav-link {{ Route::current()->getName() == 'products.stock.history' ? 'active' : '' }}">
                                                            <i class="far fa-circle nav-icon"></i>
                                                            <p>{{ __('Stock History') }}</p>
                                                        </a>
                                                    </li>

                                                </ul>
                                            </li>
                                        @endif
                                        {{-- End menu role Warehouse --}}



                                    </ul>
                                </li>

                            @endif
                            {{-- Menu --}}


                            @if (Auth::user()->role == 0 || Auth::user()->role == 4)
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'products.wip' ? 'active' : '' }}"
                                        href="{{ route('products.wip') }}">
                                        <i class="nav-icon fas fa-spinner"></i>
                                        <p class="text">{{ __('Work In Progress (WIP)') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'products.wip.history' ? 'active' : '' }}"
                                        href="{{ route('products.wip.history') }}">
                                        <i class="nav-icon fas fa-history"></i>
                                        <p class="text">{{ __('WIP History') }}</p>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->role == 0 || Auth::user()->role == 1 || Auth::user()->role == 4)
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'vendor.index' ? 'active' : '' }}"
                                        href="{{ route('vendor.index') }}">
                                        <i class="nav-icon fas fa-user-cog"></i>
                                        <p class="text">{{ __('Vendor') }}</p>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->role == 0 || Auth::user()->role == 4)
                                <li class="nav-header">Product</li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'products' ? 'active' : '' }}"
                                        href="{{ route('products') }}">
                                        <i class="nav-icon fas fa-boxes"></i>
                                        <p class="text">{{ __('Stok Barang') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'products.categories' ? 'active' : '' }}"
                                        href="{{ route('products.categories') }}">
                                        <i class="nav-icon fas fa-project-diagram"></i>
                                        <p class="text">{{ __('Kategori') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'products.shelf' ? 'active' : '' }}"
                                        href="{{ route('products.shelf') }}">
                                        <i class="nav-icon fas fa-cubes"></i>
                                        <p class="text">{{ __('Lokasi Penyimpanan') }}</p>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->role == 0 || Auth::user()->role == 2 || Auth::user()->role == 3 || Auth::user()->role == 4)
                                {{-- <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'keproyekan.index' ? 'active' : '' }}"
                                        href="{{ route('keproyekan.index') }}">
                                        <i class="nav-icon fas fa-hard-hat"></i>
                                        <p class="text">{{ __('Keproyekan') }}</p>
                                    </a>
                                </li> --}}
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'kode_material.index' ? 'active' : '' }}"
                                        href="{{ url('products/kode_material') }}">
                                        <i class="nav-icon fas fa-pallet"></i>
                                        <p class="text">{{ __('Kode Material') }}</p>
                                    </a>
                                </li>
                            @endif
                            {{-- @if (Auth::user()->role == 0)
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'keproyekan.index' ? 'active' : '' }}"
                                        href="{{ route('keproyekan.index') }}">
                                        <i class="nav-icon fas fa-hard-hat"></i>
                                        <p class="text">{{ __('Keproyekan') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'products.shelf' ? 'active' : '' }}"
                                        href="{{ route('products.shelf') }}">
                                        <i class="nav-icon fas fa-cubes"></i>
                                        <p class="text">{{ __('Lokasi Penyimpanan') }}</p>
                                    </a>
                                </li> --}}
                            {{-- <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'products.logistik' ? 'active' : '' }}"
                                        href="{{ route('products.logistik') }}">
                                        <i class="nav-icon fas fa-cubes"></i>
                                        <p class="text">{{ __('Tes Tracking Logistik') }}</p>
                                    </a>
                                </li> --}}
                            {{-- @endif --}}
                            <li class="nav-header">Settings</li>
                            @if (Auth::user()->role == 0)
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'warehouse' ? 'active' : '' }}"
                                        href="{{ route('warehouse') }}">
                                        <i class="nav-icon fas fa-warehouse"></i>
                                        <p class="text">{{ __('Warehouse') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::current()->getName() == 'users' ? 'active' : '' }}"
                                        href="{{ route('users') }}">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p class="text">{{ __('Users') }}</p>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link {{ Route::current()->getName() == 'myaccount' ? 'active' : '' }}"
                                    href="{{ route('myaccount') }}">
                                    <i class="nav-icon fas fa-user-cog"></i>
                                    <p class="text">{{ __('My Account') }}</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <form id="logout" action="{{ route('logout') }}" method="post">@csrf</form>
                                <a class="nav-link" href="javascript:;"
                                    onclick="document.getElementById('logout').submit();">
                                    <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                                    <p class="text">{{ __('Logout') }} ({{ Auth::user()->username }})</p>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                                    <p class="text">{{ __('Login') }}</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            @yield('content')
        </div>

        {{-- <footer class="main-footer">
            <b>PT</b> {{ config('app.version') }}
            <img src="{{ asset('img/garis.jpg') }}" style="width: 100%;" />
        </footer> --}}

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
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
                            <form id="cetak-pr" method="GET" action="{{ route('cetak_pr') }}" target="_blank">
                                <input type="hidden" name="id" id="id">
                            </form>
                            <div class="col-12" id="container-form">
                                <button id="button-cetak-pr" type="button" class="btn btn-primary"
                                    onclick="document.getElementById('cetak-pr').submit();">{{ __('Cetak') }}</button>
                                <table class="align-top w-100">
                                    <tr>
                                        <td style="width: 3%;"><b>No PR</b></td>
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
                                        <td><b>Produk</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <button id="button-tambah-produk" type="button"
                                                class="btn btn-info mb-3"
                                                onclick="showAddProduct()">{{ __('Tambah Item Detail') }}</button>
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
                                            <th>{{ __('Nota Pembelian') }}</th>
                                            <th>{{ __('Keterangan') }}</th>
                                            {{-- <th>{{ __('SPPH') }}</th>
                                                <th>{{ __('PO') }}</th> --}}
                                            <th>{{ __('STATUS') }}</th>
                                        </thead>
                                        <tbody id="table-prs">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-0 d-none" id="container-product">
                                <div class="card">
                                    <div class="card-body">
                                        {{-- //radio button with label INKA or IMSS option --}}
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

                                            <input type="text" class="form-control" id="pcodes" name="pcodes"
                                                min="0" placeholder="Product Code">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" id="button-check"
                                                    onclick="productChecks()">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="loaders" class="card">
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
                                                    class="col-sm-4 col-form-label">{{ __('Nama Barang') }}</label>
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

                                            <div class="form-group row">
                                                <label for="lampiran"
                                                    class="col-sm-4 col-form-label">{{ __('Nota Pembelian') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="file" class="form-control" id="lampiran"
                                                        name="lampiran" />
                                                </div>
                                            </div>

                                        </form>
                                        <button id="button-update-pr" type="button" class="btn btn-primary w-100"
                                            onclick="PRupdates()">{{ __('Tambahkan') }}</button>
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
                        <p>Anda yakin ingin menghapus request ini <span id="pcodes"
                                class="font-weight-bold"></span>?</p>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default"
                        data-dismiss="modal">{{ __('Batal') }}</button>
                    <button id="button-save" type="button" class="btn btn-danger"
                        onclick="document.getElementById('delete').submit();">{{ __('Ya, hapus') }}</button>
                </div>
            </div>
        </div>
    </div>

    {{-- stock form --}}
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
                                    <button class="btn btn-primary" id="button-check" onclick="productCheck()">
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
                    <div id="inner-stock-form" class="card">
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
                                        <input type="text" class="form-control" id="no_nota" name="no_nota">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-sm-4 col-form-label">{{ __('Nama') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="name" name="name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pamount"
                                        class="col-sm-4 col-form-label">{{ __('Jumlah') }}</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="pamount" name="pamount"
                                            min="1" value="1">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="shelf" class="col-sm-4 col-form-label">Lokasi</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" style="width: 100%;" id="shelf"
                                            name="shelf">
                                        </select>
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
                    <button type="button" class="btn btn-default"
                        data-dismiss="modal">{{ __('Close') }}</button>
                    <button id="button-update" type="button" class="btn btn-primary"
                        onclick="stockUpdate()">{{ __('Stock In') }}</button>
                </div>
            </div>
        </div>
    </div>

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
                                    <button class="btn btn-primary" id="button-check" onclick="productCheck()">
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
                                        <input type="text" class="form-control" id="no_nota" name="no_nota">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-sm-4 col-form-label">{{ __('Spesifikasi') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="name" name="name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pamount"
                                        class="col-sm-4 col-form-label">{{ __('Jumlah') }}</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="pamount" name="pamount"
                                            min="1" value="1">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="shelf" class="col-sm-4 col-form-label">Lokasi</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" style="width: 100%;" id="shelf"
                                            name="shelf">
                                        </select>
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
                    <button type="button" class="btn btn-default"
                        data-dismiss="modal">{{ __('Close') }}</button>
                    <button id="button-update" type="button" class="btn btn-primary"
                        onclick="stockUpdate()">{{ __('Stock In') }}</button>
                </div>
            </div>
        </div>
    </div>

    {{-- stock form --}}








    {{-- modal lihat detail --}}
    <div class="modal fade" id="detail-track-pr">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title-tracking" class="modal-title-tracking">{{ __('Detail Purchase Request') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="row">
                            <form id="cetak-pr" method="GET" action="{{ route('cetak_pr') }}" target="_blank">
                                <input type="hidden" name="id" id="id">
                            </form>
                            <div class="col-12" id="container-form">
                                {{-- <button id="button-cetak-pr" type="button" class="btn btn-primary"
                                        onclick="document.getElementById('cetak-pr').submit();">{{ __('Cetak') }}</button> --}}
                                <table class="align-top w-100">
                                    <tr>
                                        <td style="width: 3%;"><b>No PR</b></td>
                                        <td style="width:2%">:</td>
                                        <td style="width: 55%"><span id="no_surat_tracking"></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>Tanggal</b></td>
                                        <td>:</td>
                                        <td><span id="tgl_surat_tracking"></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>Proyek</b></td>
                                        <td>:</td>
                                        <td><span id="proyek_tracking"></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>Produk</b></td>
                                    </tr>
                                    {{-- <tr>
                                            <td colspan="3">
                                                <button id="button-tambah-produk" type="button" class="btn btn-info mb-3"
                                                    onclick="showAddProduct()">{{ __('Tambah Produk') }}</button>
                                            </td>
                                        </tr> --}}
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
                                            <th>{{ __('Keterangan') }}</th>
                                            <th>{{ __('Waktu Penyelesaian') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Ekspedisi') }}</th>
                                            <th>{{ __('QC') }}</th>
                                        </thead>
                                        <tbody id="table-tracking-pr">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-0 d-none" id="container-product">
                                <div class="card">
                                    <div class="card-body">
                                        {{-- //radio button with label INKA or IMSS option --}}
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
                                                    class="col-sm-4 col-form-label">{{ __('Nama Barang') }}</label>
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
                                                <label for="keterangan"
                                                    class="col-sm-4 col-form-label">{{ __('Keterangan') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="keterangan"
                                                        name="keterangan">
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
                                                <label for="countdown"
                                                    class="col-sm-4 col-form-label">{{ __('Durasi Penyelesaian') }}</label>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control" id="countdown"
                                                        name="countdown">
                                                </div>
                                            </div>
                                        </form>
                                        <button id="button-update-pr" type="button" class="btn btn-primary w-100"
                                            onclick="PRupdates()">{{ __('Tambahkan') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script src="{{ asset('js/adminlte.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        let table = new DataTable('#datatable', {
            responsive: true
        });
    </script>

    @hasSection('custom-js')
        @yield('custom-js')
    @endif

    <script>
        $(document).ready(function() {
            $('#inner-stock-form').hide();
        });
    </script>

    <script>
        // console.log("ready 123!");
        // $(document).ready(function() {
        // $('#inner-stock-form').hide();
        // });
        loader(0);


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
            $("#inner-stock-form").hide();
            resetForm();
            $("#type").val(type);
            //remove #proyek_id first
            $('#inner-stock-form').find('.card-body').find('#proyek_id').parent().parent().remove();
            if (type == 0) {
                $('#modal-title').text("Stock Out");
                $('#button-update').text("Stock Out");
                $("#date").show();

                //find child in #inner-stock-form with class .card-body then append
                $('#inner-stock-form').find('.card-body').append(
                    '<div class="form-group row"><label for="proyek_id" class="col-sm-4 col-form-label">Keproyekan</label><div class="col-sm-8"><select class="form-control select2" style="width: 100%;" id="proyek_id" name="proyek_id"></select></div></div>'
                );

            } else if (type == 1) {
                $('#modal-title').text("Stock In");
                $('#button-update').text("Stock In");
                $("#date").show();
                //remove the proyek_id
                $('#inner-stock-form').find('.card-body').find('#proyek_id').parent().parent().remove();
            } else {
                $('#modal-title').text("Retur");
                $('#button-update').text("Retur");
                $("#date").hide();
                //remove the proyek_id
                $('#inner-stock-form').find('.card-body').find('#proyek_id').parent().parent().remove();
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

        // function enableStockInput() {
        //     $('#button-update').prop("disabled", false);
        //     $("#button-update").show();
        //     $('#inner-stock-form').show();
        // }

        // function disableStockInput() {
        //     $('#button-update').prop("disabled", true);
        //     $("#button-update").hide();
        //     $('#inner-stock-form').hide();
        // }




        function loader(status = 1) {
            if (status == 1) {
                $('#loader').show();
            } else {
                $('#loader').hide();
            }
        }


        function productCheck() {
            var pcode = $('#pcode').val();
            console.log(pcode)
            if (pcode.length > 0) {
                loader();
                $('#inner-stock-form').hide();
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

    <script>
        function resetForm() {
            $('#save').trigger("reset");
            $('#barcode_preview_container').hide();
        }

        $('#detail-pr').on('hidden.bs.modal', function() {
            $('#container-product').addClass('d-none');
            $('#container-product').removeClass('col-5');
            $('#container-form').addClass('col-12');
            $('#container-form').removeClass('col-7');
            $('#button-tambah-detail').text('Tambah Item Detail');
        });


        $('#detail-track-pr').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var data = button.data('detail');
            $('#modal-title-tracking').text("Detail Request");
            resetForm();
            $('#id').val(data.id);
            $('#no_surat_tracking').text(data.no_pr);
            $('#tgl_surat_tracking').text(data.tgl_pr);
            $('#proyek_tracking').text(data.nama_pekerjaan);
            $('#proyek_id_val_tracking').val(data.proyek_id);
            $('#pr_id_tracking').val(data.id);
            $('#table-prs').empty();
            console.log(data);
            $.ajax({
                url: "{{ url('/products/purchase_request_detail') }}" + "/" + data.id,
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    $('#table-tracking-pr').append(
                        '<tr><td colspan="19" class="text-center">Loading...</td></tr>');
                    $('#button-cetak-pr').html('<i class="fas fa-spinner fa-spin"></i> Loading...');
                    $('#button-cetak-pr').attr('disabled', true);
                },
                success: function(data) {
                    console.log(data);

                    if (data.pr.details.length == 0) {
                        $('#table-tracking-pr').empty();
                        $('#table-tracking-pr').append(
                            '<tr><td colspan="19" class="text-center">Tidak ada produk</td></tr>');
                    } else {
                        $('#table-tracking-pr').empty();

                        $.each(data.pr.details, function(key, value) {

                            var id = value.id;
                            var status, spph, po, loi, spph_rfq, negoluar, purchase_orderluar,
                                loiluar;

                            spph = value.id_spph ? value.nomor_spph : '-';

                            // Cek nilai PO
                            po = value.id_po ? value.no_po : '-';

                            // Cek nilai LOI
                            loi = value.id_loi ? value.nomor_loi : '-';

                            // Cek nilai SPPH RFQ
                            spph_rfq = value.id_spph_rfq ? value.nomor_spph_rfq : '-';

                            // Cek nilai Negosiasi Luar
                            negoluar = value.id_negoluar ? value.nomor_negoluar : '-';

                            // Cek nilai Purchase Order Luar
                            purchase_orderluar = value.id_purchase_orderluar ? value.no_poluar :
                                '-';

                            // Cek nilai LOI
                            loiluar = value.id_loiluar ? value.nomor_loiluar : '-';

                            var hasSPPH = data.pr.details.some(function(item) {
                                return item.id_spph !== null;
                            });

                            if (value.batas_akhir == null) {
                                value.batas_akhir = '-';
                            }

                            // Atur tombol simpan berdasarkan keberadaan SPPH
                            $('#edit_pr_save').prop('disabled', !hasSPPH);

                            // Tentukan status proses
                            if (!value.id_spph && !value.id_loi && !value.id_po && !value
                                .id_spphrfq && !value.id_negoluar && !value
                                .id_purchase_orderluar && !value.id_loiluar) {
                                status = 'PR DONE, Menunggu SPPH atau LOI atau PO';
                            } else if (value.id_spph && !value.id_nego) {
                                status = 'Sedang Proses NEGOSIASI (Melalui SPPH)';
                            } else if (value.id_spphrfq && !value.id_negoluar) {
                                status =
                                    'Sedang Proses NEGOSIASI Luar Negeri (Melalui SPPH Luar Negeri)';
                            } else if (value.id_spph && value.id_nego && !value.id_po) {
                                status = 'Sedang Proses PO dari NEGOSIASI (Melalui SPPH)';
                            } else if (value.id_spphrfq && value.id_negoluar && !value
                                .id_poluar) {
                                status =
                                    'Sedang Proses PO Luar Negeri (Melalui SPPH Luar Negeri)';
                            } else if (value.id_loi && !value.id_nego) {
                                status = 'Sedang Proses NEGOSIASI (Melalui LOI)';
                            } else if (value.id_loiluar && !value.id_negoluar) {
                                status =
                                    'Sedang Proses NEGOSIASI Luar Negeri (Melalui LOI Luar Negeri)';
                            } else if (value.id_loi && value.id_nego && !value.id_po) {
                                status = 'Sedang Proses PO dari NEGOSIASI (Melalui LOI)';
                            } else if (value.id_loiluar && value.id_negoluar && !value
                                .id_poluar) {
                                status =
                                    'Sedang Proses PO Luar Negeri (Melalui LOI Luar Negeri)';
                            } else if (!value.id_spph && !value.id_loi && value.id_po) {
                                status = 'Sedang Proses PO Pembelian Langsung ';
                            } else if (value.id_po && value.no_po) {
                                status = 'Selesai di Proses hingga PO';
                            } else if (value.id_poluar && value.no_poluar) {
                                status = 'Selesai di Proses hingga PO';
                            }

                            // Alur 3: PR langsung dibuat -> PO
                            else if (!value.id_spph && !value.id_loi && value.id_po) {
                                status = 'Sedang Proses PO Pembelian Langsung ';
                            }

                            // PO Completed
                            else if (value.id_po && value.no_po) {
                                status =
                                    '<span style="color: green; font-weight: bold;">COMPLETED</span>';
                            }

                            console.log(status);


                            // STATUS LAMA

                            // else if (value.id_spph && !value.no_sph) {
                            //     status = 'Lakukan SPH';
                            // } else if (value.id_spph && value.no_sph && !value.no_just) {
                            //     status = 'Lakukan Justifikasi';
                            // } else if (value.id_spph && value.no_sph && value.no_just && !value.id_po) {
                            //     status = 'Lakukan Nego/PO';
                            // }
                            //  else if (value.id_spph && value.no_sph && value
                            //     .id_po) {
                            //     status = 'COMPLETED';
                            // }

                            var date;
                            var msg = '';

                            if (value.waktu == null) {
                                date = '-';
                                msg = '-';
                            } else {
                                msg = 'batas penerimaan barang : ';
                                date = value.waktu;
                            }
                            const ekspedisi = value.ekspedisi ? value.ekspedisi : '-';

                            const diterima_qc = value?.diterima_qc ?? '-';
                            const belum_diterima_qc = value?.belum_diterima_qc ?? '-';
                            const diterima_eks = value?.diterima_eks ?? '-';
                            const belum_diterima_eks = value?.belum_diterima_eks ?? '-';
                            const ok = value?.hasil_ok ?? '-';
                            const nok = value?.hasil_nok ?? '-';

                            const qc = value?.qc

                            let content = ''

                            if (qc) {
                                //append the qc.penerimaan, qc.hasil_ok, qc.hasil_nok, qc.tanggal_qc
                                content = `<p class="mt-2 mb-0">Penerimaan : ${qc.penerimaan}</p>
                                <p class="mt-2 mb-0">OK : ${qc.hasil_ok}</p>
                                <p class="mt-2 mb-0">NOK : ${qc.hasil_nok}</p>
                                <p class="mt-2 mb-0">${qc.tanggal_qc}</p>`
                            } else {
                                content = '-'
                            }

                            // Hentikan countdown jika PO atau PO luar sudah selesai
                            if ((value.id_po && value.no_po) || (value.id_poluar && value
                                    .no_poluar)) {
                                value.countdown = 'Selesai di Proses hingga PO ✅';
                                value.backgroundcolor = 'green'; // teks akan jadi biru
                            }

                            // $('#table-tracking-pr').append('<tr><td>' + (key + 1) +
                            //     '</td><td>' + value
                            //     .kode_material + '</td><td>' + value.uraian + '</td><td>' +
                            //     value
                            //     .spek + '</td><td>' + value.qty + '</td><td>' + value
                            //     .satuan + '</td><td>' + value
                            //     .keterangan + '</td><td>' + value.waktu +
                            //     '</td><td style="color:' +
                            //     value.backgroundcolor + '">' + value.countdown +
                            //     '</td>' + '<td><b>' + status +
                            //     '</b><br><br><b>' +
                            //     msg + date + '</b></td><td style="min-width:200px">' +
                            //     ekspedisi +
                            //     // '</td><td style="min-width:200px">' + content +
                            //     '</td></tr>'
                            // );

                            $('#table-tracking-pr').append('<tr>' +
                                '<td>' + (key + 1) + '</td>' +
                                '<td>' + value.kode_material + '</td>' +
                                '<td>' + value.uraian + '</td>' +
                                '<td>' + value.spek + '</td>' +
                                '<td>' + value.qty + '</td>' +
                                '<td>' + value.satuan + '</td>' +
                                '<td>' + value.waktu + '</td>' +
                                '<td style="color:' + value.backgroundcolor + '">' + value
                                .countdown + '</td>' +
                                '<td><b>' + status + '</b><br><br><b>' + msg + date +
                                '</b></td>' +
                                '<td style="min-width:200px">' +
                                '<b>Sudah Diterima : &nbsp;' + diterima_eks + '</b><br>' +
                                '<b>Belum Diterima : &nbsp;' + belum_diterima_eks + '</b>' +
                                '</td>' +
                                '<td style="min-width:200px">' +
                                '<b>Sudah Diterima : &nbsp;' + diterima_qc + '</b><br>' +
                                '<b>Belum Diterima : &nbsp;' + belum_diterima_qc +
                                '</b><br>' +
                                '<b>OK : &nbsp;' + ok + '</b><br>' +
                                '<b>NOK : &nbsp;' + nok + '</b>' +
                                '</td>' +
                                '</tr>');

                        });
                    }
                }
            });
        });
    </script>




</body>

</html>
