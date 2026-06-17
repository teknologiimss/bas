<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'unit',
        'no_lambung',
        'lokasi'
    ];

    public function maintenances()
    {
        return $this->hasMany(
            AssetMaintenance::class
        );
    }
}