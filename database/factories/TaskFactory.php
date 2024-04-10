<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
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
        $ProjectIds = Project::pluck('id')->toArray();

        return [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'project_id' => $this->faker->randomElement($ProjectIds),
            'status' => $this->faker->randomElement(['pending', 'in progress', 'completed']),
            'due_date' => $this->faker->date(),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'user_id' => $this->faker->randomElement($userIds),
            'client_id' => $this->faker->randomElement($clientIds),
        ];
    }
}
