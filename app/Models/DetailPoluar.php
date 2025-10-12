<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPoluar extends Model
{
    use HasFactory;
    protected $table = 'detail_poluar';

    protected $fillable = [
        'id_poluar',
        'id_del_poluar',
        'id_pr',
        'id_detail_pr',
        'poluar_qty',
        'batas_akhir',
        'harga',
        'mata_uang',
        'vat',
        'is_accept',
    ];

    public function detailPr()
    {
        return $this->belongsTo(DetailPR::class, 'id_detail_pr');
    }
}
