<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumableItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'consumable_folder_id',
        'sub_header',
        'komponen',
        'spesifikasi',
        'jan', 'feb', 'mar', 'apr', 'mei', 'juni',
        'juli', 'agus', 'sept', 'okt', 'nov', 'des',
        'satuan',
        'keterangan'
    ];

    public function folder()
    {
        return $this->belongsTo(ConsumableFolder::class, 'consumable_folder_id');
    }

    // Accessor kalkulasi total per bulan
    public function getTotalAttribute()
    {
        return $this->jan + $this->feb + $this->mar + $this->apr
            + $this->mei + $this->juni + $this->juli + $this->agus
            + $this->sept + $this->okt + $this->nov + $this->des;
    }
}
