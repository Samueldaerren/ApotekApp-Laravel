<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Carbon;

class UserExport implements FromCollection, WithHeadings, WithMapping
{
    
    public function collection()
    {
        return User::orderBy('created_at', 'DESC')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Email',
            'Role',
            'created_at',
        ];
    }

    public function map($user): array
    {
        Carbon::setLocale('id');
        $formattedDate = Carbon::parse($user->created_at)->translatedFormat('l, d-m-Y H:i:s');
    
        return [
            $user->id,                  
            $user->name,                  
            $user->email,                 
            $user->role,                  
            $formattedDate                
        ];
    }
    
}


