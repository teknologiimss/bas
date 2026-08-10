<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'subject',
        'from_email',
        'from_name',
        'body_html',
        'body_text',
        'date_received',
        'is_read',
    ];

    protected $casts = [
        'date_received' => 'datetime',
        'is_read' => 'boolean',
    ];
}