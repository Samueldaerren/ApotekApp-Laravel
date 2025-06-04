@extends('layouts.layout')
@section('content')
    <form action="{{ route('login.auth') }}" class="card p-5" method="POST">
        @csrf
        @if (Session::get('failed'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ Session::get('failed') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="mb-3">
            <label for="email" class="form-label">Input Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Input Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-success" type="submit">LoGiN</button>
    </form>
@endsection
