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
use Illuminate\Support\Facades\DB;

class AutomationController extends Controller
{
    public function succes_payment_auto(int $type_subscription_id, int $user_id = null, Object $server_response = null, String $server = null)
    {
        DB::beginTransaction();
        try {
            //dd($type_subscription_id);
            $subscription = TypeSubscription::find($type_subscription_id);
            $ai_oportunities = $subscription->ai_oportunities;
            $allowed_thesis = $subscription->allowed_thesis;
            $add_months = $subscription->until_subscription; //numero de meses que se ampliará la subscripción
            // agregando permisos para tesis y uso de AI

            $user = null;
            if ($user_id == null) {
                $user = Auth::user();
            } else {
                $user = User::find($user_id);
            }
            $person = $user->person;

            if ($person->allowed_thesis === null) {
                $person->allowed_thesis = $allowed_thesis;
            } else {
                $person->allowed_thesis += $allowed_thesis;
            }

            if ($person->paraphrase_allowed === null) {
                $person->paraphrase_allowed = $ai_oportunities;
            } else {
                $person->paraphrase_allowed += $ai_oportunities;
            }

            $person->save();

            // dando permiso a los cursos
            $courses = AcaCourse::where('status', 1)->get();
            $today = now();
            $registeredUntil = $today->addMonths($add_months); //se obtiene de la tabla type_subscription, columna until_subscription
            $newDate = null;
            foreach ($courses as $course) {
                $acaStudent = AcaStudent::where('person_id', $person->id)
                    ->where('course_id', $course->id)
                    ->first();

                if ($acaStudent) {
                    // Si el usuario ya está registrado, verificar la fecha de registro
                    if ($acaStudent->registered_until === null) {
                        // Si la fecha de registro es nula, establecer a 6 meses a partir de hoy
                        $acaStudent->registered_until = $registeredUntil;
                        $newDate = $registeredUntil;
                    } elseif (is_string($acaStudent->registered_until)) {
                        // Si la fecha de registro es un string, convertirlo a una instancia de DateTime
                        $acaStudent->registered_until = new \DateTime($acaStudent->registered_until);
                        $acaStudent->registered_until = $acaStudent->registered_until->modify('+6 months');
                        $newDate = $acaStudent->registered_until->modify('+6 months');
                    } elseif ($acaStudent->registered_until < $today) {
                        // Si la fecha de registro es anterior a hoy, actualizar a 6 meses a partir de hoy
                        $acaStudent->registered_until = $registeredUntil;
                        $newDate = $registeredUntil;
                    } else {
                        // Si la fecha de registro es posterior a hoy, sumar 6 meses a la fecha existente
                        $acaStudent->registered_until = $acaStudent->registered_until->modify('+6 months');
                        $newDate = $acaStudent->registered_until->modify('+6 months');
                    }
                    $acaStudent->save();
                } else {
                    // Si el usuario no está registrado, crear una nueva instancia de AcaStudent
                    $acaStudent = new AcaStudent();
                    $acaStudent->person_id = $person->id;
                    $acaStudent->course_id = $course->id;
                    $acaStudent->status = 1;
                    $acaStudent->registered_until = $registeredUntil;
                    $acaStudent->save();
                    $newDate = $registeredUntil;
                }
            }

            //registrando en tabla users_subscriptions
            $userSubscription = new UserSubscription();
            $userSubscription->date_start = now();
            $userSubscription->date_end = $newDate;
            $userSubscription->user_id = $user->id;
            $userSubscription->subscription_id = $type_subscription_id;
            $userSubscription->status = true;
            if ($server_response) {
                $userSubscription->status_response = $server_response->status;
                $userSubscription->payment_response = json_encode($server_response);
                $userSubscription->payment_server = $server;
            }
            $userSubscription->save();
            /*
            $ai_oportunities = $subscription->ai_oportunities;
            $allowed_thesis = $subscription->allowed_thesis;
            $add_months = $subscription->until_subscription; //numero de meses que se ampliará la subscripción
            */

            if ($ai_oportunities > 0) {
                $user->givePermissionTo('academico_directo_gpt');
            }
            // a todos le damos permiso porque hasta el gratis tiene acceso a cursos
            $user->givePermissionTo('academico_directo_cursos');

            if ($allowed_thesis > 0) {
                $user->givePermissionTo('academico_directo_tesis');
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th); // comentar esta linea
        }
    }
}
