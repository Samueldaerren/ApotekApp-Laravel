<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Carbon;  

class OrderExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Order::with('user')->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Kasir',
            'Daftar Obat',
            'Nama Pembeli',
            'Total Harga',
            'Tanggal'
        ];
    }

    public function map($order): array
    {
        $daftarObat = "";
        foreach ($order->medicines as $key => $value) {
            $obat = ($key + 1) . '. ' . $value['name_medicine'] . ' (' . $value['qty'] . ' pcs), ';
            $daftarObat .= $obat;
        }

         
        Carbon::setLocale('id');
        
        $formattedDate = Carbon::parse($order->created_at)->translatedFormat('l, d-m-Y H:i:s');

        return [
            $order->id,
            $order->user->name,
            rtrim($daftarObat, ', '),  
            $order->name_customer,
            "Rp. " . number_format($order->total_price, 0, ',', '.'),
            $formattedDate
        ];
    }
}
