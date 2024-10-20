<?php

namespace Modules\Investigation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssistantGptFilesId extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'filename',
        'deleted',
    ];

    protected static function newFactory()
    {
        return \Modules\Investigation\Database\factories\AssistantGptFilesIdFactory::new();
    }
}
