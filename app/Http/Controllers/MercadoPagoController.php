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

        try {

            $payment = $client->create([
                "token" => $request->get('token'),
                "issuer_id" => $request->get('issuer_id'),
                "payment_method_id" => $request->get('payment_method_id'),
                "transaction_amount" => (float) $request->get('transaction_amount'),
                "installments" => $request->get('installments'),
                "payer" => $request->get('payer')
            ]);

            $us = UserSubscription::find($id);

            if ($payment->status == 'approved') {

                $us->status_response = $payment->status;
                $us->payment_response = json_encode($payment);
                $us->payment_server = 'mercadopago';
                $us->payment_online = true;
                $us->save();

                $actives = new AutomationController();

                $actives->succes_payment_auto($us->subscription_id);

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
        } catch (\MercadoPago\Exceptions\MPApiException $e) {
            // Manejar la excepción
            $response = $e->getApiResponse();
            $content  = $response->getContent();

            $message = $content['message'];
            return response()->json(['error' => 'Error al procesar el pago: ' . $message], 412);
        }
    }
}
