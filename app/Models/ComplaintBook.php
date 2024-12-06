<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        'type',
        'amount',
        'description',
        'details',
        'improvement',
        'registers_user_id',
        'attends_user_id',
        'status',
        'type_item',
        'guardian_parents',
        'identifier_year',
        'response_date',
        'response_description'
    ];

    // Evento creating para generar el identifier_year
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($complaintBook) {
            $year = now()->year;

            // Obtener el último correlativo del año actual
            $lastIdentifier = DB::table('complaint_books')
                ->where('identifier_year', 'like', "%-$year")
                ->orderBy('identifier_year', 'desc')
                ->value('identifier_year');

            // Calcular el nuevo correlativo
            $newCorrelative = $lastIdentifier
                ? (int)explode('-', $lastIdentifier)[0] + 1
                : 1;

            // Formatear el identifier_year
            $complaintBook->identifier_year = str_pad($newCorrelative, 9, '0', STR_PAD_LEFT) . "-$year";
        });
    }
}
