<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSpphrfq extends Model
{
    use HasFactory;
    protected $table = 'detail_spphrfq';
    protected $fillable = [
          'spphrfq_id',
        'id_detail_pr',
        'spphrfq_qty',
        'id_del_spphrfq',
    ];
}
