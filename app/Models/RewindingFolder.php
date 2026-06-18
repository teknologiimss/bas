<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewindingFolder extends Model
{
    protected $fillable = [
        'nama_folder'
    ];

    public function rewindings()
    {
        return $this->hasMany(
            Rewinding::class
        );
    }
}