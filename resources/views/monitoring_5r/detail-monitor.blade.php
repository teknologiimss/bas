@extends('layouts.main')

@section('title', 'Detail Monitoring 5R & Scrap')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <style>
        body { background: #eef3f8; font-family: "Segoe UI", sans-serif; }
        .header-wrapper { display: flex; flex-direction: column; align-items: center; justify-content: center; margin-bottom: 25px; }
        .header-box { background: linear-gradient(135deg, #0f172a, #1e3a8a); color: #fff; padding: 20px; border-radius: 16px; text-align: center; width: 100%; max-width: 650px; box-shadow: 0 12px 28px rgba(15, 23, 42, .25); }
        .header-title { font-size: 13px; letter-spacing: 2px; text-transform: uppercase; opacity: .85; }
        .header-name { font-size: 20px; font-weight: 700; margin-top: 5px; }
        .card { border: none; border-radius: 18px; box-shadow: 0 12px 30px rgba(0, 0, 0, .08); }
        .table-container { overflow-x: auto; width: 100%; border-radius: 14px; }
        .table-check { min-width: 1450px; border-collapse: separate !important; border-spacing: 0; }
        .table-check th, .table-check td { text-align: center; vertical-align: middle; padding: 8px; border: 1px solid #d9e2ef; }
        .table-check th { background: linear-gradient(135deg, #0f172a, #1e3a8a); color: white; position: sticky; top: 0; z-index: 4; font-weight: 600; }
        .table-check th:first-child { position: sticky; left: 0; z-index: 6; }
        .table-check td:first-child { position: sticky; left: 0; background: white; z-index: 5; font-weight: bold; }
        .table-check tbody tr:hover td { background: #edf4ff; }
        .ok { background: #16a34a !important; color: white; font-weight: bold; }
        .nok { background: #dc2626 !important; color: white; font-weight: bold; }
        .status-select { color: inherit; border: none; background: transparent; }
        .status-select option { color: #000; background: #fff; }
        select, input[type=text], input[type=date] { width: 100%; border: none; background: transparent; text-align: center; font-size: 13px; }
        input[type=file] { font-size: 11px; }
        .btn { border-radius: 10px; transition: .25s; font-weight: 500; }
        .btn:hover { transform: translateY(-2px); }
        .btn-primary { background: linear-gradient(135deg, #2563eb, #1d4ed8); border: none; }
        .btn-success { background: linear-gradient(135deg, #1e3a8a, #2563eb); border: none; color: white; }
        .btn-danger { background: linear-gradient(135deg, #dc2626, #b91c1c); border: none; }
        .lampiran-box { border: 1px solid #dbe5f0; border-radius: 8px; background: white; padding: 6px; margin-bottom: 6px; }
        .img-thumbnail { border-radius: 6px; border: 1px solid #dbeafe; }
        .section-label { font-size: 11px; font-weight: 700; color: #1e3a8a; text-transform: uppercase; margin-bottom: 4px; display: block; text-align: left; }
    </style>

    <div class="header-wrapper">
        <div class="header-box">
            <div class="header-title">MONITORING 5R & SCRAP</div>
            <div class="header-name">{{ $data->deskripsi_pekerjaan ?? '-' }}</div>
            <div class="header-name" style="font-size: 16px; font-weight: 500; opacity: 0.9;">
                No. Kontrak: {{ $data->nomor_kontrak ?? '-' }}
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card p-3">
        <form method="POST" action="{{ route('monitoring_5r.detail.update', $data->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="monitoring_5r_id" value="{{ $data->id }}">

            <div class="table-container">
                <table class="table table-bordered table-check">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'] as $bln)
                                <th>{{ $bln }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        {{-- STATUS --}}
                        <tr>
                            <td>Status</td>
                            @for ($i = 1; $i <= 12; $i++)
                                @php $c = $checksheets[$i] ?? null; @endphp
                                <td class="status-cell {{ $c && $c->status == 'OK' ? 'ok' : ($c && $c->status == 'NOK' ? 'nok' : '') }}">
                                    <select name="status[{{ $i }}]" class="status-select">
                                        <option value="">-</option>
                                        <option value="OK" {{ $c && $c->status == 'OK' ? 'selected' : '' }}>OK</option>
                                        <option value="NOK" {{ $c && $c->status == 'NOK' ? 'selected' : '' }}>NOK</option>
                                    </select>
                                </td>
                            @endfor
                        </tr>

                        {{-- TANGGAL --}}
                        <tr>
                            <td>Tanggal</td>
                            @for ($i = 1; $i <= 12; $i++)
                                @php $c = $checksheets[$i] ?? null; @endphp
                                <td>
                                    <input type="date" name="tanggal[{{ $i }}]" value="{{ $c ? $c->tanggal : '' }}">
                                </td>
                            @endfor
                        </tr>

                        {{-- KETERANGAN --}}
                        <tr>
                            <td>Keterangan</td>
                            @for ($i = 1; $i <= 12; $i++)
                                @php $c = $checksheets[$i] ?? null; @endphp
                                <td>
                                    <input type="text" name="keterangan[{{ $i }}]" value="{{ $c ? $c->keterangan : '' }}" placeholder="Isi keterangan...">
                                </td>
                            @endfor
                        </tr>

                        {{-- LAMPIRAN ABSENSI --}}
                        <tr>
                            <td>Lampiran Absensi</td>
                            @for ($i = 1; $i <= 12; $i++)
                                @php 
                                    $c = $checksheets[$i] ?? null; 
                                    $absensiFiles = $c && $c->lampirans ? $c->lampirans->where('jenis_lampiran', 'absensi') : collect();
                                @endphp
                                <td style="min-width:280px">
                                    <input type="file" name="lampiran_absensi[{{ $i }}][]" multiple class="form-control form-control-sm mb-2">

                                    @foreach ($absensiFiles as $lampiran)
                                        @php 
                                            $ext = pathinfo($lampiran->file, PATHINFO_EXTENSION);
                                            $cleanPath = ltrim($lampiran->file, '/');
                                            $cleanPath = str_replace(['storage/', 'public/'], '', $cleanPath);
                                            if (!str_starts_with($cleanPath, 'lampiran/')) {
                                                $cleanPath = 'lampiran/' . basename($cleanPath);
                                            }
                                            $fileUrl = asset($cleanPath);
                                        @endphp
                                        <div class="lampiran-box">
                                            @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']))
                                                <img src="{{ $fileUrl }}" width="70" class="img-thumbnail mb-1" alt="Preview">
                                            @endif
                                            <div style="font-size:11px" class="text-truncate" title="{{ $lampiran->nama_file }}">
                                                {{ $lampiran->nama_file }}
                                            </div>
                                            <div class="d-flex gap-1 justify-content-center mt-1">
                                                <a href="{{ $fileUrl }}" target="_blank" class="btn btn-primary btn-sm py-0 px-2" style="font-size:10px;">Lihat</a>
                                                <a href="{{ $fileUrl }}" download="{{ $lampiran->nama_file }}" class="btn btn-success btn-sm py-0 px-2" style="font-size:10px;">Download</a>
                                                <button type="button" class="btn btn-danger btn-sm py-0 px-2" style="font-size:10px;" onclick="deleteLampiran('{{ route('monitoring_5r.lampiran.delete', $lampiran->id) }}')">Hapus</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </td>
                            @endfor
                        </tr>

                        {{-- LAMPIRAN PELAPORAN --}}
                        <tr>
                            <td>Lampiran Pelaporan</td>
                            @for ($i = 1; $i <= 12; $i++)
                                @php 
                                    $c = $checksheets[$i] ?? null; 
                                    $pelaporanFiles = $c && $c->lampirans ? $c->lampirans->where('jenis_lampiran', 'pelaporan') : collect();
                                @endphp
                                <td style="min-width:280px">
                                    <input type="file" name="lampiran_pelaporan[{{ $i }}][]" multiple class="form-control form-control-sm mb-2">

                                    @foreach ($pelaporanFiles as $lampiran)
                                        @php 
                                            $ext = pathinfo($lampiran->file, PATHINFO_EXTENSION);
                                            $cleanPath = ltrim($lampiran->file, '/');
                                            $cleanPath = str_replace(['storage/', 'public/'], '', $cleanPath);
                                            if (!str_starts_with($cleanPath, 'lampiran/')) {
                                                $cleanPath = 'lampiran/' . basename($cleanPath);
                                            }
                                            $fileUrl = asset($cleanPath);
                                        @endphp
                                        <div class="lampiran-box">
                                            @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']))
                                                <img src="{{ $fileUrl }}" width="70" class="img-thumbnail mb-1" alt="Preview">
                                            @endif
                                            <div style="font-size:11px" class="text-truncate" title="{{ $lampiran->nama_file }}">
                                                {{ $lampiran->nama_file }}
                                            </div>
                                            <div class="d-flex gap-1 justify-content-center mt-1">
                                                <a href="{{ $fileUrl }}" target="_blank" class="btn btn-primary btn-sm py-0 px-2" style="font-size:10px;">Lihat</a>
                                                <a href="{{ $fileUrl }}" download="{{ $lampiran->nama_file }}" class="btn btn-success btn-sm py-0 px-2" style="font-size:10px;">Download</a>
                                                <button type="button" class="btn btn-danger btn-sm py-0 px-2" style="font-size:10px;" onclick="deleteLampiran('{{ route('monitoring_5r.lampiran.delete', $lampiran->id) }}')">Hapus</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </td>
                            @endfor
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-center">
                <a href="{{ route('monitoring_5r.monitor', $data->folder_id) }}" class="btn btn-secondary mt-3 px-4 me-2">
                    ⬅️ Kembali
                </a>
                <button type="submit" class="btn btn-success mt-3 px-4">
                    💾 Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- FORM HIDDEN DELETE LAMPIRAN --}}
    <form id="deleteForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('custom-js')
    <script>
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function() {
                let td = this.closest('td');
                td.classList.remove('ok', 'nok');
                if (this.value === 'OK') {
                    td.classList.add('ok');
                } else if (this.value === 'NOK') {
                    td.classList.add('nok');
                }
            });
        });

        function deleteLampiran(url) {
            if (confirm('Hapus lampiran ini?')) {
                let form = document.getElementById('deleteForm');
                form.action = url;
                form.submit();
            }
        }
    </script>
@endsection