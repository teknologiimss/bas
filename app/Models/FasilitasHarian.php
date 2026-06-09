<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FasilitasHarian extends Model
{
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(
            FasilitasHarianItem::class
        )->orderBy('nomor');
    }

    public function getJumlahItemAttribute()
    {
        return $this->items()->count();
    }
}