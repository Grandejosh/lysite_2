<?php

namespace Modules\Investigation\Http\Livewire\Parts;

use Livewire\Component;
use Modules\Investigation\Entities\InveThesisFormatPart;

class PartsEdit extends Component
{
    protected $listeners = ['openModalPartEditForm' => 'openModalPartEdit'];

    public $part_id;
    public $format_id;
    public $part;
    public $number_order;
    public $description;
    public $information;
    public $state;
    public $index_order;
    public $body;
    public $show_description;
    public $salto_de_pagina;

    public function render()
    {
        return view('investigation::livewire.parts.parts-edit');
    }

    public function openModalPartEdit($part_id){
        $this->part_id = $part_id;

        $this->part = InveThesisFormatPart::find($this->part_id);
        $title = 'Editar : ' . $this->part->description;
        $this->number_order = $this->part->number_order;
        $this->description = $this->part->description;
        $this->information = $this->part->information;
        $this->state = $this->part->state;
        $this->index_order = $this->part->index_order;
        $this->body = $this->part->body;
        $this->show_description = $this->part->show_description;
        $this->salto_de_pagina = $this->part->salto_de_pagina;
        $this->dispatchBrowserEvent('open-modal-parts-edit', ['title' => $title]);
    }

    public function savePart(){
        $this->validate([
            //'number_order' => 'required|unique:inve_thesis_format_parts,number_order,'.$this->part_id.'id',
            'description' => 'required|string|max:255',
            'information' => 'required|string',
            'index_order' => 'required'
        ]);

        $this->part->update([
            'description' => $this->description,
            'information' => $this->information,
            'number_order' => $this->number_order,
            'state' => $this->state ? true : false,
            'index_order' => $this->index_order,
            'body' => $this->body ? true : false,
            'show_description' => $this->show_description ? true : false,
            'salto_de_pagina' => $this->salto_de_pagina ? true : false
        ]);

        $this->emit('listParts');
        $this->dispatchBrowserEvent('inve-parts-save', ['tit' => 'Enhorabuena','msg' => 'Se Actualizo correctamente','res' => 'success']);
    }
}
