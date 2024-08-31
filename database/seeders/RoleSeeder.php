<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::createOrFirst(['name' => 'superAdmin']);
        $admin = Role::createOrFirst(['name' => 'admin']);
        $user = Role::createOrFirst(['name' => 'user']);
        $employee = Role::createOrFirst(['name' => 'employee']); 
        $caseWorker = Role::createOrFirst(['name' => 'caseWorker']); 
        $supervisor = Role::createOrFirst(['name' => 'supervisor']); 

        $admin->givePermissionTo([
            'create-user',
            'edit-user',
            'delete-user',
        ]);

        $user->givePermissionTo([
        ]);

        $employee->givePermissionTo([
        ]);
    }
}