@extends('layouts.main')
@section('title', 'Laporan Harian Fasilitas & Jasa Lainnya')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')
    @if (session('success') || session('error'))
        @php
            $isError = session()->has('error');
            $notifMessage = $isError ? session('error') : session('success');
        @endphp
        <div id="laporan-toast-wrapper"
            style="position: fixed; top: 20px; right: 20px; z-index: 99999; max-width: 360px; width: calc(100% - 40px); opacity: 0; transform: translateY(-12px); transition: opacity 0.25s ease, transform 0.25s ease;">
            <div id="laporan-toast-box"
                style="display: flex; align-items: center; gap: 12px; background: #0a1f3d; color: #ffffff; border-radius: 10px; padding: 12px 14px; box-shadow: 0 10px 25px rgba(10, 31, 61, 0.28); border-left: 4px solid {{ $isError ? '#ef4444' : '#22c55e' }};">
                <div
                    style="width: 32px; height: 32px; min-width: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; background: {{ $isError ? 'rgba(239, 68, 68, 0.18)' : 'rgba(34, 197, 94, 0.18)' }}; color: {{ $isError ? '#f87171' : '#4ade80' }}; font-size: 15px;">
                    <i class="fas {{ $isError ? 'fa-exclamation-triangle' : 'fa-check' }}"
                        style="font-size: 15px; line-height: 1;"></i>
                </div>
                <div style="flex: 1; min-width: 0; line-height: 1.35;">
                    <div style="font-size: 13px; font-weight: 700; color: #ffffff; margin-bottom: 2px;">
                        {{ $isError ? 'Gagal' : 'Berhasil' }}
                    </div>
                    <div style="font-size: 12.5px; color: #dbeafe; word-break: break-word;">
                        {{ $notifMessage }}
                    </div>
                </div>
                <button type="button" id="btn-close-laporan-toast" aria-label="Tutup"
                    style="background: transparent; border: none; color: #94a3b8; font-size: 18px; line-height: 1; padding: 2px 4px; cursor: pointer; flex-shrink: 0;">
                    &times;
                </button>
            </div>
        </div>
    @endif

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Rekap Laporan Harian Fasilitas</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('laporan-fasilitas.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-1"></i> Buat Laporan Harian
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('laporan-fasilitas.bulk-delete') }}" method="POST" id="bulk-delete-form"
                onsubmit="return confirmBulkDelete()">
                @csrf
                @method('DELETE')
            </form>

            <div class="card card-navy card-outline">
                <div class="card-header">
                    <div class="d-flex flex-wrap justify-content-between align-items-center" style="gap: 8px;">
                        <form method="GET" action="{{ route('laporan-fasilitas.index') }}" class="form-inline mb-0"
                            id="filter-bulan-form">
                            <label for="filter-bulan-input" class="mr-2">Filter Bulan:</label>
                            <input type="text" id="filter-bulan-input" name="bulan" value="{{ request('bulan') }}"
                                placeholder="Contoh: desember atau 2026-12" class="form-control form-control-sm mr-2"
                                style="width: 210px;">
                            <button type="submit" id="btn-filter-bulan"
                                class="btn btn-sm btn-secondary mr-1">Filter</button>
                            @if (request('bulan'))
                                <a href="{{ route('laporan-fasilitas.index') }}"
                                    class="btn btn-sm btn-outline-secondary">Reset</a>
                            @endif
                        </form>

                        <div>
                            <button type="submit" form="bulk-delete-form" id="btn-bulk-delete"
                                class="btn btn-sm btn-danger" disabled>
                                <i class="fas fa-trash-alt mr-1"></i> Hapus Terpilih (<span id="selected-count">0</span>)
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-bordered text-nowrap">
                        <thead class="bg-navy text-white">
                            <tr>
                                <th width="4%" class="text-center">
                                    <input type="checkbox" id="check-all-laporan" title="Pilih Semua">
                                </th>
                                <th width="5%">No</th>
                                <th width="21%">Hari / Tanggal</th>
                                <th>Judul Laporan</th>
                                <th width="14%" class="text-center">Item Pekerjaan</th>
                                <th width="12%" class="text-center">Jumlah Tim</th>
                                <th width="23%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporans as $index => $row)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" name="ids[]" value="{{ $row->id }}"
                                            form="bulk-delete-form" class="laporan-checkbox">
                                    </td>
                                    <td>{{ $laporans->firstItem() + $index }}</td>
                                    <td><strong>{{ $row->tanggal_indo }}</strong></td>
                                    <td>{{ $row->judul }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-info">{{ $row->items->count() }} Item</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-success">{{ $row->teams->count() }} Personil</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('laporan-fasilitas.show', $row->id) }}"
                                            class="btn btn-xs btn-info" title="Lihat & Salin WA">
                                            <i class="fas fa-eye"></i> Detail / WA
                                        </a>
                                        <form action="{{ route('laporan-fasilitas.duplicate', $row->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Duplikasi laporan tanggal {{ $row->tanggal_indo }}?')">
                                            @csrf
                                            <button type="submit" class="btn btn-xs btn-secondary"
                                                title="Duplicate Laporan">
                                                <i class="fas fa-copy"></i> Duplicate
                                            </button>
                                        </form>
                                        <a href="{{ route('laporan-fasilitas.edit', $row->id) }}"
                                            class="btn btn-xs btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('laporan-fasilitas.destroy', $row->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Hapus laporan tanggal {{ $row->tanggal_indo }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Belum ada data laporan harian
                                        fasilitas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $laporans->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </section>

    <script>
        function confirmBulkDelete() {
            const checked = document.querySelectorAll('.laporan-checkbox:checked');
            if (checked.length === 0) {
                alert('Pilih minimal satu laporan terlebih dahulu.');
                return false;
            }
            return confirm('Yakin ingin menghapus ' + checked.length + ' laporan harian terpilih?');
        }

        (function() {
            const filterForm = document.getElementById('filter-bulan-form');
            const filterInput = document.getElementById('filter-bulan-input');
            const btnFilter = document.getElementById('btn-filter-bulan');
            const baseIndexUrl = @json(route('laporan-fasilitas.index'));

            function applyMonthFilter(e) {
                if (e) e.preventDefault();
                const val = filterInput ? filterInput.value.trim() : '';
                if (val) {
                    window.location.href = baseIndexUrl + '?bulan=' + encodeURIComponent(val);
                } else {
                    window.location.href = baseIndexUrl;
                }
            }

            if (filterForm) {
                filterForm.addEventListener('submit', applyMonthFilter);
            }
            if (btnFilter) {
                btnFilter.addEventListener('click', applyMonthFilter);
            }

            const wrapper = document.getElementById('laporan-toast-wrapper');
            const closeBtn = document.getElementById('btn-close-laporan-toast');
            if (wrapper) {
                requestAnimationFrame(() => {
                    wrapper.style.opacity = '1';
                    wrapper.style.transform = 'translateY(0)';
                });

                let isClosed = false;
                const closeToast = () => {
                    if (isClosed) return;
                    isClosed = true;
                    wrapper.style.opacity = '0';
                    wrapper.style.transform = 'translateY(-12px)';
                    setTimeout(() => {
                        if (wrapper && wrapper.parentNode) {
                            wrapper.parentNode.removeChild(wrapper);
                        }
                    }, 250);
                };

                if (closeBtn) {
                    closeBtn.addEventListener('click', closeToast);
                }

                setTimeout(closeToast, 3000);
            }

            const checkAll = document.getElementById('check-all-laporan');
            const checkboxes = Array.from(document.querySelectorAll('.laporan-checkbox'));
            const btnBulkDelete = document.getElementById('btn-bulk-delete');
            const selectedCountEl = document.getElementById('selected-count');

            function syncBulkToolbar() {
                const checkedCount = checkboxes.filter(cb => cb.checked).length;
                if (selectedCountEl) {
                    selectedCountEl.textContent = checkedCount;
                }
                if (btnBulkDelete) {
                    btnBulkDelete.disabled = checkedCount === 0;
                }
                if (checkAll) {
                    checkAll.checked = checkboxes.length > 0 && checkedCount === checkboxes.length;
                    checkAll.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
                }
            }

            if (checkAll) {
                checkAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => {
                        cb.checked = checkAll.checked;
                    });
                    syncBulkToolbar();
                });
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', syncBulkToolbar);
            });

            syncBulkToolbar();
        })();
    </script>
@endsection
