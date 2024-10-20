<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'identity_document_type_id',
        'number',
        'names',
        'last_name_father',
        'last_name_mother',
        'full_name',
        'address',
        'mobile_phone',
        'sex',
        'birth_date',
        'email',
        'department_id',
        'province_id',
        'district_id',
        'user_id',
        'country_id',
        'university_id',
        'allowed_thesis',
        'paraphrase_allowed',
        'paraphrase_used'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function student()
    {
        return $this->hasOne(\Modules\Academic\Entities\AcaStudent::class, 'person_id');
    }
}
