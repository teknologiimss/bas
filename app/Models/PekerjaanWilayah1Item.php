<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PekerjaanWilayah1Item extends Model
{
    use HasFactory;

    protected $table = 'pekerjaan_wilayah1_items';
    protected $fillable = ['pekerjaan_wilayah1_id', 'item_pekerjaan', 'satuan', 'vol_rencana', 'harga_satuan', 'progress_utama', 'progress_mingguan'];
    protected $casts = ['progress_mingguan' => 'array'];
}
