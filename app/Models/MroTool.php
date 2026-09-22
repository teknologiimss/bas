<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MroTool extends Model
{
    use HasFactory;

    protected $table = 'mro_tools';

    protected $fillable = [
        'position',
        'nama_tools',
        'spesifikasi',
        'qty',
        'satuan',
        'kondisi',
        'keterangan',
        'jenis',
        'gambar',
    ];
}