<?php

namespace Modules\Setting\Http\Livewire\Parameter;

use App\Models\Parameter;
use Livewire\Component;

class ParameterEdit extends Component
{
    public $unique_code;
    public $description;
    public $valor;
    public $parameter;

    public function render()
    {
        return view('setting::livewire.parameter.parameter-edit');
    }

    public function mount($parameter_id)
    {
        $this->parameter = Parameter::find($parameter_id);
        $this->unique_code = $this->parameter->unique_code;
        $this->description = $this->parameter->description;
        $this->valor  = $this->parameter->valor;
    }

    public function save()
    {

        $this->validate([
            'unique_code' => 'required|unique:parameters,unique_code,' . $this->parameter->id,
            'description' => 'required',
            'valor' => 'required|max:10'
        ]);

        $this->parameter->update([
            'unique_code' => $this->unique_code,
            'description' => $this->description,
            'valor' => $this->valor
        ]);

        $this->dispatchBrowserEvent('set-parameter-update', ['tit' => 'Enhorabuena', 'msg' => 'Se Actualizo correctamente']);
    }
}
