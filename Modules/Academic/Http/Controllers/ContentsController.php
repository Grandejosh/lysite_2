<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ContentsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($course_id,$section_id)
    {
        //return view('academic::contents.index');
        return view('academic::contents.index')
                    ->with('course_id',$course_id)
                    ->with('section_id',$section_id);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($section_id)
    {
        return view('academic::contents.create')
                    ->with('section_id',$section_id);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('academic::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($section_id, $content_id)
    {
        return view('academic::contents.edit')
                    ->with('section_id',$section_id)
                    ->with('content_id',$content_id);
    }

    public function link($section_id, $content_id){
        return view('academic::contents.add_link')
                    ->with('section_id',$section_id)
                    ->with('content_id',$content_id);
    }
}
