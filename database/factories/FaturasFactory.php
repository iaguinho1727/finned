<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Faturas;

class FaturasFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Faturas::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'paid' => $this->faker->word(),
            'expires_at' => $this->faker->date(),
        ];
    }
}
