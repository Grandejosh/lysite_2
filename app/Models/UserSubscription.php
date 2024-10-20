<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_start',
        'date_end',
        'user_id',
        'subscription_id',
        'status',
        'status_response',
        'payment_response',
        'payment_server',
        'payment_online'
    ];
}
