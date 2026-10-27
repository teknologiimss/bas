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
            border-radius: 14px;
            box-shadow: 0 0.75rem 1.5rem rgba(11, 37, 69, 0.08);
            background: #ffffff;
        }

        .proyek-header {
            border-left: 5px solid #1d3557;
            padding-left: 15px;
        }

        .table-responsive {
            max-height: 75vh;
            overflow: auto;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #fff;
        }

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
            width: 220px;
            min-width: 220px;
            z-index: 5;
        }

        .th-satuan,
        .td-satuan {
            position: sticky;
            left: 265px;
            width: 75px;
            min-width: 75px;
            z-index: 5;
        }

        .th-vol,
        .td-vol {
            position: sticky;
            left: 340px;
            width: 95px;
            min-width: 95px;
            z-index: 5;
        }

        .th-harga,
        .td-harga {
            position: sticky;
            left: 435px;
            width: 110px;
            min-width: 110px;
            z-index: 5;
        }

        .th-jumlah,
        .td-jumlah {
            position: sticky;
            left: 545px;
            width: 120px;
            min-width: 120px;
            z-index: 5;
        }

        .th-bobot,
        .td-bobot {
            position: sticky;
            left: 665px;
            width: 115px;
            min-width: 115px;
            z-index: 5;
        }

        .th-prog,
        .td-prog {
            position: sticky;
            left: 780px;
            width: 100px;
            min-width: 100px;
            z-index: 5;
            border-right: 3px solid #1d3557 !important;
        }

        td[class*="td-"] {
            background-color: #ffffff;
        }

        thead th,
        tfoot td {
            background-color: #0b2545 !important;
            color: #fff !important;
            z-index: 6;
        }

        .action-btn-group {
            display: flex;
            gap: 6px;
            justify-content: center;
            align-items: center;
        }

        /* Styling Tombol Atas Sesuai Keinginan */
        .btn-custom-back {
            background-color: #ffffff;
            border: 1px solid #cbd5e1;
            color: #475569;
            border-radius: 8px;
            font-weight: 500;
            padding: 6px 16px;
            transition: all 0.2s;
        }

        .btn-custom-back:hover {
            background-color: #f8fafc;
            color: #1e293b;
        }

        .btn-custom-primary {
            background-color: #1d3557;
            border: 1px solid #1d3557;
            color: #ffffff;
            border-radius: 8px;
            font-weight: 500;
            padding: 6px 16px;
            transition: all 0.2s;
        }

        .btn-custom-primary:hover {
            background-color: #0b2545;
            color: #ffffff;
        }
    </style>

    <div class="container-fluid px-3 px-md-4 py-4">
        <div class="card p-4 shadow-sm">
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom gap-3">
                <div class="proyek-header">
                    <h4 class="mb-1 text-dark font-weight-bold">PROYEK: {{ $proyek->nama_proyek }}</h4>
                    <p class="text-muted mb-2 small font-weight-medium"><strong>NO KONTRAK/SO/NODIN:</strong>
                        {{ $proyek->no_kontrak ?? '-' }}</p>

                    <!-- Badge Periode Kontrak -->
                    <div>
                        <span class="badge badge-light border px-3 py-2 text-muted shadow-sm"
                            style="font-size: 12px; border-radius: 20px;">
                            <i class="fa fa-calendar text-primary mr-1"></i> Periode Kontrak:
                            <span
                                class="text-primary font-weight-bold">{{ $tglMulaiKontrak ? \Carbon\Carbon::parse($tglMulaiKontrak)->format('d/m/Y') : '-' }}</span>
                            s/d
                            <span
                                class="text-primary font-weight-bold">{{ $tglSelesaiKontrak ? \Carbon\Carbon::parse($tglSelesaiKontrak)->format('d/m/Y') : '-' }}</span>
                        </span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('pekerjaanwil1.index') }}" class="btn btn-custom-back btn-sm shadow-sm mr-2">
                        <i class="fa fa-arrow-left mr-1"></i> Kembali
                    </a>
                    <button class="btn btn-custom-primary btn-sm shadow-sm" data-toggle="modal" data-target="#modalAddItem">
                        <i class="fa fa-plus mr-1"></i> Tambah Item Pekerjaan
                    </button>
                </div>
            </div>

            @php
                $totalHargaGlobal = $proyek->items->sum(
                    fn($item) => $item->harga_satuan ? $item->vol_rencana * $item->harga_satuan : 0,
                );
                $hasHargaGlobal = $proyek->items->contains(
                    fn($item) => !empty($item->harga_satuan) && $item->harga_satuan > 0,
                );
                $totalItemCount = $proyek->items->count();
            @endphp

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center align-middle mb-0"
                    style="font-size: 12px; white-space: nowrap;">
                    <thead class="table-dark">
                        <tr>
                            <th rowspan="4" class="align-middle th-no">NO</th>
                            <th rowspan="4" class="align-middle th-item">ITEM PEKERJAAN</th>
                            <th rowspan="4" class="align-middle th-satuan">SATUAN</th>
                            <th rowspan="4" class="align-middle th-vol">VOL RENCANA</th>
                            <th rowspan="4" class="align-middle th-harga">HARGA SATUAN</th>
                            <th rowspan="4" class="align-middle th-jumlah">JUMLAH</th>
                            <th rowspan="4" class="align-middle th-bobot">BOBOT RENCANA (%)</th>
                            <th rowspan="4" class="align-middle th-prog">
                                ASUMSI PROGRESS (%)
                                <div style="font-size: 10px; font-weight: normal; color: #cbd5e1; margin-top: 2px;">
                                    (*jika tidak ada harga, kolom ini di isi 100%)
                                </div>
                            </th>
                            @for ($w = 1; $w <= $totalWeeks; $w++)
                                @php
                                    $tglMulaiMgg = $startDate->copy()->addDays(($w - 1) * 7);
                                    $tglSelesaiMgg = $startDate->copy()->addDays($w * 7 - 1);
                                    if (
                                        $tglSelesaiKontrak &&
                                        $tglSelesaiMgg->gt(\Carbon\Carbon::parse($tglSelesaiKontrak)->startOfDay())
                                    ) {
                                        $tglSelesaiMgg = \Carbon\Carbon::parse($tglSelesaiKontrak)->startOfDay();
                                    }
                                @endphp
                                <th colspan="3" class="text-left font-weight-normal px-3 py-2"
                                    style="font-size: 11px; background-color: #1d3557;">
                                    Periode: {{ $tglMulaiMgg->format('d/m/Y') }}<br>s/d:
                                    {{ $tglSelesaiMgg->format('d/m/Y') }}
                                </th>
                            @endfor
                            <th rowspan="4" class="align-middle text-center px-3" style="width: 160px;">Aksi</th>
                        </tr>
                        <tr>
                            @for ($w = 1; $w <= $totalWeeks; $w++)
                                <th colspan="3" style="background-color: #243b55;">Progress Minggu {{ $w }}
                                </th>
                            @endfor
                        </tr>
                        <tr>
                            @for ($w = 1; $w <= $totalWeeks; $w++)
                                <th colspan="2" style="background-color: #0b2545;">Minggu ini</th>
                                <th style="background-color: #06182c;">s/d Minggu ini</th>
                            @endfor
                        </tr>
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
                            <tr>
                                <td class="align-middle td-no">{{ $index + 1 }}</td>
                                <td class="text-left align-middle td-item font-weight-bold">{{ $item->item_pekerjaan }}
                                </td>
                                <td class="align-middle td-satuan">{{ $item->satuan }}</td>
                                <td class="align-middle td-vol">{{ number_format($item->vol_rencana, 2, ',', '.') }}</td>
                                <td class="align-middle td-harga">
                                    {{ $item->harga_satuan ? number_format($item->harga_satuan, 0, ',', '.') : '-' }}</td>
                                <td class="align-middle td-jumlah">
                                    {{ $jumlah > 0 ? number_format($jumlah, 0, ',', '.') : '-' }}</td>
                                <td class="align-middle td-bobot">{{ number_format($bobotRencana, 4, ',', '.') }}%</td>
                                <td class="align-middle td-prog">
                                    <form action="{{ route('pekerjaanwil1.item.update-progress-utama') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                        <input type="number" step="any" name="progress_utama"
                                            value="{{ $item->progress_utama ?? 0 }}"
                                            class="form-control form-control-sm text-center mx-auto" style="width: 75px;"
                                            onchange="this.form.submit()">
                                    </form>
                                </td>
                                @for ($w = 1; $w <= $totalWeeks; $w++)
                                    @php
                                        $volRealisasi = $progressMingguanData[$w]['vol'] ?? '';
                                        $progMingguIni =
                                            $item->vol_rencana > 0 && is_numeric($volRealisasi)
                                                ? ($item->harga_satuan
                                                    ? ($bobotRencana * $volRealisasi) / $item->vol_rencana
                                                    : ($volRealisasi / $item->vol_rencana) * 100)
                                                : 0;
                                        $smpaiMingguIniAcc += $progMingguIni;
                                        $sumProgMingguIniPerMgg[$w] += $progMingguIni;
                                        $sumSmpaiMingguIniPerMgg[$w] += $smpaiMingguIniAcc;
                                    @endphp
                                    <td class="align-middle" style="padding: 6px;">
                                        <form action="{{ route('pekerjaanwil1.item.update-progress') }}" method="POST"
                                            onsubmit="return validateKumulatif(this, {{ $item->vol_rencana }})">
                                            @csrf
                                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                                            <input type="number" step="any"
                                                name="vol_realisasi[{{ $w }}][vol]"
                                                value="{{ $volRealisasi !== '' ? $volRealisasi : '' }}"
                                                class="form-control form-control-sm text-center mx-auto vol-realisasi-input"
                                                style="width: 60px; font-size: 11px;"
                                                onchange="if(validateKumulatif(this.form, {{ $item->vol_rencana }})) { this.form.submit(); }">
                                        </form>
                                    </td>
                                    <td class="align-middle bg-light">
                                        {{ $progMingguIni > 0 ? number_format($progMingguIni, 2, ',', '.') . '%' : '-' }}
                                    </td>
                                    <td class="align-middle bg-warning-subtle font-weight-bold">
                                        {{ $smpaiMingguIniAcc > 0 ? number_format($smpaiMingguIniAcc, 2, ',', '.') . '%' : '-' }}
                                    </td>
                                @endfor
                                <td class="align-middle text-center">
                                    <div class="action-btn-group">
                                        <button type="button"
                                            class="btn btn-warning text-white btn-sm font-weight-bold shadow-sm d-inline-flex align-items-center justify-content-center"
                                            data-toggle="modal" data-target="#modalEditItem{{ $item->id }}"
                                            style="border-radius: 6px; font-size: 11px; width: 72px; height: 30px;">
                                            <i class="fa fa-edit mr-1"></i> Edit
                                        </button>
                                        <form action="{{ route('pekerjaanwil1.item.delete', $item->id) }}" method="POST"
                                            class="d-inline mb-0">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-danger btn-sm font-weight-bold shadow-sm d-inline-flex align-items-center justify-content-center"
                                                onclick="return confirm('Hapus item ini?')"
                                                style="border-radius: 6px; font-size: 11px; width: 72px; height: 30px;">
                                                <i class="fa fa-trash mr-1"></i> Hapus
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
                            <td class="th-bobot px-3">{{ number_format($totalBobotRencana, 2, ',', '.') }}%</td>
                            <td class="th-prog"></td>
                            @for ($w = 1; $w <= $totalWeeks; $w++)
                                @php
                                    $valProgMingguIni = $hasHargaGlobal
                                        ? $sumProgMingguIniPerMgg[$w]
                                        : ($totalItemCount > 0
                                            ? $sumProgMingguIniPerMgg[$w] / $totalItemCount
                                            : 0);
                                    $valSmpaiMingguIni = $hasHargaGlobal
                                        ? $sumSmpaiMingguIniPerMgg[$w]
                                        : ($totalItemCount > 0
                                            ? $sumSmpaiMingguIniPerMgg[$w] / $totalItemCount
                                            : 0);
                                @endphp
                                <td></td>
                                <td class="text-info font-weight-bold">
                                    {{ $valProgMingguIni > 0 ? number_format($valProgMingguIni, 2, ',', '.') . '%' : '-' }}
                                </td>
                                <td class="text-warning font-weight-bold">
                                    {{ $valSmpaiMingguIni > 0 ? number_format($valSmpaiMingguIni, 2, ',', '.') . '%' : '-' }}
                                </td>
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
                <form action="{{ route('pekerjaanwil1.item.update', $item->id) }}" method="POST"
                    class="modal-content shadow border-0">
                    @csrf @method('PUT')
                    <div class="modal-header text-white px-4 py-3" style="background-color: #0b2545;">
                        <h5 class="modal-title font-weight-bold">Edit Item Pekerjaan</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="form-group mb-3"><label class="small font-weight-bold text-dark">Item
                                Pekerjaan</label><input type="text" name="item_pekerjaan"
                                value="{{ $item->item_pekerjaan }}" class="form-control" required></div>
                        <div class="form-group mb-3"><label class="small font-weight-bold text-dark">Satuan</label><input
                                type="text" name="satuan" value="{{ $item->satuan }}" class="form-control"
                                required></div>
                        <div class="form-group mb-3"><label class="small font-weight-bold text-dark">Volume
                                Rencana</label><input type="number" step="any" name="vol_rencana"
                                value="{{ $item->vol_rencana }}" class="form-control" required></div>
                        <div class="form-group mb-3"><label class="small font-weight-bold text-dark">Harga
                                Satuan</label><input type="number" step="any" name="harga_satuan"
                                value="{{ $item->harga_satuan }}" class="form-control"></div>
                    </div>
                    <div class="modal-footer bg-light px-4 py-3"><button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Tutup</button><button type="submit"
                            class="btn btn-success">Update</button></div>
                </form>
            </div>
        </div>
    @endforeach

    <!-- MODAL TAMBAH ITEM DENGAN FITUR HAPUS BARIS -->
    <div class="modal fade" id="modalAddItem" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <form action="{{ route('pekerjaanwil1.item.store', $proyek->id) }}" method="POST"
                class="modal-content shadow border-0">
                @csrf
                <div class="modal-header text-white px-4 py-3" style="background-color: #0b2545;">
                    <h5 class="modal-title font-weight-bold">Tambah Item Pekerjaan</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body p-4">
                    <div id="item-wrapper">
                        <div class="item-row border p-3 mb-3 rounded bg-light position-relative">
                            <div class="row align-items-end">
                                <div class="col-md-4 form-group mb-md-0"><label class="small font-weight-bold">Item
                                        Pekerjaan</label><input type="text" name="item_pekerjaan[]"
                                        class="form-control form-control-sm" required></div>
                                <div class="col-md-2 form-group mb-md-0"><label
                                        class="small font-weight-bold">Satuan</label><input type="text"
                                        name="satuan[]" class="form-control form-control-sm" required></div>
                                <div class="col-md-2 form-group mb-md-0"><label class="small font-weight-bold">Vol
                                        Rencana</label><input type="number" step="any" name="vol_rencana[]"
                                        class="form-control form-control-sm" required></div>
                                <div class="col-md-3 form-group mb-md-0"><label class="small font-weight-bold">Harga
                                        Satuan</label><input type="number" step="any" name="harga_satuan[]"
                                        class="form-control form-control-sm"></div>
                                <div class="col-md-1 text-center">
                                    <button type="button" class="btn btn-danger btn-sm remove-row-btn"
                                        style="height: 31px; width: 100%; display: none;"><i
                                            class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-more-row"><i
                            class="fa fa-plus mr-1"></i> Tambah Baris</button>
                </div>
                <div class="modal-footer bg-light px-4 py-3"><button type="button" class="btn btn-secondary"
                        data-dismiss="modal">Tutup</button><button type="submit" class="btn btn-success">Simpan</button>
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
            updateRemoveButtons();
        });

        document.getElementById('item-wrapper').addEventListener('click', function(e) {
            if (e.target.closest('.remove-row-btn')) {
                let row = e.target.closest('.item-row');
                let wrapper = document.getElementById('item-wrapper');
                if (wrapper.children.length > 1) {
                    row.remove();
                    updateRemoveButtons();
                }
            }
        });

        function updateRemoveButtons() {
            let wrapper = document.getElementById('item-wrapper');
            let rows = wrapper.querySelectorAll('.item-row');
            rows.forEach((row, index) => {
                let btn = row.querySelector('.remove-row-btn');
                if (rows.length > 1) {
                    btn.style.display = 'block';
                } else {
                    btn.style.display = 'none';
                }
            });
        }

        function validateKumulatif(form, volRencana) {
            let row = form.closest('tr');
            let totalRealisasi = Array.from(row.querySelectorAll('.vol-realisasi-input')).reduce((sum, input) => sum + (
                parseFloat(input.value) || 0), 0);
            if (totalRealisasi > volRencana) {
                alert('Total Volume Realisasi melebihi Volume Rencana (' + volRencana + ')!');
                form.querySelector('input[name*="[vol]"]').value = '';
                return false;
            }
            return true;
        }
    </script>
@endsection
