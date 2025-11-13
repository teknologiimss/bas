<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringDocument extends Model
{
    use HasFactory;
    protected $table = 'monitoring_documents';
    protected $fillable = [
        'monitoring_id',
        'nama_dokumen',
        'file_path'
    ];

    public function monitoring()
    {
        return $this->belongsTo(Monitoring::class);
    }
}
