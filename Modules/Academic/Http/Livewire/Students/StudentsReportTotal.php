<?php

namespace Modules\Academic\Http\Livewire\Students;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Academic\Entities\AcaStudent;

class StudentsReportTotal extends Component
{
    public $students = [];
    public $not_students = [];

    public function render()
    {
        $this->getData();
        return view('academic::livewire.students.students-report-total');
    }

    public function getData()
    {
        $this->students = AcaStudent::join('people', 'person_id', 'people.id')
            ->join('identity_document_types', 'people.identity_document_type_id', 'identity_document_types.id')
            ->select(
                'people.id',
                'people.full_name',
                'people.number',
                'identity_document_types.description as document_type_name',
                'people.mobile_phone',
                'people.email',
                DB::raw("(SELECT COUNT(permissions.name) FROM model_has_permissions INNER JOIN permissions ON permission_id = permissions.id WHERE model_id = people.user_id AND permissions.name='academico_directo_cursos') as cur"),
                DB::raw("(SELECT COUNT(permissions.name) FROM model_has_permissions INNER JOIN permissions ON permission_id = permissions.id WHERE model_id = people.user_id AND permissions.name='academico_directo_gpt') as gpt"),
                DB::raw("(SELECT COUNT(permissions.name) FROM model_has_permissions INNER JOIN permissions ON permission_id = permissions.id WHERE model_id = people.user_id AND permissions.name='academico_directo_tesis') as tes")
            )
            ->groupBy([
                'people.id',
                'people.full_name',
                'people.number',
                'identity_document_types.description',
                'people.mobile_phone',
                'people.email',
                'people.user_id'
            ])
            ->get();

        $this->not_students = AcaStudent::RightJoin('people', 'person_id', 'people.id')
            ->join('identity_document_types', 'people.identity_document_type_id', 'identity_document_types.id')
            ->select(
                'people.id',
                'people.full_name',
                'people.number',
                'identity_document_types.description as document_type_name',
                'people.mobile_phone',
                'people.email',
            )
            ->groupBy([
                'people.id',
                'people.full_name',
                'people.number',
                'identity_document_types.description',
                'people.mobile_phone',
                'people.email',
            ])->where('aca_students.person_id', '=', null)
            ->get();
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $user_id = DB::table('people')->where('id', $id)->select('user_id')->first();
            $user_id = $user_id->user_id;
            DB::delete('delete from people where id= ?', [$id]);
            DB::delete('delete from users where id=?', [$user_id]);
            DB::commit();
            $res = 'success';
            $tit = 'Enhorabuena';
            $msg = 'Se eliminó correctamente';
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            $res = 'error';
            $tit = 'Salió mal';
            $msg = 'No se puede eliminar comunicate con los administradores del Sistema';
        }

        $this->dispatchBrowserEvent('aca-person-delete', ['res' => $res, 'tit' => $tit, 'msg' => $msg]);
    }
}
