@extends('layouts.main')

@section('title', 'Print Barcode MRO')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Print Barcode MRO</h4>
    </div>

    <div class="card-body">
        <form method="GET" target="_blank" onsubmit="window.print()">
            <div class="row">
                @foreach($mro as $item)
                    <div class="col-3 text-center border p-2 mb-3">
                        <svg id="barcode-{{ $item->mro_id }}"></svg>
                        <div class="fw-bold mt-1">{{ $item->mro_code }}</div>
                        <div>{{ $item->mro_name }}</div>
                    </div>
                @endforeach
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

<script>
    @foreach($mro as $item)
        JsBarcode("#barcode-{{ $item->mro_id }}", "{{ $item->barcode }}", {
            format: "CODE128",
            displayValue: true,
            height: 40
        });
    @endforeach
</script>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .card-body, .card-body * {
            visibility: visible;
        }
        .col-3 {
            page-break-inside: avoid;
        }
    }
</style>
@endsection
