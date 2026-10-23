<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PekerjaanWilayah2 extends Model
{
    use HasFactory;

    protected $table = 'pekerjaan_wilayah2s';
    protected $fillable = ['nama_proyek', 'no_kontrak', 'tanggal_kontrak', 'tanggal_selesai_kontrak'];

    public function items()
    {
        return $this->hasMany(PekerjaanWilayah2Item::class, 'pekerjaan_wilayah2_id');
    }
}
