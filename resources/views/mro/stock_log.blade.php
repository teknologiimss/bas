@extends('layouts.main')
@section('title', 'Mutasi Stok MRO')

<style>
    /* Table wrapper */
    .table-modern {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.15);
        background: #fff;
    }

    /* Header */
    .table-modern thead {
        background: linear-gradient(135deg, #dc3545, #b02a37);
        color: #fff;
    }

    .table-modern thead th {
        border: none;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Body */
    .table-modern tbody tr {
        transition: all 0.2s ease;
    }

    .table-modern tbody tr:hover {
        background-color: #fff5f5;
    }

    .table-modern tbody td {
        vertical-align: middle;
        border-color: #f1f1f1;
        font-size: 13px;
    }

    /* Checkbox */
    .table-modern input[type="checkbox"] {
        transform: scale(1.1);
        accent-color: #dc3545;
        cursor: pointer;
    }

    /* Badge */
    .badge-modern-in {
        background: #198754;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
    }

    .badge-modern-out {
        background: #dc3545;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
    }

    /* Proyek multi-line */
    .proyek-cell {
        white-space: pre-line;
        font-weight: 500;
    }
</style>


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
                                <button class="btn btn-danger w-100">
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

                        <a href="{{ route('mro.stocklog.print', request()->query()) }}" target="_blank"
                            class="btn btn-outline-danger mb-3 ml-2">
                            <i class="fas fa-print"></i> Print
                        </a>


                        {{-- RESPONSIVE TABLE --}}
                        <div class="table-responsive table-modern">
                            <table class="table table-bordered table-hover table-xl text-nowrap small">
                                <thead class="table-light">
                                    <tr class="text-center align-middle">
                                        <th style="width:40px">
                                            <input type="checkbox" id="checkAll">
                                        </th>
                                        <th>Tanggal</th>
                                        <th>Kode Material</th>
                                        <th>Nama Barang</th>
                                        <th>Tipe</th>
                                        <th>Qty</th>
                                        <th>Stok Sebelum</th>
                                        <th>Stok Sesudah</th>
                                        <th>Proyek</th>
                                        <th>No.SPP/PR</th>
                                        <th>Akun</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($logs as $log)
                                        <tr class="align-middle">
                                            <td class="text-center">
                                                <input type="checkbox" name="ids[]" value="{{ $log->id }}"
                                                    class="checkItem">
                                            </td>

                                            {{-- <td>{{ $log->created_at }}</td> --}}
                                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>

                                            <td>{{ $log->barcode }}</td>
                                            <td>{{ $log->mro->mro_name ?? '-' }}</td>

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
                                            <td class="text-center">{{ $log->proyek ?? '-' }}</td>
                                            <td class="text-center">{{ $log->spp ?? '-' }}</td>
                                            <td>{{ $log->user }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

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
