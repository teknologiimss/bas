<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checksheet5R extends Model
{
    use HasFactory;

    protected $table = 'checksheet_5rs';
    protected $fillable = ['monitoring_5r_id', 'bulan', 'status', 'tanggal', 'keterangan'];

    public function lampirans()
    {
        return $this->hasMany(Lampiran5R::class, 'checksheet_5r_id');
    }

    public function monitoring5r()
    {
        return $this->belongsTo(Monitoring5R::class, 'monitoring_5r_id');
    }
}