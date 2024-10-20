<?php

namespace Modules\Setting\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Setting\Entities\SetModule;
use Modules\Setting\Entities\SetModulePermission;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class SeedPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $module = SetModule::create([
            'uuid' => Str::uuid(),
            'logo' => 'settings',
            'label' => 'Configuraciones',
            'destination_route' => 'setting_dashboard',
            'status' => true
        ]);

        $permissions = [];
        
        array_push($permissions,Permission::create(['name' => 'configuraciones']));
        array_push($permissions,Permission::create(['name' => 'configuraciones_modulos']));
        array_push($permissions,Permission::create(['name' => 'configuraciones_modulos_nuevo']));
        array_push($permissions,Permission::create(['name' => 'configuraciones_modulos_editar']));
        array_push($permissions,Permission::create(['name' => 'configuraciones_modulos_permisos']));
        array_push($permissions,Permission::create(['name' => 'configuraciones_modulos_eliminar']));
        array_push($permissions,Permission::create(['name' => 'configuraciones_modulos_permiso_eliminar']));
        array_push($permissions,Permission::create(['name' => 'configuraciones_roles']));
        array_push($permissions,Permission::create(['name' => 'configuraciones_roles_nuevo']));
        array_push($permissions,Permission::create(['name' => 'configuraciones_roles_editar']));
        array_push($permissions,Permission::create(['name' => 'configuraciones_roles_eliminar']));
        array_push($permissions,Permission::create(['name' => 'configuraciones_roles_permisos']));
        array_push($permissions,Permission::create(['name' => 'configuraciones_usuarios']));
        array_push($permissions,Permission::create(['name' => 'configuraciones_usuarios_nuevo']));
        array_push($permissions,Permission::create(['name' => 'configuraciones_usuarios_editar']));
        array_push($permissions,Permission::create(['name' => 'configuraciones_usuarios_eliminar']));
        
        $role = Role::find(1);
        foreach($permissions as $permission){
            SetModulePermission::create([
                'module_id' => $module->id,
                'permission_id' => $permission->id
            ]);
            $role->givePermissionTo($permission->name);
        }
    }
}
