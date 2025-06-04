@extends('layouts.layout')

@section('content')
    <div class="container mt-3">
        <div class="d-flex justify-content-end">
            <a href="{{ route('pembelian.formulir') }}" class="btn btn-primary">+ Tambah Pesanan</a>
        </div>
        <form action="{{ route('pembelian.index') }}" method="GET" class="form-inline mt-3">
            <div class="input-group">
                <input type="date" class="form-control" name="search_order" value="{{ request('search_order') }}"
                 placeholder="Cari berdasarkan tanggal">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                    <a href="{{ route('pembelian.index') }}" class="btn btn-outline-secondary" type="submit">Reset</a>
                </div>
            </div>
        </form>
        <h1>DATA PEMBELIAN : {{ Auth::user()->name }}</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pembeli</th>
                    <th>Obat</th>
                    <th>Total Harga</th>
                    <th>Tanggal Pembelian</th>
                    <th>Nama Kasir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $index => $order)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $order->name_customer }}</td>
                        <td>
                            <ol>
                                @foreach ($order->medicines as $medicine)
                                    <li>
                                        {{ $medicine['name_medicine'] }} ({{ $medicine['qty'] }}):
                                        {{ number_format($medicine['total_price'], 0, ',', '.') }}
                                    </li>
                                @endforeach
                            </ol>
                        </td> 
                        <td>{{ $order->total_price }}</td>
                        <td>{{ \Carbon\Carbon::create($order->created_at)->locale('id')->isoFormat('dddd, D MMMM YYYY H:mm:ss') }}</td>
                        <td>{{ Auth::user()->name }}</td>
                        <td>
                            {{-- <a href="{{ route('pembelian.print', $order->id) }}" class="btn btn-secondary">Cetak Struk</a> --}}
                            <a href="{{ route('pembelian.download_pdf', $order['id']) }}" class="btn btn-secondary">Cetak Struk</a>
                        </td>
                    </tr>                
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end">{{ $orders->links() }}</div>
    </div>
@endsection
