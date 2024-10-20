<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Universities extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'siglas',
        'country',
        'private',
        'department_id',
        'province_id',
        'district_id'
    ];

    public function universities_schools()
    {
        return $this->hasMany(UniversitiesSchools::class);
    }
}
