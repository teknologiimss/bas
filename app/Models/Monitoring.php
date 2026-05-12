<?php

namespace App\Models;

use Carbon\Carbon;
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
        // 1. Jika BELUM ada PO → merah (nota dinas)
        if (!$this->hasPO()) {
            return '#ef4444';
        }

        // 2. Jika SUDAH 100% → hijau
        if ($this->progress >= 100) {
            return '#22c55e';
        }

        // 3. Jika SUDAH ada PO → orange cerah
        return '#feb938';
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
            $progress += 60;
        }

        // if ($docs->contains(fn($d) =>
        //         str_contains($d, 'ba') ||
        //         str_contains($d, 'berita acara'))) {
        //     $progress += 10;
        // }

        return min($progress, 100);
    }

    public function folders()
    {
        return $this->hasMany(Folder::class, 'monitor_id');
    }

    // public function notifKontrak()
    // {
    //     $today = Carbon::today();
    //     $mulai = Carbon::parse($this->tanggal_kontrak);
    //     $selesai = Carbon::parse($this->tanggal_selesai_kontrak);

    //     // Sudah lewat kontrak
    //     if ($today->gt($selesai)) {
    //         return [
    //             'text' => 'Kontrak Telah Berakhir',
    //             'class' => 'danger'
    //         ];
    //     }

    //     // Hampir habis <= 7 hari
    //     if ($today->diffInDays($selesai, false) <= 7) {
    //         return [
    //             'text' => 'Kontrak Akan Berakhir',
    //             'class' => 'warning'
    //         ];
    //     }

    //     // Belum mulai
    //     if ($today->lt($mulai)) {
    //         return [
    //             'text' => 'Kontrak Belum Dimulai',
    //             'class' => 'secondary'
    //         ];
    //     }

    //     // Sedang berjalan
    //     return [
    //         'text' => 'Kontrak Berjalan',
    //         'class' => 'success'
    //     ];
    // }

    public function notifKontrak()
    {
        $today = Carbon::today();
        $selesai = Carbon::parse($this->tanggal_selesai_kontrak);

        // STATUS CLOSED
        if (strtolower($this->status) == 'closed') {
            return [
                'text' => 'Kontrak Selesai',
                'class' => 'primary'
            ];
        }

        // SUDAH LEWAT
        if ($today->gt($selesai)) {
            return [
                'text' => 'Kontrak Telah Berakhir',
                'class' => 'danger'
            ];
        }

        // H-7
        if ($today->diffInDays($selesai, false) <= 7) {
            return [
                'text' => 'Kontrak Akan Berakhir',
                'class' => 'warning'
            ];
        }

        // NORMAL
        return [
            'text' => 'Kontrak Berjalan',
            'class' => 'success'
        ];
    }

    // public function notifMessage()
    // {
    //     $today = \Carbon\Carbon::today();

    //     $selesai = \Carbon\Carbon::parse($this->tanggal_selesai_kontrak);

    //     $sisa = $today->diffInDays($selesai, false);

    //     // EXPIRED
    //     if ($sisa < 0) {
    //         return [
    //             'message' => 'Kontrak sudah expired',
    //             'class' => 'danger',
    //             'icon' => 'fas fa-times-circle'
    //         ];
    //     }

    //     // HARI INI
    //     if ($sisa == 0) {
    //         return [
    //             'message' => 'Kontrak berakhir hari ini',
    //             'class' => 'warning',
    //             'icon' => 'fas fa-exclamation-circle'
    //         ];
    //     }

    //     // H-7
    //     if ($sisa <= 7) {
    //         return [
    //             'message' => "Kontrak akan berakhir {$sisa} hari lagi",
    //             'class' => 'warning',
    //             'icon' => 'fas fa-bell'
    //         ];
    //     }

    //     return null;
    // }

    public function notifMessage()
    {
        $today = Carbon::today();

        $selesai = Carbon::parse($this->tanggal_selesai_kontrak);

        $sisa = $today->diffInDays($selesai, false);

        // STATUS CLOSED
        if (strtolower($this->status) == 'closed') {
            return [
                'message' => 'Kontrak telah selesai',
                'class' => 'primary',
                'icon' => 'fas fa-check-circle'
            ];
        }

        // EXPIRED
        if ($sisa < 0) {
            return [
                'message' => 'Kontrak sudah expired',
                'class' => 'danger',
                'icon' => 'fas fa-times-circle'
            ];
        }

        // HARI INI
        if ($sisa == 0) {
            return [
                'message' => 'Kontrak berakhir hari ini',
                'class' => 'warning',
                'icon' => 'fas fa-exclamation-circle'
            ];
        }

        // H-7
        if ($sisa <= 7) {
            return [
                'message' => "Kontrak akan berakhir {$sisa} hari lagi",
                'class' => 'warning',
                'icon' => 'fas fa-bell'
            ];
        }

        return null;
    }
}
