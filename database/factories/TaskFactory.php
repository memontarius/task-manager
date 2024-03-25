<?php

namespace Database\Factories;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'name' => fake()->realTextBetween(4, 12),
            'description' => fake()->sentence(),
            'status_id' => TaskStatus::all()->random()->id,
            'created_by_id' => User::all()->random()->id,
            'assigned_to_id' => User::all()->random()->id,
        ];
    }
}
