<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class InstructorsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($course_id)
    {
        return view('academic::instructors.instructors')->with('course_id',$course_id);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($course_id)
    {
        return view('academic::instructors.instructors-create')->with('course_id',$course_id);
    }

    public function listInstructors()
    {
        return view('academic::instructors.index');
    }
    public function createInstructors()
    {
        return view('academic::instructors.create');
    }
    public function editInstructors($id)
    {
        return view('academic::instructors.edit')->with('id',$id);
    }
}
