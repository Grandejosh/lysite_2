<?php

namespace Modules\Setting\Http\Livewire\SubscribeUser;

use Modules\Setting\Http\Controllers\SubscribeUsers;
use App\Models\TypeSubscription;
use App\Models\UserSubscription;
use App\Models\Person;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $search = null;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->getUsers();
    }

    public function getSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('setting::livewire.subscribe-user.index', ['people' => $this->getUsers()]);
    }

    public function getUsers()
    {
        return Person::where('names', 'like', '%' . $this->search . '%')
            ->orWhere('last_name_father', 'like', '%' . $this->search . '%')
            ->orWhere('last_name_mother', 'like', '%' . $this->search . '%')
            ->orWhere('full_name', 'like', '%' . $this->search . '%')
            ->join('users', 'users.id', 'people.user_id')
            ->join('user_subscriptions', 'users.id', 'user_subscriptions.user_id')
            ->join('type_subscriptions', 'type_subscriptions.id', 'user_subscriptions.subscription_id')
            ->select(
                'user_subscriptions.id as type_subscription_id',
                'people.full_name',
                'type_subscriptions.name as type_subscription',
                DB::raw("DATE_FORMAT(user_subscriptions.date_start, '%d-%m-%Y') as date_start"),
                DB::raw("DATE_FORMAT(user_subscriptions.date_end, '%d-%m-%Y') as date_end")
            )->where('user_subscriptions.status', '=', 1)
            ->paginate(10);
    }

    public function destroy($id)
    {
        try {
            UserSubscription::find($id)->delete();
            $res = 'success';
            $tit = 'Enhorabuena';
            $msg = 'Se eliminó correctamente';
        } catch (\Illuminate\Database\QueryException $e) {
            $res = 'error';
            $tit = 'Salió mal';
            $msg = 'No se puede eliminar porque cuenta con registros asociados';
        }

        $this->dispatchBrowserEvent('set-subscription-modes-destroy', ['res' => $res, 'tit' => $tit, 'msg' => $msg]);
    }
}
