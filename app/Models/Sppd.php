<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sppd extends Model
{
    use HasFactory;

    protected $table = 'sppd';

    protected $fillable = [
        'kode_proyek',
        'tujuan',
        'keperluan',
        'lama_perjalanan',
        'terhitung_mulai',
        'terhitung_selesai',
        // 'id_user',
        'lampiran',
        'status',
    'keterangan_status',
        'is_read'
    ];

  public function detailSppd()
    {
        return $this->hasMany(DetailSppd::class, 'id_sppd', 'id');
    }
}
