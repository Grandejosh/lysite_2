<?php

namespace Modules\Academic\Http\Controllers;

use App\Models\Person;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaInstructor;
use Modules\Academic\Entities\AcaStudent;
use PhpParser\Node\Stmt\TryCatch;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public $video = 0;
    public function index(/*$course_id*/)
    {
        return view('academic::students.index');
        //return view('academic::students.students')->with('course_id',$course_id);
    }

    public function index2($course_id)
    {

        return view('academic::students.students')->with('course_id', $course_id);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(/*$course_id*/)
    {
        return view('academic::students.create');
        //return view('academic::students.students-assign')->with('course_id',$course_id);
    }

    public function create2($course_id)
    {
        return view('academic::students.students-assign')->with('course_id', $course_id);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(/*$course_id, */$id)
    {
        return view('academic::students.edit')->with('id', $id);
    }

    public function edit2($course_id, $id)
    {
        return view('academic::students.student-assign-edit')->with([
            'course_id' => $course_id,
            'id' => $id
        ]);
    }

    public function my_course($id)
    {
        $id_person = Person::where('user_id', Auth::id())->get()->first()->id;

        try {
            $registered_until = AcaStudent::where('person_id', $id_person)->where('course_id', $id)->get()->first()->registered_until;
        } catch (\Throwable $th) {
            $registered_until = null;
        }
        $hoy = new Date(now());

        $fecha_actual = strtotime(date("d-m-Y H:i:00", time()));
        $fecha_entrada = strtotime($registered_until);
        if ($fecha_entrada > $fecha_actual && $registered_until != null) {

            $course = AcaCourse::find($id);
            $this->video = 0;
            $video_url = $this->video_selector($course->main_video);
            $course->video_url = $video_url;
            $course->video_type = $this->video;


            $instruct = AcaInstructor::join('people', 'person_id', 'people.id')
                ->select(
                    'people.names'
                )
                ->where('course_id', $id)
                ->first();

            return view('academic::students.students_my_course')->with([
                'course'    => $course,
                'instruct'  => $instruct
            ]);
        } else {
            //return view('academic::students.students-plazo-vencido');
            return redirect()->route('dashboard_courses_default');
        }
    }
    public function video_selector($url)
    {
        $url2 = $url;
        $url = explode("=", $url);  //revisa si es un enlace de Youtube https://www.youtube.com/watch?v=qYQdKJRHrKM
        $index = count($url);
        if ($index > 1) {
            $this->video = 1;  //si es un enlace de Youtube se retorna 1
            return  $url[$index - 1];
        } else {                      //si no lo es revisa de nuevo para ver si es un enlace de Vimeo o Youtube
            $url2 = explode("/", $url2);                        // https://vimeo.com/123998967  https://youtu.be/bPmNe5S19TA
            $index = count($url2);
            if ($url2[2] == "vimeo.com") {
                $this->video = 0;  //si es un enlace de Vimeo se retorna 0
                return $url2[$index - 1];
            } else {
                $this->video = 1;  //si es un enlace de Youtube se retorna 1
                return  $url2[$index - 1];
            }
        }
    }
    public function take_lesson($course_id, $section_id, $content_id)
    {
        $course = AcaCourse::find($course_id);
        $this->video = 0;
        $video_url = $this->video_selector($course->main_video);
        $course->video_url = $video_url;
        $course->video_type = $this->video;
        $instruct = AcaInstructor::join('people', 'person_id', 'people.id')
            ->select(
                'people.names',
                'people.email'
            )
            ->where('course_id', $course_id)
            ->first();

        return view('academic::students.students-take-lesson')->with([
            'course_id' => $course_id,
            'section_id' => $section_id,
            'content_id' => $content_id,
            'course' => $course,
            'instruct' => $instruct
        ]);
    }

    public function discussions_ask($course_id, $section_id, $content_id)
    {
        return view('academic::students.students_discussions_ask')->with([
            'course_id' => $course_id,
            'section_id' => $section_id,
            'content_id' => $content_id
        ]);
    }

    public function discussions_ask_edit($course_id, $section_id, $content_id, $question_id)
    {
        return view('academic::students.students_discussions_ask_edit')->with([
            'course_id' => $course_id,
            'section_id' => $section_id,
            'content_id' => $content_id,
            'question_id' => $question_id
        ]);
    }

    public function discussion($course_id, $section_id, $content_id, $question_id)
    {
        return view('academic::students.students_discussion')->with([
            'course_id' => $course_id,
            'section_id' => $section_id,
            'content_id' => $content_id,
            'question_id' => $question_id
        ]);
    }

    public function openai()
    {
        return view('academic::students.openaiview');
    }
}
