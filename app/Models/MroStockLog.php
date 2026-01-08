<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MroStockLog extends Model
{
    protected $fillable = [
        'mro_id', 'barcode', 'type', 'qty',
        'stock_before', 'stock_after', 'proyek', 'user','spp'
    ];

    public function mro()
    {
        return $this->belongsTo(Mro::class, 'mro_id');
    }
}
