<?php

namespace App\Exports;

use App\Models\Mro;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangMroExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Mro::select(
            'mro_code',
            'mro_name',
            'spesifikasi',
            'stock',
            'satuan',
            'proyek',
            
        )->get();
    }

    public function headings(): array
    {
        return [
            'Kode MRO',
            'Nama Barang',
            'Spesifikasi',
            'Stock',
            'Satuan',
            'Proyek',
            
        ];
    }
}
