<?php

namespace App\View\Components\Lyontech;

use App\Models\TypeSubscription;
use Illuminate\View\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Modules\Investigation\Entities\InveThesisStudent;

class Header extends Component

{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $courses;
    public $person_id;
    public $modos;
    public $thesis;

    protected $listeners = ['CoursesOpenModal' => 'openModalCourses'];
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->modos = TypeSubscription::limit(4)->orderBy('price')->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.lyontech.header', [
            'courses' => $this->getCourses(),
            'modos' => $this->modos
        ]);
    }

    public function getCourses()
    {
        $this->person_id = DB::table('people')->where('user_id', Auth::id())->value('id');
        $this->courses = DB::table('aca_courses')
            ->select(
                'aca_courses.id',
                'aca_courses.name',
                'aca_courses.course_image'
            )
            ->join('aca_students', 'aca_courses.id', '=', 'aca_students.course_id')
            ->where('aca_students.person_id', $this->person_id)
            ->where('aca_courses.status', 1)
            ->where('aca_students.registered_until', '>=', Carbon::createFromFormat('Y-m-d', date('Y-m-d')))
            ->distinct()
            ->get();
        //$this->courses=DB::table('Aca_courses')->get();
        return $this->courses;
    }
}
