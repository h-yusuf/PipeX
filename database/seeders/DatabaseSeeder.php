<?php

namespace Database\Seeders;

use DowntimeSeeder;
use Illuminate\Database\Seeder;
use ScheduleMaintenanceSeeder;

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
            RoleTableSeeder::class,
            PermissionTableSeeder::class,
            RolePermissionTableSeeder::class,
            UsersTableSeeder::class,
            EmployeeTableSeeder::class
        ]);
    }
}
