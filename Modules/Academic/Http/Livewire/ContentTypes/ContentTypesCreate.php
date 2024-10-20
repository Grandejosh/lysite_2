<?php

namespace Modules\Academic\Http\Livewire\ContentTypes;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Academic\Entities\AcaContentType;

class ContentTypesCreate extends Component
{
    public $name;
    public $description;
    public $status = true;

    public function render()
    {
        return view('academic::livewire.content-types.content-types-create');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    protected $rules = [
        'name' => 'required|max:255|unique:aca_content_types,name'
    ];

    public function save(){

        $this->validate();

        AcaContentType::create([
            'name' => $this->name,
            'description' => $this->description
        ]);

        $this->name = null;
        $this->description = null;

        $this->dispatchBrowserEvent('aca-content-types-create', ['tit' => 'Enhorabuena','msg' => 'Se registró correctamente']);
    }

}
