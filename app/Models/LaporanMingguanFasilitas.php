<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanMingguanFasilitas extends Model
{
    use HasFactory;

    protected $table = 'laporan_mingguan_fasilitas';

    protected $fillable = [
        'tanggal_mulai',
        'tanggal_selesai',
        'judul',
        'catatan_mingguan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function getPeriodeLabelAttribute(): string
    {
        $mulai = Carbon::parse($this->tanggal_mulai)->locale('id');
        $selesai = Carbon::parse($this->tanggal_selesai)->locale('id');

        if ($mulai->month === $selesai->month && $mulai->year === $selesai->year) {
            return $mulai->translatedFormat('d') . ' - ' . $selesai->translatedFormat('d F Y');
        }

        if ($mulai->year === $selesai->year) {
            return $mulai->translatedFormat('d M') . ' - ' . $selesai->translatedFormat('d M Y');
        }

        return $mulai->translatedFormat('d M Y') . ' - ' . $selesai->translatedFormat('d M Y');
    }

    public function getBulanTahunAttribute(): string
    {
        return Carbon::parse($this->tanggal_selesai)->locale('id')->translatedFormat('F Y');
    }
}
