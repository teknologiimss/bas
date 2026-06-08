<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rewinding extends Model
{
    protected $fillable = [

        'no_sjn',

        'tanggal_sjn_keluar',
        'lampiran_sjn_keluar',
        'nama_lampiran_keluar',

        'tanggal_sjn_masuk',
        'lampiran_sjn_masuk',
        'nama_lampiran_masuk',

        'deskripsi',

        'status',

        'keterangan',

        'no_sppjp'
    ];
}