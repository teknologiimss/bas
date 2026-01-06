@extends('layouts.main')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <h4>Stock Out — {{ $item->mro_name }}</h4>

        <form action="{{ route('mro.stockout') }}" method="POST">
            @csrf

            <input type="hidden" name="barcode" value="{{ $item->barcode }}">

            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="0">

            <button class="btn btn-danger mt-3">Kurangi Stok</button>
        </form>
    </div>
@endsection
