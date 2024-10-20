<?php

namespace Modules\Setting\Http\Livewire\Roles;

use Livewire\Component;
use Modules\Setting\Entities\SetModule;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class RolesCreate extends Component
{
    public $name;
 
    protected $rules = [
        'name' => 'required|min:3|unique:roles,name'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('setting::livewire.roles.roles-create');
    }

    public function save()
    {
        $this->validate();
 
        Role::create([
            'name' => $this->name,
            'guard_name' => 'web'
        ]);
        
        $this->name = null;

        $this->dispatchBrowserEvent('set-roles-create', ['tit' => 'Enhorabuena','msg' => 'Se registró correctamente']);
    }
}
