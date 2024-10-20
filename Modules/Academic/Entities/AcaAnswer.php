<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcaAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'answer_text',
        'user_id'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Academic\Database\factories\AcaAnswerFactory::new();
    }
}
