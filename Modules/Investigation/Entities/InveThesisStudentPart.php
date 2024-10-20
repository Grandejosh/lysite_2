<?php

namespace Modules\Investigation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InveThesisStudentPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'inve_thesis_student_id',
        'inve_thesis_format_part_id',
        'content',
        'version',
        'state',
        'commentary_user_id',
        'commentary',
        'right_margin',
        'left_margin',
        'top_margin',
        'bottom_margin'
    ];

    protected static function newFactory()
    {
        return \Modules\Investigation\Database\factories\InveThesisStudentPartFactory::new();
    }
}
