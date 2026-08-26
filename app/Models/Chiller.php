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
        'no_aset',
        'lokasi',
        'no_chiller',
        'tanggal_pelaksanaan',
        'durasi_pekerjaan',
        'personil',
        'kesimpulan',
        'catatan',
        'dokumen',  // <--- Tambahkan baris ini
    ];

    public function items()
    {
        return $this->hasMany(ChillerItem::class);
    }
}
