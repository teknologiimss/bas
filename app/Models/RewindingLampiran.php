<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewindingLampiran extends Model
{
    protected $fillable = [
        'rewinding_id',
        'tipe',
        'file',
        'nama_file'
    ];

    public function rewinding()
    {
        return $this->belongsTo(Rewinding::class);
    }
}