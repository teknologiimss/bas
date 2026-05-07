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

        .section-header {
            display: flex;
            gap: 10px;
            align-items: center;
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
            📋 Buat Checksheet Perawatan
        </h3>

        <form action="{{ route('checksheet.store') }}" method="POST">
            @csrf

            {{-- HEADER --}}
            <div class="card main-card p-4 mb-4">

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Judul</label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Forklift Harian"
                            required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Unit</label>
                        <input type="text" name="unit" class="form-control" placeholder="Contoh: Forklift">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">No Lambung</label>
                        <input type="text" name="no_lambung" class="form-control" placeholder="Contoh: FL-001">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="fw-bold">
                            Jenis Perawatan
                        </label>

                        <input type="text" name="jenis_perawatan" class="form-control"
                            placeholder="Contoh: Harian / Mingguan / Bulanan">

                    </div>

                </div>

            </div>

            {{-- SECTION --}}
            <div id="sections"></div>

            {{-- BUTTON --}}
            <div class="mb-4">

                <button type="button" class="btn btn-primary btn-add" onclick="addSection()">
                    ➕ Tambah Section
                </button>

            </div>

            <button type="submit" class="btn btn-success save-btn">
                💾 Simpan Checksheet
            </button>

        </form>

    </div>

    {{-- <script>

    let sectionIndex = 0;

    let itemIndexes = {};

    // =========================
    // ADD SECTION
    // =========================
    function addSection() {

        itemIndexes[sectionIndex] = 0;

        let html = `
        <div class="card section-card p-3 mb-4">

            <div class="section-header mb-3">

                <input type="text"
                    name="sections[${sectionIndex}][nama]"
                    class="form-control"
                    placeholder="Nama Section (contoh: Sistem Mesin)"
                    required>

                <button type="button"
                    class="btn btn-danger btn-remove"
                    onclick="removeSection(this)">
                    ✖
                </button>

            </div>

            <div id="items-${sectionIndex}"></div>

            <button type="button"
                class="btn btn-info btn-sm mt-2"
                onclick="addItem(${sectionIndex})">
                ➕ Tambah Item
            </button>

        </div>
        `;

        document
            .getElementById('sections')
            .insertAdjacentHTML('beforeend', html);

        sectionIndex++;
    }

    // =========================
    // REMOVE SECTION
    // =========================
    function removeSection(button) {

        button.closest('.section-card').remove();

    }

    // =========================
    // ADD ITEM
    // =========================
    function addItem(sIndex) {

        let iIndex = itemIndexes[sIndex];

        let html = `
        <div class="item-row">

            <div class="row">

                <div class="col-md-4 mb-2">
                    <input type="text"
                        name="sections[${sIndex}][items][${iIndex}][uraian]"
                        class="form-control"
                        placeholder="Uraian"
                        required>
                </div>

                <div class="col-md-3 mb-2">
                    <input type="text"
                        name="sections[${sIndex}][items][${iIndex}][aktivitas]"
                        class="form-control"
                        placeholder="Aktivitas">
                </div>

                <div class="col-md-3 mb-2">
                    <input type="text"
                        name="sections[${sIndex}][items][${iIndex}][standar]"
                        class="form-control"
                        placeholder="Standar">
                </div>

                <div class="col-md-2 mb-2">
                    <button type="button"
                        class="btn btn-danger w-100 btn-remove"
                        onclick="removeItem(this)">
                        🗑️
                    </button>
                </div>

            </div>

        </div>
        `;

        document
            .getElementById(`items-${sIndex}`)
            .insertAdjacentHTML('beforeend', html);

        itemIndexes[sIndex]++;
    }

    // =========================
    // REMOVE ITEM
    // =========================
    function removeItem(button) {

        button.closest('.item-row').remove();

    }

</script> --}}

    <script>
        let sectionIndex = 0;
        let itemIndexes = {};
        let detailIndexes = {};

        // =========================
        // ADD SUB JUDUL
        // =========================
        function addSection() {

            itemIndexes[sectionIndex] = 0;

            let html = `
    <div class="card section-card p-3 mb-4">

        {{-- SUB JUDUL --}}
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

        {{-- ITEMS --}}
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
        // REMOVE SUB JUDUL
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

        {{-- ITEM --}}
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

        {{-- DETAIL --}}
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

            // otomatis tambah 1 detail
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
