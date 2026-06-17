<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetMaintenance extends Model
{
    protected $fillable = [

        'asset_id',

        'tahun',

        'bulan',

        'minggu',

        'planning',

        'realisasi',

        'tanggal_realisasi'
    ];

    public function asset()
    {
        return $this->belongsTo(
            Asset::class
        );
    }
}