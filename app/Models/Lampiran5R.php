<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lampiran5R extends Model
{
    use HasFactory;

    protected $table = 'lampiran_5rs';

    protected $fillable = [
        'checksheet_5r_id',
        'jenis_lampiran',
        'file',
        'nama_file',
    ];

    public function checksheet()
    {
        return $this->belongsTo(Checksheet5R::class, 'checksheet_5r_id');
    }
}