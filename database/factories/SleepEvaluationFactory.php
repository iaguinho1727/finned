<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\SleepEvaluation;

class SleepEvaluationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SleepEvaluation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'note' => $this->faker->randomFloat(0, 0, 9999999999.),
        ];
    }
}
