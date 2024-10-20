<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcaQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_id','question_text','user_id','replyed_status','question_title','email'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Academic\Database\factories\AcaQuestionFactory::new();
    }
}
