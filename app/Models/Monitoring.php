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

    /**
     * Ambil semua nama dokumen lowercase
     */
    private function getDocumentNames()
    {
        return $this
            ->documents
            ->pluck('nama_dokumen')
            ->map(fn($d) => strtolower($d));
    }

    /**
     * Cek Nota Dinas
     */
    public function hasNotaDinas(): bool
    {
        $docs = $this->getDocumentNames();

        return $docs->contains(fn($d) =>
            str_contains($d, 'nota') ||
            str_contains($d, 'nota dinas'));
    }

    /**
     * Cek PO
     */
    // public function hasPO(): bool
    // {
    //     $docs = $this->getDocumentNames();
    //     return $docs->contains(fn($d) =>
    //         str_contains($d, 'purchase order') ||
    //         str_contains($d, 'po'));
    // }
    public function hasPO(): bool
    {
        $docs = $this->getDocumentNames();

        return $docs->contains(function ($d) {
            return str_contains($d, 'purchase order') ||
                preg_match('/\bpo\b/i', $d) ||  // po (kata utuh)
                preg_match('/p\.o/i', $d) ||  // P.O
                preg_match('/po[-\s]?\d+/i', $d);  // PO-123 / PO 123
        });
    }

    /**
     * Logic warna progress bar
     */
    public function progressColor(): string
    {
        // 1. Jika BELUM ada PO → selalu merah (fase nota dinas)
        if (!$this->hasPO()) {
            return 'bg-danger';
        }

        // 2. Jika SUDAH 100% → hijau
        if ($this->progress >= 100) {
            return 'bg-success';
        }

        // 3. Jika SUDAH ada PO → orange
        return 'bg-orange';
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

        if ($docs->contains(fn($d) =>
                str_contains($d, 'po') ||
                str_contains($d, 'nota dinas') ||
                str_contains($d, 'purchase order'))) {
            $progress += 30;
        }

        // if ($docs->contains(fn($d) => str_contains($d, 'purchase order') || str_contains($d, 'po'))) {
        //     $progress += 15;
        // }


        // if ($docs->contains(fn($d) => str_contains($d, 'purchase request') || str_contains($d, 'pr'))) {
        //     $progress += 10;
        // }


        if ($docs->contains(fn($d) =>
                str_contains($d, 'purchase request') ||
                str_contains($d, 'pr') ||
                str_contains($d, 'spp'))) {
            $progress += 10;
        }

        // if ($docs->contains(fn($d) => str_contains($d, 'surat jalan') || str_contains($d, 'sjn'))) {
        //     $progress += 10;
        // }

        

        if ($docs->contains(fn($d) =>
                
                str_contains($d, 'dokumen') ||
                str_contains($d, 'administrasi'))) {
            $progress += 50;
        }

        if ($docs->contains(fn($d) =>
                str_contains($d, 'ba') ||
                str_contains($d, 'berita acara'))) {
            $progress += 10;
        }

        return min($progress, 100);
    }

    public function folders()
    {
        return $this->hasMany(Folder::class, 'monitor_id');
    }
}
