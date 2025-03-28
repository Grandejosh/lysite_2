<?php

namespace App\Http\Controllers;

use App\Models\ComplaintBook;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailComplaintBookNotification;

class ComplaintBookController extends Controller
{
    public function index()
    {
        return view('complaintbook.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|max:255',
            'numero_dni' => 'required|max:255',
            'telefono' => 'required|max:255',
            'email' => 'required|email|max:255',
            'domicilio' => 'required|max:255',
            'monto' => 'required|numeric|regex:/^\d{1,12}(\.\d{1,2})?$/',
            'contrato-descripcion' => 'required|max:255',
            'tipo' => 'required|max:255',
            // 'serie' => 'required|max:6',
            // 'numero' => 'required|max:20',
            'detalle' => 'required|max:255',
            'pedido' => 'required|max:255',
            'conformidad' => 'accepted',
            'bien' => 'required|max:1',
        ], [
            'conformidad.accepted' => 'Debe estar conforme con lo detallado.',
        ]);

        $complaintBook = ComplaintBook::create([
            'date_register' => Carbon::now()->format('Y-m-d'),
            'full_name' => $request->get('nombres'),
            'dni_number' => $request->get('numero_dni'),
            'telephone' => $request->get('telefono'),
            'email' => $request->get('email'),
            'address' => $request->get('domicilio'),
            'serie' => $request->get('serie'),
            'number' => $request->get('numero'),
            'amount' => $request->get('monto'),
            'description' => $request->get('contrato-descripcion'),
            'type' => $request->get('tipo'),
            'details' => $request->get('detalle'),
            'improvement' => $request->get('pedido'),
            'registers_user_id' => null,
            'attends_user_id' => null,
            'status' => 1,
            'type_item' => $request->get('bien'),
            'guardian_parents' => $request->get('padres')
        ]);

        $email = $request->get('email');
        $view_email = new EmailComplaintBookNotification($complaintBook);
        Mail::to($email)->send($view_email);

        $email2 = env('MAIL_TO_NOTIFICATIONS');
        $view_email2 = new EmailComplaintBookNotification($complaintBook);
        $view_email2->subject("Hubo una queja/reclamo");
        Mail::to($email2)->send($view_email2);


        return redirect()->route('home')
            ->with('success_libroreclamos', 'Registro exitoso.');
    }
}
