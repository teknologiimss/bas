<?php

// app/Models/FcuItem.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FcuItem extends Model
{
    protected $guarded = [];

    public function details() {
        return $this->hasMany(FcuDetail::class);
    }
}
