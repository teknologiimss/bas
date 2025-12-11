@extends('layouts.main')
@section('title', 'Mutasi Stok MRO')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <h4>Monitoring Mutasi Stok Barang MRO</h4>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-body">

                    {{-- Filter --}}
                    <form method="GET" action="{{ route('mro.stock.log') }}" class="mb-4">

                        <div class="row">

                            <div class="col-md-3">
                                <label>Kode Material</label>
                                <input type="text" name="kode" class="form-control" value="{{ request('kode') }}"
                                    placeholder="Cari kode material...">
                            </div>

                            <div class="col-md-3">
                                <label>Nama Barang</label>
                                <input type="text" name="nama" class="form-control" value="{{ request('nama') }}"
                                    placeholder="Cari nama barang...">
                            </div>

                            <div class="col-md-3">
                                <label>Proyek</label>
                                <input type="text" name="proyek" class="form-control" value="{{ request('proyek') }}"
                                    placeholder="Cari proyek...">
                            </div>

                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                            </div>

                        </div>

                    </form>


                    <form action="{{ route('mro.stocklog.deleteMultiple') }}" method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger mb-3"
                            onclick="return confirm('Hapus semua data terpilih?')">
                            <i class="fas fa-trash"></i> Hapus Terpilih
                        </button>

                        <table class="table table-bordered table-hover table-sm">
                            <thead>
                                <tr class="text-center">
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>Tanggal</th>
                                    <th>Kode Material</th>
                                    <th>Nama Barang</th>
                                    <th>Tipe</th>
                                    <th>Qty</th>
                                    <th>Stok Sebelum</th>
                                    <th>Stok Sesudah</th>
                                    <th>Proyek</th>
                                    <th>Akun</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="ids[]" value="{{ $log->id }}"
                                                class="checkItem">
                                        </td>
                                        <td>{{ $log->created_at }}</td>
                                        <td>{{ $log->barcode }}</td>
                                        <td>{{ $log->mro->mro_name }}</td>
                                        <td class="text-center">
                                            @if ($log->type == 'IN')
                                                <span class="badge bg-success">IN</span>
                                            @else
                                                <span class="badge bg-danger">OUT</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $log->qty }}</td>
                                        <td class="text-center">{{ $log->stock_before }}</td>
                                        <td class="text-center">{{ $log->stock_after }}</td>
                                        <td class="text-center">{{ $log->mro->proyek }}</td>
                                        <td>{{ $log->user }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $logs->links('pagination::bootstrap-4') }}
                    </form>


                </div>
            </div>

        </div>
    </section>
@endsection

@section('custom-js')
    <script>
        // Check uncheck all
        document.getElementById('checkAll').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.checkItem');
            checkboxes.forEach(ch => ch.checked = this.checked);
        });
    </script>

@endsection
