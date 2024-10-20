<?php

namespace Modules\Setting\Http\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Modules\Setting\Entities\SetModulePermission;
use Spatie\Permission\Models\Permission;

class RolesPermissions extends Component
{
    public $role_id;
    public $role_name;
    public $modules_permissions = [];

    public function mount($role_id){
        $this->role_id = $role_id;
        $this->role = Role::find($role_id);
        $this->role_name = $this->role->name;
        
    }

    public function render()
    {
        $this->getModulesPermissions($this->role_id);
        return view('setting::livewire.roles.roles-permissions');
    }

    public function getModulesPermissions($role_id){
        $this->modules_permissions = SetModulePermission::join('permissions','permission_id','permissions.id')
            ->join('set_modules','module_id','set_modules.id')
            ->select(
                'set_module_permissions.module_id',
                'set_modules.label',
                'permissions.name',
                'permissions.id'
            )
            ->selectSub(function($query) use ($role_id) {
                $query->from('role_has_permissions')
                    ->select('role_has_permissions.permission_id')
                    ->whereColumn('role_has_permissions.permission_id','permissions.id')
                    ->where('role_has_permissions.role_id',$role_id);
            }, 'state')
            ->where('set_module_permissions.status', true)
            ->orderBy('set_modules.label')
            ->get();


    }

    public function xassign($id){
        $permission = Permission::find($id);
        $permission->assignRole($this->role_name);
    }

    public function xremove($id){
        $permission = Permission::find($id);
        $permission->removeRole($this->role_name);
    }
}
