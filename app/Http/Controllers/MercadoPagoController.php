<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeSubscription;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Person;
use Modules\Academic\Entities\AcaStudent;
use Modules\Academic\Entities\AcaCourse;
use App\Models\UserSubscription;

class MercadoPagoController extends Controller
{
    public function processPayment(Request $request, $id)
    {
        \MercadoPago\MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_TOKEN'));

        $client = new \MercadoPago\Client\Payment\PaymentClient();
        $payment_server = null;

        $sus = TypeSubscription::find($id);

        // try {

        if ($request->get('payment_method_id') == 'yape') {

            $createRequest = [
                "description" => 'suscripcion ' . $sus->name,
                "installments" => 1,
                "payer" => [
                    "email" => "test_user_123@testuser.com",
                ],
                "payment_method_id" => "yape",
                "token" => $request->get('token'),
                "transaction_amount" => (float) $sus->price,
            ];
            $payment = $client->create($createRequest);
            $payment_server = 'yape';
        } else {
            $payment = $client->create([
                "token" => $request->get('token'),
                "issuer_id" => $request->get('issuer_id'),
                "payment_method_id" => $request->get('payment_method_id'),
                "transaction_amount" => (float) $request->get('transaction_amount'),
                "installments" => $request->get('installments'),
                "payer" => $request->get('payer')
            ]);
            $payment_server = 'mercadopago';
        }


        $us = UserSubscription::find($id);

        if ($payment->status == 'approved') {

            // $us->status_response = $payment->status;
            // $us->payment_response = json_encode($payment);
            // $us->payment_server = 'mercadopago';
            // $us->payment_online = true;
            // $us->save();

            $actives = new AutomationController();

            $actives->succes_payment_auto($us->subscription_id, null, $payment, $payment_server);

            return response()->json([
                'status' => $payment->status,
                'message' => $payment->status_detail,
                'url' => route('web_gracias_por_comprar', $us->id)
            ]);
        } else {

            return response()->json([
                'status' => $payment->status,
                'message' => $payment->status_detail,
                'url' => route('modo_page')
            ]);

            $us->delete();
        }
        // } catch (\MercadoPago\Exceptions\MPApiException $e) {
        //     // Manejar la excepción
        //     $response = $e->getApiResponse();
        //     $content  = $response->getContent();

        //     $message = $content['message'];
        //     return response()->json(['error' => 'Error al procesar el pago: ' . $message], 412);
        // }
    }
}
