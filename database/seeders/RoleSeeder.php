<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define roles
        $roles = [
            ['name' => 'admin', 'description' => 'Administrator role'],
            ['name' => 'moderator', 'description' => 'Moderator role'],
            ['name' => 'user', 'description' => 'Regular user role'],
        ];
        
        DB::table('roles')->insert($roles);
    }
}
