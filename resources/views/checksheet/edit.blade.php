@extends('layouts.main')

@section('content')
    <style>
        body {
            background: #f4f6f9;
        }

        .page-title {
            font-weight: bold;
            color: #b30000;
        }

        .main-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .section-card {
            border: none;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            transition: 0.2s;
        }

        .section-card:hover {
            transform: translateY(-2px);
        }

        .btn-add {
            border-radius: 10px;
            font-weight: 600;
        }

        .item-row {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .btn-remove {
            border-radius: 10px;
        }

        .save-btn {
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: bold;
            font-size: 16px;
        }

        @media(max-width:768px) {
            .section-header {
                flex-direction: column;
            }
        }
    </style>

    <div class="container mt-4 mb-5">

        <h3 class="page-title mb-4">
            ✏️ Edit Checksheet
        </h3>

        <form action="{{ route('checksheet.update', $checksheet->id) }}" method="POST">

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
                        <label class="fw-bold">Unit</label>

                        <input type="text" name="unit" class="form-control" value="{{ $checksheet->unit }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">No Lambung</label>

                        <input type="text" name="no_lambung" class="form-control" value="{{ $checksheet->no_lambung }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Tanggal</label>

                        <input type="date" name="tanggal" class="form-control" value="{{ $checksheet->tanggal }}">
                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="fw-bold">
                            Jenis Perawatan
                        </label>

                        <input type="text" name="jenis_perawatan" class="form-control"
                            value="{{ $checksheet->jenis_perawatan }}" placeholder="Contoh: Harian / Mingguan / Bulanan">

                    </div>

                </div>

            </div>

            {{-- SECTION --}}
            <div id="sections">

                @foreach ($checksheet->sections as $sIndex => $section)
                    <div class="card section-card p-3 mb-4">

                        {{-- SUB JUDUL --}}
                        <div class="row mb-3">

                            <div class="col-md-2">
                                <input type="text" name="sections[{{ $sIndex }}][kode]" class="form-control"
                                    value="{{ $section->kode }}" placeholder="I / II">
                            </div>

                            <div class="col-md-9">
                                <input type="text" name="sections[{{ $sIndex }}][nama]" class="form-control"
                                    value="{{ $section->nama_section }}" placeholder="Sub Judul" required>
                            </div>

                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger w-100" onclick="removeSection(this)">
                                    ✖
                                </button>
                            </div>

                        </div>

                        {{-- ITEMS --}}
                        <div id="items-{{ $sIndex }}">

                            @foreach ($section->items as $iIndex => $item)
                                <div class="item-row border rounded p-3 mb-3">

                                    {{-- ITEM --}}
                                    <div class="row mb-3">

                                        <div class="col-md-2">
                                            <input type="text"
                                                name="sections[{{ $sIndex }}][items][{{ $iIndex }}][nomor]"
                                                class="form-control" value="{{ $item->nomor }}" placeholder="a / b">
                                        </div>

                                        <div class="col-md-9">
                                            <input type="text"
                                                name="sections[{{ $sIndex }}][items][{{ $iIndex }}][uraian]"
                                                class="form-control" value="{{ $item->uraian }}"
                                                placeholder="Uraian Pekerjaan" required>
                                        </div>

                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger w-100" onclick="removeItem(this)">
                                                ✖
                                            </button>
                                        </div>

                                    </div>

                                    {{-- DETAIL --}}
                                    <div id="details-{{ $sIndex }}-{{ $iIndex }}">

                                        @foreach ($item->details as $dIndex => $detail)
                                            <div class="row mb-2 detail-row">

                                                <div class="col-md-5">
                                                    <input type="hidden"
        name="sections[{{ $sIndex }}][items][{{ $iIndex }}][details][{{ $dIndex }}][id]"
        value="{{ $detail->id }}">

                                                    <input type="text"
                                                        name="sections[{{ $sIndex }}][items][{{ $iIndex }}][details][{{ $dIndex }}][aktivitas]"
                                                        class="form-control" value="{{ $detail->aktivitas }}"
                                                        placeholder="Aktivitas Pekerjaan">

                                                </div>

                                                <div class="col-md-5">

                                                    <input type="text"
                                                        name="sections[{{ $sIndex }}][items][{{ $iIndex }}][details][{{ $dIndex }}][standar]"
                                                        class="form-control" value="{{ $detail->standar }}"
                                                        placeholder="Standar">

                                                </div>

                                                <div class="col-md-2">

                                                    <button type="button" class="btn btn-danger w-100"
                                                        onclick="removeDetail(this)">

                                                        ✖

                                                    </button>

                                                </div>

                                            </div>
                                        @endforeach

                                    </div>

                                    <button type="button" class="btn btn-info btn-sm"
                                        onclick="addDetail({{ $sIndex }}, {{ $iIndex }})">

                                        ➕ Tambah Aktivitas

                                    </button>

                                </div>
                            @endforeach

                        </div>

                        <button type="button" class="btn btn-primary btn-sm" onclick="addItem({{ $sIndex }})">

                            ➕ Tambah Item

                        </button>

                    </div>
                @endforeach

            </div>

            {{-- BUTTON --}}
            <div class="mb-4">

                <button type="button" class="btn btn-primary btn-add" onclick="addSection()">

                    ➕ Tambah Section

                </button>

            </div>

            <button type="submit" class="btn btn-success save-btn">

                💾 Update Checksheet

            </button>

        </form>

    </div>

    <script>
        let sectionIndex = {{ $checksheet->sections->count() }};
        let itemIndexes = {};
        let detailIndexes = {};

        // existing item count
        @foreach ($checksheet->sections as $sIndex => $section)

            itemIndexes[{{ $sIndex }}] = {{ $section->items->count() }};

            @foreach ($section->items as $iIndex => $item)

                detailIndexes["{{ $sIndex }}_{{ $iIndex }}"] =
                    {{ $item->details->count() }};
            @endforeach
        @endforeach

        // =========================
        // ADD SUB JUDUL
        // =========================
        function addSection() {

            itemIndexes[sectionIndex] = 0;

            let html = `
    <div class="card section-card p-3 mb-4">

        <div class="row mb-3">

            <div class="col-md-2">
                <input type="text"
                    name="sections[${sectionIndex}][kode]"
                    class="form-control"
                    placeholder="I / II">
            </div>

            <div class="col-md-9">
                <input type="text"
                    name="sections[${sectionIndex}][nama]"
                    class="form-control"
                    placeholder="Sub Judul"
                    required>
            </div>

            <div class="col-md-1">
                <button type="button"
                    class="btn btn-danger w-100"
                    onclick="removeSection(this)">
                    ✖
                </button>
            </div>

        </div>

        <div id="items-${sectionIndex}"></div>

        <button type="button"
            class="btn btn-primary btn-sm"
            onclick="addItem(${sectionIndex})">

            ➕ Tambah Item

        </button>

    </div>
    `;

            document.getElementById('sections')
                .insertAdjacentHTML('beforeend', html);

            sectionIndex++;
        }

        // =========================
        // REMOVE SECTION
        // =========================
        function removeSection(btn) {
            btn.closest('.section-card').remove();
        }

        // =========================
        // ADD ITEM
        // =========================
        function addItem(sIndex) {

            let iIndex = itemIndexes[sIndex];

            detailIndexes[`${sIndex}_${iIndex}`] = 0;

            let html = `
    <div class="item-row border rounded p-3 mb-3">

        <div class="row mb-3">

            <div class="col-md-2">
                <input type="text"
                    name="sections[${sIndex}][items][${iIndex}][nomor]"
                    class="form-control"
                    placeholder="a / b">
            </div>

            <div class="col-md-9">
                <input type="text"
                    name="sections[${sIndex}][items][${iIndex}][uraian]"
                    class="form-control"
                    placeholder="Uraian Pekerjaan"
                    required>
            </div>

            <div class="col-md-1">
                <button type="button"
                    class="btn btn-danger w-100"
                    onclick="removeItem(this)">
                    ✖
                </button>
            </div>

        </div>

        <div id="details-${sIndex}-${iIndex}"></div>

        <button type="button"
            class="btn btn-info btn-sm"
            onclick="addDetail(${sIndex}, ${iIndex})">

            ➕ Tambah Aktivitas

        </button>

    </div>
    `;

            document.getElementById(`items-${sIndex}`)
                .insertAdjacentHTML('beforeend', html);

            addDetail(sIndex, iIndex);

            itemIndexes[sIndex]++;
        }

        // =========================
        // REMOVE ITEM
        // =========================
        function removeItem(btn) {
            btn.closest('.item-row').remove();
        }

        // =========================
        // ADD DETAIL
        // =========================
        function addDetail(sIndex, iIndex) {

            let key = `${sIndex}_${iIndex}`;

            let dIndex = detailIndexes[key];

            let html = `
    <div class="row mb-2 detail-row">

        <div class="col-md-5">

            <input type="text"
                name="sections[${sIndex}][items][${iIndex}][details][${dIndex}][aktivitas]"
                class="form-control"
                placeholder="Aktivitas Pekerjaan">

        </div>

        <div class="col-md-5">

            <input type="text"
                name="sections[${sIndex}][items][${iIndex}][details][${dIndex}][standar]"
                class="form-control"
                placeholder="Standar">

        </div>

        <div class="col-md-2">

            <button type="button"
                class="btn btn-danger w-100"
                onclick="removeDetail(this)">

                ✖

            </button>

        </div>

    </div>
    `;

            document.getElementById(`details-${sIndex}-${iIndex}`)
                .insertAdjacentHTML('beforeend', html);

            detailIndexes[key]++;
        }

        // =========================
        // REMOVE DETAIL
        // =========================
        function removeDetail(btn) {
            btn.closest('.detail-row').remove();
        }
    </script>
@endsection
