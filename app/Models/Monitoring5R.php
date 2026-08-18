<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoring5R extends Model
{
    use HasFactory;

    protected $table = 'monitoring_5rs';

    protected $fillable = [
        'folder_id',
        'deskripsi_pekerjaan',
        'nomor_kontrak',
        'tanggal_kontrak',
        'selesai_kontrak',
        'keterangan',
    ];

    public function folder()
    {
        return $this->belongsTo(FolderMonitoring5R::class, 'folder_id');
    }

    public function checksheets()
    {
        return $this->hasMany(Checksheet5R::class, 'monitoring_5r_id');
    }
}
