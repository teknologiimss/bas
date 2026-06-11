<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecksheetResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'detail_id',
        'status',
        'keterangan'
    ];

    public function item()
    {
        return $this->belongsTo(
            ChecksheetItem::class,
            'item_id'
        );
    }

    public function detail()
    {
        return $this->belongsTo(
            ChecksheetItemDetail::class,
            'detail_id'
        );
    }

    public function photos()
    {
        return $this->hasMany(
            ChecksheetResultPhoto::class,
            'result_id'
        );
    }
}
