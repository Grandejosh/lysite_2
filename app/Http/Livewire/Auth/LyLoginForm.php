<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\SessionHistory;
use App\Models\TypeSubscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class LyLoginForm extends Component
{
    public $email;
    public $password;
    public $rememberme = false;

    public $modos = [];

    public function render()
    {
        $this->modos = TypeSubscription::limit(4)->orderBy('price')->get();
        return view('livewire.auth.ly-login-form');
    }

    public function login()
    {
        $this->validate([
            'email' => 'required',
            'password' => 'required',
        ]);


        if (Auth::attempt(array('email' => $this->email, 'password' => $this->password), $this->rememberme)) {

            request()->session()->regenerate();

            User::find(Auth::id())->update([
                'is_online'             => true,
                'chat_last_activity'    => now()->addMinutes(5)
            ]);

            SessionHistory::create([
                'session_id' => Session::getId(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
                'login_time' => now(),
                'logout_time' => null
            ]);

            SessionHistory::where('user_id', Auth::id())
                ->where('session_id', '<>', Session::getId())
                ->whereNull('logout_time')
                ->update([
                    'logout_time' => Carbon::now()
                ]);


            ///////////////////////////////////////////////////////////////////////////////////////////////////////// Device_token Sesion unica
            // Verificar si el usuario ya tiene un token de dispositivo asignado
            $user = User::find(Auth::id());

            $existingDeviceToken = $_COOKIE['device_token'] ?? null;
            // Generar un nuevo token de dispositivo
            $deviceToken = Str::uuid()->toString();

            // Asignar el nuevo token de dispositivo al usuario en la base de datos
            $user->device_token = $deviceToken;
            $user->save();

            // Guardar el token de dispositivo en el almacenamiento local del navegador
            setcookie('device_token', $deviceToken, time() + (86400 * 2), '/'); // Almacena la cookie durante 1 días





            // Resto del código...
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////


            return redirect()->intended('dashboard');
        } else {
            $this->resetInput();
            session()->flash('message', 'Las credenciales proporcionadas no coinciden con nuestros registros.');
        }
    }

    public function resetInput()
    {
        $this->email = null;
        $this->password = null;
        $this->rememberme = null;
    }
}
