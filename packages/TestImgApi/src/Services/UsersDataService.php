<?php

namespace TestImgApi\Services;

use TestImgApi\Contracts\UserItemInterface;
use TestImgApi\Contracts\UsersDataInterface;
use TestImgApi\Models\Users;

class UsersDataService implements UsersDataInterface
{
    public function getByPaginate($page, $perPage){
        return Users::query()
            ->orderBy('id', 'asc')
            ->paginate($perPage, ['*'], 'page', $page)
            ->through(function ($item, $key) {
                return resolve(UserItemInterface::class, [
                    'item' => $item
                ]);
            });
    }
}
