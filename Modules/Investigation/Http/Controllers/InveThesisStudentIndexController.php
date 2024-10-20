<?php

namespace Modules\Investigation\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Investigation\Entities\InveThesisStudentIndex;

class InveThesisStudentIndexController extends Controller
{

    public function store(Request $request)
    {
        //dd($request->all());
        $id = $request->get('id');
        $sc = InveThesisStudentIndex::where('item_id', $request->get('item_id'))->get();
        $position = count($sc);

        if ($id) {
            InveThesisStudentIndex::find($id)->update([
                'prefix'        => $request->get('prefix'),
                'content'       => $request->get('content'),
                'page'          => $request->get('page')
            ]);
        } else {
            //dd($request->get('prefix'));
            InveThesisStudentIndex::create([
                'type'          => $request->get('type'),
                'thesis_id'     => $request->get('thesis_id'),
                'prefix'        => $request->get('prefix'),
                'content'       => $request->get('content'),
                'position'      => $position,
                'page'          => $request->get('page'),
                'item_id'       => $request->get('item_id')
            ]);
        }

        return response()->json(['success' => true]);
    }
}
