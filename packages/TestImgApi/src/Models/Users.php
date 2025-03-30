<?php

namespace TestImgApi\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use TestImgApi\Models\Factories\UsersFactory;

class Users extends User
{
    use HasFactory;

    protected $with = ['info'];

    public function info()
    {
        return $this->hasOne( UserInfo::class, 'user_id', 'id' );
    }

    protected static function newFactory()
    {
        return UsersFactory::new();
    }
}
