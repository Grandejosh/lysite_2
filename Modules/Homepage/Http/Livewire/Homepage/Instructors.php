<?php

namespace Modules\Homepage\Http\Livewire\Homepage;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Homepage\Entities\HomeInstructors;

class Instructors extends Component
{
    public function render()
    {
        return view('homepage::livewire.homepage.instructors', ['instructors' => $this->getData()]);
    }

    public function getData()
    {
        /*
        return DB::table('home_instructors')
        ->inRandomOrder()->get();
        */

        return HomeInstructors::inRandomOrder()->get();
    }
}
