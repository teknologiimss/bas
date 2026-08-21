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
        <h3 class="page-title mb-4">✏️ Edit Monitoring FCU</h3>

        <form action="{{ route('fcu.update', $fcu->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card main-card p-4 mb-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Judul Monitoring</label>
                        <input type="text" name="judul" class="form-control" value="{{ $fcu->judul }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Jenis Perawatan</label>
                        <select name="jenis_perawatan" id="jenis_perawatan" class="form-select"
                            onchange="toggleUnscheduledForm()" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="P1" {{ $fcu->jenis_perawatan == 'P1' ? 'selected' : '' }}>P1</option>
                            <option value="P3" {{ $fcu->jenis_perawatan == 'P3' ? 'selected' : '' }}>P3</option>
                            <option value="P6" {{ $fcu->jenis_perawatan == 'P6' ? 'selected' : '' }}>P6</option>
                            <option value="P12" {{ $fcu->jenis_perawatan == 'P12' ? 'selected' : '' }}>P12</option>
                            <option value="Unscheduled" {{ $fcu->jenis_perawatan == 'Unscheduled' ? 'selected' : '' }}>
                                Unscheduled</option>
                        </select>
                    </div>

                    {{-- Section Input Scheduled (Unit FCU 1 & 2) --}}
                    <div class="col-md-6 mb-3 scheduled-group">
                        <div class="p-3 bg-light rounded border">
                            <h6 class="fw-bold text-primary">UNIT FCU 1 (Atas)</h6>
                            <div class="mb-2">
                                <label class="fw-bold">No. FCU Pertama</label>
                                <input type="text" name="no_fcu" id="no_fcu_input" class="form-control" value="{{ $fcu->no_fcu }}">
                            </div>
                            <div>
                                <label class="fw-bold">Tanggal Perawatan</label>
                                <input type="date" name="tanggal" id="tanggal_input" class="form-control" value="{{ $fcu->tanggal }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3 scheduled-group">
                        <div class="p-3 bg-light rounded border">
                            <h6 class="fw-bold text-primary">UNIT FCU 2 (Bawah)</h6>
                            <div class="mb-2">
                                <label class="fw-bold">No. FCU Kedua</label>
                                <input type="text" name="no_fcu_2" class="form-control" value="{{ $fcu->no_fcu_2 }}">
                            </div>
                            <div>
                                <label class="fw-bold">Tanggal Perawatan</label>
                                <input type="date" name="tanggal_2" class="form-control" value="{{ $fcu->tanggal_2 }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Unscheduled --}}
                <div id="unscheduled_box" class="p-3 bg-light rounded-3 mt-3 border"
                    style="display: {{ $fcu->jenis_perawatan == 'Unscheduled' ? 'block' : 'none' }};">
                    <h5 class="fw-bold text-danger mb-3">⚠️ Form Unscheduled Maintenance</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="fw-bold">No. Form FCU Unscheduled</label>
                            <input type="text" name="unscheduled_no_fcu" class="form-control"
                                value="{{ optional($fcu->unscheduledForm)->no_fcu }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="fw-bold">Tanggal</label>
                            <input type="date" name="unscheduled_tanggal" id="unscheduled_tanggal_input" class="form-control"
                                value="{{ optional($fcu->unscheduledForm)->tanggal }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="fw-bold">Personil</label>
                            <input type="text" name="unscheduled_personil" class="form-control"
                                value="{{ optional($fcu->unscheduledForm)->personil }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="fw-bold">Status</label>
                            <select name="unscheduled_status" class="form-select">
                                <option value="OK"
                                    {{ optional($fcu->unscheduledForm)->status == 'OK' ? 'selected' : '' }}>OK</option>
                                <option value="NOK"
                                    {{ optional($fcu->unscheduledForm)->status == 'NOK' ? 'selected' : '' }}>NOK</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="fw-bold">Jenis Kerusakan</label>
                            <textarea name="unscheduled_jenis_kerusakan" class="form-control" rows="2">{{ optional($fcu->unscheduledForm)->jenis_kerusakan }}</textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="fw-bold">Tindak Lanjut</label>
                            <textarea name="unscheduled_tindak_lanjut" class="form-control" rows="2">{{ optional($fcu->unscheduledForm)->tindak_lanjut }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Container Sections --}}
            <div id="sections">
                @foreach ($fcu->sections as $sIdx => $section)
                    <div class="card section-card p-3 mb-4">
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <input type="text" name="sections[{{ $sIdx }}][kode]" class="form-control"
                                    value="{{ $section->kode }}" placeholder="I / II">
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="sections[{{ $sIdx }}][nama]" class="form-control section-nama-input"
                                    value="{{ $section->nama_section }}" placeholder="Sub Judul FCU">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger"
                                    onclick="this.closest('.section-card').remove()">✖</button>
                            </div>
                        </div>

                        <div id="items-{{ $sIdx }}">
                            @foreach ($section->items as $iIdx => $item)
                                <div class="item-row p-3 mb-3">
                                    <div class="row mb-3">
                                        <div class="col-md-2">
                                            <input type="text"
                                                name="sections[{{ $sIdx }}][items][{{ $iIdx }}][nomor]"
                                                class="form-control" value="{{ $item->nomor }}" placeholder="a / b">
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text"
                                                name="sections[{{ $sIdx }}][items][{{ $iIdx }}][uraian]"
                                                class="form-control item-uraian-input" value="{{ $item->uraian }}"
                                                placeholder="Uraian Pekerjaan">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger"
                                                onclick="this.closest('.item-row').remove()">✖</button>
                                        </div>
                                    </div>

                                    <div id="details-{{ $sIdx }}-{{ $iIdx }}">
                                        @foreach ($item->details as $dIdx => $detail)
                                            <div class="row mb-2 detail-row">
                                                <div class="col-md-5">
                                                    <input type="text"
                                                        name="sections[{{ $sIdx }}][items][{{ $iIdx }}][details][{{ $dIdx }}][aktivitas]"
                                                        class="form-control" value="{{ $detail->aktivitas }}"
                                                        placeholder="Aktivitas Pekerjaan">
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="text"
                                                        name="sections[{{ $sIdx }}][items][{{ $iIdx }}][details][{{ $dIdx }}][standar]"
                                                        class="form-control" value="{{ $detail->standar }}"
                                                        placeholder="Standar">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="this.closest('.detail-row').remove()">✖</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-info btn-sm text-white"
                                        onclick="addDetail({{ $sIdx }}, {{ $iIdx }})">➕ Tambah Aktivitas
                                        & Standar</button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-primary btn-sm mt-2"
                            onclick="addItem({{ $sIdx }})">➕ Tambah Item Pekerjaan</button>
                    </div>
                @endforeach
            </div>

            <div class="mb-4" id="btn_add_section_wrapper">
                <button type="button" class="btn btn-primary" onclick="addSection()">➕ Tambah Sub Judul / Section</button>
            </div>

            <button type="submit" class="btn btn-success p-3 fw-bold rounded-3">💾 Perbarui Monitoring FCU</button>
            <a href="{{ route('fcu.index') }}" class="btn btn-secondary p-3 fw-bold rounded-3">Batal</a>
        </form>
    </div>

    <script>
        function toggleUnscheduledForm() {
            let val = document.getElementById('jenis_perawatan').value;
            let unscheduledBox = document.getElementById('unscheduled_box');
            let scheduledInputs = document.querySelectorAll('.scheduled-group');
            let sectionsWrapper = document.getElementById('sections');
            let addSectionBtn = document.getElementById('btn_add_section_wrapper');

            let sectionNamaInputs = document.querySelectorAll('.section-nama-input');
            let itemUraianInputs = document.querySelectorAll('.item-uraian-input');

            if (val === 'Unscheduled') {
                // Tampilkan Form Unscheduled, sembunyikan Form P & Sections
                unscheduledBox.style.display = 'block';
                scheduledInputs.forEach(el => el.style.display = 'none');
                if (sectionsWrapper) sectionsWrapper.style.display = 'none';
                if (addSectionBtn) addSectionBtn.style.display = 'none';

                // Lepas atribut required agar validation HTML5 tidak memblok submit
                document.getElementById('no_fcu_input').removeAttribute('required');
                document.getElementById('tanggal_input').removeAttribute('required');
                
                sectionNamaInputs.forEach(el => el.removeAttribute('required'));
                itemUraianInputs.forEach(el => el.removeAttribute('required'));
            } else {
                // Tampilkan Form P & Sections, sembunyikan Unscheduled
                unscheduledBox.style.display = 'none';
                scheduledInputs.forEach(el => el.style.display = 'block');
                if (sectionsWrapper) sectionsWrapper.style.display = 'block';
                if (addSectionBtn) addSectionBtn.style.display = 'block';

                // Pasang atribut required
                document.getElementById('no_fcu_input').setAttribute('required', 'required');
                document.getElementById('tanggal_input').setAttribute('required', 'required');

                sectionNamaInputs.forEach(el => el.setAttribute('required', 'required'));
                itemUraianInputs.forEach(el => el.setAttribute('required', 'required'));
            }
        }

        document.addEventListener('DOMContentLoaded', toggleUnscheduledForm);

        let sectionIndex = {{ $fcu->sections->count() }};
        let itemIndexes = {};
        let detailIndexes = {};

        @foreach ($fcu->sections as $sIdx => $section)
            itemIndexes[{{ $sIdx }}] = {{ $section->items->count() }};
            @foreach ($section->items as $iIdx => $item)
                detailIndexes['{{ $sIdx }}_{{ $iIdx }}'] = {{ $item->details->count() }};
            @endforeach
        @endforeach

        function addSection() {
            itemIndexes[sectionIndex] = 0;
            let html = `
            <div class="card section-card p-3 mb-4">
                <div class="row mb-3">
                    <div class="col-md-2"><input type="text" name="sections[${sectionIndex}][kode]" class="form-control" placeholder="I / II"></div>
                    <div class="col-md-9"><input type="text" name="sections[${sectionIndex}][nama]" class="form-control section-nama-input" placeholder="Sub Judul FCU" required></div>
                    <div class="col-md-1"><button type="button" class="btn btn-danger" onclick="this.closest('.section-card').remove()">✖</button></div>
                </div>
                <div id="items-${sectionIndex}"></div>
                <button type="button" class="btn btn-primary btn-sm mt-2" onclick="addItem(${sectionIndex})">➕ Tambah Item Pekerjaan</button>
            </div>`;
            document.getElementById('sections').insertAdjacentHTML('beforeend', html);
            sectionIndex++;
        }

        function addItem(sIndex) {
            let iIndex = itemIndexes[sIndex] || 0;
            detailIndexes[`${sIndex}_${iIndex}`] = 0;
            let html = `
            <div class="item-row p-3 mb-3">
                <div class="row mb-3">
                    <div class="col-md-2"><input type="text" name="sections[${sIndex}][items][${iIndex}][nomor]" class="form-control" placeholder="a / b"></div>
                    <div class="col-md-9"><input type="text" name="sections[${sIndex}][items][${iIndex}][uraian]" class="form-control item-uraian-input" placeholder="Uraian Pekerjaan" required></div>
                    <div class="col-md-1"><button type="button" class="btn btn-danger" onclick="this.closest('.item-row').remove()">✖</button></div>
                </div>
                <div id="details-${sIndex}-${iIndex}"></div>
                <button type="button" class="btn btn-info btn-sm text-white" onclick="addDetail(${sIndex}, ${iIndex})">➕ Tambah Aktivitas & Standar</button>
            </div>`;
            document.getElementById(`items-${sIndex}`).insertAdjacentHTML('beforeend', html);
            addDetail(sIndex, iIndex);
            itemIndexes[sIndex] = iIndex + 1;
        }

        function addDetail(sIndex, iIndex) {
            let key = `${sIndex}_${iIndex}`;
            let dIndex = detailIndexes[key] || 0;
            let html = `
            <div class="row mb-2 detail-row">
                <div class="col-md-5"><input type="text" name="sections[${sIndex}][items][${iIndex}][details][${dIndex}][aktivitas]" class="form-control" placeholder="Aktivitas Pekerjaan"></div>
                <div class="col-md-5"><input type="text" name="sections[${sIndex}][items][${iIndex}][details][${dIndex}][standar]" class="form-control" placeholder="Standar"></div>
                <div class="col-md-2"><button type="button" class="btn btn-danger" onclick="this.closest('.detail-row').remove()">✖</button></div>
            </div>`;
            document.getElementById(`details-${sIndex}-${iIndex}`).insertAdjacentHTML('beforeend', html);
            detailIndexes[key] = dIndex + 1;
        }
    </script>
@endsection