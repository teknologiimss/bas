<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyekWil1 extends Model
{
    use HasFactory;

    protected $table = 'proyek_wil1s';
    protected $fillable = ['nama_proyek'];
}