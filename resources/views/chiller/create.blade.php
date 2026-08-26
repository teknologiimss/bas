@extends('layouts.main')

@section('content')
    <link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #0f172a;
            --secondary: #1e3a8a;
            --accent: #2563eb;
            --border: #dbeafe;
        }

        body {
            background: #eef4fb;
            font-family: 'Segoe UI', sans-serif;
        }

        .page-title {
            font-size: 26px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 25px;
        }

        .main-card {
            border: none;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .08);
            padding: 24px;
        }

        .item-card {
            background: #f8fbff;
            border: 1.5px solid var(--border);
            border-radius: 16px;
            padding: 18px;
            margin-bottom: 18px;
        }

        .detail-row {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            border: 1.5px solid var(--border);
            height: 44px;
            box-shadow: none !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent);
        }

        .btn {
            border-radius: 12px;
            font-weight: 600;
        }

        .save-btn {
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 700;
            background: linear-gradient(135deg, #16a34a, #15803d);
            border: none;
            color: white;
        }
    </style>

    <div class="container mt-4 mb-5">
        <h3 class="page-title">📋 Buat Checksheet Perawatan</h3>

        <form action="{{ route('chiller.store') }}" method="POST">
            @csrf

            {{-- HEADER DATA --}}
            <div class="main-card mb-4">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold mb-1">Judul Checksheet</label>
                        <input type="text" name="judul" class="form-control"
                            placeholder="Contoh: Checksheet Maintenance Chiller" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold mb-1">No Chiller</label>
                        <input type="text" name="no_chiller" class="form-control" placeholder="Contoh: CHILLER-01"
                            required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold mb-1">No Aset</label>
                        <input type="text" name="no_aset" class="form-control" placeholder="Contoh: AST-CH-001">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold mb-1">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Gedung A Lt. 2">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold mb-1">Tanggal Pelaksanaan</label>
                        <input type="date" name="tanggal_pelaksanaan" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold mb-1">Durasi Pekerjaan</label>
                        <input type="text" name="durasi_pekerjaan" class="form-control"
                            placeholder="Contoh: 2 Jam / 1 Hari">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold mb-1">Personil</label>
                        <input type="text" name="personil" class="form-control"
                            placeholder="Contoh: Teknisi A, Teknisi B">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold mb-1">Jenis Perawatan</label>
                        <select name="jenis_perawatan" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Jenis --</option>
                            <option value="P1">P1</option>
                            <option value="P3">P3</option>
                            <option value="P6">P6</option>
                            <option value="P12">P12</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- DAFTAR ITEM PEKERJAAN --}}
            <div class="main-card mb-4">
                <h5 class="fw-bold text-primary mb-3">🛠️ Uraian & Aktivitas Pekerjaan</h5>

                <div id="items-container"></div>

                <button type="button" class="btn btn-primary mt-2" onclick="addItem()">
                    <i class="fa fa-plus me-1"></i> Tambah Kelompok Uraian
                </button>
            </div>

            <button type="submit" class="btn save-btn">
                <i class="fa fa-save me-1"></i> Simpan Checksheet
            </button>
        </form>
    </div>

    <script>
        let itemIndex = 0;
        let detailIndexes = {};

        function addItem() {
            let sIndex = itemIndex;
            detailIndexes[sIndex] = 0;

            let html = `
            <div class="item-card">
                <div class="row align-items-center mb-3">
                    <div class="col-md-2 mb-2">
                        <label class="fw-bold small text-muted">No / Kode</label>
                        <input type="text" name="items[${sIndex}][nomor]" class="form-control" placeholder="I / A">
                    </div>
                    <div class="col-md-9 mb-2">
                        <label class="fw-bold small text-muted">Uraian Pekerjaan Utama</label>
                        <input type="text" name="items[${sIndex}][uraian_pekerjaan]" class="form-control" placeholder="Contoh: CHILLER UNIT / SISTEM KELISTRIKAN" required>
                    </div>
                    <div class="col-md-1 mb-2 text-end">
                        <label class="d-block">&nbsp;</label>
                        <button type="button" class="btn btn-danger w-100" onclick="removeItem(this)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>

                <div class="ms-3">
                    <label class="fw-bold small text-primary mb-2">Aktivitas / Detail Pekerjaan:</label>
                    <div id="details-container-${sIndex}"></div>
                    
                    <button type="button" class="btn btn-info btn-sm text-white mt-2" onclick="addDetail(${sIndex})">
                        <i class="fa fa-plus me-1"></i> Tambah Aktivitas
                    </button>
                </div>
            </div>
            `;

            document.getElementById('items-container').insertAdjacentHTML('beforeend', html);
            addDetail(sIndex);
            itemIndex++;
        }

        function addDetail(sIndex) {
            let dIndex = detailIndexes[sIndex];

            let html = `
            <div class="row align-items-center detail-row">
                <div class="col-md-6 mb-1">
                    <input type="text" name="items[${sIndex}][details][${dIndex}][aktivitas_pekerjaan]" class="form-control" placeholder="Uraian Aktivitas (Contoh: Cek Kondisi Kompresor)" required>
                </div>
                <div class="col-md-5 mb-1">
                    <input type="text" name="items[${sIndex}][details][${dIndex}][standar]" class="form-control" placeholder="Standar (Contoh: Normal / Baik)">
                </div>
                <div class="col-md-1 mb-1 text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="removeDetail(this)">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            `;

            document.getElementById(`details-container-${sIndex}`).insertAdjacentHTML('beforeend', html);
            detailIndexes[sIndex]++;
        }

        function removeItem(btn) {
            btn.closest('.item-card').remove();
        }

        function removeDetail(btn) {
            btn.closest('.detail-row').remove();
        }

        addItem();
    </script>
@endsection
