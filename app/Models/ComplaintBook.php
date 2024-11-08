<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_register',
        'full_name',
        'dni_number',
        'telephone',
        'email',
        'ubigeo',
        'address',
        'serie',
        'number',
        'amount',
        'type',
        'description',
        'details',
        'improvement',
        'registers_user_id',
        'attends_user_id',
        'status'
    ];
}
