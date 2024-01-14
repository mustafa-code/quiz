<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quizType = $this->faker->randomElement(['open', 'close']);
        $startTime = $quizType === 'close' ? $this->faker->dateTime : null;
        $endTime = $quizType === 'close' ? $this->faker->dateTimeBetween($startTime, '+1 week') : null;

        return [
            'title' => $title = $this->faker->sentence,
            'slug' => Str::slug($title),
            'tenant_id' => Tenant::factory(),
            'description' => $this->faker->paragraph,
            'quiz_type' => $quizType,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ];
    }
}
