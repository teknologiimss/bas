<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoiluarLampiran extends Model
{
    use HasFactory;

    protected $table = 'loiluar_lampiran';

    protected $fillable = [
        'loiluar_id',
        'file',
        'tipe',
    ];
}
