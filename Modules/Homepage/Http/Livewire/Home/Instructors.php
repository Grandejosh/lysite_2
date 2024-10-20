<?php

namespace Modules\Homepage\Http\Livewire\Home;

use Livewire\Component;
use Modules\Homepage\Entities\HomeInstructors;
use Illuminate\Support\Facades\Storage;

class Instructors extends Component
{
    public $search;


    public function render()
    {
        return view('homepage::livewire.home.instructors', ['instructors' => $this->getData()]);
    }

    public function getData()
    {
        return HomeInstructors::all();
    }

    public function destroy($id){
        try {
            $image_path=HomeInstructors::find($id)->image_path;
            Storage::disk('public')->delete(substr($image_path, 8));
            HomeInstructors::find($id)->delete();
            $res = 'success';
            $tit = 'Enhorabuena';
            $msg = 'Se eliminó correctamente';

        } catch (\Illuminate\Database\QueryException $e) {
            $res = 'error';
            $tit = 'Salió mal';
            $msg = 'No se puede eliminar porque cuenta con registros asociados';
        }
        redirect()->route('homepage_instructors');
        $this->dispatchBrowserEvent('home-instructors-delete', ['res' => $res, 'tit' => $tit, 'msg' => $msg]);
    }

    public function back(){
        redirect()->route('homepage_instructors');
    }

}
