<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpphRfq extends Model
{
    use HasFactory;
    protected $table = 'spphrfq';
    protected $fillable = [
        'nomor_spphrfq',
        'id_pr',
        'nomor_pr',
        'lampiran',
        'vendor_id',
        'tanggal_spphrfq',
        'batas_spphrfq',
        'perihal',
        'penerima',
        'alamat',
        'keterangan_spphrfq',
    ];
}
