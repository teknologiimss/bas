<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CutiTahunan extends Model
{
    protected $table = 'cuti_tahunans';

    protected $fillable = [

        'nama_pegawai',
        'tahun',
        'jatah',
        'carry_over',
        'tambahan',
        'pengurangan'

    ];
}