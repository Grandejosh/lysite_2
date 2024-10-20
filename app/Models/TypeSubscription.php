<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'detail_one',
        'detail_two',
        'detail_three',
        'detail_four',
        'detail_five',
        'detail_six',
        'detail_seven',
        'detail_eight',
        'price',
        'dollar_price',
        'created_user_id',
        'updated_user_id',
        'ai_oportunities',
        'allowed_thesis',
        'until_subscription'
    ];
}
