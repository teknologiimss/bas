<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PekerjaanWilayah2Item extends Model
{
    use HasFactory;

    protected $table = 'pekerjaan_wilayah2_items';
    protected $fillable = ['pekerjaan_wilayah2_id', 'item_pekerjaan', 'satuan', 'vol_rencana', 'harga_satuan', 'progress_utama', 'progress_mingguan'];
    protected $casts = ['progress_mingguan' => 'array'];
}
