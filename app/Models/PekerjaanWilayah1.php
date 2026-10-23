<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PekerjaanWilayah1 extends Model
{
    use HasFactory;

    protected $table = 'pekerjaan_wilayah1s';
    protected $fillable = ['nama_proyek', 'no_kontrak', 'tanggal_kontrak', 'tanggal_selesai_kontrak'];

    public function items()
    {
        return $this->hasMany(PekerjaanWilayah1Item::class, 'pekerjaan_wilayah1_id');
    }
}
