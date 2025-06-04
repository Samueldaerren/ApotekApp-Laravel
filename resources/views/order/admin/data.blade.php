@extends('layouts.layout')

@section('content')
    <div class="container mt-3">
        <a href="{{ route('pembelian.admin.export') }}" class="btn btn-success">Export Excel</a>  
        <form action="" method="GET" class="form-inline mt-3">
            <div class="input-group">
                <input type="date" class="form-control" name="search_order" value="{{ request('search_order') }}"
                 placeholder="Cari berdasarkan tanggal">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                    <a href="{{ route('pembelian.admin') }}" class="btn btn-outline-secondary" type="submit">Reset</a>
                </div>
            </div>
        </form>   
        <br>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pembeli</th>
                    <th>Obat</th>
                    <th>Total Harga</th>
                    <th>Tanggal Pembelian</th>
                    <th>Nama Kasir</th> 
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
                        <td>{{ $order['user']['name'] }}</td>
                    </tr>                
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end">{{ $orders->links() }}</div>
    </div>
@endsection
