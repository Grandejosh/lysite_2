<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\SessionHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class LoginForm extends Component
{
    public $email;
    public $password;
    public $rememberme = false;

    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

    public function render()
    {
        return view('livewire.auth.login-form');
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
