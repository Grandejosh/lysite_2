<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserNotification;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AutomationController;
use App\Http\Controllers\TypeSubscriptionController;
use App\Mail\NewUserOnlineEmail;
use App\Models\TypeSubscription;

class LyVerifyEmail extends Component
{
    public $unique_code;
    public $start_time_code;
    public $end_time_code;

    public $title;
    public $message;

    public function render()
    {
        return view('livewire.auth.ly-verify-email');
    }

    public function resendCode()
    {
        ///$user = User::where('unique_code', $this->unique_code)->first();
        $user = Auth::user();
        $confirmationCode = Str::random(6);
        $startTime = Carbon::now();
        $endTime = $startTime->copy()->addMinutes(5);
        $user->unique_code = $confirmationCode;
        $user->start_time_code = $startTime;
        $user->end_time_code = $endTime;

        $user->save();


        $newCorreo = new NewUserOnlineEmail([
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_code' => trim($confirmationCode)
        ]);

        Mail::to(trim($user->email))->send($newCorreo);
    }

    public function validateCode()
    {
        $user = User::where('unique_code', trim($this->unique_code))
            ->whereNull('email_verified_at')
            ->first();

        if ($user) {
            // Suponiendo que tienes las fechas almacenadas en variables $start_date y $end_date
            $start_date = Carbon::parse($user->start_time_code);
            $end_date = Carbon::parse($user->end_time_code);

            // Obtiene la fecha y hora actual
            $currentDateTime = Carbon::now();

            // Verifica si la fecha y hora actual está dentro del rango de las fechas con una diferencia de 5 minutos
            if ($currentDateTime->between($start_date->subMinutes(5), $end_date->addMinutes(5))) {
                $user->email_verified_at = Carbon::now();
                $user->unique_code = null;
                $user->save();

                Auth::login($user);
                $typeSubs = TypeSubscription::where('price', 0)->first();
                $automate_register = new AutomationController();
                $automate_register->succes_payment_auto($typeSubs->id);
                return redirect()->intended('dashboard');
            } else {
                $this->title = 'ERROR';
                $this->message = 'El código ingresado ya no es válido. Por favor, vuelva a intentarlo.';
            }
        } else {
            $this->title = 'ERROR';
            $this->message = 'El código no existe';
        }
        $this->dispatchBrowserEvent('validate-code-response', ['success' => true]);
    }
}
