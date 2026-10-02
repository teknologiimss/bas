<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyekWil2 extends Model
{
    use HasFactory;

    protected $table = 'proyek_wil2s';
    protected $fillable = ['nama_proyek'];
}