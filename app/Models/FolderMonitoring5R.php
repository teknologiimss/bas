<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FolderMonitoring5R extends Model
{
    use HasFactory;

    protected $table = 'folder_monitoring_5rs';
    protected $fillable = ['tahun', 'nama_folder'];

    public function items()
    {
        return $this->hasMany(Monitoring5R::class, 'folder_id');
    }
}