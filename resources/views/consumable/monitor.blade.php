@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>{{ $folder->title }} ({{ $folder->year }})</h4>
            <div>
                <button class="btn btn-success" data-toggle="modal" data-target="#modalAddItem">
                    <i class="fas fa-plus"></i> Tambah Komponen Baru
                </button>
                <a href="{{ route('consumable.print', $folder->id) }}" target="_blank" class="btn btn-secondary">
                    <i class="fas fa-print"></i> Print / Cetak
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-sm text-center align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th rowspan="2" class="align-middle">NO</th>
                            <th rowspan="2" class="align-middle">KOMPONEN</th>
                            <th rowspan="2" class="align-middle">SPESIFIKASI</th>
                            <th colspan="12">BULAN</th>
                            <th rowspan="2" class="align-middle">TOTAL</th>
                            <th rowspan="2" class="align-middle">SAT</th>
                            <th rowspan="2" class="align-middle">KETERANGAN</th>
                            <th rowspan="2" class="align-middle">AKSI</th>
                        </tr>
                        <tr>
                            <th>JAN</th>
                            <th>FEB</th>
                            <th>MAR</th>
                            <th>APR</th>
                            <th>MEI</th>
                            <th>JUNI</th>
                            <th>JULI</th>
                            <th>AGUS</th>
                            <th>SEPT</th>
                            <th>OKT</th>
                            <th>NOV</th>
                            <th>DES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($groupedItems as $subHeader => $items)
                            <!-- Baris Sub Header -->
                            @php $subHeaderSlug = Str::slug($subHeader); @endphp
                            <tr class="font-weight-bold text-left bg-light">
                                <td colspan="18" class="pl-2">
                                    <strong>{{ strtoupper($subHeader) }}</strong>
                                </td>
                                <td class="text-center">
                                    <!-- Tombol Tambah Item Khusus Sub Header Ini -->
                                    <button class="btn btn-xs btn-primary" data-toggle="modal"
                                        data-target="#modalAddItem{{ $subHeaderSlug }}"
                                        title="Tambah Item ke {{ $subHeader }}">
                                        <i class="fas fa-plus"></i> Item
                                    </button>
                                </td>
                            </tr>

                            <!-- Item Dalam Sub Header -->
                            @foreach ($items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-left">{{ $item->komponen }}</td>
                                    <td class="text-left">{{ $item->spesifikasi }}</td>
                                    <td>{{ $item->jan ?: '' }}</td>
                                    <td>{{ $item->feb ?: '' }}</td>
                                    <td>{{ $item->mar ?: '' }}</td>
                                    <td>{{ $item->apr ?: '' }}</td>
                                    <td>{{ $item->mei ?: '' }}</td>
                                    <td>{{ $item->juni ?: '' }}</td>
                                    <td>{{ $item->juli ?: '' }}</td>
                                    <td>{{ $item->agus ?: '' }}</td>
                                    <td>{{ $item->sept ?: '' }}</td>
                                    <td>{{ $item->okt ?: '' }}</td>
                                    <td>{{ $item->nov ?: '' }}</td>
                                    <td>{{ $item->des ?: '' }}</td>
                                    <td><strong>{{ $item->total }}</strong></td>
                                    <td>{{ $item->satuan }}</td>
                                    <td class="text-left">{{ $item->keterangan }}</td>
                                    <td>
                                        <!-- Tombol Edit Item -->
                                        <button class="btn btn-xs btn-warning" data-toggle="modal"
                                            data-target="#modalEditItem{{ $item->id }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Tombol Hapus Item -->
                                        <form action="{{ route('consumable.item.destroy', $item->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus item ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-xs btn-danger" title="Hapus"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit Item -->
                                <div class="modal fade" id="modalEditItem{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg text-left">
                                        <form action="{{ route('consumable.item.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Item Komponen</h5>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                            <label>Sub Judul (Kategori)</label>
                                                            <input type="text" name="sub_header" class="form-control"
                                                                value="{{ $item->sub_header }}" required>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label>Komponen</label>
                                                            <input type="text" name="komponen" class="form-control"
                                                                value="{{ $item->komponen }}" required>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <label>Spesifikasi</label>
                                                            <input type="text" name="spesifikasi" class="form-control"
                                                                value="{{ $item->spesifikasi }}">
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label>Satuan</label>
                                                            <input type="text" name="satuan" class="form-control"
                                                                value="{{ $item->satuan }}" required>
                                                        </div>
                                                    </div>

                                                    <label><strong>Jumlah Alokasi per Bulan:</strong></label>
                                                    <div class="row">
                                                        @php $bulanList = ['jan', 'feb', 'mar', 'apr', 'mei', 'juni', 'juli', 'agus', 'sept', 'okt', 'nov', 'des']; @endphp
                                                        @foreach ($bulanList as $b)
                                                            <div class="col-md-2 form-group">
                                                                <label class="text-uppercase">{{ $b }}</label>
                                                                <input type="number" name="{{ $b }}"
                                                                    class="form-control" value="{{ $item->$b }}"
                                                                    min="0">
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Keterangan</label>
                                                        <textarea name="keterangan" class="form-control" rows="2">{{ $item->keterangan }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success">Simpan
                                                        Perubahan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Modal Tambah Item Khusus Sub Header Ini -->
                            <div class="modal fade" id="modalAddItem{{ $subHeaderSlug }}" tabindex="-1">
                                <div class="modal-dialog modal-lg text-left">
                                    <form action="{{ route('consumable.item.store', $folder->id) }}" method="POST">
                                        @csrf
                                        <!-- Input otomatis Sub Header terisi -->
                                        <input type="hidden" name="sub_header" value="{{ $subHeader }}">

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tambah Komponen ke
                                                    <strong>{{ strtoupper($subHeader) }}</strong></h5>
                                                <button type="button" class="close"
                                                    data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label>Komponen</label>
                                                        <input type="text" name="komponen" class="form-control"
                                                            placeholder="Misal: Bearing, Oil Seal" required>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label>Spesifikasi</label>
                                                        <input type="text" name="spesifikasi" class="form-control"
                                                            placeholder="Misal: Bearing 6311 C3 SKF">
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label>Satuan</label>
                                                        <input type="text" name="satuan" class="form-control"
                                                            placeholder="pcs, set, pack" required>
                                                    </div>
                                                </div>

                                                <label><strong>Jumlah Alokasi per Bulan:</strong></label>
                                                <div class="row">
                                                    @php $bulanList = ['jan', 'feb', 'mar', 'apr', 'mei', 'juni', 'juli', 'agus', 'sept', 'okt', 'nov', 'des']; @endphp
                                                    @foreach ($bulanList as $b)
                                                        <div class="col-md-2 form-group">
                                                            <label class="text-uppercase">{{ $b }}</label>
                                                            <input type="number" name="{{ $b }}"
                                                                class="form-control" value="0" min="0">
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Keterangan opsional / Tools"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan Item</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="19" class="text-center">Data masih kosong. Silakan tambah data komponen.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Item Komponen Umum / Sub Header Baru -->
    <div class="modal fade" id="modalAddItem" tabindex="-1">
        <div class="modal-dialog modal-lg text-left">
            <form action="{{ route('consumable.item.store', $folder->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Item Consumable Baru</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Sub Judul (Kategori)</label>
                                <input type="text" name="sub_header" class="form-control"
                                    placeholder="Misal: POMPA DISTRIBUSI, FCU" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Komponen</label>
                                <input type="text" name="komponen" class="form-control"
                                    placeholder="Misal: Bearing, Oil Seal" required>
                            </div>
                            <div class="col-md-8 form-group">
                                <label>Spesifikasi</label>
                                <input type="text" name="spesifikasi" class="form-control"
                                    placeholder="Misal: Bearing 6311 C3 SKF">
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Satuan</label>
                                <input type="text" name="satuan" class="form-control"
                                    placeholder="pcs, set, pack, unit" required>
                            </div>
                        </div>

                        <label><strong>Jumlah Alokasi per Bulan:</strong></label>
                        <div class="row">
                            @php $bulanList = ['jan', 'feb', 'mar', 'apr', 'mei', 'juni', 'juli', 'agus', 'sept', 'okt', 'nov', 'des']; @endphp
                            @foreach ($bulanList as $b)
                                <div class="col-md-2 form-group">
                                    <label class="text-uppercase">{{ $b }}</label>
                                    <input type="number" name="{{ $b }}" class="form-control"
                                        value="0" min="0">
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Keterangan opsional / Tools"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Item</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
