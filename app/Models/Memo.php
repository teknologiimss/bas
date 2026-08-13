<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    use HasFactory;

    protected $fillable = [
        'monitoring_id',
        'monitoring_document_id',  // <-- Tambahkan baris ini
        'nomor_memo',
        'tanggal',
        'hal',
        'dari',
        'kepada',
        'pembuka',
        'isi_utama',
        'has_table',
        'catatan_note',
        'penutup',
        'jabatan_penandatangan',
        'nama_penandatangan',
        'ttd_path',  // 👈 Tambahkan ini
        'judul_lampiran',  // 👈 Tambahkan ini
        'lampiran_path',  // 👈 Tambahkan ini
        'pdf_path',
        // ...
    ];

    protected $guarded = ['id'];

    public function monitoring()
    {
        return $this->belongsTo(Monitoring::class, 'monitoring_id');
    }

    public function items()
    {
        return $this->hasMany(MemoItem::class, 'memo_id');
    }
}
