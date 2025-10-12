<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase_Orderluar extends Model
{
    use HasFactory;
    protected $table = 'purchase_orderluar';
    protected $fillable = [
        'vendor_id',
        'tipe',
        'no_poluar',
        'proyek_id',
        'pr_id',
        'tanggal_poluar',
        'reference',
        'rfq',
        'quotation',
        'no_nego',
        'final_quotation',
        'batas_poluar',
        'keterangan_nama',
        'signature_imss',
        'signature_vendor',
        'delivery',
        'shipment',
        'delivery_term',
        'destination',
        'payment',
        'nomor_lppb',
        'tanggal_lppb',

    ];


    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}
