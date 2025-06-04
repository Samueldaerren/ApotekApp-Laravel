@extends('layouts.layout')
@section('content')
    <div class="container mt-3">
        <form action="{{ route('pembelian.store') }}" class="card m-auto p-5" method="POST">
            @csrf

            {{-- Display validation error messages --}}
            @if ($errors->any())
                <ul class="alert alert-danger p-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            @if (Session::get('failed'))
                <div class="alert alert-danger">{{ Session::get('failed') }}</div>
            @endif

            <p>Penanggung Jawab : <b>{{ Auth::user()->name }}</b></p>

            <div class="mb-3 row">
                <label for="name_customer" class="col-sm-2 col-form-label">Nama Pembeli</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name_customer" name="name_customer">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="medicines" class="col-sm-2 col-form-label">Obat</label>
                <div class="col-sm-10">
                    <select name="medicines[]" id="medicines" class="form-select">
                        <option selected hidden disabled>---Pilih Obat---</option>
                        @foreach ($medicines as $item)
                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                        @endforeach
                    </select>
                    <div id="wrap-medicines"></div>
                    <p style="cursor: pointer;" class="text-primary" id="add-select">+ tambah obat</p>
                </div>
            </div>

            <button type="submit" class="btn btn-block btn-lg btn-primary">Konfirmasi Pembelian</button>
        </form>
    </div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    let no = 2;
    $("#add-select").on("click", function() {
        // Menambahkan elemen baru dengan Flexbox
        let html = `
            <br>
            <div class="medicine-group d-flex justify-content-between align-items-center mb-2">
                <select name="medicines[]" class="form-select w-75">  
                    <option selected hidden disabled>Pesanan ${no}</option>
                    @foreach ($medicines as $item)
                        <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-danger btn-sm remove-select">X</button>
            </div>
        `;
        $("#wrap-medicines").append(html);
        no++;
    });

    $(document).on("click", ".remove-select", function() {
        $(this).closest(".medicine-group").remove();
        no--;
        // Menyesuaikan ulang nomor urut setelah penghapusan
        $(".medicine-group").each(function(index) {
            $(this).find("select").find("option:first").text(`Pesanan ${index + 1}`);
        });
    });
</script>
@endpush
