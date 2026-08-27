<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PompaItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pompa()
    {
        return $this->belongsTo(Pompa::class, 'pompa_id');
    }

    public function photos()
    {
        return $this->hasMany(PompaPhoto::class, 'pompa_item_id');
    }
}