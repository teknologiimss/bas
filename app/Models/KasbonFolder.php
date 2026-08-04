<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\KasbonItem[] $items
 */

class KasbonFolder extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'po_nota_dinas'];

    public function items()
    {
        return $this->hasMany(KasbonItem::class, 'kasbon_folder_id');
    }
}
