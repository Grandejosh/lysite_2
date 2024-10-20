<?php

namespace Modules\Investigation\Http\Livewire\Parts;

use Livewire\Component;
use Modules\Investigation\Entities\InveThesisFormat;
use Modules\Investigation\Entities\InveThesisFormatPart;
use Livewire\WithPagination;
class PartsList extends Component
{
    use WithPagination;
    protected $listeners = ['listParts' => 'updatingListParts'];

    public $search;

    public $format;
    public $format_id;
    public $parts = [];

    public function mount($format_id){
        $this->format_id = $format_id;
        $this->format == InveThesisFormat::find($format_id);
    }

    public function render()
    {
        $this->getParts();
        return view('investigation::livewire.parts.parts-list');
    }

    public function updatingListParts()
    {
        $this->resetPage();
    }

    public function getParts(){
        $parts = InveThesisFormatPart::where('thesis_format_id',$this->format_id)
            ->whereNull('belongs')
            ->orderBy('index_order')
            ->get();
        //dd($parts);
        foreach($parts as $k => $part){
            $this->parts[$k] = [
                'id' => $part->id,
                'description' => $part->description,
                'number_order' => $part->number_order,
                'index_order' => $part->index_order,
                'items' => $this->getSubParts($part->id),
            ];
        }

    }
    public function getSubParts($id){
        $subparts = InveThesisFormatPart::where('belongs',$id)
            ->orderBy('index_order')
            ->get();
        $html = '';

        if(count($subparts)>0){
            $html .= '<ul>';
            foreach($subparts as $k => $subpart){
                $html .= '<li>';
                $html .= '<div class="btn-group mr-3">
                <label style="opacity:0.4; color:red" data-toggle="tooltip" data-placement="top" title="Esto no se mostrará en las tesis">'.$subpart->index_order.'-- </label>
                            <button wire:click="openModalTwo('.$subpart->id.')" type="button" class="btn btn-secondary btn-sm">
                                <i class="fa fa-plus"></i>
                            </button>
                            <button wire:click="openModalEditTwo('.$subpart->id.')" type="button" class="btn btn-secondary btn-sm">
                                <i class="fa fa-pencil-alt"></i>
                            </button>
                            <button onclick="deletes('.$subpart->id.')" type="button" class="btn btn-secondary btn-sm">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </div>';
                $html .= $subpart->number_order.' '.$subpart->description;
                $html .= $this->getSubParts($subpart->id);
                $html .= '</li>';
            }
            $html .= '</ul>';
        }
        return $html;
    }

    public function openModalTwo($id){
        $this->emit('openModalPartCreate',$this->format_id,$id);
    }

    public function openModalEditTwo($id){
        $this->emit('openModalPartEditForm',$id);
    }

    public function destroy($id){
        try {
            InveThesisFormatPart::find($id)->delete();
            $res = 'success';
            $tit = 'Enhorabuena';
            $msg = 'Se eliminó correctamente';
        } catch (\Illuminate\Database\QueryException $e) {
            $res = 'error';
            $tit = 'Salió mal';
            $msg = 'No se puede eliminar porque cuenta con registros asociados';
        }

        $this->dispatchBrowserEvent('inve-part-delete', ['res' => $res, 'tit' => $tit, 'msg' => $msg]);
    }
}
