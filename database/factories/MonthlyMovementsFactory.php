<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\MonthlyMovements;

class MonthlyMovementsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MonthlyMovements::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'participant_id' => $this->faker->numberBetween(-10000, 10000),
            'value' => $this->faker->randomFloat(0, 0, 9999999999.),
        ];
    }
}
