<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Categories;
use App\Models\Movements;

class MovementsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Movements::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'categories_id' => Categories::factory(),
        ];
    }
}
