<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuestionBank>
 */
class QuestionBankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quiz_id' => Quiz::select('id')->get()->random()->id,
            'question' => fake()->sentence,
            'correct_answer' => fake()->randomElement(['A', 'B', 'C', 'D']),
            'options' => collect(['A', 'B', 'C', 'D'])
        ];
    }
}
