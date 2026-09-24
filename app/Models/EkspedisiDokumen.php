<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EkspedisiDokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'deskripsi',
        'diterima_oleh',
        'tanggal',
        'keterangan',
        'file_dokumen',
    ];

    // Relasi ke User untuk mendapatkan nama pengirim
    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
