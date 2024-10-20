<?php

namespace Modules\Setting\Http\Livewire\Modules;

use Livewire\Component;
use Modules\Setting\Entities\SetModule;
use Illuminate\Support\Str;

class ModulesEdit extends Component
{
    public $name;
    public $icon;
    public $status = true;
    public $module;
 
    protected $rules = [
        'name' => 'required|min:6'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($module_id){
        $this->module = SetModule::find($module_id);
        $this->name = $this->module->label;
        $this->icon = $this->module->logo;
        $this->status = $this->module->status;
    }

    public function render()
    {
        return view('setting::livewire.modules.modules-edit');
    }

    public function save()
    {
        $this->validate();
 
        $this->module->update([
            'logo' => $this->icon ? $this->icon : 'settings',
            'label' => $this->name,
            'status' => $this->status ? true : false
        ]);

        $this->dispatchBrowserEvent('set-module-edit', ['tit' => 'Enhorabuena','msg' => 'Se actualizó correctamente']);
    }
}
