<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipDokumen extends Model
{
    use HasFactory;

    protected $table = 'arsip_dokumen';
    protected $fillable = ['pr_id', 'nama_dokumen', 'file_path'];

    public function request()
    {
        return $this->belongsTo(PurchaseRequest::class, 'pr_id');
    }
}
