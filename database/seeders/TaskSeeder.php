<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Assuming you have projects, users, and clients seeded already
        $projectIds = DB::table('projects')->pluck('id')->toArray();
        $userIds = DB::table('users')->pluck('id')->toArray();
        $clientIds = DB::table('clients')->pluck('id')->toArray();

        for ($i = 1; $i <= 10; $i++) {
            DB::table('tasks')->insert([
                'name' => $faker->sentence,
                'description' => $faker->paragraph,
                'project_id' => $faker->randomElement($projectIds),
                'status' => $faker->randomElement(['pending', 'in progress', 'completed']),
                'due_date' => $faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
                'priority' => $faker->randomElement(['low', 'medium', 'high']),
                'user_id' => $faker->randomElement($userIds),
                'client_id' => $faker->randomElement($clientIds),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
