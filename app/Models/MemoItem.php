<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemoItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function memo()
    {
        return $this->belongsTo(Memo::class, 'memo_id');
    }
}