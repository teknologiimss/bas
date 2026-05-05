<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatAngkutDetail extends Model
{
    protected $fillable = [
        'alat_id',
        'unit',
        'no_lambung',
        'kapasitas',
        'lokasi',
        'no_kontrak',
        'aset',
        'model_sn',
        'tgl_kontrak',
        'tgl_habis',
        'kontrak_dgn',
        'thn_kedatangan'
    ];

    public function alat()
    {
        return $this->belongsTo(AlatAngkut::class, 'alat_id');
    }

    public function checksheets()
    {
        return $this->hasMany(AlatAngkutChecksheet::class, 'detail_id');
    }
}
