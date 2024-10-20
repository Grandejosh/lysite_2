<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentityDocumentType extends Model
{
    use HasFactory;

    public $incrementing = false;
    
    protected $fullable = [
        'description',
        'status'
    ];
}
