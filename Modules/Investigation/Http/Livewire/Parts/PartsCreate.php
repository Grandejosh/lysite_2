<?php

namespace Modules\Investigation\Http\Livewire\Parts;

use Livewire\Component;
use Modules\Investigation\Entities\InveThesisFormat;
use Modules\Investigation\Entities\InveThesisFormatPart;

class PartsCreate extends Component
{
    protected $listeners = ['openModalPartCreate' => 'openModalPart'];

    public $part_id;
    public $format_id;
    public $part = [];
    public $number_order_old;
    public $number_order;
    public $description;
    public $information;
    public $state = true;
    public $index_order = 0;
    public $body = true;
    public $show_description = true;
    public $salto_de_pagina = false;

    public function render()
    {
        return view('investigation::livewire.parts.parts-create');
    }

    public function openModalPart($format_id, $part_id = null)
    {
        $this->format_id = $format_id;
        $this->part_id = $part_id;
        $title = 'Nueva Parte';

        if ($this->part_id) {
            $this->part = InveThesisFormatPart::find($this->part_id);
            $title = 'Nueva SubParte :' . $this->part->description;
            $this->number_order = $this->part->number_order . '.';
            $this->number_order_old = $this->part->number_order . '.';
        }
        $this->dispatchBrowserEvent('open-modal-parts', ['title' => $title]);
    }

    public function savePartNew()
    {
        $this->validate([
            //'number_order' => 'required|unique:inve_thesis_format_parts,number_order',
            'description' => 'required|string|max:255',
            'information' => 'required|string',
            'index_order' => 'required'
        ]);
        if ($this->number_order == null) $this->number_order = "";
        InveThesisFormatPart::create([
            'description' => $this->description,
            'information' => $this->information,
            'number_order' => $this->number_order,
            'thesis_format_id' => $this->format_id,
            'belongs' => $this->part_id,
            'state' => $this->state ? true : false,
            'index_order' => $this->index_order,
            'body' => $this->body ? true : false,
            'show_description' => $this->show_description ? true : false,
            'salto_de_pagina' => $this->salto_de_pagina ? true : false
        ]);

        if ($this->part_id) {
            $this->number_order = $this->number_order_old;
        } else {
            $this->number_order = null;
        }
        $this->description = null;
        $this->information = null;
        $this->state = true;
        $this->index_order = 0;
        $this->body = false;
        $this->show_description = true;
        $this->salto_de_pagina = false;
        $this->emit('listParts');
        $this->dispatchBrowserEvent('inve-parts-save', ['tit' => 'Enhorabuena', 'msg' => 'Se registró correctamente', 'res' => 'success']);
    }
}
