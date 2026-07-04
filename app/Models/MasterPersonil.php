<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterPersonil extends Model
{
    protected $fillable = [
        'nama',
        'nip',
        'status',
        'penempatan',
        'jabatan',
        'jobdesk',
        'spesialisasi',
        'catatan'
    ];
}
