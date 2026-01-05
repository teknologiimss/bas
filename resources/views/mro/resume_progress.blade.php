@extends('layouts.main')

@section('title', 'Progress MRO')

@section('content')

    <style>
        /* ================= PRINT STYLE ================= */
        @media print {

            /* Paksa warna tetap muncul */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Sembunyikan elemen yang tidak perlu */
            .no-print,
            .modal,
            .pagination {
                display: none !important;
            }

            body {
                font-size: 12px;
            }

            table {
                width: 100% !important;
                border-collapse: collapse !important;
            }

            th,
            td {
                border: 1px solid #000 !important;
                padding: 6px !important;
                vertical-align: top;
            }

            thead {
                display: table-header-group;
            }

            tr {
                page-break-inside: avoid;
            }

            @page {
                size: A4 landscape;
                margin: 10mm;
            }
        }
    </style>

    <div class="container-fluid mt-4">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3><b>Progress MRO</b></h3>

            {{-- TOMBOL PRINT --}}
            <a href="{{ route('mro.progress.print') }}" target="_blank" class="btn btn-primary no-print">
                🖨 Print Semua
            </a>

        </div>

        {{-- FLASH MESSAGE --}}
        @if (session('success'))
            <div class="alert alert-success no-print">
                {{ session('success') }}
            </div>
        @endif

        {{-- TABLE --}}
        <div class="card shadow-sm">
            <div class="card-body table-responsive">

                <table class="table table-bordered table-hover table-striped">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th width="50">No</th>
                            <th>PO / Nota Dinas</th>
                            <th>Nama Pekerjaan</th>
                            <th>Tanggal Kontrak</th>
                            <th>Selesai Kontrak</th>
                            <th>Status</th>
                            <th width="180">Progress</th>
                            <th>Keterangan Progress</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($monitorings as $index => $m)
                            @php
                                $statusClass = match ($m->status) {
                                    'Open' => 'badge badge-warning',
                                    'Closed' => 'badge badge-success',
                                    'On Hold' => 'badge badge-danger',
                                    default => 'badge badge-secondary',
                                };
                            @endphp

                            <tr>
                                <td class="text-center">
                                    {{ $monitorings->firstItem() + $index }}
                                </td>

                                <td>{{ $m->po_nota_dinas }}</td>
                                <td>{{ $m->nama_pekerjaan }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($m->tanggal_kontrak)->format('d-m-Y') }}
                                </td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($m->tanggal_selesai_kontrak)->format('d-m-Y') }}
                                </td>
                                <td class="text-center">
                                    <span class="{{ $statusClass }}">
                                        {{ $m->status }}
                                    </span>
                                </td>

                                {{-- PROGRESS BAR --}}
                                <td>
                                    <div class="progress" style="height: 18px;">
                                        <div class="progress-bar
                                        {{ $m->progress < 50 ? 'bg-danger' : ($m->progress < 100 ? 'bg-warning' : 'bg-success') }}"
                                            style="width: {{ $m->progress }}%">
                                            {{ $m->progress }}%
                                        </div>
                                    </div>
                                </td>

                                {{-- KETERANGAN --}}
                                <td>
                                    @php
                                        $text = trim($m->keterangan2 ?? '-');

                                        if (str_starts_with($text, '-')) {
                                            $lines = preg_split('/\r\n|\r|\n/', $text);
                                            echo implode('<br>', $lines);
                                        } else {
                                            $lines = preg_split('/\r\n|\r|\n/', $text);
                                            echo implode(', ', $lines);
                                        }
                                    @endphp
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    Tidak ada data monitoring
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-3 d-flex justify-content-center no-print">
            {{ $monitorings->links('pagination::bootstrap-4') }}
        </div>

    </div>

    {{-- ================= JS PRINT ================= --}}
    <script>
        function printPage() {
            window.print();
        }
    </script>

@endsection
