<?php

namespace TestImgApi\Models\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use TestImgApi\Models\Position;

class PositionFactory extends Factory
{
    protected $model = Position::class;

    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle,
        ];
    }
}
