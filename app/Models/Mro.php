<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mro extends Model
{
    use HasFactory;
    protected $table = 'mro';
    protected $fillable = [
        'po_nodin',
        'judul_pekerjaan',
        'jenis_pekerjaan',
        'tanggal_kontrak',
        'selesai_kontrak',
        'customer',
        'keterangan',
        
        
    ];
}
