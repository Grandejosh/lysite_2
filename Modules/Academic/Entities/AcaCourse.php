<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcaCourse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'status',
        'course_image',
        'main_video',
        'created_by',
        'updated_by'
    ];

    protected static function newFactory()
    {
        return \Modules\Academic\Database\factories\AcaCourseFactory::new();
    }
}
