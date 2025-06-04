@extends('layouts.layout')
@section('content')
    <div class="container mt-5">
        <div class="card mx-auto shadow-sm" style="max-width: 800px;">
            <div class="card-body p-5">
                <form action="{{ route('user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    @if (Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Nama Obat -->
                    <div class="mb-4">
                        <label for="name" class="form-label fs-5">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Add your Name" value="{{ $user['name'] }}">
                    </div>

                    <!-- Jenis Obat dan Stok Tersedia (Sejajar) -->
                    <div class="row mb-4">
                        <!-- Jenis Obat -->
                        <div class="col-md-6 w-100">
                            <label for="role" class="form-label fs-5 ">Role</label>
                            <select class="form-select" id="role" name="role">
                                <option selected disabled hidden>Select</option>
                                <option value="admin" {{$user['role'] == 'admin' ? 'selected' : ''}}>Admin</option>
                                <option value="cashier" {{$user['role'] == 'cashier' ? 'selected' : ''}}>Cashier</option>
                            </select>
                        </div>
                    </div>



                    <!-- Harga Obat -->
                    <div class="mb-4">
                        <label for="email" class="form-label fs-5">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Add Your Email" value="{{ $user['email'] }}">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label fs-5">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Add Your Password" value="{{ $user['password'] }}">
                    </div>



                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100 btn-lg">Add Data</button>
                </form>
            </div>
        </div>
    </div>
@endsection
