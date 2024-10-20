<?php

namespace Modules\Chat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_ids',
        'message',
        'user_id',
        'receiver',
        'is_seen',
        'file',
        'file_name'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Chat\Database\factories\ChatMessageFactory::new();
    }
}
