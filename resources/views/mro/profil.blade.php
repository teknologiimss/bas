@extends('layouts.main')

@section('title', 'Profil MRO')

@section('content')

    <div class="container mt-4">

        <div class="card shadow">
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0">
                    <i class="fas fa-video"></i>
                    Profil Personil MRO
                </h4>
            </div>

            <div class="card-body text-center">

                <video width="100%" controls autoplay muted loop playsinline>
                    <source src="{{ asset('video/personil.mp4') }}" type="video/mp4">
                    Browser tidak mendukung video.
                </video>

            </div>
        </div>

    </div>

@endsection
