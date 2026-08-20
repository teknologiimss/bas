@extends('layouts.main')

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <style>
        :root {
            --primary: #0f172a;
            --secondary: #1e3a8a;
            --border: #dbeafe;
        }

        body {
            background: #eef4fb;
            font-family: 'Segoe UI', sans-serif;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary);
        }

        .main-card,
        .section-card {
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 10px 25px rgba(15, 23, 42, .07);
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            border: 2px solid var(--border);
            height: 48px;
        }

        .item-row {
            background: #f8fbff;
            border: 1px solid var(--border);
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
    </style>

    <div class="container mt-4 mb-5">
        <h3 class="page-title mb-4">📋 Buat Monitoring FCU</h3>

        <form action="{{ route('fcu.store') }}" method="POST">
            @csrf

            <div class="card main-card p-4 mb-4">
                {{-- <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Judul</label>
                        <input type="text" name="judul" class="form-control"
                            placeholder="Contoh: Maintenance FCU Lantai 2" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Jenis Perawatan</label>
                        <select name="jenis_perawatan" id="jenis_perawatan" class="form-select"
                            onchange="toggleUnscheduledForm()" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="P1">P1</option>
                            <option value="P3">P3</option>
                            <option value="P6">P6</option>
                            <option value="P12">P12</option>
                            <option value="Unscheduled">Unscheduled</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Tanggal Perawatan</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">No. FCU</label>
                        <input type="text" name="no_fcu" class="form-control" placeholder="Contoh: FCU-01" required>
                    </div>
                </div> --}}

                <!-- Gantilah div class="row" di main-card create.blade.php menjadi seperti ini -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Judul Monitoring</label>
                        <input type="text" name="judul" class="form-control"
                            placeholder="Contoh: Maintenance FCU Lantai 2" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Jenis Perawatan</label>
                        <select name="jenis_perawatan" id="jenis_perawatan" class="form-select"
                            onchange="toggleUnscheduledForm()" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="P1">P1</option>
                            <option value="P3">P3</option>
                            <option value="P6">P6</option>
                            <option value="P12">P12</option>
                            <option value="Unscheduled">Unscheduled</option>
                        </select>
                    </div>

                    <!-- SISI FCU PERTAMA (ATAS) -->
                    <div class="col-md-6 mb-3">
                        <div class="p-3 bg-light rounded border">
                            <h6 class="fw-bold text-primary">UNIT FCU 1 (Atas)</h6>
                            <div class="mb-2">
                                <label class="fw-bold">No. FCU Pertama</label>
                                <input type="text" name="no_fcu" class="form-control" placeholder="Contoh: FCU-01A"
                                    required>
                            </div>
                            <div>
                                <label class="fw-bold">Tanggal Perawatan</label>
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <!-- SISI FCU KEDUA (BAWAH) -->
                    <div class="col-md-6 mb-3">
                        <div class="p-3 bg-light rounded border">
                            <h6 class="fw-bold text-primary">UNIT FCU 2 (Bawah)</h6>
                            <div class="mb-2">
                                <label class="fw-bold">No. FCU Kedua</label>
                                <input type="text" name="no_fcu_2" class="form-control"
                                    placeholder="Contoh: FCU-01B (Opsional)">
                            </div>
                            <div>
                                <label class="fw-bold">Tanggal Perawatan</label>
                                <input type="date" name="tanggal_2" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Unscheduled (Muncul jika pilih Unscheduled) --}}
                <div id="unscheduled_box" class="p-3 bg-light rounded-3 mt-3 border" style="display: none;">
                    <h5 class="fw-bold text-danger mb-3">⚠️ Form Unscheduled</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="fw-bold">Tanggal</label>
                            <input type="date" name="unscheduled_tanggal" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="fw-bold">Personil</label>
                            <input type="text" name="unscheduled_personil" class="form-control"
                                placeholder="Nama Personil">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="fw-bold">Status</label>
                            <select name="unscheduled_status" class="form-select">
                                <option value="OK">OK</option>
                                <option value="NOK">NOK</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Jenis Kerusakan</label>
                            <textarea name="unscheduled_jenis_kerusakan" class="form-control" rows="2" placeholder="Uraian kerusakan"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Tindak Lanjut</label>
                            <textarea name="unscheduled_tindak_lanjut" class="form-control" rows="2" placeholder="Uraian tindak lanjut"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div id="sections"></div>

            <div class="mb-4">
                <button type="button" class="btn btn-primary" onclick="addSection()">➕ Tambah Sub Judul / Section</button>
            </div>

            <button type="submit" class="btn btn-success p-3 fw-bold rounded-3">💾 Simpan Monitoring FCU</button>
        </form>
    </div>

    <script>
        function toggleUnscheduledForm() {
            let val = document.getElementById('jenis_perawatan').value;
            document.getElementById('unscheduled_box').style.display = (val === 'Unscheduled') ? 'block' : 'none';
        }

        let sectionIndex = 0;
        let itemIndexes = {};
        let detailIndexes = {};

        function addSection() {
            itemIndexes[sectionIndex] = 0;
            let html = `
            <div class="card section-card p-3 mb-4">
                <div class="row mb-3">
                    <div class="col-md-2"><input type="text" name="sections[${sectionIndex}][kode]" class="form-control" placeholder="I / II"></div>
                    <div class="col-md-9"><input type="text" name="sections[${sectionIndex}][nama]" class="form-control" placeholder="Sub Judul FCU" required></div>
                    <div class="col-md-1"><button type="button" class="btn btn-danger" onclick="this.closest('.section-card').remove()">✖</button></div>
                </div>
                <div id="items-${sectionIndex}"></div>
                <button type="button" class="btn btn-primary btn-sm mt-2" onclick="addItem(${sectionIndex})">➕ Tambah Item Pekerjaan</button>
            </div>`;
            document.getElementById('sections').insertAdjacentHTML('beforeend', html);
            sectionIndex++;
        }

        function addItem(sIndex) {
            let iIndex = itemIndexes[sIndex];
            detailIndexes[`${sIndex}_${iIndex}`] = 0;
            let html = `
            <div class="item-row p-3 mb-3">
                <div class="row mb-3">
                    <div class="col-md-2"><input type="text" name="sections[${sIndex}][items][${iIndex}][nomor]" class="form-control" placeholder="a / b"></div>
                    <div class="col-md-9"><input type="text" name="sections[${sIndex}][items][${iIndex}][uraian]" class="form-control" placeholder="Uraian Pekerjaan" required></div>
                    <div class="col-md-1"><button type="button" class="btn btn-danger" onclick="this.closest('.item-row').remove()">✖</button></div>
                </div>
                <div id="details-${sIndex}-${iIndex}"></div>
                <button type="button" class="btn btn-info btn-sm text-white" onclick="addDetail(${sIndex}, ${iIndex})">➕ Tambah Aktivitas & Standar</button>
            </div>`;
            document.getElementById(`items-${sIndex}`).insertAdjacentHTML('beforeend', html);
            addDetail(sIndex, iIndex);
            itemIndexes[sIndex]++;
        }

        function addDetail(sIndex, iIndex) {
            let key = `${sIndex}_${iIndex}`;
            let dIndex = detailIndexes[key];
            let html = `
            <div class="row mb-2 detail-row">
                <div class="col-md-5"><input type="text" name="sections[${sIndex}][items][${iIndex}][details][${dIndex}][aktivitas]" class="form-control" placeholder="Aktivitas Pekerjaan"></div>
                <div class="col-md-5"><input type="text" name="sections[${sIndex}][items][${iIndex}][details][${dIndex}][standar]" class="form-control" placeholder="Standar"></div>
                <div class="col-md-2"><button type="button" class="btn btn-danger" onclick="this.closest('.detail-row').remove()">✖</button></div>
            </div>`;
            document.getElementById(`details-${sIndex}-${iIndex}`).insertAdjacentHTML('beforeend', html);
            detailIndexes[key]++;
        }
    </script>
@endsection
