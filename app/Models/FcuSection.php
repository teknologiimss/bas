<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FcuSection extends Model
{
    protected $guarded = [];

    public function items() {
        return $this->hasMany(FcuItem::class);
    }
}
