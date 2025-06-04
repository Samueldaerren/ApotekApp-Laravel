@extends('layouts.layout')

@section('content')
@if (Session::get('failed'))
    <div class="alert alert-danger">
        {{ Session::get('failed') }}
    </div>
    
@endif

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh; background-color: #f8f9fa;">
    <div class="text-center p-5 bg-white rounded shadow" style="max-width: 500px;">
        <h1 class="display-4 fw-normal mb-3">Selamat Datang {{ Auth::user()->name }}</h1>
        <p class="lead text-muted mb-4">Mulai pengalaman baru dengan antarmuka yang bersih dan elegan.</p>

        <a href="#" class="btn btn-primary btn-lg px-4">Mulai</a>
        <a href="#" class="btn btn-outline-secondary btn-lg px-4">Info</a>
    </div>
</div>
@endsection
