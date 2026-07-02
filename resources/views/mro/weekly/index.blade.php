@extends('layouts.main')

@section('content')
    <style>
        .summary-card {
            background: #0b3d91;
            color: white;
            padding: 15px;
            border-radius: 10px;
            cursor: pointer;
        }

        .summary-number {
            font-size: 22px;
            font-weight: bold;
        }

        .chart-box {
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
        }

        .project-box {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
            background: #fff;
        }
    </style>

    <div class="container-fluid">

        {{-- FILTER --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" class="row">

                    <div class="col-md-4">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>

                    <div class="col-md-4">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <button class="btn btn-primary w-100">Filter</button>
                    </div>

                </form>
            </div>
        </div>

        {{-- SUMMARY --}}
        <div class="row mb-3">

            <div class="col-md-4">
                <div class="summary-card" data-bs-toggle="modal" data-bs-target="#modalTotal">
                    Total Activity
                    <div class="summary-number">{{ $total }}</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="summary-card" style="background:#ffc107;" data-bs-toggle="modal" data-bs-target="#modalOpen">
                    Open
                    <div class="summary-number">{{ $open }}</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="summary-card" style="background:#28a745;" data-bs-toggle="modal" data-bs-target="#modalClosed">
                    Closed
                    <div class="summary-number">{{ $closed }}</div>
                </div>
            </div>

        </div>

        {{-- CHART --}}
        <div class="row mb-3">

            <div class="col-md-6">
                <div class="chart-box">
                    <h5>Trend Activity</h5>
                    <div id="trendChart"></div>
                </div>
            </div>


        </div>

        {{-- EXPORT --}}
        <a href="{{ route('mro.weekly.export', [
            'start_date' => request('start_date'),
            'end_date' => request('end_date'),
        ]) }}"
            class="btn btn-success mb-3">
            Export Excel
        </a>

        {{-- DETAIL --}}
        <div class="card">
            <div class="card-header" style="background:#0b3d91;color:white;">
                Weekly Activity Detail
            </div>

            <div class="card-body">

                @foreach ($grouped as $project => $items)
                    <div class="project-box">

                        <h5>{{ $project }}</h5>
                        <small>Total: {{ $items->count() }}</small>

                        <hr>

                        @foreach ($items as $d)
                            @php
                                // 🔥 NORMALISASI SAFETY (ANTI BUG STATUS)
                                $status = strtolower(trim($d->status));
                                $ket = $d->keterangan ?? '-';
                            @endphp

                            <div style="margin-bottom:12px;">

                                <strong>{{ $d->kegiatan }}</strong><br>

                                <small>
                                    {{ date('d-m-Y', strtotime($d->tanggal)) }} |

                                    @if ($status == 'open')
                                        <span style="color:red;font-weight:bold;">OPEN (Issue)</span>
                                    @else
                                        <span style="color:green;">Closed</span>
                                    @endif
                                </small>

                                {{-- KETERANGAN --}}
                                {{-- KETERANGAN --}}
                                <div style="margin-top:5px;">

                                    @php
                                        // kalau keterangan ada beberapa baris dipisah newline
                                        $listKet = preg_split('/\r\n|\r|\n/', trim($ket));
                                    @endphp

                                    @if ($status == 'open')
                                        <div>
                                            <strong>⚠ Kendala:</strong>
                                            <ul style="margin:5px 0 0 18px; padding:0;">
                                                @foreach ($listKet as $k)
                                                    @if (trim($k) != '')
                                                        <li>{{ $k }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <div>
                                            <strong>✔ Catatan:</strong>
                                            <ul style="margin:5px 0 0 18px; padding:0;">
                                                @foreach ($listKet as $k)
                                                    @if (trim($k) != '')
                                                        <li>{{ $k }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                </div>

                            </div>

                            <hr>
                        @endforeach

                    </div>
                @endforeach

            </div>
        </div>

    </div>

    {{-- MODAL TOTAL --}}
    <div class="modal fade" id="modalTotal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5>Total Activity</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Proyek</th>
                                <th>Kegiatan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr>
                                    <td>{{ date('d-m-Y', strtotime($d->tanggal)) }}</td>
                                    <td>{{ optional($d->monitoring)->nama_pekerjaan }}</td>
                                    <td>{{ $d->kegiatan }}</td>
                                    <td>{{ strtolower(trim($d->status)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL OPEN --}}
    <div class="modal fade" id="modalOpen">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header bg-warning">
                    <h5>Open Activity</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Proyek</th>
                                <th>Kegiatan</th>
                                <th>Kendala</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                @if (strtolower(trim($d->status)) == 'open')
                                    <tr>
                                        <td>{{ date('d-m-Y', strtotime($d->tanggal)) }}</td>
                                        <td>{{ optional($d->monitoring)->nama_pekerjaan }}</td>
                                        <td>{{ $d->kegiatan }}</td>
                                        <td>{{ $d->keterangan }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL CLOSED --}}
    <div class="modal fade" id="modalClosed">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header bg-success text-white">
                    <h5>Closed Activity</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Proyek</th>
                                <th>Kegiatan</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                @if (strtolower(trim($d->status)) == 'closed')
                                    <tr>
                                        <td>{{ date('d-m-Y', strtotime($d->tanggal)) }}</td>
                                        <td>{{ optional($d->monitoring)->nama_pekerjaan }}</td>
                                        <td>{{ $d->kegiatan }}</td>
                                        <td>{{ $d->keterangan }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    {{-- BOOTSTRAP --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const trendLabels = @json($trendLabels);
            const trendTotal = @json($trendTotal);
            const trendOpen = @json($trendOpen);
            const trendClosed = @json($trendClosed);

            var options = {
                chart: {
                    type: 'line',
                    height: 300,
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                        name: 'Total Activity',
                        data: trendTotal
                    },
                    {
                        name: 'Open',
                        data: trendOpen
                    },
                    {
                        name: 'Closed',
                        data: trendClosed
                    }
                ],
                xaxis: {
                    categories: trendLabels
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                markers: {
                    size: 4
                },
                colors: ['#0b3d91', '#ffc107', '#28a745']
            };

            new ApexCharts(document.querySelector("#trendChart"), options).render();

        });
    </script>
@endsection
