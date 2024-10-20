<?php

namespace Modules\Investigation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InveThesisStudentPartSelectionComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'thesis_student_part_id',
        'thesis_student_id',
        'thesis_format_part_id',
        'selecction_text',
        'selecction_id',
        'commentary',
        'user_id',
    ];

    protected static function newFactory()
    {
        return \Modules\Investigation\Database\factories\InveThesisStudentPartSelectionCommentFactory::new();
    }
}
