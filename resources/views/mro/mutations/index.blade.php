@extends('layouts.main')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')
    <style>
        :root {
            --navy-dark: #0f172a;
            --navy-main: #1e293b;
            --navy-light: #334155;
            --accent-blue: #2563eb;
            --accent-hover: #1d4ed8;
        }

        .bg-navy-main {
            background-color: var(--navy-main) !important;
        }

        .text-navy-dark {
            color: var(--navy-dark) !important;
        }

        .card-modern {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .badge-soft-success {
            background-color: #dcfce7;
            color: #15803d;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .badge-soft-warning {
            background-color: #fef9c3;
            color: #a16207;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .badge-soft-navy {
            background-color: #e2e8f0;
            color: #1e293b;
            font-weight: 600;
            font-size: 1rem;
        }

        .table-modern thead th {
            background-color: var(--navy-main);
            color: #f8fafc;
            border: none;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
            padding: 16px 14px;
        }

        .table-modern tbody td {
            vertical-align: middle !important;
            border-color: #f1f5f9;
            font-size: 1.05rem;
            padding: 14px 12px;
        }

        .btn-action {
            width: 38px;
            height: 38px;
            padding: 0;
            font-size: 1rem;
            line-height: 38px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .form-control,
        .custom-select {
            font-size: 1rem !important;
            height: auto;
            padding: 10px 14px;
        }
    </style>

    <div class="container-fluid p-2 p-md-4">

        {{-- Alert Notification --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-lg mb-3 font-weight-bold"
                style="font-size: 1.05rem;">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-lg mb-3 font-weight-bold"
                style="font-size: 1.05rem;">
                <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
            </div>
        @endif

        {{-- Header Bar --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
            <div>
                <h3 class="font-weight-bold text-navy-dark page-header-title m-0" style="font-size: 1.75rem;">
                    <i class="fas fa-exchange-alt mr-2 text-primary"></i>Mutasi & Peminjaman Tools
                </h3>
                <span class="text-muted" style="font-size: 1.05rem;">Catat riwayat pinjam dan kembalikan peralatan
                    MRO</span>
            </div>

            <div class="mt-3 mt-md-0 d-flex gap-2">
                <a href="{{ route('mro.tools.index') }}"
                    class="btn btn-outline-secondary font-weight-bold px-3 py-2.5 rounded-lg mr-2">
                    <i class="fas fa-boxes mr-1"></i> Data Master Tools
                </a>
                <button type="button" class="btn btn-primary shadow-sm font-weight-bold px-4 py-2.5 rounded-lg"
                    data-toggle="modal" data-target="#modalTambahPinjam"
                    style="background-color: var(--accent-blue); border: none; font-size: 1.05rem;">
                    <i class="fas fa-hand-holding mr-2"></i> Tambah Peminjaman
                </button>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="card card-modern shadow-sm">

            {{-- Filter & Search Bar --}}
            <div class="card-header bg-navy-main p-3 border-0">
                <form action="{{ route('mro.mutations.index') }}" method="GET">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6 col-lg-4 mb-2 mb-md-0">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control border-0 rounded-left"
                                    placeholder="Cari peminjam atau nama tools..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary px-3 rounded-right" type="submit"
                                        style="background-color: var(--accent-blue); border: none;">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-8 d-flex justify-content-md-end align-items-center">
                            <label class="text-white mr-2 mb-0 font-weight-bold">Status:</label>
                            <select name="status" class="form-control rounded-lg border-0 bg-white w-auto"
                                onchange="this.form.submit()">
                                <option value="">-- Semua Status --</option>
                                <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam
                                </option>
                                <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>
                                    Dikembalikan</option>
                            </select>
                            @if (request('search') || request('status'))
                                <a href="{{ route('mro.mutations.index') }}"
                                    class="btn btn-light btn-sm ml-2 font-weight-bold">Reset</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-modern w-100 m-0">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">NO.</th>
                                <th>NAMA PEMINJAM</th>
                                <th>NAMA TOOLS</th>
                                <th>SPESIFIKASI</th>
                                <th class="text-center">QTY PINJAM</th>
                                <th class="text-center">TGL PINJAM</th>
                                <th class="text-center">TGL KEMBALI</th>
                                <th class="text-center">STATUS</th>
                                <th>KETERANGAN</th>
                                <th class="text-center" width="12%">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mutations as $index => $item)
                                <tr>
                                    <td class="text-center text-muted font-weight-bold">
                                        {{ $mutations->firstItem() + $index }}</td>
                                    <td class="font-weight-bold text-dark">{{ $item->nama_peminjam }}</td>
                                    <td class="text-primary font-weight-bold">
                                        {{ $item->tool->nama_tools ?? 'Tools Dihapus' }}</td>
                                    <td><span class="text-dark">{{ $item->tool->spesifikasi ?? '-' }}</span></td>
                                    <td class="text-center">
                                        <span class="badge badge-soft-navy px-3 py-1.5 rounded-pill">
                                            {{ $item->qty_pinjam }} {{ $item->tool->satuan ?? '' }}
                                        </span>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') }}</td>
                                    <td class="text-center text-nowrap">
                                        {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') : '-' }}
                                    </td>
                                    <td class="text-center">
                                        @if ($item->status == 'Dipinjam')
                                            <span class="badge badge-soft-warning px-3 py-1.5 rounded-pill"><i
                                                    class="fas fa-clock mr-1"></i> Dipinjam</span>
                                        @else
                                            <span class="badge badge-soft-success px-3 py-1.5 rounded-pill"><i
                                                    class="fas fa-check-circle mr-1"></i> Dikembalikan</span>
                                        @endif
                                    </td>
                                    <td><span class="text-dark">{{ Str::limit($item->keterangan ?? '-', 30) }}</span></td>
                                    <td class="text-center text-nowrap">
                                        @if ($item->status == 'Dipinjam')
                                            <button type="button"
                                                class="btn btn-action btn-soft-success text-success bg-light mr-1"
                                                data-toggle="modal" data-target="#modalKembali{{ $item->id }}"
                                                title="Proses Pengembalian">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        @endif

                                        <form action="{{ route('mro.mutations.destroy', $item->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus riwayat mutasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-action btn-soft-danger text-danger bg-light" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                {{-- Modal Pengembalian --}}
                                @if ($item->status == 'Dipinjam')
                                    <div class="modal fade" id="modalKembali{{ $item->id }}" tabindex="-1"
                                        role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content border-0 shadow-lg rounded-lg">
                                                <div class="modal-header bg-navy-main text-white">
                                                    <h5 class="modal-title font-weight-bold"><i
                                                            class="fas fa-undo mr-2"></i>Pengembalian Tools</h5>
                                                    <button type="button" class="close text-white"
                                                        data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <form action="{{ route('mro.mutations.return', $item->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body p-4">
                                                        <p class="mb-2"><strong>Peminjam:</strong>
                                                            {{ $item->nama_peminjam }}</p>
                                                        <p class="mb-2"><strong>Tools:</strong>
                                                            {{ $item->tool->nama_tools ?? '-' }}</p>
                                                        <p class="mb-3"><strong>Jumlah Dipinjam:</strong>
                                                            {{ $item->qty_pinjam }} {{ $item->tool->satuan ?? '' }}</p>

                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Tanggal Pengembalian <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="date" name="tanggal_kembali"
                                                                class="form-control rounded-lg"
                                                                value="{{ date('Y-m-d') }}"
                                                                min="{{ $item->tanggal_pinjam }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary rounded-lg"
                                                            data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-success rounded-lg px-4"><i
                                                                class="fas fa-check mr-1"></i> Konfirmasi
                                                            Kembalikan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-5">
                                        <i class="fas fa-exchange-alt fa-3x mb-3 text-secondary d-block"></i>
                                        Belum ada riwayat mutasi / peminjaman tools.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($mutations->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-end">
                        {{ $mutations->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Tambah Peminjaman -->
    <div class="modal fade" id="modalTambahPinjam" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg rounded-lg">
                <div class="modal-header bg-navy-main text-white">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-hand-holding mr-2"></i>Tambah Form
                        Peminjaman Tools</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form action="{{ route('mro.mutations.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="font-weight-bold">Pilih Tools <span class="text-danger">*</span></label>
                                <select name="mro_tool_id" id="select_tool" class="form-control rounded-lg" required>
                                    <option value="">-- Pilih Tools --</option>
                                    @foreach ($tools as $tool)
                                        <option value="{{ $tool->id }}"
                                            data-spesifikasi="{{ $tool->spesifikasi ?? '-' }}"
                                            data-stok="{{ $tool->qty }}" data-satuan="{{ $tool->satuan }}">
                                            {{ $tool->nama_tools }} (Tersedia: {{ $tool->qty }} {{ $tool->satuan }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <label class="font-weight-bold">Spesifikasi Tools</label>
                                <input type="text" id="info_spesifikasi" class="form-control rounded-lg bg-light"
                                    readonly placeholder="Pilih tools terlebih dahulu">
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Nama Peminjam <span class="text-danger">*</span></label>
                                <input type="text" name="nama_peminjam" class="form-control rounded-lg"
                                    placeholder="Masukkan nama peminjam..." required autocomplete="off">
                            </div>

                            <div class="col-md-3 form-group">
                                <label class="font-weight-bold">Qty Pinjam <span class="text-danger">*</span></label>
                                <input type="number" name="qty_pinjam" id="input_qty" class="form-control rounded-lg"
                                    value="1" min="1" required>
                            </div>

                            <div class="col-md-3 form-group">
                                <label class="font-weight-bold">Tanggal Pinjam <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_pinjam" class="form-control rounded-lg"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-12 form-group mb-0">
                                <label class="font-weight-bold">Keterangan / Keperluan</label>
                                <textarea name="keterangan" class="form-control rounded-lg" rows="2"
                                    placeholder="Contoh: Untuk keperluan maintenance mesin A"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary rounded-lg" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-lg px-4"
                            style="background-color: var(--accent-blue);">Simpan Peminjaman</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#select_tool').on('change', function() {
            var selected = $(this).find(':selected');
            var spesifikasi = selected.data('spesifikasi');
            var stok = selected.data('stok');

            if (selected.val()) {
                $('#info_spesifikasi').val(spesifikasi);
                $('#input_qty').attr('max', stok);
            } else {
                $('#info_spesifikasi').val('');
                $('#input_qty').removeAttr('max');
            }
        });
    });
</script>
