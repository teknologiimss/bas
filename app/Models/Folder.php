<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $fillable = [
        'monitor_id',
        'name'
    ];

    public function monitoring()
    {
        return $this->belongsTo(Monitoring::class, 'monitor_id');
    }

    public function documents()
    {
        return $this->hasMany(FolderDocument::class, 'folder_id');
    }
}

