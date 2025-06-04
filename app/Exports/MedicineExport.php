<?php

namespace App\Exports;

use App\Models\Medicine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Carbon;  

class MedicineExport implements FromCollection, WithHeadings, WithMapping
{
    
    public function collection()
    {
        return Medicine::orderBy('created_at', 'DESC')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Obat',
            'Stock',
            'created_at'
        ];
    }

    public function map($medicine): array
    {
        Carbon::setLocale('id');
        $formattedDate = Carbon::parse($medicine->created_at)->translatedFormat('l, d-m-Y H:i:s');
    
        return [
            $medicine->id,                
            $medicine->name,              
            $medicine->stock,             
            $formattedDate                
        ];
    }
    
}
