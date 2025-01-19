<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Consumable;
use App\Models\Consumption;
use App\Models\Unit;

class ConsumptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Consumption::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'consumable_id' => Consumable::factory(),
            'unit_id' => Unit::factory(),
            'quantity' => $this->faker->randomFloat(0, 0, 9999999999.),
            'comodo' => $this->faker->word(),
            'casa' => $this->faker->word(),
        ];
    }
}
