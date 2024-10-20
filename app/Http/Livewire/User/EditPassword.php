<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class EditPassword extends Component
{
    public $password_old;
    public $password_new;
    public $password_confirm;

    public function render()
    {
        return view('livewire.user.edit-password');
    }

    public function save(){
        $this->validate([
            'password_old' => 'required',
            'password_new' => 'required',
            'password_confirm' => 'required|same:password_new'
        ]);

        if (Hash::check($this->password_old, Auth::user()->password)) {
            User::find(Auth::id())->update([
                'password' => Hash::make($this->password_new)
            ]);

            $this->password_old = null;
            $this->password_new = null;
            $this->password_confirm = null;

            $this->dispatchBrowserEvent('set-user-password-update', ['tit' => 'Enhorabuena','msg' => 'Se actualizó correctamente']);
        } else {
            $this->dispatchBrowserEvent('set-user-password-notupdate', ['tit' => 'Error','msg' => 'La contraseña ingresada no coincide con actual']);
        }
    }
}
