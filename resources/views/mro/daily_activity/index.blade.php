@extends('layouts.main')
@section('title', 'Daily Activity')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')

    <style>
        .card-primary-custom {
            border-top: 4px solid #0b3d91;
        }

        .card-header-custom {
            background: #0b3d91;
            color: white;
        }

        .btn-navy {
            background: #0b3d91;
            color: #fff;
            border: none;
        }

        .btn-navy:hover {
            background: #062b66;
            color: #fff;
        }

        .table thead {
            background: #0b3d91;
            color: white;
        }

        .table tbody tr:hover {
            background: #eef5ff;
        }

        .badge-open {
            background: #198754;
            color: #fff;
        }

        .badge-close {
            background: #dc3545;
            color: #fff;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Desain Modern untuk Alert / Notifikasi */
        .alert-custom {
            border: none;
            border-radius: 10px;
            padding: 14px 20px;
            color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .alert-success-custom {
            background: linear-gradient(135deg, #28a745, #1e7e34);
        }

        .alert-danger-custom {
            background: linear-gradient(135deg, #dc3545, #bd2130);
        }

        .alert-custom .close {
            opacity: 0.8;
            text-shadow: none;
            outline: none;
        }

        .alert-custom .close:hover {
            opacity: 1;
        }
    </style>

    <div class="container-fluid">

        <!-- Notifikasi Modern (Auto-close 3 Detik) -->
        @if (session('success'))
            <div id="custom-alert" class="alert alert-custom alert-success-custom shadow-sm fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fa fa-check-circle fa-lg mr-2"></i>
                    <div><strong>Berhasil!</strong> {{ session('success') }}</div>
                </div>
                <button type="button" class="close text-white" onclick="closeAlert()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div id="custom-alert" class="alert alert-custom alert-danger-custom shadow-sm fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fa fa-exclamation-circle fa-lg mr-2"></i>
                    <div><strong>Gagal!</strong> {{ session('error') }}</div>
                </div>
                <button type="button" class="close text-white" onclick="closeAlert()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card card-primary-custom">

            <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    Daily Activity
                </h4>
                <div>
                    <!-- Tombol Hapus Terpilih -->
                    <button type="button" id="btn-bulk-delete" class="btn btn-danger mr-2" style="display: none;">
                        <i class="fa fa-trash"></i> Hapus Terpilih (<span id="count-selected">0</span>)
                    </button>

                    <a href="{{ route('mro.daily-activity.create') }}" class="btn btn-light">
                        <i class="fa fa-plus"></i> Tambah
                    </a>
                </div>
            </div>

            <div class="card-body">

                <!-- Form Pencarian (Search by Proyek & Kegiatan) -->
                <form action="{{ route('mro.daily-activity.index') }}" method="GET" class="mb-3">
                    <div class="input-group" style="max-width: 400px;">
                        <input type="text" name="search" class="form-control" placeholder="Cari Proyek atau Kegiatan..."
                            value="{{ $search ?? '' }}">
                        <div class="input-group-append">
                            <button class="btn btn-navy" type="submit">
                                <i class="fa fa-search"></i> Cari
                            </button>
                            @if (isset($search) && $search != '')
                                <a href="{{ route('mro.daily-activity.index') }}" class="btn btn-secondary"
                                    title="Reset Pencarian">
                                    <i class="fa fa-sync"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

                <!-- Form Terpisah khusus untuk Bulk Delete -->
                <form id="form-bulk-delete" action="{{ route('mro.daily-activity.bulk-delete') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div id="bulk-inputs"></div>
                </form>

                <!-- Tabel Data -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="text-center">
                            <tr>
                                <th width="40">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th width="50">No</th>
                                <th>Proyek</th>
                                <th>Kegiatan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Personil</th>
                                <th>Lampiran</th>
                                <th width="140">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($data as $d)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" value="{{ $d->id }}" class="checkbox-item">
                                    </td>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        @if ($d->monitoring)
                                            <strong>{{ $d->monitoring->po_nota_dinas }}</strong>
                                            <br>
                                            {{ $d->monitoring->nama_pekerjaan }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @foreach (preg_split("/\r\n|\n|\r/", trim($d->kegiatan)) as $item)
                                            @if (trim($item) != '')
                                                <div>{{ trim($item) }}</div>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        @if ($d->status == 'Open')
                                            <span class="badge badge-open">Open</span>
                                        @else
                                            <span class="badge badge-close">Closed</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ date('d-m-Y', strtotime($d->tanggal)) }}
                                    </td>
                                    <td>
                                        @foreach (preg_split("/\r\n|\n|\r/", trim($d->keterangan)) as $item)
                                            @if (trim($item) != '')
                                                <div>{{ trim($item) }}</div>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($d->personil ?? [] as $nama)
                                            <span class="badge badge-primary mb-1">{{ $nama }}</span>
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @forelse($d->attachments as $file)
                                            <a href="{{ asset('uploads/daily_activity/' . $file->file) }}" target="_blank"
                                                class="btn btn-sm btn-info mb-1">
                                                <i class="fa fa-file"></i> Lihat File
                                            </a>
                                            <br>
                                        @empty
                                            <span class="text-muted">Tidak ada lampiran</span>
                                        @endforelse
                                    </td>
                                    <td class="text-center">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('mro.daily-activity.edit', $d->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <!-- Tombol Hapus Satuan -->
                                        <form action="{{ route('mro.daily-activity.destroy', $d->id) }}" method="POST"
                                            style="display:inline-block"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">
                                        Data tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>

    <!-- Script JavaScript -->
    <script>
        // Fungsi manual untuk menutup alert
        function closeAlert() {
            const alertBox = document.getElementById('custom-alert');
            if (alertBox) {
                alertBox.style.opacity = '0';
                alertBox.style.transform = 'translateY(-10px)';
                setTimeout(() => alertBox.remove(), 500);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Otomatis menghilangkan alert setelah 3 detik
            const alertBox = document.getElementById('custom-alert');
            if (alertBox) {
                setTimeout(() => {
                    alertBox.style.opacity = '0';
                    alertBox.style.transform = 'translateY(-10px)';
                    setTimeout(() => alertBox.remove(), 500);
                }, 3000);
            }

            // Logika Checkbox & Bulk Delete
            const selectAllCheckbox = document.getElementById('select-all');
            const itemCheckboxes = document.querySelectorAll('.checkbox-item');
            const btnBulkDelete = document.getElementById('btn-bulk-delete');
            const countSelectedSpan = document.getElementById('count-selected');
            const formBulkDelete = document.getElementById('form-bulk-delete');
            const bulkInputsContainer = document.getElementById('bulk-inputs');

            function updateBulkDeleteButton() {
                const checkedCount = document.querySelectorAll('.checkbox-item:checked').length;
                countSelectedSpan.textContent = checkedCount;
                if (checkedCount > 0) {
                    btnBulkDelete.style.display = 'inline-block';
                } else {
                    btnBulkDelete.style.display = 'none';
                }
            }

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    itemCheckboxes.forEach(checkbox => {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                    updateBulkDeleteButton();
                });
            }

            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateBulkDeleteButton();
                    if (!this.checked) {
                        selectAllCheckbox.checked = false;
                    } else if (document.querySelectorAll('.checkbox-item:checked').length ===
                        itemCheckboxes.length) {
                        selectAllCheckbox.checked = true;
                    }
                });
            });

            if (btnBulkDelete) {
                btnBulkDelete.addEventListener('click', function() {
                    const checkedCheckboxes = document.querySelectorAll('.checkbox-item:checked');
                    if (checkedCheckboxes.length === 0) {
                        alert('Pilih minimal satu data yang ingin dihapus.');
                        return;
                    }

                    if (confirm('Yakin ingin menghapus ' + checkedCheckboxes.length +
                            ' data yang dicentang?')) {
                        // Masukkan ID yang dicentang ke dalam form tersembunyi secara dinamis
                        bulkInputsContainer.innerHTML = '';
                        checkedCheckboxes.forEach(cb => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'ids[]';
                            input.value = cb.value;
                            bulkInputsContainer.appendChild(input);
                        });

                        formBulkDelete.submit();
                    }
                });
            }
        });
    </script>

@endsection
