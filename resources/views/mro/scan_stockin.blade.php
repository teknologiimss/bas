@extends('layouts.main')

@section('content')
    <div class="container mt-4">

        <h4>Stock In — {{ $item->mro_name }}</h4>

        <form action="{{ route('mro.stockin') }}" method="POST">
            @csrf

            <input type="hidden" name="barcode" value="{{ $item->barcode }}">

            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="0">

            <div class="mb-3">
                <label class="form-label">Proyek</label>
                <input type="text" name="proyek" class="form-control"
                    placeholder="Tulis yang lengkap!! : Cuci Kereta KRL KCI" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor SPP</label>
                <input type="text" name="spp" class="form-control"
                    placeholder="Wajib Mengisi nomor SPP/PR" required>
            </div>

            <button class="btn btn-primary mt-3">Tambah Stok</button>
        </form>
    </div>
@endsection
