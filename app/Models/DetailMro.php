<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailMro extends Model
{
    use HasFactory;
    protected $table = 'detail_mro';
    protected $fillable = [
        'mro_id',
        'nomor_dokumen',
        'tanggal_dokumen',
        'perihal',
        'keterangan',
        'lampiran',
    ];
}
