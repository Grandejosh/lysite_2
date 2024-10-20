<?php

namespace Modules\Homepage\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HomepageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('homepage::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
   public function instructors(){
         return view('homepage::home.instructors');
   }

   public function histories(){
         return view('homepage::home.histories');
   }

   public function create_history(){
         return view('homepage::home.history-create');
   }

   public function create_instructor(){
    return view('homepage::home.instructor-create');
}

public function edit_history($id){
    return view('homepage::home.history-edit',['id'=>$id]);
}

public function edit_instructor($id){
    return view('homepage::home.instructor-edit',['id'=>$id]);
}

}
