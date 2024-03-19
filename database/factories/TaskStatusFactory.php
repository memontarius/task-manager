<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskStatus>
 */
class TaskStatusFactory extends Factory
{
    use PresetValuesTrait;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->getNextValue()
        ];
    }

    private function getValues(): array
    {
        return [
            'новый',
            'в работе',
            'на тестировании',
            'завершен'
        ];
    }

    private function getAlternativeValue(): string
    {
        return fake()->unique()->realTextBetween(5,12);
    }
}
