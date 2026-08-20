@extends('layouts.main')

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #334155;
        }

        .mobile-container {
            max-width: 680px;
            margin: 0 auto;
            padding-bottom: 100px;
        }

        /* Top Header Card */
        .header-card {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #ffffff;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .badge-info-pill {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            padding: 4px 10px;
            font-size: 0.8rem;
        }

        /* Generic Section Box */
        .card-box {
            background: #ffffff;
            border-radius: 16px;
            padding: 18px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            margin-bottom: 16px;
        }

        .section-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        /* Tab Switcher */
        .fcu-tabs {
            background: #e2e8f0;
            padding: 4px;
            border-radius: 12px;
        }

        .fcu-tabs .nav-link {
            border-radius: 9px;
            color: #64748b;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 8px 16px;
            transition: all 0.2s ease;
        }

        .fcu-tabs .nav-link.active {
            background-color: #ffffff;
            color: #0284c7;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        }

        /* Accordion Styling */
        .accordion-item {
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            overflow: hidden;
            margin-bottom: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .accordion-button {
            background-color: #ffffff;
            font-weight: 600;
            font-size: 0.9rem;
            color: #1e293b;
            padding: 14px 16px;
        }

        .accordion-button:not(.collapsed) {
            background-color: #f8fafc;
            color: #0284c7;
            box-shadow: none;
        }

        /* Inspection Detail Card */
        .detail-card {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 12px;
        }

        /* Radio Toggle Switch */
        .radio-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-top: 10px;
        }

        .radio-group input[type="radio"] {
            display: none;
        }

        .radio-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1.5px solid #cbd5e1;
            background: #ffffff;
            color: #64748b;
        }

        input[value="OK"]:checked+.radio-label {
            background: #10b981;
            border-color: #10b981;
            color: #ffffff;
        }

        input[value="NOK"]:checked+.radio-label {
            background: #ef4444;
            border-color: #ef4444;
            color: #ffffff;
        }

        /* Image Preview Wrapper */
        .photo-thumb {
            width: 56px;
            height: 56px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #cbd5e1;
        }

        .delete-photo-btn {
            position: absolute;
            top: -6px;
            right: -6px;
            width: 20px;
            height: 20px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            text-decoration: none;
        }

        /* Sticky Action Bar */
        .sticky-action-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border-top: 1px solid #e2e8f0;
            padding: 12px 16px;
            z-index: 1000;
        }

        .btn-submit-main {
            max-width: 400px;
            width: 100%;
            height: 46px;
            border-radius: 12px;
            background: #0284c7;
            border: none;
            font-weight: 600;
            font-size: 0.95rem;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);
        }
    </style>

    <div class="mobile-container py-3 px-2">
        {{-- Header FCU --}}
        <div class="header-card mb-3">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="badge bg-primary bg-opacity-25 text-white mb-2 px-2 py-1"
                        style="font-size: 0.75rem;">Checksheet FCU</span>
                    <h5 class="fw-bold mb-0 text-white">{{ $fcu->judul }}</h5>
                </div>
                <a href="{{ route('fcu.index') }}"
                    class="btn btn-sm btn-outline-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                    style="width: 32px; height: 32px;">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <div class="badge-info-pill"><i class="fa fa-hashtag text-info me-1"></i> FCU 1: <b>{{ $fcu->no_fcu }}</b>
                </div>
                @if ($fcu->no_fcu_2)
                    <div class="badge-info-pill"><i class="fa fa-hashtag text-info me-1"></i> FCU 2:
                        <b>{{ $fcu->no_fcu_2 }}</b></div>
                @endif
                <div class="badge-info-pill"><i class="fa fa-sliders text-warning me-1"></i> {{ $fcu->jenis_perawatan }}
                </div>
                <div class="badge-info-pill"><i class="fa fa-calendar text-success me-1"></i>
                    {{ \Carbon\Carbon::parse($fcu->tanggal)->format('d/m/Y') }}</div>
            </div>
        </div>

        {{-- Form Unscheduled Info --}}
        @if ($fcu->jenis_perawatan === 'Unscheduled' && $fcu->unscheduledForm)
            <div class="card-box border-danger border-opacity-50 bg-danger bg-opacity-10">
                <div class="section-title text-danger">
                    <i class="fa fa-triangle-exclamation"></i> Detail Unscheduled
                </div>
                <div class="small mb-1"><b>Personil:</b> {{ $fcu->unscheduledForm->personil }} &bull; <b>Status:</b>
                    {{ $fcu->unscheduledForm->status }}</div>
                <div class="small mb-1"><b>Kerusakan:</b> {{ $fcu->unscheduledForm->jenis_kerusakan }}</div>
                <div class="small"><b>Tindak Lanjut:</b> {{ $fcu->unscheduledForm->tindak_lanjut }}</div>
            </div>
        @endif

        {{-- Kesimpulan Pemeriksaan --}}
        <div class="card-box">
            <div class="section-title">
                <i class="fa fa-clipboard-check text-primary"></i> Kesimpulan Pemeriksaan
            </div>
            <form action="{{ route('fcu.hasil', $fcu->id) }}" method="POST">
                @csrf
                <div class="input-group">
                    <select class="form-select form-select-sm" name="hasil">
                        <option value="">-- Pilih Kesimpulan --</option>
                        <option value="SO" {{ $fcu->kesimpulan == 'SO' ? 'selected' : '' }}>SO</option>
                        <option value="SO DENGAN CATATAN" {{ $fcu->kesimpulan == 'SO DENGAN CATATAN' ? 'selected' : '' }}>
                            SO DENGAN CATATAN</option>
                        <option value="TSO" {{ $fcu->kesimpulan == 'TSO' ? 'selected' : '' }}>TSO</option>
                    </select>
                    <button class="btn btn-sm btn-primary px-3" type="submit"><i class="fa fa-save me-1"></i>
                        Simpan</button>
                </div>
            </form>
        </div>

        {{-- Catatan Tambahan --}}
        <div class="card-box">
            <div class="section-title">
                <i class="fa fa-note-sticky text-warning"></i> Catatan Tambahan
            </div>
            <form action="{{ route('fcu.note', $fcu->id) }}" method="POST" class="mb-2">
                @csrf
                <div class="input-group">
                    <textarea class="form-control form-control-sm" name="catatan" rows="2" placeholder="Tulis catatan di sini..."></textarea>
                    <button class="btn btn-sm btn-outline-primary px-3" type="submit"><i class="fa fa-plus"></i></button>
                </div>
            </form>
            @foreach ($fcu->notes as $note)
                <div class="p-2 bg-light rounded-3 mt-2 d-flex justify-content-between align-items-center border">
                    <div class="small text-secondary">{{ $note->catatan }}</div>
                    <form action="{{ route('fcu.note.delete', $note->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-link text-danger p-0 ms-2"><i class="fa fa-trash"></i></button>
                    </form>
                </div>
            @endforeach
        </div>

        {{-- Form Checksheet Utama --}}
        <form method="POST" action="{{ route('fcu.mobile.save') }}" enctype="multipart/form-data">
            @csrf

            @if ($fcu->no_fcu_2)
                <ul class="nav nav-pills nav-justified fcu-tabs mb-3" id="fcuTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="fcu1-tab" data-bs-toggle="pill" data-bs-target="#fcu1"
                            type="button" role="tab">
                            <i class="fa fa-snowflake me-1"></i> {{ $fcu->no_fcu }} (FCU 1)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="fcu2-tab" data-bs-toggle="pill" data-bs-target="#fcu2" type="button"
                            role="tab">
                            <i class="fa fa-snowflake me-1"></i> {{ $fcu->no_fcu_2 }} (FCU 2)
                        </button>
                    </li>
                </ul>
            @endif

            <div class="tab-content" id="fcuTabContent">
                {{-- TAB FCU 1 --}}
                <div class="tab-pane fade show active" id="fcu1" role="tabpanel">
                    <div class="accordion" id="accordionFCU1">
                        @foreach ($fcu->sections as $section)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#sec1_{{ $section->id }}">
                                        {{ $section->kode }} {{ $section->nama_section }}
                                    </button>
                                </h2>
                                <div id="sec1_{{ $section->id }}" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionFCU1">
                                    <div class="accordion-body bg-white p-3">
                                        @foreach ($section->items as $item)
                                            <div class="fw-bold text-dark mb-2" style="font-size: 0.875rem;">
                                                {{ $item->nomor }}. {{ $item->uraian }}
                                            </div>

                                            @foreach ($item->details as $detail)
                                                @php
                                                    $res1 = $detail->results
                                                        ? $detail->results->where('unit', 'fcu1')->first()
                                                        : $detail->result;
                                                @endphp
                                                <div class="detail-card">
                                                    <div class="mb-2">
                                                        <span class="text-muted d-block"
                                                            style="font-size: 0.75rem;">Aktivitas Pekerjaan:</span>
                                                        <span class="fw-semibold text-dark"
                                                            style="font-size: 0.85rem;">{{ $detail->aktivitas }}</span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <span class="text-muted d-block"
                                                            style="font-size: 0.75rem;">Standar Acuan:</span>
                                                        <span class="text-secondary"
                                                            style="font-size: 0.825rem;">{{ $detail->standar }}</span>
                                                    </div>

                                                    {{-- Radio Switch OK / NOK --}}
                                                    <div class="radio-group">
                                                        <div>
                                                            <input type="radio" id="fcu1_ok_{{ $detail->id }}"
                                                                name="details[fcu1][{{ $detail->id }}][status]"
                                                                value="OK"
                                                                {{ optional($res1)->status == 'OK' ? 'checked' : '' }}>
                                                            <label for="fcu1_ok_{{ $detail->id }}" class="radio-label">
                                                                <i class="fa fa-circle-check"></i> OK
                                                            </label>
                                                        </div>
                                                        <div>
                                                            <input type="radio" id="fcu1_nok_{{ $detail->id }}"
                                                                name="details[fcu1][{{ $detail->id }}][status]"
                                                                value="NOK"
                                                                {{ optional($res1)->status == 'NOK' ? 'checked' : '' }}>
                                                            <label for="fcu1_nok_{{ $detail->id }}"
                                                                class="radio-label">
                                                                <i class="fa fa-circle-xmark"></i> NOK
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <textarea name="details[fcu1][{{ $detail->id }}][keterangan]" class="form-control form-control-sm mt-3"
                                                        rows="2" placeholder="Tambahkan keterangan jika perlu...">{{ optional($res1)->keterangan }}</textarea>

                                                    <div class="mt-2">
                                                        <label class="form-label mb-1 text-muted"
                                                            style="font-size: 0.75rem;"><i class="fa fa-camera me-1"></i>
                                                            Upload Foto FCU 1</label>
                                                        <input type="file"
                                                            name="details[fcu1][{{ $detail->id }}][photos][]"
                                                            class="form-control form-control-sm" accept="image/*"
                                                            multiple>
                                                    </div>

                                                    @if ($res1 && $res1->photos->count())
                                                        <div class="d-flex gap-2 mt-3 flex-wrap">
                                                            @foreach ($res1->photos as $photo)
                                                                <div class="position-relative">
                                                                    <img src="{{ asset('uploads/fcu/' . $photo->foto) }}"
                                                                        class="photo-thumb">
                                                                    <a href="{{ route('fcu.photo.delete', $photo->id) }}"
                                                                        class="delete-photo-btn">&times;</a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- TAB FCU 2 --}}
                @if ($fcu->no_fcu_2)
                    <div class="tab-pane fade" id="fcu2" role="tabpanel">
                        <div class="accordion" id="accordionFCU2">
                            @foreach ($fcu->sections as $section)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#sec2_{{ $section->id }}">
                                            {{ $section->kode }} {{ $section->nama_section }}
                                        </button>
                                    </h2>
                                    <div id="sec2_{{ $section->id }}" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionFCU2">
                                        <div class="accordion-body bg-white p-3">
                                            @foreach ($section->items as $item)
                                                <div class="fw-bold text-dark mb-2" style="font-size: 0.875rem;">
                                                    {{ $item->nomor }}. {{ $item->uraian }}
                                                </div>

                                                @foreach ($item->details as $detail)
                                                    @php
                                                        $res2 = $detail->results
                                                            ? $detail->results->where('unit', 'fcu2')->first()
                                                            : null;
                                                    @endphp
                                                    <div class="detail-card">
                                                        <div class="mb-2">
                                                            <span class="text-muted d-block"
                                                                style="font-size: 0.75rem;">Aktivitas Pekerjaan:</span>
                                                            <span class="fw-semibold text-dark"
                                                                style="font-size: 0.85rem;">{{ $detail->aktivitas }}</span>
                                                        </div>
                                                        <div class="mb-3">
                                                            <span class="text-muted d-block"
                                                                style="font-size: 0.75rem;">Standar Acuan:</span>
                                                            <span class="text-secondary"
                                                                style="font-size: 0.825rem;">{{ $detail->standar }}</span>
                                                        </div>

                                                        {{-- Radio Switch OK / NOK --}}
                                                        <div class="radio-group">
                                                            <div>
                                                                <input type="radio" id="fcu2_ok_{{ $detail->id }}"
                                                                    name="details[fcu2][{{ $detail->id }}][status]"
                                                                    value="OK"
                                                                    {{ optional($res2)->status == 'OK' ? 'checked' : '' }}>
                                                                <label for="fcu2_ok_{{ $detail->id }}"
                                                                    class="radio-label">
                                                                    <i class="fa fa-circle-check"></i> OK
                                                                </label>
                                                            </div>
                                                            <div>
                                                                <input type="radio" id="fcu2_nok_{{ $detail->id }}"
                                                                    name="details[fcu2][{{ $detail->id }}][status]"
                                                                    value="NOK"
                                                                    {{ optional($res2)->status == 'NOK' ? 'checked' : '' }}>
                                                                <label for="fcu2_nok_{{ $detail->id }}"
                                                                    class="radio-label">
                                                                    <i class="fa fa-circle-xmark"></i> NOK
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <textarea name="details[fcu2][{{ $detail->id }}][keterangan]" class="form-control form-control-sm mt-3"
                                                            rows="2" placeholder="Tambahkan keterangan jika perlu...">{{ optional($res2)->keterangan }}</textarea>

                                                        <div class="mt-2">
                                                            <label class="form-label mb-1 text-muted"
                                                                style="font-size: 0.75rem;"><i
                                                                    class="fa fa-camera me-1"></i> Upload Foto FCU
                                                                2</label>
                                                            <input type="file"
                                                                name="details[fcu2][{{ $detail->id }}][photos][]"
                                                                class="form-control form-control-sm" accept="image/*"
                                                                multiple>
                                                        </div>

                                                        @if ($res2 && $res2->photos->count())
                                                            <div class="d-flex gap-2 mt-3 flex-wrap">
                                                                @foreach ($res2->photos as $photo)
                                                                    <div class="position-relative">
                                                                        <img src="{{ asset('uploads/fcu/' . $photo->foto) }}"
                                                                            class="photo-thumb">
                                                                        <a href="{{ route('fcu.photo.delete', $photo->id) }}"
                                                                            class="delete-photo-btn">&times;</a>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sticky Save Button --}}
            <div class="sticky-action-bar text-center">
                <button type="submit" class="btn btn-primary btn-submit-main">
                    <i class="fa fa-floppy-disk me-2"></i> Simpan Checksheet
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
