@extends('layouts.main')

@section('title', 'Progress MRO')

@section('content')

    <style>
        /* ================= GLOBAL ================= */
        body {
            background-color: #f5f6f8;
        }

        h3 {
            color: #dc3545;
            letter-spacing: 0.5px;
        }

        /* ================= CARD ================= */
        .card {
            border: none;
            border-radius: 12px;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* ================= TABLE ================= */
        table {
            font-size: 13px;
        }

        thead.thead-dark th {
            background-color: #dc3545 !important;
            color: #fff !important;
            border: none;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        tbody tr {
            transition: background 0.2s ease;
        }

        tbody tr:hover {
            background-color: #fff0f0;
        }

        /* ================= BADGE ================= */
        .badge {
            padding: 6px 10px;
            font-size: 11px;
            border-radius: 20px;
            letter-spacing: 0.3px;
        }

        .badge-warning {
            background-color: #ffccd2;
            color: #721c24;
        }

        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-danger {
            background-color: #dc3545;
            color: #fff;
        }

        /* ================= PROGRESS ================= */
        .progress {
            background-color: #f1f1f1;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar {
            font-size: 11px;
            font-weight: 600;
            transition: width 0.6s ease;
        }

        /* ================= LINK ================= */
        a.text-primary {
            color: #dc3545 !important;
        }

        a.text-primary:hover {
            text-decoration: underline;
        }

        /* ================= BUTTON ================= */
        .btn-primary {
            background-color: #dc3545;
            border-color: #dc3545;
            border-radius: 20px;
            padding: 6px 16px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #bd2130;
            border-color: #bd2130;
        }

        /* ================= PRINT ================= */
        @media print {
            body {
                background-color: #fff !important;
            }

            thead.thead-dark th {
                background-color: #dc3545 !important;
                color: #fff !important;
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

                                {{-- Klik PO/Nodin Spesifik ke Halaman Monitoring --}}
                                <td>
                                    <a href="{{ route('monitoring.index', $m->proyek_id) }}?po={{ urlencode(trim($m->po_nota_dinas)) }}"
                                        class="text-primary font-weight-bold">
                                        {{ $m->po_nota_dinas }}
                                    </a>
                                </td>



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
