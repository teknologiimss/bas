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
        'keterangan',
        'progress',
        'keterangan2',
    ];

    public function proyek()
    {
        return $this->belongsTo(Proyek::class);
    }

    public function documents()
    {
        return $this->hasMany(MonitoringDocument::class);
    }

    // public function documents_group()
    // {
    //     return $this->hasMany(DocumentsGroup::class, 'monitor_id');
    // }




    /**
     * Hitung progress persen otomatis berdasarkan dokumen
     */
    public function calculateProgress(): int
    {
        $progress = 0;

        $docs = $this->documents->pluck('nama_dokumen')->map(fn($d) => strtolower($d));

        if ($docs->contains(fn($d) => str_contains($d, 'nota'))) {
            $progress += 15;
        }

        if ($docs->contains(fn($d) => str_contains($d, 'purchase') || str_contains($d, 'po'))) {
            $progress += 15;
        }

        if ($docs->contains(fn($d) =>
                str_contains($d, 'foto') ||
                str_contains($d, 'dokumen') ||
                str_contains($d, 'laporan'))) {
            $progress += 60;
        }

        if ($docs->contains(fn($d) => str_contains($d, 'bakp'))) {
            $progress += 10;
        }

        return min($progress, 100);
    }

    public function folders()
    {
        return $this->hasMany(Folder::class, 'monitor_id');
    }
}
