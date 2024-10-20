<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TypeSubscriptionController extends Controller
{
    public function index()
    {
        return view('setting::subscription.index');
    }
    public function create()
    {
        return view('setting::subscription.create');
    }
    public function edit($id)
    {
        return view('setting::subscription.edit', ['subId' => $id]);
    }
}
