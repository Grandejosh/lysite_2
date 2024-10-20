<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Investigation\Entities\InveThesisFormatPart;
use Modules\Investigation\Entities\InveThesisStudent;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasrole('Admin')) {
            return view('dashboard.dashboard_admin');
        } elseif (Auth::user()->hasrole('Student')) {
            if (Person::where('user_id', Auth::user()->id)->exists()) {
                return view('dashboard.dashboard_student');
            } else {
                return view('user.edit_information');
            }
        } elseif (Auth::user()->hasrole('Instructor')) {
            return view('dashboard.dashboard_instructor');
        }
    }
    public function getCoursesDefault()
    {
        return view('dashboard.dashboard_ly_student_courses_default');
    }
    public function getHelpGPTDefault()
    {
        return view('helpGPT.ly_help_gpt_deafult');
    }

    public function getCourses()
    {
        return view('dashboard.dashboard_ly_student_courses');
    }

    public function getHelpGPT()
    {
        return view('helpGPT.ly_help_gpt');
    }

    public function getWorksheet($thesis_id, $sub_part = 0)
    {
        //para obtener el ID de la parte con el index_order mas bajo para mostrarlo al inicio cuando no se recibe parametro
        if ($sub_part == 0) {
            $format_id = InveThesisStudent::where('id', $thesis_id)->get()->first()->format_id;

            $part = InveThesisFormatPart::where('thesis_format_id', $format_id)->where('belongs', null)->orderBy('index_order', 'ASC')->get()->first();
            if ($part) {
                $sub_part = $part->id;
            }
        }

        return view('ly_worksheet')
            ->with('thesis_id', $thesis_id)
            ->with('sub_part', $sub_part);
    }

    public function getWorksheetDefault()
    {

        return view('ly_worksheet_default');
    }



    /* RUTAS DEL YISUS - Provicional */
    public function thanks()
    {
        return view('ly_thanks');
    }
}
