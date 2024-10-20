<?php

namespace Modules\Academic\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Modules\Academic\Entities\AcaContent;
use Modules\Academic\Entities\AcaStudentsSectionProgress;

class DownloadsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('academic::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('academic::create');
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
    public function edit($id)
    {
        return view('academic::edit');
    }

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
    public function downloadFile($content_id, $student_id)
    {
            /*
        $currentToken = trim((string) Session::token());
        $token = trim((string) $token);
        if ($currentToken== $token) { */
            $content = AcaContent::find($content_id);
            $file = $content->content_url;
            $pathtoFile = public_path() . "/" . $file;
            if (AcaStudentsSectionProgress::where('content_id', $content_id)->where('student_id', $student_id)->count() == 0) {
                AcaStudentsSectionProgress::create([
                    'student_id' => $student_id,
                    'section_id' => $content->section_id,
                    'content_id' => $content->id,
                ]);
            }
            //Session::regenerateToken();
            return response()->download($pathtoFile); //$content->original_name);
            /*
        }else{
            //Session::regenerateToken();
           return "Usted no tiene permisos para descargar este archivo.";
        } */
    }
}
