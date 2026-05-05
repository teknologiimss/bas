<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatAngkutChecksheet extends Model
{
    use HasFactory;
    protected $fillable = [
        'detail_id',
        'bulan',
        'status',
        'tanggal',
        'keterangan'
    ];
}
