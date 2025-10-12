<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailNegoluar extends Model
{
    use HasFactory;
    protected $table = 'detail_negoluar';
    protected $fillable = [
        'id_del_negoluar',
        'negoluar_id',
        'id_pr',
        'id_detail_pr',
        'negoluar_qty',
        'harga',
        'harga_imss',
    ];
}
