<?php
// php artisan db:seed --class=\\TestImgApi\\Seeders\\CreateUsersSeeder

namespace TestImgApi\Seeders;

use Illuminate\Database\Seeder;
use TestImgApi\Models\Position;
use TestImgApi\Models\UserInfo;
use TestImgApi\Models\Users;

class CreateUsersSeeder extends Seeder
{
    public function run()
    {
        Position::factory(25)->create();

        Users::factory(45)->create()->each(function ($user) {
            $user->info()->save(UserInfo::factory()->make());
        });
    }
}
