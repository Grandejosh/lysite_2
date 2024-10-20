<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcaSection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'status',
        'count',
        'created_by',
        'updated_by',
    ];

    protected static function newFactory()
    {
        return \Modules\Academic\Database\factories\AcaSectionFactory::new();
    }
}
