<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrLampiran extends Model
{
    use HasFactory;

    protected $table = 'pr_lampiran';

    protected $fillable = [
        'pr_id',
        'file',
        'tipe',
    ];

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class, 'pr_id');
    }
}
