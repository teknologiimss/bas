<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatAngkutLampiran extends Model
{
    use HasFactory;

    protected $fillable = [
        'checksheet_id',
        'file',
        'nama_file'
    ];

    public function checksheet()
    {
        return $this->belongsTo(AlatAngkutChecksheet::class, 'checksheet_id');
    }
}