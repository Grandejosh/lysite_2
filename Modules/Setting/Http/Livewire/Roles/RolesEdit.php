<?php

namespace Modules\Setting\Http\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RolesEdit extends Component
{
    public $name;
    public $role_id;
    public $role;

    public function mount($role_id){
        $this->role_id = $role_id;
        $this->role = Role::find($role_id);
        $this->name = $this->role->name;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('setting::livewire.roles.roles-edit');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|min:3|unique:roles,name,'.$this->role_id
        ]);
 
        $this->role->update([
            'name' => $this->name
        ]);
        
        $this->dispatchBrowserEvent('set-roles-update', ['tit' => 'Enhorabuena','msg' => 'Se actualizó correctamente']);
    }
}
