<?php

namespace Modules\Setting\Http\Livewire\Modules;

use Livewire\Component;
use Modules\Setting\Entities\SetModule;
use Illuminate\Support\Str;

class ModulesCreate extends Component
{
    public $name;
    public $icon;
    public $status = true;
 
    protected $rules = [
        'name' => 'required|min:6'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('setting::livewire.modules.modules-create');
    }

    public function save()
    {
        $this->validate();
 
        SetModule::create([
            'uuid' => Str::uuid(),
            'logo' => $this->icon?$this->icon:'settings',
            'label' => $this->name,
            'destination_route' => 'sin',
            'status' => $this->status?true:false
        ]);
        
        $this->name = null;
        $this->icon = null;
        $this->status = true;

        $this->dispatchBrowserEvent('set-module-create', ['tit' => 'Enhorabuena','msg' => 'Se registró correctamente']);
    }
}
