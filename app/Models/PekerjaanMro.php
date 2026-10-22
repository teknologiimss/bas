<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PekerjaanMro extends Model
{
    use HasFactory;

    protected $table = 'pekerjaan_mros';
    protected $fillable = ['nama_proyek', 'no_kontrak'];

    public function items()
    {
        return $this->hasMany(PekerjaanMroItem::class, 'pekerjaan_mro_id');
    }
}
