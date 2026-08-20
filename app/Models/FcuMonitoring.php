<?php

// app/Models/FcuMonitoring.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FcuMonitoring extends Model
{
    protected $guarded = [];

    public function sections() {
        return $this->hasMany(FcuSection::class);
    }

    public function unscheduledForm() {
        return $this->hasOne(FcuUnscheduledForm::class);
    }

    public function notes() {
        return $this->hasMany(FcuNote::class);
    }
}
