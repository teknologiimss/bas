<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyActivity extends Model
{
    protected $fillable = [
        'monitoring_id',
        'kegiatan',
        'status',
        'tanggal',
        'keterangan',
        'personil'
    ];

    protected $casts = [
        'personil' => 'array',
    ];

    public function monitoring()
    {
        return $this->belongsTo(Monitoring::class);
    }

    public function attachments()
    {
        return $this->hasMany(DailyActivityAttachment::class);
    }
}
