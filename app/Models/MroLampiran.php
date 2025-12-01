<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MroLampiran extends Model
{
    use HasFactory;

    protected $table = 'mro_lampiran';

    protected $fillable = [
        'mro_id',
        'file',
        'tipe',
    ];
}
