<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $questionText = $this->faker->sentence;

        return [
            'tenant_id' => Tenant::factory(),  // Creates a new Tenant
            'quiz_id' => Quiz::factory(),      // Creates a new Quiz
            'question' => $questionText,
            'slug' => Str::slug($questionText),
            'description' => $this->faker->paragraph
        ];
    }
}
