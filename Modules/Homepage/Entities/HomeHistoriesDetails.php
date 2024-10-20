<?php

namespace Modules\Homepage\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomeHistoriesDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'history_id',
        'detail'
    ];

    protected static function newFactory()
    {
        return \Modules\Homepage\Database\factories\HomeHistoriesDetailsFactory::new();
    }
}
