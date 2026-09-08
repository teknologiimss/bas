<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsumableFolder extends Model
{
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(ConsumableItem::class);
    }
}
