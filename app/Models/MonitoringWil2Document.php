<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringWil2Document extends Model
{
    use HasFactory;

    protected $table = 'monitoringwil2_documents';

    protected $fillable = [
        'monitoringwil2_id',
        'position',
        'nama_dokumen',
        'file_path',
        'status',
        'tanggal_closed',
        'keterangan_closed',
        'jenis_dokumen',
        'harga',
        'kriteria',
    ];

    public function monitoring()
    {
        return $this->belongsTo(MonitoringWil2::class, 'monitoringwil2_id');
    }
}
