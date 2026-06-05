<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rewinding extends Model
{
    protected $fillable = [
        'no_sjn',
        'tanggal_sjn',
        'tanggal_masuk_sjn',
        'status',
        'deskripsi',
        'qty',
        'satuan',
        'keterangan',
        'lampiran',
        'nama_lampiran',
        'no_sppjp'
    ];
}