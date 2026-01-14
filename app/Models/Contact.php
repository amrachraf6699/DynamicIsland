<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'subject', 'message',
        'replied_at', 'reply_message', 'reply_user_id', 'is_read',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
        'is_read' => 'boolean',
    ];

    public function replier()
    {
        return $this->belongsTo(User::class, 'reply_user_id');
    }
}

