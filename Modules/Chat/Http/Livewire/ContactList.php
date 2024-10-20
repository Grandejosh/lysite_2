<?php

namespace Modules\Chat\Http\Livewire;

use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Academic\Entities\AcaInstructor;
use Modules\Academic\Entities\AcaStudent;
use Spatie\Permission\Models\Role;

class ContactList extends Component
{
    public $students = [];
    public $instructors = [];
    public $is_instructor = false;
    public $search = "";
    public $alert_message = false;

    public $trueEstudent = false;
    public $trueInstructor = false;

    public function mount()
    {
        $this->loadData();
    }

    public function render()
    {
        return view('chat::livewire.contact-list');
    }

    public function getSearch()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $person = Person::where('user_id', Auth::id())->first();
        $person_id = null;
        if ($person) {
            $person_id = $person->id;
        }

        $courses_i = AcaInstructor::where('person_id', $person_id)->get();
        $courses_s = AcaStudent::where('person_id', $person_id)->get();

        $course_iids = [];
        $course_sids = [];

        if ($courses_i) {
            foreach ($courses_i as $k => $course) {
                $course_iids[$k] = $course->course_id;
            }
        }

        if ($courses_s) {
            foreach ($courses_s as $k => $course) {
                $course_sids[$k] = $course->course_id;
            }
        }

        $user = Auth::user();

        $roles = $user->getRoleNames();

        $in_student = AcaStudent::join('people', 'person_id', 'people.id')
            ->join('users', 'user_id', 'users.id')
            ->leftJoin('chat_messages', 'chat_messages.user_id', 'users.id')
            ->select(
                'users.id',
                'users.is_online',
                'users.avatar',
                'people.full_name',
                'people.email',
                'users.chat_last_activity',
                DB::raw('MIN(chat_messages.is_seen) as is_seen')
            )
            ->whereIn('course_id', $course_iids)
            ->where('people.id', '<>', $person_id)
            ->where(function ($query) {
                $query->orWhere('full_name', 'like', '%' . $this->search . '%');
            })
            ->groupBy([
                'users.id',
                'users.is_online',
                'users.avatar',
                'people.full_name',
                'people.email',
                'users.chat_last_activity'
            ])
            ->get()
            ->toArray();



        $admins = [];
        $ad_students = [];

        if (!$roles->contains('Admin')) {
            $admins = Person::join('users', 'people.user_id', 'users.id')
                ->join('model_has_roles', function (JoinClause $join) {
                    $join->on('model_has_roles.model_id', '=', 'users.id')
                        ->where('model_type', User::class)
                        ->where('role_id', 1);
                })
                ->select(
                    'users.id',
                    'users.is_online',
                    'users.avatar',
                    'people.full_name',
                    'people.email',
                    'users.chat_last_activity',
                    DB::raw('(SELECT MIN(is_seen) FROM chat_messages WHERE user_id = users.id ) AS is_seen'),
                    DB::raw("'Administrador' AS utype")
                )
                ->where(function ($query) {
                    $query->orWhere('people.full_name', 'like', '%' . $this->search . '%');
                })
                ->get()
                ->toArray();
        } else {
            $ad_students = AcaStudent::join('people', 'person_id', 'people.id')
                ->join('users', 'user_id', 'users.id')
                ->select(
                    'users.id',
                    'users.is_online',
                    'users.avatar',
                    'people.full_name',
                    'people.email',
                    'users.chat_last_activity',
                    DB::raw('(SELECT MIN(is_seen) FROM chat_messages WHERE user_id = users.id ) AS is_seen')
                )
                ->where('people.id', '<>', $person_id)
                ->where(function ($query) {
                    $query->orWhere('full_name', 'like', '%' . $this->search . '%');
                })
                ->groupBy([
                    'users.id',
                    'users.is_online',
                    'users.avatar',
                    'people.full_name',
                    'people.email',
                    'users.chat_last_activity'
                ])
                ->get()
                ->toArray();
        }

        //$youHavePermision = $user->hasAnyPermission(['academico_directo_cursos', 'academico_directo_tesis']);
        $youHavePermision = $user->hasAnyPermission('academico_directo_tesis');
        $instructor = [];
        if ($youHavePermision) {
            $instructor = AcaInstructor::join('people', 'person_id', 'people.id')
                ->join('users', 'user_id', 'users.id')
                ->leftJoin('chat_messages', 'chat_messages.user_id', 'users.id')
                ->select(
                    'users.id',
                    'users.is_online',
                    'users.avatar',
                    'people.full_name',
                    'people.email',
                    'users.chat_last_activity',
                    DB::raw('MIN(chat_messages.is_seen) as is_seen'),
                    DB::raw("'Instructor' AS utype")
                )
                ->whereIn('course_id', $course_sids)
                ->where('people.id', '<>', $person_id)
                ->where(function ($query) {
                    $query->orWhere('full_name', 'like', '%' . $this->search . '%');
                })
                ->groupBy([
                    'users.id',
                    'users.is_online',
                    'users.avatar',
                    'people.full_name',
                    'people.email',
                    'users.chat_last_activity'
                ])
                ->get()
                ->toArray();

            $combinedInstructors = array_merge($admins, $instructor);
        } else {
            $combinedInstructors = $admins;
        }


        $combinedStudents = array_merge($ad_students, $in_student);

        $this->instructors = collect($combinedInstructors);
        $this->students = collect($combinedStudents);

        foreach ($this->students as $student) {
            if ($student['is_seen'] == 0 && !is_null($student['is_seen'])) {
                if (Auth::id() == $student['id']) {
                    $this->trueEstudent = false;
                } else {
                    $this->trueEstudent = true;
                }

                break;
            }
        }
        foreach ($this->instructors as $instructor) {
            if ($instructor['is_seen'] == 0 && !is_null($instructor['is_seen'])) {
                if (Auth::id() == $instructor['id']) {
                    $this->trueInstructor = false;
                } else {
                    $this->trueInstructor = true;
                }
                break;
            }
        }

        $role_id = DB::table('model_has_roles')->where('model_type', User::class)->where('model_id', Auth::user()->id)->first()->role_id;

        if (Role::find($role_id)->name == "Instructor") {
            $this->is_instructor = true;
            $this->alert_message = $this->trueInstructor;
        } else {
            $this->alert_message = $this->trueEstudent;
        }

        $exists = DB::table('chat_messages')->where('receiver', Auth::id())
            ->where('is_seen', false)
            ->exists();

        if (!$exists) {
            $this->alert_message = true;
        } else {
            $this->alert_message = false;
        }
    }


    public function getLastActivity($date)
    {
        $difference = now()->diff($date);
        //dd($difference, $difference->format('%s'), $difference->i, $difference->h, $difference->d);

        if ($difference->m >= 1) {
            return $difference->m = 1 ? "hace " . $difference->m . " mes" : "hace " . $difference->m . " meses";
        } else {
            if ($difference->d >= 1) {
                return "hace " . $difference->d . " días";
            } else {
                if ($difference->h >= 1) {
                    return "hace " . $difference->h . " horas";
                } else {
                    if ($difference->i >= 2) {
                        return "hace " . $difference->i . " minuto/s";
                    } else {
                        return "hace un momento";
                    }
                }
            }
        }
    }
}
