<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PrioritiesSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(CompaniesAndStaffSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
    }
}
