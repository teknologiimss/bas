<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    protected $table = 'proyeks';

    protected $fillable = [
        'nama_proyek'
    ];

    public function proyek()
{
    $data = Proyek::paginate(10); // atau all()

    return view('perencanaan.proyek', compact('data'));
}
}
