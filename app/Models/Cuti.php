<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    protected $table = 'cuti';

    protected $fillable = [
        'user_id',
        'nama_pegawai',
        'jenis',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
        'lampiran',
        'jumlah_hari'
    ];

    
}
