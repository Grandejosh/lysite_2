<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcaStudentsSectionProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id','section_id','content_id',
    ];

    protected static function newFactory()
    {
        return \Modules\Academic\Database\factories\AcaStudentsSectionProgressFactory::new();
    }
}
