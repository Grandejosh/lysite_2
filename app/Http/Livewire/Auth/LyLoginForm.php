<?php

namespace App\Http\Livewire\Auth;

use App\Mail\NewDeviceNotification;
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
use App\Models\UserDevice;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Agent\Agent;

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
            $this->verifyDevice($user);

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

    public function verifyDevice($user)
    {
        // Obtener información del dispositivo
        $agent = new Agent();
        $deviceName = $agent->device() ?: 'Desconocido'; // Nombre del dispositivo o 'Desconocido' si no está disponible
        $userAgent = $deviceName = 'Desconocido' ? request()->header('User-Agent') : $deviceName;
        $deviceIP = request()->ip();
        $deviceOS = $agent->platform() ?: 'Desconocido'; // Sistema operativo
        $browser = $agent->browser() ?: 'Desconocido'; // Navegador
        // Verificar si el dispositivo ya está registrado
        $existingDevice = UserDevice::where('user_id', $user->id)
            ->where('device_ip', $deviceIP)
            ->where('device_name', $userAgent)
            ->first();

        if ($existingDevice) {

            if (!$existingDevice->is_verified) {
                Auth::logout();
                $msg = 'Este dispositivo aún no ha sido verificado. Verifica tu correo.';
                //session()->flash('message', 'Este dispositivo aún no ha sido verificado. Verifica tu correo.');
                $this->dispatchBrowserEvent('validate-device_message', ['message' => $msg]);
            }
        } else {
            // Crear un nuevo dispositivo y marcarlo como no verificado
            $newDevice = UserDevice::create([
                'user_id' => $user->id,
                'device_name' => $deviceName,
                'device_ip' => $deviceIP,
                'device_os' => $deviceOS,
                'browser' => $browser,
                'is_verified' => false,
            ]);

            // Enviar correo de verificación
            Mail::to($user->email)->send(new NewDeviceNotification($newDevice));

            Auth::logout();

            $msg = 'Se ha detectado un nuevo dispositivo. Por favor, verifica tu correo.';
            $this->dispatchBrowserEvent('validate-device_message', ['message' => $msg]);
        }
    }
}
