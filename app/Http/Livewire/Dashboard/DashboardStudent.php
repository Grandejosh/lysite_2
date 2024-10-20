<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Person;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaStudent;

class DashboardStudent extends Component
{
    public $person_id;
    public $date_end;
    public $registered_until = null;
    public $expire_soon;
    public $course;

    public function mount()
    {
        $person = Person::where('user_id', Auth::id())->first();
        if ($person) {
            $this->person_id = $person->id;
            $this->date_end = null;
            $this->course = AcaStudent::where('person_id', $this->person_id)->orderBy('registered_until', 'asc')->first(); //temporalmente es AcaStudent
                //->min('registered_until');  //obtiene la fecha mas cercana a vencer de subscripción
            try{
                $this->registered_until = $this->course->registered_until;
                $this->course = AcaCourse::find($this->course->course_id);
            }catch(Exception $e){
            }

        }
        $this->expire_soon=$this->getExpire_soon();
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-student');
    }

    private function getExpire_soon()
    {
        $currentDate = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        $diferencia_en_dias = $currentDate->diffInDays($this->registered_until);
        $currentDate=strtotime($currentDate);
        $registered_until = strtotime($this->registered_until);
        if($currentDate<$registered_until){
            return $diferencia_en_dias;
        }
        return 20;
    }
}
