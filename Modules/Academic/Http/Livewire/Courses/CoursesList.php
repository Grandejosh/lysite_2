<?php

namespace Modules\Academic\Http\Livewire\Courses;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Academic\Entities\AcaCourse;
use Illuminate\Support\Facades\Storage;
use Modules\Academic\Entities\AcaCourseRating;
use Modules\Academic\Entities\AcaCourseRatingVote;

class CoursesList extends Component
{
    public $search;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function getSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('academic::livewire.courses.courses-list', ['courses' => $this->getData()]);
    }

    public function getData()
    {
        return AcaCourse::where('name', 'like', '%' . $this->search . '%')
            ->paginate(10);
    }

    public function destroy($id)
    {
        try {
            //DB::beginTransaction();
            $course_image = AcaCourse::find($id)->course_image;
            $course = AcaCourse::find($id);
            $course->status = false;
            $course->save();
            AcaCourseRatingVote::where('course_id', $id)->delete();
            AcaCourseRating::where('course_id', $id)->delete();
            $course->delete();
            //DB::commit();
            $res = 'success';
            $tit = 'Enhorabuena';
            $msg = 'Se eliminó correctamente';
            Storage::disk('public')->delete(substr($course_image, 8));
        } catch (\Illuminate\Database\QueryException $e) {
            //DB::rollBack();
            $res = 'error';
            $tit = 'Salió mal';
            $msg = 'No se puede eliminar comunicate con los administradores del Sistema';
        }

        $this->dispatchBrowserEvent('aca-course-delete', ['res' => $res, 'tit' => $tit, 'msg' => $msg]);
    }
}
