<?php

namespace Modules\Academic\Http\Livewire\Instructors;

use Livewire\Component;
use Modules\Academic\Entities\AcaStudent;
use Livewire\WithPagination;
use Modules\Academic\Entities\AcaInstructor;

class InstructorsList extends Component
{
    public $search;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('academic::livewire.instructors.instructors-list',['instructors' => $this->getData()]);
    }

    public function getData(){
        return AcaInstructor::join('people','person_id','people.id')
                ->join('identity_document_types','people.identity_document_type_id','identity_document_types.id')
                ->join('aca_courses','aca_instructors.course_id','aca_courses.id')
                ->select(
                    'people.id',
                    'people.full_name',
                    'people.number',
                    'identity_document_types.description as document_type_name',
                    'people.mobile_phone',
                    'people.email',
                    'aca_courses.name'
                )
                ->where('people.full_name','LIKE','%'.$this->search.'%')
                ->paginate(10);
    }

    public function getSearch(){
        $this->resetPage();
    }
}
