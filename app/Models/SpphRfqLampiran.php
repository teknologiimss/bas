<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpphRfqLampiran extends Model
{
    use HasFactory;

    protected $table = 'spphrfq_lampiran';

    protected $fillable = [
        'spphrfq_id',
        'file',
        'tipe',
    ];
}
