<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'proyek_id',
        'tipe',
        'kategori',
        'uraian',
        'qty',
        'satuan',
        'keterangan'
    ];

    public function lampiran()
    {
        return $this->hasMany(ItemLampiran::class);
    }
}
