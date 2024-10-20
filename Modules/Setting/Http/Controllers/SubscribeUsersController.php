<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SubscribeUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('setting::subscribe-user.index');
    }
    public function create()
    {
        return view('setting::subscribe-user.create');
    }
    public function edit($id)
    {
        return view('setting::subscribe-user.edit', ['subId' => $id]);
    }

    public function onlineSubscriptions()
    {
        return view('setting::online-subscriptions.index');
    }
}
