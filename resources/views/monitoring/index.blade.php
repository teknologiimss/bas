@extends('layouts.main')

@section('title', 'Monitoring')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
<style>
    .doc-item {
        border-radius: 14px;
        background: #ffffff;
        transition: all 0.3s ease;
    }

    .doc-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
    }

    .transition {
        transition: all 0.4s ease;
    }

    .animate__fadeInUp {
        animation: fadeSlideUp 0.5s ease forwards;
    }

    @keyframes fadeSlideUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate__fadeOutDown {
        animation: fadeSlideDown 0.4s ease forwards;
    }

    @keyframes fadeSlideDown {
        from {
            opacity: 1;
            transform: translateY(0);
        }

        to {
            opacity: 0;
            transform: translateY(15px);
        }
    }

    .action-btn {
        width: 34px;
        height: 34px;
        border: none;
        background: transparent;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }

    .action-btn:hover {
        background-color: rgba(0, 0, 0, 0.05);
        transform: scale(1.1);
    }

    .action-btn.text-primary:hover {
        background-color: rgba(13, 110, 253, 0.1);
    }

    .action-btn.text-danger:hover {
        background-color: rgba(53, 53, 220, 0.1);
    }

    body {
        background: linear-gradient(135deg, #f7f5ff, #ffeaea);
    }

    .card {
        border-radius: 16px !important;
        background: rgba(255, 255, 255, 0.85);
        box-shadow: 0 10px 30px rgba(36, 0, 179, 0.08);
    }

    h3 b {
        background: linear-gradient(45deg, #14003f, #1c008d);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .btn-success {
        background: linear-gradient(135deg, #14003f, #1c008d) !important;
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(15, 0, 74, 0.25);
        transition: all 0.25s ease;
    }

    .btn-success:hover {
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 6px 18px rgba(15, 0, 74, 0.25);
    }

    #filterSection {
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(6px);
    }

    .position-relative.border.rounded {
        border: none !important;
        border-radius: 18px !important;
        background: linear-gradient(145deg, #ffffff, #f4f1ff);
        box-shadow: 0 8px 20px rgba(15, 0, 74, 0.25);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .position-relative.border.rounded::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(#14003f, #1c008d);
    }

    .position-relative.border.rounded:hover {
        transform: translateY(-5px) scale(1.01);
        box-shadow: 0 12px 30px rgba(15, 0, 74, 0.25);
    }

    .badge {
        border-radius: 30px;
        font-weight: 500;
        letter-spacing: 0.3px;
        animation: pulseBadge 2s infinite;
    }

    @keyframes pulseBadge {
        0% {
            box-shadow: 0 0 0 0 rgba(15, 0, 74, 0.25);
        }
        70% {
            box-shadow: 0 0 0 8px rgba(15, 0, 74, 0.25);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(255, 0, 0, 0);
        }
    }

    .progress {
        border-radius: 20px;
        overflow: hidden;
        background: #ffe5e5;
    }

    .progress-bar {
        font-size: 11px;
        font-weight: 600;
        animation: progressAnim 1.2s ease;
    }

    @keyframes progressAnim {
        from {
            width: 0;
        }
    }

    .doc-item {
        border-radius: 16px;
        background: linear-gradient(145deg, #ffffff, #fff5f5);
        transition: all 0.3s ease;
        border-left: 4px solid #14003f;
    }

    .doc-item:hover {
        transform: scale(1.02);
        box-shadow: 0 10px 25px rgba(20, 0, 80, 0.15);
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        border: 1px solid #ddd6ff;
        transition: all 0.2s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #14003f;
        box-shadow: 0 0 0 3px rgba(6, 0, 72, 0.1);
    }

    .action-btn {
        backdrop-filter: blur(4px);
        transition: all 0.25s ease;
    }

    .action-btn:hover {
        transform: scale(1.2) rotate(5deg);
    }

    .position-relative.border.rounded {
        animation: fadeInCard 0.5s ease;
    }

    @keyframes fadeInCard {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.98);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    #toggleFilterBtn {
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    #toggleFilterBtn:hover {
        background: #14003f;
        color: white;
    }

    html {
        scroll-behavior: smooth;
    }

    .position-relative.border.rounded h5 {
        font-weight: 700;
        font-size: 16px;
        letter-spacing: 0.3px;
        display: inline-block;
        padding: 6px 14px;
        border-radius: 12px;
        background: linear-gradient(135deg, #14003f, #17008c);
        color: white;
        box-shadow: 0 4px 12px rgba(20, 0, 106, 0.25);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .position-relative.border.rounded h5::after {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: 0.6s;
    }

    .position-relative.border.rounded:hover h5::after {
        left: 100%;
    }

    .position-relative.border.rounded:hover h5 {
        transform: scale(1.03);
        box-shadow: 0 6px 18px rgba(17, 0, 92, 0.35);
    }

    .modern-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .po-badge {
        background: linear-gradient(135deg, #14003f, #180066);
        color: white;
        padding: 10px 18px;
        border-radius: 999px;
        font-weight: 600;
        font-size: 14px;
        box-shadow: 0 4px 12px rgba(0, 7, 74, 0.25);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .po-badge span {
        background: rgba(255, 255, 255, 0.2);
        padding: 4px 10px;
        border-radius: 20px;
        margin-left: 6px;
    }

    .jenis-badge {
        background: #e1deff;
        color: #210264;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .modern-info {
        display: grid;
        gap: 10px;
        margin-top: 10px;
    }

    .info-item {
        background: #fff;
        padding: 10px 14px;
        border-radius: 10px;
        border-left: 4px solid #14003f;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        transition: 0.2s;
    }

    .info-item:hover {
        transform: translateX(4px);
        background: #f8f5ff;
    }

    .info-item span {
        font-size: 13px;
        color: #777777;
        min-width: 140px;
        flex-shrink: 0;
    }

    .info-item b,
    .nama-pekerjaan-content {
        flex: 1;
    }

    .info-item b {
        font-size: 14px;
        color: #333;
    }

    .nama-pekerjaan-wrapper {
        align-items: flex-start;
    }

    .nama-pekerjaan-content {
        display: flex;
        flex-direction: column;
    }

    .nama-text {
        font-size: 14px;
        font-weight: 600;
        color: #333;
        line-height: 1.5;
        word-break: break-word;
    }

    .short-text {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .full-text {
        -webkit-line-clamp: unset;
    }

    .btn-lihat {
        background: transparent;
        border: 1px solid #14003f;
        color: #14003f;
        padding: 4px 10px;
        font-size: 12px;
        border-radius: 20px;
        cursor: pointer;
        transition: 0.2s;
        white-space: nowrap;
    }

    .btn-lihat:hover {
        background: #14003f;
        color: white;
    }

    .dokumen-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        border-radius: 14px;
        background: linear-gradient(135deg, #f7f5ff, #eeeaff);
        border: 1px solid #e2d6ff;
        transition: 0.3s;
    }

    .dokumen-header:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(26, 0, 113, 0.1);
    }

    .dokumen-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        color: #14003f;
    }

    .icon-box {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #14003f, #1d0170);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 16px;
        box-shadow: 0 4px 10px rgba(37, 0, 170, 0.2);
    }

    .btn-dokumen {
        display: flex;
        align-items: center;
        gap: 8px;
        background: white;
        color: #14003f;
        border: 1px solid #14003f;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: 0.25s;
    }

    .btn-dokumen:hover {
        background: linear-gradient(135deg, #14003f, #1d005c);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(64, 0, 255, 0.3);
    }

    .btn-dokumen .arrow {
        transition: 0.3s;
    }

    .btn-dokumen:hover .arrow {
        transform: translateX(4px);
    }

    .status-badge {
        position: absolute;
        top: -6px;
        right: 10px;
        padding: 6px 14px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 999px;
        color: white;
        letter-spacing: 0.3px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: 0.3s;
    }

    .status-badge:hover {
        transform: translateY(-2px) scale(1.05);
    }

    .status-open {
        background: linear-gradient(135deg, #ffc107, #ff9800);
        color: #222;
    }

    .status-closed {
        background: linear-gradient(135deg, #00c853, #00a844);
    }

    .status-hold {
        background: linear-gradient(135deg, #ff1a1a, #b30000);
    }

    .status-default {
        background: linear-gradient(135deg, #6c757d, #495057);
    }

    @media (max-width: 768px) {
        .d-flex.justify-content-between.mb-3 {
            flex-direction: column !important;
            gap: 10px;
            align-items: stretch !important;
        }

        .d-flex.justify-content-between.mb-3 h3 {
            margin: 10px 0 !important;
            font-size: 20px;
            text-align: center;
        }

        .d-flex.justify-content-between.mb-3 .btn-success {
            width: 100%;
            margin: 0 !important;
        }

        .d-flex.justify-content-between.align-items-center.mb-3 {
            flex-direction: column;
            gap: 10px;
            align-items: stretch !important;
        }

        #toggleFilterBtn,
        .btn-outline-primary {
            width: 100%;
            margin: 0 !important;
            height: 42px !important;
            font-size: 13px;
        }

        .position-relative.border.rounded.p-3.mb-3.shadow-sm {
            padding: 14px !important;
        }

        .modern-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .po-badge {
            width: 100%;
            justify-content: center;
            text-align: center;
            font-size: 12px;
            padding: 10px;
        }

        .jenis-badge {
            width: 100%;
            text-align: center;
            font-size: 12px;
        }

        .info-item {
            flex-direction: column;
            gap: 4px;
            padding: 10px;
        }

        .info-item span {
            min-width: unset;
            font-size: 12px;
        }

        .info-item b,
        .nama-text {
            font-size: 13px;
        }

        .status-badge {
            position: static;
            margin-bottom: 12px;
            display: inline-flex;
            font-size: 11px;
            padding: 5px 12px;
        }

        .action-btn {
            width: 30px;
            height: 30px;
            font-size: 13px;
        }

        .d-flex.align-items-center.gap-2 {
            margin-top: 15px;
            justify-content: flex-end;
        }

        .dokumen-header {
            flex-direction: column;
            gap: 12px;
            align-items: stretch;
        }

        .dokumen-title {
            justify-content: center;
        }

        .btn-dokumen {
            width: 100%;
            justify-content: center;
            font-size: 12px;
            padding: 10px;
        }

        .doc-item {
            padding: 12px !important;
        }

        .doc-item .row {
            flex-direction: column;
        }

        .btn-update-doc,
        .btn-delete-doc {
            flex: 1;
            width: 100%;
            height: 38px;
            font-size: 12px;
            padding: 6px 10px !important;
        }

        .doc-item .d-flex.gap-2 {
            flex-direction: column;
        }

        .modal-dialog {
            margin: 10px;
        }

        .modal-body .row>div {
            margin-bottom: 10px;
        }

        #dokumenContainer .d-flex,
        [id^="dokumenContainerEdit"] .d-flex {
            flex-direction: column;
        }

        .progress {
            height: 16px !important;
        }

        .progress-bar {
            font-size: 10px;
        }

        small,
        .small {
            font-size: 11px !important;
        }

        .btn {
            font-size: 12px !important;
            padding: 7px 10px !important;
            border-radius: 8px !important;
        }

        .modal-footer .btn {
            flex: 1;
            height: 38px;
        }
    }
</style>

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h3><b style="margin: 23px;">Monitoring Proyek - {{ $proyek->nama_proyek }}</b></h3>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCreateMonitoring"
            style="margin-right: 23px;margin-top: 10;">
            + Buat Monitoring Baru
        </button>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <button id="toggleFilterBtn" class="btn btn-outline-primary btn-sm" style="margin-left: 23px;">
            🔍 Tampilkan Filter
        </button>
        <a href="{{ route('monitoring.export', $proyek->id) }}" class="btn btn-outline-primary"
            style="height: 38px; margin-top: 20px;">
            📦 Export Semua Dokumen
        </a>
    </div>

    <div id="filterSection" class="card p-3 mb-4 shadow-sm border-0 d-none animate__animated animate__fadeInDown">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="small text-muted mb-1">Nomor PO / Nota Dinas</label>
                <input type="text" id="searchPO" class="form-control form-control-sm"
                    placeholder="Cari Nomor PO / Nota Dinas...">
            </div>
            <div class="col-md-4">
                <label class="small text-muted mb-1">Nama Pekerjaan</label>
                <input type="text" id="searchNama" class="form-control form-control-sm"
                    placeholder="Cari Nama Pekerjaan...">
            </div>
            <div class="col-md-4">
                <label class="small text-muted mb-1">Tanggal Kontrak</label>
                <input type="date" id="searchTanggal" class="form-control form-control-sm">
            </div>
        </div>
    </div>

    <div class="card p-3">
        <h5>Daftar Monitoring</h5>

        @foreach ($monitorings as $m)
            <div class="position-relative border rounded p-3 mb-3 shadow-sm">
                @php
                    $statusClass = match ($m->status) {
                        'Open' => 'status-open',
                        'Closed' => 'status-closed',
                        'On Hold' => 'status-hold',
                        default => 'status-default',
                    };
                    $statusText = $m->status === 'On Hold' ? '⏸️ On Hold' : $m->status;
                @endphp

                <span class="status-badge {{ $statusClass }}">
                    {{ $statusText }}
                </span>

                <div class="d-flex justify-content-between align-items-center">
                    <div style="flex:1; min-width:0;">
                        <div class="modern-header">
                            <div class="po-badge">
                                📄 Nomor PO / Nota Dinas
                                <span>{{ $m->po_nota_dinas }}</span>
                            </div>

                            <div class="jenis-badge">
                                {{ $m->jenis_pekerjaan }}
                            </div>
                        </div>

                        <div class="modern-info">
                            <div class="info-item nama-pekerjaan-wrapper">
                                <span>📌 Nama Pekerjaan</span>
                                <div class="nama-pekerjaan-content">
                                    <div class="nama-text short-text nama-pekerjaan-filter" id="namaText{{ $m->id }}">
                                        {{ $m->nama_pekerjaan }}
                                    </div>
                                </div>
                            </div>

                            <div class="info-item" data-tanggal="{{ $m->tanggal_kontrak }}">
                                <span>📅 Periode Kontrak</span>
                                <b>
                                    {{ \Carbon\Carbon::parse($m->tanggal_kontrak)->format('d-m-Y') }}
                                    s/d
                                    {{ \Carbon\Carbon::parse($m->tanggal_selesai_kontrak)->format('d-m-Y') }}
                                </b>
                            </div>

                            <div class="info-item nama-pekerjaan-wrapper">
                                <span>📝 Keterangan</span>
                                <div class="nama-pekerjaan-content">
                                    <div class="nama-text short-text" id="keteranganText{{ $m->id }}">
                                        {{ $m->keterangan ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <small class="text-muted">Progress Pekerjaan</small>
                            <div class="progress" style="height: 18px;">
                                <div class="progress-bar" role="progressbar"
                                    style="width: {{ $m->progress ?? 0 }}%; background-color: {{ $m->progressColor() }};">
                                    {{ $m->progress ?? 0 }}%
                                </div>
                            </div>

                            <small class="d-block mt-1 text-muted">
                                @php
                                    $text = trim($m->keterangan2);
                                    if (str_starts_with($text, '-')) {
                                        $lines = preg_split('/\r\n|\r|\n/', $text);
                                        echo implode('<br>', $lines);
                                    } else {
                                        $lines = preg_split('/\r\n|\r|\n/', $text);
                                        echo implode(', ', $lines);
                                    }
                                @endphp
                            </small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-sm btn-outline-primary rounded-pill px-3" data-bs-toggle="modal"
                            data-bs-target="#modalCreateMemo{{ $m->id }}" title="Buat Memo">
                            📝 Buat Memo
                        </button>
                        <button class="action-btn text-primary" data-bs-toggle="modal"
                            data-bs-target="#modalEdit{{ $m->id }}" title="Edit">
                            <i class="fa fa-edit"></i>
                        </button>

                        <form action="{{ route('monitoring.destroy', $m->id) }}" method="POST" class="m-0 d-flex">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus monitoring ini?')" class="action-btn text-danger"
                                title="Delete">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

                @if ($m->documents->count())
                    <div class="mt-4 document-section" data-monitor-id="{{ $m->id }}">
                        <div class="dokumen-header">
                            <div class="dokumen-title">
                                <div class="icon-box">📁</div>
                                <span>Dokumen Terkait</span>
                            </div>

                            <button class="btn-dokumen toggle-docs-btn" type="button">
                                <span>👁️ Lihat Dokumen</span>
                                <i class="arrow">→</i>
                            </button>
                        </div>

                        <ul class="list-unstyled transition document-list mt-2" style="display: none;">
                            @foreach ($m->documents as $doc)
                                <li id="doc-{{ $doc->id }}"
                                    class="doc-item card shadow-sm border-0 mb-3 p-3 position-relative animate__animated animate__fadeInUp">

                                    <div class="row g-3 align-items-start">
                                        <div class="col-md-6">
                                            <label class="small fw-semibold mb-1">Nama Dokumen</label>
                                            <input type="text" class="form-control form-control-sm doc-name"
                                                value="{{ $doc->nama_dokumen }}" data-id="{{ $doc->id }}"
                                                placeholder="Nama dokumen...">

                                            <a href="{{ asset($doc->file_path) }}" target="_blank"
                                                id="file-link-{{ $doc->id }}"
                                                class="small text-primary d-inline-block mt-2">
                                                📄 Lihat File
                                            </a>

                                            <input type="file" class="form-control form-control-sm mt-2 doc-file"
                                                data-id="{{ $doc->id }}">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="small fw-semibold mb-1">Status Dokumen</label>
                                            <select class="form-select form-select-sm doc-status"
                                                data-id="{{ $doc->id }}">
                                                <option value="-" {{ $doc->status == '-' ? 'selected' : '' }}>-</option>
                                                <option value="Nok" {{ $doc->status == 'Nok' ? 'selected' : '' }}>🔴 NOK</option>
                                                <option value="Closed" {{ $doc->status == 'Closed' ? 'selected' : '' }}>🟢 OK</option>
                                            </select>

                                            <div class="closed-extra mt-2 transition {{ $doc->status == 'Closed' ? '' : 'd-none' }}">
                                                <div class="alert alert-success py-2 px-3 small mb-2">
                                                    ✅ Dokumen Closed
                                                </div>
                                                <input type="date"
                                                    class="form-control form-control-sm mb-2 doc-closed-date"
                                                    value="{{ $doc->tanggal_closed }}">
                                                <textarea class="form-control form-control-sm doc-closed-note" placeholder="Keterangan Closed">{{ $doc->keterangan_closed }}</textarea>
                                            </div>

                                            <div class="mt-3 d-flex gap-2">
                                                <button class="btn btn-success btn-sm px-3 btn-update-doc"
                                                    data-id="{{ $doc->id }}"
                                                    data-url="{{ route('monitoring.document.update', $doc->id) }}">
                                                    💾 Simpan
                                                </button>
                                                <button class="btn btn-outline-danger btn-sm px-3 btn-delete-doc"
                                                    data-id="{{ $doc->id }}"
                                                    data-url="{{ route('monitoring.document.destroy', $doc->id) }}">
                                                    🗑️ Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- MODAL EDIT MONITORING -->
            <div class="modal fade" id="modalEdit{{ $m->id }}">
                <div class="modal-dialog modal-lg">
                    <form class="modal-content" action="{{ route('monitoring.update', $m->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header bg-danger text-white">
                            <h5>Edit Monitoring</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label>PO / Nota Dinas *</label>
                                    <input type="text" name="po_nota_dinas" value="{{ $m->po_nota_dinas }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Nama Pekerjaan *</label>
                                    <input type="text" name="nama_pekerjaan" value="{{ $m->nama_pekerjaan }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Jenis Pekerjaan *</label>
                                    <input type="text" name="jenis_pekerjaan" value="{{ $m->jenis_pekerjaan }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label>Tanggal Kontrak *</label>
                                    <input type="date" name="tanggal_kontrak" value="{{ $m->tanggal_kontrak }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label>Tanggal Selesai *</label>
                                    <input type="date" name="tanggal_selesai_kontrak"
                                        value="{{ $m->tanggal_selesai_kontrak }}" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label>Status *</label>
                                    <select name="status" class="form-control">
                                        <option value="Open" {{ $m->status == 'Open' ? 'selected' : '' }}>Open</option>
                                        <option value="Closed" {{ $m->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                                        <option value="On Hold" {{ $m->status == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label>Keterangan</label>
                                    <textarea name="keterangan" class="form-control">{{ $m->keterangan }}</textarea>
                                </div>

                                <div class="col-12 mt-3">
                                    <label>Tambah Dokumen Baru</label>
                                    <div id="dokumenContainerEdit{{ $m->id }}">
                                        <div class="d-flex gap-2 mb-2">
                                            <input type="text" name="nama_dokumen[]" class="form-control"
                                                placeholder="Nama Dokumen">
                                            <input type="file" name="file_dokumen[]" class="form-control">
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-success btn-sm"
                                        onclick="addDokumenEdit({{ $m->id }})">+ Tambah Dokumen</button>
                                </div>
                            </div>

                            <div class="col-md-8 mt-3">
                                <label>Keterangan Progress</label>
                                <textarea name="keterangan2" class="form-control" placeholder="Catatan perkembangan pekerjaan...">{{ $m->keterangan2 }}</textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success">Simpan</button>
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- MODAL BUAT MEMO -->
            <div class="modal fade" id="modalCreateMemo{{ $m->id }}" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <form class="modal-content" action="{{ route('memo.store', $m->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">📝 Buat Memo Baru - PO {{ $m->po_nota_dinas }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body" style="background: #f8f9fa;">
                            <div class="card p-3 mb-3 border-0 shadow-sm">
                                <h6 class="fw-bold text-primary mb-3">Header Memo</h6>
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold">Tanggal</label>
                                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}"
                                            class="form-control form-control-sm" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold">Nomor Memo</label>
                                        <input type="text" name="nomor_memo" class="form-control form-control-sm"
                                            placeholder="010/M/340/2026" required>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label small fw-bold">Hal / Perihal</label>
                                        <input type="text" name="hal" class="form-control form-control-sm"
                                            placeholder="Pengajuan Sewa Transportasi KRL..." required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Dari</label>
                                        <input type="text" name="dari" value="Kepala Divisi Wilayah II"
                                            class="form-control form-control-sm" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Kepada Yth.</label>
                                        <input type="text" name="kepada" value="Kepala Divisi Logistik"
                                            class="form-control form-control-sm" required>
                                    </div>
                                </div>
                            </div>

                            <div class="card p-3 mb-3 border-0 shadow-sm">
                                <h6 class="fw-bold text-primary mb-3">Isi Suratan / Paragraf</h6>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">1. Paragraf Pembuka / Dasar Surat</label>
                                    <textarea name="pembuka" class="form-control form-control-sm" rows="3"
                                        placeholder="Berdasarkan :&#10;a. Kontrak Nomor {{ $m->po_nota_dinas }}...&#10;b. Surat PT INKA..."></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">2. Paragraf Utama</label>
                                    <textarea name="isi_utama" class="form-control form-control-sm" rows="2"
                                        placeholder="Sehubungan dengan point 1 di atas dapat kami sampaikan..."></textarea>
                                </div>
                            </div>

                            <div class="card p-3 mb-3 border-0 shadow-sm">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input toggle-table-switch" type="checkbox" name="has_table"
                                        value="1" id="switchTable{{ $m->id }}"
                                        data-target="#tableSection{{ $m->id }}" checked>
                                    <label class="form-check-label fw-bold text-primary"
                                        for="switchTable{{ $m->id }}">Sertakan Tabel Rincian Barang / Jasa</label>
                                </div>

                                <div id="tableSection{{ $m->id }}">
                                    <table class="table table-bordered table-sm mt-2 align-middle"
                                        id="tableItem{{ $m->id }}">
                                        <thead class="table-light">
                                            <tr class="text-center small">
                                                <th width="20%">Uraian Barang</th>
                                                <th width="35%">Spesifikasi</th>
                                                <th width="10%">Qty</th>
                                                <th width="10%">Sat</th>
                                                <th width="20%">Ket</th>
                                                <th width="5%">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="text" name="uraian_barang[]"
                                                        class="form-control form-control-sm" placeholder="Jasa Tenaga">
                                                </td>
                                                <td>
                                                    <textarea name="spesifikasi[]" class="form-control form-control-sm" rows="1"></textarea>
                                                </td>
                                                <td><input type="text" name="qty[]"
                                                        class="form-control form-control-sm text-center"></td>
                                                <td><input type="text" name="satuan[]"
                                                        class="form-control form-control-sm text-center"></td>
                                                <td><input type="text" name="keterangan_item[]"
                                                        class="form-control form-control-sm"></td>
                                                <td><button type="button"
                                                        class="btn btn-sm btn-danger btn-remove-row">×</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-sm btn-outline-success btn-add-row"
                                        data-target="#tableItem{{ $m->id }}">+ Tambah Baris Tabel</button>
                                </div>
                            </div>

                            <div class="card p-3 mb-3 border-0 shadow-sm">
                                <h6 class="fw-bold text-primary mb-3">Catatan, Penutup & Tanda Tangan</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Note / Catatan Khusus (Opsional)</label>
                                        <textarea name="catatan_note" class="form-control form-control-sm" rows="2"
                                            placeholder="Note: Mohon segera ditindaklanjuti..."></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">3. Paragraf Penutup</label>
                                        <textarea name="penutup" class="form-control form-control-sm" rows="2"
                                            placeholder="Demikian memo pengajuan ini kami sampaikan..."></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold">Jabatan Penandatangan</label>
                                        <input type="text" name="jabatan_penandatangan"
                                            value="Kepala Divisi Wilayah II" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold">Nama Penandatangan</label>
                                        <input type="text" name="nama_penandatangan" value="SUGIYATNO"
                                            class="form-control form-control-sm" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold">Upload Tanda Tangan (PNG/JPG)</label>
                                        <input type="file" name="ttd_image" class="form-control form-control-sm"
                                            accept="image/png, image/jpeg, image/jpg">
                                    </div>
                                </div>
                            </div>

                            <div class="card p-3 mb-3 border-0 shadow-sm">
                                <h6 class="fw-bold text-primary mb-3">Lampiran Dokumen / Gambar (Opsional)</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Judul / Keterangan Lampiran</label>
                                        <input type="text" name="judul_lampiran" class="form-control form-control-sm"
                                            placeholder="Contoh: Lampiran Foto Kondisi Lapangan">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Upload File Lampiran (Gambar/PDF)</label>
                                        <input type="file" name="file_lampiran" class="form-control form-control-sm"
                                            accept="image/*,application/pdf">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">💾 Generate Memo & Simpan Ke PO</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <!-- MODAL TAMBAH MONITORING -->
    <div class="modal fade" id="modalCreateMonitoring">
        <div class="modal-dialog modal-lg">
            <form class="modal-content" action="{{ route('monitoring.store', $proyek->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5>Buat Monitoring Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>PO / Nota Dinas *</label>
                            <input type="text" name="po_nota_dinas" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Nama Pekerjaan *</label>
                            <input type="text" name="nama_pekerjaan" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Jenis Pekerjaan *</label>
                            <input type="text" name="jenis_pekerjaan" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label>Tanggal Kontrak *</label>
                            <input type="date" name="tanggal_kontrak" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label>Tanggal Selesai *</label>
                            <input type="date" name="tanggal_selesai_kontrak" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label>Status *</label>
                            <select name="status" class="form-control" required>
                                <option value="Open">Open</option>
                                <option value="Closed">Closed</option>
                                <option value="On Hold">On Hold</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control"></textarea>
                        </div>

                        <div class="col-12 mt-3">
                            <label>Upload Dokumen</label>
                            <div id="dokumenContainer">
                                <div class="d-flex gap-2 mb-2">
                                    <input type="text" name="nama_dokumen[]" class="form-control"
                                        placeholder="Nama Dokumen">
                                    <input type="file" name="file_dokumen[]" class="form-control">
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="addDokumen">
                                + Tambah Dokumen
                            </button>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    {{-- JS JS SCRIPT --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // === TOGGLE FILTER ===
            $('#toggleFilterBtn').on('click', function() {
                $('#filterSection').toggleClass('d-none');
            });

            // === TOGGLE LIHAT DOKUMEN ===
            $(document).on('click', '.toggle-docs-btn', function() {
                let list = $(this).closest('.document-section').find('.document-list');
                list.slideToggle(300);
            });

            // === TAMPILKAN INPUT EXTRA JIKA STATUS = CLOSED ===
            $(document).on('change', '.doc-status', function() {
                let container = $(this).closest('.row');
                let value = $(this).val();
                let extraDiv = container.find('.closed-extra');
                
                if (value === 'Closed') {
                    extraDiv.removeClass('d-none');
                } else {
                    extraDiv.addClass('d-none');
                }
            });

            // === UPDATE DOKUMEN (AJAX) ===
            $(document).on('click', '.btn-update-doc', function() {
                let button = $(this);
                let id = button.data('id');
                let url = button.data('url');
                let token = '{{ csrf_token() }}';

                let container = $('#doc-' + id);
                let nama_dokumen = container.find('.doc-name').val();
                let status = container.find('.doc-status').val();
                let tanggal_closed = container.find('.doc-closed-date').val();
                let keterangan_closed = container.find('.doc-closed-note').val();
                let file_dokumen = container.find('.doc-file')[0].files[0];

                let formData = new FormData();
                formData.append('_token', token);
                formData.append('nama_dokumen', nama_dokumen);
                formData.append('status', status);
                formData.append('tanggal_closed', tanggal_closed ? tanggal_closed : '');
                formData.append('keterangan_closed', keterangan_closed ? keterangan_closed : '');

                if (file_dokumen) {
                    formData.append('file_dokumen', file_dokumen);
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            alert('✅ ' + response.message);
                            if (response.file_url) {
                                let link = $('#file-link-' + id);
                                link.attr('href', response.file_url);
                            }
                        } else {
                            alert('❌ Gagal memperbarui dokumen.');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Terjadi kesalahan saat memperbarui dokumen.');
                    }
                });
            });

            // === DELETE DOKUMEN (AJAX) ===
            $(document).on('click', '.btn-delete-doc', function() {
                if (!confirm('Yakin ingin menghapus dokumen ini?')) return;

                let button = $(this);
                let id = button.data('id');
                let url = button.data('url');
                let token = '{{ csrf_token() }}';

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: token
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#doc-' + id).remove();
                            alert('✅ ' + response.message);
                        } else {
                            alert('❌ Gagal menghapus dokumen.');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Terjadi kesalahan saat menghapus dokumen.');
                    }
                });
            });

            // === DYNAMIC INPUT DOKUMEN BARU ===
            $('#addDokumen').on('click', function() {
                let html = `
                    <div class="d-flex gap-2 mb-2">
                        <input type="text" name="nama_dokumen[]" class="form-control" placeholder="Nama Dokumen">
                        <input type="file" name="file_dokumen[]" class="form-control">
                    </div>`;
                $('#dokumenContainer').append(html);
            });
        });

        function addDokumenEdit(id) {
            let html = `
                <div class="d-flex gap-2 mb-2">
                    <input type="text" name="nama_dokumen[]" class="form-control" placeholder="Nama Dokumen">
                    <input type="file" name="file_dokumen[]" class="form-control">
                </div>`;
            $('#dokumenContainerEdit' + id).append(html);
        }
    </script>
@endsection