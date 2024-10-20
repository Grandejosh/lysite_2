<?php

namespace App\Http\Livewire\Auth;

use App\Models\Notification;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserNotification;
use Session;  //para Recaptcha
class RegisterForm extends Component
{
    public $full_name;
    public $email;
    public $password;
    public $repeat_password;
    public $telephone;

    public function render()
    {
        return view('livewire.auth.register-form');
    }

    public function save()
    {

        $user = $this->validate([

            'password' => 'required|min:8',
            'repeat_password' => 'required|same:password',
            'email' => 'required|email|unique:users,email',

        ]);

        $user = User::create([
            'name' => $this->full_name,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);


        $user->assignRole('Student');

        Auth::attempt(array('email' => $user->email, 'password' => $this->password));

        //notificación de correo al correo de notificaciones .env MAIL_TO_NOTIFICATIONS si notificaciones new user está activado
        if (env('NOTIFICATIONS_NEW_USER')) {
            $correo = new NewUserNotification($user->name, $user->email, trim($this->telephone));
            Mail::to(env('MAIL_TO_NOTIFICATIONS'))->send($correo);
        }

        return redirect()->intended('dashboard');
    }
}
