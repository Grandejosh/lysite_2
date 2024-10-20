<?php

namespace Modules\Academic\Http\Livewire\Contents;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Academic\Entities\AcaContent;
use Modules\Academic\Entities\AcaContentType;
use Modules\Academic\Entities\AcaSection;
use Livewire\WithFileUploads;
class ContentsInstructorForm extends Component
{
    public $section_id;
    public $section_name;
    public $content_type_id;
    public $name;
    public $content_url;
    public $status;
    public $contents = [];
    public $content_types;
    public $link;
    public $text;
    public $file;

    use WithFileUploads;
    protected $listeners = ['instructorOpenModal' => 'openModalContent'];

    public function mount(){
        $this->content_types = AcaContentType::all();
        $this->status = true;
    }

    public function render()
    {
        return view('academic::livewire.contents.contents-instructor-form');
    }

    public function openModalContent($section_id){

        $this->section_id = $section_id;
        $this->section_name = AcaSection::find($section_id)->title;

        $this->getData();

        $this->dispatchBrowserEvent('aca-content-open-modal', ['success' => true]);
    }

    public function getData(){
        $this->contents = AcaContent::join('aca_content_types','content_type_id','aca_content_types.id')
            ->select(
                'aca_content_types.name AS content_type_name',
                'aca_contents.name AS content_name',
                'aca_contents.content_url',
                'aca_contents.original_name',
                'aca_contents.status',
                'aca_contents.count',
                'aca_contents.id'
            )
            ->where('aca_contents.section_id', $this->section_id)
            ->orderBy('aca_contents.count')
            ->get();

    }

    public function saveContent(){

        $this->validate([
            'content_type_id'   => 'required',
            'name'              => 'required'
        ]);

        $count = AcaContent::where('section_id', $this->section_id)->count();

        $original_name = null;

        if($this->content_type_id == 1){
            $this->content_url = $this->link;
        }else if($this->content_type_id == 2){
            $this->content_url = htmlentities($this->text, ENT_QUOTES, "UTF-8");
        }else if ($this->content_type_id == 3 || $this->content_type_id == 4) {
            $original_name = $this->file->getClientOriginalName();
            $this->content_url = 'storage/'.substr($this->file->store('public/uploads/academic/contents'), 7);    // <----------------------Solo para archivos e imagenes-------------------------------------------
        }else{
            $this->content_url = $this->text;
        }

        AcaContent::create([
            'section_id'            => $this->section_id,
            'content_type_id'       => $this->content_type_id,
            'name'                  => $this->name,
            'content_url'           => $this->content_url,
            'original_name'         => $original_name,
            'status'                => $this->status ? true : false,
            'count'                 => $count + 1,
            'created_by'            => Auth::id()
        ]);

        $this->getData();

        $this->clearForm();
    }

    public function clearForm(){
        $this->content_type_id = null;
        $this->name = null;
        $this->content_url = null;
        $this->link = null;
        $this->text = null;
        $this->file = null;
        $this->status = true;
    }

    public function destroy($id){
        try {
            AcaContent::find($id)->delete();
            $res = 'success';
            $tit = 'Enhorabuena';
            $msg = 'Se eliminó correctamente';
        } catch (\Illuminate\Database\QueryException $e) {
            $res = 'error';
            $tit = 'Salió mal';
            $msg = 'No se puede eliminar porque no cuenta con registros asociados';
        }
        $this->getData();
        $this->dispatchBrowserEvent('aca-content-delete', ['res' => $res, 'tit' => $tit, 'msg' => $msg]);
    }
}
