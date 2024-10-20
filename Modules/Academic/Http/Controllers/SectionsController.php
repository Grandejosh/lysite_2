<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SectionsController extends Controller
{

    public function index($course_id)
    {
        return view('academic::sections.index')->with('course_id',$course_id);
    }

    public function create($course_id)
    {
        return view('academic::sections.create')->with('course_id',$course_id);
    }

    public function edit($course_id,$section_id)
    {
        return view('academic::sections.edit')->with('course_id',$course_id)->with('section_id',$section_id);
    }

}
