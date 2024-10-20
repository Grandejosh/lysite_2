<?php

namespace Modules\Homepage\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomeHistories extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'thesis_title',
        'year',
        'month',
        'career',
        'image_path',
        'university'
    ];

    protected static function newFactory()
    {
        return \Modules\Homepage\Database\factories\HomeHistoriesFactory::new();
    }
}
