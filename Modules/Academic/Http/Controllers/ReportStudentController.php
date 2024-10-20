<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ReportStudentController extends Controller
{

    public function studentTotal()
    {
        return view('academic::students.report_students_total');
    }

}
