<?php

// app/Models/FcuDetail.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FcuDetail extends Model
{
    protected $guarded = [];

    // Relasi jamak (HasMany) untuk menampung data fcu1 dan fcu2
    public function results() {
        return $this->hasMany(FcuResult::class, 'fcu_detail_id');
    }

    // Tetap pertahankan relasi tunggal jika diperlukan di tempat lain
    public function result() {
        return $this->hasOne(FcuResult::class, 'fcu_detail_id');
    }
}