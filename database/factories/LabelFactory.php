<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Label>
 */
class LabelFactory extends Factory
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
            'name' => $this->getNextValue(),
            'description' => fake()->text(40)
        ];
    }

    private function getValues(): array
    {
        return [
            'доработка',
            'интерфейс',
            'срочно',
            'ошибка',
            'документация'
        ];
    }

    private function getAlternativeValue(): mixed
    {
        return fake()->unique()->realTextBetween(5, 10);
    }
}
