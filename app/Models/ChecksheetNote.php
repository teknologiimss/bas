<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecksheetNote extends Model
{
    protected $fillable = [
        'checksheet_id',
        'catatan'
    ];

    public function checksheet()
    {
        return $this->belongsTo(Checksheet::class);
    }
}