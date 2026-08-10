@extends('layouts.main') {{-- Sesuaikan dengan layout utama aplikasi Anda --}}

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h3>Inbox Email (departemenmro@gmail.com)</h3>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('email.sync') }}" class="btn btn-primary">
                <i class="fas fa-sync-alt"></i> Sinkronkan Email
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 200px;">Pengirim</th>
                        <th>Subjek</th>
                        <th style="width: 180px;">Tanggal</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($emails as $email)
                        <tr class="{{ !$email->is_read ? 'font-weight-bold table-light' : '' }}">
                            <td>{{ $email->from_name ?? $email->from_email }}</td>
                            <td>
                                <a href="{{ route('email.show', $email->id) }}" class="text-dark">
                                    {{ Str::limit($email->subject, 60) }}
                                </a>
                            </td>
                            <td>{{ $email->date_received ? $email->date_received->format('d M Y, H:i') : '-' }}</td>
                            <td>
                                <a href="{{ route('email.show', $email->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Baca
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">Belum ada email tersimpan. Klik tombol "Sinkronkan Email".</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer text-right">
            {{ $emails->links() }}
        </div>
    </div>
</div>
@endsection