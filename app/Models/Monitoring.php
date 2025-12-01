<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    use HasFactory;

    protected $fillable = [
        'proyek_id',
        'po_nota_dinas',
        'nama_pekerjaan',
        'jenis_pekerjaan',
        'tanggal_kontrak',
        'tanggal_selesai_kontrak',
        'status',
        'keterangan'
    ];

    public function proyek()
    {
        return $this->belongsTo(Proyek::class);
    }

    public function documents()
    {
        return $this->hasMany(MonitoringDocument::class);
    }
}
