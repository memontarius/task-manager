<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskStatus>
 */
class TaskStatusFactory extends Factory
{
    private array $statuses = [
        'новый',
        'в работе',
        'на тестировании',
        'завершен'
    ];

    private static int $callCount = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        self::$callCount++;

        return [
            'name' => self::$callCount <= count($this->statuses)
                ? $this->statuses[self::$callCount - 1]
                : fake()->unique()->realTextBetween(5,12),
        ];
    }
}
