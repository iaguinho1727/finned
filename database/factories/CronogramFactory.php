<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Activy;
use App\Models\Cronogram;

class CronogramFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cronogram::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'activity_id' => Activy::factory(),
            'done_at' => $this->faker->dateTime(),
        ];
    }
}
