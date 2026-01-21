<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SppdLampiran extends Model
{
    use HasFactory;

    protected $table = 'sppd_lampiran';

    protected $fillable = [
        'sppd_id',
        'file',
        'tipe',
    ];

    public function Sppd()
    {
        return $this->belongsTo(Sppd::class, 'sppd_id');
    }
}
