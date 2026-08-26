<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chiller extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'judul',
        'jenis_perawatan',
        'no_form_unscheduled',
        'no_aset',
        'lokasi',
        'no_chiller',
        'tanggal_pelaksanaan',
        'durasi_pekerjaan',
        'personil',
        'status_kondisi',
        'jenis_kerusakan',
        'tindak_lanjut',
        'kesimpulan',
        'catatan',
        'dokumen',
    ];

    public function items()
    {
        return $this->hasMany(ChillerItem::class);
    }
}