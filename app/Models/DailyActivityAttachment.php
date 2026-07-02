<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyActivityAttachment extends Model
{
    protected $fillable=[
        'daily_activity_id',
        'file'
    ];
}
