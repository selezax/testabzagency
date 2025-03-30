<?php

namespace TestImgApi\Models\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use TestImgApi\Models\Users;

class UsersFactory extends Factory
{
    protected $model = Users::class;

    public function definition(): array
    {
        $_name = fake()->userName;
        return [
            'name' => $_name,
            'email' => fake()->email,
            'password' => bcrypt($_name),
        ];
    }
}
