<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\WorkHours;

class WorkHoursFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkHours::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'begin_date' => $this->faker->date(),
            'hours' => $this->faker->randomFloat(0, 0, 9999999999.),
        ];
    }
}
