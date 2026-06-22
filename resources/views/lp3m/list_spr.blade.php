@extends('layouts.main')

@section('title', 'List SPR')
<link rel="icon" href="{{ asset('img/logoimss.png') }}" type="image/png">

@section('content')

    <div class="container-fluid">

        <div class="card">

            <div class="card-header bg-danger text-white">
                @if ($status)
                    Data SPR {{ $status }}
                @else
                    Semua Data SPR
                @endif
            </div>

            <div class="card-body">

                <a href="{{ route('lp3m.dashboard') }}" class="btn btn-secondary mb-3">
                    Kembali Dashboard
                </a>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No SPR</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->spr_no }}</td>
                                    <td>{{ $item->deskripsi }}</td>
                                    <td>
                                        @if ($item->status == 'OPEN')
                                            <span class="badge badge-warning">OPEN</span>
                                        @else
                                            <span class="badge badge-success">CLOSED</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-3">
                    {{ $data->links() }}
                </div>

            </div>

        </div>

    </div>

@endsection
