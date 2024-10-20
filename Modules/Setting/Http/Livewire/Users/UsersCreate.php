<?php

namespace Modules\Setting\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersCreate extends Component
{
    public $name;
    public $role_id;
    public $email;
    public $password;
    public $roles;

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function render()
    {
        return view('setting::livewire.users.users-create');
    }

    public function save()
    {

        $this->validate([
            'name' => 'required|min:6|max:255',
            'email' => 'required|min:6|unique:users,email',
            'password' => 'required',
            'role_id' => 'required'
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);

        $role_name = Role::find($this->role_id)->name;

        $user->assignRole($role_name);

        $this->name = null;
        $this->email = null;
        $this->password = null;
        $this->role_id = null;

        $this->dispatchBrowserEvent('set-users-create', ['tit' => 'Enhorabuena', 'msg' => 'Se registró correctamente']);
    }
}
