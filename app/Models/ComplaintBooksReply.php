<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintBooksReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_book_id',
        'subject',
        'email',
        'complaint_book_status',
        'message',
        'user_id'
    ];
}
