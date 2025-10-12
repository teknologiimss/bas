<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negoluar extends Model
{
    use HasFactory;
    protected $table = 'negoluar';
    protected $fillable = [
        'nomor_negoluar',
        'id_pr',
        'nomor_pr',
        'lampiran',
        'vendor_id',
        'tanggal_negoluar',
        'batas_negoluar',
        'perihal',
        'penerima',
        'alamat',
        'no_jawaban_vendor',
        'franco',
        'keterangan_negoluar',
        'signature_imss',
    ];
}
