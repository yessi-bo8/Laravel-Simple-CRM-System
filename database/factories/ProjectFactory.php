<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\Client;


use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         // Get random user and client IDs from the database
         $userIds = User::pluck('id')->toArray();
         $clientIds = Client::pluck('id')->toArray();
 
         return [
             'title' => $this->faker->sentence,
             'description' => $this->faker->paragraph,
             'event_date' => $this->faker->date(),
             'user_id' => $this->faker->randomElement($userIds),
             'client_id' => $this->faker->randomElement($clientIds),
             'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
             'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
             'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
         ];
    }
}
