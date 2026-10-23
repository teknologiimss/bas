@extends('layouts.main')

@section('title', 'Monitoring Progress - ' . $proyek->nama_proyek)
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')
    <style>
        body {
            background-color: #f4f6f9;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 0.5rem 1rem rgba(11, 37, 69, 0.08);
            background: #ffffff;
        }

        .proyek-header {
            border-left: 4px solid #1d3557;
            padding-left: 15px;
        }

        .table-responsive {
            max-height: 75vh;
            overflow-x: auto;
            overflow-y: auto;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            background: #fff;
        }

        /* Styling Freeze / Sticky Column */
        .th-no,
        .td-no {
            position: sticky;
            left: 0px;
            width: 45px;
            min-width: 45px;
            z-index: 5;
        }

        .th-item,
        .td-item {
            position: sticky;
            left: 45px;
            width: 200px;
            min-width: 200px;
            z-index: 5;
            white-space: normal !important;
            word-wrap: break-word;
            word-break: break-word;
            vertical-align: middle !important;
        }

        .th-satuan,
        .td-satuan {
            position: sticky;
            left: 245px;
            width: 75px;
            min-width: 75px;
            z-index: 5;
        }

        .th-vol,
        .td-vol {
            position: sticky;
            left: 320px;
            width: 95px;
            min-width: 95px;
            z-index: 5;
        }

        .th-harga,
        .td-harga {
            position: sticky;
            left: 415px;
            width: 110px;
            min-width: 110px;
            z-index: 5;
        }

        .th-jumlah,
        .td-jumlah {
            position: sticky;
            left: 525px;
            width: 110px;
            min-width: 110px;
            z-index: 5;
        }

        .th-bobot,
        .td-bobot {
            position: sticky;
            left: 635px;
            width: 115px;
            min-width: 115px;
            z-index: 5;
        }

        .th-prog,
        .td-prog {
            position: sticky;
            left: 750px;
            width: 100px;
            min-width: 100px;
            z-index: 5;
            border-right: 3px solid #1d3557 !important;
        }

        td.th-no,
        td.td-no,
        td.th-item,
        td.td-item,
        td.th-satuan,
        td.td-satuan,
        td.th-vol,
        td.td-vol,
        td.th-harga,
        td.td-harga,
        td.th-jumlah,
        td.td-jumlah,
        td.th-bobot,
        td.td-bobot,
        td.th-prog,
        td.td-prog {
            background-color: #ffffff;
        }

        .table-striped tbody tr:nth-of-type(odd) .td-no,
        .table-striped tbody tr:nth-of-type(odd) .td-item,
        .table-striped tbody tr:nth-of-type(odd) .td-satuan,
        .table-striped tbody tr:nth-of-type(odd) .td-vol,
        .table-striped tbody tr:nth-of-type(odd) .td-harga,
        .table-striped tbody tr:nth-of-type(odd) .td-jumlah,
        .table-striped tbody tr:nth-of-type(odd) .td-bobot,
        .table-striped tbody tr:nth-of-type(odd) .td-prog {
            background-color: #f8fafc;
        }

        thead th {
            background-color: #0b2545 !important;
            color: #ffffff !important;
            border-color: #1d3557 !important;
        }

        thead th[class*="th-"],
        tfoot td[class*="th-"],
        tfoot td[class*="td-"] {
            background-color: #0b2545 !important;
            color: #fff;
            z-index: 6;
        }

        tfoot.table-dark tr td {
            background-color: #0b2545 !important;
            border-color: #1d3557 !important;
        }

        .btn {
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }

        .btn-primary {
            background-color: #1d3557;
            border-color: #1d3557;
        }

        .btn-primary:hover {
            background-color: #0b2545;
            border-color: #0b2545;
        }

        .action-btn-group {
            display: flex;
            gap: 6px;
            justify-content: center;
            align-items: center;
        }

        .modal {
            z-index: 1050 !important;
        }

        .modal-backdrop {
            z-index: 1040 !important;
        }
    </style>

    <div class="container-fluid px-2 px-md-4 py-3">
        <div class="card p-3 p-md-4 shadow-sm">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                <div class="proyek-header">
                    <h4 class="mb-1 text-dark"><strong>PROYEK:</strong> {{ $proyek->nama_proyek }}</h4>
                    <p class="text-muted mb-1 small"><strong>NO KONTRAK/SO/NODIN:</strong> {{ $proyek->no_kontrak ?? '-' }}
                    </p>

                    <p class="text-dark mb-0 small">
                        <i class="fa fa-calendar mr-1"></i> <strong>Periode Kontrak:</strong>
                        <span
                            class="text-primary font-weight-bold">{{ $tglMulaiKontrak ? \Carbon\Carbon::parse($tglMulaiKontrak)->format('d/m/Y') : '-' }}</span>
                        s/d
                        <span
                            class="text-primary font-weight-bold">{{ $tglSelesaiKontrak ? \Carbon\Carbon::parse($tglSelesaiKontrak)->format('d/m/Y') : '-' }}</span>
                    </p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('pekerjaanmro.index') }}" class="btn btn-secondary btn-sm px-3 shadow-sm">
                        <i class="fa fa-arrow-left mr-1"></i> Kembali
                    </a>
                    <button class="btn btn-primary btn-sm px-3 shadow-sm" data-toggle="modal" data-target="#modalAddItem">
                        <i class="fa fa-plus mr-1"></i> Tambah Item Pekerjaan
                    </button>
                </div>
            </div>

            @php
                $totalHargaGlobal = $proyek->items->sum(function ($item) {
                    return $item->harga_satuan ? $item->vol_rencana * $item->harga_satuan : 0;
                });
                $totalItemCount = $proyek->items->count();
            @endphp

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center align-middle mb-0"
                    style="font-size: 12px; white-space: nowrap;">
                    <thead class="table-dark">
                        <!-- BARIS 1: PERIODE TANGGAL -->
                        <tr>
                            <th rowspan="4" class="align-middle th-no">NO</th>
                            <th rowspan="4" class="align-middle th-item">ITEM PEKERJAAN</th>
                            <th rowspan="4" class="align-middle th-satuan">SATUAN</th>
                            <th rowspan="4" class="align-middle th-vol">VOL RENCANA</th>
                            <th rowspan="4" class="align-middle th-harga">HARGA SATUAN</th>
                            <th rowspan="4" class="align-middle th-jumlah">JUMLAH</th>
                            <th rowspan="4" class="align-middle th-bobot">BOBOT RENCANA (%)</th>
                            <th rowspan="4" class="align-middle th-prog">PROGRESS (%)</th>

                            @for ($w = 1; $w <= $totalWeeks; $w++)
                                @php
                                    // Hitung rentang 7 harian dari tanggal awal kontrak secara akurat
                                    $tglMulaiMgg = $startDate->copy()->addDays(($w - 1) * 7);
                                    $tglSelesaiMgg = $startDate->copy()->addDays($w * 7 - 1);

                                    // Jika tanggal selesai minggu ke-$w melebihi tanggal selesai kontrak, set tepat di tanggal selesai kontrak
                                    if (
                                        $tglSelesaiKontrak &&
                                        $tglSelesaiMgg->gt(\Carbon\Carbon::parse($tglSelesaiKontrak)->startOfDay())
                                    ) {
                                        $tglSelesaiMgg = \Carbon\Carbon::parse($tglSelesaiKontrak)->startOfDay();
                                    }
                                @endphp
                                <th colspan="3" class="text-left font-weight-normal px-3 py-2"
                                    style="font-size: 11px; background-color: #1d3557;">
                                    Periode: {{ $tglMulaiMgg->format('d/m/Y') }}<br>
                                    s/d: {{ $tglSelesaiMgg->format('d/m/Y') }}
                                </th>
                            @endfor

                            <th rowspan="4" class="align-middle px-3">Aksi</th>
                        </tr>

                        <!-- BARIS 2: PROG MGG -->
                        <tr>
                            @for ($w = 1; $w <= $totalWeeks; $w++)
                                <th colspan="3" style="background-color: #243b55;">Progress Minggu {{ $w }}
                                </th>
                            @endfor
                        </tr>

                        <!-- BARIS 3: MINGGU INI & S/D MINGGU INI -->
                        <tr>
                            @for ($w = 1; $w <= $totalWeeks; $w++)
                                <th colspan="2" style="background-color: #0b2545;">Minggu ini</th>
                                <th style="background-color: #06182c;">s/d Minggu ini</th>
                            @endfor
                        </tr>

                        <!-- BARIS 4: SUB HEADER KOLOM -->
                        <tr>
                            @for ($w = 1; $w <= $totalWeeks; $w++)
                                <th style="background-color: #132d46;">Vol realisasi</th>
                                <th style="background-color: #132d46;">Progres %</th>
                                <th style="background-color: #0b2545;">Progres %</th>
                            @endfor
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $totalBobotRencana = 0;
                            $sumProgMingguIniPerMgg = array_fill(1, $totalWeeks, 0);
                            $sumSmpaiMingguIniPerMgg = array_fill(1, $totalWeeks, 0);
                        @endphp

                        @forelse($proyek->items as $index => $item)
                            @php
                                $jumlah = $item->harga_satuan ? $item->vol_rencana * $item->harga_satuan : 0;
                                $bobotRencana = $totalHargaGlobal > 0 ? ($jumlah / $totalHargaGlobal) * 100 : 0;
                                $totalBobotRencana += $bobotRencana;

                                $progressMingguanData = $item->progress_mingguan ?? [];
                                $smpaiMingguIniAcc = 0;
                            @endphp
                            <tr class="item-row-data" data-vol-rencana="{{ $item->vol_rencana }}">
                                <td class="align-middle td-no">{{ $index + 1 }}</td>
                                <td class="text-left align-middle td-item font-weight-bold">{{ $item->item_pekerjaan }}
                                </td>
                                <td class="align-middle td-satuan">{{ $item->satuan }}</td>
                                <td class="align-middle td-vol">{{ $item->vol_rencana }}</td>
                                <td class="align-middle td-harga">
                                    {{ $item->harga_satuan ? number_format($item->harga_satuan, 0, ',', '.') : '-' }}</td>
                                <td class="align-middle td-jumlah">
                                    {{ $jumlah > 0 ? number_format($jumlah, 0, ',', '.') : '-' }}</td>
                                <td class="align-middle td-bobot">{{ number_format($bobotRencana, 4) }}%</td>
                                <td class="align-middle td-prog">
                                    <form action="{{ route('pekerjaanmro.item.update-progress-utama') }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                        <input type="number" step="any" name="progress_utama"
                                            value="{{ $item->progress_utama ?? 0 }}"
                                            class="form-control form-control-sm text-center mx-auto shadow-none"
                                            style="width: 75px;" onchange="this.form.submit()">
                                    </form>
                                </td>

                                <!-- Perhitungan Kolom Mingguan -->
                                @for ($w = 1; $w <= $totalWeeks; $w++)
                                    @php
                                        $volRealisasi = $progressMingguanData[$w]['vol'] ?? '';

                                        if ($item->vol_rencana > 0 && is_numeric($volRealisasi)) {
                                            if ($item->harga_satuan) {
                                                $progMingguIni = ($bobotRencana * $volRealisasi) / $item->vol_rencana;
                                            } else {
                                                $progMingguIni = ($volRealisasi / $item->vol_rencana) * 100;
                                            }
                                        } else {
                                            $progMingguIni = 0;
                                        }

                                        $smpaiMingguIniAcc += $progMingguIni;

                                        if ($totalItemCount > 0) {
                                            $sumProgMingguIniPerMgg[$w] += $progMingguIni;
                                            $sumSmpaiMingguIniPerMgg[$w] += $smpaiMingguIniAcc;
                                        }
                                    @endphp

                                    <td class="align-middle" style="padding: 6px;">
                                        <form action="{{ route('pekerjaanmro.item.update-progress') }}" method="POST"
                                            onsubmit="return validateKumulatif(this, {{ $item->vol_rencana }})">
                                            @csrf
                                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                                            <input type="number" step="any"
                                                name="vol_realisasi[{{ $w }}][vol]"
                                                value="{{ $volRealisasi !== '' ? $volRealisasi : '' }}"
                                                class="form-control form-control-sm text-center mx-auto shadow-none vol-realisasi-input"
                                                style="width: 60px; padding: 3px; font-size: 11px;" placeholder="-"
                                                onchange="if(validateKumulatif(this.form, {{ $item->vol_rencana }})) { this.form.submit(); }">
                                        </form>
                                    </td>
                                    <td class="align-middle bg-light">
                                        {{ $progMingguIni > 0 ? number_format($progMingguIni, 2) . '%' : '-' }}</td>
                                    <td class="align-middle bg-warning-subtle font-weight-bold">
                                        {{ $smpaiMingguIniAcc > 0 ? number_format($smpaiMingguIniAcc, 2) . '%' : '-' }}
                                    </td>
                                @endfor

                                <td class="align-middle px-3 py-2">
                                    <div class="action-btn-group">
                                        <button type="button"
                                            class="btn btn-warning btn-sm text-white px-2 py-1 shadow-sm"
                                            data-toggle="modal" data-target="#modalEditItem{{ $item->id }}"
                                            style="font-size: 11px;">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('pekerjaanmro.item.delete', $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm px-2 py-1 shadow-sm"
                                                style="font-size: 11px;" onclick="return confirm('Hapus item ini?')">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 9 + $totalWeeks * 3 }}" class="text-center py-4 text-muted">Belum ada
                                    item pekerjaan.</td>
                            </tr>
                        @endforelse
                    </tbody>

                    <tfoot class="table-dark font-weight-bold">
                        <tr>
                            <td colspan="5" class="text-right th-no px-3">TOTAL HARGA & BOBOT RENCANA:</td>
                            <td class="th-jumlah px-3">{{ number_format($totalHargaGlobal, 0, ',', '.') }}</td>
                            <td class="th-bobot px-3">{{ number_format($totalBobotRencana, 2) }}%</td>
                            <td class="th-prog"></td>
                            @for ($w = 1; $w <= $totalWeeks; $w++)
                                @php
                                    $avgProgMingguIni =
                                        $totalItemCount > 0 ? $sumProgMingguIniPerMgg[$w] / $totalItemCount : 0;
                                    $avgSmpaiMingguIni =
                                        $totalItemCount > 0 ? $sumSmpaiMingguIniPerMgg[$w] / $totalItemCount : 0;
                                @endphp
                                <td></td>
                                <td class="text-info font-weight-bold">
                                    {{ $avgProgMingguIni > 0 ? number_format($avgProgMingguIni, 2) . '%' : '-' }}</td>
                                <td class="text-warning font-weight-bold">
                                    {{ $avgSmpaiMingguIni > 0 ? number_format($avgSmpaiMingguIni, 2) . '%' : '-' }}</td>
                            @endfor
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT ITEM -->
    @foreach ($proyek->items as $item)
        <div class="modal fade" id="modalEditItem{{ $item->id }}" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form action="{{ route('pekerjaanmro.item.update', $item->id) }}" method="POST"
                    class="modal-content shadow border-0">
                    @csrf
                    @method('PUT')
                    <div class="modal-header text-white px-4 py-3" style="background-color: #0b2545;">
                        <h5 class="modal-title font-weight-bold">Edit Item Pekerjaan</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left p-4">
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-dark">Item Pekerjaan *</label>
                            <input type="text" name="item_pekerjaan" value="{{ $item->item_pekerjaan }}"
                                class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-dark">Satuan *</label>
                            <input type="text" name="satuan" value="{{ $item->satuan }}" class="form-control"
                                required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-dark">Volume Rencana *</label>
                            <input type="number" step="any" name="vol_rencana" value="{{ $item->vol_rencana }}"
                                class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-dark">Harga Satuan</label>
                            <input type="number" step="any" name="harga_satuan" value="{{ $item->harga_satuan }}"
                                class="form-control">
                        </div>
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold text-dark">Progress Utama (%)</label>
                            <input type="number" step="any" name="progress_utama"
                                value="{{ $item->progress_utama }}" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer bg-light px-4 py-3">
                        <button type="button" class="btn btn-secondary px-4 shadow-sm"
                            data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success px-4 shadow-sm">Update Item</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <!-- MODAL TAMBAH ITEM -->
    <div class="modal fade" id="modalAddItem" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <form action="{{ route('pekerjaanmro.item.store', $proyek->id) }}" method="POST"
                class="modal-content shadow border-0">
                @csrf
                <div class="modal-header text-white px-4 py-3" style="background-color: #0b2545;">
                    <h5 class="modal-title font-weight-bold">Tambah Item Pekerjaan</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div id="item-wrapper">
                        <div class="item-row border p-3 mb-3 rounded bg-light shadow-sm">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label class="small font-weight-bold text-dark">Item Pekerjaan *</label>
                                    <input type="text" name="item_pekerjaan[]" class="form-control form-control-sm"
                                        required>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label class="small font-weight-bold text-dark">Satuan *</label>
                                    <input type="text" name="satuan[]" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label class="small font-weight-bold text-dark">Vol Rencana *</label>
                                    <input type="number" step="any" name="vol_rencana[]"
                                        class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label class="small font-weight-bold text-dark">Harga Satuan</label>
                                    <input type="number" step="any" name="harga_satuan[]"
                                        class="form-control form-control-sm">
                                </div>
                                <div class="col-md-2 form-group">
                                    <label class="small font-weight-bold text-dark">Progress (%)</label>
                                    <input type="number" step="any" name="progress_utama[]"
                                        class="form-control form-control-sm" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mt-2 px-3 shadow-sm" id="add-more-row">
                        <i class="fa fa-plus mr-1"></i> Tambah Baris Lagi
                    </button>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-secondary px-4 shadow-sm" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success px-4 shadow-sm">Simpan Item</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('add-more-row').addEventListener('click', function() {
            let wrapper = document.getElementById('item-wrapper');
            let newRow = wrapper.firstElementChild.cloneNode(true);
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            wrapper.appendChild(newRow);
        });

        function validateKumulatif(form, volRencana) {
            let row = form.closest('tr');
            let inputs = row.querySelectorAll('.vol-realisasi-input');
            let totalRealisasi = 0;

            inputs.forEach(input => {
                let val = parseFloat(input.value);
                if (!isNaN(val) && val > 0) {
                    totalRealisasi += val;
                }
            });

            if (totalRealisasi > volRencana) {
                alert('Peringatan: Total Volume Realisasi dari semua minggu (' + totalRealisasi.toFixed(2) +
                    ') melebihi Volume Rencana (' + volRencana + ')! Masukan ditolak.');
                let currentInput = form.querySelector('input[name*="[vol]"]');
                currentInput.value = '';
                currentInput.focus();
                return false;
            }

            return true;
        }
    </script>
@endsection
