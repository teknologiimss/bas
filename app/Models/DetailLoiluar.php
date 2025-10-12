<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailLoiluar extends Model
{
    use HasFactory;
    protected $table = 'detail_loiluar';
    protected $fillable = [
        'loiluar_id',
        'id_del_loiluar',
        'id_detail_pr',
        'loiluar_qty',
        'harga',
        
    ];
}
