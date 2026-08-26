<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChillerItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function chiller()
    {
        return $this->belongsTo(Chiller::class);
    }

    public function photos()
    {
        return $this->hasMany(ChillerPhoto::class);
    }
}