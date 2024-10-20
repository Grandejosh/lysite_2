<?php

namespace Modules\Investigation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Setting\Entities\SetModule;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use Modules\Setting\Entities\SetModulePermission;
use Spatie\Permission\Models\Role;

class SeedPermissionModuleTableSeeder extends Seeder
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
            'logo' => 'academic',
            'label' => 'Investigación',
            'destination_route' => 'investigation_dashboard',
            'status' => true
        ]);

        $permissions = [];

        array_push($permissions,Permission::create(['name' => 'investigacion']));
        array_push($permissions,Permission::create(['name' => 'investigacion_partes']));    //usaré para formatos y partes
        array_push($permissions,Permission::create(['name' => 'investigacion_partes_nuevo']));
        array_push($permissions,Permission::create(['name' => 'investigacion_partes_editar']));
        array_push($permissions,Permission::create(['name' => 'investigacion_partes_sub']));
        array_push($permissions,Permission::create(['name' => 'investigacion_partes_eliminar']));
        array_push($permissions,Permission::create(['name' => 'investigacion_tesis']));
        array_push($permissions,Permission::create(['name' => 'investigacion_thesis_allowed']));
        array_push($permissions,Permission::create(['name' => 'universities']));
        array_push($permissions,Permission::create(['name' => 'universities_list']));
        array_push($permissions,Permission::create(['name' => 'universities_create']));
        array_push($permissions,Permission::create(['name' => 'universities_edit']));
        array_push($permissions,Permission::create(['name' => 'universities_delete'])); //universities incluye a escuelas

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
