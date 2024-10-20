<?php

namespace Modules\Academic\Http\Livewire\Sections;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaSection;

class SectionsInstructorEdit extends Component
{
    public $sections = [];
    public $section_edit = [];
    public $course_id;
    public $course;
    public $video;

    public function mount($course_id){

        $this->course_id = $course_id;
        $this->course = AcaCourse::find($course_id);
        $this->course->main_video = $this->video_selector($this->course->main_video);
        $this->getData();
    }

    public function render()
    {
        return view('academic::livewire.sections.sections-instructor-edit');
    }

    public function getData(){
        $sections = AcaSection::where('course_id',$this->course_id)
                    ->orderBy('count')
                    ->get();


        foreach($sections as $key => $section){
            $this->section_edit[$key] = false;
            $this->sections[$key] = [
                'title'         => $section->title,
                'description'   => $section->description,
                'status'        => $section->status,
                'id'            => $section->id
            ];
        }
    }

    public function changeordernumber($direction,$id,$number,$index){
        if($direction == 1){

            $move = AcaSection::where('id',$id);
            $change_array = $this->sections[$index-1];
            $change = AcaSection::where('id',$change_array['id']);

            $move->update([
                'count' => $number-1
            ]);

            $change->update([
                'count' => $number
            ]);

        }else if($direction == 0){

            $move = AcaSection::where('id',$id);
            $change_array = $this->sections[$index+1];
            $change = AcaSection::where('id',$change_array['id']);

            $move->update([
                'count' => $number+1
            ]);

            $change->update([
                'count' => $number
            ]);

        }

        $this->getData();
    }

    public function activeEdit($key){
        $this->section_edit[$key] = true;
    }
    public function inactiveEdit($key){
        $this->section_edit[$key] = false;
    }

    public function saveChangesSection($key){

        $this->validate([
            'sections.'.$key.'.title' => 'required',
            'sections.'.$key.'.description' => 'required'
        ]);

        $section = $this->sections[$key];

        if($section['id']){
            AcaSection::where('id',$section['id'])
            ->update([
                'title' => $section['title'],
                'description' => $section['description'],
                'status' => $section['status'] ? true : false,
                'updated_by' => Auth::id()
            ]);
        }else{
            $count = count($this->sections);
            AcaSection::create([
                'course_id' => $this->course_id,
                'title' => $section['title'],
                'description' => $section['description'],
                'status' => $section['status'] ? true : false,
                'count' => ($count),
                'created_by' => Auth::id()
            ]);
        }
        $this->getData();
        //$this->section_edit[$key] = false;
    }

    public function addSection(){
        $count = count($this->sections);
        $this->section_edit[$count] = true;
        $sections = [
            'title'         => null,
            'description'   => null,
            'status'        => true,
            'id'            => null
        ];

        array_push($this->sections,$sections);
    }

    public function destroySection($number,$id){

        $val = AcaSection::where('id',$id)
                ->where('created_by',Auth::id())
                ->exists();

        if($val){
            try {

                $count = AcaSection::where('course_id',$this->course_id)->max('count');

                AcaSection::find($id)->delete();

                $this->sections = [];
                for($c = $number;$c <=$count; $c++){
                    AcaSection::where('course_id',$this->course_id)
                            ->where('count',$c)
                            ->update([
                                'count' => $c - 1
                            ]);
                }

                $res = 'success';
                $tit = 'Enhorabuena';
                $msg = 'Se eliminó correctamente';
            } catch (\Illuminate\Database\QueryException $e) {
                $res = 'error';
                $tit = 'Salió mal';
                $msg = 'No se puede eliminar porque cuenta con registros asociados';
            }


        }else{
            $res = 'error';
            $tit = 'Salió mal';
            $msg = 'Ustd. No se puede eliminar esta seccion';
        }
        $this->getData();
        $this->dispatchBrowserEvent('set-section-delete', ['res' => $res, 'tit' => $tit, 'msg' => $msg]);
    }

    public function video_selector($url){
        $url2=$url;
        $url = explode("=", $url);  //revisa si es un enlace de Youtube https://www.youtube.com/watch?v=qYQdKJRHrKM
        $index=count($url);
        if($index>1){
            $this->video=1;  //si es un enlace de Youtube se retorna 1
            return  $url[$index-1];
        }else{                      //si no lo es revisa de nuevo para ver si es un enlace de Vimeo o Youtube
            $url2 = explode("/", $url2);                        // https://vimeo.com/123998967  https://youtu.be/bPmNe5S19TA
            $index=count($url2);
            if($url2[2]=="vimeo.com"){
                $this->video=0;  //si es un enlace de Vimeo se retorna 0
                return $url2[$index-1];
            }else{
                $this->video=1;  //si es un enlace de Youtube se retorna 1
                return  $url2[$index-1];
            }
        }
    }
}
