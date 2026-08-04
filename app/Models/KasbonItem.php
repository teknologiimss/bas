<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasbonItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'kasbon_folder_id',
        'deskripsi',
        'tanggal',
        'uang_masuk',
        'uang_keluar',
        'dokumen',
        'keterangan'
    ];

    /**
     * Konversi tipe data otomatis dari database.
     */
    protected $casts = [
        'dokumen' => 'array', // Mengubah simpanan JSON di DB otomatis jadi array PHP
        'tanggal' => 'date',  // Mengubah kolom tanggal jadi instance Carbon
    ];

    public function folder()
    {
        return $this->belongsTo(KasbonFolder::class, 'kasbon_folder_id');
    }
}