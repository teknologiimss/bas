<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PekerjaanMroItem extends Model
{
    use HasFactory;

    protected $table = 'pekerjaan_mro_items';

    protected $fillable = [
        'pekerjaan_mro_id',
        'item_pekerjaan',
        'satuan',
        'vol_rencana',
        'harga_satuan',
        'progress_mingguan'
    ];

    protected $casts = [
        'progress_mingguan' => 'array',
    ];
}
