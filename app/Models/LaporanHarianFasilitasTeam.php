<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanHarianFasilitasTeam extends Model
{
    use HasFactory;

    protected $table = 'laporan_harian_fasilitas_teams';

    protected $fillable = [
        'laporan_id',
        'nama_personil',
        'keterangan',
        'urutan',
    ];

    public function laporan()
    {
        return $this->belongsTo(LaporanHarianFasilitas::class, 'laporan_id');
    }
}
