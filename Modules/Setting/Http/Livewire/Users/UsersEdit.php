<?php

namespace Modules\Setting\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersEdit extends Component
{
    public $user_id;
    public $name;
    public $role_id;
    public $email;
    public $password;
    public $roles;
    public $user;
    public $role_id_old;
    public $gpt;
    public $cur;
    public $tes;

    public function mount($user_id)
    {
        $this->roles = Role::all();
        $this->user_id = $user_id;

        $this->user = User::find($user_id);
        $this->role_id = DB::table('model_has_roles')->where('model_type', User::class)->where('model_id', $this->user_id)->first()->role_id;
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->role_id_old = $this->role_id;

        $this->gpt = $this->user->hasPermissionTo('academico_directo_gpt');
        $this->cur = $this->user->hasPermissionTo('academico_directo_cursos');
        $this->tes = $this->user->hasPermissionTo('academico_directo_tesis');
    }

    public function render()
    {
        return view('setting::livewire.users.users-edit');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:6|max:255',
            'email' => 'required|min:6|unique:users,email,' . $this->user_id,
            'role_id' => 'required'
        ]);

        $role_name_old = Role::find($this->role_id_old)->name;
        $this->user->removeRole($role_name_old);

        User::find($this->user_id)->update([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password ? Hash::make($this->password) : $this->user->password
        ]);

        $role_name = Role::find($this->role_id)->name;

        User::find($this->user_id)->assignRole($role_name);

        if ($this->gpt) {
            $this->user->givePermissionTo('academico_directo_gpt');
        } else {
            $this->user->revokePermissionTo('academico_directo_gpt');
        }
        if ($this->cur) {
            $this->user->givePermissionTo('academico_directo_cursos');
        } else {
            $this->user->revokePermissionTo('academico_directo_cursos');
        }
        if ($this->tes) {
            $this->user->givePermissionTo('academico_directo_tesis');
        } else {
            $this->user->revokePermissionTo('academico_directo_tesis');
        }

        $this->dispatchBrowserEvent('set-users-update', ['tit' => 'Enhorabuena', 'msg' => 'Se actualizó correctamente']);
    }
}
