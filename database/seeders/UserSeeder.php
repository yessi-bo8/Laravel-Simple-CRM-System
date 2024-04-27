<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $modRole = Role::firstOrCreate(['name' => 'moderator']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ])->roles()->attach($adminRole);

        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ])->roles()->attach($userRole);

        User::factory()->create([
            'name' => 'Moderator User',
            'email' => 'moderator@example.com',
            'password' => bcrypt('password'),
        ])->roles()->attach($modRole);
    }
}
