@extends('layouts.main')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">
@section('content')
    <div class="container py-4">
        <div class="card p-4 border-0 shadow-sm rounded-4 mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h3>📋 {{ $chiller->judul }}</h3>
                    <p class="text-muted mb-0">Jenis Perawatan: <strong>{{ $chiller->jenis_perawatan }}</strong> | No
                        Chiller: <strong>{{ $chiller->no_chiller }}</strong></p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('chiller.index') }}" class="btn btn-secondary">Kembali</a>
                    <a href="{{ route('chiller.mobile', $chiller->id) }}" class="btn btn-success">📱 Input Inspeksi</a>
                    <a href="{{ route('chiller.print', $chiller->id) }}" target="_blank" class="btn btn-primary">🖨️ Cetak
                        PDF</a>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th>Uraian Pekerjaan</th>
                            <th>Aktivitas Pekerjaan</th>
                            <th>Standar</th>
                            <th width="10%">Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chiller->items as $item)
                            <tr>
                                <td class="text-center">{{ $item->nomor }}</td>
                                <td><strong>{{ $item->uraian_pekerjaan }}</strong></td>
                                <td>{{ $item->aktivitas_pekerjaan }}</td>
                                <td>{{ $item->standar }}</td>
                                <td class="text-center">
                                    @if ($item->status == 'OK')
                                        <span class="badge bg-success">OK</span>
                                    @elseif($item->status == 'NOK')
                                        <span class="badge bg-danger">NOK</span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>
                                <td>{{ $item->keterangan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
