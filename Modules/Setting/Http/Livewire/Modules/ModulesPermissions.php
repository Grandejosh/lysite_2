<?php

namespace Modules\Setting\Http\Livewire\Modules;

use Livewire\Component;
use Modules\Setting\Entities\SetModule;
use Livewire\WithPagination;
use Modules\Setting\Entities\SetModulePermission;
use Spatie\Permission\Models\Permission;

class ModulesPermissions extends Component
{
    public $module_id;
    public $search;
    public $module_name;
    public $module_name_new;
    public $name;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function mount($module_id){
        $this->module_id = $module_id;
        $this->module_name = SetModule::find($module_id)->label;
        $this->module_name_new = cctom($this->module_name).'_';
    }

    public function getSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('setting::livewire.modules.modules-permissions',['permissions' => $this->getData() ]);
    }

    public function getData(){
        return SetModulePermission::where('module_id',$this->module_id)
            ->where('permissions.name','like','%'.$this->search.'%')
            ->join('permissions','permission_id','permissions.id')
            ->select(
                'permissions.name',
                'set_module_permissions.id',
                'set_module_permissions.status'
            )
            ->paginate();
    }

    public function changeState($id){
        $permission = SetModulePermission::find($id);
        SetModulePermission::find($id)->update(['status' => !$permission->status]);
    }

    public function savePermission(){

        $this->permission_name = $this->module_name_new.str_replace(' ','_',$this->name);

        $this->validate([
            'name' => 'required',
            'permission_name' => 'required|unique:permissions,name'
        ]);
        
        $permission = Permission::create(['name' => $this->permission_name,'guard_name' => 'web']);

        SetModulePermission::create([
            'module_id' => $this->module_id,
            'permission_id' => $permission->id,
            'status' => true
        ]);

        $this->name = null;

        $this->dispatchBrowserEvent('set-module-permission-add', ['tit' => 'Enhorabuena','msg' => 'Se agrego correctamente']);
    }

    public function destroy($id){
        try {
            $permission = SetModulePermission::find($id);
            SetModulePermission::find($id)->delete();
            Permission::find($permission->permission_id)->delete();
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
