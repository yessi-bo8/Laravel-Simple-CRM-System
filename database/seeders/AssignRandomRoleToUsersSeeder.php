<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class AssignRandomRoleToUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users without roles
        $usersWithoutRoles = User::whereDoesntHave('roles')->get();
        
        $roles = Role::all();

        $usersWithoutRoles->each(function ($user) use ($roles) {
            $randomRole = $roles->random();
            $user->roles()->attach($randomRole);
        });
    }
}
