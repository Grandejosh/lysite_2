<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SetModulePermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'permission_id',
        'status'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Setting\Database\factories\SetModulePermissionFactory::new();
    }
}
