<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rewinding extends Model
{
    protected $fillable = [
        'rewinding_folder_id',
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

    public function folder()
    {
        return $this->belongsTo(
            RewindingFolder::class,
            'rewinding_folder_id'
        );
    }
}
