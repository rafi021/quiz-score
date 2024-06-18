<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuizResult>
 */
class QuizResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::where(['is_admin' => false])->select('id')->get()->random()->id,
            'quiz_id' => Quiz::select('id')->get()->random()->id,
            'right_answer' => $this->faker->numberBetween(0, 10),
            'wrong_answer' => $this->faker->numberBetween(0, 10),
            'score' => $this->faker->numberBetween(0, 100),
        ];
    }
}
