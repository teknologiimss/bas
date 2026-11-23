<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanHarianFasilitas extends Model
{
    use HasFactory;

    protected $table = 'laporan_harian_fasilitas';

    protected $fillable = [
        'tanggal',
        'judul',
        'catatan',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(LaporanHarianFasilitasItem::class, 'laporan_id')->orderBy('urutan');
    }

    public function itemsKelompokA()
    {
        return $this
            ->hasMany(LaporanHarianFasilitasItem::class, 'laporan_id')
            ->where('kelompok', 'A')
            ->orderBy('urutan');
    }

    public function itemsKelompokB()
    {
        return $this
            ->hasMany(LaporanHarianFasilitasItem::class, 'laporan_id')
            ->where('kelompok', 'B')
            ->orderBy('urutan');
    }

    public function teams()
    {
        return $this->hasMany(LaporanHarianFasilitasTeam::class, 'laporan_id')->orderBy('urutan');
    }

    public function getTanggalIndoAttribute(): string
    {
        return Carbon::parse($this->tanggal)->locale('id')->translatedFormat('l, d F Y');
    }
}
