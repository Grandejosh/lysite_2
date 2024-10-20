<?php

namespace Modules\Academic\Http\Livewire\Contents;

use Modules\Academic\Entities\AcaContent;
use Modules\Academic\Entities\AcaContentType;
use Modules\Academic\Entities\AcaCourse;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Modules\Academic\Entities\AcaSection;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ContentsEdit extends Component
{
    use WithFileUploads;
    public $content_types;
    public $section_id;
    public $content_id;
    public $content_type_id;
    public $content_url;
    public $content_url_editor;
    public $content_url_last; // for checking if url is changed y luego debe borrarse el archivo
    public $status;
    public $content_type_id_last;
    public $its_image=false;
    public $name; //nombre o título del contenido
    public $original_name;

    //entidades
    public $section;
    public $content;
    public $course;

    public $txturl;
    public $txtimage;
    public $txtimage_last;
    public $txtarchivo;
    public $txttexto;

    public function mount($section_id, $content_id){
        $this->section = AcaSection::find($section_id);
        $this->content = AcaContent::find($content_id);
        $this->content_types = AcaContentType::all();
        $this->original_name =$this->content->original_name;
        $this->content_type_id = $this->content->content_type_id;
        $this->course = AcaCourse::find($this->section->course_id);
        $this->content_url = $this->content->content_url;
        $this->content_type_id_last = $this->content_type_id;
        $this->status = $this->content->status;
        $this->name = $this->content->name;

        if($this->content_type_id == 1){
            $this->txturl = $this->content->content_url;
        }
        if($this->content_type_id == 2){
            $this->txttexto = $this->content->content_url;
        }
        if($this->content_type_id == 3){
            $this->txtarchivo = $this->content->content_url;
        }
        if($this->content_type_id == 4){
            $this->txtimage = $this->content->content_url;
            $this->txtimage_last = $this->txtimage;
        }
    }

    public function render()
    {
        return view('academic::livewire.contents.contents-edit',['content' => $this->getContent()]);
    }

    public function getContent(){
        $this->content = AcaContent::find($this->content_id);
        return $this->content;
    }

    public function save(){
        $this->its_image=false;

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
            if($this->content_url_last != $this->content_url){
                $this->original_name = $this->content_url->getClientOriginalName();
                $this->content_url = 'storage/'.substr($this->content_url->store('public/uploads/academic/contents'),7);    // <----------------------Solo para archivos e imagenes-------------------------------------------
                //tuve que hacer substring para quitar el public del path, ya que no me dejaba cargar la imagen en la carpeta public
                //$this->content_url = $this->content_url->store('contents');
                $content_url=AcaContent::find($this->content_id)->content_url;
                Storage::disk('public')->delete(substr($content_url, 8));
            }
        }

        $this->content->update([
            'content_type_id' => $this->content_type_id,
            'name' => trim($this->name),
            'content_url' => $this->content_url,
            'original_name' => $this->original_name,
            'status' => $this->status,
            'updated_by' => Auth::id(),
        ]);

        $this->dispatchBrowserEvent('aca-content-update', ['tit' => 'Enhorabuena','msg' => 'Se Actualizo correctamente']);
    }

    public function updatedPhoto(){
        $this->validate([
            'content_url' => 'image|max:10240',
        ]);
    }
    protected $rules = [
        'content_url' => 'required'
    ];

    public function back(){
        redirect()->route('academico_contenido',[$this->course->id,$this->section->id]);
    }
}
