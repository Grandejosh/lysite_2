<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SetModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'logo',
        'label',
        'destination_route',
        'status'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Setting\Database\factories\SetModuleFactory::new();
    }
}
