<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasbon extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'po_nota_dinas',
        'deskripsi',
        'tanggal',
        'uang_masuk',
        'uang_keluar',
        'dokumen',
        'keterangan',
    ];
}
