<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mro extends Model
{
    use HasFactory;

    protected $table = 'mro';
    protected $primaryKey = 'mro_id';   // ← TAMBAHKAN INI
    public $incrementing = true;
    protected $keyType = 'int';
    

    protected $fillable = [
        
        'mro_code',
        'mro_name',
        'spesifikasi',
        'stock',
        'satuan',
        'proyek',
        'category_id',
        'barcode',
    ];
}
