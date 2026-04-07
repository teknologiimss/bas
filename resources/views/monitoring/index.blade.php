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
</style>

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h3><b style="margin: 23px;">Monitoring Proyek - {{ $proyek->nama_proyek }}</b></h3>
        <button class="btn btn-success" data-toggle="modal" data-target="#modalCreateMonitoring"
            style="margin-right: 23px;margin-top: 10;">
            + Buat Monitoring Baru
        </button>

    </div>
    {{-- 🔍 Tombol Filter --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

        <button id="toggleFilterBtn" class="btn btn-outline-primary btn-sm" style="margin-left: 23px;">
            🔍 Tampilkan Filter
        </button>
        <a href="{{ route('monitoring.export', $proyek->id) }}" class="btn btn-outline-primary"
            style="height: 38px; margin-top: 20px;">
            📦 Export Semua Dokumen
        </a>
    </div>

    {{-- 🔽 Area Filter (bisa disembunyikan) --}}
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
                {{-- STATUS --}}
                @php
                    $statusClass = match ($m->status) {
                        'Open' => 'bg-warning text-dark',
                        'Closed' => 'bg-success text-white',
                        'On Hold' => 'bg-danger text-white',
                        default => 'bg-secondary text-white',
                    };
                    $statusText = $m->status === 'On Hold' ? '⏸️ On Hold' : $m->status;
                @endphp

                <span class="badge {{ $statusClass }} position-absolute top-0 end-0 mt-2 me-2 px-3 py-2 shadow-sm"
                    style="font-size: 0.9rem;right: 7px;top: -4px;">
                    {{ $statusText }}
                </span>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5><b>Nomor PO / Nota Dinas : {{ $m->po_nota_dinas }}</b></h5>
                        <small>{{ $m->jenis_pekerjaan }}</small><br>
                        <small>Nama Pekerjaan: {{ $m->nama_pekerjaan }}</small><br>
                        <small>
                            Periode:
                            {{ \Carbon\Carbon::parse($m->tanggal_kontrak)->format('d-m-Y') }}
                            s/d
                            {{ \Carbon\Carbon::parse($m->tanggal_selesai_kontrak)->format('d-m-Y') }}
                        </small><br>
                        <small>Keterangan: {{ $m->keterangan ?? '-' }}</small>

                        {{-- PROGRESS --}}
                        <div class="mt-3">
                            <small class="text-muted">Progress Pekerjaan</small>
                            {{-- <div class="progress" style="height: 18px;">
                                <div class="progress-bar 
                                    {{ $m->progress < 50 ? 'bg-danger' : ($m->progress < 100 ? 'bg-warning' : 'bg-success') }}"
                                    role="progressbar" style="width: {{ $m->progress ?? 0 }}%">
                                    {{ $m->progress ?? 0 }}%
                                </div>

                            </div> --}}

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
                                        // Jika pakai "-"
                                        $lines = preg_split('/\r\n|\r|\n/', $text);
                                        echo implode('<br>', $lines);
                                    } else {
                                        // Jika tanpa "-"
                                        $lines = preg_split('/\r\n|\r|\n/', $text);
                                        echo implode(', ', $lines);
                                    }
                                @endphp
                            </small>
                        </div>



                    </div>

                    <div>
                        <button class="btn btn-sm btn-primary" data-toggle="modal"
                            data-target="#modalEdit{{ $m->id }}">Edit</button>
                        <form action="{{ route('monitoring.destroy', $m->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus monitoring ini?')"
                                class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </div>




                {{-- 📄 Dokumen --}}
                @if ($m->documents->count())
                    <div class="mt-4 document-section" data-monitor-id="{{ $m->id }}">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="fw-bold text-primary mb-0">📁 Dokumen Terkait</h6>
                            <button class="btn btn-outline-primary btn-sm px-3 toggle-docs-btn" type="button">
                                👁️ Lihat Dokumen
                            </button>
                        </div>

                        {{-- Daftar Dokumen --}}
                        <ul class="list-unstyled transition document-list" style="display: none;">
                            @foreach ($m->documents as $doc)
                                <li id="doc-{{ $doc->id }}"
                                    class="doc-item card shadow-sm border-0 mb-3 p-3 position-relative animate__animated animate__fadeInUp">

                                    <div class="row g-3 align-items-start">
                                        {{-- KIRI --}}
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

                                        {{-- KANAN --}}
                                        <div class="col-md-6">
                                            <label class="small fw-semibold mb-1">Status Dokumen</label>
                                            <select class="form-select form-select-sm doc-status"
                                                data-id="{{ $doc->id }}">
                                                <option value="-" {{ $doc->status == '-' ? 'selected' : '' }}>-
                                                </option>
                                                <option value="Nok" {{ $doc->status == 'Nok' ? 'selected' : '' }}>🔴
                                                    NOK</option>
                                                <option value="Closed" {{ $doc->status == 'Closed' ? 'selected' : '' }}>🟢
                                                    OK</option>
                                            </select>

                                            <div
                                                class="closed-extra mt-2 transition {{ $doc->status == 'Closed' ? '' : 'd-none' }}">
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








            {{-- MODAL EDIT MONITORING --}}
            <div class="modal fade" id="modalEdit{{ $m->id }}">
                <div class="modal-dialog modal-lg">
                    <form class="modal-content" action="{{ route('monitoring.update', $m->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header bg-danger text-white">
                            <h5>Edit Monitoring</h5>
                            <button type="button" class="btn-close btn-close-white" data-dismiss="modal"></button>
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
                                        <option value="Closed" {{ $m->status == 'Closed' ? 'selected' : '' }}>Closed
                                        </option>
                                        <option value="On Hold" {{ $m->status == 'On Hold' ? 'selected' : '' }}>On Hold
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label>Keterangan</label>
                                    <textarea name="keterangan" class="form-control">{{ $m->keterangan }}</textarea>
                                </div>

                                {{-- Tambah Dokumen Baru --}}
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

                            {{-- <div class="col-md-4">
                                <label>Progress (%)</label>
                                <input type="number" name="progress" class="form-control"
                                    min="0" max="100" value="{{ $m->progress ?? 0 }}" required>
                            </div> --}}

                            <div class="col-md-8">
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
        @endforeach
    </div>

    {{-- MODAL TAMBAH MONITORING --}}
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

                        {{-- Upload Dokumen --}}
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


                        {{-- <div class="col-md-4">
                            <label>Progress (%)</label>
                            <input type="number" name="progress" class="form-control" min="0" max="100"
                                value="0" required>
                        </div>

                        <div class="col-md-8">
                            <label>Keterangan Progress</label>
                            <textarea name="keterangan2" class="form-control" placeholder="Catatan awal progress"></textarea>
                        </div> --}}



                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    {{-- JS --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>




    <script>
        $('.doc-file').on('change', function() {
            let id = $(this).data('id');
            let file = this.files[0];

            let formData = new FormData();
            formData.append('file_dokumen', file);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "{{ route('monitoring.document.update', ':id') }}".replace(':id', id),
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.success) {

                        // 🔥 PAKSA LINK UPDATE
                        let link = $('#file-link-' + id);
                        link.attr('href', res.file_url + '&t=' + new Date().getTime());
                        link.text('📄 Lihat File Terbaru');

                        alert('File berhasil diupdate');
                    }
                }
            });
        });
    </script>







    {{-- 🔹 AJAX DELETE & UPDATE DOKUMEN --}}
    {{-- <script>
        $(document).ready(function() {
            // Hapus dokumen
            $('#document-list').on('click', '.btn-delete-doc', function() {
                if (!confirm('Yakin ingin menghapus dokumen ini?')) return;

                let button = $(this);
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
                            $('#doc-' + button.data('id')).remove();
                            alert(response.message);
                        } else {
                            alert('Gagal menghapus dokumen.');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Terjadi kesalahan saat menghapus dokumen.');
                    }
                });
            });

            // Update dokumen (nama & file)
            $('#document-list').on('click', '.btn-update-doc', function() {
                let button = $(this);
                let id = button.data('id');
                let url = button.data('url');
                let token = '{{ csrf_token() }}';

                let nama_dokumen = $('#doc-' + id + ' .doc-name').val();
                let file_dokumen = $('#doc-' + id + ' .doc-file')[0].files[0];

                let formData = new FormData();
                formData.append('_token', token);
                formData.append('nama_dokumen', nama_dokumen);
                if (file_dokumen) formData.append('file_dokumen', file_dokumen);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            alert('✅ ' + response.message);
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
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            // === DELETE DOKUMEN ===
            $('#document-list').on('click', '.btn-delete-doc', function() {
                if (!confirm('Yakin ingin menghapus dokumen ini?')) return;

                let button = $(this);
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
                            $('#doc-' + button.data('id')).remove();
                            alert(response.message);
                        } else {
                            alert('Gagal menghapus dokumen.');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Terjadi kesalahan saat menghapus dokumen.');
                    }
                });
            });

            // === TAMPILKAN INPUT TAMBAHAN JIKA STATUS = CLOSED ===
            $('#document-list').on('change', '.doc-status', function() {
                const container = $(this).closest('li');
                const value = $(this).val();
                if (value === 'Closed') {
                    container.find('.closed-extra').removeClass('d-none');
                } else {
                    container.find('.closed-extra').addClass('d-none');
                }
            });

            // === UPDATE DOKUMEN (nama, file, status, tanggal, keterangan) ===
            $('#document-list').on('click', '.btn-update-doc', function() {
                let button = $(this);
                let id = button.data('id');
                let url = button.data('url');
                let token = '{{ csrf_token() }}';

                let container = $('#doc-' + id);
                let nama_dokumen = container.find('.doc-name').val();
                let file_dokumen = container.find('.doc-file')[0].files[0];
                let status = container.find('.doc-status').val();
                let tanggal_closed = container.find('.doc-closed-date').val();
                let keterangan_closed = container.find('.doc-closed-note').val();

                let formData = new FormData();
                formData.append('_token', token);
                formData.append('nama_dokumen', nama_dokumen);
                formData.append('status', status);
                if (status === 'Closed') {
                    formData.append('tanggal_closed', tanggal_closed);
                    formData.append('keterangan_closed', keterangan_closed);
                }
                if (file_dokumen) formData.append('file_dokumen', file_dokumen);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            alert('✅ ' + response.message);
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
        });
    </script>


    {{-- Tambah input dokumen baru --}}
    <script>
        document.getElementById('addDokumen').addEventListener('click', () => {
            const container = document.getElementById('dokumenContainer');
            container.insertAdjacentHTML('beforeend', `
                <div class="d-flex gap-2 mb-2">
                    <input type="text" name="nama_dokumen[]" class="form-control" placeholder="Nama Dokumen" required>
                    <input type="file" name="file_dokumen[]" class="form-control" required>
                </div>
            `);
        });

        function addDokumenEdit(id) {
            const container = document.getElementById('dokumenContainerEdit' + id);
            const html = `
                <div class="d-flex gap-2 mb-2">
                    <input type="text" name="nama_dokumen[]" class="form-control" placeholder="Nama Dokumen">
                    <input type="file" name="file_dokumen[]" class="form-control">
                </div>`;
            container.insertAdjacentHTML('beforeend', html);
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Tombol toggle tiap dokumen
            document.querySelectorAll(".document-section").forEach(section => {
                const btn = section.querySelector(".toggle-docs-btn");
                const list = section.querySelector(".document-list");
                let visible = false;

                btn.addEventListener("click", function() {
                    if (!visible) {
                        list.style.display = "block";
                        list.classList.add("animate__fadeInUp");
                        btn.innerHTML = "📁 Sembunyikan Dokumen";
                        visible = true;
                    } else {
                        list.classList.remove("animate__fadeInUp");
                        list.classList.add("animate__fadeOutDown");
                        setTimeout(() => {
                            list.style.display = "none";
                            list.classList.remove("animate__fadeOutDown");
                        }, 400);
                        btn.innerHTML = "👁️ Lihat Dokumen";
                        visible = false;
                    }
                });
            });

            // Animasi field tambahan untuk dokumen Closed
            document.addEventListener("change", function(e) {
                if (e.target.classList.contains("doc-status")) {
                    const parent = e.target.closest(".doc-item");
                    const extra = parent.querySelector(".closed-extra");
                    if (e.target.value === "Closed") {
                        extra.classList.remove("d-none");
                        extra.classList.add("d-block");
                    } else {
                        extra.classList.remove("d-block");
                        extra.classList.add("d-none");
                    }
                }
            });
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ===== Toggle Dokumen per Section =====
            document.querySelectorAll(".document-section").forEach(section => {
                const btn = section.querySelector(".toggle-docs-btn");
                const list = section.querySelector(".document-list");
                let visible = false;

                btn.addEventListener("click", function() {
                    if (!visible) {
                        list.style.display = "block";
                        list.classList.add("animate__fadeInUp");
                        btn.innerHTML = "📁 Sembunyikan Dokumen";
                        visible = true;
                    } else {
                        list.classList.remove("animate__fadeInUp");
                        list.classList.add("animate__fadeOutDown");
                        setTimeout(() => {
                            list.style.display = "none";
                            list.classList.remove("animate__fadeOutDown");
                        }, 400);
                        btn.innerHTML = "👁️ Lihat Dokumen";
                        visible = false;
                    }
                });
            });

            // ===== Status Dokumen (Closed/Open) =====
            document.addEventListener("change", function(e) {
                if (e.target.classList.contains("doc-status")) {
                    const parent = e.target.closest(".doc-item");
                    const extra = parent.querySelector(".closed-extra");
                    if (e.target.value === "Closed") {
                        extra.classList.remove("d-none");
                        extra.classList.add("d-block");
                    } else {
                        extra.classList.remove("d-block");
                        extra.classList.add("d-none");
                    }
                }
            });

            // ====== Tombol Simpan Dokumen ======
            document.addEventListener("click", async function(e) {
                if (e.target.classList.contains("btn-update-doc")) {
                    e.preventDefault();
                    const btn = e.target;
                    const docId = btn.dataset.id;
                    const url = btn.dataset.url;
                    const parent = btn.closest(".doc-item");

                    // Ambil data dokumen
                    const formData = new FormData();
                    formData.append("nama_dokumen", parent.querySelector(".doc-name").value);
                    formData.append("status", parent.querySelector(".doc-status").value);
                    formData.append("tanggal_closed", parent.querySelector(".doc-closed-date")?.value ||
                        "");
                    formData.append("keterangan_closed", parent.querySelector(".doc-closed-note")
                        ?.value || "");

                    const fileInput = parent.querySelector(".doc-file");
                    if (fileInput.files.length > 0) {
                        formData.append("file", fileInput.files[0]);
                    }

                    // Loading state
                    btn.innerHTML = "⏳ Menyimpan...";
                    btn.disabled = true;

                    try {
                        const response = await fetch(url, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector(
                                    'meta[name="csrf-token"]').content
                            },
                            body: formData
                        });

                        if (response.ok) {
                            btn.innerHTML = "✅ Tersimpan";
                            setTimeout(() => {
                                btn.innerHTML = "💾 Simpan";
                                btn.disabled = false;
                            }, 1200);
                        } else {
                            throw new Error("Gagal menyimpan dokumen");
                        }
                    } catch (err) {
                        alert("❌ Gagal menyimpan dokumen.");
                        btn.innerHTML = "💾 Simpan";
                        btn.disabled = false;
                    }
                }
            });

            // ====== Tombol Hapus Dokumen ======
            document.addEventListener("click", async function(e) {
                if (e.target.classList.contains("btn-delete-doc")) {
                    e.preventDefault();
                    const btn = e.target;
                    const docId = btn.dataset.id;
                    const url = btn.dataset.url;
                    const parent = btn.closest(".doc-item");

                    if (!confirm("Yakin ingin menghapus dokumen ini?")) return;

                    btn.innerHTML = "🗑️ Menghapus...";
                    btn.disabled = true;

                    try {
                        const response = await fetch(url, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector(
                                    'meta[name="csrf-token"]').content
                            }
                        });

                        if (response.ok) {
                            parent.classList.add("animate__fadeOutDown");
                            setTimeout(() => parent.remove(), 400);
                        } else {
                            throw new Error("Gagal menghapus dokumen");
                        }
                    } catch (err) {
                        alert("❌ Gagal menghapus dokumen.");
                        btn.innerHTML = "🗑️ Hapus";
                        btn.disabled = false;
                    }
                }
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggleBtn = document.getElementById("toggleFilterBtn");
            const filterSection = document.getElementById("filterSection");
            const searchPO = document.getElementById("searchPO");
            const searchNama = document.getElementById("searchNama");
            const searchTanggal = document.getElementById("searchTanggal");

            // Semua item monitoring
            const monitorItems = document.querySelectorAll(".position-relative.border.rounded.p-3.mb-3.shadow-sm");

            // 🧠 Fungsi filter
            function filterMonitoring() {
                const poValue = searchPO.value.toLowerCase();
                const namaValue = searchNama.value.toLowerCase();
                const tanggalValue = searchTanggal.value;

                monitorItems.forEach(item => {
                    const poText = (item.querySelector("h5")?.textContent || "").toLowerCase();
                    const namaText = (item.querySelector("small:nth-of-type(2)")?.textContent || "")
                        .toLowerCase();
                    const tanggalText = (item.querySelector("small:nth-of-type(3)")?.textContent || "");

                    const matchPO = poText.includes(poValue);
                    const matchNama = namaText.includes(namaValue);
                    const matchTanggal = tanggalValue === "" || tanggalText.includes(tanggalValue);

                    item.style.display = (matchPO && matchNama && matchTanggal) ? "" : "none";
                });
            }

            // Jalankan filter ketika input berubah
            [searchPO, searchNama, searchTanggal].forEach(input => {
                input.addEventListener("input", filterMonitoring);
                input.addEventListener("change", filterMonitoring);
            });

            // 🔄 Toggle tampilan filter
            toggleBtn.addEventListener("click", () => {
                const isHidden = filterSection.classList.contains("d-none");
                if (isHidden) {
                    filterSection.classList.remove("d-none", "animate__fadeOutUp");
                    filterSection.classList.add("animate__fadeInDown");
                    toggleBtn.innerHTML = "❌ Sembunyikan Filter";
                } else {
                    filterSection.classList.add("animate__fadeOutUp");
                    setTimeout(() => filterSection.classList.add("d-none"), 400);
                    toggleBtn.innerHTML = "🔍 Lihat Filter";
                }
            });
        });
    </script>
@endsection
