<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecksheetItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'nomor',
        'uraian',
        'aktivitas',
        'standar',
        'urutan'
    ];

    public function section()
    {
        return $this->belongsTo(ChecksheetSection::class);
    }

    public function result()
    {
        return $this->hasOne(ChecksheetResult::class, 'item_id');
    }

    public function details()
    {
        return $this
            ->hasMany(ChecksheetItemDetail::class, 'item_id')
            ->orderBy('urutan');
    }
}
