<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EditAccountController extends Controller
{
    public function editAccount(){
        if (Auth::check()){
            return view('auth.editAccount');
         }else{
            return view('login');
         }
    }

    public function changePassword(){
        if (Auth::check()){
            return view('auth.changePassword');
         }else{
            return view('login');
         }
    }
}

