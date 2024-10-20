<?php

namespace Modules\Investigation\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ThesisFormatsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('investigation::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */


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
        return view('investigation::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function list($school_id)
    {
        return view('investigation::thesis-formats.thesis-formats')->with('school_id', $school_id);
    }

    public function create($school_id)
    {
        return view('investigation::thesis-formats.thesis-formats-create')->with('school_id', $school_id);
    }

    public function edit($school_id, $thesis_format_id)
    {
        return view('investigation::thesis-formats.thesis-formats-edit')->with('school_id', $school_id)->with('thesis_format_id', $thesis_format_id);
    }

    public function list_complete()
    {
        return view('investigation::thesis-formats.thesis-formats-list-complete');
    }

    public function create_complete()
    {
        return view('investigation::thesis-formats.thesis-formats-create-complete');
    }

    public function edit_complete($thesis_format_id)
    {
        return view('investigation::thesis-formats.thesis-formats-edit-complete')->with('thesis_format_id', $thesis_format_id);
    }

}
