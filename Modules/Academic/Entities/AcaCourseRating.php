<?php

namespace Modules\Academic\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcaCourseRating extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'rating', 'voters'];

    protected static function newFactory()
    {
        return \Modules\Academic\Database\factories\AcaCourseRatingFactory::new();
    }
}
