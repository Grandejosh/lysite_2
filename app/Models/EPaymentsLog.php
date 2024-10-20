<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EPaymentsLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_origin',
        'currency',
        'gross_amount',
        'net_amount',
        'commission',
        'status_order',
        'email',
        'name',
        'country_origin'
    ];
}
