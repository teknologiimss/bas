<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecksheetSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'checksheet_id',
        'kode',
        'nama_section',
        'urutan'
    ];

    public function checksheet()
    {
        return $this->belongsTo(Checksheet::class);
    }

    public function items()
{
    return $this->hasMany(ChecksheetItem::class, 'section_id');
}
}