<?php

namespace Modules\Investigation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InveThesisStudentIndex extends Model
{
    use HasFactory;

    protected $fillable = [
        'thesis_id',
        'prefix',
        'content',
        'position',
        'item_id',
        'page',
        'type'
    ];

    protected static function newFactory()
    {
        return \Modules\Investigation\Database\factories\InveThesisStudentIndexFactory::new();
    }
}
