<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringWil1Document extends Model
{
    use HasFactory;

    protected $table = 'monitoringwil1_documents';

    protected $fillable = [
        'monitoringwil1_id', 'position', 'nama_dokumen', 'file_path',
        'status', 'tanggal_closed', 'keterangan_closed'
    ];

    public function monitoring()
    {
        return $this->belongsTo(MonitoringWil1::class, 'monitoringwil1_id');
    }
}
