<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678')
        ]);

        Role::create(['name' => 'Admin']); // por defecto siempre sera el id 1
        Role::create(['name' => 'Student']);
        Role::create(['name' => 'Instructor']);

        $user->assignRole('Admin');
    }
}
