<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengirimanDetail extends Model
{
    use HasFactory;
    protected $table = 'pengiriman_detail';
    protected $fillable = [
        'pengiriman_id',
        'trainset',
        'tipe_kereta',
        'nomor_lambung',
        'batch',
        'trucking',
        'nopol',
        'no_sjn',
        'code_armada',
        'plan_delivery',
        'actual_delivery',
        'leadtime_delivery',
        'status_delivery',
        'loading_truck',
        'loading_vessel',
        'plan_unloading',
        'actual_unloading',
        'leadtime_unloading',
        'vendor',
        'keterangan',

        
    ];
}
