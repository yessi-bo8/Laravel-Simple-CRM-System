<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Assuming you have users and clients seeded already
        $userIds = DB::table('users')->pluck('id')->toArray();
        $clientIds = DB::table('clients')->pluck('id')->toArray();

        for ($i = 1; $i <= 5; $i++) {
            DB::table('projects')->insert([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'event_date' => $faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
                'user_id' => $faker->randomElement($userIds),
                'client_id' => $faker->randomElement($clientIds),
                'status' => $faker->randomElement(['pending', 'in_progress', 'completed']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
