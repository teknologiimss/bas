<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FcuUnscheduledForm extends Model
{
    use HasFactory;

    protected $table = 'fcu_unscheduled_forms';

    protected $guarded = [];

    public function monitoring()
    {
        return $this->belongsTo(FcuMonitoring::class, 'fcu_monitoring_id');
    }
}