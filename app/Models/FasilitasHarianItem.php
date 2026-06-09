<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FasilitasHarianItem extends Model
{
    protected $guarded = [];

    public function checksheet()
    {
        return $this->belongsTo(
            FasilitasHarian::class
        );
    }

    public function results()
    {
        return $this->hasMany(
            FasilitasHarianResult::class,
            'item_id'
        );
    }

    public function aktivitas()
    {
        return $this->hasMany(
            FasilitasHarianAktivitas::class,
            'item_id'
        );
    }
}
