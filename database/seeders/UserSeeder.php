<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $superAdmin = User::create([
        //     'name' => 'super user',
        //     'email' => 'super@gmail.com',
        //     'password' => Hash::make('123456789')
        // ]);
        // $superAdmin->assignRole('superAdmin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Syed Ahsan Kamal',
            'email' => 'admin@admin.com',
            'password' => Hash::make('ahsan1234')
        ]);
        $admin->assignRole('admin');

        $employee = User::create([
            'name' => 'employee1',
            'email' => 'employee@gmail.com',
            'password' => Hash::make('123456789')
        ]);
        $employee->assignRole('employee');

        $caseWoker = User::create([
            'name' => 'case work',
            'email' => 'caseWoker@gmail.com',
            'password' => Hash::make('123456789')
        ]);
        $caseWoker->assignRole('caseWorker');   

        $supervisor = User::create([
            'name' => 'supervisor',
            'email' => 'supervisor@gmail.com',
            'password' => Hash::make('123456789')
        ]);
        $caseWoker->assignRole('supervisor');

        // Creating Application User
        $user = User::create([
            'name' => 'Naghman Ali',
            'email' => 'naghman@allphptricks.com',
            'password' => Hash::make('naghman1234')
        ]);
        $user->assignRole('user');
    }
}
