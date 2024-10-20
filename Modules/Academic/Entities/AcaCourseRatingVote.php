<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcaCourseRatingVote extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'user_id', 'rating'];

    protected static function newFactory()
    {
        return \Modules\Academic\Database\factories\AcaCourseRatingVoteFactory::new();
    }
}
