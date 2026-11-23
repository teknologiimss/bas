<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanHarianFasilitasItem extends Model
{
    use HasFactory;

    protected $table = 'laporan_harian_fasilitas_items';

    protected $fillable = [
        'laporan_id',
        'kelompok',
        'sub_kategori',
        'deskripsi',
        'sub_items',
        'urutan',
    ];

    protected $casts = [
        'sub_items' => 'array',
    ];

    public function laporan()
    {
        return $this->belongsTo(LaporanHarianFasilitas::class, 'laporan_id');
    }
}
