<?php

namespace Modules\Setting\Http\Livewire\Parameter;

use App\Models\Parameter;
use Livewire\Component;

class ParameterCreate extends Component
{
    public $unique_code;
    public $description;
    public $valor;

    public function render()
    {
        return view('setting::livewire.parameter.parameter-create');
    }

    public function save()
    {

        $this->validate([
            'unique_code' => 'required|unique:parameters,unique_code',
            'description' => 'required',
            'valor' => 'required|max:10'
        ]);

        Parameter::create([
            'unique_code' => $this->unique_code,
            'description' => $this->description,
            'valor' => $this->valor
        ]);

        $this->unique_code = null;
        $this->description = null;
        $this->valor = null;

        $this->dispatchBrowserEvent('set-parameter-create', ['tit' => 'Enhorabuena', 'msg' => 'Se registró correctamente']);
    }
}
