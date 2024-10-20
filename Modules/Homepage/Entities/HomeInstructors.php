<?php

namespace Modules\Homepage\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomeInstructors extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_instructor',
        'image_path',
        'content',
        'career'
    ];

    protected static function newFactory()
    {
        return \Modules\Homepage\Database\factories\HomeInstructorsFactory::new();
    }
}
