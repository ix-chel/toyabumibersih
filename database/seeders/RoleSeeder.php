<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::updateOrCreate(
            ['role_name' => 'Admin'],
            ['description' => 'Administrator with full access']
        );

        Role::updateOrCreate(
            ['role_name' => 'Technician'],
            ['description' => 'Technician responsible for maintenance']
        );

        Role::updateOrCreate(
            ['role_name' => 'Manager'],
            ['description' => 'Manager overseeing operations']
        );

        Role::updateOrCreate(
            ['role_name' => 'Staff'],
            ['description' => 'Regular staff member']
        );
    }
}
