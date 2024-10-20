<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcaContentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'name'
    ];

    protected static function newFactory()
    {
        return \Modules\Academic\Database\factories\AcaContentTypeFactory::new();
    }
}
