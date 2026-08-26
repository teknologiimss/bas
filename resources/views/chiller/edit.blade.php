@extends('layouts.main')

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .container {
            max-width: 1100px;
        }

        .page-title {
            font-weight: 700;
            color: #b30000;
            font-size: 28px;
        }

        .main-card {
            border: none;
            border-radius: 22px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .06);
            background: white;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            min-height: 44px;
            border: 1px solid #dbe2ea;
            font-size: 14px;
        }

        textarea.form-control {
            min-height: 80px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #b30000;
        }

        label {
            font-size: 14px;
            margin-bottom: 6px;
        }

        .item-row {
            background: #f8fafc;
            border-radius: 16px;
            padding: 14px;
            margin-bottom: 14px;
            border: 1px solid #edf1f5;
        }

        .detail-row {
            background: white;
            border-radius: 12px;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #edf1f5;
        }

        .btn {
            border-radius: 12px;
            font-weight: 600;
        }

        .save-btn {
            border-radius: 14px;
            padding: 13px 28px;
            font-weight: 700;
            font-size: 15px;
            min-width: 230px;
            box-shadow: 0 4px 14px rgba(25, 135, 84, .2);
        }
    </style>

    <div class="container mt-4 mb-5">
        <h3 class="page-title mb-4">✏️ Edit Checksheet Chiller</h3>

        <form action="{{ route('chiller.update', $checksheet->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- HEADER --}}
            <div class="card main-card p-4 mb-4">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Judul</label>
                        <input type="text" name="judul" class="form-control" value="{{ $checksheet->judul }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Jenis Perawatan</label>
                        <select name="jenis_perawatan" id="jenis_perawatan" class="form-select" onchange="toggleFormType()"
                            required>
                            <option value="" disabled>-- Pilih Jenis Perawatan --</option>
                            <option value="P1" {{ $checksheet->jenis_perawatan == 'P1' ? 'selected' : '' }}>P1</option>
                            <option value="P3" {{ $checksheet->jenis_perawatan == 'P3' ? 'selected' : '' }}>P3</option>
                            <option value="P6" {{ $checksheet->jenis_perawatan == 'P6' ? 'selected' : '' }}>P6</option>
                            <option value="P12" {{ $checksheet->jenis_perawatan == 'P12' ? 'selected' : '' }}>P12
                            </option>
                            <option value="Unscheduled"
                                {{ $checksheet->jenis_perawatan == 'Unscheduled' ? 'selected' : '' }}>Unscheduled</option>
                        </select>
                    </div>

                    {{-- Form Field Khusus Unscheduled --}}
                    <div class="col-md-4 mb-3 unscheduled-field"
                        style="display: {{ $checksheet->jenis_perawatan == 'Unscheduled' ? 'block' : 'none' }};">
                        <label class="fw-bold">No. Form Unscheduled Chiller</label>
                        <input type="text" name="no_form_unscheduled" class="form-control"
                            value="{{ $checksheet->no_form_unscheduled }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">No Chiller</label>
                        <input type="text" name="no_chiller" class="form-control" value="{{ $checksheet->no_chiller }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">No Aset</label>
                        <input type="text" name="no_aset" class="form-control" value="{{ $checksheet->no_aset }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" value="{{ $checksheet->lokasi }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal_pelaksanaan" class="form-control"
                            value="{{ $checksheet->tanggal_pelaksanaan }}">
                    </div>

                    {{-- Field Khusus Scheduled --}}
                    <div class="col-md-4 mb-3 scheduled-field"
                        style="display: {{ $checksheet->jenis_perawatan != 'Unscheduled' ? 'block' : 'none' }};">
                        <label class="fw-bold">Durasi Pekerjaan</label>
                        <input type="text" name="durasi_pekerjaan" class="form-control"
                            value="{{ $checksheet->durasi_pekerjaan }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Personil</label>
                        <input type="text" name="personil" class="form-control" value="{{ $checksheet->personil }}">
                    </div>

                    {{-- Field Khusus Unscheduled Status --}}
                    <div class="col-md-4 mb-3 unscheduled-field"
                        style="display: {{ $checksheet->jenis_perawatan == 'Unscheduled' ? 'block' : 'none' }};">
                        <label class="fw-bold">Status OK / NOK</label>
                        <select name="status_kondisi" class="form-select">
                            <option value="" disabled>-- Pilih Status --</option>
                            <option value="OK" {{ $checksheet->status_kondisi == 'OK' ? 'selected' : '' }}>OK</option>
                            <option value="NOK" {{ $checksheet->status_kondisi == 'NOK' ? 'selected' : '' }}>NOK
                            </option>
                        </select>
                    </div>

                    {{-- Field Khusus Unscheduled Kerusakan & Tindak Lanjut --}}
                    <div class="col-md-6 mb-3 unscheduled-field"
                        style="display: {{ $checksheet->jenis_perawatan == 'Unscheduled' ? 'block' : 'none' }};">
                        <label class="fw-bold">Jenis Kerusakan</label>
                        <textarea name="jenis_kerusakan" class="form-control" rows="3">{{ $checksheet->jenis_kerusakan }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3 unscheduled-field"
                        style="display: {{ $checksheet->jenis_perawatan == 'Unscheduled' ? 'block' : 'none' }};">
                        <label class="fw-bold">Tindak Lanjut</label>
                        <textarea name="tindak_lanjut" class="form-control" rows="3">{{ $checksheet->tindak_lanjut }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ITEMS --}}
            <div id="scheduled-container" class="scheduled-field"
                style="display: {{ $checksheet->jenis_perawatan != 'Unscheduled' ? 'block' : 'none' }};">
                <div id="items-container">
                    @php
                        $groupedItems = $checksheet->items->groupBy('uraian_pekerjaan');
                    @endphp

                    @foreach ($groupedItems as $uraian => $items)
                        @php $iIndex = $loop->index; @endphp
                        <div class="item-row border rounded p-3 mb-3">
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <input type="text" name="items[{{ $iIndex }}][nomor]" class="form-control"
                                        value="{{ $items->first()->nomor }}" placeholder="No (a/b)">
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="items[{{ $iIndex }}][uraian_pekerjaan]"
                                        class="form-control" value="{{ $uraian }}" placeholder="Uraian Pekerjaan">
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger w-100"
                                        onclick="removeItem(this)">✖</button>
                                </div>
                            </div>

                            <div id="details-{{ $iIndex }}">
                                @foreach ($items as $dIndex => $detail)
                                    <div class="row mb-2 detail-row align-items-center">
                                        <input type="hidden"
                                            name="items[{{ $iIndex }}][details][{{ $dIndex }}][id]"
                                            value="{{ $detail->id }}">

                                        <div class="col-md-7">
                                            <input type="text"
                                                name="items[{{ $iIndex }}][details][{{ $dIndex }}][aktivitas_pekerjaan]"
                                                class="form-control" value="{{ $detail->aktivitas_pekerjaan }}"
                                                placeholder="Aktivitas Pekerjaan">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text"
                                                name="items[{{ $iIndex }}][details][{{ $dIndex }}][standar]"
                                                class="form-control" value="{{ $detail->standar }}"
                                                placeholder="Standar">
                                        </div>
                                        <div class="col-md-1 text-center">
                                            <button type="button" class="btn btn-danger w-100"
                                                onclick="removeDetail(this)">✖</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" class="btn btn-info btn-sm text-white mt-2"
                                onclick="addDetail({{ $iIndex }})">
                                ➕ Tambah Aktivitas
                            </button>
                        </div>
                    @endforeach
                </div>

                <div class="mb-4">
                    <button type="button" class="btn btn-primary" onclick="addItem()">
                        ➕ Tambah Uraian Pekerjaan
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-success save-btn">
                💾 Update Checksheet
            </button>
        </form>
    </div>

    <script>
        let itemIndex = {{ count($groupedItems ?? []) }};
        let detailIndexes = {};

        @if (isset($groupedItems))
            @foreach ($groupedItems as $uraian => $items)
                detailIndexes[{{ $loop->index }}] = {{ count($items) }};
            @endforeach
        @endif

        function toggleFormType() {
            let jenis = document.getElementById('jenis_perawatan').value;
            let unscheduledFields = document.querySelectorAll('.unscheduled-field');
            let scheduledFields = document.querySelectorAll('.scheduled-field');

            if (jenis === 'Unscheduled') {
                unscheduledFields.forEach(el => el.style.display = 'block');
                scheduledFields.forEach(el => el.style.display = 'none');
            } else {
                unscheduledFields.forEach(el => el.style.display = 'none');
                scheduledFields.forEach(el => el.style.display = 'block');
            }
        }

        function addItem() {
            let iIndex = itemIndex;
            detailIndexes[iIndex] = 0;

            let html = `
            <div class="item-row border rounded p-3 mb-3">
                <div class="row mb-3">
                    <div class="col-md-2">
                        <input type="text" name="items[${iIndex}][nomor]" class="form-control" placeholder="No (a/b)">
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="items[${iIndex}][uraian_pekerjaan]" class="form-control" placeholder="Uraian Pekerjaan">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger w-100" onclick="removeItem(this)">✖</button>
                    </div>
                </div>

                <div id="details-${iIndex}"></div>

                <button type="button" class="btn btn-info btn-sm text-white mt-2" onclick="addDetail(${iIndex})">
                    ➕ Tambah Aktivitas
                </button>
            </div>`;

            document.getElementById('items-container').insertAdjacentHTML('beforeend', html);
            addDetail(iIndex);
            itemIndex++;
        }

        function removeItem(btn) {
            btn.closest('.item-row').remove();
        }

        function addDetail(iIndex) {
            let dIndex = detailIndexes[iIndex] || 0;

            let html = `
            <div class="row mb-2 detail-row align-items-center">
                <div class="col-md-7">
                    <input type="text" name="items[${iIndex}][details][${dIndex}][aktivitas_pekerjaan]" class="form-control" placeholder="Aktivitas Pekerjaan">
                </div>
                <div class="col-md-4">
                    <input type="text" name="items[${iIndex}][details][${dIndex}][standar]" class="form-control" placeholder="Standar">
                </div>
                <div class="col-md-1 text-center">
                    <button type="button" class="btn btn-danger w-100" onclick="removeDetail(this)">✖</button>
                </div>
            </div>`;

            document.getElementById(`details-${iIndex}`).insertAdjacentHTML('beforeend', html);
            detailIndexes[iIndex] = dIndex + 1;
        }

        function removeDetail(btn) {
            btn.closest('.detail-row').remove();
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleFormType();
        });
    </script>
@endsection
