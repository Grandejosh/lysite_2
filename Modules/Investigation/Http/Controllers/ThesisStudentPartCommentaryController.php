<?php

namespace Modules\Investigation\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\Investigation\Entities\InveThesisStudentPartSelectionComment;
use Illuminate\Validation\Validator;
use Modules\Academic\Emails\NotificationCheckThesisEmail;
use Modules\Investigation\Entities\InveThesisStudent;

class ThesisStudentPartCommentaryController extends Controller
{
    public function createComenntarySelection(Request $request)
    {
        $request->validate([
            'thesi_student_part_id' => 'required',
            'thesi_student_id' => 'required',
            'thesi_format_part_id' => 'required',
            'selecction_text' => 'required',
            'selecction_id' => 'required',
            'commentary' => 'required',
        ]);

        InveThesisStudentPartSelectionComment::create([
            'thesis_student_part_id' => $request->get('thesi_student_part_id'),
            'thesis_student_id' => $request->get('thesi_student_id'),
            'thesis_format_part_id' => $request->get('thesi_format_part_id'),
            'selecction_text' => $request->get('selecction_text'),
            'selecction_id' => $request->get('selecction_id'),
            'commentary' => $request->get('commentary'),
            'user_id' => Auth::id(),
        ]);

        $instructor = DB::table('users')->where('id', Auth::id())->first()->name;
        $thesis_student = DB::table('inve_thesis_students')->select('people.names', 'inve_thesis_students.external_id')
            ->join('users', 'users.id', '=', 'inve_thesis_students.user_id')
            ->join('people', 'people.user_id', '=', 'users.id')
            ->where('inve_thesis_students.id', $request->get('thesi_student_id'))
            ->first();

        $name_student = $thesis_student->names;
        $external_id = $thesis_student->external_id;

        $avatar_url = env('APP_URL') . '/storage/' . Auth::user()->avatar;
        $correo = new NotificationCheckThesisEmail($instructor, $name_student, $external_id, $request->get('thesi_format_part_id'), $request->get('commentary'), $avatar_url); //$this->question->question_text, $this->answer_text, DB::table('users')->where('id', Auth::id())->first()->name, $this->question_id);
        $correo->subject = 'Tesis Revisada';
        $email = DB::table('users')
            ->join('inve_thesis_students', 'inve_thesis_students.user_id', '=', 'users.id')
            ->where('inve_thesis_students.external_id', $external_id)->value('email');

        Mail::to($email)->send($correo);

        return response()->json([
            'status' => 'success',
            'message' => 'Los datos se han procesado correctamente',
        ]);
    }

    public function getCommetsByThesis($id)
    {
        $comments = InveThesisStudentPartSelectionComment::where('thesis_student_id', $id)->get();
        if (count($comments) > 0) {
            $comments = $comments->toArray();
        }

        return response()->json($comments);
    }

    public function destroyCommetsById($id, $thesis_id)
    {
        InveThesisStudentPartSelectionComment::find($id)->delete();
        $exists = InveThesisStudentPartSelectionComment::where('thesis_student_id', $thesis_id)->exists();
        return response()->json(['success' => true, 'exists' => $exists]);
    }
}
