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
        $users = User::all();
        $roles = Role::all();

        $users->each(function ($user) use ($roles) {
            $randomRole = $roles->random();
            $user->roles()->attach($randomRole);
        });
    }
}
