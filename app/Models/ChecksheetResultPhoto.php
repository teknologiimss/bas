<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecksheetResultPhoto extends Model
{
    protected $fillable = [
        'result_id',
        'foto'
    ];

    public function result()
    {
        return $this->belongsTo(
            ChecksheetResult::class,
            'result_id'
        );
    }
}
