<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NegoluarLampiran extends Model
{
    use HasFactory;
    protected $table = 'negoluar_lampiran';

    protected $fillable = [
        'negoluar_id',
        'file',
        'tipe',
    ];
}
