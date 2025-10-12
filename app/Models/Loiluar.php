<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loiluar extends Model
{
    use HasFactory;
    protected $table = 'loiluar';
    protected $fillable = [
        'nomor_loiluar',
        'id_pr',
        'nomor_pr',
        'lampiran',
        'vendor_id',
        'tanggal_loiluar',
        'batas_loiluar',
        'perihal',
        'penerima',
        'alamat',
        'keterangan_loiluar',
        'nomor_po',
        'tanggal_po',
    ];
}
