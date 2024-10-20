<?php

namespace Modules\Academic\Http\Livewire\ContentTypes;

use Livewire\Component;
use Modules\Academic\Entities\AcaContentType;
use Illuminate\Support\Facades\Auth;



class ContentTypesEdit extends Component
{
    public $contentType;
    public $name;
    public $description;
    public function mount($content_type_id){
        $this->contentType = AcaContentType::find($content_type_id);
        $this->name = $this->contentType->name;
        $this->description = $this->contentType->description;
        $this->status = $this->contentType->status;
    }

    public function render()
    {
        return view('academic::livewire.content-types.content-types-edit');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    protected $rules = [
        'name' => 'required|max:255'
    ];

    public function update(){

        $this->validate([
            'name' => 'unique:aca_content_types,name,'.$this->contentType->id
        ]);

        $this->contentType->update([
            'name' => $this->name,
            'description' => $this->description
        ]);

        $this->dispatchBrowserEvent('aca-content-types-update', ['tit' => 'Enhorabuena','msg' => 'Se Actualizo correctamente']);
    }

}
