<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecksheetItemDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    protected $table = 'checksheet_item_details';

    public function item()
    {
        return $this->belongsTo(
            ChecksheetItem::class,
            'item_id'
        );
    }

    public function result()
    {
        return $this->hasOne(
            ChecksheetResult::class,
            'detail_id'
        );
    }
}