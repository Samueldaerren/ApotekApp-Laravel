@extends('layouts.layout')
@section('content')
    <div class="container mt-5">
        <div class="card mx-auto shadow-sm" style="max-width: 800px;">
            <div class="card-body p-5">
                <form action="{{ route('medicine.edit.form' , $medicine->id) }}" method="POST">
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
                        <label for="name" class="form-label fs-5">Medicine Name:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Add your medicine" value="{{ $medicine['name'] }}">
                    </div>

                    <!-- Jenis Obat dan Stok Tersedia (Sejajar) -->
                    <div class="row mb-4">
                        <!-- Jenis Obat -->
                        <div class="col-md-6 w-100 ">
                            <label for="type" class="form-label fs-5">Medicine Type:</label>
                            <select class="form-select" id="type" name="type">
                                <option selected disabled hidden>Select</option>
                                <option value="tablet" {{$medicine['type'] == 'tablet' ? 'selected' : ''}}>Tablet</option>
                                <option value="sirup" {{$medicine['type'] == 'sirup' ? 'selected' : ''}}>sirup</option>
                                <option value="kapsul" {{$medicine['type'] == 'kapsul' ? 'selected' : ''}}>kapsul</option>
                            </select>
                        </div>

                        <!-- Stok Tersedia -->
                    </div>
                    <!-- Harga Obat -->
                    <div class="mb-4">
                        <label for="price" class="form-label fs-5">Medicine Price:</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Add Your Medicine Price" value="{{$medicine ['price'] }}">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100 btn-lg">Add Data</button>
                </form>
            </div>
        </div>
    </div>
@endsection
