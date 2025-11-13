<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    protected $table = 'proyeks';

    protected $fillable = [
        'nama_proyek'
    ];
}
