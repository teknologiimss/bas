@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <a href="{{ route('email.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Inbox
        </a>
    </div>

    <div class="card">
        <div class="card-header bg-white">
            <h4>{{ $email->subject }}</h4>
            <div class="text-muted small">
                Dari: <strong>{{ $email->from_name }}</strong> &lt;{{ $email->from_email }}&gt;<br>
                Tanggal: {{ $email->date_received ? $email->date_received->format('d F Y, H:i:s') : '-' }}
            </div>
        </div>
        <div class="card-body">
            {!! $email->body_html ?? nl2br(e($email->body_text)) !!}
        </div>
    </div>
</div>
@endsection