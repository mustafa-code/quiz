<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Choice>
 */
class ChoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'question_id' => Question::factory(),
            'title' => $this->faker->sentence,
            'is_correct' => $this->faker->boolean,
            'order' => $this->faker->numberBetween(1, 10),
            'description' => $this->faker->paragraph,
            'explanation' => $this->faker->paragraph
        ];
    }
}
