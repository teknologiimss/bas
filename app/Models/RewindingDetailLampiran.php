<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewindingDetailLampiran extends Model
{
    protected $fillable = [

        'rewinding_detail_id',

        'file',

        'nama_file'

    ];

    public function detail()
    {
        return $this->belongsTo(
            RewindingDetail::class
        );
    }
}
