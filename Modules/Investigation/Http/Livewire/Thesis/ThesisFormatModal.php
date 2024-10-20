<?php

namespace Modules\Investigation\Http\Livewire\Thesis;

use App\Models\Country;
use App\Models\Person;
use App\Models\Universities;
use App\Models\UniversitiesSchools;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Investigation\Entities\InveThesisFormat;
use Modules\Investigation\Entities\InveThesisFormatPart;

class ThesisFormatModal extends Component
{
    public $xparts = [];
    public $xpart_id;
    public $xformat_id;
    public $xnumber_order;
    public $xdescription;
    public $xschool_id;
    public $xname;
    public $xtype_thesis;
    public $xnormative_thesis;
    public $xenum_types;
    public $xenum_normatives;
    public $xuniversity_id;
    public $xcountry_id;

    public $xbottom;
    public $xtop;
    public $xright;
    public $xleft;

    public function mount()
    {
        $person = Person::where('user_id', Auth::id())->first();
        $this->xcountry_id = $person->country_id;
        $this->xuniversity_id = $person->university_id;

        $this->xenum_types = $this->getTypes();
        $this->xenum_normatives = $this->getNormatives();
    }
    public function getNormatives()
    {
        return ['APA', 'Vancouver', 'Otros'];
    }
    public function getTypes()
    {
        //return ['histórica', 'descriptiva', 'experimental', 'meta-descriptiva', 'metodológica', 'teorica', 'Cuantitativo', 'Cualitativo', 'Mixto', 'otra'];
        return ['Cuantitativo', 'Cualitativo', 'Mixto'];
    }
    public function render()
    {
        return view('investigation::livewire.thesis.thesis-format-modal');
    }
    public function getPartsNew()
    {
        $this->xparts = [];
        $parts = InveThesisFormatPart::where('thesis_format_id', $this->xformat_id)
            ->whereNull('belongs')
            ->orderBy('index_order')
            ->get();

        foreach ($parts as $k => $part) {
            $this->xparts[$k] = [
                'id' => $part->id,
                'description' => $part->description,
                'number_order' => $part->number_order,
                'index_order' => $part->index_order,
                'items' => $this->getSubPartsNew($part->id),
            ];
        }

        $this->dispatchBrowserEvent('inve-thesis-student-format-add-reload', ['class' => true]);
    }
    public function getSubPartsNew($id)
    {
        $subparts = InveThesisFormatPart::where('belongs', $id)
            ->orderBy('index_order')
            ->get();
        $html = '';

        if (count($subparts) > 0) {

            foreach ($subparts as $k => $subpart) {
                $html .= '<li>';
                $html .= '<div class="btn-group mr-3">
                           
                            <button onclick="addSubPartFormatNewJS(' . $k . ',' . $subpart->id . ')" type="button" class="btn btn-secondary btn-sm">
                                <i class="fa fa-plus"></i>
                            </button>
                            <button onclick="deletePartStudentNewJS(' . $subpart->id . ')" type="button" class="btn btn-secondary btn-sm">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                            
                        </div>';
                $html .= '<a class="formattitlereload" href="#" id="subformattitle' . $subpart->id . '" data-type="text" data-pk="' . $k . '" data-title="Escriba Titulo">' . $subpart->description . '</a>';
                $html .= '<ul id="ULsubpartFormatNew' . $k . $subpart->id . '">';
                $html .= $this->getSubPartsNew($subpart->id);
                $html .= '</ul>';
                $html .= '</li>';
            }
        }
        return $html;
    }

    public function addTitlePartNew()
    {

        array_push($this->xparts, [
            'id'            => '',
            'description'   => '',
            'number_order'  => '',
            'index_order'   => '',
            'items'         => []
        ]);
        $index = count($this->xparts) - 1;

        $this->dispatchBrowserEvent('inve-thesis-student-format-add', ['keytitle' => $index]);
    }

    public function saveFormatStudentNew()
    {

        $this->validate([
            'xname'          => 'required|max:255',
            'xtype_thesis'   => 'required',
            'xnormative_thesis'   => 'required',
            'xright'              => 'required|numeric',
            'xleft'              => 'required|numeric',
            'xtop'              => 'required|numeric',
            'xbottom'              => 'required|numeric',
        ]);

        $this->xformat_id = InveThesisFormat::create([
            'name'              => trim($this->xname),
            'description'       => 'Formato Creado por el alumno',
            'type_thesis'       => trim($this->xtype_thesis),
            'normative_thesis'  => trim($this->xnormative_thesis),
            'school_id'         => $this->xschool_id,
            'user_id'           => Auth::id(),
            'right_margin' => $this->xright,
            'left_margin' => $this->xleft,
            'top_margin' => $this->xtop,
            'bottom_margin' => $this->xbottom
        ])->id;


        $this->dispatchBrowserEvent('thesis-format-create-estudent', ['tit' => 'Enhorabuena', 'msg' => 'Se registró correctamente']);
    }
    public function savePartEstudentNew()
    {
        $this->validate([
            'xdescription' => 'required|string|max:255'
        ]);

        InveThesisFormatPart::create([
            'description'       => $this->xdescription,
            'information'       => 'No hay informacion',
            'number_order'      => $this->xnumber_order,
            'thesis_format_id'  => $this->xformat_id,
            'belongs'           => $this->xpart_id,
            'state'             => true,
            'index_order'       => 1,
            'body'              => true,
            'show_description'  => true,
            'salto_de_pagina'   => true,
            'user_id'           => Auth::id()
        ]);
        $this->xpart_id = null;
        $this->getPartsNew();
    }
    public function deletePartStudentNew($id)
    {
        InveThesisFormatPart::find($id)->delete();
        $this->getPartsNew();
    }
    public function savePartEstudentNewUpdate($id)
    {
        $this->validate([
            'xdescription' => 'required|string|max:255'
        ]);

        InveThesisFormatPart::find($id)->update([
            'description' => $this->xdescription
        ]);

        $this->getPartsNew();
    }
}
