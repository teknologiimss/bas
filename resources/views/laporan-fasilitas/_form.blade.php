<style>
    @media (max-width: 575.98px) {
        .form-laporan-wrap .card-header {
            flex-wrap: wrap !important;
            gap: 8px;
        }

        .form-laporan-wrap .card-header .card-title {
            font-size: 0.95rem !important;
            width: 100%;
        }

        .form-laporan-wrap .card-header .btn {
            margin-left: 0 !important;
            width: 100%;
        }

        .form-laporan-wrap .item-row {
            padding: 12px !important;
        }

        .form-laporan-wrap .item-row .col-md-1.text-right {
            text-align: left !important;
            margin-top: 8px;
        }

        .form-laporan-wrap .item-row .col-md-1.text-right label {
            display: none !important;
        }

        .form-laporan-wrap .item-row .btn-remove-item {
            width: 100%;
        }

        .form-laporan-wrap .team-row {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px !important;
            background: #f8fafc;
        }

        .form-laporan-wrap .team-row>div {
            margin-bottom: 8px;
        }

        .form-laporan-wrap .team-row>div:last-child {
            margin-bottom: 0;
            text-align: left !important;
        }

        .form-laporan-wrap .team-row .btn-remove-team {
            width: 100%;
        }

        .form-laporan-wrap .form-submit-actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-laporan-wrap .form-submit-actions .btn-lg {
            width: 100%;
            font-size: 0.95rem;
            padding: 10px 14px;
        }
    }
</style>

