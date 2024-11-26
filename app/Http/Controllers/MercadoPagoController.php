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

        try {

            if ($request->get('payment_method_id') == 'yape') {

                $createRequest = [
                    "description" => 'suscripcion ' . $sus->name,
                    "installments" => 1,
                    "payer" => [
                        "email" => Auth::user()->email,
                    ],
                    "payment_method_id" => "yape",
                    "token" => $request->get('token'),
                    "transaction_amount" => (float) $sus->price,
                ];
                $payment = $client->create($createRequest);
                $payment_server = 'yape';
            } else {
                $createRequest = [
                    "issuer_id" => $request->get('issuer_id'),
                    "description" => 'suscripcion ' . $sus->name,
                    "installments" => $request->get('installments'),
                    "payer" => $request->get('payer'),
                    "payment_method_id" => $request->get('payment_method_id'),
                    "token" => $request->get('token'),
                    "transaction_amount" => (float) $sus->price
                ];
                //dd($createRequest);
                $payment = $client->create($createRequest);

                $payment_server = 'mercadopago';
            }


            $us = UserSubscription::find($id);

            $url = route('web_gracias_por_comprar', $us->id);
            $message = null;
            //dd($payment->status);
            switch ($payment->status) {
                case "approved":
                    $actives = new AutomationController();
                    $actives->succes_payment_auto($us->subscription_id, null, $payment, $payment_server);
                    $message = 'Pago aprobado';
                    break;
                case "rejected":
                    $message = 'Rechazado por error general';
                    break;
                case "in_process":
                    $message = 'Pendiente de pago';
                    break;
                default:
                    $message = 'Pendiente de pago';
                    break;
            }
            return response()->json([
                'status' => $payment->status,
                //'message' => $payment->status_detail,
                'message' => $message,
                'url' => $url
            ]);
        } catch (\MercadoPago\Exceptions\MPApiException $e) {
            // Manejar la excepción
            $response = $e->getApiResponse();
            $content  = $response->getContent();
            //dd($content);
            $message = $content['message'];
            return response()->json(['error' => 'Error al procesar el pago: ' . $message], 412);
        }
    }
}
