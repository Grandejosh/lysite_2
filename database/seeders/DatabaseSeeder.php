<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Setting\Database\Seeders\SettingDatabaseSeeder;
use Modules\Academic\Database\Seeders\AcademicDatabaseSeeder;
use Modules\Investigation\Database\Seeders\InvestigationDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // UserSeeder::class,
            // SettingDatabaseSeeder::class,
            // AcademicDatabaseSeeder::class,
            // InvestigationDatabaseSeeder::class,
            Subscriptions::class
        ]);
    }
}
