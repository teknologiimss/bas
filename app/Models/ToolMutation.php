<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolMutation extends Model
{
    use HasFactory;

    protected $fillable = [
        'mro_tool_id',
        'nama_peminjam',
        'qty_pinjam',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'keterangan',
    ];

    public function tool()
    {
        return $this->belongsTo(MroTool::class, 'mro_tool_id');
    }
}