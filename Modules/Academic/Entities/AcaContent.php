<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcaContent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'section_id',
        'content_type_id',
        'name',
        'content_url',
        'original_name',
        'status',
        'count',
        'created_by',
        'updated_by'
    ];

    protected static function newFactory()
    {
        return \Modules\Academic\Database\factories\AcaContentFactory::new();
    }
}
