<?php

namespace Modules\Investigation\Http\Livewire\Thesis;

use App\Models\Person;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Investigation\Entities\InveThesisFormat;
use Modules\Investigation\Entities\InveThesisFormatPart;

class ThesisFormatModalEdit extends Component
{
    public $parts = [];
    public $part_idx;
    public $format_idx;
    public $format;
    public $part = [];
    public $number_order_old;
    public $number_orderx;
    public $descriptionx;
    public $information;
    public $index_order = 0;
    public $school_id;
    public $namex;
    public $description_format;
    public $type_thesisx;
    public $normative_thesisx;
    public $enum_types;
    public $enum_normatives;
    public $university_id;
    public $country_id;

    public $xbottom;
    public $xtop;
    public $xright;
    public $xleft;

    public function mount()
    {
        $person = Person::where('user_id', Auth::id())->first();
        $this->country_id = $person->country_id;
        $this->university_id = $person->university_id;

        $this->enum_types = $this->getTypes();
        $this->enum_normatives = $this->getNormatives();
    }

    public function getAllData($id)
    {
        $format = InveThesisFormat::find($id);
        $this->format_idx = $id;
        $this->normative_thesisx = $format->normative_thesis;
        $this->type_thesisx = $format->type_thesis;
        $this->namex = $format->name;
    }

    public function getParts()
    {

        $this->parts = [];
        $parts = InveThesisFormatPart::where('thesis_format_id', $this->format_idx)
            ->whereNull('belongs')
            ->orderBy('index_order')
            ->get();

        foreach ($parts as $k => $part) {
            $this->parts[$k] = [
                'id' => $part->id,
                'description' => $part->description,
                'number_order' => $part->number_order,
                'index_order' => $part->index_order,
                'items' => $this->getSubParts($part->id),
            ];
        }
        $this->dispatchBrowserEvent('inve-thesis-student-format-add-load', ['class' => true]);
    }
    public function getSubParts($id)
    {
        $subparts = InveThesisFormatPart::where('belongs', $id)
            ->orderBy('index_order')
            ->get();
        $html = '';

        if (count($subparts) > 0) {

            foreach ($subparts as $k => $subpart) {
                $html .= '<li>';
                $html .= '<div class="btn-group mr-3">
                           
                            <button onclick="addSubPartFormatJS(' . $k . ',' . $subpart->id . ')" type="button" class="btn btn-secondary btn-sm">
                                <i class="fa fa-plus"></i>
                            </button>
                            <button onclick="deletePartStudentJS(' . $subpart->id . ')" type="button" class="btn btn-secondary btn-sm">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                            
                        </div>';
                $html .= '<a class="formattitleload" href="#" id="xsubformattitle' . $subpart->id . '" data-type="text" data-pk="' . $k . '" data-title="Escriba Titulo">' . $subpart->description . '</a>';
                $html .= '<ul id="ULsubpartFormat' . $k . $subpart->id . '">';
                $html .= $this->getSubParts($subpart->id);
                $html .= '</ul>';
                $html .= '</li>';
            }
        }
        return $html;
    }

    public function getNormatives()
    {
        return ['APA', 'Vancouver', 'Otros'];
    }
    public function getTypes()
    {
        //return ['histórica', 'descriptiva', 'experimental', 'meta-descriptiva', 'metodológica', 'teorica', 'otra'];
        return ['Cuantitativo', 'Cualitativo', 'Mixto'];
    }
    public function render()
    {
        return view('investigation::livewire.thesis.thesis-format-modal-edit');
    }
    public function addTitlePartEdit()
    {
        array_push($this->parts, [
            'id'            => '',
            'description'   => '',
            'number_order'  => '',
            'index_order'   => '',
            'items'         => []
        ]);
        $index = count($this->parts) - 1;
        $this->dispatchBrowserEvent('inve-thesis-student-format-add-update', ['keytitle' => $index]);
    }
    public function savePartEstudentEdit()
    {

        InveThesisFormatPart::create([
            'description'       => $this->descriptionx,
            'information'       => 'No hay informacion',
            'number_order'      => $this->number_orderx,
            'thesis_format_id'  => $this->format_idx,
            'belongs'           => $this->part_idx,
            'state'             => true,
            'index_order'       => 1,
            'body'              => true,
            'show_description'  => true,
            'salto_de_pagina'   => true,
            'user_id'           => Auth::id()
        ]);
        $this->part_idx = null;
        $this->getParts();
    }

    public function savePartEstudentEditUpdate($id)
    {
        $this->validate([
            'descriptionx' => 'required|string|max:255'
        ]);

        InveThesisFormatPart::find($id)->update([
            'description' => $this->descriptionx
        ]);

        $this->getParts();
    }

    public function deletePartStudent($id)
    {
        InveThesisFormatPart::find($id)->delete();
        $this->getParts();
    }

    public function updateFormatStudent()
    {
        $this->validate([
            'namex'          => 'required|max:255',
            'type_thesisx'   => 'required',
            'normative_thesisx'   => 'required',
            'xright'              => 'required|numeric',
            'xleft'              => 'required|numeric',
            'xtop'              => 'required|numeric',
            'xbottom'              => 'required|numeric',
        ]);

        InveThesisFormat::find($this->format_idx)->update([
            'name'              => trim($this->namex),
            'type_thesis'       => trim($this->type_thesisx),
            'normative_thesis'  => trim($this->normative_thesisx),
            'right_margin'      => $this->xright,
            'left_margin'       => $this->xleft,
            'top_margin'        => $this->xtop,
            'bottom_margin'     => $this->xbottom
        ]);

        $this->dispatchBrowserEvent('thesis-format-create-estudent-edit', ['tit' => 'Enhorabuena', 'msg' => 'Se registró correctamente']);
    }
}
