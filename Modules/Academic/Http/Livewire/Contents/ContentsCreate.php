<?php

namespace Modules\Academic\Http\Livewire\Contents;

use Livewire\Component;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaContent;
use Modules\Academic\Entities\AcaContentType;
use Modules\Academic\Entities\AcaSection;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class ContentsCreate extends Component
{
    use WithFileUploads;

    public $section_id;
    public $course;
    public $section;
    public $name; //nombre o título del contenido
    public $content_types;

    public $content_type_id;
    public $content_url;
    public $content_url_editor;
    public $status;
    public $created_by;
    public $original_name;

    public $txturl;
    public $txtimage;
    public $txtarchivo;
    public $txttexto;

    public function render()
    {
        return view('academic::livewire.contents.contents-create');
    }

    public function mount($section_id)
    {
        $this->section_id = $section_id;
        $this->section = AcaSection::find($section_id);
        $this->course = AcaCourse::find($this->section->course_id);
        $this->content_types = AcaContentType::all();
    }


    public function save()
    {

        if($this->content_type_id == 1){
            $this->content_url = $this->txturl;
        }
        if($this->content_type_id == 2){
            $this->content_url = htmlentities($this->txttexto, ENT_QUOTES, "UTF-8");
        }
        if($this->content_type_id == 3){
            $this->content_url = $this->txtarchivo;
        }
        if($this->content_type_id == 4){
            $this->content_url = $this->txtimage;
        }

        $this->validate();

        if ($this->content_type_id == 3 || $this->content_type_id == 4) {
            $this->original_name = $this->content_url->getClientOriginalName();
            $this->content_url = 'storage/'.substr($this->content_url->store('public/uploads/academic/contents'), 7);    // <----------------------Solo para archivos e imagenes-------------------------------------------

        }


        $count = AcaContent::where('Section_id',$this->section_id)->count();

        AcaContent::create([
            'section_id' => $this->section_id,
            'content_type_id' => $this->content_type_id,
            'name' => trim($this->name),
            'content_url' => $this->content_url, //tuve que hacer substring para quitar el public del path, ya que no me dejaba cargar la imagen en la carpeta public
            'original_name' => $this->original_name,
            'status' => true,
            'count' => $count + 1,
            'created_by' => Auth::id()
        ]);

        $this->content_type_id = null;
        $this->content_url = null;
        $this->content_url_editor = null;
        $this->created_by = null;
        $this->name=null;

        $this->dispatchBrowserEvent('aca-content-create', ['tit' => 'Enhorabuena', 'msg' => 'Se registró correctamente']);

    }

    public function updatedPhoto(){
        $this->validate([
            'content_url' => 'image|max:10240',
        ]);
    }

    protected $rules = [
        'content_url' => 'required',
        'name' => 'required'
    ];

    public function back(){
        redirect()->route('academico_contenido',[$this->section->course_id,$this->section->id]);
    }
}
