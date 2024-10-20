<?php

namespace Modules\Setting\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersList extends Component
{
    public $search;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function getSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('setting::livewire.users.users-list', ['users' => $this->getData()]);
    }

    public function getData()
    {
        return User::join('model_has_roles', function ($query) {
            return $query->on('model_has_roles.model_id', 'users.id')
                ->where('model_has_roles.model_type', User::class);
        })
            ->join('roles', 'model_has_roles.role_id', 'roles.id')
            ->where('users.name', 'like', '%' . $this->search . '%')
            ->select(
                'users.name',
                'users.email',
                'users.id',
                'roles.name AS role_name'
            )
            ->paginate(10);
    }

    public function destroy($id)
    {
        try {
            User::find($id)->delete();
            $res = 'success';
            $tit = 'Enhorabuena';
            $msg = 'Se eliminó correctamente';
        } catch (\Illuminate\Database\QueryException $e) {
            $res = 'error';
            $tit = 'Salió mal';
            $msg = 'No se puede eliminar porque cuenta con registros asociados';
        }

        $this->dispatchBrowserEvent('set-module-delete', ['res' => $res, 'tit' => $tit, 'msg' => $msg]);
    }
}
