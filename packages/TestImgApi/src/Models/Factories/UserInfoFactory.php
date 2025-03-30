<?php

namespace TestImgApi\Models\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use TestImgApi\Models\Position;
use TestImgApi\Models\UserInfo;

class UserInfoFactory extends Factory
{
    protected $model = UserInfo::class;

    public function definition(): array
    {
        return [
            'firstname' => fake()->firstName,
            'lastname' => fake()->lastName,
            'position_id' => Position::inRandomOrder()->first()->id,
            'address' => fake()->streetAddress,
            'phone' => '+380' . fake()->randomElement(['67', '50', '93', '99']) . fake()->numerify('#######'),
            'photo' => 'https://picsum.photos/seed/picsum/70',
        ];
    }
}
