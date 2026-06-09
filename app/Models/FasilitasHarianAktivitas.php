<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FasilitasHarianAktivitas extends Model
{
    protected $table = 'fasilitas_harian_aktivitas';

    protected $fillable = [
        'item_id',
        'aktivitas'
    ];

    public function item()
    {
        return $this->belongsTo(
            FasilitasHarianItem::class,
            'item_id'
        );
    }
}