@extends('layouts.main')

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <style>
        :root {
            --primary: #0f172a;
            --primary-dark: #020617;
            --secondary: #1e3a8a;
            --accent: #2563eb;
            --light: #eff6ff;
            --border: #dbeafe;
            --success: #16a34a;
            --danger: #dc2626;
        }

        body {
            background: #eef4fb;
            font-family: 'Segoe UI', sans-serif;
        }

        /* TITLE */

        .page-title {
            font-size: 30px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 25px;
        }

        /* MAIN CARD */

        .main-card {
            border: none;
            border-radius: 22px;
            background: #fff;
            box-shadow: 0 15px 35px rgba(15, 23, 42, .08);
            animation: fadeUp .4s ease;
        }

        /* SECTION */

        .section-card {
            border: none;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 10px 25px rgba(15, 23, 42, .07);
            transition: .25s;
            border-top: 5px solid var(--secondary);
        }

        .section-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 35px rgba(15, 23, 42, .12);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ITEM */

        .item-row {
            background: #f8fbff;
            border: 1px solid var(--border) !important;
            border-radius: 16px;
            padding: 18px;
            margin-bottom: 15px;
        }

        .detail-row {
            background: #ffffff;
            border: 1px solid #e5eefc;
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 10px;
        }

        /* FORM */

        .form-control {
            border-radius: 12px;
            border: 2px solid var(--border);
            height: 48px;
            transition: .25s;
            box-shadow: none !important;
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 .25rem rgba(37, 99, 235, .15) !important;
        }

        label.fw-bold {
            color: #334155;
            font-weight: 600 !important;
        }

        /* BUTTON */

        .btn {
            border-radius: 12px;
            font-weight: 600;
            transition: .25s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
        }

        .btn-primary:hover {
            background: #1e40af;
        }

        .btn-info {
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            border: none;
            color: #fff;
        }

        .btn-info:hover {
            color: #fff;
            background: #0369a1;
        }

        .btn-success {
            background: linear-gradient(135deg, #16a34a, #15803d);
            border: none;
        }

        .btn-success:hover {
            background: #166534;
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            border: none;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .btn-add {
            padding: 12px 22px;
            border-radius: 14px;
        }

        .save-btn {
            border-radius: 14px;
            padding: 14px 34px;
            font-size: 16px;
            font-weight: 700;
            box-shadow: 0 10px 25px rgba(22, 163, 74, .25);
        }

        /* ANIMATION */

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

        /* MOBILE */

        @media(max-width:768px) {

            body {
                font-size: 13px;
            }

            .container {
                padding-left: 10px;
                padding-right: 10px;
            }

            .page-title {
                font-size: 23px;
                line-height: 1.4;
            }

            .main-card,
            .section-card {
                border-radius: 18px;
                padding: 16px !important;
            }

            .row>div {
                margin-bottom: 10px;
            }

            .form-control {
                height: 44px;
                font-size: 13px;
            }

            label.fw-bold {
                font-size: 13px;
            }

            .section-header {
                flex-direction: column;
            }

            .item-row {
                padding: 14px;
            }

            .detail-row {
                padding: 10px;
            }

            .btn {
                width: 100%;
                font-size: 13px;
                padding: 10px;
            }

            .btn-add {
                width: 100%;
                margin-top: 10px;
            }

            .save-btn {
                width: 100%;
                font-size: 15px;
                padding: 13px;
            }

            .btn-danger {
                width: 100%;
            }

            .btn-info.btn-sm,
            .btn-primary.btn-sm {
                width: 100%;
                margin-top: 8px;
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
                        <input type="text" name="judul" class="form-control" autocomplete="off"
                            placeholder="Contoh: Forklift Harian" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Unit</label>
                        <input type="text" name="unit" class="form-control" autocomplete="off"
                            placeholder="Contoh: Forklift">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">No Lambung</label>
                        <input type="text" name="no_lambung" class="form-control" autocomplete="off"
                            placeholder="Contoh: FL-001">
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
                            placeholder="Contoh: Harian / Mingguan / Bulanan" autocomplete="off">

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
                    placeholder="I / II" autocomplete="off">
            </div>

            <div class="col-md-9">
                <input type="text"
                    name="sections[${sectionIndex}][nama]"
                    class="form-control"
                    placeholder="Sub Judul" autocomplete="off"
                    required>
            </div>

            <div class="col-md-1">
                <button type="button"
                    class="btn btn-danger "
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
                    placeholder="a / b" autocomplete="off">
            </div>

            <div class="col-md-9">
                <input type="text"
                    name="sections[${sIndex}][items][${iIndex}][uraian]"
                    class="form-control" autocomplete="off"
                    placeholder="Uraian Pekerjaan"
                    required>
            </div>

            <div class="col-md-1">
                <button type="button"
                    class="btn btn-danger "
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
                placeholder="Aktivitas Pekerjaan" autocomplete="off">

        </div>

        <div class="col-md-5">

            <input type="text"
                name="sections[${sIndex}][items][${iIndex}][details][${dIndex}][standar]"
                class="form-control"
                placeholder="Standar" autocomplete="off">

        </div>

        <div class="col-md-2">

            <button type="button"
                class="btn btn-danger "
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
