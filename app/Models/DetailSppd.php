<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSppd extends Model
{
    use HasFactory;

    protected $table = 'detail_sppd';

    protected $fillable = [
        'id_sppd',
        // 'user_id',
        'nama',
        'nip',
        'golongan',
        'unit_kerja',
        'hari',
        'tarif',
        'jumlah',
        'jenis_kendaraan',
        'tanggal',
        'lampiran',
        'id_del',
    ];

   
}
