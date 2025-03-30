<?php

namespace TestImgApi\Contracts;

use TestImgApi\Services\UsersDataService;

interface UsersDataInterface
{
    public function getByPaginate($page, $perPage);
}
