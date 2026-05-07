<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checksheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'unit',
        'no_lambung',
        'tanggal',
        'jenis_perawatan'
    ];

    // relasi ke section
    public function sections()
    {
        return $this->hasMany(ChecksheetSection::class)->orderBy('urutan');
    }
}