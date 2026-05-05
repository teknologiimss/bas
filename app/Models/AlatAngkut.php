<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatAngkut extends Model
{
    protected $fillable = ['nama_proyek'];

    public function details()
    {
        return $this->hasMany(AlatAngkutDetail::class, 'alat_id');
    }
}
