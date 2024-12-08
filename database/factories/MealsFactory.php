<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Meals;

class MealsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Meals::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'data' => '{}',
            'ate_at' => $this->faker->dateTime(),
        ];
    }
}
