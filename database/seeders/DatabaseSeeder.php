<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //  User::factory(20)->create()->each(function($user){
        //  });

        User::factory()->create([
            'name' => 'odai',
            'email' => 'odaiten@gmail.com',
            'password' => '123456789',
            'address' => 'address1',
        ])->assignRole('user');
    }
}
