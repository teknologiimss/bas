@extends('layouts.main')

@section('content')
<div class="container mt-4 text-center">
    <h4>{{ $item->mro_name }}</h4>
    <p>{{ $item->spesifikasi }}</p>

    <a href="{{ route('mro.scan.stockin', $item->barcode) }}"
       class="btn btn-success btn-lg">
        ➕ Stok Masuk
    </a>

    <a href="{{ route('mro.scan.stockout', $item->barcode) }}"
       class="btn btn-danger btn-lg ml-2">
        ➖ Stok Keluar
    </a>
</div>
@endsection
