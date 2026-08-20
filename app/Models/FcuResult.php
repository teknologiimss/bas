<?php

// app/Models/FcuResult.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FcuResult extends Model
{
    protected $guarded = [];

    public function photos() {
        return $this->hasMany(FcuResultPhoto::class);
    }
}
