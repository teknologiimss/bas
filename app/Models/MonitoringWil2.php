<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringWil2 extends Model
{
    use HasFactory;

    protected $table = 'monitoringwil2s';

    protected $fillable = [
        'proyek_id', 'po_nota_dinas', 'nama_pekerjaan', 'jenis_pekerjaan',
        'tanggal_kontrak', 'tanggal_selesai_kontrak', 'status',
        'keterangan', 'progress', 'keterangan2'
    ];

    public function proyek()
    {
        return $this->belongsTo(Proyek::class);
    }

    public function documents()
    {
        return $this->hasMany(MonitoringWil2Document::class, 'monitoringwil2_id')->orderBy('position', 'asc');
    }

    public function calculateProgress(): int
    {
        $progress = 0;
        $docs = $this->documents->pluck('nama_dokumen')->map(fn($d) => strtolower($d));

        if ($docs->contains(fn($d) => str_contains($d, 'po') || str_contains($d, 'nota dinas') || str_contains($d, 'so'))) {
            $progress += 30;
        }
        if ($docs->contains(fn($d) => str_contains($d, 'purchase request') || str_contains($d, 'pr') || str_contains($d, 'memo'))) {
            $progress += 10;
        }
        if ($docs->contains(fn($d) => str_contains($d, 'dokumen') || str_contains($d, 'administrasi'))) {
            $progress += 60;
        }

        return min($progress, 100);
    }

    public function progressColor(): string
    {
        if ($this->progress >= 100)
            return '#22c55e';
        return '#feb938';
    }

    public function notifKontrak(): array
    {
        if ($this->status === 'Closed') {
            return [
                'text' => 'Kontrak Selesai',
                'class' => 'primary'
            ];
        }

        if (!$this->tanggal_selesai_kontrak) {
            return [
                'text' => '-',
                'class' => 'secondary'
            ];
        }

        $today = Carbon::today();
        $endDate = Carbon::parse($this->tanggal_selesai_kontrak)->startOfDay();
        $diffInDays = (int) $today->diffInDays($endDate, false);

        if ($diffInDays < 0) {
            return [
                'text' => 'Kontrak Telah Berakhir',
                'class' => 'danger'
            ];
        } elseif ($diffInDays <= 7) {
            return [
                'text' => 'Akan Berakhir (H-' . $diffInDays . ')',
                'class' => 'warning'
            ];
        }

        return [
            'text' => 'Kontrak Berjalan',
            'class' => 'success'
        ];
    }
}
