<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewindingDetail extends Model
{
    protected $fillable = [

        'rewinding_id',

        'tanggal',

        'status',

        'keterangan'

    ];

    public function rewinding()
    {
        return $this->belongsTo(
            Rewinding::class
        );
    }

    public function lampirans()
    {
        return $this->hasMany(
            RewindingDetailLampiran::class
        );
    }
}