<div class="form-laporan-wrap">
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Periksa kembali inputan Anda:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="card card-navy">
        <div class="card-header">
            <h3 class="card-title">Informasi Header Laporan</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tanggal Laporan <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                            required
                            value="{{ old('tanggal', $laporan ? $laporan->tanggal->format('Y-m-d') : date('Y-m-d')) }}">
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Judul Laporan <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                            required
                            value="{{ old('judul', $laporan->judul ?? 'JOB DESK PEMELIHARAAN FASILITAS & JASA LAINNYA') }}">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- INPUT ITEM PEKERJAAN --}}
    <div class="card card-primary card-outline">
        <div class="card-header d-flex align-items-center">
            <h3 class="card-title font-weight-bold mb-0">Daftar Pekerjaan (Bagian A & Bagian B)</h3>
            <button type="button" class="btn btn-sm btn-success ml-auto" id="btn-add-item">
                <i class="fas fa-plus mr-1"></i> Tambah Baris Pekerjaan
            </button>
        </div>
        <div class="card-body">
            <div id="items-container">
                @php
                    $existingItems = old(
                        'items',
                        $laporan
                            ? $laporan->items
                                ->map(function ($i) {
                                    return [
                                        'kelompok' => $i->kelompok,
                                        'sub_kategori' => $i->sub_kategori,
                                        'deskripsi' => $i->deskripsi,
                                        'sub_items_raw' => is_array($i->sub_items) ? implode("\n", $i->sub_items) : '',
                                    ];
                                })
                                ->toArray()
                            : [
                                [
                                    'kelompok' => 'A',
                                    'sub_kategori' => 'Pengecekan Harian',
                                    'deskripsi' => '',
                                    'sub_items_raw' => '',
                                ],
                            ],
                    );
                @endphp

                @foreach ($existingItems as $idx => $item)
                    @php
                        $kelVal = $item['kelompok'] ?? 'A';
                        $opts = $subKategoriList[$kelVal] ?? $subKategoriList['A'];
                        $subVal = $item['sub_kategori'] ?? ($opts[0] ?? '');
                    @endphp
                    <div class="border rounded p-3 mb-3 bg-light item-row">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Kelompok</label>
                                    <select name="items[{{ $idx }}][kelompok]"
                                        class="form-control kelompok-select">
                                        <option value="A" {{ $kelVal === 'A' ? 'selected' : '' }}>A. Fasilitas
                                            Angkut-Angkut</option>
                                        <option value="B" {{ $kelVal === 'B' ? 'selected' : '' }}>B. Pekerjaan Lain
                                            /
                                            Jasa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Sub Kategori</label>
                                    <select name="items[{{ $idx }}][sub_kategori]"
                                        class="form-control subkategori-select" data-selected="{{ $subVal }}">
                                        @foreach ($opts as $opt)
                                            <option value="{{ $opt }}"
                                                {{ $subVal === $opt ? 'selected' : '' }}>
                                                {{ $opt }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Deskripsi Pekerjaan Utama <small class="text-muted">(bisa Enter ke baris
                                            baru)</small></label>
                                    <textarea name="items[{{ $idx }}][deskripsi]" rows="3" class="form-control"
                                        placeholder="Contoh:&#10;Forklift ( D-01 ; D-02 ; D-03 )&#10;Pick Up ( 01 ; 02 )">{{ $item['deskripsi'] ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-1 text-right">
                                <label class="d-block">&nbsp;</label>
                                <button type="button" class="btn btn-danger btn-remove-item" title="Hapus Baris">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-0">
                                    <label class="text-muted small">Sub-Item Bernomor (Opsional — pisahkan tiap baris
                                        dengan
                                        Enter, lalu ketik isi baris baru)</label>
                                    <textarea name="items[{{ $idx }}][sub_items_raw]" rows="3" class="form-control form-control-sm"
                                        placeholder="Ketik item di sini, tekan Enter untuk baris berikutnya...&#10;Contoh: K102616 ✅">{{ $item['sub_items_raw'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- INPUT DAFTAR TEAM --}}
    <div class="card card-info card-outline">
        <div class="card-header d-flex align-items-center">
            <h3 class="card-title font-weight-bold mb-0">Daftar Team Bertugas</h3>
            <button type="button" class="btn btn-sm btn-info ml-auto" id="btn-add-team">
                <i class="fas fa-user-plus mr-1"></i> Tambah Personil
            </button>
        </div>
        <div class="card-body">
            <div id="teams-container">
                @php
                    $existingTeams = old(
                        'teams',
                        $laporan ? $laporan->teams->toArray() : [['nama_personil' => '', 'keterangan' => '']],
                    );
                @endphp

                @foreach ($existingTeams as $tIdx => $team)
                    <div class="row mb-2 team-row align-items-center">
                        <div class="col-md-6">
                            <input type="text" name="teams[{{ $tIdx }}][nama_personil]" class="form-control"
                                placeholder="Nama Personil (Contoh: Amar)" value="{{ $team['nama_personil'] ?? '' }}">
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="teams[{{ $tIdx }}][keterangan]" class="form-control"
                                placeholder="Keterangan Opsional (Contoh: Perbantuan Wil 1 / CT / BWI)"
                                value="{{ $team['keterangan'] ?? '' }}">
                        </div>
                        <div class="col-md-1 text-right">
                            <button type="button" class="btn btn-danger btn-remove-team" title="Hapus Personil">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="mb-4 form-submit-actions">
        <button type="submit" class="btn btn-primary btn-lg" id="btn-simpan-laporan">
            <i class="fas fa-save mr-1"></i> Simpan Laporan
        </button>
        <a href="{{ route('laporan-fasilitas.index') }}" class="btn btn-secondary btn-lg">Batal</a>
    </div>
</div>

<script>
    (function() {
        const subKategoriMap = @json($subKategoriList);
        let itemIndex = {{ count($existingItems) + 10 }};
        let teamIndex = {{ count($existingTeams) + 10 }};

        function escapeHtml(text) {
            return String(text || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        function fillSubKategori(selectEl, kelompok, selectedVal = '') {
            const list = subKategoriMap[kelompok] || subKategoriMap['A'] || [];
            const targetVal = selectedVal || list[0] || '';
            selectEl.innerHTML = '';

            list.forEach(function(sub) {
                const opt = document.createElement('option');
                opt.value = sub;
                opt.textContent = sub;
                if (sub === targetVal) {
                    opt.selected = true;
                }
                selectEl.appendChild(opt);
            });
        }

        function initAllSubKategori() {
            document.querySelectorAll('#items-container .item-row').forEach(function(row) {
                const kelSelect = row.querySelector('.kelompok-select');
                const subSelect = row.querySelector('.subkategori-select');
                if (kelSelect && subSelect) {
                    fillSubKategori(subSelect, kelSelect.value, subSelect.getAttribute('data-selected') ||
                        subSelect.value);
                }
            });
        }

        initAllSubKategori();

        document.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('kelompok-select')) {
                const row = e.target.closest('.item-row');
                const subSelect = row ? row.querySelector('.subkategori-select') : null;
                if (subSelect) {
                    fillSubKategori(subSelect, e.target.value, '');
                }
            }
        });

        const btnAddItem = document.getElementById('btn-add-item');
        if (btnAddItem) {
            btnAddItem.addEventListener('click', function() {
                const container = document.getElementById('items-container');
                if (!container) return;

                const idx = itemIndex++;
                const defaultKel = 'A';
                const optsHtml = (subKategoriMap[defaultKel] || [])
                    .map(function(sub, i) {
                        return `<option value="${escapeHtml(sub)}" ${i === 0 ? 'selected' : ''}>${escapeHtml(sub)}</option>`;
                    })
                    .join('');

                const div = document.createElement('div');
                div.className = 'border rounded p-3 mb-3 bg-light item-row';
                div.innerHTML = `
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Kelompok</label>
                            <select name="items[${idx}][kelompok]" class="form-control kelompok-select">
                                <option value="A" selected>A. Fasilitas Angkut-Angkut</option>
                                <option value="B">B. Pekerjaan Lain / Jasa</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Sub Kategori</label>
                            <select name="items[${idx}][sub_kategori]" class="form-control subkategori-select">
                                ${optsHtml}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Deskripsi Pekerjaan Utama <small class="text-muted">(bisa Enter ke baris baru)</small></label>
                            <textarea name="items[${idx}][deskripsi]" rows="3" class="form-control"
                                placeholder="Contoh:&#10;Forklift ( D-01 ; D-02 ; D-03 )&#10;Pick Up ( 01 ; 02 )"></textarea>
                        </div>
                    </div>
                    <div class="col-md-1 text-right">
                        <label class="d-block">&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-remove-item" title="Hapus Baris">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-0">
                            <label class="text-muted small">Sub-Item Bernomor (Opsional — pisahkan tiap baris dengan Enter, lalu ketik isi baris baru)</label>
                            <textarea name="items[${idx}][sub_items_raw]" rows="3" class="form-control form-control-sm"
                                placeholder="Ketik item di sini, tekan Enter untuk baris berikutnya...&#10;Contoh: K102616 ✅"></textarea>
                        </div>
                    </div>
                </div>
            `;
                container.appendChild(div);
            });
        }

        const btnAddTeam = document.getElementById('btn-add-team');
        if (btnAddTeam) {
            btnAddTeam.addEventListener('click', function() {
                const container = document.getElementById('teams-container');
                if (!container) return;

                const idx = teamIndex++;
                const div = document.createElement('div');
                div.className = 'row mb-2 team-row align-items-center';
                div.innerHTML = `
                <div class="col-md-6">
                    <input type="text" name="teams[${idx}][nama_personil]" class="form-control"
                        placeholder="Nama Personil (Contoh: Amar)">
                </div>
                <div class="col-md-5">
                    <input type="text" name="teams[${idx}][keterangan]" class="form-control"
                        placeholder="Keterangan Opsional (Contoh: Perbantuan Wil 1 / CT / BWI)">
                </div>
                <div class="col-md-1 text-right">
                    <button type="button" class="btn btn-danger btn-remove-team" title="Hapus Personil">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
                container.appendChild(div);
            });
        }

        document.addEventListener('click', function(e) {
            const removeItemBtn = e.target.closest('.btn-remove-item');
            if (removeItemBtn) {
                const row = removeItemBtn.closest('.item-row');
                const container = document.getElementById('items-container');
                if (row && container) {
                    if (container.querySelectorAll('.item-row').length > 1) {
                        row.remove();
                    } else {
                        row.querySelectorAll('input, textarea').forEach(el => el.value = '');
                    }
                }
                return;
            }

            const removeTeamBtn = e.target.closest('.btn-remove-team');
            if (removeTeamBtn) {
                const row = removeTeamBtn.closest('.team-row');
                const container = document.getElementById('teams-container');
                if (row && container) {
                    if (container.querySelectorAll('.team-row').length > 1) {
                        row.remove();
                    } else {
                        row.querySelectorAll('input').forEach(el => el.value = '');
                    }
                }
            }
        });
    })();
</script>
